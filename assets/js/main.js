/**
 * Main JavaScript - D Theme
 * Main theme script
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  // Cache DOM elements
  const header = document.getElementById('header');
  const logoImg = document.querySelector('.logo-img');
  
  /**
   * Keep logo and header visuals in sync with theme/scroll state
   */
  function syncHeaderLogo(headerElement) {
    if (!logoImg || !headerElement) return;
    
    const darkLogo = logoImg.getAttribute('data-logo-dark');
    const lightLogo = logoImg.getAttribute('data-logo-light') || darkLogo;
    if (!darkLogo && !lightLogo) return;
    
    const theme = document.documentElement.getAttribute('data-theme') || 'dark';
    const headerTransparent = !headerElement.classList.contains('scrolled') && !headerElement.classList.contains('solid-bg');
    
    let targetSrc = logoImg.src;
    if (theme === 'light') {
      targetSrc = headerTransparent
        ? (darkLogo || lightLogo || targetSrc)
        : (lightLogo || darkLogo || targetSrc);
    } else {
      targetSrc = darkLogo || lightLogo || targetSrc;
    }
    
    if (targetSrc && logoImg.src !== targetSrc) {
      logoImg.src = targetSrc;
    }
  }
  
  /**
   * Header Scroll Effect with requestAnimationFrame
   */
  function initHeaderScroll() {
    if (!header) return;
    
    let ticking = false;
    let lastScroll = 0;
    
    const updateHeaderState = () => {
      const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
      const isScrolled = currentScroll > 50;
      const hasClass = header.classList.contains('scrolled');
      
      if (isScrolled !== hasClass) {
        if (isScrolled) {
          header.classList.add('scrolled');
        } else {
          header.classList.remove('scrolled');
        }
        syncHeaderLogo(header);
      }
      
      lastScroll = currentScroll;
      ticking = false;
    };
    
    const onScroll = () => {
      if (!ticking) {
        window.requestAnimationFrame(updateHeaderState);
        ticking = true;
      }
    };
    
    window.addEventListener('scroll', onScroll, { passive: true });
    document.addEventListener('themeChanged', () => syncHeaderLogo(header));
    
    // Initial state
    updateHeaderState();
    syncHeaderLogo(header);
  }

  /**
   * Mobile Footer - Active class management
   */
  function initMobileFooter() {
    const mobileFooterItems = document.querySelectorAll('.mobile-footer-item:not(#mobileFooterMenu)');
    
    if (mobileFooterItems.length === 0) return;
    
    mobileFooterItems.forEach(item => {
      item.addEventListener('click', function() {
        mobileFooterItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');
      });
    });
  }
  
  /**
   * Smooth Scroll for anchor links
   */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        // Only for real anchor links, not #
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
   * Back to Top Button (optional)
   */
  function initBackToTop() {
    const backToTop = document.querySelector('.back-to-top');
    if (!backToTop) return;
    
    let ticking = false;
    
    const updateVisibility = () => {
      if (window.pageYOffset > 300) {
        backToTop.classList.add('visible');
      } else {
        backToTop.classList.remove('visible');
      }
      ticking = false;
    };
    
    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(updateVisibility);
        ticking = true;
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
   * Initialize all functions
   */
  function init() {
    initHeaderScroll();
    initMobileFooter();
    initSmoothScroll();
    initBackToTop();
  }
  
  // Execute after DOM is loaded
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
  
})();
