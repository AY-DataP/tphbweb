<?php get_header(); ?>

<main id="main" class="site-main">

    <div class="page-hero">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow">Devotional &amp; Insights</span>
            <h1>Reflections</h1>
            <p>Sermon snippets, devotional thoughts, and glimpses of God moving through Nights of Mercy and beyond.</p>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current">Reflections</span>
            </nav>
        </div>
    </div>

    <section class="archive-section section">
        <div class="container">

            <!-- Category Filter -->
            <div class="archive-filter" style="margin-bottom:2.5rem;">
                <a href="<?php echo esc_url(get_post_type_archive_link('reflection')); ?>" class="filter-btn <?php echo !get_query_var('reflection_type') ? 'active' : ''; ?>">All</a>
                <?php
                $terms = get_terms(['taxonomy' => 'reflection_type', 'hide_empty' => true]);
                foreach ((array)$terms as $term):
                    if (is_wp_error($term)) continue;
                ?>
                <a href="<?php echo esc_url(get_term_link($term)); ?>" class="filter-btn"><?php echo esc_html($term->name); ?></a>
                <?php endforeach; ?>
            </div>

            <?php if (have_posts()): ?>
                <div class="posts-grid">
                    <?php while (have_posts()): the_post(); ?>
                        <?php
                        $type      = get_field('reflection_type');
                        $youtube   = get_field('reflection_youtube_url');
                        $category  = get_field('reflection_category');
                        $thumb     = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        if (!$thumb && $youtube) {
                            $vid = tphb_get_youtube_id($youtube);
                            if ($vid) $thumb = "https://img.youtube.com/vi/{$vid}/hqdefault.jpg";
                        }
                        $cat_labels = ['sermon-snippet' => 'Sermon Snippet', 'nights-of-mercy' => 'Nights of Mercy', 'devotional' => 'Devotional', 'other' => 'Reflection'];
                        $cat_label  = $cat_labels[$category] ?? 'Reflection';
                        ?>
                        <article class="post-card fade-in-up">
                            <div class="post-card__thumb">
                                <?php if ($thumb): ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                    </a>
                                <?php else: ?>
                                    <a href="<?php the_permalink(); ?>" style="display:block;aspect-ratio:16/9;background:linear-gradient(135deg,var(--navy-mid),var(--blue));display:flex;align-items:center;justify-content:center;">
                                        <span style="color:rgba(255,255,255,0.3);font-size:2.5rem;">&#128214;</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="post-card__body">
                                <span class="post-card__category"><?php echo esc_html($cat_label); ?></span>
                                <div class="post-card__meta"><?php echo esc_html(get_the_date('F j, Y')); ?></div>
                                <h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p class="post-card__excerpt"><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline">Read More</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <div class="pagination"><?php the_posts_pagination(['mid_size' => 2]); ?></div>
            <?php else: ?>

                <!-- ── Reflection Placeholders: Editorial magazine layout ── -->
                <div class="ph-label">&#128274; Sample previews — reflections coming soon</div>

                <?php
                $rph = [
                    [
                        'cat'     => 'Devotional',
                        'cat_color' => '#7B5EA7',
                        'date'    => 'June 1, 2026',
                        'title'   => 'Grace in the Waiting',
                        'quote'   => 'Sometimes God\'s greatest gift is the pause before the answer — the sacred space where faith is forged.',
                        'excerpt' => 'Waiting is not wasted time in God\'s economy. This devotional explores what Scripture teaches us about seasons of stillness and why they are essential to spiritual growth.',
                        'read'    => '4 min read',
                    ],
                    [
                        'cat'     => 'Nights of Mercy',
                        'cat_color' => '#2E7D6E',
                        'date'    => 'May 28, 2026',
                        'title'   => 'A Night That Changed Everything',
                        'quote'   => 'Mercy is not passive — it moves toward the broken, wraps around the wounded, and refuses to let go.',
                        'excerpt' => 'A recap of our most recent Nights of Mercy gathering — testimonies, moments of breakthrough, and the tangible presence of God that filled the room.',
                        'read'    => '6 min read',
                    ],
                    [
                        'cat'     => 'Sermon Snippet',
                        'cat_color' => '#C0392B',
                        'date'    => 'May 21, 2026',
                        'title'   => 'The Father\'s Heart — Highlights',
                        'quote'   => 'You do not have to perform for a Father who already delights in you.',
                        'excerpt' => 'Key moments and takeaways from Pastor Diipo\'s powerful message on identity, sonship, and the unconditional love of the Father.',
                        'read'    => '3 min read',
                    ],
                    [
                        'cat'     => 'Devotional',
                        'cat_color' => '#7B5EA7',
                        'date'    => 'May 14, 2026',
                        'title'   => 'Start Your Day With Surrender',
                        'quote'   => 'The most productive thing you can do each morning is give God the first moment of your day.',
                        'excerpt' => 'A practical morning devotional to help you anchor your day in prayer, Scripture, and a posture of surrender — before the noise of the world begins.',
                        'read'    => '5 min read',
                    ],
                ];
                foreach ($rph as $r): ?>
                <article class="rph-card fade-in-up">
                    <div class="rph-card__accent" style="background:<?php echo esc_attr($r['cat_color']); ?>;"></div>
                    <div class="rph-card__body">
                        <div class="rph-card__top">
                            <span class="rph-cat" style="background:<?php echo esc_attr($r['cat_color']); ?>15;color:<?php echo esc_attr($r['cat_color']); ?>;"><?php echo esc_html($r['cat']); ?></span>
                            <span class="rph-meta">&#128197; <?php echo esc_html($r['date']); ?> &nbsp;&middot;&nbsp; &#9201; <?php echo esc_html($r['read']); ?></span>
                        </div>
                        <h3 class="rph-card__title"><?php echo esc_html($r['title']); ?></h3>
                        <blockquote class="rph-quote"><?php echo esc_html($r['quote']); ?></blockquote>
                        <p class="rph-excerpt"><?php echo esc_html($r['excerpt']); ?></p>
                        <a href="#" class="btn btn-outline" style="font-size:0.82rem;padding:0.45rem 1.1rem;">Read More &rarr;</a>
                    </div>
                </article>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
