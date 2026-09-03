<?php
/*
 * Template Name: Gallery
 */
get_header();

$gallery_images = get_field('gallery_images');
?>

<main id="main" class="site-main">

    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow">Moments &amp; Memories</span>
            <h1>Our Gallery</h1>
            <p>A glimpse into the life of The Praise House — where community and ministry meet.</p>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current">Gallery</span>
            </nav>
        </div>
    </div>

    <!-- Gallery Grid -->
    <section class="gallery-section section">
        <div class="container">
            <?php if ($gallery_images): ?>
                <div class="gallery-grid">
                    <?php foreach ($gallery_images as $i => $img): ?>
                        <div class="gallery-item" data-src="<?php echo esc_url($img['url']); ?>" data-alt="<?php echo esc_attr($img['alt'] ?: $img['title']); ?>" role="button" tabindex="0" aria-label="View image: <?php echo esc_attr($img['alt'] ?: $img['title'] ?: 'Gallery image ' . ($i + 1)); ?>">
                            <img src="<?php echo esc_url($img['sizes']['large'] ?? $img['url']); ?>"
                                 alt="<?php echo esc_attr($img['alt'] ?: $img['title']); ?>"
                                 loading="lazy">
                            <div class="gallery-item__overlay" aria-hidden="true">
                                <span>&#128269;</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>

                <!-- ── Gallery Placeholders: Mosaic grid layout ── -->
                <div class="ph-label" style="margin-bottom:2rem;">&#128274; Gallery photos coming soon — below is a preview of the layout</div>

                <div class="gph-mosaic">
                    <?php
                    $tiles = [
                        ['label'=>'Sunday Worship',        'grad'=>'135deg,#1A3660,#4A9FD4', 'span'=>'wide'],
                        ['label'=>'Nights of Mercy',       'grad'=>'135deg,#2E7D6E,#52C7B8', 'span'=>'tall'],
                        ['label'=>'Community Outreach',    'grad'=>'135deg,#7B5EA7,#B39DDB', 'span'=>''],
                        ['label'=>'Youth Ministry',        'grad'=>'135deg,#C0392B,#E57373', 'span'=>''],
                        ['label'=>'Prayer & Worship',      'grad'=>'135deg,#0D2040,#24488A', 'span'=>'wide'],
                        ['label'=>'Baptism Service',       'grad'=>'135deg,#E67E22,#F5A623', 'span'=>''],
                        ['label'=>'Choir &amp; Music',     'grad'=>'135deg,#1A3660,#2E5BAA', 'span'=>'tall'],
                        ['label'=>'Special Events',        'grad'=>'135deg,#27AE60,#6FCF97', 'span'=>''],
                        ['label'=>'Fellowship &amp; Food', 'grad'=>'135deg,#8E44AD,#D7BDE2', 'span'=>''],
                        ['label'=>'Children\'s Church',    'grad'=>'135deg,#2980B9,#7EC8E3', 'span'=>'wide'],
                        ['label'=>'Leadership Retreat',    'grad'=>'135deg,#24488A,#4A9FD4', 'span'=>''],
                        ['label'=>'Harvest Thanksgiving',  'grad'=>'135deg,#B7410E,#E67E22', 'span'=>''],
                    ];
                    foreach ($tiles as $t): ?>
                    <div class="gph-tile gph-tile--<?php echo $t['span'] ?: 'normal'; ?>" style="background:linear-gradient(<?php echo $t['grad']; ?>);">
                        <div class="gph-tile__overlay">
                            <span class="gph-tile__icon">&#128247;</span>
                            <span class="gph-tile__label"><?php echo $t['label']; ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
