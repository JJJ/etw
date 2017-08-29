<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Atomic
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

<header id="masthead" class="site-header">
	<!-- Get the header background image -->
	<?php
		$header_opacity = get_theme_mod( 'atomic_bg_opacity', '.5' );
		$header_image = get_header_image();
		if ( ! empty( $header_image ) ) { ?>
		<div class="site-header-bg-wrap">
			<div class="site-header-bg background-effect" style="background-image: url(<?php header_image(); ?>); opacity: <?php echo esc_attr( $header_opacity ); ?>;"></div>
		</div>
	<?php } ?>

	<div class="top-navigation">
		<?php
			// Get the mobile menu
			get_template_part( 'template-parts/content-menu-drawer' );
		?>

		<div class="container">
			<div class="site-identity clear">
				<!-- Site title and logo -->
				<?php atomic_title_logo(); ?>

				<div class="top-navigation-right">
					<!-- Main navigation -->
					<nav id="site-navigation" class="main-navigation">
						<?php wp_nav_menu( array(
							'theme_location' => 'primary'
						) );?>
					</nav><!-- .main-navigation -->
				</div><!-- .top-navigation-right -->
			</div><!-- .site-identity-->
		</div><!-- .container -->
	</div><!-- .top-navigation -->

	<!-- Get the header background image -->
	<?php if ( is_front_page() ) { ?>
			<div class="container text-container">
				<?php
					$header_title    = get_theme_mod( 'atomic_header_title' );
					$header_subtitle = get_theme_mod( 'atomic_header_subtitle' );

					if ( $header_title || $header_subtitle ) {
				?>
					<div class="header-text">
						<?php if ( $header_title ) { ?>
							<h2><?php echo esc_html( $header_title ); ?></h2>
						<?php } ?>

						<?php if ( $header_subtitle ) { ?>
							<p><?php echo esc_html( $header_subtitle ); ?></p>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
	<?php } ?>
</header><!-- .site-header -->

<?php
// Sticky bar for single pages
if( is_single() ) { ?>
	<nav class="home-nav single-nav">
		<h2 class="sticky-title"><?php the_title(); ?></h2>

		<?php
			// Sharing Buttons
			if ( function_exists( 'sharing_display' ) ) {
				echo sharing_display();
			}
		?>
	</nav>
<?php } ?>

<?php
	// Get the featured content for the blog
	get_template_part( 'template-parts/content-featured-content' );
?>

<?php
	if ( is_front_page() && !is_home() ) {
		$container = 'home-container';
	} else {
		$container = 'container';
	}
?>

<div id="page" class="hfeed site <?php echo $container; ?>">
	<div id="content" class="site-content">
