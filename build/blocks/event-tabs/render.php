<?php

/**
 * Server-side rendering for Event Tabs block
 */

$attributes = isset( $attributes ) ? $attributes : array();

// Get event categories (terms)
$event_categories = get_terms(
	array(
		'taxonomy' => 'event_category',
		'hide_empty' => false,
	)
);

// Build tab list: first tab is 'All', rest are categories
$tab_list = array_merge(
	array(
		array(
			'id' => null,
			'name' => __( 'All', 'event-tabs' ),
		),
	),
	array_map(
		function ( $cat ) {
			return array(
				'id' => $cat->term_id,
				'name' => $cat->name,
			);
		},
		$event_categories
	)
);

// Output markup
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<div class="event-tabs">
		<ul class="tabs">
			<?php foreach ( $tab_list as $idx => $tab ) : ?>
				<li class="tab<?php echo $idx === 0 ? ' active' : ''; ?>" data-tab-index="<?php echo esc_attr( $idx ); ?>">
					<?php echo esc_html( $tab['name'] ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content-wrap">
			<?php foreach ( $tab_list as $idx => $tab ) : ?>
				<div class="tab-content" style="<?php echo $idx === 0 ? '' : 'display:none;'; ?>">
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php
							$events = minami_get_latest_events_for_category( $tab['id'] );
							if ( empty( $events ) ) {
								echo '<div class="swiper-slide"><p>' . esc_html__( 'No events found for this category.', 'event-tabs' ) . '</p></div>';
							} else {
								foreach ( $events as $event ) {
									$thumb_url = minami_get_event_thumb_url( $event->ID );
									$title = get_the_title( $event );
									$link = get_permalink( $event );
									?>
									<div class="swiper-slide event-item">
										<a href="<?php echo esc_url( $link ); ?>" rel="noopener noreferrer" class="event-thumb-link">
											<?php if ( $thumb_url ) : ?>
												<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="event-thumb" />
											<?php else : ?>
												<img src="https://placehold.co/400x300?text=No+Image" alt="No image" class="event-thumb" />
											<?php endif; ?>
										</a>
										<h4>
											<a href="<?php echo esc_url( $link ); ?>" rel="noopener noreferrer"><?php echo esc_html( $title ); ?></a>
										</h4>
										<div class="event-excerpt">
											<?php echo minami_truncate_excerpt( $event, 10 ); ?>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
						<!-- Swiper controls -->
						<div class="swiper-pagination"></div>
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>
					<?php
					// Add "More" button for each tab.
					if ( $tab['id'] ) {
						// For specific category - link to category archive.
						$category_link = get_term_link( $tab['id'], 'event_category' );
						if ( ! is_wp_error( $category_link ) ) {
							?>
							<div class="tab-more-button">
								<a href="<?php echo esc_url( $category_link ); ?>" class="btn btn-more" rel="noopener noreferrer">
									<?php echo esc_html__( 'More', 'event-tabs' ); ?>
								</a>
							</div>
							<?php
						}
					} else {
						// For "All" tab - link to main events archive.
						$events_archive_link = get_post_type_archive_link( 'event' );

						// Fallback: if archive link doesn't exist, create a custom events page link.
						if ( ! $events_archive_link ) {
							// Try to find a page with slug 'events' or use home page with events query.
							$events_page = get_page_by_path( 'events' );
							if ( $events_page ) {
								$events_archive_link = get_permalink( $events_page );
							} else {
								// Fallback to home page with events query parameter.
								$events_archive_link = home_url( '/?post_type=event' );
							}
						}

						if ( $events_archive_link ) {
							?>
							<div class="tab-more-button">
								<a href="<?php echo esc_url( $events_archive_link ); ?>" class="btn btn-more" rel="noopener noreferrer">
									<?php echo esc_html__( 'More Events', 'event-tabs' ); ?>
								</a>
							</div>
							<?php
						}
					}
					?>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
</div>
