<?php
defined('ABSPATH') || exit;

// ─── Theme Setup ──────────────────────────────────────────────────────────────
function tphb_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
    add_theme_support('custom-logo', ['height'=>80,'width'=>200,'flex-height'=>true,'flex-width'=>true]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('wp-block-styles');

    register_nav_menus([
        'primary' => __('Primary Menu', 'tphb'),
        'footer'  => __('Footer Menu', 'tphb'),
    ]);

    load_theme_textdomain('tphb', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'tphb_setup');

// ─── Enqueue Scripts & Styles ─────────────────────────────────────────────────
function tphb_scripts() {
    wp_enqueue_style('tphb-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Poppins:wght@300;400;500;600;700&display=swap',
        [], null
    );
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0.0');
    wp_enqueue_style('tphb-main', get_template_directory_uri() . '/assets/css/main.css', ['tphb-google-fonts','swiper-css'], filemtime(get_template_directory() . '/assets/css/main.css'));

    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.0', true);
    wp_enqueue_script('tphb-main', get_template_directory_uri() . '/assets/js/main.js', ['swiper-js'], filemtime(get_template_directory() . '/assets/js/main.js'), true);

    wp_localize_script('tphb-main', 'tphbData', [
        'ajaxUrl'   => admin_url('admin-ajax.php'),
        'restUrl'   => rest_url('tphb/v1/'),
        'nonce'     => wp_create_nonce('tphb_nonce'),
        'restNonce' => wp_create_nonce('wp_rest'),
        'siteUrl'   => get_site_url(),
    ]);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'tphb_scripts');

// ─── Custom Post Types ────────────────────────────────────────────────────────
function tphb_register_cpts() {

    $cpts = [
        'sermon' => [
            'name'       => 'Sermons',
            'singular'   => 'Sermon',
            'slug'       => 'sermon',
            'icon'       => 'dashicons-book-alt',
            'supports'   => ['title','editor','thumbnail','excerpt'],
        ],
        'reflection' => [
            'name'       => 'Reflections',
            'singular'   => 'Reflection',
            'slug'       => 'reflections',
            'icon'       => 'dashicons-format-quote',
            'supports'   => ['title','editor','thumbnail','excerpt'],
        ],
        'tphb_event' => [
            'name'       => 'Events',
            'singular'   => 'Event',
            'slug'       => 'events',
            'icon'       => 'dashicons-calendar-alt',
            'supports'   => ['title','editor','thumbnail','excerpt'],
        ],
        'tphb_outreach' => [
            'name'       => 'Outreach Posts',
            'singular'   => 'Outreach Post',
            'slug'       => 'outreach',
            'icon'       => 'dashicons-groups',
            'supports'   => ['title','editor','thumbnail','excerpt'],
        ],
        'testimonial' => [
            'name'       => 'Testimonials',
            'singular'   => 'Testimonial',
            'slug'       => 'testimonials',
            'icon'       => 'dashicons-format-status',
            'supports'   => ['title','thumbnail'],
            'public'     => false,
        ],
        'hero_slide' => [
            'name'       => 'Hero Slides',
            'singular'   => 'Hero Slide',
            'slug'       => 'hero-slides',
            'icon'       => 'dashicons-slides',
            'supports'   => ['title','thumbnail'],
            'public'     => false,
        ],
        'prayer_request' => [
            'name'       => 'Prayer Requests',
            'singular'   => 'Prayer Request',
            'slug'       => 'prayer-requests',
            'icon'       => 'dashicons-heart',
            'supports'   => ['title','editor'],
            'public'     => false,
            'no_create'  => true,
        ],
    ];

    foreach ($cpts as $type => $args) {
        $capabilities = [];
        if (!empty($args['no_create'])) {
            $capabilities = ['create_posts' => 'do_not_allow'];
        }

        register_post_type($type, [
            'labels' => [
                'name'          => $args['name'],
                'singular_name' => $args['singular'],
                'add_new'       => 'Add New ' . $args['singular'],
                'add_new_item'  => 'Add New ' . $args['singular'],
                'edit_item'     => 'Edit ' . $args['singular'],
                'view_item'     => 'View ' . $args['singular'],
                'search_items'  => 'Search ' . $args['name'],
                'not_found'     => 'No ' . strtolower($args['name']) . ' found.',
            ],
            'public'             => $args['public'] ?? true,
            'show_ui'            => true,
            'show_in_nav_menus'  => true,
            'has_archive'        => $args['public'] ?? true,
            'menu_icon'          => $args['icon'],
            'supports'           => $args['supports'],
            'rewrite'            => ['slug' => $args['slug']],
            'show_in_rest'       => true,
            'map_meta_cap'       => true,
            'capability_type'    => 'post',
            'capabilities'       => $capabilities,
        ]);
    }
}
add_action('init', 'tphb_register_cpts');

// ─── Custom Taxonomies ────────────────────────────────────────────────────────
function tphb_register_taxonomies() {
    register_taxonomy('sermon_series', 'sermon', [
        'labels'       => ['name'=>'Sermon Series','singular_name'=>'Series'],
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => ['slug'=>'sermon-series'],
    ]);
    register_taxonomy('reflection_type', 'reflection', [
        'labels'       => ['name'=>'Reflection Types','singular_name'=>'Type'],
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug'=>'reflection-type'],
    ]);
    register_taxonomy('outreach_type', 'tphb_outreach', [
        'labels'       => ['name'=>'Outreach Types','singular_name'=>'Type'],
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug'=>'outreach-type'],
    ]);
}
add_action('init', 'tphb_register_taxonomies');

// ─── ACF Options Page ─────────────────────────────────────────────────────────
add_action('acf/init', function () {
    if (!function_exists('acf_add_options_page')) return;
    acf_add_options_page([
        'page_title' => 'TPHB Site Settings',
        'menu_title' => 'Site Settings',
        'menu_slug'  => 'tphb-settings',
        'capability' => 'manage_options',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-site-alt3',
    ]);
});

// ─── ACF Field Groups ─────────────────────────────────────────────────────────
add_action('acf/init', 'tphb_register_acf_fields');
function tphb_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) return;

    // SITE OPTIONS
    acf_add_local_field_group([
        'key'    => 'group_site_options',
        'title'  => 'Site Options',
        'fields' => [
            ['key'=>'field_site_phone',    'label'=>'Phone Number',            'name'=>'site_phone',            'type'=>'text'],
            ['key'=>'field_site_email',    'label'=>'Public Email Address',    'name'=>'site_email',            'type'=>'email', 'instructions'=>'Shown in the footer and contact page'],
            // ── Form notification recipients ──
            ['key'=>'field_email_contact_page','label'=>'Contact Page — Notification Email', 'name'=>'email_contact_page','type'=>'email','default_value'=>'info@rccgthepraisehouse.org','instructions'=>'Receives messages submitted via the Contact page form'],
            ['key'=>'field_email_contact_home','label'=>'Homepage Contact — Notification Email','name'=>'email_contact_home','type'=>'email','default_value'=>'info@rccgthepraisehouse.org','instructions'=>'Receives messages submitted via the homepage "Get in Touch" form'],
            ['key'=>'field_email_prayer',     'label'=>'Prayer Request — Notification Email', 'name'=>'email_prayer_form', 'type'=>'email','default_value'=>'info@rccgthepraisehouse.org','instructions'=>'Receives prayer requests submitted from the homepage'],
            ['key'=>'field_email_visit',      'label'=>'Plan a Visit — Notification Email',   'name'=>'email_visit_form',  'type'=>'email','default_value'=>'info@rccgthepraisehouse.org','instructions'=>'Receives plan-a-visit forms submitted from the New Here page'],
            ['key'=>'field_site_address',  'label'=>'Address',                 'name'=>'site_address',          'type'=>'textarea','rows'=>3],
            ['key'=>'field_sunday_svc',    'label'=>'Sunday Service Time',     'name'=>'sunday_service_time',   'type'=>'text','default_value'=>'Sundays at 9:00am (In-Person & Online)'],
            ['key'=>'field_wednesday_svc', 'label'=>'Wednesday Service Time',  'name'=>'wednesday_service_time','type'=>'text','default_value'=>'Wednesdays at 7:00pm (Online Only)'],
            ['key'=>'field_zoom_id',       'label'=>'Zoom Meeting ID',         'name'=>'zoom_id',               'type'=>'text'],
            ['key'=>'field_facebook_url',  'label'=>'Facebook URL',            'name'=>'facebook_url',          'type'=>'url'],
            ['key'=>'field_instagram_url', 'label'=>'Instagram URL',           'name'=>'instagram_url',         'type'=>'url'],
            ['key'=>'field_youtube_url',   'label'=>'YouTube Channel URL',     'name'=>'youtube_url',           'type'=>'url'],
            ['key'=>'field_whatsapp_url',  'label'=>'WhatsApp URL',            'name'=>'whatsapp_url',          'type'=>'url'],
            ['key'=>'field_yt_channel_id',        'label'=>'YouTube Channel ID (for Live detection)', 'name'=>'youtube_channel_id',        'type'=>'text','instructions'=>'Find this in your YouTube Studio URL'],
            ['key'=>'field_yt_api_key',            'label'=>'YouTube API Key',                         'name'=>'youtube_api_key',           'type'=>'text','instructions'=>'Create at console.cloud.google.com'],
            ['key'=>'field_about_hero_video_url',  'label'=>'About Page Hero Video URL',               'name'=>'about_hero_video_url',      'type'=>'url','instructions'=>'Looping background video on the About page'],
            ['key'=>'field_wwr_hero_video_url',    'label'=>'Who We Are Hero Video URL',               'name'=>'wwr_hero_video_url',        'type'=>'url','instructions'=>'Looping background video on the Who We Are page'],
            ['key'=>'field_sermon_archive_hero_bg','label'=>'Sermons Archive Hero Background',         'name'=>'sermon_archive_hero_bg',    'type'=>'image','return_format'=>'array','preview_size'=>'medium','instructions'=>'Background image for the Sermons page header'],
        ],
        'location' => [[['param'=>'options_page','operator'=>'==','value'=>'tphb-settings']]],
    ]);

    // LEADERSHIP & MINISTRY TEAM (options page — used on homepage and about page)
    acf_add_local_field_group([
        'key'    => 'group_leadership',
        'title'  => 'Leadership & Ministry Team',
        'fields' => [
            ['key'=>'field_ministry_team','label'=>'Ministry Team','name'=>'ministry_team','type'=>'repeater',
             'button_label'=>'Add Team Member','layout'=>'table',
             'sub_fields'=>[
                 ['key'=>'field_mt_name',     'label'=>'Name',               'name'=>'minister_name',     'type'=>'text','required'=>1],
                 ['key'=>'field_mt_ministry', 'label'=>'Ministry Department','name'=>'minister_ministry', 'type'=>'text'],
                 ['key'=>'field_mt_role',     'label'=>'Role',               'name'=>'minister_role',     'type'=>'text','default_value'=>'Minister-in-Charge'],
                 ['key'=>'field_mt_photo',    'label'=>'Photo',              'name'=>'minister_photo',    'type'=>'image','return_format'=>'array','preview_size'=>'thumbnail'],
                 ['key'=>'field_mt_initials', 'label'=>'Initials (if no photo)','name'=>'minister_initials','type'=>'text'],
             ]],
        ],
        'location' => [[['param'=>'options_page','operator'=>'==','value'=>'tphb-settings']]],
    ]);

    // HOME PAGE
    acf_add_local_field_group([
        'key'    => 'group_home_settings',
        'title'  => 'Home Page Settings',
        'fields' => [
            ['key'=>'field_pastor_name',     'label'=>'Pastor Name',         'name'=>'pastor_name',           'type'=>'text','default_value'=>'Pastor Diipo Omopariola'],
            ['key'=>'field_pastor_title',    'label'=>'Pastor Title',        'name'=>'pastor_title',          'type'=>'text','default_value'=>'Senior Pastor'],
            ['key'=>'field_pastor_welcome',  'label'=>'Welcome Message',     'name'=>'pastor_welcome_message','type'=>'wysiwyg'],
            ['key'=>'field_pastor_photo',    'label'=>'Lead Pastor Photo',   'name'=>'pastor_photo',          'type'=>'image','return_format'=>'array','preview_size'=>'medium'],
            ['key'=>'field_pastor_co_photo', 'label'=>'Co-Pastor Photo',     'name'=>'pastor_co_photo',       'type'=>'image','return_format'=>'array','preview_size'=>'medium'],
            ['key'=>'field_pastor_video',    'label'=>'Welcome Video URL',   'name'=>'pastor_video_url',      'type'=>'url','instructions'=>'Optional YouTube URL for video welcome'],
            ['key'=>'field_mission_title',   'label'=>'Mission Section Title','name'=>'mission_title',        'type'=>'text','default_value'=>'Our Mission'],
            ['key'=>'field_mission_text',    'label'=>'Mission Text',        'name'=>'mission_text',          'type'=>'wysiwyg'],
            ['key'=>'field_mission_scripture','label'=>'Mission Scripture',  'name'=>'mission_scripture',     'type'=>'text','instructions'=>'E.g., Matthew 28:19'],
            ['key'=>'field_mission_scripture_text','label'=>'Scripture Text','name'=>'mission_scripture_text','type'=>'textarea','rows'=>2],
        ],
        'location' => [[['param'=>'page_type','operator'=>'==','value'=>'front_page']]],
    ]);

    // HERO SLIDE
    acf_add_local_field_group([
        'key'    => 'group_hero_slide',
        'title'  => 'Hero Slide Settings',
        'fields' => [
            ['key'=>'field_slide_type',      'label'=>'Slide Type',        'name'=>'slide_type',      'type'=>'radio','choices'=>['image'=>'Image','video_bg'=>'Video Background'],'default_value'=>'image','layout'=>'horizontal'],
            ['key'=>'field_slide_image',     'label'=>'Background Image',  'name'=>'slide_image',     'type'=>'image','return_format'=>'array','preview_size'=>'large'],
            ['key'=>'field_slide_video_url', 'label'=>'Background Video URL','name'=>'slide_video_url','type'=>'url'],
            ['key'=>'field_slide_heading',   'label'=>'Heading',           'name'=>'slide_heading',   'type'=>'text'],
            ['key'=>'field_slide_subheading','label'=>'Subheading',        'name'=>'slide_subheading','type'=>'textarea','rows'=>2],
            ['key'=>'field_slide_cta_text',  'label'=>'CTA Button Text',   'name'=>'slide_cta_text',  'type'=>'text'],
            ['key'=>'field_slide_cta_url',   'label'=>'CTA Button URL',    'name'=>'slide_cta_url',   'type'=>'url'],
            ['key'=>'field_slide_cta2_text', 'label'=>'Secondary Button Text','name'=>'slide_cta2_text','type'=>'text'],
            ['key'=>'field_slide_cta2_url',  'label'=>'Secondary Button URL', 'name'=>'slide_cta2_url', 'type'=>'url'],
            ['key'=>'field_slide_overlay',   'label'=>'Overlay Intensity', 'name'=>'slide_overlay',   'type'=>'select','choices'=>['0.3'=>'Light (30%)','0.5'=>'Medium (50%)','0.7'=>'Dark (70%)','0.85'=>'Heavy (85%)'],'default_value'=>'0.6'],
            ['key'=>'field_slide_order',     'label'=>'Display Order',     'name'=>'slide_order',     'type'=>'number','default_value'=>10],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'hero_slide']]],
    ]);

    // SERMON
    acf_add_local_field_group([
        'key'    => 'group_sermon',
        'title'  => 'Sermon Details',
        'fields' => [
            ['key'=>'field_sermon_youtube',   'label'=>'YouTube Video URL',   'name'=>'sermon_youtube_url',  'type'=>'url'],
            ['key'=>'field_sermon_speaker',   'label'=>'Speaker',             'name'=>'sermon_speaker',      'type'=>'text','default_value'=>'Pastor Diipo Omopariola'],
            ['key'=>'field_sermon_date',      'label'=>'Sermon Date',         'name'=>'sermon_date',         'type'=>'date_picker','display_format'=>'F j, Y','return_format'=>'Y-m-d'],
            ['key'=>'field_sermon_scripture', 'label'=>'Scripture Reference', 'name'=>'sermon_scripture',    'type'=>'text','instructions'=>'E.g., John 3:16'],
            ['key'=>'field_sermon_series_name','label'=>'Series Name',        'name'=>'sermon_series_name',  'type'=>'text'],
            ['key'=>'field_sermon_duration',  'label'=>'Duration',            'name'=>'sermon_duration',     'type'=>'text','instructions'=>'E.g., 45 min'],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'sermon']]],
    ]);

    // REFLECTION
    acf_add_local_field_group([
        'key'    => 'group_reflection',
        'title'  => 'Reflection Details',
        'fields' => [
            ['key'=>'field_reflection_type',    'label'=>'Content Type',    'name'=>'reflection_type',    'type'=>'radio','choices'=>['text'=>'Text Only','video'=>'Video Only','both'=>'Video & Text'],'default_value'=>'text','layout'=>'horizontal'],
            ['key'=>'field_reflection_youtube', 'label'=>'YouTube URL',     'name'=>'reflection_youtube_url','type'=>'url'],
            ['key'=>'field_reflection_category','label'=>'Category',        'name'=>'reflection_category',  'type'=>'select','choices'=>['sermon-snippet'=>'Sermon Snippet','nights-of-mercy'=>'Nights of Mercy','devotional'=>'Devotional','other'=>'Other'],'default_value'=>'sermon-snippet'],
            ['key'=>'field_reflection_gallery', 'label'=>'Photo Gallery',   'name'=>'reflection_gallery',   'type'=>'gallery','return_format'=>'array','preview_size'=>'medium','instructions'=>'Upload photos related to this reflection.'],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'reflection']]],
    ]);

    // OUTREACH
    acf_add_local_field_group([
        'key'    => 'group_outreach',
        'title'  => 'Outreach Details',
        'fields' => [
            ['key'=>'field_outreach_event_date', 'label'=>'Event Date',    'name'=>'outreach_event_date', 'type'=>'date_picker','display_format'=>'F j, Y','return_format'=>'Y-m-d'],
            ['key'=>'field_outreach_location',   'label'=>'Location',      'name'=>'outreach_location',   'type'=>'text'],
            ['key'=>'field_outreach_program',    'label'=>'Program Type',  'name'=>'outreach_program_type','type'=>'text','instructions'=>'E.g., Jesus on the Streets, Young Adult Week'],
            ['key'=>'field_outreach_video',      'label'=>'Video URL',     'name'=>'outreach_video_url',  'type'=>'url','instructions'=>'Optional YouTube recap video'],
            ['key'=>'field_outreach_gallery',    'label'=>'Photo Gallery', 'name'=>'outreach_gallery',    'type'=>'gallery','return_format'=>'array','preview_size'=>'medium','instructions'=>'Upload photos from this outreach event.'],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'tphb_outreach']]],
    ]);

    // EVENT
    acf_add_local_field_group([
        'key'    => 'group_event',
        'title'  => 'Event Details',
        'fields' => [
            ['key'=>'field_event_date',        'label'=>'Event Date',       'name'=>'event_date',             'type'=>'date_picker','display_format'=>'F j, Y','return_format'=>'Y-m-d'],
            ['key'=>'field_event_time',        'label'=>'Event Time',       'name'=>'event_time',             'type'=>'time_picker','display_format'=>'g:i a','return_format'=>'H:i:s'],
            ['key'=>'field_event_end_date',    'label'=>'End Date',         'name'=>'event_end_date',         'type'=>'date_picker','display_format'=>'F j, Y','return_format'=>'Y-m-d','instructions'=>'Fill only for multi-day events'],
            ['key'=>'field_event_location',    'label'=>'Location',         'name'=>'event_location',         'type'=>'text'],
            ['key'=>'field_event_flyer',       'label'=>'Event Flyer',      'name'=>'event_flyer',            'type'=>'image','return_format'=>'array','preview_size'=>'medium'],
            ['key'=>'field_event_register_url','label'=>'Registration URL', 'name'=>'event_registration_url', 'type'=>'url','instructions'=>'Optional link to register or RSVP'],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'tphb_event']]],
    ]);

    // TESTIMONIAL
    acf_add_local_field_group([
        'key'    => 'group_testimonial',
        'title'  => 'Testimonial Details',
        'fields' => [
            ['key'=>'field_testimonial_type',   'label'=>'Type',          'name'=>'testimonial_type',        'type'=>'radio','choices'=>['text'=>'Text','video'=>'Video'],'default_value'=>'text','layout'=>'horizontal'],
            ['key'=>'field_testimonial_text',   'label'=>'Testimonial',   'name'=>'testimonial_text',        'type'=>'textarea','rows'=>5],
            ['key'=>'field_testimonial_video',  'label'=>'YouTube URL',   'name'=>'testimonial_video_url',   'type'=>'url'],
            ['key'=>'field_testimonial_author', 'label'=>'Author Name',   'name'=>'testimonial_author',      'type'=>'text'],
            ['key'=>'field_testimonial_role',   'label'=>'Author Role',   'name'=>'testimonial_author_role', 'type'=>'text','instructions'=>'E.g., Church Member, Youth Leader'],
            ['key'=>'field_testimonial_photo',  'label'=>'Author Photo',  'name'=>'testimonial_photo',       'type'=>'image','return_format'=>'array','preview_size'=>'thumbnail'],
        ],
        'location' => [[['param'=>'post_type','operator'=>'==','value'=>'testimonial']]],
    ]);

    // GALLERY PAGE
    acf_add_local_field_group([
        'key'    => 'group_gallery',
        'title'  => 'Gallery Images',
        'fields' => [
            ['key'=>'field_gallery_images','label'=>'Gallery Images','name'=>'gallery_images','type'=>'gallery','return_format'=>'array','preview_size'=>'medium','instructions'=>'Upload or select images for the gallery grid.'],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-gallery.php']]],
    ]);

    // GIVE PAGE
    acf_add_local_field_group([
        'key'    => 'group_give',
        'title'  => 'Give Page Settings',
        'fields' => [
            ['key'=>'field_give_intro',       'label'=>'Intro Text',              'name'=>'give_intro_text',    'type'=>'wysiwyg'],
            ['key'=>'field_cashapp_username', 'label'=>'Cash App Username',       'name'=>'cashapp_username',   'type'=>'text','instructions'=>'Include the $ sign, e.g., $PraiseHouseBmore'],
            ['key'=>'field_cashapp_qr',       'label'=>'Cash App QR Code',        'name'=>'cashapp_qr_image',   'type'=>'image','return_format'=>'array'],
            ['key'=>'field_zelle_contact',    'label'=>'Zelle Email or Phone',    'name'=>'zelle_contact',      'type'=>'text'],
            ['key'=>'field_zelle_qr',         'label'=>'Zelle QR Code',           'name'=>'zelle_qr_image',     'type'=>'image','return_format'=>'array'],
            ['key'=>'field_donate_url',       'label'=>'Online Donate Button URL','name'=>'donate_button_url',  'type'=>'url'],
            ['key'=>'field_donate_label',     'label'=>'Donate Button Label',     'name'=>'donate_button_label','type'=>'text','default_value'=>'Give Online Now'],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-give.php']]],
    ]);

    // ABOUT PAGE SETTINGS (pastor photos/bios and timeline)
    acf_add_local_field_group([
        'key'    => 'group_about_settings',
        'title'  => 'About Page Settings',
        'fields' => [
            ['key'=>'field_about_lead_photo', 'label'=>'Senior Pastor Photo', 'name'=>'about_senior_pastor_photo', 'type'=>'image', 'return_format'=>'array', 'preview_size'=>'medium'],
            ['key'=>'field_about_lead_bio',   'label'=>'Senior Pastor Bio',   'name'=>'about_senior_pastor_bio',   'type'=>'textarea', 'rows'=>3],
            ['key'=>'field_about_co_photo',   'label'=>'Co-Pastor Photo',     'name'=>'about_co_pastor_photo',     'type'=>'image', 'return_format'=>'array', 'preview_size'=>'medium'],
            ['key'=>'field_about_co_bio',     'label'=>'Co-Pastor Bio',       'name'=>'about_co_pastor_bio',       'type'=>'textarea', 'rows'=>3],
            ['key'=>'field_timeline_items',   'label'=>'Our Journey Timeline', 'name'=>'timeline_items', 'type'=>'repeater',
             'button_label'=>'Add Milestone', 'layout'=>'block',
             'sub_fields'=>[
                 ['key'=>'field_tl_date',  'label'=>'Date',                    'name'=>'timeline_date',  'type'=>'text'],
                 ['key'=>'field_tl_title', 'label'=>'Title',                   'name'=>'timeline_title', 'type'=>'text'],
                 ['key'=>'field_tl_desc',  'label'=>'Description',             'name'=>'timeline_desc',  'type'=>'textarea', 'rows'=>3],
                 ['key'=>'field_tl_image', 'label'=>'Photo',                   'name'=>'timeline_image', 'type'=>'image', 'return_format'=>'array', 'preview_size'=>'thumbnail'],
                 ['key'=>'field_tl_icon',  'label'=>'Icon emoji (if no photo)','name'=>'timeline_icon',  'type'=>'text'],
             ]],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-about.php']]],
    ]);

    // NEW HERE PAGE SETTINGS (welcome slideshow scenes)
    acf_add_local_field_group([
        'key'    => 'group_new_here_settings',
        'title'  => 'New Here — Welcome Slideshow',
        'fields' => [
            ['key'=>'field_reel_scenes', 'label'=>'Slideshow Scenes', 'name'=>'reel_scenes', 'type'=>'repeater',
             'button_label'=>'Add Scene', 'layout'=>'block', 'min'=>1, 'max'=>10,
             'sub_fields'=>[
                 ['key'=>'field_rs_image',    'label'=>'Background Image',  'name'=>'scene_image',    'type'=>'image', 'return_format'=>'array', 'preview_size'=>'medium', 'required'=>1],
                 ['key'=>'field_rs_eyebrow',  'label'=>'Eyebrow Text',      'name'=>'scene_eyebrow',  'type'=>'text'],
                 ['key'=>'field_rs_headline', 'label'=>'Headline',          'name'=>'scene_headline', 'type'=>'text'],
                 ['key'=>'field_rs_sub',      'label'=>'Subtext',           'name'=>'scene_sub',      'type'=>'text'],
                 ['key'=>'field_rs_cta_label','label'=>'CTA Button Label',  'name'=>'scene_cta_label','type'=>'text', 'instructions'=>'Leave blank for no button'],
                 ['key'=>'field_rs_cta_url',  'label'=>'CTA Button URL',    'name'=>'scene_cta_url',  'type'=>'url'],
                 ['key'=>'field_rs_duration', 'label'=>'Duration (ms)',     'name'=>'scene_duration', 'type'=>'number', 'default_value'=>4000],
             ]],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-new-here.php']]],
    ]);
}

// ─── Rate-limit helper ────────────────────────────────────────────────────────
// Allows $limit submissions per $window seconds per IP for a given $action.
// Calls wp_send_json_error() and exits if the limit is exceeded.
function tphb_rate_limit(string $action, int $limit = 3, int $window = 3600): void {
    $ip  = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $key = 'tphb_rl_' . md5($action . $ip);
    $count = (int) get_transient($key);
    if ($count >= $limit) {
        wp_send_json_error(['message' => 'Too many submissions. Please wait a while before trying again.'], 429);
    }
    set_transient($key, $count + 1, $window);
}

// ─── Prayer Request AJAX ──────────────────────────────────────────────────────
function tphb_handle_prayer_request() {
    check_ajax_referer('tphb_nonce', 'nonce');
    tphb_rate_limit('prayer_request');

    $name    = sanitize_text_field($_POST['prayer_name']    ?? '');
    $email   = sanitize_email($_POST['prayer_email']        ?? '');
    $request = sanitize_textarea_field($_POST['prayer_request'] ?? '');
    $private = !empty($_POST['prayer_private']);
    $source  = sanitize_text_field($_POST['form_source'] ?? 'Prayer Request');

    if (empty($name) || empty($request)) {
        wp_send_json_error(['message' => 'Please provide your name and prayer request.']);
    }

    $post_id = wp_insert_post([
        'post_type'    => 'prayer_request',
        'post_title'   => esc_html($name) . ' — ' . wp_date('Y-m-d H:i'),
        'post_content' => $request,
        'post_status'  => 'private',
        'meta_input'   => [
            '_prayer_email'   => $email,
            '_prayer_private' => $private ? '1' : '0',
            '_prayer_name'    => $name,
        ],
    ]);

    if (!$post_id || is_wp_error($post_id)) {
        wp_send_json_error(['message' => 'Sorry, there was a problem saving your request. Please try again.']);
    }

    $to      = tphb_option('email_prayer_form') ?: 'info@rccgthepraisehouse.org';
    $subject = "[{$source}] New Prayer Request from {$name}";
    $body    = "Form: {$source}\n" . str_repeat('─', 40) . "\nName: {$name}\nEmail: {$email}\n\nPrayer Request:\n{$request}\n\n" . ($private ? '(Marked as private)' : '');
    wp_mail($to, $subject, $body);

    wp_send_json_success(['message' => 'Your prayer request has been received. We are praying with you!']);
}
add_action('wp_ajax_tphb_prayer_request',        'tphb_handle_prayer_request');
add_action('wp_ajax_nopriv_tphb_prayer_request', 'tphb_handle_prayer_request');

// ─── Contact Form AJAX ────────────────────────────────────────────────────────
function tphb_handle_contact_form() {
    check_ajax_referer('tphb_nonce', 'nonce');
    tphb_rate_limit('contact_form');

    $name    = sanitize_text_field($_POST['contact_name']    ?? '');
    $email   = sanitize_email($_POST['contact_email']        ?? '');
    $subject = sanitize_text_field($_POST['contact_subject'] ?? '');
    $message = sanitize_textarea_field($_POST['contact_message'] ?? '');
    $source  = sanitize_text_field($_POST['form_source'] ?? 'Contact Us');

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => 'Please fill in all required fields.']);
    }
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Please provide a valid email address.']);
    }

    $email_field = ($source === 'Get in Touch') ? 'email_contact_home' : 'email_contact_page';
    $to          = tphb_option($email_field) ?: 'info@rccgthepraisehouse.org';
    $subject     = "[{$source}] " . ($subject ?: 'Message from ' . $name);
    $body    = "Form: {$source}\n" . str_repeat('─', 40) . "\nFrom: {$name} ({$email})\n\nMessage:\n{$message}";
    $headers = ['Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>'];

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Thank you! Your message has been sent. We will be in touch soon.']);
    } else {
        wp_send_json_error(['message' => 'Sorry, there was an error sending your message. Please try again or email us directly.']);
    }
}
add_action('wp_ajax_tphb_contact_form',        'tphb_handle_contact_form');
add_action('wp_ajax_nopriv_tphb_contact_form', 'tphb_handle_contact_form');

