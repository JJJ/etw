/**
 * tco_woo_checkout admin Javascript
 * 
 * @since 1.0.0
 */
var tco_woo_checkout = {

    /**
     *  Add a new row. We copy the hidden field and append it to the table
     */
    add_checkout_element : function(){
        var tco_woo_item_count = jQuery('#tco_woo_item_count').val();
        var newRow = jQuery('div.tco_woo_append_row script[type="tco_woo_checkout_row"]').clone();
        newRow.attr('id',tco_woo_item_count);
        newRow = newRow.html().replace(/CURRENTCOUNT/g,tco_woo_item_count);
        jQuery('.tco_woo_checkout_table tbody.sort-checkout').append(newRow);
        tco_woo_item_count++;
        jQuery('#tco_woo_item_count').val(tco_woo_item_count);
    },

    /**
     * Delete a custom input
     * 
     * @param elem - the element
     */
    delete_checkout_element : function(elem){
        jQuery(elem).parent().parent().remove();
    },

    /**
     *  Tabs Script
     */
    tabs : function(){
        jQuery('.tco_woo_checkout_fields ul.tabs').each(function(){
            // For each set of tabs, we want to keep track of
            // which tab is active and its associated content
            var $active, $content, $links = jQuery(this).find('a');

            // If the location.hash matches one of the links, use that as the active tab.
            // If no match is found, use the first link as the initial active tab.
            $active = jQuery($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
            $active.addClass('active');

            $content = jQuery($active[0].hash);

            // Hide the remaining content
            $links.not($active).each(function () {
                jQuery(this.hash).hide();
            });

            // Bind the click event handler
            jQuery(this).on('click', 'a', function(e){
                // Make the old tab inactive.
                $active.removeClass('active');
                $content.hide();

                // Update the variables with the new link and content
                $active = jQuery(this);
                $content = jQuery(this.hash);

                // Make the tab active.
                $active.addClass('active');
                $content.show();

                // Prevent the anchor's default click action
                e.preventDefault();
            });
        });

    },

    /**
     * Show the Settings Modal
     */
    init_settings : function(elem){
        var id = jQuery(elem).attr('data-id');
        var selected = jQuery('#field_validate_'+id).val();

        //Drop down seects
        if(selected == 'custom' ){
            jQuery('.custom_validation_form').show();
        }else{
            jQuery('.custom_validation_form').hide();
        }

        var cond_selected = jQuery('#field_conditional_'+id).val();
        if(cond_selected == 1){
            jQuery('.container_conditional_settings').show();
        }else{
            jQuery('.container_conditional_settings').hide();
        }
        

        jQuery('.condition_radio').prop('checked', false);
        
        jQuery("#tco_woo_options_validation_option option[value='" + selected + "']").prop("selected", true);
        jQuery("#tco_woo_options_conditional_option option[value='" + cond_selected + "']").prop("selected", true);


        jQuery('#tco_woo_options_modal_count_regex').val(id);
        jQuery('#tco_woo_options_modal_regex').val();
        jQuery('#tco_woo_options_modal_regex').val(jQuery('#field_regex_'+id).val());

        //Show all options
        jQuery("#tco_woo_options_modal_validation_field").children('option').show();

        //Check if the option is the same as our filed and hide it
        var option = jQuery(elem).attr('data-field');
        if (typeof option !== typeof undefined && option !== false) {
            jQuery("#tco_woo_options_modal_validation_field option[value=" + option + "]").hide();
        }
        

        jQuery("#tco_woo_options_modal_validation_field option:selected").prop("selected", false);

        var selected_id = jQuery('#field_validation_field_'+id).val();
        jQuery("#tco_woo_options_modal_validation_field option[value='" + selected_id + "']").prop("selected", true);
        
        
        var products_condition = jQuery('#field_products_condition_'+id).val();
        if(products_condition)
            jQuery('.container_conditional_settings #'+products_condition).prop('checked', true);
        else
            jQuery('.container_conditional_settings #or').prop('checked', true);

        jQuery('#tco_woo_options_modal_count_conditional').val(id);
        jQuery('#tco_woo_options_modal_accepted_value').val();
        jQuery('#tco_woo_options_modal_accepted_value').val(jQuery('#field_conditional_value_'+id).val());

        //Show all options
        jQuery("#tco_woo_options_modal_accepted_field").children('option').show();

        //Check if the option is the same as our filed and hide it
        var option = jQuery(elem).attr('data-field');
        if (typeof option !== typeof undefined && option !== false) {
            jQuery("#tco_woo_options_modal_accepted_field option[value=" + option + "]").hide();
        }
		
		//Clear selections
		jQuery("#tco_woo_options_modal_accepted_field option:selected").prop("selected", false);

        //Selected options marked in multiselect
        var fields = jQuery('#field_conditional_fields_'+id).val();
        jQuery.each(fields.split(","), function(i,e){
            jQuery("#tco_woo_options_modal_accepted_field option[value='" + e + "']").prop("selected", true);
        });

        var products_fields_validation = jQuery('#field_products_fields_validation_'+id).val();
        var fields_validation_second = jQuery('#field_products_fields_validation_second_'+id).val();

        
        jQuery("#product_validation_option option:selected").prop("selected", false);
        jQuery("#product_validation_option_second option:selected").prop("selected", false);

        jQuery("#product_validation_option option[value='" + products_fields_validation + "']").prop("selected", true);
        jQuery("#product_validation_option_second option[value='" + fields_validation_second + "']").prop("selected", true);

        jQuery("#product_validation_option_products option:selected").prop("selected", false);

        var fields = jQuery('#field_products_fields_'+id).val();
        jQuery.each(fields.split(","), function(i,e){
            jQuery("#product_validation_option_products option[value='" + e + "']").prop("selected", true);
        });

        jQuery("#product_validation_option_products_second option:selected").prop("selected", false);
        var fields = jQuery('#field_products_fields_second_'+id).val();
        jQuery.each(fields.split(","), function(i,e){
            jQuery("#product_validation_option_products_second option[value='" + e + "']").prop("selected", true);
        });


        jQuery(".chosen-select").trigger("chosen:updated");
        jQuery(".chosen-select").chosen({ width: "240px"});
        jQuery('#tco_woo_checkout-settings-dialog-form-dialog').modal({
            fadeDuration: 100,
        });
        return false;
    },

    /**
     * Save Settings
     */
    save_settings : function(){
        var id = jQuery('#tco_woo_options_modal_count_regex').val();
        //Save select options first
        jQuery('#field_validate_'+id).val(jQuery('#tco_woo_options_validation_option').val());
        jQuery('#field_conditional_'+id).val(jQuery('#tco_woo_options_conditional_option').val());


        jQuery('#field_regex_'+id).val(jQuery('#tco_woo_options_modal_regex').val());
        jQuery('#field_validation_field_'+id).val(jQuery('#tco_woo_options_modal_validation_field').val());

        

        //Save conditional options
        var id = jQuery('#tco_woo_options_modal_count_conditional').val();
        jQuery('#field_products_condition_'+id).val(jQuery('.condition_radio:checked').val());

        
        jQuery('#field_conditional_value_'+id).val(jQuery('#tco_woo_options_modal_accepted_value').val());
        var selected_options = jQuery.map(jQuery("#tco_woo_options_modal_accepted_field option:selected"), function (el, i) {
            return jQuery(el).val();
        });
        jQuery('#field_conditional_fields_'+id).val(selected_options.join(","));

        jQuery('#field_products_fields_validation_'+id).val(jQuery('#product_validation_option').val());
        jQuery('#field_products_fields_validation_second_'+id).val(jQuery('#product_validation_option_second').val());
        
        
        var selected_options = jQuery.map(jQuery("#product_validation_option_products option:selected"), function (el, i) {
            return jQuery(el).val();
        });
        jQuery('#field_products_fields_'+id).val(selected_options.join(","));

        var selected_options = jQuery.map(jQuery("#product_validation_option_products_second option:selected"), function (el, i) {
            return jQuery(el).val();
        });
        jQuery('#field_products_fields_second_'+id).val(selected_options.join(","));

        //Close Modal
        jQuery.modal.close();
    },



    /**
     * Show multiselect or select options
     */
    show_options : function(elem){
        var id = jQuery(elem).attr('data-id');
        var selected = jQuery(elem).val();
        if(selected == 'select' || selected == 'tco_woomultiselect' || selected == 'radio'){
            jQuery('#tco_woo_item_checkout_fields_'+id).show();
        }else{
            jQuery('#tco_woo_item_checkout_fields_'+id).hide();
        }
        
    },

    /**
     * Regex Options Select
     */
    show_regex : function(elem){
        var selected = jQuery(elem).val();
        if(selected == 'custom' ){
            jQuery('.custom_validation_form').show();
        }else{
            jQuery('.custom_validation_form').hide();
        }
        
    },

    /**
     * Conditional Options select
     */
    show_condition : function(elem){
        var selected = jQuery(elem).val();
        if(selected == 1){
            jQuery('.container_conditional_settings').show();
        }else{
            jQuery('.container_conditional_settings').hide();
        }
        
    },

    /**
     * Manage dialog modal 
     * 
     * @param elem - the element
     */
    manage_options : function(elem){
        var id = jQuery(elem).attr('data-id');
        jQuery('#tco_woo_options_modal_count').val(id);
        jQuery('#tco_woo_options_modal').val();
        jQuery('#tco_woo_options_modal').val(jQuery('#field_options_'+id).val());

        jQuery('#tco_woo_checkout-options-dialog-form-dialog').modal({
            fadeDuration: 100
        });
        return false;
    },

    /**
     *  Assign dialog options and close
     */
    assign_options : function(){
        var id = jQuery('#tco_woo_options_modal_count').val();
        jQuery('#field_options_'+id).val(jQuery('#tco_woo_options_modal').val());
        jQuery.modal.close();
    }
}