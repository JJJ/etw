/**
 * @package Make Plus
 */

/* global jQuery, MakePreview, MakePlusFontWeight */

(function($, MakePreview, MakePlusFontWeight) {
	'use strict';

	if ( ! MakePreview ) { return; }

	var MakePlus;

	MakePlus = $.extend(MakePreview, MakePlusFontWeight);

	MakePlus = $.extend(MakePlus, {
		initFontWeight: function() {
			var self = this;

			// Additions to the fontSettings array
			$.each(self['typography-groups'], function(i, suffix) {
				self.fontSettings = self.fontSettings.concat(['font-style-' + suffix, 'font-weight-' + suffix]);
			});
		}
	});

	MakePlus.initFontWeight();
})(jQuery, MakePreview, MakePlusFontWeight);