// ─── Plan a Visit / First-Time Visitor Form AJAX ─────────────────────────────
function tphb_handle_plan_visit() {
    check_ajax_referer('tphb_nonce', 'nonce');
    tphb_rate_limit('plan_visit');

    // Common fields
    $source     = sanitize_text_field($_POST['form_source']      ?? 'New Here');
    $type       = sanitize_text_field($_POST['visit_type']       ?? '');
    $first_name = sanitize_text_field($_POST['visit_first_name'] ?? '');
    $last_name  = sanitize_text_field($_POST['visit_last_name']  ?? '');
    $email      = sanitize_email($_POST['visit_email']           ?? '');
    $phone      = sanitize_text_field($_POST['visit_phone']      ?? '');
    $referral   = sanitize_text_field($_POST['visit_referral']   ?? '');
    $notes      = sanitize_textarea_field($_POST['visit_notes']  ?? '');

    // Group 1 — visited today
    $date_today = sanitize_text_field($_POST['visit_date_today'] ?? '');
    $came_with  = sanitize_text_field($_POST['visit_came_with']  ?? '');
    $followup   = !empty($_POST['visit_followup']);

    // Group 2 — planning to visit
    $planned_date = sanitize_text_field($_POST['visit_planned_date'] ?? '');
    $party        = sanitize_text_field($_POST['visit_party']        ?? '');
    $transport    = !empty($_POST['visit_transport']);

    if (empty($type) || empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($referral)) {
        wp_send_json_error(['message' => 'Please fill in all required fields.']);
    }
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Please provide a valid email address.']);
    }
    if ($type === 'visited' && (empty($date_today) || empty($came_with))) {
        wp_send_json_error(['message' => 'Please fill in all required fields.']);
    }
    if ($type === 'planning' && (empty($planned_date) || empty($party))) {
        wp_send_json_error(['message' => 'Please fill in all required fields.']);
    }

    $full_name = $first_name . ' ' . $last_name;
    $to        = tphb_option('email_visit_form') ?: 'info@rccgthepraisehouse.org';
    $headers   = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $full_name . ' <' . $email . '>',
    ];

    if ($type === 'visited') {
        $subject = "[{$source}] First-Time Visitor — {$full_name} ({$date_today})";
        $body    = "Form: {$source}\n" . str_repeat('─', 40) . "\n"
                 . "A first-time visitor has submitted their information!\n\n"
                 . "Name:        {$full_name}\n"
                 . "Email:       {$email}\n"
                 . "Phone:       {$phone}\n"
                 . "Visit Date:  {$date_today}\n"
                 . "Came With:   {$came_with}\n"
                 . "Heard From:  {$referral}\n"
                 . "Follow Up:   " . ($followup ? 'Yes — welcomes a follow-up' : 'No') . "\n"
                 . "Notes:       " . ($notes ?: '—') . "\n";
        $success = "Thank you, {$first_name}! We're so glad you joined us today. Our Welcome Team will be in touch soon.";
    } else {
        $subject = "[{$source}] Upcoming Visit — {$full_name} on {$planned_date}";
        $body    = "Form: {$source}\n" . str_repeat('─', 40) . "\n"
                 . "A new visitor is planning their first visit!\n\n"
                 . "Name:          {$full_name}\n"
                 . "Email:         {$email}\n"
                 . "Phone:         {$phone}\n"
                 . "Planned Date:  {$planned_date}\n"
                 . "Party:         {$party}\n"
                 . "Heard From:    {$referral}\n"
                 . "Transport:     " . ($transport ? 'Yes — needs help' : 'No') . "\n"
                 . "Notes:         " . ($notes ?: '—') . "\n";
        $success = "You're all set, {$first_name}! We look forward to meeting you on {$planned_date}. See you Sunday!";
    }

    $sent = wp_mail($to, $subject, $body, $headers);
    if (!$sent) {
        wp_send_json_error(['message' => 'Sorry, there was an error sending your submission. Please try again or contact us directly.']);
    }
    wp_send_json_success(['message' => $success]);
}
add_action('wp_ajax_tphb_plan_visit',        'tphb_handle_plan_visit');
add_action('wp_ajax_nopriv_tphb_plan_visit', 'tphb_handle_plan_visit');

