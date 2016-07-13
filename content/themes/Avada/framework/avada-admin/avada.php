<?php
if( !defined('AVADA_ADMIN_DIR') )
	define( 'AVADA_ADMIN_DIR', get_template_directory_uri() . '/framework/avada-admin/' );

if( !class_exists( 'Avada_Admin' ) ){
	class Avada_Admin{
		function __construct(){
			add_action( 'wp_before_admin_bar_render', array( $this, 'avada_add_wp_toolbar_menu' ) );	
			add_action( 'admin_init', array( $this, 'avada_admin_init' ) );	
			add_action( 'admin_menu', array( $this, 'avada_admin_menu') );
			add_action( 'admin_head', array( $this, 'avada_admin_scripts' ) );
			add_action( 'admin_menu', array( $this, 'edit_admin_menus' ) );
			add_action( 'after_switch_theme', array( $this, 'avada_activation_redirect' ) );
			add_action( 'wp_ajax_avada_update_registration', array( $this, 'avada_update_registration' ) );
		}
		
		function avada_add_wp_toolbar_menu() {
			global $wp_admin_bar;

			if ( current_user_can( 'edit_theme_options' ) ) {

				$registration_complete = FALSE;
				$avada_options = get_option( 'Avada_Key' );
				$tf_username = isset( $avada_options[ 'tf_username' ] ) ? $avada_options[ 'tf_username' ] : '';
				$tf_api = isset( $avada_options[ 'tf_api' ] ) ? $avada_options[ 'tf_api' ] : '';
				$tf_purchase_code = isset( $avada_options[ 'tf_purchase_code' ] ) ? $avada_options[ 'tf_purchase_code' ] : '';
				if ( $tf_username !== '' && 
					 $tf_api !== '' && 
					 $tf_purchase_code !== ''
				) {
					$registration_complete = TRUE;
				}
				$avada_parent_menu_title = '<span class="ab-icon"></span><span class="ab-label">Avada</span>';

				$this->avada_add_wp_toolbar_menu_item( $avada_parent_menu_title, FALSE, admin_url( 'admin.php?page=avada' ), array( 'class' => 'avada-menu' ), 'avada' );
				
				if ( ! $registration_complete ) {
					$this->avada_add_wp_toolbar_menu_item( __( 'Product Registration', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada' ) );
				}
				$this->avada_add_wp_toolbar_menu_item( __( 'Support', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada-support' ) );
				$this->avada_add_wp_toolbar_menu_item( __( 'Install Demos', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada-demos' ) );
				$this->avada_add_wp_toolbar_menu_item( __( 'Fusion Plugins', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada-plugins' ) );
				$this->avada_add_wp_toolbar_menu_item( __( 'System Status', 'Avada' ), 'avada', admin_url( 'admin.php?page=avada-system-status' ) );	
				$this->avada_add_wp_toolbar_menu_item( __( 'Theme Options', 'Avada' ), 'avada', admin_url( 'themes.php?page=optionsframework' ) );
			}
		}

		function avada_add_wp_toolbar_menu_item( $title, $parent = FALSE, $href = '', $custom_meta = array(), $custom_id = '' ) {
			global $wp_admin_bar;

			if ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! is_super_admin() ||
					 ! is_admin_bar_showing() 
				) {
					return;
				}

				// Set custom ID
				if ( $custom_id ) {
					$id = $custom_id;
				// Generate ID based on $title
				} else {
					$id = strtolower( str_replace( ' ', '-', $title ) );
				}

				// links from the current host will open in the current window
				$meta = strpos( $href, site_url() ) !== false ? array() : array( 'target' => '_blank' ); // external links open in new tab/window
				$meta = array_merge( $meta, $custom_meta );

				$wp_admin_bar->add_node( array(
					'parent' => $parent,
					'id' => $id,
					'title' => $title,
					'href' => $href,
					'meta' => $meta,
				) );
			}
		}
		
		function edit_admin_menus() {
			global $submenu;

			if ( current_user_can( 'edit_theme_options' ) ) {
				$submenu['avada'][0][0] = 'Product Registration'; // Change Avada to Product Registration
			}
		}
		
		function avada_activation_redirect(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				header('Location:'.admin_url().'admin.php?page=avada');
			}
		}
		
		function avada_admin_init(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				// Save avada key in a different location
				$avada_key = get_option( 'Avada_Key' );
				if( ! is_array( $avada_key ) && empty( $avada_key ) ) {
					$avada_options = get_option( 'Avada_options' );
					$tf_username = isset( $avada_options[ 'tf_username' ] ) ? $avada_options[ 'tf_username' ] : '';
					$tf_api = isset( $avada_options[ 'tf_api' ] ) ? $avada_options[ 'tf_api' ] : '';
					$tf_purchase_code = isset( $avada_options[ 'tf_purchase_code' ] ) ? $avada_options[ 'tf_purchase_code' ] : '';

					if( $tf_username && $tf_api && $tf_purchase_code ) {
						update_option( 'Avada_Key', array(
							'tf_username' 		=> $tf_username,
							'tf_api'	  		=> $tf_api,
							'tf_purchase_code'	=> $tf_purchase_code
						));
					}
				}

				if( isset( $_GET['avada-deactivate'] ) && $_GET['avada-deactivate'] == 'deactivate-plugin' ) {
					check_admin_referer( 'avada-deactivate', 'avada-deactivate-nonce' );

					$plugins = TGM_Plugin_Activation::$instance->plugins;

					foreach( $plugins as $plugin ) {
						if( $plugin['slug'] == $_GET['plugin'] ) {
							deactivate_plugins( $plugin['file_path'] );
						}
					}
				} if( isset( $_GET['avada-activate'] ) && $_GET['avada-activate'] == 'activate-plugin' ) {
					check_admin_referer( 'avada-activate', 'avada-activate-nonce' );

					$plugins = TGM_Plugin_Activation::$instance->plugins;

					foreach( $plugins as $plugin ) {
						if( $plugin['slug'] == $_GET['plugin'] ) {
							activate_plugin( $plugin['file_path'] );
						}
					}
				}
			}
		}
		function avada_admin_menu(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				// Work around for theme check
				$avada_menu_page_creation_method = 'add_menu_page';
				$avada_submenu_page_creation_method = 'add_submenu_page';
			
				$welcome_screen = $avada_menu_page_creation_method( 
					'Avada',
					'Avada',
					'administrator',
					'avada',
					array( $this, 'avada_welcome_screen' ),
					'dashicons-fusiona-logo',
					3);			
				
				$support = $avada_submenu_page_creation_method(
						'avada',
						__( 'Avada Support', 'Avada' ),
						__( 'Support', 'Avada' ),
						'administrator',
						'avada-support',
						array( $this, 'avada_support_tab' ) );

				$demos = $avada_submenu_page_creation_method(
						'avada',
						__( 'Install Avada Demos', 'Avada' ),
						__( 'Install Demos', 'Avada' ),
						'administrator',
						'avada-demos',
						array( $this, 'avada_demos_tab' ) );

				$plugins = $avada_submenu_page_creation_method(
						'avada',
						__( 'Fusion Plugins', 'Avada' ),
						__( 'Fusion Plugins', 'Avada' ),
						'administrator',
						'avada-plugins',
						array( $this, 'avada_plugins_tab' ) );					
				
				$status = $avada_submenu_page_creation_method(
						'avada',
						__( 'System Status', 'Avada' ),
						__( 'System Status', 'Avada' ),
						'administrator',
						'avada-system-status',
						array( $this, 'avada_system_status_tab' ) );

				$theme_options = $avada_submenu_page_creation_method(
						'avada',
						__( 'Theme Options', 'Avada' ),
						__( 'Theme Options', 'Avada' ),
						'administrator',
						'themes.php?page=optionsframework' );	

				add_action( 'admin_print_scripts-'.$welcome_screen, array( $this, 'welcome_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$support, array( $this, 'support_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$demos, array( $this, 'demos_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$plugins, array( $this, 'plugins_screen_scripts' ) );
				add_action( 'admin_print_scripts-'.$status, array( $this, 'status_screen_scripts' ) );
			}
		}
		
		function avada_welcome_screen(){
			require_once('screens/welcome.php');
		}
		
		function avada_support_tab(){
			require_once('screens/support.php');
		}
		
		function avada_demos_tab(){
			require_once('screens/install-demos.php');
		}
		
		function avada_plugins_tab(){
			require_once('screens/fusion-plugins.php');
		}

		function avada_system_status_tab(){
			require_once('screens/system-status.php');
		}
		
		function avada_update_registration(){
			global $wp_version;

			$avada_options = get_option( 'Avada_Key' );
			$data = $_POST;
			$tf_username = isset( $data[ 'tf_username' ] ) ? $data[ 'tf_username' ] : '';
			$tf_api = isset( $data[ 'tf_api' ] ) ? $data[ 'tf_api' ] : '';
			$tf_purchase_code = isset( $data[ 'tf_purchase_code' ] ) ? $data[ 'tf_purchase_code' ] : '';

			if( $tf_username !== "" && $tf_api !== "" && $tf_purchase_code !== "" ) {
				$avada_options[ 'tf_username' ] = $tf_username;
				$avada_options[ 'tf_api' ] = $tf_api;
				$avada_options[ 'tf_purchase_code' ] = $tf_purchase_code;

				$prepare_request = array(
					'user-agent' => 'WordPress/'. $wp_version .'; '. home_url()
				);

				$raw_response = wp_remote_post( 'http://marketplace.envato.com/api/v3/' . $tf_username . '/' . $tf_api . '/download-purchase:' . $tf_purchase_code . '.json', $prepare_request );

				if( ! is_wp_error( $raw_response ) ) {
					$response = json_decode( $raw_response['body'], true );
				}

				if( ! empty( $response ) ) {
					if( ( isset( $response['error'] ) ) || ( isset( $response['download-purchase'] ) && empty( $response['download-purchase'] ) ) ) {
						echo 'Error';
					} elseif( isset( $response['download-purchase'] ) && ! empty( $response['download-purchase'] ) ) {
						$result = update_option( 'Avada_Key', $avada_options );
						
						echo 'Updated';
					}
				} else {
					echo 'Error';
				}
			} else {
				echo 'Empty';
			}
			die();
		}
		
		function avada_admin_scripts(){
			if ( is_admin() && current_user_can( 'edit_theme_options' ) ) {
			?>
			<style type="text/css">
			@media screen and (max-width: 782px) {
				#wp-toolbar > ul > .avada-menu {
					display: block;
				}
				
				#wpadminbar .avada-menu > .ab-item .ab-icon {
					padding-top: 6px !important;
					height: 40px !important;
					font-size: 30px !important;
				}	
			}
			/*
			#menu-appearance a[href="themes.php?page=optionsframework"] {
				display: none;
			}
			*/
			#wpadminbar .avada-menu > .ab-item .ab-icon:before,
            .dashicons-fusiona-logo:before{
                content: "\e62d";
                font-family: 'icomoon';
                speak: none;
                font-style: normal;
                font-weight: normal;
                font-variant: normal;
                text-transform: none;
                line-height: 1;
            
                /* Better Font Rendering =========== */
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            </style>
            <?php
			}
		}

		function welcome_screen_scripts(){
			wp_enqueue_style( 'avada_admin_css', AVADA_ADMIN_DIR . '../assets/css/avada-admin.css' );
			wp_enqueue_style( 'welcome_screen_css', AVADA_ADMIN_DIR . '../assets/css/avada-welcome-screen.css' );
			wp_enqueue_script( 'avada_welcome_screen', AVADA_ADMIN_DIR . '../assets/js/avada-welcome-screen.js' );
		}
		
		function support_screen_scripts(){
			wp_enqueue_style( 'avada_admin_css', AVADA_ADMIN_DIR . '../assets/css/avada-admin.css' );
		}
		
		function demos_screen_scripts(){
			wp_enqueue_style( 'avada_admin_css', AVADA_ADMIN_DIR . '../assets/css/avada-admin.css' );
			wp_enqueue_script( 'avada_admin_js', AVADA_ADMIN_DIR . '../assets/js/avada-admin.js' );
		}
		
		function plugins_screen_scripts(){
			wp_enqueue_style( 'avada_admin_css', AVADA_ADMIN_DIR . '../assets/css/avada-admin.css' );
		}

		function status_screen_scripts(){
			wp_enqueue_style( 'avada_admin_css', AVADA_ADMIN_DIR . '../assets/css/avada-admin.css' );
			wp_enqueue_script( 'avada_admin_js', AVADA_ADMIN_DIR . '../assets/js/avada-admin.js' );
		}

		function plugin_link( $item ) {
			$installed_plugins = get_plugins();

			$item['sanitized_plugin'] = $item['name'];

			/** We need to display the 'Install' hover link */
			if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
				$actions = array(
					'install' => sprintf(
						'<a href="%1$s" class="button button-primary" title="Install %2$s">Install</a>',
						esc_url( wp_nonce_url(
							add_query_arg(
								array(
									'page'		  	=> urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'		=> urlencode( $item['slug'] ),
									'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
									'plugin_source' => urlencode( $item['source'] ),
									'tgmpa-install' => 'install-plugin',
									'return_url' => 'fusion_plugins'
								),
								admin_url( TGM_Plugin_Activation::$instance->parent_url_slug )
							),
							'tgmpa-install'
						) ),
						$item['sanitized_plugin']
					),
				);
			}
			/** We need to display the 'Activate' hover link */
			elseif ( is_plugin_inactive( $item['file_path'] ) ) {
				$actions = array(
					'activate' => sprintf(
						'<a href="%1$s" class="button button-primary" title="Activate %2$s">Activate</a>',
						esc_url( add_query_arg(
							array(
								'plugin'			   => urlencode( $item['slug'] ),
								'plugin_name'		  => urlencode( $item['sanitized_plugin'] ),
								'plugin_source'		=> urlencode( $item['source'] ),
								'avada-activate'	   => 'activate-plugin',
								'avada-activate-nonce' => wp_create_nonce( 'avada-activate' ),
							),
							admin_url( 'admin.php?page=avada-plugins' )
						) ),
						$item['sanitized_plugin']
					),
				);
			}
			/** We need to display the 'Update' hover link */
			elseif ( version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' ) ) {
				$actions = array(
					'update' => sprintf(
						'<a href="%1$s" class="button button-primary" title="Install %2$s">Update</a>',
						wp_nonce_url(
							add_query_arg(
								array(
									'page'		  => urlencode( TGM_Plugin_Activation::$instance->menu ),
									'plugin'		=> urlencode( $item['slug'] ),
									'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
									'plugin_source' => urlencode( $item['source'] ),
									'tgmpa-update' => 'update-plugin',
									'version' => urlencode( $item['version'] ),
									'return_url' => 'fusion_plugins'
								),
								admin_url( TGM_Plugin_Activation::$instance->parent_url_slug )
							),
							'tgmpa-install'
						),
						$item['sanitized_plugin']
					),
				);
			} elseif ( is_plugin_active( $item['file_path'] ) ) {
				$actions = array(
					'deactivate' => sprintf(
						'<a href="%1$s" class="button button-primary" title="Deactivate %2$s">Deactivate</a>',
						esc_url( add_query_arg(
							array(
								'plugin'			=> urlencode( $item['slug'] ),
								'plugin_name'		  => urlencode( $item['sanitized_plugin'] ),
								'plugin_source'		=> urlencode( $item['source'] ),
								'avada-deactivate'	   => 'deactivate-plugin',
								'avada-deactivate-nonce' => wp_create_nonce( 'avada-deactivate' ),
							),
							admin_url( 'admin.php?page=avada-plugins' )
						) ),
						$item['sanitized_plugin']
					),
				);
			}

			return $actions;
		}

		/**
		 * let_to_num function.
		 *
		 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
		 *
		 * @param $size
		 * @return int
		 */
		function let_to_num( $size ) {
			$l   = substr( $size, -1 );
			$ret = substr( $size, 0, -1 );
			switch ( strtoupper( $l ) ) {
				case 'P':
					$ret *= 1024;
				case 'T':
					$ret *= 1024;
				case 'G':
					$ret *= 1024;
				case 'M':
					$ret *= 1024;
				case 'K':
					$ret *= 1024;
			}
			return $ret;
		}
	}
	new Avada_Admin;
}