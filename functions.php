<?php
// Theme Setup
function twod_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    
    // ثبت منوها
    register_nav_menus(array(
        'primary' => 'منوی اصلی',
        'footer'  => 'منوی فوتر'
    ));
}
add_action('after_setup_theme', 'twod_theme_setup');

// ثبت استایل و اسکریپت
function twod_theme_scripts() {
    wp_enqueue_style('2d-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_script('2d-theme-script', get_template_directory_uri() . '/assets/js/theme.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'twod_theme_scripts');

// تبدیل تاریخ به شمسی
require_once get_template_directory() . '/inc/persian-date.php';

wp_enqueue_style('IRANYekanX', get_template_directory_uri() . '/assets/fonts/fontiran.css', array(), '1.0.0');