// ─── YouTube Live Check REST Endpoint ────────────────────────────────────────
add_action('rest_api_init', function () {
    register_rest_route('tphb/v1', '/live-check', [
        'methods'             => 'GET',
        'callback'            => 'tphb_check_youtube_live',
        'permission_callback' => '__return_true',
    ]);
});

function tphb_check_youtube_live() {
    $channel_id = tphb_option('youtube_channel_id');
    $api_key    = tphb_option('youtube_api_key');

    if (empty($channel_id) || empty($api_key)) {
        return new WP_REST_Response(['live' => false, 'reason' => 'not_configured'], 200);
    }

    $cache_key = 'tphb_yt_live_' . md5($channel_id);
    $cached    = get_transient($cache_key);
    if ($cached !== false) {
        return new WP_REST_Response($cached, 200);
    }

    $api_url = add_query_arg([
        'part'      => 'snippet',
        'channelId' => $channel_id,
        'type'      => 'video',
        'eventType' => 'live',
        'key'       => $api_key,
    ], 'https://www.googleapis.com/youtube/v3/search');

    $response = wp_remote_get($api_url, ['timeout' => 8]);

    if (is_wp_error($response)) {
        return new WP_REST_Response(['live' => false, 'reason' => 'api_error'], 200);
    }

    $body     = json_decode(wp_remote_retrieve_body($response), true);
    $is_live  = !empty($body['items']);
    $video_id = $is_live ? ($body['items'][0]['id']['videoId'] ?? '') : '';
    $result   = ['live' => $is_live, 'video_id' => $video_id];

    set_transient($cache_key, $result, 2 * MINUTE_IN_SECONDS);

    return new WP_REST_Response($result, 200);
}

