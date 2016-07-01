/* global jQuery, _ */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, $, _, oneApp, $oneApp) {
	'use strict';

	// Panels items
	oneApp.PanelsItemView = Backbone.View.extend({
		template: '',
		className: 'ttfmp-panels-item ttfmp-panels-item-open',

		events: {
			'click .ttfmp-panels-item-remove': 'removeItem',
			'click .ttfmp-panels-item-toggle': 'toggleSection'
		},

		initialize: function (options) {
			this.model = options.model;
			this.idAttr = 'ttfmp-panels-item-' + this.model.get('id');
			this.serverRendered = ( options.serverRendered ) ? options.serverRendered : false;
			this.template = _.template($('#tmpl-ttfmake-panels-item').html());
		},

		render: function () {
			this.$el.html(this.template(this.model.toJSON()))
				.attr('id', this.idAttr)
				.attr('data-id', this.model.get('id'));
			return this;
		},

		removeItem: function (evt) {
			evt.preventDefault();

			var $stage = this.$el.parents('.ttfmp-panels'),
				$orderInput = $('.ttfmp-panels-item-order', $stage);

			oneApp.removeOrderValue(this.model.get('id'), $orderInput);

			// Fade and slide out the section, then cleanup view
			this.$el.animate({
				opacity: 'toggle',
				height: 'toggle'
			}, oneApp.options.closeSpeed, function() {
				this.remove();
			}.bind(this));
		},

		toggleSection: function (evt) {
			evt.preventDefault();

			var $this = $(evt.target),
				$section = $this.parents('.ttfmp-panels-item'),
				$sectionBody = $('.ttfmp-panels-item-body', $section),
				$input = $('.ttfmp-panels-item-state', this.$el);

			if ($section.hasClass('ttfmp-panels-item-open')) {
				$sectionBody.slideUp(oneApp.options.closeSpeed, function() {
					$section.removeClass('ttfmp-panels-item-open');
					$input.val('closed');
				});
			} else {
				$sectionBody.slideDown(oneApp.options.openSpeed, function() {
					$section.addClass('ttfmp-panels-item-open');
					$input.val('open');
				});
			}
		}
	});

	// Panels section
	oneApp.PanelsView = oneApp.SectionView.extend({

		events: function() {
			return _.extend({}, oneApp.SectionView.prototype.events, {
				'click .ttfmp-panels-add-item' : 'addItem'
			});
		},

		addItem: function (evt, params) {
			evt.preventDefault();

			var view, html;

			// Create view
			view = new oneApp.PanelsItemView({
				model: new oneApp.PanelsItemModel({
					id: new Date().getTime(),
					parentID: this.getParentID()
				})
			});

			// Append view
			html = view.render().el;
			$('.ttfmp-panels-stage', this.$el).append(html);

			// Only scroll and focus if not triggered by the pseudo event
			if ( ! params ) {
				// Scroll to added view and focus first input
				oneApp.scrollToAddedView(view);
			}

			// Initiate the color picker
			oneApp.initializePanelsColorPicker(view);

			// Add the section value to the sortable order
			oneApp.addOrderValue(view.model.get('id'), $('.ttfmp-panels-item-order', $(view.$el).parents('.ttfmp-panels')));
		},

		getParentID: function() {
			var idAttr = this.$el.attr('id'),
				id = idAttr.replace('ttfmake-section-', '');

			return parseInt(id, 10);
		}
	});

	// Makes panels sortable
	oneApp.initializePanelsItemSortables = function(view) {
		var $selector;
		view = view || '';

		if (view.$el) {
			$selector = $('.ttfmp-panels-stage', view.$el);
		} else {
			$selector = $('.ttfmp-panels-stage');
		}

		$selector.sortable({
			handle: '.ttfmake-sortable-handle',
			placeholder: 'sortable-placeholder',
			forcePlaceholderSizeType: true,
			distance: 2,
			tolerance: 'pointer',
			start: function (event, ui) {
				// Set the height of the placeholder to that of the sorted item
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttfmp-panels-stage');

				$('.sortable-placeholder', $stage).height($item.height());
			},
			stop: function (event, ui) {
				var $item = $(ui.item.get(0)),
					$section = $item.parents('.ttfmake-section'),
					$stage = $item.parents('.ttfmp-panels'),
					$orderInput = $('.ttfmp-panels-item-order', $stage),
					sectionId = $section.attr('data-id'),
					itemId = $item.attr('data-id');

				oneApp.setOrder($(this).sortable('toArray', {attribute: 'data-id'}), $orderInput);

				setTimeout(function() {
					oneApp.initFrame(sectionId + '-' + itemId);
				}, 100);
			}
		});
	};

	// Initialize the color picker
	oneApp.initializePanelsColorPicker = function (view) {
		var $selector;
		view = view || '';

		if (view.$el) {
			$selector = $('.ttfmake-configuration-color-picker', view.$el);
		} else {
			$selector = $('.ttfmake-configuration-color-picker');
		}

		$selector.wpColorPicker();
	};

	// Initialize the sortables
	$oneApp.on('afterSectionViewAdded', function(evt, view) {
		if ('panels' === view.model.get('sectionType')) {
			// Add an initial slide item
			$('.ttfmp-panels-add-item', view.$el).trigger('click', {type: 'pseudo'});

			// Initialize the sortables
			oneApp.initializePanelsItemSortables(view);

			// Initialize the color pickers
			oneApp.initializePanelsColorPicker(view);
		}
	});

	// Initialize available panels
	oneApp.initPanelsItemViews = function ($el) {
		$el = $el || '';
		var $panels = ('' === $el) ? $('.ttfmp-panels-item') : $('.ttfmp-panels-item', $el);

		$panels.each(function () {
			var $item = $(this),
				idAttr = $item.attr('id'),
				id = $item.attr('data-id'),
				$section = $item.parents('.ttfmake-section'),
				parentID = $section.attr('data-id'),
				model, view;

			// Build the model
			model = new oneApp.PanelsItemModel({
				id: id,
				parentID: parentID
			});

			// Build the view
			view = new oneApp.PanelsItemView({
				model: model,
				el: $('#' + idAttr),
				serverRendered: true
			});
		});

		oneApp.initializePanelsItemSortables();
		oneApp.initializePanelsColorPicker();
	};

	// Initialize the views when the app starts up
	oneApp.initPanelsItemViews();
})(window, jQuery, _, oneApp, $oneApp);