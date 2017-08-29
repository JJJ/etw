(function($) {
	"use strict";

	$(document).ready(function() {

		// Equalize column heights
		function equalHeight() {
			$('.section-team .post,.section-portfolio .post,.section-services .post,.section-blog .post,.woocommerce .products li').matchHeight();
		}

        $(window).on('load', function() {
            var current_width = $(window).width();

			// Only run on desktop
            if ( current_width > 768 ) {
				equalHeight();

				// Recalculate the Woo column height after item is added to cart
				$( document.body ).on( 'added_to_cart', function(){
					$('.woocommerce .products li').matchHeight();
				});

				// Find menu items with a drop menu and center them
		        $('.main-navigation li').each(function() {
		            if ($(this).find('ul:first-of-type').length > 0) {
		                var parent_width = $(this).outerWidth(true);
		                var child_width  = $(this).find('ul').outerWidth(true);
		                var new_width    = parseInt((child_width - parent_width) / 2);
		                $(this).find('ul').css('margin-left', -new_width + 'px');
		            }
		        });
        	}
        });


		// Standardize drop menu types
		$('.main-navigation .children').addClass('sub-menu');
		$('.main-navigation .page_item_has_children').addClass('menu-item-has-children');


		// Toggle the mobile menu
		$('.menu-toggle').click(function() {
			$('.mobile-navigation').toggleClass('toggle-active');
			$('.drawer').toggle();
			$(this).find('span').toggle();
		});

		// Append a clickable icon to mobile drop menus
		var item = $('<button class="toggle-sub" aria-expanded="false"><i class="fa fa-angle-down"></i></button>');

		// Append clickable icon for mobile drop menu
		if ($('.drawer .menu-item-has-children .toggle-sub').length == 0) {
			$('.drawer .menu-item-has-children,.drawer .page_item_has_children').append(item);
		}

		// Show sub menu when toggle is clicked
		$('.drawer .menu-item-has-children .toggle-sub').click(function(e) {
			$(this).each(function() {
				e.preventDefault();

				// Change aria expanded value
				$(this).attr('aria-expanded', ($(this).attr('aria-expanded')=='false') ? 'true':'false');

				// Open the drop menu
				$(this).closest('.menu-item-has-children').toggleClass('drop-open');
				$(this).prev('.sub-menu').toggleClass('drop-active');

				// Change the toggle icon
				$(this).find('i').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
			});
		});


		// Fitvids
        $('.post,.featured-image').fitVids();


		// Add a page loaded class
		$(window).bind('load', function() {
			$('body').addClass('page-loaded');
		});


		// Comments toggle
		$('.comments-toggle').click(function(e) {
			$('.comment-list,.comment-respond').slideToggle(400);
			return false;
		});


		// Scroll to comment on direct link
		if (document.location.href.indexOf('#comment') > -1) {
			// Grab the comment ID from the url
			var commentID = window.location.hash.substr(1);

			// Show the comment form
			$('.comment-list,.comment-respond').show();
		}


		// Scroll back to top
		$('.back-to-top a, .sticky-title').click(function(e) {
			e.preventDefault();

			$('html,body').animate({
			    scrollTop: 0
			}, 700);

			return false;
		} );


		// Infinite scroll
		$(document.body).on('post-load', function () {
			var $container = $('#page .index-posts');
			var $newItems  = $('.new-infinite-posts').not('.is--replaced');
			var $elements  = $newItems.find('.post');

			// Remove the empty elements that break the grid
			$('.new-infinite-posts,.infinite-loader').remove();

			// Append IS posts
			$container.append($elements);
		});


		// Create homepage section nav
		function create_home_menu() {
			// Add the markup for the homepage nav
			$('body.page-template-template-homepage').prepend('<nav class="home-nav"><ul></ul></nav>');

			// Create the homepage nav items
			$('.home-section .content-left h2').each(function() {
				$('.home-nav ul').append($('<li/>', { text: $(this).text() }));
			});

			$('.home-nav li').each(function(i) {
				$(this).append('<a href="#panel'+(i+1)+'">'+$(this).html()+'</a>');
				$(this).contents().filter(function () {
				     return this.nodeType === 3;
				}).remove();
			});

			// Scroll to homepage sections upon click
			$(document).on('click', '.home-nav a', function(event){
				event.preventDefault();

				// Calculate the top padding
				var top_padding = $('.home-section').css('padding-top').replace('px', '');

				$('html, body').animate({
					scrollTop: $($.attr(this,'href')).offset().top - top_padding + 2
				}, 500);
			});

			// Define the homepage and nav sections
			var sections = $('.home-section'),
				nav      = $('.home-nav');

			$(window).scroll(function() {
				// Highlight active homepage section when reached
				var cur_pos = $(this).scrollTop();

				sections.each(function() {

					// Calculate position and padding
					var top_padding = $('.home-section').css('padding-top').replace('px', '');
					var top        = $(this).offset().top - top_padding - 1;
					var bottom     = top + $(this).outerHeight();

					// Add and remove active class based on scroll position
					if (cur_pos >= top && cur_pos <= bottom) {
						nav.find('a').removeClass('active');
						sections.removeClass('active');
						$(this).addClass('active');
						nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
					}
				});
			});
		}


		// Create the sticky nav bar if homepage sections exist
		if ($('.home .home-section')[0]){
			create_home_menu();

			// Calculate the top padding of the home section
			var top_padding       = $('.home-section:first-child').css('padding-top').replace('px', '');
			var section_container = $('.site-main').offset().top - top_padding - 1;

			// Show the nav bar when we get to the homepage sections
			$(window).scroll(function() {
				if($(window).scrollTop() > section_container) {
					$('.home-nav').addClass('show-nav');
				} else {
					$('.home-nav').removeClass('show-nav');
				}
			});
		}


		// Create the sticky nav bar if we're on the single page
		if ($('.single .entry-byline')[0]){
			var title_height   = $('.entry-title').outerHeight();
			var section_single = $('.entry-byline').offset().top -title_height;

			// Show the nav bar when we get to the post title
			$(window).scroll(function() {
				if($(window).scrollTop() > section_single) {
					$('.home-nav').addClass('show-nav');
				} else {
					$('.home-nav').removeClass('show-nav');
				}
			});
		}

		// Center main navigation drop down on desktop
        $(window).on('load', function() {
            var current_width = $(window).width();

			// Only run on tablet and mobile
            if ( current_width < 768 ) {
				// Initialize responsive slides
				var $slides = $('.featured-post-container');
				$slides.responsiveSlides({
				    auto: false,
				    speed: 200,
				    nav: true,
				    navContainer: ".slide-navs",
				});

				// Add touch support to responsive slides
				$('.rslides').each(function() {
				    $(this).swipe({
					swipeLeft: function() {
					    $(this).parent().find('.rslides_nav.prev').click();
					},
					swipeRight: function() {
					    $(this).parent().find('.rslides_nav.next').click();
					}
				    });
				});
        	}
        });


		// Mobile toggle for Woo sidebar
		$('.woo-expand').click(function() {
			$(this).toggleClass('woo-expand-open');
			$(this).find('span').toggle();
			$('.shop-sidebar').toggle();
		} );

	});

})(jQuery);
