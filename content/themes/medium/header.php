<?php
/**
 *
 * Displays all of the <head> section and everything through <div class="main">
 *
 * @package Medium
 * @since 1.0
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

	<!-- media queries -->
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0" />

	<!--[if lte IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/styles/ie.css" media="screen"/>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/includes/js/IE/ie-html5.js"></script>
	<![endif]-->

	<!-- add js class -->
	<script type="text/javascript">document.documentElement.className = 'js';</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="body-wrap">
		<header class="header">
			<div class="nano">
				<div class="navigation-inner">
					<div class="header-search">
						<?php get_search_form();?>
						<a class="menu-toggle" href="#"><?php _e( 'Menu', 'medium' ); ?> <i class="fa fa-bars"></i></a>
					</div>

					<?php if ( get_theme_mod( 'medium_customizer_logo' ) ) { ?>

						<hgroup>
							<h1 class="logo-image">
								<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
									<img class="logo" src="<?php echo get_theme_mod( 'medium_customizer_logo', '' ); ?>" alt="<?php bloginfo('name'); ?>"/>
								</a>
							</h1>
						</hgroup>

					<?php } else { ?>

						<hgroup>
							<h1 class="logo-text"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name') ?></a></h1>
							<h2 class="logo-subtitle"><?php bloginfo('description') ?></h2>
						</hgroup>

					<?php } ?>

					<nav role="navigation" class="header-nav open-widget">
						<?php wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'nav', 'container' => false ) ); ?>
					</nav>

					<div class="widgets">
						<?php dynamic_sidebar( 'left-sidebar' ); ?>
					</div>
				</div>
			</div>
		</header>

		<div id="wrapper">
			<div id="main">
