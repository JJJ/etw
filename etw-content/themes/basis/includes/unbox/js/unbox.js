/* global jQuery */
(function($) {
	'use strict';

	var unbox = {
		cache: {
			$overlay: $('.unbox-overlay')
		},

		init: function() {
			// When clicking anywhere on the overlay, close the overlay
			$('#wpwrap').on('click', unbox.cache.$overlay, unbox.close);

			// Close the overlay when clicking the close button. Make sure to prevent the default event as it is a link.
			unbox.cache.$overlay.on('click', '.close', function(evt) {
				evt.preventDefault();
				unbox.close();
			});

			// If clicking within the unbox message, do not close the overlay
			unbox.cache.$overlay.on('click', '.unbox-message', unbox.stopPropagation);
		},

		close: function() {
			// Fade and remove the overlay
			unbox.cache.$overlay.fadeOut('fast', function() {
				unbox.cache.$overlay.remove();
			});
		},

		stopPropagation: function(evt) {
			evt.stopPropagation();
		}
	};

	unbox.init();
})(jQuery);