<?php
$testimonials = get_posts([
    'post_type'      => 'testimonial',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
]);

$has_testimonials = !empty($testimonials);

// Placeholder data shown until real testimonials are added
$placeholders = [
    ['name' => 'Sarah Johnson',   'role' => 'Church Member',   'text' => 'Joining The Praise House changed my life completely. I found a family, a purpose, and a deeper faith than I ever thought possible. This church truly lives its motto.'],
    ['name' => 'Michael Osei',    'role' => 'Young Adult',     'text' => 'The worship here is unlike anything I have experienced. Every Sunday I leave feeling renewed and ready to face the week. I am so grateful for this community.'],
    ['name' => 'Amara Williams',  'role' => 'New Member',      'text' => 'I was nervous visiting for the first time, but I was welcomed with such warmth. The Praise House is the most genuine, loving congregation I have ever been part of.'],
];
?>

<section class="testimonials-section section">
    <div class="container">
        <div class="section-header fade-in-up">
            <span class="section-header__eyebrow">Testimonies</span>
            <h2 class="section-header__title">What God Is Doing</h2>
            <p class="section-header__subtitle">Real stories of lives transformed by grace, faith, and community.</p>
            <div class="section-divider"></div>
        </div>

        <div class="swiper testimonials-swiper fade-in-up">
            <div class="swiper-wrapper">

                <?php if ($has_testimonials): ?>
                    <?php $i = 0; foreach ($testimonials as $testimonial): $i++; ?>
                        <?php
                        $type      = get_field('testimonial_type',        $testimonial->ID) ?: 'text';
                        $text      = get_field('testimonial_text',        $testimonial->ID);
                        $video_url = get_field('testimonial_video_url',   $testimonial->ID);
                        $author    = get_field('testimonial_author',      $testimonial->ID) ?: get_the_title($testimonial->ID);
                        $role      = get_field('testimonial_author_role', $testimonial->ID) ?: 'Church Member';
                        $photo     = get_field('testimonial_photo',       $testimonial->ID);
                        $embed_url = $video_url ? tphb_get_youtube_embed_url($video_url) : '';
                        $initials  = strtoupper(substr($author, 0, 1) . (strpos($author, ' ') !== false ? substr(strrchr($author, ' '), 1, 1) : ''));
                        $reverse   = ($i % 2 === 0) ? 'testimonial-split--reverse' : '';
                        ?>
                        <div class="swiper-slide">
                            <div class="testimonial-split <?php echo esc_attr($reverse); ?>">

                                <!-- Person panel -->
                                <div class="testimonial-split__person">
                                    <div class="testimonial-split__avatar">
                                        <?php if ($photo): ?>
                                            <img src="<?php echo esc_url($photo['sizes']['medium'] ?? $photo['url']); ?>" alt="<?php echo esc_attr($author); ?>">
                                        <?php else: ?>
                                            <span class="testimonial-split__initials"><?php echo esc_html($initials); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="testimonial-split__name"><?php echo esc_html($author); ?></div>
                                    <div class="testimonial-split__role"><?php echo esc_html($role); ?></div>
                                </div>

                                <!-- Content panel -->
                                <div class="testimonial-split__content">
                                    <div class="testimonial-split__church">RCCG The Praise House</div>
                                    <?php if ($type === 'video' && $embed_url): ?>
                                        <div class="testimonial-split__video">
                                            <iframe src="<?php echo esc_url($embed_url); ?>" frameborder="0" allowfullscreen loading="lazy" title="Testimonial by <?php echo esc_attr($author); ?>"></iframe>
                                        </div>
                                    <?php elseif ($text): ?>
                                        <blockquote class="testimonial-split__quote">&ldquo;<?php echo esc_html($text); ?>&rdquo;</blockquote>
                                    <?php endif; ?>
                                    <?php if ($type === 'both' && $embed_url && $text): ?>
                                        <div class="testimonial-split__video" style="margin-top:1rem;">
                                            <iframe src="<?php echo esc_url($embed_url); ?>" frameborder="0" allowfullscreen loading="lazy" title="Testimonial"></iframe>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <!-- Placeholder testimonials -->
                    <?php foreach ($placeholders as $i => $p): ?>
                        <div class="swiper-slide">
                            <div class="testimonial-split <?php echo $i % 2 !== 0 ? 'testimonial-split--reverse' : ''; ?>">
                                <div class="testimonial-split__person">
                                    <div class="testimonial-split__avatar testimonial-split__avatar--placeholder">
                                        <span class="testimonial-split__initials"><?php echo esc_html(strtoupper(substr($p['name'], 0, 1) . substr(strrchr($p['name'], ' '), 1, 1))); ?></span>
                                    </div>
                                    <div class="testimonial-split__name"><?php echo esc_html($p['name']); ?></div>
                                    <div class="testimonial-split__role"><?php echo esc_html($p['role']); ?></div>
                                </div>
                                <div class="testimonial-split__content">
                                    <div class="testimonial-split__church">RCCG The Praise House</div>
                                    <blockquote class="testimonial-split__quote">&ldquo;<?php echo esc_html($p['text']); ?>&rdquo;</blockquote>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>

            <div class="swiper-pagination" style="margin-top:1.5rem;position:relative;bottom:auto;"></div>
            <div class="swiper-button-prev testimonials-swiper__prev"></div>
            <div class="swiper-button-next testimonials-swiper__next"></div>
        </div>
    </div>
</section>
