<?php
$_acf_video = tphb_option('about_hero_video_url');
$video_url  = esc_url($_acf_video ?: content_url('/uploads/2026/06/about-hero-loop-wide.mp4'));
?>

<section class="about-video-hero" aria-label="About The Praise House">

    <!-- Looping background video -->
    <video class="about-video-hero__video"
           autoplay muted loop playsinline
           aria-hidden="true">
        <source src="<?php echo $video_url; ?>" type="video/mp4">
    </video>

    <!-- Gradient overlay -->
    <div class="about-video-hero__overlay"></div>

    <!-- Text content -->
    <div class="about-video-hero__content">
        <div class="line-wrap">
            <span class="about-video-hero__eyebrow">Our Story</span>
        </div>
        <div class="line-wrap">
            <h1 class="about-video-hero__heading">About The Praise House</h1>
        </div>
        <div class="about-video-hero__divider"></div>
        <div class="line-wrap">
            <p class="about-video-hero__tagline">A newbreed church rooted in love, raised in faith, and reaching the world.</p>
        </div>
        <div class="about-video-hero__badge">
            <span class="about-video-hero__badge-label">Est.</span>
            <span class="about-video-hero__badge-year">May 2021</span>
        </div>
        <nav class="breadcrumbs about-video-hero__breadcrumb" aria-label="Breadcrumb" style="margin-top:2rem;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,0.55);">Home</a>
            <span class="breadcrumbs__sep" aria-hidden="true" style="color:rgba(255,255,255,0.3);">/</span>
            <span class="current" style="color:rgba(255,255,255,0.9);">About Us</span>
        </nav>
    </div>

    <!-- Scroll cue -->
    <div class="about-video-hero__scroll" aria-hidden="true">
        <div class="about-video-hero__scroll-dot"></div>
    </div>

</section>

<script>
(function () {
    var c = document.querySelector('.about-video-hero__content');
    if (c) setTimeout(function () { c.style.pointerEvents = 'none'; }, 6600);
})();
</script>
