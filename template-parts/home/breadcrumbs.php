<?php
/**
 * Template Part: Breadcrumbs
 * 
 * نمایش Breadcrumb Navigation
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// چک کردن فعال بودن Breadcrumb از Customizer
if (!get_theme_mod('show_breadcrumb', true)) {
    return;
}

// در صفحه اصلی breadcrumb نمایش داده نمی‌شود
if (is_front_page()) {
    return;
}

// نمایش breadcrumb
echo d_theme_breadcrumb();
