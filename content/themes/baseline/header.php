<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Baseline
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
<nav id="slideout-menu" class="slideout-menu">
	<!-- Sidebar navigation -->
	<nav id="site-navigation" class="sidebar-navigation" role="navigation">
		<!-- Get the main navigation for mobile -->
		<div class="mobile-menu">
		<?php wp_nav_menu( array(
			'theme_location' => 'primary',
			'fallback_cb'    => 'wp_page_menu'
		) );?>
		</div>
	</nav><!-- #site-navigation -->

	<?php get_sidebar(); ?>
</nav>

<?php if ( 'enabled' === get_theme_mod( 'baseline_browse_drawer', 'enabled' ) ) { ?>
	<div class="category-drawer header-drawer">
		<button class="sort-list-toggle"><?php esc_html_e( 'Categories', 'baseline' ); ?> <i class="fa fa-caret-down"></i></button>
		<?php wp_nav_menu( array(
			'theme_location' => 'category-header',
			'fallback_cb'    => 'baseline_fallback_category_menu',
			'menu_id'        => 'category-menu',
			'menu_class'     => 'sort-list',
			'depth'          => 1,
		) );?>

		<div class="featured-posts-wrap clear">
			<div class="featured-posts clear">
				<div class="post-container clear"></div>
			</div>
		</div><!-- .featured-posts -->
	</div><!-- .category-drawer -->
<?php } ?>

<div class="fixed-nav">
	<div class="container">
		<div class="menu-toggle fixed-toggle">
			<i class="fa"></i> <span><?php echo baseline_menu_button_text(); ?></span>
		</div>

		<?php
		// Get the social icon menu
		if ( has_nav_menu( 'social' ) ) { ?>
			<div class="fixed-nav-right">
				<nav class="social-navigation" role="navigation">
					<?php wp_nav_menu( array(
						'theme_location' => 'social',
						'depth'          => 1,
						'fallback_cb'    => false
					) );?>
				</nav><!-- .footer-navigation -->
			</div>
		<?php } ?>

		<?php if ( 'enabled' === get_theme_mod( 'baseline_browse_drawer', 'enabled' ) ) { ?>
			<div class="browse-button">
				<div class="browse-toggle fixed-toggle"><i class="fa"></i> <span><?php echo baseline_browse_button_text(); ?></span></div>
			</div>
		<?php } ?>
	</div><!-- .container -->
</div><!-- .fixed-nav -->

<header id="masthead" class="site-header" role="banner">
	<!-- Site title and logo -->
	<div class="site-title-wrap">
		<?php baseline_title_logo(); ?>

		<!-- Get the header background image -->
		<?php
			// Get header opacity from Appearance > Customize > Header & Footer Image
			$header_opacity = get_theme_mod( 'baseline_bg_opacity', '0.1' );
			$header_image = get_header_image();
			if ( ! empty( $header_image ) ) { ?>

			<div class="site-header-bg-wrap">
				<div class="site-header-bg background-effect" style="background-image: url(<?php header_image(); ?>); opacity: <?php echo esc_attr( $header_opacity ); ?>;"></div>
			</div>
		<?php } ?>
	</div>

	<!-- Get the main menu -->
	<nav class="main-navigation" role="navigation">
		<?php wp_nav_menu( array(
			'theme_location' => 'primary',
			'fallback_cb'    => 'wp_page_menu'
		) );?>
	</nav><!-- .main-navigation -->
</header><!-- #masthead -->

<div id="page" class="hfeed site">
	<div id="content" class="site-content">
