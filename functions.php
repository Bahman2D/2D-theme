<?php
/**
 * D Theme - Functions
 * 
 * Ù‡Ø³ØªÙ‡ Ø§ØµÙ„ÛŒ Ù‚Ø§Ù„Ø¨ Ø¯ÛŒ ØªÙ…
 * 
 * @package D_Theme
 * @version 1.0.0
 * @author Bahman2D
 * @link https://t.me/behman2d
 */

// Ø¬Ù„ÙˆÚ¯ÛŒØ±ÛŒ Ø§Ø² Ø¯Ø³ØªØ±Ø³ÛŒ Ù…Ø³ØªÙ‚ÛŒÙ…
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
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
    
    // پشتیبانی از Refresh انتخابی در Customizer
    add_theme_support('customize-selective-refresh-widgets');

    // تنظیم حداقل عرض محتوا
    if (!isset($content_width)) {
        $content_width = 1400;
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
    
    // ========== CSS Files ==========
    
    // 1. فونت‌ها (اولین و تنهایت)
    wp_enqueue_style(
        'd-theme-fonts',
        get_template_directory_uri() . '/assets/fonts/fontiran.css',
        array(),
        '2.4'
    );

    // 2. متغیرهای CSS
    wp_enqueue_style(
        'd-theme-variables',
        get_template_directory_uri() . '/assets/css/variables.css',
        array(),
        '1.0.0'
    );

    // 3. استایل اصلی
    wp_enqueue_style(
        'd-theme-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array('d-theme-variables'),
        '1.0.0'
    );

    // 4. کامپوننت‌ها
    wp_enqueue_style(
        'd-theme-components',
        get_template_directory_uri() . '/assets/css/components.css',
        array('d-theme-main'),
        '1.0.0'
    );

    // 5. هدر
    wp_enqueue_style(
        'd-theme-header',
        get_template_directory_uri() . '/assets/css/header.css',
        array('d-theme-main'),
        '1.0.0'
    );

    // 6. فوتر
    wp_enqueue_style(
        'd-theme-footer',
        get_template_directory_uri() . '/assets/css/footer.css',
        array('d-theme-main'),
        '1.0.0'
    );

    // 7. Hero CSS برای صفحه اصلی
    if (is_front_page()) {
        wp_enqueue_style(
            'd-theme-hero',
            get_template_directory_uri() . '/assets/css/hero.css',
            array('d-theme-main'),
            '1.0.0'
        );
    }

    // 8. Category CSS برای صفحه دسته‌بندی
    if (is_page_template('page-category.php')) {
        wp_enqueue_style(
            'd-theme-category',
            get_template_directory_uri() . '/assets/css/category.css',
            array('d-theme-main'),
            '1.0.0'
        );
    }

    // ========== JavaScript Files ==========
    
    // 1. اسکریپت اصلی
    wp_enqueue_script(
        'd-theme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );

    // 2. تغییر تم (شب/روز)
    wp_enqueue_script(
        'd-theme-toggle',
        get_template_directory_uri() . '/assets/js/toggle.js',
        array(),
        '1.0.0',
        true
    );

    // 3. منو
    wp_enqueue_script(
        'd-theme-menu',
        get_template_directory_uri() . '/assets/js/menu.js',
        array(),
        '1.0.0',
        true
    );

    // 4. جستجو
    wp_enqueue_script(
        'd-theme-search',
        get_template_directory_uri() . '/assets/js/search.js',
        array(),
        '1.0.0',
        true
    );

    
    // 5. آکاردئون (برای سوالات متداول و محتوای تاشو)
    wp_enqueue_script(
        'd-theme-accordion',
        get_template_directory_uri() . '/assets/js/accordion.js',
        array(),
        '1.0.0',
        true
    );
    // 5. Hero Slider برای صفحه اصلی
    if (is_front_page()) {
        wp_enqueue_script(
            'd-theme-hero-slider',
            get_template_directory_uri() . '/assets/js/hero-slider.js',
            array(),
            '1.0.0',
            true
        );
    }

    // انتقال داده‌ها به بخش JavaScript
    wp_localize_script('d-theme-main', 'dTheme', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('d-theme-nonce'),
        'themeUrl' => get_template_directory_uri(),
        'homeUrl' => home_url('/'),
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
require get_template_directory() . '/inc/helpers/schema.php';
require get_template_directory() . '/inc/helpers/svg-support.php';
require get_template_directory() . '/inc/helpers/performance.php';

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

    // اگر صفحه فعلی از نوع page باشد
    if (is_page()) {
        global $post;

        // اضافه کردن slug صفحه
        $classes[] = 'page-' . $post->post_name;

        // اگر صفحه والد دارد
        if ($post->post_parent) {
            $parent = get_post($post->post_parent);
            if ($parent) {
                $classes[] = 'category-' . $parent->post_name;
            }
        }
    }

    // اگر صفحه اصلی باشد
    if (is_front_page()) {
        $classes[] = 'front-page';
    }

    // اگر صفحه تکی باشد
    if (is_single()) {
        $classes[] = 'single-post';
    }

    // اگر صفحه بایگانی باشد
    if (is_archive()) {
        $classes[] = 'archive-page';
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
        echo '<nav class="breadcrumb" aria-label="breadcrumb">';
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
        
        echo '</nav>';
    }
}

/**
 * نمایش زمان مطالعه محتوا
 */
if (!function_exists('d_theme_reading_time')) {
    function d_theme_reading_time() {
        $content = get_post_field('post_content', get_the_ID());
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // برآورد زمان مطالعه محتوا در دقیقه
        
        return $reading_time . ' دقیقه';
    }
}

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


