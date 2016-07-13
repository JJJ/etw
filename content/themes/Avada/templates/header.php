<?php
if( ! function_exists( 'avada_header_template' ) ) {
	/**
	 * Avada Header Template Function
	 * @param  string $slider_position Show header below or above slider
	 * @return void
	 */
	function avada_header_template( $slider_position = 'Below' ) {
		$page_id = get_queried_object_id();

		if( $slider_position == 'Below' ) {
			$reverse_position = 'Above';
		} else {
			$reverse_position = 'Below';
		}

		$theme_option_slider_position = fusion_get_theme_option( 'slider_position' );
		$page_option_slider_position = fusion_get_page_option( 'slider_position', $page_id );

		if( ( ! $theme_option_slider_position ||
			( $theme_option_slider_position == $slider_position && $page_option_slider_position != strtolower( $reverse_position ) ) ||
			( $theme_option_slider_position != $slider_position && $page_option_slider_position == strtolower( $slider_position ) ) ) &&
			! is_page_template( 'blank.php' ) &&
			fusion_get_page_option( 'display_header', $page_id ) != 'no' &&
			fusion_get_theme_option( 'header_position' ) == 'Top'
		) {

			$header_wrapper_class = 'fusion-header-wrapper';

			if( fusion_get_theme_option( 'header_shadow' ) ) {
				$header_wrapper_class .= ' fusion-header-shadow';
			}

			$header_wrapper_class = sprintf( 'class="%s"', $header_wrapper_class );

			/**
			 * avada_before_header_wrapper hook
			 */						
			do_action( 'avada_before_header_wrapper' );

			if( fusion_get_theme_option( 'sticky_header_logo' ) ) {
				$sticky_header_logo = true;
			} else {
				$sticky_header_logo = false;
			}

			if( fusion_get_theme_option( 'mobile_logo' ) ) {
				$mobile_logo = true;
			} else {
				$mobile_logo = false;
			}
			
			$sticky_header_type2_layout = '';
			if ( fusion_get_theme_option('header_layout') == 'v4' || 
				 fusion_get_theme_option('header_layout') == 'v5' 
			) {
				if ( fusion_get_theme_option( 'header_sticky_type2_layout' ) == 'menu_and_logo' ) {
					$sticky_header_type2_layout = ' fusion-sticky-menu-and-logo';
				} else {
					$sticky_header_type2_layout = ' fusion-sticky-menu-only';
				}
			}
		?>
			<div <?php echo $header_wrapper_class; ?>>
				<div class="<?php echo sprintf( 'fusion-header-%s fusion-logo-%s fusion-sticky-menu-%s fusion-sticky-logo-%s fusion-mobile-logo-%s fusion-mobile-menu-design-%s%s', fusion_get_theme_option( 'header_layout' ), strtolower( fusion_get_theme_option( 'logo_alignment' ) ), has_nav_menu( 'sticky_navigation' ), $sticky_header_logo, $mobile_logo, strtolower( fusion_get_theme_option( 'mobile_menu_design' ) ), $sticky_header_type2_layout ); ?>">
					<?php
					/**
					 * avada_header hook
					 * @hooked avada_secondary_header - 10
					 * @hooked avada_header_1 - 20 (adds header content for header v1-v3)
					 * @hooked avada_header_2 - 20 (adds header content for header v4-v5)
					 */						
					do_action( 'avada_header' );
					?>
				</div>
			</div>
		<?php
			/**
			 * avada_after_header_wrapper hook
			 */						
			do_action( 'avada_after_header_wrapper' );
		}
	}
}

