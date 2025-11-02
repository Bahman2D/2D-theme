<?php
/**
 * Schema.org Markup
 * 
 * اضافه کردن Schema Markup برای بهبود سئو
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// جلوگیری از دسترسی مستقیم
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

/**
 * اضافه کردن Schema Organization به footer
 */
function d_theme_organization_schema() {
    if (!is_front_page()) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'description' => get_bloginfo('description'),
    );
    
    // لوگو
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_url = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($logo_url) {
            $schema['logo'] = $logo_url[0];
        }
    }
    
    // شبکه‌های اجتماعی
    $social_links = array();
    $socials = array('telegram', 'instagram', 'whatsapp', 'linkedin', 'twitter');
    
    foreach ($socials as $social) {
        $link = get_theme_mod("social_{$social}");
        if ($link) {
            $social_links[] = $link;
        }
    }
    
    if (!empty($social_links)) {
        $schema['sameAs'] = $social_links;
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_footer', 'd_theme_organization_schema');

/**
 * اضافه کردن Schema WebSite با SearchAction
 */
function d_theme_website_schema() {
    if (!is_front_page()) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'description' => get_bloginfo('description'),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}')
            ),
            'query-input' => 'required name=search_term_string'
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_footer', 'd_theme_website_schema');

/**
 * اضافه کردن Schema Article برای پست‌ها
 */
function d_theme_article_schema() {
    if (!is_single()) {
        return;
    }
    
    global $post;
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title(),
        'description' => get_the_excerpt(),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
        'author' => array(
            '@type' => 'Person',
            'name' => get_the_author()
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'url' => home_url('/')
        )
    );
    
    // تصویر شاخص
    if (has_post_thumbnail()) {
        $image_url = get_the_post_thumbnail_url($post->ID, 'full');
        if ($image_url) {
            $schema['image'] = $image_url;
        }
    }
    
    // لوگو برای publisher
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_url = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($logo_url) {
            $schema['publisher']['logo'] = array(
                '@type' => 'ImageObject',
                'url' => $logo_url[0]
            );
        }
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_footer', 'd_theme_article_schema');

/**
 * اضافه کردن Schema Breadcrumb
 */
function d_theme_breadcrumb_schema() {
    if (is_front_page()) {
        return;
    }
    
    $items = array();
    $position = 1;
    
    // خانه
    $items[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'خانه',
        'item' => home_url('/')
    );
    
    // دسته‌بندی
    if (is_category() || is_single()) {
        $categories = get_the_category();
        if ($categories) {
            foreach ($categories as $category) {
                $items[] = array(
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => $category->name,
                    'item' => get_category_link($category->term_id)
                );
            }
        }
    }
    
    // صفحه/پست فعلی
    if (is_single() || is_page()) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
    }
    
    if (count($items) > 1) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_footer', 'd_theme_breadcrumb_schema');

/**
 * اضافه کردن Schema FAQPage برای صفحات با آکاردئون
 */
function d_theme_faq_schema() {
    // این تابع را می‌توانید برای صفحات سوالات متداول فعال کنید
    // مثال:
    // if (is_page('faq')) {
    //     $faq_items = array(); // دریافت سوالات از ACF یا محتوای صفحه
    //     $schema = array(
    //         '@context' => 'https://schema.org',
    //         '@type' => 'FAQPage',
    //         'mainEntity' => $faq_items
    //     );
    //     echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
    // }
}
add_action('wp_footer', 'd_theme_faq_schema');
