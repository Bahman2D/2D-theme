/**
 * Customizer Live Preview - D Theme
 * پیش‌نمایش زنده تغییرات Customizer
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function($) {
  'use strict';
  
  /**
   * رنگ اصلی (Primary)
   */
  wp.customize('primary_color', function(value) {
    value.bind(function(newval) {
      $('head').find('#d-theme-primary-color-css').remove();
      
      const css = `
        <style id="d-theme-primary-color-css">
          :root {
            --primary: ${newval};
          }
        </style>
      `;
      
      $('head').append(css);
    });
  });
  
  /**
   * رنگ ثانویه (Secondary)
   */
  wp.customize('secondary_color', function(value) {
    value.bind(function(newval) {
      $('head').find('#d-theme-secondary-color-css').remove();
      
      const css = `
        <style id="d-theme-secondary-color-css">
          :root {
            --secondary: ${newval};
          }
        </style>
      `;
      
      $('head').append(css);
    });
  });
  
  /**
   * رنگ تاکیدی (Accent)
   */
  wp.customize('accent_color', function(value) {
    value.bind(function(newval) {
      $('head').find('#d-theme-accent-color-css').remove();
      
      const css = `
        <style id="d-theme-accent-color-css">
          :root {
            --accent: ${newval};
          }
        </style>
      `;
      
      $('head').append(css);
    });
  });
  
  /**
   * ارتفاع لوگو (دسکتاپ)
   */
  wp.customize('logo_height_desktop', function(value) {
    value.bind(function(newval) {
      $('.logo-img').css('height', newval + 'px');
    });
  });
  
  /**
   * Hero Slider - اسلایدها
   */
  for (let i = 1; i <= 3; i++) {
    // عنوان
    wp.customize(`hero_slide_${i}_title`, function(value) {
      value.bind(function(newval) {
        $(`.hero-slide-${i} .hero-title`).text(newval);
      });
    });
    
    // متن
    wp.customize(`hero_slide_${i}_text`, function(value) {
      value.bind(function(newval) {
        $(`.hero-slide-${i} .hero-text`).text(newval);
      });
    });
    
    // دکمه 1 متن
    wp.customize(`hero_slide_${i}_btn1_text`, function(value) {
      value.bind(function(newval) {
        $(`.hero-slide-${i} .hero-buttons .btn-white`).text(newval);
      });
    });
    
    // دکمه 2 متن
    wp.customize(`hero_slide_${i}_btn2_text`, function(value) {
      value.bind(function(newval) {
        $(`.hero-slide-${i} .hero-buttons .btn-outline`).text(newval);
      });
    });
    
    // رنگ گرادینت شروع
    wp.customize(`hero_slide_${i}_gradient_start`, function(value) {
      value.bind(function(newval) {
        updateSlideGradient(i);
      });
    });
    
    // رنگ گرادینت پایان
    wp.customize(`hero_slide_${i}_gradient_end`, function(value) {
      value.bind(function(newval) {
        updateSlideGradient(i);
      });
    });
  }
  
  /**
   * بروزرسانی گرادینت اسلاید
   */
  function updateSlideGradient(slideNum) {
    const start = wp.customize(`hero_slide_${slideNum}_gradient_start`)();
    const end = wp.customize(`hero_slide_${slideNum}_gradient_end`)();
    
    $(`.hero-slide-${slideNum}`).css({
      'background': `linear-gradient(135deg, ${start}, ${end})`
    });
  }
  
})(jQuery);
