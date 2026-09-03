<?php
$today = wp_date('Ymd');

$all_events = get_posts([
    'post_type'      => 'tphb_event',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'meta_value',
    'meta_key'       => 'event_date',
    'order'          => 'ASC',
]);

$upcoming = [];
$past     = [];

foreach ($all_events as $event) {
    $event_date = get_field('event_date', $event->ID);
    if (empty($event_date)) continue;
    $date_num = str_replace('-', '', $event_date);
    if ($date_num >= $today) {
        $upcoming[] = $event;
    } else {
        $past[] = $event;
    }
}

usort($past, function($a, $b) {
    return strtotime(get_field('event_date', $b->ID)) - strtotime(get_field('event_date', $a->ID));
});

$featured_upcoming = array_slice($upcoming, 0, 3);
$side_upcoming     = array_slice($upcoming, 3, 3);
$featured_past     = array_slice($past, 0, 3);
$side_past         = array_slice($past, 3, 3);

$has_upcoming = !empty($upcoming);
$has_past     = !empty($past);

/* ── SVG icon helpers ───────────────────────────────────────────────────── */
$svg_cal = '<svg class="meta-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="14" height="14" rx="2"/><path d="M7 2v4M13 2v4M3 9h14"/></svg>';
$svg_pin = '<svg class="meta-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 2a6 6 0 0 1 6 6c0 4-6 10-6 10S4 12 4 8a6 6 0 0 1 6-6z"/><circle cx="10" cy="8" r="2"/></svg>';
$svg_cal_placeholder = '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="8" width="36" height="36" rx="4"/><path d="M16 4v8M32 4v8M6 20h36"/></svg>';
?>

