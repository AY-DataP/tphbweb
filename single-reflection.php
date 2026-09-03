<?php
get_header();
the_post();

$type     = get_field('reflection_type');
$youtube  = get_field('reflection_youtube_url');
$category = get_field('reflection_category');
$gallery  = get_field('reflection_gallery');
$embed    = tphb_get_youtube_embed_url($youtube);
$cat_labels = ['sermon-snippet'=>'Sermon Snippet','nights-of-mercy'=>'Nights of Mercy','devotional'=>'Devotional','other'=>'Reflection'];
$cat_label  = $cat_labels[$category] ?? 'Reflection';
$recent = get_posts(['post_type'=>'reflection','posts_per_page'=>4,'post_status'=>'publish','post__not_in'=>[get_the_ID()]]);
?>

<main id="main" class="site-main">

    <div class="page-hero">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow"><?php echo esc_html($cat_label); ?></span>
            <h1><?php the_title(); ?></h1>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <a href="<?php echo esc_url(get_post_type_archive_link('reflection')); ?>">Reflections</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current"><?php the_title(); ?></span>
            </nav>
        </div>
    </div>

    <section class="single-section">
        <div class="container">
            <div class="single-layout">
                <article class="single-article">
                    <?php if ($embed && ($type === 'video' || $type === 'both')): ?>
                        <div class="single-article__video">
                            <iframe src="<?php echo esc_url($embed); ?>" frameborder="0" allowfullscreen allow="accelerometer; autoplay; encrypted-media" title="<?php the_title_attribute(); ?>"></iframe>
                        </div>
                    <?php elseif (has_post_thumbnail()): ?>
                        <div style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:2rem;"><?php the_post_thumbnail('large'); ?></div>
                    <?php endif; ?>

                    <div class="single-meta">
                        <span class="single-meta__item">&#128197; <?php echo esc_html(get_the_date('F j, Y')); ?></span>
                        <span class="single-meta__item">&#127991; <strong><?php echo esc_html($cat_label); ?></strong></span>
                    </div>

                    <div class="entry-content"><?php the_content(); ?></div>

                    <?php if ($gallery): ?>
                    <div class="post-gallery">
                        <h3 class="post-gallery__title">&#128247; Photos</h3>
                        <div class="post-gallery__grid">
                            <?php foreach ($gallery as $i => $img): ?>
                            <div class="gallery-item post-gallery__item" data-src="<?php echo esc_url($img['url']); ?>" data-alt="<?php echo esc_attr($img['alt'] ?: $img['title']); ?>" role="button" tabindex="0" aria-label="View photo <?php echo $i + 1; ?>">
                                <img src="<?php echo esc_url($img['sizes']['medium'] ?? $img['url']); ?>" alt="<?php echo esc_attr($img['alt'] ?: $img['title']); ?>" loading="lazy">
                                <div class="gallery-item__overlay" aria-hidden="true"><span>&#128269;</span></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div style="display:flex;gap:1rem;margin-top:2.5rem;padding-top:2rem;border-top:1px solid var(--gray-light);">
                        <a href="<?php echo esc_url(get_post_type_archive_link('reflection')); ?>" class="btn btn-outline">&larr; All Reflections</a>
                    </div>
                </article>

                <aside class="single-sidebar">
                    <?php if (!empty($recent)): ?>
                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget__title">More Reflections</h4>
                        <?php foreach ($recent as $r): ?>
                            <div class="sidebar-post">
                                <div>
                                    <div class="sidebar-post__title"><a href="<?php echo esc_url(get_permalink($r->ID)); ?>"><?php echo esc_html(get_the_title($r->ID)); ?></a></div>
                                    <div class="sidebar-post__date"><?php echo esc_html(get_the_date('F j, Y', $r->ID)); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
