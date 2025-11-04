/**
 * Theme Toggle - D Theme
 * اسکریپت تغییر تم شب/روز
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
  
  /**
   * تشخیص تم سیستم
   */
  function getSystemTheme() {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
      return 'light';
    }
    return 'dark'; // دیفالت dark
  }
  
  /**
   * دریافت تم فعلی
   */
  function getCurrentTheme() {
    // ابتدا از localStorage بخوانیم
    const savedTheme = localStorage.getItem('d-theme');
    
    if (savedTheme) {
      return savedTheme;
    }
    
    // اگر ذخیره نشده، از تم سیستم استفاده کنیم
    return getSystemTheme();
  }
  
  /**
   * تنظیم تم
   */
  function setTheme(theme) {
    html.setAttribute('data-theme', theme);
    localStorage.setItem('d-theme', theme);
    updateIcons(theme);
    
    // ارسال event سفارشی برای سایر اسکریپت‌ها
    document.dispatchEvent(new CustomEvent('themeChanged', { detail: { theme } }));
  }
  
  /**
   * بروزرسانی آیکون‌ها
   */
  function updateIcons(theme) {
    if (!lightIcon || !darkIcon) return;
    
    if (theme === 'dark') {
      lightIcon.style.display = 'none';
      darkIcon.style.display = 'block';
      themeToggle.setAttribute('aria-label', 'تغییر به حالت روز');
    } else {
      lightIcon.style.display = 'block';
      darkIcon.style.display = 'none';
      themeToggle.setAttribute('aria-label', 'تغییر به حالت شب');
    }
    
    // تغییر لوگو بر اساس تم
    const logoImg = document.querySelector('.logo-img');
    if (logoImg) {
      const darkLogo = logoImg.getAttribute('data-logo-dark');
      const lightLogo = logoImg.getAttribute('data-logo-light');
      
      if (darkLogo && lightLogo) {
        logoImg.src = theme === 'dark' ? darkLogo : lightLogo;
      }
    }
  }
  
  /**
   * Toggle تم
   */
  function toggleTheme() {
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    // انیمیشن نرم برای تغییر تم
    html.classList.add('theme-transitioning');
    
    setTheme(newTheme);
    
    setTimeout(() => {
      html.classList.remove('theme-transitioning');
    }, 300);
  }
  
  /**
   * مقداردهی اولیه
   */
  function init() {
    const currentTheme = getCurrentTheme();
    setTheme(currentTheme);
    
    // Event listener برای دکمه
    themeToggle.addEventListener('click', toggleTheme);
    
    // گوش دادن به تغییرات تم سیستم
    if (window.matchMedia) {
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        // فقط اگر کاربر خودش تمی انتخاب نکرده
        if (!localStorage.getItem('d-theme')) {
          setTheme(e.matches ? 'dark' : 'light');
        }
      });
    }
  }
  
  // اجرای مقداردهی
  init();
  
  /**
   * API عمومی برای دسترسی از خارج
   */
  window.dThemeToggle = {
    setTheme: setTheme,
    getCurrentTheme: () => html.getAttribute('data-theme'),
    toggleTheme: toggleTheme
  };
  
})();

/**
 * استایل CSS برای انیمیشن نرم تغییر تم
 * این کد باید در یکی از فایل‌های CSS قرار بگیرد
 */
/*
html:not(.theme-transitioning) * {
  transition: background-color 0.3s ease, 
              color 0.3s ease, 
              border-color 0.3s ease,
              box-shadow 0.3s ease !important;
}

html.theme-transitioning * {
  transition: none !important;
}
*/
