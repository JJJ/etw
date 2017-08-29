<?php
/**
 * This template adds the Getting Started page, license settings and the theme updater.
 *
 * @package WordPress
 * @subpackage Medium
 */


/**
 * Add Getting Started menu item
 */
function medium_license_menu() {
	add_theme_page( __( 'Getting Started', 'medium' ), __( 'Getting Started', 'medium' ), 'manage_options', 'medium-getting-started', 'medium_getting_started_page' );
}
add_action('admin_menu', 'medium_license_menu');


/**
 * Load Getting Started styles in the admin
 */
function medium_start_load_admin_scripts() {

	// Load styles only on our page
	global $pagenow;
	if( 'themes.php' != $pagenow )
		return;

	// Getting started script and styles
	wp_enqueue_script( 'getting-started', get_template_directory_uri() . '/includes/admin/getting-started/getting-started.js', array( 'jquery' ), '1.0.0', true );
	wp_register_style( 'getting-started', get_template_directory_uri() . '/includes/admin/getting-started/getting-started.css', false, '1.0.0' );
	wp_enqueue_style( 'getting-started' );

	// Thickbox
	add_thickbox();
}
add_action( 'admin_enqueue_scripts', 'medium_start_load_admin_scripts' );


/**
 * Create the Getting Started page and settings
 */
