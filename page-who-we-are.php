<?php
/*
 * Template Name: Who We Are
 */
get_header();
?>

<main id="main" class="site-main">

    <!-- Video Hero -->
    <section class="wwr-hero" aria-label="Who We Are">
        <video class="wwr-hero__video" autoplay muted loop playsinline aria-hidden="true">
            <source src="<?php echo esc_url(tphb_option('wwr_hero_video_url') ?: content_url('/uploads/2026/06/who-we-are-hero-loop.mp4')); ?>" type="video/mp4">
        </video>
        <div class="wwr-hero__overlay"></div>
        <div class="wwr-hero__content container">
            <span class="wwr-hero__eyebrow">RCCG The Praise House Baltimore</span>
            <h1 class="wwr-hero__heading">Who We Are</h1>
            <div class="wwr-hero__divider"></div>
            <p class="wwr-hero__sub">Our story, upcoming events, and community outreach &mdash; select a section below to explore.</p>
            <nav class="breadcrumbs wwr-hero__breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current">Who We Are</span>
            </nav>
        </div>
    </section>

    <!-- Hub cards -->
    <section class="wwr-hub section section--lg">
        <div class="container">
            <div class="wwr-grid">

                <?php
                $about_page = get_page_by_path('about-us') ?: get_page_by_path('about');
                $about_url  = $about_page ? get_permalink($about_page) : home_url('/about-us/');
                ?>
                <a href="<?php echo esc_url($about_url); ?>" class="wwr-card fade-in-up">
                    <div class="wwr-card__icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 42h40M8 42V20l16-14 16 14v22"/>
                            <rect x="18" y="28" width="12" height="14" rx="1"/>
                            <path d="M24 10v4"/>
                        </svg>
                    </div>
                    <h2 class="wwr-card__title">About Us</h2>
                    <p class="wwr-card__desc">Learn about our history, mission, vision, and the leadership team that serves our congregation.</p>
                    <span class="wwr-card__cta">Learn More &rarr;</span>
                </a>

                <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>" class="wwr-card fade-in-up">
                    <div class="wwr-card__icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="6" y="10" width="36" height="34" rx="3"/>
                            <path d="M16 6v8M32 6v8M6 22h36"/>
                            <rect x="14" y="28" width="6" height="6" rx="1"/>
                            <rect x="28" y="28" width="6" height="6" rx="1"/>
                        </svg>
                    </div>
                    <h2 class="wwr-card__title">Events</h2>
                    <p class="wwr-card__desc">Stay connected with upcoming programs, services, and community gatherings at The Praise House.</p>
                    <span class="wwr-card__cta">View Events &rarr;</span>
                </a>

                <a href="<?php echo esc_url(get_post_type_archive_link('tphb_outreach')); ?>" class="wwr-card fade-in-up">
                    <div class="wwr-card__icon" aria-hidden="true">
                        <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 28c0-4 3-7 7-7h4l5 5 5-5h4c4 0 7 3 7 7v2H8v-2z"/>
                            <circle cx="24" cy="14" r="6"/>
                            <path d="M4 40c2-4 6-6 10-6M44 40c-2-4-6-6-10-6M14 34H34"/>
                        </svg>
                    </div>
                    <h2 class="wwr-card__title">Outreach</h2>
                    <p class="wwr-card__desc">See how we are making a difference beyond our walls &mdash; community outreach, missions, and service.</p>
                    <span class="wwr-card__cta">See Our Work &rarr;</span>
                </a>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
