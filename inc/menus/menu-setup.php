<?php
/**
 * Menu Setup - D Theme
 * 
 * Register and configure theme menus
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * Add active class to current menu item
 */
function d_theme_menu_active_class($classes, $item) {
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active';
    }
    
    if (in_array('current-page-ancestor', $classes)) {
        $classes[] = 'active-ancestor';
    }
    
    return $classes;
}
add_filter('nav_menu_css_class', 'd_theme_menu_active_class', 10, 2);

/**
 * Add aria-current to active link
 */
function d_theme_menu_link_attributes($atts, $item, $args) {
    if (in_array('current-menu-item', $item->classes)) {
        $atts['aria-current'] = 'page';
    }
    
    return $atts;
}
add_filter('nav_menu_link_attributes', 'd_theme_menu_link_attributes', 10, 3);

/**
 * Remove extra WordPress classes from menu (optional - for cleaner code)
 */
function d_theme_clean_menu_classes($classes, $item, $args) {
    // Classes we want to keep
    $keep_classes = array(
        'menu-item',
        'current-menu-item',
        'current-page-ancestor',
        'menu-item-has-children',
        'active',
        'active-ancestor'
    );
    
    // Filter classes
    return array_intersect($classes, $keep_classes);
}
// Enable this filter optionally
// add_filter('nav_menu_css_class', 'd_theme_clean_menu_classes', 10, 3);
