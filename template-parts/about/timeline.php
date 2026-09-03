<?php
$_acf_milestones = get_field('timeline_items');
$_base = content_url('/uploads/2026/06/');

if (!empty($_acf_milestones)) {
    $milestones = array_map(function ($row) {
        $img = $row['timeline_image'];
        return [
            'date'  => $row['timeline_date'],
            'title' => $row['timeline_title'],
            'desc'  => $row['timeline_desc'],
            'image' => is_array($img) ? ($img['url'] ?? '') : (string) $img,
            'icon'  => $row['timeline_icon'] ?? '',
        ];
    }, $_acf_milestones);
} else {
    $milestones = [
        ['date'=>'May 5, 2021',  'title'=>'Founded',                  'desc'=>'The Praise House held its very first service with a clear mandate — to raise a generation of true worshippers in Spirit and Truth.','image'=>'','icon'=>'🏛️'],
        ['date'=>'Late 2021',    'title'=>'First Community Outreach',  'desc'=>'Taking the love of God beyond the church walls — our first outreach planted seeds of hope across the Pikesville community.','image'=>$_base.'Copy-of-IMG_7066-scaled.jpg','icon'=>''],
        ['date'=>'2022',         'title'=>'New Ministries Launched',   'desc'=>'Sunday School, Youth Ministry, Children\'s Ministry, and more — a growing family building purpose-driven community.','image'=>'','icon'=>'🌱'],
        ['date'=>'2023',         'title'=>'2nd Anniversary',           'desc'=>'Celebrating two years of God\'s faithfulness — a milestone marked with worship, gratitude, and renewed vision.','image'=>$_base.'Copy-of-IMG_8791-scaled.jpg','icon'=>''],
        ['date'=>'2024',         'title'=>'Expanding Impact',          'desc'=>'Deeper roots, wider reach — serving more families across the community through consistent outreach and ministry growth.','image'=>$_base.'Copy-of-IMG_6674-scaled.jpg','icon'=>''],
        ['date'=>'Today',        'title'=>'Still Growing',             'desc'=>'A thriving, diverse, multigenerational family — still worshipping, still serving, still becoming.','image'=>$_base.'Copy-of-IMG_5427-scaled.jpg','icon'=>''],
    ];
}
?>

<section class="about-timeline section" aria-labelledby="timeline-heading">
    <div class="container">

        <div class="section-header fade-in-up">
            <span class="section-header__eyebrow">How We Got Here</span>
            <h2 class="section-header__title" id="timeline-heading">Our Journey</h2>
            <p class="section-header__subtitle">From a first gathering of faith to a thriving church family — every step has been guided by purpose.</p>
            <div class="section-divider"></div>
        </div>

        <div class="timeline-scroll-wrap">
            <div class="timeline-track">

                <?php foreach ($milestones as $i => $m) : ?>
                <div class="timeline-item fade-in-up <?php echo ($i % 2 === 0) ? 'timeline-item--above' : 'timeline-item--below'; ?>">

                    <div class="timeline-item__card">
                        <?php if ($m['image']) : ?>
                            <div class="timeline-item__thumb">
                                <img src="<?php echo esc_url($m['image']); ?>" alt="<?php echo esc_attr($m['title']); ?>" loading="lazy">
                            </div>
                        <?php elseif ($m['icon']) : ?>
                            <div class="timeline-item__icon"><?php echo $m['icon']; ?></div>
                        <?php endif; ?>
                        <div class="timeline-item__body">
                            <span class="timeline-item__date"><?php echo esc_html($m['date']); ?></span>
                            <h3 class="timeline-item__title"><?php echo esc_html($m['title']); ?></h3>
                            <p class="timeline-item__desc"><?php echo esc_html($m['desc']); ?></p>
                        </div>
                    </div>

                    <div class="timeline-item__connector">
                        <div class="timeline-item__dot"></div>
                    </div>

                </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
</section>
