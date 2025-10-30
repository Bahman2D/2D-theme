<?php
// Theme Setup
function twod_theme_setup() {
    // فعال‌سازی پشتیبانی از تصویر شاخص
    add_theme_support('post-thumbnails');
    
    // فعال‌سازی عنوان خودکار
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'twod_theme_setup');