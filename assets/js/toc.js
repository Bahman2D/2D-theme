/**
 * Table of Contents JavaScript
 * 
 * عملکرد فهرست مطالب - Responsive با sticky sidebar
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  const toc = document.getElementById('toc');
  if (!toc) return;
  
  const tocToggle = toc.querySelector('.toc-toggle');
  const tocLinks = toc.querySelectorAll('.toc-link');
  
  // تابع برای محاسبه دقیق ارتفاع header + admin bar
  function getHeaderHeight() {
    const header = document.getElementById('header');
    const adminBar = document.getElementById('wpadminbar');
    
    let height = header ? header.offsetHeight : (window.innerWidth >= 1024 ? 100 : 80);
    
    // اضافه کردن ارتفاع admin bar اگر وجود داشته باشد
    if (adminBar) {
      height += adminBar.offsetHeight;
    }
    
    // 20px فاصله اضافی برای راحتی خواندن
    return height + 20;
  }
  
  // ========== Mobile & Tablet Accordion ==========
  if (window.innerWidth < 1024) {
    // پاک کردن localStorage قدیمی (یک بار) - برای رفع مشکل نسخه‌های قدیمی
    const oldState = localStorage.getItem('toc-expanded');
    if (oldState && oldState !== 'true' && oldState !== 'false') {
      localStorage.removeItem('toc-expanded');
    }
    
    // وضعیت از localStorage - دیفالت: بسته (false)
    const savedState = localStorage.getItem('toc-expanded');
    const isExpanded = savedState === 'true'; // فقط اگر صراحتاً true باشد
    
    toc.setAttribute('data-expanded', isExpanded);
    if (tocToggle) {
      tocToggle.setAttribute('aria-expanded', isExpanded);
    }
    
    // Toggle handler
    if (tocToggle) {
      tocToggle.addEventListener('click', function(e) {
        e.preventDefault();
        
        const expanded = toc.getAttribute('data-expanded') === 'true';
        const newState = !expanded;
        
        toc.setAttribute('data-expanded', newState);
        tocToggle.setAttribute('aria-expanded', newState);
        localStorage.setItem('toc-expanded', newState);
      });
    }
  }
  
  // ========== Smooth Scroll ==========
  tocLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      const targetId = this.getAttribute('data-target') || this.getAttribute('href').substring(1);
      const target = document.getElementById(targetId);
      
      if (target) {
        const headerHeight = getHeaderHeight();
        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
        
        window.scrollTo({
          top: Math.max(0, targetPosition),
          behavior: 'smooth'
        });
        
        // Highlight active link
        tocLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      }
    });
  });
  
  // ========== Active Section Highlight ==========
  if (window.innerWidth >= 1024) {
    const headings = Array.from(document.querySelectorAll('h2[id], h3[id], h4[id]'));
    
    if (headings.length === 0) return;
    
    const headerHeight = getHeaderHeight();
    const observerOptions = {
      root: null,
      rootMargin: `-${headerHeight}px 0px -80% 0px`,
      threshold: 0
    };
    
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.getAttribute('id');
          
          // پیدا کردن لینک فعال
          const activeLink = Array.from(tocLinks).find(link => 
            link.getAttribute('data-target') === id
          );
          
          if (activeLink) {
            tocLinks.forEach(l => l.classList.remove('active'));
            activeLink.classList.add('active');
            
            // Scroll TOC to active item
            const tocList = toc.querySelector('.toc-list');
            if (tocList) {
              const linkPosition = activeLink.getBoundingClientRect().top;
              const tocPosition = tocList.getBoundingClientRect().top;
              const offset = linkPosition - tocPosition - 100;
              
              tocList.scrollTo({
                top: tocList.scrollTop + offset,
                behavior: 'smooth'
              });
            }
          }
        }
      });
    }, observerOptions);
    
    headings.forEach(heading => {
      observer.observe(heading);
    });
  }
  
  // ========== Responsive Toggle ==========
  let resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      // Reload behavior on resize
      if (window.innerWidth < 1024) {
        const savedState = localStorage.getItem('toc-expanded');
        toc.setAttribute('data-expanded', savedState === 'true');
      }
    }, 250);
  }, { passive: true });
  
  // ========== Hash Navigation Support ==========
  // اگر صفحه با hash لود شد، scroll کن
  if (window.location.hash) {
    window.addEventListener('load', function() {
      setTimeout(function() {
        const targetId = window.location.hash.substring(1);
        const target = document.getElementById(targetId);
        
        if (target) {
          const headerHeight = getHeaderHeight();
          const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
          
          window.scrollTo({
            top: Math.max(0, targetPosition),
            behavior: 'smooth'
          });
          
          // Highlight corresponding TOC link
          tocLinks.forEach(link => {
            if (link.getAttribute('data-target') === targetId) {
              link.classList.add('active');
            }
          });
        }
      }, 100);
    });
  }
  
})();

