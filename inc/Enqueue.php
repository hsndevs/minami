<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 *
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
 * Enqueue Class
 *
 * This class handles the enqueueing of styles and scripts for the theme.
 */
class Enqueue {

	use Traits\Singleton; // Use the Singleton trait to ensure only one instance of this class exists.
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
	 * This method sets up the necessary hooks for enqueueing styles and scripts.
	 *
	 * @return void
	 */
	public function init() {
		// Enqueue style for frontend.
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_frontend_style' ) );
		// Enqueue scripts for block editor.
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
		// add_action('enqueue_admin_assets', array($this, 'enqueue_admin_style')); .
	}

	/**
	 * Enqueue style for frontend.
	 *
	 * @return void
	 */
	public function enqueue_frontend_style() {
		wp_enqueue_style( 'frontend-style', get_stylesheet_directory_uri() . '/build/frontend.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
		// enqueue for both frontend and backend.

		wp_enqueue_style( 'google-icon-style', esc_url( 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined' ), array(), wp_get_theme()->get( 'Version' ), 'all' );

		wp_enqueue_script(
			'minami-index',
			get_stylesheet_directory_uri() . '/build/index.js',
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);

		wp_enqueue_script(
			'minami-script',
			get_stylesheet_directory_uri() . '/build/frontend.js',
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);

		wp_localize_script( 'minami-script', 'minami', array( 'assets_url' => MINAMI_ASSETS_URI ) );
	}

	/**
	 * Enqueue scripts for block editor
	 *
	 * @return void
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_script(
			'minami-blocks',
			get_stylesheet_directory_uri() . '/build/index.js',
			array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data' ),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}

	/**
	 * Enqueue style for admin.
	 *
	 * @return void
	 */
	public function enqueue_admin_style() {
		wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri() . '/build/minami-admin.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
		wp_enqueue_script(
			'minami-admin-script',
			get_stylesheet_directory_uri() . '/build/minami-admin.js',
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);
		wp_localize_script( 'minami-admin-script', 'minami', array( 'assets_url' => MINAMI_ASSETS_URI ) );
	}
}
