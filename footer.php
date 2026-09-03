<footer class="site-footer">
    <div class="footer-top">
        <div class="container footer-grid">

            <div class="footer-col footer-brand">
                <div class="footer-logo">
                    <span class="footer-logo__name">The Praise House</span>
                    <span class="footer-logo__city">Baltimore</span>
                </div>
                <p class="footer-tagline">BElong. BElieve. BEcome.</p>
                <p class="footer-desc">A newbreed church committed to raising true worshippers in Spirit and Truth.</p>
                <div class="footer-social">
                    <?php
                    $socials = [
                        'youtube'   => ['url' => tphb_option('youtube_url',   'https://www.youtube.com/@rccgtphb/videos'),                                                          'label' => 'YouTube'],
                        'facebook'  => ['url' => tphb_option('facebook_url',  'https://www.facebook.com/Rccgthepraisehousebaltimore/'),                                          'label' => 'Facebook'],
                        'instagram' => ['url' => tphb_option('instagram_url', 'https://www.instagram.com/rccgtphb?utm_source=qr&igsh=Y2hibmd0OTczeDJn'), 'label' => 'Instagram'],
                        'whatsapp'  => ['url' => tphb_option('whatsapp_url'),  'label' => 'WhatsApp'],
                    ];
                    foreach ($socials as $key => $s):
                        if (empty($s['url'])) continue;
                    ?>
                    <a href="<?php echo esc_url($s['url']); ?>" target="_blank" rel="noopener noreferrer"
                       class="footer-social__link footer-social__link--<?php echo esc_attr($key); ?>"
                       aria-label="<?php echo esc_attr($s['label']); ?>">
                        <?php echo tphb_social_icon($key); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="footer-col">
                <h4 class="footer-col__title">Our Social</h4>
                <ul class="footer-nav" style="list-style:none;padding:0;margin:0;">
                    <?php
                    $footer_socials = [
                        'youtube'   => ['label' => 'YouTube',   'url' => tphb_option('youtube_url',   'https://www.youtube.com/@rccgtphb/videos')],
                        'instagram' => ['label' => 'Instagram', 'url' => tphb_option('instagram_url', 'https://www.instagram.com/rccgtphb?utm_source=qr&igsh=Y2hibmd0OTczeDJn')],
                        'facebook'  => ['label' => 'Facebook',  'url' => tphb_option('facebook_url',  'https://www.facebook.com/Rccgthepraisehousebaltimore/')],
                    ];
                    foreach ($footer_socials as $key => $s): ?>
                    <li>
                        <a href="<?php echo esc_url($s['url']); ?>" target="_blank" rel="noopener noreferrer"
                           style="display:flex;align-items:center;gap:0.5rem;">
                            <span style="width:15px;height:15px;flex-shrink:0;display:flex;align-items:center;">
                                <?php echo tphb_social_icon($key); ?>
                            </span>
                            <?php echo esc_html($s['label']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col__title">Service Times</h4>
                <ul class="footer-services">
                    <li>
                        <span class="footer-services__icon">&#9829;</span>
                        <?php echo esc_html(tphb_option('sunday_service_time', 'Sundays at 9:00am (In-Person & Online)')); ?>
                    </li>
                    <li>
                        <span class="footer-services__icon">&#9829;</span>
                        <?php echo esc_html(tphb_option('wednesday_service_time', 'Wednesdays at 7:00pm (Online Only)')); ?>
                    </li>
                    <?php $zoom = tphb_option('zoom_id'); if ($zoom):
                        $zoom_link = 'https://zoom.us/j/' . preg_replace('/[^0-9]/', '', $zoom);
                    ?>
                    <li class="footer-services__zoom">
                        <a href="<?php echo esc_url($zoom_link); ?>" target="_blank" rel="noopener noreferrer">
                            &#128247; Join on Zoom <span style="font-weight:400;">(ID: <?php echo esc_html($zoom); ?>)</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-col__title">Contact Us</h4>
                <address class="footer-address">
                    <?php $addr = tphb_option('site_address', "806 Reisterstown Rd\nPikesville, MD 21208, USA"); if ($addr): ?>
                    <p><?php echo nl2br(esc_html($addr)); ?></p>
                    <?php endif; ?>
                    <?php $phone = tphb_option('site_phone', '+1 (682) 228-7808'); if ($phone): ?>
                    <p><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/','',$phone)); ?>"><?php echo esc_html($phone); ?></a></p>
                    <?php endif; ?>
                    <?php $email = tphb_option('site_email', 'info@rccgthepraisehouse.org'); if ($email): ?>
                    <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                    <?php endif; ?>
                </address>
                <?php
                $give_page = get_page_by_path('give');
                $give_url  = $give_page ? get_permalink($give_page->ID) : '#';
                ?>
                <a href="<?php echo esc_url($give_url); ?>" class="btn btn-outline-light footer-give-btn">Give / Donate</a>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container footer-bottom__inner">
            <p class="footer-copyright">
                &copy; <?php echo esc_html(wp_date('Y')); ?> RCCG The Praise House Baltimore. All Rights Reserved.
            </p>
            <p class="footer-verse">"For God so loved the world…" — John 3:16</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
