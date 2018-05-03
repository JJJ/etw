// =============================================================================
// JS/X-HEAD.JS
// -----------------------------------------------------------------------------
// Site specific functionality needed in <head> element.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Imports
// =============================================================================

// Imports
// =============================================================================

// =include "vendor/everinit.js"
// =============================================================================
// JS/SRC/SITE/INC/X-HEAD-CUSTOM.JS
// -----------------------------------------------------------------------------
// Includes all miscellaneous, custom functionality to be output in the <head>.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Add scrollBottom plugin
//   02. Custom Functionality
// =============================================================================

// Add scrollBottom() plugin
// ---------------------------

jQuery.fn.scrollBottom = function() {
  return jQuery(document).height() - this.scrollTop() - this.height();
};



// Custom Functionality
// =============================================================================

jQuery(document).ready(function($) {

  // Setup Globals
  // -------------

  window.xGlobal = {
    classActive  : 'x-active',
    classFocused : 'x-focused',
  }

  // Prevent Default Behavior on Various Toggles
  // -------------------------------------------

  $('.x-btn-navbar, .x-btn-navbar-search, .x-btn-widgetbar').click(function(e) {
    e.preventDefault();
  });


  // YouTube z-index Fix
  // -------------------

  $('iframe[src*="youtube.com"]').each(function() {
    var url = $(this).attr('src');
    if ($(this).attr('src').indexOf('?') > 0) {
      $(this).attr({
        'src'   : url + '&wmode=transparent',
        'wmode' : 'Opaque'
      });
    } else {
      $(this).attr({
        'src'   : url + '?wmode=transparent',
        'wmode' : 'Opaque'
      });
    }
  });


  // Isotope
  // -------
  // Resize container if gallery navigation is clicked or if an arrow key is
  // pressed to ensure that elements are spaced out properly.

  $('body').on('click', '.x-iso-container .flex-direction-nav a', function() {
    setTimeout(function() { $(window).xsmartresize(); }, 750);
  });

  $('body.x-masonry-active').on('keyup', function(e) {
    if (e.which >= 37 && e.which <= 40) {
      setTimeout(function() { $(window).xsmartresize(); }, 750);
    }
  });

});


