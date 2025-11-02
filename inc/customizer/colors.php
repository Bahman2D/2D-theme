<?php
/**
 * Customizer - Colors
 * 
 * تنظیمات رنگ‌های قالب در Customizer
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن تنظیمات رنگ به Customizer
 */
function d_theme_customize_colors($wp_customize) {
    
    /**
     * Section: رنگ‌ها
     */
    $wp_customize->add_section('d_theme_colors', array(
        'title' => __('رنگ‌های قالب', 'd-theme'),
        'description' => __('تنظیم رنگ‌های اصلی قالب', 'd-theme'),
        'panel' => 'd_theme_options',
        'priority' => 10,
    ));
    
    /**
     * Setting & Control: رنگ اصلی (Primary)
     */
    $wp_customize->add_setting('primary_color', array(
        'default' => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('رنگ اصلی', 'd-theme'),
        'description' => __('رنگ اصلی قالب (دکمه‌ها، لینک‌ها، عناصر تاکیدی)', 'd-theme'),
        'section' => 'd_theme_colors',
        'settings' => 'primary_color',
    )));
    
    /**
     * Setting & Control: رنگ ثانویه (Secondary)
     */
    $wp_customize->add_setting('secondary_color', array(
        'default' => '#64748b',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label' => __('رنگ ثانویه', 'd-theme'),
        'description' => __('رنگ ثانویه قالب (متن‌های ثانویه، آیکون‌ها)', 'd-theme'),
        'section' => 'd_theme_colors',
        'settings' => 'secondary_color',
    )));
    
    /**
     * Setting & Control: رنگ تاکیدی (Accent)
     */
    $wp_customize->add_setting('accent_color', array(
        'default' => '#ff8800',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label' => __('رنگ تاکیدی', 'd-theme'),
        'description' => __('رنگ برای تاکید و هایلایت (نوتیفیکیشن‌ها، پیشنهادها)', 'd-theme'),
        'section' => 'd_theme_colors',
        'settings' => 'accent_color',
    )));
    
    /**
     * جداکننده
     */
    $wp_customize->add_setting('colors_separator', array(
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'colors_separator', array(
        'label' => '',
        'description' => '<hr style="margin: 20px 0;">',
        'section' => 'd_theme_colors',
        'type' => 'hidden',
    )));
    
    /**
     * توضیح: رنگ‌های دسته‌ها
     */
    $wp_customize->add_setting('colors_category_note', array(
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'colors_category_note', array(
        'label' => __('رنگ‌های دسته‌بندی', 'd-theme'),
        'description' => __('<p><strong>توجه:</strong> رنگ‌های دسته‌بندی‌ها از Design System قالب پیروی می‌کنند و از طریق <code>inc/helpers/color-helper.php</code> قابل تنظیم هستند.</p><ul style="margin: 10px 0; padding-right: 20px;"><li>🔵 فولاد بلبرینگ: آبی</li><li>🟢 فولاد فنر: سبز</li><li>🟣 فولاد نیتراته: بنفش</li><li>🔴 فولاد مقاوم به حرارت: قرمز</li><li>⚪ سایر آلیاژها: خاکستری</li></ul>', 'd-theme'),
        'section' => 'd_theme_colors',
        'type' => 'hidden',
    )));
}
add_action('customize_register', 'd_theme_customize_colors', 11);
