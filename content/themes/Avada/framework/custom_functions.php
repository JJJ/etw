<?php
// why do we need this function?
if( ! function_exists( 'tf_checkIfMenuIsSetByLocation' ) ) {
	function tf_checkIfMenuIsSetByLocation($menu_location = '') {
		if(has_nav_menu($menu_location)) {
			return true;
		}

		return false;
	}
}


add_action('wp_head', 'avada_set_post_views');
if( ! function_exists( 'avada_set_post_views' ) ) {
	function avada_set_post_views() {
		global $post;

		if('post' == get_post_type() && is_single()) {
			$postID = $post->ID;

			if(!empty($postID)) {
				$count_key = 'avada_post_views_count';
				$count = get_post_meta($postID, $count_key, true);

				if($count == '') {
					$count = 0;
					delete_post_meta($postID, $count_key);
					add_post_meta($postID, $count_key, '0');
				} else {
					$count++;
					update_post_meta($postID, $count_key, $count);
				}
			}
		}
	}
}

add_filter( 'bbp_get_forum_pagination_links', 'tf_get_forum_pagination_links', 1 );
if( ! function_exists( 'tf_get_forum_pagination_links' ) ) {
	function tf_get_forum_pagination_links() {
		$bbp = bbpress();

		$pagination_links = $bbp->topic_query->pagination_links;

		$pagination_links = str_replace( 'page-numbers current', 'current', $pagination_links );
		$pagination_links = str_replace( 'page-numbers', 'inactive', $pagination_links );
		$pagination_links = str_replace( 'prev inactive', 'pagination-prev', $pagination_links );
		$pagination_links = str_replace( 'next inactive', 'pagination-next', $pagination_links );

		$pagination_links = str_replace( '&larr;', __('Previous', 'Avada').'<span class="page-prev"></span>', $pagination_links );
		$pagination_links = str_replace( '&rarr;', __('Next', 'Avada').'<span class="page-next"></span>', $pagination_links );

		return $pagination_links;
	}
}

add_filter( 'bbp_get_topic_pagination_links', 'tf_get_topic_pagination_links', 1 );
if( ! function_exists( 'tf_get_topic_pagination_links' ) ) {
	function tf_get_topic_pagination_links() {
		$bbp = bbpress();

		$pagination_links = $bbp->reply_query->pagination_links;
		$permalink		= get_permalink( $bbp->current_topic_id );
		$max_num_pages	= $bbp->reply_query->max_num_pages;
		$paged			= $bbp->reply_query->paged;

		$pagination_links = str_replace( 'page-numbers current', 'current', $pagination_links );
		$pagination_links = str_replace( 'page-numbers', 'inactive', $pagination_links );
		$pagination_links = str_replace( 'prev inactive', 'pagination-prev', $pagination_links );
		$pagination_links = str_replace( 'next inactive', 'pagination-next', $pagination_links );

		$pagination_links = str_replace( '&larr;', __('Previous', 'Avada').'<span class="page-prev"></span>', $pagination_links );
		$pagination_links = str_replace( '&rarr;', __('Next', 'Avada').'<span class="page-next"></span>', $pagination_links );

		return $pagination_links;
	}
}

add_filter( 'bbp_get_search_pagination_links', 'tf_get_search_pagination_links', 1 );
if( ! function_exists( 'tf_get_search_pagination_links' ) ) {
	function tf_get_search_pagination_links() {
		$bbp = bbpress();

		$pagination_links = $bbp->search_query->pagination_links;

		$pagination_links = str_replace( 'page-numbers current', 'current', $pagination_links );
		$pagination_links = str_replace( 'page-numbers', 'inactive', $pagination_links );
		$pagination_links = str_replace( 'prev inactive', 'pagination-prev', $pagination_links );
		$pagination_links = str_replace( 'next inactive', 'pagination-next', $pagination_links );

		$pagination_links = str_replace( '&larr;', __('Previous', 'Avada').'<span class="page-prev"></span>', $pagination_links );
		$pagination_links = str_replace( '&rarr;', __('Next', 'Avada').'<span class="page-next"></span>', $pagination_links );

		return $pagination_links;
	}
}

if( ! function_exists( 'avada_slider_name' ) ) {
	function avada_slider_name( $name ) {
		$type = '';
		
		switch( $name ) {
			case 'layer':
				$type = 'slider';
				break;
			case 'flex':
				$type = 'wooslider';
				break;
			case 'rev':
				$type = 'revslider';
				break;
			case 'elastic':
				$type = 'elasticslider';
				break;
		}

		return $type;
	}
}

if( ! function_exists( 'avada_get_slider_type' ) ) {
	function avada_get_slider_type( $post_id ) {
		$get_slider_type = get_post_meta($post_id, 'pyre_slider_type', true);

		return $get_slider_type;
	}
}

if( ! function_exists( 'avada_get_slider' ) ) {
	function avada_get_slider( $post_id, $type ) {
		$type = avada_slider_name( $type );

		if( $type ) {
			$get_slider = get_post_meta( $post_id, 'pyre_' . $type, true );

			return $get_slider;
		} else {
			return false;
		}
	}
}

if( ! function_exists( 'avada_slider' ) ) {
	function avada_slider( $post_id ) {
		$slider_type = avada_get_slider_type( $post_id );
		$slider = avada_get_slider( $post_id, $slider_type );

		if( $slider ) {
			$slider_name = avada_slider_name( $slider_type );

			if( $slider_name == 'slider' ) {
				$slider_name = 'layerslider';
			}

			$function = 'avada_' . $slider_name;

			$function( $slider );
		}
	}
}

if( ! function_exists( 'avada_revslider' ) ) {
	function avada_revslider( $name ) {
		if( function_exists('putRevSlider') ) {
			putRevSlider( $name );
		}
	}
}

if( ! function_exists( 'avada_layerslider' ) ) {
	function avada_layerslider( $id ) {
		global $wpdb;

		// Get slider
		$ls_table_name = $wpdb->prefix . "layerslider";
		$ls_slider = $wpdb->get_row("SELECT * FROM $ls_table_name WHERE id = " . (int) $id . " ORDER BY date_c DESC LIMIT 1" , ARRAY_A);
		$ls_slider = json_decode($ls_slider['data'], true);
		?>
		<style type="text/css">
			#layerslider-container{max-width:<?php echo $ls_slider['properties']['width'] ?>;}
		</style>
		<div id="layerslider-container">
			<div id="layerslider-wrapper">
				<?php if($ls_slider['properties']['skin'] == 'avada'): ?>
					<div class="ls-shadow-top"></div>
				<?php endif; ?>
				<?php echo do_shortcode('[layerslider id="' . $id . '"]'); ?>
				<?php if($ls_slider['properties']['skin'] == 'avada'): ?>
					<div class="ls-shadow-bottom"></div>
				<?php endif; ?>
			</div>
		</div>
	<?php
	}
}

