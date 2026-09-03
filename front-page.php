<?php get_header(); ?>

<main id="main" class="site-main">

    <?php get_template_part('template-parts/home/hero'); ?>
    <?php get_template_part('template-parts/home/welcome'); ?>
    <?php get_template_part('template-parts/home/mission'); ?>
    <?php get_template_part('template-parts/home/sermons-preview'); ?>
    <?php get_template_part('template-parts/home/events'); ?>
    <?php get_template_part('template-parts/home/service-times'); ?>
    <?php get_template_part('template-parts/home/testimonials'); ?>

    <section class="forms-section section">
        <div class="container">
            <div class="forms-grid">
                <?php get_template_part('template-parts/home/contact-form'); ?>
                <?php get_template_part('template-parts/home/prayer-form'); ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
