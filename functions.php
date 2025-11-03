<?php
/**
 * D Theme - Functions
 * فایل functions.php قالب D با قابلیت‌های اضافه شده برای فولاد اقبالی
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ==========================================
 * 1️⃣ تنظیمات اولیه قالب
 * ==========================================
 */
function d_theme_setup() {

    // پشتیبانی از Title Tag
    add_theme_support('title-tag');
    
    // پشتیبانی از تصویر شاخص
    add_theme_support('post-thumbnails');

    // پشتیبانی از متن خلاصه مطلب
    add_post_type_support('page', 'excerpt');
    add_post_type_support('post', 'excerpt');

    // سایزهای تصویر سفارشی
    add_image_size('d-thumbnail', 400, 300, true);
    add_image_size('d-card', 600, 400, true);
    add_image_size('d-hero', 1920, 1080, true);
    add_image_size('d-banner', 1400, 600, true);
    add_image_size('alloy-thumbnail', 400, 300, true);
    add_image_size('alloy-large', 800, 600, true);

    // پشتیبانی از HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // پشتیبانی از Custom Logo
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ));
    
    // پشتیبانی از Custom Background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));
    
    // بارگذاری Textdomain برای ترجمه‌ها
    load_theme_textdomain('d-theme', get_template_directory() . '/languages');

    // پشتیبانی از Refresh انتخابی در Customizer
    add_theme_support('customize-selective-refresh-widgets');
    
    // پشتیبانی از فید خودکار
    add_theme_support('automatic-feed-links');

    // تنظیم حداقل عرض محتوا
    if (!isset($GLOBALS['content_width'])) {
        $GLOBALS['content_width'] = 1400;
    }

    // ثبت منوها
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'd-theme'),
        'footer'  => __('منوی فوتر', 'd-theme'),
        'mobile'  => __('منوی موبایل', 'd-theme')
    ));
}
add_action('after_setup_theme', 'd_theme_setup');

/**
 * ==========================================
 * 2️⃣ بارگذاری استایل‌ها و اسکریپت‌ها
 * ==========================================
 */
function d_theme_enqueue_assets() {

    $version = wp_get_theme()->get('Version');

    if (empty($version)) {

        $version = '1.0.0';

    }



    $theme_dir = get_template_directory_uri();



    // ========== CSS Files ==========



    // 1. Fonts (global)

    wp_enqueue_style(

        'd-theme-fonts',

        $theme_dir . '/assets/fonts/fontiran.css',

        array(),

        '2.4'

    );



    // 2. Variables

    wp_enqueue_style(

        'd-theme-variables',

        $theme_dir . '/assets/css/variables.css',

        array(),

        $version

    );



    // 3. Base stylesheet

    wp_enqueue_style(

        'd-theme-main',

        $theme_dir . '/assets/css/main.css',

        array('d-theme-variables'),

        $version

    );



    // 4. Components

    wp_enqueue_style(

        'd-theme-components',

        $theme_dir . '/assets/css/components.css',

        array('d-theme-main'),

        $version

    );



    // 5. Header

    wp_enqueue_style(

        'd-theme-header',

        $theme_dir . '/assets/css/header.css',

        array('d-theme-main'),

        $version

    );



    // 6. Footer

    wp_enqueue_style(

        'd-theme-footer',

        $theme_dir . '/assets/css/footer.css',

        array('d-theme-main'),

        $version

    );



    // 7. Front page hero

    if (is_front_page()) {

        wp_enqueue_style(

            'd-theme-hero',

            $theme_dir . '/assets/css/hero.css',

            array('d-theme-main'),

            $version

        );

    }



    // 8. Category page template (حذف شد: فایل/تمپلیت موجود نیست)



    // 9. Steel alloy single pages

    if (is_singular('steel_alloy')) {

        wp_enqueue_style(

            'd-alloy-single',

            $theme_dir . '/assets/css/alloy-single.css',

            array('d-theme-main'),

            $version

        );

    }



    // 10. Steel category archives

    if (is_tax('steel_category')) {

        wp_enqueue_style(

            'd-category',

            $theme_dir . '/assets/css/category-archive.css',

            array('d-theme-main'),

            $version

        );

    }



    // ========== JavaScript Files ==========



    // 1. Core script

    wp_enqueue_script(

        'd-theme-main',

        $theme_dir . '/assets/js/main.js',

        array('jquery'),

        $version,

        true

    );



    // 2. Theme toggle

    wp_enqueue_script(

        'd-theme-toggle',

        $theme_dir . '/assets/js/toggle.js',

        array(),

        $version,

        true

    );



    // 3. Menu interactions

    wp_enqueue_script(

        'd-theme-menu',

        $theme_dir . '/assets/js/menu.js',

        array(),

        $version,

        true

    );



    // 4. Search

    wp_enqueue_script(

        'd-theme-search',

        $theme_dir . '/assets/js/search.js',

        array(),

        $version,

        true

    );



    // 5. Front page hero slider

    if (is_front_page()) {

        wp_enqueue_script(

            'd-theme-hero-slider',

            $theme_dir . '/assets/js/hero-slider.js',

            array(),

            $version,

            true

        );

    }



    // 6. Steel alloy single pages

    if (is_singular('steel_alloy')) {

        wp_enqueue_script(

            'd-alloy-single',

            $theme_dir . '/assets/js/alloy-single.js',

            array('jquery', 'd-theme-main'),

            $version,

            true

        );

    }



    // 7. Steel category archives

    if (is_tax('steel_category')) {

        wp_enqueue_script(

            'd-category',

            $theme_dir . '/assets/js/category-archive.js',

            array('jquery', 'd-theme-main'),

            $version,

            true

        );

    }



    // Localize data for scripts

    wp_localize_script('d-theme-main', 'dTheme', array(

        'ajaxUrl' => admin_url('admin-ajax.php'),

        'nonce' => wp_create_nonce('d-theme-nonce'),

        'themeUrl' => $theme_dir,

        'homeUrl' => home_url('/'),

    ));



    wp_localize_script('d-theme-main', 'eghbalData', array(

        'ajaxUrl' => admin_url('admin-ajax.php'),

        'nonce' => wp_create_nonce('eghbal_nonce'),

        'siteUrl' => get_site_url(),

    ));

}

