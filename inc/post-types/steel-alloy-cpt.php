<?php
/**
 * Steel Alloy Custom Post Type
 * 
 * ثبت Custom Post Type برای آلیاژهای فولادی
 * 
 * @package Eghbal_Steel_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * ثبت Custom Post Type: steel_alloy
 */
function eghbal_register_steel_alloy_cpt() {
    
    $labels = array(
        'name'                  => 'آلیاژهای فولادی',
        'singular_name'         => 'آلیاژ فولادی',
        'menu_name'             => 'آلیاژها',
        'name_admin_bar'        => 'آلیاژ فولادی',
        'add_new'               => 'افزودن آلیاژ جدید',
        'add_new_item'          => 'افزودن آلیاژ جدید',
        'new_item'              => 'آلیاژ جدید',
        'edit_item'             => 'ویرایش آلیاژ',
        'view_item'             => 'مشاهده آلیاژ',
        'all_items'             => 'همه آلیاژها',
        'search_items'          => 'جستجوی آلیاژ',
        'parent_item_colon'     => 'آلیاژ والد:',
        'not_found'             => 'آلیاژی یافت نشد',
        'not_found_in_trash'    => 'آلیاژی در زباله‌دان یافت نشد',
        'archives'              => 'آرشیو آلیاژها',
        'insert_into_item'      => 'درج در آلیاژ',
        'uploaded_to_this_item' => 'آپلود شده به این آلیاژ',
        'filter_items_list'     => 'فیلتر لیست آلیاژها',
        'items_list_navigation' => 'ناوبری لیست آلیاژها',
        'items_list'            => 'لیست آلیاژها',
    );
    
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array(
            'slug'       => 'kharid',  // /kharid/1-3505/
            'with_front' => false,
        ),
        'capability_type'     => 'post',
        'has_archive'         => false, // Archive از Taxonomy می‌آد
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-hammer',
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
            'custom-fields',
        ),
        'show_in_rest'        => true, // برای Gutenberg
        'rest_base'           => 'steel-alloys',
    );
    
    register_post_type('steel_alloy', $args);
}
add_action('init', 'eghbal_register_steel_alloy_cpt');

/**
 * ثبت Taxonomy: steel_category
 */
function eghbal_register_steel_category_taxonomy() {
    
    $labels = array(
        'name'                       => 'دسته‌بندی فولاد',
        'singular_name'              => 'دسته‌بندی',
        'menu_name'                  => 'دسته‌بندی‌ها',
        'all_items'                  => 'همه دسته‌ها',
        'parent_item'                => 'دسته والد',
        'parent_item_colon'          => 'دسته والد:',
        'new_item_name'              => 'نام دسته جدید',
        'add_new_item'               => 'افزودن دسته جدید',
        'edit_item'                  => 'ویرایش دسته',
        'update_item'                => 'بروزرسانی دسته',
        'view_item'                  => 'مشاهده دسته',
        'separate_items_with_commas' => 'دسته‌ها را با کاما جدا کنید',
        'add_or_remove_items'        => 'افزودن یا حذف دسته',
        'choose_from_most_used'      => 'انتخاب از پرکاربردترین‌ها',
        'popular_items'              => 'دسته‌های محبوب',
        'search_items'               => 'جستجوی دسته',
        'not_found'                  => 'دسته‌ای یافت نشد',
    );
    
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true, // مثل Categories
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => false,
        'rewrite'           => array(
            'slug'         => 'kharid-foolad', // /kharid-foolad-belbering/
            'with_front'   => false,
            'hierarchical' => false,
        ),
        'show_in_rest'      => true,
    );
    
    register_taxonomy('steel_category', array('steel_alloy'), $args);
}
add_action('init', 'eghbal_register_steel_category_taxonomy');

/**
 * ثبت Taxonomy: steel_application (کاربردها)
 */
function eghbal_register_steel_application_taxonomy() {
    
    $labels = array(
        'name'          => 'کاربردها',
        'singular_name' => 'کاربرد',
        'menu_name'     => 'کاربردها',
    );
    
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => false, // مثل Tags
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => true,
        'rewrite'           => array(
            'slug' => 'karbord',
        ),
        'show_in_rest'      => true,
    );
    
    register_taxonomy('steel_application', array('steel_alloy'), $args);
}
add_action('init', 'eghbal_register_steel_application_taxonomy');

/**
 * اضافه کردن ستون‌های سفارشی به لیست آلیاژها در ادمین
 */
