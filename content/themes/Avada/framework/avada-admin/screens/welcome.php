<?php
$avada_theme = wp_get_theme();
if($avada_theme->parent_theme) {
    $template_dir =  basename(get_template_directory());
    $avada_theme = wp_get_theme($template_dir);
}
$avada_version = $avada_theme->get( 'Version' );
$avada_options = get_option( 'Avada_Key' );
$registration_complete = false;
$tf_username = isset( $avada_options[ 'tf_username' ] ) ? $avada_options[ 'tf_username' ] : '';
$tf_api = isset( $avada_options[ 'tf_api' ] ) ? $avada_options[ 'tf_api' ] : '';
$tf_purchase_code = isset( $avada_options[ 'tf_purchase_code' ] ) ? $avada_options[ 'tf_purchase_code' ] : '';
if( $tf_username !== "" && $tf_api !== "" && $tf_purchase_code !== "" ) {
	$registration_complete = true;
}
$theme_fusion_url = 'https://theme-fusion.com/';
?>
<div class="wrap about-wrap avada-wrap">
	<h1><?php echo __( "Welcome to Avada!", "Avada" ); ?></h1>
    
	<div class="updated registration-notice-1" style="display: none;"><p><strong><?php echo __( "Thanks for registering your purchase. You will now receive the automatic updates.", "Avada" ); ?> </strong></p></div>
    
	<div class="updated error registration-notice-2" style="display: none;"><p><strong><?php echo __( "Please provide all the three details for registering your copy of Avada.", "Avada" ); ?>.</strong></p></div>
    
	<div class="updated error registration-notice-3" style="display: none;"><p><strong><?php echo __( "Something went wrong. Please verify your details and try again.", "Avada" ); ?></strong></p></div>
    
	<div class="about-text"><?php echo __( "Avada is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it! <a href='//www.youtube.com/embed/dn6g_gJDAIk?rel=0&TB_iframe=true&height=540&width=960' class='thickbox' title='Guided Tour of Avada'>Watch Our Quick Guided Tour!</a>", "Avada" ); ?></div>
    <div class="avada-logo"><span class="avada-version"><?php echo __( "Version", "Avada" ); ?> <?php echo $avada_version; ?></span></div>
	<h2 class="nav-tab-wrapper">
    	<?php
		printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', __( "Product Registration", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-support' ), __( "Support", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-demos' ), __( "Install Demos", "Avada" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-plugins' ), __( "Fusion Plugins", "Avada" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-system-status' ), __( "System Status", "Avada" ) );
		?>
	</h2>
<!--    <p class="about-description"><span class="dashicons dashicons-admin-network avada-icon-key"></span><?php echo __( "Your Purchase Must Be Registered To Receive Theme Support & Auto Updates", "Avada" ); ?></p> -->
	<div class="avada-registration-steps">
    	<div class="feature-section col three-col">
        	<div>
				<h4><?php echo __( "Step 1 - Signup for Support", "Avada" ); ?></h4>
				<p><?php printf( '<a href="%s" target="_blank">%s</a> ', $theme_fusion_url . 'support/?from_theme=1', __( "Click here", "Avada" ) ); echo __("to signup at our support center.", "Avada" ); echo __( "&nbsp;View a tutorial&nbsp;", "Avada" );
				printf( '<a href="%s" target="_blank">%s</a>', $theme_fusion_url . 'avada-doc/getting-started/free-forum-support/', __( "here.", "Avada" ) );  echo __( "&nbsp;This gives you access to our documentation, knowledgebase, video tutorials and ticket system.", "Avada" ); ?></p>
            </div>
            <div>
				<h4><?php echo __( "Step 2 - Generate an API Key", "Avada" ); ?></h4>
				<p><?php echo __( 'Once you registered at our support center, you need to generate a product API key under the "Licenses" section of your Themeforest account. View a tutorial&nbsp;', 'Avada' );
				printf( '<a href="%s" target="_blank">%s</a>.',$theme_fusion_url . 'avada-doc/install-update/generate-themeforest-api/',  __('here', "Avada" ) ); ?></p>
            </div>
        	<div class="last-feature">
				<h4><?php echo __( "Step 3 - Purchase Validation", "Avada" ); ?></h4>
				<p><?php echo __( "Enter your ThemeForest username, purchase code and generated API key into the fields below. This will give you access to automatic theme updates.", "Avada" ); ?></p>
            </div>
        </div>
        <!--<div class="start_registration_button">
        	 <?php printf( '<a href="%s" class="button button-large button-primary avada-large-button" target="_blank">%s</a>', $theme_fusion_url . 'support/',  __( "Start Registration Now!", "Avada" ) ); ?>
        </div>-->
    </div>
    <div class="avada-important-notice registration-form-container">
    	<?php
		if( $registration_complete ) {
			echo '<p class="about-description"><span class="dashicons dashicons-yes avada-icon-key"></span>' . __("Registration Complete! Thank you for registering your purchase, you can now receive automatic updates, theme support and future goodies.", "Avada") . '</p>';
		} else {
		?>
		<p class="about-description"><?php echo __( "After Steps 1-2 are complete, enter your credentials below to complete product registration.", "Avada" ); ?></p>
        <?php } ?>
        <div class="avada-registration-form">
        	<form id="avada_product_registration">
                <input type="hidden" name="action" value="avada_update_registration" />
                <input type="text" name="tf_username" id="tf_username" placeholder="<?php echo __( "Themeforest Username", "Avada" ); ?>" value="<?php echo $tf_username; ?>" />
                <input type="text" name="tf_purchase_code" id="tf_purchase_code" placeholder="<?php echo __( "Enter Themeforest Purchase Code", "Avada" ); ?>" value="<?php echo $tf_purchase_code; ?>" />
                <input type="text" name="tf_api" id="tf_api" placeholder="<?php echo __( "Enter API Key", "Avada" ); ?>" value="<?php echo $tf_api; ?>" />
            </form>
        </div>
        <button class="button button-large button-primary avada-large-button avada-register"><?php echo __( "Submit", "Avada" ); ?></button>
        <span class="avada-loader"><i class="dashicons dashicons-update loader-icon"></i><span></span></span>
    </div>
    <div class="avada-thanks">
        <hr />
    	<p class="description"><?php echo __( "Thank you for choosing Avada. We are honored and are fully dedicated to making your experience perfect.", "Avada" ); ?></p>
    </div>
</div>