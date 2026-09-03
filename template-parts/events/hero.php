<?php
$today = wp_date('Y-m-d');

// Month context (from URL or current)
$current_month = (isset($_GET['month']) && preg_match('/^\d{4}-\d{2}$/', $_GET['month']))
    ? sanitize_text_field($_GET['month'])
    : wp_date('Y-m');

$cal_year  = (int) substr($current_month, 0, 4);
$cal_month = (int) substr($current_month, 5, 2);
$prev_month  = wp_date('Y-m', mktime(0, 0, 0, $cal_month - 1, 1, $cal_year));
$next_month  = wp_date('Y-m', mktime(0, 0, 0, $cal_month + 1, 1, $cal_year));
$month_label = wp_date('F Y', mktime(0, 0, 0, $cal_month, 1, $cal_year));
$days_in_month     = (int) wp_date('t', mktime(0, 0, 0, $cal_month, 1, $cal_year));
$first_day_of_week = (int) wp_date('w', mktime(0, 0, 0, $cal_month, 1, $cal_year));

// Days in this calendar month that have events
$month_events = get_posts([
    'post_type'      => 'tphb_event',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => [[
        'key'     => 'event_date',
        'value'   => [$current_month . '-01', $current_month . '-' . wp_date('t', mktime(0, 0, 0, $cal_month, 1, $cal_year))],
        'compare' => 'BETWEEN',
        'type'    => 'DATE',
    ]],
]);
$event_days = [];
foreach ($month_events as $e) {
    $d = get_field('event_date', $e->ID);
    if ($d) $event_days[] = (int) substr($d, 8, 2);
}

// Upcoming events for slideshow
$upcoming_events = get_posts([
    'post_type'      => 'tphb_event',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
    'orderby'        => 'meta_value',
    'meta_key'       => 'event_date',
    'order'          => 'ASC',
    'meta_query'     => [[
        'key'     => 'event_date',
        'value'   => $today,
        'compare' => '>=',
        'type'    => 'DATE',
    ]],
]);
$has_upcoming = !empty($upcoming_events);
$archive_url  = get_post_type_archive_link('tphb_event');
?>

