(function($) {

	$(document).ready(function() {

		// Fitvids
		$(".post").fitVids();

		// Remove fancy underline from linked images
		$('.entry-content img').each(function() {
			$(this).parent().addClass('no-underline');
		});


		// Selectors for mobile toggle
		toggle_selectors = $('.main-navigation, .mobile-overlay, body');


		// Standardize drop menu types
		$('.main-navigation .children').addClass('sub-menu');
		$('.main-navigation .page_item_has_children').addClass('menu-item-has-children');


		// Mobile menu toggle
		$('.menu-toggle, .menu-close').click(function(e) {
			toggle_selectors.toggleClass('mobile-active');
			return false;
		} );


		// When menu is open, allow click on body to close
		$('html').click(function() {
			toggle_selectors.removeClass('mobile-active');
			$('.sub-menu').removeClass('drop-active');
			$('.toggle-sub i').removeClass('fa-angle-up').addClass('fa-angle-down');
		});


		// Allow clicking in the overlay when it's open
		$('.mobile-overlay').click(function(event){
		    event.stopPropagation();
		});


		// Append a clickable icon to mobile drop menus
		var item = $('<span class="toggle-sub"><i class="fa fa-angle-down"></i></span>');
		$('.menu-item-has-children,.page_item_has_children').append(item);


		// Toggle the mobile drop menu on click
		$('.mobile-active .menu-item-has-children .toggle-sub,.widget-area .menu-item-has-children .toggle-sub').click(function(e) {
			$(this).each(function() {
				$(this).prev('.sub-menu').toggle();
			});
		});


		// Change the icon to angle up on toggle
		$('.toggle-sub').click(function() {
			$(this).find('i').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
			var dropopen = $(this).closest('.menu-item-has-children').toggleClass('drop-open');
		});


		// Toggle the desktop drop menu on click
		$('.menu-item-has-children:not(.drop-open) .toggle-sub').click(function(e) {
			$(this).prev('.sub-menu').toggleClass('drop-active');
		});


		$('.drop-open .toggle-sub').click(function(e) {
			$(this).prev('.sub-menu').removeClass('drop-active');
		});


		// Allow clicking in sub nav when it's open
		$('.sub-menu').click(function(event){
		    event.stopPropagation();
		});


		// Detect window width and execute responsive functions
		$(window).on('resize load', function() {
			var current_width = $(window).width();

			// If width is above iPad size
			if(current_width > 769) {
				toggle_selectors.removeClass('mobile-active');
			}
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
		var $blocks = $('.gallery-wrapper');

		$blocks.imagesLoaded( function() {
			$blocks.masonry({
				itemSelector: '.post',
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

		// Mobile menu toggle
		$('.back-to-top').click(function(e) {
			$('html,body').animate({
                scrollTop: $('body').offset().top
            }, 800);
			return false;
		} );

	});

})(jQuery);
