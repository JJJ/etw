/* global jQuery */

(function($, ttfmpColumnSize) {
	'use strict';

	var columnSize = {
		cache: {
			$stage: $('#ttfmake-stage')
		},

		/**
		 * Initialize the module when the page loads.
		 *
		 * @since 1.6.0.
		 */
		init: function() {
			var self = this,
				$stage = this.cache.$stage;

			// Set up each column section when the page loads
			$stage
				// Make sure newly added sections get set up
				.on('sortcreate', '.ttfmake-text-columns-stage', function() {
					var $section = $(this).parents('.ttfmake-section');
					self.sectionSetup($section);
				})
				// Set up all existing sections
				.find('.ttfmake-section-text').each(function() {
					self.sectionSetup($(this));
				})
			;

			// Redo the column sizing each time the number of active columns changes
			$stage.on('change', '.ttfmake-text-columns', function() {
				var $section = $(this).parents('.ttfmake-section');
				self.removeClasses($section.find('.ttfmake-text-column'), 'ttfmake-column-width-');
				$section.find('.ttfmp-column-size-input').val('');
				self.resizeInit($(this));
			});
		},

		/**
		 * Set up the given section to allow column resizing.
		 *
		 * @since 1.6.0.
		 *
		 * @param $section
		 */
		sectionSetup: function($section) {
			var self = this,
				$container = $section.find('.ttfmp-column-size-container'),
				$columnSelect = $section.find('.ttfmake-text-columns'),
				$columnStage = $section.find('.ttfmake-text-columns-stage');
			$container.appendTo($columnStage);
			self.modifySortables($columnStage, $container);
			self.resizeInit($columnSelect);
		},

		/**
		 * Modify the column sortable functionality to be compatible with the resizing.
		 *
		 * @since 1.6.0.
		 *
		 * @param $stage
		 * @param $container
		 */
		modifySortables: function($stage, $container) {
			// Make sure the column size container is omitted from the sortables
			$stage.sortable('option', 'items', '.ttfmake-text-column');

			// Hide the column size container while items are being sorted
			$stage.on('sortstart', function(event, ui) {
				$container.hide();
			});
			$stage.on('sortstop', function(event, ui) {
				$container.show();
			});
		},

		/**
		 * Initialize the resizing functionality for a particular section.
		 *
		 * @since 1.6.0.
		 *
		 * @param $columnSelect
		 */
		resizeInit: function($columnSelect) {
			var self = this,
				columns = parseInt($columnSelect.val(), 10),
				$section = $columnSelect.parents('.ttfmake-section');

			// Remove previous sliders
			self.tearDown($section);

			// Two column setup
			if (2 === columns) {
				self.twoColInit($section);
			}

			// 3 column setup
			else if (3 === columns) {
				self.threeColInit($section);
			}
		},

		/**
		 * Remove the resizing sliders from a particular section.
		 *
		 * @since 1.6.0.
		 *
		 * @param $section
		 */
		tearDown: function($section) {
			var self = this,
				$sliders = $section.find('.ttfmp-column-size-slider', '.ttfmp-column-size-container');

			if ($sliders.length > 0) {
				$sliders.each(function() {
					$(this).slider('destroy').remove();
				});
			}
		},

		/**
		 * Initialize the resizing sliders in a section with two active columns.
		 *
		 * @since 1.6.0.
		 *
		 * @param $section
		 */
		twoColInit: function($section) {
			var self = this,
				$container = $section.find('.ttfmp-column-size-container'),
				$slider,
				initialValue = self.getSliderValue(1, 2, $section);

			// Add slider element
			$slider = $('<div>').addClass('ttfmp-column-size-slider two-col').appendTo($container);

			// Initialize slider
			$slider.slider({
				value : initialValue,
				min   : -2,
				max   : 2,
				step  : 1
			});

			// Update the column sizes when the slider value changes
			$slider.on('slide', function(e, ui) {
				var classes = self.getColumnClasses(2, ui.value);

				self.removeClasses($section.find('.ttfmake-text-column'), 'ttfmake-column-width-');

				$.each(classes, function(index, size) {
					var i = index + 1;
					$section
						.find('.ttfmake-text-column-position-' + i)
						.addClass('ttfmake-column-width-' + size)
						.find('.ttfmp-column-size-input')
						.val(size)
					;
				});
			});
		},

		/**
		 * Initialize the resizing sliders in a section with three active columns.
		 *
		 * There are two sliders when there are three columns. The first slider corresponds to column 1 and
		 * the second slider corresponds to column 2. Column 3 gets updated based on the sizes of the other columns.
		 *
		 * @since 1.6.0.
		 *
		 * @param $section
		 */
		threeColInit: function($section) {
			var self = this,
				$container = $section.find('.ttfmp-column-size-container'),
				$slider,
				initialValue,
				sliderID;

			// Two sliders
			for (sliderID = 1; sliderID <= 2; sliderID++) {
				// Add the slider element
				initialValue = self.getSliderValue(sliderID, 3, $section);
				$slider = $('<div>').addClass('ttfmp-column-size-slider three-col-' + sliderID).data('id', sliderID).appendTo($container);

				// Initialize the slider
				$slider.slider({
					value: initialValue,
					min  : -1,
					max  : 1,
					step : 1
				});

				// Update the column sizes when the slider value changes
				$slider.on('slide', function (e, ui) {
					var id = parseInt($(this).data('id')),
						classes = self.getColumnClasses(3, ui.value),
						bigger,
						$sibling = $(this).siblings('.ttfmp-column-size-slider').first();

					// Determine which column will be bigger than the other two
					if (ui.value < 0) {
						bigger = id + 1;
					} else {
						bigger = id;
					}

					self.removeClasses($section.find('.ttfmake-text-column'), 'ttfmake-column-width-');

					$.each(classes, function (index, size) {
						var i = index + id;

						if (i == bigger) {
							$section
								.find('.ttfmake-text-column-position-' + bigger)
								.addClass('ttfmake-column-width-' + size)
								.find('.ttfmp-column-size-input')
								.val(size)
							;
						} else {
							$section
								.find('.ttfmake-text-column').not('.ttfmake-text-column-position-' + bigger)
								.addClass('ttfmake-column-width-' + size)
								.find('.ttfmp-column-size-input')
								.val(size)
							;
						}
					});

					// Update the other slider
					$sibling.slider('value', self.getSliderValue($sibling.data('id'), 3, $section));
				});
			}
		},

		/**
		 * Determine the numeric value of the slider based on the existing column sizes.
		 *
		 * @since 1.6.0.
		 *
		 * @param slider
		 * @param columns
		 * @param $section
		 * @returns {number}
		 */
		getSliderValue: function(slider, columns, $section) {
			var range = ttfmpColumnSize[columns],
				$keyPos = $section.find('.ttfmake-text-column-position-' + slider),
				size = $keyPos.find('.ttfmp-column-size-input').val(),
				value = 0;

			if (size) {
				for (var key in range) {
					if (range[key] == size) {
						value = parseInt(key);
						break;
					}
				}
			}

			return value;
		},

		/**
		 * Determine the column classes/input values for a section's columns based on the slider value.
		 *
		 * The first item in the returned array is for the column that corresponds to the slider (either 1 or 2).
		 * The second item is for the other column(s).
		 *
		 * @since 1.6.0.
		 *
		 * @param columns
		 * @param value
		 * @returns {*[]}
		 */
		getColumnClasses: function(columns, value) {
			var range = ttfmpColumnSize[columns],
				val = parseInt(value),
				classes = [ range[val] ];

			// A slider value of 0 means all the columns are equal
			if (0 != val) {
				classes[1] = range[ -val ];
			} else {
				classes[1] = range[val];
			}

			return classes;
		},

		/**
		 * Remove classes with a particular prefix from a specific element set.
		 *
		 * @since 1.3.0.
		 *
		 * @param $el
		 * @param classStub
		 * @returns {*}
		 */
		removeClasses: function($el, classStub) {
			return $el.removeClass(function (index, css) {
				var regex = new RegExp('(^|\\s)' + classStub + '\\S+', 'g');
				return (css.match(regex) || []).join(' ');
			});
		}
	};

	columnSize.init();
})(jQuery, ttfmpColumnSize);