function medium_getting_started_page() {

	// License info
	$license            = get_option( 'medium_license_key' );
	$status             = get_option( 'medium_license_key_status' );

	// Theme info
	$theme              = wp_get_theme( 'medium' );

	// Lowercase theme name for resources links
	$theme_name_lower   = get_template();

	// Grab the change log from array.is for display in the Latest Updates tab
	$changelog = wp_remote_get( 'https://array.is/themes/medium-wordpress-theme/changelog/' );
	if( $changelog && !is_wp_error( $changelog ) ) {
		$changelog = $changelog['body'];
	} else {
		$changelog = __( 'There seems to be a problem retrieving the latest updates information from Array. Please check back later.', 'medium' );
	}

	// Array Toolkit URL
	if( is_multisite() ) {
		$adminurl = network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=array-toolkit&TB_iframe=true&width=640&height=589' );
	} else {
		$adminurl = admin_url( 'plugin-install.php?tab=plugin-information&plugin=array-toolkit&TB_iframe=true&width=640&height=589' );
	}

	?>


	<div class="wrap getting-started">
		<div class="intro-wrap">
			<img class="theme-image" src="<?php echo get_template_directory_uri() . '/screenshot.png'; ?>" alt="" />
			<div class="intro">
				<h2><?php printf( __( 'Getting started with %1$s v%2$s', 'medium' ), $theme['Name'], $theme['Version'] ); ?></h2>

				<h3><?php printf( __( 'Thanks for purchasing %1$s! We truly appreciate the support and the opportunity to share our work with you. Please visit the tabs below to get started setting up your theme!', 'medium' ), $theme['Name'] ); ?></h3>
			</div>
		</div>

		<div class="panels">
			<ul class="inline-list">
				<span class="inline-list-links">
					<li class="current"><a id="help" href="#"><?php _e( 'Help File', 'medium' ); ?></a></li>
					<li class="license-tab"><a id="license" href="#"><?php _e( 'License', 'medium' ); ?></a></li>
					<li><a id="updates" href="#"><?php _e( 'Latest Updates', 'medium' ); ?></a></li>
				</span>
				<li>
					<a href="http://array.is/support/forum/<?php echo $theme_name_lower; ?>" title="<?php esc_attr_e( __( 'View support forum', 'medium' ) ); ?>"><?php _e( 'Support Forum &rarr;', 'medium' ); ?></a>
				</li>
			</ul>

			<!-- Help file panel -->
			<div id="help-panel" class="panel visible clearfix">
				<div class="panel-left">
					<!-- Grab feed of help file -->
					<?php
						include_once( ABSPATH . WPINC . '/feed.php' );

						$rss = fetch_feed( 'http://array.is/articles/' . $theme_name_lower . '/feed/?withoutcomments=1' );

						if ( ! is_wp_error( $rss ) ) :
						    $maxitems = $rss->get_item_quantity( 1 );
						    $rss_items = $rss->get_items( 0, $maxitems );
						endif;
					?>

					<!-- Output the feed -->
					<?php if ( is_wp_error( $rss ) ) : ?>
						<p><?php _e( 'This help file feed seems to be temporarily down. You can view the help file on Array in the mean time.', 'medium' ); ?> <a href="https://array.is/articles/<?php echo $theme_name_lower; ?>" title="View help file"><?php echo $theme['Name']; ?> <?php _e( 'Help File &rarr;', 'medium' ); ?></a></p>
					<?php else : ?>
					    <?php foreach ( $rss_items as $item ) : ?>
							<?php echo $item->get_content(); ?>
					    <?php endforeach; ?>
					<?php endif; ?>
				</div>

				<div class="panel-right">
					<!-- Check to see if theme requires the Array Toolkit -->
				<?php
					if( current_theme_supports( 'array_themes_portfolio_support' ) ||
						current_theme_supports( 'array_themes_gallery_support' ) ||
						current_theme_supports( 'array_themes_slider_support' ) ||
						current_theme_supports( 'array_themes_metabox_support' ) ) {

					if ( !class_exists( 'Array_Toolkit' ) ) { ?>
						<div class="panel-aside">

								<h4><?php _e( 'Install the Array Toolkit', 'medium' ); ?></h4>
								<p><?php _e( 'The Array Toolkit is a plugin that adds various features to your theme.', 'medium' ); ?> <?php echo $theme['Name']; ?> <?php _e( 'requires the Array Toolkit to enable the following features:', 'medium' ); ?></p>

								<ul>
									<?php if( current_theme_supports( 'array_themes_portfolio_support' ) ) { ?>
										<li><?php _e( 'Portfolio Items', 'medium' ); ?></li>
									<?php } ?>

									<?php if( current_theme_supports( 'array_themes_gallery_support' ) ) { ?>
										<li><?php _e( 'Custom Galleries', 'medium' ); ?></li>
									<?php } ?>

									<?php if( current_theme_supports( 'array_themes_slider_support' ) ||
											current_theme_supports( 'array_themes_metabox_support' ) ) { ?>
										<li><?php _e( 'Slider Items', 'medium' ); ?></li>
									<?php } ?>
								</ul>

								<a class="button button-primary thickbox onclick" href="<?php echo esc_url( $adminurl ); ?>" title="<?php esc_attr_e( __( 'Install Array toolkit', 'medium' ) ); ?>"><?php _e( 'Install Array Toolkit Plugin', 'medium' ); ?></a>

						</div>
					<?php } else {
						do_action( 'array_toolkit_getting_started_theme_page' );
					}
				} ?>

					<div class="panel-aside">
						<h4><?php _e( 'Visit the Knowledge Base', 'medium' ); ?></h4>
						<p><?php _e( 'New to the WordPress world? Our Knowledge Base has over 20 video tutorials, from installing WordPress to working with themes and more.', 'medium' ); ?></p>

						<a class="button button-primary" href="https://array.is/articles/" title="<?php esc_attr_e( __( 'Visit the knowledge base', 'medium' ) ); ?>"><?php _e( 'Visit the Knowledge Base', 'medium' ); ?></a>
					</div>
				</div>
			</div><!-- #help-panel -->

			<!-- License panel -->
			<div id="license-panel" class="panel clearfix">
				<div class="panel-left">
					<h3><?php _e( 'Activate your license for seamless updates!', 'medium' ); ?></h3>
					<p>
						<?php
							$license_screenshot = 'http://cl.ly/UKW6/license.jpg?TB_iframe=true&amp;width=1000&amp;height=485';
							printf( __( 'Add your license key to get theme updates without leaving your dashboard! Find your license key in your Array Dashboard in the <a class="thickbox" href="%s">Downloads</a> section. Save your key and then click the Activate button.', 'medium' ), esc_url( $license_screenshot ) );
						?>
					</p>

					<!-- License setting -->
					<form class="enter-license" method="post" action="options.php">
						<?php settings_fields( 'medium_license' ); ?>

						<label class="description" for="medium_license_key"><strong><?php _e( 'Enter your license key:', 'medium'); ?></strong></label>

						<input id="license_key_input" name="medium_license_key" type="text" class="regular-text" value="<?php if( isset( $license ) ) { echo $license; } ?>" />

						<?php submit_button( __( 'Save License Key', 'medium' ) ); ?>

						<?php if( false !== $license ) { ?>
							<div class="activate">
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span class="activate-text"><?php _e( 'Your license is active!', 'medium' ); ?></span>
									<?php wp_nonce_field( 'medium_license_nonce', 'medium_license_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_theme_license_deactivate" value="<?php _e( 'Deactivate License', 'medium' ); ?>"/>
								<?php } else if( $license ) {
									wp_nonce_field( 'medium_license_nonce', 'medium_license_nonce' ); ?>
									<span class="activate-text"><?php _e( 'License saved! Click to activate &rarr;', 'medium' ); ?></span>
									<input type="submit" class="button-secondary" name="edd_theme_license_activate" value="<?php _e( 'Activate License', 'medium' ); ?>"/>
								<?php } ?>
							</div>
						<?php } ?>
					</form><!-- .enter-license -->
				</div><!-- .panel-left -->

				<div class="panel-right">
					<div class="panel-aside">
						<p><strong><?php _e( 'Updating Your Theme', 'medium' ); ?></strong></p>

						<p>
							<?php
								$update_notice = 'http://cl.ly/UKJk/update-notice.jpg?TB_iframe=true&width=883&height=520';
								printf( __( 'Once your license key is activated, you can download and install theme updates by going to Appearance &rarr; Themes. A <a class="thickbox" href="%s">notice</a> will be displayed when an update is available.', 'medium' ), esc_url( $update_notice ) );
							?>
						</p>

						<p><?php _e( 'The update process will grab the latest theme files from Array and replace your current theme. Any changes you&apos;ve made to the theme files will be overwritten, so be sure to back up your theme before updating!', 'medium' ); ?></p>
					</div>
				</div><!-- .panel-right -->
			</div><!-- #license-panel -->

			<!-- Updates panel -->
			<div id="updates-panel" class="panel">
				<div class="panel-left">
					<h3><?php _e( 'Latest Theme Updates', 'medium' ); ?></h3>
					<p><?php echo $changelog; ?></p>
				</div><!-- .panel-left -->
			</div><!-- #updates-panel -->
		</div><!-- .panels -->
	</div><!-- .getting-started -->

	<?php
}

