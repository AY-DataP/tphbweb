<?php
$mission_title    = get_field('mission_title',           get_the_ID()) ?: 'Our Mission';
$mission_text     = get_field('mission_text',            get_the_ID());
$scripture_ref    = get_field('mission_scripture',       get_the_ID()) ?: 'Matthew 28:19';
$scripture_text   = get_field('mission_scripture_text',  get_the_ID()) ?: '"Go therefore and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit."';
?>

<section class="mission-section section section--lg">
    <div class="container mission-inner">

        <div class="mission-lead fade-in-up">
            <span class="section-header__eyebrow" style="display:inline-block;color:rgba(200,230,245,0.7);margin-bottom:0.75rem;">Who We Are</span>
            <h2><?php echo esc_html($mission_title); ?></h2>
            <?php if ($mission_text): ?>
                <div><?php echo wp_kses_post($mission_text); ?></div>
            <?php else: ?>
                <p>We are a newbreed church committed to raising a movement of true worshippers in Spirit and Truth — transforming lives through the power of God's Word, one person at a time.</p>
            <?php endif; ?>
        </div>

        <div class="mission-pillars">
            <div class="mission-pillar fade-in-up">
                <div class="mission-pillar__number">01</div>
                <div class="mission-pillar__word"><span>BE</span>long</div>
                <p class="mission-pillar__desc">You are not alone. We are a family — an inclusive community where everyone is welcomed, known, and valued just as they are.</p>
            </div>
            <div class="mission-pillar fade-in-up">
                <div class="mission-pillar__number">02</div>
                <div class="mission-pillar__word"><span>BE</span>lieve</div>
                <p class="mission-pillar__desc">Faith is the foundation. We anchor ourselves in the truth of God's Word and the transforming power of Christ Jesus.</p>
            </div>
            <div class="mission-pillar fade-in-up">
                <div class="mission-pillar__number">03</div>
                <div class="mission-pillar__word"><span>BE</span>come</div>
                <p class="mission-pillar__desc">Growth is intentional. We are a people committed to becoming everything God has destined us to be — in character, purpose, and impact.</p>
            </div>
        </div>

        <?php if ($scripture_text): ?>
        <div class="mission-scripture fade-in-up">
            <p class="mission-scripture__text"><?php echo esc_html($scripture_text); ?></p>
            <span class="mission-scripture__ref">— <?php echo esc_html($scripture_ref); ?></span>
        </div>
        <?php endif; ?>

    </div>
</section>
