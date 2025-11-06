/**
 * Mobile Menu - D Theme
 * Mobile menu script
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  // Cache DOM elements
  const mobileFooterMenu = document.getElementById('mobileFooterMenu');
  const mobileMenu = document.getElementById('mobileMenu');
  const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
  const mobileMenuClose = document.getElementById('mobileMenuClose');
  
  if (!mobileMenu || !mobileMenuOverlay) return;
  
  // Cache menu items selectors
  const menuItemSelector = '.mobile-menu-item > .mobile-menu-link';
  const submenuItemSelector = '.mobile-submenu-item > .mobile-submenu-link';
  const submenuLevel2Selector = '.mobile-submenu-level-2-item > .mobile-submenu-level-2-link';
  const openItemsSelector = '.mobile-menu-item.active, .mobile-submenu-item.active, .mobile-submenu-level-2-item.active';
  
  /**
   * Open mobile menu
   */
  function openMenu() {
    mobileMenu.classList.add('active');
    mobileMenuOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Focus trap for accessibility
    const focusableElements = mobileMenu.querySelectorAll(
      'button, a[href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    if (focusableElements.length > 0) {
      focusableElements[0].focus();
    }
  }
  
  /**
   * Close mobile menu
   */
  function closeMenu() {
    mobileMenu.classList.remove('active');
    mobileMenuOverlay.classList.remove('active');
    document.body.style.overflow = '';
    
    // Close all open submenus
    const openItems = mobileMenu.querySelectorAll(openItemsSelector);
    openItems.forEach(item => {
      item.classList.remove('active');
    });
    
    // Return focus to open button
    if (mobileFooterMenu) {
      mobileFooterMenu.focus();
    }
  }
  
  /**
   * Toggle submenu
   */
  function toggleSubmenu(element, submenuClass) {
    const parent = element.closest('.mobile-menu-item, .mobile-submenu-item, .mobile-submenu-level-2-item');
    if (!parent) return false;
    
    const hasSubmenu = parent.querySelector(submenuClass);
    
    if (hasSubmenu) {
      // Close sibling items at same level
      const siblings = parent.parentElement.children;
      Array.from(siblings).forEach(sibling => {
        if (sibling !== parent) {
          sibling.classList.remove('active');
        }
      });
      
      // Toggle current item
      parent.classList.toggle('active');
      
      return true; // Has submenu
    }
    
    return false; // No submenu
  }
  
  /**
   * Setup accordion for menu items
   */
  function setupAccordion(selector, submenuClass) {
    const items = mobileMenu.querySelectorAll(selector);
    items.forEach(item => {
      item.addEventListener('click', function(e) {
        if (toggleSubmenu(this, submenuClass)) {
          e.preventDefault();
        }
      });
    });
  }
  
  /**
   * Event Listeners
   */
  
  // Open menu
  if (mobileFooterMenu) {
    mobileFooterMenu.addEventListener('click', function(e) {
      e.preventDefault();
      openMenu();
    });
  }
  
  // Close menu
  if (mobileMenuClose) {
    mobileMenuClose.addEventListener('click', closeMenu);
  }
  
  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener('click', closeMenu);
  }
  
  // ESC key to close menu
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
      closeMenu();
    }
  });
  
  // Setup accordions
  setupAccordion(menuItemSelector, '.mobile-submenu');
  setupAccordion(submenuItemSelector, '.mobile-submenu-level-2');
  setupAccordion(submenuLevel2Selector, '.mobile-submenu-level-3');
  
  /**
   * Close menu when resizing to desktop
   */
  let resizeTimer;
  const debounceResize = () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      if (window.innerWidth >= 1024 && mobileMenu.classList.contains('active')) {
        closeMenu();
      }
    }, 250);
  };
  
  window.addEventListener('resize', debounceResize, { passive: true });
  
})();
