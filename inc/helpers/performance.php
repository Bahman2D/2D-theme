<?php
/**
 * Performance Optimizations
 * 
 * بهینه‌سازی‌های پرفورمنس برای سرعت بارگذاری بهتر
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن Lazy Loading به تصاویر
 */
function d_theme_add_lazy_loading($content) {
    // اضافه کردن loading="lazy" به تگ img
    $content = preg_replace('/<img(.*?)>/', '<img$1 loading="lazy">', $content);
    return $content;
}
add_filter('the_content', 'd_theme_add_lazy_loading');
add_filter('post_thumbnail_html', 'd_theme_add_lazy_loading');

/**
 * حذف query strings از استاتیک resources
 */
function d_theme_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'd_theme_remove_query_strings', 10, 1);
add_filter('script_loader_src', 'd_theme_remove_query_strings', 10, 1);

/**
 * اضافه کردن preconnect برای فونت‌ها و CDN‌ها
 */
function d_theme_preconnect_fonts() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <?php
}
add_action('wp_head', 'd_theme_preconnect_fonts', 1);

/**
 * غیرفعال کردن emoji scripts
 */
function d_theme_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'd_theme_disable_emojis');

/**
 * غیرفعال کردن embeds
 */
function d_theme_disable_embeds() {
    // حذف JavaScript wp-embed
    wp_dequeue_script('wp-embed');
    
    // حذف oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    
    // حذف oEmbed REST API route
    remove_action('rest_api_init', 'wp_oembed_register_route');
    
    // فیلتر کردن oEmbed
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
}
add_action('init', 'd_theme_disable_embeds', 9999);

/**
 * حذف jQuery Migrate
 */
function d_theme_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'd_theme_remove_jquery_migrate');

/**
 * بهینه‌سازی database queries
 */
function d_theme_optimize_database_queries() {
    // حذف revision های قدیمی
    if (!defined('WP_POST_REVISIONS')) {
        define('WP_POST_REVISIONS', 3);
    }
    
    // خالی کردن trash به صورت خودکار
    if (!defined('EMPTY_TRASH_DAYS')) {
        define('EMPTY_TRASH_DAYS', 7);
    }
}
add_action('init', 'd_theme_optimize_database_queries');

/**
 * اضافه کردن Cache-Control headers
 */
function d_theme_add_cache_headers() {
    if (!is_user_logged_in()) {
        header('Cache-Control: public, max-age=31536000');
    }
}
add_action('send_headers', 'd_theme_add_cache_headers');

/**
 * بهینه‌سازی تصاویر با srcset و sizes
 */
function d_theme_responsive_images($html, $post_id, $attachment_id) {
    // اضافه کردن srcset و sizes به تصاویر
    $image_meta = wp_get_attachment_metadata($attachment_id);
    
    if (!empty($image_meta['sizes'])) {
        $sizes = array();
        foreach ($image_meta['sizes'] as $size => $data) {
            $sizes[] = $data['width'] . 'w';
        }
        
        if (!empty($sizes)) {
            $html = str_replace('<img', '<img srcset="' . esc_attr(implode(', ', $sizes)) . '" sizes="(max-width: 768px) 100vw, 50vw"', $html);
        }
    }
    
    return $html;
}
add_filter('post_thumbnail_html', 'd_theme_responsive_images', 10, 3);

/**
 * حذف CSS و JS غیر ضروری از صفحات
 */
function d_theme_dequeue_unnecessary_scripts() {
    // حذف jQuery در صفحه اصلی اگر لازم نیست
    // wp_dequeue_script('jquery');
    
    // حذف WordPress Block Library CSS در فرانت اگر از Gutenberg استفاده نمی‌کنید
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style'); // WooCommerce
        wp_dequeue_style('global-styles'); // WordPress 5.9+
    }
}
add_action('wp_enqueue_scripts', 'd_theme_dequeue_unnecessary_scripts', 100);

/**
 * اضافه کردن async/defer به اسکریپت‌های خارجی
 */
function d_theme_async_defer_scripts($tag, $handle, $src) {
    // لیست اسکریپت‌هایی که باید async باشند
    $async_scripts = array(
        'google-analytics',
        'facebook-pixel',
    );
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'd_theme_async_defer_scripts', 10, 3);

/**
 * تنظیم expires headers برای فایل‌های استاتیک
 */
function d_theme_set_expires_headers() {
    if (!is_admin()) {
        ?>
        <meta http-equiv="Cache-Control" content="max-age=31536000, public">
        <?php
    }
}
add_action('wp_head', 'd_theme_set_expires_headers', 1);

/**
 * بهینه‌سازی Google Fonts
 */
function d_theme_optimize_google_fonts() {
    // اگر از Google Fonts استفاده می‌کنید، این کد را فعال کنید
    // wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', array(), null);
}
// add_action('wp_enqueue_scripts', 'd_theme_optimize_google_fonts');

/**
 * حذف Dashicons در فرانت برای کاربران غیر لاگین
 */
function d_theme_dequeue_dashicons() {
    if (!is_user_logged_in()) {
        wp_dequeue_style('dashicons');
        wp_deregister_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'd_theme_dequeue_dashicons');

/**
 * بهینه‌سازی Heartbeat API
 */
function d_theme_optimize_heartbeat($settings) {
    // کاهش فرکانس Heartbeat به 60 ثانیه
    $settings['interval'] = 60;
    return $settings;
}
add_filter('heartbeat_settings', 'd_theme_optimize_heartbeat');

/**
 * غیرفعال کردن Heartbeat در فرانت
 */
function d_theme_disable_heartbeat_frontend() {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'd_theme_disable_heartbeat_frontend', 1);

/**
 * اضافه کردن resource hints
 */
function d_theme_resource_hints($hints, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $hints[] = '//fonts.googleapis.com';
        $hints[] = '//fonts.gstatic.com';
    }
    
    return $hints;
}
add_filter('wp_resource_hints', 'd_theme_resource_hints', 10, 2);
