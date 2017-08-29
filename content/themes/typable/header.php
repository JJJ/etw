<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<title><?php wp_title( '|', true, 'right' ); ?> <?php echo bloginfo( 'name' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- media queries -->
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0" />

	<!--[if lte IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/styles/ie.css" media="screen"/>
	<![endif]-->

	<!-- add js class -->
	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<!-- load scripts -->
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header class="header">
		<div class="header-inside clearfix">

			<!-- grab the logo and site title -->
			<?php if ( get_theme_mod( 'typable_customizer_logo' ) ) { ?>
		    	<h1 class="logo-image">
					<a href="<?php echo home_url( '/' ); ?>"><img class="logo" src="<?php echo get_theme_mod( 'typable_customizer_logo' ); ?>" alt="<?php the_title_attribute(); ?>" /></a>
				</h1>
		    <?php } else { ?>
			    <div class="hgroup animated flipInX">
			    	<h1 class="logo-text"><a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ) ?></a></h1>
			    	<h2 class="logo-subtitle"><?php bloginfo( 'description' ) ?></h2>
			    </div>
		    <?php } ?>

		    <!-- nav drawer icons -->
		    <div class="icon-nav animated flipInX">
				<a class="nav-toggle" href="#"><i class="fa fa-bars"></i></a>
		    	<a id="archive-toggle" class="archive-toggle" href="#">
		    		<i class="fa fa-folder"></i>
		    		<i class="fa fa-folder-open"></i>
		    	</a>
			    <a class="search-toggle" href="#"><i class="fa fa-search"></i></a>

			    <!-- add widget toggle if there are widgets -->
			    <?php if ( is_active_sidebar( 'widget-drawer' ) ) { ?>
			    	<a class="drawer-toggle" href="#"><i class="fa fa-list-alt"></i></a>
			    <?php } ?>
		    </div>

		    <!-- search form toggle -->
		    <div id="searchform" class="header-panel">
				<?php get_search_form(); ?>
			</div>

			<!-- nav menu toggle -->
			<div id="nav-list" class="header-panel">
				<?php wp_nav_menu( array('theme_location' => 'main', 'menu_class' => 'nav' ) ); ?>
			</div>

			<!-- latest posts toggle -->
			<div id="archive-list" class="header-panel">
				<ul>
					<?php
						global $post;
						$args = array( 'numberposts' => 10 );
						$archive_posts = get_posts( $args );
						foreach( $archive_posts as $post ) : setup_postdata( $post );
					?>

					<li><span><?php echo get_the_date( 'm.d.y' ); ?></span> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></li>

					<?php endforeach; wp_reset_postdata(); ?>
				</ul>
			</div>

			<!-- widget toggle -->
			<?php if ( is_active_sidebar( 'widget-drawer' ) ) { ?>
				<div id="widget-drawer" class="header-panel">
					<div class="widget-drawer-wrap">
						<?php dynamic_sidebar( 'widget-drawer' ); ?>
					</div>
				</div>
			<?php } ?>
	    </div>
	</header>

	<div id="wrapper">
		<div id="main">