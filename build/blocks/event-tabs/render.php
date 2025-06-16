<?php

/**
 * Server-side rendering for Event Tabs block
 */

$attributes = isset($attributes) ? $attributes : array();

// Get event categories (terms)
$event_categories = get_terms(array(
	'taxonomy' => 'event_category',
	'hide_empty' => false,
));

// Get latest 3 events for a category (or all if $cat_id is null)
function minami_get_latest_events_for_category($cat_id = null, $limit = 3) {
	$args = array(
		'post_type' => 'event',
		'posts_per_page' => $limit,
		'orderby' => 'date',
		'order' => 'DESC',
	);
	if ($cat_id) {
		$args['tax_query'] = array(array(
			'taxonomy' => 'event_category',
			'field' => 'term_id',
			'terms' => $cat_id,
		));
	}
	return get_posts($args);
}

// Helper: Get event excerpt (max 10 words)
function minami_truncate_excerpt($post, $word_limit = 10) {
	$excerpt = get_the_excerpt($post);
	$words = preg_split('/\s+/', wp_strip_all_tags($excerpt), -1, PREG_SPLIT_NO_EMPTY);
	$truncated = array_slice($words, 0, $word_limit);
	return esc_html(implode(' ', $truncated) . (count($words) > $word_limit ? '...' : ''));
}

// Helper: Get event thumbnail URL
function minami_get_event_thumb_url($post_id) {
	$thumb_id = get_post_thumbnail_id($post_id);
	if ($thumb_id) {
		$img = wp_get_attachment_image_src($thumb_id, 'medium');
		return $img ? $img[0] : '';
	}
	return '';
}

// Build tab list: first tab is 'All', rest are categories
$tab_list = array_merge([
	array('id' => null, 'name' => __('All', 'event-tabs'))
], array_map(function ($cat) {
	return array('id' => $cat->term_id, 'name' => $cat->name);
}, $event_categories));

// Output markup
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<div class="event-tabs">
		<ul class="tabs">
			<?php foreach ($tab_list as $idx => $tab): ?>
				<li class="tab<?php echo $idx === 0 ? ' active' : ''; ?>" data-tab-index="<?php echo esc_attr($idx); ?>">
					<?php echo esc_html($tab['name']); ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content-wrap">
			<?php foreach ($tab_list as $idx => $tab): ?>
				<div class="tab-content" style="<?php echo $idx === 0 ? '' : 'display:none;'; ?>">
					<?php
					$events = minami_get_latest_events_for_category($tab['id']);
					if (empty($events)) {
						echo '<p>' . esc_html__('No events found for this category.', 'event-tabs') . '</p>';
					} else {
						foreach ($events as $event) {
							$thumb_url = minami_get_event_thumb_url($event->ID);
							$title = get_the_title($event);
							$link = get_permalink($event);
					?>
						<div class="event-item">
							<a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer" class="event-thumb-link">
								<?php if ($thumb_url): ?>
									<img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>" class="event-thumb" />
								<?php else: ?>
									<img src="https://placehold.co/400x300?text=No+Image" alt="No image" class="event-thumb" />
								<?php endif; ?>
							</a>
							<h4>
								<a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($title); ?></a>
							</h4>
							<div class="event-excerpt">
								<?php echo minami_truncate_excerpt($event, 10); ?>
							</div>
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
<script>
	// Simple tab switcher for frontend (no jQuery)
	document.addEventListener('DOMContentLoaded', function() {
		var tabBlocks = document.querySelectorAll('.event-tabs');
		tabBlocks.forEach(function(tabBlock) {
			var tabs = tabBlock.querySelectorAll('.tabs .tab');
			var contents = tabBlock.querySelectorAll('.tab-content');
			tabs.forEach(function(tab, idx) {
				tab.addEventListener('click', function() {
					tabs.forEach(function(t) {
						t.classList.remove('active');
					});
					contents.forEach(function(c) {
						c.style.display = 'none';
					});
					tab.classList.add('active');
					contents[idx].style.display = '';
				});
			});
		});
	});
</script>
