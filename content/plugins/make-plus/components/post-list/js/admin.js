/*!
 * Admin script for Posts List section/widget.
 */
var ajaxurl = ajaxurl || ttfmpPostsList.ajaxurl || '',
	pagenow = pagenow || ttfmpPostsList.pagenow || '';

(function($, ajaxurl, pagenow){
	var Filter = {
		cache: { $document: $(document) },

		/**
		 * Initialize and bind.
		 *
		 * @since 1.6.2.
		 *
		 * @param pagenow
		 */
		init: function(pagenow) {
			if (! pagenow) {
				return;
			}

			var self = this,
				selector = self.getContainerSelector(pagenow);

			// Initialize pre-rendered items
			$(selector).each(function() {
				self.initializeItem($(this));
			});

			// Initialize dynamically added items
			if ('page' == pagenow && 'undefined' != typeof $oneApp) {
				$oneApp.on('afterSectionViewAdded', function(evt, view) {
					if ('postlist' === view.model.get('sectionType')) {
						self.initializeItem(view.$el);
					}
				});
			} else if ('widgets' == pagenow || 'customizer' == pagenow) {
				self.cache.$document.on('widget-added', function(evt, widget) {
					self.initializeItem( $(widget) );
				});
			}
		},

		/**
		 * Determine the Posts List container selector based on the current Admin page.
		 *
		 * @since 1.6.2.
		 *
		 * @param pagenow
		 * @returns {string}
		 */
		getContainerSelector: function(pagenow) {
			var selector = '';

			switch (pagenow) {
				case 'page' :
					selector = '.ttfmake-section-postlist, .ttfmp-widget-area-overlay-region';
					break;
				case 'widgets' :
					selector = '.widget[id*="ttfmp-post-list"]';
					break;
				case 'customizer' :
					selector = '.customize-control-widget_form[id*="ttfmp-post-list"]';
					break;
			}

			return selector;
		},

		/**
		 * Get the jQuery object for the Type select.
		 *
		 * @since 1.6.2.
		 *
		 * @param $el The jQuery object for the item container.
		 * @returns {*|HTMLElement}
		 */
		getTypeSelect: function($el) {
			return $('.ttfmp-posts-list-select-type', $el);
		},

		/**
		 * Get the jQuery object for the From select.
		 *
		 * @since 1.6.2.
		 *
		 * @param $el The jQuery object for the item container.
		 * @returns {*|HTMLElement}
		 */
		getFromSelect: function($el) {
			return $('.ttfmp-posts-list-select-from', $el);
		},

		/**
		 * Find the required elements inside an item and bind events.
		 *
		 * @since 1.6.2.
		 *
		 * @param $el The jQuery object for the item container.
		 */
		initializeItem: function($el) {
			var self = this,
				$this = $el,
				$type = self.getTypeSelect($this),
				$from = self.getFromSelect($this);

			if ($type.length > 0 && $from.length > 0) {
				$type.on('change', function() {
					var value = $(this).val();
					self.updateFromSelect($from, value);
					self.toggleTaxonomyOptions($this, value);
				});
			}
		},

		/**
		 * Fire the Ajax request and repopulate the From select.
		 *
		 * @since 1.6.2.
		 *
		 * @param $el The jQuery object for the From select.
		 * @param type The current value of the Type select.
		 */
		updateFromSelect: function($el, type) {
			var data = {
				action: 'ttfmp_posts_list_filter',
				p: type,
				v: $el.val()
			};

			$.post(ajaxurl, data, function(response) {
				$el.html(response);
			});
		},

		/**
		 * Toggle the visibility of taxonomy display options, depending on the chosen post type.
		 *
		 * @since 1.6.2.
		 *
		 * @param $el The jQuery object for the item container.
		 * @param type The current value of the Type select.
		 */
		toggleTaxonomyOptions: function($el, type) {
			var $options = $('.show-taxonomy', $el);

			if ('post' == type) {
				$options.show();
			} else {
				$options.hide();
			}
		}
	};

	Filter.init(pagenow);
}(jQuery, ajaxurl, pagenow));