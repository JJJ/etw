//Handle the file uploads
jQuery(document).ready(function($) {
  'use strict';

  /**
   * Function called when the File upload button is called
   * We upload the files before we submit the forms
   */
  function tco_woo_file_upload(){
    $(document).on('click', 'button.tco_woo_file_upload', function(e) {
      e.preventDefault();
      var sending = false;
      var $inputFile = $(this).prev();
      var $button = $(this);
      $inputFile.click();
      $inputFile.on('change', function() {
        if(!sending){
          var data = new FormData();
          var id = $(this).attr('id');
          var $loading = $('#'+id+'_loading');
          var $ok = $('#'+id+'_ok');
          $loading.attr('src', tco_woo_js.loading_image).attr('alt', tco_woo_js.processing);

          data.append('action', 'tco_woo_handle_file_upload');
          data.append('security', $(id+'_secret').val());
          data.append('tco_woo_file', $(this).prop('files')[0]);

          $.ajax({
            type: 'POST',
            processData: false, // important
            contentType: false, // important
            data: data,
            url: tco_woo_js.ajaxurl,
            success: function(jsonData) {
              if( jsonData.error ) {
                return false;
              }
              $button.hide();
              $loading.show();
              $loading.fadeOut(2000, function() {
                $button.fadeIn('fast');
                if(!jsonData.error){
                  $('#'+id+'_file').val(jsonData.url);
                }
                $inputFile.hide();
                $ok.show();
                $ok.fadeOut(2000, function() { });
              });
              $inputFile.hide();
            },
            error : function(){
              $loading.fadeOut(2000, function() {
                $button.fadeIn('fast');
              });
              alert(tco_woo_js.error);
            }
          });
        }
        sending = true;
      });
    });
  }

  tco_woo_file_upload(); //Call put function

});
