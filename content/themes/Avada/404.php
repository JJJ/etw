<?php get_header(); ?>
	<div id="content" class="full-width">
		<div id="post-404page">
			<div class="post-content">
				<?php 
				// Render the page titles
				$subtitle =  __( 'Oops, This Page Could Not Be Found!', 'Avada' );
				$subtitle_size = 2;

				echo do_shortcode( sprintf( '[title size="%s" content_align="left" style_type="default"]%s[/title]', $subtitle_size, $subtitle ) );
		
				echo '<div class="fusion-clearfix"></div>';
				echo '<div class="error-page">';
				
					// First column
					echo do_shortcode( '[one_third last="no" spacing="yes"]<div class="error-message">404</div>[/one_third]' );
					
					// Second column
					$second_column = sprintf( '<h3>%s</h3>', __( 'Here are some useful links:', 'Avada' ) );

					if ( $smof_data['checklist_circle'] ) {
						$circle_class = 'circle-yes';
					} else {
						$circle_class = 'circle-no';
					}
					$second_column .= wp_nav_menu( array( 'theme_location' => '404_pages', 'depth' => 1, 'container' => false, 'menu_id' => 'checklist-1', 'menu_class' => 'error-menu list-icon list-icon-arrow ' . $circle_class, 'echo' => 0 ) );
					
					echo do_shortcode( sprintf( '[one_third last="no" spacing="yes" class="useful-links"]%s[/one_third]', $second_column ) );
					
					// Third column
					
					$third_column = sprintf( '<h3>%s</h3>', __( 'Search Our Website', 'Avada' ) ); 
					$third_column .= sprintf( '<p>%s</p>', __( 'Can\'t find what you need? Take a moment and do a search below!', 'Avada' ) );
					$third_column .= '<div class="search-page-search-form">';
						$third_column .= sprintf( '<form class="searchform seach-form" role="search" method="get" action="%s">', home_url( '/' ) );
							$third_column .= '<div class="search-table">';
								$third_column .= '<div class="search-field">';
									$third_column .= sprintf( '<input type="text" value="" name="s" class="s" placeholder="%s" />', __( 'Search ...', 'Avada' ) );
								$third_column .= '</div>';
								$third_column .= '<div class="search-button">';
									$third_column .= '<input type="submit" class="searchsubmit" value="&#xf002;" />';
								$third_column .= '</div>';
							$third_column .= '</div>';
						$third_column .= '</form>';
					$third_column .= '</div>';
					
					echo do_shortcode( sprintf( '[one_third last="yes" spacing="yes"]%s[/one_third]', $third_column ) );
					?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>