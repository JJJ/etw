/**
 * @package Make Plus
 */

/* global jQuery */

(function($) {
	'use strict';

	var MakePlus = {
		/**
		 * Cache elements for later
		 *
		 * @since 1.7.0.
		 */
		cache: {
			$window: $(window),
			$document: $(document)
		},

		/**
		 * Initialize the sticky header functionality.
		 *
		 * @since 1.7.0.
		 */
		initStickyHeader: function() {
			var self = this,
				$el;

			self.cache.$stickyheader = $('.makeplus-sticky-header');

			self.cache.$document.ready(function() {
				if (self.cache.$stickyheader.length > 0) {
					if (self.cache.$stickyheader.hasClass('sticky-header-bar')) {
						$el = self.cache.$stickyheader.find('.header-bar');
					} else if (self.cache.$stickyheader.hasClass('sticky-site-header')) {
						$el = self.cache.$stickyheader;
					}

					self.makeSticky($el);
					self.initAnchorOffset($el);
				}
			});
		},

		/**
		 * Clone the element and add a class to apply sticky styles to it.
		 *
		 * @since 1.7.0.
		 *
		 * @param $el    A jQuery object
		 */
		makeSticky: function($el) {
			$el.clone().attr('aria-hidden', true).insertAfter($el);
			$el.addClass('makeplus-is-sticky');
		},

		/**
		 * Calculate the height to offset and bind events.
		 *
		 * @since 1.7.3.
		 *
		 * @param $el    A jQuery object
		 */
		initAnchorOffset: function($el) {
			var self = MakePlus,
				$adminbar = $('#wpadminbar');

			self.cache.headerheight = $el.innerHeight();
			if ($adminbar.length > 0) {
				self.cache.headerheight += $adminbar.innerHeight();
			}

			self.cache.$window.on('hashchange', self.anchorOffset);

			self.anchorOffset();
		},

		/**
		 * Offset the scroll position of the document to account for the sticky header.
		 *
		 * @since 1.7.3.
		 */
		anchorOffset: function() {
			var self = MakePlus,
				$target = $(':target'),
				offset, posish;

			if ($target.length > 0) {
				offset = $(':target').offset();
				posish = parseInt(offset.top) - self.cache.headerheight;

				self.cache.$document.scrollTop(posish);
			}
		}
	};

	MakePlus.initStickyHeader();
})(jQuery);