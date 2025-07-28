<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Block Variations
 *
 * @package wordpress-theme
 * @since 1.0
 */

namespace Minami\Blocks;

use Minami\Blocks\Variations\Btn_Minami_Type;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Variations Class
 *
 * This class registers custom block variations for the Gutenberg block editor.
 */
class Variations {

	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Class constructor
	 * (private to enforce singleton pattern).
	 */
	private function __construct() {
		// All the initialization tasks.
		$this->register_hooks();
	}

	/**
	 * Register hooks and do other setup tasks.
	 *
	 * @return void
	 */
	public function register_hooks() {
		// Register block styles.
		add_action( 'enqueue_block_assets', array( $this, 'minami_register_block_styles' ) );
	}

	/**
	 * Register block styles.
	 *
	 * This method registers custom block styles for the Gutenberg block editor.
	 *
	 * @return void
	 */
	public function minami_register_block_styles() {
		// Register block variations.
		Btn_Minami_Type::get_instance();

		// List_With_Bullet::get_instance();
		// List_With_Gradient_Bullet::get_instance();
		// List_With_Circle::get_instance();
		// List_With_Right_Arrow::get_instance(); .
	}
}
