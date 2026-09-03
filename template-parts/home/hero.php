<?php
$slides = get_posts([
    'post_type'      => 'hero_slide',
    'posts_per_page' => 5,
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'slide_order',
    'order'          => 'ASC',
    'post_status'    => 'publish',
]);

$has_slides = !empty($slides);
$sunday     = tphb_option('sunday_service_time',    'Sundays at 9:00am (In-Person & Online)');
$wednesday  = tphb_option('wednesday_service_time', 'Wednesdays at 7:00pm (Online Only)');
$address    = tphb_option('site_address',            '806 Reisterstown Rd, Pikesville, MD 21208');
?>

<section class="hero" aria-label="Hero">

    <!-- YouTube Live Banner -->
    <div class="live-banner" id="liveBanner" role="alert" aria-live="polite">
        <span class="live-banner__dot"></span>
        We are LIVE now — <strong>Join Us</strong>
    </div>

    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">

            <?php if ($has_slides): ?>
                <?php foreach ($slides as $slide): ?>
                    <?php
                    $type      = get_field('slide_type',      $slide->ID) ?: 'image';
                    $image     = get_field('slide_image',     $slide->ID);
                    $video_url = get_field('slide_video_url', $slide->ID);
                    $heading   = get_field('slide_heading',   $slide->ID) ?: get_the_title($slide->ID);
                    $subhead   = get_field('slide_subheading',$slide->ID);
                    $cta1_text = get_field('slide_cta_text',  $slide->ID);
                    $cta1_url  = get_field('slide_cta_url',   $slide->ID);
                    $cta2_text = get_field('slide_cta2_text', $slide->ID);
                    $cta2_url  = get_field('slide_cta2_url',  $slide->ID);
                    $overlay   = get_field('slide_overlay',   $slide->ID) ?: '0.6';
                    $bg_style  = $image ? 'background-image:url(' . esc_url($image['url']) . ');' : '';
                    ?>
                    <div class="swiper-slide">
                        <div class="hero-slide">
                            <div class="hero-slide__bg" style="<?php echo esc_attr($bg_style); ?>">
                                <?php if ($type === 'video_bg' && $video_url): ?>
                                    <video autoplay muted loop playsinline aria-hidden="true">
                                        <source src="<?php echo esc_url($video_url); ?>">
                                    </video>
                                <?php endif; ?>
                            </div>
                            <div class="hero-slide__overlay" style="background:rgba(13,32,64,<?php echo esc_attr($overlay); ?>);"></div>
                            <div class="hero-slide__content">
                                <span class="hero-slide__eyebrow">RCCG The Praise House Baltimore</span>
                                <h1 class="hero-slide__title"><?php echo wp_kses_post($heading); ?></h1>
                                <?php if ($subhead): ?>
                                    <p class="hero-slide__subtitle"><?php echo esc_html($subhead); ?></p>
                                <?php endif; ?>
                                <?php if ($cta1_text || $cta2_text): ?>
                                <div class="hero-slide__actions">
                                    <?php if ($cta1_text && $cta1_url): ?>
                                        <a href="<?php echo esc_url($cta1_url); ?>" class="btn btn-primary btn-lg"><?php echo esc_html($cta1_text); ?></a>
                                    <?php endif; ?>
                                    <?php if ($cta2_text && $cta2_url): ?>
                                        <a href="<?php echo esc_url($cta2_url); ?>" class="btn btn-outline-white btn-lg"><?php echo esc_html($cta2_text); ?></a>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <!-- Default slide when no slides are created yet -->
                <div class="swiper-slide" data-swiper-autoplay="8000">
                    <div class="hero-slide hero-slide--video-top">
                        <div class="hero-slide__bg">
                            <video autoplay muted loop playsinline id="heroVideo">
                                <source src="<?php echo esc_url(content_url('/uploads/2026/07/98a8b9f0-73ac-4529-8729-a38edc82b2b9.mp4')); ?>" type="video/mp4">
                            </video>
                        </div>
                        <div class="hero-slide__overlay" style="background:rgba(13,32,64,0.5);"></div>
                        <div class="hero-slide__content">
                            <div class="hero-slide__title-spacer"></div>
                            <p class="hero-slide__subtitle">A newbreed church raising true worshippers in Spirit and Truth. Join our family — a place to belong.</p>
                        </div>
                        <div class="hero-slide__actions hero-slide__actions--pinned">
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('new-here')) ?: home_url('/new-here/')); ?>" class="btn btn-primary btn-lg">I'm New Here</a>
                            <a href="#service-times" class="btn btn-outline-white btn-lg">Service Times</a>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" data-swiper-autoplay="5000">
                    <div class="hero-slide">
                        <div class="hero-slide__bg" style="background:linear-gradient(135deg,#24488A 0%,#1A3660 100%);"></div>
                        <div class="hero-slide__overlay" style="background:rgba(13,32,64,0.4);"></div>
                        <div class="hero-slide__content">
                            <span class="hero-slide__eyebrow">Join Us This Sunday</span>
                            <h1 class="hero-slide__title">Transformative Messages for Spirit, Soul &amp; Body</h1>
                            <p class="hero-slide__subtitle">Every Sunday at 9:00am — In-Person &amp; Online. All are welcome.</p>
                            <div class="hero-slide__actions">
                                <a href="<?php echo esc_url(get_post_type_archive_link('sermon')); ?>" class="btn btn-secondary btn-lg">Watch Sermons</a>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) ?: home_url('/contact/')); ?>" class="btn btn-outline-white btn-lg">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <!-- Service bar -->
    <div class="hero-service-bar">
        <div class="container">
            <div class="service-bar-item">
                <span class="service-bar-item__icon">&#9829;</span>
                <span><?php echo esc_html($sunday); ?></span>
            </div>
            <div class="service-bar-divider"></div>
            <div class="service-bar-item">
                <span class="service-bar-item__icon">&#128247;</span>
                <span><?php echo esc_html($wednesday); ?></span>
            </div>
            <div class="service-bar-divider"></div>
            <div class="service-bar-item">
                <span class="service-bar-item__icon">&#128205;</span>
                <span><?php echo esc_html(str_replace("\n", ', ', $address)); ?></span>
            </div>
        </div>
    </div>

</section>

<script>
(function () {
    var hero = document.querySelector('.hero');
    if (!hero || !('IntersectionObserver' in window)) return;
    var observer = new IntersectionObserver(function (entries) {
        var videos = hero.querySelectorAll('video');
        if (!videos.length) return;
        if (entries[0].isIntersecting) {
            videos.forEach(function (v) { v.play().catch(function () {}); });
        } else {
            videos.forEach(function (v) { v.pause(); });
        }
    }, { threshold: 0 });
    observer.observe(hero);
})();
</script>

<!-- YouTube Live Modal -->
<div class="live-modal" id="liveModal" role="dialog" aria-modal="true" aria-label="Live Service">
    <div class="live-modal__inner">
        <div class="live-modal__header">
            <span>&#128247; We Are Live Now</span>
            <button class="live-modal__close" id="liveModalClose" aria-label="Close">&times;</button>
        </div>
        <div class="live-modal__frame">
            <iframe id="liveIframe" frameborder="0" allowfullscreen allow="autoplay; encrypted-media" title="Live Church Service"></iframe>
        </div>
    </div>
</div>
