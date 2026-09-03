<?php get_header(); ?>

<main id="main" class="site-main">

    <section class="notfound-section">
        <div class="notfound-section__bg" aria-hidden="true"></div>
        <div class="container notfound-section__content">

            <div class="notfound-code" aria-hidden="true">404</div>

            <span class="notfound-eyebrow">Page Not Found</span>
            <h1 class="notfound-heading">Hmm, we couldn't find that page.</h1>
            <div class="notfound-divider"></div>
            <p class="notfound-sub">The page you're looking for may have been moved, renamed, or doesn't exist. Here are some helpful places to go instead.</p>

            <div class="notfound-links">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="notfound-link">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9.5L10 3l7 6.5V18a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/><path d="M7 19v-7h6v7"/></svg>
                    Home
                </a>
                <a href="<?php echo esc_url(home_url('/about/')); ?>" class="notfound-link">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="10" cy="7" r="3"/><path d="M4 17c0-3.314 2.686-6 6-6s6 2.686 6 6"/></svg>
                    About Us
                </a>
                <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>" class="notfound-link">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="14" height="14" rx="2"/><path d="M7 2v4M13 2v4M3 9h14"/></svg>
                    Events
                </a>
                <a href="<?php echo esc_url(get_post_type_archive_link('sermon')); ?>" class="notfound-link">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="5,3 19,10 5,17"/></svg>
                    Sermons
                </a>
                <a href="<?php echo esc_url(home_url('/new-here/')); ?>" class="notfound-link">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 2a8 8 0 1 1 0 16A8 8 0 0 1 10 2zm0 4v4l3 3"/></svg>
                    I'm New Here
                </a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="notfound-link">
                    <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 4h16v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4z"/><path d="M2 4l8 7 8-7"/></svg>
                    Contact Us
                </a>
            </div>

            <div class="notfound-search">
                <p class="notfound-search__label">Or search for what you need:</p>
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="notfound-search__form">
                    <input type="search" name="s" placeholder="Search sermons, events, pages…" value="<?php echo esc_attr(get_search_query()); ?>" class="notfound-search__input" aria-label="Search">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>
