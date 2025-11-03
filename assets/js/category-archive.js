/**
 * Category Archive JavaScript
 * 
 * @package Eghbal_Steel_Theme
 */

(function($) {
  'use strict';

  $(document).ready(function() {
    initSearch();
    initSort();
  });

  /**
   * Search Filter
   */
  function initSearch() {
    $('#search-alloy').on('keyup', function() {
      var searchTerm = $(this).val().toLowerCase().trim();
      
      $('.alloy-card').each(function() {
        var $card = $(this);
        var alloyCode = $card.data('alloy-code') ? $card.data('alloy-code').toLowerCase() : '';
        var alloyName = $card.data('alloy-name') ? $card.data('alloy-name').toLowerCase() : '';
        var cardText = $card.text().toLowerCase();
        
        if (searchTerm === '' || 
            alloyCode.includes(searchTerm) || 
            alloyName.includes(searchTerm) || 
            cardText.includes(searchTerm)) {
          $card.fadeIn(200);
        } else {
          $card.fadeOut(200);
        }
      });
      
      // Check if no results
      checkNoResults();
    });
  }

  /**
   * Sort Filter
   */
  function initSort() {
    $('#sort-alloy').on('change', function() {
      var sortBy = $(this).val();
      var $grid = $('.alloys-grid');
      var $cards = $grid.find('.alloy-card').get();
      
      $cards.sort(function(a, b) {
        var $a = $(a);
        var $b = $(b);
        
        switch(sortBy) {
          case 'title-asc':
            return $a.data('alloy-name').localeCompare($b.data('alloy-name'), 'fa');
          
          case 'title-desc':
            return $b.data('alloy-name').localeCompare($a.data('alloy-name'), 'fa');
          
          case 'date-asc':
            // Assuming data-date exists
            return new Date($a.data('date')) - new Date($b.data('date'));
          
          case 'date-desc':
          default:
            return new Date($b.data('date')) - new Date($a.data('date'));
        }
      });
      
      // Re-append sorted cards
      $.each($cards, function(index, card) {
        $grid.append(card);
      });
      
      // Animate
      $cards.forEach(function(card) {
        $(card).addClass('fade-in');
      });
    });
  }

  /**
   * Check No Results
   */
  function checkNoResults() {
    var visibleCards = $('.alloy-card:visible').length;
    
    if (visibleCards === 0) {
      if ($('.no-search-results').length === 0) {
        $('.alloys-grid').after(
          '<div class="no-search-results no-results">' +
            '<svg class="icon" width="64" height="64" viewBox="0 0 24 24" fill="currentColor">' +
              '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>' +
            '</svg>' +
            '<h3>نتیجه‌ای یافت نشد</h3>' +
            '<p>لطفاً عبارت جستجوی دیگری امتحان کنید</p>' +
          '</div>'
        );
      }
    } else {
      $('.no-search-results').remove();
    }
  }

})(jQuery);
