jQuery(document).ready(function( $ ) {
	//Add JS class to html
	$("html").addClass("js");

	//FitVids
	$(".post-content iframe").wrap("<div class='fitvid'/>");
	$(".fitvid,iframe").fitVids();

    //Device Class
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
       $("body").addClass("device");
    }

    //View Lightbox
    $(".slides li a").addClass("view");
    $(".slides li a").attr('rel', 'lightbox');

    // Responsive navigation
	$(".nav-toggle").click(function(){
		$("#menu-canvas").toggleClass("active");
		$(".container").toggleClass("active");
		$("#menu-canvas .nav").show();
	});

	$(window).on("resize load", function () {
		var current_width = $(window).width();

		if(current_width < 769){
			$(".header-wrap .header-nav").appendTo("#menu-canvas");
		}

		if(current_width > 769){
			$(".header-nav").appendTo(".header");
			$("#menu-canvas.active").toggleClass("active");
			$(".container.active").toggleClass("active");
		}
	});
});
