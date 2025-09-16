<?php
/**
 * Docs Instruction Block Render
 *
 * @package Minami
 */

$docs_tabs = $attributes['tabs'] ?? array();
$search_placeholder = $attributes['searchPlaceholder'] ?? __( 'Search documentation...', 'docs-instruction' );
$is_password_protected = $attributes['isPasswordProtected'] ?? false;
$password = $attributes['password'] ?? '';
$password_prompt = $attributes['passwordPrompt'] ?? __( 'Enter password to access this documentation', 'docs-instruction' );

if ( empty( $docs_tabs ) ) {
	$docs_tabs = array(
		array(
			'id' => 'tab-1',
			'title' => __( 'Getting Started', 'docs-instruction' ),
			'content' => __( 'Welcome to the documentation. This section covers the basics of getting started.', 'docs-instruction' ),
			'youtubeUrl' => '',
			'description' => __( 'A comprehensive guide to help you get started with the platform.', 'docs-instruction' ),
		),
		array(
			'id' => 'tab-2',
			'title' => __( 'Installation', 'docs-instruction' ),
			'content' => __( 'Learn how to install and configure the system properly.', 'docs-instruction' ),
			'youtubeUrl' => '',
			'description' => __( 'Step-by-step installation instructions and configuration setup.', 'docs-instruction' ),
		),
	);
}

$unique_id = uniqid( 'docs-' );

// Check if user has valid session for this block.
// Use a more consistent session key based on post ID and password.
global $post;
$current_post_id = $post ? $post->ID : 0;
$session_key = 'docs_access_' . md5( $current_post_id . '_' . $password );
$has_access = false;

if ( $is_password_protected && ! empty( $password ) ) {
	// Check if user has valid session.
	$remote_addr = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$session_data = get_transient( $session_key . '_' . $remote_addr );
	if ( $session_data && 'authenticated' === $session_data ) {
		$has_access = true;
	}
} else {
	$has_access = true; // No password protection or no password set.
}
?>

<div <?php echo wp_kses_post( get_block_wrapper_attributes() ); ?>>
	<div class="docs-instruction" data-docs-id="<?php echo esc_attr( $unique_id ); ?>">
		<?php if ( $is_password_protected && ! empty( $password ) && ! $has_access ) : ?>
			<!-- Password protection form -->
			<div class="docs-password-form">
				<div class="docs-password-content">
					<h3><?php echo esc_html( $password_prompt ); ?></h3>
					<form class="docs-password-form-element" data-docs-id="<?php echo esc_attr( $unique_id ); ?>" data-session-key="<?php echo esc_attr( $session_key ); ?>">
						<div class="docs-password-input-group">
							<input type="password" name="docs_password" class="docs-password-input" placeholder="<?php echo esc_attr__( 'Enter password', 'docs-instruction' ); ?>" required>
							<button type="submit" class="docs-password-submit"><?php echo esc_html__( 'Access', 'docs-instruction' ); ?></button>
						</div>
						<div class="docs-password-error" style="display: none; color: #d63638; margin-top: 10px;"></div>
					</form>
				</div>
			</div>
		<?php else : ?>
			<!-- Normal documentation content -->
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
					<?php
					$youtube_url = isset( $docs_tab['youtubeUrl'] ) ? $docs_tab['youtubeUrl'] : '';
					$description = isset( $docs_tab['description'] ) ? $docs_tab['description'] : '';
					$video_id = minami_get_youtube_video_id( $youtube_url );
					$embed_url = minami_get_youtube_embed_url( $video_id );
					?>
					<div
						class="docs-content<?php echo 0 === $index ? ' active' : ''; ?>"
						data-content-id="<?php echo esc_attr( $docs_tab['id'] ); ?>"
					>
						<h3 class="docs-content-title">
							<?php echo wp_kses_post( $docs_tab['title'] ); ?>
						</h3>

						<?php if ( $embed_url ) : ?>
							<div class="docs-youtube-section">
								<div class="docs-youtube-iframe-container">
									<iframe
										src="<?php echo esc_url( $embed_url ); ?>"
										title="<?php echo esc_attr( $docs_tab['title'] ); ?>"
										frameborder="0"
										allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
										allowfullscreen
										class="docs-youtube-iframe"
									></iframe>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $description ) ) : ?>
							<div class="docs-description-section">
								<div class="docs-description-text">
									<?php echo wp_kses_post( $description ); ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $docs_tab['content'] ) ) : ?>
							<div class="docs-additional-content">
								<div class="docs-content-text">
									<?php echo wp_kses_post( $docs_tab['content'] ); ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<!-- Hidden data for JavaScript -->
		<script type="application/json" class="docs-data">
			<?php
			echo wp_json_encode(
				array(
					'tabs'               => $docs_tabs,
					'uniqueId'           => $unique_id,
					'isPasswordProtected' => $is_password_protected,
					'hasAccess'          => $has_access,
					'sessionKey'         => $session_key,
					'postId'             => $current_post_id,
				)
			);
			?>
		</script>
	</div>
</div>
