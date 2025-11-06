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
  const header = document.getElementById('header');
  const headerHeight = header ? header.offsetHeight : 80;
  
  // ========== Mobile Accordion ==========
  if (window.innerWidth < 768) {
    // وضعیت از localStorage
    const savedState = localStorage.getItem('toc-expanded');
    const isExpanded = savedState !== 'false';
    
    toc.setAttribute('data-expanded', isExpanded);
    if (tocToggle) {
      tocToggle.setAttribute('aria-expanded', isExpanded);
    }
    
    // Toggle handler
    if (tocToggle) {
      tocToggle.addEventListener('click', function() {
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
      const targetId = this.getAttribute('data-target') || this.getAttribute('href').substring(1);
      const target = document.getElementById(targetId);
      
      if (target) {
        e.preventDefault();
        
        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
        
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
        
        // Highlight active link
        tocLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      }
    });
  });
  
  // ========== Active Section Highlight ==========
  if (window.innerWidth >= 768) {
    const headings = Array.from(document.querySelectorAll('h2[id], h3[id], h4[id]'));
    
    if (headings.length === 0) return;
    
    const observerOptions = {
      root: null,
      rootMargin: `-${headerHeight + 20}px 0px -80% 0px`,
      threshold: 0
    };
    
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.getAttribute('id');
          const activeLink = toc.querySelector(`.toc-link[data-target="${id}"]`);
          
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
      if (window.innerWidth < 768) {
        const savedState = localStorage.getItem('toc-expanded');
        toc.setAttribute('data-expanded', savedState !== 'false');
      }
    }, 250);
  }, { passive: true });
  
})();

