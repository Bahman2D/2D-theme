/**
 * Mobile Menu - D Theme
 * اسکریپت منوی موبایل
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  const mobileFooterMenu = document.getElementById('mobileFooterMenu');
  const mobileMenu = document.getElementById('mobileMenu');
  const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
  const mobileMenuClose = document.getElementById('mobileMenuClose');
  
  if (!mobileMenu || !mobileMenuOverlay) return;
  
  /**
   * باز کردن منوی موبایل
   */
  function openMenu() {
    mobileMenu.classList.add('active');
    mobileMenuOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Focus trap برای accessibility
    const focusableElements = mobileMenu.querySelectorAll(
      'button, a[href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    if (focusableElements.length > 0) {
      focusableElements[0].focus();
    }
  }
  
  /**
   * بستن منوی موبایل
   */
  function closeMenu() {
    mobileMenu.classList.remove('active');
    mobileMenuOverlay.classList.remove('active');
    document.body.style.overflow = '';
    
    // بستن همه زیرمنوهای باز
    const openItems = document.querySelectorAll(
      '.mobile-menu-item.active, .mobile-submenu-item.active, .mobile-submenu-level-2-item.active'
    );
    
    openItems.forEach(item => {
      item.classList.remove('active');
    });
    
    // بازگشت فوکوس به دکمه باز کردن
    if (mobileFooterMenu) {
      mobileFooterMenu.focus();
    }
  }
  
  /**
   * Toggle زیرمنو
   */
  function toggleSubmenu(element, submenuClass) {
    const parent = element.parentElement;
    const hasSubmenu = parent.querySelector(submenuClass);
    
    if (hasSubmenu) {
      const isActive = parent.classList.contains('active');
      
      // بستن سایر آیتم‌های هم‌سطح
      const siblings = parent.parentElement.children;
      Array.from(siblings).forEach(sibling => {
        if (sibling !== parent) {
          sibling.classList.remove('active');
        }
      });
      
      // Toggle آیتم فعلی
      parent.classList.toggle('active');
      
      return true; // زیرمنو دارد
    }
    
    return false; // زیرمنو ندارد
  }
  
  /**
   * Event Listeners
   */
  
  // باز کردن منو
  if (mobileFooterMenu) {
    mobileFooterMenu.addEventListener('click', function(e) {
      e.preventDefault();
      openMenu();
    });
  }
  
  // بستن منو
  if (mobileMenuClose) {
    mobileMenuClose.addEventListener('click', closeMenu);
  }
  
  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener('click', closeMenu);
  }
  
  // کلید ESC برای بستن منو
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
      closeMenu();
    }
  });
  
  // آکاردئون سطح اول
  document.querySelectorAll('.mobile-menu-item > .mobile-menu-link').forEach(item => {
    item.addEventListener('click', function(e) {
      if (toggleSubmenu(this, '.mobile-submenu')) {
        e.preventDefault();
      }
    });
  });
  
  // آکاردئون سطح دوم
  document.querySelectorAll('.mobile-submenu-item > .mobile-submenu-link').forEach(item => {
    item.addEventListener('click', function(e) {
      if (toggleSubmenu(this, '.mobile-submenu-level-2')) {
        e.preventDefault();
      }
    });
  });
  
  // آکاردئون سطح سوم
  document.querySelectorAll('.mobile-submenu-level-2-item > .mobile-submenu-level-2-link').forEach(item => {
    item.addEventListener('click', function(e) {
      if (toggleSubmenu(this, '.mobile-submenu-level-3')) {
        e.preventDefault();
      }
    });
  });
  
  /**
   * بستن منو هنگام تغییر اندازه صفحه به دسکتاپ
   */
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      if (window.innerWidth >= 1024 && mobileMenu.classList.contains('active')) {
        closeMenu();
      }
    }, 250);
  });
  
})();
