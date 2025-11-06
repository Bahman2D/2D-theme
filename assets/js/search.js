/**
 * Search Modal - D Theme
 * Search modal script
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
   * Open search modal
   */
  function openSearch() {
    searchModal.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Focus on input with short delay for animation
    setTimeout(() => {
      if (searchInput) {
        searchInput.focus();
      }
    }, 300);
  }
  
  /**
   * Close search modal
   */
  function closeSearch() {
    searchModal.classList.remove('active');
    document.body.style.overflow = '';
    
    // Return focus to search button
    if (searchBtn) {
      searchBtn.focus();
    }
  }
  
  /**
   * Event Listeners
   */
  
  // Open search
  if (searchBtn) {
    searchBtn.addEventListener('click', openSearch);
  }
  
  // Close search
  if (searchModalClose) {
    searchModalClose.addEventListener('click', closeSearch);
  }
  
  // Close on overlay click
  searchModal.addEventListener('click', function(e) {
    if (e.target === searchModal) {
      closeSearch();
    }
  });
  
  // Keyboard shortcuts (combined handler)
  document.addEventListener('keydown', function(e) {
    // ESC to close
    if (e.key === 'Escape' && searchModal.classList.contains('active')) {
      closeSearch();
      return;
    }
    
    // Ctrl/Cmd + K to open
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      openSearch();
    }
  });
  
})();
