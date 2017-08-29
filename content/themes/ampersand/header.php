<?php
/**
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page">
	<header id="masthead" class="site-header" role="banner">
		<div class="header-wrap">
			<div class="header-inside">
				<div class="navigation-wrap clearfix">
					<div class="hgroup">
						<?php ampersand_title_logo(); ?>
					</div>

					<div class="navigation-wrap-inside clearfix">
						<div class="navigation-toggle">
							<nav role="navigation" class="site-navigation main-navigation">
								<h1 class="menu-toggle"><i class="fa fa-bars"></i> <?php _e( 'Menu', 'ampersand' ); ?></h1>
								<div class="assistive-text skip-link"><a href="#content"><?php _e( 'Skip to content', 'ampersand' ); ?></a></div>
									<?php
										wp_nav_menu( array(
											'theme_location' => 'primary',
											'container_class'      => 'menu',
										));
									?>
							</nav><!-- .site-navigation .main-navigation -->
						</div>
					</div><!-- .navigation-wrap-inside -->
				</div><!-- .navigation-wrap -->

				<?php get_template_part( 'template-titles' ); ?>
			</div><!-- .header-inside -->
		</div><!-- .header-wrap -->
	</header><!-- #masthead .site-header -->

	<div class="inside-page animated fadeIn">
