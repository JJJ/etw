<?php
/**
 * Contains all theme specific functions
 *
 * @author		ThemeFusion
 * @package		Avada
 * @since		Version 3.8
 */

fusion_block_direct_access();


/**
 * Alters the wp_title output to add the site name
 * @param  string $title The default page title
 *
 * @return string The altered title
 **/
if( ! function_exists( 'avada_add_site_name_to_title' ) ) {	 
	function avada_add_site_name_to_title( $title ) {
		if ( ! defined('WPSEO_VERSION') ) {
			if ( $title ) {
				$title = bloginfo( 'name' ) . ' - ' . $title;
			} else {
				$title = bloginfo( 'name' );
			}
		}
		
		return $title;
	}
	add_filter( 'wp_title', 'avada_add_site_name_to_title' );
}

/**
 * Get the post (excerpt)
 *
 * @return void Content is directly echoed
 **/
if( ! function_exists( 'avada_render_blog_post_content' ) ) {
	function avada_render_blog_post_content() {
		global $smof_data;
	
		if ( is_search() && $smof_data['search_excerpt'] ) {
			return;
		}	

		echo fusion_get_post_content();
		
	}
}
add_action( 'avada_blog_post_content', 'avada_render_blog_post_content', 10 );

/**
 * Get the portfolio post (excerpt)
 *
 * @return void Content is directly echoed
 **/
if( ! function_exists( 'avada_render_portfolio_post_content' ) ) {
	function avada_render_portfolio_post_content( $page_id ) {

		echo fusion_get_post_content( $page_id, 'portfolio' );

	}
}
add_action( 'avada_portfolio_post_content', 'avada_render_portfolio_post_content', 10 );

/**
 * Render the HTML for the date box for large/medium alternate blog layouts
 *
 * @return void directly echoed HTML markup to display the date box
 **/
if( ! function_exists( 'avada_render_blog_post_date' ) ) {
	function avada_render_blog_post_date() {
		global $smof_data;

		echo '<div class="fusion-date-box">';
			echo sprintf( '<span class="fusion-date">%s</span>', get_the_time( $smof_data['alternate_date_format_day'] ) );
			echo sprintf( '<span class="fusion-month-year">%s</span>' , get_the_time( $smof_data['alternate_date_format_month_year'] ) );
		echo '</div>';			  
	}
}
add_action( 'avada_blog_post_date_and_format', 'avada_render_blog_post_date', 10 );

/**
 * Render the HTML for the format box for large/medium alternate blog layouts
 *
 * @return void directly echoed HTML markup to display the format box
 **/
if( ! function_exists( 'avada_render_blog_post_format' ) ) {
	function avada_render_blog_post_format() {
		global $smof_data;

		switch ( get_post_format() ) {
			case 'gallery':
				$format_class = 'images';
				break;
			case 'link':
				$format_class = 'link';
				break;
			case 'image':
				$format_class = 'image';
				break;
			case 'quote':
				$format_class = 'quotes-left';
				break;
			case 'video':
				$format_class = 'film';
				break;
			case 'audio':
				$format_class = 'headphones';
				break;
			case 'chat':
				$format_class = 'bubbles';
				break;
			default:
				$format_class = 'pen';
				break;
		}

		echo '<div class="fusion-format-box">';
			echo sprintf( '<i class="fusion-icon-%s"></i>', $format_class );
		echo '</div>';
	}
}
add_action( 'avada_blog_post_date_and_format', 'avada_render_blog_post_format', 15 );

/**
 * Output author information on the author archive page
 *
 * @return void directly echos the author info HTML markup
 **/
if( ! function_exists( 'avada_render_author_info' ) ) {
	function avada_render_author_info() {
		global $smof_data, $social_icons;

		// Initialize needed variables
		$author = get_user_by( 'id', get_query_var( 'author' ) );
		$author_id = $author->ID;
		$author_name = get_the_author_meta( 'display_name', $author_id );
		$author_avatar = get_avatar( get_the_author_meta( 'email', $author_id ), '82' );
		$author_description = get_the_author_meta( 'description', $author_id );
		$author_custom = get_the_author_meta( 'author_custom', $author_id );

		// If no description was added by user, add some default text and stats
		if ( empty( $author_description ) ) {
			$author_description  = __( 'This author has not yet filled in any details.', 'Avada' );
			$author_description .= '<br />' . sprintf( __( 'So far %s has created %s blog entries.', 'Avada' ), $name, count_user_posts( $author_id ) );
		}	

		echo '<div class="fusion-author">';
			echo '<div class="fusion-author-avatar">';
				echo $author_avatar;
			echo '</div>';
			echo '<div class="fusion-author-info">';
				// Check if rich snippets are allowed
				if ( ! $smof_data['disable_date_rich_snippet_pages'] ) {
					echo sprintf( '<h3 class="fusion-author-title vcard">%s <span class="fn">%s </span>', __( 'About', 'Avada' ), $author_name );
				} else {
					echo sprintf( '<h3 class="fusion-author-title">%s %s', __( 'About', 'Avada' ), $author_name );
				}
					// If user can edit his profile, offer a link for it
					if ( current_user_can( 'edit_users' ) || 
						 get_current_user_id() == $author_id
					) {
						echo sprintf( '<span class="fusion-edit-profile">(<a href="%s">%s</a>)</span>', admin_url( 'profile.php?user_id=' . $author_id ),  __( 'Edit profile', 'Avada' ) );
					}

				echo '</h3>';
				echo $author_description;
			echo '</div>';

			echo '<div style="clear:both;"></div>';

			echo '<div class="fusion-author-social clearfix">';
				echo '<div class="fusion-author-tagline">';
					if ( $author_custom ) {
						echo $author_custom;
					}
				echo '</div>';

				// Get the social icons for the author set on his profile page
				$author_soical_icon_options = array (
					'authorpage'		=> 'yes',
					'author_id'			=> $author_id,
					'position'			=> 'author',				
					'icon_colors' 		=> $smof_data['social_links_icon_color'],
					'box_colors' 		=> $smof_data['social_links_box_color'],
					'icon_boxed' 		=> $smof_data['social_links_boxed'],
					'icon_boxed_radius' => $smof_data['social_links_boxed_radius'],
					'tooltip_placement'	=> $smof_data['social_links_tooltip_placement'],
					'linktarget'		=> $smof_data['social_icons_new'],
				);

				echo $social_icons->render_social_icons( $author_soical_icon_options );

			echo '</div>';
		echo '</div>';
	}
}
add_action( 'avada_author_info', 'avada_render_author_info', 10 );

