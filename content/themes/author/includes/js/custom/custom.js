jQuery(document).ready(function( $ ) {

		//Flex Slider
		$('.flexslider').flexslider({
			controlNav: false,
			slideshow: false,
			animationSpeed: 100
		});

	    $('.ribbon').fadeIn();


		//Menu Toggle
		$(".menu-toggle").click(function() {
		  $(".main-nav,.secondary-menu").slideToggle(100);
		  return false;
		});

		$( window ).resize( function() {
			var browserWidth = $( window ).width();

			if ( browserWidth > 768 ) {
				$(".main-nav,.secondary-menu").show();
			}
		} );


		//FitVids
		$(".post-content iframe").wrap("<div class='fitvid'/>");
		$(".arrayvideo,.fitvid").fitVids();

});