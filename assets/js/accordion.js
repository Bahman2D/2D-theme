/**
 * Accordion Component - D Theme
 * کامپوننت آکاردئون برای سوالات متداول و محتوای تاشو
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  /**
   * مقداردهی اولیه آکاردئون‌ها
   */
  function initAccordions() {
    const accordions = document.querySelectorAll('.accordion');
    
    accordions.forEach(accordion => {
      const items = accordion.querySelectorAll('.accordion-item');
      
      items.forEach(item => {
        const header = item.querySelector('.accordion-header');
        
        if (!header) return;
        
        header.addEventListener('click', () => {
          // بررسی اینکه آیا آیتم فعال است
          const isActive = item.classList.contains('active');
          
          // اگر می‌خواهیم فقط یک آیتم باز باشد (single mode)
          if (accordion.hasAttribute('data-single')) {
            items.forEach(otherItem => {
              if (otherItem !== item) {
                otherItem.classList.remove('active');
              }
            });
          }
          
          // Toggle کردن آیتم فعلی
          item.classList.toggle('active');
          
          // اضافه کردن aria-expanded برای Accessibility
          const isNowActive = item.classList.contains('active');
          header.setAttribute('aria-expanded', isNowActive);
        });
        
        // تنظیم aria-expanded اولیه
        header.setAttribute('aria-expanded', 'false');
        header.setAttribute('role', 'button');
        header.setAttribute('tabindex', '0');
        
        // پشتیبانی از کیبورد (Enter و Space)
        header.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            header.click();
          }
        });
      });
    });
  }
  
  /**
   * اجرای مقداردهی بعد از لود شدن DOM
   */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAccordions);
  } else {
    initAccordions();
  }
  
  /**
   * API عمومی برای دسترسی از خارج
   */
  window.dAccordion = {
    init: initAccordions,
    open: function(itemElement) {
      if (itemElement && !itemElement.classList.contains('active')) {
        itemElement.querySelector('.accordion-header')?.click();
      }
    },
    close: function(itemElement) {
      if (itemElement && itemElement.classList.contains('active')) {
        itemElement.querySelector('.accordion-header')?.click();
      }
    },
    toggle: function(itemElement) {
      itemElement?.querySelector('.accordion-header')?.click();
    }
  };
  
})();
