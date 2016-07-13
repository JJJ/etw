<?php get_header(); ?>
	<?php
	global $smof_data;
	if(get_post_meta($post->ID, 'pyre_width', true) == 'half') {
		$portfolio_width = 'half';
	} else {
		$portfolio_width = 'full';
	}
	if( ! $smof_data['portfolio_featured_images'] && 
		$portfolio_width == 'half' 
	) {
		$portfolio_width = 'full';
	}

	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = '';
	$sidebar_exists = false;
	$sidebar_left = '';
	$double_sidebars = false;

	$sidebar_1 = get_post_meta( $post->ID, 'sbg_selected_sidebar_replacement', true );
	$sidebar_2 = get_post_meta( $post->ID, 'sbg_selected_sidebar_2_replacement', true );

	if( $smof_data['portfolio_global_sidebar'] ) {
		if( $smof_data['portfolio_sidebar'] != 'None' ) {
			$sidebar_1 = array( $smof_data['portfolio_sidebar'] );
		} else {
			$sidebar_1 = '';
		}

		if( $smof_data['portfolio_sidebar_2'] != 'None' ) {
			$sidebar_2 = array( $smof_data['portfolio_sidebar_2'] );
		} else {
			$sidebar_2 = '';
		}
	}

	if( ( is_array( $sidebar_1 ) && ( $sidebar_1[0] || $sidebar_1[0] === '0' ) ) && ( is_array( $sidebar_2 ) && ( $sidebar_2[0] || $sidebar_2[0] === '0' ) ) ) {
		$double_sidebars = true;
	}

	if( is_array( $sidebar_1 ) &&
		( $sidebar_1[0] || $sidebar_1[0] === '0' ) 
	) {
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
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'default' || ! metadata_exists( 'post', $post->ID, 'pyre_sidebar_position' )) {
		$content_class = 'portfolio-one-sidebar';
		if($smof_data['portfolio_sidebar_position'] == 'Left') {
			$content_css = 'float:right;';
			$sidebar_css = 'float:left;';
			$sidebar_exists = true;
			$sidebar_left = 1;
		} elseif($smof_data['portfolio_sidebar_position'] == 'Right') {
			$content_css = 'float:left;';
			$sidebar_css = 'float:right;';
			$sidebar_exists = true;
			$sidebar_left = 2;
		}		
	}

	if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$sidebar_left = 2;
	}

	if( $smof_data['portfolio_global_sidebar'] ) {
		if( $smof_data['portfolio_sidebar'] != 'None' ) {
			$sidebar_1 = $smof_data['portfolio_sidebar'];
			
			if( $smof_data['portfolio_sidebar_position'] == 'Right' ) {
				$content_css = 'float:left;';
				$sidebar_css = 'float:right;';	
				$sidebar_left = 2;
			} else {
				$content_css = 'float:right;';
				$sidebar_css = 'float:left;';
				$sidebar_left = 1;
			}			
		}

		if( $smof_data['portfolio_sidebar_2'] != 'None' ) {
			$sidebar_2 = $smof_data['portfolio_sidebar_2'];
		}
		
		if( $smof_data['portfolio_sidebar'] != 'None' && $smof_data['portfolio_sidebar_2'] != 'None' ) {
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
	?>
	<div id="content" class="portfolio-<?php echo $portfolio_width; ?> <?php echo $content_class; ?>" style="<?php echo $content_css; ?>">
		<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
		<?php query_posts($query_string.'&paged='.$paged); ?>
		<?php
		$nav_categories = '';
		if(isset($_GET['portfolioID'])) {
			$portfolioID = $_GET['portfolioID'];
		} else {
			$portfolioID = '';
		}
		if(isset($_GET['categoryID'])) {
			$categoryID = $_GET['categoryID'];
		} else {
			$categoryID = '';
		}
		$page_categories = get_post_meta($portfolioID, 'pyre_portfolio_category', true);
		if($page_categories && is_array($page_categories) && $page_categories[0] !== '0') {
			$nav_categories = implode(',', $page_categories);
		}

		if($categoryID) {
			$nav_categories = $categoryID;
		}
		?>
		<?php if( ( ! $smof_data['portfolio_pn_nav'] && get_post_meta($post->ID, 'pyre_post_pagination', true) != 'no' ) ||
				  ( $smof_data['portfolio_pn_nav'] && get_post_meta($post->ID, 'pyre_post_pagination', true) == 'yes' ) ): ?>
		<div class="single-navigation clearfix">
			<?php
			if($portfolioID || $categoryID) {
				$previous_post_link = fusion_previous_post_link_plus(array('format' => '%link', 'link' => __('Previous', 'Avada'), 'in_same_tax' => 'portfolio_category', 'in_cats' => $nav_categories, 'return' => 'href'));
			} else {
				$previous_post_link = fusion_previous_post_link_plus(array('format' => '%link', 'link' => __('Previous', 'Avada'), 'return' => 'href'));
			}
			?>
			<?php if($previous_post_link):
			if($portfolioID || $categoryID) {
				if($portfolioID) {
					$previous_post_link = fusion_add_url_parameter($previous_post_link, 'portfolioID', $portfolioID);
				} else {
					$previous_post_link = fusion_add_url_parameter($previous_post_link, 'categoryID', $categoryID);
				}
			}
			?>
			<a href="<?php echo $previous_post_link; ?>" rel="prev"><?php _e('Previous', 'Avada'); ?></a>
			<?php endif; ?>
			<?php
			if($portfolioID || $categoryID) {
				$next_post_link = fusion_next_post_link_plus(array('format' => '%link', 'link' => __('Next', 'Avada'), 'in_same_tax' => 'portfolio_category', 'in_cats' => $nav_categories, 'return' => 'href'));
			} else {
				$next_post_link = fusion_next_post_link_plus(array('format' => '%link', 'link' => __('Next', 'Avada'), 'return' => 'href'));
			}
			?>
			<?php if($next_post_link):
			if($portfolioID || $categoryID) {
				if($portfolioID) {
					$next_post_link = fusion_add_url_parameter($next_post_link, 'portfolioID', $portfolioID);
				} else {
					$next_post_link = fusion_add_url_parameter($next_post_link, 'categoryID', $categoryID);
				}
			}
			?>
			<a href="<?php echo $next_post_link; ?>" rel="next"><?php _e('Next', 'Avada'); ?></a>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<?php if(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			$full_image = '';
			
			if( ! post_password_required($post->ID) ): // 1
			if( $smof_data['portfolio_featured_images'] ): // 2 
			if( avada_number_of_featured_images() > 0 || get_post_meta( $post->ID, 'pyre_video', true ) ): // 3
			?>
			<div class="fusion-flexslider flexslider fusion-post-slideshow post-slideshow fusion-flexslider-loading">
				<ul class="slides">
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li>
						<div class="full-video">
							<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if( has_post_thumbnail() && get_post_meta( $post->ID, 'pyre_show_first_featured_image', true ) != 'yes' ): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<?php if( ! $smof_data['status_lightbox'] && ! $smof_data['status_lightbox_single'] ): ?>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>" data-title="<?php echo get_post_field('post_title', get_post_thumbnail_id()); ?>" data-caption="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" /></a>
						<?php else: ?>
						<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
						<?php endif; ?>
					</li>
					<?php endif; ?>
					<?php
					$i = 2;
					while($i <= $smof_data['posts_slideshow_number']):
					$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, 'avada_portfolio');
					if($attachment_new_id):
					?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment_new_id, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment_new_id); ?>
					<li>
						<?php if( ! $smof_data['status_lightbox'] && ! $smof_data['status_lightbox_single'] ): ?>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_excerpt', $attachment_new_id); ?>" data-title="<?php echo get_post_field( 'post_title', $attachment_new_id ); ?>" data-caption="<?php echo get_post_field('post_excerpt', $attachment_new_id ); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" /></a>
						<?php else: ?>
						<img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_meta($attachment_new_id, '_wp_attachment_image_alt', true); ?>" />
						<?php endif; ?>
					</li>
					<?php endif; $i++; endwhile; ?>
				</ul>
			</div>
			<?php endif; // 3 ?>
			<?php endif; // 2 portfolio single image theme option check ?>
			<?php endif; // 1 password check ?>
			<?php
			$project_info_style = '';
			$project_desc_style = '';
			$project_desc_title_style = '';
			if(get_post_meta($post->ID, 'pyre_project_details', true) == 'no') {
				$project_info_style = 'display:none;';
			}
			if($portfolio_width == 'full' && get_post_meta($post->ID, 'pyre_project_details', true) == 'no') {
				$project_desc_style = 'width:100%;';
			}
			if(get_post_meta($post->ID, 'pyre_project_desc_title', true) == 'no') {
				$project_desc_title_style = 'display:none;';
			}
			?>
			<div class="project-content clearfix">
				<?php 
					echo avada_render_rich_snippets_for_pages();
					
					$project_details = ( get_post_meta( $post->ID, 'pyre_project_details', true ) != 'no' ) ? TRUE : FALSE;
				?>
				<div class="project-description post-content<?php echo ( $project_details ) ? ' fusion-project-description-details' : ''; ?>" style="<?php echo $project_desc_style; ?>">
					<?php if( ! post_password_required($post->ID) && get_post_meta($post->ID, 'pyre_project_desc_title', true) != 'no' ): ?>
					<h3><?php echo __('Project Description', 'Avada') ?></h3>
					<?php endif; ?>
					<?php the_content(); ?>
				</div>
				<?php if( ! post_password_required($post->ID) && $project_details ): ?>
				<div class="project-info">
					<h3><?php echo __('Project Details', 'Avada'); ?></h3>
					<?php if(get_the_term_list($post->ID, 'portfolio_skills', '', '<br />', '')): ?>
					<div class="project-info-box">
						<h4><?php echo __('Skills Needed', 'Avada') ?>:</h4>
						<div class="project-terms">
							<?php echo get_the_term_list($post->ID, 'portfolio_skills', '', '<br />', ''); ?>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_the_term_list($post->ID, 'portfolio_category', '', '<br />', '')): ?>
					<div class="project-info-box">
						<h4><?php echo __('Categories', 'Avada') ?>:</h4>
						<div class="project-terms">
							<?php echo get_the_term_list($post->ID, 'portfolio_category', '', '<br />', ''); ?>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_the_term_list($post->ID, 'portfolio_tags', '', '<br />', '')): ?>
					<div class="project-info-box">
						<h4><?php echo __('Tags', 'Avada') ?>:</h4>
						<div class="project-terms">
							<?php echo get_the_term_list($post->ID, 'portfolio_tags', '', '<br />', ''); ?>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_post_meta($post->ID, 'pyre_project_url', true) && get_post_meta($post->ID, 'pyre_project_url_text', true)):
						$link_target = '';
						if( get_post_meta( $post->ID, 'pyre_link_icon_target', true ) == 'yes' ) {
							$link_target = ' target="_blank"';
						}
					?>
					<div class="project-info-box">
						<h4><?php echo __('Project URL', 'Avada') ?>:</h4>
						<span><a href="<?php echo get_post_meta($post->ID, 'pyre_project_url', true); ?>"<?php echo $link_target; ?>><?php echo get_post_meta($post->ID, 'pyre_project_url_text', true); ?></a></span>
					</div>
					<?php endif; ?>
					<?php if(get_post_meta($post->ID, 'pyre_copy_url', true) && get_post_meta($post->ID, 'pyre_copy_url_text', true)):
						$link_target = '';
						if( get_post_meta( $post->ID, 'pyre_link_icon_target', true ) == 'yes' ) {
							$link_target = ' target="_blank"';
						}
					?>
					<div class="project-info-box">
						<h4><?php echo __('Copyright', 'Avada'); ?>:</h4>
						<span><a href="<?php echo get_post_meta($post->ID, 'pyre_copy_url', true); ?>"<?php echo $link_target; ?>><?php echo get_post_meta($post->ID, 'pyre_copy_url_text', true); ?></a></span>
					</div>
					<?php endif; ?>
					<?php if($smof_data['portfolio_author']): ?>
					<div class="project-info-box<?php if( ! $smof_data['disable_date_rich_snippet_pages'] ) { echo ' vcard'; } ?>">
						<h4><?php echo __('By', 'Avada'); ?>:</h4><span<?php if( ! $smof_data['disable_date_rich_snippet_pages'] ) { echo ' class="fn"'; } ?>><?php the_author_posts_link(); ?></span>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
			<div class="portfolio-sep"></div>
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php if( ( $smof_data['portfolio_social_sharing_box'] && get_post_meta($post->ID, 'pyre_share_box', true) != 'no' ) || 
					  ( ! $smof_data['portfolio_social_sharing_box'] && get_post_meta($post->ID, 'pyre_share_box', true) == 'yes' ) ):

				$sharingbox_social_icon_options = array (
					'sharingbox'		=> 'yes',
					'icon_colors' 		=> $smof_data['sharing_social_links_icon_color'],
					'box_colors' 		=> $smof_data['sharing_social_links_box_color'],
					'icon_boxed' 		=> $smof_data['sharing_social_links_boxed'],
					'icon_boxed_radius' => $smof_data['sharing_social_links_boxed_radius'],
					'tooltip_placement'	=> $smof_data['sharing_social_links_tooltip_placement'],
                	'linktarget'        => $smof_data['social_icons_new'],
					'title'				=> wp_strip_all_tags(get_the_title( $post->ID ), true),
					'description'		=> wp_strip_all_tags(get_the_title( $post->ID ), true),
					'link'				=> get_permalink( $post->ID ),
					'pinterest_image'	=> ($full_image) ? $full_image[0] : '',
				);
				?>
				<div class="fusion-sharing-box share-box">
					<h4><?php echo __('Share This Story, Choose Your Platform!', 'Avada'); ?></h4>
					<?php echo $social_icons->render_social_icons( $sharingbox_social_icon_options ); ?>
				</div>
			<?php endif; ?>

			<?php
			// Render Related Posts
			echo avada_render_related_posts( 'avada_portfolio' );
			?>
			
			<?php if($smof_data['portfolio_comments']): ?>
				<?php
				wp_reset_query();
				comments_template();
				?>
			<?php endif; ?>
			<?php endif; ?>
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