<section class="events-hero<?php echo $has_upcoming ? ' events-hero--slides' : ''; ?>" aria-label="Events">

    <?php if ($has_upcoming): ?>
    <!-- ── Upcoming event slideshow background ── -->
    <div class="swiper events-hero-swiper">
        <div class="swiper-wrapper">
            <?php foreach ($upcoming_events as $ev):
                $flyer    = get_field('event_flyer',    $ev->ID);
                $bg_thumb = $flyer ? $flyer['url'] : get_the_post_thumbnail_url($ev->ID, 'large');
                $ev_date  = get_field('event_date',     $ev->ID);
                $ev_time  = get_field('event_time',     $ev->ID);
                $ev_loc   = get_field('event_location', $ev->ID);
                $ev_reg   = get_field('event_registration_url', $ev->ID);
            ?>
            <div class="swiper-slide">
                <div class="events-hero__slide-bg"
                     <?php if ($bg_thumb): ?>style="background-image:url('<?php echo esc_url($bg_thumb); ?>')"<?php endif; ?>
                     aria-hidden="true"></div>
                <div class="events-hero__slide-overlay" aria-hidden="true"></div>
                <div class="events-hero__slide-content">
                    <span class="events-hero__upcoming-badge">Upcoming</span>
                    <h2 class="events-hero__slide-title">
                        <a href="<?php echo esc_url(get_permalink($ev->ID)); ?>"><?php echo esc_html(get_the_title($ev->ID)); ?></a>
                    </h2>
                    <div class="events-hero__slide-meta">
                        <?php
                        $svg_cal_hero = '<svg class="meta-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="14" height="14" rx="2"/><path d="M7 2v4M13 2v4M3 9h14"/></svg>';
                        $svg_pin_hero = '<svg class="meta-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 2a6 6 0 0 1 6 6c0 4-6 10-6 10S4 12 4 8a6 6 0 0 1 6-6z"/><circle cx="10" cy="8" r="2"/></svg>';
                        ?>
                        <?php if ($ev_date): ?><span><?php echo $svg_cal_hero; ?> <?php echo esc_html(wp_date('F j, Y', strtotime($ev_date))); ?><?php echo $ev_time ? ' &mdash; ' . esc_html(wp_date('g:i a', strtotime($ev_time))) : ''; ?></span><?php endif; ?>
                        <?php if ($ev_loc): ?><span><?php echo $svg_pin_hero; ?> <?php echo esc_html($ev_loc); ?></span><?php endif; ?>
                    </div>
                    <div class="events-hero__slide-actions">
                        <a href="<?php echo esc_url(get_permalink($ev->ID)); ?>" class="btn btn-outline-white">Learn More</a>
                        <?php if ($ev_reg): ?>
                            <a href="<?php echo esc_url($ev_reg); ?>" target="_blank" rel="noopener" class="btn btn-primary">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination events-hero__pagination"></div>
        <div class="swiper-button-prev events-hero__prev"></div>
        <div class="swiper-button-next events-hero__next"></div>
    </div>

    <?php else: ?>
    <!-- ── Static background (no upcoming events) ── -->
    <div class="events-hero__bg" aria-hidden="true"></div>
    <div class="events-hero__content">
        <span class="events-hero__eyebrow">Programs &amp; Events</span>
        <h1 class="events-hero__heading">Events</h1>
        <div class="events-hero__divider"></div>
        <p class="events-hero__sub">Stay connected with everything happening at The Praise House.</p>
        <nav class="breadcrumbs events-hero__breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,0.45);">Home</a>
            <span class="breadcrumbs__sep" aria-hidden="true" style="color:rgba(255,255,255,0.22);">/</span>
            <span class="current" style="color:rgba(255,255,255,0.8);">Events</span>
        </nav>
    </div>
    <?php endif; ?>

    <!-- ── Interactive Calendar (always present) ── -->
    <div class="events-hero__cal-wrap" aria-label="Filter events by month">
        <div class="events-hero__cal">
            <div class="events-hero__cal-nav">
                <a href="<?php echo esc_url(add_query_arg('month', $prev_month, $archive_url)); ?>" class="events-hero__cal-arrow" aria-label="Previous month">&#8249;</a>
                <span class="events-hero__cal-month"><?php echo esc_html($month_label); ?></span>
                <a href="<?php echo esc_url(add_query_arg('month', $next_month, $archive_url)); ?>" class="events-hero__cal-arrow" aria-label="Next month">&#8250;</a>
            </div>
            <div class="events-hero__cal-grid">
                <?php foreach (['S','M','T','W','T','F','S'] as $d): ?>
                    <span class="events-hero__cal-dayname"><?php echo $d; ?></span>
                <?php endforeach; ?>
                <?php for ($blank = 0; $blank < $first_day_of_week; $blank++): ?>
                    <span class="events-hero__cal-cell events-hero__cal-cell--blank"></span>
                <?php endfor; ?>
                <?php for ($day = 1; $day <= $days_in_month; $day++):
                    $has_event = in_array($day, $event_days);
                    $date_str  = sprintf('%04d-%02d-%02d', $cal_year, $cal_month, $day);
                    $is_today  = ($date_str === $today);
                ?>
                    <a href="<?php echo esc_url(add_query_arg('month', $current_month, $archive_url)); ?>#events-list"
                       class="events-hero__cal-cell<?php echo $has_event ? ' events-hero__cal-cell--event' : ''; ?><?php echo $is_today ? ' events-hero__cal-cell--today' : ''; ?>"
                       <?php if (!$has_event): ?>tabindex="-1" aria-disabled="true"<?php endif; ?>
                       aria-label="<?php echo esc_attr(wp_date('F j, Y', strtotime($date_str))); ?><?php echo $has_event ? ' — has events' : ''; ?>">
                        <?php echo $day; ?>
                    </a>
                <?php endfor; ?>
            </div>
            <?php if (!empty($event_days)): ?>
                <div class="events-hero__cal-legend"><span class="events-hero__cal-dot"></span> Event day</div>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php if ($has_upcoming): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var el = document.querySelector('.events-hero-swiper');
    if (!el || typeof Swiper === 'undefined') return;
    new Swiper('.events-hero-swiper', {
        loop: true,
        speed: 800,
        autoplay: { delay: 5000, disableOnInteraction: false },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        pagination: { el: '.events-hero__pagination', clickable: true },
        navigation: { nextEl: '.events-hero__next', prevEl: '.events-hero__prev' },
    });
});
</script>
<?php endif; ?>
