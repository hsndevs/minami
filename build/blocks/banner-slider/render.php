<?php
$images = $attributes['images'] ?? [];

if (empty($images)) {
	return '';
}

$unique_id = uniqid('swiper-');
?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<div class="banner-slider-editor-preview">
		<div class="swiper" data-swiper-id="<?php echo esc_attr($unique_id); ?>">
			<div class="swiper-wrapper">
				<?php foreach ($images as $image) : ?>
					<div class="swiper-slide">
						<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
					</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-pagination"></div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
	</div>
</div>
