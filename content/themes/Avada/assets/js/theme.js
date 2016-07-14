var generate_carousel = function() {
	if ( jQuery().carouFredSel ) {
		jQuery( '.fusion-carousel' ).each( function() {
			// Initialize the needed variables from data fields
			var $image_size = ( jQuery( this ).attr( 'data-imagesize' ) ) ? jQuery( this ).data( 'imagesize' ) : 'fixed',
				$center_vertically = ( jQuery( this ).attr( 'data-metacontent' ) && jQuery( this ).data( 'metacontent' ) == 'yes' ) ? false : true,
				$autoplay = ( jQuery( this ).attr( 'data-autoplay' ) && jQuery( this ).data( 'autoplay' ) == 'yes' ) ? true : false,
				$scroll_effect = ( jQuery( this ).attr( 'data-scrollfx' ) ) ? jQuery( this ).data( 'scrollfx' ) : 'scroll',
				$scroll_items = ( jQuery( this ).attr( 'data-scrollitems' ) ) ? jQuery( this ).data( 'scrollitems' ) : null,
				$touch_scroll = ( jQuery( this ).attr( 'data-touchscroll' ) && jQuery( this ).data( 'touchscroll' ) == 'yes' ) ? true : false,
				$touch_scroll_class = ( $touch_scroll ) ? ' fusion-carousel-swipe' : '',
				$column_maximum = ( jQuery( this ).attr( 'data-columns' ) ) ? jQuery( this ).data( 'columns' ) : 6,
				$item_margin = ( jQuery( this ).attr( 'data-itemmargin' ) ) ? parseInt( jQuery( this ).data( 'itemmargin' ) ) : 44,
				$item_min_width = ( jQuery( this ).attr( 'data-itemwidth' ) ) ? parseInt( jQuery( this ).data( 'itemwidth' ) )  + $item_margin : 180 + $item_margin,
				$carousel_width = jQuery( this ).width(),
				$carousel_height = ( jQuery ( this ).parent().hasClass( 'fusion-image-carousel' ) && $image_size == 'fixed' ) ? '115px' : 'variable',
				$max_number_of_items = Math.floor( $carousel_width / $item_min_width );

			// Shift the wrapping positioning container $item_margin to the left
			jQuery( this ).find( '.fusion-carousel-positioner' ).css( 'margin-left', '-' + $item_margin + 'px' );

			// Add $item_margin as left margin to all items
			jQuery( this ).find( '.fusion-carousel-item' ).css( 'margin-left', $item_margin  + 'px' );

			// Shift the left navigation button $item_margin to the right
			jQuery( this ).find( '.fusion-nav-prev' ).css( 'margin-left', $item_margin + 'px' );

			// Initialize the carousel
			jQuery( this ).find( 'ul' ).carouFredSel({
				circular: true,
				infinite: true,
				responsive: true,
				centerVertically: $center_vertically,
				height: $carousel_height,
				width: '100%',
				auto: {
					play: $autoplay
				},
				items: {
					height: 'variable',
					width: $item_min_width,
					visible: {
						min: 1,
						max: $column_maximum
					}
				},
				scroll: {
					pauseOnHover: true,
					items: $scroll_items,
					fx: $scroll_effect,
				},
				swipe: {
					onTouch: $touch_scroll,
					onMouse: $touch_scroll,
					options: {
						excludedElements: 'button, input, select, textarea, a, .noSwipe',
					},
				},
				prev: jQuery( this ).find( '.fusion-nav-prev' ),
				next: jQuery( this ).find( '.fusion-nav-next' ),
				onCreate: function( data ) {
					// Make the images visible once the carousel is loaded
					jQuery( this ).find( '.fusion-carousel-item-wrapper' ).css( 'visibility', 'visible' );

					// Make the navigation visible once the carousel is loaded
					jQuery( this ).parents( '.fusion-carousel' ).find( '.fusion-carousel-nav' ).css( 'visibility', 'visible' );

					// Remove overflow: hidden to  make carousel stretch full width
					if ( jQuery( this ).parents( '.fusion-woo-featured-products-slider' ).length ) {
						jQuery( this ).parent().css( 'overflow', '' );
					}

					// Set the line-height of the main ul element to the height of the wrapping container
					if ( $center_vertically ) {
						jQuery( this ).css( 'line-height', jQuery( this ).parent().height() + 'px' );
					}

					// Set the ul element to top: auto position to make is respect top padding
					jQuery( this ).css( 'top', 'auto' );

					// Set the position of the right navigation element to make it fit the overall carousel width
					jQuery( this ).parents( '.fusion-carousel' ).find( '.fusion-nav-next' ).each( function() {
						jQuery( this ).css( 'left', jQuery( this ).parents( '.fusion-carousel' ).find( '.fusion-carousel-wrapper' ).width() - jQuery( this ).width() );
					});

					// Resize the placeholder images correctly in "fixed" picture size carousels
					if ( $image_size == 'fixed' ) {
						jQuery( this ).find( '.fusion-placeholder-image' ).each( function() {
							jQuery( this ).css(	'height', jQuery( this ).parents( '.fusion-carousel-item' ).siblings().first().find( 'img').height() );
							jQuery( this ).css(	'width', '100%' );
						});
					}
				},
				currentVisible: function( $items ) {
					return $items;
				},
			}, {
				// Set custom class name to the injected carousel container
				wrapper: {
					classname: 'fusion-carousel-wrapper' + $touch_scroll_class,
				}
			});
		});
	}
};

var calcTabsLayout = function(tab_selector) {
	jQuery(tab_selector).each(function() {
		var menuWidth = jQuery(this).parent().width();
		var menuItems = jQuery(this).find('li').length;
		var mod = menuWidth % menuItems;
		var itemWidth = (menuWidth - mod)/menuItems;
		var lastItemWidth = menuWidth - itemWidth*(menuItems - 1);

		jQuery(this).css({'width': menuWidth +'px'});
		jQuery(this).find('li').css({'width': itemWidth +'px'});
		jQuery(this).find('li:last').css({'width': lastItemWidth +'px'}).addClass('no-border-right');
	});
};

var fusion_reanimate_slider = function( content_container ) {
	var slide_content = content_container.find( '.slide-content' );

	jQuery( slide_content ).each( function() {

		jQuery(this).stop( true, true );

		jQuery(this).css('opacity', '0');
		jQuery(this).css('margin-top', '50px');

		jQuery(this).animate({
			'opacity': '1',
			'margin-top': '0'
		}, 1000 );

	});
};

// Calculate the responsive type values for font size and line height for all heading tags
var fusion_calculate_responsive_type_values = function( $custom_sensitivity, $custom_minimum_font_size_factor, $custom_mobile_break_point, $elements ) {

    // Setup options
    var $sensitivity = $custom_sensitivity || 1,
    	$minimum_font_size_factor = $custom_minimum_font_size_factor || 1.5,
    	$minimum_font_size = js_local_vars.body_font_size * $minimum_font_size_factor,
    	$mobile_break_point = ( $custom_mobile_break_point || $custom_mobile_break_point === 0 ) ? $custom_mobile_break_point : 800;

    var calculate_values = function() {
		// Get the site width for responsive type
		if ( jQuery( window ).width() >= $mobile_break_point ) {
			// Get px based site width from Theme Options
			if ( js_local_vars.site_width.indexOf( 'px' ) ) {
				var $site_width = parseInt( js_local_vars.site_width );
			// If site width is percentage based, use default site width
			} else {
				var $site_width = 1100;
			}
		// If we are below $mobile_break_point of viewport width, set $mobile_break_point as site width
		} else {
			var $site_width = $mobile_break_point;
		}

		// The resizing factor can be finetuned through a custom sensitivity; values below 1 decrease resizing speed
		var $window_site_width_ratio = jQuery( window ).width() / $site_width,
			$resize_factor = 1 - ( ( 1 - $window_site_width_ratio ) * $sensitivity );

		// If window width is smaller than site width then let's adjust the headings
		if ( jQuery( window ).width() <= $site_width ) {

			// Loop over all heading tegs
			jQuery( $elements ).each(
				function() {
					// Only decrease font-size if the we stay above $minimum_font_size
					if ( jQuery( this ).data( 'fontsize' ) * $resize_factor > $minimum_font_size ) {
						jQuery( this ).css( {
							'font-size': Math.round( jQuery( this ).data( 'fontsize' ) * $resize_factor * 1000 ) / 1000,
							'line-height': ( Math.round( jQuery( this ).data( 'lineheight' ) * $resize_factor * 1000 ) / 1000 ) + 'px'
						});
					// If decreased font size would become too small, natural font size is above $minimum_font_size, set font size to $minimum_font_size
					} else if ( jQuery( this ).data( 'fontsize' ) > $minimum_font_size ) {
						jQuery( this ).css( {
							'font-size': $minimum_font_size,
							'line-height': ( Math.round( jQuery( this ).data( 'lineheight' ) * $minimum_font_size / jQuery( this ).data( 'fontsize' ) * 1000 ) / 1000 ) + 'px'
						});
					}
				}
			);
		// If window width is larger than site width, delete any resizing styles
		} else {
			jQuery( $elements ).each(
				function() {
					// If initially an inline font size was set, restore it
					if ( jQuery( this ).data( 'inline-fontsize' ) ) {
						jQuery( this ).css( 'font-size', jQuery( this ).data( 'fontsize' ) );
					// Otherwise remove inline font size
					} else {
						jQuery( this ).css( 'font-size', '' );
					}
					// If initially an inline line height was set, restore it
					if ( jQuery( this ).data( 'inline-lineheight' ) ) {
						jQuery( this ).css( 'line-height', jQuery( this ).data( 'lineheight' ) + 'px' );
					// Otherwise remove inline line height
					} else {
						jQuery( this ).css( 'line-height', '' );
					}

				}
			);
		}
	};

	calculate_values();

	jQuery( window ).on( 'resize orientationchange', calculate_values );
};

function onPlayerStateChange(frame, slider) {
	return function(event) {
		if(event.data == YT.PlayerState.PLAYING) {
			jQuery(slider).flexslider("pause");
		}
		if(event.data == YT.PlayerState.PAUSED) {
			jQuery(slider).flexslider("play");
		}
		if(event.data == YT.PlayerState.BUFFERING) {
			jQuery(slider).flexslider("pause");
		}
	};
}
function onPlayerReady(slide) {
	return function(event) {
		if( jQuery(slide).attr('data-mute') == 'yes' ) {
			event.target.mute();
		}
	};
}