if( ! function_exists( 'avada_elasticslider' ) ) {
	function avada_elasticslider( $term ) {
		global $smof_data;

		if( ! $smof_data['status_eslider'] ) {
			$args				= array(
				'post_type'		=> 'themefusion_elastic',
				'posts_per_page'   => - 1,
				'suppress_filters' => 0
			);
			$args['tax_query'][] = array(
				'taxonomy' => 'themefusion_es_groups',
				'field'	=> 'slug',
				'terms'	=> $term
			);
			$query			   = new WP_Query( $args );
			$count			   = 1;
			if ( $query->have_posts() ) {
			?>
				<div id="ei-slider" class="ei-slider">
					<div class="fusion-slider-loading"><?php _e( 'Loading...', 'Avada' ); ?></div>
					<ul class="ei-slider-large">
						<?php while ( $query->have_posts() ): $query->the_post(); ?>
							<li style="<?php echo ( $count > 0 ) ? 'opacity: 0;' : ''; ?>">
								<?php the_post_thumbnail( 'full', array( 'title' => '', 'alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ) ); ?>
								<div class="ei-title">
									<?php if ( get_post_meta( get_the_ID(), 'pyre_caption_1', true ) ): ?>
										<h2><?php echo get_post_meta( get_the_ID(), 'pyre_caption_1', true ); ?></h2>
									<?php endif; ?>
									<?php if ( get_post_meta( get_the_ID(), 'pyre_caption_2', true ) ): ?>
										<h3><?php echo get_post_meta( get_the_ID(), 'pyre_caption_2', true ); ?></h3>
									<?php endif; ?>
								</div>
							</li>
							<?php $count ++; endwhile; ?>
					</ul>
					<ul class="ei-slider-thumbs" style="display: none;">
						<li class="ei-slider-element">Current</li>
						<?php while ( $query->have_posts() ): $query->the_post(); ?>
							<li>
								<a href="#"><?php the_title(); ?></a>
								<?php the_post_thumbnail( 'full', array( 'title' => '', 'alt' => get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ) ); ?>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php
				wp_reset_postdata();
			}
			wp_reset_query();
		}
	}
}

if( ! function_exists( 'avada_wooslider' ) ) {
	function avada_wooslider( $term ) {
		global $smof_data;

		if( ! $smof_data['status_fusion_slider'] ) {
			$term_details = get_term_by( 'slug', $term, 'slide-page' );

			$slider_settings = get_option( 'taxonomy_' . $term_details->term_id );

			if( ! isset( $slider_settings['typo_sensitivity'] ) ) {
				$slider_settings['typo_sensitivity'] = '0.6';
			}

			if( ! isset( $slider_settings['typo_factor'] ) ) {
				$slider_settings['typo_factor'] = '1.5';
			}


			if( ! isset( $slider_settings['slider_width'] ) || $slider_settings['slider_width'] == '' ) {
				$slider_settings['slider_width'] = '100%';
			}

			if( ! isset( $slider_settings['slider_height'] ) || $slider_settings['slider_height'] == '' ) {
				$slider_settings['slider_height'] = '500px';
			}

			if( ! isset( $slider_settings['full_screen'] ) ) {
				$slider_settings['full_screen'] = false;
			}

			if( ! isset( $slider_settings['animation'] ) ) {
				$slider_settings['animation'] = true;
			}

			$slider_data = '';
			
			if( $slider_settings ) {
				foreach( $slider_settings as $slider_setting => $slider_setting_value ) {
					$slider_data .= 'data-' . $slider_setting . '="' . $slider_setting_value . '" ';
				}
			}

			$slider_class = '';

			if( $slider_settings['slider_width'] == '100%' && ! $slider_settings['full_screen'] ) {
				$slider_class .= ' full-width-slider';
			}

			if( $slider_settings['slider_width'] != '100%' && ! $slider_settings['full_screen'] ) {
				$slider_class .= ' fixed-width-slider';
			}

			if( isset( $slider_settings['slider_content_width'] ) && $slider_settings['slider_content_width'] != '' ) {
				$content_max_width = sprintf( 'max-width: %s;', $slider_settings['slider_content_width'] );
			} else {
				$content_max_width = '';
			}

			$args				= array(
				'post_type'		=> 'slide',
				'posts_per_page'   => -1,
				'suppress_filters' => 0
			);
			$args['tax_query'][] = array(
				'taxonomy' => 'slide-page',
				'field'	=> 'slug',
				'terms'	=> $term
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
			
				if ( $slider_settings['animation'] == 'fade' ) {
					$max_width = 'max-width:' . $slider_settings['slider_width'];
				} else {
					$max_width = '';
				}
				?>
				<div class="fusion-slider-container <?php echo $slider_class; ?>-container" style="height:<?php echo $slider_settings['slider_height']; ?>;max-width:<?php echo $slider_settings['slider_width']; ?>;">
					<div class="fusion-slider-loading"><?php _e( 'Loading...', 'Avada' ); ?></div>
					<div class="tfs-slider flexslider main-flex<?php echo $slider_class; ?>" style="max-width:<?php echo $slider_settings['slider_width']; ?>;" <?php echo $slider_data; ?>>
						<ul class="slides" style="<?php echo $max_width ?>;">
							<?php
							while( $query->have_posts() ): $query->the_post();
								$metadata = get_metadata( 'post', get_the_ID() );
								
								$background_image = '';
								$background_class = '';

								$img_width = '';

								if( isset( $metadata['pyre_type'][0] ) && $metadata['pyre_type'][0] == 'image' && has_post_thumbnail() ) {
									$image_id = get_post_thumbnail_id();
									$image_url = wp_get_attachment_image_src( $image_id, 'full', true );
									$background_image = 'background-image: url(' . $image_url[0] . ');';
									$background_class = 'background-image';
									$img_width = $image_url[1];
								}

								$video_attributes = '';
								$youtube_attributes = '';
								$vimeo_attributes = '';
								$data_mute = 'no';
								$data_loop = 'no';
								$data_autoplay = 'no';

								if( isset( $metadata['pyre_mute_video'][0] ) && $metadata['pyre_mute_video'][0] == 'yes' ) {
									$video_attributes = 'muted';
									$data_mute = 'yes';
								}

								if( isset( $metadata['pyre_autoplay_video'][0] ) && $metadata['pyre_autoplay_video'][0] == 'yes' ) {
									$video_attributes .= ' autoplay';
									$youtube_attributes .= '&amp;autoplay=0';
									$vimeo_attributes .= '&amp;autoplay=0';
									$data_autoplay = 'yes';
								}

								if( isset( $metadata['pyre_loop_video'][0] ) && $metadata['pyre_loop_video'][0] == 'yes' ) {
									$video_attributes .= ' loop';
									$youtube_attributes .= '&amp;loop=1&amp;playlist=' . $metadata['pyre_youtube_id'][0];
									$vimeo_attributes .= '&amp;loop=1';
									$data_loop = 'yes';
								}

								if( isset ( $metadata['pyre_hide_video_controls'][0] ) && $metadata['pyre_hide_video_controls'][0] == 'no' ) {
									$video_attributes .= ' controls';
									$youtube_attributes .= '&amp;controls=1';
									$video_zindex = 'z-index: 1;';
								} else {
									$youtube_attributes .= '&amp;controls=0';
									$video_zindex = 'z-index: -99;';
								}

								$heading_color = '';

								if( isset ( $metadata['pyre_heading_color'][0] ) && $metadata['pyre_heading_color'][0] ) {
									$heading_color = 'color:' . $metadata['pyre_heading_color'][0] . ';';
								}

								$heading_bg = '';

								if( isset ( $metadata['pyre_heading_bg'][0] ) && $metadata['pyre_heading_bg'][0] == 'yes' ) {
									$heading_bg = 'background-color: rgba(0,0,0, 0.4);';
									if( isset ( $metadata['pyre_heading_bg_color'][0] ) && $metadata['pyre_heading_bg_color'][0] != '' ) {
										$rgb = fusion_hex2rgb( $metadata['pyre_heading_bg_color'][0] );
										$heading_bg = sprintf( 'background-color: rgba(%s,%s,%s,%s);', $rgb[0], $rgb[1], $rgb[2], 0.4 );
									}
								}

								$caption_color = '';

								if( isset ( $metadata['pyre_caption_color'][0] ) && $metadata['pyre_caption_color'][0] ) {
									$caption_color = 'color:' . $metadata['pyre_caption_color'][0] . ';';
								}

								$caption_bg = '';

								if( isset ( $metadata['pyre_caption_bg'][0] ) && $metadata['pyre_caption_bg'][0] == 'yes' ) {
									$caption_bg = 'background-color: rgba(0, 0, 0, 0.4);';

									if( isset ( $metadata['pyre_caption_bg_color'][0] ) && $metadata['pyre_caption_bg_color'][0] != '' ) {
										$rgb = fusion_hex2rgb( $metadata['pyre_caption_bg_color'][0] );
										$caption_bg = sprintf( 'background-color: rgba(%s,%s,%s,%s);', $rgb[0], $rgb[1], $rgb[2], 0.4 );
									}
								}

								$video_bg_color = '';

								if( isset ( $metadata['pyre_video_bg_color'][0] ) && $metadata['pyre_video_bg_color'][0] ) {
									$video_bg_color_hex = fusion_hex2rgb( $metadata['pyre_video_bg_color'][0]  );
									$video_bg_color = 'background-color: rgba(' . $video_bg_color_hex[0] . ', ' . $video_bg_color_hex[1] . ', ' . $video_bg_color_hex[2] . ', 0.4);';
								}

								$video = false;

								if( isset( $metadata['pyre_type'][0] ) ) {
									if( isset( $metadata['pyre_type'][0] ) && $metadata['pyre_type'][0] == 'self-hosted-video' || $metadata['pyre_type'][0] == 'youtube' || $metadata['pyre_type'][0] == 'vimeo' ) {
										$video = true;
									}
								}

								if( isset ( $metadata['pyre_type'][0] ) &&  $metadata['pyre_type'][0] == 'self-hosted-video' ) {
									$background_class = 'self-hosted-video-bg';
								}

								$heading_font_size = 'font-size:60px;line-height:80px;';
								if( isset ( $metadata['pyre_heading_font_size'][0] ) && $metadata['pyre_heading_font_size'][0] ) {
									$line_height = $metadata['pyre_heading_font_size'][0] * 1.2;
									$heading_font_size = 'font-size:' . $metadata['pyre_heading_font_size'][0] . 'px;line-height:' . $line_height . 'px;';
								}

								$caption_font_size = 'font-size: 24px;line-height:38px;';
								if( isset ( $metadata['pyre_caption_font_size'][0] ) && $metadata['pyre_caption_font_size'][0] ) {
									$line_height = $metadata['pyre_caption_font_size'][0] * 1.2;
									$caption_font_size = 'font-size:' . $metadata['pyre_caption_font_size'][0] . 'px;line-height:' . $line_height . 'px;';
								}
							?>
							<li data-mute="<?php echo $data_mute; ?>" data-loop="<?php echo $data_loop; ?>" data-autoplay="<?php echo $data_autoplay; ?>">
								<div class="slide-content-container slide-content-<?php if ( isset( $metadata['pyre_content_alignment'][0] ) && $metadata['pyre_content_alignment'][0] ) { echo $metadata['pyre_content_alignment'][0]; } ?>" style="display: none;">
									<div class="slide-content" style="<?php echo $content_max_width; ?>">
										<?php if( isset ( $metadata['pyre_heading'][0] ) && $metadata['pyre_heading'][0] ): ?>
										<div class="heading <?php if($heading_bg): echo 'with-bg'; endif; ?>"><h2 style="<?php echo $heading_bg; ?><?php echo $heading_color; ?><?php echo $heading_font_size; ?>"><?php echo do_shortcode( $metadata['pyre_heading'][0] ); ?></h2></div>
										<?php endif; ?>
										<?php if( isset ( $metadata['pyre_caption'][0] ) && $metadata['pyre_caption'][0] ): ?>
										<div class="caption <?php if($caption_bg): echo 'with-bg'; endif; ?>"><h3 style="<?php echo $caption_bg; ?><?php echo $caption_color; ?><?php echo $caption_font_size; ?>"><?php echo do_shortcode( $metadata['pyre_caption'][0] ); ?></h3></div>
										<?php endif; ?>
										<?php if( isset ( $metadata['pyre_link_type'][0] ) && $metadata['pyre_link_type'][0] == 'button' ): ?>
										<div class="buttons" >
											<?php
											if( isset ( $metadata['pyre_button_1'][0] ) && $metadata['pyre_button_1'][0] ) {
												echo '<div class="tfs-button-1">' . do_shortcode( $metadata['pyre_button_1'][0] ) . '</div>';
											}
											if( isset ( $metadata['pyre_button_2'][0] ) && $metadata['pyre_button_2'][0] ) {
												echo '<div class="tfs-button-2">' . do_shortcode( $metadata['pyre_button_2'][0] ) . '</div>';
											}
											?>
										</div>
										<?php endif; ?>
									</div>
								</div>
								<?php if( isset( $metadata['pyre_link_type'][0] ) && $metadata['pyre_link_type'][0] == 'full' && isset( $metadata['pyre_slide_link'][0] ) && $metadata['pyre_slide_link'][0] ): ?>
								<a href="<?php echo $metadata['pyre_slide_link'][0]; ?>" class="overlay-link" <?php echo ( isset( $metadata['pyre_slide_target'][0] ) && $metadata['pyre_slide_target'][0] == 'yes' ) ? 'target="_blank"' : ''; ?>></a>
								<?php endif; ?>
								<?php if( isset ( $metadata['pyre_preview_image'][0] ) && $metadata['pyre_preview_image'][0] && isset( $metadata['pyre_type'][0] ) && $metadata['pyre_type'][0] == 'self-hosted-video' ): ?>
								<div class="mobile_video_image" style="background-image: url(<?php echo $metadata['pyre_preview_image'][0]; ?>);"></div>
								<?php elseif( isset( $metadata['pyre_type'][0] ) && $metadata['pyre_type'][0] == 'self-hosted-video' ): ?>
								<div class="mobile_video_image" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/video_preview.jpg);"></div>
								<?php endif; ?>
								<?php if( $video_bg_color && $video == true ): ?>
								<div class="overlay" style="<?php echo $video_bg_color; ?>"></div>
								<?php endif; ?>
								<div class="background <?php echo $background_class; ?>" style="<?php echo $background_image; ?>max-width:<?php echo $slider_settings['slider_width']; ?>;height:<?php echo $slider_settings['slider_height']; ?>;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $image_url[0]; ?>', sizingMethod='scale');-ms-filter:'progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $image_url[0]; ?>', sizingMethod='scale')';" data-imgwidth="<?php echo $img_width; ?>">
									<?php if( isset( $metadata['pyre_type'][0] ) ): if( $metadata['pyre_type'][0] == 'self-hosted-video' && ( $metadata['pyre_webm'][0] || $metadata['pyre_mp4'][0] || $metadata['pyre_ogg'][0] ) ): ?>
									<video width="1800" height="700" <?php echo $video_attributes; ?> preload="auto">
										<?php if( array_key_exists( 'pyre_mp4', $metadata ) && $metadata['pyre_mp4'][0] ): ?>
										<source src="<?php echo $metadata['pyre_mp4'][0]; ?>" type="video/mp4">
										<?php endif; ?>
										<?php if( array_key_exists( 'pyre_ogg', $metadata ) && $metadata['pyre_ogg'][0] ): ?>
										<source src="<?php echo $metadata['pyre_ogg'][0]; ?>" type="video/ogg">
										<?php endif; ?>
										<?php if( array_key_exists( 'pyre_webm', $metadata ) && $metadata['pyre_webm'][0] ): ?>
										<source src="<?php echo $metadata['pyre_webm'][0]; ?>" type="video/webm">
										<?php endif; ?>
									</video>
									<?php endif; endif; ?>
									<?php if( isset( $metadata['pyre_type'][0] ) && isset( $metadata['pyre_youtube_id'][0] ) && $metadata['pyre_type'][0] == 'youtube' && $metadata['pyre_youtube_id'][0] ): ?>
									<div style="position: absolute; top: 0; left: 0; <?php echo $video_zindex; ?> width: 100%; height: 100%">
										<iframe frameborder="0" height="100%" width="100%" src="http<?php echo (is_ssl())? 's' : ''; ?>://www.youtube.com/embed/<?php echo $metadata['pyre_youtube_id'][0]; ?>?wmode=transparent&amp;modestbranding=1&amp;showinfo=0&amp;autohide=1&amp;enablejsapi=1&amp;rel=0<?php echo $youtube_attributes; ?>"></iframe>
									</div>
									<?php endif; ?>
									 <?php if( isset( $metadata['pyre_type'][0] ) && isset( $metadata['pyre_vimeo_id'][0] ) &&  $metadata['pyre_type'][0] == 'vimeo' && $metadata['pyre_vimeo_id'][0] ): ?>
									 <div style="position: absolute; top: 0; left: 0; <?php echo $video_zindex; ?> width: 100%; height: 100%">
										<iframe src="http<?php echo (is_ssl())? 's' : ''; ?>://player.vimeo.com/video/<?php echo $metadata['pyre_vimeo_id'][0]; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;badge=0&amp;title=0<?php echo $vimeo_attributes; ?>" height="100%" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
									</div>
									<?php endif; ?>
								</div>
							</li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			<?php
			}

			wp_reset_query();
		}
	}
}

if( ! function_exists( 'avada_get_page_title_bar_contents' ) ) {
	function avada_get_page_title_bar_contents( $post_id, $get_secondary_content = TRUE ) {
		global $smof_data;

		if ( $get_secondary_content ) {
			ob_start();
			if ( fusion_get_option( 'page_title_bar_bs', 'page_title_breadcrumbs_search_bar', $post_id ) != 'none' ) {
				if ( ( $smof_data['page_title_bar_bs'] == 'Breadcrumbs' && get_post_meta($post_id, 'pyre_page_title_breadcrumbs_search_bar', true) == 'breadcrumbs' ) ||
					( $smof_data['page_title_bar_bs'] != 'Breadcrumbs' && get_post_meta($post_id, 'pyre_page_title_breadcrumbs_search_bar', true) == 'breadcrumbs' ) ||
					( $smof_data['page_title_bar_bs'] == 'Breadcrumbs' && ( get_post_meta($post_id, 'pyre_page_title_breadcrumbs_search_bar', true) == 'default' || get_post_meta($post_id, 'pyre_page_title_breadcrumbs_search_bar', true) == '' ) ) ) {

					fusion_breadcrumbs();

				} else if( ( $smof_data['page_title_bar_bs'] == 'Search Box' && get_post_meta($post_id, 'pyre_page_title_breadcrumbs_search_bar', true) == 'searchbar' ) ||
					( $smof_data['page_title_bar_bs'] != 'Search Box' && get_post_meta($post_id, 'pyre_page_title_breadcrumbs_search_bar', true) == 'searchbar' ) ||
					( $smof_data['page_title_bar_bs'] == 'Search Box' && ( get_post_meta($post_id, 'pyre_page_title_breadcrumbs_search_bar', true) == 'default' || get_post_meta($post_id, 'pyre_page_title_breadcrumbs_search_bar', true) == '' ) ) ) {
					get_search_form();
				}
			}
			$secondary_content = ob_get_contents();
			ob_get_clean();
		} else {
			$secondary_content = '';
		}

		$title = '';
		$subtitle = '';

		if( get_post_meta( $post_id, 'pyre_page_title_custom_text', true ) != '' ) {
			$title = get_post_meta( $post_id, 'pyre_page_title_custom_text', true );
		}

		if( get_post_meta( $post_id, 'pyre_page_title_custom_subheader', true ) != '' ) {
			$subtitle = get_post_meta( $post_id, 'pyre_page_title_custom_subheader', true );
		}

		if( get_post_meta( $post_id, 'pyre_page_title_text', true ) == '' || get_post_meta( $post_id, 'pyre_page_title_text', true ) == 'default' ) {
			$page_title_text = $smof_data['page_title_bar_text'];
		} else {
			$page_title_text = get_post_meta( $post_id, 'pyre_page_title_text', true );
		}

		if( ! $title ) {
			$title = get_the_title();

			if( is_home() ) {
				$title = $smof_data['blog_title'];
			}

			if( is_search() ) {
				$title = __( 'Search results for:', 'Avada' ) . ' ' . get_search_query();
			}

			if( is_404() ) {
				$title = __('Error 404 Page', 'Avada');
			}

			if( ( class_exists( 'TribeEvents' ) && tribe_is_event() && ! is_single() && ! is_home() ) ||
				( class_exists( 'TribeEvents' ) && is_events_archive() ) ||
				( class_exists( 'TribeEvents' ) && is_events_archive() && is_404() )
			) { 
				$title = tribe_get_events_title();
				
			}

			if( is_archive() && 
				! is_bbpress() &&
				! is_search()
			) {
				if ( is_day() ) {
					$title = __( 'Daily Archives:', 'Avada' ) . '<span> ' . get_the_date() . '</span>';
				} else if ( is_month() ) {
					$title = __( 'Monthly Archives:', 'Avada' ) . '<span> ' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Avada' ) ) . '</span>';
				} elseif ( is_year() ) {
					$title = __( 'Yearly Archives:', 'Avada' ) . '<span> ' . get_the_date( _x( 'Y', 'yearly archives date format', 'Avada' ) ) . '</span>';
				} elseif ( is_author() ) {
					$curauth = get_user_by( 'id', get_query_var( 'author' ) );
					$title = $curauth->nickname;
				} elseif( is_post_type_archive() ) {				
					$title = post_type_archive_title( '', false );
					
					$sermon_settings = get_option('wpfc_options');
					if( is_array( $sermon_settings ) ) {
						$title = $sermon_settings['archive_title'];
					}				
				} else {
					$title = single_cat_title( '', false );
				}
			}

			if( class_exists( 'Woocommerce' ) && is_woocommerce() && ( is_product() || is_shop() ) && ! is_search() ) {
				if( ! is_product() ) {
					$title = woocommerce_page_title( false );
				}
			}
		}

		if ( ! $subtitle ) {
			if( is_home() ) {
				$subtitle = $smof_data['blog_subtitle'];
			}
		}
		
		if( ! is_archive() && ! is_search() && ! ( is_home() && ! is_front_page() ) ) {
			if ( get_post_meta( $post_id, 'pyre_page_title', true ) == 'yes' ||
				get_post_meta( $post_id, 'pyre_page_title', true ) == 'yes_without_bar' ||
				( $smof_data['page_title_bar'] != 'hide' && get_post_meta( $post_id, 'pyre_page_title', true ) != 'no' )
			) {		

				if( $page_title_text == 'no' ) {
					$title = '';
					$subtitle = '';
				}
			}
		} else {
			if( $smof_data['page_title_bar'] != 'hide' ) {
				if( $page_title_text == 'no' ) {
					$title = '';
					$subtitle = '';
				}				
			}
		}

		return array( $title, $subtitle, $secondary_content );
	}
}

if ( ! function_exists( 'avada_current_page_title_bar' ) ) {
	function avada_current_page_title_bar( $post_id  ) {
		global $smof_data;
		$page_title_bar_contents = avada_get_page_title_bar_contents( $post_id );	

		if( ! is_archive() && ! is_search() && ! ( is_home() && ! is_front_page() ) ) {
			if ( get_post_meta( $post_id, 'pyre_page_title', true ) == 'yes' ||
				get_post_meta( $post_id, 'pyre_page_title', true ) == 'yes_without_bar' ||
				( $smof_data['page_title_bar'] != 'hide' && get_post_meta( $post_id, 'pyre_page_title', true ) != 'no' )
			) {
				if( is_home() && is_front_page() && ! $smof_data['blog_show_page_title_bar'] ) {
					// do nothing
				} else {
					avada_page_title_bar( $page_title_bar_contents[0], $page_title_bar_contents[1], $page_title_bar_contents[2] );
				}
			}
		} else {

			if( is_home() && ! $smof_data['blog_show_page_title_bar'] ) {
				// do nothing
			} else {

				if( $smof_data['page_title_bar'] != 'hide' ) {
					avada_page_title_bar( $page_title_bar_contents[0], $page_title_bar_contents[1], $page_title_bar_contents[2] );
				}
			}
		}	
	}
}

if( ! function_exists( 'avada_backend_check_new_bbpress_post' ) ) {
	function avada_backend_check_new_bbpress_post() {
		global $pagenow, $post_type;
		
		if( in_array( $pagenow, array( 'post-new.php' ) ) &&
			$post_type == 'forum' || $post_type == 'topic' | $post_type == 'reply'
		) {
			return true;
		}
		
		return false;
	}
}

if( ! function_exists( 'avada_get_portfolio_image_size' ) ) {
	function avada_get_portfolio_image_size( $current_page_id ) {
		global $smof_data;
		
		if( is_page_template( 'portfolio-one-column-text.php' ) ) {
			$custom_image_size = 'portfolio-full';
		} else if( is_page_template( 'portfolio-one-column.php' ) ) {
			$custom_image_size = 'portfolio-one';
		} else if( is_page_template( 'portfolio-two-column.php' ) ||
				   is_page_template( 'portfolio-two-column-text.php' ) 
		) {
			$custom_image_size = 'portfolio-two';
		} else if( is_page_template( 'portfolio-three-column.php' ) || 
				   is_page_template( 'portfolio-three-column-text.php' ) 
		) {
			$custom_image_size = 'portfolio-three';
		} else if( is_page_template( 'portfolio-four-column.php' ) || 
				   is_page_template( 'portfolio-four-column-text.php' ) 
		) {
			$custom_image_size = 'portfolio-four';
		} else if( is_page_template( 'portfolio-five-column.php' ) || 
				   is_page_template( 'portfolio-five-column-text.php' ) 
		) {
			$custom_image_size = 'portfolio-five';
		} else if( is_page_template( 'portfolio-six-column.php' ) || 
				   is_page_template( 'portfolio-six-column-text.php' ) 
		) {
			$custom_image_size = 'portfolio-six';
		} else {
			$custom_image_size = 'full';
		}
		
		if( get_post_meta($current_page_id, 'pyre_portfolio_featured_image_size', true) == 'default' || 
			! get_post_meta($current_page_id, 'pyre_portfolio_featured_image_size', true)
		) {
			if( $smof_data['portfolio_featured_image_size'] == 'full' ) {
				$featured_image_size = 'full';
			} else {
				$featured_image_size = $custom_image_size;
			}
		} else if( get_post_meta($current_page_id, 'pyre_portfolio_featured_image_size', true) == 'full' ) {
			$featured_image_size = 'full';
		} else {
			$featured_image_size = $custom_image_size;
		}
		
		if( is_page_template( 'portfolio-grid.php' ) ) {
			$featured_image_size = 'full';
		}
		
		return $featured_image_size;
	}
}

if( ! function_exists( 'avada_featured_images_for_pages' ) ) {
	function avada_featured_images_for_pages() {
		if( ! post_password_required( get_the_ID() ) ) {
			global $smof_data; 
			
			$html = $video = $featured_images = '';
			
			if( ! $smof_data['featured_images_pages'] ) {
				if( avada_number_of_featured_images() > 0 || get_post_meta( get_the_ID(), 'pyre_video', true ) ) {
					if( get_post_meta( get_the_ID(), 'pyre_video', true ) ) {
						$video = sprintf( '<li><div class="full-video">%s</div></li>', get_post_meta( get_the_ID(), 'pyre_video', true ) );
					}

					if( has_post_thumbnail() && get_post_meta( get_the_ID(), 'pyre_show_first_featured_image', true ) != 'yes' ) {
						$attachment_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$full_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
						$attachment_data = wp_get_attachment_metadata (get_post_thumbnail_id() );

						$featured_images .= sprintf( '<li><a href="%s" rel="prettyPhoto[gallery%s]" data-title="%s" data-caption="%s"><img src="%s" alt="%s" /></a></li>', $full_image[0], get_the_ID(), 
													 get_post_field( 'post_title', get_post_thumbnail_id() ), get_post_field( 'post_excerpt', get_post_thumbnail_id() ) , $attachment_image[0], get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) );
					}

					$i = 2;
					while( $i <= $smof_data['posts_slideshow_number'] ):
						$attachment_new_id = kd_mfi_get_featured_image_id( 'featured-image-'.$i, 'page' );

						if( $attachment_new_id ) {

							$attachment_image = wp_get_attachment_image_src($attachment_new_id, 'full');
							$full_image = wp_get_attachment_image_src($attachment_new_id, 'full');
							$attachment_data = wp_get_attachment_metadata($attachment_new_id);

							$featured_images .= sprintf( '<li><a href="%s" rel="prettyPhoto[gallery%s]" data-title="%s" data-caption="%s"><img src="%s" alt="%s" /></a></li>', $full_image[0], get_the_ID(), 
														 get_post_field( 'post_title', $attachment_new_id ), get_post_field( 'post_excerpt', $attachment_new_id ), $attachment_image[0], get_post_meta( $attachment_new_id, '_wp_attachment_image_alt', true ) );
						}
						$i++; 
					endwhile;

					
					$html .= sprintf( '<div class="fusion-flexslider flexslider post-slideshow"><ul class="slides">%s%s</ul></div>', $video, $featured_images );
				}
			}
		}
		
		return $html;
	}
}
if( ! function_exists( 'avada_featured_images_lightbox' ) ) {
	function avada_featured_images_lightbox( $post_id ) {
		global $smof_data; 
		$html = $video = $featured_images = '';

		if( get_post_meta( $post_id, 'pyre_video_url', true ) ) {
			$video = sprintf( '<a href="%s" class="iLightbox[gallery%s]"></a>', get_post_meta( $post_id, 'pyre_video_url', true ), $post_id );
		}
		
		$i = 2;
		
		while( $i <= $smof_data['posts_slideshow_number'] ):
			$attachment_new_id = kd_mfi_get_featured_image_id( 'featured-image-'.$i, get_post_type( $post_id ) );
			if( $attachment_new_id ) {
				$attachment_image = wp_get_attachment_image_src($attachment_new_id, 'full');
				$full_image = wp_get_attachment_image_src($attachment_new_id, 'full');
				$attachment_data = wp_get_attachment_metadata($attachment_new_id);
				$featured_images .= sprintf( '<a href="%s" rel="iLightbox[gallery%s]" title="%s"></a>', $full_image[0],
				 $post_id, get_post_field( 'post_excerpt', $attachment_new_id ), $attachment_image[0], get_post_meta( $attachment_new_id, 
				 '_wp_attachment_image_alt', true ) );
			}
			$i++; 
		endwhile;
		$html .= sprintf( '<div class="fusion-portfolio-gallery-hidden">%s%s</div>', $video, $featured_images );

		return $html;
	}
		
}
if( ! function_exists( 'avada_display_sidenav' ) ) {
	function avada_display_sidenav( $post_id ) {
	
		$html = '<ul class="side-nav">';

		$post_ancestors = get_ancestors( $post_id, 'page' );
		$post_parent = end( $post_ancestors );
	
		$html .= '<li';
		if( is_page( $post_parent ) ) {
			$html .= ' class="current_page_item"';
		}

		if( $post_parent ) {
			$html .= sprintf( '><a href="%s" title="%s">%s</a></li>', get_permalink( $post_parent ), __( 'Back to Parent Page', 'Avada' ), get_the_title( $post_parent ) );
		} else {
			$html .= sprintf( '><a href="%s" title="%s">%s</a></li>', get_permalink( $post_id ), __( 'Back to Parent Page', 'Avada' ), get_the_title( $post_id ) );
		}

		if( $post_parent ) {
			$children = wp_list_pages( sprintf( 'title_li=&child_of=%s&echo=0', $post_parent ) );
		} else {
			$children = wp_list_pages( sprintf( 'title_li=&child_of=%s&echo=0', $post_id ) );
		}
		if ( $children ) {
			$html .= $children;
		}
		
		$html .= '</ul>';
		
		return $html;
	}
}