if( ! function_exists( 'avada_side_header' ) ) {
	/**
	 * Avada Side Header Template Function
	 * @return void
	 */
	function avada_side_header() {		
		$queried_object_id = get_queried_object_id();

		if( ! is_page_template( 'blank.php' ) && get_post_meta( $queried_object_id, 'pyre_display_header', true) != 'no' ) {
			/**
			 * avada_before_header_wrapper hook
			 */						
			do_action( 'avada_before_header_wrapper' );

			if( fusion_get_theme_option( 'sticky_header_logo' ) ) {
				$sticky_header_logo = true;
			} else {
				$sticky_header_logo = false;
			}

			if( fusion_get_theme_option( 'mobile_logo' ) ) {
				$mobile_logo = true;
			} else {
				$mobile_logo = false;
			}
		?>
		<div id="side-header-sticky"></div>
		<div id="side-header" class="<?php echo sprintf( 'clearfix fusion-mobile-menu-design-%s fusion-sticky-logo-%s fusion-mobile-logo-%s fusion-sticky-menu-%s',  strtolower( fusion_get_theme_option( 'mobile_menu_design' ) ), $sticky_header_logo, $mobile_logo, has_nav_menu( 'sticky_navigation' ) ); ?><?php if( fusion_get_theme_option( 'header_shadow' ) ): ?> header-shadow<?php endif; ?>">
			<div class="side-header-wrapper">
				<?php
				/**
				 * avada_header_inner_before
				 */						
				do_action( 'avada_header_inner_before' );
				if( fusion_get_theme_option( 'mobile_logo' ) ) {
					$mobile_logo = true;
				} else {
					$mobile_logo = false;
				}
				?>
				<div class="side-header-content <?php echo sprintf( 'fusion-logo-%s fusion-mobile-logo-%s', strtolower( fusion_get_theme_option( 'logo_alignment' ) ), $mobile_logo ); ?>">
					<?php avada_logo(); ?>
				</div>
				<div class="fusion-main-menu-container <?php echo sprintf( 'fusion-logo-menu-%s', strtolower( fusion_get_theme_option( 'logo_alignment' ) ) ); ?>">
					
					<?php avada_main_menu(); ?>
				</div>
				<?php
				if( fusion_get_theme_option( 'header_left_content' ) != 'Leave Empty' || fusion_get_theme_option( 'header_right_content' ) != 'Leave Empty' ):
					$content_1 = avada_secondary_header_content( 'header_left_content' );
					$content_2 = avada_secondary_header_content( 'header_right_content' );
				?>
				<div class="side-header-content side-header-content-1-2">
					<?php
					if( $content_1 ): ?>
						<div class="side-header-content-1"><?php echo $content_1; ?></div>
					<?php endif; ?>
					<?php if( $content_2 ): ?>
						<div class="side-header-content-2"><?php echo $content_2; ?></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<?php if( fusion_get_theme_option( 'header_v4_content' ) != 'None' ): ?>
				<div class="side-header-content side-header-content-3">
					<?php avada_header_content_3(); ?>
				</div>
				<?php endif;

				/**
				 * avada_header_inner_after
				 */						
				do_action( 'avada_header_inner_after' );
				?>
			</div>
		</div>
		<?php
			/**
			 * avada_after_header_wrapper hook
			 */						
			do_action( 'avada_after_header_wrapper' );
		}
	}
}

if( fusion_get_theme_option('header_layout') == 'v2' || fusion_get_theme_option('header_layout') == 'v3' ||
	fusion_get_theme_option('header_layout') == 'v4' || fusion_get_theme_option('header_layout') == 'v5' ) {
	add_action( 'avada_header', 'avada_secondary_header', 10 );
}
function avada_secondary_header() {
	if( fusion_get_theme_option( 'header_left_content' ) != 'Leave Empty' || fusion_get_theme_option( 'header_right_content' ) != 'Leave Empty' ):
		$content_1 = avada_secondary_header_content( 'header_left_content' );
		$content_2 = avada_secondary_header_content( 'header_right_content' );
?>
<div class="fusion-secondary-header">
	<div class="fusion-row">
		<?php if( $content_1 ): ?>
			<div class="fusion-alignleft"><?php echo $content_1; ?></div>
		<?php endif; ?>
		<?php if( $content_2 ): ?>
			<div class="fusion-alignright"><?php echo $content_2; ?></div>
		<?php endif; ?>
	</div>
</div>
<?php
	endif;
}

if( fusion_get_theme_option('header_layout') == 'v1' || fusion_get_theme_option('header_layout') == 'v2' ||
	fusion_get_theme_option('header_layout') == 'v3' ) {
	add_action( 'avada_header', 'avada_header_1', 20 );
}
function avada_header_1() { ?>
<div class="fusion-header-sticky-height"></div>
<div class="fusion-header">
	<div class="fusion-row">
		<?php
		avada_logo();
		avada_main_menu();
		?>
	</div>
</div>
<?php }

