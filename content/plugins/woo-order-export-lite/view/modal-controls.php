<div id='fields_control_products' class='fields_control_style' style="display: none;">
    <div class='div_meta' >
        <div id="custom_meta_products_mode">
            <label><input id="custom_meta_products_mode_used" type="checkbox" name="custom_meta_products_mode" value="used"> <?php _e('Hide unused fields', 'woo-order-export-lite') ?></label>
        </div>
        <label for="select_custom_meta_products"><?php _e('Product fields', 'woo-order-export-lite')?>:</label>
        <select id='select_custom_meta_products'></select>

        <label for="select_custom_meta_order_items"><?php _e('Order item fields', 'woo-order-export-lite')?>:</label>
        <select id='select_custom_meta_order_items'></select>
        <div style="width: 80%; text-align: center;"><?php _e('OR', 'woo-order-export-lite') ?></div>
        <label><?php _e('Taxonomy', 'woo-order-export-lite')?>:</label><select id='select_custom_taxonomies_products'>
            <option></option>
            <?php
            foreach (WC_Order_Export_Data_Extractor_UI::get_product_taxonomies() as $tax_id => $tax_name) {
                echo "<option value='__$tax_name' >__$tax_name</option>";
            };
            ?>
        </select>
        <label><?php _e('Column name', 'woo-order-export-lite')?>:</label><input type='text' id='colname_custom_meta_products'/>
        <div style="text-align: right;">
            <button  id='button_custom_meta_products' class='button-secondary'><?php _e('Add field', 'woo-order-export-lite')?></button>
        </div>
    </div>
    <div class='div_custom'>
        <label><?php _e('Column name', 'woo-order-export-lite')?>:</label><input type='text' id='colname_custom_field_products'/>
        <label><?php _e('Value', 'woo-order-export-lite')?>:</label><input type='text' id='value_custom_field_products'/>
        <div style="text-align: right;">
            <button  id='button_custom_field_products' class='button-secondary'><?php _e('Add static field', 'woo-order-export-lite')?></button>
        </div>
    </div>
</div>

<div id='fields_control_coupons' class='fields_control_style' style="display: none;">
    <div class='div_meta' >
        <label><?php _e('Meta key', 'woo-order-export-lite')?>:</label>
        <div id="custom_meta_coupons_mode" style="display: none;">
            <label><input id="custom_meta_coupons_mode_all" type="radio" name="custom_meta_coupons_mode" value="all"> <?php _e('All meta', 'woo-order-export-lite') ?></label>
            <label><input id="custom_meta_coupons_mode_used" type="radio" name="custom_meta_coupons_mode" value="used"> <?php _e('Hide unused fields', 'woo-order-export-lite') ?></label>
        </div>
        <select id='select_custom_meta_coupons'>
        </select>
        <label><?php _e('Column name', 'woo-order-export-lite')?>:</label><input type='text' id='colname_custom_meta_coupons'/></label>
        <div style="text-align: right;">
            <button  id='button_custom_meta_coupons' class='button-secondary'><?php _e('Add field', 'woo-order-export-lite')?></button>
        </div>
    </div>
    <div class='div_custom'>
        <label><?php _e('Column name', 'woo-order-export-lite')?>:</label><input type='text' id='colname_custom_field_coupons'/></label>
        <label><?php _e('Value', 'woo-order-export-lite')?>:</label><input type='text' id='value_custom_field_coupons'/></label>
        <div style="text-align: right;">
            <button  id='button_custom_field_coupons' class='button-secondary'><?php _e('Add static field', 'woo-order-export-lite')?></button>
        </div>
    </div>
</div>