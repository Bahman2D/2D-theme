<?php
/**
 * D Theme - Functions
 * 
 * Main theme functions file
 * 
 * @package D_Theme
 * @version 1.0.0
 * @author Bahman2D
 * @link https://t.me/behman2d
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}


/**
 * ==========================================
 * 1️⃣ Theme Setup
 * ==========================================
 */
function d_theme_setup() {

    // Support for Title Tag
    add_theme_support('title-tag');
    
    // Support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Support for Excerpt
    add_post_type_support('page', 'excerpt');
    add_post_type_support('post', 'excerpt');

    // Custom Image Sizes
    add_image_size('d-thumbnail', 400, 300, true);
    add_image_size('d-card', 600, 400, true);
    add_image_size('d-hero', 1920, 1080, true);
    add_image_size('d-banner', 1400, 600, true);

    // HTML5 Support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Custom Logo Support
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ));
    
    // Custom Background Support
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));
    
    // Selective Refresh in Customizer
    add_theme_support('customize-selective-refresh-widgets');

    // Set content width
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1400;
    }

    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => __('منوی اصلی', 'd-theme'),
        'footer'  => __('منوی فوتر', 'd-theme'),
        'mobile'  => __('منوی موبایل', 'd-theme')
    ));
}
add_action('after_setup_theme', 'd_theme_setup');

/**
 * ==========================================
 * 2️⃣ Enqueue Styles and Scripts
 * ==========================================
 */
function d_theme_enqueue_assets() {
    
    // ========== CSS Files ==========
    
    // 1. Fonts (load first)
    wp_enqueue_style(
        'd-theme-fonts',
        get_template_directory_uri() . '/assets/fonts/fontiran.css',
        array(),
        '2.4'
    );

    // 2. CSS Variables
    wp_enqueue_style(
        'd-theme-variables',
        get_template_directory_uri() . '/assets/css/variables.css',
        array(),
        wp_get_theme()->get('Version') ?: '1.0.0'
    );

    // 3. Main Styles
    wp_enqueue_style(
        'd-theme-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array('d-theme-variables'),
        wp_get_theme()->get('Version') ?: '1.0.0'
    );

    // 4. Components
    wp_enqueue_style(
        'd-theme-components',
        get_template_directory_uri() . '/assets/css/components.css',
        array('d-theme-main'),
        wp_get_theme()->get('Version') ?: '1.0.0'
    );

    // 5. Header
    wp_enqueue_style(
        'd-theme-header',
        get_template_directory_uri() . '/assets/css/header.css',
        array('d-theme-main'),
        wp_get_theme()->get('Version') ?: '1.0.0'
    );

    // 6. Footer
    wp_enqueue_style(
        'd-theme-footer',
        get_template_directory_uri() . '/assets/css/footer.css',
        array('d-theme-main'),
        wp_get_theme()->get('Version') ?: '1.0.0'
    );

    // 7. Hero CSS for front page
    if (is_front_page()) {
        wp_enqueue_style(
            'd-theme-hero',
            get_template_directory_uri() . '/assets/css/hero.css',
            array('d-theme-main'),
            '1.0.0'
        );
    }

    // 8. Category CSS for category page template
    if (is_page_template('page-category.php')) {
        wp_enqueue_style(
            'd-theme-category',
            get_template_directory_uri() . '/assets/css/category.css',
            array('d-theme-main'),
            '1.0.0'
        );
    }

    // ========== JavaScript Files ==========
    
    // 1. Main Script
    wp_enqueue_script(
        'd-theme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version') ?: '1.0.0',
        true
    );

    // 2. Theme Toggle (Dark/Light)
    wp_enqueue_script(
        'd-theme-toggle',
        get_template_directory_uri() . '/assets/js/toggle.js',
        array(),
        wp_get_theme()->get('Version') ?: '1.0.0',
        true
    );

    // 3. Menu
    wp_enqueue_script(
        'd-theme-menu',
        get_template_directory_uri() . '/assets/js/menu.js',
        array(),
        wp_get_theme()->get('Version') ?: '1.0.0',
        true
    );

    // 4. Search
    wp_enqueue_script(
        'd-theme-search',
        get_template_directory_uri() . '/assets/js/search.js',
        array(),
        wp_get_theme()->get('Version') ?: '1.0.0',
        true
    );

    
    // 5. Hero Slider for front page only
    if (is_front_page()) {
        wp_enqueue_script(
            'd-theme-hero-slider',
            get_template_directory_uri() . '/assets/js/hero-slider.js',
            array(),
            wp_get_theme()->get('Version') ?: '1.0.0',
            true
        );
    }

    // Localize script data for JavaScript
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
 * 3️⃣ Include Required Files
 * ==========================================
 */

