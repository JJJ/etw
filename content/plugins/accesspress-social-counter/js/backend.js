(function ($) {
    $(function () {
	   //All the backend js for the plugin 
       
       /*
       Settings Tabs Switching 
       */
       $('.apsc-tabs-trigger').click(function(){
        $('.apsc-tabs-trigger').removeClass('apsc-active-tab');
        $(this).addClass('apsc-active-tab');
        var board_id = 'apsc-board-'+$(this).attr('id');
        $('.apsc-boards-tabs').hide();
        $('#'+board_id).show();
       });
       
       /**
        * For sortable 
        */
       $('.apsc-sortable').sortable({containment: "parent"});
       
	   
	});
}(jQuery));
