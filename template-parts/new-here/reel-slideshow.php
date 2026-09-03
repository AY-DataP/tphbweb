<?php
$_acf_scenes = get_field('reel_scenes');
$_reel_base  = content_url('/uploads/2026/06/');

if (!empty($_acf_scenes)) {
    $reel_scenes = array_map(function ($row) {
        $img = $row['scene_image'];
        $cta = null;
        if (!empty($row['scene_cta_label']) && !empty($row['scene_cta_url'])) {
            $cta = ['label' => $row['scene_cta_label'], 'url' => $row['scene_cta_url']];
        }
        return [
            'image'    => is_array($img) ? ($img['url'] ?? '') : (string) $img,
            'position' => 'center center',
            'duration' => !empty($row['scene_duration']) ? (int) $row['scene_duration'] : 4000,
            'eyebrow'  => $row['scene_eyebrow']  ?? '',
            'headline' => $row['scene_headline'] ?? '',
            'sub'      => $row['scene_sub']      ?? '',
            'cta'      => $cta,
        ];
    }, $_acf_scenes);
} else {
    $reel_scenes = [
        ['image'=>$_reel_base.'Copy-of-c2dde4df-c6da-42f0-9b43-c52e95799c87.jpg','position'=>'center 30%','duration'=>5000,'eyebrow'=>'Welcome to','headline'=>'The Praise House','sub'=>'Baltimore, Maryland','cta'=>null],
        ['image'=>$_reel_base.'Copy-of-70a09fc0-fdac-4579-a443-53e524819a1a.jpg','position'=>'center center','duration'=>4000,'eyebrow'=>'A Church Built on Love','headline'=>'Vibrant. Diverse. Multigenerational.','sub'=>'A family where everyone belongs.','cta'=>null],
        ['image'=>$_reel_base.'Copy-of-IMG_7231-scaled.jpg','position'=>'center 40%','duration'=>4000,'eyebrow'=>'Our Vision','headline'=>'BElong. BElieve. BEcome.','sub'=>'You have a place here.','cta'=>null],
        ['image'=>$_reel_base.'Copy-of-IMG_9237-scaled.jpg','position'=>'center center','duration'=>4000,'eyebrow'=>'For Every Generation','headline'=>'Children · Youth · Young Adults','sub'=>'Programs your whole family will love.','cta'=>null],
        ['image'=>$_reel_base.'Copy-of-IMG_7066-scaled.jpg','position'=>'center 60%','duration'=>4000,'eyebrow'=>'Beyond the Walls','headline'=>'Serving Our Community','sub'=>'Outreach · Mission · Impact','cta'=>null],
        ['image'=>$_reel_base.'Copy-of-IMG_4997-scaled.jpg','position'=>'center 25%','duration'=>4000,'eyebrow'=>'Every Sunday at 9:00 AM','headline'=>'What to Expect','sub'=>'Worship · Word · Prayer · Fellowship','cta'=>null],
        ['image'=>$_reel_base.'Copy-of-IMG_5427-scaled.jpg','position'=>'center center','duration'=>5000,'eyebrow'=>"We'd Love to Meet You",'headline'=>'Your Story Starts Here','sub'=>'','cta'=>['label'=>"Let's Stay Connected &rarr;",'url'=>'#plan-visit']],
    ];
}
?>

<section class="reel-slideshow" aria-label="Welcome to The Praise House — visual story">

    <!-- Story-style progress bars -->
    <div class="reel-progress" aria-hidden="true">
        <?php foreach ( $reel_scenes as $i => $_ ) : ?>
            <div class="reel-progress__bar">
                <div class="reel-progress__fill"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Scenes -->
    <?php foreach ( $reel_scenes as $i => $scene ) : ?>
    <div class="reel-scene<?php echo $i === 0 ? ' reel-scene--active' : ''; ?>"
         data-duration="<?php echo (int) $scene['duration']; ?>"
         aria-hidden="<?php echo $i === 0 ? 'false' : 'true'; ?>">

        <div class="reel-scene__bg"
             style="background-image:url('<?php echo esc_url( $scene['image'] ); ?>');
                    background-position:<?php echo esc_attr( $scene['position'] ); ?>;"></div>
        <div class="reel-scene__overlay"></div>

        <div class="reel-scene__content">
            <?php if ( $scene['eyebrow'] ) : ?>
                <span class="reel-scene__eyebrow"><?php echo esc_html( $scene['eyebrow'] ); ?></span>
            <?php endif; ?>

            <h2 class="reel-scene__headline"><?php echo esc_html( $scene['headline'] ); ?></h2>

            <?php if ( $scene['sub'] ) : ?>
                <p class="reel-scene__sub"><?php echo esc_html( $scene['sub'] ); ?></p>
            <?php endif; ?>

            <?php if ( $scene['cta'] ) : ?>
                <div class="reel-scene__cta-wrap">
                    <a href="<?php echo esc_url($scene['cta']['url']); ?>" class="btn btn-primary btn-lg">
                        <?php echo esc_html($scene['cta']['label']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>

</section>

<script>
(function () {
    var container = document.querySelector('.reel-slideshow');
    if (!container) return;

    var scenes  = container.querySelectorAll('.reel-scene');
    var fills   = container.querySelectorAll('.reel-progress__fill');
    var current = 0;
    var timer   = null;

    function showScene(idx) {
        clearTimeout(timer);

        scenes.forEach(function (scene, i) {
            var active = (i === idx);
            scene.classList.toggle('reel-scene--active', active);
            scene.setAttribute('aria-hidden', active ? 'false' : 'true');

            if (active) {
                var bg = scene.querySelector('.reel-scene__bg');
                bg.style.animation = 'none';
                void bg.offsetWidth; // force reflow to restart keyframe
                bg.style.animation = '';
            }
        });

        fills.forEach(function (fill, i) {
            fill.style.animation = 'none';
            void fill.offsetWidth;
            if (i < idx) {
                fill.style.cssText = 'width:100%;';
            } else if (i === idx) {
                var dur = scenes[idx].dataset.duration;
                fill.style.cssText = 'animation:reelProgress ' + dur + 'ms linear forwards;';
            } else {
                fill.style.cssText = 'width:0%;';
            }
        });

        var dur = parseInt(scenes[idx].dataset.duration, 10);
        timer = setTimeout(function () {
            current = (current + 1) % scenes.length;
            showScene(current);
        }, dur);
    }

    showScene(0);
})();
</script>
