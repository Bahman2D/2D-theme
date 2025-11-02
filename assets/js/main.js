/**
 * Main JavaScript - D Theme
 * اسکریپت اصلی قالب
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  /**
   * هدر Scroll Effect
   */
  function initHeaderScroll() {
    const header = document.getElementById('header');
    if (!header) return;
    
    let lastScroll = 0;
    
    window.addEventListener('scroll', function() {
      const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
      
      // اضافه کردن کلاس scrolled
      if (currentScroll > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
      
      lastScroll = currentScroll;
    }, { passive: true });
  }
  
  /**
   * فوتر موبایل - کلاس active
   */
  function initMobileFooter() {
    const mobileFooterItems = document.querySelectorAll('.mobile-footer-item:not(#mobileFooterMenu)');
    
    mobileFooterItems.forEach(item => {
      item.addEventListener('click', function() {
        mobileFooterItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');
      });
    });
  }
  
  /**
   * Smooth Scroll برای لینک‌های anchor
   */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        // فقط برای لینک‌های anchor واقعی، نه #
        if (href !== '#' && href !== '#!') {
          const target = document.querySelector(href);
          
          if (target) {
            e.preventDefault();
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        }
      });
    });
  }
  
  /**
   * Back to Top Button (اختیاری)
   */
  function initBackToTop() {
    const backToTop = document.querySelector('.back-to-top');
    if (!backToTop) return;
    
    window.addEventListener('scroll', function() {
      if (window.pageYOffset > 300) {
        backToTop.classList.add('visible');
      } else {
        backToTop.classList.remove('visible');
      }
    }, { passive: true });
    
    backToTop.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
  
  /**
   * اجرای همه توابع
   */
  function init() {
    initHeaderScroll();
    initMobileFooter();
    initSmoothScroll();
    initBackToTop();
  }
  
  // اجرای کد پس از بارگذاری DOM
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
  
})();
