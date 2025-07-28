<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Plugin File: AM API
 * Description: This plugin will show related random posts under each post.
 *
 * @package wordpress-plugin
 * @since 1.0
 */

namespace Minami;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post_Types Class
 *
 * This class handles the registration of custom post types and taxonomies.
 */
class Post_Types {
	use Traits\Singleton;
	use Traits\PluginData; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor (private to enforce singleton pattern).
	 *
	 * @return void
	 */
	private function __construct() {
		// All the initialization tasks.
		$this->init();
	}

	/**
	 * Initialize the class by registering hooks.
	 *
	 * This method sets up the necessary hooks for registering custom post types and taxonomies.
	 *
	 * @return void
	 */
	public function init() {
		// Register custom post types.
		add_action( 'init', array( $this, 'register_custom_post_types' ) );
		// Register custom taxonomies.
		add_action( 'init', array( $this, 'register_custom_taxonomies' ) );
	}


	/* Event Post Type taxonomy "category" */
	/**
	 * Register custom taxonomies for the 'event' post type.
	 *
	 * @return void
	 */
	public function register_custom_taxonomies() {
		// Register a custom taxonomy called 'event_category' for the 'event' post type.
		register_taxonomy(
			'event_category',
			'event',
			array(
				'labels' => array(
					'name' => __( 'Event Categories', 'minami' ),
					'singular_name' => __( 'Event Category', 'minami' ),
					'menu_name' => __( 'Event Categories', 'minami' ),
					'all_items' => __( 'All Event Categories', 'minami' ),
					'edit_item' => __( 'Edit Event Category', 'minami' ),
					'view_item' => __( 'View Event Category', 'minami' ),
					'update_item' => __( 'Update Event Category', 'minami' ),
					'add_new_item' => __( 'Add New Event Category', 'minami' ),
					'new_item_name' => __( 'New Event Category Name', 'minami' ),
					'search_items' => __( 'Search Event Categories', 'minami' ),
					'not_found' => __( 'No event categories found', 'minami' ),
				),
				'hierarchical' => true, // Set to true for hierarchical taxonomy (like categories).
				'show_in_rest' => true, // Enable Gutenberg editor support.
				'rewrite' => array( 'slug' => 'event-category' ), // Optional: set a custom slug.
			)
		);
	}

	/**
	 * Register custom post types.
	 *
	 * This method registers custom post types for the theme.
	 *
	 * @return void
	 */
	public function register_custom_post_types() {
		// Example: Register a custom post type called 'activity'.
		register_post_type(
			'activity',
			array(
				'labels' => array(
					'name' => __( 'Activities', 'minami' ),
					'singular_name' => __( 'Activity', 'minami' ),
					'menu_name' => __( 'Activities', 'minami' ),
					'all_items' => __( 'All Activities', 'minami' ),
					'add_new_item' => __( 'New Activity +', 'minami' ),
					'edit_item' => __( 'Edit Activity', 'minami' ),
					'new_item' => __( 'New Activity', 'minami' ),
					'view_item' => __( 'View Activity', 'minami' ),
					'search_items' => __( 'Search Activities', 'minami' ),
					'not_found' => __( 'No activities found', 'minami' ),
					'not_found_in_trash' => __( 'No activities found in Trash', 'minami' ),
				),
				'public' => true,
				'has_archive' => true, // Enable archive page.
				'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'menu_icon' => 'dashicons-art',
				'rewrite' => array( 'slug' => 'activities' ),
				'show_in_rest' => true, // Enable Gutenberg editor support.
			)
		);

		// Register a custom post type called 'event'.
		// This post type is used for events and can be categorized using the 'event_category' taxonomy.
		register_post_type(
			'event',
			array(
				'labels' => array(
					'name' => __( 'Events', 'minami' ),
					'singular_name' => __( 'Event', 'minami' ),
					'menu_name' => __( 'Events', 'minami' ),
					'all_items' => __( 'All Events', 'minami' ),
					'add_new_item' => __( 'New Event +', 'minami' ),
					'edit_item' => __( 'Edit Event', 'minami' ),
					'new_item' => __( 'New Event', 'minami' ),
					'view_item' => __( 'View Event', 'minami' ),
					'search_items' => __( 'Search Events', 'minami' ),
					'not_found' => __( 'No events found', 'minami' ),
					'not_found_in_trash' => __( 'No events found in Trash', 'minami' ),
				),
				'public' => true,
				'has_archive' => true, // Enable archive page.
				'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'menu_icon' => 'dashicons-art',
				'rewrite' => array( 'slug' => 'events' ),
				'show_in_rest' => true, // Enable Gutenberg editor support.
			)
		);

		// Register a custom post type called 'report'.
		// This post type is used for walking reports and can be categorized using the 'event_category' taxonomy.
		register_post_type(
			'report',
			array(
				'labels' => array(
					'name' => __( 'Walking Reports', 'minami' ),
					'singular_name' => __( 'Walking Report', 'minami' ),
					'menu_name' => __( 'Walking Reports', 'minami' ),
					'all_items' => __( 'All Walking Reports', 'minami' ),
					'add_new_item' => __( 'New Walking Report +', 'minami' ),
					'edit_item' => __( 'Edit Walking Report', 'minami' ),
					'new_item' => __( 'New Walking Report', 'minami' ),
					'view_item' => __( 'View Walking Report', 'minami' ),
					'search_items' => __( 'Search Walking Reports', 'minami' ),
					'not_found' => __( 'No Walking Reports found', 'minami' ),
					'not_found_in_trash' => __( 'No Walking Reports found in Trash', 'minami' ),
				),
				'public' => true,
				'has_archive' => true, // Enable archive page.
				'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
				'menu_icon' => 'dashicons-art',
				'rewrite' => array( 'slug' => 'walking-reports' ),
				'show_in_rest' => true, // Enable Gutenberg editor support.
			)
		);
	}
}
