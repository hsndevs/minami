<?php
/**
 * Docs Instruction Block Render
 *
 * @package Minami
 */

$docs_tabs = $attributes['tabs'] ?? array();
$search_placeholder = $attributes['searchPlaceholder'] ?? __( 'Search documentation...', 'docs-instruction' );

if ( empty( $docs_tabs ) ) {
	$docs_tabs = array(
		array(
			'id' => 'tab-1',
			'title' => __( 'Getting Started', 'docs-instruction' ),
			'content' => __( 'Welcome to the documentation. This section covers the basics of getting started.', 'docs-instruction' ),
		),
		array(
			'id' => 'tab-2',
			'title' => __( 'Installation', 'docs-instruction' ),
			'content' => __( 'Learn how to install and configure the system properly.', 'docs-instruction' ),
		),
	);
}

$unique_id = uniqid( 'docs-' );
?>

<div <?php echo wp_kses_post( get_block_wrapper_attributes() ); ?>>
	<div class="docs-instruction" data-docs-id="<?php echo esc_attr( $unique_id ); ?>">
		<div class="docs-search">
			<input
				type="text"
				class="docs-search-input"
				placeholder="<?php echo esc_attr( $search_placeholder ); ?>"
				data-search-target="<?php echo esc_attr( $unique_id ); ?>"
			/>
		</div>

		<div class="docs-container">
			<div class="docs-tabs-sidebar">
				<div class="docs-tabs-list">
					<?php foreach ( $docs_tabs as $index => $docs_tab ) : ?>
						<div
							class="docs-tab<?php echo 0 === $index ? ' active' : ''; ?>"
							data-tab-id="<?php echo esc_attr( $docs_tab['id'] ); ?>"
							data-tab-index="<?php echo esc_attr( $index ); ?>"
						>
							<span class="docs-tab-title">
								<?php echo wp_kses_post( $docs_tab['title'] ); ?>
							</span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="docs-content-area">
				<?php foreach ( $docs_tabs as $index => $docs_tab ) : ?>
					<div
						class="docs-content<?php echo 0 === $index ? ' active' : ''; ?>"
						data-content-id="<?php echo esc_attr( $docs_tab['id'] ); ?>"
					>
						<h3 class="docs-content-title">
							<?php echo wp_kses_post( $docs_tab['title'] ); ?>
						</h3>
						<div class="docs-content-text">
							<?php echo wp_kses_post( $docs_tab['content'] ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- Hidden data for JavaScript -->
		<script type="application/json" class="docs-data">
			<?php
			echo wp_json_encode(
				array(
					'tabs'     => $docs_tabs,
					'uniqueId' => $unique_id,
				)
			);
			?>
		</script>
	</div>
</div>
