			</div>  <!-- fusion-row -->
		</div>  <!-- #main -->
		
		<?php
		global $smof_data, $social_icons;
		
		if ( strpos( $smof_data['footer_special_effects'], 'footer_sticky' ) !== FALSE) {
			echo '</div>';
		}
		
		// Get the correct page ID
		$object_id = get_queried_object_id();
		if ( ( get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) && is_home() ) ||
			 ( get_option( 'page_for_posts' ) && is_archive() && ! is_post_type_archive() ) && ! ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) || 
			 ( get_option('page_for_posts' ) && is_search() )
		) {
			$c_pageID = get_option('page_for_posts');
		} else {
			if ( isset( $object_id ) ) {
				$c_pageID = $object_id;
			}

			if ( class_exists( 'Woocommerce' ) ) {
				if ( is_shop() || 
					 is_tax( 'product_cat' ) || 
					 is_tax( 'product_tag' ) 
				) {
					$c_pageID = get_option( 'woocommerce_shop_page_id' );
				}
			}
		}

		// Only include the footer
		if ( ! is_page_template( 'blank.php' ) ) {
		
			$footer_parallax_class = '';
			if ( $smof_data['footer_special_effects'] == 'footer_parallax_effect' ) {
				$footer_parallax_class = ' fusion-footer-parallax';
			}

			echo sprintf( '<div class="fusion-footer%s">', $footer_parallax_class );

				// Check if the footer widget area should be displayed
				if ( ( $smof_data['footer_widgets'] && get_post_meta( $c_pageID, 'pyre_display_footer', true ) != 'no' ) ||
					 ( ! $smof_data['footer_widgets'] && get_post_meta( $c_pageID, 'pyre_display_footer', true ) == 'yes' ) 
				) {
				?>
					<footer class="fusion-footer-widget-area">
						<div class="fusion-row">
							<div class="fusion-columns fusion-columns-<?php echo $smof_data['footer_widgets_columns']; ?> fusion-widget-area">

								<?php
								// Check the column width based on the amount of columns chosen in Theme Options
								$column_width = 12 / $smof_data['footer_widgets_columns']; 
								if( $smof_data['footer_widgets_columns'] == '5' ) {
									$column_width = 2;
								}

								// Render as many widget columns as have been chosen in Theme Options
								for ( $i = 1; $i < 7; $i++ ) {
									if ( $smof_data['footer_widgets_columns'] >= $i ) {
										echo sprintf( '<div class="fusion-column col-lg-%s col-md-%s col-sm-%s">', $column_width, $column_width, $column_width );

											if (  function_exists( 'dynamic_sidebar' ) && 
												 dynamic_sidebar( sprintf( 'Footer Widget %s', $i ) )
											) {
												// All is good, dynamic_sidebar() already called the rendering
											}
										echo '</div>';
									}
								}
								?>

								<div class="fusion-clearfix"></div>
							</div> <!-- fusion-columns -->
						</div> <!-- fusion-row -->
					</footer> <!-- fusion-footer-area -->
				<?php 
				} // end footer wigets check

				// Check if the footer copyright area should be displayed
				if ( ( $smof_data['footer_copyright'] && get_post_meta( $c_pageID, 'pyre_display_copyright', true ) != 'no' ) ||
					  ( ! $smof_data['footer_copyright'] && get_post_meta( $c_pageID, 'pyre_display_copyright', true ) == 'yes' ) 
				) {
				?>
					<footer id="footer" class="fusion-footer-copyright-area">
						<div class="fusion-row">
							<div class="fusion-copyright-content">

								<?php 
								/**
								 * avada_footer_copyright_content hook
								 *
								 * @hooked avada_render_footer_copyright_notice - 10 (outputs the HTML for the Theme Options footer copyright text)
								 * @hooked avada_render_footer_social_icons - 15 (outputs the HTML for the footer social icons)
								 */						
								do_action( 'avada_footer_copyright_content' ); 
								?>

							</div> <!-- fusion-fusion-copyright-area-content -->
						</div> <!-- fusion-row -->
					</footer> <!-- #footer -->
				</div> <!-- fusion-footer -->
			<?php
			} // end footer copyright area check
		} // end is not blank page check
		?>
		</div> <!-- wrapper -->

		<?php 
		// Check if boxed side header layout is used; if so close the #boxed-wrapper container
		if ( ( ( $smof_data['layout'] == 'Boxed' && get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'default' ) || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'boxed' ) && 
			 $smof_data['header_position'] != 'Top' 
		
		) { 
		?>
			</div> <!-- #boxed-wrapper -->
		<?php
		}

		?>

		<!-- W3TC-include-js-head -->

		<?php 
		wp_footer();

		// Echo the scripts added to the "before </body>" field in Theme Options
		echo $smof_data['space_body']; 
		?>

		<!--[if lte IE 8]>
			<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/respond.js"></script>
		<![endif]-->
	</body>
</html>