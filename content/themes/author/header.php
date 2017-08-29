<?php
/**
 *
 * Displays all of the <head> section and everything before <div id="content-wrap">
 *
 * @package Author
 * @since Author 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/styles/ie.css" media="screen"/>
	<![endif]-->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="wrapper" class="clearfix">

		<div id="main" class="clearfix">
			<div class="header-wrapper clearfix">
				<div class="header-inside clearfix">
					<a class="menu-toggle" href="#"><i class="fa fa-bars"></i></a>
					<!-- load the logo -->
					<?php if ( get_theme_mod( 'author_customizer_logo' ) ) { ?>
						<div class="logo-img">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img class="logo" src="<?php echo esc_url( get_theme_mod( 'author_customizer_logo' ) );?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
						</div>
					<!-- otherwise show the site title and description -->
					<?php } else { ?>
						<div class="logo-default">
							<div class="logo-text">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
								<span><?php bloginfo( 'description' ) ?></span>
							</div>
						</div>
					<?php } ?>

					<?php if ( has_nav_menu( 'main' ) ) { ?>
					<div class="top-bar">
						<div class="menu-wrap">
							<?php wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'main-nav clearfix' ) ); ?>
						</div>
					</div><!-- top bar -->
					<?php } ?>
				</div><!-- header inside -->
			</div><!-- header wrapper -->

			<!-- secondary menu -->
			<?php if ( has_nav_menu( 'secondary' ) ) { ?>
				<div class="secondary-menu-wrap">
					<div class="secondary-menu-wrap-inside">
						<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_class' => 'secondary-menu' ) ); ?>
					</div>
				</div>
			<?php } ?>
