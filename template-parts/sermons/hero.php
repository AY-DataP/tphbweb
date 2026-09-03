<?php
$_acf_bg = tphb_option('sermon_archive_hero_bg');
$_bg_raw = is_array($_acf_bg) ? ($_acf_bg['url'] ?? '') : $_acf_bg;
$bg_url  = esc_url($_bg_raw ?: content_url('/uploads/2026/07/Sermon-4.png'));
?>

<section class="sermon-hero" aria-label="Sermons">

    <!-- Background image -->
    <div class="sermon-hero__bg"
         style="background-image:url('<?php echo $bg_url; ?>');"
         aria-hidden="true"></div>

    <!-- Right-side image vignette -->
    <div class="sermon-hero__vignette" aria-hidden="true"></div>

    <!-- Diagonal dark panel -->
    <div class="sermon-hero__panel">

        <span class="sermon-hero__eyebrow">The Word</span>

        <h1 class="sermon-hero__heading">Sermons</h1>

        <div class="sermon-hero__divider"></div>

        <p class="sermon-hero__sub">
            Life-giving messages to strengthen your faith,<br>
            renew your mind, and ignite your purpose.
        </p>

        <blockquote class="sermon-hero__scripture">
            <p class="sermon-hero__scripture-verse">
                "So faith comes from hearing, and hearing through the word of Christ."
            </p>
            <cite class="sermon-hero__scripture-ref">Romans 10:17</cite>
        </blockquote>

        <nav class="breadcrumbs sermon-hero__breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="color:rgba(255,255,255,0.5);">Home</a>
            <span class="breadcrumbs__sep" aria-hidden="true" style="color:rgba(255,255,255,0.25);">/</span>
            <span class="current" style="color:rgba(255,255,255,0.88);">Sermons</span>
        </nav>

    </div>

</section>
