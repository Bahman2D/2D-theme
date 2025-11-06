<?php
/**
 * Customizer Setup
 * 
 * Main Customizer settings for theme
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Register Customizer settings
 * 
 * @param WP_Customize_Manager $wp_customize Customizer manager
 */
function d_theme_customize_register($wp_customize) {
    
    // Remove unnecessary default sections
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('background_image');
    
    /**
     * Panel اصلی قالب
     */
    $wp_customize->add_panel('d_theme_options', array(
        'title' => __('تنظیمات قالب D Theme', 'd-theme'),
        'description' => __('تنظیمات سفارشی‌سازی قالب', 'd-theme'),
        'priority' => 10,
        'capability' => 'edit_theme_options',
    ));
    
    /**
     * Section: تنظیمات عمومی
     */
    $wp_customize->add_section('d_theme_general', array(
        'title' => __('تنظیمات عمومی', 'd-theme'),
        'panel' => 'd_theme_options',
        'priority' => 10,
    ));
    
    // فعال/غیرفعال سازی Breadcrumb
    $wp_customize->add_setting('show_breadcrumb', array(
        'default' => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_breadcrumb', array(
        'label' => __('نمایش Breadcrumb', 'd-theme'),
        'description' => __('نمایش مسیر صفحه در بالای محتوا', 'd-theme'),
        'section' => 'd_theme_general',
        'type' => 'checkbox',
    ));
    
    /**
     * Section: شبکه‌های اجتماعی
     */
    $wp_customize->add_section('d_theme_social', array(
        'title' => __('شبکه‌های اجتماعی', 'd-theme'),
        'description' => __('لینک‌های شبکه‌های اجتماعی', 'd-theme'),
        'panel' => 'd_theme_options',
        'priority' => 40,
    ));
    
    $socials = array(
        'telegram' => __('تلگرام', 'd-theme'),
        'instagram' => __('اینستاگرام', 'd-theme'),
        'whatsapp' => __('واتساپ', 'd-theme'),
        'linkedin' => __('لینکدین', 'd-theme'),
        'twitter' => __('توییتر', 'd-theme'),
    );
    
    foreach ($socials as $key => $label) {
        $wp_customize->add_setting("social_{$key}", array(
            'default' => '',
            'sanitize_callback' => function($value) {
                // Validate URL before sanitizing
                $url = esc_url_raw($value);
                return filter_var($url, FILTER_VALIDATE_URL) ? $url : '';
            },
            'validate_callback' => function($validity, $value) {
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $validity->add('invalid_url', __('لینک وارد شده معتبر نیست.', 'd-theme'));
                }
                return $validity;
            },
        ));
        
        $wp_customize->add_control("social_{$key}", array(
            'label' => $label,
            'section' => 'd_theme_social',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'd_theme_customize_register');

/**
 * Add Live Preview script
 */
function d_theme_customizer_live_preview() {
    wp_enqueue_script(
        'd-theme-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('jquery', 'customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'd_theme_customizer_live_preview');

/**
 * Add CSS for Customizer Panel
 */
function d_theme_customizer_styles() {
    ?>
    <style>
        /* Custom Customizer styles */
        #customize-theme-controls .customize-pane-child {
            direction: rtl;
        }
        
        .customize-control-description {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'd_theme_customizer_styles');

/**
 * Clear theme cache when customizer is saved
 */
function d_theme_customizer_save_cache_clear() {
    // Clear all theme-related caches
    d_theme_clear_all_cache();
    
    // Clear specific caches
    d_theme_delete_cached('hero_active_slides');
    d_theme_delete_cached('search_suggestions');
    d_theme_delete_cached('logo_urls');
}
add_action('customize_save_after', 'd_theme_customizer_save_cache_clear');
