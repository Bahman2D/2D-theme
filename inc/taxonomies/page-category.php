<?php
/**
 * Page Category Taxonomy
 * 
 * Taxonomy برای دسته‌بندی صفحات
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * ثبت Taxonomy برای صفحات
 */
function d_theme_register_page_category_taxonomy() {
    $labels = array(
        'name' => __('دسته‌بندی صفحات', 'd-theme'),
        'singular_name' => __('دسته‌بندی صفحه', 'd-theme'),
        'menu_name' => __('دسته‌بندی صفحات', 'd-theme'),
        'all_items' => __('همه دسته‌بندی‌ها', 'd-theme'),
        'parent_item' => __('دسته‌بندی والد', 'd-theme'),
        'parent_item_colon' => __('دسته‌بندی والد:', 'd-theme'),
        'new_item_name' => __('نام دسته‌بندی جدید', 'd-theme'),
        'add_new_item' => __('افزودن دسته‌بندی جدید', 'd-theme'),
        'edit_item' => __('ویرایش دسته‌بندی', 'd-theme'),
        'update_item' => __('بروزرسانی دسته‌بندی', 'd-theme'),
        'view_item' => __('مشاهده دسته‌بندی', 'd-theme'),
        'separate_items_with_commas' => __('جدا کردن با کاما', 'd-theme'),
        'add_or_remove_items' => __('افزودن یا حذف دسته‌بندی', 'd-theme'),
        'choose_from_most_used' => __('انتخاب از پراستفاده‌ترین‌ها', 'd-theme'),
        'popular_items' => __('دسته‌بندی‌های محبوب', 'd-theme'),
        'search_items' => __('جستجوی دسته‌بندی', 'd-theme'),
        'not_found' => __('یافت نشد', 'd-theme'),
        'no_terms' => __('بدون دسته‌بندی', 'd-theme'),
        'items_list' => __('لیست دسته‌بندی‌ها', 'd-theme'),
        'items_list_navigation' => __('ناوبری لیست دسته‌بندی‌ها', 'd-theme'),
    );
    
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => false,
        'show_in_rest' => true,
        'rewrite' => false, // غیرفعال کردن rewrite پیش‌فرض
        'query_var' => true,
    );
    
    register_taxonomy('page_category', array('page'), $args);
}
add_action('init', 'd_theme_register_page_category_taxonomy', 0);

/**
 * اضافه کردن column به لیست صفحات
 */
function d_theme_add_page_category_column($columns) {
    $columns['page_category'] = __('دسته‌بندی', 'd-theme');
    return $columns;
}
add_filter('manage_page_posts_columns', 'd_theme_add_page_category_column');

/**
 * نمایش محتوای column
 */
