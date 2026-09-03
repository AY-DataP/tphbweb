<?php get_header(); ?>

<main id="main" class="site-main">

    <div class="page-hero">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow">Reaching the Community</span>
            <h1>Outreach</h1>
            <p>Going beyond our walls — touching lives through intentional acts of love and service.</p>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current">Outreach</span>
            </nav>
        </div>
    </div>

    <?php get_template_part('template-parts/wwr-subnav'); ?>

    <section class="archive-section section">
        <div class="container">

            <?php
            $outreach_types = get_terms(['taxonomy' => 'outreach_type', 'hide_empty' => true]);
            if (!empty($outreach_types) && !is_wp_error($outreach_types)):
            ?>
            <div class="archive-filter">
                <a href="<?php echo esc_url(get_post_type_archive_link('tphb_outreach')); ?>" class="filter-btn active">All</a>
                <?php foreach ($outreach_types as $term): ?>
                    <a href="<?php echo esc_url(get_term_link($term)); ?>" class="filter-btn"><?php echo esc_html($term->name); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (have_posts()): ?>
                <div class="outreach-grid">
                    <?php while (have_posts()): the_post();
                        $event_date = get_field('outreach_event_date');
                        $location   = get_field('outreach_location');
                        $program    = get_field('outreach_program_type');
                        $thumb      = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $month      = $event_date ? date('M', strtotime($event_date)) : '';
                        $day        = $event_date ? date('j',   strtotime($event_date)) : '';
                    ?>
                        <article class="outreach-card fade-in-up">
                            <a href="<?php the_permalink(); ?>" class="outreach-card__thumb-link">
                                <div class="outreach-card__thumb">
                                    <?php if ($thumb): ?>
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="outreach-card__thumb-placeholder">
                                            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="24" cy="16" r="8"/><path d="M8 40c0-8.837 7.163-16 16-16s16 7.163 16 16"/>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($month && $day): ?>
                                        <div class="outreach-card__date-badge">
                                            <span class="month"><?php echo esc_html($month); ?></span>
                                            <span class="day"><?php echo esc_html($day); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="outreach-card__body">
                                <?php if ($program): ?>
                                    <span class="outreach-card__type"><?php echo esc_html($program); ?></span>
                                <?php endif; ?>
                                <h2 class="outreach-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="outreach-card__meta">
                                    <?php if ($event_date): ?>
                                    <span class="outreach-card__meta-item">
                                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect x="3" y="4" width="14" height="14" rx="2"/><path d="M7 2v4M13 2v4M3 9h14"/>
                                        </svg>
                                        <?php echo esc_html(date('F j, Y', strtotime($event_date))); ?>
                                    </span>
                                    <?php endif; ?>
                                    <?php if ($location): ?>
                                    <span class="outreach-card__meta-item">
                                        <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M10 2a6 6 0 0 1 6 6c0 4-6 10-6 10S4 12 4 8a6 6 0 0 1 6-6z"/><circle cx="10" cy="8" r="2"/>
                                        </svg>
                                        <?php echo esc_html($location); ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <p class="outreach-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                                <a href="<?php the_permalink(); ?>" class="outreach-card__link">
                                    View Recap
                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M3 8h10M9 4l4 4-4 4"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <div class="pagination"><?php the_posts_pagination(['mid_size' => 2]); ?></div>

            <?php else: ?>
                <!-- Sample previews — shown when no real outreach posts are published yet -->
                <p class="ph-label">Sample previews &mdash; real outreach recaps coming soon</p>
                <div class="outreach-grid">
                    <?php
                    $ph_outreach = [
                        ['title' => 'Community Food Drive',       'program' => 'Community Service', 'date' => 'June 14, 2026', 'location' => 'Pikesville Community Center',     'grad' => '135deg,#1A3660,#2E5BAA', 'excerpt' => 'Church members distributed over 200 food packages to families in need across the Pikesville area.'],
                        ['title' => 'Back-to-School Giveaway',    'program' => 'Children & Youth',   'date' => 'August 2, 2026', 'location' => 'Northwest Baltimore Schools',    'grad' => '135deg,#24488A,#4A9FD4', 'excerpt' => 'We provided backpacks, stationery, and school supplies to over 100 children ahead of the new school year.'],
                        ['title' => 'Hospital & Elderly Visitation', 'program' => 'Care & Compassion', 'date' => 'May 25, 2026', 'location' => 'Sinai Hospital, Baltimore',      'grad' => '135deg,#0D2040,#1A3660', 'excerpt' => 'A team of volunteers visited hospital wards and care homes, bringing prayer, gifts, and encouragement.'],
                    ];
                    $svg_ph_thumb = '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="24" cy="16" r="8"/><path d="M8 40c0-8.837 7.163-16 16-16s16 7.163 16 16"/></svg>';
                    $svg_cal_sm   = '<svg class="meta-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="14" height="14" rx="2"/><path d="M7 2v4M13 2v4M3 9h14"/></svg>';
                    $svg_pin_sm   = '<svg class="meta-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 2a6 6 0 0 1 6 6c0 4-6 10-6 10S4 12 4 8a6 6 0 0 1 6-6z"/><circle cx="10" cy="8" r="2"/></svg>';
                    foreach ($ph_outreach as $ph): ?>
                    <article class="outreach-card outreach-card--placeholder fade-in-up">
                        <div class="outreach-card__thumb-link">
                            <div class="outreach-card__thumb">
                                <div class="outreach-card__thumb-placeholder" style="background:linear-gradient(<?php echo esc_attr($ph['grad']); ?>);"><?php echo $svg_ph_thumb; ?></div>
                            </div>
                        </div>
                        <div class="outreach-card__body">
                            <span class="outreach-card__type"><?php echo esc_html($ph['program']); ?></span>
                            <h2 class="outreach-card__title"><a href="#"><?php echo esc_html($ph['title']); ?></a></h2>
                            <div class="outreach-card__meta">
                                <span class="outreach-card__meta-item"><?php echo $svg_cal_sm; ?> <?php echo esc_html($ph['date']); ?></span>
                                <span class="outreach-card__meta-item"><?php echo $svg_pin_sm; ?> <?php echo esc_html($ph['location']); ?></span>
                            </div>
                            <p class="outreach-card__excerpt"><?php echo esc_html($ph['excerpt']); ?></p>
                            <a href="#" class="outreach-card__link">View Recap <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>
