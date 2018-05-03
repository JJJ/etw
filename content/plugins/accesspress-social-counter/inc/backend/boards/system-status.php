<div class="apsc-boards-tabs" id="apsc-board-system-status" style="display:none">
	<div class="apsc-tab-wrapper">
		<div class="apsc-option-inner-wrapper">
			<label>fsockopen/cURL</label>
			<div class="apsc-option-field">
				<?php 
                if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
					if ( function_exists( 'fsockopen' ) && function_exists( 'curl_init' ) ) {
						 _e( 'Your server has fsockopen and cURL enabled.', 'accesspress-social-counter' );
					} elseif ( function_exists( 'fsockopen' ) ) {
						_e( 'Your server has fsockopen enabled, cURL is disabled.', 'accesspress-social-counter' );
					} else {
						_e( 'Your server has cURL enabled, fsockopen is disabled.', 'accesspress-social-counter' );
					}

					
				}
                ?>
			</div>
		</div>
        <div class="apsc-option-inner-wrapper">
			<label>WP Remote Get</label>
			<div class="apsc-option-field">
				<?php 
                
				$response      = wp_remote_get( 'https://httpbin.org/ip', array( 'timeout' => 60 ) );

				if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
					
					_e( 'wp_remote_get() was successful.', 'accesspress-social-counter' );
				} elseif ( is_wp_error( $response ) ) {
					_e( 'wp_remote_get() failed. This plugin won\'t work with your server. Contact your hosting provider. Error:', 'accesspress-social-counter' ) . ' ' . $response->get_error_message();
				}
                ?>
			</div>
		</div>
        <div class="apsc-extra-note"><?php _e('Note: The plugin will only work properly if fsockopen/cURL and wp_remote_get is working in your server.','accesspress-social-counter');?></div>
	</div>
</div>