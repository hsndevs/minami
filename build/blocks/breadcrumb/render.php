<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<?php
// Minami Breadcrumb Block Render
function minami_breadcrumb_get_items() {
	$items = array();
	$home_url = home_url( '/' );
	$items[] = array(
		'url' => $home_url,
		'label' => '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/home.webp' ) . '" alt="Home" style="height:1em;width:auto;vertical-align:middle;margin-right:0.3em;" />' . esc_html__( 'Home', 'minami' ),
	);

	if ( is_singular() ) {
		$post = get_post();
		$post_type = get_post_type_object( $post->post_type );
		if ( 'page' !== $post->post_type ) {
			$archive_link = get_post_type_archive_link( $post->post_type );
			if ( $archive_link ) {
				$items[] = array(
					'url' => $archive_link,
					'label' => $post_type->labels->singular_name,
				);
			}
		}
		$items[] = array(
			'url' => get_permalink( $post ),
			'label' => get_the_title( $post ),
		);
	} elseif ( is_post_type_archive() ) {
		$post_type = get_post_type_object( get_post_type() );
		$items[] = array(
			'url' => '',
			'label' => $post_type->labels->singular_name,
		);
	} elseif ( is_home() || is_front_page() ) {
		// Only Home
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		$taxonomy = get_taxonomy( $term->taxonomy );
		$items[] = array(
			'url' => get_term_link( $term ),
			'label' => $term->name,
		);
	} elseif ( is_search() ) {
		$items[] = array(
			'url' => '',
			'label' => sprintf( __( 'Search results for "%s"', 'minami' ), get_search_query() ),
		);
	} elseif ( is_404() ) {
		$items[] = array(
			'url' => '',
			'label' => __( '404 Not Found', 'minami' ),
		);
	}
	return $items;
}

$custom_title = isset( $attributes['customTitle'] ) && $attributes['customTitle'] ? $attributes['customTitle'] : '';

$items = minami_breadcrumb_get_items();
if ( empty( $items ) ) {
	return;
}

// Output the custom title (or fallback to the last breadcrumb label) as <h1> before the breadcrumb.
$page_heading = '';
$title_to_show = $custom_title ? $custom_title : ( isset( $items[ count( $items ) - 1 ]['label'] ) ? wp_strip_all_tags( $items[ count( $items ) - 1 ]['label'] ) : '' );
if ( $custom_title ) {
	$page_heading = '<h1 class="minami-breadcrumb-title">' . esc_html( $custom_title ) . '</h1>';
} elseif ( $title_to_show ) {
	$page_heading = '<h1 class="minami-breadcrumb-title">' . esc_html( $title_to_show ) . '</h1>';
}

?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore ?>>
<?php echo wp_kses_post( $page_heading ); ?>
<nav class="minami-breadcrumb" aria-label="Breadcrumb">
	<ul>
		<?php foreach ( $items as $i => $item ) : ?>
			<li>
				<?php if ( $item['url'] && $i < count( $items ) - 1 ) : ?>
					<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo wp_kses_post( $item['label'] ); ?></a>
				<?php else : ?>
					<span><?php echo wp_kses_post( $title_to_show ); ?></span>
				<?php endif; ?>
			</li>
			<!-- include this <li>></li> if it is not the last item -->
			<?php if ( $i < count( $items ) - 1 ) : ?>
				<li class="separator">></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>
</div>
