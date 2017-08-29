(function($) {
	"use strict";

	$(document).ready(function() {

        $(window).on('load', function() {
            var current_width = $(window).width();

			// Only run on desktop
            if ( current_width > 768 ) {

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
		function fitVids() {
			$('.post,.featured-image').fitVids();
		}
		fitVids();


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
			var $container = $('#post-wrap');
			var $newItems  = $('.new-infinite-posts').not('.is--replaced');
			var $elements  = $newItems.find('.post');

			// Remove the empty elements that break the grid
			$('.new-infinite-posts,.infinite-loader').remove();

			// Append IS posts
			$container.append($elements);

			// Run fitvids on newly arrived posts
			fitVids();
		});


		// Create the sticky nav bar if we're on the single page
		if ($('.single .header-text h1')[0]){
			var section_single = $('#page').offset().top;

			// Show the nav bar when we get to the post title
			$(window).scroll(function() {
				if($(window).scrollTop() > section_single) {
					$('.home-nav').addClass('show-nav');
				} else {
					$('.home-nav').removeClass('show-nav');
				}
			});
		}


		// Move the carousel gallery on portfolio items
		$('.jetpack-portfolio-template-template-portfolio-center-carousel .gallery:first-of-type').addClass('first-gallery').insertBefore('#page');
		$('.jetpack-portfolio-template-template-portfolio-center-carousel .carousel-navs').insertBefore('#page');


		// Carousel slider
		var carousel = $('.section-portfolio-carousel,.jetpack-portfolio-template-template-portfolio-center-carousel .first-gallery')
		.slick({
			centerMode: true,
		    slidesToShow: 2,
			arrows: false,
			initialSlide: 1,
		    responsive: [
		      {
		        breakpoint: 768,
		        settings: {
		          arrows: false,
		          centerMode: true,
		          slidesToShow: 1
		        }
		      },
		      {
		        breakpoint: 480,
		        settings: {
		          arrows: false,
		          centerMode: true,
		          slidesToShow: 1
		        }
		      }
		    ]
	    });


		// Hide carousel navs if not needed
		var slidecount = $('.slick-slide').length;
		if (slidecount < 3) {
			$('.page-template-template-portfolio-carousel #page,.jetpack-portfolio-template-template-portfolio-center-carousel').addClass('no-navs');
		}


		// Carousel navigations
		$('.carousel-prev').click(function(){
			carousel.slick('slickPrev');
		});

		$('.carousel-next').click(function(){
			carousel.slick('slickNext');
		});

		// Bind carousel navigations to keys
		$(document).keydown(function(e){
		    if (e.keyCode == 37) {
		       carousel.slick('slickPrev');
		       return false;
		    }
		});

		$(document).keydown(function(e){
		    if (e.keyCode == 39) {
		       carousel.slick('slickNext');
		       return false;
		    }
		});


		// Provide IE fallback for object fit
		if ( ! Modernizr.objectfit ) {
			$('.portfolio-block-left').each(function () {
				var $container = $(this),
				imgUrl = $container.find('img').prop('src');

				if (imgUrl) {
					$container
					.css('backgroundImage', 'url(' + imgUrl + ')')
					.addClass('compat-object-fit');
				}
			});
		}

		$('.jetpack-portfolio-template-template-portfolio-center-carousel .post,.jetpack-portfolio-template-template-portfolio-center-carousel .carousel-navs').fadeTo( "fast", 1 );

		// Masonry blocks
		var $blocks = $('.section-portfolio-masonry');

		$blocks.imagesLoaded( function() {
			$blocks.masonry({
				itemSelector: '.post',
				transitionDuration: 0
			});
		});


		// Resize masonry blocks on window resize
		$(window).resize(function() {
			$blocks.masonry();
		});

	});

})(jQuery);
