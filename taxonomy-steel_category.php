<?php
if (!defined('ABSPATH')) { exit; }
/**
 * Template: Steel Category Archive
 * 
 * صفحه آرشیو دسته‌بندی فولادها (مثل: خرید فولاد بلبرینگ)
 * 
 * @package Eghbal_Steel_Theme
 * @version 1.0.0
 */

get_header();

// دریافت اطلاعات Term
$term = get_queried_object();
$term_slug = $term->slug;
$term_name = $term->name;
$term_description = term_description();

// رنگ‌های دسته‌بندی
$category_colors = array(
    'bearing-steel' => '#b8b563ff',
    'spring-steel' => '#4ca66dff',
    'nitriding-steel' => '#7d57a1ff',
    'heat-resistant-steel' => '#c26565ff',
    'other-alloys' => '#6e8bb4ff',
);

$category_color = isset($category_colors[$term_slug]) ? $category_colors[$term_slug] : '#3b82f6';

// آیکون‌های دسته
$category_icons = array(
    'bearing-steel' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><circle cx="12" cy="12" r="3"/>',
    'spring-steel' => '<path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>',
    'nitriding-steel' => '<path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94L14.4 2.81c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>',
    'heat-resistant-steel' => '<path d="M11.57 13.16c-1.36.28-2.17 1.16-2.17 2.41 0 1.34 1.11 2.42 2.49 2.42 2.05 0 3.71-1.66 3.71-3.71 0-1.07-.15-2.12-.46-3.12-.79 1.07-2.2 1.72-3.57 2zM13 5.08V2c-6 .8-10.5 6.08-10.5 12.5 0 .83.09 1.64.26 2.41C5.94 15.03 9.59 14 13 14V5.08z"/><path d="M18.5 10c-1.33 0-2.42 1.08-2.42 2.42 0 1.33 1.08 2.42 2.42 2.42 1.33 0 2.42-1.08 2.42-2.42 0-1.33-1.08-2.42-2.42-2.42z"/>',
    'other-alloys' => '<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>',
);

$category_icon = isset($category_icons[$term_slug]) ? $category_icons[$term_slug] : '<circle cx="12" cy="12" r="10"/>';
?>

