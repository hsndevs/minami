<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Traits of the plugin.
 *
 * @package wordpress-plugin
 */

namespace Minami\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Singleton Trait
 *
 * This trait provides a simple implementation of the singleton pattern.
 * It ensures that only one instance of the class can exist at a time.
 *
 * @package Minami\Traits
 */
trait Singleton {

	/**
	 * Instance of the class.
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * Get the instance of the class.
	 *
	 * @return mixed
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
