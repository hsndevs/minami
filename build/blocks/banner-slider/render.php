<?php
/**
 * Banner Slider Block Render
 *
 * @package Minami
 */

$images = $attributes['images'] ?? array();
if ( empty( $images ) ) {
	$images = array(
		array(
			'url' => get_template_directory_uri() . '/assets/images/namba-square.webp',
			'alt' => 'Namba Square',
			'caption' => 'Namba Square',
			'link' => '#',
			'mime' => 'image/webp',
			'type' => 'image',
			'subtype' => 'webp',
			'sizes' => array(
				'full' => array(
					'url' => get_template_directory_uri() . '/assets/images/namba-square.webp',
					'height' => 840,
					'width' => 1261,
					'orientation' => 'landscape',
				),
			),
		),
		array(
			'url' => get_template_directory_uri() . '/assets/images/namba-square.webp',
			'alt' => 'Namba Square',
			'caption' => 'Namba Square',
			'link' => '#',
			'mime' => 'image/webp',
			'type' => 'image',
			'subtype' => 'webp',
			'sizes' => array(
				'full' => array(
					'url' => get_template_directory_uri() . '/assets/images/namba-square.webp',
					'height' => 954,
					'width' => 1431,
					'orientation' => 'landscape',
				),
			),
		),
	);
}

$unique_id = uniqid( 'swiper-' );
$slider_height = isset( $attributes['sliderHeight'] ) ? intval( $attributes['sliderHeight'] ) : 500;
?>

<div <?php echo esc_attr( get_block_wrapper_attributes() ); ?>>
	<div class="banner-slider-editor-preview" style="height:<?php echo esc_attr( $slider_height ); ?>px">
		<div class="swiper" data-swiper-id="<?php echo esc_attr( $unique_id ); ?>" data-slider-height="<?php echo esc_attr( $slider_height ); ?>">
			<div class="swiper-wrapper">
				<?php foreach ( $images as $image ) : ?>
					<div class="swiper-slide">
						<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
					</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-pagination"></div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
	</div>
</div>