function d_theme_show_page_category_column($column, $post_id) {
    if ($column === 'page_category') {
        $terms = get_the_terms($post_id, 'page_category');
        if ($terms && !is_wp_error($terms)) {
            $term_names = array();
            foreach ($terms as $term) {
                $term_names[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
            }
            echo implode(', ', $term_names);
        } else {
            echo '—';
        }
    }
}
add_action('manage_page_posts_custom_column', 'd_theme_show_page_category_column', 10, 2);

/**
 * تنظیم query برای taxonomy archive صفحات
 * 
 * WordPress به صورت پیش‌فرض فقط post type 'post' را در taxonomy archive نشان می‌دهد
 * این تابع query را برای post type 'page' تنظیم می‌کند
 */
function d_theme_taxonomy_page_category_query($query) {
    // فقط در frontend و برای taxonomy archive
    if (!is_admin() && $query->is_main_query() && is_tax('page_category')) {
        $query->set('post_type', 'page');
        $query->set('posts_per_page', 12);
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'd_theme_taxonomy_page_category_query');

/**
 * Flush rewrite rules بعد از فعال شدن قالب یا تغییر taxonomy
 */
function d_theme_flush_rewrite_rules() {
    if (get_option('d_theme_flush_rewrite_rules_flag')) {
        flush_rewrite_rules();
        delete_option('d_theme_flush_rewrite_rules_flag');
    }
}
add_action('init', 'd_theme_flush_rewrite_rules', 20);

/**
 * Flush rewrite rules بعد از ایجاد، ویرایش یا حذف term
 */
function d_theme_flush_rewrite_on_term_change($term_id, $tt_id, $taxonomy) {
    if ($taxonomy === 'page_category') {
        update_option('d_theme_flush_rewrite_rules_flag', true);
    }
}
add_action('created_page_category', 'd_theme_flush_rewrite_on_term_change', 10, 3);
add_action('edited_page_category', 'd_theme_flush_rewrite_on_term_change', 10, 3);
add_action('delete_page_category', 'd_theme_flush_rewrite_on_term_change', 10, 3);

/**
 * تنظیم flag برای flush rewrite rules
 */
function d_theme_set_flush_rewrite_rules_flag() {
    update_option('d_theme_flush_rewrite_rules_flag', true);
}
add_action('after_switch_theme', 'd_theme_set_flush_rewrite_rules_flag');

/**
 * Force flush rewrite rules (برای استفاده دستی)
 * 
 * این تابع را می‌توانید از functions.php یا هر جای دیگر فراخوانی کنید
 * برای flush کردن rewrite rules
 */
function d_theme_force_flush_rewrite_rules() {
    flush_rewrite_rules();
    update_option('d_theme_flush_rewrite_rules_flag', false);
}

/**
 * اضافه کردن rewrite rule سفارشی برای taxonomy
 * 
 * این تابع URL را به صورت yoursite.com/category-name تنظیم می‌کند
 */
function d_theme_add_page_category_rewrite_rules() {
    // گرفتن همه terms از taxonomy
    $terms = get_terms(array(
        'taxonomy' => 'page_category',
        'hide_empty' => false,
    ));
    
    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            // اضافه کردن rewrite rule برای هر term
            // فرمت: yoursite.com/category-name
            add_rewrite_rule(
                '^' . $term->slug . '/?$',
                'index.php?page_category=' . $term->slug,
                'top'
            );
            
            // برای دسته‌بندی‌های سلسله‌مراتبی
            if ($term->parent) {
                $parent = get_term($term->parent, 'page_category');
                if ($parent && !is_wp_error($parent)) {
                    add_rewrite_rule(
                        '^' . $parent->slug . '/' . $term->slug . '/?$',
                        'index.php?page_category=' . $term->slug,
                        'top'
                    );
                }
            }
        }
    }
}
add_action('init', 'd_theme_add_page_category_rewrite_rules', 20);

/**
 * اضافه کردن query var برای taxonomy
 */
function d_theme_add_page_category_query_var($vars) {
    $vars[] = 'page_category';
    return $vars;
}
add_filter('query_vars', 'd_theme_add_page_category_query_var');

/**
 * تنظیم query برای taxonomy با URL سفارشی
 */
function d_theme_page_category_custom_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        $category_slug = get_query_var('page_category');
        
        if (!empty($category_slug)) {
            // بررسی اینکه آیا این slug مربوط به taxonomy ماست
            $term = get_term_by('slug', $category_slug, 'page_category');
            
            if ($term && !is_wp_error($term)) {
                $query->set('post_type', 'page');
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'page_category',
                        'field' => 'slug',
                        'terms' => $category_slug,
                    ),
                ));
                $query->set('posts_per_page', 12);
                $query->set('orderby', 'menu_order');
                $query->set('order', 'ASC');
                $query->is_tax = true;
                $query->is_archive = true;
                $query->is_home = false;
            }
        }
    }
}
add_action('pre_get_posts', 'd_theme_page_category_custom_query', 10);

/**
 * تغییر URL لینک‌های taxonomy به فرمت بدون prefix
 * 
 * این تابع URL لینک‌های taxonomy را از yoursite.com/category/category-name
 * به yoursite.com/category-name تغییر می‌دهد
 */
function d_theme_page_category_term_link($termlink, $term, $taxonomy) {
    if ($taxonomy === 'page_category') {
        $termlink = home_url('/' . $term->slug . '/');
    }
    return $termlink;
}
add_filter('term_link', 'd_theme_page_category_term_link', 10, 3);

