<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Candid
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<button class="menu-toggle" type="button">
	<span class="button-open"><i class="fa fa-bars"></i> <?php esc_html_e( 'Menu', 'candid' ); ?></span>
	<span class="button-close"><i class="fa fa-times"></i> <?php esc_html_e( 'Close Menu', 'candid' ); ?></span>
</button>

<header id="masthead" class="site-header" role="banner">
	<div class="container">
		<!-- Site title and logo -->
		<?php candid_title_logo(); ?>

		<!-- Main navigation -->
		<div class="mobile-overlay">
			<div class="mobile-overlay-inside">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'primary'
					) );?>
				</nav><!-- #site-navigation -->

				<?php get_search_form(); ?>
			</div>
		</div><!-- .mobile-overlay -->
	</div><!-- .container -->
</header><!-- #masthead -->

<div id="page" class="hfeed site container">
	<div id="content" class="site-content">