add_action('wp_enqueue_scripts', 'd_theme_enqueue_assets');

/**
 * ==========================================
 * 3️⃣ بارگذاری استایل‌ها و اسکریپت‌ها
 * ==========================================
 */

// 🔧 Customizer (پنل تنظیمات)
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/colors.php';
require get_template_directory() . '/inc/customizer/logo.php';
require get_template_directory() . '/inc/customizer/hero.php';

// 🔍 Menus (منوها)
require get_template_directory() . '/inc/menus/menu-setup.php';
require get_template_directory() . '/inc/menus/menu-walker.php';

// 🛠 Custom Fields
// require get_template_directory() . '/inc/custom-fields/category-fields.php';

// 🛠 Helpers (توابع کمکی)
require get_template_directory() . '/inc/helpers/helpers.php';
require get_template_directory() . '/inc/helpers/color-helper.php';
require get_template_directory() . '/inc/post-types/steel-alloy-cpt.php';
require get_template_directory() . '/inc/seo/schema.php';
require get_template_directory() . '/inc/ajax/quote-form.php';


// 🗓 تاریخ شمسی
require get_template_directory() . '/inc/persian-date.php';

/**
 * ==========================================
 * 4️⃣ تابعه کمکی سریعا
 * ==========================================
 */

/**
 * اضافه کردن کلاس به تگ body بر اساس صفحه فعلی
 */
function d_theme_body_classes($classes) {

    $theme_mode = isset($_COOKIE['theme_mode']) ? sanitize_text_field($_COOKIE['theme_mode']) : 'dark';

    $classes[] = 'theme-' . sanitize_html_class($theme_mode);



    if (is_page()) {

        global $post;



        $classes[] = 'page-' . $post->post_name;



        if ($post->post_parent) {

            $parent = get_post($post->post_parent);

            if ($parent) {

                $classes[] = 'category-' . $parent->post_name;

            }

        }

    }



    if (is_front_page()) {

        $classes[] = 'front-page';

    }



    if (is_single()) {

        $classes[] = 'single-post';

    }



    if (is_archive()) {

        $classes[] = 'archive-page';

    }



    if (is_singular('steel_alloy')) {

        $categories = get_the_terms(get_the_ID(), 'steel_category');

        if ($categories && !is_wp_error($categories)) {

            $classes[] = 'category-' . sanitize_html_class($categories[0]->slug);

        }

    }



    return $classes;

}

