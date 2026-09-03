<?php
get_header();
the_post();

$event_date = get_field('outreach_event_date');
$location   = get_field('outreach_location');
$program    = get_field('outreach_program_type');
$video_url  = get_field('outreach_video_url');
$embed      = tphb_get_youtube_embed_url($video_url);
$gallery    = get_field('outreach_gallery');
$recent     = get_posts(['post_type'=>'tphb_outreach','posts_per_page'=>4,'post_status'=>'publish','post__not_in'=>[get_the_ID()]]);
?>

<main id="main" class="site-main">

    <div class="page-hero">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow"><?php echo $program ? esc_html($program) : 'Outreach'; ?></span>
            <h1><?php the_title(); ?></h1>
            <?php if ($event_date): ?>
                <p style="color:rgba(255,255,255,0.7);">&#128197; <?php echo esc_html(date('F j, Y', strtotime($event_date))); ?><?php echo $location ? ' &nbsp;&middot;&nbsp; &#128205; ' . esc_html($location) : ''; ?></p>
            <?php endif; ?>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <a href="<?php echo esc_url(get_post_type_archive_link('tphb_outreach')); ?>">Outreach</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current"><?php the_title(); ?></span>
            </nav>
        </div>
    </div>

    <section class="single-section">
        <div class="container">
            <div class="single-layout">
                <article class="single-article">
                    <?php if ($embed): ?>
                        <div class="single-article__video">
                            <iframe src="<?php echo esc_url($embed); ?>" frameborder="0" allowfullscreen allow="accelerometer; autoplay; encrypted-media" title="<?php the_title_attribute(); ?>"></iframe>
                        </div>
                    <?php elseif (has_post_thumbnail()): ?>
                        <div style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:2rem;"><?php the_post_thumbnail('large'); ?></div>
                    <?php endif; ?>

                    <div class="single-meta">
                        <?php if ($event_date): ?><span class="single-meta__item">&#128197; <strong><?php echo esc_html(date('F j, Y', strtotime($event_date))); ?></strong></span><?php endif; ?>
                        <?php if ($location): ?><span class="single-meta__item">&#128205; <?php echo esc_html($location); ?></span><?php endif; ?>
                        <?php if ($program): ?><span class="single-meta__item">&#128101; <?php echo esc_html($program); ?></span><?php endif; ?>
                    </div>

                    <div class="entry-content"><?php the_content(); ?></div>

                    <?php if ($gallery): ?>
                    <div class="post-gallery">
                        <h3 class="post-gallery__title">&#128247; Event Photos</h3>
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
                        <a href="<?php echo esc_url(get_post_type_archive_link('tphb_outreach')); ?>" class="btn btn-outline">&larr; All Outreach</a>
                    </div>
                </article>

                <aside class="single-sidebar">
                    <?php if (!empty($recent)): ?>
                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget__title">More Outreach</h4>
                        <?php foreach ($recent as $r): ?>
                            <?php $r_thumb = get_the_post_thumbnail_url($r->ID, 'thumbnail'); ?>
                            <div class="sidebar-post">
                                <?php if ($r_thumb): ?>
                                    <div class="sidebar-post__thumb"><img src="<?php echo esc_url($r_thumb); ?>" alt="<?php echo esc_attr(get_the_title($r->ID)); ?>" loading="lazy"></div>
                                <?php endif; ?>
                                <div>
                                    <div class="sidebar-post__title"><a href="<?php echo esc_url(get_permalink($r->ID)); ?>"><?php echo esc_html(get_the_title($r->ID)); ?></a></div>
                                    <?php $r_date = get_field('outreach_event_date', $r->ID); ?>
                                    <div class="sidebar-post__date"><?php echo $r_date ? esc_html(wp_date('F j, Y', strtotime($r_date))) : esc_html(get_the_date('F j, Y', $r->ID)); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <div class="sidebar-widget" style="background:var(--blue-pale);text-align:center;">
                        <h4 style="color:var(--navy);margin-bottom:0.75rem;">Get Involved</h4>
                        <p style="font-size:0.85rem;color:var(--gray-dark);margin-bottom:1.25rem;">Want to join our next outreach? We would love to have you.</p>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) ?: home_url('/contact/')); ?>" class="btn btn-primary" style="font-size:0.85rem;">Contact Us</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
