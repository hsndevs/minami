<?php
/**
 * Navigation Menu Block Template
 *
 * @package Minami
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$menu_id = isset( $attributes['menuId'] ) ? (int) $attributes['menuId'] : 0;

// If no menu selected, show placeholder.
if ( ! $menu_id ) {
	?>
	<div class="minami-nav-block" style="padding: 20px; border: 1px dashed #ccc; text-align: center;">
		<p><?php esc_html_e( 'No menu selected.', 'minami' ); ?></p>
	</div>
	<?php
	return;
}

// Get menu items.
$menu_items = wp_get_nav_menu_items( $menu_id );

if ( ! $menu_items ) {
	?>
	<div class="minami-nav-block" style="padding: 20px; border: 1px dashed #ccc; text-align: center;">
		<?php /* translators: %d: Menu ID */ ?>
		<p><?php echo esc_html( sprintf( __( 'Menu not found or empty. Menu ID: %d', 'minami' ), $menu_id ) ); ?></p>
	</div>
	<?php
	return;
}

// Setup menu items with custom fields.
foreach ( $menu_items as $item ) {
	$item->english_title = get_post_meta( $item->ID, '_menu_item_english_title', true );
	$item->is_dropdown   = get_post_meta( $item->ID, '_menu_item_is_dropdown', true );
}

/**
 * Build menu tree structure
 *
 * @param array $menu_items Array of menu items.
 * @return array Menu tree structure.
 */
function minami_build_menu_tree( $menu_items ) {
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
 * @return void
 */
function minami_render_menu_level( $menu_tree, $parent_id = 0, $is_submenu = false ) {
	if ( ! isset( $menu_tree[ $parent_id ] ) ) {
		return;
	}

	$class = 'minami-nav-list';
	if ( $is_submenu ) {
		$class .= ' minami-nav-submenu';
	}
	?>
	<ul class="<?php echo esc_attr( $class ); ?>">
		<?php
		$menu_items  = $menu_tree[ $parent_id ];
		$total_items = count( $menu_items );
		foreach ( $menu_items as $index => $item ) :
			?>
			<?php
			$has_children = isset( $menu_tree[ $item->ID ] );
			$item_class   = 'minami-nav-item';
			if ( $has_children ) {
				$item_class .= ' has-submenu';
			}
			// Check if this is the last item in the main menu and has children.
			$is_last_main_item = 0 === $parent_id && ( $total_items - 1 ) === $index && $has_children;
			if ( $is_last_main_item ) {
				$item_class .= ' last-main-item';
			}
			// Add dropdown class if enabled and has children.
			if ( ! empty( $item->is_dropdown ) && $has_children && ! $is_submenu ) {
				$item_class .= ' is-dropdown';
			}
			?>
			<li class="<?php echo esc_attr( $item_class ); ?>">
				<a href="<?php echo esc_url( $item->url ); ?>" class="minami-nav-link">
					<span class="minami-nav-title"><?php echo esc_html( $item->title ); ?></span>
					<?php if ( ! empty( $item->english_title ) ) : ?>
						<span class="minami-item-separator"><?php echo esc_html( $is_submenu ? '/' : '' ); ?></span>
						<span class="minami-nav-en-title"><?php echo esc_html( $item->english_title ); ?></span>
					<?php endif; ?>
				</a>
				<?php if ( $has_children ) : ?>
					<?php minami_render_menu_level( $menu_tree, $item->ID, true ); ?>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

// Build menu tree and render.
$menu_tree = minami_build_menu_tree( $menu_items );
?>

<nav class="minami-nav">
	<?php minami_render_menu_level( $menu_tree, 0 ); ?>
</nav>
