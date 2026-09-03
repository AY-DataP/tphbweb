<?php
$sermons = get_posts([
    'post_type'      => 'sermon',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>

<section class="sermons-section section">
    <div class="container">
        <div class="section-header fade-in-up">
            <span class="section-header__eyebrow">The Word</span>
            <h2 class="section-header__title">Latest Sermons</h2>
            <p class="section-header__subtitle">Be transformed by the renewing of your mind through powerful, life-giving messages.</p>
            <div class="section-divider"></div>
        </div>

        <div class="sermon-cards">
            <?php if (!empty($sermons)): ?>
                <?php foreach ($sermons as $sermon): ?>
                    <?php
                    $youtube_url = get_field('sermon_youtube_url', $sermon->ID);
                    $speaker     = get_field('sermon_speaker',     $sermon->ID) ?: 'Pastor Diipo Omopariola';
                    $date        = get_field('sermon_date',        $sermon->ID);
                    $scripture   = get_field('sermon_scripture',   $sermon->ID);
                    $series      = get_field('sermon_series_name', $sermon->ID);
                    $duration    = get_field('sermon_duration',    $sermon->ID);
                    $thumb       = get_the_post_thumbnail_url($sermon->ID, 'large');

                    if (!$thumb && $youtube_url) {
                        $vid_id = tphb_get_youtube_id($youtube_url);
                        if ($vid_id) $thumb = "https://img.youtube.com/vi/{$vid_id}/hqdefault.jpg";
                    }
                    ?>
                    <article class="sermon-card fade-in-up">
                        <div class="sermon-card__thumb">
                            <?php if ($thumb): ?>
                                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($sermon->ID)); ?>" loading="lazy">
                            <?php else: ?>
                                <div class="sermon-card__thumb-placeholder">
                                    <span>&#9654;</span>
                                </div>
                            <?php endif; ?>
                            <?php if ($youtube_url): ?>
                                <a href="<?php echo esc_url(get_permalink($sermon->ID)); ?>" class="sermon-card__play" aria-label="Watch sermon">
                                    <span class="sermon-card__play-icon">&#9654;</span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="sermon-card__body">
                            <?php if ($series): ?>
                                <span class="sermon-card__series"><?php echo esc_html($series); ?></span>
                            <?php endif; ?>
                            <div class="sermon-card__meta">
                                <?php if ($date): ?><span>&#128197; <?php echo esc_html(date('M j, Y', strtotime($date))); ?></span><?php endif; ?>
                                <?php if ($speaker): ?><span>&#127908; <?php echo esc_html($speaker); ?></span><?php endif; ?>
                                <?php if ($duration): ?><span>&#8987; <?php echo esc_html($duration); ?></span><?php endif; ?>
                            </div>
                            <h3 class="sermon-card__title">
                                <a href="<?php echo esc_url(get_permalink($sermon->ID)); ?>"><?php echo esc_html(get_the_title($sermon->ID)); ?></a>
                            </h3>
                            <?php if ($scripture): ?>
                                <p class="sermon-card__scripture">&#128214; <?php echo esc_html($scripture); ?></p>
                            <?php else: ?>
                                <p class="sermon-card__excerpt"><?php echo esc_html(get_the_excerpt($sermon->ID)); ?></p>
                            <?php endif; ?>
                            <a href="<?php echo esc_url(get_permalink($sermon->ID)); ?>" class="sermon-card__link">
                                Watch &amp; Read <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>

            <?php else: ?>
                <!-- Placeholder cards shown until sermons are published -->
                <?php
                $placeholders = [
                    ['title' => 'The Power of Faith',          'speaker' => 'Pastor Diipo Omopariola', 'scripture' => 'Hebrews 11:1',    'date' => 'Add sermon date'],
                    ['title' => 'Walking in His Purpose',      'speaker' => 'Pastor Diipo Omopariola', 'scripture' => 'Jeremiah 29:11',  'date' => 'Add sermon date'],
                    ['title' => 'Belonging to God\'s Family',  'speaker' => 'Pastor Diipo Omopariola', 'scripture' => 'Romans 8:14-17',  'date' => 'Add sermon date'],
                ];
                foreach ($placeholders as $p): ?>
                <article class="sermon-card sermon-card--placeholder fade-in-up">
                    <div class="sermon-card__thumb">
                        <div class="sermon-card__thumb-placeholder">
                            <span>&#9654;</span>
                        </div>
                    </div>
                    <div class="sermon-card__body">
                        <div class="sermon-card__meta">
                            <span>&#127908; <?php echo esc_html($p['speaker']); ?></span>
                        </div>
                        <h3 class="sermon-card__title"><?php echo esc_html($p['title']); ?></h3>
                        <p class="sermon-card__scripture">&#128214; <?php echo esc_html($p['scripture']); ?></p>
                        <p class="sermon-card__placeholder-note">Add sermons from your WordPress dashboard to populate this section.</p>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="section-cta fade-in-up">
            <a href="<?php echo esc_url(get_post_type_archive_link('sermon')); ?>" class="btn btn-primary">
                View All Sermons &rarr;
            </a>
        </div>
    </div>
</section>
