<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Camera
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	/* Define options */
	$logo = get_theme_mod( 'camera_customizer_logo' );
?>

<div class="sidebar-toggle">
	<div class="flyout-toggle"><i class="fa fa-bars"></i></div>
</div><!-- .sidebar-toggle -->

<div id="secondary" class="widget-area">

	<div class="flyout-toggle"><i class="fa fa-times"></i> <?php _e( 'Close', 'camera' ); ?></div>

	<!-- Sidebar widgets -->
	<?php get_sidebar(); ?>

</div><!-- #secondary -->

<div class="site-header">

	<nav id="site-navigation" class="main-navigation widget" role="navigation">
		<?php wp_nav_menu( array(
			'theme_location' => 'primary'
		) );?>
	</nav><!-- #site-navigation -->

	<?php if ( function_exists( 'the_site_logo' ) && has_site_logo() ) { ?>
		<!-- Use the Site Logo feature, if supported -->
		<h1 class="site-logo">
			<?php the_site_logo(); ?>
		</h1>
	<?php } else { ?>
		<?php if ( ! function_exists( 'the_site_logo' ) && ! empty( $logo ) ) { ?>
			<!-- Use the standard Customizer logo -->
			<h1 class="site-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
			</h1>
		<?php } ?>
	<?php } ?>

	<?php if( function_exists( 'the_site_logo' ) && ! has_site_logo() || ( ! function_exists( 'the_site_logo' ) && empty( $logo ) ) ) { ?>
		<!-- Site avatar, title and description -->
		<div class="site-title-wrap">
			<a class="site-avatar <?php if ( get_theme_mod( 'camera_show_avatar', '1' ) ) { ?>show-avatar<?php } ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php echo get_avatar( get_option( 'admin_email' ), 120 ); ?>
			</a>

			<div class="site-titles">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>
		</div>
	<?php } ?>
</div>

<div id="page" class="hfeed site <?php if ( get_theme_mod( 'camera_show_sidebar' ) ) { echo 'sidebar-open'; } ?>">
	<div id="content" class="site-content">
