<?php
get_header();
the_post();

$thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
?>

<main id="main" class="site-main">

    <div class="page-hero">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow">The Praise House</span>
            <h1><?php the_title(); ?></h1>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current"><?php the_title(); ?></span>
            </nav>
        </div>
    </div>

    <section class="section section--lg">
        <div class="container">
            <div class="page-content-wrap">

                <?php if ($thumb): ?>
                    <div class="page-content-wrap__thumb">
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <div class="page-content-wrap__footer">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline">&larr; Back to Home</a>
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) ?: home_url('/contact/')); ?>" class="btn btn-primary">Contact Us</a>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
