<?php
/**
 * Header Template
 * 
 * هدر قالب - شامل منوی 3 سطحی و دکمه‌های عملیاتی
 * 
 * @package D_Theme
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl" data-theme="dark">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <?php
    // Resource hints for better performance
    $template_uri = get_template_directory_uri();
    ?>
    <link rel="dns-prefetch" href="<?php echo esc_url(parse_url(home_url(), PHP_URL_HOST)); ?>">
    <link rel="preconnect" href="<?php echo esc_url($template_uri); ?>" crossorigin>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ========== HEADER ========== -->
<header class="header <?php echo is_front_page() ? '' : 'solid-bg'; ?>" id="header">
    <div class="header-container">
        
        <!-- لوگو -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php bloginfo('name'); ?>">
            <?php
            // Use cached logo URLs for better performance
            $logo_urls = d_theme_get_cached_logo_urls();
            
            if ($logo_urls && !empty($logo_urls['dark'])) :
                $logo_dark_src = esc_url($logo_urls['dark']);
                $logo_light_src = !empty($logo_urls['light']) ? esc_url($logo_urls['light']) : $logo_dark_src;
            ?>
                <!-- Dark Mode Logo (default) -->
                <img src="<?php echo $logo_dark_src; ?>" 
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                     class="logo-img logo-dark"
                     data-logo-dark="<?php echo $logo_dark_src; ?>" 
                     data-logo-light="<?php echo $logo_light_src; ?>"
                     loading="eager"
                     fetchpriority="high">
            <?php 
            else : 
            ?>
                <span class="logo-text"><?php bloginfo('name'); ?></span>
            <?php endif; ?>
        </a>

        <!-- منوی دسکتاپ -->
        <nav class="desktop-nav" aria-label="منوی اصلی">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav-menu',
                    'walker' => class_exists('D_Theme_Menu_Walker') ? new D_Theme_Menu_Walker() : '',
                    'fallback_cb' => false,
                ));
            } else {
                // منوی پیش‌فرض اگر منو تنظیم نشده باشد
                echo '<ul class="nav-menu">';
                echo '<li class="nav-item"><a href="' . esc_url(home_url('/')) . '" class="nav-link">خانه</a></li>';
                echo '<li class="nav-item"><a href="#" class="nav-link">محصولات</a></li>';
                echo '<li class="nav-item"><a href="#" class="nav-link">بلاگ</a></li>';
                echo '<li class="nav-item"><a href="#" class="nav-link">تماس با ما</a></li>';
                echo '</ul>';
            }
            ?>
        </nav>

        <!-- دکمه‌های عملیاتی -->
        <div class="header-actions">
            
            <!-- دکمه سرچ -->
            <button class="icon-btn" id="searchBtn" aria-label="جستجو" title="جستجو">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
            </button>

            <!-- دکمه تم شب/روز -->
            <button class="icon-btn" id="themeToggle" aria-label="تغییر تم" title="تغییر تم">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="lightIcon" aria-hidden="true">
                    <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L5.99 4.58zm12.37 12.37c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0 .39-.39.39-1.03 0-1.41l-1.06-1.06zm1.06-10.96c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06zM7.05 18.36c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06z"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="darkIcon" style="display: none;" aria-hidden="true">
                    <path d="M9 2c-1.05 0-2.05.16-3 .46 4.06 1.27 7 5.06 7 9.54 0 4.48-2.94 8.27-7 9.54.95.3 1.95.46 3 .46 5.52 0 10-4.48 10-10S14.52 2 9 2z"/>
                </svg>
            </button>

        </div>

    </div>
</header>

<!-- ========== MOBILE MENU ========== -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <h2 class="mobile-menu-title">منوی سایت</h2>
        <button class="mobile-menu-close" id="mobileMenuClose" aria-label="بستن منو">✕</button>
    </div>
    
    <div class="mobile-menu-content">
        <?php
        if (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'mobile-menu-list',
                'walker' => class_exists('D_Theme_Mobile_Menu_Walker') ? new D_Theme_Mobile_Menu_Walker() : '',
                'fallback_cb' => false,
            ));
        } else {
            // منوی پیش‌فرض موبایل
            echo '<div class="mobile-menu-item">';
            echo '<a href="' . esc_url(home_url('/')) . '" class="mobile-menu-link"><span>خانه</span></a>';
            echo '</div>';
            echo '<div class="mobile-menu-item">';
            echo '<a href="#" class="mobile-menu-link"><span>محصولات</span></a>';
            echo '</div>';
            echo '<div class="mobile-menu-item">';
            echo '<a href="#" class="mobile-menu-link"><span>بلاگ</span></a>';
            echo '</div>';
            echo '<div class="mobile-menu-item">';
            echo '<a href="#" class="mobile-menu-link"><span>تماس با ما</span></a>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- ========== SEARCH MODAL ========== -->
<div class="search-modal" id="searchModal" role="dialog" aria-labelledby="searchModalTitle" aria-modal="true">
    <div class="search-modal-content">
        <div class="search-modal-header">
            <h2 class="search-modal-title" id="searchModalTitle">جستجو در سایت</h2>
            <button class="search-modal-close" id="searchModalClose" aria-label="بستن جستجو">✕</button>
        </div>
        
        <div class="search-input-wrapper">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <label for="searchInput" class="sr-only">جستجو</label>
                <input type="search" 
                       id="searchInput"
                       class="search-input" 
                       placeholder="نام محصول، دسته‌بندی یا مقاله را جستجو کنید..." 
                       name="s" 
                       value="<?php echo get_search_query(); ?>"
                       required
                       autocomplete="off">
                <button type="submit" class="search-input-icon" aria-label="جستجو">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                </button>
            </form>
        </div>

        <div class="search-suggestions">
            <div class="search-suggestions-title">جستجوهای پیشنهادی:</div>
            <?php
            // جستجوهای پیشنهادی - پویا با استفاده از صفحات مهم
            $suggestions = d_theme_get_cached('search_suggestions', function() {
                $suggestions = array();
                
                // صفحات مهم
                $important_pages = array('محصولات', 'بلاگ', 'درباره ما', 'تماس با ما');
                
                foreach ($important_pages as $page_title) {
                    $page = get_page_by_title($page_title);
                    if ($page) {
                        $suggestions[] = array(
                            'title' => $page_title,
                            'url' => get_permalink($page->ID),
                            'icon' => '🔍'
                        );
                    }
                }
                
                // اگر هیچ صفحه‌ای پیدا نشد، از پیش‌فرض استفاده کن
                if (empty($suggestions)) {
                    $suggestions = array(
                        array('title' => 'محصولات', 'url' => home_url('/?s=محصولات'), 'icon' => '🔍'),
                        array('title' => 'بلاگ', 'url' => home_url('/?s=بلاگ'), 'icon' => '📝'),
                        array('title' => 'درباره ما', 'url' => home_url('/?s=درباره'), 'icon' => 'ℹ️')
                    );
                }
                
                return $suggestions;
            }, HOUR_IN_SECONDS);
            
            if (!empty($suggestions) && is_array($suggestions)) :
                foreach ($suggestions as $suggestion) :
                    $url = isset($suggestion['url']) ? $suggestion['url'] : home_url('/?s=' . urlencode($suggestion['title']));
                    $icon = isset($suggestion['icon']) ? $suggestion['icon'] : '🔍';
            ?>
                <a href="<?php echo esc_url($url); ?>" class="search-suggestion-item">
                    <?php echo esc_html($icon . ' ' . esc_html($suggestion['title'])); ?>
                </a>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>

<?php
// Hook بعد از header
d_theme_after_header();
?>
