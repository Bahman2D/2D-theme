/**
 * Theme Toggle - D Theme
 * Dark/Light theme toggle script
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  const themeToggle = document.getElementById('themeToggle');
  const lightIcon = document.getElementById('lightIcon');
  const darkIcon = document.getElementById('darkIcon');
  const html = document.documentElement;
  
  if (!themeToggle || !html) return;
  
  // Cache logo element
  let logoImg = null;
  
  /**
   * Get system theme preference
   */
  function getSystemTheme() {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
      return 'light';
    }
    return 'dark'; // Default dark
  }
  
  /**
   * Get current theme
   */
  function getCurrentTheme() {
    // First check localStorage
    const savedTheme = localStorage.getItem('d-theme');
    
    if (savedTheme) {
      return savedTheme;
    }
    
    // If not saved, use system theme
    return getSystemTheme();
  }
  
  /**
   * Update icons based on theme
   */
  function updateIcons(theme) {
    if (!lightIcon || !darkIcon) return;
    
    if (theme === 'dark') {
      lightIcon.style.display = 'none';
      darkIcon.style.display = 'block';
      themeToggle.setAttribute('aria-label', 'Switch to light mode');
    } else {
      lightIcon.style.display = 'block';
      darkIcon.style.display = 'none';
      themeToggle.setAttribute('aria-label', 'Switch to dark mode');
    }
    
    // Update logo based on theme (cache logo on first access)
    if (!logoImg) {
      logoImg = document.querySelector('.logo-img');
    }
    
    if (logoImg) {
      const darkLogo = logoImg.getAttribute('data-logo-dark');
      const lightLogo = logoImg.getAttribute('data-logo-light');
      
      if (darkLogo && lightLogo) {
        logoImg.src = theme === 'dark' ? darkLogo : lightLogo;
      }
    }
  }
  
  /**
   * Set theme
   */
  function setTheme(theme) {
    html.setAttribute('data-theme', theme);
    localStorage.setItem('d-theme', theme);
    updateIcons(theme);
    
    // Dispatch custom event for other scripts
    document.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme } }));
  }
  
  /**
   * Toggle theme
   */
  function toggleTheme() {
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    // Smooth animation for theme change
    html.classList.add('theme-transitioning');
    
    setTheme(newTheme);
    
    setTimeout(() => {
      html.classList.remove('theme-transitioning');
    }, 300);
  }
  
  /**
   * Initialize
   */
  function init() {
    const currentTheme = getCurrentTheme();
    setTheme(currentTheme);
    
    // Event listener for button
    themeToggle.addEventListener('click', toggleTheme);
    
    // Listen to system theme changes
    if (window.matchMedia) {
      const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
      mediaQuery.addEventListener('change', (e) => {
        // Only if user hasn't manually selected a theme
        if (!localStorage.getItem('d-theme')) {
          setTheme(e.matches ? 'dark' : 'light');
        }
      });
    }
  }
  
  // Execute initialization
  init();
  
  /**
   * Public API for external access
   */
  window.dThemeToggle = {
    setTheme: setTheme,
    getCurrentTheme: () => html.getAttribute('data-theme'),
    toggleTheme: toggleTheme
  };
  
})();
