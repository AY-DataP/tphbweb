<?php
get_header();
the_post();

$event_date   = get_field('event_date');
$event_time   = get_field('event_time');
$end_date     = get_field('event_end_date');
$location     = get_field('event_location');
$flyer        = get_field('event_flyer');
$reg_url      = get_field('event_registration_url');
$iso_dt       = tphb_get_event_datetime_iso(get_the_ID());
$thumb        = $flyer ? $flyer['url'] : get_the_post_thumbnail_url(get_the_ID(), 'large');
$today        = wp_date('Ymd');
$is_past      = $event_date && str_replace('-', '', $event_date) < $today;

$related = get_posts([
    'post_type'      => 'tphb_event',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'post__not_in'   => [get_the_ID()],
    'meta_key'       => 'event_date',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
]);
?>

<main id="main" class="site-main">

    <!-- Page hero -->
    <div class="page-hero" style="padding-bottom:3rem;">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow"><?php echo $is_past ? 'Past Event' : 'Upcoming Event'; ?></span>
            <h1><?php the_title(); ?></h1>
            <?php if ($event_date): ?>
                <p style="color:rgba(255,255,255,0.7);">
                    &#128197; <?php echo esc_html(date('F j, Y', strtotime($event_date))); ?>
                    <?php if ($event_time): ?>&mdash; <?php echo esc_html(wp_date('g:i a', strtotime($event_time))); ?><?php endif; ?>
                    <?php if ($end_date && $end_date !== $event_date): ?> &ndash; <?php echo esc_html(date('F j, Y', strtotime($end_date))); ?><?php endif; ?>
                </p>
            <?php endif; ?>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>">Events</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current"><?php the_title(); ?></span>
            </nav>
        </div>
    </div>

    <section class="single-section">
        <div class="container">
            <div class="single-layout">

                <article class="single-article">

                    <!-- Flyer / thumbnail -->
                    <?php if ($thumb): ?>
                        <div style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:2rem;box-shadow:var(--shadow-lg);">
                            <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="eager" style="width:100%;height:auto;display:block;">
                        </div>
                    <?php endif; ?>

                    <!-- Event meta strip -->
                    <div class="single-meta" style="margin-bottom:2rem;">
                        <?php if ($event_date): ?>
                            <span class="single-meta__item">
                                &#128197; <strong><?php echo esc_html(date('F j, Y', strtotime($event_date))); ?></strong>
                                <?php if ($event_time): ?>&mdash; <?php echo esc_html(wp_date('g:i a', strtotime($event_time))); ?><?php endif; ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($end_date && $end_date !== $event_date): ?>
                            <span class="single-meta__item">&#128198; Ends <?php echo esc_html(date('F j, Y', strtotime($end_date))); ?></span>
                        <?php endif; ?>
                        <?php if ($location): ?>
                            <span class="single-meta__item">&#128205; <?php echo esc_html($location); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Countdown (upcoming events only) -->
                    <?php if (!$is_past && $iso_dt): ?>
                        <div style="background:var(--blue-pale);border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:2rem;text-align:center;">
                            <p style="font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:var(--blue);margin-bottom:0.75rem;">Counting Down</p>
                            <div class="countdown" data-event-date="<?php echo esc_attr($iso_dt); ?>" style="justify-content:center;">
                                <div class="countdown__unit"><span class="countdown__value" data-unit="days">--</span><span class="countdown__label">Days</span></div>
                                <div class="countdown__unit"><span class="countdown__value" data-unit="hours">--</span><span class="countdown__label">Hrs</span></div>
                                <div class="countdown__unit"><span class="countdown__value" data-unit="minutes">--</span><span class="countdown__label">Min</span></div>
                                <div class="countdown__unit"><span class="countdown__value" data-unit="seconds">--</span><span class="countdown__label">Sec</span></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Post content -->
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <!-- Action buttons -->
                    <div style="display:flex;gap:1rem;margin-top:2.5rem;flex-wrap:wrap;padding-top:2rem;border-top:1px solid var(--gray-light);">
                        <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>" class="btn btn-outline">&larr; All Events</a>
                        <?php if ($reg_url && !$is_past): ?>
                            <a href="<?php echo esc_url($reg_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">&#9989; Register / RSVP</a>
                        <?php endif; ?>
                    </div>

                </article>

                <!-- Sidebar -->
                <aside class="single-sidebar">

                    <!-- Location widget -->
                    <?php if ($location): ?>
                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget__title">Location</h4>
                        <p style="font-size:0.9rem;color:var(--gray-dark);margin-bottom:1rem;">&#128205; <?php echo esc_html($location); ?></p>
                        <a href="https://maps.google.com/?q=<?php echo urlencode($location); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="font-size:0.82rem;padding:0.5rem 1.1rem;">Get Directions</a>
                    </div>
                    <?php endif; ?>

                    <!-- Registration widget (upcoming only) -->
                    <?php if ($reg_url && !$is_past): ?>
                    <div class="sidebar-widget" style="background:var(--navy);color:var(--white);text-align:center;">
                        <p style="font-size:1.05rem;font-weight:700;color:var(--white);margin-bottom:0.5rem;">Join Us!</p>
                        <p style="font-size:0.875rem;color:rgba(255,255,255,0.75);margin-bottom:1.25rem;">Register or RSVP to reserve your spot.</p>
                        <a href="<?php echo esc_url($reg_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="width:100%;justify-content:center;">&#9989; Register Now</a>
                    </div>
                    <?php endif; ?>

                    <!-- Other events -->
                    <?php if (!empty($related)): ?>
                    <div class="sidebar-widget">
                        <h4 class="sidebar-widget__title">Other Events</h4>
                        <div class="sidebar-post-list">
                        <?php foreach ($related as $r):
                            $r_date  = get_field('event_date', $r->ID);
                            $r_flyer = get_field('event_flyer', $r->ID);
                            $r_thumb = $r_flyer ? $r_flyer['url'] : get_the_post_thumbnail_url($r->ID, 'thumbnail');
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
                                    <?php if ($r_date): ?>
                                        <div class="sidebar-post__date">&#128197; <?php echo esc_html(date('M j, Y', strtotime($r_date))); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Prayer CTA -->
                    <div class="sidebar-widget" style="background:var(--blue-pale);text-align:center;">
                        <p style="font-size:0.875rem;color:var(--gray-dark);margin-bottom:1rem;">Need prayer? Our team is here for you.</p>
                        <a href="<?php echo esc_url(home_url('/#prayer-request')); ?>" class="btn btn-outline" style="font-size:0.82rem;">&#128591; Prayer Request</a>
                    </div>

                </aside>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
