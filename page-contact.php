<?php
/*
 * Template Name: Contact
 */
get_header();

$phone         = tphb_option('site_phone',    '+1 (682) 228-7808');
$email         = tphb_option('site_email',    'info@rccgthepraisehouse.org');
$address       = tphb_option('site_address',  "806 Reisterstown Rd\nPikesville, MD 21208, USA");
$sunday        = tphb_option('sunday_service_time',    'Sundays at 9:00am (In-Person & Online)');
$wed           = tphb_option('wednesday_service_time', 'Wednesdays at 7:00pm (Online Only)');
$zoom          = tphb_option('zoom_id');
$map_query     = $address ? urlencode(str_replace("\n", ' ', $address)) : '';
$directions_url = $address ? 'https://www.google.com/maps/dir/?api=1&destination=' . $map_query : '';
$address_plain  = $address ? str_replace("\n", ', ', $address) : '';
?>

<main id="main" class="site-main">

    <?php get_template_part('template-parts/contact/hero'); ?>

    <?php if ($address): ?>
    <!-- Map embed — immediately after hero -->
    <div class="contact-map">
        <iframe
            src="https://maps.google.com/maps?q=<?php echo esc_attr($map_query); ?>&output=embed"
            width="100%"
            height="420"
            style="border:0;display:block;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="RCCG The Praise House Baltimore — Map">
        </iframe>
    </div>
    <?php endif; ?>

    <!-- Contact Content -->
    <section class="contact-section section section--lg">
        <div class="container">
            <div class="contact-grid">

                <!-- Contact Info -->
                <div class="contact-info fade-in-up">
                    <h2 style="margin-bottom:1.75rem;">Get In Touch</h2>

                    <?php if ($address): ?>
                    <div class="contact-info__item">
                        <div class="contact-info__icon" aria-hidden="true">&#128205;</div>
                        <div>
                            <div class="contact-info__label">Location</div>
                            <div class="contact-info__value"><?php echo nl2br(esc_html($address)); ?></div>
                            <div style="display:flex;gap:0.6rem;margin-top:0.75rem;flex-wrap:wrap;">
                                <a href="<?php echo esc_url($directions_url); ?>" target="_blank" rel="noopener noreferrer"
                                   class="btn btn-secondary" style="font-size:0.78rem;padding:0.4rem 1rem;">
                                    &#x2197; Get Directions
                                </a>
                                <button type="button" id="copyAddrBtn" onclick="tphbCopyAddress()"
                                        class="btn btn-outline" style="font-size:0.78rem;padding:0.4rem 1rem;">
                                    &#10697; Copy Address
                                </button>
                            </div>
                        </div>
                    </div>
                    <script>
                    function tphbCopyAddress() {
                        var addr = <?php echo json_encode($address_plain); ?>;
                        var btn  = document.getElementById('copyAddrBtn');
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(addr).then(function() {
                                btn.textContent = '✓ Copied!';
                                setTimeout(function(){ btn.textContent = '⎘ Copy Address'; }, 2000);
                            });
                        } else {
                            var ta = document.createElement('textarea');
                            ta.value = addr; document.body.appendChild(ta);
                            ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
                            btn.textContent = '✓ Copied!';
                            setTimeout(function(){ btn.textContent = '⎘ Copy Address'; }, 2000);
                        }
                    }
                    </script>
                    <?php endif; ?>

                    <?php if ($phone): ?>
                    <div class="contact-info__item">
                        <div class="contact-info__icon" aria-hidden="true">&#128222;</div>
                        <div>
                            <div class="contact-info__label">Phone</div>
                            <div class="contact-info__value">
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($email): ?>
                    <div class="contact-info__item">
                        <div class="contact-info__icon" aria-hidden="true">&#9993;</div>
                        <div>
                            <div class="contact-info__label">Email</div>
                            <div class="contact-info__value">
                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="contact-info__item">
                        <div class="contact-info__icon" aria-hidden="true">&#9829;</div>
                        <div>
                            <div class="contact-info__label">Service Times</div>
                            <div class="contact-info__value">
                                <p><?php echo esc_html($sunday); ?></p>
                                <p><?php echo esc_html($wed); ?></p>
                                <?php if ($zoom):
                                    $zoom_join = 'https://zoom.us/j/' . preg_replace('/[^0-9]/', '', $zoom);
                                ?>
                                    <p style="font-size:0.83rem;margin-top:0.25rem;">
                                        <a href="<?php echo esc_url($zoom_join); ?>" target="_blank" rel="noopener noreferrer">
                                            &#128247; Join on Zoom
                                        </a>
                                        <span style="color:var(--gray);"> &mdash; ID: <?php echo esc_html($zoom); ?></span>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="contact-info__item">
                        <div class="contact-info__icon" aria-hidden="true">&#128279;</div>
                        <div>
                            <div class="contact-info__label">Follow Us</div>
                            <div class="contact-social-icons">
                                <?php
                                $follow_platforms = [
                                    'youtube'   => ['label' => 'YouTube',   'url' => tphb_option('youtube_url',   'https://www.youtube.com/@rccgtphb/videos'),                                                          'color' => '#FF0000'],
                                    'instagram' => ['label' => 'Instagram', 'url' => tphb_option('instagram_url', 'https://www.instagram.com/rccgtphb?utm_source=qr&igsh=Y2hibmd0OTczeDJn'), 'color' => '#E1306C'],
                                    'facebook'  => ['label' => 'Facebook',  'url' => tphb_option('facebook_url',  'https://www.facebook.com/Rccgthepraisehousebaltimore/'),                                          'color' => '#1877F2'],
                                ];
                                foreach ($follow_platforms as $key => $p):
                                    $href = !empty($p['url']) ? esc_url($p['url']) : '#';
                                ?>
                                <a href="<?php echo $href; ?>"
                                   <?php if (!empty($p['url'])): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                                   class="contact-social-btn"
                                   style="--social-color:<?php echo esc_attr($p['color']); ?>;"
                                   aria-label="Follow us on <?php echo esc_attr($p['label']); ?>">
                                    <span class="contact-social-btn__icon"><?php echo tphb_social_icon($key); ?></span>
                                    <span class="contact-social-btn__name"><?php echo esc_html($p['label']); ?></span>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Prayer Request CTA -->
                    <div style="margin-top:2rem;padding:1.75rem;background:var(--blue-pale);border-radius:var(--radius-lg);border-left:4px solid var(--blue);">
                        <h4 style="color:var(--navy);margin-bottom:0.5rem;">&#128591; Need Prayer?</h4>
                        <p style="font-size:0.875rem;margin-bottom:1rem;">Submit a prayer request and our team will be praying with you.</p>
                        <a href="<?php echo esc_url(home_url('/#prayer-request')); ?>" class="btn btn-secondary" style="font-size:0.85rem;padding:0.6rem 1.4rem;">Submit Prayer Request</a>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-box fade-in-up">
                    <h3 style="margin-bottom:0.5rem;color:var(--navy);">Send Us a Message</h3>
                    <p style="color:var(--gray);margin-bottom:1.75rem;font-size:0.9rem;">Fill in the form below and we will get back to you as soon as possible.</p>

                    <form id="contactForm" novalidate>
                        <input type="hidden" name="form_source" value="Contact Us">
                        <div class="form-group">
                            <label for="contact_name">Full Name *</label>
                            <input type="text" id="contact_name" name="contact_name" placeholder="Your full name" required autocomplete="name">
                        </div>
                        <div class="form-group">
                            <label for="contact_email">Email Address *</label>
                            <input type="email" id="contact_email" name="contact_email" placeholder="your@email.com" required autocomplete="email">
                        </div>
                        <div class="form-group">
                            <label for="contact_subject">Subject</label>
                            <input type="text" id="contact_subject" name="contact_subject" placeholder="What is this about?">
                        </div>
                        <div class="form-group">
                            <label for="contact_message">Message *</label>
                            <textarea id="contact_message" name="contact_message" placeholder="How can we help you?" required rows="6"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">Send Message</button>
                        <div class="form-message" role="alert" aria-live="polite"></div>
                    </form>
                </div>

            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>
