<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Button Block Variations
 *
 * @package wordpress-theme
 * @since 1.0
 */

namespace Minami\Blocks\Variations;

/**
 * Btn_Minami_Type Class
 *
 * This class registers custom button styles for the Gutenberg block editor.
 */
class Btn_Minami_Type {
	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Constructor.
	 *
	 * Registers custom button styles for the Gutenberg block editor.
	 */
	public function __construct() {
		// Action to add register_block_style.
		register_block_style(
			'core/button',
			array(
				'name'         => 'btn-default',
				'label'        => __( 'btn Default', 'minami' ),
				'inline_style' => '.wp-block-button.is-style-btn-default .wp-block-button__link{
				background-color: #000000;
				color: #EFF2F6;
				border-radius: 4px;
				box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.25);
				padding: 12px 72px;
			}',
			)
		);

		// Action to add register_block_style.
		register_block_style(
			'core/button',
			array(
				'name'         => 'btn-outline',
				'label'        => __( 'btn Outline', 'minami' ),
				'inline_style' => '.wp-block-button.is-style-btn-outline .wp-block-button__link{
					background-color: transparent;
					color: #000000;
					border: 2px solid #000000;
					border-radius: 40px;
					box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.25);
				}',
			)
		);
	}
}
