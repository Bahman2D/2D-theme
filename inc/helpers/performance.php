<?php
/**
 * Performance Optimizations
 * 
 * Performance optimizations for better loading speed
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Optimize database queries - Define constants early
 * These should be defined before init hook
 */
if (!defined('WP_POST_REVISIONS')) {
    define('WP_POST_REVISIONS', 3);
}

if (!defined('EMPTY_TRASH_DAYS')) {
    define('EMPTY_TRASH_DAYS', 7);
}

/**
 * Add lazy loading to images
 * Only add if WordPress native lazy loading is not already present
 */
function d_theme_add_lazy_loading($content) {
    // Skip if content is empty or already has loading attribute
    if (empty($content) || strpos($content, 'loading=') !== false) {
        return $content;
    }
    
    // Use more specific regex to avoid conflicts
    // Only match img tags without loading attribute
    $content = preg_replace(
        '/<img((?![^>]*loading=)[^>]*?)>/i',
        '<img$1 loading="lazy">',
        $content
    );
    
    return $content;
}
add_filter('the_content', 'd_theme_add_lazy_loading', 20);
add_filter('post_thumbnail_html', 'd_theme_add_lazy_loading', 20);

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
 * Add preconnect for fonts and CDNs
 * Note: Only add if using Google Fonts
 */
function d_theme_preconnect_fonts() {
    // Only add if actually using Google Fonts
    // Uncomment if you add Google Fonts
    // ?>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"> -->
    <?php
}
// add_action('wp_head', 'd_theme_preconnect_fonts', 1);

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
 * Optimize database queries
 * Note: Constants are now defined at the top of the file
 * This function is kept for backward compatibility
 */
function d_theme_optimize_database_queries() {
    // Constants are already defined at file level
    // This function can be used for additional optimizations if needed
}

/**
 * Add Cache-Control headers
 * Note: This may conflict with caching plugins
 */
function d_theme_add_cache_headers() {
    if (!is_user_logged_in() && !headers_sent()) {
        header('Cache-Control: public, max-age=31536000');
    }
}
// Disabled by default - may conflict with caching plugins
// add_action('send_headers', 'd_theme_add_cache_headers');

/**
 * Enable responsive images support
 * WordPress handles srcset automatically when using wp_get_attachment_image()
 */
function d_theme_setup_responsive_images() {
    // Add support for responsive images (WordPress 4.4+)
    add_theme_support('responsive-embeds');
    // WordPress automatically adds srcset when using wp_get_attachment_image()
}
add_action('after_setup_theme', 'd_theme_setup_responsive_images');

/**
 * Remove unnecessary CSS and JS from pages
 */
function d_theme_dequeue_unnecessary_scripts() {
    // Remove jQuery from front page if not needed
    // wp_dequeue_script('jquery');
    
    // Remove WordPress Block Library CSS from frontend if not using Gutenberg
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style'); // WooCommerce
        wp_dequeue_style('global-styles'); // WordPress 5.9+
    }
}
add_action('wp_enqueue_scripts', 'd_theme_dequeue_unnecessary_scripts', 100);

/**
 * Add async/defer to external scripts
 */
function d_theme_async_defer_scripts($tag, $handle, $src) {
    if (empty($tag) || empty($handle)) {
        return $tag;
    }
    
    // List of scripts that should be async
    $async_scripts = array(
        'google-analytics',
        'facebook-pixel',
    );
    
    // Validate array before using in_array
    if (!empty($async_scripts) && is_array($async_scripts) && in_array($handle, $async_scripts, true)) {
        // Only add async if not already present
        if (strpos($tag, ' async') === false && strpos($tag, 'defer') === false) {
            return str_replace(' src', ' async src', $tag);
        }
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'd_theme_async_defer_scripts', 10, 3);

/**
 * Set expires headers for static files
 * Note: This may conflict with caching plugins
 */
function d_theme_set_expires_headers() {
    if (!is_admin() && !headers_sent()) {
        ?>
        <meta http-equiv="Cache-Control" content="max-age=31536000, public">
        <?php
    }
}
// Disabled by default - may conflict with caching plugins
// add_action('wp_head', 'd_theme_set_expires_headers', 1);

/**
 * Optimize Google Fonts
 */
function d_theme_optimize_google_fonts() {
    // If using Google Fonts, enable this code
    // wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', array(), null);
}
// add_action('wp_enqueue_scripts', 'd_theme_optimize_google_fonts');

/**
 * Remove Dashicons from frontend for non-logged-in users
 */
function d_theme_dequeue_dashicons() {
    if (!is_user_logged_in()) {
        wp_dequeue_style('dashicons');
        wp_deregister_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'd_theme_dequeue_dashicons');

/**
 * Optimize Heartbeat API
 */
function d_theme_optimize_heartbeat($settings) {
    // Reduce Heartbeat frequency to 60 seconds
    if (is_array($settings)) {
        $settings['interval'] = 60;
    }
    return $settings;
}
add_filter('heartbeat_settings', 'd_theme_optimize_heartbeat');

/**
 * Disable Heartbeat in frontend
 */
function d_theme_disable_heartbeat_frontend() {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'd_theme_disable_heartbeat_frontend', 1);

/**
 * Add resource hints
 */
function d_theme_resource_hints($hints, $relation_type) {
    if ('dns-prefetch' === $relation_type && is_array($hints)) {
        $hints[] = '//fonts.googleapis.com';
        $hints[] = '//fonts.gstatic.com';
    }
    
    return $hints;
}
// Only add if using Google Fonts
// add_filter('wp_resource_hints', 'd_theme_resource_hints', 10, 2);