if( fusion_get_theme_option('header_layout') == 'v4' || fusion_get_theme_option('header_layout') == 'v5'  ) {
	add_action( 'avada_header', 'avada_header_2', 20 );
	add_action( 'avada_header', 'avada_secondary_main_menu', 30 );
}
function avada_header_2() { ?>
<div class="fusion-header-sticky-height"></div>
<div class="fusion-sticky-header-wrapper"> <!-- start fusion sticky header wrapper -->
	<div class="fusion-header">
		<div class="fusion-row">
			<?php
			avada_logo();
			echo avada_modern_menu();
			?>
		</div>
	</div>
<?php }

function avada_secondary_main_menu() { ?>
	<div class="fusion-secondary-main-menu">
		<div class="fusion-row">
			<?php
			avada_main_menu();

			if( fusion_get_theme_option('header_layout') == 'v4' ) {
				$header_content_3 = fusion_get_theme_option( 'header_v4_content' );
				if( $header_content_3 == 'Tagline And Search' ) {
					echo sprintf( '<div class="fusion-secondary-menu-search">%s</div>', get_search_form( false ) );
				} elseif( $header_content_3 == 'Search' ) {
					echo sprintf( '<div class="fusion-secondary-menu-search">%s</div>', get_search_form( false ) );
				}
			}
			?>
		</div>
	</div>
</div> <!-- end fusion sticky header wrapper -->
<?php }

