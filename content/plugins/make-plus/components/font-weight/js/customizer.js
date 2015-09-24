/**
 * Update the font weight options in the Customizer when a font family or
 * font style is chosen.
 *
 * @since 1.6.5.
 */
(function($, data) {
	var api = wp.customize,
		FontWeight;

	FontWeight = {
		controlPrefix: 'ttfmake_',

		/**
		 * Convert the list of typography "groups" into an array
		 */
		groups: data.groups.split(','),

		/**
		 * Bind events to the font controls.
		 *
		 * @since 1.6.5.
		 */
		init: function() {
			var self = this;

			$.each(this.groups, function(i, suffix) {
				api('font-family-' + suffix, 'font-style-' + suffix, 'font-weight-' + suffix, function(familySetting, styleSetting, weightSetting) {
					api.control(self.controlPrefix + 'font-weight-' + suffix, function(weightControl) {
						familySetting.bind(function(family) {
							self.updateWeights(family, styleSetting(), weightSetting, weightControl);
						});

						styleSetting.bind(function(style) {
							self.updateWeights(familySetting(), style, weightSetting, weightControl);
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
		 * @param family string
		 * @param style string
		 * @param weightSetting object
		 * @param weightControl object
		 */
		updateWeights: function(family, style, weightSetting, weightControl) {
			var self = this,
				postdata = {
					action: 'ttfmp_font_weight',
					family: family,
					style:  style,
					value:  weightSetting()
				};

			$.post(data.ajax_url, postdata, function(response) {
				var $select = $('select', weightControl.container);
				$select.html( response );

				if ( $select.val() != weightSetting() ) {
					weightSetting.set( $select.val() );
				}
			});
		}
	};

	FontWeight.init();
})(jQuery, ttfmpFontWeight);