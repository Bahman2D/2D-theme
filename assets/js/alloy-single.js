/**
 * Alloy Single Page JavaScript
 * 
 * @package Eghbal_Steel_Theme
 */

(function($) {
  'use strict';

  $(document).ready(function() {
    initAccordion();
    initQuoteForm();
    initTOCHighlight();
  });

  /**
   * Accordion
   */
  function initAccordion() {
    $('.accordion-header').on('click', function() {
      var $item = $(this).closest('.accordion-item');
      var $accordion = $item.closest('.accordion');
      
      // Check if single mode
      var isSingle = $accordion.data('single') !== undefined;
      
      if (isSingle) {
        // Close all others
        $accordion.find('.accordion-item').not($item).removeClass('active');
      }
      
      // Toggle current
      $item.toggleClass('active');
    });
  }

  /**
   * Quote Form Submit
   */
  function initQuoteForm() {
    $('#quoteForm').on('submit', function(e) {
      e.preventDefault();
      
      var $form = $(this);
      var $button = $form.find('button[type="submit"]');
      var formData = $form.serialize();
      
      // Disable button
      $button.prop('disabled', true).html('<span class="loading-spinner"></span> در حال ارسال...');
      
      $.ajax({
        url: eghbalData.ajaxUrl,
        type: 'POST',
        data: formData,
        success: function(response) {
          if (response.success) {
            // Success message
            $form.before('<div class="alert alert-success">درخواست شما با موفقیت ارسال شد. به زودی با شما تماس می‌گیریم.</div>');
            $form[0].reset();
          } else {
            // Error message
            $form.before('<div class="alert alert-danger">خطا در ارسال فرم. لطفاً دوباره تلاش کنید.</div>');
          }
        },
        error: function() {
          $form.before('<div class="alert alert-danger">خطا در ارسال فرم. لطفاً دوباره تلاش کنید.</div>');
        },
        complete: function() {
          // Re-enable button
          $button.prop('disabled', false).html('<svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg> ارسال درخواست');
          
          // Remove alert after 5 seconds
          setTimeout(function() {
            $('.alert').fadeOut(function() {
              $(this).remove();
            });
          }, 5000);
        }
      });
    });
  }

  /**
   * TOC Highlight on Scroll
   */
  function initTOCHighlight() {
    var $sections = $('.content-section[id]');
    var $navLinks = $('.toc-nav a');
    
    if ($sections.length === 0 || $navLinks.length === 0) return;
    
    $(window).on('scroll', function() {
      var scrollPos = $(window).scrollTop() + 100;
      
      $sections.each(function() {
        var $section = $(this);
        var sectionTop = $section.offset().top;
        var sectionBottom = sectionTop + $section.outerHeight();
        var sectionId = $section.attr('id');
        
        if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
          $navLinks.removeClass('active');
          $('.toc-nav a[href="#' + sectionId + '"]').addClass('active');
        }
      });
    });
  }

})(jQuery);
