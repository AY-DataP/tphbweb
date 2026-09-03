<?php
get_header();
?>
<main class="site-main">
    <div class="container">
        <?php if (have_posts()): ?>
            <div class="posts-grid">
                <?php while (have_posts()): the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()): ?>
                            <div class="post-card__thumb">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="post-card__body">
                            <div class="post-card__meta">
                                <span><?php echo esc_html(get_the_date()); ?></span>
                            </div>
                            <h2 class="post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="post-card__excerpt"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline">Read More</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="pagination"><?php the_posts_pagination(); ?></div>
        <?php else: ?>
            <p class="no-content">No content found.</p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
