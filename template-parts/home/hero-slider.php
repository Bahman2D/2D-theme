<?php
/**
 * Template Part: Hero Slider
 * 
 * اسلایدر Hero صفحه اصلی - 3 اسلایدی قابل ویرایش از Customizer
 * 
 * @package D_Theme
 * @version 1.0.0
 */

// چک کردن فعال بودن Hero  
// Use get_theme_mod directly for customizer to work properly
if (!get_theme_mod('hero_enabled', true)) {
    return;
}
?>

<section class="hero-slider" role="banner" aria-label="اسلایدر اصلی">
    
    <?php
    // Get cached active slides to reduce database queries
    $active_slides = d_theme_get_cached('hero_active_slides', function() {
        $slides = array();
        $theme_mods = get_theme_mods(); // Get all mods at once
        
        for ($i = 1; $i <= 3; $i++) {
            $key = "hero_slide_{$i}_enabled";
            $enabled = isset($theme_mods[$key]) ? $theme_mods[$key] : true;
            if ($enabled) {
                $slides[] = $i;
            }
        }
        
        return $slides;
    }, HOUR_IN_SECONDS);
    
    // اگر هیچ اسلایدی فعال نیست
    if (empty($active_slides)) {
        return;
    }
    
    // Get all theme mods at once to reduce queries
    $theme_mods = get_theme_mods();
    
    // نمایش اسلایدها
    $slide_index = 0;
    foreach ($active_slides as $i) :
        $is_active = ($slide_index === 0) ? 'active' : '';
        
        // دریافت تنظیمات اسلاید از cached mods
        $title = isset($theme_mods["hero_slide_{$i}_title"]) ? $theme_mods["hero_slide_{$i}_title"] : "عنوان اسلاید {$i}";
        $text = isset($theme_mods["hero_slide_{$i}_text"]) ? $theme_mods["hero_slide_{$i}_text"] : "متن توضیحات اسلاید {$i}";
        $btn1_text = isset($theme_mods["hero_slide_{$i}_btn1_text"]) ? $theme_mods["hero_slide_{$i}_btn1_text"] : 'دکمه 1';
        $btn1_link = isset($theme_mods["hero_slide_{$i}_btn1_link"]) ? $theme_mods["hero_slide_{$i}_btn1_link"] : '#';
        $btn2_text = isset($theme_mods["hero_slide_{$i}_btn2_text"]) ? $theme_mods["hero_slide_{$i}_btn2_text"] : 'دکمه 2';
        $btn2_link = isset($theme_mods["hero_slide_{$i}_btn2_link"]) ? $theme_mods["hero_slide_{$i}_btn2_link"] : '#';
        $gradient_start = isset($theme_mods["hero_slide_{$i}_gradient_start"]) ? $theme_mods["hero_slide_{$i}_gradient_start"] : '#667eea';
        $gradient_end = isset($theme_mods["hero_slide_{$i}_gradient_end"]) ? $theme_mods["hero_slide_{$i}_gradient_end"] : '#764ba2';
        $bg_image = isset($theme_mods["hero_slide_{$i}_bg_image"]) ? $theme_mods["hero_slide_{$i}_bg_image"] : '';
        
        // Build background style
        $bg_style = "background: linear-gradient(135deg, " . esc_attr($gradient_start) . ", " . esc_attr($gradient_end) . ");";
        
        if ($bg_image) {
            $bg_image_url = esc_url($bg_image);
            $bg_style .= " background-image: linear-gradient(135deg, " . esc_attr($gradient_start) . "cc, " . esc_attr($gradient_end) . "cc), url('" . $bg_image_url . "');";
            $bg_style .= " background-size: cover; background-position: center;";
        }
    ?>
    
    <div class="hero-slide <?php echo esc_attr($is_active); ?> hero-slide-<?php echo $i; ?>" 
         style="<?php echo esc_attr($bg_style); ?>"
         aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html($title); ?></h1>
            <p class="hero-text"><?php echo esc_html($text); ?></p>
            <div class="hero-buttons">
                <?php if ($btn1_text) : ?>
                    <a href="<?php echo esc_url($btn1_link); ?>" class="btn btn-white">
                        <?php echo esc_html($btn1_text); ?>
                    </a>
                <?php endif; ?>
                
                <?php if ($btn2_text) : ?>
                    <a href="<?php echo esc_url($btn2_link); ?>" class="btn btn-outline">
                        <?php echo esc_html($btn2_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php 
        $slide_index++;
    endforeach; 
    
    // اگر بیش از یک اسلاید فعال است، کنترل‌ها را نمایش بده
    if (count($active_slides) > 1) :
    ?>
    
    <!-- فلش راست (بعدی) -->
    <button class="hero-arrow hero-arrow-right" id="heroNext" aria-label="اسلاید بعدی">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
        </svg>
    </button>

    <!-- فلش چپ (قبلی) -->
    <button class="hero-arrow hero-arrow-left" id="heroPrev" aria-label="اسلاید قبلی">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
        </svg>
    </button>

    <!-- Navigation Dots -->
    <div class="hero-nav" role="tablist" aria-label="انتخاب اسلاید">
        <?php 
        $dot_index = 0;
        foreach ($active_slides as $slide_num) : 
            $is_active = ($dot_index === 0) ? 'active' : '';
            $aria_selected = ($dot_index === 0) ? 'true' : 'false';
        ?>
            <button class="hero-nav-dot <?php echo esc_attr($is_active); ?>" 
                    data-slide="<?php echo $dot_index; ?>" 
                    role="tab" 
                    aria-label="اسلاید <?php echo ($dot_index + 1); ?>"
                    aria-selected="<?php echo $aria_selected; ?>"></button>
        <?php 
            $dot_index++;
        endforeach; 
        ?>
    </div>
    
    <?php endif; ?>

</section>
