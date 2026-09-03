<?php
/*
 * Template Name: About Us
 */
get_header();
?>

<main id="main" class="site-main">

    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container page-hero__content">
            <span class="page-hero__eyebrow">Our Story</span>
            <h1>About The Praise House</h1>
            <p>A newbreed church rooted in love, raised in faith, and reaching the world.</p>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                <span class="breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="current">About Us</span>
            </nav>
        </div>
    </div>

    <?php get_template_part('template-parts/wwr-subnav'); ?>

    <!-- About Story -->
    <section class="about-story section section--lg">
        <div class="container">
            <div class="about-story-grid">
                <div class="about-story-img fade-in-up">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large', ['loading' => 'lazy']); ?>
                    <?php else: ?>
                        <img src="<?php echo esc_url(content_url('uploads/2026/06/973e370c-cf55-4477-b34b-65ab89c5bfa1.jpeg')); ?>" alt="RCCG The Praise House Baltimore" loading="lazy" style="width:100%;height:100%;object-fit:cover;border-radius:var(--radius-lg);" />
                    <?php endif; ?>
                </div>
                <div class="fade-in-up">
                    <span class="section-header__eyebrow" style="display:inline-block;margin-bottom:0.75rem;">Who We Are</span>
                    <h2 style="margin-bottom:1.25rem;">RCCG The Praise House Baltimore</h2>
                    <div class="section-divider" style="margin:0 0 1.75rem;"></div>
                    <?php
                    $had_content = false;
                    if (have_posts()): while (have_posts()): the_post();
                        if (get_the_content()) { $had_content = true; }
                    ?>
                        <div class="entry-content"><?php the_content(); ?></div>
                    <?php endwhile; endif; ?>

                    <?php if (!$had_content): ?>
                    <p>Founded on <strong>May 5, 2021</strong>, RCCG The Praise House Baltimore held its first service with a clear mandate: to raise a movement of true worshippers in Spirit and Truth. What began as a small, faith-filled gathering in Pikesville, Maryland, has grown into a vibrant family of believers committed to impacting their community and the world.</p>
                    <p>We are a proud part of the <strong>Redeemed Christian Church of God</strong> (RCCG) worldwide network — carrying the global mission while remaining deeply rooted in our local community.</p>
                    <p>At The Praise House, you will find a welcoming home where your story matters, your faith is strengthened, and your purpose is discovered.</p>
                    <div style="display:flex;gap:1rem;margin-top:2rem;flex-wrap:wrap;">
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('new-here')) ?: home_url('/new-here/')); ?>" class="btn btn-primary">I'm New Here</a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) ?: home_url('/contact/')); ?>" class="btn btn-outline">Contact Us</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Values -->
    <section class="values-section section">
        <div class="container">
            <div class="section-header fade-in-up">
                <span class="section-header__eyebrow">What Drives Us</span>
                <h2 class="section-header__title">Mission &amp; Core Values</h2>
                <p class="section-header__subtitle">Everything we do is guided by these foundational values.</p>
                <div class="section-divider"></div>
            </div>

            <div style="max-width:760px;margin:0 auto 3.5rem;text-align:center;" class="fade-in-up">
                <h3 style="color:var(--navy);margin-bottom:1rem;">Our Mission</h3>
                <p style="font-size:1.05rem;">To make heaven and to take as many people as possible with us — nurturing Spirit, Soul, and Body through transformative messages of truth, love, and grace.</p>
                <blockquote style="border-left:4px solid var(--blue);padding:1rem 1.5rem;background:var(--blue-pale);border-radius:0 var(--radius) var(--radius) 0;margin-top:1.5rem;font-style:italic;color:var(--navy);">
                    "Go therefore and make disciples of all nations…" — Matthew 28:19
                </blockquote>
            </div>

            <div class="values-grid">
                <?php
                $values = [
                    ['icon'=>'❤️',  'name'=>'Love'],
                    ['icon'=>'✝️',  'name'=>'Faith'],
                    ['icon'=>'👨‍👩‍👧‍👦','name'=>'Family'],
                    ['icon'=>'⭐',  'name'=>'Excellence'],
                    ['icon'=>'🤝',  'name'=>'Relationship'],
                    ['icon'=>'🛡️',  'name'=>'Integrity'],
                    ['icon'=>'💎',  'name'=>'Honesty'],
                    ['icon'=>'🙏',  'name'=>'Respect'],
                ];
                foreach ($values as $value): ?>
                <div class="value-card fade-in-up">
                    <div class="value-card__icon"><?php echo $value['icon']; ?></div>
                    <div class="value-card__name"><?php echo esc_html($value['name']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- RCCG Heritage -->
    <section class="rccg-heritage section section--lg">
        <div class="container">

            <div class="section-header fade-in-up">
                <span class="section-header__eyebrow">Our Heritage</span>
                <h2 class="section-header__title">Rooted in a Global Movement</h2>
                <p class="section-header__subtitle">The Praise House Baltimore is a proud <a href="https://rccgnewbreed.com/about/" target="_blank" rel="noopener noreferrer" style="color:var(--blue-muted);text-decoration:underline;text-underline-offset:3px;">New Breed</a> parish of the Redeemed Christian Church of God — one of the fastest-growing church networks in the world, led by Pastor E.A. Adeboye.</p>
                <div class="section-divider"></div>
            </div>

            <!-- Vision & Mission -->
            <div class="rccg-vm-grid fade-in-up">
                <div class="rccg-vm-card">
                    <div class="rccg-vm-card__icon">&#128065;</div>
                    <h3 class="rccg-vm-card__title">RCCG Vision</h3>
                    <ul class="rccg-vm-list">
                        <li>To make heaven.</li>
                        <li>To take as many people with us.</li>
                        <li>To have a member of RCCG in every family of all nations.</li>
                    </ul>
                </div>
                <div class="rccg-vm-card">
                    <div class="rccg-vm-card__icon">&#127919;</div>
                    <h3 class="rccg-vm-card__title">RCCG Mission</h3>
                    <ul class="rccg-vm-list">
                        <li>Holiness will be our lifestyle as we pursue the vision.</li>
                        <li>Plant churches within five minutes' walking distance in every city of developing countries, and five minutes' driving distance in developed countries.</li>
                        <li>Pursue these objectives until every nation in the world is reached for the Lord Jesus Christ.</li>
                    </ul>
                </div>
            </div>

            <!-- New Breed -->
            <div class="rccg-newbreed fade-in-up">
                <div class="rccg-newbreed__badge">New Breed</div>
                <h3 class="rccg-newbreed__title">About RCCG New Breed</h3>
                <p>In May 2017, in New York City, General Overseer Pastor E.A. Adeboye shared a God-given vision for the New Breed Churches — a mandate to raise multi-cultural, multi-racial, Spirit-filled congregations that would cater for a young, upwardly mobile generation. Young men began arriving from Africa in 2017, fulfilling that vision.</p>
                <p>The RCCG New Breed arm exists to plant dynamic churches that minister to the next generation within the faith and values of the RCCG. Currently, there are nine New Breed parishes across Maine, Maryland, Atlanta, New Jersey, Florida, Washington, California, and Texas — coordinated under the leadership of Pastor Daniel Ajayi-Adeniran and Pastor James Fadel.</p>
                <p><strong>The Praise House Baltimore is one of these New Breed parishes</strong> — carrying this mandate right here in the heart of Maryland.</p>
            </div>

            <!-- Links -->
            <div class="rccg-links fade-in-up">
                <a href="https://www.rccghq.org/" target="_blank" rel="noopener noreferrer" class="rccg-link-card">
                    <div class="rccg-link-card__icon">&#127758;</div>
                    <div>
                        <div class="rccg-link-card__label">Parent Church</div>
                        <div class="rccg-link-card__name">Redeemed Christian Church of God</div>
                        <div class="rccg-link-card__url">rccghq.org &#8599;</div>
                    </div>
                </a>
                <a href="https://rccgnewbreed.com/about/" target="_blank" rel="noopener noreferrer" class="rccg-link-card">
                    <div class="rccg-link-card__icon">&#9889;</div>
                    <div>
                        <div class="rccg-link-card__label">Our Network</div>
                        <div class="rccg-link-card__name">RCCG New Breed Churches</div>
                        <div class="rccg-link-card__url">rccgnewbreed.com &#8599;</div>
                    </div>
                </a>
            </div>

        </div>
    </section>

    <!-- Leadership -->
    <section class="leadership-section section">
        <div class="container">
            <div class="section-header fade-in-up">
                <span class="section-header__eyebrow">Servant Leaders</span>
                <h2 class="section-header__title">Our Leadership</h2>
                <p class="section-header__subtitle">Led by vision, fueled by purpose, guided by grace.</p>
                <div class="section-divider"></div>
            </div>

            <!-- Senior Pastors -->
            <?php
            $_lead_acf  = get_field('about_senior_pastor_photo');
            $_co_acf    = get_field('about_co_pastor_photo');
            $_lead_bio  = get_field('about_senior_pastor_bio') ?: 'Visionary leader and shepherd of The Praise House family.';
            $_co_bio    = get_field('about_co_pastor_bio')     ?: 'A pillar of grace, wisdom, and unwavering support to the church family.';
            $_lead_photo_url = is_array($_lead_acf) ? ($_lead_acf['url'] ?? '') : $_lead_acf;
            $_co_photo_url   = is_array($_co_acf)   ? ($_co_acf['url']   ?? '') : $_co_acf;
            if (!$_lead_photo_url) $_lead_photo_url = content_url('uploads/2026/07/4fb0b9e2-c4ff-446d-bad8-8a924f02d47f.jpeg');
            if (!$_co_photo_url)   $_co_photo_url   = content_url('uploads/2026/07/99a35d97-a005-47b7-9502-d5ded3d1a4d8.jpeg');
            ?>
            <div class="pastors-grid">
                <div class="leader-card leader-card--featured fade-in-up">
                    <div class="leader-photo" style="border-color:rgba(255,255,255,0.3);">
                        <img src="<?php echo esc_url($_lead_photo_url); ?>" alt="Pastor Diipo Omopariola" loading="lazy" style="width:100%;height:100%;object-fit:cover;object-position:top;">
                    </div>
                    <div class="leader-name" style="color:var(--white);">Pastor Diipo Omopariola</div>
                    <div class="leader-title">Senior Pastor</div>
                    <p style="font-size:0.83rem;color:rgba(255,255,255,0.6);margin-top:0.75rem;line-height:1.6;"><?php echo esc_html($_lead_bio); ?></p>
                </div>
                <div class="leader-card fade-in-up">
                    <div class="leader-photo">
                        <img src="<?php echo esc_url($_co_photo_url); ?>" alt="Pastor Abidemi Omopariola" loading="lazy" style="width:100%;height:100%;object-fit:cover;object-position:top;">
                    </div>
                    <div class="leader-name">Pastor Abidemi Omopariola</div>
                    <div class="leader-title">Co-Pastor</div>
                    <p style="font-size:0.83rem;color:rgba(255,255,255,0.75);margin-top:0.75rem;line-height:1.6;"><?php echo esc_html($_co_bio); ?></p>
                </div>
            </div>

            <!-- Ministry Team -->
            <div class="ministry-team-header fade-in-up">
                <h3>Ministry Team</h3>
                <p>Department leaders serving faithfully across every area of church life.</p>
            </div>

            <div class="ministry-grid">
                <?php
                $_acf_team = tphb_option('ministry_team');
                $u = content_url('uploads');
                if (!empty($_acf_team)) {
                    $ministries = array_map(function ($row) {
                        $img = $row['minister_photo'] ?? null;
                        return [
                            'name'     => $row['minister_name']     ?? '',
                            'ministry' => $row['minister_ministry'] ?? '',
                            'role'     => $row['minister_role']     ?? 'Minister-in-Charge',
                            'image'    => is_array($img) ? ($img['url'] ?? '') : (string) $img,
                            'initials' => $row['minister_initials'] ?? '',
                        ];
                    }, $_acf_team);
                } else {
                    $ministries = [
                        ['name'=>'Mr Akin Akin-Babalola',       'ministry'=>'Special Duties & Projects','role'=>'Minister-in-Charge','image'=>$u.'/2026/07/61e5e4bf-3726-4e60-a505-8a822da963c6.jpeg','initials'=>'AA'],
                        ['name'=>'Pastor Wale Ilemobola',        'ministry'=>'Evangelism',               'role'=>'Minister-in-Charge','image'=>$u.'/2026/07/Pastor-Wale-scaled.jpg','initials'=>'WI'],
                        ['name'=>'Pastor Mrs Bukola Akin-Babalola','ministry'=>'Leaders & Workers',      'role'=>'Minister-in-Charge','image'=>$u.'/2026/07/Mrs-Babalola-1-scaled.jpg','initials'=>'BA'],
                        ['name'=>'Pastor Moses Joseph',          'ministry'=>'Sunday School',            'role'=>'Minister-in-Charge','image'=>$u.'/2026/07/Pastor-Moses-Joseph-Sunday-School-scaled.jpg','initials'=>'MJ'],
                        ['name'=>'Mrs Yetunde Ilemobola',        'ministry'=>'Follow-Up',                'role'=>'Minister-in-Charge','image'=>$u.'/2026/07/9cb4b2ed-47fd-4403-a25c-34458dc097f6.jpeg','initials'=>'YI'],
                        ['name'=>'Mr Ope Fasoro',                'ministry'=>'Youth & Teenagers',        'role'=>'Minister-in-Charge','image'=>$u.'/2026/07/05a46dfd-a630-4d5d-b96f-cd2e515fa692-scaled.jpeg','initials'=>'OF'],
                        ['name'=>'Mr Elisha Oduro',              'ministry'=>'Prayers',                  'role'=>'Minister-in-Charge','image'=>$u.'/2026/07/Elisha-1-scaled.jpg','initials'=>'EO'],
                        ['name'=>'Mr Temitayo Sewanu Ajose',     'ministry'=>'Ushering',                 'role'=>'Minister-in-Charge','image'=>$u.'/2026/07/eb0becf6-a5f8-4781-b6e3-b41ac6cec9fd.jpeg','initials'=>'TA'],
                        ['name'=>'Mr Peter Olatunji',            'ministry'=>'Choir',                    'role'=>'Minister-in-Charge','image'=>$u.'/2026/07/Bro-Peter-Olatunji-Choir-1-scaled.jpg','initials'=>'PO'],
                        ['name'=>'Mrs Tunmise Fosoro',           'ministry'=>'Media & Publicity',        'role'=>'Minister-in-Charge','image'=>'','initials'=>'TF'],
                    ];
                }
                foreach ($ministries as $m):
                    $has_data = !empty($m['name']);
                ?>
                <div class="ministry-card fade-in-up <?php echo $has_data ? '' : 'ministry-card--placeholder'; ?>">
                    <div class="ministry-photo">
                        <?php if ($has_data && !empty($m['image'])): ?>
                            <img src="<?php echo esc_url($m['image']); ?>" alt="<?php echo esc_attr($m['name']); ?>" loading="lazy" />
                        <?php else: ?>
                            <div class="ministry-photo__initials"><?php echo esc_html($m['initials'] ?: '?'); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if ($has_data): ?>
                        <div class="ministry-card__ministry"><?php echo esc_html($m['ministry']); ?></div>
                        <div class="ministry-card__name"><?php echo esc_html($m['name']); ?></div>
                        <div class="ministry-card__role"><?php echo esc_html($m['role']); ?></div>
                    <?php else: ?>
                        <div class="ministry-card__ministry">Coming Soon</div>
                        <div class="ministry-card__name">&nbsp;</div>
                        <div class="ministry-card__role">&nbsp;</div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>