/**
 * Ooutput the footer copyright notice
 *
 * @return void directly echos the footer copyright notice HTML markup
 **/
if( ! function_exists( 'avada_render_footer_copyright_notice' ) ) {
	function avada_render_footer_copyright_notice() {
		global $smof_data;

		echo '<div class="fusion-copyright-notice">';
			echo sprintf( '<div>%s</div>', do_shortcode( $smof_data['footer_text'] ) );
		echo '</div>';
	}
}
add_action( 'avada_footer_copyright_content', 'avada_render_footer_copyright_notice', 10 );

/**
 * Output the footer social icons
 *
 * @return void directly echos the footer footer social icons HTML markup
 **/
if( ! function_exists( 'avada_render_footer_social_icons' ) ) {
	function avada_render_footer_social_icons() {
		global $smof_data, $social_icons;

		// Render the social icons
		if ( $smof_data['icons_footer'] ) {				
			echo '<div class="fusion-social-links-footer">';

				$footer_soical_icon_options = array (
					'position'			=> 'footer',
					'icon_colors' 		=> $smof_data['footer_social_links_icon_color'],
					'box_colors' 		=> $smof_data['footer_social_links_box_color'],
					'icon_boxed' 		=> $smof_data['footer_social_links_boxed'],
					'icon_boxed_radius' => $smof_data['footer_social_links_boxed_radius'],
					'tooltip_placement'	=> $smof_data['footer_social_links_tooltip_placement'],
					'linktarget'		=> $smof_data['social_icons_new']
				);

				echo $social_icons->render_social_icons( $footer_soical_icon_options );
			echo '</div>';
		}
	}
}
add_action( 'avada_footer_copyright_content', 'avada_render_footer_social_icons', 15 );

/**
 * Output the image rollover
 * @param  string 	$post_id 					ID of the current post
 * @param  string 	$permalink 					Permalink of current post
 * @param  boolean 	$display_woo_price 			Set to yes to show´woocommerce price tag for woo sliders
 * @param  boolean 	$display_woo_buttons		Set to yes to show the woocommerce "add to cart" and "show details" buttons
 * @param  string	$display_post_categories 	Controls if the post categories will be shown; "deafult": theme option setting; enable/disable otheriwse
 * @param  string	$display_post_title 		Controls if the post title will be shown; "deafult": theme option setting; enable/disable otheriwse
 *
 * @return void 	Directly echos the placeholder image HTML markup
 **/
