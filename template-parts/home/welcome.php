<?php
$pastor_name    = get_field('pastor_name',            get_the_ID()) ?: 'Pastor Diipo Omopariola';
$pastor_title   = get_field('pastor_title',           get_the_ID()) ?: 'Senior Pastor';
$pastor_message = get_field('pastor_welcome_message', get_the_ID());
$pastor_photo   = get_field('pastor_photo',           get_the_ID());
$pastor_video   = get_field('pastor_video_url',       get_the_ID());
?>

<section class="welcome-section section section--lg">
    <div class="container">
        <div class="welcome-grid">

            <div class="welcome-media fade-in-up">
                <div class="welcome-photo<?php echo !$pastor_photo ? ' welcome-photo--placeholder' : ''; ?>">
                    <?php if ($pastor_photo): ?>
                        <img src="<?php echo esc_url($pastor_photo['url']); ?>"
                             alt="<?php echo esc_attr($pastor_photo['alt'] ?: $pastor_name); ?>"
                             loading="lazy">
                    <?php else: ?>
                        <img src="<?php echo esc_url(content_url('uploads/2026/07/98b40655-376d-4fbf-800c-b78229d0d1a9.jpeg')); ?>"
                             alt="<?php echo esc_attr($pastor_name); ?>"
                             loading="lazy">
                    <?php endif; ?>
                </div>
                <div class="welcome-tag">
                    <div class="welcome-tag__name"><?php echo esc_html($pastor_name); ?></div>
                    <div class="welcome-tag__title"><?php echo esc_html($pastor_title); ?></div>
                </div>
            </div>

            <div class="welcome-content fade-in-up">
                <div class="section-header" style="text-align:left;">
                    <span class="section-header__eyebrow">A Word From Our Pastor</span>
                    <h2 class="section-header__title">Welcome to<br>The Praise House</h2>
                    <div class="section-divider" style="margin-left:0;"></div>
                </div>

                <?php if ($pastor_message): ?>
                    <div class="welcome-message">
                        <?php echo wp_kses_post($pastor_message); ?>
                    </div>
                <?php else: ?>
                    <p>We are so glad you are here. RCCG The Praise House Baltimore is a family built on love, faith, and purpose. Whether you are exploring faith for the first time or looking for a place to call home, you belong with us.</p>
                    <p>Our vision is simple: to help you <strong>BElong</strong> to God's family, <strong>BElieve</strong> in the transforming power of Christ, and <strong>BEcome</strong> everything God has called you to be.</p>
                    <p>We would love to have you join us this Sunday.</p>
                <?php endif; ?>

                <div class="welcome-actions" style="display:flex;gap:1rem;margin-top:1.75rem;flex-wrap:wrap;align-items:center;">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('new-here')) ?: home_url('/new-here/')); ?>" class="btn btn-primary">
                        I'm New Here
                    </a>
                    <?php if ($pastor_video): ?>
                    <button class="welcome-video-btn" id="welcomeVideoBtn" data-video="<?php echo esc_attr(tphb_get_youtube_id($pastor_video)); ?>">
                        <span class="welcome-video-btn__icon">&#9654;</span>
                        Watch Welcome Video
                    </button>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<?php if ($pastor_video): ?>
<div class="live-modal" id="welcomeModal" role="dialog" aria-modal="true" aria-label="Welcome Video">
    <div class="live-modal__inner">
        <div class="live-modal__header">
            <span>Welcome from <?php echo esc_html($pastor_name); ?></span>
            <button class="live-modal__close" id="welcomeModalClose" aria-label="Close">&times;</button>
        </div>
        <div class="live-modal__frame">
            <iframe id="welcomeIframe" frameborder="0" allowfullscreen allow="autoplay; encrypted-media" title="Welcome Video"></iframe>
        </div>
    </div>
</div>
<script>
(function(){
    var btn   = document.getElementById('welcomeVideoBtn');
    var modal = document.getElementById('welcomeModal');
    var frame = document.getElementById('welcomeIframe');
    var close = document.getElementById('welcomeModalClose');
    if(!btn||!modal) return;
    var vid   = btn.dataset.video;
    btn.addEventListener('click', function(){
        frame.src = 'https://www.youtube.com/embed/'+vid+'?autoplay=1&rel=0';
        modal.classList.add('open');
        document.body.style.overflow='hidden';
    });
    function closeModal(){
        modal.classList.remove('open');
        frame.src='';
        document.body.style.overflow='';
    }
    if(close) close.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e){ if(e.target===modal) closeModal(); });
})();
</script>
<?php endif; ?>
