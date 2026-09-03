<?php
/*
 * Template Name: Give
 */
get_header();

$intro       = get_field('give_intro_text');
$cashapp_usr = get_field('cashapp_username');
$cashapp_qr  = get_field('cashapp_qr_image');
$zelle_con   = get_field('zelle_contact');
$zelle_qr    = get_field('zelle_qr_image');
$donate_url  = get_field('donate_button_url');
$donate_lbl  = get_field('donate_button_label') ?: 'Give Online Now';

$cashapp_qr_url = $cashapp_qr ? $cashapp_qr['url'] : content_url('uploads/2026/07/cbd7b3ab-bc9f-4915-98e2-258a30f41e48.jpeg');
$zelle_qr_url   = $zelle_qr   ? $zelle_qr['url']   : content_url('uploads/2026/07/2c75d735-7180-47a5-89fb-59f769571c02.jpeg');
?>

<main id="main" class="site-main">

    <!-- Page Hero -->
    <div class="page-hero" style="padding-top:calc(var(--header-h) + 2rem);padding-bottom:2.5rem;">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow">Support the Vision</span>
            <h1>Give &amp; Donate</h1>
            <p>Your generosity makes an eternal difference — in lives, in our community, and beyond.</p>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current">Give</span>
            </nav>
        </div>
    </div>

    <!-- Scripture Banner -->
    <div class="give-scripture section--sm">
        <div class="container">
            <blockquote>"Each of you should give what you have decided in your heart to give, not reluctantly or under compulsion, for God loves a cheerful giver."</blockquote>
            <cite>— 2 Corinthians 9:7</cite>
        </div>
    </div>

    <!-- Intro Text -->
    <?php if ($intro): ?>
    <section class="section--sm bg-white" style="padding-bottom:1rem;">
        <div class="container container--narrow" style="text-align:center;">
            <div class="entry-content"><?php echo wp_kses_post($intro); ?></div>
        </div>
    </section>
    <?php else: ?>
    <section class="section--sm bg-white" style="padding-bottom:1rem;">
        <div class="container container--narrow" style="text-align:center;">
            <p style="font-size:1.05rem;color:var(--gray-dark);">Your contributions enable us to fulfil our mission of nurturing true worshippers and spreading transformative messages throughout Pikesville and beyond. Every gift — no matter the size — goes directly toward church activities, outreach programs, community services, and facility maintenance.</p>
        </div>
    </section>
    <?php endif; ?>

    <!-- Giving Methods -->
    <section class="give-section section" style="padding-top:1.5rem;">
        <div class="container">
            <div class="section-header fade-in-up">
                <span class="section-header__eyebrow">Ways to Give</span>
                <h2 class="section-header__title">Choose How to Give</h2>
                <div class="section-divider"></div>
            </div>

            <div class="give-grid">

                <!-- Cash App -->
                <div class="give-card fade-in-up">
                    <div class="give-card__icon">💳</div>
                    <h3 class="give-card__title">Cash App</h3>
                    <p class="give-card__sub">Scan the QR code or send to our Cash App username.</p>
                    <div class="give-card__qr">
                        <img src="<?php echo esc_url($cashapp_qr_url); ?>" alt="Cash App QR Code" loading="lazy">
                    </div>
                    <?php if ($cashapp_usr): ?>
                        <div class="give-card__handle"><?php echo esc_html($cashapp_usr); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Zelle -->
                <div class="give-card fade-in-up">
                    <div class="give-card__icon">🏦</div>
                    <h3 class="give-card__title">Zelle</h3>
                    <p class="give-card__sub">Send directly via Zelle using the QR code or our contact details.</p>
                    <div class="give-card__qr">
                        <img src="<?php echo esc_url($zelle_qr_url); ?>" alt="Zelle QR Code" loading="lazy">
                    </div>
                    <?php if ($zelle_con): ?>
                        <div class="give-card__handle"><?php echo esc_html($zelle_con); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Online Giving -->
                <?php if ($donate_url): ?>
                <div class="give-card fade-in-up">
                    <div class="give-card__icon">🌐</div>
                    <h3 class="give-card__title">Give Online</h3>
                    <p class="give-card__sub">Give securely online through our donation portal.</p>
                    <a href="<?php echo esc_url($donate_url); ?>" class="btn btn-primary" target="_blank" rel="noopener noreferrer"><?php echo esc_html($donate_lbl); ?></a>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- Give in Person -->
    <section class="section--sm" style="background:var(--off-white);">
        <div class="container container--narrow" style="text-align:center;">
            <h3 style="margin-bottom:0.75rem;">Give In Person</h3>
            <p>We also receive tithes and offerings during our <strong>Sunday service at 9:00am</strong>. Join us at <?php echo esc_html(tphb_option('site_address','806 Reisterstown Rd, Pikesville, MD 21208')); ?>.</p>
        </div>
    </section>

</main>

<?php get_footer(); ?>
