/**
 * Hero Slider - D Theme
 * Hero slider script for front page
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  const slides = document.querySelectorAll('.hero-slide');
  const dots = document.querySelectorAll('.hero-nav-dot');
  const totalSlides = slides.length;
  
  if (totalSlides === 0) return;
  
  let currentSlide = 0;
  let slideInterval;
  let isAnimating = false;
  
  // Cache DOM elements
  const heroSlider = document.querySelector('.hero-slider');
  const nextBtn = document.getElementById('heroNext');
  const prevBtn = document.getElementById('heroPrev');
  
  /**
   * Show slide at index
   */
  function showSlide(index) {
    if (isAnimating) return;
    isAnimating = true;
    
    // Normalize index
    if (index >= totalSlides) {
      currentSlide = 0;
    } else if (index < 0) {
      currentSlide = totalSlides - 1;
    } else {
      currentSlide = index;
    }
    
    // Update slides
    slides.forEach((slide, i) => {
      const isActive = i === currentSlide;
      slide.classList.toggle('active', isActive);
      slide.setAttribute('aria-hidden', !isActive);
    });
    
    // Update dots
    dots.forEach((dot, i) => {
      const isActive = i === currentSlide;
      dot.classList.toggle('active', isActive);
      dot.setAttribute('aria-selected', isActive);
    });
    
    // Reset animation flag
    setTimeout(() => {
      isAnimating = false;
    }, 600);
  }
  
  /**
   * Next slide
   */
  function nextSlide() {
    showSlide(currentSlide + 1);
  }
  
  /**
   * Previous slide
   */
  function prevSlide() {
    showSlide(currentSlide - 1);
  }
  
  /**
   * Start autoplay
   */
  function startAutoPlay() {
    stopAutoPlay();
    slideInterval = setInterval(nextSlide, 5000);
  }
  
  /**
   * Stop autoplay
   */
  function stopAutoPlay() {
    if (slideInterval) {
      clearInterval(slideInterval);
      slideInterval = null;
    }
  }
  
  /**
   * Handle navigation action
   */
  function handleNavigation(action) {
    action();
    startAutoPlay();
  }
  
  /**
   * Setup navigation buttons
   */
  if (nextBtn) {
    nextBtn.addEventListener('click', () => handleNavigation(nextSlide));
  }
  
  if (prevBtn) {
    prevBtn.addEventListener('click', () => handleNavigation(prevSlide));
  }
  
  /**
   * Setup navigation dots
   */
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => handleNavigation(() => showSlide(index)));
  });
  
  /**
   * Keyboard navigation
   */
  document.addEventListener('keydown', function(e) {
    if (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft') return;
    if (!heroSlider) return;
    
    // Only if slider is in viewport
    const rect = heroSlider.getBoundingClientRect();
    if (rect.top >= window.innerHeight || rect.bottom <= 0) return;
    
    if (e.key === 'ArrowRight') {
      handleNavigation(prevSlide); // RTL: right = previous
    } else if (e.key === 'ArrowLeft') {
      handleNavigation(nextSlide); // RTL: left = next
    }
  });
  
  /**
   * Pause autoplay on hover/focus
   */
  if (heroSlider) {
    heroSlider.addEventListener('mouseenter', stopAutoPlay);
    heroSlider.addEventListener('mouseleave', startAutoPlay);
    
    // Pause on focus
    const controls = heroSlider.querySelectorAll('button, a');
    controls.forEach(control => {
      control.addEventListener('focus', stopAutoPlay);
      control.addEventListener('blur', startAutoPlay);
    });
  }
  
  /**
   * Swipe support for mobile
   */
  let touchStartX = 0;
  let touchEndX = 0;
  
  if (heroSlider) {
    heroSlider.addEventListener('touchstart', function(e) {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    
    heroSlider.addEventListener('touchend', function(e) {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    }, { passive: true });
  }
  
  function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        handleNavigation(nextSlide); // Swipe left = next
      } else {
        handleNavigation(prevSlide); // Swipe right = previous
      }
    }
  }
  
  /**
   * Pause/Resume with Visibility API
   */
  document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
      stopAutoPlay();
    } else {
      startAutoPlay();
    }
  });
  
  /**
   * Preload background images
   */
  function preloadImages() {
    slides.forEach(slide => {
      const bg = window.getComputedStyle(slide).backgroundImage;
      
      // Only preload URL-based backgrounds (skip gradients)
      if (!bg || bg === 'none' || !bg.startsWith('url(')) {
        return;
      }

      const url = bg.slice(4, -1).replace(/["']/g, '');
      if (url) {
        const img = new Image();
        img.src = url;
      }
    });
  }
  
  /**
   * Initialize
   */
  function init() {
    showSlide(0);
    startAutoPlay();
    preloadImages();
  }
  
  init();
  
  /**
   * Public API
   */
  window.dThemeHeroSlider = {
    next: nextSlide,
    prev: prevSlide,
    goto: showSlide,
    play: startAutoPlay,
    pause: stopAutoPlay,
    getCurrentSlide: () => currentSlide
  };
  
})();