add_filter('body_class', 'd_theme_body_classes');

/**
 * اضافه کردن کدهای مربوط به تنظیمات رنگی Customizer به بخش head
 */
function d_theme_customizer_css() {
    $primary = get_theme_mod('primary_color', '#3b82f6');
    $secondary = get_theme_mod('secondary_color', '#64748b');
    $accent = get_theme_mod('accent_color', '#ff8800');
    ?>
    <style type="text/css">
        :root {
            --primary: <?php echo esc_attr($primary); ?>;
            --secondary: <?php echo esc_attr($secondary); ?>;
            --accent: <?php echo esc_attr($accent); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'd_theme_customizer_css');

/**
 * تنظیم طول excerpt
 */
function d_theme_excerpt_length($length) {
    if (is_tax('steel_category')) {
        return 20;
    }

    return 30;
}
add_filter('excerpt_length', 'd_theme_excerpt_length');

/**
 * تنظیم ... excerpt more
 */
function d_theme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'd_theme_excerpt_more');

/**
 * اضافه کردن نوع فایل SVG به آپلود
 */
function d_theme_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'd_theme_mime_types');

/**
 * غیرفعال کردن کدهای مربوط به emoji scripts (بهینه‌سازی)
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

/**
 * حذف WP version از head (بهینه‌سازی)
 */
remove_action('wp_head', 'wp_generator');

/**
 * حذف RSD link
 */
remove_action('wp_head', 'rsd_link');

/**
 * حذف wlwmanifest link
 */
remove_action('wp_head', 'wlwmanifest_link');

function d_theme_remove_query_strings($src) {
    if (strpos($src, '?ver=') !== false) {
        $src = remove_query_arg('ver', $src);
    }

    return $src;
}
add_filter('style_loader_src', 'd_theme_remove_query_strings', 10, 1);
add_filter('script_loader_src', 'd_theme_remove_query_strings', 10, 1);

/**
 * اضافه کردن defer به اسکریپت‌ها (بهینه‌سازی)
 */

function d_theme_add_defer($tag, $handle) {
    $defer_scripts = array(
        'd-theme-main',
        'd-theme-toggle',
        'd-theme-menu',
        'd-theme-search',
        'd-theme-hero-slider',
        'd-alloy-single',
        'd-category',
    );
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'd_theme_add_defer', 10, 2);

/**
 * اضافه کردن کدهای مربوط به RTL
 */
function d_theme_rtl_support() {
    if (is_rtl()) {
        echo '<style>body { direction: rtl; }</style>';
    }
}
add_action('wp_head', 'd_theme_rtl_support');

/**
 * ==========================================
 * 5ï¸âƒ£ تنظیمات تاریخ شمسی
 * ==========================================
 */

// تنظیم زبان فارسی
add_filter('locale', function($locale) {
    return 'fa_IR';
});

// تنظیم منطقه زمانی تهران
add_action('after_setup_theme', function() {
    date_default_timezone_set('Asia/Tehran');
});

/**
 * تبدیل تاریخ get_the_date()
 */
add_filter('get_the_date', function($the_date, $format, $post) {
    if (function_exists('persian_date')) {
        if (empty($format)) {
            $format = get_option('date_format');
        }
        $timestamp = get_post_time('U', false, $post);
        return persian_date($format, $timestamp);
    }
    return $the_date;
}, 10, 3);

/**
 * تبدیل زمان get_the_time()
 */
add_filter('get_the_time', function($the_time, $format, $post) {
    if (function_exists('persian_date')) {
        if (empty($format)) {
            $format = get_option('time_format');
        }
        $timestamp = get_post_time('U', false, $post);
        return persian_date($format, $timestamp);
    }
    return $the_time;
}, 10, 3);

/**
 * ==========================================
 * 6ï¸âƒ£ ویدجت‌ها
 * ==========================================
 */
