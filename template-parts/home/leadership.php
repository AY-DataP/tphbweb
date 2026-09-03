<?php
$_lead_photo = tphb_option('pastor_photo');
$_co_photo   = tphb_option('pastor_co_photo');

$pastors = [
    [
        'name'     => 'Pastor Diipo Omopariola',
        'title'    => 'Senior Pastor & Lead',
        'bio'      => 'Visionary founder and shepherd of The Praise House family — leading with faith, purpose, and an unwavering passion for raising true worshippers in Spirit and Truth.',
        'initials' => 'DO',
        'photo'    => is_array($_lead_photo) ? ($_lead_photo['url'] ?? '') : '',
    ],
    [
        'name'     => 'Pastor Abidemi Omopariola',
        'title'    => 'Co-Pastor',
        'bio'      => 'A pillar of grace, wisdom, and pastoral care — nurturing the church family with love, strength, and an unshakeable faith in God\'s promises.',
        'initials' => 'AO',
        'photo'    => is_array($_co_photo) ? ($_co_photo['url'] ?? '') : '',
    ],
];

$_acf_team = tphb_option('ministry_team');
if (!empty($_acf_team)) {
    $ministers = array_map(function ($row) {
        $img = $row['minister_photo'] ?? null;
        return [
            'name'     => $row['minister_name']     ?? '',
            'role'     => (!empty($row['minister_ministry']) ? $row['minister_ministry'] : ($row['minister_role'] ?? '')),
            'initials' => $row['minister_initials'] ?? '',
            'photo'    => is_array($img) ? ($img['url'] ?? '') : (string) $img,
        ];
    }, $_acf_team);
} else {
    $ministers = [
        ['name'=>'Minister','role'=>'Sunday School',        'initials'=>'SS','photo'=>''],
        ['name'=>'Minister','role'=>'Youth Ministry',       'initials'=>'YM','photo'=>''],
        ['name'=>'Minister','role'=>"Children's Ministry",  'initials'=>'CM','photo'=>''],
        ['name'=>'Minister','role'=>'Media & Technology',   'initials'=>'MT','photo'=>''],
        ['name'=>'Minister','role'=>'Worship & Music',      'initials'=>'WM','photo'=>''],
        ['name'=>'Minister','role'=>'Evangelism',           'initials'=>'EV','photo'=>''],
        ['name'=>'Minister','role'=>'Welfare & Care',       'initials'=>'WC','photo'=>''],
        ['name'=>'Minister','role'=>"Women's Fellowship",   'initials'=>'WF','photo'=>''],
        ['name'=>'Minister','role'=>"Men's Fellowship",     'initials'=>'MF','photo'=>''],
        ['name'=>'Minister','role'=>'Prayer & Intercession','initials'=>'PI','photo'=>''],
        ['name'=>'Minister','role'=>'Ushering & Protocol',  'initials'=>'UP','photo'=>''],
        ['name'=>'Minister','role'=>'Finance & Stewardship','initials'=>'FS','photo'=>''],
    ];
}
?>

<section class="home-leadership section" aria-labelledby="leadership-heading">
    <div class="container">

        <div class="section-header fade-in-up">
            <span class="section-header__eyebrow">Servant Leaders</span>
            <h2 class="section-header__title" id="leadership-heading">Our Leadership</h2>
            <p class="section-header__subtitle">Led by vision, fueled by purpose, and guided by grace.</p>
            <div class="section-divider"></div>
        </div>

        <!-- ── Tier 1: Pastors ── -->
        <div class="pastor-cards">
            <?php foreach ($pastors as $p): ?>
            <div class="pastor-card fade-in-up">
                <div class="pastor-card__photo">
                    <?php if ($p['photo']): ?>
                        <img src="<?php echo esc_url($p['photo']); ?>" alt="<?php echo esc_attr($p['name']); ?>" loading="lazy">
                    <?php else: ?>
                        <span><?php echo esc_html($p['initials']); ?></span>
                    <?php endif; ?>
                </div>
                <div class="pastor-card__name"><?php echo esc_html($p['name']); ?></div>
                <div class="pastor-card__title"><?php echo esc_html($p['title']); ?></div>
                <p class="pastor-card__bio"><?php echo esc_html($p['bio']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ── Tier 2: Ministers ── -->
        <div class="ministers-divider fade-in-up">
            <span class="ministers-divider__label">Ministry Team</span>
        </div>

        <div class="ministers-grid">
            <?php foreach ($ministers as $m): ?>
            <div class="minister-card fade-in-up">
                <div class="minister-card__avatar">
                    <?php if (!empty($m['photo'])): ?>
                        <img src="<?php echo esc_url($m['photo']); ?>" alt="<?php echo esc_attr($m['name']); ?>" loading="lazy">
                    <?php else: ?>
                        <span><?php echo esc_html($m['initials']); ?></span>
                    <?php endif; ?>
                </div>
                <div class="minister-card__name"><?php echo esc_html($m['name']); ?></div>
                <div class="minister-card__role"><?php echo esc_html($m['role']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
