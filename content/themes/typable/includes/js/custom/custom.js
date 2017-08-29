jQuery(document).ready(function( $ ) {

	// Start AJAX magic, if enabled
	if ( ( custom_js_vars.toggle_ajax ) != 'disabled' ) {

		// Establish Variables
		var History = window.History,
		State 		= History.getState(),
		$log 		= $('#log'),
		loading 	= false,
		$loader 	= $('.icon-nav'),
		getContent, loadAjax, doSearch;

		// Push the requested page url and title to History if a user asks for a new page
		getContent = function(element, title){
			if ( loading === false ) {
				var path = element.attr('href');
				History.pushState('ajax',title,path);
			}
	    return false;
		};

		// Get the title of the link for the page title
		$('body').on('click', '.next-prev a, .entry-title a, .excerpt-link, .archive-box a, .nav a, #archive-list a, #nav-list a, .featured-image', function() {
			getContent( $(this), $(this).attr("title") );
	    return false;
		});

		// Add title attribute to links that don't have it.
		function post_nav_title() {
			$('.next-prev a, .nav a').each(function() {
				var linktitle = $(this).html();
				$(this).prop('title', linktitle);
			});
		}
		post_nav_title();

		// Bind to state change

		// When the statechange happens, load the appropriate url via ajax
		History.Adapter.bind(window,'statechange',function() {
	    	loadAjax();
		});

		// Load content with ajax using pushed history state
		loadAjax = function() {
	    	loading = true;
			$loader.prepend('<i class="fa fa-spinner"></i>');

			State = History.getState();

			$(".fa-spinner").fadeIn();
			$(".posts").fadeTo(200,.3);

			var stateURL = encodeURI(State.url);

			$("#main").load(stateURL + ' #main', function(data) {
			    // This code will be run once the ajax page has loaded. Place your scripts here to be run after the AJAX page loads.

			    // Reset page elements now that content has loaded
			    $(".posts").fadeTo(200,1);
			    $(".fa-spinner").fadeOut();
			    $(".fa-spinner").remove();
			    $(".icon-nav a").removeClass("active");
			    $("#archive-toggle").removeClass("open-folder");
			    $("body").removeClass('body-header-open');
			    $(".header").removeClass('header-open');
			    $("#searchform,#nav-list,#archive-list,#widget-drawer").slideUp();

			    // Scroll to the top of the page
			    $("html, body").animate({
			      scrollTop: $("body").offset().top
			    }, 500);

			    // Rerun Fitvid
			    $(".post").fitVids();

			    // If user has Disqus enabled comments, load the Disqus scripts on post load.
			    if ( ( custom_js_vars.disqus ) == 'enabled' ) {
				    (function() {
						var dsq = document.createElement('script');
						dsq.type = 'text/javascript'; dsq.async = true;
						dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					})();
		      	}

		      	twttr.widgets.load();

			    // Run post nav title function
			    post_nav_title();

			    // Loading is complete. It's now safe to load again.
			    loading = false;
			});
		}

		// AJAX Search
		doSearch = function(){
			var searchTerm = $('.search-form-input').val();

			if (searchTerm != WPLANG['type_your_search'] && loading === false){
			  var searchTerm = encodeURIComponent(searchTerm);
			  var searchPath = WPCONFIG['site_url'] + '?s=' + searchTerm;

			  History.pushState('ajax', 'Search results', searchPath);
			}
		};

		// Search via ajax on form submission
		$(".search-form").submit( function(e){
			e.preventDefault();
			doSearch();
		});

		// Also search upon input field blur.
		// This triggers search if iOS users tap "Done"
		// instead of "Go", which they may well do.
		$(".search-form-input").blur( function(e){
			doSearch();
		});

	} // end AJAX magic


	// Icon Nav
	$(".icon-nav a").click(function(){
		$(this).toggleClass('active');
		$(".icon-nav a").not(this).removeClass();

	    return false;
	});

	// Search Toggle
	$("#searchform").hide();
	$(".search-toggle").click(function() {
		$("#archive-list,#nav-list,#widget-drawer").slideUp(150);
		$("#searchform").slideToggle(150);
    	$(".header").removeClass('header-open');
    	$(".search-form-input").val(WPLANG['type_your_search']);
		return false;
	});

	// Archive TToggle
	$("#archive-list").hide();
	$("#archive-toggle").click(function () {
		$("#archive-toggle").toggleClass("open-folder");
		$("#searchform,#nav-list,#widget-drawer").slideUp(150);
		$("#archive-list").slideToggle(150);
		return false;
	});

	// Widget Toggle
	$("#widget-drawer").hide();
	$(".drawer-toggle").click(function () {
		$("#searchform,#nav-list,#archive-list").slideUp(150);
		$("#widget-drawer").slideToggle(150);
		$(".fa-folder").removeClass('fa-folder-open');
		return false;
	});

	// Nav Toggle
	$("#nav-list").hide();
	$(".nav-toggle").click(function () {
		$("#searchform,#archive-list,#widget-drawer").slideUp(150);
		$("#nav-list").slideToggle(150);
		$(".fa-folder").removeClass('fa-folder-open');
		return false;
	});

	//FitVids
	$(".post").fitVids();

});