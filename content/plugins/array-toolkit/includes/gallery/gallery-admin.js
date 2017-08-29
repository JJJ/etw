 jQuery(document).ready(function( $ ) {
 	function checkPostFormat() {
	  if($('#post-format-gallery').is(":checked")) {
	     $('#array_gallery_meta_box').css('display', 'block');
	  } else {
	  	$('#array_gallery_meta_box').css('display', 'none');
	  }
	}
	checkPostFormat();
  $(".post-format").change(function () {
		checkPostFormat();
	});
	if ($(".array-gallery-thumbs").html()){
		$("#array-gallery-button").html("Edit Gallery").removeClass('button-primary');
	}	else {
		$("#array-gallery-button").html("Add Gallery").addClass('button-primary');
	}
});
