/**
 * @package Make Plus
 */

/* global jQuery, MakeControls, MakePlusTypekit */

(function($, wp, MakeControls, MakePlusTypekit) {
	'use strict';

	if ( ! wp || ! wp.customize || ! MakeControls ) { return; }

	var api = wp.customize,
		MakePlus;

	MakePlus = $.extend(MakeControls, MakePlusTypekit);

	/**
	 * Initialize instances of MAKEPLUS_Component_Typekit_Control
	 *
	 * @since 1.7.0.
	 */
	api.controlConstructor.makeplus_typekit = api.Control.extend({
		/**
		 * Kick things off when the template has been embedded.
		 *
		 * @since 1.7.0.
		 */
		ready: function() {
			var control = this,
				$container = control.container.find('.makeplus-typekit-container'),
				$value = $('#kit-id_' + control.id),
				$status = $('#kit-id-status_' + control.id),
				$buttons = $container.find('.makeplus-typekit-buttons'),
				$refresh = $('#refresh_' + control.id),
				$troubleshoot = $('#troubleshooting_' + control.id);

			$.getScript(MakePlus.webfonturl, function() {
				// Listen for changes to the Kit ID value.
				control.doneTyping($value);

				// Initialize containers for extra Ajax data.
				MakeControls.cache.ajax['make-font-choices'] = MakeControls.cache.ajax['make-font-choices'] || {};
				MakeControls.cache.ajax['makeplus-fontweight-load'] = MakeControls.cache.ajax['makeplus-fontweight-load'] || {};

				// Test the contents of the kid ID field when the Typekit section is first opened.
				api.section('ttfmake_font-typekit', function(section) {
					section.container.one('expanded', function() {
						if ($value.val()) {
							$value.trigger('makeplus:typekit:donetyping');
						}
					});
				});

				// Kit ID field
				$value.on('makeplus:typekit:donetyping', function() {
					var kitID = control.validateKitId( $value.val() ) ? $value.val() : '',
						$spinner = $('<img>').attr('src', MakePlus.spinner);

					// Clear UI.
					$status.removeClass('success error').addClass('loading').html($spinner);
					$refresh.addClass('button-disabled');

					// Add extra Ajax data.
					MakeControls.cache.ajax['make-font-choices']['makeplus-typekit-id'] = kitID;
					MakeControls.cache.ajax['makeplus-fontweight-load']['makeplus-typekit-id'] = kitID;

					// Only send a kit request if there is a valid-ish kit ID.
					if (kitID) {
						WebFont.load({
							typekit: {
								id: kitID
							},
							active: function() {
								// Kit loaded successfully
								$status.removeClass('loading').addClass('success').html('');
								$refresh.removeClass('button-disabled');
								$troubleshoot.addClass('screen-reader-text');

								// Update the setting value
								control.setting.set(kitID);

								// Refresh the font family lists
								MakeControls.updateFontElements();
							},
							inactive: function() {
								// Kit could not load
								$status.removeClass('loading').addClass('error').html('');
								$refresh.addClass('button-disabled');
								$troubleshoot.removeClass('screen-reader-text');

								// Refresh the font family lists
								MakeControls.updateFontElements();
							}
						});
					}
					// Update font list and preview pane if kit ID is removed.
					else {
						$status.removeClass('loading').html('');
						$troubleshoot.addClass('screen-reader-text');
						if ( '' !== $value.val() ) {
							// Kit ID field contains invalid characters
							$status.addClass('error');
							$troubleshoot.removeClass('screen-reader-text');
						}

						$refresh.addClass('button-disabled');

						// Update the setting value
						control.setting.set(kitID);

						// Refresh the font family lists
						MakeControls.updateFontElements();
					}
				});

				// Refresh button
				if (control.validateKitId(control.setting())) {
					$refresh.removeClass('button-disabled');
				}
				$refresh.on('click', function(evt) {
					evt.preventDefault();
				});
				$buttons.on('click', '#refresh_' + control.id + ':not(.button-disabled)', function() {
					var $element = $(this),
						kitID = $value.val(),
						data = {
							action: 'makeplus-typekit-refresh',
							kit_id: kitID
						};

					$element.addClass('button-disabled');

					// Add extra Ajax data
					MakeControls.cache.ajax['make-font-choices']['makeplus-typekit-id'] = kitID;
					MakeControls.cache.ajax['makeplus-fontweight-load']['makeplus-typekit-id'] = kitID;

					// Refresh the kit
					MakeControls.sendRequest(data, function() {
						$value.trigger('makeplus:typekit:donetyping');
					});
				});
			});
		},

		/**
		 * Check if a kit ID contains any invalid characters.
		 *
		 * @since 1.7.0.
		 *
		 * @param kitID
		 * @returns {boolean}
		 */
		validateKitId: function(kitID) {
			kitID = kitID.trim();
			return kitID && ! kitID.match(/[^0-9a-zA-Z]+/);
		},

		/**
		 * Listen for a pause in typing into the kit ID's input field and trigger an event.
		 *
		 * @link http://stackoverflow.com/a/14042239
		 *
		 * @since 1.7.0.
		 *
		 * @param $el jQuery element set
		 */
		doneTyping: function($el) {
			var timeout = 400,
				timeoutReference,
				doneTyping = function($el){
					if (! timeoutReference) return;
					timeoutReference = null;
					$el.trigger('makeplus:typekit:donetyping');
				};

			$el.on('keyup keypress paste', function(evt) {
				// This catches the backspace button in chrome, but also prevents
				// the event from triggering too preemptively. Without this line,
				// using tab/shift+tab will make the focused element fire the callback.
				if ('keyup' == evt.type && evt.keyCode != 8) return;

				// Check if timeout has been set. If it has, "reset" the clock and
				// start over again.
				if (timeoutReference) clearTimeout(timeoutReference);
				timeoutReference = setTimeout(function() {
					// if we made it here, our timeout has elapsed. Fire the
					// callback
					doneTyping($el);
				}, timeout);
			}).on('blur', function() {
				// If we can, fire the event since we're leaving the field
				doneTyping($el);
			});
		}
	});
})(jQuery, wp, MakeControls, MakePlusTypekit);