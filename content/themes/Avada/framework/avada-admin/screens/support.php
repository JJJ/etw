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
		printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', __( "Support", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-demos' ), __( "Install Demos", "Avada" ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-plugins' ), __( "Fusion Plugins", "Avada" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=avada-system-status' ), __( "System Status", "Avada" ) );
		?>
	</h2>
    <div class="avada-important-notice">
		<p class="about-description"><?php echo __( "To access our support forum and resources, you first must register your purchase.<br /> 
See the", "Avada" ); ?> <?php printf( '<a href="%s">%1s</a> %2s', admin_url( 'admin.php?page=avada' ), __( "Product Registration", "Avada" ), __("tab for instructions on how to complete registration.", "Avada" ) ); ?></p>
    </div>
	<div class="avada-registration-steps">
    	<div class="feature-section col three-col">
        	<div>
				<h4><span class="dashicons dashicons-sos"></span><?php echo __( "Submit A Ticket", "Avada" ); ?></h4>
				<p><?php echo __( "We offer excellent support through our advanced ticket system. Make sure to register your purchase first to access our support and other resources.", "Avada" ); ?></p>
                <?php printf( '<a href="%s" class="button button-large button-primary avada-large-button" target="_blank">%s</a>', $theme_fusion_url . 'support-ticket/', __( "Submit A Ticket", "Avada" ) ); ?>
            </div>
            <div>
				<h4><span class="dashicons dashicons-book"></span><?php echo __( "Documentation", "Avada" ); ?></h4>
				<p><?php echo __( "This is the place to go to reference different aspects of the theme. Our online documentaiton is an incredible resource for learning the ins and outs of using Avada.", "Avada" ); ?></p>
                <?php printf( '<a href="%s" class="button button-large button-primary avada-large-button" target="_blank">%s</a>', $theme_fusion_url . 'support/documentation/avada-documentation/', __( "Documentation", "Avada" ) ); ?>
            </div>
        	<div class="last-feature">
				<h4><span class="dashicons dashicons-portfolio"></span><?php echo __( "Knowledgebase", "Avada" ); ?></h4>
				<p><?php echo __( "Our knowledgebase contains additional content that is not inside of our documentation. This information is more specific and unique to various versions or aspects of Avada.", "Avada" ); ?></p>
                <?php printf( '<a href="%s" class="button button-large button-primary avada-large-button" target="_blank">%s</a>', $theme_fusion_url . 'support/knowledgebase/', __( "Knowledgebase", "Avada" ) ); ?>
            </div>
            
            
            <div>
            	<h4><span class="dashicons dashicons-format-video"></span><?php echo __( "Video Tutorials", "Avada" ); ?></h4>
				<p><?php echo __( "Nothing is better than watching a video to learn. We have a growing library of high-definititon, narrated video tutorials to help teach you the different aspects of using Avada.", "Avada" ); ?></p>
                <?php printf( '<a href="%s" class="button button-large button-primary avada-large-button" target="_blank">%s</a>', $theme_fusion_url . 'support/video-tutorials/avada-videos/', __( "Watch Videos", "Avada" ) ); ?>
            </div>
            
            
            <div>
				<h4><span class="dashicons dashicons-groups"></span><?php echo __( "Community Forum", "Avada" ); ?></h4>
				<p><?php echo __( "We also have a community forum for user to user interactions. Ask another Avada user! Please note that ThemeFusion does not provide product support here.", "Avada" ); ?></p>
                <?php printf( '<a href="%s" class="button button-large button-primary avada-large-button" target="_blank">%s</a>', $theme_fusion_url . 'support/forum/', __( "Community Forum", "Avada" ) ); ?>
            </div>
            
            
            
        </div>
    </div>
    <div class="avada-thanks">
        <hr />
    	<p class="description"><?php echo __( "Thank you for choosing Avada. We are honored and are fully dedicated to making your experience perfect.", "Avada" ); ?></p>
    </div>
</div>