(function( jQuery ) {

	"use strict";

	jQuery('.tfs-slider').each(function() {
		var this_tfslider = this;

		if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
			jQuery(this_tfslider).data('parallax', 0);
			jQuery(this_tfslider).data('full_screen', 0);
		}

		if(cssua.ua.tablet_pc) {
			jQuery(this_tfslider).data('parallax', 0);
		}

		if(cssua.ua.mobile) {
			jQuery(this_tfslider).data('parallax', 0);
		}
	});

	// Waypoint
	jQuery.fn.init_waypoint = function() {
		if( jQuery().waypoint ) {

			// Counters Box
			jQuery('.fusion-counter-box').not('.fusion-modal .fusion-counter-box').waypoint(function() {
				jQuery(this).find('.display-counter').each(function() {
					jQuery(this).fusion_box_counting();
				});
			}, {
				triggerOnce: true,
				offset: 'bottom-in-view'
			});

			// Counter Circles
			jQuery('.counter-circle-wrapper').not('.fusion-modal .counter-circle-wrapper').waypoint(function() {
				jQuery(this).fusion_draw_circles();
			}, {
				triggerOnce: true,
				offset: 'bottom-in-view'
			});

			// Counter Circles Responsive Resizing
			jQuery('.counter-circle-wrapper').not('.fusion-modal .counter-circle-wrapper').waypoint(function() {
				var counter_circles = jQuery( this );

				jQuery(window).on('resize', function() {
					counter_circles.fusion_redraw_circles();
				});
			}, {
				triggerOnce: true,
				offset: 'bottom-in-view'
			});

			// Progressbar
			jQuery( '.fusion-progressbar' ).not('.fusion-modal .fusion-progressbar').waypoint( function() {
				jQuery(this).fusion_draw_progress();
			}, {
				triggerOnce: true,
				offset: 'bottom-in-view'
			});

			// CSS Animations
			jQuery( '.fusion-animated' ).waypoint( function() {
				jQuery( this ).css( 'visibility', 'visible' );

				// this code is executed for each appeared element
				var $animation_type = jQuery( this ).data( 'animationtype' ),
					$animation_duration = jQuery( this ).data( 'animationduration' );

				jQuery( this ).addClass( $animation_type );

				if ( $animation_duration ) {
					jQuery( this ).css( '-moz-animation-duration', $animation_duration + 's' );
					jQuery( this ).css( '-webkit-animation-duration', $animation_duration + 's' );
					jQuery( this ).css( '-ms-animation-duration', $animation_duration + 's' );
					jQuery( this ).css( '-o-animation-duration', $animation_duration + 's' );
					jQuery( this ).css( 'animation-duration', $animation_duration + 's' );
				}
			}, { triggerOnce: true, offset: 'bottom-in-view' } );
		}
	};

	// Recalculate carousel elements
	jQuery.fn.fusion_recalculate_carousel = function() {
		jQuery( this ).not( '.fusion-woo-featured-products-slider' ).each( function() {
			var $carousel = jQuery( this ),
				$image_size = jQuery( this ).data( 'imagesize' );

			// Timeout needed for size changes to take effect, before weaccess them
			setTimeout( function() {
				// Set the position of the right navigation element to make it fit the overall carousel width
				$carousel.find( '.fusion-nav-next' ).each( function() {
					jQuery( this ).css( 'left', $carousel.find( '.fusion-carousel-wrapper' ).width() - jQuery( this ).width() );
				});

				// Resize the placeholder images correctly in "fixed" picture size carousels
				if ( $image_size == 'fixed' ) {
					$carousel.find( '.fusion-placeholder-image' ).each( function() {
						jQuery( this ).css(	'height', jQuery( this ).parents( '.fusion-carousel-item' ).siblings().first().find( 'img').height() );
					});
					if( jQuery( $carousel ).parents( '.fusion-image-carousel' ).length >= 1 ) {
						$carousel.find( '.fusion-image-wrapper' ).each( function() {
							jQuery( this ).css(	'height', jQuery( this ).parents( '.fusion-carousel-item' ).siblings().first().find( 'img').height() );
							jQuery( this ).css(	'width', '100%' );
						});
					}
				}
			}, 5 );
		});
	};

	// Animate counter boxes
	jQuery.fn.fusion_box_counting = function() {
		var $count_value = jQuery( this ).data( 'value' ),
			$count_direction = jQuery( this ).data( 'direction' ),
			$delimiter = jQuery( this ).data( 'delimiter' ),
			$from_value = 0,
			$to_value = $count_value;

		if ( ! $delimiter ) {
			$delimiter = '';
		}

		if ( $count_direction == 'down' ) {
			$from_value = $count_value;
			$to_value = 0;
		}

		jQuery (this ).countTo( {
			from: $from_value,
			to: $to_value,
			refreshInterval: 10,
			speed: 1000,
			formatter: function ( value, options ) {
				value = value.toFixed( options.decimals );
				value = value.replace( /\B(?=(\d{3})+(?!\d))/g, $delimiter );

				if ( value == '-0' ) {
					value = 0;
				}

				return value;
			}
		} );
	};

	// Animate counter circles
	jQuery.fn.fusion_draw_circles = function() {
		var circle = jQuery( this );
		var countdown = circle.children( '.counter-circle' ).attr( 'data-countdown' );
		var filledcolor = circle.children( '.counter-circle' ).attr( 'data-filledcolor' );
		var unfilledcolor = circle.children( '.counter-circle' ).attr( 'data-unfilledcolor' );
		var scale = circle.children( '.counter-circle' ).attr( 'data-scale' );
		var size = circle.children( '.counter-circle' ).attr( 'data-size' );
		var speed = circle.children( '.counter-circle' ).attr( 'data-speed' );
		var strokesize = circle.children( '.counter-circle' ).attr( 'data-strokesize' );
		var percentage = circle.children( '.counter-circle' ).attr( 'data-percent' );

		// Check if set values fit the container
		if( circle.parent().width() < circle.width() ) {
			size = circle.parent().width();
			strokesize =  size / 220 * 11;

			circle.css({ 'width': size, 'height': size, 'line-height': size + 'px' });
			circle.find( '.fusion-counter-circle' ).each( function() {
				jQuery( this ).css({ 'width': size, 'height': size, 'line-height': size + 'px' });
				jQuery( this ).data( 'size', size );
				jQuery( this ).data( 'strokesize', strokesize );
			});
		}

		if( scale ) {
			scale = jQuery( 'body' ).css( 'color' );
		}

		if( countdown ) {
			circle.children( '.counter-circle' ).attr( 'data-percent', 100 );

			circle.children( '.counter-circle' ).easyPieChart({
				barColor: filledcolor,
				trackColor: unfilledcolor,
				scaleColor: scale,
				scaleLength: 5,
				lineCap: 'round',
				lineWidth: strokesize,
				size: size,
				rotate: 0,
				animate: {
					duration: speed, enabled: true
				}
			});
			circle.children( '.counter-circle' ).data( 'easyPieChart' ).enableAnimation();
			circle.children( '.counter-circle' ).data( 'easyPieChart' ).update( percentage );
		} else {
			circle.children( '.counter-circle' ).easyPieChart({
				barColor: filledcolor,
				trackColor: unfilledcolor,
				scaleColor: scale,
				scaleLength: 5,
				lineCap: 'round',
				lineWidth: strokesize,
				size: size,
				rotate: 0,
				animate: {
					duration: speed, enabled: true
				}
			});
		}
	};

	jQuery.fn.fusion_redraw_circles = function() {
		var counter_circles_wrapper = jQuery( this );
		counter_circles_wrapper.attr( 'data-originalsize', counter_circles_wrapper.width() );
		var fusion_counters_circle_width = counter_circles_wrapper.parent().width();

		if( fusion_counters_circle_width < counter_circles_wrapper.data( 'originalsize' ) ) {

			counter_circles_wrapper.css({ 'width': fusion_counters_circle_width, 'height': fusion_counters_circle_width, 'line-height': fusion_counters_circle_width + 'px' });
			counter_circles_wrapper.find( '.fusion-counter-circle' ).each( function() {
				jQuery( this ).css({ 'width': fusion_counters_circle_width, 'height': fusion_counters_circle_width, 'line-height': fusion_counters_circle_width + 'px' });
				jQuery( this ).data( 'size', fusion_counters_circle_width );
				jQuery( this ).data( 'strokesize', fusion_counters_circle_width / 220 * 11 );
				jQuery( this ).data( 'animate', false );
				jQuery( this ).attr( 'data-size', fusion_counters_circle_width );
				jQuery( this ).attr( 'data-strokesize', fusion_counters_circle_width / 220 * 11 );
				jQuery( this ).children( 'canvas' ).remove();
				jQuery( this ).removeData( 'easyPieChart' );
			});

			counter_circles_wrapper.fusion_draw_circles();
		} else if( fusion_counters_circle_width >= counter_circles_wrapper.data( 'originalsize' ) && counter_circles_wrapper.width() < counter_circles_wrapper.data( 'originalsize' ) )  {
			var original_size = counter_circles_wrapper.data( 'originalsize' );

			counter_circles_wrapper.css({ 'width': original_size, 'height': original_size, 'line-height': original_size + 'px' });
			counter_circles_wrapper.find( '.fusion-counter-circle' ).each( function() {
				jQuery( this ).css({ 'width': original_size, 'height': original_size, 'line-height': original_size + 'px' });
				jQuery( this ).data( 'size', original_size );
				jQuery( this ).data( 'strokesize', original_size / 220 * 11 );
				jQuery( this ).data( 'animate', false );
				jQuery( this ).attr( 'data-size', original_size );
				jQuery( this ).attr( 'data-strokesize', original_size / 220 * 11 );
				jQuery( this ).children( 'canvas' ).remove();
				jQuery( this ).removeData( 'easyPieChart' );
			});

			counter_circles_wrapper.fusion_draw_circles();
		}
	};

	// animate progress bar
	jQuery.fn.fusion_draw_progress = function() {
		var progressbar = jQuery( this );
		if ( jQuery( 'html' ).hasClass( 'lt-ie9' ) ) {
			progressbar.css( 'visibility', 'visible' );
			progressbar.each( function() {
				var percentage = progressbar.find( '.progress' ).attr("aria-valuenow");
				progressbar.find( '.progress' ).css( 'width', '0%' );
				progressbar.find( '.progress' ).animate( {
					width: percentage+'%'
				}, 'slow' );
			} );
		} else {
			progressbar.find( '.progress' ).css( "width", function() {
				return jQuery( this ).attr( "aria-valuenow" ) + "%";
			});
		}
	};

	// set flip boxes equal front/back height
	jQuery.fn.fusion_calc_flip_boxes_height = function() {
		var flip_box = jQuery( this );
		var outer_height, height, top_margin = 0;

		flip_box.find( '.flip-box-front' ).css( 'min-height', '' );
		flip_box.find( '.flip-box-back' ).css( 'min-height', '' );
		flip_box.find( '.flip-box-front-inner' ).css( 'margin-top', '' );
		flip_box.find( '.flip-box-back-inner' ).css( 'margin-top', '' );
		flip_box.css( 'min-height', '' );

		setTimeout( function() {
			if( flip_box.find( '.flip-box-front' ).outerHeight() > flip_box.find( '.flip-box-back' ).outerHeight() ) {
				height = flip_box.find( '.flip-box-front' ).height();
				if( cssua.ua.ie && cssua.ua.ie.substr(0, 1) == '8' ) {
					outer_height = flip_box.find( '.flip-box-front' ).height();
				} else {
					outer_height = flip_box.find( '.flip-box-front' ).outerHeight();
				}
				top_margin = ( height - flip_box.find( '.flip-box-back-inner' ).outerHeight() ) / 2;

				flip_box.find( '.flip-box-back' ).css( 'min-height', outer_height );
				flip_box.css( 'min-height', outer_height );
				flip_box.find( '.flip-box-back-inner' ).css( 'margin-top', top_margin );
			} else {
				height = flip_box.find( '.flip-box-back' ).height();
				if( cssua.ua.ie && cssua.ua.ie.substr(0, 1) == '8' ) {
					outer_height = flip_box.find( '.flip-box-back' ).height();
				} else {
					outer_height = flip_box.find( '.flip-box-back' ).outerHeight();
				}
				top_margin = ( height - flip_box.find( '.flip-box-front-inner' ).outerHeight() ) / 2;

				flip_box.find( '.flip-box-front' ).css( 'min-height', outer_height );
				flip_box.css( 'min-height', outer_height );
				flip_box.find( '.flip-box-front-inner' ).css( 'margin-top', top_margin );
			}

			if( cssua.ua.ie && cssua.ua.ie.substr(0, 1) == '8' ) {
				flip_box.find( '.flip-box-back' ).css( 'height', '100%' );
			}

		}, 100 );
	};

	// fusion scroller plugin to change css while scrolling
	jQuery.fn.fusion_scroller = function( options ) {
        var settings = jQuery.extend({
        	type: 'opacity',
        	offset: 0,
        	end_offset: ''
        }, options );

		var divs = jQuery(this);

		divs.each(function() {
			var offset, height, end_offset;
			var current_element = this;

			jQuery(window).on('scroll', function() {
				offset = jQuery(current_element).offset().top;
				if(jQuery('body').hasClass('admin-bar')) {
					offset = jQuery(current_element).offset().top - jQuery('#wpadminbar').outerHeight();
				}
				if(settings.offset > 0) {
					offset = jQuery(current_element).offset().top - settings.offset;
				}
				height = jQuery(current_element).outerHeight();

				end_offset = offset + height;
				if(settings.end_offset) {
					end_offset = jQuery(settings.end_offset).offset().top;
				}

	        	var st = jQuery(this).scrollTop();

				if(st >= offset && st <= end_offset) {
					var diff = end_offset - st;
					var diff_percentage = (diff / height) * 100;

					if(settings.type == 'opacity') {
						var opacity = (diff_percentage / 100) * 1;
						jQuery(current_element).css({
							'opacity': opacity
						});
					} else if(settings.type == 'blur') {
						var diff_percentage = 100 - diff_percentage;
						var blur = 'blur(' + ((diff_percentage / 100) * 50) + 'px)';
						jQuery(current_element).css({
							'-webkit-filter': blur,
							'-ms-filter': blur,
							'-o-filter': blur,
							'-moz-filter': blur,
							'filter': blur
						});
					} else if(settings.type == 'fading_blur') {
						var opacity = (diff_percentage / 100) * 1;
						var diff_percentage = 100 - diff_percentage;
						var blur = 'blur(' + ((diff_percentage / 100) * 50) + 'px)';
						jQuery(current_element).css({
							'-webkit-filter': blur,
							'-ms-filter': blur,
							'-o-filter': blur,
							'-moz-filter': blur,
							'filter': blur,
							'opacity': opacity
						});
					}
				}

				if( st < offset ) {
					if(settings.type == 'opacity') {
						jQuery(current_element).css({
							'opacity': 1
						});
					} else if(settings.type == 'blur') {
						var blur = 'blur(0px)';
						jQuery(current_element).css({
							'-webkit-filter': blur,
							'-ms-filter': blur,
							'-o-filter': blur,
							'-moz-filter': blur,
							'filter': blur
						});
					} else if(settings.type == 'fading_blur') {
						var blur = 'blur(0px)';
						jQuery(current_element).css({
							'opacity': 1,
							'-webkit-filter': blur,
							'-ms-filter': blur,
							'-o-filter': blur,
							'-moz-filter': blur,
							'filter': blur
						});
					}
				}
			});
		});
	};

	// Change active tab when a link containing a tab ID is clicked; on and off page
	jQuery.fn.fusion_switch_tab_on_link_click = function( $custom_id ) {

		// The custom_id is used for on page links
		var $link_hash = $custom_id || document.location.hash,
			$link_id = $link_hash.split( '#' )[1];

		if( $link_hash && jQuery( this ).find( '.nav-tabs li a[href="' + $link_hash + '"]' ).length ) {
			jQuery( this ).find( '.nav-tabs li' ).removeClass( 'active' );
			jQuery( this ).find( '.nav-tabs li a[href="' + $link_hash + '"]' ).parent().addClass( 'active' );

			jQuery( this ).find( '.tab-content .tab-pane' ).removeClass( 'in' ).removeClass( 'active' );
			jQuery( this ).find( '.tab-content .tab-pane[id="' + $link_id  + '"]' ).addClass( 'in' ).addClass( 'active' );
		}

		if( $link_hash && jQuery( this ).find( '.nav-tabs li a[id="' + $link_id + '"]' ).length ) {
			jQuery( this ).find( '.nav-tabs li' ).removeClass( 'active' );
			jQuery( this ).find( '.nav-tabs li a[id="' + $link_id + '"]' ).parent().addClass( 'active' );

			jQuery( this ).find( '.tab-content .tab-pane' ).removeClass( 'in' ).removeClass( 'active' );
			jQuery( this ).find( '.tab-content .tab-pane[id="' + jQuery( this ).find( '.nav-tabs li a[id="' + $link_id + '"]' ).attr( 'href' ).split('#')[1] + '"]' ).addClass( 'in' ).addClass( 'active' );
		}
	};

	// Max height for columns and content boxes
	jQuery.fn.equalHeights = function( $min_height, $max_height ) {

		if ( jQuery( this ).children( '.fusion-column-table' ).length || Modernizr.mq( 'only screen and (min-width: 800px)' ) || Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait)' ) ) {
			var $tallest = ( $min_height ) ? $min_height : 0;

			this.each( function() {
				jQuery( this ).css( 'min-height', '0' );
				jQuery( this ).css('height', 'auto' );
				jQuery( this ).find( '.fusion-column-table' ).css('height', 'auto' );

				if ( jQuery( this ).outerHeight() > $tallest ) {
					$tallest = jQuery( this ).outerHeight();
				}
			});

			if ( ( $max_height ) && $tallest > $max_height) {
				$tallest = $max_height;
			}

			return this.each( function() {
				var $new_height = $tallest;

				// Needed for vertically centered columns
                if ( jQuery( this ).children( '.fusion-column-table' ).length ) {
                    $new_height = $tallest - ( jQuery( this ).outerHeight() - jQuery( this ).height() );
                }

				jQuery( this ).css( 'min-height', $new_height );
				jQuery( this ).find( '.fusion-column-table' ).height( $new_height );
			});
		} else {
			return this.each( function() {
				jQuery( this ).css( 'min-height', '' );
				jQuery( this ).find( '.fusion-column-table' ).css( 'height', '' );
			});
		}
	};

	// Set the bg image dimensions of an empty column as data attributes
	jQuery.fn.fusion_set_bg_img_dims = function() {
		jQuery( this ).each( function() {
			if ( ! jQuery.trim( jQuery( this ).html() ) && jQuery( this ).data( 'bg-url' ) ) {
				// For background image we need to setup the image object to get the natural heights
				var $background_image = new Image();
				$background_image.src = jQuery( this ).data( 'bg-url' );
				var $image_height = parseInt( $background_image.naturalHeight ),
					$image_width = parseInt( $background_image.naturalWidth );

				// IE8, Opera fallback
				$background_image.onload = function() {
					$image_height = parseInt( this.height );
					$image_width = parseInt( this.width );
				};

				// Set the
				jQuery( this ).attr( 'data-bg-height', $image_height );
				jQuery( this ).attr( 'data-bg-width', $image_width );
			}
		});
	 };

	// Calculate the correct aspect ratio respecting height of an empty column with bg image
	jQuery.fn.fusion_calculate_empty_column_height = function() {
		jQuery( this ).each( function() {
			if ( ( jQuery( this ).parents( '.fusion-equal-height-columns' ).length && Modernizr.mq( 'screen and (max-width: 800px)' ) ) || ! jQuery( this ).parents( '.fusion-equal-height-columns' ).length ) {
				if ( ! jQuery.trim( jQuery( this ).html() ) ) {
					var $image_height = jQuery( this ).data( 'bg-height' ),
						$image_width = jQuery( this ).data( 'bg-width' ),
						$container_width = jQuery( this ).outerWidth(),
						$width_ratio = $container_width / $image_width,
						$calculated_container_height = $image_height * $width_ratio;

					jQuery( this ).height( $calculated_container_height );
				}
			}
		});
	 };

	// Reinitialize google map; needed when maps are loaded inside of hidden containers
	jQuery.fn.reinitialize_google_map = function() {
		var fusion_map_object = jQuery( this ).data( 'plugin_fusion_maps' );

		if ( fusion_map_object ) {
			var	map = fusion_map_object.map,
				center = map.getCenter(),
				markers = fusion_map_object.markers;

			google.maps.event.trigger( map, 'resize' );
			map.setCenter( center );
			if ( markers ) {
				for ( var i = 0; i < markers.length; i++ ) {
					google.maps.event.trigger( markers[i], 'click' );
					google.maps.event.trigger( markers[i], 'click' );
				}
			}
		}
	};

	// Initialize fusion filters and corresponding posts
	jQuery.fn.fusion_filters_initialization = function( $posts ) {
		// Check if filters are displayed
		if ( jQuery( this ).length ) {

			// Show the filters container
			jQuery( this ).fadeIn();

			// Set needed variables
			var $filters = jQuery( this ).find( '.fusion-filter' ),
				$filter_active_element = jQuery( this ).find( '.fusion-active' ).children( 'a' ),
				$filter_active =  $filter_active_element.attr( 'data-filter' ).substr( 1 );

			// Loop through filters
			if ( $filters ) {
				$filters.each( function() {
					var $filter = jQuery( this ),
						$filter_name = $filter.children( 'a' ).data( 'filter' );

					// Loop through initial post set
					if ( $posts ) {
						// If "All" filter is deactivated, hide posts for later check for active filter
						if ( $filter_active.length ) {
							$posts.hide();
						}

						$posts.each( function() {
							var $post = jQuery( this ),
								$post_gallery_name = $post.find( '.fusion-rollover-gallery' ).data( 'rel' );

							// If a post belongs to an invisible filter, fade it in
							if ( $post.hasClass( $filter_name.substr( 1 ) ) ) {
								if ( $filter.hasClass( 'fusion-hidden' ) ) {
									$filter.removeClass( 'fusion-hidden' );
								}
							}

							// If "All" filter is deactivated, only show the items of the first filter (which is auto activated)
							if ( $filter_active.length && $post.hasClass( $filter_active ) ) {
								$post.show();

								// Set the lightbox gallery
								$post.find( '.fusion-rollover-gallery' ).attr( 'data-rel', $post_gallery_name.replace( 'gallery', $filter_active ) );
							}
						});
					}
				});
			}

			if ( $filter_active.length ) {
				// Relayout the posts according to filter selection
				jQuery( instance.elements ).isotope( { filter: '.' + $filter_active } );

				// Create new lightbox instance for the new gallery
				$il_instances.push( jQuery( '[data-rel="iLightbox[' + $filter_active + ']"], [rel="iLightbox[' + $filter_active + ']"]' ).iLightBox( $avada_lightbox.prepare_options( 'iLightbox[' + $filter_active + ']' ) ) );

				// Refresh the lightbox
				$avada_lightbox.refresh_lightbox();

				// Set active filter to lightbox created
				$filter_active_element.data( 'lightbox', 'created' );
			}
		}
	};

	// Initialize parallax footer
	jQuery.fn.fusion_footer_parallax = function() {
		var $footer = jQuery( this );

		// Needed timeout for dynamic footer content
		setTimeout( function() {
			var $wrapper_height = ( $footer.css( 'position' ) == 'fixed' ) ? jQuery( '#wrapper' ).outerHeight() : jQuery( '#wrapper' ).outerHeight() - $footer.outerHeight();

			// On desktops and on iPads enable parallax footer effect
			if ( $footer.outerHeight() < jQuery( window ).height() && $wrapper_height > jQuery( window ).height() && ( js_local_vars.header_position == 'Top' || ( js_local_vars.header_position != 'Top' && jQuery( window ).height() > jQuery( '.side-header-wrapper' ).height() ) ) && ( Modernizr.mq( 'only screen and (min-width:' + ( 800 + parseInt( js_local_vars.side_header_width ) ) + 'px)' ) || Modernizr.mq( 'only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait)' ) ) ) {
				$footer.css( {
					'position': '',
					'margin': '',
					'padding': ''
				});
				jQuery( '#main' ).css( 'margin-bottom', $footer.outerHeight() );

				if( jQuery('.tfs-slider').length >= 1 && jQuery('.tfs-slider').data('parallax') == 1 && $footer.hasClass('fusion-footer-parallax') ) {
					var $slider_height = jQuery('.tfs-slider').parents('#sliders-container').outerHeight();
					var $footer_height = $footer.outerHeight();
					if( $slider_height > $footer_height ) {
						jQuery( '#main' ).css('min-height', $slider_height + 100 );
					} else if( $footer_height > $slider_height ) {
						jQuery( '#main' ).css('min-height', $footer_height + 100 );
					}
				}
			// On mobiles the footer will be static
			} else {
				$footer.css( {
					'position': 'static',
					'margin': '0',
					'padding': '0'
				});
				jQuery( '#main' ).css( 'margin-bottom', '' );
			}
		}, 1 );
	};

	jQuery.fn.fusion_calculate_secondary_menu_height = function() {
		if( jQuery( this ).parent().hasClass( 'fusion-alignleft' ) ) {
			var $other_content_alignment  = '.fusion-alignright';
		} else {
			var $other_content_alignment  = '.fusion-alignleft';
		}

		var $other_content_height = jQuery( '.fusion-secondary-header' ).find( $other_content_alignment ).height();
		var $heights = [];
		var $min_height;

		jQuery( this ).find( '> ul > li > a' ).each(function() {
			$heights.push( jQuery( this ).outerHeight() );
		});

		$min_height = Math.min.apply( Math, $heights );

		if ( $min_height < $other_content_height ) {
			jQuery( this ).find( '> ul > li > a' ).css({
				'height': $other_content_height,
				'line-height': $other_content_height + 'px'
			});
		}

		if ( Modernizr.mq( 'only screen and (max-width: 800px)' ) ) {
			jQuery( this ).find( '> ul > li > a' ).css( {
				'height': '',
				'line-height': ''
			});
		}
	};
})( jQuery );