function eghbal_alloy_admin_columns($columns) {
    $new_columns = array();
    
    // ستون Checkbox
    if (isset($columns['cb'])) {
        $new_columns['cb'] = $columns['cb'];
    }
    
    // ستون تصویر شاخص
    $new_columns['thumbnail'] = 'تصویر';
    
    // ستون عنوان
    if (isset($columns['title'])) {
        $new_columns['title'] = $columns['title'];
    }
    
    // ستون کد آلیاژ
    $new_columns['alloy_code'] = 'کد آلیاژ';
    
    // ستون دسته
    if (isset($columns['taxonomy-steel_category'])) {
        $new_columns['taxonomy-steel_category'] = 'دسته‌بندی';
    }
    
    // ستون تاریخ
    if (isset($columns['date'])) {
        $new_columns['date'] = $columns['date'];
    }
    
    return $new_columns;
}
add_filter('manage_steel_alloy_posts_columns', 'eghbal_alloy_admin_columns');

/**
 * محتوای ستون‌های سفارشی
 */
function eghbal_alloy_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(50, 50));
            } else {
                echo '—';
            }
            break;
            
        case 'alloy_code':
            $code = get_post_meta($post_id, 'alloy_code', true);
            if ($code) {
                echo esc_html($code);
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_steel_alloy_posts_custom_column', 'eghbal_alloy_admin_column_content', 10, 2);

/**
 * فیلتر کردن آلیاژها بر اساس دسته در ادمین
 */
function eghbal_alloy_admin_filter() {
    global $typenow;
    
    if ($typenow == 'steel_alloy') {
        $taxonomy = 'steel_category';
        $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
        
        wp_dropdown_categories(array(
            'show_option_all' => 'همه دسته‌ها',
            'taxonomy'        => $taxonomy,
            'name'            => $taxonomy,
            'orderby'         => 'name',
            'selected'        => $selected,
            'hierarchical'    => true,
            'depth'           => 3,
            'show_count'      => true,
            'hide_empty'      => false,
        ));
    }
}
add_action('restrict_manage_posts', 'eghbal_alloy_admin_filter');

/**
 * Flush rewrite rules بعد از activation قالب
 * فقط یکبار اجرا می‌شه
 */
function eghbal_flush_rewrite_rules() {
    eghbal_register_steel_alloy_cpt();
    eghbal_register_steel_category_taxonomy();
    eghbal_register_steel_application_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'eghbal_flush_rewrite_rules');

/**
 * تغییر متن "Enter title here" برای آلیاژها
 */
function eghbal_alloy_title_placeholder($title) {
    $screen = get_current_screen();
    
    if ($screen && $screen->post_type == 'steel_alloy') {
        $title = 'نام آلیاژ (مثال: فولاد بلبرینگ DIN 1.3505 - 100Cr6)';
    }
    
    return $title;
}
add_filter('enter_title_here', 'eghbal_alloy_title_placeholder');

/**
 * پیغام‌های سفارشی برای آلیاژها
 */
function eghbal_alloy_updated_messages($messages) {
    global $post;
    
    $messages['steel_alloy'] = array(
        0  => '',
        1  => sprintf('آلیاژ بروزرسانی شد. <a href="%s">مشاهده آلیاژ</a>', esc_url(get_permalink($post->ID))),
        2  => 'فیلد سفارشی بروزرسانی شد.',
        3  => 'فیلد سفارشی حذف شد.',
        4  => 'آلیاژ بروزرسانی شد.',
        5  => isset($_GET['revision']) ? sprintf('آلیاژ به بازنگری %s بازگردانده شد', wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6  => sprintf('آلیاژ منتشر شد. <a href="%s">مشاهده آلیاژ</a>', esc_url(get_permalink($post->ID))),
        7  => 'آلیاژ ذخیره شد.',
        8  => sprintf('آلیاژ ارسال شد. <a target="_blank" href="%s">پیش‌نمایش آلیاژ</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post->ID)))),
        9  => sprintf('آلیاژ برای تاریخ: <strong>%1$s</strong> زمان‌بندی شد. <a target="_blank" href="%2$s">پیش‌نمایش آلیاژ</a>', date_i18n('Y/m/d @ g:i a', strtotime($post->post_date)), esc_url(get_permalink($post->ID))),
        10 => sprintf('پیش‌نویس آلیاژ بروزرسانی شد. <a target="_blank" href="%s">پیش‌نمایش آلیاژ</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post->ID)))),
    );
    
    return $messages;
}
add_filter('post_updated_messages', 'eghbal_alloy_updated_messages');
