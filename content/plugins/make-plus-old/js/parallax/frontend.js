/*!
 * Front end script for the Parallax feature.
 */

/* global jQuery, MakeFrontEnd, MakePlusParallax */

(function($, MakeFrontEnd, MakePlusParallax){
	'use strict';

	if ( ! MakeFrontEnd || ! MakePlusParallax ) { return; }
	
	var MakePlus = $.extend(MakeFrontEnd, MakePlusParallax);

	MakePlus = $.extend(MakePlus, {
		/**
		 * Cache elements for later.
		 *
		 * @since 1.6.1.
		 */
		parallaxCache: function() {
			var ua = navigator.userAgent;
			
			this.cache.$sections = $('.builder-section.has-background.parallax');
			this.cache.hasParallaxDeps = ('undefined' !== typeof $.fn.stellar);
			this.cache.isMobileWebkit = /WebKit/.test(ua) && /Mobile/.test(ua);
		},

		/**
		 * Initialize a page for the Parallax feature.
		 *
		 * @since 1.6.1.
		 */
		parallaxInit: function() {
			var self = this;

			self.parallaxCache();

			if (false == self.cache.hasParallaxDeps || true == self.cache.isMobileWebkit) {
				return;
			}

			self.cache.$document.ready(function() {
				self.cache.$sections.each(function() {
					var $el = $(this);
					self.prepSection($el);
				});

				self.stellarInit();
			});
		},

		/**
		 * Prepare a section to have parallax activated on it.
		 *
		 * @since 1.6.1.
		 *
		 * @param $el    The section's wrapper element.
		 */
		prepSection: function($el) {
			$el
				.css({
					backgroundAttachment: 'fixed'
				})
				.attr({
					'data-stellar-background-ratio': parseFloat(MakePlus.backgroundRatio)
				})
			;
		},

		/**
		 * Initialize the Stellar script and activate parallax.
		 *
		 * @since 1.6.1.
		 */
		stellarInit: function() {
			var stellarConfig = $.parseJSON(MakePlus.stellarConfig);
			$.stellar(stellarConfig);
		}
	});

	MakePlus.parallaxInit();
}(jQuery, MakeFrontEnd, MakePlusParallax));