jQuery( window ).load( function() { // start window_load_1

	// Static layout
	if( js_local_vars.is_responsive == '0' ) {
		var column_classes = ['col-sm-0', 'col-sm-1', 'col-sm-2', 'col-sm-3', 'col-sm-4', 'col-sm-5', 'col-sm-6', 'col-sm-7', 'col-sm-8', 'col-sm-9', 'col-sm-10', 'col-sm-11', 'col-sm-12'];
		jQuery( '.col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12' ).each( function() {
			for( var i = 0; i < column_classes.length; i++ ) {
				if( jQuery( this ).attr('class').indexOf( column_classes[i] ) !== -1 ) {
					jQuery( this ).addClass( 'col-xs-' + i );
				}
			}
		});
	}

	// Initialize Waypoint
	setTimeout( function() {
		jQuery(window).init_waypoint();
		jQuery.waypoints( 'viewportHeight' );
	}, 300 );

	// Counters Box - Modals
	jQuery('.fusion-modal .fusion-counter-box').each(function() {
		jQuery(this).appear(function() {
			jQuery(this).find('.display-counter').each(function() {
				jQuery(this).fusion_box_counting();
			});
		});
	});

	// Counter Circles - Modals
	jQuery('.fusion-modal .counter-circle-wrapper').each(function() {
		jQuery(this).appear(function() {
			jQuery(this).fusion_draw_circles();
		});
	});

	// Progressbar - Modals
	jQuery('.fusion-modal .fusion-progressbar').each(function() {
		jQuery(this).appear(function() {
			jQuery(this).fusion_draw_progress();
		});
	});

	// Flip Boxes
	jQuery( '.flip-box-inner-wrapper' ).each( function() {
		jQuery( this ).fusion_calc_flip_boxes_height();
	});

	// Testimonials
	function onBefore( curr, next, opts, fwd ) {
	  var $ht = jQuery( this ).height();

	  //set the active testimonial class for resize event
	  jQuery( this ).parent().children().removeClass( 'active-testimonial' );
	  jQuery( this ).addClass( 'active-testimonial' );

	  //set the container's height to that of the current slide
	  jQuery( this ).parent().animate( { height: $ht }, 500 );
	}

	if ( jQuery().cycle ) {
		var reviews_cycle_args = {
			fx: 'fade',
			before:  onBefore,
			containerResize: 0,
			containerResizeHeight: 1,
			height: 'auto',
			width: '100%',
			fit: 1,
			speed: 500,
			delay: 0
		};

		if ( js_local_vars.testimonials_speed ) {
			reviews_cycle_args.timeout = parseInt( js_local_vars.testimonials_speed );
		}

		reviews_cycle_args.pager = '.testimonial-pagination';

		jQuery( '.fusion-testimonials .reviews' ).each( function() {
			if ( jQuery( this ).children().length == 1 ) {
				jQuery( this ).children().fadeIn();
			}

			reviews_cycle_args.pager = '#' + jQuery( this ).parent().find( '.testimonial-pagination' ).attr( 'id' );

			reviews_cycle_args.random = jQuery( this ).parent().data( 'random' );
			jQuery( this ).cycle( reviews_cycle_args );
		});



		jQuery( window ).resize( function() {
			jQuery( '.fusion-testimonials .reviews' ).each( function() {
				jQuery( this ).css( 'height', jQuery( this ).children( '.active-testimonial' ).height() );
			});
		});
	}

	// Toggles
	jQuery( document ).on('click', '.fusion-accordian .panel-title a', function ( e ) {
		e.preventDefault();

		var clicked_toggle = jQuery( this );
		var toggle_content_to_activate = jQuery( jQuery( this ).data( 'target' ) ).find( '.panel-body' );

		if( clicked_toggle.hasClass( 'active' ) ) {
			clicked_toggle.parents( '.fusion-accordian ').find( '.panel-title a' ).removeClass( 'active' );
		} else {
			clicked_toggle.parents( '.fusion-accordian ').find( '.panel-title a' ).removeClass( 'active' );
			clicked_toggle.addClass( 'active' );

			setTimeout( function(){
				toggle_content_to_activate.find( '.shortcode-map' ).each(function() {
					jQuery( this ).reinitialize_google_map();
				});

				if( toggle_content_to_activate.find( '.fusion-carousel' ).length ) {
					generate_carousel();
				}

				toggle_content_to_activate.find( '.fusion-portfolio' ).each( function() {
					jQuery( this).find( '.fusion-portfolio-wrapper' ).isotope();
				});

				// To make premium sliders work in tabs
				if( toggle_content_to_activate.find.find( '.flexslider, .rev_slider_wrapper, .ls-container' ).length ) {
					jQuery( window ).trigger( 'resize' );
				}

				toggle_content_to_activate.find( '.fusion-blog-shortcode' ).each( function() {
					var columns = 2;
					for( i = 1; i < 7; i++ ) {
						if( jQuery( this ).find( '.fusion-blog-layout-grid' ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
							columns = i;
						}
					}

					var grid_width = Math.floor( 100 / columns * 100 ) / 100  + '%';
					jQuery( this ).find( '.fusion-blog-layout-grid' ).find( '.fusion-post-grid' ).css( 'width', grid_width );

					jQuery( this).find( '.fusion-blog-layout-grid' ).isotope();

					calc_select_arrow_dimensions();
				});
			}, 350);
		}
	});

	// Initialize Bootstrap Modals
	jQuery( '.fusion-modal' ).each( function() {
		jQuery( '#wrapper' ).append( jQuery( this ) );
	});

	jQuery( '.fusion-modal' ).bind('hidden.bs.modal', function () {
		jQuery( 'html' ).css( 'overflow', '' );
	});

	jQuery( '.fusion-modal' ).bind('show.bs.modal', function () {
		var $slidingbar = jQuery( '#slidingbar' );

		jQuery( 'html' ).css( 'overflow', 'visible' );

		var modal_window = jQuery ( this );

		// Reinitialize dynamic content
		setTimeout( function(){
			// To make premium sliders work in tabs
			if ( modal_window.find( '.flexslider, .rev_slider_wrapper, .ls-container' ).length ) {
				jQuery( window ).trigger( 'resize' );
			}

			// Reinitialize carousels
			if( modal_window.find( '.fusion-carousel' ).length ) {
				generate_carousel();
			}

			// Reinitialize blog shortcode isotope grid
			modal_window.find( '.fusion-blog-shortcode' ).each( function() {
				var columns = 2;
				for( i = 1; i < 7; i++ ) {
					if( jQuery( this ).find( '.fusion-blog-layout-grid' ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
						columns = i;
					}
				}

				var grid_width = Math.floor( 100 / columns * 100 ) / 100  + '%';
				jQuery( this ).find( '.fusion-blog-layout-grid' ).find( '.fusion-post-grid' ).css( 'width', grid_width );

				jQuery( this).find( '.fusion-blog-layout-grid' ).isotope();

				calc_select_arrow_dimensions();
			});

			// Reinitialize google maps
			modal_window.find( '.shortcode-map' ).each(function() {
				jQuery( this ).reinitialize_google_map();
			});

			// Reinitialize portfolio
			modal_window.find( '.fusion-portfolio' ).each( function() {
				jQuery( this ).find( '.fusion-portfolio-wrapper' ).isotope();
			});

			// Reinitialize testimonial height; only needed for hidden wrappers
			if ( $slidingbar.find( '.fusion-testimonials' ).length ) {
				var $active_testimonial = $slidingbar.find( '.fusion-testimonials .reviews' ).children( '.active-testimonial' );

				$slidingbar.find( '.fusion-testimonials .reviews' ).height( $active_testimonial.height() );
			}
		}, 350);
	});

	if( jQuery( '#sliders-container .tfs-slider' ).data( 'parallax' ) == 1 ) {
		jQuery( '.fusion-modal' ).css( 'top', jQuery( '.header-wrapper' ).height() );
	}

	// stop videos in modals when closed
    jQuery( '.fusion-modal' ).each(function() {
        jQuery( this ).on( 'hide.bs.modal', function() {

			// Youtube
			jQuery( this ).find('iframe').each(function(i) {
				var func = 'pauseVideo';
				this.contentWindow.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
			});

			// Vimeo
			jQuery( this ).find('.fusion-vimeo iframe').each(function(i) {
				$f(this).api('pause');
			});
		});
	});

	jQuery('[data-toggle=modal]').on('click', function(e) {
		e.preventDefault();
	});

	jQuery( '.fusion-modal-text-link' ).click( function( e ) {
		e.preventDefault();
	});

	if(cssua.ua.mobile || cssua.ua.tablet_pc) {
		jQuery('.fusion-popover, .fusion-tooltip').each(function() {
			jQuery(this).attr('data-trigger', 'click');
			jQuery(this).data('trigger', 'click');
		});
	}

	// Initialize Bootstrap Popovers
	jQuery( '[data-toggle~="popover"]' ).popover({
		container: 'body'
	});

	// Initialize Bootstrap Tabs
	// Initialize vertical tabs content container height
	if( jQuery( '.vertical-tabs' ).length ) {
		jQuery( '.vertical-tabs .tab-content .tab-pane' ).each( function() {
			if( jQuery ( this ).parents( '.vertical-tabs' ).hasClass( 'clean' ) ) {
				jQuery ( this ).css( 'min-height', jQuery( '.vertical-tabs .nav-tabs' ).outerHeight() - 10 );
			} else {
				jQuery ( this ).css( 'min-height', jQuery( '.vertical-tabs .nav-tabs' ).outerHeight() );
			}

			if( jQuery ( this ).find( '.video-shortcode' ).length ) {
				var video_width = parseInt( jQuery ( this ).find( '.fusion-video' ).css( 'max-width' ).replace( 'px', '' ) );
				jQuery ( this ).css({
					'float': 'none',
					'max-width': video_width + 60
				});
			}
		});
	}

	jQuery( window ).on( 'resize', function() {
		if( jQuery( '.vertical-tabs' ).length ) {
			jQuery( '.vertical-tabs .tab-content .tab-pane' ).css( 'min-height', jQuery( '.vertical-tabs .nav-tabs' ).outerHeight() );
		}
	});

	// Initialize Bootstrap Tooltip
	jQuery( '[data-toggle="tooltip"]' ).each( function() {
		if ( jQuery( this ).parents( '.fusion-header-wrapper' ).length ) {
			$container = '.fusion-header-wrapper';
		} else if ( jQuery( this ).parents( '#side-header' ).length ) {
			$container = '#side-header';
		} else {
			$container = 'body';
		}

		jQuery( this ).tooltip({
			container: $container
		});
	});

	jQuery( '.fusion-tooltip' ).hover( function(){
			// Get the current title attribute
			var $title = jQuery( this ).attr( 'title' );

			// Store it in a data var
			jQuery( this ).attr( 'data-title', $title );

			// Set the title to nothing so we don't see the tooltips
			jQuery( this ).attr( 'title', '' );

	});

	 jQuery( '.fusion-tooltip' ).click( function(){

			// Retrieve the title from the data attribute
			var $title = jQuery( this ).attr( 'data-title' );

			// Return the title to what it was
			jQuery( this ).attr( 'title', $title );

		});

	generate_carousel();

	// Equal Heights Elements
	jQuery( '.content-boxes-icon-boxed' ).each( function() {
		jQuery( this ).find('.content-box-column .content-wrapper-boxed' ).equalHeights();
		jQuery( this ).find('.content-box-column .content-wrapper-boxed' ).css( 'overflow', 'visible' );
	});

	jQuery( window ).on( 'resize', function() {
		jQuery( '.content-boxes-icon-boxed' ).each( function() {
			jQuery( this ).find( '.content-box-column .content-wrapper-boxed' ).equalHeights();
			jQuery( this ).find( '.content-box-column .content-wrapper-boxed' ).css( 'overflow', 'visible' );
		});
	});

	jQuery( '.double-sidebars.woocommerce .social-share > li' ).equalHeights();

	jQuery( '.fusion-fullwidth.fusion-equal-height-columns' ).each( function() {
		jQuery( this ).find( '.fusion-layout-column .fusion-column-wrapper' ).equalHeights();
	});

	jQuery( '.fusion-layout-column .fusion-column-wrapper' ).fusion_set_bg_img_dims();
	jQuery( '.fusion-layout-column .fusion-column-wrapper' ).fusion_calculate_empty_column_height();

	jQuery( window ).on( 'resize', function() {
		jQuery( '.fusion-fullwidth.fusion-equal-height-columns' ).each( function() {
			jQuery( this ).find( '.fusion-layout-column .fusion-column-wrapper' ).equalHeights();
		});

		jQuery( '.fusion-layout-column .fusion-column-wrapper' ).fusion_calculate_empty_column_height();
	});

	/**
	 * Icon Hack for iOS7 on Buttons
	 */
	if(cssua.ua.ios) {
		var ios_version = parseInt(cssua.ua.ios);
		if(ios_version == 7) {
			jQuery('.button-icon-divider-left, .button-icon-divider-right').each(function() {
				var height = jQuery(this).parent().outerHeight();
				jQuery(this).css('height', height);

			});
		}
	}
}); // end window_load_1

jQuery(document).ready(function($) { // start document_ready_1
	// Loop through all headings
	jQuery( 'h1, h2, h3, h4, h5, h6' ).each(
		function() {

			// If there are inline styles on the element initially, store information about it in data attribute
			if ( jQuery( this ).prop( 'style' )['font-size'] ) {
				jQuery( this ).attr( 'data-inline-fontsize', true );
			}

			if ( jQuery( this ).prop( 'style' )['font-size'] ) {
				jQuery( this ).attr( 'data-inline-lineheight', true );
			}

			// Set the original font size and line height to every heading as data attribute
			jQuery( this ).attr( 'data-fontsize', parseInt( jQuery( this ).css( 'font-size' ) ) );
			jQuery( this ).attr( 'data-lineheight', parseInt( jQuery( this ).css( 'line-height' ) ) );
		}
	);

	// Setup responsive type for headings if enabled in Theme Options
	if ( js_local_vars.typography_responsive == 1 ) {
		// Calculate responsive type values
		fusion_calculate_responsive_type_values( js_local_vars.typography_sensitivity, js_local_vars.typography_factor, 800, 'h1, h2, h3, h4, h5, h6' );
	}

	jQuery( '.tfs-slider' ).each(function() {
		fusion_calculate_responsive_type_values( jQuery( this ).data( 'typo_sensitivity' ), jQuery( this ).data( 'typo_factor' ), 800, '.tfs-slider h2, .tfs-slider h3' );
	});

	// Carousle resize
	jQuery(window).on( 'resize', function() {
		jQuery( '.fusion-carousel' ).fusion_recalculate_carousel();
	});

	// Handle parallax footer
	jQuery( '.fusion-footer-parallax' ).fusion_footer_parallax();

	jQuery(window).on( 'resize', function() {
		jQuery( '.fusion-footer-parallax' ).fusion_footer_parallax();
	});

	// Check if the side header is larger than browser window in height and make it scrolling if needed
	if( js_local_vars.header_position != 'Top' ) {
		var resize_width = jQuery(window).width();
		var resize_height = jQuery(window).height();

		jQuery(window).on( 'resize', function() {
			if( jQuery(window).width() != resize_width || jQuery(window).height() != resize_height ) {
				if( jQuery( window ).height() < jQuery( '.side-header-wrapper' ).height() ) {
					jQuery('body').css(	'position', 'relative' );

					if ( jQuery( '.above-footer-wrapper' ).length ) {
						jQuery( 'html, body, #boxed-wrapper, #wrapper' ).css( 'height', jQuery( '.side-header-wrapper' ).height() + 20 );
					}

					if( jQuery( '.layout-boxed-mode' ).length && js_local_vars.header_position == 'Right'  ) {
						jQuery( '.side-header-wrapper' ).css( 'position', 'absolute' );

					} else if( jQuery( 'body.rtl' ).length && js_local_vars.header_position == 'Left' ) {
						jQuery( '#side-header' ).css({
							'position': 'absolute',
							'top': '0'
						});
						jQuery( '.side-header-wrapper' ).css( 'position', 'absolute' );
						jQuery( '#slidingbar-area' ).css( 'top', '0' );
					} else {
						jQuery( '#slidingbar-area' ).css( 'top', '0' );

						jQuery( '#side-header' ).css({
							'position': 'absolute',
							'top': '0'
						});
					}
				} else {
					jQuery('body').css(	'position', '' );

					jQuery( 'html, body, #boxed-wrapper, #wrapper' ).css( 'height', '' );

					jQuery( '#slidingbar-area' ).css( 'top', '' );

					jQuery( '#side-header' ).css({
						'position': '',
						'top': ''
					});

					jQuery( '.side-header-wrapper' ).css( 'position', '' );
				}

				resize_width = jQuery(window).width();
				resize_height = jQuery(window).height();
			}
		});

		if( jQuery( window ).height() < jQuery( '.side-header-wrapper' ).height() ) {
			jQuery('body').css(	'position', 'relative' );

			if ( jQuery( '.above-footer-wrapper' ).length ) {
				jQuery( 'html, body, #boxed-wrapper, #wrapper' ).css( 'height', jQuery( '.side-header-wrapper' ).height() + 20 );
			}

			if( jQuery( '.layout-boxed-mode' ).length && js_local_vars.header_position == 'Right'  ) {
				jQuery( '.side-header-wrapper' ).css( 'position', 'absolute' );
			} else if( jQuery( 'body.rtl' ).length && js_local_vars.header_position == 'Left' ) {
				jQuery( '#side-header' ).css({
					'position': 'absolute',
					'top': '0'
				});
				jQuery( '.side-header-wrapper' ).css( 'position', 'absolute' );
				jQuery( '#slidingbar-area' ).css( 'top', '0' );
			} else {
				jQuery( '#slidingbar-area' ).css( 'top', '0' );

				jQuery( '#side-header' ).css({
					'position': 'absolute',
					'top': '0'
				});
			}
		}
	}

	if ( js_local_vars.disable_mobile_animate_css == '1' && cssua.ua.mobile ) {
		jQuery( 'body' ).addClass( 'dont-animate' );
	} else {
		jQuery( 'body' ).addClass( 'do-animate' );
	}

	// Sidebar Position
	if(jQuery('#sidebar-2').length >= 1) {
		var sidebar_1_float = jQuery('#sidebar').css('float');
		jQuery('body').addClass('sidebar-position-' + sidebar_1_float);
	}

	jQuery('.fusion-flip-box').mouseover(function() {
		jQuery(this).addClass('hover');
	});

	jQuery('.fusion-flip-box').mouseout(function() {
		jQuery(this).removeClass('hover');
	});

	jQuery('.fusion-accordian .panel-title a').click(function(e) {
		e.preventDefault();
	});

	jQuery(".my-show").click(function(){
		jQuery(".my-hidden").css('visibility', 'visible');
	});

	if (jQuery(".demo_store").length ) {
		jQuery("#wrapper").css('margin-top', jQuery(".demo_store").outerHeight());
		if(jQuery("#slidingbar-area").outerHeight()  > 0) {
			jQuery(".header-wrapper").css('margin-top', '0');
		}
		if(jQuery('.sticky-header').length ) {
			jQuery('.sticky-header').css('margin-top', jQuery('.demo_store').outerHeight());
		}
	}

	// Slidingbar initialization
	var slidingbar_state = 0;

 	// Open slidingbar on page load if .open_onload class is present
	if ( jQuery( '#slidingbar-area.open_onload' ).length ) {
		jQuery( '#slidingbar' ).slideDown( 240,'easeOutQuad' );
		jQuery( '.sb-toggle' ).addClass( 'open' );
		slidingbar_state = 1;

		// Reinitialize google maps
		if ( jQuery('#slidingbar .shortcode-map' ).length ) {
			jQuery( '#slidingbar' ).find( '.shortcode-map' ).each( function() {
				jQuery( this ).reinitialize_google_map();
			});
		}

		jQuery( '#slidingbar-area' ).removeClass('open_onload');
	}

	// Handle the slidingbar toggle click
	jQuery( '.sb-toggle' ).click( function(){
		var $slidingbar = jQuery ( this ).parents( '#slidingbar-area' ).children( '#slidingbar' );

		//Expand
		if ( slidingbar_state === 0 ) {
			$slidingbar.slideDown( 240, 'easeOutQuad' );
			jQuery( '.sb-toggle' ).addClass( 'open' );
			slidingbar_state = 1;

			// Reinitialize google maps
			if ( $slidingbar.find( '.shortcode-map' ).length ) {
				$slidingbar.find( '.shortcode-map' ).each( function() {
					jQuery( this ).reinitialize_google_map();
				});
			}

			// Reinitialize carousels
			if( $slidingbar.find( '.fusion-carousel' ).length ) {
				generate_carousel();
			}

			jQuery( '#slidingbar' ).find( '.fusion-carousel' ).fusion_recalculate_carousel();

			// reinitialize testimonial height; only needed for hidden wrappers
			if ( $slidingbar.find( '.fusion-testimonials' ).length ) {
				var $active_testimonial = $slidingbar.find( '.fusion-testimonials .reviews' ).children( '.active-testimonial' );

				$slidingbar.find( '.fusion-testimonials .reviews' ).height( $active_testimonial.height() );
			}

		//Collapse
		} else if( slidingbar_state == 1 ) {
			$slidingbar.slideUp(240,'easeOutQuad');
			jQuery( '.sb-toggle' ).removeClass( 'open' );
			slidingbar_state = 0;
		}
	});

	// Foter without social icons
	if( ! jQuery( '.fusion-social-links-footer' ).find( '.fusion-social-networks' ).children().length ) {
		jQuery( '.fusion-social-links-footer' ).hide();
		jQuery( '.fusion-footer-copyright-area .fusion-copyright-notice' ).css( 'padding-bottom', '0' );
	}

	// to top
	if(jQuery().UItoTop) {
		if(cssua.ua.mobile && js_local_vars.status_totop_mobile == '1') {
			jQuery().UItoTop({ easingType: 'easeOutQuart' });
		} else if( ! cssua.ua.mobile ) {
			jQuery().UItoTop({ easingType: 'easeOutQuart' });
		}
	}

	// sticky header resizing control
	jQuery(window).on('resize', function() {
		// check for woo demo bar which can take on 2 lines and thus sticky position must be calculated
		if(jQuery(".demo_store").length) {
			jQuery("#wrapper").css('margin-top', jQuery(".demo_store").outerHeight());
			if(jQuery('.sticky-header').length) {
				jQuery(".sticky-header").css('margin-top', jQuery(".demo_store").outerHeight());
			}
		}

		if(jQuery(".sticky-header").length ) {
			if(jQuery(window).width() < 765) {
				jQuery('body.admin-bar #header-sticky.sticky-header').css('top', '46px');
			} else {
				jQuery('body.admin-bar #header-sticky.sticky-header').css('top', '32px');
			}
		}
	});

	//side header main nav
	if(js_local_vars.mobile_menu_design == 'classic') {
		jQuery('.sh-mobile-nav-holder').append('<div class="mobile-selector"><span>'+js_local_vars.dropdown_goto+'</span></div>');
		jQuery('.sh-mobile-nav-holder .mobile-selector').append('<div class="selector-down"></div>');
	}
	jQuery('.sh-mobile-nav-holder').append(jQuery('.nav-holder .fusion-navbar-nav').clone());
	jQuery('.sh-mobile-nav-holder .fusion-navbar-nav').attr("id","mobile-nav");
	jQuery('.sh-mobile-nav-holder ul#mobile-nav').removeClass('fusion-navbar-nav');
	jQuery('.sh-mobile-nav-holder ul#mobile-nav').children('.cart').remove();
	jQuery('.sh-mobile-nav-holder ul#mobile-nav .mobile-nav-item').children('.login-box').remove();

	jQuery('.sh-mobile-nav-holder ul#mobile-nav li').children('#main-nav-search-link').each(function () {
		jQuery(this).parents('li').remove();
	});
	jQuery('.sh-mobile-nav-holder ul#mobile-nav').find('li').each(function () {
		var classes = 'mobile-nav-item';

		if(jQuery(this).hasClass('current-menu-item') || jQuery(this).hasClass('current-menu-parent') || jQuery(this).hasClass('current-menu-ancestor')) {
			classes += ' mobile-current-nav-item';
		}
		jQuery( this ).attr( 'class', classes );
		if( jQuery( this ).attr( 'id' ) ) {
			jQuery( this ).attr( 'id', jQuery( this ).attr( 'id' ).replace( 'menu-item', 'mobile-menu-item' ) );
		}
		jQuery( this ).attr( 'style', '' );
	});
	jQuery('.sh-mobile-nav-holder .mobile-selector').click(function(){
		if( jQuery('.sh-mobile-nav-holder #mobile-nav').hasClass( 'mobile-menu-expanded' ) ) {
			jQuery('.sh-mobile-nav-holder #mobile-nav').removeClass( 'mobile-menu-expanded' );
		} else {
			jQuery('.sh-mobile-nav-holder #mobile-nav').addClass( 'mobile-menu-expanded' );
	}
		jQuery('.sh-mobile-nav-holder #mobile-nav').slideToggle(200,'easeOutQuad');
	});

	// Make megamenu items mobile ready
	jQuery('.header-wrapper .mobile-nav-holder .navigation > .mobile-nav-item, .sticky-header .mobile-nav-holder .navigation > .mobile-nav-item, .sh-mobile-nav-holder .navigation > .mobile-nav-item').each(function() {
		jQuery(this).find('.fusion-megamenu-widgets-container').remove();

		jQuery(this).find('.fusion-megamenu-holder > ul').each( function() {
			jQuery(this).attr('class', 'sub-menu');
			jQuery(this).attr('style', '');
			jQuery(this).find('> li').each( function() {

				// add menu needed menu classes to li elements
				var classes = 'mobile-nav-item';

				if(jQuery(this).hasClass('current-menu-item') || jQuery(this).hasClass('current-menu-parent') || jQuery(this).hasClass('current-menu-ancestor') || jQuery(this).hasClass('mobile-current-nav-item')) {
					classes += ' mobile-current-nav-item';
				}
				jQuery( this ).attr( 'class', classes );

				// Append column titles and title links correctly
				if( ! jQuery(this).find('.fusion-megamenu-title a, > a').length ) {
					jQuery(this).find('.fusion-megamenu-title').each( function() {
						if( ! jQuery( this ).children( 'a' ).length ) {
							jQuery( this ).append( '<a href="#">' + jQuery( this ).text() + '</a>' );
						}
					});

					if( ! jQuery(this).find('.fusion-megamenu-title').length ) {

						var parent_li = jQuery(this);

						jQuery( this ).find( '.sub-menu').each( function() {
							parent_li.after( jQuery( this ) );

						});
						jQuery( this ).remove();
					}
				}
				jQuery( this ).prepend( jQuery( this ).find( '.fusion-megamenu-title a, > a' ) );

				jQuery( this ).find( '.fusion-megamenu-title' ).remove();
			});
			jQuery( this ).closest( '.mobile-nav-item' ).append( jQuery( this ) );
		});

		jQuery( this ).find( '.fusion-megamenu-wrapper, .caret, .fusion-megamenu-bullet' ).remove();
	});

	// Make mobile menu sub-menu toggles
	if( js_local_vars.submenu_slideout == 1 ) {
		jQuery('.header-wrapper .mobile-topnav-holder .mobile-topnav li, .header-wrapper .mobile-nav-holder .navigation li, .sticky-header .mobile-nav-holder .navigation li, .sh-mobile-nav-holder .navigation li').each(function() {
			var classes = 'mobile-nav-item';

			if(jQuery(this).hasClass('current-menu-item') || jQuery(this).hasClass('current-menu-parent') || jQuery(this).hasClass('current-menu-ancestor') || jQuery(this).hasClass('mobile-current-nav-item')) {
				classes += ' mobile-current-nav-item';
			}
			jQuery( this ).attr( 'class', classes );

			if( jQuery( this ).find( ' > ul' ).length ) {
				jQuery( this ).prepend('<span href="#" aria-haspopup="true" class="open-submenu"></span>' );

				jQuery( this ).find( ' > ul' ).hide();
			}
		});

		jQuery('.header-wrapper .mobile-topnav-holder .open-submenu, .header-wrapper .mobile-nav-holder .open-submenu, .sticky-header .mobile-nav-holder .open-submenu, .sh-mobile-nav-holder .open-submenu').click( function(e) {

			e.stopPropagation();
			jQuery( this ).parent().children( '.sub-menu' ).slideToggle(200,'easeOutQuad');

		});
	}

	// One page scrolling effect
	var $sticky_header_type = 1,
		$adminbar_height = 0,
		$sticky_header_height = 0;

	function set_sticky_header_height() {
		// Set the correct WP admin bar height
		if ( jQuery( '#wpadminbar' ).length ) {
			$adminbar_height = parseInt( jQuery( '#wpadminbar' ).outerHeight() );
		}

		// Set header type to 2 for headers v4, v5
		if ( jQuery( '.fusion-header-v4' ).length || jQuery( '.fusion-header-v5' ).length ) {
			$sticky_header_type = 2;
		}

		// Sticky header is enabled
		if ( js_local_vars.header_sticky == '1' ) {
			// Desktop mode - headers v1, v2, v3
			if ( $sticky_header_type == 1 ) {
				$sticky_header_height = jQuery( '.fusion-header' ).outerHeight();
			// Desktop mode - headers v4, v5
			} else {
				$sticky_header_height = jQuery( '.fusion-secondary-main-menu' ).outerHeight();
			}

			// Mobile mode
			if ( window.$media_query_test_4 ) {

				// Sticky header is enabled on mobile
				if ( js_local_vars.header_sticky_mobile == '1' ) {
					// Classic mobile menu
					if ( jQuery( '.fusion-mobile-menu-design-classic' ).length ) {
						$sticky_header_height = jQuery( '.fusion-secondary-main-menu' ).outerHeight();
					}

					// Modern mobile menu
					if ( jQuery( '.fusion-mobile-menu-design-modern' ).length ) {
						$sticky_header_height = jQuery( '.fusion-header' ).outerHeight();
					}
				// Sticky header is disabled on mobile
				} else {
					$sticky_header_height = 0;
				}
			}

			// Tablet mode
			if ( js_local_vars.header_sticky_tablet != '1' && ( window.$media_query_test_1 ) ) {
				$sticky_header_height = 0;
			}
		}
	}

	set_sticky_header_height();

	jQuery( window ).on('resize scroll', function() {
		set_sticky_header_height();
	});

	jQuery( '.fusion-menu a:not([href=#], .fusion-megamenu-widgets-container a, .search-link), .fusion-mobile-nav-item a:not([href=#], .search-link), .fusion-button:not([href=#]), .fusion-one-page-text-link:not([href=#])' ).click( function() {
		if ( location.pathname.replace( /^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname ) {
			if ( this.hash ) {
				var $target = jQuery( this.hash );
				$target = $target.length ? $target : jQuery( '[name=' + this.hash.slice( 1 ) +']' );
				if ( $target.length && this.hash.slice( 1 ) !== '' ) {
					set_sticky_header_height();

					var $current_scroll_position = $( document ).scrollTop(),
						$new_scroll_position = $target.offset().top - $adminbar_height - $sticky_header_height,
						$half_scroll_amount = Math.abs( $current_scroll_position - $new_scroll_position ) / 2;

					if ( $current_scroll_position > $new_scroll_position ) {
						var $half_scroll_position = $current_scroll_position - $half_scroll_amount;
					} else {
						var $half_scroll_position = $current_scroll_position + $half_scroll_amount;
					}

					jQuery( 'html, body' ).animate({
						 scrollTop: $half_scroll_position
					}, { duration: 400, easing: 'easeInExpo', complete: function() {

						set_sticky_header_height();

						$new_scroll_position = ( $target.offset().top - $adminbar_height - $sticky_header_height );

						jQuery( 'html, body' ).animate({
							 scrollTop: $new_scroll_position
						}, 450, 'easeOutExpo');

					}

					});

					// On page tab link
					if ( $target.hasClass( 'tab-link' ) ) {
						jQuery( '.fusion-tabs' ).fusion_switch_tab_on_link_click();
					}

					return false;
				}
			}
		}
	});

	jQuery( 'body' ).scrollspy({
		target: '.fusion-menu',
		offset: parseInt( $adminbar_height + $sticky_header_height + 1 )
	});

	// side nav drop downs
	jQuery('.side-nav-left .side-nav li').each(function() {
		if(jQuery(this).find('> .children').length) {
			if( jQuery( '.rtl' ).length ) {
				jQuery(this).find('> a').prepend('<span class="arrow"></span>');
			} else {
				jQuery(this).find('> a').append('<span class="arrow"></span>');
			}
		}
	});

	jQuery('.side-nav-right .side-nav li').each(function() {
		if(jQuery(this).find('> .children').length) {
			if( jQuery( 'body.rtl' ).length ) {
				jQuery(this).find('> a').append('<span class="arrow"></span>');
			} else {
				jQuery(this).find('> a').prepend('<span class="arrow"></span>');
			}
		}
	});

	jQuery('.side-nav .current_page_item').each(function() {
		if(jQuery(this).find('.children').length ){
			jQuery(this).find('.children').show('slow');
		}
	});

	jQuery('.side-nav .current_page_item').each(function() {
		if(jQuery(this).parent().hasClass('side-nav')) {
			jQuery(this).find('ul').show('slow');
		}

		if(jQuery(this).parent().hasClass('children')){
			jQuery(this).parents('ul').show('slow');
		}
	});

	if ('ontouchstart' in document.documentElement || navigator.msMaxTouchPoints) {
		jQuery('.fusion-main-menu li.menu-item-has-children > a, .fusion-secondary-menu li.menu-item-has-children > a, .order-dropdown > li .current-li').on("click", function (e) {
			var link = jQuery(this);
			if (link.hasClass('hover')) {
				link.removeClass("hover");
				return true;
			} else {
				link.addClass("hover");
				jQuery('.fusion-main-menu li.menu-item-has-children > a, .fusion-secondary-menu li.menu-item-has-children > a, .order-dropdown > li .current-li').not(this).removeClass("hover");
				return false;
			}
		});


		jQuery('.sub-menu li, .fusion-mobile-nav-item li').not('li.menu-item-has-children').on("click", function (e) {
			var link = jQuery(this).find('a').attr('href');
			window.location = link;

	  		return true;
		});
	}

	// Touch support for win phone devices
	jQuery( '.fusion-main-menu li.menu-item-has-children a, .fusion-secondary-menu li.menu-item-has-children a, .side-nav li.page_item_has_children a' ).each( function() {
		jQuery( this ).attr( 'aria-haspopup', 'true' );
	});

	// Ubermenu responsive fix
	if(jQuery('.megaResponsive').length >= 1) {
		jQuery('.mobile-nav-holder.main-menu').addClass('set-invisible');
	}

	// WPML search form input add
	if( js_local_vars.language_flag !== '' ) {
		jQuery('.search-field, .searchform').each( function() {
			if( ! jQuery( this ).find( 'input[name="lang"]' ).length && ! jQuery( this ).parents( '.searchform' ).find( 'input[name="lang"]' ).length ) {
				jQuery( this ).append('<input type="hidden" name="lang" value="'+js_local_vars.language_flag+'"/>');
			}
		});
	}

	jQuery( '#wrapper .share-box' ).each( function() {
		if( ! jQuery( 'meta[property="og:title"]' ).length ) {
			jQuery( 'head title' ).after( '<meta property="og:title" content="' + jQuery( this ).data( 'title' )  + '"/>' );
			jQuery( 'head title' ).after( '<meta property="og:description" content="' + jQuery( this ).data( 'description' )  + '"/>' );
			jQuery( 'head title' ).after( '<meta property="og:type" content="article"/>' );
			jQuery( 'head title' ).after( '<meta property="og:url" content="' + jQuery( this ).data( 'link' )  + '"/>' );
			jQuery( 'head title' ).after( '<meta property="og:image" content="' + jQuery( this ).data( 'image' )  + '"/>' );
		}
	});

	sharebox_h4_width = jQuery('#wrapper .share-box h4').outerWidth();
	sharebox_ul = jQuery('.share-box ul').outerWidth();
	// social share box alignment on resize
	if( sharebox_h4_width + sharebox_ul > jQuery('.post-content').width() && ! jQuery('.single-avada_portfolio').length ) {
		jQuery('#wrapper .share-box').css('height', 'auto');
		jQuery('#wrapper .share-box h4').css('float', 'none').css('line-height', '20px').css('padding-bottom', '25px').css('padding-top', '25px');
		jQuery('.share-box ul').css('float', 'none').css('margin-top', '0').css('overflow', 'hidden').css('padding', '0 25px 25px');
	} else {
		jQuery('#wrapper .share-box').css( 'height', '' );
	}

	jQuery(window).on('resize', function() {
		jQuery('.title').each(function(index) {
			if(special_titles_width[index] > jQuery(this).parent().width()) {
				jQuery(this).addClass('border-below-title');
			} else {
				jQuery(this).removeClass('border-below-title');
			}
		});

		// social share box alignment on resize
		if( sharebox_h4_width + sharebox_ul > jQuery('#content').width() ) {
			jQuery('#wrapper .share-box').css('height', 'auto');
			jQuery('#wrapper .share-box h4').css('float', 'none').css('line-height', '20px').css('padding-bottom', '25px').css('padding-top', '25px');
			jQuery('.share-box ul').css('float', 'none').css('margin-top', '0').css('overflow', 'hidden').css('padding', '0 25px 25px');
		} else {
			jQuery('#wrapper .share-box').css( 'height', '' );
			//jQuery('#wrapper .share-box, #wrapper .share-box h4, .share-box ul').attr("style", "");
		}
	});

	// Position main menu search box correctly
	if( js_local_vars.header_position == 'Top' ) {
		jQuery(window).on( 'resize', function() {
			jQuery( '.main-nav-search' ).each( function() {
				if( jQuery( this ).hasClass( 'search-box-open' ) ) {
					var search_form = jQuery( this ).find( '.main-nav-search-form' ),
						search_form_width = search_form.outerWidth(),
						search_form_left_edge = search_form.offset().left,
						search_form_right_edge = search_form_left_edge + search_form_width,
						search_menu_item_left_edge = search_form.parent().offset().left,
						window_right_edge = jQuery( window ).width();


					if( ! jQuery( 'body.rtl' ).length ) {
						if( ( search_form_left_edge < search_menu_item_left_edge && search_form_left_edge < 0 ) || ( search_form_left_edge == search_menu_item_left_edge && search_form_left_edge - search_form_width < 0 ) ) {
							search_form.css({
								'left': '0',
								'right': 'auto'
							});
						} else {
							search_form.css({
								'left': 'auto',
								'right': '0'
							});
						}
					} else {
						if( ( search_form_left_edge == search_menu_item_left_edge && search_form_right_edge > window_right_edge ) || ( search_form_left_edge < search_menu_item_left_edge && search_form_right_edge + search_form_width > window_right_edge )  ) {
							search_form.css({
								'left': 'auto',
								'right': '0'
							});
						} else {
							search_form.css({
								'left': '0',
								'right': 'auto'
							});
						}
					}
				}
			});
		});
	}

	var special_titles_width = [];
	jQuery('.title').each(function(index) {
		special_titles_width[index] = jQuery(this).find('h1,h2,h3,h4,h5,h6').width();
		if(jQuery(this).find('h1,h2,h3,h4,h5,h6').width() > jQuery(this).parent().width()) {
			jQuery(this).addClass('border-below-title');
		}
	});

	// Tabs
	// On page load
	// Direct linked tab handling
	jQuery( '.fusion-tabs' ).fusion_switch_tab_on_link_click();

	//On Click Event
	jQuery(".nav-tabs li").click(function(e) {
		var clicked_tab = jQuery(this);
		var tab_content_to_activate = jQuery(this).find("a").attr("href");
		var map_id = clicked_tab.attr('id');

		setTimeout( function(){
			clicked_tab.parents( '.fusion-tabs' ).find( tab_content_to_activate ).find( '.shortcode-map' ).each(function() {
				jQuery( this ).reinitialize_google_map();
			});

			if( clicked_tab.parents( '.fusion-tabs' ).find( tab_content_to_activate ).find( '.fusion-carousel' ).length ) {
				generate_carousel();
			}

			clicked_tab.parents( '.fusion-tabs' ).find( tab_content_to_activate ).find( '.fusion-portfolio' ).each( function() {
				jQuery( this).find( '.fusion-portfolio-wrapper' ).isotope();
			});

			// To make premium sliders work in tabs
			if( clicked_tab.parents( '.fusion-tabs' ).find( tab_content_to_activate ).find( '.flexslider, .rev_slider_wrapper, .ls-container' ).length ) {
				jQuery( window ).trigger( 'resize' );
			}

			clicked_tab.parents( '.fusion-tabs' ).find( tab_content_to_activate ).find( '.fusion-blog-shortcode' ).each( function() {
				var columns = 2;
				for( i = 1; i < 7; i++ ) {
					if( jQuery( this ).find( '.fusion-blog-layout-grid' ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
						columns = i;
					}
				}

				var grid_width = Math.floor( 100 / columns * 100 ) / 100  + '%';
				jQuery( this ).find( '.fusion-blog-layout-grid' ).find( '.fusion-post-grid' ).css( 'width', grid_width );

				jQuery( this).find( '.fusion-blog-layout-grid' ).isotope();

				calc_select_arrow_dimensions();
			});
		}, 350);

		e.preventDefault();
	});

	// Tabs Widget
	jQuery( '.tabs-widget .tabset li a' ).click( function( e ) {
		e.preventDefault();
	});

	// When page loads
	jQuery( '.tabs-widget' ).each(function() {
		jQuery( this ).find( '.tabset li:first' ).addClass( 'active' ).show(); //Activate first tab
		jQuery( this ).find( '.tab_content:first' ).show(); //Show first tab content
	});

	//On Click Event
	jQuery( '.tabs-widget .tabset li' ).click(function(e) {
		var tab_to_activate = jQuery( this ).find( 'a' ).attr( 'href' );

		jQuery( this ).parent().find( ' > li' ).removeClass( 'active' ); //Remove all 'active' classes
		jQuery( this ).addClass( 'active' ); // Add 'active' class to selected tab

		jQuery( this ).parents( '.tabs-widget' ).find( '.tab_content' ).hide(); //Hide all tab content
		jQuery( this ).parents( '.tabs-widget' ).find( tab_to_activate ).fadeIn(); //Fade in the new active tab content
	});

	jQuery('.woocommerce .images #carousel a').click(function(e) {
		e.preventDefault();
	});

	jQuery('.tooltip-shortcode, .fusion-secondary-header .fusion-social-networks li, .fusion-author-social .fusion-social-networks li, .fusion-footer-copyright-area .fusion-social-networks li, .fusion-footer-widget-area .fusion-social-networks li, .sidebar .fusion-social-networks li, .social_links_shortcode li, .share-box li, .social-icon, .social li').mouseenter(function(e){
		jQuery(this).find('.popup').hoverFlow(e.type, {
			'opacity' :'show'
		});
	});

	jQuery('.tooltip-shortcode, .fusion-secondary-header .fusion-social-networks li, .fusion-author-social .fusion-social-networks li, .fusion-footer-copyright-area .fusion-social-networks li, .fusion-footer-widget-area .fusion-social-networks li, .sidebar .fusion-social-networks li, .social_links_shortcode li, .share-box li, .social-icon, .social li').mouseleave(function(e){
		jQuery(this).find('.popup').hoverFlow(e.type, {
			'opacity' :'hide'
		});
	});

	// Handle the portfolio filter clicks
	jQuery('.fusion-portfolio .fusion-filters a').click( function( e ) {
		e.preventDefault();

		// Relayout isotope based on filter selection
		var $filter_active = jQuery( this ).data( 'filter' );
		jQuery( this ).parents( '.fusion-portfolio' ).find( '.fusion-portfolio-wrapper' ).isotope( { filter: $filter_active } );

		// Remove active filter class from old filter item and add it to new
		jQuery( this ).parents( '.fusion-filters' ).find( '.fusion-filter' ).removeClass( 'fusion-active' );
		jQuery( this ).parent().addClass( 'fusion-active' );

		if ( $filter_active.length ) {
			// Set the lightbox gallery
			jQuery( this ).parents( '.fusion-portfolio' ).find( '.fusion-portfolio-wrapper' ).find( $filter_active ).each( function() {
				jQuery( this ).find( '.fusion-rollover-gallery' ).attr( 'data-rel', 'iLightbox[' + $filter_active.substr(1) + ']' );
			});
		} else {
			jQuery( this ).parents( '.fusion-portfolio' ).find( '.fusion-portfolio-wrapper' ).find( '.fusion-portfolio-post' ).each( function() {
				jQuery( this ).find( '.fusion-rollover-gallery' ).attr( 'data-rel', 'iLightbox[gallery]' );
			});
		}

		// Check if we need to create a new gallery
		if ( jQuery( this ).data( 'lightbox' ) != 'created' ) {


			// Create new lightbox instance for the new gallery
			$filter_active = $filter_active.substr( 1 );
			$il_instances.push( jQuery( '[data-rel="iLightbox[' + $filter_active + ']"], [rel="iLightbox[' + $filter_active + ']"]' ).iLightBox( $avada_lightbox.prepare_options( 'iLightbox[' + $filter_active + ']' ) ) );

			// Refresh the lightbox
			$avada_lightbox.refresh_lightbox();

			// Set filter to lightbox created
			jQuery( this ).data( 'lightbox', 'created' );
		}
	});

	// Setup filters and click events for the faq page
	jQuery( '.fusion-faqs' ).each( function() {
		// Initialize the filters and corresponding posts
		// Check if filters are displayed
		var $faqs_page = jQuery( this ),
			$filters_wrapper = $faqs_page.find( '.fusion-filters' );

			// Make the faq posts visible
			jQuery( '.fusion-faqs-wrapper' ).fadeIn();

		if ( $filters_wrapper.length ) {

			// Make filters visible
			$filters_wrapper.fadeIn();

			// Set needed variables
			var $filters = $filters_wrapper.find( '.fusion-filter' ),
				$filter_active_element = $filters_wrapper.find( '.fusion-active' ).children( 'a' ),
				$filter_active =  $filter_active_element.attr( 'data-filter' ).substr( 1 ),
				$posts = jQuery( this ).find( '.fusion-faqs-wrapper .fusion-faq-post' );

			// Loop through filters
			if ( $filters ) {
				$filters.each( function() {
					var $filter = jQuery( this ),
						$filter_name = $filter.children( 'a' ).data( 'filter' );

					// Loop through post set
					if ( $posts ) {
						// If "All" filter is deactivated, hide posts for later check for active filter
						if ( $filter_active.length ) {
							$posts.hide();
						}

						$posts.each( function() {
							var $post = jQuery( this );

							// If a post belongs to an invisible filter, fade the filter in
							if ( $post.hasClass( $filter_name.substr( 1 ) ) ) {
								if ( $filter.hasClass( 'fusion-hidden' ) ) {
									$filter.removeClass( 'fusion-hidden' );
								}
							}

							// If "All" filter is deactivated, only show the items of the first filter (which is auto activated)
							if ( $filter_active.length && $post.hasClass( $filter_active ) ) {
								$post.show();
							}
						});
					}
				});
			}
		}

		// Handle the filter clicks
		$faqs_page .find( '.fusion-filters a' ).click( function(e) {
			e.preventDefault();

			var selector = jQuery( this ).attr( 'data-filter' );

			// Fade out the faq posts and fade in the ones matching the selector
			$faqs_page .find( '.fusion-faqs-wrapper .fusion-faq-post' ).fadeOut();
			setTimeout( function() {
				$faqs_page .find( '.fusion-faqs-wrapper .fusion-faq-post' + selector ).fadeIn();
			}, 400 );

			// Set the active
			jQuery( this ).parents( '.fusion-filters' ).find( '.fusion-filter' ).removeClass( 'fusion-active' );
			jQuery( this ).parent().addClass( 'fusion-active' );
		});
	});

	function isScrolledIntoView(elem)
	{
		var docViewTop = jQuery(window).scrollTop();
		var docViewBottom = docViewTop + jQuery(window).height();

		var elemTop = jQuery(elem).offset().top;
		var elemBottom = elemTop + jQuery(elem).height();

		return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	}

	jQuery('.fusion-alert .close').click(function(e) {
		e.preventDefault();

		jQuery(this).parent().slideUp();
	});

	jQuery('input, textarea').placeholder();

	function checkForImage(url) {
		return( url.match(/\.(jpeg|jpg|gif|png)$/) !== null );
	}

	if(Modernizr.mq('only screen and (max-width: 479px)')) {
		jQuery('.overlay-full.layout-text-left .slide-excerpt p').each(function () {
			var excerpt = jQuery(this).html();
			var wordArray = excerpt.split(/[\s\.\?]+/); //Split based on regular expression for spaces
			var maxWords = 10; //max number of words
			var total_words = wordArray.length; //current total of words
			var newString = "";
			//Roll back the textarea value with the words that it had previously before the maximum was reached
			if (total_words > maxWords+1) {
				 for (var i = 0; i < maxWords; i++) {
					newString += wordArray[i] + " ";
				}
				jQuery(this).html(newString);
			}
		});

		jQuery('.fusion-portfolio .fusion-rollover-gallery').each(function () {
			var img = jQuery(this).attr('href');

			if(checkForImage(img) === true) {
				jQuery(this).parents('.fusion-image-wrapper').find('> img').attr('src', img).attr('width', '').attr('height', '');
			}
			jQuery(this).parents('.fusion-portfolio-post').css('width', 'auto');
			jQuery(this).parents('.fusion-portfolio-post').css('height', 'auto');
			jQuery(this).parents('.fusion-portfolio-one:not(.fusion-portfolio-one-text)').find('.fusion-portfolio-post').css('margin', '0');
		});

		if( jQuery('.fusion-portfolio').length ) {
			jQuery('.fusion-portfolio-wrapper').isotope();
		}
	}

	if(Modernizr.mq('only screen and (max-width: 800px)')) {
		jQuery('.tabs-vertical').addClass('tabs-horizontal').removeClass('tabs-vertical');
	}

	jQuery(window).on('resize', function() {
		if(Modernizr.mq('only screen and (max-width: 800px)')) {
			jQuery('.tabs-vertical').addClass('tabs-original-vertical');
			jQuery('.tabs-vertical').addClass('tabs-horizontal').removeClass('tabs-vertical');
		} else {
			jQuery('.tabs-original-vertical').removeClass('tabs-horizontal').addClass('tabs-vertical');
		}
	});

	// Woocommerce
	jQuery('.catalog-ordering .orderby .current-li a').html(jQuery('.catalog-ordering .orderby ul li.current a').html());
	jQuery('.catalog-ordering .sort-count .current-li a').html(jQuery('.catalog-ordering .sort-count ul li.current a').html());
	jQuery('.woocommerce .shop_table .variation dd').after('<br />');
	jQuery('.woocommerce .avada-myaccount-data th.order-actions').text(js_local_vars.order_actions);

	jQuery( 'body.rtl .woocommerce .wc-forward' ).each( function() {
		var checkout_button = jQuery( this );
		checkout_button.val( '\u2190 ' + checkout_button.val().replace( '\u2192', '' ) );
	});

	// My account page error check
	if ( jQuery( '.avada_myaccount_user' ).length && jQuery( '.woocommerce-error' ).length && ! jQuery( '.avada-myaccount-nav' ).find( '.active' ).children().hasClass( 'address' ) ) {
		jQuery( '.avada-myaccount-nav' ).find( '.active' ).removeClass( 'active' );
		jQuery( '.avada-myaccount-nav' ).find( '.account' ).parent().addClass( 'active' );
	}

	var avada_myaccount_active = jQuery('.avada-myaccount-nav').find('.active a');

	if(avada_myaccount_active.hasClass('address') ) {
		jQuery('.avada-myaccount-data .edit_address_heading').fadeIn();
	} else {
		jQuery('.avada-myaccount-data h2:nth-of-type(1)').fadeIn();
	}

	if(avada_myaccount_active.hasClass('downloads') ) {
		jQuery('.avada-myaccount-data .digital-downloads').fadeIn();
	} else if(avada_myaccount_active.hasClass('orders') ) {
		jQuery('.avada-myaccount-data .my_account_orders').fadeIn();
	} else if(avada_myaccount_active.hasClass('address') ) {
		jQuery('.avada-myaccount-data .myaccount_address, .avada-myaccount-data .addresses').fadeIn();
	} else if(avada_myaccount_active ) {
		jQuery('.avada-myaccount-data .edit-account-form, .avada-myaccount-data .edit-account-heading').fadeIn();
		jQuery('.avada-myaccount-data h2:nth-of-type(1)').hide();
	}

	jQuery('body.rtl .avada-myaccount-data .my_account_orders .order-status').each( function() {
		jQuery( this ).css( 'text-align', 'right' );
	});

	jQuery('.woocommerce input').each(function() {
		if(!jQuery(this).has('#coupon_code')) {
			var name = jQuery(this).attr('id');
			jQuery(this).attr('placeholder', jQuery(this).parent().find('label[for='+name+']').text());
		}
	});


	if(jQuery('.woocommerce #reviews #comments .comment_container .comment-text').length ) {
		jQuery('.woocommerce #reviews #comments .comment_container').append('<div class="clear"></div>');
	}

	var $title_sep = js_local_vars.title_style_type.split( ' ' ),
		$title_sep_class_string = '';

	for ( var i = 0; i < $title_sep.length; i++ ) {
		$title_sep_class_string += ' sep-' + $title_sep[i];
	}

	if( jQuery('.woocommerce.single-product .related.products > h2').length ) {
		jQuery('.woocommerce.single-product .related.products > h2').addClass( 'title-heading-left'  );
		jQuery('.woocommerce.single-product .related.products > h2').wrap( '<div class="fusion-title title' + $title_sep_class_string + '"></div>' );
		jQuery('.woocommerce.single-product .related.products > .title').append( '<div class="title-sep-container"><div class="title-sep' + $title_sep_class_string + ' "></div></div>' );
	}

	if( jQuery('.woocommerce.single-product .upsells.products > h2').length ) {
		jQuery('.woocommerce.single-product .upsells.products > h2').addClass( 'title-heading-left' );
		jQuery('.woocommerce.single-product .upsells.products > h2').wrap( '<div class="fusion-title title' + $title_sep_class_string + '"></div>' );
		jQuery('.woocommerce.single-product .upsells.products > .title').append( '<div class="title-sep-container"><div class="title-sep' + $title_sep_class_string + ' "></div></div>' );
	}

	if(jQuery('body .sidebar').css('display') == "block") {
		calcTabsLayout('.woocommerce-tabs .tabs-horizontal');
	}

	jQuery('.sidebar .products,.fusion-footer-widget-area .products,#slidingbar-area .products').each(function() {
		jQuery(this).removeClass('products-4');
		jQuery(this).removeClass('products-3');
		jQuery(this).removeClass('products-2');
		jQuery(this).addClass('products-1');
	});

	jQuery('.products-6 li, .products-5 li, .products-4 li, .products-3 li, .products-3 li').removeClass('last');

	// Woocommerce nested products plugin support
	jQuery( '.subcategory-products' ).each( function() {
		jQuery( this ).addClass( 'products-' + js_local_vars.woocommerce_shop_page_columns );
	});

	jQuery('.woocommerce-tabs ul.tabs li a').unbind( 'click' );
	jQuery('.woocommerce-tabs > ul.tabs li a').click(function(){

		var tab = jQuery( this );
		var tabs_wrapper = tab.closest( '.woocommerce-tabs' );

		jQuery( 'ul.tabs li', tabs_wrapper ).removeClass( 'active' );
		jQuery( '> div.panel', tabs_wrapper ).hide();
		jQuery( 'div' + tab.attr( 'href' ), tabs_wrapper ).show();
		tab.parent().addClass( 'active' );

		return false;
	});


	jQuery('.woocommerce-checkout-nav a,.continue-checkout').click(function(e) {
		var $admin_bar_height = ( jQuery( '#wpadminbar' ).length ) ? jQuery( '#wpadminbar' ).height() : 0,
			$header_div_children = jQuery( '.fusion-header-wrapper').find( 'div' ),
			$sticky_header_height = 0;

		$header_div_children.each( function() {
			if ( jQuery( this ).css( 'position' ) == 'fixed' ) {
				$sticky_header_height = jQuery( this ).height();
			}
		});

		e.preventDefault();

		if( ! jQuery( '.woocommerce .avada-checkout' ).find( '.woocommerce-invalid' ).is( ':visible' ) ) {
			var data_name = $(this).attr('data-name');
			var name = data_name;
			if(data_name != '#order_review') {
				name = '.' + data_name;
			}

			jQuery('form.checkout .col-1, form.checkout .col-2, form.checkout #order_review_heading, form.checkout #order_review').hide();

			jQuery('form.checkout').find(name).fadeIn();
			if(name == '#order_review') {
				jQuery('form.checkout').find('#order_review_heading').fadeIn();
			}

			jQuery('.woocommerce-checkout-nav li').removeClass('active');
			jQuery('.woocommerce-checkout-nav').find('[data-name='+data_name+']').parent().addClass('active');

			if( jQuery( this ).hasClass( 'continue-checkout' ) && jQuery( window ).scrollTop() > 0 ) {
				jQuery('html, body').animate({scrollTop: jQuery( '.woocommerce-content-box.avada-checkout' ).offset().top - $admin_bar_height - $sticky_header_height }, 500);
			}
		}

		// set heights of select arrows correctly
		calc_select_arrow_dimensions();
	});

	// Ship to a different address toggle
	jQuery( 'input[name=ship_to_different_address]' ).change(
		function() {
			if ( jQuery ( this ).is( ':checked' ) ) {
				setTimeout( function() {
					// set heights of select arrows correctly
					calc_select_arrow_dimensions();
				}, 1 );
			}
		}
	);

	jQuery('.avada-myaccount-nav a').click(function(e) {
		e.preventDefault();

		jQuery('.avada-myaccount-data h2, .avada-myaccount-data .digital-downloads, .avada-myaccount-data .my_account_orders, .avada-myaccount-data .myaccount_address, .avada-myaccount-data .addresses, .avada-myaccount-data .edit-account-heading, .avada-myaccount-data .edit-account-form').hide();

		if(jQuery(this).hasClass('downloads') ) {
			jQuery('.avada-myaccount-data h2:nth-of-type(1), .avada-myaccount-data .digital-downloads').fadeIn();
		} else if(jQuery(this).hasClass('orders') ) {

			if( jQuery(this).parents('.avada-myaccount-nav').find('.downloads').length ) {
				heading = jQuery('.avada-myaccount-data h2:nth-of-type(2)');
			} else {
				heading = jQuery('.avada-myaccount-data h2:nth-of-type(1)');
			}

			heading.fadeIn();
			jQuery('.avada-myaccount-data .my_account_orders').fadeIn();
		} else if(jQuery(this).hasClass('address') ) {

			if( jQuery(this).parents('.avada-myaccount-nav').find('.downloads').length && jQuery(this).parents('.avada-myaccount-nav').find('.orders').length ) {
				heading = jQuery('.avada-myaccount-data h2:nth-of-type(3)');
			} else if( jQuery(this).parents('.avada-myaccount-nav').find('.downloads').length || jQuery(this).parents('.avada-myaccount-nav').find('.orders').length ) {
				heading = jQuery('.avada-myaccount-data h2:nth-of-type(2)');
			} else {
				heading = jQuery('.avada-myaccount-data h2:nth-of-type(1)');
			}

			heading.fadeIn();
			jQuery('.avada-myaccount-data .myaccount_address, .avada-myaccount-data .addresses').fadeIn();
		} else if(jQuery(this).hasClass('account') ) {
			jQuery('.avada-myaccount-data .edit-account-heading, .avada-myaccount-data .edit-account-form').fadeIn();
		}

		jQuery('.avada-myaccount-nav li').removeClass('active');
		jQuery(this).parent().addClass('active');
	});

	jQuery( '.add_to_cart_button' ).click(function(e) {
		var $add_to_cart_button = jQuery( this );

		$add_to_cart_button.closest( '.product' ).find( '.cart-loading' ).find( 'i' ).removeClass( 'fusion-icon-check-square-o' ).addClass( 'fusion-icon-spinner' );
		$add_to_cart_button.closest( '.product' ).find( '.cart-loading' ).fadeIn();
		setTimeout( function(){
			$add_to_cart_button.closest( '.product' ).find( '.product-images img' ).animate( {opacity: 0.75} );
			$add_to_cart_button.closest( '.product' ).find( '.cart-loading' ).find( 'i' ).hide().removeClass( 'fusion-icon-spinner' ).addClass( 'fusion-icon-check-square-o' ).fadeIn();

			setTimeout( function(){
				$add_to_cart_button.closest( '.product' ).find( '.cart-loading' ).fadeOut().closest( '.product' ).find( '.product-images img' ).animate( {opacity: 1} );
			}, 2000 );
		}, 2000 );
	});

	jQuery('li.product').mouseenter(function() {
		if(jQuery(this).find('.cart-loading').find('i').hasClass('fusion-icon-check-square-o')) {
			jQuery(this).find('.cart-loading').fadeIn();
		}
	}).mouseleave(function() {
		if(jQuery(this).find('.cart-loading').find('i').hasClass('fusion-icon-check-square-o')) {
			jQuery(this).find('.cart-loading').fadeOut();
		}
	});

    // Text area climit expandability
    jQuery( '.textarea-comment' ).each( function() {
		jQuery( this ).css( 'max-width', jQuery( '#content').width() );
    });

	if(Modernizr.mq('only screen and (max-width: 800px)')) {
		 jQuery('.fullwidth-faded').each(function() {
		 	var bkgd_img = jQuery(this).css('background-image');
		 	jQuery(this).parent().css('background-image', bkgd_img);
		 	jQuery(this).remove();
		 });
	}

	// Remove gravity IE specific class
	jQuery( '.gform_wrapper' ).each( function() {
		jQuery( this ).removeClass( 'gf_browser_ie' );
	});

}); // end document_ready_1

jQuery(window).load(function() {
    if(cssua.ua.mobile === undefined) {
	    // Change opacity of page title bar on scrolling
	    if(js_local_vars.page_title_fading == '1') {
		    if(js_local_vars.header_position == 'Left' || js_local_vars.header_position == 'Right') {
		    	jQuery('.fusion-page-title-wrapper').fusion_scroller({type: 'opacity', end_offset: '.fusion-page-title-captions > h1'});
		    } else {
			    jQuery('.fusion-page-title-wrapper').fusion_scroller({type: 'opacity', offset: 100});
			}
		}

		// Fading and blur effect for new fade="" param on full width boxes
	    jQuery('.fullwidth-faded').fusion_scroller({type: 'fading_blur'});
	}
});

/*
 * Dynamic javascript File Port
 */

function insertParam(url, parameterName, parameterValue, atStart){
	replaceDuplicates = true;

	if(url.indexOf('#') > 0){
		var cl = url.indexOf('#');
		urlhash = url.substring(url.indexOf('#'),url.length);
	} else {
		urlhash = '';
		var cl = url.length;
	}
	sourceUrl = url.substring(0,cl);

	var urlParts = sourceUrl.split("?");
	var newQueryString = "";

	if (urlParts.length > 1)
	{
		var parameters = urlParts[1].split("&");
		for (var i=0; (i < parameters.length); i++)
		{
			var parameterParts = parameters[i].split("=");
			if (!(replaceDuplicates && parameterParts[0] == parameterName))
			{
				if (newQueryString === "") {
					newQueryString = "?" + parameterParts[0] + "=" + (parameterParts[1]?parameterParts[1]:'');
				}
				else {
					newQueryString += "&";
					newQueryString += parameterParts[0] + "=" + (parameterParts[1]?parameterParts[1]:'');
				}
			}
		}
	}
	if (newQueryString === "")
		newQueryString = "?";

	if(atStart){
		newQueryString = '?'+ parameterName + "=" + parameterValue + (newQueryString.length>1?'&'+newQueryString.substring(1):'');
	} else {
		if (newQueryString !== "" && newQueryString != '?')
			newQueryString += "&";
		newQueryString += parameterName + "=" + (parameterValue?parameterValue:'');
	}
	return urlParts[0] + newQueryString + urlhash;
}

function ytVidId(url) {
	var p = /^(?:https?:)?(\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
	return (url.match(p)) ? RegExp.$1 : false;
	//return (url.match(p)) ? true : false;
}

jQuery(document).ready(function() {
	var iframes = jQuery('iframe');
	jQuery.each(iframes, function(i, v) {
		var src = jQuery(this).attr('src');
		if(src) {
			if(!Number(js_local_vars.status_vimeo) && src.indexOf('vimeo') >= 1) {
				jQuery(this).attr('id', 'player_'+(i+1));
				var new_src = insertParam(src, 'api', '1', false);
				var new_src_2 = insertParam(new_src, 'player_id', 'player_'+(i+1), false);

				jQuery(this).attr('src', new_src_2);
			}

			if(!Number(js_local_vars.status_yt) && ytVidId(src)) {
				jQuery(this).attr('id', 'player_'+(i+1));
				jQuery(this).parent().wrap('<span class="play3" />');

				var new_src = insertParam(src, 'enablejsapi', '1', false);

				jQuery(this).attr('src', new_src);

				window.yt_vid_exists = true;
			}
		}
	});

	jQuery('.fusion-fullwidth.video-background').each(function() {
		if(jQuery(this).find('> div').attr('data-youtube-video-id')) {
			window.yt_vid_exists = true;
		}
	});

	if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
		var tag = document.createElement('script');
		tag.src = window.location.protocol + "//www.youtube.com/iframe_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	}
});


// Define YT_ready function.
var YT_ready = (function() {
	var onReady_funcs = [], api_isReady = false;
	/* @param func function	 Function to execute on ready
	 * @param func Boolean	  If true, all qeued functions are executed
	 * @param b_before Boolean  If true, the func will added to the first
	 position in the queue*/
	return function(func, b_before) {
		if (func === true) {
			api_isReady = true;
			while (onReady_funcs.length) {
				// Removes the first func from the array, and execute func
				onReady_funcs.shift()();
			}
		} else if (typeof func == "function") {
			if (api_isReady) func();
			else onReady_funcs[b_before?"unshift":"push"](func);
		}
	};
})();

// This function will be called when the API is fully loaded
function onYouTubePlayerAPIReady() {YT_ready(true);}

// Control header-v1 and sticky on tfs parallax pages

// Setting some global vars. Those are also needed for the correct header resizing on none parallax slider pages
var orig_logo_height = jQuery('.header-wrapper' ).find( '.logo' ).height();
var orig_logo_container_margin_top = String( jQuery('.header-wrapper' ).find( '.logo' ).data( 'margin-top' ) );
var orig_logo_container_margin_bottom = String( jQuery('.header-wrapper' ).find( '.logo' ).data( 'margin-bottom' ) );
var orig_menu_height = jQuery( '.header-wrapper .fusion-navbar-nav > li > a' ).outerHeight();
if( jQuery( '#wrapper' ).length >= 1 ) {
	var wrapper_position = jQuery( '#wrapper' ).position().left;
} else {
	var wrapper_position;
}
var is_parallax_tfs_slider = false;

if ( ! orig_logo_container_margin_top ) {
	orig_logo_container_margin_top = '0px';
}

if ( ! orig_logo_container_margin_bottom ) {
	orig_logo_container_margin_bottom = '0px';
}

jQuery(window).load(function() {
	var headerHeight = jQuery( '.fusion-header-wrapper' ).height();

	if(jQuery('.sidebar').is(':visible')) {
		jQuery('.post-content .fusion-portfolio').each(function() {
			var columns = jQuery(this).data('columns');
			jQuery(this).addClass('fusion-portfolio-'+columns+'-sidebar');
		});
	}

	// Portfolio isotope loading
	if ( jQuery().isotope && jQuery( '.fusion-portfolio .fusion-portfolio-wrapper' ).length ) {
		jQuery( '.fusion-portfolio .fusion-portfolio-wrapper' ).each( function() {
			jQuery( '.fusion-load-more-button' ).fadeIn();

			// Resize the placeholder images correctly in "fixed" picture size carousels
			if ( jQuery( this ).data( 'picturesize' ) == 'fixed' ) {
				jQuery( this ).find( '.fusion-placeholder-image' ).each( function() {
					jQuery( this ).css(	{
						'height': jQuery( this ).parents( '.fusion-portfolio-post' ).siblings().first().find( 'img' ).height(),
						'width': jQuery( this ).parents( '.fusion-portfolio-post' ).siblings().first().find( 'img' ).width()
					});

				});
			}

			// Check if filters are displayed
			if ( jQuery( '.fusion-filters' ).length ) {

				// Set needed variables
				var $filters = jQuery( '.fusion-filters' ).find( '.fusion-filter' ),
					$filter_active_element = jQuery( '.fusion-filters' ).find( '.fusion-active' ).children( 'a' ),
					$posts = jQuery( this ).find( '.fusion-portfolio-post' );

				// "All" filter is active
				if ( $filter_active_element.length ) {
					var $filter_active = $filter_active_element.attr( 'data-filter' ).substr( 1 );
				// "All" filter is deactivated - get the first category of the first post in the set and activate that filter
				} else {
					var $first_item_classes = jQuery( $posts ).first().attr( 'class' ).split( ' ' ),
						$filter_active = $first_item_classes[1];

					$filters.each( function() {
						if ( jQuery ( this ).find( 'a' ).data( 'filter' ) == '.' + $filter_active ) {
							jQuery( this ).addClass( 'fusion-active' );
						}
					});
				}

				// Loop through filters
				if ( $filters ) {
					$filters.each( function() {
						var $filter = jQuery( this ),
							$filter_name = $filter.children( 'a' ).data( 'filter' );

						// Loop through initial post set
						if ( $posts ) {
							// If "All" filter is deactivated, hide posts for later check for active filter
							if ( $filter_active.length ) {
								$posts.hide();
							}

							jQuery( '.fusion-filters' ).show();

							$posts.each( function() {
								var $post = jQuery( this ),
									$post_gallery_name = $post.find( '.fusion-rollover-gallery' ).data( 'rel' );

								// If a post belongs to an invisible filter, fade filter in
								if ( $post.hasClass( $filter_name.substr( 1 ) ) ) {
									if ( $filter.hasClass( 'fusion-hidden' ) ) {
										$filter.removeClass( 'fusion-hidden' );
									}
								}

								// If "All" filter is deactivated, only show the items of the first filter (which is auto activated)
								if ( $filter_active.length && $post.hasClass( $filter_active ) ) {
									$post.show();

									// Set the lightbox gallery
									if ( $post_gallery_name ) {
										$post.find( '.fusion-rollover-gallery' ).attr( 'data-rel', $post_gallery_name.replace( 'gallery', $filter_active ) );
									}
								}
							});
						}
					});
				}

				if ( $filter_active.length ) {
					// Relayout the posts according to filter selection
					jQuery( this ).isotope( { filter: '.' + $filter_active } );

					// Create new lightbox instance for the new gallery
					$il_instances.push( jQuery( '[data-rel="iLightbox[' + $filter_active + ']"], [rel="iLightbox[' + $filter_active + ']"]' ).iLightBox( $avada_lightbox.prepare_options( 'iLightbox[' + $filter_active + ']' ) ) );

					// Refresh the lightbox
					$avada_lightbox.refresh_lightbox();

					// Set active filter to lightbox created
					$filter_active_element.data( 'lightbox', 'created' );
				}
			}

			// Refresh the scrollspy script for one page layouts
			jQuery( '[data-spy="scroll"]' ).each(function () {
				var $spy = jQuery( this ).scrollspy( 'refresh' );
			});

			// Initialize isotope depending on the portfolio layout
		    if ( jQuery( this ).parent().hasClass( 'fusion-portfolio-one' ) ) {
				window.$portfolio_isotope = jQuery( this );
				window.$portfolio_isotope.isotope({
					// Isotope options
					itemSelector: '.fusion-portfolio-post',
					layoutMode: 'vertical',
					transformsEnabled: false,
					isOriginLeft: jQuery( '.rtl' ).length ? false : true
				});
			} else {
				window.$portfolio_isotope = jQuery( this );
				window.$portfolio_isotope.isotope({
					// Isotope options
					itemSelector: '.fusion-portfolio-post',
					resizable: true,
					layoutMode: js_local_vars.isotope_type,
					transformsEnabled: false,
					isOriginLeft: jQuery( '.rtl' ).length ? false : true
				});
			}

			// Fade in placeholder images
			var $placeholder_images = jQuery( this ).find( '.fusion-portfolio-post .fusion-placeholder-image' );
			$placeholder_images.each( function() {
				jQuery( this ).parents( '.fusion-portfolio-content-wrapper, .fusion-image-wrapper' ).animate({ opacity: 1 });
			});

			// Fade in placeholder images
			var $videos = jQuery( this ).find( '.fusion-portfolio-post .fusion-video' );
			$videos.each( function() {
				jQuery( this ).animate({ opacity: 1 });
			});

			// Portfolio Images Loaded Check
			window.$portfolio_images_index = 0;

			jQuery( this ).imagesLoaded().progress( function( $instance, $image ) {
				if( jQuery( $image.img ).parents( '.fusion-portfolio-content-wrapper' ).length >= 1 ) {
					jQuery( $image.img, $placeholder_images ).parents( '.fusion-portfolio-content-wrapper' ).delay( 100 * window.$portfolio_images_index ).animate({
						opacity: 1
					});
				} else {
					jQuery( $image.img, $placeholder_images ).parents( '.fusion-image-wrapper' ).delay( 100 * window.$portfolio_images_index ).animate({
						opacity: 1
					});
				}

				window.$portfolio_images_index++;
			});
		});
	}

	if(jQuery().flexslider) {
		var avada_ytplayer;

		if(!Number(js_local_vars.status_vimeo)) {
			function ready(player_id) {
				var froogaloop = $f(player_id);

				var slide = jQuery('#' + player_id).parents('li');

				froogaloop.addEvent('play', function (data) {
					jQuery('#' + player_id).parents('li').parent().parent().flexslider("pause");
				});

				froogaloop.addEvent('pause', function (data) {
					if(jQuery(slide).attr('data-loop') == 'yes') {
						jQuery('#' + player_id).parents('li').parent().parent().flexslider("pause");
					} else {
						jQuery('#' + player_id).parents('li').parent().parent().flexslider("play");
					}
				});
			}

			var vimeoPlayers = jQuery('.flexslider').find('iframe'), player;

			jQuery('.flexslider').find('iframe').each(function () {
				var id = jQuery(this).attr('id');

				if(id) {
					$f(id).addEvent('ready', ready);
				}
			});

			function addEvent(element, eventName, callback) {
				if (element.addEventListener) {
					element.addEventListener(eventName, callback, false);
				} else {
					element.attachEvent(eventName, callback, false);
				}
			}
		}

		jQuery('.full-video, .video-shortcode, .wooslider .slide-content').not('#bbpress-forums full-video, #bbpress-forums .video-shortcode, #bbpress-forums .wooslider .slide-content').fitVids();
		jQuery('#bbpress-forums').fitVids();

		jQuery('.tfs-slider').each(function() {
			var this_tfslider = this;

			var first_slide = jQuery(this_tfslider).find('li').get(0);

			if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
				jQuery(this_tfslider).data('parallax', 0);
				jQuery(this_tfslider).data('full_screen', 0);
			}

			if(cssua.ua.tablet_pc) {
				jQuery(this_tfslider).data('parallax', 0);
			}

			if(cssua.ua.mobile || Modernizr.mq('only screen and (max-width: 1000px)')) {
				jQuery(this_tfslider).data('parallax', 0);
			}

			wpadminbarHeight = 0;
			if(jQuery('#wpadminbar').length >= 1) {
				var wpadminbarHeight = jQuery('#wpadminbar').height();
			}

			if(jQuery(this_tfslider).parents('#sliders-container').length >= 1 && jQuery(this_tfslider).data('parallax') === 1) {
				jQuery('.fusion-header').addClass('fusion-header-backface');
			}

			if(jQuery(this_tfslider).data('full_screen') == 1) {
				var sliderHeight = jQuery(window).height();

				if(jQuery(this_tfslider).parents('#sliders-container').next().hasClass('fusion-header-wrapper')) {
					sliderHeight = sliderHeight + (headerHeight - wpadminbarHeight);
				}

				if(jQuery(this_tfslider).data('parallax') === 0) {
					sliderHeight = jQuery(window).height() - (headerHeight + wpadminbarHeight);
				}

				if(Modernizr.mq('only screen and (max-width: 1000px)')) {
					var sliderHeight = jQuery(window).height() - (headerHeight + wpadminbarHeight);
				}

				jQuery(this_tfslider).find('video').each(function() {
					var aspect_ratio = jQuery(this).width() / jQuery(this).height();
					var arc_sliderWidth = aspect_ratio * sliderHeight;
					var arc_sliderLeft = '-' + ((arc_sliderWidth - jQuery(this_tfslider).width()) / 2) + 'px';
					var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
					if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
						compare_width = jQuery(this_tfslider).width();
					}
					if(compare_width > arc_sliderWidth) {
						arc_sliderWidth = '100%';
						arc_sliderLeft = 0;
					}
					jQuery(this).width(arc_sliderWidth);
					jQuery(this).css('left', arc_sliderLeft);
				});
			} else {
				var sliderWidth = jQuery(this_tfslider).data('slider_width');

				if(sliderWidth.indexOf('%') != -1) {
					sliderWidth = jQuery(first_slide).find('.background-image').data('imgwidth');
					if( ! sliderWidth && ! cssua.ua.mobile ) {
						sliderWidth = jQuery(first_slide).find('video').width();
					}

					if( ! sliderWidth ) {
						sliderWidth = 940;
					}

					jQuery(this_tfslider).data('first_slide_width', sliderWidth);

					if(sliderWidth < jQuery(this_tfslider).data('slider_width')) {
						sliderWidth = jQuery(this_tfslider).data('slider_width');
					}

					var percentage_width = true;
				} else {
					sliderWidth = parseInt(jQuery(this_tfslider).data('slider_width'));
				}

				var sliderHeight = parseInt(jQuery(this_tfslider).data('slider_height'));
				var aspect_ratio = sliderHeight / sliderWidth;

				if(aspect_ratio < 0.5) {
					aspect_ratio = 0.5;
				}

				var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
				if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
					compare_width = jQuery(this_tfslider).width();
				}
				var sliderHeight = aspect_ratio * compare_width;

				if(sliderHeight > parseInt(jQuery(this_tfslider).data('slider_height'))) {
					sliderHeight = parseInt(jQuery(this_tfslider).data('slider_height'));
				}

				if(sliderHeight < 200) {
					sliderHeight = 300;
				}
			}

			if(jQuery(this_tfslider).data('full_screen') == 1) {
				jQuery(this_tfslider).css('max-width', '100%');
				jQuery(this_tfslider).find('.slides, .background').css('width', '100%');
			}

			if((js_local_vars.header_position == 'Left' || js_local_vars.header_position == 'Right') && ! jQuery(this_tfslider).hasClass('fixed-width-slider') && jQuery(this_tfslider).data('parallax') == 1) {
				jQuery(this_tfslider).css('max-width', jQuery('#wrapper').width());
				if(jQuery('body').hasClass('side-header-left')) {
					jQuery(this_tfslider).css('left', jQuery('#side-header').width() + 1);
				} else if(jQuery('body').hasClass('side-header-right')) {
					jQuery(this_tfslider).css('right', jQuery('#side-header').width() + 1);
				}
			}

			jQuery(this_tfslider).parents('.fusion-slider-container').css('height', sliderHeight);
			jQuery(this_tfslider).css('height', sliderHeight);
			jQuery(this_tfslider).find('.background, .mobile_video_image').css('height', sliderHeight);

			if(jQuery('.layout-boxed-mode').length >= 1) {
				var boxed_mode_width = jQuery('.layout-boxed-mode #wrapper').width();
				jQuery(this_tfslider).css('width', boxed_mode_width);
				jQuery(this_tfslider).css('margin-left', 'auto');
				jQuery(this_tfslider).css('margin-right', 'auto');

				if(jQuery(this_tfslider).data('parallax') == 1 && ! Modernizr.mq('only screen and (max-width: 1000px)')) {
					jQuery(this_tfslider).css('left', '50%');
					if( js_local_vars.header_position == 'Left' || js_local_vars.header_position == 'Right' ) {
						boxed_mode_width = jQuery('.layout-boxed-mode #wrapper').width() - jQuery('.layout-boxed-mode #side-header').width();
						if( js_local_vars.header_position == 'Right' ) {
							boxed_mode_width = jQuery('.layout-boxed-mode #wrapper').width() + jQuery('.layout-boxed-mode #side-header').width();
						}
						jQuery(this_tfslider).css('margin-left', '-' + Math.floor( boxed_mode_width / 2 ) + 'px');
					} else {
						jQuery(this_tfslider).css('margin-left', '-' + (boxed_mode_width / 2) + 'px');
					}
				}
				jQuery(this_tfslider).find('.slides, .background').css('width', '100%');
			}

			if(cssua.ua.mobile) {
				jQuery(this_tfslider).find('.fusion-button').each(function() {
					jQuery(this).removeClass('button-xlarge button-large button-medium');
					jQuery(this).addClass('button-small');
				});
				jQuery(this_tfslider).find('li').each(function() {
					jQuery(this).attr('data-autoplay', 'no');
					jQuery(this).data('autoplay', 'no');
				});
			}

			jQuery(this_tfslider).find('a.button').each(function() {
				jQuery(this).data('old', jQuery(this).attr('class'));
			});

			if(Modernizr.mq('only screen and (max-width: 800px)')) {
				jQuery(this_tfslider).find('.fusion-button').each(function() {
					jQuery(this).data('old', jQuery(this).attr('class'));
					jQuery(this).removeClass('button-xlarge button-large button-medium');
					jQuery(this).addClass('button-small');
				});
			} else {
				jQuery(this_tfslider).find('a.button').each(function() {
					jQuery(this).attr('class', jQuery(this).data('old'));
				});
			}

			if(jQuery(this_tfslider).data('parallax') == 1) {
				jQuery(window).scroll(function () {
					if(jQuery(window).scrollTop() >= jQuery(this_tfslider).parents('#sliders-container').position().top + jQuery(this_tfslider).parents('#sliders-container').height()) {
						jQuery(this_tfslider).css('display', 'none');
					} else {
						jQuery(this_tfslider).css('display', 'block');
					}
				});
			}

			var resize_width = jQuery(window).width();
			var resize_height = jQuery(window).height();

			jQuery(window).on('resize', function() { // start_tfslider_resize
				if( jQuery(window).width() != resize_width || jQuery(window).height() != resize_height ) {
					var wpadminbarHeight = 0;

					if(jQuery('#wpadminbar').length >= 1) {
						var wpadminbarHeight = jQuery('#wpadminbar').height();
					}


					if(jQuery(this_tfslider).data('full_screen') == 1) {
						var sliderHeight = jQuery(window).height();

						if(jQuery(this_tfslider).parents('#sliders-container').next().hasClass('fusion-header-wrapper')) {
							sliderHeight = sliderHeight + (headerHeight - wpadminbarHeight);
						}

						if(jQuery(this_tfslider).data('parallax') === 0) {
							sliderHeight = jQuery(window).height() - (headerHeight + wpadminbarHeight);
						}

						if(Modernizr.mq('only screen and (max-width: 800px)')) {
							var sliderHeight = jQuery(window).height() - (headerHeight + wpadminbarHeight);
						}

						jQuery(this_tfslider).find('video').each(function() {
							var aspect_ratio = jQuery(this).width() / jQuery(this).height();
							var arc_sliderWidth = aspect_ratio * jQuery(window).height();
							var arc_sliderLeft = '-' + ((arc_sliderWidth - jQuery(this_tfslider).width()) / 2) + 'px';
							var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
							if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
								compare_width = jQuery(this_tfslider).width();
							}
							if(compare_width > arc_sliderWidth) {
								arc_sliderWidth = '100%';
								arc_sliderLeft = 0;
							}
							jQuery(this).width(arc_sliderWidth);
							jQuery(this).css('left', arc_sliderLeft);
						});
					} else {
						var sliderWidth = jQuery(this_tfslider).data('slider_width');

						if(sliderWidth.indexOf('%') != -1) {
							sliderWidth = jQuery(this_tfslider).data('first_slide_width');

							if( sliderWidth < jQuery(this_tfslider).data('slider_width') ) {
								sliderWidth = jQuery(this_tfslider).data('slider_width');
							}

							var percentage_width = true;
						} else {
							sliderWidth = parseInt(jQuery(this_tfslider).data('slider_width'));
						}

						var sliderHeight = parseInt(jQuery(this_tfslider).data('slider_height'));
						var aspect_ratio = sliderHeight / sliderWidth;

						if(aspect_ratio < 0.5) {
							aspect_ratio = 0.5;
						}

						var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
						if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
							compare_width = jQuery(this_tfslider).width();
						}
						var sliderHeight = aspect_ratio * compare_width;

						if(sliderHeight > parseInt(jQuery(this_tfslider).data('slider_height'))) {
							sliderHeight = parseInt(jQuery(this_tfslider).data('slider_height'));
						}

						if(sliderHeight < 300) {
							sliderHeight = 300;
						}

						jQuery(this_tfslider).find('video').each(function() {
							var aspect_ratio = jQuery(this).width() / jQuery(this).height();
							var arc_sliderWidth = aspect_ratio * sliderHeight;

							if(arc_sliderWidth < sliderWidth && !jQuery(this_tfslider).hasClass('full-width-slider')) {
								arc_sliderWidth = sliderWidth;
							}

							var arc_sliderLeft = '-' + ((arc_sliderWidth - jQuery(this_tfslider).width()) / 2) + 'px';
							var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
							if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
								compare_width = jQuery(this_tfslider).width();
							}
							if(compare_width > arc_sliderWidth && percentage_width === true && jQuery(this_tfslider).data('full_screen') != 1) {
								arc_sliderWidth = '100%';
								arc_sliderLeft = 0;
							}
							jQuery(this).width(arc_sliderWidth);
							jQuery(this).css('left', arc_sliderLeft);
						});

						if(Modernizr.mq('only screen and (max-width: 800px)')) {
							jQuery(this_tfslider).find('.fusion-button').each(function() {
								jQuery(this).removeClass('button-xlarge button-large button-medium');
								jQuery(this).addClass('button-small');
							});
						} else {
							jQuery(this_tfslider).find('.fusion-button').each(function() {
								jQuery(this).attr('class', jQuery(this).data('old'));
							});
						}
					}

					if(jQuery(this_tfslider).data('full_screen') == 1 && jQuery(this_tfslider).data('animation') == "fade" ) {
						jQuery(this_tfslider).css('max-width', '100%');
						jQuery(this_tfslider).find('.slides, .background').css('width', '100%');
					}

					if((js_local_vars.header_position == 'Left' || js_local_vars.header_position == 'Right') && ! jQuery(this_tfslider).hasClass('fixed-width-slider') && jQuery(this_tfslider).data('parallax') == 1) {
						jQuery(this_tfslider).css('max-width', jQuery('#wrapper').width());
						if(jQuery('body').hasClass('side-header-left')) {
							jQuery(this_tfslider).css('left', jQuery('#side-header').width() + 1);
						} else if(jQuery('body').hasClass('side-header-right')) {
							jQuery(this_tfslider).css('right', jQuery('#side-header').width() + 1);
						}
					}

					jQuery(this_tfslider).parents('.fusion-slider-container').css('height', sliderHeight);
					jQuery(this_tfslider).parents('.fusion-slider-container').css('max-height', sliderHeight );
					jQuery(this_tfslider).css('height', sliderHeight);
					jQuery(this_tfslider).find('.background, .mobile_video_image').css('height', sliderHeight);

					if(jQuery('.layout-boxed-mode').length >= 1 && jQuery(this_tfslider).parents('.post-content').length === 0) {
						var boxed_mode_width = jQuery('.layout-boxed-mode #wrapper').width();
						jQuery(this_tfslider).css('width', boxed_mode_width);
						jQuery(this_tfslider).css('margin-left', 'auto');
						jQuery(this_tfslider).css('margin-right', 'auto');

						if(jQuery(this_tfslider).data('parallax') == 1 && ! Modernizr.mq('only screen and (max-width: 1000px)')) {
							jQuery(this_tfslider).css('left', '50%');
							if( js_local_vars.header_position == 'Left' || js_local_vars.header_position == 'Right' ) {
								boxed_mode_width = jQuery('.layout-boxed-mode #wrapper').width() - jQuery('.layout-boxed-mode #side-header').width();
								if( js_local_vars.header_position == 'Right' ) {
									boxed_mode_width = jQuery('.layout-boxed-mode #wrapper').width() + jQuery('.layout-boxed-mode #side-header').width();
								}
								jQuery(this_tfslider).css('margin-left', '-' + Math.floor( boxed_mode_width / 2 ) + 'px');
							} else {
								jQuery(this_tfslider).css('margin-left', '-' + (boxed_mode_width / 2) + 'px');
							}
						}

						if(jQuery(this_tfslider).data('animation') != 'slide') {
							jQuery(this_tfslider).find('.slides').css('width', '100%');
						}
						jQuery(this_tfslider).find('.background').css('width', '100%');
					}

					if(jQuery(this_tfslider).data('parallax') == 1 && ! Modernizr.mq('only screen and (max-width: ' + ( 1000 + parseInt( js_local_vars.side_header_width ) ) + 'px)')) {
						jQuery(this_tfslider).css('position', 'fixed');
						if( jQuery( '.fusion-header-wrapper' ).css( 'position' ) != 'absolute' ) {
							jQuery('.fusion-header-wrapper').css('position', 'relative');
							jQuery(this_tfslider).parents('.fusion-slider-container').css('margin-top', '-' + headerHeight + 'px');
						}
						jQuery('#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar').css('position', 'relative');
						jQuery('#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar').css('z-index', '3');
						jQuery('.fusion-header-wrapper').css('z-index', '5');
						jQuery('.fusion-header-wrapper').css('height', headerHeight);

						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-webkit-transform', 'translate(0, ' + (headerHeight / 2) + 'px)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-ms-transform', 'translate(0, ' + (headerHeight / 2) + 'px)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-o-transform', 'translate(0, ' + (headerHeight / 2) + 'px)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-moz-transform', 'translate(0, ' + (headerHeight / 2) + 'px)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('transform', 'translate(0, ' + (headerHeight / 2) + 'px)');

						if(jQuery(this_tfslider).hasClass('fixed-width-slider')) {
							if( js_local_vars.header_position == 'Left' || js_local_vars.header_position == 'Right' ) {
								if( jQuery(this_tfslider).parents( '#sliders-container' ).length ) {
									var wrapping_container = jQuery( '#sliders-container' );
								} else {
									var wrapping_container = jQuery( '#main' );
								}

								if( wrapping_container.width() < parseFloat( jQuery(this_tfslider).parent().css( 'max-width' ) ) ) {
									jQuery(this_tfslider).css( 'max-width', wrapping_container.width() );
								} else {
									jQuery(this_tfslider).css( 'max-width', jQuery(this_tfslider).parent().css( 'max-width' ) );
								}

								if( wrapping_container.width() < parseFloat( jQuery(this_tfslider).parent().css( 'max-width' ) ) ) {
									jQuery(this_tfslider).css( 'max-width', wrapping_container.width() );
								} else {
									jQuery(this_tfslider).css( 'max-width', jQuery(this_tfslider).parent().css( 'max-width' ) );
								}

								if( js_local_vars.header_position == 'Left' ) {
									var fixed_width_center = '-' + ((jQuery(this_tfslider).width() - jQuery( '#side-header' ).width() ) / 2) + 'px';
								} else {
									var fixed_width_center = '-' + ((jQuery(this_tfslider).width() + jQuery( '#side-header' ).width() ) / 2) + 'px';
								}

								if( ( -1 ) * fixed_width_center > jQuery(this_tfslider).width() ) {
									fixed_width_center = ( -1 ) * jQuery(this_tfslider).width();
								}
							} else {
								var fixed_width_center = '-' + (jQuery(this_tfslider).width() / 2) + 'px';
							}
							jQuery(this_tfslider).css('left', '50%');
							jQuery(this_tfslider).css('margin-left', fixed_width_center);
						}

						jQuery(this_tfslider).find('.flex-control-nav').css('bottom', (headerHeight / 2));
					} else if(jQuery(this_tfslider).data('parallax') == 1 && Modernizr.mq('only screen and (max-width: ' + ( 1000 + parseInt( js_local_vars.side_header_width ) ) + 'px)')) {
						jQuery(this_tfslider).css('position', 'relative');
						jQuery(this_tfslider).css('left', '0');
						jQuery(this_tfslider).css('margin-left', '0');
						if( jQuery( '.fusion-header-wrapper' ).css( 'position' ) != 'absolute' ) {
							jQuery('.fusion-header-wrapper').css('position', 'relative');
						}
						jQuery('#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar').css('position', 'relative');
						jQuery('#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar').css('z-index', '3');
						jQuery('.fusion-header-wrapper').css('z-index', '5');
						jQuery('.fusion-header-wrapper').css('height', 'auto');
						jQuery(this_tfslider).parents('.fusion-slider-container').css('margin-top', '');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-webkit-transform', 'translate(0, 0)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-ms-transform', 'translate(0, 0)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-o-transform', 'translate(0, 0)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-moz-transform', 'translate(0, 0)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('transform', 'translate(0, 0)');

						jQuery(this_tfslider).find('.flex-control-nav').css('bottom', 0);
					}

					if(Modernizr.mq('only screen and (max-width: 640px)')) {
						jQuery(this_tfslider).parents('.fusion-slider-container').css('height', sliderHeight);
						jQuery(this_tfslider).css('height', sliderHeight);
						jQuery(this_tfslider).find('.background, .mobile_video_image').css('height', sliderHeight);

						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							var contentPadding = '0px';

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					} else if(Modernizr.mq('only screen and (max-width: 1000px)')) {
						jQuery(this_tfslider).parents('.fusion-slider-container').css('height', sliderHeight);
						jQuery(this_tfslider).css('height', sliderHeight);
						jQuery(this_tfslider).find('.background, .mobile_video_image').css('height', sliderHeight);

						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							var contentPadding = '0px';

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					} else {
						jQuery(this_tfslider).parents('.fusion-slider-container').css('height', sliderHeight);
						jQuery(this_tfslider).css('height', sliderHeight);
						jQuery(this_tfslider).find('.background, .mobile_video_image').css('height', sliderHeight);

						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							jQuery(this).css('-webkit-transform', '');
							jQuery(this).css('-ms-transform', '');
							jQuery(this).css('-o-transform', '');
							jQuery(this).css('-moz-transform', '');
							jQuery(this).css('transform', '');

							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							if(jQuery(this_tfslider).data('parallax') == '1' && jQuery(this_tfslider).parents('.post-content').length === 0) {
								var contentPadding = headerHeight / 2;
							}

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					}

					if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
						jQuery(this_tfslider).parents('.fusion-slider-container').css('height', 'auto');
						jQuery(this_tfslider).css('height', 'auto');
						jQuery(this_tfslider).parents('.fusion-slider-container').css('max-height', 'none');
						jQuery(this_tfslider).find('.mobile_video_image').each(function() {
							var img_url = jQuery('.mobile_video_image').css('background-image').replace('url(', '').replace(')', '');
							if(img_url) {
								var preview_image = new Image();
								preview_image.name = img_url;
								preview_image.src = img_url;
								preview_image.onload = function() {
									var ar = this.height / this.width;
									var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
									if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
										compare_width = jQuery(this_tfslider).width();
									}
									var mobile_preview_height = ar * compare_width;
									if(mobile_preview_height < sliderHeight) {
										jQuery(this_tfslider).find('.mobile_video_image').css('height', mobile_preview_height);
										jQuery(this_tfslider).css('height', mobile_preview_height);
									}
								};
							}
						});
					}

					if(Modernizr.mq('only screen and (max-width: 1000px)')) {
							jQuery('.fusion-header-wrapper').css('height', '' );
					}

					resize_width = jQuery(window).width();
					resize_height = jQuery(window).height();
				}
			}); // // end_tfslider_resize

			if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
				jQuery(this_tfslider).css('max-width', '100%');
				if(jQuery(this_tfslider).data('animation') != 'slide') {
					jQuery(this_tfslider).find('.slides').css('max-width', '100%');
				}
			}

			jQuery(this_tfslider).find('video').each(function() {
				if( typeof jQuery(this)[0].pause === "function" ) {
					jQuery(this)[0].pause();
				}
			});

			jQuery(this_tfslider).flexslider({
				animation: jQuery(this_tfslider).data('animation'),
				slideshow: jQuery(this_tfslider).data('autoplay'),
				slideshowSpeed: jQuery(this_tfslider).data('slideshow_speed'),
				animationSpeed: jQuery(this_tfslider).data('animation_speed'),
				controlNav: Boolean(Number(jQuery(this_tfslider).data('pagination_circles'))),
				directionNav: Boolean(Number(jQuery(this_tfslider).data('nav_arrows'))),
				animationLoop: Boolean(Number(jQuery(this_tfslider).data('loop'))),
				smoothHeight: true,
				pauseOnHover: false,
				useCSS: true,
				video: true,
				touch: true,
				prevText: '&#xe61e;',
				nextText: '&#xe620;',
				start: function(slider) {
					jQuery( this_tfslider ).parent().find( '.fusion-slider-loading' ).remove();

					wpadminbarHeight = 0;
					if(jQuery('#wpadminbar').length >= 1) {
						var wpadminbarHeight = jQuery('#wpadminbar').height();
					}

					jQuery(slider.slides.eq(slider.currentSlide)).find('.slide-content-container').show();

					if(jQuery(this_tfslider).data('full_screen') == 1) {
						var sliderHeight = jQuery(window).height();

						if(jQuery(this_tfslider).parents('#sliders-container').next().hasClass('fusion-header-wrapper')) {
							sliderHeight = sliderHeight + (headerHeight - wpadminbarHeight);
						}

						if(jQuery(this_tfslider).data('parallax') === 0) {
							sliderHeight = jQuery(window).height() - (headerHeight + wpadminbarHeight);
						}

 						if(Modernizr.mq('only screen and (max-width: 1000px)')) {
							var sliderHeight = jQuery(window).height() - (headerHeight + wpadminbarHeight);
						}

						jQuery(this_tfslider).find('video').each(function() {
							var aspect_ratio = jQuery(this).width() / jQuery(this).height();
							var arc_sliderWidth = aspect_ratio * sliderHeight;
							var arc_sliderLeft = '-' + ((arc_sliderWidth - jQuery(this_tfslider).width()) / 2) + 'px';
							var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
							if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
								compare_width = jQuery(this_tfslider).width();
							}
							if(compare_width > arc_sliderWidth) {
								arc_sliderWidth = '100%';
								arc_sliderLeft = 0;
							}
							jQuery(this).width(arc_sliderWidth);
							jQuery(this).css('left', arc_sliderLeft);
						});
					} else {
						var sliderWidth = jQuery(this_tfslider).data('slider_width');

						if(sliderWidth.indexOf('%') != -1) {
							sliderWidth = jQuery(first_slide).find('.background-image').data('imgwidth');
							if( ! sliderWidth && ! cssua.ua.mobile ) {
								sliderWidth = jQuery(first_slide).find('video').width();
							}

							if( ! sliderWidth ) {
								sliderWidth = 940;
							}

							jQuery(this_tfslider).data('first_slide_width', sliderWidth);

							if(sliderWidth < jQuery(this_tfslider).data('slider_width')) {
								sliderWidth = jQuery(this_tfslider).data('slider_width');
							}

							var percentage_width = true;
						} else {
							sliderWidth = parseInt(jQuery(this_tfslider).data('slider_width'));
						}

						var sliderHeight = parseInt(jQuery(this_tfslider).data('slider_height'));
						var aspect_ratio = sliderHeight / sliderWidth;

						if(aspect_ratio < 0.5) {
							aspect_ratio = 0.5;
						}

						var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
						if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
							compare_width = jQuery(this_tfslider).width();
						}
						var sliderHeight = aspect_ratio * compare_width;

						if(sliderHeight > parseInt(jQuery(this_tfslider).data('slider_height'))) {
							sliderHeight = parseInt(jQuery(this_tfslider).data('slider_height'));
						}

						if(sliderHeight < 200) {
							sliderHeight = 300;
						}

						jQuery(this_tfslider).find('video').each(function() {
							var aspect_ratio = jQuery(this).width() / jQuery(this).height();
							var arc_sliderWidth = aspect_ratio * sliderHeight;

							if(arc_sliderWidth < sliderWidth && !jQuery(this_tfslider).hasClass('full-width-slider')) {
								arc_sliderWidth = sliderWidth;
							}

							var arc_sliderLeft = '-' + ((arc_sliderWidth - jQuery(this_tfslider).width()) / 2) + 'px';
							var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
							if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
								compare_width = jQuery(this_tfslider).width();
							}
							if(compare_width > arc_sliderWidth && percentage_width === true && jQuery(this_tfslider).data('full_screen') != 1) {
								arc_sliderWidth = '100%';
								arc_sliderLeft = 0;
							}
							jQuery(this).width(arc_sliderWidth);
							jQuery(this).css('left', arc_sliderLeft);
						});
					}

					jQuery(this_tfslider).parents('.fusion-slider-container').css('max-height', sliderHeight);
					jQuery(this_tfslider).parents('.fusion-slider-container').css('height', sliderHeight);
					jQuery(this_tfslider).css('height', sliderHeight);
					jQuery(this_tfslider).find('.background, .mobile_video_image').css('height', sliderHeight);

					if(jQuery(this_tfslider).data('full_screen') == 0 && (cssua.ua.mobile && cssua.ua.mobile != 'ipad') || jQuery(this_tfslider).parents('.post-content').length >= 1) {
						jQuery(this_tfslider).parents('.fusion-slider-container').css('height', 'auto');
						jQuery(this_tfslider).find('.mobile_video_image').each(function() {
							var img_url = jQuery('.mobile_video_image').css('background-image').replace('url(', '').replace(')', '');
							if(img_url) {
								var preview_image = new Image();
								preview_image.name = img_url;
								preview_image.src = img_url;
								preview_image.onload = function() {
									var ar = this.height / this.width;
									var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
									if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
										compare_width = jQuery(this_tfslider).width();
									}
									var mobile_preview_height = ar * compare_width;
									if(mobile_preview_height < sliderHeight) {
										jQuery(this_tfslider).find('.mobile_video_image').css('height', mobile_preview_height);
										jQuery(this_tfslider).find('.mobile_video_image').css('height', mobile_preview_height);
									}
								};
							}
						});
						if(jQuery(slider.slides.eq(slider.currentSlide)).find('video').length >= 1 && jQuery(slider.slides.eq(slider.currentSlide)).find('.mobile_video_image').length >= 1) {
							var img_url = jQuery(slider.slides.eq(slider.currentSlide)).find('.mobile_video_image').css('background-image').replace('url(', '').replace(')', '');
							if(img_url) {
								var preview_image = new Image();
								preview_image.name = img_url;
								preview_image.src = img_url;
								preview_image.onload = function() {
									var ar = this.height / this.width;
									var compare_width = jQuery(this_tfslider).parent().parent().parent().width();
									if(jQuery(this_tfslider).parents('.post-content').length >= 1) {
										compare_width = jQuery(this_tfslider).width();
									}
									var mobile_preview_height = ar * compare_width;
									if(mobile_preview_height < sliderHeight) {
										jQuery(this_tfslider).find('.mobile_video_image').css('height', mobile_preview_height);
										jQuery(this_tfslider).css('height', mobile_preview_height);
									}
								};
							}
						}
					}

					if(jQuery(this_tfslider).data('parallax') == 1 && ! Modernizr.mq('only screen and (max-width: ' + ( 1000 + parseInt( js_local_vars.side_header_width ) ) + 'px)')) {
						jQuery(this_tfslider).css('position', 'fixed');
						if( jQuery( '.fusion-header-wrapper' ).css( 'position' ) != 'absolute' ) {
							jQuery('.fusion-header-wrapper').css('position', 'relative');
							jQuery(this_tfslider).parents('.fusion-slider-container').css('margin-top', '-' + headerHeight + 'px');
						}
						jQuery('#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar').css('position', 'relative');
						jQuery('#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar').css('z-index', '3');
						jQuery('.fusion-header-wrapper').css('z-index', '5');
						jQuery('.fusion-header-wrapper').css('height', headerHeight);

						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-webkit-transform', 'translate(0, ' + (headerHeight / 2) + 'px)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-ms-transform', 'translate(0, ' + (headerHeight / 2) + 'px)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-o-transform', 'translate(0, ' + (headerHeight / 2) + 'px)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-moz-transform', 'translate(0, ' + (headerHeight / 2) + 'px)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('transform', 'translate(0, ' + (headerHeight / 2) + 'px)');

						if(jQuery(this_tfslider).data('full_screen') == 1) {
							jQuery(slider).find('.flex-control-nav').css('bottom', (headerHeight / 2));
						} else {
							jQuery(slider).find('.flex-control-nav').css('bottom', 0);
						}

						if(jQuery(this_tfslider).hasClass('fixed-width-slider')) {
							if( js_local_vars.header_position == 'Left' || js_local_vars.header_position == 'Right' ) {
								if( jQuery(this_tfslider).parents( '#sliders-container' ).length ) {
									var wrapping_container = jQuery( '#sliders-container' );
								} else {
									var wrapping_container = jQuery( '#main' );
								}

								if( wrapping_container.width() < parseFloat( jQuery(this_tfslider).parent().css( 'max-width' ) ) ) {
									jQuery(this_tfslider).css( 'max-width', wrapping_container.width() );
								} else {
									jQuery(this_tfslider).css( 'max-width', jQuery(this_tfslider).parent().css( 'max-width' ) );
								}

								if( js_local_vars.header_position == 'Left' ) {
									var fixed_width_center = '-' + ((jQuery(this_tfslider).width() - jQuery( '#side-header' ).width() ) / 2) + 'px';
								} else {
									var fixed_width_center = '-' + ((jQuery(this_tfslider).width() + jQuery( '#side-header' ).width() ) / 2) + 'px';
								}

								if( ( -1 ) * fixed_width_center > jQuery(this_tfslider).width() ) {
									fixed_width_center = ( -1 ) * jQuery(this_tfslider).width();
								}
							} else {
								var fixed_width_center = '-' + (jQuery(this_tfslider).width() / 2) + 'px';
							}
							jQuery(this_tfslider).css('left', '50%');
							jQuery(this_tfslider).css('margin-left', fixed_width_center);
						}
					} else if(jQuery(this_tfslider).data('parallax') == 1 && Modernizr.mq('only screen and (max-width: ' + ( 1000 + parseInt( js_local_vars.side_header_width ) ) + 'px)')) {
						jQuery(this_tfslider).css('position', 'relative');
						jQuery(this_tfslider).css('left', '0');
						jQuery(this_tfslider).css('margin-left', '0');
						if( jQuery( '.fusion-header-wrapper' ).css( 'position' ) != 'absolute' ) {
							jQuery('.fusion-header-wrapper').css('position', 'relative');
						}
						jQuery('#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar').css('position', 'relative');
						jQuery('#main, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-page-title-bar').css('z-index', '3');
						jQuery('.fusion-header-wrapper').css('z-index', '5');
						jQuery('.fusion-header-wrapper').css('height', 'auto');
						jQuery(this_tfslider).parents('.fusion-slider-container').css('margin-top', '');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-webkit-transform', 'translate(0, 0)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-ms-transform', 'translate(0, 0)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-o-transform', 'translate(0, 0)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('-moz-transform', 'translate(0, 0)');
						jQuery(this_tfslider).find('.flex-direction-nav li a').css('transform', 'translate(0, 0)');

						jQuery(this_tfslider).find('.flex-control-nav').css('bottom', 0);
					}

					if(Modernizr.mq('only screen and (max-width: 640px)')) {
						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							var contentPadding = '0px';

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					} else if(Modernizr.mq('only screen and (max-width: 800px)')) {
						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							var contentPadding = '0px';

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					} else {
						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							jQuery(this).css('-webkit-transform', '');
							jQuery(this).css('-ms-transform', '');
							jQuery(this).css('-o-transform', '');
							jQuery(this).css('-moz-transform', '');
							jQuery(this).css('transform', '');

							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							if(jQuery(this_tfslider).data('parallax') == '1' && jQuery(this_tfslider).parents('.post-content').length === 0) {
								var contentPadding = headerHeight / 2;
							}

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					}

					jQuery(slider.slides.eq(slider.currentSlide)).find('video').each(function() {
						if(jQuery(this).parents('li').attr('data-autoplay') == 'yes') {
							if( typeof jQuery(this)[0].play === "function" ) {
								jQuery(this)[0].play();
							}
						}
					});

					jQuery(slider.slides.eq(slider.currentSlide)).find('iframe').each(function() {
						if(jQuery(this).parents('li').attr('data-autoplay') == 'yes') {
							jQuery(this_tfslider).flexslider('pause');
							var video = this;
							setTimeout(function() {
								video.contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
							}, 1000);
						}
					});

					if(js_local_vars.header_position == 'Left' || js_local_vars.header_position == 'Right') {
						if( jQuery(this_tfslider).parents('#sliders-container').length >= 1 ) {
							var slideContent = jQuery(this_tfslider).parents('#sliders-container').find('.slide-content-container');
							jQuery(slideContent).each(function() {
								if(jQuery(this).hasClass('slide-content-right')) {
									jQuery(this).find('.slide-content').css('margin-right', '100px');
								} else if(jQuery(this).hasClass('slide-content-left')) {
									jQuery(this).find('.slide-content').css('margin-left', '100px');
								}
							});
						}
					}

					fusion_reanimate_slider( slideContent );

					if(typeof(slider.slides) !== 'undefined' && slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
						if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
							YT_ready(function() {
								new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
									events: {
										'onReady': onPlayerReady(slider.slides.eq(slider.currentSlide)),
										'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
									}
								});
							});
						}
						if(!Number(js_local_vars.status_vimeo)) {
							$f(slider.slides.eq(slider.currentSlide).find('iframe')[0]).api('pause');

							if(jQuery(slider.slides.eq(slider.currentSlide)).data('autoplay') == 'yes') {
								$f(slider.slides.eq(slider.currentSlide).find('iframe')[0]).api('play');
							}
							if(jQuery(slider.slides.eq(slider.currentSlide)).data('mute') == 'yes') {
								$f(slider.slides.eq(slider.currentSlide).find('iframe')[0]).api('setVolume', 0);
							}
						}
					}

					jQuery(this_tfslider).find('.overlay-link').hide();
					jQuery(slider.slides.eq(slider.currentSlide)).find('.overlay-link').show();

					// Reinitialize waypoint
					jQuery.waypoints( 'viewportHeight' );
					jQuery.waypoints('refresh');

				},
				before: function(slider) {
					jQuery(this_tfslider).find('.slide-content-container').hide();

					if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
						if(!Number(js_local_vars.status_vimeo)) {
							jQuery(this_tfslider).find('iframe').each(function() {
								$f(jQuery(this)[0]).api('pause');
							});

							if(jQuery(slider.slides.eq(slider.currentSlide)).data('autoplay') == 'yes') {
								$f(slider.slides.eq(slider.currentSlide).find('iframe')[0]).api('play');
							}
							if(jQuery(slider.slides.eq(slider.currentSlide)).data('mute') == 'yes') {
								$f(slider.slides.eq(slider.currentSlide).find('iframe')[0]).api('setVolume', 0);
							}
						}

						if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
							YT_ready(function() {
								new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
									events: {
										'onReady': onPlayerReady(slider.slides.eq(slider.currentSlide)),
										'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
									}
								});
							});
						}
					}

					playVideoAndPauseOthers(slider);
				},
				after: function(slider) {
					jQuery(slider.slides.eq(slider.currentSlide)).find('.slide-content-container').show();

					if(Modernizr.mq('only screen and (max-width: 640px)')) {
						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							var contentPadding = '0px';

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					} else if(Modernizr.mq('only screen and (max-width: 800px)')) {
						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							var contentPadding = '0px';

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					} else {
						var slideContent = jQuery(this_tfslider).find('.slide-content-container');
						jQuery(slideContent).each(function() {
							jQuery(this).css('-webkit-transform', '');
							jQuery(this).css('-ms-transform', '');
							jQuery(this).css('-o-transform', '');
							jQuery(this).css('-moz-transform', '');
							jQuery(this).css('transform', '');

							var contentHeight = '-' + (jQuery(this).find('.slide-content').height() / 2) + 'px';
							if(jQuery(this_tfslider).data('parallax') == '1' && jQuery(this_tfslider).parents('.post-content').length === 0) {
								var contentPadding = headerHeight / 2;
							}

							jQuery(this).css('margin-top', contentHeight);
							jQuery(this).css('padding-top', contentPadding);
						});
					}

					fusion_reanimate_slider( slideContent );

					if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
						if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
							YT_ready(function() {
								new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
									events: {
										'onReady': onPlayerReady(slider.slides.eq(slider.currentSlide)),
										'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
									}
								});
							});
						}
						if(!Number(js_local_vars.status_vimeo)) {
							jQuery(this_tfslider).find('iframe').each(function() {
								$f(jQuery(this)[0]).api('pause');
							});

							if(jQuery(slider.slides.eq(slider.currentSlide)).data('autoplay') == 'yes') {
								$f(slider.slides.eq(slider.currentSlide).find('iframe')[0]).api('play');
							}
							if(jQuery(slider.slides.eq(slider.currentSlide)).data('mute') == 'yes') {
								$f(slider.slides.eq(slider.currentSlide).find('iframe')[0]).api('setVolume', 0);
							}
						}
					}

					jQuery(this_tfslider).find('.overlay-link').hide();
					jQuery(slider.slides.eq(slider.currentSlide)).find('.overlay-link').show();

					playVideoAndPauseOthers(slider);

					jQuery('[data-spy="scroll"]').each(function () {
					  var $spy = jQuery(this).scrollspy('refresh');
					});
				}
			});
		});

		if(js_local_vars.page_smoothHeight === 'false') {
			page_smoothHeight = false;
		} else {
			page_smoothHeight = true;
		}

		jQuery('.fusion-blog-layout-grid .flexslider').flexslider({
			slideshow: Boolean(Number(js_local_vars.slideshow_autoplay)),
			slideshowSpeed: Number(js_local_vars.slideshow_speed),
			video: true,
			smoothHeight: page_smoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function(slider) {
				jQuery( slider ).removeClass( 'fusion-flexslider-loading' );

				if(typeof(slider.slides) !== 'undefined' && slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '-20px');
					} else {
						jQuery(slider).find('.flex-control-nav').hide();
					}
					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}
				} else {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '0px');
					} else {
						jQuery(slider).find('.flex-control-nav').show();
					}
				}

				// Reinitialize waypoints
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints('refresh');
			},
			before: function(slider) {
				if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(!Number(js_local_vars.status_vimeo)) {
						$f(slider.slides.eq(slider.currentSlide).find('iframe')[0] ).api('pause');
					}

					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers(slider);
				}
			},
			after: function(slider) {
				if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '-20px');
					} else {
						jQuery(slider).find('.flex-control-nav').hide();
					}

					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}
				} else {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '0px');
					} else {
						jQuery(slider).find('.flex-control-nav').show();
					}
				}
				jQuery('[data-spy="scroll"]').each(function () {
				  var $spy = jQuery(this).scrollspy('refresh');
				});
			}
		});

		if(js_local_vars.flex_smoothHeight === 'false') {
			flex_smoothHeight = false;
		} else {
			flex_smoothHeight = true;
		}

		jQuery('.fusion-flexslider').flexslider({
			slideshow: Boolean(Number(js_local_vars.slideshow_autoplay)),
			slideshowSpeed: js_local_vars.slideshow_speed,
			video: true,
			smoothHeight: flex_smoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function(slider) {
				// Remove Loading
				slider.removeClass('fusion-flexslider-loading');

				// For dynamic content, like equalHeights
				jQuery( window ).trigger( 'resize' );

				if(typeof(slider.slides) !== 'undefined' && slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '-20px');
					} else {
						jQuery(slider).find('.flex-control-nav').hide();
					}
					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}
				} else {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '0px');
					} else {
						jQuery(slider).find('.flex-control-nav').show();
					}
				}

				// Reinitialize waypoint
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints( 'refresh' );
			},
			before: function(slider) {
				if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(!Number(js_local_vars.status_vimeo)) {
						$f( slider.slides.eq(slider.currentSlide).find('iframe')[0] ).api('pause');
					}

					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers(slider);
				}
			},
			after: function(slider) {
				if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '-20px');
					} else {
						jQuery(slider).find('.flex-control-nav').hide();
					}

					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}
				} else {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '0px');
					} else {
						jQuery(slider).find('.flex-control-nav').show();
					}
				}
				jQuery('[data-spy="scroll"]').each(function () {
				  var $spy = jQuery(this).scrollspy('refresh');
				});
			}
		});

		jQuery('.flexslider').flexslider({
			slideshow: Boolean(Number(js_local_vars.slideshow_autoplay)),
			slideshowSpeed: js_local_vars.slideshow_speed,
			video: true,
			smoothHeight: flex_smoothHeight,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function(slider) {
				// Remove Loading
				slider.removeClass('fusion-flexslider-loading');

				if(typeof(slider.slides) !== 'undefined' && slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '-20px');
					} else {
						jQuery(slider).find('.flex-control-nav').hide();
					}
					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}
				} else {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '0px');
					} else {
						jQuery(slider).find('.flex-control-nav').show();
					}
				}

				// Reinitialize waypoint
				jQuery.waypoints( 'viewportHeight' );
				jQuery.waypoints( 'refresh' );
			},
			before: function(slider) {
				if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(!Number(js_local_vars.status_vimeo)) {
						$f( slider.slides.eq(slider.currentSlide).find('iframe')[0] ).api('pause');
					}

					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}

					/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
					playVideoAndPauseOthers(slider);
				}
			},
			after: function(slider) {
				if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '-20px');
					} else {
						jQuery(slider).find('.flex-control-nav').hide();
					}

					if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
						YT_ready(function() {
							new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
								events: {
									'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
								}
							});
						});
					}
				} else {
					if(Number(js_local_vars.pagination_video_slide)) {
						jQuery(slider).find('.flex-control-nav').css('bottom', '0px');
					} else {
						jQuery(slider).find('.flex-control-nav').show();
					}
				}
				jQuery('[data-spy="scroll"]').each(function () {
				  var $spy = jQuery(this).scrollspy('refresh');
				});
			}
		});

		function playVideoAndPauseOthers(slider) {
			jQuery(slider).find('iframe').each(function(i) {
				var func = 'pauseVideo';
				this.contentWindow.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
				if(!jQuery(this).parents('li').hasClass('clone') && jQuery(this).parents('li').hasClass('flex-active-slide') && jQuery(this).parents('li').attr('data-autoplay') == 'yes') {
					jQuery(this).parents('.flexslider').flexslider('pause');
					this.contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');

					if(jQuery(this).parents('li').attr('data-mute') == 'yes') {
						this.contentWindow.postMessage('{"event":"command","func":"' + 'mute' + '","args":""}', '*');
					}
				}
			});
			jQuery(slider).find('video').each(function(i) {
				if( typeof jQuery(this)[0].pause === "function" ) {
					jQuery(this)[0].pause();
				}
				if(!jQuery(this).parents('li').hasClass('clone') && jQuery(this).parents('li').hasClass('flex-active-slide') && jQuery(this).parents('li').attr('data-autoplay') == 'yes') {
					if( typeof jQuery(this)[0].play === "function" ) {
						jQuery(this)[0].play();
					}
				}
			});
		}

		/* ------------------ PREV & NEXT BUTTON FOR FLEXSLIDER (YOUTUBE) ------------------ */
		jQuery('.flex-next, .flex-prev').click(function() {
			//playVideoAndPauseOthers(jQuery(this).parents('.flexslider'));
		});
	}

	if(jQuery().isotope) {

		jQuery( '.fusion-blog-layout-grid' ).each(function() {

			var columns = 2;
			for( i = 1; i < 7; i++ ) {
				if( jQuery ( this ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
					columns = i;
				}
			}

			var grid_width = Math.floor( 100 / columns * 100 ) / 100  + '%';
			jQuery( this ).find( '.fusion-post-grid' ).css( 'width', grid_width );
			jQuery( this ).isotope({
				layoutMode: 'masonry',
				itemSelector: '.fusion-post-grid',
				transformsEnabled: false,
				isOriginLeft: jQuery( 'body.rtl' ).length ? false : true,
				resizable: true,

			});


			if( ( jQuery ( this ).hasClass( 'fusion-blog-layout-grid-4') || jQuery ( this ).hasClass( 'fusion-blog-layout-grid-5') || jQuery ( this ).hasClass( 'fusion-blog-layout-grid-6') ) && Modernizr.mq('only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait)')) {
				var grid_width = Math.floor( 100 / 3 * 100 ) / 100  + '%';
				jQuery( this ).find( '.fusion-post-grid' ).css( 'width', grid_width );
				jQuery( this ).isotope({
					layoutMode: 'masonry',
					itemSelector: '.fusion-post-grid',
					transformsEnabled: false,
					isOriginLeft: jQuery( 'body.rtl' ).length ? false : true,
					resizable: true,

				});
			}
		});
	}

	if(Boolean(Number(js_local_vars.avada_rev_styles))) {
		jQuery('.rev_slider_wrapper').each(function() {
			var rev_slider_wrapper = jQuery(this);

			if(jQuery(this).length >=1 && jQuery(this).find('.tp-bannershadow').length === 0) {
				jQuery('<div class="shadow-left">').appendTo(this);
				jQuery('<div class="shadow-right">').appendTo(this);

				jQuery(this).addClass('avada-skin-rev');
			}

			if( ! jQuery(this).find( '.tp-leftarrow' ).hasClass( 'preview1' ) && ! jQuery(this).find( '.tp-leftarrow' ).hasClass( 'preview2' ) && ! jQuery(this).find( '.tp-leftarrow' ).hasClass( 'preview3' ) && ! jQuery(this).find( '.tp-leftarrow' ).hasClass( 'preview4' ) ) {
				jQuery(this).addClass('avada-skin-rev-nav');

				if( rev_slider_wrapper.find( '.tp-leftarrow' ).height() > rev_slider_wrapper.height() / 4 && rev_slider_wrapper.find( '.tp-leftarrow' ).height() < rev_slider_wrapper.height() ) {
					var rev_slider_id = rev_slider_wrapper.attr('id');
					var new_dimension = rev_slider_wrapper.height() / 4;
					if( rev_slider_wrapper.children( '.avada-rev-arrows' ).length ) {
						rev_slider_wrapper.children( '.avada-rev-arrows' ).empty();
						rev_slider_wrapper.children( '.avada-rev-arrows' ).append( '<style type="text/css">#' + rev_slider_id + ' .tp-leftarrow, #' + rev_slider_id + ' .tp-rightarrow{margin-top:-' + new_dimension / 2 + 'px !important;width:' + new_dimension + 'px !important;height:' + new_dimension + 'px !important;}#' + rev_slider_id + ' .tp-leftarrow:before, #' + rev_slider_id + ' .tp-rightarrow:before{line-height:' + new_dimension  + 'px;font-size:' + new_dimension / 2 + 'px;}</style>' );
					} else {
						rev_slider_wrapper.prepend( '<div class="avada-rev-arrows"><style type="text/css">#' + rev_slider_id + ' .tp-leftarrow, #' + rev_slider_id + ' .tp-rightarrow{margin-top:-' + new_dimension / 2 + 'px !important;width:' + new_dimension + 'px !important;height:' + new_dimension + 'px !important;}#' + rev_slider_id + ' .tp-leftarrow:before, #' + rev_slider_id + ' .tp-rightarrow:before{line-height:' + new_dimension  + 'px;font-size:' + new_dimension / 2 + 'px;}</style></div>' );
					}
				}

				jQuery(window).on('resize', function() {
					if( rev_slider_wrapper.find( '.tp-leftarrow' ).height() > rev_slider_wrapper.height() / 4 && rev_slider_wrapper.find( '.tp-leftarrow' ).height() < rev_slider_wrapper.height() ) {
						var rev_slider_id = rev_slider_wrapper.attr('id');
						var new_dimension = rev_slider_wrapper.height() / 4;
						if( rev_slider_wrapper.children( '.avada-rev-arrows' ).length ) {
							rev_slider_wrapper.children( '.avada-rev-arrows' ).empty();
							rev_slider_wrapper.children( '.avada-rev-arrows' ).append( '<style type="text/css">#' + rev_slider_id + ' .tp-leftarrow, #' + rev_slider_id + ' .tp-rightarrow{margin-top:-' + new_dimension / 2 + 'px !important;width:' + new_dimension + 'px !important;height:' + new_dimension + 'px !important;}#' + rev_slider_id + ' .tp-leftarrow:before, #' + rev_slider_id + ' .tp-rightarrow:before{line-height:' + new_dimension  + 'px;font-size:' + new_dimension / 2 + 'px;}</style>' );
						} else {
							rev_slider_wrapper.prepend( '<div class="avada-rev-arrows"><style type="text/css">#' + rev_slider_id + ' .tp-leftarrow, #' + rev_slider_id + ' .tp-rightarrow{margin-top:-' + new_dimension / 2 + 'px !important;width:' + new_dimension + 'px !important;height:' + new_dimension + 'px !important;}#' + rev_slider_id + ' .tp-leftarrow:before, #' + rev_slider_id + ' .tp-rightarrow:before{line-height:' + new_dimension  + 'px;font-size:' + new_dimension / 2 + 'px;}</style></div>' );
						}
					} else {
						rev_slider_wrapper.children( '.avada-rev-arrows' ).remove();
					}
				});
			}

		});
	}
});

