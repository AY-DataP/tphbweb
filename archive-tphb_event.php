<?php get_header(); ?>

<main id="main" class="site-main">

    <?php get_template_part('template-parts/events/hero'); ?>

    <?php get_template_part('template-parts/wwr-subnav'); ?>

    <!-- Events Archive -->
    <section class="section" id="events-list">
        <div class="container">
            <?php
            $filter_month = (isset($_GET['month']) && preg_match('/^\d{4}-\d{2}$/', $_GET['month']))
                ? sanitize_text_field($_GET['month'])
                : '';

            $paged = max(1, get_query_var('paged'));

            $query_args = [
                'post_type'      => 'tphb_event',
                'posts_per_page' => 9,
                'post_status'    => 'publish',
                'meta_key'       => 'event_date',
                'orderby'        => 'meta_value',
                'order'          => 'DESC',
                'paged'          => $paged,
            ];

            if ($filter_month) {
                $fm_year  = (int) substr($filter_month, 0, 4);
                $fm_month = (int) substr($filter_month, 5, 2);
                $query_args['meta_query'] = [[
                    'key'     => 'event_date',
                    'value'   => [$filter_month . '-01', $filter_month . '-' . wp_date('t', mktime(0, 0, 0, $fm_month, 1, $fm_year))],
                    'compare' => 'BETWEEN',
                    'type'    => 'DATE',
                ]];
            }

            $events_query = new WP_Query($query_args);

            /* ── SVG icon helpers ───────────────────────────────────── */
            $svg_cal = '<svg class="meta-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="14" height="14" rx="2"/><path d="M7 2v4M13 2v4M3 9h14"/></svg>';
            $svg_pin = '<svg class="meta-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 2a6 6 0 0 1 6 6c0 4-6 10-6 10S4 12 4 8a6 6 0 0 1 6-6z"/><circle cx="10" cy="8" r="2"/></svg>';
            $svg_thumb_placeholder = '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="8" width="36" height="36" rx="4"/><path d="M16 4v8M32 4v8M6 20h36"/></svg>';
            ?>

            <?php if ($filter_month): ?>
            <div class="events-filter-bar fade-in-up">
                <span>Showing events for <strong><?php echo esc_html(wp_date('F Y', strtotime($filter_month . '-01'))); ?></strong></span>
                <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>" class="events-filter-bar__clear">Clear &times;</a>
            </div>
            <?php endif; ?>

            <?php if ($events_query->have_posts()): ?>

                <div class="events-blog-grid">
                    <?php while ($events_query->have_posts()): $events_query->the_post();
                        $event_date = get_field('event_date');
                        $event_time = get_field('event_time');
                        $location   = get_field('event_location');
                        $flyer      = get_field('event_flyer');
                        $reg_url    = get_field('event_registration_url');
                        $thumb      = $flyer ? $flyer['url'] : get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $is_past    = $event_date && str_replace('-', '', $event_date) < wp_date('Ymd');
                        $month_abbr = $event_date ? wp_date('M', strtotime($event_date)) : '';
                        $day_num    = $event_date ? wp_date('j', strtotime($event_date)) : '';
                    ?>
                    <article class="event-blog-card fade-in-up">

                        <div class="event-blog-card__thumb">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ($thumb): ?>
                                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                <?php else: ?>
                                    <div class="event-blog-card__thumb-placeholder"><?php echo $svg_thumb_placeholder; ?></div>
                                <?php endif; ?>
                            </a>
                            <?php if ($month_abbr && $day_num): ?>
                            <div class="event-card__date-badge">
                                <span class="month"><?php echo esc_html($month_abbr); ?></span>
                                <span class="day"><?php echo esc_html($day_num); ?></span>
                            </div>
                            <?php endif; ?>
                            <span class="event-blog-card__status-badge <?php echo $is_past ? 'past' : 'upcoming'; ?>">
                                <?php echo $is_past ? 'Past Event' : 'Upcoming'; ?>
                            </span>
                        </div>

                        <div class="event-blog-card__body">
                            <h2 class="event-blog-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="event-blog-card__meta">
                                <?php if ($event_date): ?>
                                    <span><?php echo $svg_cal; ?> <?php echo esc_html(wp_date('F j, Y', strtotime($event_date))); ?><?php echo $event_time ? ' &mdash; ' . esc_html(wp_date('g:i a', strtotime($event_time))) : ''; ?></span>
                                <?php endif; ?>
                                <?php if ($location): ?>
                                    <span><?php echo $svg_pin; ?> <?php echo esc_html($location); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="event-blog-card__excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="event-blog-card__actions">
                                <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline">
                                    <?php echo $is_past ? 'View Recap' : 'Learn More'; ?>
                                </a>
                                <?php if ($reg_url && !$is_past): ?>
                                    <a href="<?php echo esc_url($reg_url); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-primary">Register</a>
                                <?php endif; ?>
                            </div>
                        </div>

                    </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>

                <div class="pagination">
                    <?php echo paginate_links([
                        'total'    => $events_query->max_num_pages,
                        'current'  => $paged,
                        'mid_size' => 2,
                        'add_args' => $filter_month ? ['month' => $filter_month] : [],
                    ]); ?>
                </div>

            <?php else: ?>

                <?php if ($filter_month): ?>
                <div class="events-empty">
                    <div class="events-empty__icon"><?php echo $svg_thumb_placeholder; ?></div>
                    <p>No events found for <strong><?php echo esc_html(wp_date('F Y', strtotime($filter_month . '-01'))); ?></strong>.</p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>" class="btn btn-outline" style="margin-top:1.5rem;">View All Events</a>
                </div>

                <?php else: ?>
                <!-- Sample previews — shown when no real events are published yet -->
                <p class="ph-label">Sample previews &mdash; real events coming soon</p>
                <div class="events-blog-grid">
                    <?php
                    $placeholders = [
                        ['title' => 'Night of Worship & Prayer',        'date' => 'Jul 6, 2026',  'date_fmt' => 'July 6, 2026',   'month' => 'Jul', 'day' => '6',  'location' => '806 Reisterstown Rd, Pikesville', 'status' => 'upcoming', 'grad' => '135deg,#1A3660,#2E5BAA', 'excerpt' => 'Join us for an evening of powerful worship and intercession as we seek God together as a family.'],
                        ['title' => 'Community Outreach Day',            'date' => 'Jun 28, 2026', 'date_fmt' => 'June 28, 2026',  'month' => 'Jun', 'day' => '28', 'location' => 'Pikesville Community Center',    'status' => 'past',     'grad' => '135deg,#24488A,#4A9FD4', 'excerpt' => 'We went out to serve our community with food, resources, and the love of Christ. A blessed day of impact.'],
                        ['title' => 'Marriage & Family Conference',      'date' => 'Jul 19, 2026', 'date_fmt' => 'July 19, 2026',  'month' => 'Jul', 'day' => '19', 'location' => '806 Reisterstown Rd, Pikesville', 'status' => 'upcoming', 'grad' => '135deg,#0D2040,#1A3660', 'excerpt' => 'A one-day conference for couples and families — tools, wisdom, and prayer for thriving relationships.'],
                        ['title' => 'Youth Rally: Ignite 2026',          'date' => 'Jul 26, 2026', 'date_fmt' => 'July 26, 2026',  'month' => 'Jul', 'day' => '26', 'location' => '806 Reisterstown Rd, Pikesville', 'status' => 'upcoming', 'grad' => '135deg,#2E5BAA,#4A9FD4', 'excerpt' => 'A high-energy gathering for teens and young adults — worship, games, testimonies, and the Word of God.'],
                        ['title' => "Pastor's Appreciation Sunday",      'date' => 'Jun 15, 2026', 'date_fmt' => 'June 15, 2026',  'month' => 'Jun', 'day' => '15', 'location' => 'The Praise House, Pikesville',    'status' => 'past',     'grad' => '135deg,#1A3660,#24488A', 'excerpt' => 'The congregation celebrated and honoured our senior pastor for his faithful service and dedication.'],
                        ['title' => 'Annual Church Picnic & Fellowship', 'date' => 'Aug 9, 2026',  'date_fmt' => 'August 9, 2026', 'month' => 'Aug', 'day' => '9',  'location' => 'Oregon Ridge Park, Baltimore',  'status' => 'upcoming', 'grad' => '135deg,#0D2040,#24488A', 'excerpt' => 'Food, fun, and fellowship for the whole family! Come spend the day outdoors as we celebrate community.'],
                    ];
                    foreach ($placeholders as $ph): ?>
                    <article class="event-blog-card event-blog-card--placeholder fade-in-up">
                        <div class="event-blog-card__thumb">
                            <div class="event-blog-card__thumb-placeholder" style="background:linear-gradient(<?php echo esc_attr($ph['grad']); ?>);"><?php echo $svg_thumb_placeholder; ?></div>
                            <div class="event-card__date-badge">
                                <span class="month"><?php echo esc_html($ph['month']); ?></span>
                                <span class="day"><?php echo esc_html($ph['day']); ?></span>
                            </div>
                            <span class="event-blog-card__status-badge <?php echo esc_attr($ph['status']); ?>">
                                <?php echo $ph['status'] === 'upcoming' ? 'Upcoming' : 'Past Event'; ?>
                            </span>
                        </div>
                        <div class="event-blog-card__body">
                            <h2 class="event-blog-card__title"><a href="#"><?php echo esc_html($ph['title']); ?></a></h2>
                            <div class="event-blog-card__meta">
                                <span><?php echo $svg_cal; ?> <?php echo esc_html($ph['date_fmt']); ?></span>
                                <span><?php echo $svg_pin; ?> <?php echo esc_html($ph['location']); ?></span>
                            </div>
                            <div class="event-blog-card__excerpt"><?php echo esc_html($ph['excerpt']); ?></div>
                            <div class="event-blog-card__actions">
                                <a href="#" class="btn btn-sm btn-outline">
                                    <?php echo $ph['status'] === 'past' ? 'View Recap' : 'Learn More'; ?>
                                </a>
                                <?php if ($ph['status'] === 'upcoming'): ?>
                                    <a href="#" class="btn btn-sm btn-primary">Register</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>