function d_theme_widgets_init() {
    // Sidebar اصلی
    register_sidebar(array(
        'name'          => __('سایدبار اصلی', 'd-theme'),
        'id'            => 'sidebar-main',
        'description'   => __('ویجت‌های سایدبار اصلی', 'd-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // فوتر - ستون 1
    register_sidebar(array(
        'name'          => __('فوتر - ستون 1', 'd-theme'),
        'id'            => 'footer-1',
        'description'   => __('ویجت‌های ستون اول فوتر', 'd-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // فوتر - ستون 2
    register_sidebar(array(
        'name'          => __('فوتر - ستون 2', 'd-theme'),
        'id'            => 'footer-2',
        'description'   => __('ویجت‌های ستون دوم فوتر', 'd-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // فوتر - ستون 3
    register_sidebar(array(
        'name'          => __('فوتر - ستون 3', 'd-theme'),
        'id'            => 'footer-3',
        'description'   => __('ویجت‌های ستون سوم فوتر', 'd-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // فوتر - ستون 4
    register_sidebar(array(
        'name'          => __('فوتر - ستون 4', 'd-theme'),
        'id'            => 'footer-4',
        'description'   => __('ویجت‌های ستون چهارم فوتر', 'd-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'd_theme_widgets_init');

/**
 * ==========================================
 * 7ï¸âƒ£ تبدیل تاریخ و زمان
 * ==========================================
 */

/**
 * تاریخافت URL لوگو
 */
function d_theme_get_logo() {
    if (has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        return $logo[0];
    }
    return get_template_directory_uri() . '/assets/images/logo.png';
}

/**
 * نمایش breadcrumb
 */
function d_theme_breadcrumb() {
    if (!is_front_page()) {
        echo '<nav class="breadcrumbs breadcrumb" aria-label="breadcrumb">';
        echo '<div class="container">';
        echo '<a href="' . home_url() . '">خانه</a>';

        if (is_category() || is_single()) {
            echo ' / ';
            the_category(' / ');
            if (is_single()) {
                echo ' / ';
                the_title();
            }
        } elseif (is_page()) {
            echo ' / ';
            the_title();
        }

        echo '</div>';
        echo '</nav>';
    }
}

// حذف تابع تکراری زمان مطالعه؛ نسخه اصلی در inc/helpers/helpers.php موجود است

/**
 * بررسی اینکه آیا صفحه دسته‌بندی است
 */

function is_category_page() {
    return is_page_template('page-category.php');
}

/**
 * ==========================================
 * 8ï¸âƒ£ تبدیل تاریخ و زمان
 * ==========================================
 */

/**
 * غیرفعال کردن XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * حذف meta tags اضافی
 */
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

/**
 * محدود کردن تلا‌ش‌هایی ویرایشگر
 * برای امنیت بیشتر می‌توان پلگین‌های استفاده‌کننده از استافاده‌کننده‌های کد
 */

/**
 * ==========================================
 * 9ï¸âƒ£ بهینه‌سازی
 * ==========================================
 */

/**
 * ایجاد پیش بارگذاری برای فونت‌ها
 */
function d_theme_preload_fonts() {
    ?>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/IRANYekanXVF.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/staticfonts/IRANYekanX-Regular.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/staticfonts/IRANYekanX-Bold.woff" as="font" type="font/woff" crossorigin>
    <?php
}
add_action('wp_head', 'd_theme_preload_fonts', 1);

/**
 * غیرفعال کردن Gutenberg CSS در فرانت (اختیاری)
 */
// add_action('wp_enqueue_scripts', function() {
//     wp_dequeue_style('wp-block-library');
//     wp_dequeue_style('wp-block-library-theme');
// }, 100);

/**
 * ==========================================
 * 🔧 Hook هایی که فعال می‌شوند
 * ==========================================
 */

/**
 * Hook قبل از header
 */
function d_theme_before_header() {
    do_action('d_theme_before_header');
}

/**
 * Hook بعد از header
 */
function d_theme_after_header() {
    do_action('d_theme_after_header');
}

/**
 * Hook قبل از footer
 */
function d_theme_before_footer() {
    do_action('d_theme_before_footer');
}

/**
 * Hook بعد از footer
 */
function d_theme_after_footer() {
    do_action('d_theme_after_footer');
}

/**
 * ACF Options Page
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'تنظیمات قالب',
        'menu_title' => 'تنظیمات قالب',
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-settings',
    ));
}
