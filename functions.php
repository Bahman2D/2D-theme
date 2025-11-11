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

/**
 * Get cached theme version
 * 
 * @return string Theme version
 */
function d_theme_get_version() {
    static $version = null;
    
    if (null === $version) {
        $theme = wp_get_theme();
        $version = $theme->get('Version') ?: '1.0.0';
    }
    
    return $version;
}

function d_theme_enqueue_assets() {
    // Cache theme version to avoid multiple calls
    $theme_version = d_theme_get_version();
    $template_uri = get_template_directory_uri();
    
    // ========== CSS Files ==========
    
    // 1. Fonts (load first)
    wp_enqueue_style(
        'd-theme-fonts',
        $template_uri . '/assets/fonts/fontiran.css',
        array(),
        '2.4'
    );

    // 2. CSS Variables
    wp_enqueue_style(
        'd-theme-variables',
        $template_uri . '/assets/css/variables.css',
        array(),
        $theme_version
    );

    // 3. Main Styles
    wp_enqueue_style(
        'd-theme-main',
        $template_uri . '/assets/css/main.css',
        array('d-theme-variables'),
        $theme_version
    );

    // 4. Components
    wp_enqueue_style(
        'd-theme-components',
        $template_uri . '/assets/css/components.css',
        array('d-theme-main'),
        $theme_version
    );

    // 5. Header
    wp_enqueue_style(
        'd-theme-header',
        $template_uri . '/assets/css/header.css',
        array('d-theme-main'),
        $theme_version
    );

    // 6. Footer
    wp_enqueue_style(
        'd-theme-footer',
        $template_uri . '/assets/css/footer.css',
        array('d-theme-main'),
        $theme_version
    );

    // 7. Hero CSS for front page
    if (is_front_page()) {
        wp_enqueue_style(
            'd-theme-hero',
            $template_uri . '/assets/css/hero.css',
            array('d-theme-main'),
            $theme_version
        );
    }
    
    // 8. Category CSS for category page template
    if (is_page_template('page-category.php')) {
        wp_enqueue_style(
            'd-theme-category',
            $template_uri . '/assets/css/category.css',
            array('d-theme-main'),
            $theme_version
        );
    }

    // 9. TOC CSS (for single posts and pages with TOC)
    if (is_singular()) {
        if (d_theme_needs_toc()) {
            wp_enqueue_style(
                'd-theme-toc',
                $template_uri . '/assets/css/toc.css',
                array('d-theme-main'),
                $theme_version
            );
        }
    }
    
    // 10. FAQ CSS (if FAQ exists)
    if (is_singular()) {
        global $post;
        $faqs = $post ? get_post_meta($post->ID, 'd_theme_faq_items', true) : array();
        if (!empty($faqs)) {
            wp_enqueue_style(
                'd-theme-faq',
                $template_uri . '/assets/css/faq.css',
                array('d-theme-main'),
                $theme_version
            );
        }
    }
    
    // 11. Single Post CSS
    if (is_single()) {
        wp_enqueue_style(
            'd-theme-single',
            $template_uri . '/assets/css/single.css',
            array('d-theme-main'),
            $theme_version
        );
    }
    
    // 12. Blog Page CSS
    if (is_page_template('page-blog.php')) {
        wp_enqueue_style(
            'd-theme-blog',
            $template_uri . '/assets/css/blog.css',
            array('d-theme-main'),
            $theme_version
        );
    }
    
    // 13. Alloy Page CSS
    if (is_page_template('page-alloy.php')) {
        wp_enqueue_style(
            'd-theme-alloy',
            $template_uri . '/assets/css/alloy.css',
            array('d-theme-main'),
            $theme_version
        );
    }
    
    // 14. Comments CSS
    if (is_singular() && (comments_open() || get_comments_number())) {
        wp_enqueue_style(
            'd-theme-comments',
            $template_uri . '/assets/css/comments.css',
            array('d-theme-main'),
            $theme_version
        );
    }

    // ========== JavaScript Files ==========
    
    // 1. Main Script
    wp_enqueue_script(
        'd-theme-main',
        $template_uri . '/assets/js/main.js',
        array(),
        $theme_version,
        true
    );

    // 2. Theme Toggle (Dark/Light)
    wp_enqueue_script(
        'd-theme-toggle',
        $template_uri . '/assets/js/toggle.js',
        array(),
        $theme_version,
        true
    );

    // 3. Menu
    wp_enqueue_script(
        'd-theme-menu',
        $template_uri . '/assets/js/menu.js',
        array(),
        $theme_version,
        true
    );

    // 4. Search
    wp_enqueue_script(
        'd-theme-search',
        $template_uri . '/assets/js/search.js',
        array(),
        $theme_version,
        true
    );

    
    // 5. Hero Slider for front page only
    if (is_front_page()) {
        wp_enqueue_script(
            'd-theme-hero-slider',
            $template_uri . '/assets/js/hero-slider.js',
            array(),
            $theme_version,
            true
        );
    }
    
    // 6. TOC JavaScript (for single posts and pages with TOC)
    if (is_singular()) {
        if (d_theme_needs_toc()) {
            wp_enqueue_script(
                'd-theme-toc',
                $template_uri . '/assets/js/toc.js',
                array(),
                $theme_version,
                true
            );
        }
    }
    
    // 7. FAQ JavaScript (if FAQ exists)
    if (is_singular()) {
        global $post;
        $faqs = $post ? get_post_meta($post->ID, 'd_theme_faq_items', true) : array();
        if (!empty($faqs)) {
            wp_enqueue_script(
                'd-theme-faq',
                $template_uri . '/assets/js/faq.js',
                array(),
                $theme_version,
                true
            );
        }
    }

    // Localize script data for JavaScript
    wp_localize_script('d-theme-main', 'dTheme', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('d-theme-nonce'),
        'themeUrl' => $template_uri,
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
require get_template_directory() . '/inc/helpers/toc-helper.php';
require get_template_directory() . '/inc/helpers/seo-helper.php';

// Metaboxes
require get_template_directory() . '/inc/metaboxes/faq-metabox.php';
require get_template_directory() . '/inc/metaboxes/alloy-metabox.php';

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
 * Get cached theme mods
 * 
 * @param string $key Theme mod key
 * @param mixed $default Default value
 * @return mixed Theme mod value
 */
function d_theme_get_cached_mod($key, $default = '') {
    static $mods_cache = null;
    
    if (null === $mods_cache) {
        // Cache all theme mods at once to reduce database queries
        $mods_cache = get_theme_mods();
    }
    
    return isset($mods_cache[$key]) ? $mods_cache[$key] : $default;
}

/**
 * Add Customizer color settings CSS to head
 */
function d_theme_customizer_css() {
    // Use cached theme mods
    $primary = d_theme_get_cached_mod('primary_color', '#3b82f6');
    $secondary = d_theme_get_cached_mod('secondary_color', '#64748b');
    $accent = d_theme_get_cached_mod('accent_color', '#ff8800');
    
    // Only output if colors are different from defaults or custom
    $has_custom_colors = ($primary !== '#3b82f6' || $secondary !== '#64748b' || $accent !== '#ff8800');
    
    if (!$has_custom_colors) {
        return;
    }
    
    ?>
    <style type="text/css" id="d-theme-customizer-colors">
        :root {
            --primary: <?php echo esc_attr($primary); ?>;
            --secondary: <?php echo esc_attr($secondary); ?>;
            --accent: <?php echo esc_attr($accent); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'd_theme_customizer_css', 5);

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
        echo '<style id="d-theme-rtl">body { direction: rtl; }</style>';
    }
}
add_action('wp_head', 'd_theme_rtl_support', 5);

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
    // بررسی صفحه اصلی
    if (is_front_page()) {
        return;
    }
    
    // بررسی تنظیمات Customizer
    $show_breadcrumb = get_theme_mod('show_breadcrumb', true);
    if (!$show_breadcrumb) {
        return;
    }
    
    $breadcrumb_items = array();
    
    // خانه
    $breadcrumb_items[] = '<a href="' . esc_url(home_url('/')) . '">خانه</a>';
    
    // Category archive
    if (is_category()) {
        $category = get_queried_object();
        if ($category) {
            $breadcrumb_items[] = '<span class="breadcrumb-current">' . esc_html($category->name) . '</span>';
        }
    }
    // Tag archive
    elseif (is_tag()) {
        $tag = get_queried_object();
        if ($tag) {
            $breadcrumb_items[] = '<span class="breadcrumb-current">' . esc_html($tag->name) . '</span>';
        }
    }
    // Single post
    elseif (is_single()) {
        $categories = get_the_category();
        if (!empty($categories)) {
            $category = $categories[0];
            $breadcrumb_items[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
        }
        $breadcrumb_items[] = '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    }
    // Page
    elseif (is_page()) {
        global $post;
        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                $breadcrumb_items[] = '<a href="' . esc_url(get_permalink($ancestor)) . '">' . get_the_title($ancestor) . '</a>';
            }
        }
        $breadcrumb_items[] = '<span class="breadcrumb-current">' . get_the_title() . '</span>';
    }
    // Search
    elseif (is_search()) {
        $breadcrumb_items[] = '<span class="breadcrumb-current">نتایج جستجو: ' . esc_html(get_search_query()) . '</span>';
    }
    // 404
    elseif (is_404()) {
        $breadcrumb_items[] = '<span class="breadcrumb-current">صفحه پیدا نشد</span>';
    }
    // Archive
    elseif (is_archive()) {
        $breadcrumb_items[] = '<span class="breadcrumb-current">' . get_the_archive_title() . '</span>';
    }
    
    if (count($breadcrumb_items) > 0) {
        echo '<nav class="breadcrumb" aria-label="breadcrumb">';
        echo implode(' <span class="breadcrumb-separator">/</span> ', $breadcrumb_items);
        echo '</nav>';
    } else {
        // اگر هیچ آیتمی نبود، حداقل خانه را نمایش بده
        echo '<nav class="breadcrumb" aria-label="breadcrumb">';
        echo '<a href="' . esc_url(home_url('/')) . '">خانه</a>';
        echo '</nav>';
    }
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

/**
 * ==========================================
 * 🔟 Save Phone Number in Comments
 * ==========================================
 */

/**
 * Save phone number to comment meta
 */
function d_theme_save_comment_phone($comment_id) {
    if (isset($_POST['phone']) && !empty($_POST['phone'])) {
        $phone = sanitize_text_field($_POST['phone']);
        add_comment_meta($comment_id, 'phone', $phone);
    }
}
add_action('comment_post', 'd_theme_save_comment_phone');

