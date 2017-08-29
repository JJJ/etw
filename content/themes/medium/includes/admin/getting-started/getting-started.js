jQuery(document).ready(function ($) {

	//Tabs
	$('.inline-list-links').each(function() {
		$(this).find('li').each(function(i) {
			$(this).click(function(){
				$(this).addClass('current').siblings().removeClass('current')
				.parents('#wpbody').find('div.panel').hide().end().find('div.panel:eq('+i+')').fadeIn(150);
				return false;
			});
		});
	});

	// Show license tab after settings saved
	if(window.location.href.indexOf("settings-updated=true") > -1) {
		$('.inline-list-links li').removeClass('current');
		$('.panel').hide();

		$('.license-tab').addClass('current');
		$('#license-panel').show();

		$('html, body').animate({
	        scrollTop: $(".panels").offset().top
	    }, 300);
	}

});