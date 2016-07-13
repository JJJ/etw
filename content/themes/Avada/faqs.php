<?php
// Template Name: FAQs
get_header();

$content_css = 'width:100%';
$sidebar_css = 'display:none';
$content_class = '';
$sidebar_exists = false;
$sidebar_left = '';
$double_sidebars = false;

$sidebar_1 = get_post_meta( $post->ID, 'sbg_selected_sidebar_replacement', true );
$sidebar_2 = get_post_meta( $post->ID, 'sbg_selected_sidebar_2_replacement', true );

if( $smof_data['pages_global_sidebar'] ) {
	if( $smof_data['pages_sidebar'] != 'None' ) {
		$sidebar_1 = array( $smof_data['pages_sidebar'] );
	} else {
		$sidebar_1 = '';
	}

	if( $smof_data['pages_sidebar_2'] != 'None' ) {
		$sidebar_2 = array( $smof_data['pages_sidebar_2'] );
	} else {
		$sidebar_2 = '';
	}
}

if( ( is_array( $sidebar_1 ) && ( $sidebar_1[0] || $sidebar_1[0] === '0' ) ) && ( is_array( $sidebar_2 ) && ( $sidebar_2[0] || $sidebar_2[0] === '0' ) ) ) {
	$double_sidebars = true;
}

if( ( is_array( $sidebar_1 ) && ( $sidebar_1[0] || $sidebar_1[0] === '0' ) ) || ( is_array( $sidebar_2 ) && ( $sidebar_2[0] || $sidebar_2[0] === '0' ) ) ) {
	$sidebar_exists = true;
} else {
	$sidebar_exists = false;
}

if( ! $sidebar_exists ) {
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$sidebar_exists = false;
} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
	$content_css = 'float:right;';
	$sidebar_css = 'float:left;';
	$content_class = 'portfolio-one-sidebar';
	$sidebar_exists = true;
	$sidebar_left = 1;
} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
	$content_css = 'float:left;';
	$sidebar_css = 'float:right;';
	$content_class = 'portfolio-one-sidebar';
	$sidebar_exists = true;
} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'default'  || ! metadata_exists( 'post', $post->ID, 'pyre_sidebar_position' )) {
	$content_class = 'portfolio-one-sidebar';
	if($smof_data['default_sidebar_pos'] == 'Left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
		$sidebar_exists = true;
		$sidebar_left = 1;
	} elseif($smof_data['default_sidebar_pos'] == 'Right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
		$sidebar_exists = true;
		$sidebar_left = 2;
	}
}

if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
	$sidebar_left = 2;
}

if( $smof_data['pages_global_sidebar'] ) {
	if( $smof_data['pages_sidebar'] != 'None' ) {
		$sidebar_1 = $smof_data['pages_sidebar'];

		if( $smof_data['default_sidebar_pos'] == 'Right' ) {
			$content_css = 'float:left;';
			$sidebar_css = 'float:right;';	
			$sidebar_left = 2;
		} else {
			$content_css = 'float:right;';
			$sidebar_css = 'float:left;';
			$sidebar_left = 1;
		}			
	}

	if( $smof_data['pages_sidebar_2'] != 'None' ) {
		$sidebar_2 = $smof_data['pages_sidebar_2'];
	}

	if( $smof_data['pages_sidebar'] != 'None' && $smof_data['pages_sidebar_2'] != 'None' ) {
		$double_sidebars = true;
	}
} else {
	$sidebar_1 = '0';
	$sidebar_2 = '0';
}

if($double_sidebars == true) {
	$content_css = 'float:left;';
	$sidebar_css = 'float:left;';
	$sidebar_2_css = 'float:left;';
} else {
	$sidebar_left = 1;
}

