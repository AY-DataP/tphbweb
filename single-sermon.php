<?php
get_header();
the_post();

$youtube_url = get_field('sermon_youtube_url');
$speaker     = get_field('sermon_speaker')      ?: 'Pastor Diipo Omopariola';
$date        = get_field('sermon_date');
$scripture   = get_field('sermon_scripture');
$series      = get_field('sermon_series_name');
$duration    = get_field('sermon_duration');
$embed_url   = tphb_get_youtube_embed_url($youtube_url);

$recent = get_posts(['post_type'=>'sermon','posts_per_page'=>4,'post_status'=>'publish','post__not_in'=>[get_the_ID()]]);
?>

<main id="main" class="site-main">

    <div class="page-hero" style="padding-bottom:3rem;">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow"><?php echo $series ? esc_html($series) : 'Sermon'; ?></span>
            <h1><?php the_title(); ?></h1>
            <?php if ($scripture): ?>
                <p style="color:rgba(255,255,255,0.7);">&#128214; <?php echo esc_html($scripture); ?></p>
            <?php endif; ?>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <a href="<?php echo esc_url(get_post_type_archive_link('sermon')); ?>">Sermons</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current"><?php the_title(); ?></span>
            </nav>
        </div>
    </div>

    <section class="single-section">
        <div class="container">
            <div class="single-layout">

                <article class="single-article">
                    <?php if ($embed_url): ?>
                        <div class="single-article__video">
                            <iframe src="<?php echo esc_url($embed_url); ?>" frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" title="<?php the_title_attribute(); ?>"></iframe>
                        </div>
                    <?php elseif (has_post_thumbnail()): ?>
                        <div style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:2rem;">
                            <?php the_post_thumbnail('large', ['loading' => 'lazy']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="single-meta">
                        <?php if ($speaker): ?><span class="single-meta__item">&#127908; <strong><?php echo esc_html($speaker); ?></strong></span><?php endif; ?>
                        <?php if ($date): ?><span class="single-meta__item">&#128197; <?php echo esc_html(wp_date('F j, Y', strtotime($date))); ?></span><?php endif; ?>
                        <?php if ($duration): ?><span class="single-meta__item">&#8987; <?php echo esc_html($duration); ?></span><?php endif; ?>
                        <?php if ($series): ?><span class="single-meta__item">&#128218; <?php echo esc_html($series); ?></span><?php endif; ?>
                    </div>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <div style="display:flex;gap:1rem;margin-top:2.5rem;flex-wrap:wrap;padding-top:2rem;border-top:1px solid var(--gray-light);">
                        <a href="<?php echo esc_url(get_post_type_archive_link('sermon')); ?>" class="btn btn-outline">&larr; All Sermons</a>
                        <?php if ($youtube_url): ?>
                            <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">&#9654; Watch on YouTube</a>
                        <?php endif; ?>
                    </div>
                </article>

                <aside class="single-sidebar">
                    <?php if (!empty($recent)): ?>
                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget__title">Recent Sermons</h4>
                        <div class="sidebar-post-list">
                        <?php foreach ($recent as $r): ?>
                            <?php
                            $r_thumb = get_the_post_thumbnail_url($r->ID, 'thumbnail');
                            $r_yt    = get_field('sermon_youtube_url', $r->ID);
                            if (!$r_thumb && $r_yt) {
                                $r_vid = tphb_get_youtube_id($r_yt);
                                if ($r_vid) $r_thumb = "https://img.youtube.com/vi/{$r_vid}/hqdefault.jpg";
                            }
                            ?>
                            <div class="sidebar-post">
                                <?php if ($r_thumb): ?>
                                    <div class="sidebar-post__thumb">
                                        <img src="<?php echo esc_url($r_thumb); ?>" alt="<?php echo esc_attr(get_the_title($r->ID)); ?>" loading="lazy">
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="sidebar-post__title">
                                        <a href="<?php echo esc_url(get_permalink($r->ID)); ?>"><?php echo esc_html(get_the_title($r->ID)); ?></a>
                                    </div>
                                    <div class="sidebar-post__date"><?php echo esc_html(get_the_date('F j, Y', $r->ID)); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="sidebar-widget" style="background:var(--navy);color:var(--white);text-align:center;">
                        <p style="font-family:var(--font-display);font-size:1.1rem;font-style:italic;color:rgba(255,255,255,0.85);margin-bottom:1rem;">"Your word is a lamp for my feet, a light on my path."</p>
                        <cite style="font-size:0.8rem;color:var(--blue);font-weight:600;font-style:normal;">— Psalm 119:105</cite>
                        <div style="margin-top:1.25rem;">
                            <a href="<?php echo esc_url(home_url('/#prayer-request')); ?>" class="btn btn-outline-white" style="font-size:0.82rem;">&#128591; Submit Prayer Request</a>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
