<?php
/**
 * Archive template for custom post type: activity
 * Place this file in your theme root to override the archive for 'activity'.
 */
get_header();
?>
<main id="primary" class="site-main">
    <h1><?php post_type_archive_title(); ?></h1>
    <?php if ( have_posts() ) : ?>
        <div class="activity-archive-list">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php endif; ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php the_posts_navigation(); ?>
    <?php else : ?>
        <p><?php esc_html_e('No activities found.', 'minami'); ?></p>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