jQuery( document ).ready( function() {
	if(jQuery().flexslider && jQuery('.woocommerce .images #carousel').length >= 1) {
		var WooThumbWidth = 100;
		if(jQuery('body.woocommerce .sidebar').is(':visible')) {
			wooThumbWidth = 100;
		} else {
			wooThumbWidth = 118;
		}

		if(typeof jQuery('.woocommerce .images #carousel').data('flexslider') !== 'undefined') {
			jQuery('.woocommerce .images #carousel').flexslider('destroy');
			jQuery('.woocommerce .images #slider').flexslider('destroy');
		}

		jQuery('.woocommerce .images #carousel').flexslider({
			animation: 'slide',
			controlNav: false,
			directionNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: wooThumbWidth,
			itemMargin: 9,
			touch: false,
			useCSS: false,
			asNavFor: '.woocommerce .images #slider',
			smoothHeight: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function(slider) {
				jQuery( slider ).removeClass( 'fusion-flexslider-loading' );
			}
		});

		jQuery('.woocommerce .images #slider').flexslider({
			animation: 'slide',
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			smoothHeight: true,
			touch: true,
			useCSS: false,
			sync: '.woocommerce .images #carousel',
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			start: function(slider) {
				jQuery( slider ).removeClass( 'fusion-flexslider-loading' );
			}
		});
	}

	if(jQuery().flexslider && jQuery('.flexslider-attachments').length >= 1) {
		if(typeof jQuery('.flexslider-attachments').data('flexslider') !== 'undefined') {
			jQuery('.flexslider-attachments').flexslider('destroy');
		}

		jQuery('.flexslider-attachments').flexslider({
			slideshow: Boolean(Number(js_local_vars.slideshow_autoplay)),
			slideshowSpeed: js_local_vars.slideshow_speed,
			video: false,
			smoothHeight: false,
			pauseOnHover: false,
			useCSS: false,
			prevText: '&#xf104;',
			nextText: '&#xf105;',
			controlNav: 'thumbnails',
			start: function(slider) {
				jQuery( slider ).find( '.fusion-slider-loading' ).remove();

				// Remove Loading
				slider.removeClass('fusion-flexslider-loading');
			}
		});
	}
});

