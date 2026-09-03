<?php
$phone   = tphb_option('site_phone',   '+1 (682) 228-7808');
$email   = tphb_option('site_email',   'info@rccgthepraisehouse.org');
$address = tphb_option('site_address', "806 Reisterstown Rd\nPikesville, MD 21208, USA");
$address_single = preg_replace('/\s*\n\s*/', ', ', trim($address));
?>

<section class="contact-hero" aria-label="Contact The Praise House">

    <!-- Radial gradient background -->
    <div class="contact-hero__bg" aria-hidden="true"></div>

    <!-- Signal source + pulsing rings -->
    <div class="contact-hero__signal" aria-hidden="true">
        <div class="contact-hero__signal-core"></div>
        <div class="contact-hero__ring contact-hero__ring--1"></div>
        <div class="contact-hero__ring contact-hero__ring--2"></div>
        <div class="contact-hero__ring contact-hero__ring--3"></div>
    </div>

    <!-- Text content -->
    <div class="contact-hero__content">

        <span class="contact-hero__eyebrow">We'd Love to Hear From You</span>
        <h1 class="contact-hero__heading">Contact Us</h1>
        <div class="contact-hero__divider"></div>
        <p class="contact-hero__sub">Reach out with questions, prayer requests, or just to say hello — we are here.</p>

        <!-- Quick-contact pills -->
        <div class="contact-hero__pills">

            <a href="tel:<?php echo esc_attr(preg_replace('/[^+\d]/', '', $phone)); ?>"
               class="contact-hero__pill">
                <svg class="contact-hero__pill-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                </svg>
                <span><?php echo esc_html($phone); ?></span>
            </a>

            <a href="mailto:<?php echo esc_attr($email); ?>"
               class="contact-hero__pill">
                <svg class="contact-hero__pill-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <span><?php echo esc_html($email); ?></span>
            </a>

            <div class="contact-hero__pill contact-hero__pill--location">
                <svg class="contact-hero__pill-icon" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <span><?php echo esc_html($address_single); ?></span>
            </div>

        </div>

        <nav class="breadcrumbs contact-hero__breadcrumb" aria-label="Breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"
               style="color:rgba(255,255,255,0.45);">Home</a>
            <span class="breadcrumbs__sep" aria-hidden="true"
                  style="color:rgba(255,255,255,0.22);">/</span>
            <span class="current"
                  style="color:rgba(255,255,255,0.8);">Contact Us</span>
        </nav>

    </div>

</section>
