<?php
/**
 * Customizer - Hero Slider
 * 
 * تنظیمات Hero Slider صفحه اصلی در Customizer
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن تنظیمات Hero به Customizer
 */
function d_theme_customize_hero($wp_customize) {
    
    /**
     * Section: Hero Slider
     */
    $wp_customize->add_section('d_theme_hero', array(
        'title' => __('Hero Slider صفحه اصلی', 'd-theme'),
        'description' => __('تنظیمات 3 اسلاید Hero صفحه اصلی', 'd-theme'),
        'panel' => 'd_theme_options',
        'priority' => 30,
    ));
    
    /**
     * Setting: فعال/غیرفعال سازی Hero Slider
     */
    $wp_customize->add_setting('hero_enabled', array(
        'default' => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('hero_enabled', array(
        'label' => __('نمایش Hero Slider', 'd-theme'),
        'description' => __('فعال/غیرفعال سازی Hero Slider در صفحه اصلی', 'd-theme'),
        'section' => 'd_theme_hero',
        'type' => 'checkbox',
    ));
    
    /**
     * Setting: سرعت اتوپلی (میلی‌ثانیه)
     */
    $wp_customize->add_setting('hero_autoplay_speed', array(
        'default' => 5000,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('hero_autoplay_speed', array(
        'label' => __('سرعت اتوپلی', 'd-theme'),
        'description' => __('زمان نمایش هر اسلاید به میلی‌ثانیه (5000 = 5 ثانیه)', 'd-theme'),
        'section' => 'd_theme_hero',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 2000,
            'max' => 10000,
            'step' => 1000,
        ),
    ));
    
    // تنظیمات 3 اسلاید
    for ($i = 1; $i <= 3; $i++) {
        d_theme_add_hero_slide_settings($wp_customize, $i);
    }
}
add_action('customize_register', 'd_theme_customize_hero', 11);

/**
 * اضافه کردن تنظیمات یک اسلاید
 * 
 * @param WP_Customize_Manager $wp_customize
 * @param int $slide_number شماره اسلاید
 */
function d_theme_add_hero_slide_settings($wp_customize, $slide_number) {
    
    // عنوان‌های پیش‌فرض
    $default_titles = array(
        1 => 'خوش آمدید به قالب D Theme',
        2 => 'طراحی مدرن و حرفه‌ای',
        3 => 'آماده برای پروژه شما',
    );
    
    $default_texts = array(
        1 => 'قالبی قدرتمند، سریع و بهینه شده برای وردپرس با پشتیبانی کامل RTL و فارسی',
        2 => 'با استفاده از آخرین استانداردهای وب و تکنولوژی‌های روز دنیا ساخته شده است',
        3 => 'به راحتی قابل سفارشی‌سازی و گسترش برای هر نوع وب‌سایت و پروژه',
    );
    
    $default_gradients = array(
        1 => array('start' => '#667eea', 'end' => '#764ba2'),
        2 => array('start' => '#f093fb', 'end' => '#f5576c'),
        3 => array('start' => '#4facfe', 'end' => '#00f2fe'),
    );
    
    /**
     * جداکننده
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_separator", array(
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, "hero_slide_{$slide_number}_separator", array(
        'label' => sprintf(__('اسلاید %d', 'd-theme'), $slide_number),
        'description' => '<hr style="margin: 15px 0; border: none; border-top: 2px solid #ddd;">',
        'section' => 'd_theme_hero',
        'type' => 'hidden',
    )));
    
    /**
     * فعال/غیرفعال سازی اسلاید
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_enabled", array(
        'default' => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    
    $wp_customize->add_control("hero_slide_{$slide_number}_enabled", array(
        'label' => sprintf(__('نمایش اسلاید %d', 'd-theme'), $slide_number),
        'section' => 'd_theme_hero',
        'type' => 'checkbox',
    ));
    
    /**
     * عنوان اسلاید
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_title", array(
        'default' => $default_titles[$slide_number],
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control("hero_slide_{$slide_number}_title", array(
        'label' => __('عنوان', 'd-theme'),
        'section' => 'd_theme_hero',
        'type' => 'text',
    ));
    
    /**
     * متن اسلاید
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_text", array(
        'default' => $default_texts[$slide_number],
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control("hero_slide_{$slide_number}_text", array(
        'label' => __('متن توضیحات', 'd-theme'),
        'section' => 'd_theme_hero',
        'type' => 'textarea',
    ));
    
    /**
     * دکمه 1 - متن
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_btn1_text", array(
        'default' => ($slide_number == 1) ? 'مشاهده بیشتر' : (($slide_number == 2) ? 'ویژگی‌ها' : 'تماس با ما'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control("hero_slide_{$slide_number}_btn1_text", array(
        'label' => __('متن دکمه 1', 'd-theme'),
        'section' => 'd_theme_hero',
        'type' => 'text',
    ));
    
    /**
     * دکمه 1 - لینک
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_btn1_link", array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control("hero_slide_{$slide_number}_btn1_link", array(
        'label' => __('لینک دکمه 1', 'd-theme'),
        'section' => 'd_theme_hero',
        'type' => 'url',
    ));
    
    /**
     * دکمه 2 - متن
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_btn2_text", array(
        'default' => ($slide_number == 1) ? 'شروع کنید' : (($slide_number == 2) ? 'نمونه کارها' : 'درباره ما'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control("hero_slide_{$slide_number}_btn2_text", array(
        'label' => __('متن دکمه 2', 'd-theme'),
        'section' => 'd_theme_hero',
        'type' => 'text',
    ));
    
    /**
     * دکمه 2 - لینک
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_btn2_link", array(
        'default' => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control("hero_slide_{$slide_number}_btn2_link", array(
        'label' => __('لینک دکمه 2', 'd-theme'),
        'section' => 'd_theme_hero',
        'type' => 'url',
    ));
    
    /**
     * رنگ گرادینت شروع
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_gradient_start", array(
        'default' => $default_gradients[$slide_number]['start'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "hero_slide_{$slide_number}_gradient_start", array(
        'label' => __('رنگ گرادینت (شروع)', 'd-theme'),
        'section' => 'd_theme_hero',
        'settings' => "hero_slide_{$slide_number}_gradient_start",
    )));
    
    /**
     * رنگ گرادینت پایان
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_gradient_end", array(
        'default' => $default_gradients[$slide_number]['end'],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, "hero_slide_{$slide_number}_gradient_end", array(
        'label' => __('رنگ گرادینت (پایان)', 'd-theme'),
        'section' => 'd_theme_hero',
        'settings' => "hero_slide_{$slide_number}_gradient_end",
    )));
    
    /**
     * تصویر پس‌زمینه (اختیاری)
     */
    $wp_customize->add_setting("hero_slide_{$slide_number}_bg_image", array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "hero_slide_{$slide_number}_bg_image", array(
        'label' => __('تصویر پس‌زمینه (اختیاری)', 'd-theme'),
        'description' => __('در صورت آپلود، بر روی گرادینت قرار می‌گیرد', 'd-theme'),
        'section' => 'd_theme_hero',
        'settings' => "hero_slide_{$slide_number}_bg_image",
    )));
}
