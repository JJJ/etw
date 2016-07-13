<?php

class Avada_Scripts {

    public $ID;
    public $theme_info;
    public $template_directory;
    public $main_js;

    public function __construct() {

        global $smof_data, $wp_styles, $woocommerce;

        // Early exit if we're on the dashboard if on the login/register pages.
        if ( is_admin() || in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
            return;
        }

        $this->ID           = $this->get_c_pageID();
        $this->theme_info         = wp_get_theme();
        $this->theme_uri = get_template_directory_uri();

        add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
        if ( $smof_data['dev_mode'] ) {
            add_action( 'wp_enqueue_scripts', array( $this, 'dev_scripts' ) );
        }

    }

    /**
     * Get the current object's ID.
     */
    public function get_c_pageID() {

        global $smof_data, $wp_styles, $woocommerce;

        $c_pageID = get_queried_object_id();

        if ( ( get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) && is_home()) || ( get_option( 'page_for_posts' ) && is_archive() && ! is_post_type_archive() ) ) {
            $c_pageID = get_option( 'page_for_posts' );
        } else {
            if ( class_exists( 'Woocommerce' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
                $c_pageID = get_option('woocommerce_shop_page_id');
            }
        }

        return $c_pageID;

    }

    public function scripts() {

        global $smof_data, $wp_styles, $woocommerce;

        // Add jQuery
        wp_enqueue_script( 'jquery', false, array(), $this->theme_info->get( 'Version' ), true );

        // Add the comment-reply script
        if ( is_singular() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        // Deregister the default novagallery modernizr script if it's installed separately
        if ( function_exists( 'novagallery_shortcode' ) ) {
            wp_deregister_script( 'novagallery_modernizr' );
        }

        // Deregister the modernizr script from the ccgallery plugin
        if ( function_exists( 'ccgallery_shortcode' ) ) {
            wp_deregister_script( 'ccgallery_modernizr' );
        }

        if ( ! $smof_data['status_gmap'] ) {
            $map_api = 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://maps.googleapis.com/maps/api/js?sensor=false&amp;language=' . substr( get_locale(), 0, 2 );
            wp_register_script( 'google-maps-api', $map_api, array(), $this->theme_info->get( 'Version' ), false );
            wp_register_script( 'google-maps-infobox', 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js', array(), $this->theme_info->get( 'Version' ), false );
        }

        if ( ! $smof_data['dev_mode'] ) {
            $this->main_js = $this->theme_uri . '/assets/js/main.min.js';
        }

		wp_deregister_script( 'avada' );
		wp_register_script( 'avada', $this->main_js, array(), $this->theme_info->get( 'Version' ), true );
		wp_enqueue_script( 'avada' );

        $smoothHeight = ( get_post_meta( $this->ID, 'pyre_fimg_width', true ) == 'auto' && get_post_meta( $this->ID, 'pyre_width', true ) == 'half' ) ? 'true' : 'false';

		if ( get_post_meta( $this->ID, 'pyre_fimg_width', true ) == 'auto' && get_post_meta($this->ID, 'pyre_width', true ) == 'half' ) {
            $flex_smoothHeight = 'true';
        } else {
            $flex_smoothHeight = ( $smof_data["slideshow_smooth_height"] ) ? 'true' : 'false';
        }

        $db_vars = $smof_data;

        $db_vars['slideshow_autoplay'] = ( ! $smof_data['slideshow_autoplay'] ) ? false : true;

        if ( ! $smof_data['slideshow_speed'] ) {
            $db_vars['slideshow_speed'] = 7000;
        }

        $language_code = ( defined( 'ICL_SITEPRESS_VERSION' ) && defined( 'ICL_LANGUAGE_CODE' ) ) ? ICL_LANGUAGE_CODE : '';

        $current_page_template = get_page_template_slug( $this->ID );
        $portfolio_image_size = avada_get_portfolio_image_size( $this->ID );

        $isotope_type = ( $portfolio_image_size == 'full' ) ? 'masonry' : 'fitRows';

        if ( is_archive() ) {
            $portfolio_layout_setting = strtolower( $smof_data['portfolio_archive_layout'] );
            $isotope_type = ( $smof_data['portfolio_featured_image_size'] == 'full' || strpos( $portfolio_layout_setting, 'grid' ) ) ? 'masonry' : 'fitRows';
        }

        $layout = ( get_post_meta( $this->ID, 'pyre_page_bg_layout', true ) == 'boxed' || get_post_meta($this->ID, 'pyre_page_bg_layout', true ) == 'wide' ) ? get_post_meta( $this->ID, 'pyre_page_bg_layout', true ) : $smof_data['layout'];

        $avada_rev_styles = ( get_post_meta( $this->ID, 'pyre_avada_rev_styles', true ) == 'no' || ( ! $smof_data['avada_rev_styles'] && get_post_meta( $this->ID, 'pyre_avada_rev_styles', true ) != 'yes' ) ) ? 1 : 0;

		$local_variables = array(
			'admin_ajax'					=> admin_url( 'admin-ajax.php' ),
			'admin_ajax_nonce'				=> wp_create_nonce( 'avada_admin_ajax' ),
			'protocol'						=> is_ssl(),
			'theme_url' 					=> get_template_directory_uri(),
			'dropdown_goto' 				=> __('Go to...', 'Avada'),
			'mobile_nav_cart' 				=> __('Shopping Cart', 'Avada'),
			'page_smoothHeight' 			=> $smoothHeight,
			'flex_smoothHeight' 			=> $flex_smoothHeight,
			'language_flag' 				=> $language_code,
			'infinite_blog_finished_msg' 	=> '<em>'.__('All posts displayed.', 'Avada').'</em>',
			'infinite_finished_msg'			=> '<em>'.__('All items displayed.', 'Avada').'</em>',
			'infinite_blog_text' 			=> '<em>'. __('Loading the next set of posts...', 'Avada').'</em>',
			'portfolio_loading_text' 		=> '<em>'. __('Loading Portfolio Items...', 'Avada').'</em>',
			'faqs_loading_text' 			=> '<em>'. __('Loading FAQ Items...', 'Avada').'</em>',
			'order_actions' 				=>  __( 'Details' , 'Avada'),
			'avada_rev_styles'				=> $avada_rev_styles,
			'avada_styles_dropdowns'		=> $smof_data['avada_styles_dropdowns'],
			'blog_grid_column_spacing'		=> $smof_data['blog_grid_column_spacing'],
			'blog_pagination_type'			=> $smof_data['blog_pagination_type'],
			'body_font_size'				=> $smof_data['body_font_size'],
			'custom_icon_image_retina'		=> $smof_data['custom_icon_image_retina'],
			'disable_mobile_animate_css'	=> $smof_data['disable_mobile_animate_css'],
			'portfolio_pagination_type'		=> $smof_data['grid_pagination_type'],
			'header_transparency'			=> ( ( ( $smof_data['header_bg_color']['opacity'] < 1 && ! get_post_meta( $this->ID, 'pyre_header_bg_opacity', true ) ) || ( get_post_meta( $this->ID, 'pyre_header_bg_opacity', true ) != '' && get_post_meta( $this->ID, 'pyre_header_bg_opacity', true ) < 1 ) ) ) ? 1 : 0,
			'header_padding_bottom'			=> $smof_data['margin_header_bottom'],
			'header_padding_top'			=> $smof_data['margin_header_top'],
			'header_position'				=> $smof_data['header_position'],
			'header_sticky'					=> $smof_data['header_sticky'],
			'header_sticky_tablet'			=> $smof_data['header_sticky_tablet'],
			'header_sticky_mobile'			=> $smof_data['header_sticky_mobile'],
			'header_sticky_type2_layout'	=> $smof_data['header_sticky_type2_layout'],
			'ipad_potrait'					=> $smof_data['ipad_potrait'],
			'is_responsive' 				=> $smof_data['responsive'],
			'isotope_type'					=> $isotope_type,
			'layout_mode'					=> strtolower( $layout ),
			'lightbox_animation_speed'		=> $smof_data['lightbox_animation_speed'],
			'lightbox_path'					=> $smof_data['lightbox_path'],
			'lightbox_arrows'				=> $smof_data['lightbox_arrows'],
			'lightbox_autoplay'				=> $smof_data['lightbox_autoplay'],
			'lightbox_desc'					=> $smof_data['lightbox_desc'],
			'lightbox_deeplinking'			=> $smof_data['lightbox_deeplinking'],
			'lightbox_gallery'				=> $smof_data['lightbox_gallery'],
			'lightbox_opacity'				=> $smof_data['lightbox_opacity'],
			'lightbox_post_images'			=> $smof_data['lightbox_post_images'],
			'lightbox_skin'					=> $smof_data['lightbox_skin'],
			'lightbox_slideshow_speed'		=> $smof_data['lightbox_slideshow_speed'],
			'lightbox_social'				=> $smof_data['lightbox_social'],
			'lightbox_title'				=> $smof_data['lightbox_title'],
			'logo_alignment'				=> $smof_data['logo_alignment'],
			'logo_margin_bottom'			=> $smof_data['margin_logo_bottom'],
			'logo_margin_top'				=> $smof_data['margin_logo_top'],
			'megamenu_max_width'			=> $smof_data['megamenu_max_width'],
			'mobile_menu_design'			=> $smof_data['mobile_menu_design'],
			'nav_height'					=> $smof_data['nav_height'],
			'nav_highlight_border'			=> $smof_data['nav_highlight_border'],
			'page_title_fading'				=> $smof_data['page_title_fading'],
			'pagination_video_slide'		=> $smof_data['pagination_video_slide'],
			'retina_icon_height'			=> $smof_data['retina_icon_height'],
			'retina_icon_width'				=> $smof_data['retina_icon_width'],
			'submenu_slideout'				=> $smof_data['mobile_nav_submenu_slideout'],
			'sidenav_behavior'				=> $smof_data['sidenav_behavior'],
			'site_width'					=> $smof_data['site_width'],
			'slider_position'				=> $smof_data['slider_position'],
			'slideshow_autoplay'			=> $smof_data['slideshow_autoplay'],
			'slideshow_speed'				=> $smof_data['slideshow_speed'],
			'smooth_scrolling'				=> $smof_data['smooth_scrolling'],
			'status_lightbox'				=> $smof_data['status_lightbox'],
			'status_totop_mobile'			=> $smof_data['status_totop_mobile'],
			'status_vimeo'					=> $smof_data['status_vimeo'],
			'status_yt'						=> $smof_data['status_yt'],
			'submenu_slideout' 				=> $smof_data['mobile_nav_submenu_slideout'],
			'testimonials_speed' 			=> $smof_data['testimonials_speed'],
			'tfes_animation' 				=> $smof_data['tfes_animation'],
			'tfes_autoplay' 				=> $smof_data['tfes_autoplay'],
			'tfes_interval' 				=> $smof_data['tfes_interval'],
			'tfes_speed' 					=> $smof_data['tfes_speed'],
			'tfes_width' 					=> $smof_data['tfes_width'],
			'typography_responsive'			=> $smof_data['typography_responsive'],
			'typography_sensitivity'		=> $smof_data['typography_sensitivity'],
			'typography_factor'				=> $smof_data['typography_factor'],
			'woocommerce_shop_page_columns'	=> $smof_data['woocommerce_shop_page_columns']
		);

		if ( class_exists( 'Woocommerce' ) && version_compare( $woocommerce->version, '2.3', '>=' ) ) {
            $local_variables['woocommerce_23'] = true;
        }

        $local_variables['side_header_width'] = ( $smof_data['header_position'] != 'Top' ) ? str_replace( 'px', '', $smof_data['side_header_width'] ) : '0';

		wp_localize_script( 'avada', 'js_local_vars', $local_variables );

		$header_demo = ( is_page( 'header-2' ) || is_page( 'header-3' ) || is_page( 'header-4' ) || is_page( 'header-5' ) ) ? true : false;

		if ( $smof_data['google_body'] && $smof_data['google_body'] != 'None' ) {
			$gfont[urlencode( $smof_data['google_body'] )] = '' . urlencode( $smof_data['google_body'] );
		}

		if ( $smof_data['google_nav'] && $smof_data['google_nav'] != 'None' && $smof_data['google_nav'] != $smof_data['google_body'] ) {
			$gfont[urlencode( $smof_data['google_nav'] )] = '' . urlencode( $smof_data['google_nav'] );
		}

		if( $smof_data['google_headings'] && $smof_data['google_headings'] != 'None' && $smof_data['google_headings'] != $smof_data['google_body'] && $smof_data['google_headings'] != $smof_data['google_nav'] ) {
			$gfont[urlencode( $smof_data['google_headings'] )] = '' . urlencode( $smof_data['google_headings'] );
		}

		if( $smof_data['google_footer_headings'] && $smof_data['google_footer_headings'] != 'None' && $smof_data['google_footer_headings'] != $smof_data['google_body'] && $smof_data['google_footer_headings'] != $smof_data['google_nav'] && $smof_data['google_footer_headings'] != $smof_data['google_headings'] ) {
			$gfont[urlencode( $smof_data['google_footer_headings'] )] = '' . urlencode( $smof_data['google_footer_headings'] );
		}

		if( $smof_data['google_footer_headings'] && $smof_data['google_footer_headings'] != 'None' && $smof_data['google_footer_headings'] != $smof_data['google_body'] && $smof_data['google_footer_headings'] != $smof_data['google_nav'] && $smof_data['google_footer_headings'] != $smof_data['google_headings'] ) {
			$gfont[urlencode( $smof_data['google_footer_headings'] )] = '' . urlencode( $smof_data['google_footer_headings'] );
		}

		if( $smof_data['google_button'] && $smof_data['google_button'] != 'None' && $smof_data['google_button'] != $smof_data['google_body'] && $smof_data['google_button'] != $smof_data['google_nav'] && $smof_data['google_button'] != $smof_data['google_headings'] && $smof_data['google_button'] != $smof_data['google_footer_headings'] ) {
			$gfont[urlencode( $smof_data['google_button'] )] = '' . urlencode( $smof_data['google_button'] );
		}

		if ( isset( $gfont ) && $gfont ) {
			$font_family = '';

			foreach( $gfont as $g_font ) {
				$font_family .= sprintf( '%s:%s|', $g_font, urlencode( $smof_data['gfont_settings'] ) );
			}

			wp_enqueue_style( 'avada-google-fonts', 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://fonts.googleapis.com/css?family=' . $font_family, array(), '' );

		}

		wp_enqueue_style( 'avada-stylesheet', get_stylesheet_uri(), array(), $this->theme_info->get( 'Version' ) );

		wp_enqueue_style( 'avada-dynamic', $this->theme_uri . '/assets/less/theme/dynamic.less', array(), $this->theme_info->get( 'Version' ) );

		wp_enqueue_style( 'avada-dynamic-IE', $this->theme_uri . '/assets/less/theme/dynamic.less', array(), $this->theme_info->get( 'Version' ) );
		$wp_styles->add_data( 'avada-dynamic-IE', 'conditional', 'lte IE 9' );

		wp_enqueue_style( 'avada-shortcodes', $this->theme_uri . '/shortcodes.css', array(), $this->theme_info->get( 'Version' ) );
		$wp_styles->add_data( 'avada-shortcodes', 'conditional', 'lte IE 9' );

		if ( ! $smof_data['status_fontawesome'] ) {
			wp_enqueue_style( 'fontawesome', $this->theme_uri . '/assets/fonts/fontawesome/font-awesome.css', array(), $this->theme_info->get( 'Version' ) );
			wp_enqueue_style( 'avada-IE-fontawesome', $this->theme_uri . '/assets/fonts/fontawesome/font-awesome.css', array(), $this->theme_info->get( 'Version' ) );
			$wp_styles->add_data( 'avada-IE-fontawesome', 'conditional', 'lte IE 9' );
		}

		wp_enqueue_style( 'avada-IE8', $this->theme_uri . '/assets/css/ie8.css', array(), $this->theme_info->get( 'Version' ) );
		$wp_styles->add_data( 'avada-IE8', 'conditional', 'lte IE 8' );

		wp_enqueue_style( 'avada-IE', $this->theme_uri . '/assets/css/ie.css', array(), $this->theme_info->get( 'Version' ) );
		$wp_styles->add_data( 'avada-IE', 'conditional', 'IE' );

		wp_deregister_style( 'woocommerce-layout' );
		wp_deregister_style( 'woocommerce-smallscreen' );
		wp_deregister_style( 'woocommerce-general' );

		if ( ! $smof_data['status_lightbox'] ) {
			wp_enqueue_style( 'avada-iLightbox', $this->theme_uri . '/ilightbox.css', array(), $this->theme_info->get( 'Version' ) );
		}

		if( ! $smof_data['use_animate_css'] ) {
			wp_enqueue_style( 'avada-animations', $this->theme_uri . '/animations.css', array(), $this->theme_info->get( 'Version' ) );
		}

		if ( ! $smof_data['status_lightbox'] && class_exists( 'Woocommerce' ) ) {
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		}

    }

    /**
     * Development mode scripts
     */
    public function dev_scripts() {

        global $smof_data, $wp_styles, $woocommerce;

        $this->main_js = $this->theme_uri . '/assets/js/theme.js';

        wp_deregister_script( 'bootstrap' );
        wp_register_script( 'bootstrap', $this->theme_uri . '/assets/js/bootstrap.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'bootstrap' );

        wp_deregister_script( 'cssua' );
        wp_register_script( 'cssua', $this->theme_uri . '/assets/js/cssua.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'cssua' );

        wp_deregister_script( 'easyPieChart' );
        wp_register_script( 'easyPieChart', $this->theme_uri . '/assets/js/easyPieChart.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'easyPieChart' );

        wp_deregister_script( 'excanvas' );
        wp_register_script( 'excanvas', $this->theme_uri . '/assets/js/excanvas.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'excanvas' );

        wp_deregister_script( 'Froogaloop' );
        wp_register_script( 'Froogaloop', $this->theme_uri . '/assets/js/Froogaloop.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'Froogaloop' );

        wp_deregister_script( 'imagesLoaded' );
        wp_register_script( 'imagesLoaded', $this->theme_uri . '/assets/js/imagesLoaded.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'imagesLoaded' );

        wp_deregister_script( 'jquery.infinitescroll' );
        wp_register_script( 'jquery.infinitescroll', $this->theme_uri . '/assets/js/jquery.infinitescroll.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.infinitescroll' );

        wp_deregister_script( 'isotope' );
        wp_register_script( 'isotope', $this->theme_uri . '/assets/js/isotope.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'isotope' );

        wp_deregister_script( 'jquery.appear' );
        wp_register_script( 'jquery.appear', $this->theme_uri . '/assets/js/jquery.appear.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.appear' );

        wp_deregister_script( 'jquery.touchSwipe' );
        wp_register_script( 'jquery.touchSwipe', $this->theme_uri . '/assets/js/jquery.touchSwipe.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.touchSwipe' );

        wp_deregister_script( 'jquery.carouFredSel' );
        wp_register_script( 'jquery.carouFredSel', $this->theme_uri . '/assets/js/jquery.carouFredSel.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.carouFredSel' );

        wp_deregister_script( 'jquery.countTo' );
        wp_register_script( 'jquery.countTo', $this->theme_uri . '/assets/js/jquery.countTo.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.countTo' );

        wp_deregister_script( 'jquery.cycle' );
        wp_register_script( 'jquery.cycle', $this->theme_uri . '/assets/js/jquery.cycle.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.cycle' );

        wp_deregister_script( 'jquery.easing' );
        wp_register_script( 'jquery.easing', $this->theme_uri . '/assets/js/jquery.easing.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.easing' );

        wp_deregister_script( 'jquery.elasticslider' );
        wp_register_script( 'jquery.elasticslider', $this->theme_uri . '/assets/js/jquery.elasticslider.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.elasticslider' );

        wp_deregister_script( 'jquery.fitvids' );
        wp_register_script( 'jquery.fitvids', $this->theme_uri . '/assets/js/jquery.fitvids.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.fitvids' );

        wp_deregister_script( 'jquery.flexslider' );
        wp_register_script( 'jquery.flexslider', $this->theme_uri . '/assets/js/jquery.flexslider.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.flexslider' );

        wp_deregister_script( 'jquery.fusion_maps' );
        wp_register_script( 'jquery.fusion_maps', $this->theme_uri . '/assets/js/jquery.fusion_maps.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.fusion_maps' );

        wp_deregister_script( 'jquery.hoverflow' );
        wp_register_script( 'jquery.hoverflow', $this->theme_uri . '/assets/js/jquery.hoverflow.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.hoverflow' );

        wp_deregister_script( 'jquery.hoverIntent' );
        wp_register_script( 'jquery.hoverIntent', $this->theme_uri . '/assets/js/jquery.hoverIntent.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.hoverIntent' );

        wp_deregister_script( 'jquery.placeholder' );
        wp_register_script( 'jquery.placeholder', $this->theme_uri . '/assets/js/jquery.placeholder.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.placeholder' );

        wp_deregister_script( 'jquery.toTop' );
        wp_register_script( 'jquery.toTop', $this->theme_uri . '/assets/js/jquery.toTop.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.toTop' );

        wp_deregister_script( 'jquery.waypoints' );
        wp_register_script( 'jquery.waypoints', $this->theme_uri . '/assets/js/jquery.waypoints.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.waypoints' );

        wp_deregister_script( 'modernizr' );
        wp_register_script( 'modernizr', $this->theme_uri . '/assets/js/modernizr.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'modernizr' );

        wp_deregister_script( 'jquery.requestAnimationFrame' );
        wp_register_script( 'jquery.requestAnimationFrame', $this->theme_uri . '/assets/js/jquery.requestAnimationFrame.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.requestAnimationFrame' );

        wp_deregister_script( 'jquery.mousewheel' );
        wp_register_script( 'jquery.mousewheel', $this->theme_uri . '/assets/js/jquery.mousewheel.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'jquery.mousewheel' );

        if ( ! $smof_data['status_lightbox'] ) {
            wp_deregister_script( 'ilightbox.packed' );
            wp_register_script( 'ilightbox.packed', $this->theme_uri . '/assets/js/ilightbox.js', array(), $this->theme_info->get( 'Version' ), true );
            wp_enqueue_script( 'ilightbox.packed' );
        }

        wp_deregister_script( 'avada-lightbox' );
        wp_register_script( 'avada-lightbox', $this->theme_uri . '/assets/js/avada-lightbox.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'avada-lightbox' );

        wp_deregister_script( 'avada-header' );
        wp_register_script( 'avada-header', $this->theme_uri . '/assets/js/avada-header.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'avada-header' );

        wp_deregister_script( 'avada-select' );
        wp_register_script( 'avada-select', $this->theme_uri . '/assets/js/avada-select.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'avada-select' );

        wp_deregister_script( 'avada-parallax' );
        wp_register_script( 'avada-parallax', $this->theme_uri . '/assets/js/avada-parallax.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'avada-parallax' );

        wp_deregister_script( 'avada-video-bg' );
        wp_register_script( 'avada-video-bg', $this->theme_uri . '/assets/js/avada-video-bg.js', array(), $this->theme_info->get( 'Version' ), true );
        wp_enqueue_script( 'avada-video-bg' );

        if ( class_exists( 'Woocommerce' ) ) {
            wp_dequeue_script('avada-woocommerce');
            wp_register_script( 'avada-woocommerce', $this->theme_uri . '/assets/js/avada-woocommerce.js' , array( 'jquery' ), $this->theme_info->get( 'Version' ), true );
            wp_enqueue_script( 'avada-woocommerce' );
        }
        if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
            wp_dequeue_script('avada-bbpress');
            wp_register_script( 'avada-bbpress', $this->theme_uri . '/assets/js/avada-bbpress.js' , array( 'jquery' ), $this->theme_info->get( 'Version' ), true );
            wp_enqueue_script( 'avada-bbpress' );
        }

        if ( ! $smof_data['smooth_scrolling'] ) {
            wp_dequeue_script('jquery.nicescroll');
            wp_register_script( 'jquery.nicescroll', $this->theme_uri . '/assets/js/jquery.nicescroll.js' , array( 'jquery' ), $this->theme_info->get( 'Version' ), true );
            wp_enqueue_script( 'jquery.nicescroll' );

            wp_dequeue_script('avada-nicescroll');
            wp_register_script( 'avada-nicescroll', $this->theme_uri . '/assets/js/avada-nicescroll.js' , array( 'jquery' ), $this->theme_info->get( 'Version' ), true );
            wp_enqueue_script( 'avada-nicescroll' );
        }

    }

}
