<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * List With Circle Block Variation
 *
 * @package wordpress-theme
 * @since 1.0
 */

namespace Minami\Blocks\Variations;

/**
 * List_With_Circle Class
 *
 * This class registers a custom list style with circle icons for the Gutenberg block editor.
 */
class List_With_Circle {

	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Constructor.
	 *
	 * Registers a custom list style with circle icons for the Gutenberg block editor.
	 */
	public function __construct() {

		// Register the block style for list with circle icons.
		register_block_style(
			'core/list',
			array(
				'name'         => 'list-with-circle',
				'label'        => __( 'Circle', 'minami' ),
				'inline_style' => '
				.wp-block-list.is-style-list-with-circle {
					list-style: none;
					padding: 0;
					margin: 0;
				}

				.wp-block-list.is-style-list-with-circle li {
					display: flex;
					align-items: center;
				}

				.wp-block-list.is-style-list-with-circle li::before {
					content: "";
					width: 16px;
					height: 16px;
					background-image: url(' . MINAMI_THEME_URI . 'assets/images/svg-icons/circle.svg);
					background-size: contain;
					background-repeat: no-repeat;
					margin-right: 12px;
					flex-shrink: 0;
					display: inline-block;
					flex-shrink: 0;
					vertical-align: middle;

				}',
			)
		);
	}
}
