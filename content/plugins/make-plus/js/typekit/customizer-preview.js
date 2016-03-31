/**
 * @package Make Plus
 */

/* global jQuery, wp, MakePreview */

(function($, wp, MakePreview) {
	'use strict';

	if ( ! wp || ! wp.customize || ! MakePreview ) { return; }

	var api = wp.customize;

	MakePreview.cache.ajax['make-css-inline'] = MakePreview.cache.ajax['make-css-inline'] || {};
	MakePreview.cache.ajax['make-font-json'] = MakePreview.cache.ajax['make-font-json'] || {};

	api('typekit-id', function(setting) {
		MakePreview.cache.ajax['make-css-inline']['makeplus-typekit-id'] = setting();
		MakePreview.cache.ajax['make-font-json']['makeplus-typekit-id'] = setting();

		setting.bind(function(value) {
			MakePreview.cache.ajax['make-css-inline']['makeplus-typekit-id'] = value;
			MakePreview.cache.ajax['make-font-json']['makeplus-typekit-id'] = value;
		});
	});
})(jQuery, wp, MakePreview);