<section class="events-section section">
    <div class="container">
        <div class="section-header fade-in-up">
            <span class="section-header__eyebrow">Programs &amp; Events</span>
            <h2 class="section-header__title">Upcoming &amp; Past Programs</h2>
            <p class="section-header__subtitle">Stay connected — see what God is doing through our church community.</p>
            <div class="section-divider"></div>
        </div>

        <!-- Tabs -->
        <div class="events-tabs">
            <button class="events-tab active" data-panel="upcoming-events">
                Upcoming
                <?php if ($has_upcoming): ?>
                    <span class="events-tab__count"><?php echo count($upcoming); ?></span>
                <?php endif; ?>
            </button>
            <button class="events-tab" data-panel="past-events">Past Events</button>
        </div>

        <!-- ── Upcoming Events ── -->
        <div class="events-panel active" id="upcoming-events">
            <?php if ($has_upcoming): ?>
                <div class="events-split-layout">

                    <!-- Main featured column (left) -->
                    <div class="events-main-col">
                        <?php foreach ($featured_upcoming as $event): ?>
                            <?php
                            $event_date = get_field('event_date',     $event->ID);
                            $event_time = get_field('event_time',     $event->ID);
                            $location   = get_field('event_location', $event->ID);
                            $flyer      = get_field('event_flyer',    $event->ID);
                            $reg_url    = get_field('event_registration_url', $event->ID);
                            $thumb      = $flyer ? $flyer['url'] : get_the_post_thumbnail_url($event->ID, 'large');
                            $iso_dt     = tphb_get_event_datetime_iso($event->ID);
                            $month      = $event_date ? date('M', strtotime($event_date)) : '';
                            $day        = $event_date ? date('j', strtotime($event_date)) : '';
                            ?>
                            <div class="event-card-featured fade-in-up">
                                <div class="event-card-featured__thumb">
                                    <?php if ($thumb): ?>
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($event->ID)); ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="event-card-featured__thumb-placeholder"><?php echo $svg_cal_placeholder; ?></div>
                                    <?php endif; ?>
                                    <?php if ($month && $day): ?>
                                        <div class="event-card__date-badge">
                                            <span class="month"><?php echo esc_html($month); ?></span>
                                            <span class="day"><?php echo esc_html($day); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="event-card-featured__body">
                                    <h3 class="event-card-featured__title">
                                        <a href="<?php echo esc_url(get_permalink($event->ID)); ?>"><?php echo esc_html(get_the_title($event->ID)); ?></a>
                                    </h3>
                                    <div class="event-card-featured__meta">
                                        <?php if ($event_date): ?>
                                        <span><?php echo $svg_cal; ?> <?php echo esc_html(date('F j, Y', strtotime($event_date))); ?><?php echo $event_time ? ' &mdash; ' . esc_html(date('g:i a', strtotime($event_time))) : ''; ?></span>
                                        <?php endif; ?>
                                        <?php if ($location): ?>
                                        <span><?php echo $svg_pin; ?> <?php echo esc_html($location); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($iso_dt): ?>
                                        <div class="countdown" data-event-date="<?php echo esc_attr($iso_dt); ?>">
                                            <div class="countdown__unit"><span class="countdown__value" data-unit="days">--</span><span class="countdown__label">Days</span></div>
                                            <div class="countdown__unit"><span class="countdown__value" data-unit="hours">--</span><span class="countdown__label">Hrs</span></div>
                                            <div class="countdown__unit"><span class="countdown__value" data-unit="minutes">--</span><span class="countdown__label">Min</span></div>
                                            <div class="countdown__unit"><span class="countdown__value" data-unit="seconds">--</span><span class="countdown__label">Sec</span></div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="event-card-featured__actions">
                                        <a href="<?php echo esc_url(get_permalink($event->ID)); ?>" class="btn btn-sm btn-outline">Learn More</a>
                                        <?php if ($reg_url): ?>
                                            <a href="<?php echo esc_url($reg_url); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-primary">Register</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Sidebar column (right) -->
                    <?php if (!empty($side_upcoming)): ?>
                    <div class="events-side-col">
                        <h4 class="events-side-col__title">More Upcoming</h4>
                        <?php foreach ($side_upcoming as $event): ?>
                            <?php
                            $event_date = get_field('event_date',     $event->ID);
                            $event_time = get_field('event_time',     $event->ID);
                            $location   = get_field('event_location', $event->ID);
                            $flyer      = get_field('event_flyer',    $event->ID);
                            $thumb      = $flyer ? $flyer['url'] : get_the_post_thumbnail_url($event->ID, 'medium');
                            $month      = $event_date ? date('M', strtotime($event_date)) : '';
                            $day        = $event_date ? date('j', strtotime($event_date)) : '';
                            ?>
                            <div class="event-card-side fade-in-up">
                                <?php if ($thumb): ?>
                                    <div class="event-card-side__thumb">
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($event->ID)); ?>" loading="lazy">
                                        <?php if ($month && $day): ?>
                                            <div class="event-card__date-badge event-card__date-badge--sm">
                                                <span class="month"><?php echo esc_html($month); ?></span>
                                                <span class="day"><?php echo esc_html($day); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="event-card-side__body">
                                    <h4 class="event-card-side__title">
                                        <a href="<?php echo esc_url(get_permalink($event->ID)); ?>"><?php echo esc_html(get_the_title($event->ID)); ?></a>
                                    </h4>
                                    <div class="event-card-side__meta">
                                        <?php if ($event_date): ?><span><?php echo $svg_cal; ?> <?php echo esc_html(date('M j, Y', strtotime($event_date))); ?></span><?php endif; ?>
                                        <?php if ($location): ?><span><?php echo $svg_pin; ?> <?php echo esc_html($location); ?></span><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>

            <?php else: ?>
                <div class="events-empty">
                    <div class="events-empty__icon"><?php echo $svg_cal_placeholder; ?></div>
                    <h3>Events Coming Soon</h3>
                    <p>Programs and events will appear here as they are published. Check back soon.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- ── Past Events ── -->
        <div class="events-panel" id="past-events">
            <?php if ($has_past): ?>
                <div class="events-split-layout">
                    <div class="events-main-col">
                        <?php foreach ($featured_past as $event): ?>
                            <?php
                            $event_date = get_field('event_date',     $event->ID);
                            $location   = get_field('event_location', $event->ID);
                            $flyer      = get_field('event_flyer',    $event->ID);
                            $thumb      = $flyer ? $flyer['url'] : get_the_post_thumbnail_url($event->ID, 'large');
                            $month      = $event_date ? date('M', strtotime($event_date)) : '';
                            $day        = $event_date ? date('j', strtotime($event_date)) : '';
                            ?>
                            <div class="event-card-featured past-event-card fade-in-up">
                                <div class="event-card-featured__thumb event-card-featured__thumb--past">
                                    <?php if ($thumb): ?>
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($event->ID)); ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="event-card-featured__thumb-placeholder"><?php echo $svg_cal_placeholder; ?></div>
                                    <?php endif; ?>
                                    <?php if ($month && $day): ?>
                                        <div class="event-card__date-badge">
                                            <span class="month"><?php echo esc_html($month); ?></span>
                                            <span class="day"><?php echo esc_html($day); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="past-overlay"><span>Past Event</span></div>
                                </div>
                                <div class="event-card-featured__body">
                                    <span class="past-badge">Past Event</span>
                                    <h3 class="event-card-featured__title">
                                        <a href="<?php echo esc_url(get_permalink($event->ID)); ?>"><?php echo esc_html(get_the_title($event->ID)); ?></a>
                                    </h3>
                                    <div class="event-card-featured__meta">
                                        <?php if ($event_date): ?><span><?php echo $svg_cal; ?> <?php echo esc_html(date('F j, Y', strtotime($event_date))); ?></span><?php endif; ?>
                                        <?php if ($location): ?><span><?php echo $svg_pin; ?> <?php echo esc_html($location); ?></span><?php endif; ?>
                                    </div>
                                    <a href="<?php echo esc_url(get_permalink($event->ID)); ?>" class="btn btn-sm btn-outline" style="margin-top:0.75rem;">View Recap</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($side_past)): ?>
                    <div class="events-side-col">
                        <h4 class="events-side-col__title">More Past Events</h4>
                        <?php foreach ($side_past as $event): ?>
                            <?php
                            $event_date = get_field('event_date',     $event->ID);
                            $location   = get_field('event_location', $event->ID);
                            $flyer      = get_field('event_flyer',    $event->ID);
                            $thumb      = $flyer ? $flyer['url'] : get_the_post_thumbnail_url($event->ID, 'medium');
                            ?>
                            <div class="event-card-side fade-in-up">
                                <?php if ($thumb): ?>
                                    <div class="event-card-side__thumb event-card-side__thumb--past">
                                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($event->ID)); ?>" loading="lazy">
                                    </div>
                                <?php endif; ?>
                                <div class="event-card-side__body">
                                    <span class="past-badge past-badge--sm">Past</span>
                                    <h4 class="event-card-side__title">
                                        <a href="<?php echo esc_url(get_permalink($event->ID)); ?>"><?php echo esc_html(get_the_title($event->ID)); ?></a>
                                    </h4>
                                    <?php if ($event_date): ?>
                                        <div class="event-card-side__meta"><span><?php echo $svg_cal; ?> <?php echo esc_html(date('M j, Y', strtotime($event_date))); ?></span></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <div class="events-empty">
                    <div class="events-empty__icon"><?php echo $svg_cal_placeholder; ?></div>
                    <h3>No Past Events Yet</h3>
                    <p>Past events will appear here once they are published and their dates have passed.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="section-cta fade-in-up" style="margin-top:2.5rem;">
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery')) ?: home_url('/gallery/')); ?>" class="btn btn-outline">View Gallery &rarr;</a>
        </div>
    </div>
</section>
