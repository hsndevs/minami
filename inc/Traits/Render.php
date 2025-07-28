<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Render trait.
 *
 * @package wordpress-plugin
 */

namespace Minami\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Render Trait
 *
 * This trait provides a method to render templates from the views directory.
 *
 * @package Minami\Traits
 */
trait Render {
	/**
	 * Path to the views directory.
	 *
	 * @var string
	 */
	private static $view_path = MINAMI_THEME_PATH . '/views/';

	/**
	 * Render the template.
	 *
	 * @param string $file File name.
	 * @param array  $args Arguments.
	 * @return void
	 */
	public function render( $file, $args = array() ) {

		$file = self::$view_path . $file . '.php';

		if ( file_exists( $file ) ) {
			foreach ( $args as $key => $value ) {
				${$key} = $value;
			}

			include_once $file;
		}
	}
}
