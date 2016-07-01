/**
 * @package Make Plus
 *
 * Update the font weight options in the Customizer when a font family or
 * font style is chosen.
 *
 * @since 1.6.5.
 */

/* global jQuery, wp, MakeControls, MakePlusFontWeight */

(function($, wp, MakeControls, MakePlusFontWeight) {
	'use strict';

	if ( ! wp || ! wp.customize || ! MakeControls ) { return; }

	var api = wp.customize,
		MakePlus;

	MakePlus = $.extend(MakeControls, MakePlusFontWeight);

	MakePlus = $.extend(MakePlus, {
		controlPrefix: 'ttfmake_',

		/**
		 * Bind events to the font controls.
		 *
		 * @since 1.6.5.
		 */
		initFontWeight: function() {
			var self = this;

			$.each(self['typography-groups'], function(i, suffix) {
				api('font-family-' + suffix, 'font-style-' + suffix, 'font-weight-' + suffix, function(familySetting, styleSetting, weightSetting) {
					api.control(self.controlPrefix + 'font-weight-' + suffix, function(weightControl) {
						familySetting.bind(function(family) {
							var data = {
								family: family,
								style:  styleSetting(),
								value:  weightSetting
							};

							self.updateWeights(weightControl, data);
						});

						styleSetting.bind(function(style) {
							var data = {
								family: familySetting(),
								style:  style,
								value:  weightSetting
							};

							self.updateWeights(weightControl, data);
						});
					});
				});
			});
		},

		/**
		 * Make the Ajax request for new font weights and update the select options.
		 *
		 * @since 1.6.5.
		 *
		 * @param weightControl object
		 * @param data          object
		 */
		updateWeights: function(weightControl, weightData) {
			var self = this,
				data = {
					action: 'makeplus-fontweight-load'
				};

			data = $.extend(data, weightData);

			self.sendRequest(data, function(response) {
				var $select = $('select', weightControl.container);
				$select.html(response);

				if ($select.val() != weightControl.setting()) {
					weightControl.setting.set($select.val());
				}
			});
		}
	});

	MakePlus.initFontWeight();
})(jQuery, wp, MakeControls, MakePlusFontWeight);