if( ! function_exists( 'avada_logo' ) ) {
	function avada_logo() { ?>
		<div class="fusion-logo" data-margin-top="<?php echo fusion_get_theme_option( 'margin_logo_top' ); ?>" data-margin-bottom="<?php echo fusion_get_theme_option( 'margin_logo_bottom' ); ?>" data-margin-left="<?php echo fusion_get_theme_option( 'margin_logo_left' ); ?>" data-margin-right="<?php echo fusion_get_theme_option( 'margin_logo_right' ); ?>">
			<?php
			/**
			 * avada_logo_prepend hook
			 */
			do_action( 'avada_logo_prepend' );
			?>
			<a href="<?php echo home_url(); ?>">
				<?php
				$logo_url = fusion_get_theme_option( 'logo' );
				
				if ( fusion_get_theme_option( 'retina_logo_width' ) && fusion_get_theme_option( 'retina_logo_height' ) ) {
					$logo_size['width'] = fusion_get_theme_option( 'retina_logo_width' );
					$logo_size['height'] = fusion_get_theme_option( 'retina_logo_height' );
				} else {
					$logo_size['width'] = '';
					$logo_size['height'] = '';
				}
				?>			
				<img src="<?php echo fusion_get_theme_option( 'logo' ); ?>" width="<?php echo $logo_size['width']; ?>" height="<?php echo $logo_size['height']; ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-1x fusion-standard-logo" />
				<?php
				$retina_logo = fusion_get_theme_option( 'logo_retina' );
				if( $retina_logo ):
				$style = sprintf( 'style="width:%1$s%3$s; max-height: %2$s%3$s; height: auto;"', $logo_size['width'], $logo_size['height'], 'px' );
				?>
				<img src="<?php echo $retina_logo; ?>" width="<?php echo $logo_size['width']; ?>" height="<?php echo $logo_size['height']; ?>" alt="<?php bloginfo('name'); ?>" <?php echo $style; ?> class="fusion-standard-logo fusion-logo-2x" />
				<?php else: ?>
				<img src="<?php echo fusion_get_theme_option( 'logo' ); ?>" width="<?php echo $logo_size['width']; ?>" height="<?php echo $logo_size['height']; ?>" alt="<?php bloginfo('name'); ?>" class="fusion-standard-logo fusion-logo-2x" />
				<?php endif; ?>

				<!-- mobile logo -->
				<?php if( fusion_get_theme_option( 'mobile_logo' ) ): ?>
					<img src="<?php echo fusion_get_theme_option( 'mobile_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-1x fusion-mobile-logo-1x" />
					<?php
					$retina_logo = fusion_get_theme_option( 'mobile_logo_retina' );
					if( $retina_logo ):
					if ( fusion_get_theme_option( 'mobile_retina_logo_width' ) && fusion_get_theme_option( 'mobile_retina_logo_height' ) ) {
						$logo_size['width'] = fusion_get_theme_option( 'mobile_retina_logo_width' );
						$logo_size['height'] = fusion_get_theme_option( 'mobile_retina_logo_height' );
					} else {
						$logo_size['width'] = '';
						$logo_size['height'] = '';
					}
					$style = sprintf( 'style="width:%1$s%3$s; max-height: %2$s%3$s; height: auto;"', $logo_size['width'], $logo_size['height'], 'px' );
					?>
					<img src="<?php echo $retina_logo; ?>" alt="<?php bloginfo('name'); ?>" <?php echo $style; ?> class="fusion-logo-2x fusion-mobile-logo-2x" />
					<?php else: ?>
					<img src="<?php echo fusion_get_theme_option( 'mobile_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-2x fusion-mobile-logo-2x" />
					<?php endif; ?>
				<?php endif; ?>

				<!-- sticky header logo -->
				<?php if( fusion_get_theme_option( 'sticky_header_logo' ) && 
						( fusion_get_theme_option('header_layout') == 'v1' || fusion_get_theme_option('header_layout') == 'v2' || fusion_get_theme_option('header_layout') == 'v3' || 
						( ( fusion_get_theme_option('header_layout') == 'v4' | fusion_get_theme_option('header_layout') == 'v5' ) && fusion_get_theme_option('header_sticky_type2_layout') == 'menu_and_logo' ) ) ): ?>
					<img src="<?php echo fusion_get_theme_option( 'sticky_header_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-1x fusion-sticky-logo-1x" />
					<?php
					$retina_logo = fusion_get_theme_option( 'sticky_header_logo_retina' );
					if( $retina_logo ):
					if ( fusion_get_theme_option( 'sticky_retina_logo_width' ) && fusion_get_theme_option( 'sticky_retina_logo_height' ) ) {
						$logo_size['width'] = fusion_get_theme_option( 'sticky_retina_logo_width' );
						$logo_size['height'] = fusion_get_theme_option( 'sticky_retina_logo_height' );
					} else {
						$logo_size['width'] = '';
						$logo_size['height'] = '';
					}
					$style = sprintf( 'style="width:%1$s%3$s; max-height: %2$s%3$s; height: auto;"', $logo_size['width'], $logo_size['height'], 'px' );
					?>
					<img src="<?php echo $retina_logo; ?>" alt="<?php bloginfo('name'); ?>" <?php echo $style; ?> class="fusion-logo-2x fusion-sticky-logo-2x" />
					<?php else: ?>
					<img src="<?php echo fusion_get_theme_option( 'sticky_header_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-2x fusion-sticky-logo-2x" />
					<?php endif; ?>
				<?php endif; ?>
			</a>
			<?php
			/**
			 * avada_logo_append hook
			 * @hooked avada_header_content_3 - 10
			 */
			if( fusion_get_theme_option( 'header_position' ) == 'Top' ) {
				do_action( 'avada_logo_append' );
			}
			?>
		</div>
	<?php }
}

if( ! function_exists( 'avada_main_menu' ) ) {
	function avada_main_menu() {
		if( ! fusion_get_theme_option( 'disable_megamenu' ) ) {
			wp_nav_menu(array(
				'theme_location'	=> 'main_navigation',
				'depth'				=> 5,
				'menu_class'      	=> 'fusion-menu',
				'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'	   	=> 'FusionCoreFrontendWalker::fallback',
				'walker'			=> new FusionCoreFrontendWalker(),
				'container_class'	=> 'fusion-main-menu'
			));

			if( has_nav_menu( 'sticky_navigation' ) &&
				( ! function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) || ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ! ubermenu_get_menu_instance_by_theme_location( 'sticky_navigation' ) ) )
			) {
				wp_nav_menu(array(
					'theme_location'	=> 'sticky_navigation',
					'depth'				=> 5,
					'menu_class'      	=> 'fusion-menu',
					'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'fallback_cb'	   	=> 'FusionCoreFrontendWalker::fallback',
					'walker'			=> new FusionCoreFrontendWalker(),
					'container_class'	=> 'fusion-main-menu fusion-sticky-menu'
				));
			}
		} else {
			wp_nav_menu(array(
				'theme_location' 	=> 'main_navigation',
				'depth' 		 	=> 5,
				'menu_class'      	=> 'fusion-menu',
				'fallback_cb' 	 	=> 'avada_default_menu_fallback',
				'items_wrap' 	 	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'container_class'	=> 'fusion-main-menu'
			));

			if( has_nav_menu( 'sticky_navigation' ) &&
				( ! function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) || ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ! ubermenu_get_menu_instance_by_theme_location( 'sticky_navigation' ) ) )
			) {
				wp_nav_menu(array(
					'theme_location'	=> 'sticky_navigation',
					'depth'				=> 5,
					'menu_class'      	=> 'fusion-menu',
					'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'fallback_cb'	   	=> 'avada_default_menu_fallback',
					'container_class'	=> 'fusion-main-menu fusion-sticky-menu'
				));
			}
		}
		
		// Make sure mobile menu is not loaded when ubermenu is used
		if ( ! function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) ||
			 ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ! ubermenu_get_menu_instance_by_theme_location( 'main_navigation' ) )
		) {
			avada_mobile_main_menu();			
		}
	}
}

