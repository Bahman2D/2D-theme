/**
 * Search Modal - D Theme
 * اسکریپت مودال جستجو
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  const searchBtn = document.getElementById('searchBtn');
  const searchModal = document.getElementById('searchModal');
  const searchModalClose = document.getElementById('searchModalClose');
  const searchInput = document.getElementById('searchInput');
  
  if (!searchModal) return;
  
  /**
   * باز کردن مودال جستجو
   */
  function openSearch() {
    searchModal.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // فوکوس روی اینپوت با تاخیر کوتاه برای انیمیشن
    setTimeout(() => {
      if (searchInput) {
        searchInput.focus();
      }
    }, 300);
  }
  
  /**
   * بستن مودال جستجو
   */
  function closeSearch() {
    searchModal.classList.remove('active');
    document.body.style.overflow = '';
    
    // پاک کردن مقدار اینپوت (اختیاری)
    // if (searchInput) {
    //   searchInput.value = '';
    // }
    
    // بازگشت فوکوس به دکمه جستجو
    if (searchBtn) {
      searchBtn.focus();
    }
  }
  
  /**
   * Event Listeners
   */
  
  // باز کردن جستجو
  if (searchBtn) {
    searchBtn.addEventListener('click', function() {
      openSearch();
    });
  }
  
  // بستن جستجو
  if (searchModalClose) {
    searchModalClose.addEventListener('click', function() {
      closeSearch();
    });
  }
  
  // بستن با کلیک روی overlay
  if (searchModal) {
    searchModal.addEventListener('click', function(e) {
      if (e.target === searchModal) {
        closeSearch();
      }
    });
  }
  
  // بستن با کلید ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && searchModal.classList.contains('active')) {
      closeSearch();
    }
  });
  
  /**
   * کلید Ctrl/Cmd + K برای باز کردن جستجو
   */
  document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      openSearch();
    }
  });
  
  /**
   * جستجوی لحظه‌ای (اختیاری)
   * این بخش را می‌توانید برای AJAX search فعال کنید
   */
  /*
  if (searchInput) {
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
      clearTimeout(searchTimeout);
      
      const query = this.value.trim();
      
      if (query.length < 3) {
        return;
      }
      
      searchTimeout = setTimeout(() => {
        performSearch(query);
      }, 500);
    });
  }
  
  function performSearch(query) {
    // AJAX جستجو
    console.log('Searching for:', query);
    
    // می‌توانید از fetch API استفاده کنید:
    // fetch(dTheme.ajaxUrl + '?action=search&s=' + encodeURIComponent(query))
    //   .then(response => response.json())
    //   .then(data => {
    //     // نمایش نتایج
    //   });
  }
  */
  
})();
