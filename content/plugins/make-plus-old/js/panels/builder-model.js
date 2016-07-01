/* global Backbone, jQuery, _ */
var oneApp = oneApp || {};

(function (window, Backbone, $, _, oneApp) {
	'use strict';

	oneApp.PanelsItemModel = Backbone.Model.extend({
		defaults: {
			id: '',
			parentID: '',
			sectionType: 'panelsItem'
		}
	});

	// Set up this model as a "no URL model" where data is not synced with the server
	oneApp.PanelsItemModel.prototype.sync = function () { return null; };
	oneApp.PanelsItemModel.prototype.fetch = function () { return null; };
	oneApp.PanelsItemModel.prototype.save = function () { return null; };
})(window, Backbone, jQuery, _, oneApp);