if( ! function_exists( 'avada_default_menu_fallback' ) ) {
	function avada_default_menu_fallback( $args ) {
		return null;
	}
}

if( ! function_exists( 'avada_contact_info' ) ) {
	function avada_contact_info() {
		$phone_number = do_shortcode( fusion_get_theme_option( 'header_number' ) );
		$email = fusion_get_theme_option( 'header_email' );
		$header_position = fusion_get_theme_option( 'header_position' );
		$html = '';

		if( $phone_number || $email ) {
			$html .= '<div class="fusion-contact-info">';
				$html .= $phone_number;
				if( $phone_number && $email ) {
					if( $header_position == 'Top' ) {
						$html .= '<span class="fusion-header-separator">' . apply_filters( 'avada_header_separator', '|' ) .'</span>';
					} else {
						$html .= '<br />';
					}
				}
				$html .= sprintf( apply_filters( 'avada_header_contact_info_email', '<a href="mailto:%s">%s</a>' ), $email, $email );
			$html .= '</div>';
		}

		return $html;
	}
}

if( ! function_exists( 'avada_secondary_nav' ) ) {
	function avada_secondary_nav() {
		if ( has_nav_menu( 'top_navigation' ) ) {
			return wp_nav_menu(array(
				'theme_location'	=> 'top_navigation',
				'depth'				=> 5,
				'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'container_class'	=> 'fusion-secondary-menu',
				'echo'				=> false
			));
		}
	}
}

if( ! function_exists( 'avada_header_social_links' ) ) {
	function avada_header_social_links() {
		global $social_icons;

		$options = array(
			'position'			=> 'header',
			'icon_colors' 		=> fusion_get_theme_option( 'header_social_links_icon_color'),
			'box_colors' 		=> fusion_get_theme_option( 'header_social_links_box_color' ),
			'icon_boxed' 		=> fusion_get_theme_option( 'header_social_links_boxed' ),
			'icon_boxed_radius' => fusion_get_theme_option( 'header_social_links_boxed_radius' ),
			'tooltip_placement'	=> fusion_get_theme_option( 'header_social_links_tooltip_placement' ),
			'linktarget'		=> fusion_get_theme_option( 'social_icons_new' )
		);

		$render_social_icons = $social_icons->render_social_icons( $options );
		$html = '';

		if( $render_social_icons ) {
			$html .= '<div class="fusion-social-links-header">';
				$html .= $render_social_icons;
			$html .= '</div>';
		}

		return $html;
	}
}

if( ! function_exists( 'avada_secondary_header_content' ) ) {
	/**
	 * Get the secondary header content based on the content area
	 * @param  string $content_area Secondary header content area from theme optins
	 * @return string               Html for the content
	 */
	function avada_secondary_header_content( $content_area ) {
		if( fusion_get_theme_option( $content_area ) == 'Contact Info' ) {
			return avada_contact_info();
		} elseif( fusion_get_theme_option( $content_area ) == 'Social Links' ) {
			return avada_header_social_links();
		} elseif( fusion_get_theme_option( $content_area ) == 'Navigation' ) {
			$mobile_menu_wrapper = '';
			if ( has_nav_menu( 'top_navigation' ) ) {
				$mobile_menu_wrapper = '<div class="fusion-mobile-nav-holder"></div>';
			}
			return avada_secondary_nav() . $mobile_menu_wrapper;
		}
	}
}