// ─── Prayer Request Dashboard Columns ────────────────────────────────────────
add_filter('manage_prayer_request_posts_columns', function ($cols) {
    return array_merge($cols, ['_prayer_name' => 'Name', '_prayer_email' => 'Email', '_prayer_private' => 'Private?']);
});
add_action('manage_prayer_request_posts_custom_column', function ($col, $post_id) {
    if (in_array($col, ['_prayer_name','_prayer_email','_prayer_private'])) {
        $val = get_post_meta($post_id, $col, true);
        echo esc_html($col === '_prayer_private' ? ($val ? 'Yes' : 'No') : $val);
    }
}, 10, 2);

// ─── Helper Functions ─────────────────────────────────────────────────────────
function tphb_option($key, $default = '') {
    if (!function_exists('get_field')) return $default;
    $val = get_field($key, 'option');
    return (!empty($val)) ? $val : $default;
}

function tphb_get_youtube_embed_url($url) {
    if (empty($url)) return '';
    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
    return isset($m[1]) ? 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1' : '';
}

function tphb_get_youtube_id($url) {
    if (empty($url)) return '';
    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $m);
    return $m[1] ?? '';
}

function tphb_social_icon($platform) {
    $icons = [
        'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.54 3.5 12 3.5 12 3.5s-7.54 0-9.38.55A3.02 3.02 0 0 0 .5 6.19C0 8.04 0 12 0 12s0 3.96.5 5.81a3.02 3.02 0 0 0 2.12 2.14C4.46 20.5 12 20.5 12 20.5s7.54 0 9.38-.55a3.02 3.02 0 0 0 2.12-2.14C24 15.96 24 12 24 12s0-3.96-.5-5.81zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>',
        'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M24 12.07C24 5.41 18.63 0 12 0S0 5.41 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.04V9.41c0-3.02 1.8-4.7 4.54-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.5 0-1.96.93-1.96 1.89v2.26h3.32l-.53 3.49h-2.79V24C19.61 23.1 24 18.1 24 12.07z"/></svg>',
        'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        'whatsapp'  => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>',
    ];
    return $icons[$platform] ?? '';
}