function medium_register_option() {
	// Creates our license setting in the options table
	register_setting('medium_license', 'medium_license_key', 'array_theme_sanitize_license' );
}
add_action('admin_init', 'medium_register_option');


/**
 * Getting Started notice
 */

function medium_getting_started_notice() {
	global $current_user;
	$user_id = $current_user->ID;

	// Getting Started URL
	$getting_started_url = admin_url( 'themes.php?page=medium-getting-started' );

	if ( ! get_user_meta( $user_id, 'medium_getting_started_ignore_notice' ) ) {
		echo '<div class="updated"><p>';

		printf( __( ' %1$s activated! Visit the <a href="%2$s">Getting Started</a> page to view the help file, install the Array Toolkit or ask us a question. ', 'medium' ), wp_get_theme(), esc_url( $getting_started_url ) );

		printf( __( '<a href="%1$s">Hide this notice</a>', 'medium' ), '?medium_getting_started_nag_ignore=0' );

		echo "</p></div>";
	}
}
add_action( 'admin_notices', 'medium_getting_started_notice' );


function medium_getting_started_nag_ignore() {
	global $current_user;
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset( $_GET['medium_getting_started_nag_ignore'] ) && '0' == $_GET['medium_getting_started_nag_ignore'] ) {
			 add_user_meta( $user_id, 'medium_getting_started_ignore_notice', 'true', true );
	}
}
add_action( 'admin_init', 'medium_getting_started_nag_ignore' );


/***********************************************
* Theme updater
***********************************************/

// This is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'MEDIUM_SL_STORE_URL', 'https://array.is' );

// The name of your product. This should match the download name in EDD exactly
define( 'MEDIUM_SL_THEME_NAME', 'Medium WordPress Theme' );

// The theme version to use in the updater. Stores parent version to avoid child conflicts.
define( 'MEDIUM_SL_THEME_VERSION', wp_get_theme( 'medium' )->get( 'Version' ) );

/***********************************************
* Include update class
***********************************************/

if ( !class_exists( 'EDD_SL_Theme_Updater' ) ) {
	// Load our custom theme updater
	include( get_template_directory() . '/includes/admin/theme-updater/theme-updater.php' );
}

function medium_theme_updater() {

	$medium_license = trim( get_option( 'medium_license_key' ) );

	$edd_updater = new EDD_SL_Theme_Updater( array(
			'remote_api_url' => MEDIUM_SL_STORE_URL,     // Our store URL that is running EDD
			'version'        => MEDIUM_SL_THEME_VERSION, // The current theme version we are running
			'license'        => $medium_license,         // The license key (used get_option above to retrieve from DB)
			'item_name'      => MEDIUM_SL_THEME_NAME,    // The name of this theme
			'author'         => 'Array'                  // The author's name
		)
	);
}
add_action( 'admin_init', 'medium_theme_updater' );


/***********************************************
* Gets rid of the local license status option
* when adding a new one
***********************************************/

function array_theme_sanitize_license( $new ) {
	$old = get_option( 'medium_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'medium_license_key_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}


/***********************************************
* Illustrates how to activate a license key.
***********************************************/

function medium_activate_license() {

	if( isset( $_POST['edd_theme_license_activate'] ) ) {
	 	if( ! check_admin_referer( 'medium_license_nonce', 'medium_license_nonce' ) )
			return; // get out if we didn't click the Activate button

		global $wp_version;

		$license = trim( get_option( 'medium_license_key' ) );

		$api_params = array(
			'edd_action' => 'activate_license',
			'license' => $license,
			'item_name' => urlencode( MEDIUM_SL_THEME_NAME )
		);

		$response = wp_remote_get( add_query_arg( $api_params, MEDIUM_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"

		update_option( 'medium_license_key_status', $license_data->license );

	}
}
add_action('admin_init', 'medium_activate_license');


/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function medium_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_theme_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'medium_license_nonce', 'medium_license_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'medium_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( MEDIUM_SL_THEME_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, MEDIUM_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'medium_license_key_status' );

	}
}
add_action('admin_init', 'medium_deactivate_license');


/***********************************************
* Illustrates how to check if a license is valid
***********************************************/

function medium_check_license() {

	global $wp_version;

	$license = trim( get_option( 'medium_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( MEDIUM_SL_THEME_NAME )
	);

	$response = wp_remote_get( add_query_arg( $api_params, MEDIUM_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}