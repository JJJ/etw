<?php

/**
 * Plugin Name: WP Tracking Code
 * Plugin URI:  https://wordpress.org/plugins/wp-tracking-code
 * Author:      Chris G. Smith
 * Author URI:  https://flox.io/
 * Version:     0.0.1
 * Description: Add tracking code to site head or footer
 * License:     GPL v2 or later
 */


// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', 'wp_tracking_code_menu_item' );
add_action( 'wp_head'   , 'wp_tracking_code_head' );

/**
 * Add tracking code submenu item
 */
function wp_tracking_code_menu_item() {
    add_submenu_page( 'options-general.php', 'Tracking Code', 'Tracking Code', 'manage_options', 'wp-tracking-code','wp_tracking_code_form');
}

/**
 * Add tracking code to header
 */
function wp_tracking_code_head() {
    $tracker = get_option('wp_tracking_code');

    if (!empty($tracker['tracking_head']['code'])) {
        echo stripslashes($tracker['tracking_head']['code']);
    }
}

/**
 * Form to allow changing the tracking code
 */
function wp_tracking_code_form(){

    if( isset($_POST['save']) ){
        if( check_admin_referer('wp_tracking_code') && !empty($_POST['data']) ){
            update_option( 'wp_tracking_code', $_POST['data'] );
            $isSaved = true;
        }
    }

    $data = stripslashes_deep(get_option('wp_tracking_code'));

    ?>

    <div class="wrap">
        <div id="icon-options-general" class="icon32 icon32-posts-page"><br /></div>
        <form method="post" action="">
            <h2><?php esc_html_e('Tracking Code', 'wp-tracking-code');?></h2>
            <p><?php esc_html_e('Add web tracking code to html head or footer section.', 'wp-tracking-code');?></p>
            <?php if( !empty( $isSaved ) ) : ?>
                <div class="updated"><p><strong><?php esc_html_e('Saved Successfully.', 'wp-tracking-code'); ?></strong></p></div>
            <?php endif; ?>
            <p>
            <h3><?php esc_html_e('Add Tracking Code to HTML head', 'wp-tracking-code');?></h3>
            <textarea rows="20" style="width:100%" name="data[tracking_head][code]"><?php echo @$data['tracking_head']['code'] ?></textarea>
            <br />
            <input type="checkbox" name="data[tracking_head][disable]" id="tracking_head_disable" <?php checked( @$data['tracking_head']['disable'], 'on' ); ?>  />
            <label for="tracking_head_disable"><?php esc_html_e('Disable this head tracking code', 'wp-tracking-code');?></label>
            </p>

            <?php wp_nonce_field( 'wp_tracking_code' ); ?>

            <p><input class="button-primary" type="submit" name="save" value="Save Changes"/></p>

        </form>
    </div>
    <?php
}
