jQuery(document).ready(function( $ ) { 

		// Menu Toggle
		$(".menu-toggle").click(function() { 
			$(".menu-toggle").toggleClass("menu-toggle-active");
			$(".main-menu").slideToggle(100);
			return false;
		});

		// Fitvids
		$("iframe,object").wrap( "<div class='fitvid'></div>" );
		$(".fitvid").fitVids();

		// Backstretch
		if ( (transmit_custom_js_vars.bg_image_url) ) {
			$("body").backstretch( transmit_custom_js_vars.bg_image_url, { speed: 200 } );
		}
		
});