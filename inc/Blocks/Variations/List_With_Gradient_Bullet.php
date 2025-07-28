<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * List With Gradient Bullet Block Variation
 *
 * @package wordpress-theme
 * @since 1.0
 */

namespace Minami\Blocks\Variations;

/**
 * List_With_Gradient_Bullet Class
 *
 * This class registers a custom list style with gradient bullet points for the Gutenberg block editor.
 */
class List_With_Gradient_Bullet {

	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Constructor.
	 *
	 * Registers a custom list style with gradient bullet points for the Gutenberg block editor.
	 */
	public function __construct() {

		// Register the block style for list with gradient bullet points.
		register_block_style(
			'core/list',
			array(
				'name'         => 'list-with-gradient-bullet',
				'label'        => __( 'Gradient', 'minami' ),
				'inline_style' => '
				.wp-block-list.is-style-list-with-gradient-bullet {
					list-style: none;
					padding: 0;
					margin: 0;
				}

				.wp-block-list.is-style-list-with-gradient-bullet li {
					display: flex;
					align-items: center;
				}

				.wp-block-list.is-style-list-with-gradient-bullet li::before {
					content: "";
					width: 16px;
					height: 16px;
					background-image: url(' . MINAMI_THEME_URI . 'assets/images/svg-icons/gradient-bullet.svg);
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
