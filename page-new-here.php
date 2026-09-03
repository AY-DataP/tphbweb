<?php
/*
 * Template Name: New Here
 */
get_header();
?>

<main id="main" class="site-main">

    <!-- Reel Slideshow Hero -->
    <?php get_template_part('template-parts/new-here/reel-slideshow'); ?>

    <!-- Intro -->
    <section class="new-here-intro section">
        <div class="container container--narrow" style="text-align:center;">
            <span class="section-header__eyebrow fade-in-up">A Little About Us</span>
            <h2 class="fade-in-up" style="margin-bottom:1.25rem;">We Are The Praise House</h2>
            <div class="section-divider fade-in-up" style="margin-bottom:2rem;"></div>
            <p class="fade-in-up" style="font-size:1.05rem;line-height:1.85;">RCCG The Praise House Baltimore is a <strong>newbreed church</strong> in Pikesville, Maryland — a place where people from all walks of life come together to worship, grow, and make an impact. We are not your typical church. We are a family — vibrant, modern, and deeply rooted in the truth of God's Word.</p>
            <p class="fade-in-up">Our vision is captured in three words: <strong>BElong. BElieve. BEcome.</strong> — and we mean it for every single person who walks through our doors.</p>
        </div>
    </section>

    <!-- Q&A Section -->
    <section class="new-here-qa section">
        <div class="container container--narrow">
            <div class="section-header fade-in-up">
                <span class="section-header__eyebrow">Frequently Asked</span>
                <h2 class="section-header__title">Questions You Might Be Asking</h2>
                <div class="section-divider"></div>
            </div>

            <div class="qa-list">
                <div class="qa-item fade-in-up">
                    <div class="qa-item__icon" aria-hidden="true">&#128205;</div>
                    <div>
                        <h3 class="qa-item__question">Is this church for me?</h3>
                        <div class="qa-item__answer">
                            <p>Absolutely — yes. The Praise House is for everyone. Whether you are exploring faith for the first time, returning after a long break, or simply looking for a new church home, you are welcome here. We are a diverse, multigenerational community that celebrates every person.</p>
                        </div>
                    </div>
                </div>

                <div class="qa-item fade-in-up">
                    <div class="qa-item__icon" aria-hidden="true">&#127916;</div>
                    <div>
                        <h3 class="qa-item__question">What should I expect on Sunday?</h3>
                        <div class="qa-item__answer">
                            <p>Our Sunday service starts at <strong>9:00am</strong> and runs approximately 90 minutes to 2 hours. You can expect:</p>
                            <p>&#127925; <strong>Praise &amp; Worship</strong> — Spirit-filled, contemporary worship music<br>
                            &#128214; <strong>The Word</strong> — Relevant, practical Bible-based teaching<br>
                            &#128101; <strong>Community</strong> — A warm, welcoming atmosphere where you will feel at home</p>
                            <p>Dress comfortably — there is no dress code. Come as you are.</p>
                        </div>
                    </div>
                </div>

                <div class="qa-item fade-in-up">
                    <div class="qa-item__icon" aria-hidden="true">&#128100;</div>
                    <div>
                        <h3 class="qa-item__question">Who leads the church?</h3>
                        <div class="qa-item__answer">
                            <p>The Praise House is led by <strong>Pastor Diipo Omopariola</strong> (Senior Pastor) and <strong>Pastor Abidemi Omopariola</strong> (Co-Pastor). Together, they lead a passionate team of ministry heads and volunteers committed to serving you and the community.</p>
                        </div>
                    </div>
                </div>

                <div class="qa-item fade-in-up">
                    <div class="qa-item__icon" aria-hidden="true">&#128101;</div>
                    <div>
                        <h3 class="qa-item__question">Are there programs for children &amp; youth?</h3>
                        <div class="qa-item__answer">
                            <p>Yes! We have a dedicated <strong>Children's Ministry</strong> that runs during the Sunday service, providing a safe, fun, and faith-building environment for your little ones. We also have programs for young adults and teens — check our events page for the latest.</p>
                        </div>
                    </div>
                </div>

                <div class="qa-item fade-in-up">
                    <div class="qa-item__icon" aria-hidden="true">&#128247;</div>
                    <div>
                        <h3 class="qa-item__question">Can I join online?</h3>
                        <div class="qa-item__answer">
                            <p>Absolutely. We stream every Sunday service live on <strong>YouTube</strong> and host our Wednesday midweek service exclusively online via <strong>Zoom</strong>.</p>
                            <?php
                            $nh_zoom = tphb_option('zoom_id', '999 599 0340');
                            $nh_zoom_link = 'https://zoom.us/j/' . preg_replace('/[^0-9]/', '', $nh_zoom);
                            ?>
                            <p>Sunday at 9:00am — Live on YouTube<br>
                            Wednesday at 7:00pm — <a href="<?php echo esc_url($nh_zoom_link); ?>" target="_blank" rel="noopener noreferrer">Join on Zoom</a> (ID: <?php echo esc_html($nh_zoom); ?>)</p>
                        </div>
                    </div>
                </div>

                <div class="qa-item fade-in-up">
                    <div class="qa-item__icon" aria-hidden="true">&#10084;</div>
                    <div>
                        <h3 class="qa-item__question">What do you believe?</h3>
                        <div class="qa-item__answer">
                            <p>We believe in the Holy Trinity — Father, Son, and Holy Spirit. We believe the Bible is the inspired Word of God, that Jesus Christ is Lord and Savior, and that every person is loved, purposed, and destined for greatness in God.</p>
                            <p>We believe in <strong>holiness as a lifestyle</strong>, not just a Sunday experience — and in the power of community to transform individuals and neighborhoods.</p>
                        </div>
                    </div>
                </div>

                <div class="qa-item fade-in-up">
                    <div class="qa-item__icon" aria-hidden="true">&#128663;</div>
                    <div>
                        <h3 class="qa-item__question">I need help getting to church — can you help?</h3>
                        <div class="qa-item__answer">
                            <p>We do not want transportation to be a barrier. Please reach out to us directly and we will do our best to connect you with someone who can help.</p>
                            <p>
                                &#128222; <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', tphb_option('site_phone', '+16822287808'))); ?>" style="color:var(--blue);font-weight:600;"><?php echo esc_html(tphb_option('site_phone', '+1 (682) 228-7808')); ?></a><br>
                                &#9993; <a href="mailto:<?php echo esc_attr(tphb_option('site_email', 'info@rccgthepraisehouse.org')); ?>" style="color:var(--blue);font-weight:600;"><?php echo esc_html(tphb_option('site_email', 'info@rccgthepraisehouse.org')); ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Plan a Visit Form -->
    <?php get_template_part('template-parts/new-here/visit-form'); ?>

    <!-- Next Steps -->
    <section class="next-steps section section--lg">
        <div class="container">
            <div class="section-header fade-in-up" style="color:var(--white);">
                <span class="section-header__eyebrow" style="color:rgba(200,230,245,0.7);">Ready to Take the Next Step?</span>
                <h2 class="section-header__title" style="color:var(--white);">Here is How to Connect</h2>
                <div class="section-divider"></div>
            </div>

            <div class="steps-grid">
                <div class="step-card fade-in-up">
                    <div class="step-card__num">01</div>
                    <h3 class="step-card__title">Visit Us</h3>
                    <p class="step-card__desc">Join us this Sunday at 9:00am. <?php echo esc_html(tphb_option('site_address', '806 Reisterstown Rd, Pikesville, MD 21208')); ?></p>
                </div>
                <div class="step-card fade-in-up">
                    <div class="step-card__num">02</div>
                    <h3 class="step-card__title">Say Hello</h3>
                    <p class="step-card__desc">After service, introduce yourself to our Welcome Team — they are easy to spot and always happy to meet you.</p>
                </div>
                <div class="step-card fade-in-up">
                    <div class="step-card__num">03</div>
                    <h3 class="step-card__title">Get Connected</h3>
                    <p class="step-card__desc">Join a ministry team, attend a Bible study, or follow us on social media to stay in the loop.</p>
                </div>
            </div>

            <div style="text-align:center;margin-top:3rem;" class="fade-in-up">
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) ?: home_url('/contact/')); ?>" class="btn btn-outline-white btn-lg">Contact Us</a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