if( ! function_exists( 'avada_link_pages' ) ) {
	function avada_link_pages() {		
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Avada' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>'
		) ); 
	}
}

if( ! function_exists( 'avada_number_of_featured_images' ) ) {
	function avada_number_of_featured_images() {
		global $smof_data, $post;
		$number_of_images = 0;

		if( has_post_thumbnail() && get_post_meta( $post->ID, 'pyre_show_first_featured_image', true ) != 'yes' ) {
			$number_of_images++;
		}

		for( $i = 2; $i <= $smof_data['posts_slideshow_number']; $i++ ) {
			$attachment_new_id = kd_mfi_get_featured_image_id('featured-image-'.$i, $post->post_type );

			if( $attachment_new_id ) {
				$number_of_images++;
			}
		}

		return $number_of_images;
	}
}

if( ! class_exists( 'Avada_GoogleMap' ) ) {
	class Avada_GoogleMap {

		private $map_id;

		public static $args;

		/**
		 * Initiate the shortcode
		 */
		public function __construct() {

			add_filter( 'fusion_attr_avada-google-map-shortcode', array( $this, 'attr' ) );
			add_shortcode( 'avada_map', array( $this, 'render' ) );

		}

		/**
		 * Function to get the default shortcode param values applied.
		 *
		 * @param  array  $args  Array with user set param values
		 * @return array  $defaults  Array with default param values
		 */
		public static function set_shortcode_defaults( $defaults, $args ) {
			
			if( ! $args ) {
				$$args = array();
			}
		
			$args = shortcode_atts( $defaults, $args );	 
		
			foreach( $args as $key => $value ) {
				if( $value == '' ) {
					$args[$key] = $defaults[$key];
				}
			}

			return $args;
		
		}

		public static function calc_color_brightness( $color ) {
		
			if( strtolower( $color ) == 'black' ||
				strtolower( $color ) == 'navy' ||
				strtolower( $color ) == 'purple' ||
				strtolower( $color ) == 'maroon' ||
				strtolower( $color ) == 'indigo' ||
				strtolower( $color ) == 'darkslategray' ||
				strtolower( $color ) == 'darkslateblue' ||
				strtolower( $color ) == 'darkolivegreen' ||
				strtolower( $color ) == 'darkgreen' ||
				strtolower( $color ) == 'darkblue' 
			) {
				$brightness_level = 0;
			} elseif( strpos( $color, '#' ) === 0 ) {
				$color = fusion_hex2rgb( $color );

				$brightness_level = sqrt( pow( $color[0], 2) * 0.299 + pow( $color[1], 2) * 0.587 + pow( $color[2], 2) * 0.114 );		   
			} else {
				$brightness_level = 150;
			}

			return $brightness_level;
		}   

		/**
		 * Function to apply attributes to HTML tags.
		 * Devs can override attributes in a child theme by using the correct slug
		 *
		 *
		 * @param  string $slug	   Slug to refer to the HTML tag
		 * @param  array  $attributes Attributes for HTML tag
		 * @return [type]			 [description]
		 */
		public static function attributes( $slug, $attributes = array() ) {

			$out = '';
			$attr = apply_filters( "fusion_attr_{$slug}", $attributes );

			if ( empty( $attr ) ) {
				$attr['class'] = $slug;
			}

			foreach ( $attr as $name => $value ) {
				$out .= !empty( $value ) ? sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) ) : esc_html( " {$name}" );
			}

			return trim( $out );

		} // end attr()

		/**
		 * Render the shortcode
		 * @param  array $args	 Shortcode paramters
		 * @param  string $content Content between shortcode
		 * @return string		  HTML output
		 */
		function render( $args, $content = '' ) {
			global $smof_data;

			$defaults = $this->set_shortcode_defaults(
				array(
					'class'					 => '',
					'id'						=> '',
					'animation'				 => 'no',
					'address'				   => '',
					'address_pin'			   => 'yes',
					'height'					=> '300px',			 
					'icon'					  => '',
					'infobox'				   => '',
					'infobox_background_color'  => '',
					'infobox_content'		   => '',
					'infobox_text_color'		=> '',
					'map_style'				 => '',
					'overlay_color'			 => '',
					'popup'					 => 'yes',
					'scale'					 => 'yes',			   
					'scrollwheel'			   => 'yes',			   
					'type'					  => 'roadmap',
					'width'					 => '100%',
					'zoom'					  => '14',
					'zoom_pancontrol'		   => 'yes',
				), $args
			);

			extract( $defaults );

			self::$args = $defaults;

			$html = '';

			if( $address ) {
				$addresses = explode( '|', $address );

				$infobox_content = addslashes( html_entity_decode( $infobox_content ) );

				if( $infobox_content ) {
					$infobox_content_array = explode( '|', $infobox_content );
				} else {
					$infobox_content_array = '';
				}

				if( $icon ) {
					$icon_array = explode( '|', $icon );
				} else {
					$icon_array = '';
				}	   

				if( $addresses ) {
					self::$args['address'] = $addresses;
				}
				
				$num_of_addresses = count( $addresses );
				
				if( $icon &&
					strpos( $icon, '|' ) === false ) {
					for( $i = 0; $i < $num_of_addresses; $i++ ) {
						$icon_array[$i] = $icon;				
					}
				}
			
				if( $map_style == 'theme' ) {
					$map_style = 'custom';
					$icon = 'theme';
					$animation = 'yes';
					$infobox = 'custom';
					$infobox_background_color = fusion_hex2rgb( $smof_data['primary_color'] );
					$infobox_background_color = 'rgba(' . $infobox_background_color[0] . ', ' . $infobox_background_color[1] . ', ' . $infobox_background_color[2] . ', 0.8)';
					$overlay_color = $smof_data['primary_color'];
					$brightness_level = $this->calc_color_brightness( $smof_data['primary_color'] );

					if( $brightness_level > 140 ) {
						$infobox_text_color = '#fff';
					} else {
						$infobox_text_color = '#747474';
					}			   
				}
				
				if( $icon == 'theme' && $map_style == 'custom' ) {
					for( $i = 0; $i < $num_of_addresses; $i++ ) {
						$icon_array[$i] = get_template_directory_uri() . '/assets/images/avada_map_marker.png';				
					}
				}		   

				wp_print_scripts( 'google-maps-api' );
				wp_print_scripts( 'google-maps-infobox' );

				foreach( self::$args['address'] as $add ) {
					$add = trim( $add );
					$add_arr = explode( "\n", $add );
					$add_arr = array_filter( $add_arr, 'trim' );
					$add = implode( '<br/>', $add_arr );
					$add = str_replace( "\r", '', $add );
					$add = str_replace( "\n", '', $add );

					$coordinates[]['address'] = $add;
				}

				if( ! is_array( $coordinates ) ) {
					return;
				}
				
				for( $i = 0; $i < $num_of_addresses; $i++ ) {
					if( strpos( self::$args['address'][$i], 'latlng=' ) === 0 ) {
						self::$args['address'][$i] = $coordinates[$i]['address'];
					}
				}
				
				if( is_array( $infobox_content_array ) && 
					! empty( $infobox_content_array ) 
				) {
					for( $i = 0; $i < $num_of_addresses; $i++ ) {
						if( ! array_key_exists( $i, $infobox_content_array ) ) {
							$infobox_content_array[$i] = self::$args['address'][$i];
						}
					}
					self::$args['infobox_content'] = $infobox_content_array;
				} else {
					self::$args['infobox_content'] = self::$args['address'];
				}
				
				$cached_addresses = get_option( 'fusion_map_addresses' );

				foreach( self::$args['address'] as $key => $address ) {
					$json_addresses[] = array(
						'address' => $address,
						'infobox_content' => self::$args['infobox_content'][$key]
					);

					if( isset( $icon_array ) && is_array( $icon_array ) ) {
						$json_addresses[$key]['marker'] = $icon_array[$key];
					}

					if( strpos( $address, strtolower( 'latlng=' ) ) !== false ) {
						$json_addresses[$key]['address'] = str_replace( 'latlng=', '', $address );
						$latLng = explode(',', $json_addresses[$key]['address']);
						$json_addresses[$key]['coordinates'] = true;
						$json_addresses[$key]['latitude'] = $latLng[0];
						$json_addresses[$key]['longitude'] = $latLng[1];
						$json_addresses[$key]['cache'] = false;

						if( strpos( self::$args['infobox_content'][$key], strtolower( 'latlng=' ) ) !== false ) {
							$json_addresses[$key]['infobox_content'] = '';
						}

						if( isset( $cached_addresses[ trim( $json_addresses[$key]['latitude'] . ',' . $json_addresses[$key]['longitude'] ) ] ) ) {
							$json_addresses[$key]['geocoded_address'] = $cached_addresses[ trim( $json_addresses[$key]['latitude'] . ',' . $json_addresses[$key]['longitude'] ) ]['address'];
							$json_addresses[$key]['cache'] = true;
						}
					} else {
						$json_addresses[$key]['coordinates'] = false;
						$json_addresses[$key]['cache'] = false;

						if( isset( $cached_addresses[ trim( $json_addresses[$key]['address'] ) ] ) ) {
							$json_addresses[$key]['latitude'] = $cached_addresses[ trim( $json_addresses[$key]['address'] ) ]['latitude'];
							$json_addresses[$key]['longitude'] = $cached_addresses[ trim( $json_addresses[$key]['address'] ) ]['longitude'];
							$json_addresses[$key]['cache'] = true;					
						}
					}
				}

				$json_addresses = json_encode( $json_addresses );

				$map_id = uniqid( 'fusion_map_' ); // generate a unique ID for this map
				$this->map_id = $map_id;

				ob_start(); ?>
				<script type="text/javascript">
					var map_<?php echo $map_id; ?>;
					var markers = [];
					var counter = 0;
					function fusion_run_map_<?php echo $map_id ; ?>() {
						jQuery('#<?php echo $map_id ; ?>').fusion_maps({
							addresses: <?php echo $json_addresses; ?>,
							address_pin: <?php echo ($address_pin == 'yes') ? 'true' : 'false'; ?>,
							animations: <?php echo ($animation == 'yes') ? 'true' : 'false'; ?>,
							infobox_background_color: '<?php echo $infobox_background_color; ?>',
							infobox_styling: '<?php echo $infobox; ?>',
							infobox_text_color: '<?php echo $infobox_text_color; ?>',
							map_style: '<?php echo $map_style; ?>',
							map_type: '<?php echo $type; ?>',
							marker_icon: '<?php echo $icon; ?>',
							overlay_color: '<?php echo $overlay_color; ?>',
							overlay_color_hsl: <?php echo json_encode( fusion_rgb2hsl( $overlay_color ) ); ?>,
							pan_control: <?php echo ($zoom_pancontrol == 'yes') ? 'true' : 'false'; ?>,
							show_address: <?php echo ($popup == 'yes') ? 'true' : 'false'; ?>,
							scale_control: <?php echo ($scale == 'yes') ? 'true' : 'false'; ?>,
							scrollwheel: <?php echo ($scrollwheel == 'yes') ? 'true' : 'false'; ?>,
							zoom: <?php echo $zoom; ?>,
							zoom_control: <?php echo ($zoom_pancontrol == 'yes') ? 'true' : 'false'; ?>,
						});
					}

					google.maps.event.addDomListener(window, 'load', fusion_run_map_<?php echo $map_id ; ?>);
				</script>
				<?php
				if( $defaults['id'] ) {
					$html = ob_get_clean() . sprintf( '<div id="%s"><div %s></div></div>', $defaults['id'], $this->attributes( 'avada-google-map-shortcode' ) );
				} else {
					$html = ob_get_clean() . sprintf( '<div %s></div>', $this->attributes( 'avada-google-map-shortcode' ) );
				}

			}

			return $html;

		}

		function attr() {
		
			$attr['class'] = 'shortcode-map fusion-google-map avada-google-map';

			if( self::$args['class'] ) {
				$attr['class'] .= ' ' . self::$args['class'];
			}

			$attr['id'] = $this->map_id;
			
			$attr['style'] = sprintf('height:%s;width:%s;',  self::$args['height'], self::$args['width'] );

			return $attr;

		}

	}

	new Avada_GoogleMap();
}