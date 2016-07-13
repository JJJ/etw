<?php
$avada_theme = wp_get_theme();
if($avada_theme->parent_theme) {
	$template_dir =  basename(get_template_directory());
	$avada_theme = wp_get_theme($template_dir);
}
$avada_version = $avada_theme->get( 'Version' );
$theme_fusion_url = 'https://theme-fusion.com/';
?>
<div class="wrap about-wrap avada-wrap">
	<h1><?php echo __( "Welcome to Avada!", "Avada" ); ?></h1>
	<div class="about-text"><?php echo __( "Avada is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it! <a href='//www.youtube.com/embed/dn6g_gJDAIk?rel=0&TB_iframe=true&height=540&width=960' class='thickbox' title='Guided Tour of Avada'>Watch Our Quick Guided Tour!</a>", "Avada" ); ?></div>
	<div class="avada-logo"><span class="avada-version"><?php echo __( "Version", "Avada" ); ?> <?php echo $avada_version; ?></span></div>
	<h2 class="nav-tab-wrapper">
		<?php
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada' ), __( "Product Registration", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-support' ), __( "Support", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-demos' ), __( "Install Demos", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-plugins' ), __( "Fusion Plugins", "Avada" ) );
		printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', __( "System Status", "Avada" ) );
		?>
	</h2>
	<div class="avada-system-status">
		<div class="updated system-status-debug" style="display: block !important;">
			<p><a href="#" class="button-primary debug-report"><?php _e( 'Get System Report', 'Avada' ); ?></a> <?php _e( 'Click the button to produce a report, then copy and paste into your support ticket.', 'Avada' ); ?></p>

			<div id="debug-report">
				<textarea readonly="readonly"></textarea>
				<p class="submit"><button id="copy-for-support" class="button-primary" href="#" data-tip="<?php _e( 'Copied!', 'Avada' ); ?>"><?php _e( 'Copy for Support', 'Avada' ); ?></button></p>
			</div>
		</div>
		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3" data-export-label="WordPress Environment"><?php _e( 'WordPress Environment', 'Avada' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td data-export-label="Home URL"><?php _e( 'Home URL', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The URL of your site\'s homepage.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php echo home_url(); ?></td>
				</tr>
				<tr>
					<td data-export-label="Site URL"><?php _e( 'Site URL', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The root URL of your site.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php echo site_url(); ?></td>
				</tr>
				<tr>
					<td data-export-label="WP Version"><?php _e( 'WP Version', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of WordPress installed on your site.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php bloginfo('version'); ?></td>
				</tr>
				<tr>
					<td data-export-label="WP Multisite"><?php _e( 'WP Multisite', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Whether or not you have WordPress Multisite enabled.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php if ( is_multisite() ) echo '&#10004;'; else echo '&ndash;'; ?></td>
				</tr>
				<tr>
					<td data-export-label="WP Memory Limit"><?php _e( 'WP Memory Limit', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php
						$memory = $this->let_to_num( WP_MEMORY_LIMIT );
						if ( $memory < 128000000 ) {
							echo '<mark class="error">' . sprintf( __( '%s - We recommend setting memory to at least <strong>128MB</strong>. <br /> To import classic demo data, <strong>256MB</strong> of memory limit is required. <br /> Please define memory limit in <strong>wp-config.php</strong> file. To learn how, see: <a href="%s" target="_blank">Increasing memory allocated to PHP.</a>', 'Avada' ), size_format( $memory ), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) . '</mark>';
						} else {
							echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
							if ( $memory < 256000000 ) {
								echo '<br /><mark class="error">' . __( 'Your current memory limit is sufficient, but if you need to import classic demo content, the required memory limit is <strong>256MB.</strong>', 'Avada' ) . '</mark>';
							}
						}
					?></td>
				</tr>
				<tr>
					<td data-export-label="WP Debug Mode"><?php _e( 'WP Debug Mode', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Displays whether or not WordPress is in Debug Mode.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">' . '&#10004;' . '</mark>'; else echo '<mark class="no">' . '&ndash;' . '</mark>'; ?></td>
				</tr>
				<tr>
					<td data-export-label="Language"><?php _e( 'Language', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The current language used by WordPress. Default = English', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php echo get_locale() ?></td>
				</tr>
			</tbody>
		</table>

		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3" data-export-label="Server Environment"><?php _e( 'Server Environment', 'Avada' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td data-export-label="Server Info"><?php _e( 'Server Info', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Information about the web server that is currently hosting your site.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
				</tr>
				<tr>
					<td data-export-label="PHP Version"><?php _e( 'PHP Version', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of PHP installed on your hosting server.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php if ( function_exists( 'phpversion' ) ) echo esc_html( phpversion() ); ?></td>
				</tr>
				<?php if ( function_exists( 'ini_get' ) ) : ?>
					<tr>
						<td data-export-label="PHP Post Max Size"><?php _e( 'PHP Post Max Size', 'Avada' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest file size that can be contained in one post.', 'Avada'  ) . '">[?]</a>'; ?></td>
						<td><?php echo size_format( $this->let_to_num( ini_get('post_max_size') ) ); ?></td>
					</tr>
					<tr>
						<td data-export-label="PHP Time Limit"><?php _e( 'PHP Time Limit', 'Avada' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'Avada'  ) . '">[?]</a>'; ?></td>
						<td><?php
							$time_limit = ini_get('max_execution_time');

							if ( $time_limit < 180 && $time_limit != 0 ) {
								echo '<mark class="error">' . sprintf( __( '%s - We recommend setting max execution time to at least 180. <br /> To import classic demo content, <strong>300</strong> seconds of max execution time is required.<br />See: <a href="%s" target="_blank">Increasing max execution to PHP</a>', 'Avada' ), $time_limit, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded' ) . '</mark>';
							} else {
								echo '<mark class="yes">' . $time_limit . '</mark>';
								if ( $time_limit < 300 && $time_limit != 0 ) {
									echo '<br /><mark class="error">' . __( 'Current time limit is sufficient, but if you need import classic demo content, the required time is <strong>300</strong>.', 'Avada' ) . '</mark>';
								}
							}
						?></td>
					</tr>
					<tr>
						<td data-export-label="PHP Max Input Vars"><?php _e( 'PHP Max Input Vars', 'Avada' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'Avada'  ) . '">[?]</a>'; ?></td>
						<?php
						$registered_navs = get_nav_menu_locations();
						$menu_items_count = array( "0" => "0" );
						foreach( $registered_navs as $handle => $registered_nav ) {
							$menu = wp_get_nav_menu_object( $registered_nav );
							if( $menu ) {
								$menu_items_count[] = $menu->count;
							}
						}

						$max_items = max( $menu_items_count );
						if( ! fusion_get_theme_option( 'disable_megamenu' ) ) {
							$required_input_vars = $max_items * 20;
						} else {
							$required_input_vars = ini_get('max_input_vars');
						}
						?>
						<td><?php
							$max_input_vars = ini_get('max_input_vars');
							$required_input_vars = $required_input_vars + ( 500 + 1000 );
							// 1000 = theme options

							if ( $max_input_vars < $required_input_vars ) {
								echo '<mark class="error">' . sprintf( __( '%s - Recommended Value: %s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%s" target="_blank">Increasing max input vars limit.</a>', 'Avada' ), $max_input_vars, '<strong>' . ( $required_input_vars + ( 500 + 1000 ) ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>';
							} else {
								echo '<mark class="yes">' . $max_input_vars . '</mark>';
							}
						?></td>
					</tr>
					<tr>
						<td data-export-label="SUHOSIN Installed"><?php _e( 'SUHOSIN Installed', 'Avada' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself.
		If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'Avada'  ) . '">[?]</a>'; ?></td>
						<td><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
					</tr>
					<?php if( extension_loaded( 'suhosin' ) ): ?>
					<tr>
						<td data-export-label="Suhosin Post Max Vars"><?php _e( 'Suhosin Post Max Vars', 'Avada' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'Avada'  ) . '">[?]</a>'; ?></td>
						<?php
						$registered_navs = get_nav_menu_locations();
						$menu_items_count = array( "0" => "0" );
						foreach( $registered_navs as $handle => $registered_nav ) {
							$menu = wp_get_nav_menu_object( $registered_nav );
							if( $menu ) {
								$menu_items_count[] = $menu->count;
							}
						}

						$max_items = max( $menu_items_count );
						if( ! fusion_get_theme_option( 'disable_megamenu' ) ) {
							$required_input_vars = $max_items * 20;
						} else {
							$required_input_vars = ini_get( 'suhosin.post.max_vars' );
						}
						?>
						<td><?php
							$max_input_vars = ini_get( 'suhosin.post.max_vars' );
							$required_input_vars = $required_input_vars + ( 500 + 1000 );

							if ( $max_input_vars < $required_input_vars ) {
								echo '<mark class="error">' . sprintf( __( '%s - Recommended Value: %s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%s" target="_blank">Increasing max input vars limit.</a>', 'Avada' ), $max_input_vars, '<strong>' . ( $required_input_vars + ( 500 + 1000 ) ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>';
							} else {
								echo '<mark class="yes">' . $max_input_vars . '</mark>';
							}
						?></td>
					</tr>
					<tr>
						<td data-export-label="Suhosin Request Max Vars"><?php _e( 'Suhosin Request Max Vars', 'Avada' ); ?>:</td>
						<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'Avada'  ) . '">[?]</a>'; ?></td>
						<?php
						$registered_navs = get_nav_menu_locations();
						$menu_items_count = array( "0" => "0" );
						foreach( $registered_navs as $handle => $registered_nav ) {
							$menu = wp_get_nav_menu_object( $registered_nav );
							if( $menu ) {
								$menu_items_count[] = $menu->count;
							}
						}

						$max_items = max( $menu_items_count );
						if( ! fusion_get_theme_option( 'disable_megamenu' ) ) {
							$required_input_vars = $max_items * 20;
						} else {
							$required_input_vars = ini_get( 'suhosin.request.max_vars' );
						}
						?>
						<td><?php
							$max_input_vars = ini_get( 'suhosin.request.max_vars' );
							$required_input_vars = $required_input_vars + ( 500 + 1000 );

							if ( $max_input_vars < $required_input_vars ) {
								echo '<mark class="error">' . sprintf( __( '%s - Recommended Value: %s.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%s" target="_blank">Increasing max input vars limit.</a>', 'Avada' ), $max_input_vars, '<strong>' . ( $required_input_vars + ( 500 + 1000 ) ) . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>';
							} else {
								echo '<mark class="yes">' . $max_input_vars . '</mark>';
							}
						?></td>
					</tr>
					<?php endif; ?>
				<?php endif; ?>
				<tr>
					<td data-export-label="ZipArchive"><?php _e( 'ZipArchive', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php echo class_exists( 'ZipArchive' ) ? '<mark class="yes">&#10004;</mark>' : '<mark class="error">ZipArchive is not installed on your server, but is required if you need to import demo content.</mark>'; ?></td>
				</tr>
				<tr>
					<td data-export-label="MySQL Version"><?php _e( 'MySQL Version', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The version of MySQL installed on your hosting server.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td>
						<?php
						/** @global wpdb $wpdb */
						global $wpdb;
						echo $wpdb->db_version();
						?>
					</td>
				</tr>
				<tr>
					<td data-export-label="Max Upload Size"><?php _e( 'Max Upload Size', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The largest file size that can be uploaded to your WordPress installation.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php echo size_format( wp_max_upload_size() ); ?></td>
				</tr>
				<tr>
					<td data-export-label="Default Timezone is UTC"><?php _e( 'Default Timezone is UTC', 'Avada' ); ?>:</td>
					<td class="help"><?php echo '<a href="#" class="help_tip" data-tip="' . esc_attr__( 'The default timezone for your server.', 'Avada'  ) . '">[?]</a>'; ?></td>
					<td><?php
						$default_timezone = date_default_timezone_get();
						if ( 'UTC' !== $default_timezone ) {
							echo '<mark class="error">' . '&#10005; ' . sprintf( __( 'Default timezone is %s - it should be UTC', 'Avada' ), $default_timezone ) . '</mark>';
						} else {
							echo '<mark class="yes">' . '&#10004;' . '</mark>';
						} ?>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="widefat" cellspacing="0" id="status">
			<thead>
				<tr>
					<th colspan="3" data-export-label="Active Plugins (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)"><?php _e( 'Active Plugins', 'Avada' ); ?> (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$active_plugins = (array) get_option( 'active_plugins', array() );

				if ( is_multisite() ) {
					$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
				}

				foreach ( $active_plugins as $plugin ) {

					$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
					$dirname        = dirname( $plugin );
					$version_string = '';
					$network_string = '';

					if ( ! empty( $plugin_data['Name'] ) ) {

						// link the plugin name to the plugin url if available
						$plugin_name = esc_html( $plugin_data['Name'] );

						if ( ! empty( $plugin_data['PluginURI'] ) ) {
							$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . __( 'Visit plugin homepage' , 'Avada' ) . '">' . $plugin_name . '</a>';
						}
						?>
						<tr>
							<td><?php echo $plugin_name; ?></td>
							<td class="help">&nbsp;</td>
							<td><?php echo sprintf( _x( 'by %s', 'by author', 'Avada' ), $plugin_data['Author'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string; ?></td>
						</tr>
						<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="avada-thanks">
		<hr />
		<p class="description"><?php echo __( "Thank you for choosing Avada. We are honored and are fully dedicated to making your experience perfect.", "Avada" ); ?></p>
	</div>
</div>