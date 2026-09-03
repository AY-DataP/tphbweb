<nav class="wwr-subnav" aria-label="Who We Are sections">
    <div class="container">
        <a href="<?php echo esc_url(home_url('/who-we-are/')); ?>" class="wwr-subnav__back">
            &larr; Who We Are
        </a>
        <div class="wwr-subnav__links">
            <?php
            $about_page = get_page_by_path('about-us') ?: get_page_by_path('about');
            $about_url  = $about_page ? get_permalink($about_page) : home_url('/about-us/');
            ?>
            <a href="<?php echo esc_url($about_url); ?>"
               class="wwr-subnav__link<?php echo ($about_page && is_page($about_page->ID)) ? ' active' : ''; ?>">
                About Us
            </a>
            <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>"
               class="wwr-subnav__link<?php echo is_post_type_archive('tphb_event') ? ' active' : ''; ?>">
                Events
            </a>
            <a href="<?php echo esc_url(get_post_type_archive_link('tphb_outreach')); ?>"
               class="wwr-subnav__link<?php echo is_post_type_archive('tphb_outreach') ? ' active' : ''; ?>">
                Outreach
            </a>
        </div>
    </div>
</nav>