if( ! function_exists( 'avada_render_rollover' ) ) {
	function avada_render_rollover( $post_id, $post_permalink = '', $display_woo_price = FALSE, $display_woo_buttons = FALSE, $display_post_categories = 'default', $display_post_title = 'default', $gallery_id = '' ) {
		global $smof_data;

		// Retrieve the permalink if it is not set
		if ( ! $post_permalink ) {
			$post_permalink = get_permalink( $post_id );
		}

		// Check if theme options are used as base or if there is an override for post categories
		if ( $display_post_categories == 'enable' ) {
			$display_post_categories = TRUE;
		} elseif ( $display_post_categories == 'disable' ) {
			$display_post_categories = FALSE;
		} else {
			$display_post_categories = ! $smof_data['cats_image_rollover'];
		}
		
		// Check if theme options are used as base or if there is an override for post title
		if ( $display_post_title == 'enable' ) {
			$display_post_title = TRUE;
		} elseif ( $display_post_title == 'disable' ) {
			$display_post_title = FALSE;
		} else {
			$display_post_title = ! $smof_data['title_image_rollover'];
		}

		// Set the link on the link icon to a custom url if set in page options
		if( fusion_get_page_option( 'link_icon_url', $post_id ) != NULL ) {
			$icon_permalink = fusion_get_page_option( 'link_icon_url', $post_id );
		} else {
			$icon_permalink = $post_permalink;
		}

		if( fusion_get_page_option( 'image_rollover_icons', $post_id ) == ''  || 
			fusion_get_page_option( 'image_rollover_icons', $post_id ) == 'default' ) {
			if( ! $smof_data['link_image_rollover'] && ! $smof_data['zoom_image_rollover'] ) { // link + zoom
				$image_rollover_icons = 'linkzoom';
			} elseif( ! $smof_data['link_image_rollover'] && $smof_data['zoom_image_rollover'] ) { // link
				$image_rollover_icons = 'link';
			} elseif( $smof_data['link_image_rollover'] && ! $smof_data['zoom_image_rollover'] ) { // zoom
				$image_rollover_icons = 'zoom';
			} elseif( $smof_data['link_image_rollover'] && $smof_data['zoom_image_rollover'] ) { // link
				$image_rollover_icons = 'no';
			} else {
				$image_rollover_icons = 'linkzoom';
			}
		} else {
			$image_rollover_icons = fusion_get_page_option( 'image_rollover_icons', $post_id );
		}

		// Set the link target to blank if the option is set
		$link_target = '';
		if( fusion_get_page_option( 'link_icon_target', $post_id ) == 'yes' ||
			fusion_get_page_option( 'post_links_target', $post_id ) == 'yes' ) {
			$link_target = ' target="_blank"';
		}

		echo '<div class="fusion-rollover">';
			echo '<div class="fusion-rollover-content">';
				
				// Check if rollover icons should be displayed
				if ( $image_rollover_icons != 'no' && 
					get_post_type( $post_id ) != 'product'
				) {
				
					// If set, render the rollover link icon
					if ( $image_rollover_icons != 'zoom' ) {
						echo sprintf( '<a class="fusion-rollover-link" href="%s"%s>Permalink</a>', $icon_permalink, $link_target );
					}

					// If set, render the rollover zoom icon
					if ( $image_rollover_icons != 'link' ) {
						// Get the image data
						$full_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

						if ( ! is_array( $full_image ) ) {
							$full_image = array();
							$full_image[0] = '';
						}

						// If a video url is set in the post options, use it inside the lightbox
						if ( fusion_get_page_option( 'video_url', $post_id ) ) {
							$full_image[0] = fusion_get_page_option( 'video_url', $post_id );
						}


						// If both icons will be shown, add a separator
						if ( $image_rollover_icons == 'linkzoom' || $image_rollover_icons === '' ) {
							echo '<div class="fusion-rollover-sep"></div>';
						}

						// Render the rollover zoom icon if we have an image
						if ( $full_image[0] ) {
							// Only show images of the clicked post
							if ( $smof_data['lightbox_behavior'] == "individual" ) {
								$lightbox_content = avada_featured_images_lightbox( $post_id );
								$data_rel = sprintf( 'iLightbox[gallery%s]', $post_id );
							// Show the first image of every post on the archive page
							} else {
								$lightbox_content = '';
								$data_rel = sprintf( 'iLightbox[gallery%s]', $gallery_id );			
							}
							
							echo sprintf( '<a class="fusion-rollover-gallery" href="%s" data-rel="%s" data-title="%s" data-caption="%s">Gallery</a>%s', 
										  $full_image[0], $data_rel, get_post_field( 'post_title', get_post_thumbnail_id( $post_id ) ), get_post_field( 'post_excerpt', get_post_thumbnail_id( $post_id ) ), $lightbox_content );
						}
					}
				}
				
				// Check if we should render the post title on the rollover
				if ( $display_post_title ) {
					echo sprintf( '<h4 class="fusion-rollover-title"><a href="%s"%s>%s</a></h4>', $icon_permalink, $link_target, get_the_title( $post_id ) );
				}

				// Check if we should render the post categories on the rollover
				if ( $display_post_categories ) {
					
					// Determine the correct taxonomy
					if ( get_post_type( $post_id ) == 'post' ) {
						$post_taxonomy = 'category';
					} elseif ( get_post_type( $post_id ) == 'avada_portfolio' ) {
						$post_taxonomy = 'portfolio_category';
					} elseif ( get_post_type( $post_id ) == 'product' ) {
						$post_taxonomy = 'product_cat';
					}
				
					echo get_the_term_list( $post_id, $post_taxonomy, '<div class="fusion-rollover-categories">', ', ', '</div>' );
				}
				
				// Check if we should render the woo product price
				if ( $display_woo_price ) {
					woocommerce_get_template( 'loop/price.php' );
				}
				
				// Check if we should render the woo "add to cart" and "details" buttons
				if ( $display_woo_buttons ) {
					echo '<div class="fusion-product-buttons">';
						woocommerce_get_template('loop/add-to-cart.php');
						echo '<span class="fusion-rollover-linebreak"></span>';
						echo sprintf( '<a class="fusion-show-details-button" href="%s">%s</a>', $post_permalink, __( 'Details', 'Avada' ) );
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';
	}
}
add_action( 'avada_rollover', 'avada_render_rollover', 10, 7 );

/**
 * Action to output a placeholder image
 * @param  string $featured_image_size 	Size of the featured image that should be emulated
 *
 * @return void 						Directly echos the placeholder image HTML markup
 **/
if( ! function_exists( 'avada_render_placeholder_image' ) ) {
	function avada_render_placeholder_image( $featured_image_size = 'full' ) {
		global $_wp_additional_image_sizes;

		if ( $featured_image_size == 'full' ||
			 $featured_image_size == 'fixed'
		) {
			$height = apply_filters( 'avada_set_placeholder_image_height', '150' );
			$width = '100%';
		} else {
			@$height = $_wp_additional_image_sizes[$featured_image_size]['height'];
			@$width = $_wp_additional_image_sizes[$featured_image_size]['width'] . 'px';
		 }

		echo sprintf( '<div class="fusion-placeholder-image" data-origheight="%s" data-origwidth="%s" style="height:%spx;width:%s;"></div>', $height, $width, $height, $width );
	}
}
add_action( 'avada_placeholder_image', 'avada_render_placeholder_image', 10 );

if ( ! function_exists( 'avada_render_first_featured_image_markup' ) ) {
	/**
	 * Render the full markup of the first featured image, incl. image wrapper and rollover
	 * @param  string  $post_id 					ID of the current post
	 * @param  string  $post_featured_image_size 	Size of the featured image
	 * @param  string  $post_permalink 				Permalink of current post
	 * @param  boolean $display_post_title 			Set to yes to show post title on rollover
	 * @param  boolean $display_post_categories 	Set to yes to show post categories on rollover 
	 *
	 * @return string Full HTML markup of the first featured image
	 **/
	function avada_render_first_featured_image_markup( $post_id, $post_featured_image_size = '', $post_permalink = '', $display_placeholder_image = FALSE, $display_woo_price = FALSE, $display_woo_buttons = FALSE, $display_post_categories = 'default', $display_post_title = 'default', $type = '', $gallery_id = '' ) {
		global $smof_data;

		$html = '<div class="fusion-image-wrapper" aria-haspopup="true">';
			// Get the featured image
			ob_start();
			// If there is a featured image, display it
			if ( has_post_thumbnail( $post_id ) ) {
				echo get_the_post_thumbnail( $post_id, $post_featured_image_size );
				
			// If there is no featured image setup a placeholder
			} elseif ( $display_placeholder_image ) {
					/**
					 * avada_placeholder_image hook
					 *
					 * @hooked avada_render_placeholder_image - 10 (outputs the HTML for the placeholder image)
					 */								
					do_action( 'avada_placeholder_image', $post_featured_image_size );
			}
			$featured_image = ob_get_clean();

			if ( $type == 'related' && $post_featured_image_size == 'fixed' && get_post_thumbnail_id( $post_id ) ) {
				$image = Fusion_Image_Resizer::image_resize( array(
					'width' => '500',
					'height' => '383',
					'url' =>  wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ),
					'path' => get_attached_file( get_post_thumbnail_id( $post_id ) )
				) );

				$featured_image = sprintf( '<img src="%s" width="%s" height="%s" alt="%s" />', $image['url'], $image['width'], $image['height'], get_the_title( $post_id ) );
			}

			// If rollovers are enabled, add one to the image container
			if ( $smof_data['image_rollover'] ) {
				$html .= $featured_image;

				ob_start();
				/**
				 * avada_rollover hook
				 *
				 * @hooked avada_render_rollover - 10 (outputs the HTML for the image rollover)
				 */			 
				do_action( 'avada_rollover', $post_id, $post_permalink, $display_woo_price, $display_woo_buttons, $display_post_categories, $display_post_title, $gallery_id );				
				$rollover = ob_get_clean();
				
				$html .= $rollover;
				
			// If rollovers are disabled, add post permalink to the featured image
			} else {
				$html .= sprintf( '<a href="%s">%s</a>', $post_permalink, $featured_image );
			}

		$html .= '</div>';
		
		return $html;
	}
}

