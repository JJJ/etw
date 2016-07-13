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
	
	<div class="updated error importer-notice importer-notice-1" style="display: none;">
		<p><strong><?php echo __( "We're sorry but the demo data could not import. It is most likely due to low PHP configurations on your server. There are two possible solutions.", 'Avada' ); ?></strong></p>

		<p><strong><?php _e( 'Solution 1:', 'Avada' ); ?></strong> <?php _e( 'Import the demo using alternate method.', 'Avada' ); ?><a href="https://theme-fusion.com/avada-doc/demo-content-info/alternate-demo-method/" class="button-primary" target="_blank" style="margin-left: 10px;"><?php _e( 'Alternate Method', 'Avada' ); ?></a></p>
		<p><strong><?php _e( 'Solution 2:', 'Avada' ); ?></strong> <?php echo sprintf( __( 'Fix the PHP configurations in the System Status that are reported in <strong style="color: red;">RED</strong>, then use %s, then reimport.', 'Avada' ), '<a href="' . admin_url() . 'plugin-install.php?tab=plugin-information&amp;plugin=wordpress-reset&amp;TB_iframe=true&amp;width=830&amp;height=472' . '">Reset WordPress Plugin</a>' ); ?><a href="<?php echo admin_url( 'admin.php?page=avada-system-status' ); ?>" class="button-primary" target="_blank" style="margin-left: 10px;"><?php _e( 'System Status', 'Avada' ); ?></a></p>
	</div>

	<div class="updated importer-notice importer-notice-2" style="display: none;"><p><strong><?php echo __( "Demo data successfully imported. Now, please install and run", "Avada" ); ?> <a href="<?php echo admin_url();?>plugin-install.php?tab=plugin-information&amp;plugin=regenerate-thumbnails&amp;TB_iframe=true&amp;width=830&amp;height=472" class="thickbox" title="<?php echo __( "Regenerate Thumbnails", "Avada" ); ?>"><?php echo __( "Regenerate Thumbnails", "Avada" ); ?></a> <?php echo __( "plugin once", "Avada" ); ?>.</strong></p></div>
	
	<div class="updated error importer-notice importer-notice-3" style="display: none;">
		<p><strong><?php echo __( "We're sorry but the demo data could not import. It is most likely due to low PHP configurations on your server. There are two possible solutions.", 'Avada' ); ?></strong></p>

		<p><strong><?php _e( 'Solution 1:', 'Avada' ); ?></strong> <?php _e( 'Import the demo using alternate method.', 'Avada' ); ?><a href="https://theme-fusion.com/avada-doc/demo-content-info/alternate-demo-method/" class="button-primary" target="_blank" style="margin-left: 10px;"><?php _e( 'Alternate Method', 'Avada' ); ?></a></p>
		<p><strong><?php _e( 'Solution 2:', 'Avada' ); ?></strong> <?php echo sprintf( __( 'Fix the PHP configurations in the System Status that are reported in <strong style="color: red;">RED</strong>, then use %s, then reimport.', 'Avada' ), '<a href="' . admin_url() . 'plugin-install.php?tab=plugin-information&amp;plugin=wordpress-reset&amp;TB_iframe=true&amp;width=830&amp;height=472' . '">Reset WordPress Plugin</a>' ); ?><a href="<?php echo admin_url( 'admin.php?page=avada-system-status' ); ?>" class="button-primary" target="_blank" style="margin-left: 10px;"><?php _e( 'System Status', 'Avada' ); ?></a></p>
	</div>
	
	<div class="about-text"><?php echo __( "Avada is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it! <a href='//www.youtube.com/embed/dn6g_gJDAIk?rel=0&TB_iframe=true&height=540&width=960' class='thickbox' title='Guided Tour of Avada'>Watch Our Quick Guided Tour!</a>", "Avada" ); ?></div>
	<div class="avada-logo"><span class="avada-version"><?php echo __( "Version", "Avada" ); ?> <?php echo $avada_version; ?></span></div>
	<h2 class="nav-tab-wrapper">
		<?php
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada' ),  __( "Product Registration", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-support' ), __( "Support", "Avada" ) );
		printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', __( "Install Demos", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-plugins' ), __( "Fusion Plugins", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-system-status' ), __( "System Status", "Avada" ) );
		?>
	</h2>
	 <div class="avada-important-notice">
		<p class="about-description"><?php echo __( "Installing a demo provides pages, posts, images, theme options, widgets, sliders and more. IMPORTANT: The included plugins need to be installed and activated before you install a demo. Please check the 'System Status' tab to ensure your server meets all requirements for a successful import. Settings that need attention will be listed in red.", "Avada" ); ?> <?php printf( '<a href="%s" target="_blank">%s</a>', $theme_fusion_url . 'avada-doc/demo-content-info/import-xml-file/', __( "View more info here.", "Avada" ) ); ?></p>
	</div>
	<div class="avada-demo-themes">
		<div class="feature-section theme-browser rendered">
			<!-- Classic -->
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/avada-classic.png'; ?>" />
				</div>
				<h3 class="theme-name" id="classic"><?php echo __( "Avada - Classic", "Avada" ); ?></h3>
				<div class="theme-actions">
					<?php printf( '<a class="button button-primary button-install-demo" data-demo-id="classic" href="#">%1s</a>', __( "Install", "Avada" ) ); ?>
					<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', 'http://theme-fusion.com/avada/', __( "Preview", "Avada" ) ); ?>
				</div>
				<div id="demo-preview-classic" class="screenshot-hover fusion-animated fadeInUp">
					<a href="http://theme-fusion.com/avada/" target="_blank"><img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/classic.jpg'; ?>" /></a>
				</div>
				<div class="demo-import-loader preview-all"></div>
				<div class="demo-import-loader preview-classic"><i class="dashicons dashicons-admin-generic"></i></div>
			</div>
			<!-- Agency -->
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/avada-agency.jpg'; ?>" />
				</div>
				<h3 class="theme-name" id="agency"><?php echo __( "Avada - Agency", "Avada" ); ?></h3>
				<div class="theme-actions">
					<?php printf( '<a class="button button-primary button-install-demo" data-demo-id="agency" href="#">%s</a>', __( "Install", "Avada" ) ); ?>
					<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', 'http://theme-fusion.com/avada_demos/agency/', __( "Preview", "Avada" ) ); ?>
				</div>
				<div id="demo-preview-agency" class="screenshot-hover fusion-animated fadeInUp">
					<a href="http://theme-fusion.com/avada_demos/agency/" target="_blank"><img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/agency.jpg'; ?>" /></a>
				</div>
				<div class="demo-import-loader preview-all"></div>
				<div class="demo-import-loader preview-agency"><i class="dashicons dashicons-admin-generic"></i></div>
			</div>
			<!-- App -->
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/avada-app.jpg'; ?>" />
				</div>
				<h3 class="theme-name" id="app"><?php echo __( "Avada - App", "Avada" ); ?></h3>
				<div class="theme-actions">
					<?php printf( '<a class="button button-primary button-install-demo" data-demo-id="app" href="#">%s</a>', __( "Install", "Avada" ) ); ?>
					<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', 'http://theme-fusion.com/avada_demos/app/', __( "Preview", "Avada" ) ); ?>
				</div>
				<div id="demo-preview-app" class="screenshot-hover fusion-animated fadeInUp">
					<a href="http://theme-fusion.com/avada_demos/app/" target="_blank"><img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/app_popover.jpg'; ?>" /></a>
				</div>
				<div class="demo-import-loader preview-all"></div>
				<div class="demo-import-loader preview-app"><i class="dashicons dashicons-admin-generic"></i></div>
			</div>
			<!-- Travel -->
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/avada-travel.jpg'; ?>" />
				</div>
				<h3 class="theme-name" id="travel"><?php echo __( "Avada - Travel", "Avada" ); ?></h3>
				<div class="theme-actions">
					<?php printf( '<a class="button button-primary button-install-demo" data-demo-id="travel" href="#">%s</a>', __( "Install", "Avada" ) ); ?>
					<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', 'http://theme-fusion.com/avada_demos/travel/', __( "Preview", "Avada" ) ); ?>
				</div>
				<div id="demo-preview-travel" class="screenshot-hover fusion-animated fadeInUp">
					<a href="http://theme-fusion.com/avada_demos/travel/" target="_blank"><img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/travel_popover.jpg'; ?>" /></a>
				</div>
				<div class="demo-import-loader preview-all"></div>
				<div class="demo-import-loader preview-travel"><i class="dashicons dashicons-admin-generic"></i></div>
			</div>
			<!-- Cafe -->
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/avada-cafe.jpg'; ?>" />
				</div>
				<h3 class="theme-name" id="cafe"><?php echo __( "Avada - Cafe", "Avada" ); ?></h3>
				<div class="theme-actions">
					<?php printf( '<a class="button button-primary button-install-demo" data-demo-id="cafe" href="#">%s</a>', __( "Install", "Avada" ) ); ?>
					<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', 'http://theme-fusion.com/avada_demos/cafe/', __( "Preview", "Avada" ) ); ?>
				</div>
				<div id="demo-preview-cafe" class="screenshot-hover fusion-animated fadeInUp">
					<a href="http://theme-fusion.com/avada_demos/cafe/" target="_blank"><img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/cafe_popover.jpg'; ?>" /></a>
				</div>
				<div class="demo-import-loader preview-all"></div>
				<div class="demo-import-loader preview-cafe"><i class="dashicons dashicons-admin-generic"></i></div>
			</div>
			<!-- Fashion -->
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/avada-fashion.jpg'; ?>" />
				</div>
				<h3 class="theme-name" id="fashion"><?php echo __( "Avada - Fashion", "Avada" ); ?></h3>
				<div class="theme-actions">
					<?php printf( '<a class="button button-primary button-install-demo" data-demo-id="fashion" href="#">%s</a>', __( "Install", "Avada" ) ); ?>
					<?php printf( '<a class="button button-primary" target="_blank" href="%1s">%2s</a>', 'http://theme-fusion.com/avada_demos/fashion/', __( "Preview", "Avada" ) ); ?>
				</div>
				<div id="demo-preview-fashion" class="screenshot-hover fusion-animated fadeInUp">
					<a href="http://theme-fusion.com/avada_demos/fashion/" target="_blank"><img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/fashion_popover.jpg'; ?>" /></a>
				</div>
				<div class="demo-import-loader preview-all"></div>
				<div class="demo-import-loader preview-fashion"><i class="dashicons dashicons-admin-generic"></i></div>
			</div>
		</div>
	</div>
	<div class="avada-thanks">
		<hr />
		<p class="description"><?php echo __( "Thank you for choosing Avada. We are honored and are fully dedicated to making your experience perfect.", "Avada" ); ?></p>
	</div>
</div>