/**
 * FAQ JavaScript
 * 
 * عملکرد accordion برای FAQ
 * 
 * @package D_Theme
 * @version 1.0.0
 */

(function() {
  'use strict';
  
  const faqSection = document.getElementById('faq-section');
  if (!faqSection) return;
  
  const faqQuestions = faqSection.querySelectorAll('.faq-question');
  
  faqQuestions.forEach(question => {
    const faqItem = question.closest('.faq-item');
    const answer = faqItem.querySelector('.faq-answer');
    
    // Set initial state
    const isExpanded = false;
    question.setAttribute('aria-expanded', isExpanded);
    faqItem.setAttribute('aria-expanded', isExpanded);
    
    // Click handler
    question.addEventListener('click', function() {
      const expanded = question.getAttribute('aria-expanded') === 'true';
      const newState = !expanded;
      
      // Close other items (optional - remove if you want multiple open)
      // faqQuestions.forEach(q => {
      //   if (q !== question) {
      //     q.setAttribute('aria-expanded', 'false');
      //     q.closest('.faq-item').setAttribute('aria-expanded', 'false');
      //   }
      // });
      
      question.setAttribute('aria-expanded', newState);
      faqItem.setAttribute('aria-expanded', newState);
      
      // Smooth scroll to question if opening
      if (newState) {
        setTimeout(() => {
          const questionPosition = question.getBoundingClientRect().top + window.pageYOffset - 100;
          window.scrollTo({
            top: questionPosition,
            behavior: 'smooth'
          });
        }, 100);
      }
    });
  });
  
})();