function tphb_is_upcoming_event($post_id) {
    $event_date = get_field('event_date', $post_id);
    if (empty($event_date)) return false;
    return strtotime($event_date) >= strtotime(wp_date('Y-m-d'));
}

function tphb_get_event_datetime_iso($post_id) {
    $date = get_field('event_date', $post_id);
    $time = get_field('event_time', $post_id) ?: '00:00:00';
    if (empty($date)) return '';
    return $date . 'T' . $time;
}

add_filter('excerpt_length', fn() => 22);
add_filter('excerpt_more',   fn() => '&hellip;');

// ─── Editor Role — Admin UI Cleanup ──────────────────────────────────────────
add_action('admin_menu', function () {
    if (current_user_can('manage_options')) return; // Admins see everything

    // Hide ACF field group editor — Editors fill in fields, not define them
    remove_menu_page('edit.php?post_type=acf-field-group');

    // Hide Tools — not needed for content managers
    remove_menu_page('tools.php');

    // Hide Comments — not used on this site
    remove_menu_page('edit-comments.php');
}, 999);

// Redirect Editors away from admin pages they shouldn't access
add_action('admin_init', function () {
    if (current_user_can('manage_options')) return;

    $blocked = ['tools.php', 'edit-comments.php'];
    $current = basename($_SERVER['PHP_SELF']);
    if (in_array($current, $blocked, true)) {
        wp_redirect(admin_url());
        exit;
    }
});

