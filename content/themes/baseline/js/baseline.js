(function($) {
	"use strict";

	$(document).ready(function() {

		$('.post').fitVids();

		// Close the featured post drawer if it's open
		function closeDrawer() {
			$('.category-drawer').removeClass('drawer-open');
			$('.browse-toggle').removeClass('browse-active');
			$('html').removeClass('no-scroll');
        }

        // Close the menu if it's open
		function closeMenu() {
			$('html').removeClass('slideout-open');
			$('.menu-toggle').removeClass('menu-active');
        }

		// Menu toggle
		$('.menu-toggle').click(function(e) {
			closeDrawer();
            $('html').toggleClass('slideout-open');
            $(this).toggleClass('menu-active');
			return false;
		});

		// Post drawer toggle
		$('.browse-toggle').click(function(e) {
			closeMenu();
			$('.category-drawer').toggleClass('drawer-open');
			$(this).toggleClass('browse-active');
			$('html').toggleClass('no-scroll');
			return false;
		});

		// Close the drawer with the escape key
		$(window).keydown(function(e){
			if (e.keyCode == 27) {
				closeDrawer();
				closeMenu();
			}
		});

		// Close the drawer on body click
		$('html').click(function() {
			closeDrawer();
			closeMenu();
		});

		// Allow clicking in the drawer when it's open
		$('.category-drawer,.slideout-menu').click(function(event){
		    event.stopPropagation();
		});

		// Remove fancy underline from linked images
		$('.entry-content img').each(function() {
			$(this).parent().addClass('no-underline');
		});


		// Standardize drop menu types
		$('.sidebar-navigation .children').addClass('sub-menu');
		$('.sidebar-navigation .page_item_has_children').addClass('menu-item-has-children');

		// Append a clickable icon to mobile drop menus
		var item = $('<span class="toggle-sub"><i class="fa fa-angle-down"></i></span>');
		$('.slideout-menu .menu-item-has-children,.slideout-menu .page_item_has_children').prepend(item);

		// Change the icon to angle up on toggle
		$('.slideout-menu .toggle-sub').click(function() {
			$(this).find('i').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
			var dropopen = $(this).closest('.menu-item-has-children').toggleClass('drop-open');
		});


		// Headroom fixed nav bar
		$('.fixed-nav').headroom({
		    offset : 200,
		    tolerance : 10
		});


		// Fade in the images as they load
		function fade_images() {
			$('.gallery-wrapper .gallery-thumb').each(function(i) {
				var row = $(this);
				setTimeout(function() {
					row.addClass('fadeInUp');
				}, 90*i)
			});
		}


		// Masonry blocks
		var $blocks = $('.two-column .gallery-wrapper,.three-column .gallery-wrapper');

		$blocks.imagesLoaded( function() {
			$blocks.masonry({
				itemSelector: 'body:not(.one-column) .post',
				transitionDuration: 0
			});

			// Fade blocks in after images are ready
			fade_images();
		});


		// Resize masonry blocks on window resize
		$(window).resize(function() {
			$blocks.masonry();
		});


		// Layout posts that arrive via infinite scroll
		$(document.body ).on('post-load', function() {
			var $newItems = $('.new-infinite-posts').not('.is--replaced');
			var $elements = $newItems.find('.post');
			$elements.hide();
			$blocks.append($elements);

			$blocks.imagesLoaded( function() {
				$blocks.masonry('appended', $elements, true ).masonry('reloadItems').masonry('layout');
				$elements.show();
				fade_images();
				$('#infinite-handle').show();
			});
		});


		// Add padding to footer to smooth out infinite scroll
		$('body').on('click', '#infinite-handle', function() {
		    $('.site-footer').addClass('footer-padding').delay(1500).queue(function(){
			    $(this).removeClass('footer-padding').dequeue();
			});
		});


		// Show the initial IS handle
		$('#infinite-handle').show();


		// Fade out the featured post container while loading
		$('.sort-list a').click(function(e) {
			$('.post-container').addClass('post-loading');
		});


		// Close the sort list to show posts on mobile
		$(window).on('load', function() {
			var current_width = $(window).width();

		    // If width is below iPad size
		    if (current_width < 769) {
		    	$('.sort-list a').click(function(e) {
					setTimeout(function() {
						$('.sort-list').slideUp();
					}, 400)
				});
		    }
		});


		// Sort list toggle
		$('.sort-list-toggle').click(function(e) {
			$('.sort-list').slideToggle();
			return false;
		});


		// Fetch ajax posts for category menu in the header
		var header_drawer = $('#category-menu a');

		header_drawer.click(function (event) {

			var cat_link = $(this).attr('data-object-id');

			if (typeof cat_link !== typeof undefined && cat_link !== false) {

				event.preventDefault();

				var id        = $(this).attr('data-object-id');
				var container = $('.header-drawer .post-container');
				var catHeader = $('.header-drawer .featured-header-category');

				var data = {
					action: 'baseline_category',
					id: id
				}

				// Fade out the featured post container while loading
				$('.header-drawer .post-container').addClass('post-loading');

				$.ajax({
					data: data,
					type: "POST",
					dataType: "json",
					url: baseline_js_vars.ajaxurl,
					success: function(response) {
						container.html(response.html);
						catHeader.html(response.term_html);
						$('.post-container').removeClass('post-loading');
					},
					error: function(response) {
						container.html(response.html);
					}
				});

				$(this).parent().siblings().removeClass('current-menu-item');
				$(this).parent().addClass('current-menu-item');
			}
		});


		// Fetch ajax posts for footer category menu in the footer
		var footer_drawer = $('#footer-category-menu a');

		footer_drawer.click(function (event) {

			var cat_link = $(this).attr('data-object-id');

			if (typeof cat_link !== typeof undefined && cat_link !== false) {

				event.preventDefault();

				var id        = $(this).attr('data-object-id');
				var container = $('.footer-drawer .post-container');
				var catHeader = $('.footer-drawer .featured-header-category');

				var data = {
					action: 'baseline_category',
					id: id
				}

				// Fade out the featured post container while loading
				$('.footer-drawer .post-container').addClass('post-loading');

				$.ajax({
					data: data,
					type: "POST",
					dataType: "json",
					url: baseline_js_vars.ajaxurl,
					success: function(response) {
						container.html(response.html);
						catHeader.html(response.term_html);
						$('.post-container').removeClass('post-loading');
					},
					error: function(response) {
						container.html(response.html);
					}
				});

				$(this).parent().siblings().removeClass('current-menu-item');
				$(this).parent().addClass('current-menu-item');
			}
		});


		// Click the first category link to use as a placeholder
		$('.sort-list li:first-child a').click();


		// Initialize responsive slides
		var $slides = $('.featured-content .featured-slides');
		$slides.responsiveSlides({
		    auto: false,
		    speed: 200,
		    nav: true,
		    navContainer: ".slide-navs",
		    pager: true,
		    manualControls: "#pager-navs"
		});


		// Next ResponsiveSlide
		$('.arrow-link.prev').click(function(e) {
			$(this).closest('.featured-content').find('.rslides_nav.prev').click();
		});

		// Next ResponsiveSlide
		$('.arrow-link.next').click(function(e) {
			$(this).closest('.featured-content').find('.rslides_nav.next').click();
		});


		// Allow clicking anywhere in post nav to navigate
		$('.nav-post').click(function() {
			window.location = $(this).find('a').attr('href');
			return false;
		});
	});

})(jQuery);
