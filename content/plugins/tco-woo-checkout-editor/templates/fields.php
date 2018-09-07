<?php
/**
 * Fields Table
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="tco_woo_main">
    <div class="tco_woo_checkout_fields">
        <form method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
            <?php wp_nonce_field('tco_woo_checkout_settings','tco_woo_checkout_noncename'); ?>
            <input type="hidden" name="sort_order" id="sort_order" value=""/>
            <input type="hidden" name="tco_woo_section" value="<?php echo $section; ?>"/>
            <p class="submit">
                <a class="button button-secondary" onclick="tco_woo_checkout.add_checkout_element()"><?php _e('Add Checkout Field','tco_woo_checkout'); ?></a>&nbsp;&nbsp;&nbsp;<input class='button button-primary' type='submit' name='tco_woo_checkout_settings' value='<?php _e('Save Options','tco_woo_checkout'); ?>'/>&nbsp;&nbsp;&nbsp;<input class='button button-primary' type='submit' name='tco_woo_checkout_settings_reset' value='<?php _e('Reset Options','tco_woo_checkout'); ?>'/>
            </p>
            <table width="100%" border="0" class="widefat tco_woo_checkout_table">
                <thead>
                    <tr>
                        <th width="1%" align="left" scope="col"></th>
                        <th align="left" scope="col"><?php _e('Name','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Label','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Place Holder','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Type','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Class','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Settings','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Mandatory','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Enabled','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"></th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th align="left" scope="col"></th>
                        <th align="left" scope="col"><?php _e('Name','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Label','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Place Holder','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Type','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Class','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Settings','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Mandatory','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"><?php _e('Enabled','tco_woo_checkout'); ?></th>
                        <th align="left" scope="col"></th>
                    </tr>
                </tfoot>
                <tbody class='sort-checkout ui-sortable'>
                    <?php
                    global $tco_woo_woo_checkout;
                    $count = 0;
                    if (is_array($checkout_fields) && count($checkout_fields) > 0) {
                        foreach ( $checkout_fields as $name => $field ){
                            ?>
                            <tr id="<?php echo esc_attr( $name ); ?>">
                                <td><span style="cursor:move" class="dashicons dashicons-move"></span></td>
                                <?php

                                if(!in_array( $name, $default_woo_keys )){
                                    ?>
                                    <td><input type="text" name="field_name[]" value="<?php echo esc_attr( $name ); ?>"/></td>
                                    <?php
                                }else{
                                    ?>
                                    <td>
                                        <?php echo esc_attr( $name ); ?>
                                        <input type="hidden" name="field_name[]" value="<?php echo esc_attr( $name ); ?>"/>
                                    </td>
                                <?php
                                }
                                ?>
                                    <td><input type="text" name="field_label[]" value="<?php echo $field['label']; ?>"/></td>
                                    <td>
                                        <input type="text" name="field_placeholder[]"  value="<?php echo $field['placeholder']; ?>"/>
                                        <input type="hidden" name="field_options[]" id="field_options_<?php echo $count; ?>" value="<?php echo $field['options']; ?>"/>
                                    </td>
                                    <td>
                                        <?php echo $field['type']; ?>
                                        <input type="hidden" name="field_type[]" value="<?php echo $field['type']; ?>"/>
                                    </td>
                                    <td><input type="text" name="field_class[]" value="<?php echo $field['class']; ?>"/></td>
                                    <td>
                                        <input type="hidden" name="field_validate[]" id="field_validate_<?php echo $count; ?>" value="<?php echo $field['validate']; ?>"/>
                                        <input type="hidden" name="field_regex[]" id="field_regex_<?php echo $count; ?>" value="<?php echo $field['regex']; ?>"/>
                                        <input type="hidden" name="field_validation_field[]" id="field_validation_field_<?php echo $count; ?>" value="<?php echo $field['validation_field']; ?>"/>

                                        <input type="hidden" name="field_conditional[]" id="field_conditional_<?php echo $count; ?>" value="<?php echo $field['conditional']; ?>"/>
                                        <input type="hidden" name="field_conditional_value[]" id="field_conditional_value_<?php echo $count; ?>" value="<?php echo $field['conditional_value']; ?>"/>
                                        <input type="hidden" name="field_conditional_fields[]" id="field_conditional_fields_<?php echo $count; ?>" value="<?php echo $field['conditional_fields']; ?>"/>

                                        <input type="hidden" name="field_products_condition[]" id="field_products_condition_<?php echo $count; ?>" value="<?php echo $field['products_condition']; ?>"/>
                                        <input type="hidden" name="field_products_fields[]" id="field_products_fields_<?php echo $count; ?>" value="<?php echo $field['product_fields']; ?>"/>
                                        <input type="hidden" name="field_products_fields_validation[]" id="field_products_fields_validation_<?php echo $count; ?>" value="<?php echo $field['product_fields_validation']; ?>"/>
                                        <input type="hidden" name="field_products_fields_second[]" id="field_products_fields_second_<?php echo $count; ?>" value="<?php echo $field['product_fields_second']; ?>"/>
                                        <input type="hidden" name="field_products_fields_validation_second[]" id="field_products_fields_validation_second_<?php echo $count; ?>" value="<?php echo $field['product_fields_validation_second']; ?>"/>

										<a href="javascript:;" class='tco_woo_item_checkout_setting' id="tco_woo_item_checkout_setting_<?php echo $count; ?>" data-field="<?php echo esc_attr( $name ); ?>" data-id="<?php echo $count; ?>" onclick="tco_woo_checkout.init_settings(this)"><?php _e('Options','tco_woo_checkout'); ?></a>
									</td>
                                    <td>
										<select name="field_required[]">
											<option value="0" <?php selected($field['required'],1) ?> ><?php _e('No','tco_woo_checkout'); ?></option>
											<option value="1" <?php selected($field['required'],1) ?> ><?php _e('Yes','tco_woo_checkout'); ?></option>
										</select>
									</td>
                                    <td>
										<select name="field_enabled[]">
											<option value="0" <?php selected($field['enabled'],1) ?> ><?php _e('No','tco_woo_checkout'); ?></option>
											<option value="1" <?php selected($field['enabled'],1) ?> ><?php _e('Yes','tco_woo_checkout'); ?></option>
										</select>
									</td>
                                    <td><?php if ( ! in_array($name, $default_billing_fields) && ! in_array($name, $default_shipping_fields) ) : ?>
                                      <span class="handle dashicons dashicons-no-alt" onclick="tco_woo_checkout.delete_checkout_element(this)" title="<?php _e('Remove','tco_woo_checkout'); ?>"></span>
                                    <?php endif; ?></td>
                            </tr>
                            <?php
                            $count++;
                        }
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
            <p class="submit">
                <a class="button button-secondary" onclick="tco_woo_checkout.add_checkout_element()"><?php _e('Add Checkout Field','tco_woo_checkout'); ?></a>&nbsp;&nbsp;&nbsp;<input class='button button-primary' type='submit' name='tco_woo_checkout_settings' value='<?php _e('Save Options','tco_woo_checkout'); ?>'/>&nbsp;&nbsp;&nbsp;<input class='button button-primary' type='submit' name='tco_woo_checkout_settings_reset' value='<?php _e('Reset Options','tco_woo_checkout'); ?>'/>
            </p>
        </form>
        <!-- Keep count of items so we can manipulate them better -->
        <input type="hidden" id="tco_woo_item_count" value="<?php echo $count; ?>" />
        <!-- Custom Script that is called when we click the Add New Button -->
        <div style="display:none" class="tco_woo_append_row">
            <script type="tco_woo_checkout_row">
                <tr class="ui-sortable-handle">
                    <td><span style="cursor:move" class="dashicons dashicons-move"></span></td>
                    <td><input type="text" name="field_name[]" value="<?php echo $section.'_'; ?>"/></td>
                    <td><input type="text" name="field_label[]" value=""/></td>
                    <td>
                        <input type="text" name="field_placeholder[]"  value=""/>
                        <input type="hidden" name="field_options[]" value="" id="field_options_CURRENTCOUNT"/>
                        &nbsp;<a href="javascript:;" class='tco_woo_item_checkout_fields' style="display:none" id="tco_woo_item_checkout_fields_CURRENTCOUNT" data-id="CURRENTCOUNT" onclick="tco_woo_checkout.manage_options(this)"><?php _e('Manage Options','tco_woo_checkout'); ?></a>
                    </td>
                    <td>
                        <select name="field_type[]" data-id="CURRENTCOUNT" onchange="tco_woo_checkout.show_options(this)">
                            <?php
                                foreach ($tco_woo_woo_checkout->form_elements as $forms => $form) {
                                    ?>
                                    <option value="<?php echo $forms; ?>" ><?php _e($form); ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="field_class[]" value="form-row-wide"/></td>
                    <td>
                        <input type="hidden" name="field_validate[]" id="field_validate_CURRENTCOUNT" value=""/>
                        <input type="hidden" name="field_regex[]" id="field_regex_CURRENTCOUNT" value=""/>
                        <input type="hidden" name="field_validation_field[]" id="field_validation_field_CURRENTCOUNT" value=""/>

                        <input type="hidden" name="field_conditional[]" id="field_conditional_CURRENTCOUNT" value=""/>
                        <input type="hidden" name="field_conditional_value[]" id="field_conditional_value_CURRENTCOUNT" value=""/>
                        <input type="hidden" name="field_conditional_fields[]" id="field_conditional_fields_CURRENTCOUNT" value=""/>

                        <input type="hidden" name="field_products_condition[]" id="field_products_condition_CURRENTCOUNT" value=""/>
                        <input type="hidden" name="field_products_fields[]" id="field_products_fields_CURRENTCOUNT" value=""/>
                        <input type="hidden" name="field_products_fields_validation[]" id="field_products_fields_validation_CURRENTCOUNT" value=""/>
                        <input type="hidden" name="field_products_fields_second[]" id="field_products_fields_second_CURRENTCOUNT" value=""/>
                        <input type="hidden" name="field_products_fields_validation_second[]" id="field_products_fields_validation_second_CURRENTCOUNT" value=""/>

                        <a href="javascript:;" class='tco_woo_item_checkout_setting' id="tco_woo_item_checkout_setting_CURRENTCOUNT"  data-id="CURRENTCOUNT" onclick="tco_woo_checkout.init_settings(this)"><?php _e('Options','tco_woo_checkout'); ?></a>
                    </td>
                    <td>
						<select name="field_required[]">
							<option value="0" ><?php _e('No','tco_woo_checkout'); ?></option>
							<option value="1" ><?php _e('Yes','tco_woo_checkout'); ?></option>
						</select>
					</td>
                    <td>
						<select name="field_enabled[]">
							<option value="0" ><?php _e('No','tco_woo_checkout'); ?></option>
							<option value="1" ><?php _e('Yes','tco_woo_checkout'); ?></option>
						</select>
					</td>
                    <td><span class="handle dashicons dashicons-no-alt" onclick="tco_woo_checkout.delete_checkout_element(this)" title="<?php _e('Remove','tco_woo_checkout'); ?>"></span></td>
                </tr>
            </script>

        </div>
        <!-- End Custom Script that is called when we click the Add New Button -->
        <!--Dialog for Settings-->
        <div id="tco_woo_checkout-settings-dialog-form-dialog" class="tco_woo_checkout_fields tco_woo_checkout_fields_modal modal" style="display:none">
            <ul class='tabs'>
                <li><a href='#validation'><?php _e("Validation","tco_woo_checkout"); ?></a></li>
                <li><a href='#conditional'><?php _e("Conditional","tco_woo_checkout"); ?></a></li>
            </ul>
            <div id='validation'>
                <h3><?php _e("Validation Settings","tco_woo_checkout"); ?></h3>
                <p>
                    <select name="tco_woo_options_validation_option" id="tco_woo_options_validation_option" onchange="tco_woo_checkout.show_regex(this)">
                        <?php
                        foreach ($tco_woo_woo_checkout->validation_options as $key => $value) {
                            ?>
                            <option value="<?php echo $key; ?>"><?php _e($value); ?></option>
                            <?php
                        }
                        ?>
                    </select><br/><br/>
                    <form style="display:none" class="custom_validation_form">
                        <fieldset>
                            <input type="hidden" id="tco_woo_options_modal_count_regex" value=""/>
                            <label for="tco_woo_options_modal"><?php _e("Enter the parent field to validate against","tco_woo_checkout"); ?></label><br/>
                            <select name="tco_woo_options_modal_validation_field" id="tco_woo_options_modal_validation_field" style="width: 240px;" class="chosen-select">
                            <?php
                            foreach ( $checkout_fields as $name => $field ){
                                ?>
                                <option value="<?php echo $name; ?>" ><?php _e($field['label']); ?></option>
                                <?php
                            }
                            ?>
                            </select><br/>
                            <label for="tco_woo_options_modal"><?php _e("Regex String","tco_woo_checkout"); ?></label><br/>
                            <input type="text" name="tco_woo_options_modal_regex" id="tco_woo_options_modal_regex" value="" style="width:90%" class="text ui-widget-content ui-corner-all">
                        </fieldset><br/>
                    </form>
                </p>
            </div>
            <div id='conditional'>
                <input type="hidden" id="current_product_conditional_count" class="current_product_conditional_count"  value="1" />
                <h3><?php _e("Conditional Settings","tco_woo_checkout"); ?></h3>
                <p>
                    <select id="tco_woo_options_conditional_option" onchange="tco_woo_checkout.show_condition(this)">
                        <option value="0"><?php _e('Disable','tco_woo_checkout'); ?></option>
                        <option value="1"><?php _e('Enable','tco_woo_checkout'); ?></option>
                    </select><br/><br/>
                    <div class="container_conditional_settings" style="display:none">
                        <?php _e("Show field only if","tco_woo_checkout"); ?>
                        <table width="100%" border="0" class="widefat row_conditional_settings" >
                            <tbody>
                                <tr>
                                    <td style="width: 155px;">
                                        <label for="tco_woo_options_modal"><?php _e("The text","tco_woo_checkout"); ?></label><br/>
                                        <input type="text" name="tco_woo_options_modal_accepted_value" id="tco_woo_options_modal_accepted_value" value="" style="width:90%" class="text ui-widget-content ui-corner-all"><br/>
                                    </td>
                                    <td>
                                        <label for="tco_woo_options_modal"><?php _e("is in","tco_woo_checkout"); ?></label>
                                        <select name="tco_woo_options_modal_accepted_field[]" id="tco_woo_options_modal_accepted_field" style="width: 240px;" class="chosen-select" multiple>
                                        <?php
                                        foreach ( $checkout_fields as $name => $field ){
                                            ?>
                                            <option value="<?php echo $name; ?>" ><?php _e($field['label']); ?></option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </td>
                                    <td><input type="hidden" id="tco_woo_options_modal_count_conditional" value=""/></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><?php _e("Or","tco_woo_checkout"); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 155px;">
                                        <select name="product_validation_option" id="product_validation_option">
                                            <?php
                                            foreach ($tco_woo_woo_checkout->cart_options as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" ><?php _e($value); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="product_validation_option_products[]" data-placeholder="<?php _e('Select Products','tco_woo_checkout'); ?>" id="product_validation_option_products" style="width: 100%;" class="chosen-select" multiple>
                                        <?php
                                        foreach ( $woocommerce_products as $product ):
                                            ?>
                                            <option value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
                                            <?php
                                        endforeach;
                                        wp_reset_postdata();
                                        ?>
                                        </select>
                                    </td>
                                    <td style="width:132px;">
                                        <ul class="tco_woo_checkout-toggle-now">
                                            <li>
                                                <input type="radio" class='condition_radio' id="or" name="condition" value="or"/>
                                                <label for="or"><?php _e("OR","tco_woo_checkout"); ?></label>
                                            </li>
                                            <li>
                                                <input type="radio" class='condition_radio' id="and" name="condition" value="and"/>
                                                <label for="and"><?php _e("AND","tco_woo_checkout"); ?></label>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 155px;">
                                        <select name="product_validation_option_second" id="product_validation_option_second">
                                            <?php
                                            foreach ($tco_woo_woo_checkout->cart_options as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" ><?php _e($value); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="product_validation_option_products_second[]" data-placeholder="<?php _e('Select Products','tco_woo_checkout'); ?>" id="product_validation_option_products_second" style="width: 100%;" class="chosen-select" multiple>
                                        <?php
                                        foreach ( $woocommerce_products as $product ):
                                            ?>
                                            <option value="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></option>
                                            <?php
                                        endforeach;
                                        wp_reset_postdata();
                                        ?>
                                        </select>
                                    </td>
                                    <td style="width:132px;">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </p>
            </div>
            <a class="button button-primary" onclick="tco_woo_checkout.save_settings()"><?php _e("Update Settings","tco_woo_checkout"); ?></a>
        </div>
        <!-- Select or Multi select options -->
        <div id="tco_woo_checkout-options-dialog-form-dialog" class="modal" style="display:none">
            <p>
                <form>
                    <fieldset>
                        <input type="hidden" id="tco_woo_options_modal_count" value=""/>
                        <label for="tco_woo_options_modal"><?php _e("Seperate options with pipes (|)","tco_woo_checkout"); ?></label><br/>
                        <input type="text" name="tco_woo_options_modal" id="tco_woo_options_modal" value="" style="width:90%" class="text ui-widget-content ui-corner-all">
                    </fieldset>
                    <a class="button button-primary" onclick="tco_woo_checkout.assign_options()"><?php _e("Update options","tco_woo_checkout"); ?></a>
                </form>
            </p>
        </div>
        <!-- End Select or Multi select options -->

        <!-- End Conditional options -->
        <script type="text/javascript">
            jQuery(document).ready(function() {
                var idsInOrder = [];
                jQuery("tbody.sort-checkout").sortable({
                    update: function( event, ui ) {
                        idsInOrder = [];
                        jQuery('tbody.sort-checkout tr').each(function() {
                            idsInOrder.push(jQuery(this).attr('id'));
                        });
                        jQuery('#sort_order').val(idsInOrder);
                    }
                });
                tco_woo_checkout.tabs();
            });
        </script>
    </div>
</div>
