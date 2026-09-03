<?php
get_header();
the_post();

$author     = get_the_author();
$date       = get_the_date('F j, Y');
$categories = get_the_category();
$tags       = get_the_tags();
$thumb      = get_the_post_thumbnail_url(get_the_ID(), 'large');
$recent     = get_posts(['post_type' => 'post', 'posts_per_page' => 4, 'post_status' => 'publish', 'post__not_in' => [get_the_ID()]]);
?>

<main id="main" class="site-main">

    <div class="page-hero">
        <div class="container page-hero__content">
            <?php if (!empty($categories)): ?>
                <span class="page-hero__eyebrow"><?php echo esc_html($categories[0]->name); ?></span>
            <?php else: ?>
                <span class="page-hero__eyebrow">Post</span>
            <?php endif; ?>
            <h1><?php the_title(); ?></h1>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current"><?php the_title(); ?></span>
            </nav>
        </div>
    </div>

    <section class="single-section">
        <div class="container">
            <div class="single-layout">

                <article class="single-article">

                    <?php if ($thumb): ?>
                        <div style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:2rem;">
                            <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" style="width:100%;height:auto;display:block;">
                        </div>
                    <?php endif; ?>

                    <div class="single-meta">
                        <span class="single-meta__item">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="meta-icon" aria-hidden="true"><rect x="3" y="4" width="14" height="14" rx="2"/><path d="M7 2v4M13 2v4M3 9h14"/></svg>
                            <?php echo esc_html($date); ?>
                        </span>
                        <?php if ($author): ?>
                        <span class="single-meta__item">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="meta-icon" aria-hidden="true"><circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/></svg>
                            <?php echo esc_html($author); ?>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($categories)): ?>
                        <span class="single-meta__item">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="meta-icon" aria-hidden="true"><path d="M3 5h5l2 2h7v10H3z"/></svg>
                            <?php echo esc_html(implode(', ', array_column($categories, 'name'))); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="entry-content"><?php the_content(); ?></div>

                    <?php if (!empty($tags)): ?>
                    <div class="single-tags">
                        <?php foreach ($tags as $tag): ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="single-tag"><?php echo esc_html($tag->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="single-nav">
                        <?php $prev = get_previous_post(); $next = get_next_post(); ?>
                        <?php if ($prev): ?>
                            <a href="<?php echo esc_url(get_permalink($prev->ID)); ?>" class="single-nav__link single-nav__link--prev">
                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 8H3M7 4l-4 4 4 4"/></svg>
                                <span>
                                    <em>Previous</em>
                                    <?php echo esc_html(get_the_title($prev->ID)); ?>
                                </span>
                            </a>
                        <?php endif; ?>
                        <?php if ($next): ?>
                            <a href="<?php echo esc_url(get_permalink($next->ID)); ?>" class="single-nav__link single-nav__link--next">
                                <span>
                                    <em>Next</em>
                                    <?php echo esc_html(get_the_title($next->ID)); ?>
                                </span>
                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>

                </article>

                <aside class="single-sidebar">
                    <?php if (!empty($recent)): ?>
                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget__title">Recent Posts</h4>
                        <?php foreach ($recent as $r): ?>
                            <div class="sidebar-post">
                                <?php $r_thumb = get_the_post_thumbnail_url($r->ID, 'thumbnail'); ?>
                                <?php if ($r_thumb): ?>
                                    <div class="sidebar-post__thumb">
                                        <a href="<?php echo esc_url(get_permalink($r->ID)); ?>">
                                            <img src="<?php echo esc_url($r_thumb); ?>" alt="<?php echo esc_attr(get_the_title($r->ID)); ?>" loading="lazy">
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="sidebar-post__title"><a href="<?php echo esc_url(get_permalink($r->ID)); ?>"><?php echo esc_html(get_the_title($r->ID)); ?></a></div>
                                    <div class="sidebar-post__date"><?php echo esc_html(get_the_date('F j, Y', $r->ID)); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget__title">Explore</h4>
                        <div style="display:flex;flex-direction:column;gap:0.6rem;">
                            <a href="<?php echo esc_url(get_post_type_archive_link('sermon')); ?>" class="btn btn-outline btn-sm">Sermons</a>
                            <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>" class="btn btn-outline btn-sm">Events</a>
                            <a href="<?php echo esc_url(get_post_type_archive_link('tphb_outreach')); ?>" class="btn btn-outline btn-sm">Outreach</a>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) ?: home_url('/contact/')); ?>" class="btn btn-primary btn-sm">Contact Us</a>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
