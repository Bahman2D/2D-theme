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
   * Keep logo and header visuals in sync with theme/scroll state
   */
  function syncHeaderLogo(headerElement) {
    const logoImg = document.querySelector('.logo-img');
    if (!logoImg) return;
    
    const darkLogo = logoImg.getAttribute('data-logo-dark');
    const lightLogo = logoImg.getAttribute('data-logo-light') || darkLogo;
    if (!darkLogo && !lightLogo) return;
    
    const theme = document.documentElement.getAttribute('data-theme') || 'dark';
    const header = headerElement || document.getElementById('header');
    const headerTransparent = header && !header.classList.contains('scrolled') && !header.classList.contains('solid-bg');
    
    let targetSrc = logoImg.src;
    if (theme === 'light') {
      targetSrc = headerTransparent
        ? (darkLogo || lightLogo || targetSrc)
        : (lightLogo || darkLogo || targetSrc);
    } else {
      targetSrc = darkLogo || lightLogo || targetSrc;
    }
    
    if (targetSrc) {
      logoImg.src = targetSrc;
    }
  }
  
  /**
   * هدر Scroll Effect
   */
  function initHeaderScroll() {
    const header = document.getElementById('header');
    if (!header) return;
    
    const updateHeaderState = () => {
      const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
      const isScrolled = currentScroll > 50;
      const hasClass = header.classList.contains('scrolled');
      
      if (isScrolled && !hasClass) {
        header.classList.add('scrolled');
      } else if (!isScrolled && hasClass) {
        header.classList.remove('scrolled');
      }
      
      if (isScrolled !== hasClass) {
        syncHeaderLogo(header);
      }
    };
    
    window.addEventListener('scroll', updateHeaderState, { passive: true });
    document.addEventListener('themeChanged', () => syncHeaderLogo(header));
    
    updateHeaderState();
    syncHeaderLogo(header);
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
