<?php
/**
 * Customizer - Logo
 * 
 * تنظیمات لوگو قالب در Customizer
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن تنظیمات لوگو به Customizer
 * توجه: از Custom Logo پیش‌فرض وردپرس استفاده می‌کنیم
 * این فایل برای تنظیمات اضافی لوگو است
 */
function d_theme_customize_logo($wp_customize) {
    
    /**
     * Section: لوگو (بهبود section پیش‌فرض وردپرس)
     */
    
    // تغییر توضیحات section لوگو پیش‌فرض
    if ($wp_customize->get_section('title_tagline')) {
        $wp_customize->get_section('title_tagline')->description = 
            __('لوگو و تنظیمات هویت سایت', 'd-theme');
    }
    
    /**
     * Setting: لوگوی حالت روز (Light Mode)
     */
    $wp_customize->add_setting('logo_light', array(
        'default' => '',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'logo_light', array(
        'label' => __('لوگوی حالت روز', 'd-theme'),
        'description' => __('لوگوی سایت برای Light Mode (تم روز). اگر تنظیم نشود، از لوگوی اصلی استفاده می‌شود.', 'd-theme'),
        'section' => 'title_tagline',
        'mime_type' => 'image',
        'priority' => 9,
    )));
    
    /**
     * Setting: نمایش نام سایت در کنار لوگو
     */
    $wp_customize->add_setting('show_site_title_with_logo', array(
        'default' => false,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('show_site_title_with_logo', array(
        'label' => __('نمایش نام سایت در کنار لوگو', 'd-theme'),
        'description' => __('اگر فعال باشد، نام سایت در کنار لوگو نمایش داده می‌شود', 'd-theme'),
        'section' => 'title_tagline',
        'type' => 'checkbox',
        'priority' => 10,
    ));
    
    /**
     * Setting: ارتفاع لوگو (دسکتاپ)
     */
    $wp_customize->add_setting('logo_height_desktop', array(
        'default' => 45,
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('logo_height_desktop', array(
        'label' => __('ارتفاع لوگو (دسکتاپ)', 'd-theme'),
        'description' => __('ارتفاع لوگو به پیکسل در نمایش دسکتاپ', 'd-theme'),
        'section' => 'title_tagline',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 20,
            'max' => 100,
            'step' => 1,
        ),
        'priority' => 11,
    ));
    
    /**
     * Setting: ارتفاع لوگو (موبایل)
     */
    $wp_customize->add_setting('logo_height_mobile', array(
        'default' => 38,
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('logo_height_mobile', array(
        'label' => __('ارتفاع لوگو (موبایل)', 'd-theme'),
        'description' => __('ارتفاع لوگو به پیکسل در نمایش موبایل', 'd-theme'),
        'section' => 'title_tagline',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 20,
            'max' => 80,
            'step' => 1,
        ),
        'priority' => 12,
    ));
    
    /**
     * راهنما
     */
    $wp_customize->add_setting('logo_note', array(
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'logo_note', array(
        'label' => __('راهنمای لوگو', 'd-theme'),
        'description' => __('<hr><strong>توصیه‌ها:</strong><ul style="margin: 10px 0; padding-right: 20px;"><li>اندازه پیشنهادی: 300×100 پیکسل</li><li>فرمت: PNG با پس‌زمینه شفاف یا SVG</li><li>برای Dark Mode: از رنگ‌های روشن استفاده کنید</li><li>حجم فایل: کمتر از 100KB</li></ul>', 'd-theme'),
        'section' => 'title_tagline',
        'type' => 'hidden',
        'priority' => 13,
    )));
}
add_action('customize_register', 'd_theme_customize_logo', 11);

/**
 * اضافه کردن استایل سفارشی لوگو به head
 */
function d_theme_logo_custom_css() {
    $height_desktop = get_theme_mod('logo_height_desktop', 45);
    $height_mobile = get_theme_mod('logo_height_mobile', 38);
    
    ?>
    <style id="d-theme-logo-css">
        .logo-img {
            height: <?php echo absint($height_desktop); ?>px;
        }
        
        @media (max-width: 767px) {
            .logo-img {
                height: <?php echo absint($height_mobile); ?>px;
            }
        }
        
        <?php if (get_theme_mod('show_site_title_with_logo', false)) : ?>
        .logo {
            gap: var(--space-3);
        }
        
        .logo-text {
            display: inline-block !important;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'd_theme_logo_custom_css');
