<?php get_header(); ?>
	<?php
	$sidebar_exists = true;
	$container_class = '';
	$timeline_icon_class = '';	
	$post_class = '';
	$content_class = '';
	$sidebar_exists = false;
	$sidebar_left = '';
	$double_sidebars = false;

	$sidebar_1 = $smof_data['search_sidebar'];
	$sidebar_2 = $smof_data['search_sidebar_2'];
	if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
		$double_sidebars = true;
	}

	if( $sidebar_1 != 'None' ) {
		$sidebar_exists = true;
	} else {
		$sidebar_exists = false;
	}

	if( ! $sidebar_exists ) {
		$content_css = 'width:100%';
		$sidebar_css = 'display:none';
		$content_class= 'full-width';
		$sidebar_exists = false;
	} elseif($smof_data['search_sidebar_position'] == 'Left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
		$sidebar_left = 1;
	} elseif($smof_data['search_sidebar_position'] == 'Right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
		$sidebar_left = 2;
	}

	if($double_sidebars == true) {
		$content_css = 'float:left;';
		$sidebar_css = 'float:left;';
		$sidebar_2_css = 'float:left;';
	} else {
		$sidebar_left = 1;
	}
	?>
	<div id="content" class="<?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<?php if ( have_posts() && strlen( trim(get_search_query()) ) != 0 ) : ?>
		<div class="search-page-search-form">
			
			<?php 
			// Render the post title
			echo avada_render_post_title( 0, FALSE, __( 'Need a new search?', 'Avada' ) ); ?>
			
			<p><?php echo __('If you didn\'t find what you were looking for, try a new search!', 'Avada'); ?></p>
			<form class="searchform seach-form" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
				<div class="search-table">
					<div class="search-field">
						<input type="text" value="" name="s" class="s" placeholder="<?php _e( 'Search ...', 'Avada' ); ?>"/>
					</div>
					<div class="search-button">
						<input type="submit" class="searchsubmit" value="&#xf002;" />
					</div>
				</div>
			</form>		
		</div>	
		<?php get_template_part( 'templates/blog', 'layout' ); ?>
	<?php else: ?>
	<div class="post-content">
		<?php 
			$title = __( 'Couldn\'t find what you\'re looking for!', 'Avada' );
			echo do_shortcode( sprintf( '[title size="2" content_align="left" style_type="default"]%s[/title]', $title ) ); 
		?>
		<div class="error-page">
			<?php 
			// First column
			echo do_shortcode( sprintf( '[one_third last="no" spacing="yes"]<h1 class="oops %s">%s</h1>[/one_third]', ( $sidebar_css != 'display:none') ? 'sidebar-oops' : '', __( 'Oops!', 'Avada' ) ) );		
			
			// Second column
			$subheading = sprintf( '<h3>%s</h3>', __( 'Here are some useful links:', 'Avada' ) );
			$iconcolor = strtolower( $smof_data['checklist_icons_color'] );
			$list_css = sprintf( '<style type="text/css">.post-content #checklist-1 li:before{color:%s !important;}.rtl .post-content #checklist-1 li:after{color:%s !important;}</style>', $iconcolor, $iconcolor );
			$useful_links_menu = wp_nav_menu( array( 'theme_location' => '404_pages', 'depth' => 1, 'container' => false, 'menu_id' => 'checklist-1', 'menu_class' => 'list-icon circle-yes list-icon-arrow', 'echo' => 0 ) );
		
			echo do_shortcode( sprintf( '[one_third last="no" spacing="yes" class="useful-links"]%s%s%s[/one_third]', $subheading, $list_css, $useful_links_menu ) );
			
			
			// Third column
			$subheading = sprintf( '<h3>%s</h3>', __( 'Try again!', 'Avada' ) );
			$info_text = sprintf( '<p>%s</p>', __( 'If you want to rephrase your query, here is your chance:', 'Avada' ) );
			$search_form = get_search_form( FALSE );
			
			echo do_shortcode( sprintf( '[one_third last="yes" spacing="yes"]%s%s%s[/one_third]', $subheading, $info_text, $search_form ) );
			?>
		</div>
	</div>
	<?php endif; ?>
	</div>
	<?php if( $sidebar_exists == true ): ?>
	<?php wp_reset_query(); ?>
	<div id="sidebar" class="sidebar" style="<?php echo $sidebar_css; ?>">
		<?php
		if($sidebar_left == 1) {
			generated_dynamic_sidebar($sidebar_1);
		}
		if($sidebar_left == 2) {
			generated_dynamic_sidebar_2($sidebar_2);
		}
		?>
	</div>
	<?php if( $double_sidebars == true ): ?>
	<div id="sidebar-2" class="sidebar" style="<?php echo $sidebar_2_css; ?>">
		<?php
		if($sidebar_left == 1) {
			generated_dynamic_sidebar_2($sidebar_2);
		}
		if($sidebar_left == 2) {
			generated_dynamic_sidebar($sidebar_1);
		}
		?>
	</div>
	<?php endif; ?>
	<?php endif; ?>
<?php get_footer(); ?>