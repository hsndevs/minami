<?php

/**
 * Plugin File: AM API
 * Description: This plugin will show related random posts under each post.
 *
 * @package wordpress-plugin
 * @since 1.0
 */

namespace Minami;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Plugin_Main Class
 */
class Enqueue
{
	use Traits\Singleton, Traits\PluginData; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor (private to enforce singleton pattern).
	 *
	 * @return void
	 */
	private function __construct()
	{
		// All the initialization tasks.
		$this->init();
	}

	public function init()
	{
		// Enqueue style for frontend
		add_action('enqueue_block_assets', array($this, 'enqueue_frontend_style'));
		// add_action('enqueue_admin_assets', array($this, 'enqueue_admin_style'));
	}

	/**
	 * Enqueue style for frontend.
	 *
	 * @return void
	 */
	public function enqueue_frontend_style()
	{
		wp_enqueue_style('frontend-style', get_stylesheet_directory_uri() . '/build/frontend.css', array(), wp_get_theme()->get('Version'), 'all');
		// enqueue for both frontend and backend

		wp_enqueue_style('google-icon-style', esc_url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined'), array(), wp_get_theme()->get('Version'), 'all');

		wp_enqueue_script(
			'minami-script',
			get_stylesheet_directory_uri() . '/build/frontend.js',
			array(),
			wp_get_theme()->get('Version'),
			true
		);
		wp_localize_script('minami-script', 'minami', array('assets_url' => MINAMI_ASSETS_URI));
	}

	/**
	 * Enqueue style for admin.
	 *
	 * @return void
	 */
	public function enqueue_admin_style()
	{
		wp_enqueue_style('admin-style', get_stylesheet_directory_uri() . '/build/minami-admin.css', array(), wp_get_theme()->get('Version'), 'all');
		wp_enqueue_script(
			'minami-admin-script',
			get_stylesheet_directory_uri() . '/build/minami-admin.js',
			array(),
			wp_get_theme()->get('Version'),
			true
		);
		wp_localize_script('minami-admin-script', 'minami', array('assets_url' => MINAMI_ASSETS_URI));
	}
}
