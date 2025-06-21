<?php
$images = $attributes['images'] ?? [];

if (empty($images)) {
	return '';
}

$unique_id = uniqid('swiper-');
$slider_height = isset($attributes['sliderHeight']) ? intval($attributes['sliderHeight']) : 500;
?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<div class="banner-slider-editor-preview" style="height:<?php echo esc_attr($slider_height); ?>px">
		<div class="swiper" data-swiper-id="<?php echo esc_attr($unique_id); ?>" data-slider-height="<?php echo esc_attr($slider_height); ?>">
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
