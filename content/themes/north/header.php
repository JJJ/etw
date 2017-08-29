<?php
/**
 *
 * Displays all of the <head> section and everything through <div class="inside-wrap clearfix">
 *
 * @package North
 * @since 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- media queries -->
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/styles/ie.css" media="screen"/>
	<![endif]-->

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="header-wrap clearfix">
		<div class="container">
			<!-- mobile nav toggle -->
			<a class="nav-toggle" href="#"><i class="fa fa-bars"></i></a>

			<header class="header">
				<?php if ( get_theme_mod( 'north_logo_upload' ) ) { ?>
			    	<h1 class="logo-image">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="logo" src="<?php echo get_theme_mod( 'north_logo_upload' ); ?>" alt="<?php the_title_attribute(); ?>" /></a>
					</h1>
			    <?php } else { ?>
				    <hgroup>
				    	<h1 class="logo-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo( 'name' ) ?></a></h1>
				    </hgroup>
			    <?php } ?>

			    <!-- main navigation -->
			    <nav role="navigation" class="header-nav">
			    	<?php wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'nav' ) ); ?>
			    </nav>
			</header>
		</div><!-- container -->
	</div><!-- header wrap -->

	<div id="wrapper" class="clearfix">
		<div class="inside-wrap clearfix">