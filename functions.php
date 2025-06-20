<?php

/**
 * Functions and definitions of the theme.
 *
 * @package wordpress-theme
 * @since 1.0
 */

if (!defined('ABSPATH')) {
	exit;
}

// Load Composer autoloader.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/vendor/autoload.php';
}

Minami\Theme_Main::get_instance();

define('MINAMI_PLACEHOLDER_IMAGE', 'https://placehold.co/600x400/ddd/999/svg?text=No+Image+Found');

add_filter('post_thumbnail_html', 'minami_filter_activity_thumbnail_html', 10, 5);

function minami_filter_activity_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
	// Check if the current post is of type 'activity'
	if (get_post_type($post_id) === 'activity' && empty($html)) {
		$placeholder = '<img src="' . MINAMI_PLACEHOLDER_IMAGE . '"';
		$placeholder .= ' alt="' . esc_attr(get_the_title($post_id)) . '"';
		$placeholder .= ' class="wp-post-image" />';
		return $placeholder;
	}

	return $html;
}

// This function will add fallback post thumbnail here for each post
function minami_post_thumbnail($post = null) {
	if (!$post) {
		global $post;
	}
	$post_id = is_object($post) ? $post->ID : $post;
	// Get the post thumbnail
	$post_thumbnail = get_the_post_thumbnail($post_id, 'medium');

	// Check if the post has a thumbnail
	if ($post_thumbnail == '' || !has_post_thumbnail($post_id)) {
		// Fallback image if no thumbnail
		$post_thumbnail = '<img src="' . MINAMI_PLACEHOLDER_IMAGE . '" alt="no post image" />';
	}

	// Display the post thumbnail
	echo $post_thumbnail;
}
// action hook to add the function
// add_action('post_thumbnail_html', 'minami_post_thumbnail');
// action hook to add the function
// add_action('minami_activity_post_thumbnail', 'minami_post_thumbnail');


/**
 * Print data in a readable format
 *
 * @param mixed $data Data to print
 * @param bool $die Whether to die after printing
 */
function pr($data, $die = false) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	if ($die) {
		die();
	}
}

function wpdocs_register_multiple_blocks() {
	$build_dir = __DIR__ . '/build/blocks';

	if (!is_dir($build_dir)) {
		return; // Exit if the build directory does not exist
	}
	foreach (scandir($build_dir) as $result) {
		$block_location = $build_dir . '/' . $result;

		if (!is_dir($block_location) || '.' === $result || '..' === $result) {
			continue;
		}
		// echo '<br>'.$block_location;
		register_block_type($block_location);
	}
	// die;
}



add_action('init', 'wpdocs_register_multiple_blocks');


// Add featured_media_url to event REST API response
add_action('rest_api_init', function () {
	register_rest_field('event', 'featured_media_url', [
		'get_callback' => function ($post_arr) {
			$img_id = $post_arr['featured_media'];
			if ($img_id) {
				$img = wp_get_attachment_image_src($img_id, 'medium');
				return $img ? $img[0] : '';
			}
			return '';
		},
		'schema' => null,
	]);
});

function create_pages_if_not_exist() {
	$pages = ['Home', 'About Us', 'Services', 'Address', 'Member List', 'Minamimachi-News', 'Minami Town Story', 'Minami Town Story Cinema History', 'Minami Walking Report', 'Minami Survey Report', 'Activity Report', 'Past Activities'];
	foreach ($pages as $slug) {
		$existing_page = get_page_by_path(strtolower($slug));
		if (!$existing_page) {
			wp_insert_post([
				'post_title'  => $slug,
				'post_status' => 'publish',
				'post_type'   => 'page',
			]);
		}
	}
}

add_action('init', 'create_pages_if_not_exist');

// Disable theme and plugin editors in WP admin
define('DISALLOW_FILE_EDIT', true);

// Add admin menu for custom translations
add_action('admin_menu', function () {
	add_menu_page(
		'Custom Translations',
		'Custom Translations',
		'manage_options',
		'custom-translations',
		'minami_custom_translations_page',
		'dashicons-translation',
		80
	);
});

function minami_custom_translations_page() {
	if (!current_user_can('manage_options')) return;
	// Handle form submission
	if (isset($_POST['minami_translation_nonce']) && wp_verify_nonce($_POST['minami_translation_nonce'], 'minami_save_translation')) {
		$en = sanitize_text_field($_POST['minami_en'] ?? '');
		$jp = sanitize_text_field($_POST['minami_jp'] ?? '');
		if ($en && $jp) {
			minami_save_translation_to_po($en, $jp);
			echo '<div class="updated"><p>Translation saved!</p></div>';
		}
	}
?>
	<div class="wrap">
		<h1>Custom Translations</h1>
		<form method="post">
			<?php wp_nonce_field('minami_save_translation', 'minami_translation_nonce'); ?>
			<table class="form-table">
				<tr>
					<th><label for="minami_en">English Text</label></th>
					<td><input type="text" name="minami_en" id="minami_en" class="regular-text" required></td>
				</tr>
				<tr>
					<th><label for="minami_jp">Japanese Text</label></th>
					<td><input type="text" name="minami_jp" id="minami_jp" class="regular-text" required></td>
				</tr>
			</table>
			<?php submit_button('Save Translation'); ?>
		</form>
	</div>
<?php
}

function minami_save_translation_to_po($en, $jp) {
	$po_path = get_template_directory() . '/languages/minami-custom.po';
	$entry = "\nmsgid \"$en\"\nmsgstr \"$jp\"\n";
	file_put_contents($po_path, $entry, FILE_APPEND | LOCK_EX);
}

function minami_enqueue_gallery_slider_extension() {
	wp_enqueue_script(
		'minami-gallery-slider-extension',
		get_theme_file_uri('/build/gallery-slider-extension.js'),
		array('wp-blocks', 'wp-element', 'wp-components', 'wp-compose', 'wp-editor', 'wp-block-editor'),
		get_theme_file_path('/build/gallery-slider-extension.js'),
		true // Load in footer
	);
	// Set as module for ES6 imports
	add_filter('script_loader_tag', function ($tag, $handle, $src) {
		if ($handle === 'minami-gallery-slider-extension') {
			return '<script type="module" src="' . esc_url($src) . '"></script>';
		}
		return $tag;
	}, 10, 3);
}
add_action('enqueue_block_editor_assets', 'minami_enqueue_gallery_slider_extension');
