<?php get_header(); ?>

<main id="main" class="site-main">

    <?php get_template_part('template-parts/sermons/hero'); ?>

    <section class="archive-section section">
        <div class="container">
            <?php if (have_posts()): ?>
                <div class="posts-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <?php
                        $youtube_url = get_field('sermon_youtube_url');
                        $speaker     = get_field('sermon_speaker')      ?: 'Pastor Diipo Omopariola';
                        $date        = get_field('sermon_date');
                        $scripture   = get_field('sermon_scripture');
                        $series      = get_field('sermon_series_name');
                        $duration    = get_field('sermon_duration');
                        $thumb       = get_the_post_thumbnail_url(get_the_ID(), 'large');

                        if (!$thumb && $youtube_url) {
                            $vid_id = tphb_get_youtube_id($youtube_url);
                            if ($vid_id) $thumb = "https://img.youtube.com/vi/{$vid_id}/hqdefault.jpg";
                        }
                        ?>
                        <article class="post-card fade-in-up">
                            <div class="post-card__thumb">
                                <?php if ($thumb): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                    </a>
                                <?php else: ?>
                                    <a href="<?php the_permalink(); ?>" style="display:block;width:100%;height:100%;background:linear-gradient(135deg,var(--navy),var(--blue));display:flex;align-items:center;justify-content:center;">
                                        <span style="color:rgba(255,255,255,0.3);font-size:3rem;">&#9654;</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="post-card__body">
                                <?php if ($series): ?>
                                    <span class="post-card__category"><?php echo esc_html($series); ?></span>
                                <?php endif; ?>
                                <div class="post-card__meta">
                                    <?php if ($date): ?>&#128197; <?php echo esc_html(wp_date('F j, Y', strtotime($date))); ?><?php endif; ?>
                                    <?php if ($speaker): ?> &middot; &#127908; <?php echo esc_html($speaker); ?><?php endif; ?>
                                    <?php if ($duration): ?> &middot; &#8987; <?php echo esc_html($duration); ?><?php endif; ?>
                                </div>
                                <h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <?php if ($scripture): ?>
                                    <p style="font-size:0.82rem;color:var(--blue);font-weight:600;margin-bottom:0.75rem;">&#128214; <?php echo esc_html($scripture); ?></p>
                                <?php endif; ?>
                                <p class="post-card__excerpt"><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline">Watch / Read</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <div class="pagination"><?php the_posts_pagination(['mid_size' => 2]); ?></div>
            <?php else: ?>

                <!-- ── Sermon Placeholders: Video-streaming layout ── -->
                <div class="ph-label">&#128274; Sample previews — real sermons coming soon</div>

                <!-- Featured sermon -->
                <div class="sph-featured fade-in-up">
                    <div class="sph-featured__thumb" style="background:linear-gradient(135deg,var(--navy-dark),var(--navy-mid));">
                        <div class="sph-play">&#9654;</div>
                        <span class="sph-badge">Latest Sermon</span>
                        <span class="sph-duration">48 min</span>
                    </div>
                    <div class="sph-featured__body">
                        <span class="post-card__category">Faith &amp; Purpose</span>
                        <div class="post-card__meta">&#128197; June 1, 2026 &middot; &#127908; Pastor Diipo Omopariola</div>
                        <h2 class="sph-featured__title">Walking in the Spirit</h2>
                        <p style="color:var(--blue);font-size:0.85rem;font-weight:600;margin-bottom:1rem;">&#128214; Romans 8:1–11</p>
                        <p style="line-height:1.8;color:var(--gray-dark);">There is therefore now no condemnation for those who are in Christ Jesus. Discover what it truly means to walk not after the flesh but after the Spirit — and how that transformative walk changes every area of your life.</p>
                        <div style="display:flex;gap:1rem;margin-top:1.75rem;flex-wrap:wrap;">
                            <a href="#" class="btn btn-primary">&#9654;&nbsp; Watch Sermon</a>
                            <a href="#" class="btn btn-outline">Read Notes</a>
                        </div>
                    </div>
                </div>

                <!-- Sermon grid -->
                <div class="sph-grid">
                    <?php
                    $ph = [
                        ['title'=>'The Power of Surrender',  'series'=>'Kingdom Living',  'date'=>'May 25, 2026', 'scripture'=>'Matthew 16:24', 'dur'=>'52 min', 'grad'=>'135deg,#1A3660,#2E5BAA'],
                        ['title'=>'Unshakeable Faith',       'series'=>'Faith Series',    'date'=>'May 18, 2026', 'scripture'=>'Hebrews 11:1',  'dur'=>'44 min', 'grad'=>'135deg,#24488A,#4A9FD4'],
                        ['title'=>'Kingdom Priorities',      'series'=>'The Kingdom',     'date'=>'May 11, 2026', 'scripture'=>'Matthew 6:33',  'dur'=>'39 min', 'grad'=>'135deg,#0D2040,#1A3660'],
                        ['title'=>'Renewed Mind',            'series'=>'Transformation',  'date'=>'May 4, 2026',  'scripture'=>'Romans 12:2',   'dur'=>'41 min', 'grad'=>'135deg,#2E5BAA,#4A9FD4'],
                        ['title'=>'Living Purposefully',     'series'=>'Purpose',         'date'=>'Apr 27, 2026', 'scripture'=>'Jeremiah 29:11','dur'=>'46 min', 'grad'=>'135deg,#1A3660,#24488A'],
                        ['title'=>'The Father\'s Heart',     'series'=>'Identity in God', 'date'=>'Apr 20, 2026', 'scripture'=>'Luke 15:20',    'dur'=>'37 min', 'grad'=>'135deg,#0D2040,#24488A'],
                    ];
                    foreach ($ph as $s): ?>
                    <article class="sph-card fade-in-up">
                        <div class="sph-card__thumb" style="background:linear-gradient(<?php echo esc_attr($s['grad']); ?>);">
                            <div class="sph-play sph-play--sm">&#9654;</div>
                            <span class="sph-duration sph-duration--card"><?php echo esc_html($s['dur']); ?></span>
                        </div>
                        <div class="sph-card__body">
                            <span class="post-card__category"><?php echo esc_html($s['series']); ?></span>
                            <div class="post-card__meta">&#128197; <?php echo esc_html($s['date']); ?></div>
                            <h3 class="sph-card__title"><?php echo esc_html($s['title']); ?></h3>
                            <p style="font-size:0.8rem;color:var(--blue);font-weight:600;margin:0;">&#128214; <?php echo esc_html($s['scripture']); ?></p>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
