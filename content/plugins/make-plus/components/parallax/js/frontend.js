/*!
 * Front end script for the Parallax feature.
 */
(function($, config){
	var Parallax = {
		cache: {
			$document: $(document)
		},

		/**
		 * Cache elements for later.
		 *
		 * @since 1.6.1.
		 */
		populateCache: function() {
			var ua = navigator.userAgent;

			this.cache.$sections = $('.builder-section.has-background.parallax');
			this.cache.hasDeps = ('undefined' !== typeof $.fn.stellar);
			this.cache.isMobileWebkit = /WebKit/.test(ua) && /Mobile/.test(ua);
		},

		/**
		 * Initialize a page for the Parallax feature.
		 *
		 * @since 1.6.1.
		 */
		init: function() {
			var self = this;

			self.populateCache();

			if (false == self.cache.hasDeps || true == self.cache.isMobileWebkit) {
				return;
			}

			self.cache.$document.ready(function() {
				self.cache.$sections.each(function() {
					var $el = $(this);
					self.prepSection($el);
				});

				self.parallaxInit();
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
					'data-stellar-background-ratio': parseFloat(config.backgroundRatio)
				})
			;
		},

		/**
		 * Initialize the Stellar script and activate parallax.
		 *
		 * @since 1.6.1.
		 */
		parallaxInit: function() {
			var stellarConfig = $.parseJSON(config.stellarConfig);
			$.stellar(stellarConfig);
		}
	};

	Parallax.init();
}(jQuery, ttfmpParallax));