echo sprintf( '<div id="content" class="fusion-faqs" style="%s">', $content_css );
	// Get the content of the faq page itself
	while ( have_posts() ): the_post();

		ob_start();
		post_class();
		$post_classes = ob_get_clean();

		echo sprintf( '<div id="post-%s" %s>', get_the_ID(), $post_classes );	
			// Get rich snippets of the faq page
			echo avada_render_rich_snippets_for_pages();
		
			// Get featured images of the faq page
			echo avada_featured_images_for_pages();

			// Render the content of the faq page
			echo '<div class="post-content">';		
				the_content();
				avada_link_pages();
			echo '</div>';
		echo '</div>';
	endwhile;

	// Check if the post is password protected	
	if ( ! post_password_required( $post->ID ) ) {

		// Get faq terms
		$faq_terms = get_terms( 'faq_category' );

		// Check if we should display filters
		if ( $smof_data['faq_filters'] != 'no' && 
			 $faq_terms 
		) {

			echo '<ul class="fusion-filters clearfix">';

				// Check if the "All" filter should be displayed
				if ( $smof_data['faq_filters'] == 'yes' ) {
					echo sprintf( '<li class="fusion-filter fusion-filter-all fusion-active"><a data-filter="*" href="#">%s</a></li>', apply_filters( 'avada_faq_all_filter_name', __( 'All', 'Avada' ) ) );

					$first_filter = FALSE;
				} else {
					$first_filter = TRUE;
				}
				
				// Loop through the terms to setup all filters
				foreach ( $faq_terms as $faq_term ) {
					// If the "All" filter is disabled, set the first real filter as active
					if ( $first_filter ) {
						echo sprintf( '<li class="fusion-filter fusion-active"><a data-filter=".%s" href="#">%s</a></li>', urldecode( $faq_term->slug ), $faq_term->name );

						$first_filter = FALSE;
					} else {
						echo sprintf( '<li class="fusion-filter fusion-hidden"><a data-filter=".%s" href="#">%s</a></li>', urldecode( $faq_term->slug ), $faq_term->name );
					}
				}

			echo '</ul>';
		}	

		echo '<div class="fusion-faqs-wrapper">';
			echo '<div class="accordian fusion-accordian">';
				echo '<div class="panel-group" id="accordian-one">';

					$args = array(
						'post_type' => 'avada_faq',
						'posts_per_page' => -1
					);
					$faq_items = new WP_Query( $args );
					$count = 0;
					while ( $faq_items->have_posts() ): $faq_items->the_post();
						$count++;

						//Get all terms of the post and it as classes; needed for filtering							
						$post_classes = '';
						$post_terms = get_the_terms( $post->ID, 'faq_category' );
						if ( $post_terms ) {
							foreach ( $post_terms as $post_term ) {
								$post_classes .= urldecode( $post_term->slug ) . ' ';
							}
						}

						echo sprintf( '<div class="fusion-panel panel-default fusion-faq-post %s">', $post_classes );
							// get the rich snippets for the post
							echo avada_render_rich_snippets_for_pages();

							echo '<div class="panel-heading">';
								echo sprintf( '<h4 class="panel-title toggle"><a data-toggle="collapse" class="collapsed" data-parent="#accordian-one" data-target="#collapse-%s" href="#collapse-%s"><i class="fa-fusion-box"></i>%s</a></h4>', get_the_ID(), get_the_ID(), get_the_title() );
							echo '</div>';
							echo sprintf( '<div id="collapse-%s" class="panel-collapse collapse">', get_the_ID() );
								echo '<div class="panel-body toggle-content post-content">';
									// Render the featured image of the post
									if ( $smof_data['faq_featured_image'] &&
										 has_post_thumbnail()
									) {

										$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

										if ( $featured_image[0] ) {										
											echo '<div class="flexslider post-slideshow">';
												echo '<ul class="slides">';
													echo '<li>';
														echo sprintf( '<a href="%s" data-rel="iLightbox[gallery]" data-title="%s" data-caption="%s">%s</a>', 
																	  $featured_image[0], get_post_field( 'post_title', get_post_thumbnail_id() ), get_post_field( 'post_excerpt', get_post_thumbnail_id() ), get_the_post_thumbnail( get_the_ID(), 'blog-large' ) );
													echo '</li>';
												echo '</ul>';
											echo '</div>';
										}
									}
									// Render the post content
									the_content();
								echo '</div>';
							echo '</div>';
						echo '</div>';
					endwhile; // loop through faq_items
				echo '</div>';
			echo '</div>';
		echo '</div>';
	} // password check
echo '</div>';
wp_reset_query(); 
?>
<?php if( $sidebar_exists == true ): ?>
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