if ( ! function_exists( 'avada_get_image_orientation_class' ) ) {
	/**
	 * Returns the image class according to aspect ratio
	 *
	 * @return string The image class
	 **/
	function avada_get_image_orientation_class( $attachment ) {

		$sixteen_to_nine_ratio = 1.77;
		$imgage_class = 'fusion-image-grid';

		if ( ! empty( $attachment[1] ) && 
			 ! empty( $attachment[2] ) 
		) {
			// Landscape
			if ( $attachment[1] / $attachment[2] > $sixteen_to_nine_ratio ) {
				$imgage_class = 'fusion-image-landscape';
			// Portrait
			} elseif ( $attachment[2] / $attachment[1] > $sixteen_to_nine_ratio ) {
				$imgage_class = 'fusion-image-portrait';
			}
		}

		return $imgage_class;
	}	
}

if ( ! function_exists( 'avada_render_post_title' ) ) {
	/**
	 * Render the post title as linked h1 tag
	 *
	 * @return string The post title as linked h1 tag
	 **/
	function avada_render_post_title( $post_id = '', $linked = TRUE, $custom_title = '', $custom_size = '2' ) {
		global $smof_data;
		
		$entry_title_class = '';
		
		// Add the entry title class if rich snippets are enabled
		if ( ! $smof_data['disable_date_rich_snippet_pages'] ) { 
			$entry_title_class = ' class="entry-title"';
		}		
		
		// If we have a custom title, use it
		if ( $custom_title ) {
			$title = $custom_title;
		// Otherwise get post title
		} else {
			$title = get_the_title( $post_id );
		}
		
		// If the post title should be linked at the markup
		if ( $linked ) {
			$link_target = '';
			if( fusion_get_page_option( 'link_icon_target', $post_id ) == 'yes' ||
				fusion_get_page_option( 'post_links_target', $post_id ) == 'yes' ) {
				$link_target = ' target="_blank"';
			}

			$title = sprintf( '<a href="%s"%s>%s</a>', get_permalink( $post_id ), $link_target, $title );
		}

		// Setup the HTML markup of the post title
		$html = sprintf( '<h%s%s>%s</h%s>', $custom_size, $entry_title_class, $title, $custom_size );

		
		return $html;
	}
}

if ( ! function_exists( 'avada_get_portfolio_classes' ) ) {
	/**
	 * Determine the css classes need for portfolio page content container
	 *
	 * @return string The classes separated with space
	 **/
	function avada_get_portfolio_classes( $post_id = '' ) {
		global $smof_data;
		
		$classes = 'fusion-portfolio';
		
		// Get the page template slug without .php suffix
		$page_template = str_replace( '.php', '', get_page_template_slug( $post_id ) );

		// Add the text class, if a text layout is used
		if ( strpos( $page_template, 'text' ) ||
			 strpos( $page_template, 'one' )
		) {
			$classes .= ' fusion-portfolio-text';
		}
		
		// If one column text layout is used, add special class
		if ( strpos( $page_template, 'one' ) &&
			 ! strpos( $page_template, 'text' )
		) {
			$classes .= ' fusion-portfolio-one-nontext';
		}		
		
		// For text layouts add the class for boxed/unboxed
		if ( strpos( $page_template, 'text' ) ) {
			
			$classes .= sprintf( ' fusion-portfolio-%s ', fusion_get_option( 'portfolio_text_layout', 'portfolio_text_layout', $post_id  ) );
			$page_template = str_replace( '-text', '', $page_template );
		}
		
		// Add the column class
		$page_template = str_replace( '-column', '', $page_template );
		$classes .= ' fusion-' . $page_template;

		return $classes;
	}
}

if( ! function_exists( 'avada_is_portfolio_template' ) ) {
	function avada_is_portfolio_template() {
		if ( is_page_template( 'portfolio-one-column-text.php' ) || 
			is_page_template( 'portfolio-one-column.php' ) || 
			is_page_template( 'portfolio-two-column.php' ) || 
			is_page_template( 'portfolio-two-column-text.php' ) || 
			is_page_template( 'portfolio-three-column.php' ) || 
			is_page_template( 'portfolio-three-column-text.php' ) || 
			is_page_template( 'portfolio-four-column.php' ) || 
			is_page_template( 'portfolio-four-column-text.php' ) || 
			is_page_template( 'portfolio-five-column.php' ) || 
			is_page_template( 'portfolio-five-column-text.php' ) ||
			is_page_template( 'portfolio-six-column.php' ) || 
			is_page_template( 'portfolio-six-column-text.php' ) ||
			is_page_template( 'portfolio-grid.php' )
		) {
			return true;
		}
		
		return false;
	}
}

if ( ! function_exists( 'avada_get_blog_layout' ) ) {
	/**
	 * Get the blog layout for the current page template
	 *
	 * @return string The correct layout name for the blog post class
	 **/
	function avada_get_blog_layout() {
		global $smof_data;
		$theme_options_blog_var = '';

		if ( is_home() ) {
			$theme_options_blog_var = 'blog_layout';
		} elseif ( is_archive() || is_author() ) {
			$theme_options_blog_var = 'blog_archive_layout';
		} elseif ( is_search() ) {
			$theme_options_blog_var = 'search_layout';
		}

		$blog_layout = str_replace( ' ', '-', strtolower( $smof_data[$theme_options_blog_var] ) );

		return $blog_layout;
	}
}

