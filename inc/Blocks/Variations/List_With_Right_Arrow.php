<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * List With Right Arrow Block Variation
 *
 * @package wordpress-theme
 * @since 1.0
 */

namespace Minami\Blocks\Variations;

/**
 * List_With_Right_Arrow Class
 *
 * This class registers a custom list style with right arrow icons for the Gutenberg block editor.
 */
class List_With_Right_Arrow {

	use \Minami\Traits\Singleton; // Use the Singleton and PluginData trait.

	/**
	 * Constructor.
	 *
	 * Registers a custom list style with right arrow icons for the Gutenberg block editor.
	 */
	public function __construct() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'list-with-right-arrow',
				'label'        => __( 'Right Arrow', 'minami' ),
				'inline_style' => '
				.wp-block-list.is-style-list-with-right-arrow {
					list-style: none;
					padding: 0;
					margin: 0;
				}

				.wp-block-list.is-style-list-with-right-arrow li {
					display: flex;
					align-items: flex-start;
					margin-bottom: 20px;
				}

				.wp-block-list.is-style-list-with-right-arrow li::before {
					content: "";
					width: 24px;
					height: 24px;
					background-image: url(' . MINAMI_THEME_URI . 'assets/images/svg-icons/right-arrow-angle.svg);
					background-size: contain;
					background-repeat: no-repeat;
					margin-right: 12px;
					flex-shrink: 0;

				}',
			)
		);
	}
}
