/*!
 * Front end script for the Panels section.
 */

/* global jQuery, MakeFrontEnd, MakePlusPanels */

(function($, MakeFrontEnd, MakePlusPanels){

	if ( ! MakeFrontEnd || ! MakePlusPanels ) { return; }

	var MakePlus = $.extend(MakeFrontEnd, MakePlusPanels);

	MakePlus = $.extend(MakePlus, {
		/**
		 * Add elements to the cache for later use.
		 *
		 * @since 1.6.0.
		 */
		panelsCache: function() {
			this.cache.$document    = $(document);
			this.cache.$accordion   = $('.ttfmp-accordion-container');
			this.cache.$tabs        = $('.ttfmp-tabs-container');
			this.cache.isCustomizer = $(parent.document).find('body').hasClass('wp-customizer');
		},

		/**
		 * Initialize the Panels functionality.
		 *
		 * @since 1.6.0.
		 */
		panelsInit: function() {
			var self = this;

			self.cache.$document.ready(function() {
				self.panelsCache();
				if (self.cache.$accordion.length > 0) {
					self.accordionInit(self.cache.$accordion);
				}
				if (self.cache.$tabs.length > 0 && false == self.cache.isCustomizer) {
					self.tabsInit(self.cache.$tabs);
				}
				// Add the Tabs placeholder if this is in the Customizer
				if (true == self.cache.isCustomizer) {
					self.tabsPlaceholderInit(self.cache.$tabs);
				}
			});
		},

		/**
		 * Initialize Panels sections in Accordion mode.
		 *
		 * @since 1.6.0.
		 *
		 * @param $el    jQuery collection of Accordion containers.
		 */
		accordionInit: function($el) {
			if (! $.fn.accordion) {
				return;
			}

			$el.each(function() {
				var $this = $(this),
					arg = {
						animate: 200,
						icons: false,
						// Scroll to top of panel when it opens, if it is above the viewport.
						// @link http://www.stampede-design.com/blog/2013/04/improving-navigation-on-large-accordion-content-panels/
						activate: function(event, ui) {
							var h = ui.newHeader,
								ws = $(window).scrollTop();
							if (! $.isEmptyObject(h.offset()) && h.offset().top < ws) {
								$('html:not(:animated), body:not(:animated)').animate({
									scrollTop: h.offset().top - h.height()
								}, 'slow');
							}
						}
					},
					data = $this.data();

				$.extend(true, arg, data);

				$this.accordion(arg);
			});
		},

		/**
		 * Initialize Panels sections in Tabs mode.
		 *
		 * @since 1.6.0.
		 *
		 * @param $el    jQuery collection of Tabs containers.
		 */
		tabsInit: function($el) {
			if (! $.fn.tabs) {
				return;
			}

			$el.each(function() {
				var $this = $(this),
					arg = $el.data();
				$this.tabs(arg);
			});
		},

		/**
		 * Set up a non-functional Tabs placeholder that can still be styled in the Customizer.
		 *
		 * As of May 2015, the preview pane in the Customizer is not compatible with the jQuery UI Tabs widget.
		 * @link https://core.trac.wordpress.org/ticket/23225
		 *
		 * @since 1.6.0.
		 *
		 * @param $el    jQuery collection of Tabs containers.
		 */
		tabsPlaceholderInit: function($el) {
			if ('undefined' == typeof MakePlus.tabsPlaceholder) {
				return;
			}

			$el.each(function() {
				var $this = $(this),
					$tabs = $this.find('.ttfmp-panels-item-titles'),
					$content = $this.find('.ttfmp-panels-item-content'),
					$placeholder = $('<div>').addClass('ttfmp-panels-item-content ui-tabs-panel ui-widget-content ui-corner-bottom').html(MakePlus.tabsPlaceholder);
				$this.addClass('ui-tabs ui-widget ui-widget-content ui-corner-all');
				$tabs.addClass('ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all')
					.find('li').addClass('ui-state-default ui-corner-top')
					.find('a').addClass('ui-tabs-anchor').click(function() { return false; });
				$tabs.find('li').first().addClass('ui-tabs-active ui-state-active');
				$content.hide();
				$this.append($placeholder);
			});
		}
	});

	MakePlus.panelsInit();
}(jQuery, MakeFrontEnd, MakePlusPanels));