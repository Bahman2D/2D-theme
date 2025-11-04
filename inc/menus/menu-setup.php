<?php
/**
 * Menu Setup
 * 
 * ثبت و تنظیم منوهای قالب
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن کلاس فعال به آیتم منوی فعلی
 */
function d_theme_active_menu_class($classes, $item, $args) {
    if (in_array('current-menu-item', $classes) || in_array('current-page-ancestor', $classes)) {
        $classes[] = 'active';
    }
    
    return $classes;
}
add_filter('nav_menu_css_class', 'd_theme_active_menu_class', 10, 3);

/**
 * اضافه کردن aria-current به لینک فعال
 */
function d_theme_menu_link_attributes($atts, $item, $args) {
    if (in_array('current-menu-item', $item->classes)) {
        $atts['aria-current'] = 'page';
    }
    
    return $atts;
}
add_filter('nav_menu_link_attributes', 'd_theme_menu_link_attributes', 10, 3);

/**
 * حذف کلاس‌های اضافی وردپرس از منو (اختیاری - برای کد تمیزتر)
 */
function d_theme_clean_menu_classes($classes, $item, $args, $depth) {
    // کلاس‌هایی که می‌خواهیم حفظ کنیم
    $allowed_classes = array(
        'menu-item-has-children',
        'current-menu-item',
        'current-menu-parent',
        'current-menu-ancestor',
        'current-page-ancestor',
    );
    
    // فیلتر کردن کلاس‌ها
    return array_intersect($classes, $allowed_classes);
}
// فعال‌سازی این فیلتر اختیاری است
// add_filter('nav_menu_css_class', 'd_theme_clean_menu_classes', 10, 4);
