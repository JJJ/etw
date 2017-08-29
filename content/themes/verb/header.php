<?php
/**
 *
 * Displays the header and loads scripts via wp_head.
 *
 * @package Verb
 * @since Verb 1.0
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

	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/styles/ie9.css" media="screen"/>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/styles/ie.css" media="screen"/>
	<![endif]-->

	<!-- load scripts -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!-- responsive menu -->
	<div id="menu-canvas"></div>

	<div class="container">
		<div class="header-wrap clearfix">
			<header class="header">
				<!-- grab the logo and site title -->
				<?php if ( $logo = get_theme_mod( 'verb_customizer_logo' ) ) { ?>
			    	<h1 class="logo-image">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="logo" src="<?php echo esc_url( $logo ); ?>" alt="<?php the_title_attribute(); ?>" /></a>
					</h1>
			    <?php } else { ?>

				    <hgroup>
				    	<h1 class="logo-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name') ?></a></h1>
				    	<h2 class="logo-subtitle"><?php bloginfo('description') ?></h2>
				    </hgroup>

			    <?php } ?>

			    <nav role="navigation" class="header-nav">
			    	<!-- nav menu -->
			    	<?php wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'nav' ) ); ?>
			    </nav>

			    <a class="nav-toggle" href="#"><i class="fa fa-bars"></i></a>
			</header>
		</div>

		<div id="wrapper" class="clearfix">
			<div class="inside-wrap clearfix">