// Custom dashboard welcome widget for content managers
add_action('wp_dashboard_setup', function () {
    if (current_user_can('manage_options')) return;

    wp_add_dashboard_widget(
        'tphb_editor_welcome',
        'Welcome — The Praise House Content Team',
        function () {
            echo '<p>Here\'s what you can manage:</p>';
            echo '<ul style="margin:0.5rem 0 0 1.25rem;line-height:2;">';
            echo '<li><a href="' . admin_url('edit.php?post_type=sermon') . '">Sermons</a> — Add or update sermon recordings and notes</li>';
            echo '<li><a href="' . admin_url('edit.php?post_type=tphb_event') . '">Events</a> — Create and manage upcoming events</li>';
            echo '<li><a href="' . admin_url('edit.php?post_type=tphb_outreach') . '">Outreach</a> — Post outreach recaps and photos</li>';
            echo '<li><a href="' . admin_url('edit.php?post_type=reflection') . '">Reflections</a> — Add devotionals and sermon snippets</li>';
            echo '<li><a href="' . admin_url('edit.php?post_type=testimonial') . '">Testimonials</a> — Add member testimonies</li>';
            echo '<li><a href="' . admin_url('edit.php?post_type=hero_slide') . '">Hero Slides</a> — Update homepage banner slides</li>';
            echo '<li><a href="' . admin_url('upload.php') . '">Media Library</a> — Upload photos and files</li>';
            echo '</ul>';
        }
    );
});

// ─── Include Custom Post Types in Search ─────────────────────────────────────
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $query->set('post_type', ['post', 'page', 'sermon', 'reflection', 'tphb_event', 'tphb_outreach']);
    }
});

// ─── Extend Search to Include ACF / Post Meta Fields ─────────────────────────
add_filter('posts_search', function ($search, $query) {
    global $wpdb;
    if (is_admin() || !$query->is_main_query() || !$query->is_search()) return $search;

    $term = $query->get('s');
    if (empty($term)) return $search;

    $like   = '%' . $wpdb->esc_like($term) . '%';
    $search .= $wpdb->prepare(
        " OR {$wpdb->posts}.ID IN (
            SELECT post_id FROM {$wpdb->postmeta}
            WHERE meta_value LIKE %s
        )",
        $like
    );

    return $search;
}, 10, 2);

// Prevent duplicate results when a post matches both title/content and meta
add_filter('posts_groupby', function ($groupby, $query) {
    global $wpdb;
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $groupby = "{$wpdb->posts}.ID";
    }
    return $groupby;
}, 10, 2);
