jQuery(document).ready(function( $ ) {

		//Flexslider
		function flex() {
			$('.flexslider').flexslider({
				animation: "fade",
				animationSpeed: 150
			});

			$(".flex-next").html('<i class="fa fa-chevron-right"></i>');
			$(".flex-prev").html('<i class="fa fa-chevron-left"></i>');
		}
		flex();


		//Fitvid
		function fitvids() {
			$("article iframe").not(".fitvid iframe").wrap("<div class='fitvid'/>");
			$(".fitvid").fitVids();
		}
		fitvids();


		//Infinite Scroll
		if ((custom_js_vars.infinite_scroll) == 'disabled') { } else {
			$('.posts').infinitescroll({
			      loading: {
			          msgText: "...loading more posts...",
			          finishedMsg: "- All posts loaded -"
			      },
			      nextSelector: '.post-nav-right a',
			      navSelector: '.post-nav',
			      itemSelector: 'article',
			      contentSelector: '.posts',
			      appendCallback: true
			},function () { fitvids(); flex(); });
		}


		//Replace Scrollbars
		enquire.register("screen and (min-width: 1024px)", function() {

	        $('.nano').toggleClass('overthrow navigation-content');

	        $(".navigation-content").nanoScroller({
		    	contentClass: 'navigation-inner',
		    	preventPageScrolling: 'true',
		    });

	    }).listen();

	    enquire.register("screen and (max-width: 1024px)", function() {
	        $('.nano').removeClass('overthrow navigation-content');
	    }).listen();


	    //Menu Toggle
		$(".menu-toggle").click(function() {
		  $(".header-nav, .header .widgets").slideToggle(100);
		  return false;
		});

		$( window ).resize( function() {
			var browserWidth = $( window ).width();

			if ( browserWidth > 1024 ) {
				$(".header-nav, .header .widgets").show();
			}
		} );

});