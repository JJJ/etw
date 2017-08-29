<?php
/**
 *
 * Displays all of the <head> section.
 *
 * @package Transmit
 * @since Transmit 1.0
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

	<div id="main" class="clearfix">
		<div id="page" class="clearfix animated fadeIn">
			<div class="header-wrap">
				<div class="header-top">
					<div id="logo">
						<!-- grab the logo -->
						<?php if ( get_theme_mod('transmit_customizer_logo') ) { ?>
					    	<h1 class="logo-img">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<img class="logo" src="<?php echo esc_url( get_theme_mod( 'transmit_customizer_logo' ) );?>" alt="<?php the_title_attribute(); ?>" />
								</a>
							</h1>
						<!-- otherwise show the site title and description -->
				        <?php } else { ?>
				            <h1 id="logo-text">
				            	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo('name') ?></a>
				            </h1>
				        <?php } ?>
			        </div><!-- logo -->

			        <a href="#" class="menu-toggle"><i class="fa fa-bars"></i></a>
		        </div><!-- header top -->
			</div><!-- header wrap -->

			<div class="main-menu">
				<?php wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'nav' ) ); ?>
			</div>