<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="siteHeader">
    <div class="header-inner container">

        <div class="site-logo">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?> — Home">
                    <div class="logo-text">
                        <span class="logo-primary">The Praise House</span>
                        <span class="logo-sub">Baltimore</span>
                    </div>
                </a>
            <?php endif; ?>
        </div>

        <nav class="site-nav" id="siteNav" role="navigation" aria-label="Primary">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-menu',
                'fallback_cb'    => false,
            ]); ?>
        </nav>

        <div class="header-cta">
            <?php
            $give_page = get_page_by_path('give');
            $give_url  = $give_page ? get_permalink($give_page->ID) : '#give';
            ?>
            <a href="<?php echo esc_url($give_url); ?>" class="btn btn-give">Give</a>
            <button class="hamburger" id="hamburger" aria-label="Toggle navigation" aria-expanded="false" aria-controls="mobileNav">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <div class="mobile-nav" id="mobileNav" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="mobile-nav-backdrop" id="mobileNavBackdrop"></div>
        <div class="mobile-nav-panel">
            <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close menu">&times;</button>
            <div class="mobile-logo">
                <span class="logo-primary">The Praise House</span>
                <span class="logo-sub">Baltimore</span>
            </div>
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'mobile-menu',
                'fallback_cb'    => false,
            ]); ?>
            <a href="<?php echo esc_url($give_url); ?>" class="btn btn-give btn-give--mobile">Give</a>
            <div class="mobile-nav-social">
                <?php
                $socials = [
                    'youtube'   => tphb_option('youtube_url',   'https://www.youtube.com/@rccgtphb/videos'),
                    'facebook'  => tphb_option('facebook_url',  'https://www.facebook.com/Rccgthepraisehousebaltimore/'),
                    'instagram' => tphb_option('instagram_url', 'https://www.instagram.com/rccgtphb?utm_source=qr&igsh=Y2hibmd0OTczeDJn'),
                    'whatsapp'  => tphb_option('whatsapp_url'),
                ];
                foreach ($socials as $key => $url):
                    if (empty($url)) continue;
                ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="social-icon" aria-label="<?php echo esc_attr(ucfirst($key)); ?>">
                    <?php echo tphb_social_icon($key); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</header>