<main class="archive-category" data-category="<?php echo esc_attr($term_slug); ?>">
    
    <!-- Breadcrumbs -->
    <?php get_template_part('template-parts/home/breadcrumbs'); ?>
    
    <!-- Hero Section -->
    <section class="category-hero" style="--category-accent: <?php echo esc_attr($category_color); ?>">
        <div class="container">
            <div class="hero-content">
                
                <!-- آیکون دسته -->
                <div class="category-icon">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="currentColor">
                        <?php echo $category_icon; ?>
                    </svg>
                </div>
                
                <!-- عنوان -->
                <h1 class="hero-title"><?php echo esc_html($term_name); ?></h1>
                
                <!-- توضیحات -->
                <?php if ($term_description) : ?>
                    <div class="hero-description">
                        <?php echo wp_kses_post($term_description); ?>
                    </div>
                <?php endif; ?>
                
                <!-- آمار سریع -->
                <?php 
                $alloy_count = $term->count;
                ?>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo esc_html($alloy_count); ?></span>
                        <span class="stat-label">آلیاژ موجود</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">پشتیبانی</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">+<?php echo date_i18n('Y') - 1984; ?></span>
                        <span class="stat-label">سال تجربه</span>
                    </div>
                </div>
                
                <!-- دکمه‌ها -->
                <div class="hero-actions">
                    <a href="#alloys-list" class="btn btn-primary">
                        مشاهده آلیاژها
                    </a>
                    <a href="<?php echo esc_url(home_url('/gheymat-' . $term_slug)); ?>" class="btn btn-outline">
                        دریافت قیمت
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- معرفی دسته -->
    <section class="category-intro section-padding">
        <div class="container">
            <div class="intro-grid">
                <div class="intro-content">
                    <h2 class="section-title"><?php echo esc_html($term_name); ?> چیست؟</h2>
                    <div class="intro-text">
                        <?php 
                        // محتوای معرفی دسته (می‌تونی با ACF Term Fields اضافه کنی)
                        echo wp_kses_post($term_description);
                        ?>
                    </div>
                </div>
                
                <div class="intro-features">
                    <h3 class="features-title">ویژگی‌های کلیدی:</h3>
                    <ul class="features-list">
                        <?php 
                        // ویژگی‌های دسته (می‌تونی با ACF Term Fields اضافه کنی)
                        $features = array(
                            'bearing-steel' => array(
                                'سختی بالا پس از عملیات حرارتی',
                                'مقاومت سایشی عالی',
                                'استحکام خستگی بالا',
                                'قابلیت سخت‌کاری یکنواخت'
                            ),
                            'spring-steel' => array(
                                'الاستیسیته و انعطاف‌پذیری بالا',
                                'مقاومت در برابر خستگی',
                                'استحکام تسلیم بالا',
                                'قابلیت بازگشت به شکل اولیه'
                            ),
                            'nitriding-steel' => array(
                                'سختی سطحی بسیار بالا',
                                'مقاومت سایشی عالی',
                                'مقاومت به خوردگی',
                                'پایداری حرارتی'
                            ),
                            'heat-resistant-steel' => array(
                                'مقاومت به اکسیداسیون در دمای بالا',
                                'استحکام در دماهای مرتفع',
                                'مقاومت به خزش',
                                'پایداری ساختاری در حرارت'
                            ),
                            'other-alloys' => array(
                                'تنوع کاربردهای صنعتی',
                                'خواص مکانیکی متنوع',
                                'قابلیت سفارشی‌سازی',
                                'مناسب برای کاربردهای خاص'
                            ),
                        );
                        
                        $current_features = isset($features[$term_slug]) ? $features[$term_slug] : $features['other-alloys'];
                        
                        foreach ($current_features as $feature) :
                        ?>
                            <li>
                                <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                <?php echo esc_html($feature); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- لیست آلیاژها -->
    <section id="alloys-list" class="alloys-section section-padding bg-light">
        <div class="container">
            
            <div class="section-header">
                <h2 class="section-title">انواع <?php echo esc_html($term_name); ?></h2>
                <p class="section-subtitle">برای دریافت مشاوره رایگان و قیمت روز هر آلیاژ، با ما تماس بگیرید</p>
            </div>
            
            <!-- فیلتر و جستجو -->
            <div class="alloys-filters">
                <div class="filter-group">
                    <label for="search-alloy">جستجو:</label>
                    <input type="text" id="search-alloy" class="filter-input" placeholder="جستجو بر اساس کد یا نام...">
                </div>
                
                <div class="filter-group">
                    <label for="sort-alloy">مرتب‌سازی:</label>
                    <select id="sort-alloy" class="filter-select">
                        <option value="date-desc">جدیدترین</option>
                        <option value="date-asc">قدیمی‌ترین</option>
                        <option value="title-asc">الفبایی (الف-ی)</option>
                        <option value="title-desc">الفبایی (ی-الف)</option>
                    </select>
                </div>
            </div>
            
            <!-- Grid آلیاژها -->
            <div class="alloys-grid">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        
                        // دریافت فیلدهای ACF
                        $alloy_code = get_field('alloy_code');
                        $common_name = get_field('common_name');
                        $description_short = get_field('description_short');
                        $hardness = get_field('hardness');
                        $stock_status = get_field('stock_status');
                        $datasheet_pdf = get_field('datasheet_pdf');
                        
                        $status_labels = array(
                            'in_stock' => 'موجود',
                            'on_order' => 'قابل سفارش',
                            'out_of_stock' => 'ناموجود'
                        );
                ?>
                    <article class="alloy-card" data-alloy-code="<?php echo esc_attr($alloy_code); ?>" data-alloy-name="<?php echo esc_attr(get_the_title()); ?>">
                        
                        <!-- تصویر -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="alloy-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                                
                                <?php if ($stock_status) : 
                                    $badge_class = $stock_status === 'in_stock' ? 'success' : ($stock_status === 'on_order' ? 'warning' : 'danger');
                                ?>
                                    <span class="alloy-badge badge-<?php echo esc_attr($badge_class); ?>">
                                        <?php echo esc_html($status_labels[$stock_status]); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- محتوا -->
                        <div class="alloy-card-body">
                            
                            <!-- کد آلیاژ -->
                            <?php if ($alloy_code || $common_name) : ?>
                                <div class="alloy-codes">
                                    <?php if ($alloy_code) : ?>
                                        <span class="code-badge">DIN <?php echo esc_html($alloy_code); ?></span>
                                    <?php endif; ?>
                                    <?php if ($common_name) : ?>
                                        <span class="code-badge secondary"><?php echo esc_html($common_name); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- عنوان -->
                            <h3 class="alloy-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <!-- توضیح کوتاه -->
                            <?php if ($description_short) : ?>
                                <p class="alloy-card-excerpt"><?php echo esc_html(wp_trim_words($description_short, 15)); ?></p>
                            <?php endif; ?>
                            
                            <!-- مشخصات سریع -->
                            <?php if ($hardness) : ?>
                                <div class="alloy-quick-specs">
                                    <span class="spec-item">
                                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94L14.4 2.81c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>
                                        </svg>
                                        سختی: <?php echo esc_html($hardness); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- دکمه‌ها -->
                            <div class="alloy-card-actions">
                                <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary">
                                    مشاهده جزئیات
                                </a>
                                
                                <?php if ($datasheet_pdf) : ?>
                                    <a href="<?php echo esc_url($datasheet_pdf['url']); ?>" class="btn btn-sm btn-outline" download title="دانلود PDF">
                                        <svg class="icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="7 10 12 15 17 10"/>
                                            <line x1="12" y1="15" x2="12" y2="3"/>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php
                    endwhile;
                else :
                ?>
                    <div class="no-results">
                        <svg class="icon" width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        <h3>آلیاژی یافت نشد</h3>
                        <p>در حال حاضر آلیاژی در این دسته موجود نیست.</p>
                    </div>
                <?php
                endif;
                ?>
            </div>
            
            <!-- Pagination -->
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg> قبلی',
                'next_text' => 'بعدی <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>',
            ));
            ?>
        </div>
    </section>
    
    <!-- کاربردهای صنعتی -->
    <section class="applications-section section-padding">
        <div class="container">
            <h2 class="section-title">کاربردهای صنعتی <?php echo esc_html($term_name); ?></h2>
            
            <div class="applications-grid">
                <?php 
                // کاربردهای دسته
                $applications = array(
                    'bearing-steel' => array(
                        array('title' => 'بلبرینگ‌های صنعتی', 'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z'),
                        array('title' => 'رولبرینگ‌ها', 'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z'),
                        array('title' => 'قطعات دقیق', 'icon' => 'M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94L14.4 2.81c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z'),
                        array('title' => 'خودروسازی', 'icon' => 'M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z'),
                    ),
                    'spring-steel' => array(
                        array('title' => 'فنرهای صنعتی', 'icon' => 'M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2z'),
                        array('title' => 'سیستم تعلیق', 'icon' => 'M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z'),
                        array('title' => 'ابزارآلات', 'icon' => 'M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z'),
                        array('title' => 'ماشین‌آلات', 'icon' => 'M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94L14.4 2.81c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z'),
                    ),
                );
                
                $current_apps = isset($applications[$term_slug]) ? $applications[$term_slug] : array();
                
                foreach ($current_apps as $app) :
                ?>
                    <div class="app-card">
                        <div class="app-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                <?php echo $app['icon']; ?>
                            </svg>
                        </div>
                        <h3 class="app-title"><?php echo esc_html($app['title']); ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- CTA -->
    <section class="cta-section section-padding bg-accent">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">نیاز به مشاوره تخصصی دارید؟</h2>
                <p class="cta-text">تیم متخصص ما آماده است تا در انتخاب بهترین <?php echo esc_html($term_name); ?> برای پروژه شما به شما کمک کند.</p>
                <div class="cta-actions">
                    <a href="tel:09121952564" class="btn btn-light btn-lg">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 15.5c-1.2 0-2.4-.2-3.5-.6-.3-.1-.7 0-1 .2l-2.2 2.2c-2.8-1.5-5.2-3.8-6.6-6.6l2.2-2.2c.3-.3.4-.7.2-1-.3-1.1-.5-2.3-.5-3.5 0-.6-.4-1-1-1H4c-.6 0-1 .4-1 1 0 9.4 7.6 17 17 17 .6 0 1-.4 1-1v-3.5c0-.6-.4-1-1-1z"/>
                        </svg>
                        تماس با ما: ۰۹۱۲-۱۹۵-۲۵۶۴
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="btn btn-outline-light btn-lg">
                        فرم تماس
                    </a>
                </div>
            </div>
        </div>
    </section>
    
</main>

<?php get_footer(); ?>
