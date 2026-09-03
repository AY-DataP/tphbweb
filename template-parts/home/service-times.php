<?php
$sunday    = tphb_option('sunday_service_time',    'Sundays at 9:00am (In-Person & Online)');
$wednesday = tphb_option('wednesday_service_time', 'Wednesdays at 7:00pm (Online Only)');
$zoom_id   = tphb_option('zoom_id');
$address   = tphb_option('site_address',            "806 Reisterstown Rd\nPikesville, MD 21208");
$phone     = tphb_option('site_phone',              '+1 (682) 228-7808');
$email     = tphb_option('site_email',              'info@rccgthepraisehouse.org');
?>

<section class="service-section" id="service-times">
    <div class="container">
        <div class="section-header fade-in-up">
            <span class="section-header__eyebrow">Join Us</span>
            <h2 class="section-header__title">Service Times &amp; Location</h2>
            <p class="section-header__subtitle">All are welcome. Come as you are — grace is waiting.</p>
            <div class="section-divider"></div>
        </div>

        <div class="service-grid">
            <div class="service-card fade-in-up">
                <div class="service-card__icon">&#9729;</div>
                <span class="service-card__day">Sunday</span>
                <div class="service-card__time">9:00 AM</div>
                <p class="service-card__note">In-Person &amp; Online<br>Join us at our physical location or stream live on YouTube.</p>
                <?php if ($address): ?>
                    <p class="service-card__zoom" style="font-size:0.8rem;margin-top:0.5rem;color:var(--gray);">
                        &#128205; <?php echo esc_html(str_replace("\n", ', ', $address)); ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="service-card fade-in-up">
                <div class="service-card__icon">&#128247;</div>
                <span class="service-card__day">Wednesday</span>
                <div class="service-card__time">7:00 PM</div>
                <p class="service-card__note">Online Only<br>Midweek service streamed live — join from anywhere in the world.</p>
                <?php if ($zoom_id):
                    $zoom_link = 'https://zoom.us/j/' . preg_replace('/[^0-9]/', '', $zoom_id);
                ?>
                    <p class="service-card__zoom">
                        <a href="<?php echo esc_url($zoom_link); ?>" target="_blank" rel="noopener noreferrer">
                            &#128247; Join on Zoom <span style="font-weight:400;font-size:0.8em;">(ID: <?php echo esc_html($zoom_id); ?>)</span>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <div class="service-card fade-in-up">
                <div class="service-card__icon">&#128205;</div>
                <span class="service-card__day">Find Us</span>
                <div class="service-card__time" style="font-size:1rem;">Pikesville, MD</div>
                <p class="service-card__note">
                    <?php echo nl2br(esc_html($address)); ?>
                </p>
                <div style="display:flex;flex-direction:column;gap:0.35rem;margin-top:0.75rem;">
                    <?php if ($phone): ?>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/','', $phone)); ?>" style="font-size:0.85rem;color:var(--navy);font-weight:600;">
                            &#128222; <?php echo esc_html($phone); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($email): ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" style="font-size:0.85rem;color:var(--blue);">
                            &#9993; <?php echo esc_html($email); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