if ( ! function_exists( 'avada_render_post_metadata' ) ) {
	/**
	 * Render the full meta data for blog archive and single layouts
	 * @param 	string $layout 	The blog layout (either single, standard, alternate or grid_timeline)
	 *
	 * @return 	string 			HTML markup to display the date and post format box
	 **/
	function avada_render_post_metadata( $layout, $settings = array() ) {
		global $smof_data;

		$html = $author = $date = $metadata = '';
		
		if ( ! $settings ) {
			$settings['post_meta'] = $smof_data['post_meta'];
			$settings['post_meta_author'] = $smof_data['post_meta_author'];
			$settings['post_meta_date'] = $smof_data['post_meta_date'];
			$settings['post_meta_cats'] = $smof_data['post_meta_cats'];
			$settings['post_meta_tags'] = $smof_data['post_meta_tags'];
			$settings['post_meta_comments'] = $smof_data['post_meta_comments'];
		}
		
		// Check if meta data is enabled
		if ( ( $settings['post_meta'] && get_post_meta( get_queried_object_id(), 'pyre_post_meta', TRUE ) != 'no' ) || 
			 ( ! $settings['post_meta'] && get_post_meta( get_queried_object_id(), 'pyre_post_meta', TRUE ) == 'yes' ) ) {
			
			// For alternate, grid and timeline layouts return empty single-line-meta if all meta data for that position is disabled
			if ( ( $layout == 'alternate' || $layout == 'grid_timeline' ) &&
				$settings['post_meta_author'] &&
				$settings['post_meta_date'] &&
				$settings['post_meta_cats'] &&
				$settings['post_meta_tags'] && 
				$settings['post_meta_comments']  
			) {
				return $html;
			}
			
			// Render author meta data
			if ( ! $settings['post_meta_author'] ) { 
				ob_start();
				the_author_posts_link();
				$author_post_link = ob_get_clean();
				
				// Check if rich snippets are enabled
				if ( $smof_data['disable_date_rich_snippet_pages'] ) {
					$metadata .= sprintf( '%s <span>%s</span><span class="fusion-inline-sep">|</span>', __( 'By', 'Avada' ), $author_post_link );
				} else {
					$metadata .= sprintf( '%s <span class="vcard"><span class="fn">%s</span></span><span class="fusion-inline-sep">|</span>', __( 'By', 'Avada' ), $author_post_link );
				}
			// If author meta data won't be visible, render just the invisible author rich snippet
			} else {
				$author .= avada_render_rich_snippets_for_pages( FALSE, TRUE, FALSE );
			}
			
			// Render the updated meta data or at least the rich snippet if enabled
			if ( ! $settings['post_meta_date'] ) { 
				$metadata .= avada_render_rich_snippets_for_pages( FALSE, FALSE, TRUE );
				$metadata .= sprintf( '<span>%s</span><span class="fusion-inline-sep">|</span>', get_the_time( $smof_data['date_format'] ) );
			} else {
				$date .= avada_render_rich_snippets_for_pages( FALSE, FALSE, TRUE );
			}		
			
			// Render rest of meta data
			if ( $layout != 'grid_timeline' ) {
				// Render categories
				if ( ! $settings['post_meta_cats'] ) {
					ob_start();
					the_category( ', ' );
					$categories = ob_get_clean();				 

					if ( $categories ) {
						if ( ! $settings['post_meta_tags'] ) { 
							$metadata .=  __( 'Categories:', 'Avada' ) . ' ';
						}

						$metadata .= sprintf( '%s<span class="fusion-inline-sep">|</span>', $categories );
					}
				}

				// Render tags
				if ( ! $settings['post_meta_tags'] ) {
					ob_start();
					the_tags( '' );
					$tags = ob_get_clean();					 

					if( $tags ) {
						$metadata .= sprintf( '<span class="meta-tags">%s %s</span><span class="fusion-inline-sep">|</span>', __( 'Tags:', 'Avada' ), $tags );
					}
				}

				// Render comments
				if ( ! $settings['post_meta_comments'] ) {	
					ob_start();
					comments_popup_link( __( '0 Comments', 'Avada' ), __( '1 Comment', 'Avada' ), '% ' . __( 'Comments', 'Avada' ) );
					$comments = ob_get_clean();	
					$metadata .= sprintf( '<span class="fusion-comments">%s</span>', $comments );
				}
			}
					
			// Render the HTML wrappers for the different layouts
			if ( $metadata ) {
				$metadata = $author . $date . $metadata;
			
				if ( $layout == 'single' ) {
					$html .= sprintf ( '<div class="fusion-meta-info"><div class="fusion-meta-info-wrapper">%s</div></div>', $metadata );				
				} elseif ( $layout == 'alternate' || 
					$layout == 'grid_timeline' 
				) {
					$html .= sprintf( '<p class="fusion-single-line-meta">%s</p>', $metadata );
				} else {
					$html .= sprintf( '<div class="fusion-alignleft">%s</div>', $metadata );
				}
			} else {
				$html .= $author . $date;
			}
		// Render author and updated rich snippets for grid and timeline layouts
		} else {
			if ( ! $smof_data['disable_date_rich_snippet_pages'] ) {
				$html .= avada_render_rich_snippets_for_pages( FALSE );
			}
		}

		return $html;
	}
}

