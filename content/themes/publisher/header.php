<?php
/**
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Publisher
 * @since Publisher 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page">
	<div class="navigation-wrap clearfix">
		<div class="navigation-wrap-inside clearfix">
			<nav role="navigation" class="site-navigation main-navigation">
				<div id="menu-button" class="assistive-text menu-button"><i class="fa fa-bars"></i> <?php _e( 'Menu', 'publisher' ); ?></div>
				<div class="assistive-text skip-link"><a href="#content"><?php _e( 'Skip to content', 'publisher' ); ?></a></div>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- .site-navigation .main-navigation -->

			<!-- Grab header icons template -->
			<?php get_template_part( 'templates/template-icons' ); ?>
		</div><!-- .navigation-wrap-inside -->
	</div><!-- .navigation-wrap -->

	<header id="masthead" class="site-header" role="banner" <?php if ( '' != get_header_image() ) { ?>style="background-image: url('<?php echo header_image(); ?>');"<?php } ?>>

		<div class="header-wrap">
			<div class="hgroup">
				<?php if ( get_theme_mod( 'publisher_customizer_logo' ) ) { ?>
			    	<h1 class="logo-image">
						<a href="<?php echo home_url( '/' ); ?>">
							<img src="<?php echo esc_url( get_theme_mod( 'publisher_customizer_logo' ) );?>" alt="<?php the_title(); ?>" />
							<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
						</a>
					</h1>
			    <?php } else { ?>
					<h1 class="site-title animated flipInY"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h1>
					<h2 class="site-description animated fadeIn"><?php bloginfo( 'description' ); ?></h2>
				<?php } ?>
			</div>
		</div><!-- .header-wrap -->
	</header><!-- #masthead .site-header -->
