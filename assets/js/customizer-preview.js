/**
 * Customizer Live Preview - D Theme
 * Live preview updates for Customizer settings
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function($) {
  'use strict';

  /**
   * Update CSS custom properties (colors)
   */
  wp.customize('primary_color', function(value) {
    value.bind(function(newColor) {
      document.documentElement.style.setProperty('--primary', newColor);
    });
  });

  wp.customize('secondary_color', function(value) {
    value.bind(function(newColor) {
      document.documentElement.style.setProperty('--secondary', newColor);
    });
  });

  wp.customize('accent_color', function(value) {
    value.bind(function(newColor) {
      document.documentElement.style.setProperty('--accent', newColor);
    });
  });

  /**
   * Update Hero Slider content
   */
  for (var i = 1; i <= 3; i++) {
    // Title
    wp.customize('hero_slide_' + i + '_title', function(setting) {
      var slideNum = setting.id.replace('hero_slide_', '').replace('_title', '');
      setting.bind(function(newTitle) {
        var slide = document.querySelector('.hero-slide-' + slideNum);
        if (slide) {
          var titleEl = slide.querySelector('.hero-title');
          if (titleEl) {
            titleEl.textContent = newTitle;
          }
        }
      });
    });

    // Text
    wp.customize('hero_slide_' + i + '_text', function(setting) {
      var slideNum = setting.id.replace('hero_slide_', '').replace('_text', '');
      setting.bind(function(newText) {
        var slide = document.querySelector('.hero-slide-' + slideNum);
        if (slide) {
          var textEl = slide.querySelector('.hero-text');
          if (textEl) {
            textEl.textContent = newText;
          }
        }
      });
    });

    // Button 1 Text
    wp.customize('hero_slide_' + i + '_btn1_text', function(setting) {
      var slideNum = setting.id.replace('hero_slide_', '').replace('_btn1_text', '');
      setting.bind(function(newText) {
        var slide = document.querySelector('.hero-slide-' + slideNum);
        if (slide) {
          var btn = slide.querySelector('.hero-buttons .btn:first-child');
          if (btn) {
            btn.textContent = newText;
          }
        }
      });
    });

    // Button 2 Text
    wp.customize('hero_slide_' + i + '_btn2_text', function(setting) {
      var slideNum = setting.id.replace('hero_slide_', '').replace('_btn2_text', '');
      setting.bind(function(newText) {
        var slide = document.querySelector('.hero-slide-' + slideNum);
        if (slide) {
          var buttons = slide.querySelectorAll('.hero-buttons .btn');
          if (buttons.length > 1) {
            buttons[1].textContent = newText;
          }
        }
      });
    });

    // Gradient Start
    wp.customize('hero_slide_' + i + '_gradient_start', function(setting) {
      var slideNum = setting.id.replace('hero_slide_', '').replace('_gradient_start', '');
      setting.bind(function(newColor) {
        var slide = document.querySelector('.hero-slide-' + slideNum);
        if (slide) {
          var endColor = wp.customize('hero_slide_' + slideNum + '_gradient_end').get();
          var bgImage = wp.customize('hero_slide_' + slideNum + '_bg_image').get();
          
          var bgStyle = 'background: linear-gradient(135deg, ' + newColor + ', ' + endColor + ');';
          
          if (bgImage) {
            bgStyle += ' background-image: linear-gradient(135deg, ' + newColor + 'cc, ' + endColor + 'cc), url("' + bgImage + '");';
            bgStyle += ' background-size: cover; background-position: center;';
          }
          
          slide.setAttribute('style', bgStyle);
        }
      });
    });

    // Gradient End
    wp.customize('hero_slide_' + i + '_gradient_end', function(setting) {
      var slideNum = setting.id.replace('hero_slide_', '').replace('_gradient_end', '');
      setting.bind(function(newColor) {
        var slide = document.querySelector('.hero-slide-' + slideNum);
        if (slide) {
          var startColor = wp.customize('hero_slide_' + slideNum + '_gradient_start').get();
          var bgImage = wp.customize('hero_slide_' + slideNum + '_bg_image').get();
          
          var bgStyle = 'background: linear-gradient(135deg, ' + startColor + ', ' + newColor + ');';
          
          if (bgImage) {
            bgStyle += ' background-image: linear-gradient(135deg, ' + startColor + 'cc, ' + newColor + 'cc), url("' + bgImage + '");';
            bgStyle += ' background-size: cover; background-position: center;';
          }
          
          slide.setAttribute('style', bgStyle);
        }
      });
    });
  }

  /**
   * Update Logo Heights
   */
  wp.customize('logo_height_desktop', function(value) {
    value.bind(function(newHeight) {
      var style = document.getElementById('d-theme-logo-css');
      if (!style) {
        style = document.createElement('style');
        style.id = 'd-theme-logo-css';
        document.head.appendChild(style);
      }
      
      var mobileHeight = wp.customize('logo_height_mobile').get();
      style.textContent = '.logo-img { height: ' + newHeight + 'px; }' +
        '@media (max-width: 767px) { .logo-img { height: ' + mobileHeight + 'px; } }';
    });
  });

  wp.customize('logo_height_mobile', function(value) {
    value.bind(function(newHeight) {
      var style = document.getElementById('d-theme-logo-css');
      if (!style) {
        style = document.createElement('style');
        style.id = 'd-theme-logo-css';
        document.head.appendChild(style);
      }
      
      var desktopHeight = wp.customize('logo_height_desktop').get();
      style.textContent = '.logo-img { height: ' + desktopHeight + 'px; }' +
        '@media (max-width: 767px) { .logo-img { height: ' + newHeight + 'px; } }';
    });
  });

})(jQuery);