if( ! function_exists( 'avada_render_related_posts' ) ) {
	/**
	 * Render related posts carousel
	 * @param  string $post_type 		The post type to determine correct related posts and headings
	 *
	 * @return string 					HTML markup to display related posts
	 **/
	function avada_render_related_posts( $post_type = 'post' ) {
		global $smof_data;
		$html = '';

		// Set the needed variables according to post type
		if ( $post_type == 'post' ) {
			$theme_option_name = 'related_posts';
			$main_heading =  __( 'Related Posts', 'Avada' );
		} elseif ( $post_type == 'avada_portfolio' ) {
			$theme_option_name = 'portfolio_related_posts';
			$main_heading =  __( 'Related Projects', 'Avada' );
		}

		// Check if related posts should be shown		
		if ( fusion_get_option( $theme_option_name, 'related_posts', get_the_ID() ) == 'yes' ||
			 fusion_get_option( $theme_option_name, 'related_posts', get_the_ID() ) == '1'
		) {
			if ( $post_type == 'post' ) {
				$related_posts = fusion_get_related_posts( get_the_ID(), $smof_data['number_related_posts'] );
			} elseif ( $post_type == 'avada_portfolio' ) {
				$related_posts = fusion_get_related_projects( get_the_ID(), $smof_data['number_related_posts'] );
			}
			
			// If there are related posts, display them
			if ( $related_posts->have_posts() ) {
				$html .= '<div class="related-posts single-related-posts">';
					ob_start();
					echo do_shortcode( sprintf( '[title size="2" content_align="left" style_type="default"]%s[/title]', $main_heading ) );
					$html .= ob_get_clean();
					
					// Get the correct image size
					if ( $smof_data['related_posts_image_size'] == 'cropped' ) {
						$featured_image_size = 'fixed';
						$data_image_size = 'fixed';
					} else {
						$featured_image_size = 'full';
						$data_image_size = 'auto';
					}
					
					// Set the meta content variable
					if ( $smof_data['related_posts_layout'] == 'title_on_rollover' ) {	
						$data_meta_content = 'no';
					} else {
						$data_meta_content = 'yes';
					}
					
					// Set the autoplay variable
					if ( $smof_data['related_posts_autoplay'] ) {
						$data_autoplay = 'yes';
					} else {
						$data_autoplay = 'no';
					}
					
					// Set the touch scroll variable
					if ( $smof_data['related_posts_swipe'] ) {
						$data_swipe = 'yes';
					} else {
						$data_swipe = 'no';
					}				
					
					$carousel_item_css = '';
					if ( sizeof( $related_posts->posts ) < $smof_data['related_posts_columns'] ) {
						$carousel_item_css = ' style="max-width: 300px;"';
					}						
					
					$html .= sprintf( '<div class="fusion-carousel" data-imagesize="%s" data-metacontent="%s" data-autoplay="%s" data-touchscroll="%s" data-columns="%s" data-itemmargin="%s" data-itemwidth="180" data-touchscroll="yes" data-scrollitems="%s">', 
									  $data_image_size, $data_meta_content, $data_autoplay, $data_swipe, $smof_data['related_posts_columns'], $smof_data['related_posts_column_spacing'], $smof_data['related_posts_swipe_items'] );
						$html .= '<div class="fusion-carousel-positioner">';
							$html .= '<ul class="fusion-carousel-holder">';
								// Loop through related posts
								while( $related_posts->have_posts() ): $related_posts->the_post();
									$html .= sprintf( '<li class="fusion-carousel-item"%s>', $carousel_item_css );
										$html .= '<div class="fusion-carousel-item-wrapper">';
											// Title on rollover layout
											if ( $smof_data['related_posts_layout'] == 'title_on_rollover' ) {
												$html .= avada_render_first_featured_image_markup( get_the_ID(), $featured_image_size, get_permalink( get_the_ID() ), TRUE, FALSE, FALSE, 'disable', 'default', 'related' );
											// Title below image layout
											} else {
												$html .= avada_render_first_featured_image_markup( get_the_ID(), $featured_image_size, get_permalink( get_the_ID() ), TRUE, FALSE, FALSE, 'disable', 'disable', 'related' );
												
												// Get the post title
												$html .= sprintf( '<h4 class="fusion-carousel-title"><a href="%s"%s>%s</a></h4>', get_permalink( get_the_ID() ), '_self', get_the_title() );
												
												$html .= '<div class="fusion-carousel-meta">';
												
													$html .= sprintf( '<span class="fusion-date">%s</span>', get_the_time( $smof_data['date_format'], get_the_ID() ) );
													
													$html .= '<span class="fusion-inline-sep">|</span>';
													
													$comments = $comments_link = '';
													ob_start();
													comments_popup_link( __( '0 Comments', 'Avada' ), __( '1 Comment', 'Avada' ), '% ' . __( 'Comments', 'Avada' ) );
													$comments_link = ob_get_clean();

													$html .= sprintf( '<span>%s</span>', $comments_link );	

												$html .= '</div>'; // fusion-carousel-meta
											}
										$html .= '</div>'; // fusion-carousel-item-wrapper
									$html .= '</li>';
								endwhile;
							$html .= '</ul>'; // fusion-carousel-holder
							// Add navigation if needed
							if ( $smof_data['related_posts_navigation'] ) {
								$html .= '<div class="fusion-carousel-nav"><span class="fusion-nav-prev"></span><span class="fusion-nav-next"></span></div>';	
							}
						$html .= '</div>'; // fusion-carousel-positioner
					$html .= '</div>'; // fusion-carousel
				$html .= '</div>'; // related-posts
				
				wp_reset_postdata();
			}
		}
		
		return $html;
	}
}


if( ! function_exists( 'avada_render_rich_snippets_for_pages' ) ) {
	/**
	 * Render the full meta data for blog archive and single layouts
	 * @param  boolean $title_tag 		Set to TRUE to render title rich snippet
	 * @param  boolean $author_tag 		Set to TRUE to render author rich snippet
	 * @param  boolean $updated_tag 	Set to TRUE to render updated rich snippet 
	 *
	 * @return string 					HTML markup to display rich snippets
	 **/
	function avada_render_rich_snippets_for_pages( $title_tag = TRUE, $author_tag = TRUE, $updated_tag = TRUE ) {
		global $smof_data;
		
		$html = '';
		
		if( ! $smof_data['disable_date_rich_snippet_pages'] ) {
		
			if( $title_tag ) {
				$html = '<span class="entry-title" style="display: none;">' . get_the_title() . '</span>';
			}
			
			if( $author_tag ) {
				ob_start();
				the_author_posts_link();
				$author_post_link = ob_get_clean();
				$html .= '<span class="vcard" style="display: none;"><span class="fn">' . $author_post_link . '</span></span>';
			}
			
			if( $updated_tag ) {
				$html .= '<span class="updated" style="display:none;">' . get_the_modified_time( 'c' ) . '</span>';
			}
		}
		
		return $html;
	}
}

if ( ! function_exists( 'avada_process_tag' ) ) {
	/**
	 * For specific shortcodes return the shortcode contents, to be able to use it in excerpts
	 *
	 * @return string The shortcode contents
	 **/
	function avada_process_tag( $m ) {
		if ( $m[2] == 'dropcap' || 
			 $m[2] == 'highlight' || 
			 $m[2] == 'tooltip' || 
			 $m[2] == 'fusion_text' || 
			 $m[2] == 'vc_row' || 
			 $m[2] == 'vc_column' ||  
			 $m[2] == 'vc_column_text'
		) {
			return $m[0];
		}
		
		if ( $m[2] == 'fullwidth' ) {
			return strip_shortcodes( $m[5] );
		}

		// allow [[foo]] syntax for escaping a tag
		if ( $m[1] == '[' && 
			 $m[6] == ']' 
		) {
			return substr($m[0], 1, -1);
		}

	   return $m[1] . $m[6];
	}
}

