/**
 * Hero Slider - D Theme
 * اسکریپت اسلایدر Hero صفحه اصلی
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  let currentSlide = 0;
  const slides = document.querySelectorAll('.hero-slide');
  const dots = document.querySelectorAll('.hero-nav-dot');
  const totalSlides = slides.length;
  
  if (totalSlides === 0) return;
  
  let slideInterval;
  let isAnimating = false;
  
  /**
   * نمایش اسلاید
   */
  function showSlide(index) {
    if (isAnimating) return;
    isAnimating = true;
    
    // محدود کردن index
    if (index >= totalSlides) {
      currentSlide = 0;
    } else if (index < 0) {
      currentSlide = totalSlides - 1;
    } else {
      currentSlide = index;
    }
    
    // حذف کلاس active از همه
    slides.forEach(slide => {
      slide.classList.remove('active');
      slide.setAttribute('aria-hidden', 'true');
    });
    
    dots.forEach(dot => {
      dot.classList.remove('active');
      dot.setAttribute('aria-selected', 'false');
    });
    
    // اضافه کردن active به اسلاید فعلی
    slides[currentSlide].classList.add('active');
    slides[currentSlide].setAttribute('aria-hidden', 'false');
    
    dots[currentSlide].classList.add('active');
    dots[currentSlide].setAttribute('aria-selected', 'true');
    
    // تاخیر برای جلوگیری از کلیک‌های سریع
    setTimeout(() => {
      isAnimating = false;
    }, 600);
  }
  
  /**
   * اسلاید بعدی
   */
  function nextSlide() {
    showSlide(currentSlide + 1);
  }
  
  /**
   * اسلاید قبلی
   */
  function prevSlide() {
    showSlide(currentSlide - 1);
  }
  
  /**
   * شروع اتوپلی
   */
  function startAutoPlay() {
    stopAutoPlay();
    slideInterval = setInterval(nextSlide, 5000);
  }
  
  /**
   * توقف اتوپلی
   */
  function stopAutoPlay() {
    if (slideInterval) {
      clearInterval(slideInterval);
    }
  }
  
  /**
   * دکمه‌های بعدی/قبلی
   */
  const nextBtn = document.getElementById('heroNext');
  const prevBtn = document.getElementById('heroPrev');
  
  if (nextBtn) {
    nextBtn.addEventListener('click', function() {
      nextSlide();
      startAutoPlay();
    });
  }
  
  if (prevBtn) {
    prevBtn.addEventListener('click', function() {
      prevSlide();
      startAutoPlay();
    });
  }
  
  /**
   * Navigation Dots
   */
  dots.forEach((dot, index) => {
    dot.addEventListener('click', function() {
      showSlide(index);
      startAutoPlay();
    });
  });
  
  /**
   * Keyboard Navigation
   */
  document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
      const heroSection = document.querySelector('.hero-slider');
      if (!heroSection) return;
      
      // فقط اگر اسلایدر در viewport باشد
      const rect = heroSection.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom > 0) {
        if (e.key === 'ArrowRight') {
          prevSlide(); // در RTL، راست = قبلی
          startAutoPlay();
        } else if (e.key === 'ArrowLeft') {
          nextSlide(); // در RTL، چپ = بعدی
          startAutoPlay();
        }
      }
    }
  });
  
  /**
   * توقف اتوپلی هنگام hover
   */
  const heroSlider = document.querySelector('.hero-slider');
  
  if (heroSlider) {
    heroSlider.addEventListener('mouseenter', stopAutoPlay);
    heroSlider.addEventListener('mouseleave', startAutoPlay);
    
    // توقف اتوپلی هنگام focus روی دکمه‌ها
    const controls = heroSlider.querySelectorAll('button, a');
    controls.forEach(control => {
      control.addEventListener('focus', stopAutoPlay);
      control.addEventListener('blur', startAutoPlay);
    });
  }
  
  /**
   * Swipe Support برای موبایل
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
        // Swipe left - بعدی
        nextSlide();
      } else {
        // Swipe right - قبلی
        prevSlide();
      }
      startAutoPlay();
    }
  }
  
  /**
   * Pause/Resume با Visibility API
   */
  document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
      stopAutoPlay();
    } else {
      startAutoPlay();
    }
  });
  
  /**
   * مقداردهی اولیه
   */
  function init() {
    showSlide(0);
    startAutoPlay();
    
    // Preload تصاویر background اگر وجود داشته باشند
    slides.forEach(slide => {
      const bg = window.getComputedStyle(slide).backgroundImage;
      
      // Only preload when we actually have a URL-based background (skip gradients)
      if (!bg || bg === 'none' || !bg.startsWith('url(')) {
        return;
      }

      const url = bg.slice(4, -1).replace(/"/g, '');
      if (!url) {
        return;
      }

      const img = new Image();
      img.src = url;
    });
  }
  
  init();
  
  /**
   * API عمومی
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
