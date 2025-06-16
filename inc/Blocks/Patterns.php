<?php

/**
 * Block Variations
 *
 * @package wordpress-theme
 * @since 1.0
 */

namespace Minami\Blocks;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Block_Variations Class
 */
class Patterns {

	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor
	 * (private to enforce singleton pattern).
	 */
	private function __construct() {
		// All the initialization tasks.
		$this->register_hooks();
	}


	public function register_hooks() {
		// Register block styles.
		add_action('init', array($this, 'minami_register_block_patterns'));
	}

	/**
	 * Register block variations
	 */
	public function minami_register_block_patterns() {
		// Register banner patterns.
		register_block_pattern('minami/minami-banner', [
			'title'   => __('Minami Banner', 'minami'),
			'content' => '<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}},"background":{"backgroundImage":{"url":"' . esc_url(get_template_directory_uri() . '/assets/images/namba-square.png') . '","id":119,"source":"file","title":"namba-square"},"backgroundSize":"cover","backgroundAttachment":"scroll","backgroundPosition":"50% 50%"},"dimensions":{"minHeight":"600px"}},"layout":{"type":"default"}} --><div class="wp-block-group" style="min-height:600px;margin-top:0;margin-bottom:0"></div><!-- /wp:group -->',
		]);
		// Register banner patterns.
		register_block_pattern('minami/minami-clients', [
			'title'   => __('Minami Clients', 'minami'),
			'content' => '<!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"20px","bottom":"20px"}}},"backgroundColor":"black","layout":{"type":"default"}} -->
<div class="wp-block-group has-black-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:20px;padding-bottom:20px"><!-- wp:group {"layout":{"type":"constrained","contentSize":"1352px"}} -->
<div class="wp-block-group"><!-- wp:gallery {"columns":6,"linkTo":"none","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
<figure class="wp-block-gallery has-nested-images columns-6 is-cropped"><!-- wp:image {"id":47,"sizeSlug":"large","linkDestination":"attachment"} -->
<figure class="wp-block-image size-large"><a href="#" target="_blank" rel=" noreferrer noopener"><img src="' . esc_url(get_template_directory_uri() . '/assets/images/gallery4.webp') . '" alt="" class="wp-image-47"/></a></figure>
<!-- /wp:image -->

<!-- wp:image {"id":46,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . esc_url(get_template_directory_uri() . '/assets/images/gallery3.webp') . '" alt="" class="wp-image-46"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":45,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . esc_url(get_template_directory_uri() . '/assets/images/gallery2.webp') . '" alt="" class="wp-image-45"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":44,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . esc_url(get_template_directory_uri() . '/assets/images/gallery1.webp') . '" alt="" class="wp-image-44"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":119,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . esc_url(get_template_directory_uri() . '/assets/images/gallery5.png') . '" alt="" class="wp-image-119"/></figure>
<!-- /wp:image -->

<!-- wp:image {"id":163,"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="' . esc_url(get_template_directory_uri() . '/assets/images/namba-square.png') . '" alt="" class="wp-image-163"/></figure>
<!-- /wp:image --></figure>
<!-- /wp:gallery --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		]);
	}
}


/*

*/