if( ! function_exists( 'avada_page_title_bar' ) ) {
	/**
	 * Render the HTML markup of the page title bar
	 * @param  string $title 				Main title; page/post title or custom title set by user
	 * @param  string $subtitle 			Subtitle as custom user setting
	 * @param  string $secondary_content 	HTML markup of the secondary content; breadcrumbs or search field
	 *
	 * @return void 						Content is directly echoed
	 **/
	function avada_page_title_bar( $title, $subtitle, $secondary_content ) {
		global $smof_data;
		$post_id = get_queried_object_id();

		// Check for the secondary content
		$content_type = 'none';
		if ( strpos( $secondary_content, 'searchform' ) !== FALSE ) {
			$content_type = 'search';
		} elseif ( $secondary_content != '' ) {
			$content_type = 'breadcrumbs';
		}

		// Check the position of page title
		if ( metadata_exists( 'post', $post_id, 'pyre_page_title_text_alignment' ) && 
			 get_post_meta( get_queried_object_id(), 'pyre_page_title_text_alignment', TRUE ) != 'default' 
		) {
			$alignment = get_post_meta( $post_id, 'pyre_page_title_text_alignment', TRUE );
		} elseif ( $smof_data['page_title_alignment'] ) {
			$alignment = $smof_data['page_title_alignment'];
		}

		// Render the page title bar
		echo sprintf( '<div class="fusion-page-title-bar fusion-page-title-bar-%s fusion-page-title-bar-%s">', $content_type, $alignment );
			echo '<div class="fusion-page-title-row">';
				echo '<div class="fusion-page-title-wrapper">';
					echo '<div class="fusion-page-title-captions">';
						if( $title ) {
							// Add entry-title for rich snippets
							$entry_title_class = '';
							if ( ! $smof_data['disable_date_rich_snippet_pages'] ) { 
								$entry_title_class = ' class="entry-title"';
							}					
							echo sprintf( '<h1%s>%s</h1>', $entry_title_class, $title );

							if ( $subtitle ) {
								echo sprintf( '<h3>%s</h3>', $subtitle );
							}
						}

						// Render secondary content on center layout
						if ( $alignment == 'center') {
							if ( fusion_get_option( 'page_title_bar_bs', 'page_title_breadcrumbs_search_bar', $post_id ) != 'none' ) {
								echo '<div class="fusion-page-title-secondary">';
									echo $secondary_content;
								echo '</div>';
							}
						}

					echo '</div>';
					
					// Render secondary content on left/right layout
					if ( $alignment != 'center' ) {
						if ( fusion_get_option( 'page_title_bar_bs', 'page_title_breadcrumbs_search_bar', $post_id ) != 'none' ) {
							echo '<div class="fusion-page-title-secondary">';
								echo $secondary_content;
							echo '</div>';
						}
					}

				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
}

add_filter( 'wp_nav_menu_items', 'avada_add_login_box_to_nav', 10, 3 );
/**
 * Add woocommerce cart to main navigation or top navigation
 * @param  string HTML for the main menu items
 * @param  args   Arguments for the WP menu
 * @return string   
 */
if( ! function_exists( 'avada_add_login_box_to_nav' ) ) {
	function avada_add_login_box_to_nav( $items, $args ) {
		$ubermenu = false;

		if( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ubermenu_get_menu_instance_by_theme_location( $args->theme_location ) ) {
			// disable woo cart on ubermenu navigations
			$ubermenu = true;
		}

		if( $ubermenu == false ) {
			if( $args->theme_location == 'main_navigation' || $args->theme_location == 'top_navigation' || $args->theme_location == 'sticky_navigation' ) {
				if( $args->theme_location == 'main_navigation' || $args->theme_location == 'sticky_navigation' ) {
					$is_enabled = fusion_get_theme_option( 'woocommerce_acc_link_main_nav' );
				} else if( $args->theme_location == 'top_navigation' ) {
					$is_enabled = fusion_get_theme_option( 'woocommerce_acc_link_top_nav' );
				}

				if( class_exists( 'Woocommerce' ) && $is_enabled ) {
					$woo_account_page_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
					$logout_link = wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) );
					
					if ( $woo_account_page_link ) {
						$items .= '<li class="fusion-custom-menu-item fusion-menu-login-box">';
							$items .= sprintf( '<a href="%s">%s</a>', $woo_account_page_link, __( 'My Account', 'Avada' ) );
							if( ! is_user_logged_in() ) {
							$items .= '<div class="fusion-custom-menu-item-contents">';
								if( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) {
									$items .= sprintf( '<p class="fusion-menu-login-box-error">%s</p>', __( 'Login failed, please try again', 'Avada' ) );
								}
								$items .= sprintf( '<form action="%s" name="loginform" method="post">', wp_login_url() );
									$items .= sprintf( '<p><input type="text" class="input-text" name="log" id="username" value="" placeholder="%s" /></p>', __( 'Username', 'Avada' ) );
									$items .= sprintf( '<p><input type="password" class="input-text" name="pwd" id="password" value="" placeholder="%s" /></p>', __( 'Password', 'Avada' ) );
									$items .= sprintf( '<p class="fusion-remember-checkbox"><label for="fusion-menu-login-box-rememberme"><input name="rememberme" type="checkbox" id="fusion-menu-login-box-rememberme" value="forever"> %s</label></p>', __( 'Remember Me', 'Avada' ) );
									$items .= sprintf( '<p class="fusion-login-box-submit">
															<input type="submit" name="wp-submit" id="wp-submit" class="button small default comment-submit" value="%s">
															<input type="hidden" name="redirect_to" value="%s">
															<input type="hidden" name="testcookie" value="1">
														</p>', __( 'Log In', 'Avada' ), ( isset( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : '' );
								$items .= '</form>';
							$items .= '</div>';
							} else {
								$items .= '<ul class="sub-menu">';
									$items .= sprintf( '<li><a href="%s">%s</a></li>', $logout_link, __( 'Logout', 'Avada' ) );
								$items .= '</ul>';
							}
						$items .= '</li>';
					}
				}
			}
		}

		return $items;
	}
}

