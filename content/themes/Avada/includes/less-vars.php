<?php

add_filter( 'less_vars', 'avada_less_vars', 10, 2 );
/**
 * Variables which will be passed to dynamic.less stylesheet
 * @param  array  $vars   Variables passed to LESS stylesheets
 * @param  string $handle Reference to the handle used with wp_enqueue_style()
 * @return array          Modified variables passed to LESS
 */
if( ! function_exists( 'avada_less_vars' ) ) {
	function avada_less_vars( $vars, $handle ) {
		if( $handle == 'avada-dynamic' ) {
			global $smof_data, $of_options;

			if ( ! $smof_data ) {
				$smof_data = of_get_options();
			}

			$options = array();

			foreach( $of_options as $option ) {
				if( isset( $option['std'] ) ) {
					$options[ $option['id'] ] = $option['std'];
				}
			}

			foreach( $smof_data as $key => $data ) {
				if( $data == NULL && $data != '' && isset( $options[ $key ] ) ) {
					$smof_data[ $key ] = $options[ $key ];
				}
			}

			if( strpos( $smof_data['site_width'], '%' ) === false && strpos( $smof_data['site_width'], 'px' ) === false ) {
				$smof_data['site_width'] = $smof_data['site_width'] . 'px';
			}

			// General
			$vars['template-directory'] = sprintf( '~"%s"', get_template_directory_uri() );
			$vars['page-layout'] = $smof_data['layout'];
			$vars['header-position'] = $smof_data['header_position'];
			$vars['footer-width-100'] = $smof_data['footer_100_width'];
			$vars['custom-font'] =  ( isset( $smof_data['custom_font_woff'] ) && $smof_data['custom_font_woff'] ) &&
									( isset( $smof_data['custom_font_ttf'] ) && $smof_data['custom_font_ttf'] ) &&
									( isset( $smof_data['custom_font_svg'] ) && $smof_data['custom_font_svg'] ) &&
									( isset( $smof_data['custom_font_eot'] ) && $smof_data['custom_font_eot'] );
			$vars['site-width'] = $smof_data['site_width'];
			$vars['responsive'] = $smof_data['responsive'];
			$vars['ipad-portrait'] = $smof_data['ipad_potrait'];
			$vars['disable-avada-dropdown-styles'] = $smof_data['avada_styles_dropdowns'];
			$vars['content-width'] = ( is_numeric ( $smof_data['content_width'] ) ) ? $smof_data['content_width'] . '%' : $smof_data['content_width'];
			$vars['sidebar-width'] = ( is_numeric ( $smof_data['sidebar_width'] ) ) ? $smof_data['sidebar_width'] . '%' : $smof_data['sidebar_width'];
			$vars['content-width-2'] = ( is_numeric ( $smof_data['content_width_2'] ) ) ? $smof_data['content_width_2'] . '%' : $smof_data['content_width_2'];
			$vars['sidebar-2-1-width'] = ( is_numeric ( $smof_data['sidebar_2_1_width'] ) ) ? $smof_data['sidebar_2_1_width'] . '%' : $smof_data['sidebar_2_1_width'];
			$vars['sidebar-2-2-width'] = ( is_numeric ( $smof_data['sidebar_2_2_width'] ) ) ? $smof_data['sidebar_2_2_width'] . '%' : $smof_data['sidebar_2_2_width'];
			$vars['scheme-type'] = $smof_data['scheme_type'];
			$vars['breadcrumbs-mobile'] = $smof_data['breadcrumb_mobile'];
			$vars['image-rollover'] = $smof_data['image_rollover'];
			$vars['image-rollover-direction'] = $smof_data['image_rollover_direction'];
			$vars['woocommerce-one-page-checkout'] = $smof_data['woocommerce_one_page_checkout'];
			if ( $smof_data['header_position'] == 'Top' ) {
				$vars['side-header-width'] = '0px';
			} else {
				// Set the side-header width to 280px (default value ) if the theme options setting is above a threshold of 280px
				$vars['side-header-width'] = ( $smof_data['side_header_width'] != NULL ) ? $smof_data['side_header_width'] : $options['side_header_width'];
			}        
			$vars['header-shadow'] = $smof_data['header_shadow'];
			$vars['hundred-percent-padding'] = $smof_data['hundredp_padding'];
			$vars['is-woocommerce'] = class_exists( 'Woocommerce' );
			$vars['is-rtl'] = is_rtl();
			$vars['disable-smooth-scrolling'] = $smof_data['smooth_scrolling'];
			$vars['search-form-height'] = ( $smof_data['search_form_height'] != NULL ) ? $smof_data['search_form_height'] : $options['search_form_height'];

			// Styling Variables
			$vars['primary-color'] = $smof_data['primary_color'];
			$vars['content-bg-color'] = $smof_data['content_bg_color'];
			$vars['bg-color'] = $smof_data['bg_color'];
			$vars['footer-bg-color'] = $smof_data['footer_bg_color'];
			$vars['footer-border-color'] = $smof_data['footer_border_color'];
			$vars['copyright-bg-color'] = $smof_data['copyright_bg_color'];
			$vars['copyright-border-color'] = $smof_data['copyright_border_color'];
			$vars['pricing-box-color'] = $smof_data['pricing_box_color'];
			$vars['image-rollover-opacity'] = $smof_data['image_gradient_top_color']['opacity'];
			$vars['image-rollover-gradient-top-color'] = $smof_data['image_gradient_top_color']['color'];
			if( $vars['image-rollover-gradient-top-color'] != '' ) {
				$image_rollover_gradient_top = fusion_hex2rgb( $vars['image-rollover-gradient-top-color'] );

				$vars['image-rollover-gradient-top-color'] = sprintf( 'rgba(%s,%s,%s, %s)', $image_rollover_gradient_top[0], $image_rollover_gradient_top[1], $image_rollover_gradient_top[2], $vars['image-rollover-opacity'] );
			}
			$vars['image-rollover-gradient-bottom-color'] = $smof_data['image_gradient_bottom_color'];
			if( $vars['image-rollover-gradient-bottom-color'] != '' ) {
				$image_rollover_gradient_bottom = fusion_hex2rgb( $vars['image-rollover-gradient-bottom-color'] );
				
				$vars['image-rollover-gradient-bottom-color'] = sprintf( 'rgba(%s,%s,%s, %s)', $image_rollover_gradient_bottom[0], $image_rollover_gradient_bottom[1], $image_rollover_gradient_bottom[2], $vars['image-rollover-opacity'] );
			}
			$vars['image-rollover-text-color'] = $smof_data['image_rollover_text_color'];
			$vars['button-gradient-top-color'] = ( ! $smof_data['button_gradient_top_color'] ) ? 'transparent' : $smof_data['button_gradient_top_color'];
			$vars['button-gradient-bottom-color'] = ( ! $smof_data['button_gradient_bottom_color'] ) ? 'transparent' : $smof_data['button_gradient_bottom_color'];
			$vars['button-accent-color'] = ( ! $smof_data['button_accent_color'] ) ? 'transparent' : $smof_data['button_accent_color'];
			$vars['button-gradient-top-hover-color'] = ( ! $smof_data['button_gradient_top_color_hover'] ) ? 'transparent' : $smof_data['button_gradient_top_color_hover'];
			$vars['button-gradient-bottom-hover-color'] = ( ! $smof_data['button_gradient_bottom_color_hover'] ) ? 'transparent' : $smof_data['button_gradient_bottom_color_hover'];
			$vars['button-accent-hover-color'] = ( ! $smof_data['button_accent_hover_color'] ) ? 'transparent' : $smof_data['button_accent_hover_color'];
			$vars['page-title-bar-border-color'] = $smof_data['page_title_border_color'];
			$vars['page-title-bar-mobile-height'] = ( $smof_data['page_title_mobile_height'] ) ? $smof_data['page_title_mobile_height'] : $options['page_title_mobile_height'];
			$vars['icon-circle-color'] = $smof_data['icon_circle_color'];
			$vars['icon-border-color'] = $smof_data['icon_border_color'];
			$vars['icon-color'] = $smof_data['icon_color'];
			$vars['title-border-color'] = $smof_data['title_border_color'];
			$vars['testimonial-bg-color'] = $smof_data['testimonial_bg_color'];
			$vars['testimonial-text-color'] = $smof_data['testimonial_text_color'];
			$vars['body-text-color'] = $smof_data['body_text_color'];
			$vars['h1-color'] = $smof_data['h1_color'];
			$vars['h2-color'] = $smof_data['h2_color'];
			$vars['h3-color'] = $smof_data['h3_color'];
			$vars['h4-color'] = $smof_data['h4_color'];
			$vars['h5-color'] = $smof_data['h5_color'];
			$vars['h6-color'] = $smof_data['h6_color'];
			$vars['page-title-bar-color'] = $smof_data['page_title_color'];
			$vars['pricing-table-sep-heading-color'] = $smof_data['sep_pricing_box_heading_color'];
			$vars['pricing-table-full-heading-color'] = $smof_data['full_boxed_pricing_box_heading_color'];
			$vars['link-color'] = $smof_data['link_color'];
			$vars['breadcrumbs-text-color'] = $smof_data['breadcrumbs_text_color'];
			$vars['slidingbar-headings-color'] = $smof_data['slidingbar_headings_color'];
			$vars['slidingbar-text-color'] =  $smof_data['slidingbar_text_color'];
			$vars['slidingbar-link-color'] = $smof_data['slidingbar_link_color'];
			$vars['sidebar-heading-color'] = $smof_data['sidebar_heading_color'];
			$vars['footer-headings-color'] = $smof_data['footer_headings_color'];
			$vars['footer-text-color'] = $smof_data['footer_text_color'];
			$vars['footer-link-color'] = $smof_data['footer_link_color'];
			$vars['elasticslider-title-color'] = $smof_data['es_title_color'];
			$vars['elasticslider-caption-color'] = $smof_data['es_caption_color'];
			$vars['sep-color'] = $smof_data['sep_color'];
			$vars['woo-qty-bg-color'] = $smof_data['qty_bg_color'];
			$vars['woo-qty-bg-hover-color'] = $smof_data['qty_bg_hover_color'];
			$vars['woo-dropdown-bg-color'] = $smof_data['woo_dropdown_bg_color'];
			if( trim( $vars['woo-dropdown-bg-color'] ) == '' ) {
				$vars['woo-dropdown-bg-color'] = $options['woo_dropdown_bg_color'];
			}
			$vars['woo-dropdown-text-color'] = $smof_data['woo_dropdown_text_color'];
			if( trim( $vars['woo-dropdown-text-color'] ) == '' ) {
				$vars['woo-dropdown-text-color'] = $options['woo_dropdown_text_color'];
			}
			$vars['woo-dropdown-border-color'] = $smof_data['woo_dropdown_border_color'];
			$vars['slidingbar-toggle-icon-color'] = $smof_data['slidingbar_toggle_icon_color'];
			$vars['slidingbar-divider-color'] = $smof_data['slidingbar_divider_color'];
			$vars['footer-divider-color'] = $smof_data['footer_divider_color'];
			$vars['form-bg-color'] = $smof_data['form_bg_color'];
			$vars['form-text-color'] = $smof_data['form_text_color'];
			$vars['form-border-color'] = $smof_data['form_border_color'];
			$vars['tagline-font-color'] = $smof_data['tagline_font_color'];
			$vars['sidebar-bg-color'] = $smof_data['sidebar_bg_color'];
			$vars['woo-cart-bg-color'] = $smof_data['woo_cart_bg_color'];
			$vars['accordion-inactive-color'] = $smof_data['accordian_inactive_color'];
			$vars['counter-filled-color'] = $smof_data['counter_filled_color'];
			$vars['counter-unfilled-color'] = $smof_data['counter_unfilled_color'];
			$vars['dates-box-bg-color'] = $smof_data['dates_box_color'];
			$vars['carousel-nav-bg-color'] = $smof_data['carousel_nav_color'];
			$vars['carousel-nav-hover-bg-color'] = $smof_data['carousel_hover_color'];
			$vars['content-box-bg-color'] = $smof_data['content_box_bg_color'];
			$vars['tabs-bg-color'] = $smof_data['tabs_bg_color'];
			$vars['tabs-inactive-color'] = $smof_data['tabs_inactive_color'];
			$vars['tabs-border-color'] = $smof_data['tabs_border_color'];
			$vars['social-bg-color'] = $smof_data['social_bg_color'];
			$vars['timeline-bg-color'] = $smof_data['timeline_bg_color'];
			if( $vars['timeline-bg-color'] == '' ) {
				$vars['timeline-bg-color'] = 'transparent';
			}
			$vars['timeline-color'] = $smof_data['timeline_color'];
			$vars['load-more-posts-button-bg-color'] = $smof_data['load_more_posts_button_bg_color'];
			$load_more_bg_color_rgb = fusion_hex2rgb( $smof_data['load_more_posts_button_bg_color'] );
			$vars['load-more-posts-button-bg-color-hover'] = sprintf( 'rgba(%s,%s,%s,0.8)', $load_more_bg_color_rgb[0], $load_more_bg_color_rgb[1], $load_more_bg_color_rgb[2] );
			$vars['bbp-forum-header-bg-color'] = $smof_data['bbp_forum_header_bg'];
			$vars['bbp-forum-border-color'] = $smof_data['bbp_forum_border_color'];
			$vars['button-bevel-color'] = $smof_data['button_bevel_color'];
			$vars['tagline-bg-color'] = $smof_data['tagline_bg'];
			$vars['link-image-rollover'] = $smof_data['link_image_rollover'];
			$vars['zoom-image-rollover'] = $smof_data['zoom_image_rollover'];
			$vars['title-image-rollover'] = $smof_data['title_image_rollover'];
			$vars['cats-image-rollover'] = $smof_data['cats_image_rollover'];
			$vars['icon-color-image-rollover'] = $smof_data['image_rollover_icon_color'];
			$vars['icon-size-image-rollover'] = ( $smof_data['image_rollover_icon_size'] != NULL ) ? $smof_data['image_rollover_icon_size'] : $option['image_rollover_icon_size'];
			$vars['main-nav-submenu-bg-color'] = $smof_data['menu_sub_bg_color'];
			$vars['main-nav-color'] = $smof_data['menu_first_color'];
			$vars['main-nav-hover-color'] = $smof_data['menu_hover_first_color'];
			$vars['main-nav-submenu-separator-color'] = $smof_data['menu_sub_sep_color'];
			$vars['main-nav-submenu-hover-color'] = $smof_data['menu_bg_hover_color'];
			$vars['main-nav-submenu-font-color'] = $smof_data['menu_sub_color'];
			$vars['secondary-header-font-color'] = $smof_data['snav_color'];
			$vars['secondary-menu-divider-color'] = $smof_data['header_top_first_border_color'];
			$vars['secondary-menu-bg-color'] = $smof_data['header_top_sub_bg_color'];
			$vars['secondary-menu-border-color'] = $smof_data['header_top_menu_sub_sep_color'];
			$vars['header-border-color'] = $smof_data['header_border_color'];
			$vars['secondary-menu-font-color'] = $smof_data['header_top_menu_sub_color'];
			$vars['secondary-menu-hover-bg-color'] = $smof_data['header_top_menu_bg_hover_color'];
			$vars['secondary-menu-hover-font-color'] = $smof_data['header_top_menu_sub_hover_color'];
			$vars['secondary-header-bg-color'] = $smof_data['header_top_bg_color'];
			$vars['sticky-header-bg-color'] =  $smof_data['header_sticky_bg_color']['color'];
			$vars['sticky-header-bg-opacity'] =  $smof_data['header_sticky_bg_color']['opacity'];
			if( $vars['sticky-header-bg-color'] != '' ) {
				$rgba = fusion_hex2rgb( $vars['sticky-header-bg-color'] );

				$vars['sticky-header-bg-color'] = sprintf( 'rgba(%s,%s,%s, %s)', $rgba[0], $rgba[1], $rgba[2], $vars['sticky-header-bg-opacity'] );
			}
			$vars['mobile-menu-bg-color'] = $smof_data['mobile_menu_background_color'];
			$vars['mobile-menu-border-color'] = $smof_data['mobile_menu_border_color'];
			$vars['mobile-menu-hover-color'] = $smof_data['mobile_menu_hover_color'];
			$vars['mobile-header-bg-color'] = $smof_data['mobile_header_bg_color'];
			$vars['mobile-menu-font-color'] = $smof_data['mobile_menu_font_color'];
			$vars['mobile-menu-toggle-color'] = $smof_data['mobile_menu_toggle_color'];
			
			// Buttons
			$vars['button-type'] = $smof_data['button_type'];
			$vars['button-size'] = strtolower( $smof_data['button_size'] );
			$vars['button-border-width'] = $smof_data['button_border_width'];
			if( ! $vars['button-border-width'] ) {
				$vars['button-border-width'] = '1px';
			}
			$vars['button-shape'] = $smof_data['button_shape'];

			// Image Rollover
			$vars['image-rollover-icon-circle'] = $smof_data['icon_circle_image_rollover'];

			// Typography
			$vars['custom-font-eot'] = sprintf( '~"%s"', $smof_data['custom_font_eot'] );
			$vars['custom-font-woff'] = sprintf( '~"%s"', $smof_data['custom_font_woff'] );
			$vars['custom-font-ttf'] = sprintf( '~"%s"', $smof_data['custom_font_ttf'] );
			$vars['custom-font-svg'] = sprintf( '~"%s"', $smof_data['custom_font_svg'] );

			if( $smof_data['google_body'] != 'None' ) {
				$vars['font'] = sprintf( '\'%s\'', $smof_data['google_body'] ) . ', Arial, Helvetica, sans-serif';
			} elseif( $smof_data['standard_body'] != 'Select Font' ) {
				$vars['font'] = $smof_data['standard_body'];
			}

			$vars['font'] = sprintf( '~"%s"', $vars['font'] );

			if( $smof_data['google_nav'] != 'None' ) {
				$vars['nav-font'] = sprintf( '\'%s\'', $smof_data['google_nav'] ) . ', Arial, Helvetica, sans-serif';
			} elseif( $smof_data['standard_nav'] != 'Select Font' ) {
				$vars['nav-font'] = $smof_data['standard_nav'];
			}

			if( $vars['custom-font'] ) {
				$vars['nav-font'] =  '\'MuseoSlab500Regular\', Arial, Helvetica, sans-serif';
			}

			$vars['nav-font'] = sprintf( '~"%s"', $vars['nav-font'] );

			if( ! $vars['custom-font'] && $smof_data['google_headings'] != 'None' ) {
				$vars['headings-font'] = sprintf( '\'%s\'', $smof_data['google_headings'] ) . ', Arial, Helvetica, sans-serif';
			} elseif( ! $vars['custom-font'] && $smof_data['standard_headings'] != 'Select Font' ) {
				$vars['headings-font'] = $smof_data['standard_headings'];
			} else {
				$vars['headings-font'] = 'false';
			}

			if( $vars['headings-font'] != 'false' && $vars['headings-font'] != '' ) {
				$vars['headings-font'] = sprintf( '~"%s"', $vars['headings-font'] );
			}

			if( $smof_data['google_footer_headings'] != 'None' ) {
				$vars['footer-headings-font'] = sprintf( '\'%s\'', $smof_data['google_footer_headings'] ) . ', Arial, Helvetica, sans-serif';
			} elseif( $smof_data['standard_footer_headings'] != 'Select Font' ) {
				$vars['footer-headings-font'] = $smof_data['standard_footer_headings'];
			}
			
			if( $smof_data['google_button'] != 'None' ) {
				$vars['button-font'] = sprintf( '\'%s\'', $smof_data['google_button'] ) . ', Arial, Helvetica, sans-serif';
			} elseif( $smof_data['standard_button'] != 'Select Font' ) {
				$vars['button-font'] = $smof_data['standard_button'];
			}

			$vars['font-weight-body'] = $smof_data['font_weight_body'];
			$vars['font-weight-menu'] = $smof_data['font_weight_menu'];
			$vars['font-weight-headings'] = $smof_data['font_weight_headings'];
			$vars['font-weight-footer-headings'] = $smof_data['font_weight_footer_headings'];
			$vars['font-weight-button'] = $smof_data['font_weight_button'];

			$vars['typography-responsive'] = $smof_data['typography_responsive'];
			$vars['footer-headings-font'] = sprintf( '~"%s"', $vars['footer-headings-font'] );
			$vars['body-font-size'] = ( $smof_data['body_font_size'] != NULL ) ? $smof_data['body_font_size'] : $options['body_font_size'];
			$vars['body-line-height'] = ( $smof_data['body_font_lh'] != NULL ) ? $smof_data['body_font_lh'] : $options['body_font_lh'];
			$vars['nav-font-size'] = ( $smof_data['nav_font_size'] != NULL ) ? $smof_data['nav_font_size'] : $options['nav_font_size'];
			$vars['breadcrumbs-font-size'] = ( $smof_data['breadcrumbs_font_size'] != NULL ) ? $smof_data['breadcrumbs_font_size'] : $options['breadcrumbs_font_size'];
			$vars['side-nav-font-size'] = ( $smof_data['side_nav_font_size'] != NULL ) ? $smof_data['side_nav_font_size'] : $options['side_nav_font_size'];
			$vars['sidebar-widget-title-font-size'] = ( $smof_data['sidew_font_size'] != NULL ) ? $smof_data['sidew_font_size'] : $options['sidew_font_size'];
			$vars['slidingbar-font-size'] = ( $smof_data['slidingbar_font_size'] != NULL ) ? $smof_data['slidingbar_font_size'] : $options['slidingbar_font_size'];
			$vars['footer-widget-title-font-size'] = ( $smof_data['footw_font_size'] != NULL ) ? $smof_data['footw_font_size'] : $options['footw_font_size'];
			$vars['copyright-font-size'] = ( $smof_data['copyright_font_size'] != NULL ) ? $smof_data['copyright_font_size'] : $options['copyright_font_size'];
			$vars['h1-font-size'] = ( $smof_data['h1_font_size'] != NULL ) ? $smof_data['h1_font_size'] : $options['h1_font_size'];
			$vars['h1-line-height'] = ( $smof_data['h1_font_lh'] != NULL ) ? $smof_data['h1_font_lh'] : $options['h1_font_lh'];
			$vars['h2-font-size'] = ( $smof_data['h2_font_size'] != NULL ) ? $smof_data['h2_font_size'] : $options['h2_font_size'];
			$vars['h2-line-height'] = ( $smof_data['h2_font_lh'] != NULL ) ? $smof_data['h2_font_lh'] : $options['h2_font_lh'];
			$vars['h3-font-size'] = ( $smof_data['h3_font_size'] != NULL ) ? $smof_data['h3_font_size'] : $options['h3_font_size'];
			$vars['h3-line-height'] = ( $smof_data['h3_font_lh'] != NULL ) ? $smof_data['h3_font_lh'] : $options['h3_font_lh'];
			$vars['h4-font-size'] = ( $smof_data['h4_font_size'] != NULL ) ? $smof_data['h4_font_size'] : $options['h4_font_size'];
			$vars['h4-line-height'] = ( $smof_data['h4_font_lh'] != NULL ) ? $smof_data['h4_font_lh'] : $options['h4_font_lh'];
			$vars['h5-font-size'] = ( $smof_data['h5_font_size'] != NULL ) ? $smof_data['h5_font_size'] : $options['h5_font_size'];
			$vars['h5-line-height'] = ( $smof_data['h5_font_lh'] != NULL ) ? $smof_data['h5_font_lh'] : $options['h5_font_lh'];
			$vars['h6-font-size'] = ( $smof_data['h6_font_size'] != NULL ) ? $smof_data['h6_font_size'] : $options['h6_font_size'];
			$vars['h6-line-height'] = ( $smof_data['h6_font_lh'] != NULL ) ? $smof_data['h6_font_lh'] : $options['h6_font_lh'];
			$vars['elasticslider-title-font-size'] = ( $smof_data['es_title_font_size'] != NULL ) ? $smof_data['es_title_font_size'] : $options['es_title_font_size'];
			$vars['elasticslider-caption-font-size'] = ( $smof_data['es_caption_font_size'] != NULL ) ? $smof_data['es_caption_font_size'] : $options['es_caption_font_size'];
			$vars['meta-font-size'] = ( $smof_data['meta_font_size'] != NULL ) ? $smof_data['meta_font_size'] : $options['meta_font_size'];
			$vars['woo-icon-font-size'] = ( $smof_data['woo_icon_font_size'] != NULL ) ? $smof_data['woo_icon_font_size'] : $smof_data['woo_icon_font_size'];
			$vars['pagination-font-size'] = ( $smof_data['pagination_font_size'] != NULL ) ? $smof_data['pagination_font_size'] : $options['pagination_font_size'];
			$vars['tagline-font-size'] = ( $smof_data['tagline_font_size'] != NULL ) ? $smof_data['tagline_font_size'] : $options['tagline_font_size'];
			$vars['page-title-bar-title-font-size'] = ( $smof_data['page_title_font_size'] != NULL ) ? $smof_data['page_title_font_size'] : $options['page_title_font_size'];
			$vars['page-title-bar-subheader-font-size'] = ( $smof_data['page_title_subheader_font_size'] != NULL ) ? $smof_data['page_title_subheader_font_size'] : $options['page_title_subheader_font_size'];
			$vars['main-nav-font-size'] = ( $smof_data['nav_font_size'] != NULL ) ? $smof_data['nav_font_size'] : $smof_data['nav_font_size'];
			$vars['main-nav-submenu-font-size'] = ( $smof_data['nav_dropdown_font_size'] != NULL ) ? $smof_data['nav_dropdown_font_size'] : $options['nav_dropdown_font_size'];
			$vars['megamenu-title-size'] = ( $smof_data['megamenu_title_size'] != NULL ) ? $smof_data['megamenu_title_size'] : $options['megamenu_title_size'];
			$vars['secondary-header-font-size'] = ( $smof_data['snav_font_size'] != NULL ) ? $smof_data['snav_font_size'] : $options['snav_font_size'];
			$vars['secondary-menu-line-height'] = ( $smof_data['sec_menu_lh'] != NULL ) ? $smof_data['sec_menu_lh'] : $options['sec_menu_lh'];
			if( $smof_data['header_sticky_nav_font_size'] ) {
				$vars['sticky-header-font-size'] = ( $smof_data['header_sticky_nav_font_size'] != NULL ) ? $smof_data['header_sticky_nav_font_size'] : $options['header_sticky_nav_font_size'];
			} else {
				$vars['sticky-header-font-size'] = ( $smof_data['nav_font_size'] != NULL ) ? $smof_data['nav_font_size'] : $options['nav_font_size'];
			}
			
			$vars['menu-letter-spacing'] = ( $smof_data['menu_font_ls'] != NULL ) ? $smof_data['menu_font_ls'] : $options['menu_font_ls'];
			$vars['button-letter-spacing'] = ( $smof_data['button_font_ls'] != NULL ) ? $smof_data['button_font_ls'] : $options['button_font_ls'];
			$vars['content-box-title-size'] = ( $smof_data['content_box_title_size'] != NULL ) ? $smof_data['content_box_title_size'] : $options['content_box_title_size'];
			$vars['sharing-social-links-size'] = ( $smof_data['sharing_social_links_font_size'] != NULL ) ? $smof_data['sharing_social_links_font_size'] : $options['sharing_social_links_font_size'];
			$vars['sharing-social-links-boxed-padding'] = ( $smof_data['sharing_social_links_boxed_padding'] != NULL ) ? $smof_data['sharing_social_links_boxed_padding'] : $options['sharing_social_links_boxed_padding'];
			$vars['social-links-size'] = ( $smof_data['social_links_font_size'] != NULL ) ? $smof_data['social_links_font_size'] : $options['social_links_font_size'];
			$vars['social-links-boxed-padding'] = ( $smof_data['social_links_boxed_padding'] != NULL ) ? $smof_data['social_links_boxed_padding'] : $options['social_links_boxed_padding'];
			$vars['mobile-menu-font-size'] = ( $smof_data['mobile_menu_font_size'] != NULL ) ? $smof_data['mobile_menu_font_size'] : $options['mobile_menu_font_size'];

			$vars['h1-top-margin'] = ( $smof_data['h1_top_margin'] != NULL ) ? $smof_data['h1_top_margin'] : $options['h1_top_margin'];
			$vars['h1-bottom-margin'] = ( $smof_data['h1_bottom_margin'] != NULL ) ? $smof_data['h1_bottom_margin'] : $options['h1_bottom_margin'];
			$vars['h2-top-margin'] = ( $smof_data['h2_top_margin'] != NULL ) ? $smof_data['h2_top_margin'] : $options['h2_top_margin'];
			$vars['h2-bottom-margin'] = ( $smof_data['h2_bottom_margin'] != NULL ) ? $smof_data['h2_bottom_margin'] : $options['h2_bottom_margin'];
			$vars['h3-top-margin'] = ( $smof_data['h3_top_margin'] != NULL ) ? $smof_data['h3_top_margin'] : $options['h3_top_margin'];
			$vars['h3-bottom-margin'] = ( $smof_data['h3_bottom_margin'] != NULL ) ? $smof_data['h3_bottom_margin'] : $options['h3_bottom_margin'];
			$vars['h4-top-margin'] = ( $smof_data['h4_top_margin'] != NULL ) ? $smof_data['h4_top_margin'] : $options['h4_top_margin'];
			$vars['h4-bottom-margin'] = ( $smof_data['h4_bottom_margin'] != NULL ) ? $smof_data['h4_bottom_margin'] : $options['h4_bottom_margin'];
			$vars['h5-top-margin'] = ( $smof_data['h5_top_margin'] != NULL ) ? $smof_data['h5_top_margin'] : $options['h5_top_margin'];
			$vars['h5-bottom-margin'] = ( $smof_data['h5_bottom_margin'] != NULL ) ? $smof_data['h5_bottom_margin'] : $options['h5_bottom_margin'];
			$vars['h6-top-margin'] = ( $smof_data['h6_top_margin'] != NULL ) ? $smof_data['h6_top_margin'] : $options['h6_top_margin'];
			$vars['h6-bottom-margin'] = ( $smof_data['h6_bottom_margin'] != NULL ) ? $smof_data['h6_bottom_margin'] : $options['h6_bottom_margin'];

			// Header Variables
			$vars['side-header-break-point'] = $smof_data['side_header_break_point'];
			$vars['header-top-padding'] = ( $smof_data['margin_header_top'] != NULL ) ? $smof_data['margin_header_top'] : $options['margin_header_top'];
			$vars['header-bottom-padding'] = ( $smof_data['margin_header_bottom'] != NULL ) ? $smof_data['margin_header_bottom'] : $options['margin_header_bottom'];
			$vars['header-left-padding'] = ( $smof_data['padding_header_left'] != NULL ) ? $smof_data['padding_header_left'] : $options['padding_header_left'];
			$vars['header-right-padding'] = ( $smof_data['padding_header_right'] != NULL ) ? $smof_data['padding_header_right'] : $options['padding_header_right'];
			$vars['logo-margin-left'] = ( $smof_data['margin_logo_left'] != NULL ) ? $smof_data['margin_logo_left'] : $options['margin_logo_left'];
			$vars['logo-margin-right'] = ( $smof_data['margin_logo_right'] != NULL ) ? $smof_data['margin_logo_right'] : $options['margin_logo_right'];
			$vars['logo-margin-top'] = ( $smof_data['margin_logo_top'] != NULL ) ? $smof_data['margin_logo_top'] : $options['margin_logo_top'];
			$vars['logo-margin-bottom'] = ( $smof_data['margin_logo_bottom'] != NULL ) ? $smof_data['margin_logo_bottom'] : $options['margin_logo_bottom'];
			$vars['main-nav-height'] = ( $smof_data['nav_height'] != NULL ) ? $smof_data['nav_height'] : $options['nav_height'];
			$vars['main-nav-padding'] = ( $smof_data['nav_padding'] != NULL ) ? $smof_data['nav_padding'] : $options['nav_padding'];
			$vars['main-nav-dropdown-width'] = ( $smof_data['dropdown_menu_width'] != NULL ) ? $smof_data['dropdown_menu_width']: $options['dropdown_menu_width'];
			$vars['main-nav-highlight-border'] = ( $smof_data['nav_highlight_border'] != NULL ) ? $smof_data['nav_highlight_border'] : $options['nav_highlight_border'];
			$vars['site-header-width'] = ( $smof_data['side_header_width'] != NULL ) ? $smof_data['side_header_width'] : $options['side_header_width'];
			$vars['megamenu-shadow'] = $smof_data['megamenu_shadow'];
			$vars['secondary-menu-dropdown-width'] = ( $smof_data['topmenu_dropwdown_width'] != NULL ) ? $smof_data['topmenu_dropwdown_width'] : $options['topmenu_dropwdown_width'];
			if( $smof_data['header_sticky_nav_padding'] ) {
				$vars['sticky-header-nav-padding'] = ( $smof_data['header_sticky_nav_padding'] != NULL ) ? $smof_data['header_sticky_nav_padding'] : $options['header_sticky_nav_padding'];
			} else {
				$vars['sticky-header-nav-padding'] = ( $smof_data['nav_padding'] != NULL ) ? $smof_data['nav_padding'] : $options['nav_padding'];
			}
			$vars['mobile-menu-icons-top-margin'] = ( $smof_data['mobile_menu_icons_top_margin'] != NULL ) ? $smof_data['mobile_menu_icons_top_margin'] : $options['mobile_menu_icons_top_margin'];
			$vars['main-nav-icon-circle'] = $smof_data['main_nav_icon_circle'];
			$vars['header-social-links-size'] = ( $smof_data['header_social_links_font_size'] != NULL ) ? $smof_data['header_social_links_font_size'] : $options['header_social_links_font_size'];
			$vars['header-social-links-boxed-padding'] = ( $smof_data['header_social_links_boxed_padding'] != NULL ) ? $smof_data['header_social_links_boxed_padding'] : $options['header_social_links_boxed_padding'];
			$vars['main-nav-text-align'] = $smof_data['menu_text_align'];
			$vars['mobile-menu-nav-height'] = ( $smof_data['mobile_menu_nav_height'] != NULL ) ? $smof_data['mobile_menu_nav_height'] : $options['mobile_menu_nav_height'];
			$vars['mobile-menu-text-align'] = $smof_data['mobile_menu_text_align'];
			
			// Page Title Bar
			$vars['page-title-bar-height'] = ( $smof_data['page_title_height'] != NULL ) ? $smof_data['page_title_height'] : $options['page_title_height'];
			$vars['page-title-bar-100-width'] = $smof_data['page_title_100_width'];

			// Sliding Bar
			$vars['slidingbar-top-border'] = $smof_data['slidingbar_top_border'];
			$vars['slidingbar-bg-color'] = $smof_data['slidingbar_bg_color']['color'];
			$vars['slidingbar-opacity'] = $smof_data['slidingbar_bg_color']['opacity'];
			if( $vars['slidingbar-bg-color'] != '' ) {
				$rgba = fusion_hex2rgb( $vars['slidingbar-bg-color'] );

				$vars['slidingbar-bg-color'] = sprintf( 'rgba(%s,%s,%s, %s)', $rgba[0], $rgba[1], $rgba[2], $smof_data['slidingbar_bg_color']['opacity'] );
			}

			// Blog
			$vars['blog-grid-spacing-check'] = ( $smof_data['blog_grid_column_spacing'] || $smof_data['blog_grid_column_spacing'] === '0' );
			$vars['blog-grid-column-spacing'] = ( $smof_data['blog_grid_column_spacing'] != NULL ) ? $smof_data['blog_grid_column_spacing'] : $options['blog_grid_column_spacing'];
			
			//woocommerce
			$vars['woocommerce-product-tab-design'] = $smof_data['woocommerce_product_tab_design'];

			// Elastic Slider
			$vars['elasticslider-width'] = ( $smof_data['tfes_slider_width'] != NULL ) ? $smof_data['tfes_slider_width'] : $options['tfes_slider_width'];
			$vars['elasticslider-height'] = ( $smof_data['tfes_slider_height'] != NULL ) ? $smof_data['tfes_slider_height'] : $options['tfes_slider_height'];

			// Sidebar 
			$vars['sidebar-padding'] = $smof_data['sidebar_padding'];

			// Footer
			$vars['footer-bg-image'] = sprintf( '~"%s"', $smof_data['footerw_bg_image'] );
			$vars['footer-bg-repeat'] = $smof_data['footerw_bg_repeat'];
			$vars['footer-bg-position'] = $smof_data['footerw_bg_pos'];
			$vars['footer-bg-full'] = $smof_data['footerw_bg_full'];
			$vars['footer-parallax'] = ( $smof_data['footer_special_effects'] == 'footer_area_bg_parallax' || $smof_data['footer_special_effects'] == 'footer_sticky_with_parallax_bg_image' ) ? 1 : 0;
			$vars['footer-sticky-height'] = ( $smof_data['footer_sticky_height'] && ( $smof_data['footer_special_effects'] == 'footer_sticky' || $smof_data['footer_special_effects'] == 'footer_sticky_with_parallax_bg_image' ) ) ? $smof_data['footer_sticky_height'] : 0;
			$vars['footer-top-padding'] = ( $smof_data['footer_area_top_padding'] != NULL ) ? $smof_data['footer_area_top_padding'] : $options['footer_area_top_padding'];
			$vars['footer-bottom-padding'] = ( $smof_data['footer_area_bottom_padding'] != NULL ) ? $smof_data['footer_area_bottom_padding'] : $options['footer_area_bottom_padding'];
			$vars['footer-left-padding'] = ( $smof_data['footer_area_left_padding'] != NULL ) ? $smof_data['footer_area_left_padding'] : $options['footer_area_left_padding'];
			$vars['footer-right-padding'] = ( $smof_data['footer_area_right_padding'] != NULL ) ? $smof_data['footer_area_right_padding'] : $options['footer_area_right_padding'];
			$vars['copyright-top-padding'] = ( $smof_data['copyright_top_padding'] != NULL ) ? $smof_data['copyright_top_padding'] : $options['copyright_top_padding'];
			$vars['copyright-bottom-padding'] = ( $smof_data['copyright_bottom_padding'] != NULL ) ? $smof_data['copyright_bottom_padding'] : $options['copyright_bottom_padding'];
			$vars['footer-social-links-size'] = ( $smof_data['footer_social_links_font_size'] != NULL ) ? $smof_data['footer_social_links_font_size'] : $options['footer_social_links_font_size'];
			$vars['footer-social-links-boxed-padding'] = ( $smof_data['footer_social_links_boxed_padding'] != NULL ) ? $smof_data['footer_social_links_boxed_padding'] : $options['footer_social_links_boxed_padding'];
			$vars['footer-parallax-and-bg-image'] = ( $smof_data['footerw_bg_image'] && ( $smof_data['footer_special_effects'] == 'footer_parallax_effect' || $smof_data['footer_special_effects'] == 'footer_area_bg_parallax' || $smof_data['footer_special_effects'] == 'footer_sticky_with_parallax_bg_image' ) ) ? 1 : 0;
		}

		return $vars;
	}
}