if( fusion_get_theme_option('header_layout') == 'v4' ) {
	add_action( 'avada_logo_append', 'avada_header_content_3', 10 );
}
if( ! function_exists( 'avada_header_content_3' ) ) {
	function avada_header_content_3() {
		$header_content_3 = fusion_get_theme_option( 'header_v4_content' );
		$html = '';

		if( $header_content_3 == 'Tagline' ) {
			$html .= avada_header_tagline();
		} elseif( $header_content_3 == 'Tagline And Search' ) {
			if( fusion_get_theme_option( 'header_position' ) == 'Top' ) {
				if( fusion_get_theme_option( 'logo_alignment' ) == 'Right' ) {
					$html .= avada_header_tagline();
					$html .= sprintf( '<div class="fusion-secondary-menu-search">%s</div>', get_search_form( false ) );
				} else {
					$html .= sprintf( '<div class="fusion-secondary-menu-search">%s</div>', get_search_form( false ) );
					$html .= avada_header_tagline();				
				}
			} else {
				$html .= avada_header_tagline();
				$html .= sprintf( '<div class="fusion-secondary-menu-search">%s</div>', get_search_form( false ) );			
			}
		} elseif( $header_content_3 == 'Search' ) {
			$html .= sprintf( '<div class="fusion-secondary-menu-search">%s</div>', get_search_form( false ) );
		} elseif( $header_content_3 == 'Banner' ) {
			$html .= avada_header_banner();
		}

		echo $html;
	}
}

if( ! function_exists( 'avada_header_banner' ) ) {
	function avada_header_banner() {
		return sprintf( '<div class="fusion-header-banner">%s</div>', do_shortcode( fusion_get_theme_option( 'header_banner_code' ) ) );
	}
}

if( ! function_exists( 'avada_header_tagline' ) ) {
	function avada_header_tagline() {
		return sprintf( '<h3 class="fusion-header-tagline">%s</h3>', do_shortcode( fusion_get_theme_option( 'header_tagline' ) ) );
	}
}

if( ! function_exists( 'avada_modern_menu' ) ) {
	function avada_modern_menu() {
		$html = '';

		if( fusion_get_theme_option( 'mobile_menu_design' ) == 'modern' ) {
			$header_content_3 = fusion_get_theme_option( 'header_v4_content' );
			
			$html .= '<div class="fusion-mobile-menu-icons">';
				// Make sure mobile menu toggle is not loaded when ubermenu is used
				if ( ! function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) ||
					 ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ! ubermenu_get_menu_instance_by_theme_location( 'main_navigation' ) )
				) {
					$html .= '<a href="#" class="fusion-icon fusion-icon-bars"></a>';		
				}			
	
				if ( fusion_get_theme_option('header_layout') == 'v4' && ( $header_content_3 == 'Tagline And Search' || $header_content_3 == 'Search' ) ) {
					$html .= '<a href="#" class="fusion-icon fusion-icon-search"></a>';
				}
				if ( class_exists('Woocommerce') && fusion_get_theme_option( 'woocommerce_cart_link_main_nav' ) ) {
					$html .= sprintf( '<a href="%s" class="fusion-icon fusion-icon-shopping-cart"></a>', get_permalink( get_option( 'woocommerce_cart_page_id' ) ) );
				}
			$html .= '</div>';
		}

		return $html;
	}
}

if( ! function_exists( 'avada_mobile_main_menu' ) ) {
	function avada_mobile_main_menu() {
		if( fusion_get_theme_option('header_position') != 'Top' ||
			( fusion_get_theme_option('header_layout') != 'v4' && fusion_get_theme_option('header_layout') != 'v5' )
		) {
			echo avada_modern_menu();
		}

		echo '<div class="fusion-mobile-nav-holder"></div>';

		if( has_nav_menu( 'sticky_navigation' ) ) {
			echo '<div class="fusion-mobile-nav-holder fusion-mobile-sticky-nav-holder"></div>';
		}
	}
}