if( ! function_exists( 'avada_nav_woo_cart' ) ) {
	/**
	 * Woo Cart Dropdown for Main Nav or Top Nav
	 * 
	 * @return string HTML of Dropdown
	 */
	function avada_nav_woo_cart( $position = 'main' ) {
		global $woocommerce;

		if( $position == 'main' ) {
			$is_enabled = fusion_get_theme_option( 'woocommerce_cart_link_main_nav' );
			$main_cart_class = 'fusion-main-menu-cart';
			$cart_link_active_class = 'fusion-main-menu-icon fusion-main-menu-icon-active';
			$cart_link_active_text = '';
			$cart_link_inactive_class = 'fusion-main-menu-icon';
			$cart_link_inactive_text = '';
		} else if( $position ='secondary' ) {
			$is_enabled = fusion_get_theme_option( 'woocommerce_cart_link_top_nav' );
			$main_cart_class = 'fusion-secondary-menu-cart';
			$cart_link_active_class = 'fusion-secondary-menu-icon';
			$cart_link_active_text = sprintf('%s %s <span class="fusion-woo-cart-separator">-</span> %s', $woocommerce->cart->cart_contents_count, __( 'Item(s)', 'Avada' ),wc_price( $woocommerce->cart->subtotal ) );
			$cart_link_inactive_class = $cart_link_active_class;
			$cart_link_inactive_text = __( 'Cart', 'Avada' );
		}

		if( class_exists( 'Woocommerce' ) && $is_enabled ) {
			$woo_cart_page_link = get_permalink( get_option( 'woocommerce_cart_page_id' ) );

			$items = sprintf( '<li class="fusion-custom-menu-item fusion-menu-cart %s">', $main_cart_class );
				if( $woocommerce->cart->cart_contents_count ) {
					$checkout_link = get_permalink( get_option('woocommerce_checkout_page_id') );

					$items .= sprintf( '<a class="%s" href="%s">%s</a>', $cart_link_active_class, $woo_cart_page_link, $cart_link_active_text );
					
					$items .= '<div class="fusion-custom-menu-item-contents fusion-menu-cart-items">';
						foreach( $woocommerce->cart->cart_contents as $cart_item ) {
							$product_link = get_permalink( $cart_item['product_id'] );
							$thumbnail_id = ( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
							$items .= '<div class="fusion-menu-cart-item">';
								$items .= sprintf( '<a href="%s">', $product_link );
									$items .= get_the_post_thumbnail( $thumbnail_id, 'recent-works-thumbnail' );
									$items .= '<div class="fusion-menu-cart-item-details">';
										$items .= sprintf( '<span class="fusion-menu-cart-item-title">%s</span>', $cart_item['data']->post->post_title );
										$items .= sprintf( '<span class="fusion-menu-cart-item-quantity">%s x %s</span>', $cart_item['quantity'], $woocommerce->cart->get_product_subtotal( $cart_item['data'], 1 ) );
									$items .= '</div>';
								$items .= '</a>';
							$items .= '</div>';
						}
						$items .= '<div class="fusion-menu-cart-checkout">';
							$items .= sprintf( '<div class="fusion-menu-cart-link"><a href="%s">%s</a></div>', $woo_cart_page_link, __('View Cart', 'Avada') );
							$items .= sprintf( '<div class="fusion-menu-cart-checkout-link"><a href="%s">%s</a></div>', $checkout_link, __('Checkout', 'Avada') );
						$items .= '</div>';
					$items .= '</div>';
				} else {
					$items .= sprintf( '<a class="%s" href="%s">%s</a>', $cart_link_inactive_class, $woo_cart_page_link, $cart_link_inactive_text );
				}
			$items .= '</li>';

			return $items;
		}
	}
}

if( class_exists( 'Woocommerce' ) ) {
	add_filter( 'wp_nav_menu_items', 'avada_add_woo_cart_to_nav', 10, 3 );
}
/**
 * Add woocommerce cart to main navigation or top navigation
 * @param  string HTML for the main menu items
 * @param  args   Arguments for the WP menu
 * @return string   
 */
if( ! function_exists( 'avada_add_woo_cart_to_nav' ) ) {
	function avada_add_woo_cart_to_nav( $items, $args ) {
		global $woocommerce;

		$ubermenu = false;

		if( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ubermenu_get_menu_instance_by_theme_location( $args->theme_location ) ) {
			// disable woo cart on ubermenu navigations
			$ubermenu = true;
		}

		if( $ubermenu == false && $args->theme_location == 'main_navigation' || $args->theme_location == 'sticky_navigation' ) {
			$items .= avada_nav_woo_cart( 'main' );
		} else if( $ubermenu == false && $args->theme_location == 'top_navigation' ) {
			$items .= avada_nav_woo_cart( 'secondary' );
		}

		return $items;
	}
}
add_filter( 'wp_nav_menu_items', 'avada_add_search_to_main_nav', 20, 4 );
/**
 * Add search to the main navigation
 * @param  string HTML for the main menu items
 * @param  args   Arguments for the WP menu
 * @return string   
 */
if( ! function_exists( 'avada_add_search_to_main_nav' ) ) {
	function avada_add_search_to_main_nav( $items, $args ) {
		$ubermenu = false;

		if( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ubermenu_get_menu_instance_by_theme_location( $args->theme_location ) ) {
			// disable woo cart on ubermenu navigations
			$ubermenu = true;
		}

		if( $ubermenu == false ) {
			if( $args->theme_location == 'main_navigation'  || $args->theme_location == 'sticky_navigation' ) {
				if( fusion_get_theme_option( 'main_nav_search_icon' ) ) {
					$items .= '<li class="fusion-custom-menu-item fusion-main-menu-search">';
						$items .= '<a class="fusion-main-menu-icon"></a>';
						$items .= '<div class="fusion-custom-menu-item-contents">';
							$items .= get_search_form( false );
						$items .= '</div>';
					$items .= '</li>';
				}
			}
		}

		return $items;
	}
}

if( ! function_exists( 'avada_update_featured_content_for_split_terms' ) ) {
	function avada_update_featured_content_for_split_terms( $old_term_id, $new_term_id, $term_taxonomy_id, $taxonomy ) {
		if( 'portfolio_category' == $taxonomy ) {
			$pages = get_pages();

			if( $pages ) {
			    foreach( $pages as $page ) {
			    	$page_id = $page->ID;
			    	$categories = get_post_meta( $page_id, 'pyre_portfolio_category', true );
			    	$new_categories = array();
			    	if( $categories ) {
			    		foreach( $categories as $category ) {
			    			if( $category != '0' ) {
			    				if ( isset( $category ) && $old_term_id == $category ) {
			    					$new_categories[] = $new_term_id;
			    				} else {
			    					$new_categories[] = $category;
			    				}
			    			} else {
			    				$new_categories[] = '0';
			    			}
			    		}

			    		update_post_meta( $page_id, 'pyre_portfolio_category', $new_categories );
			    	}
			    }
			}
		}
	}
	
	add_action( 'split_shared_term', 'avada_update_featured_content_for_split_terms', 10, 4 );
}