jQuery( window ).load( function() {
	// Calculate the needed height of the secondary menu
	jQuery( '.fusion-secondary-menu' ).fusion_calculate_secondary_menu_height();

	jQuery(window).on('resize', function() {
		jQuery( '.fusion-secondary-menu' ).fusion_calculate_secondary_menu_height();
	});

	if ( jQuery( '.fusion-secondary-menu .fusion-secondary-menu-cart' ).width() > 176 ) {
		setTimeout( function() {
			var cart_width = jQuery( '.fusion-secondary-menu .fusion-secondary-menu-cart' ).outerWidth(),
				cart_content = jQuery('.fusion-secondary-menu-cart .fusion-menu-cart-items a'),
				cart_content_width = cart_content.width(),
				cart_content_padding = cart_content.outerWidth() - cart_content_width,
				new_cart_content_width = cart_width - cart_content_padding,
				img = jQuery( '.fusion-secondary-menu-cart .fusion-menu-cart-items a > img' ),
				img_width = img.width();
				img_margin = img.outerWidth( true ) - img_width;

			jQuery('.fusion-secondary-menu-cart .fusion-menu-cart-items').width( cart_width );
			jQuery('.fusion-secondary-menu-cart .fusion-menu-cart-items a').width( new_cart_content_width );

			jQuery('.fusion-secondary-menu-cart .fusion-menu-cart-items a').find( '.fusion-menu-cart-item-details' ).each( function() {
				jQuery ( this ).width( jQuery ( this ).parent().width() - img_width - img_margin );
			});
		}, 750 );
	}

	if( js_local_vars.sidenav_behavior == 'Click' ) {
		jQuery('.side-nav li a').on('click', function(e) {
			if( jQuery(this).parent('.page_item_has_children').length ) {
				if(jQuery(this).parent().find('> .children').length  && ! jQuery(this).parent().find('> .children').is(':visible') ) {
					jQuery(this).parent().find('> .children').stop(true, true).slideDown('slow');
				} else {
					jQuery(this).parent().find('> .children').stop(true, true).slideUp('slow');
				}
			}

			if( jQuery(this).parent('.page_item_has_children.current_page_item').length ) {
				return false;
			}
		});
	} else {
		jQuery('.side-nav li').hoverIntent({
		over: function() {
			if( jQuery(this).find('> .children').length ) {
				jQuery(this).find('> .children').stop(true, true).slideDown('slow');
			}
		},
		out: function() {
			if(jQuery(this).find('.current_page_item').length === 0 && jQuery(this).hasClass('current_page_item') === false) {
				jQuery(this).find('.children').stop(true, true).slideUp('slow');
			}
		},
		timeout: 500
		});
	}

	if(jQuery().eislideshow) {
		var eislideshow_args = {
			autoplay: Boolean(Number(js_local_vars.tfes_autoplay))
		};

		if(js_local_vars.tfes_animation) {
			eislideshow_args.animation = js_local_vars.tfes_animation;
		}
		if(js_local_vars.tfes_interval) {
			eislideshow_args.slideshow_interval = js_local_vars.tfes_interval;
		}
		if(js_local_vars.tfes_speed) {
			eislideshow_args.speed = js_local_vars.tfes_speed;
		}
		if(js_local_vars.tfes_width) {
			eislideshow_args.thumbMaxWidth = js_local_vars.tfes_width;
		}

		jQuery('#ei-slider').eislideshow(eislideshow_args);
	}

	var retina = window.devicePixelRatio > 1 ? true : false;

	if(js_local_vars.custom_icon_image_retina && retina) {
		jQuery('.fusion-social-networks a.custom').each(function() {
			jQuery(this).find('img').attr('src', js_local_vars.custom_icon_image_retina);
			jQuery(this).find('img').attr('width', js_local_vars.retina_icon_width);
			jQuery(this).find('img').attr('height', js_local_vars.retina_icon_height);
		});
	}

	/* wpml flag in center */
	var wpml_flag = jQuery('ul#navigation > li > a > .iclflag');
	var wpml_h = wpml_flag.height();
	wpml_flag.css('margin-top', +wpml_h / - 2 + "px");

	var wpml_flag = jQuery('.top-menu > ul > li > a > .iclflag');
	var wpml_h = wpml_flag.height();
	wpml_flag.css('margin-top', +wpml_h / - 2 + "px");

	// Timeline vars and click events for infinite scroll
	var last_timeline_date = jQuery( '.blog-layout-timeline' ).find( '.timeline-date' ).last().text();
	var collapse_month_visible = true;

	jQuery( '.fusion-blog-layout-timeline' ).find( '.fusion-timeline-date' ).click( function() {
		jQuery( this ).next( '.collapse-month' ).slideToggle();
	});

	jQuery( '.fusion-timeline-icon' ).find( '.fusion-icon-bubbles' ).click( function() {
		if ( collapse_month_visible ) {
			jQuery( this ).parent().next( '.fusion-blog-layout-timeline' ).find( '.fusion-collapse-month' ).slideUp();
			collapse_month_visible = false;
		} else {
			jQuery( this ).parent().next( '.fusion-blog-layout-timeline' ).find( '.fusion-collapse-month' ).slideDown();
			collapse_month_visible = true;
		}
	});

	// Setup infinite scroll for each blog instance; main blog page and blog shortcodes
	jQuery( '.fusion-posts-container-infinite' ).each( function() {
		// Set the correct container for blog shortcode infinite scroll
		var $blog_infinite_container = jQuery( this );
		if ( jQuery( this ).find( '.fusion-blog-layout-timeline' ).length ) {
			$blog_infinite_container = jQuery( this ).find( '.fusion-blog-layout-timeline' );
		}

		// Infite scroll for main blog page and blog shortcode
		jQuery( $blog_infinite_container ).infinitescroll({
			navSelector  : "div.pagination",
						   // selector for the paged navigation (it will be hidden)
			nextSelector : "a.pagination-next",
						   // selector for the NEXT link (to page 2)
			itemSelector : "div.pagination .current, div.post:not( .fusion-archive-description ), .fusion-collapse-month, .fusion-timeline-date",
						   // selector for all items you'll retrieve
			loading	  : {
							finishedMsg: js_local_vars.infinite_finished_msg,
							msg: jQuery( '<div class="fusion-loading-container fusion-clearfix"><div class="fusion-loading-spinner"><div class="fusion-spinner-1"></div><div class="fusion-spinner-2"></div><div class="fusion-spinner-3"></div></div><div class="fusion-loading-msg">'+js_local_vars.infinite_blog_text+'</div>' )
			},
			errorCallback: function() {
				if ( jQuery( $blog_infinite_container ).hasClass( 'isotope' ) ) {
					jQuery( $blog_infinite_container ).isotope();
				}
			}
		}, function( posts ) {
			// Timeline layout specific actions
			if ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-layout-timeline' ) ) {
				// Check if the last already displayed moth is the same as the first newly loaded; if so, delete one label
				if ( jQuery( posts ).first( '.fusion-timeline-date' ).text() == last_timeline_date ) {
					jQuery( posts ).first( '.fusion-timeline-date' ).remove();
				}
				// Set the last timeline date to lat of the currently loaded
				last_timeline_date = jQuery( $blog_infinite_container ).find( '.fusion-timeline-date' ).last().text();

				// Append newly loaded items of the same month to the container that is already there
				jQuery( $blog_infinite_container ).find( '.fusion-timeline-date' ).each( function() {
					jQuery( this ).next( '.fusion-collapse-month' ).append( jQuery( this ).nextUntil( '.fusion-timeline-date', '.fusion-post-timeline' ) );
				});

				// If all month containers are collapsed, also collapse the new ones
				if ( ! collapse_month_visible ) {
					setTimeout( function() {
						jQuery( $blog_infinite_container ).find ( '.fusion-collapse-month' ).hide();
					}, 200 );
				}

				// Delete empty collapse-month containers
				setTimeout( function() {
					jQuery( $blog_infinite_container ).find ( '.fusion-collapse-month' ).each( function() {
						if ( ! jQuery( this ).children().length ) {
							jQuery( this ).remove();
						}
					});
				}, 10 );

				// Reset the click event for the collapse-month toggle
				jQuery( $blog_infinite_container ).find( '.fusion-timeline-date' ).unbind( 'click' );
				jQuery( $blog_infinite_container ).find( '.fusion-timeline-date' ).click( function() {
					jQuery( this ).next( '.fusion-collapse-month' ).slideToggle();
				});
			}

			// Grid layout specific actions
			if ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-layout-grid' ) &&
				 jQuery().isotope
			) {
				jQuery( posts ).hide();

				// Get the amount of columns
				var columns = 2;
				for ( i = 1; i < 7; i++ ) {
					if ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-layout-grid-' + i ) ) {
						columns = i;
					}
				}

				// Calculate grid with
				var grid_width = Math.floor( 100 / columns * 100 ) / 100  + '%';
				jQuery( $blog_infinite_container ).find( '.post' ).css( 'width', grid_width );

				// Add and fade in new posts when all images are loaded
				imagesLoaded( posts, function() {
					jQuery( posts ).fadeIn();

					// Relayout isotope
					if ( jQuery( $blog_infinite_container ).hasClass( 'isotope' ) ) {
						jQuery( $blog_infinite_container ).isotope( 'appended', jQuery( posts ) );
						jQuery( $blog_infinite_container ).isotope();
					}

					// Refresh the scrollspy script for one page layouts
					jQuery( '[data-spy="scroll"]' ).each( function () {
						  var $spy = jQuery( this ).scrollspy( 'refresh' );
					});
				});
			}

			// Initialize flexslider for post slideshows
			jQuery( $blog_infinite_container ).find( '.flexslider' ).flexslider({
				slideshow: Boolean(Number(js_local_vars.slideshow_autoplay)),
				slideshowSpeed: js_local_vars.slideshow_speed,
				video: true,
				pauseOnHover: false,
				useCSS: false,
				prevText: '&#xf104;',
				nextText: '&#xf105;',
				start: function( slider ) {
					// Remove Loading
					slider.removeClass('fusion-flexslider-loading');

					if(typeof(slider.slides) !== 'undefined' && slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
						if(Number(js_local_vars.pagination_video_slide)) {
							jQuery(slider).find('.flex-control-nav').css('bottom', '-20px');
						} else {
							jQuery(slider).find('.flex-control-nav').hide();
						}
						if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
							YT_ready(function() {
								new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
									events: {
										'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
									}
								});
							});
						}
					} else {
						if(Number(js_local_vars.pagination_video_slide)) {
							jQuery(slider).find('.flex-control-nav').css('bottom', '0px');
						} else {
							jQuery(slider).find('.flex-control-nav').show();
						}
					}

					// Reinitialize waypoints
					jQuery.waypoints( 'viewportHeight' );
					jQuery.waypoints('refresh');
				},
				before: function(slider) {
					if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
						if(!Number(js_local_vars.status_vimeo)) {
							$f( slider.slides.eq(slider.currentSlide).find('iframe')[0] ).api('pause');
						}

						if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
							YT_ready(function() {
								new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
									events: {
										'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
									}
								});
							});
						}

						/* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
						//playVideoAndPauseOthers(slider);
					}
				},
				after: function(slider) {
					if(slider.slides.eq(slider.currentSlide).find('iframe').length !== 0) {
						if(Number(js_local_vars.pagination_video_slide)) {
							jQuery(slider).find('.flex-control-nav').css('bottom', '-20px');
						} else {
							jQuery(slider).find('.flex-control-nav').hide();
						}

						if(!Number(js_local_vars.status_yt) && window.yt_vid_exists === true) {
							YT_ready(function() {
								new YT.Player(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), {
									events: {
										'onStateChange': onPlayerStateChange(slider.slides.eq(slider.currentSlide).find('iframe').attr('id'), slider)
									}
								});
							});
						}
					} else {
						if(Number(js_local_vars.pagination_video_slide)) {
							jQuery(slider).find('.flex-control-nav').css('bottom', '0px');
						} else {
							jQuery(slider).find('.flex-control-nav').show();
						}
					}
					jQuery('[data-spy="scroll"]').each(function () {
					  var $spy = jQuery(this).scrollspy('refresh');
					});
				}
			});

			// Trigger fitvids
			jQuery( posts ).each( function() {
				jQuery( this ).find( '.full-video, .video-shortcode, .wooslider .slide-content' ).fitVids();
			});

			// Hide the load more button, if the currently loaded page is already the last page
			$fusion_posts_container = $blog_infinite_container;
			if ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-layout-timeline' ) ) {
				$fusion_posts_container = jQuery( $blog_infinite_container ).parents( '.fusion-posts-container-infinite' );
			}

			$current_page = $fusion_posts_container.find( '.current' ).html();
			$fusion_posts_container.find( '.current' ).remove();

			if ( $fusion_posts_container.data( 'pages' ) == $current_page ) {
				$fusion_posts_container.parent().find( '.fusion-loading-container' ).hide();
           		$fusion_posts_container.parent().find( '.fusion-load-more-button' ).hide();
			}
		});

		// Setup infinite scroll manual loading
		if ( ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-archive' ) && js_local_vars.blog_pagination_type == 'load_more_button' ) ||
			 jQuery( $blog_infinite_container ).hasClass( 'fusion-posts-container-load-more' ) ||
			 ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-layout-timeline' ) && jQuery( $blog_infinite_container ).parent().hasClass( 'fusion-posts-container-load-more' ) )
		) {
			jQuery( $blog_infinite_container ).infinitescroll( 'unbind' );

			// Load more posts button click
			if ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-archive' ) ) {
				$load_more_button = jQuery( $blog_infinite_container ).parent().find( '.fusion-load-more-button' );
			} else {
				$load_more_button = jQuery( $blog_infinite_container ).parents( '.fusion-blog-archive' ).find( '.fusion-load-more-button' );
			}

			$load_more_button.on( 'click', function(e) {
				e.preventDefault();

				// Use the retrieve method to get the next set of posts
				jQuery( $blog_infinite_container ).infinitescroll( 'retrieve' );

				// Trigger isotope for correct positioning
				if ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-layout-grid' ) ) {
					jQuery( $blog_infinite_container ).isotope();
				}
			});
		}

		// Hide the load more button, if there is only one page
		$fusion_posts_container = $blog_infinite_container;
		if ( jQuery( $blog_infinite_container ).hasClass( 'fusion-blog-layout-timeline' ) ) {
			$fusion_posts_container = jQuery( $blog_infinite_container ).parents( '.fusion-posts-container-infinite' );
		}

		if ( $fusion_posts_container.data( 'pages' ) == '1' ) {
			$fusion_posts_container.parent().find( '.fusion-loading-container' ).hide();
			$fusion_posts_container.parent().find( '.fusion-load-more-button' ).hide();
		}
	});

	// Portfolio infinite scroll
	if ( js_local_vars.portfolio_pagination_type == 'Infinite Scroll' || js_local_vars.portfolio_pagination_type == 'load_more_button' ) {
		$infinte_scroll_container = jQuery( '.fusion-portfolio:not(.fusion-recent-works) .fusion-portfolio-wrapper' );

		// Initialize the infinite scroll object
		$infinte_scroll_container.infinitescroll({
			navSelector  : ".pagination",
						   // selector for the paged navigation (it will be hidden)
			nextSelector : ".pagination-next",
						   // selector for the NEXT link (to page 2)
			itemSelector : 'div.pagination .current, .fusion-portfolio-post',
						   // selector for all items you'll retrieve
			loading	  : {
							finishedMsg: js_local_vars.infinite_finished_msg,
							msg: jQuery('<div class="fusion-loading-container fusion-clearfix"><div class="fusion-loading-spinner"><div class="fusion-spinner-1"></div><div class="fusion-spinner-2"></div><div class="fusion-spinner-3"></div></div><div class="fusion-loading-msg">'+js_local_vars.infinite_blog_text+'</div>')
			},
			errorCallback: function() {
				jQuery( '.fusion-portfolio .fusion-portfolio-wrapper' ).isotope();
			},

		}, function( $posts ) {

			if ( jQuery().isotope ) {

				var $filters = jQuery( '.fusion-filters ' ).find( '.fusion-filter' ),
					$posts = jQuery( $posts );

				// Hide posts while loading
				$posts.hide();

				// Make sure images are loaded before the posts get shown
				imagesLoaded( $posts, function() {
					// Fade in placeholder images
					var $placeholder_images = jQuery( $posts ).find( '.fusion-portfolio-post .fusion-placeholder-image' );
					$placeholder_images.parent().animate({ opacity: 1 });

					// Portfolio Images Loaded Check
					window.$portfolio_images_index = 0;
					jQuery( $posts ).imagesLoaded().progress( function( $instance, $image ) {
						if( jQuery( $image.img ).parents( '.fusion-portfolio-content-wrapper' ).length >= 1 ) {
							jQuery( $image.img, $placeholder_images ).parents( '.fusion-portfolio-content-wrapper' ).delay( 100 * window.$portfolio_images_index ).animate({
								opacity: 1
							});
						} else {
							jQuery( $image.img, $placeholder_images ).parent().delay( 100 * window.$portfolio_images_index ).animate({
								opacity: 1
							});
						}

						window.$portfolio_images_index++;
					});

					if ( $filters ) {
						// Loop through all filters
						$filters.each( function() {
							var $filter = jQuery( this ),
								$filter_name = $filter.children( 'a' ).data( 'filter' );

							if ( $posts ) {
								// Loop through the newly loaded posts
								$posts.each( function() {
									$post = jQuery( this );

									// Check if one of the new posts has the class of a still hidden filter
									if ( $post.hasClass( $filter_name.substr( 1 ) ) ) {
										if ( $filter.hasClass( 'fusion-hidden' ) ) {


											if ( ! Modernizr.mq( 'only screen and (max-width: 800px)' ) ) {
												// Animate the filter to make it visible
												var $filter_width = $filter.css( 'width' ),
													$filter_margin_right = $filter.css( 'margin-right' );

												$filter.css( 'width', 0 );
												$filter.css( 'margin-right', 0 );
												$filter.removeClass( 'fusion-hidden' );

												$filter.animate({
													'width' : $filter_width,
													'margin-right' : $filter_margin_right
												}, 400, function() {
													// Finally remove animation style values
													$filter.removeAttr( 'style');
												});
											} else {
												$filter.fadeIn( 400, function() {
													$filter.removeClass( 'fusion-hidden' );
												});
											}
										}
									}
								});
							}
						});
					}

					// Check if filters are displayed
				 	if ( jQuery( '.fusion-filters' ).length ) {
						// Display new posts based on filter selection
						var $filter_active_element = jQuery( '.fusion-portfolio .fusion-filters' ).find( '.fusion-filter.fusion-active a' ),
							$filter_active = $filter_active_element.attr( 'data-filter' ).substr( 1 );

						// If active filter is not the "All" filter
						if ( $filter_active.length ) {
							// Show the new posts matching the active filter
							$posts.each( function() {
								var $post = jQuery( this ),
									$post_gallery_name = $post.find( '.fusion-rollover-gallery' ).data( 'rel' );

								if ( $post.hasClass( $filter_active ) ) {
									$post.fadeIn();

									// Set the lightbox gallery
									$post.find( '.fusion-rollover-gallery' ).attr( 'data-rel', $post_gallery_name.replace( 'gallery', $filter_active ) );
								}
							});

							// Check if we need to create a new gallery
							if ( $filter_active_element.data( 'lightbox' ) != 'created' ) {

								// Create new lightbox instance for the new gallery
								$il_instances.push( jQuery( '[data-rel^="iLightbox[' + $filter_active + ']"]' ).iLightBox( $avada_lightbox.prepare_options( 'iLightbox[' + $filter_active + ']' ) ) );

								// Set active filter to lightbox created
								$filter_active_element.data( 'lightbox', 'created' );
							}

							// Refresh the lightbox, needed in any case
							$avada_lightbox.refresh_lightbox();

						} else {
							$posts.fadeIn();
						}
					} else {
						$posts.fadeIn();
					}

					// Trigger isotope for correct positioning
					$infinte_scroll_container.isotope( 'appended', $posts );

					// Trigger fitvids
					$posts.each(function() {
						jQuery( this ).find( '.full-video, .video-shortcode, .wooslider .slide-content' ).fitVids();
					});

					// Refresh the scrollspy script for one page layouts
					jQuery( '[data-spy="scroll"]' ).each(function () {
						  var $spy = jQuery( this ).scrollspy( 'refresh' );
					});

					// Hide the load more button, if the currently loaded page is already the last page
					$current_page = $infinte_scroll_container.find( '.current' ).html();
					$infinte_scroll_container.find( '.current' ).remove();

					if ( $infinte_scroll_container.data( 'pages' ) == $current_page ) {
						$infinte_scroll_container.parent().find( '.fusion-loading-container' ).hide();
						$infinte_scroll_container.parent().find( '.fusion-load-more-button' ).hide();
					}
				});
			}
		});

		// Hide the load more button, if there is only one page
		if ( $infinte_scroll_container.data( 'pages' ) == '1' ) {
			$infinte_scroll_container.parent().find( '.fusion-loading-container' ).hide();
			$infinte_scroll_container.parent().find( '.fusion-load-more-button' ).hide();
		}

		// Setup infinite scroll manual loading
		if ( js_local_vars.portfolio_pagination_type == 'load_more_button' ) {
			$infinte_scroll_container.infinitescroll( 'unbind' );

			jQuery( '.fusion-portfolio' ).find( '.fusion-load-more-button' ).on( 'click', function(e) {
				e.preventDefault();

				// Use the retrieve method to get the next set of posts
				$infinte_scroll_container.infinitescroll( 'retrieve' );

				// Trigger isotope for correct positioning
				$infinte_scroll_container.isotope();
			});
		}
	}
});