// Customizer (Settings Panel)
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/colors.php';
require get_template_directory() . '/inc/customizer/logo.php';
require get_template_directory() . '/inc/customizer/hero.php';

// Menus
require get_template_directory() . '/inc/menus/menu-setup.php';
require get_template_directory() . '/inc/menus/menu-walker.php';

// Custom Fields (commented - uncomment if needed)
// require get_template_directory() . '/inc/custom-fields/category-fields.php';

// Helper Functions
require get_template_directory() . '/inc/helpers/helpers.php';
require get_template_directory() . '/inc/helpers/color-helper.php';
require get_template_directory() . '/inc/helpers/schema.php';
require get_template_directory() . '/inc/helpers/svg-support.php';
require get_template_directory() . '/inc/helpers/performance.php';

// Persian Date
require get_template_directory() . '/inc/persian-date.php';

/**
 * ==========================================
 * 4️⃣ Helper Functions
 * ==========================================
 */

/**
 * Add classes to body tag based on current page
 */
function d_theme_body_classes($classes) {
    if (!is_array($classes)) {
        $classes = array();
    }

    // If current page is a page
    if (is_page()) {
        global $post;
        
        if ($post && isset($post->post_name)) {
            // Add page slug
            $classes[] = 'page-' . sanitize_html_class($post->post_name);

            // If page has parent
            if ($post->post_parent) {
                $parent = get_post($post->post_parent);
                if ($parent && isset($parent->post_name)) {
                    $classes[] = 'category-' . sanitize_html_class($parent->post_name);
                }
            }
        }
    }

    // If front page
    if (is_front_page()) {
        $classes[] = 'front-page';
    }

    // If single post
    if (is_single()) {
        $classes[] = 'single-post';
    }

    // If archive page
    if (is_archive()) {
        $classes[] = 'archive-page';
    }
    
    return $classes;
}
add_filter('body_class', 'd_theme_body_classes');

/**
 * Add Customizer color settings CSS to head
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
 * Set excerpt length
 */
function d_theme_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'd_theme_excerpt_length');

/**
 * Set excerpt more text
 */
function d_theme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'd_theme_excerpt_more');

/**
 * Add SVG file type to uploads
 */
function d_theme_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'd_theme_mime_types');

/**
 * Remove WP version from head (optimization)
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove RSD link
 */
remove_action('wp_head', 'rsd_link');

/**
 * Remove wlwmanifest link
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Add defer to scripts (optimization)
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
 * Add RTL-related code
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

// Set Persian language
add_filter('locale', function($locale) {
    return 'fa_IR';
});

// Set Tehran timezone
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
 * Convert time for get_the_time()
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
    // Main Sidebar
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
 * Get logo URL
 */
function d_theme_get_logo() {
    if (has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if ($logo && isset($logo[0])) {
                return esc_url($logo[0]);
            }
        }
    }
    return get_template_directory_uri() . '/assets/images/logo.png';
}

/**
 * Display breadcrumb
 */
function d_theme_breadcrumb() {
    if (!is_front_page() && get_theme_mod('show_breadcrumb', true)) {
        echo '<nav class="breadcrumb" aria-label="breadcrumb">';
        echo '<a href="' . esc_url(home_url()) . '">خانه</a>';
        
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
 * Check if current page is a category page template
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
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove extra meta tags
 */
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

/**
 * Limit editor attempts
 * For better security, can use plugins that use code validators
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
 * Disable Gutenberg CSS in frontend (optional)
 */
// add_action('wp_enqueue_scripts', function() {
//     wp_dequeue_style('wp-block-library');
//     wp_dequeue_style('wp-block-library-theme');
// }, 100);

/**
 * ==========================================
 * 🔟 Theme Hooks
 * ==========================================
 */

/**
 * Hook before header
 */
function d_theme_before_header() {
    do_action('d_theme_before_header');
}

/**
 * Hook after header
 */
function d_theme_after_header() {
    do_action('d_theme_after_header');
}

/**
 * Hook before footer
 */
function d_theme_before_footer() {
    do_action('d_theme_before_footer');
}

/**
 * Hook after footer
 */
function d_theme_after_footer() {
    do_action('d_theme_after_footer');
}


