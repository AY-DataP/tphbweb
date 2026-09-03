<?php get_header(); ?>

<?php
global $wp_query;
$query = get_search_query();

$type_labels = [
    'sermon'        => 'Sermon',
    'reflection'    => 'Reflection',
    'tphb_event'    => 'Event',
    'tphb_outreach' => 'Outreach',
    'page'          => 'Page',
    'post'          => 'Post',
];
?>

<main id="main" class="site-main">

    <!-- Search Hero -->
    <div class="page-hero">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow">Search Results</span>
            <h1>
                <?php if ($query): ?>
                    Results for &ldquo;<?php echo esc_html($query); ?>&rdquo;
                <?php else: ?>
                    Search
                <?php endif; ?>
            </h1>
            <?php if (have_posts()): ?>
                <p><?php echo esc_html($wp_query->found_posts); ?> result<?php echo $wp_query->found_posts !== 1 ? 's' : ''; ?> found</p>
            <?php endif; ?>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current">Search</span>
            </nav>
        </div>
    </div>

    <section class="archive-section section">
        <div class="container">

            <!-- Search form -->
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-bar fade-in-up">
                <input type="search" name="s" value="<?php echo esc_attr($query); ?>" placeholder="Search sermons, events, pages…" class="search-bar__input" aria-label="Search">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <?php if (have_posts()): ?>

                <div class="search-results-grid">
                    <?php while (have_posts()): the_post();
                        $post_type  = get_post_type();
                        $type_label = $type_labels[$post_type] ?? ucfirst($post_type);
                        $thumb      = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                    ?>
                    <article class="search-result-card fade-in-up">
                        <?php if ($thumb): ?>
                        <a href="<?php the_permalink(); ?>" class="search-result-card__thumb-link" tabindex="-1" aria-hidden="true">
                            <div class="search-result-card__thumb">
                                <img src="<?php echo esc_url($thumb); ?>" alt="" loading="lazy">
                            </div>
                        </a>
                        <?php else: ?>
                        <div class="search-result-card__thumb search-result-card__thumb--placeholder" aria-hidden="true">
                            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M4 42h40M8 42V20l16-14 16 14v22"/><rect x="18" y="28" width="12" height="14" rx="1"/></svg>
                        </div>
                        <?php endif; ?>

                        <div class="search-result-card__body">
                            <div class="search-result-card__meta">
                                <span class="search-result-card__type"><?php echo esc_html($type_label); ?></span>
                                <span class="search-result-card__date"><?php echo esc_html(get_the_date('F j, Y')); ?></span>
                            </div>
                            <h2 class="search-result-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="search-result-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 25)); ?></p>
                            <a href="<?php the_permalink(); ?>" class="search-result-card__link">
                                View
                                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                            </a>
                        </div>
                    </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination"><?php the_posts_pagination(['mid_size' => 2]); ?></div>

            <?php else: ?>

                <div class="archive-empty fade-in-up">
                    <div class="archive-empty__icon">
                        <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="28" cy="28" r="20"/><path d="M42 42l12 12"/>
                            <path d="M21 28h14M28 21v14" opacity="0.4"/>
                        </svg>
                    </div>
                    <h3>No results found<?php echo $query ? ' for &ldquo;' . esc_html($query) . '&rdquo;' : ''; ?></h3>
                    <p>Try a different keyword, or browse one of the sections below.</p>
                    <div class="archive-empty__links">
                        <a href="<?php echo esc_url(get_post_type_archive_link('sermon')); ?>" class="btn btn-outline">Sermons</a>
                        <a href="<?php echo esc_url(get_post_type_archive_link('tphb_event')); ?>" class="btn btn-outline">Events</a>
                        <a href="<?php echo esc_url(get_post_type_archive_link('tphb_outreach')); ?>" class="btn btn-outline">Outreach</a>
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary">Contact Us</a>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </section>

</main>

<?php get_footer(); ?>
