<?php
/**
 * Navigation Menu Block
 *
 * @package Minami
 */

namespace Minami\Blocks;

/**
 * Navigation Menu Block Class
 */
class Navigation_Menu {

	use \Minami\Traits\Singleton; // Use the Singleton trait.

	/**
	 * Constructor (private to enforce singleton pattern)
	 */
	private function __construct() {
		$this->register_hooks();
	}

	/**
	 * Register hooks
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'register_block' ) );
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'add_custom_nav_fields' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'save_custom_nav_fields' ), 10, 3 );
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'setup_nav_menu_item' ) );
		add_action( 'rest_api_init', array( $this, 'register_rest_fields' ) );
	}

	/**
	 * Register the block
	 */
	public function register_block() {
		// Register block using block.json.
		register_block_type(
			get_template_directory() . '/src/blocks/navigation-menu',
			array(
				'render_callback' => array( $this, 'render_callback' ),
			)
		);
	}

	/**
	 * Render the block
	 *
	 * @param array $attributes Block attributes.
	 * @return string
	 */
	public function render_callback( $attributes ) {
		$menu_id = isset( $attributes['menuId'] ) ? intval( $attributes['menuId'] ) : 0;

		if ( ! $menu_id ) {
			return '<div class="minami-nav-block-notice">Please select a menu to display.</div>';
		}

		// Debug information.
		$debug_output = '';
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$debug_output = '<div class="debug-info">Menu ID: ' . esc_html( $menu_id ) . '</div>';
		}

		// Load the template file.
		ob_start();
		include get_template_directory() . '/src/blocks/navigation-menu/render.php';
		$template_output = ob_get_clean();

		return $debug_output . $template_output;
	}

	/**
	 * Build menu tree structure
	 *
	 * @param array $menu_items Array of menu items.
	 * @return array Menu tree structure.
	 */
	private function build_menu_tree( $menu_items ) {
		$tree = array();

		foreach ( $menu_items as $item ) {
			$parent_id = (int) $item->menu_item_parent;

			if ( ! isset( $tree[ $parent_id ] ) ) {
				$tree[ $parent_id ] = array();
			}

			$tree[ $parent_id ][] = $item;
		}

		return $tree;
	}

	/**
	 * Render menu level
	 *
	 * @param array $menu_tree Menu tree structure.
	 * @param int   $parent_id Parent ID.
	 * @param bool  $is_submenu Whether this is a submenu.
	 * @return string Rendered menu HTML.
	 */
	private function render_menu_level( $menu_tree, $parent_id = 0, $is_submenu = false ) {
		if ( ! isset( $menu_tree[ $parent_id ] ) ) {
			return '';
		}

		$class = 'minami-nav-list';
		if ( $is_submenu ) {
			$class .= ' minami-nav-submenu';
		}

		$output = '<ul class="' . esc_attr( $class ) . '">';

		foreach ( $menu_tree[ $parent_id ] as $item ) {
			$has_children = isset( $menu_tree[ $item->ID ] );

			$item_class = 'minami-nav-item';
			if ( $has_children ) {
				$item_class .= ' has-submenu';
			}

			$output .= '<li class="' . esc_attr( $item_class ) . '">';

			// Link.
			$output .= '<a href="' . esc_url( $item->url ) . '" class="minami-nav-link">';
			$output .= '<span class="minami-nav-title">' . esc_html( $item->title ) . '</span>';

			// Use custom English title meta field if available.
			if ( ! empty( $item->english_title ) ) {
				$output .= '<span class="minami-nav-en-title"> - ' . esc_html( $item->english_title ) . '</span>';
			}

			$output .= '</a>';

			// Render children.
			if ( $has_children ) {
				$output .= $this->render_menu_level( $menu_tree, $item->ID, true );
			}

			$output .= '</li>';
		}

		$output .= '</ul>';

		return $output;
	}

	/**
	 * Add custom fields to nav menu items
	 *
	 * @param int    $item_id Menu item ID.
	 * @param object $item Menu item object.
	 * @param int    $depth Depth of menu item.
	 * @param array  $args Menu arguments.
	 */
	public function add_custom_nav_fields( $item_id, $item, $depth, $args ) {
		$english_title = get_post_meta( $item_id, '_menu_item_english_title', true );
		?>
		<p class="field-english-title description description-wide">
			<label for="edit-menu-item-english-title-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'English Title', 'minami' ); ?><br />
				<input type="text" id="edit-menu-item-english-title-<?php echo esc_attr( $item_id ); ?>"
					   class="widefat code edit-menu-item-english-title"
					   name="menu-item-english-title[<?php echo esc_attr( $item_id ); ?>]"
					   value="<?php echo esc_attr( $english_title ); ?>" />
				<span class="description"><?php esc_html_e( 'Optional English translation/subtitle for this menu item.', 'minami' ); ?></span>
			</label>
		</p>
		<?php
	}

	/**
	 * Save custom nav menu fields
	 *
	 * @param int   $menu_id Menu ID.
	 * @param int   $menu_item_db_id Menu item ID.
	 * @param array $args Menu item arguments.
	 */
	public function save_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
		// WordPress handles nonce verification for nav menu updates.
		if ( isset( $_POST['menu-item-english-title'][ $menu_item_db_id ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$english_title = sanitize_text_field( wp_unslash( $_POST['menu-item-english-title'][ $menu_item_db_id ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
			update_post_meta( $menu_item_db_id, '_menu_item_english_title', $english_title );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu_item_english_title' );
		}
	}

	/**
	 * Setup nav menu item with custom fields
	 *
	 * @param object $menu_item Menu item object.
	 * @return object Modified menu item object.
	 */
	public function setup_nav_menu_item( $menu_item ) {
		$menu_item->english_title = get_post_meta( $menu_item->ID, '_menu_item_english_title', true );
		return $menu_item;
	}

	/**
	 * Register REST API fields for menu items
	 */
	public function register_rest_fields() {
		register_rest_field(
			'nav_menu_item',
			'english_title',
			array(
				'get_callback' => array( $this, 'get_english_title_rest_field' ),
				'schema'       => array(
					'description' => __( 'English title for the menu item.', 'minami' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
				),
			)
		);
	}

	/**
	 * Get English title for REST API
	 *
	 * @param array $object Menu item object.
	 * @return string English title.
	 */
	public function get_english_title_rest_field( $object ) {
		return get_post_meta( $object['id'], '_menu_item_english_title', true );
	}
}
