<?php
$avada_theme = wp_get_theme();
if($avada_theme->parent_theme) {
	$template_dir =  basename(get_template_directory());
	$avada_theme = wp_get_theme($template_dir);
}
$avada_version = $avada_theme->get( 'Version' );
$plugins = TGM_Plugin_Activation::$instance->plugins;
$installed_plugins = get_plugins();
?>
<div class="wrap about-wrap avada-wrap">
	<h1><?php echo __( "Welcome to Avada!", "Avada" ); ?></h1>
	<?php add_thickbox(); ?>
	<div class="about-text"><?php echo __( "Avada is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it! <a href='//www.youtube.com/embed/dn6g_gJDAIk?rel=0&TB_iframe=true&height=540&width=960' class='thickbox' title='Guided Tour of Avada'>Watch Our Quick Guided Tour!</a>", "Avada" ); ?></div>
	<div class="avada-logo"><span class="avada-version"><?php echo __( "Version", "Avada"); ?> <?php echo $avada_version; ?></span></div>
	<h2 class="nav-tab-wrapper">
		<?php 
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada' ), __( "Product Registration", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-support' ), __( "Support", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-demos' ), __( "Install Demos", "Avada" ) );
		printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', __( "Fusion Plugins", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-system-status' ), __( "System Status", "Avada" ) );
		?>
	</h2>
	 <div class="avada-important-notice">
		<p class="about-description">These are the plugins we include with Avada.  Currently Fusion Core is the only required plugin that is needed to use Avada. You can activate, deactivate or update the plugins from this tab.  In addition, we are very excited about new products being released in 2015. <a href="http://theme-fusion.us2.list-manage2.com/subscribe?u=4345c7e8c4f2826cc52bb84cd&id=af30829ace" target="_blank">Subscribe to our newsletter</a> to be notified when they are ready.</p>
	</div>
	<div class="avada-demo-themes avada-install-plugins">
		<div class="feature-section theme-browser rendered">
			<?php
			foreach( $plugins as $plugin ):
				$class = '';
				$plugin_status = '';
				$file_path = $plugin['file_path'];
				$plugin_action = $this->plugin_link( $plugin );

				if( is_plugin_active( $file_path ) ) {
					$plugin_status = 'active';
					$class = 'active';
				}
			?>
			<div class="theme <?php echo $class; ?>">
				<div class="theme-screenshot">
					<img src="<?php echo $plugin['image_url']; ?>" alt="" />
				</div>
				<h3 class="theme-name">
					<?php
					if( $plugin_status == 'active' ) {
						echo sprintf( '<span>%s</span> ', __( 'Active:', 'Avada' ) );
					}
					echo $plugin['name'];
					?>
				</h3>
				<div class="theme-actions">
					<?php foreach( $plugin_action as $action ) { echo $action; } ?>
				</div>
				<?php if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
				<div class="theme-update">Update Available: Version <?php echo $plugin['version']; ?></div>
				<?php endif; ?>

				<?php if( isset( $installed_plugins[$plugin['file_path']] ) ): ?> 
				<div class="plugin-info">
					<?php echo sprintf('Version %s | %s', $installed_plugins[$plugin['file_path']]['Version'], $installed_plugins[$plugin['file_path']]['Author'] ); ?>
				</div>
				<?php endif; ?>
				<?php if( $plugin['required'] ): ?>
				<div class="plugin-required">
					<?php _e( 'Required', 'Avada' ); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/coming_soon.png'; ?>" alt="" />
				</div>
			</div>
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/coming_soon.png'; ?>" alt="" />
				</div>
			</div>
			<div class="theme">
				<div class="theme-screenshot">
					<img src="<?php echo AVADA_ADMIN_DIR . '../assets/images/coming_soon.png'; ?>" alt="" />
				</div>
			</div>
		</div>
	</div>
	<div class="avada-thanks">
		<hr />
		<p class="description"><?php echo __( "Thank you for choosing Avada. We are honored and are fully dedicated to making your experience perfect.", "Avada" ); ?></p>
	</div>
</div>