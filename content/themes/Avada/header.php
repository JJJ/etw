<!DOCTYPE html>
<?php global $smof_data, $woocommerce; ?>
<html class="<?php echo ( ! $smof_data['smooth_scrolling'] ) ? 'no-overflow-y' : ''; ?>" xmlns="http<?php echo (is_ssl())? 's' : ''; ?>://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<?php
	if( isset( $_SERVER['HTTP_USER_AGENT'] ) &&
		( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false )
	) {
		echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />';
	}
	?>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?php wp_title( '' ); ?></title>

	<!--[if lte IE 8]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
	<![endif]-->

	<?php
	if(is_page('header-2') && ( function_exists( 'is_buddypress' ) && ! is_buddypress() )) {
		$smof_data['header_right_content'] = 'Social Links';
		if($smof_data['scheme_type'] == 'Dark') {
			$smof_data['header_top_bg_color'] = '#29292a';
			$smof_data['snav_color'] = '#ffffff';
			$smof_data['header_top_first_border_color'] = '#3e3e3e';
		} else {
			$smof_data['header_top_bg_color'] = '#ffffff';
			$smof_data['snav_color'] = '#747474';
			$smof_data['header_top_first_border_color'] = '#efefef';
		}
	} elseif(is_page('header-3') && ( function_exists( 'is_buddypress' ) && ! is_buddypress() )) {
		$smof_data['header_right_content'] = 'Social Links';
		if($smof_data['scheme_type'] == 'Dark') {
			$smof_data['snav_color'] = '#747474';
			$smof_data['snav_color'] = '#bebdbd';
		} else {
			$smof_data['snav_color'] = '#ffffff';
			$smof_data['header_social_links_icon_color'] = '#ffffff';
		}
	} elseif(is_page('header-4') && ( function_exists( 'is_buddypress' ) && ! is_buddypress() )) {
		$smof_data['header_left_content'] = 'Social Links';
		if($smof_data['scheme_type'] == 'Dark') {
			$smof_data['snav_color'] = '#747474';
			$smof_data['snav_color'] = '#bebdbd';
		} else {
			$smof_data['snav_color'] = '#ffffff';
			$smof_data['header_social_links_icon_color'] = '#ffffff';
		}
		$smof_data['header_right_content'] = 'Navigation';
	} elseif(is_page('header-5') && ( function_exists( 'is_buddypress' ) && ! is_buddypress() )) {
		$smof_data['header_right_content'] = 'Social Links';
		if($smof_data['scheme_type'] == 'Dark') {
			$smof_data['snav_color'] = '#747474';
			$smof_data['snav_color'] = '#bebdbd';
		} else {
			$smof_data['snav_color'] = '#ffffff';
			$smof_data['header_social_links_icon_color'] = '#ffffff';
		}		
	}
	?>
	<?php $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
	if($smof_data['responsive']):
	if(!$isiPad || !$smof_data['ipad_potrait']):
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<?php endif; endif; ?>

	<?php if($smof_data['favicon']): ?>
	<link rel="shortcut icon" href="<?php echo $smof_data['favicon']; ?>" type="image/x-icon" />
	<?php endif; ?>

	<?php if($smof_data['iphone_icon']): ?>
	<!-- For iPhone -->
	<link rel="apple-touch-icon-precomposed" href="<?php echo $smof_data['iphone_icon']; ?>">
	<?php endif; ?>

	<?php if($smof_data['iphone_icon_retina']): ?>
	<!-- For iPhone 4 Retina display -->
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $smof_data['iphone_icon_retina']; ?>">
	<?php endif; ?>

	<?php if($smof_data['ipad_icon']): ?>
	<!-- For iPad -->
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $smof_data['ipad_icon']; ?>">
	<?php endif; ?>

	<?php if($smof_data['ipad_icon_retina']): ?>
	<!-- For iPad Retina display -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $smof_data['ipad_icon_retina']; ?>">
	<?php endif; ?>

	<?php wp_head(); ?>

	<?php
	$object_id = get_queried_object_id();
	if((get_option('show_on_front') && get_option('page_for_posts') && is_home()) ||
		(get_option('page_for_posts') && is_archive() && !is_post_type_archive()) && !(is_tax('product_cat') || is_tax('product_tag')) || (get_option('page_for_posts') && is_search())) {
		$c_pageID = get_option('page_for_posts');		
	} else {
		if(isset($object_id)) {
			$c_pageID = $object_id;
		}

		if(class_exists('Woocommerce')) {
			if(is_shop()) {
				$c_pageID = get_option('woocommerce_shop_page_id');
			}
		}

		if (  ! is_singular() ) {
			$c_pageID = false;
		}
	}
	?>

	<!--[if lte IE 8]>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	var imgs, i, w;
	var imgs = document.getElementsByTagName( 'img' );
	for( i = 0; i < imgs.length; i++ ) {
		w = imgs[i].getAttribute( 'width' );
		imgs[i].removeAttribute( 'width' );
		imgs[i].removeAttribute( 'height' );
	}
	});
	</script>
	
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/excanvas.js"></script>
	
	<![endif]-->
	
	<!--[if lte IE 9]>
	<script type="text/javascript">
	jQuery(document).ready(function() {
	
	// Combine inline styles for body tag
	jQuery('body').each( function() {	
		var combined_styles = '<style type="text/css">';

		jQuery( this ).find( 'style' ).each( function() {
			combined_styles += jQuery(this).html();
			jQuery(this).remove();
		});

		combined_styles += '</style>';

		jQuery( this ).prepend( combined_styles );
	});
	});
	</script>
	
	<![endif]-->	
	
	<script type="text/javascript">
	/*@cc_on
		@if (@_jscript_version == 10)
			document.write('<style type="text/css">.fusion-body .fusion-header-shadow:after{z-index: 99 !important;}.fusion-body.side-header #side-header.header-shadow:after{ z-index: 0 !important; }.search input,.searchform input {padding-left:10px;} .avada-select-parent .select-arrow,.select-arrow{height:33px;<?php if($smof_data['form_bg_color']): ?>background-color:<?php echo $smof_data['form_bg_color']; ?>;<?php endif; ?>}.search input{padding-left:5px;}header .tagline{margin-top:3px;}.star-rating span:before {letter-spacing: 0;}.avada-select-parent .select-arrow,.gravity-select-parent .select-arrow,.wpcf7-select-parent .select-arrow,.select-arrow{background: #fff;}.star-rating{width: 5.2em;}.star-rating span:before {letter-spacing: 0.1em;}</style>');
		@end
	@*/

	var doc = document.documentElement;
	doc.setAttribute('data-useragent', navigator.userAgent);
	</script>

	<style type="text/css">
	<?php
	ob_start();
	include_once get_template_directory() . '/includes/dynamic_css.php';
	$dynamic_css = ob_get_contents();
	ob_get_clean();
	echo fusion_compress_css( $dynamic_css );
	?>
	</style>
	
	<?php echo $smof_data['google_analytics']; ?>

	<?php echo $smof_data['space_head']; ?>
</head>
<?php
$body_classes = array();
$wrapper_class = '';

$body_classes[] = 'fusion-body';

if( is_page_template('blank.php') ) {
	$body_classes[] = 'body_blank';
	$wrapper_class = 'wrapper_blank';
}
if( ! $smof_data['header_sticky_tablet'] ) {
	$body_classes[] = 'no-tablet-sticky-header';
}
if( ! $smof_data['header_sticky_mobile'] ) {
	$body_classes[] = 'no-mobile-sticky-header';
}
if( $smof_data['mobile_slidingbar_widgets'] ) {
	$body_classes[] = 'no-mobile-slidingbar';
}
if( $smof_data['status_totop'] ) {
	$body_classes[] = 'no-totop';
}
if( ! $smof_data['status_totop_mobile'] ) {
	$body_classes[] = 'no-mobile-totop';
}
if( $smof_data['woocommerce_product_tab_design'] == 'horizontal' && is_singular( 'product' ) ) {
	$body_classes[] = 'woo-tabs-horizontal';
}
if( $smof_data['mobile_menu_design'] == 'modern' ) {
	$mobile_logo_pos = strtolower( $smof_data['logo_alignment'] );
	if( strtolower( $smof_data['logo_alignment'] ) == 'center' ) {
		$mobile_logo_pos = 'left';
	}
	$body_classes[] = 'mobile-logo-pos-' . $mobile_logo_pos;
}
if( ( $smof_data['layout'] == 'Boxed' && get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'default' ) || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'boxed' ) {
	$body_classes[] = 'layout-boxed-mode';
} else {
	$body_classes[] = 'layout-wide-mode';
}
$sidebar_1 = get_post_meta( $c_pageID, 'sbg_selected_sidebar_replacement', true );
$sidebar_2 = get_post_meta( $c_pageID, 'sbg_selected_sidebar_2_replacement', true );

if( is_single() && ! is_singular( 'avada_portfolio' ) && ! is_singular( 'product' ) && ! is_bbpress()  && ! is_buddypress() ) {
	if( $smof_data['posts_global_sidebar'] ) {
		if( $smof_data['posts_sidebar'] != 'None' ) {
			$sidebar_1 = array( $smof_data['posts_sidebar'] );
		} else {
			$sidebar_1 = '';
		}

		if( $smof_data['posts_sidebar_2'] != 'None' ) {
			$sidebar_2 = array( $smof_data['posts_sidebar_2'] );
		} else {
			$sidebar_2 = '';
		}
	}

	if( class_exists( 'TribeEvents' ) && tribe_is_event( $c_pageID ) && $smof_data['pages_global_sidebar'] ) {
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
} else if( is_singular( 'avada_portfolio' ) ) {
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
} else if( is_singular( 'product' ) || ( class_exists('Woocommerce') && is_shop() ) ) {
	if( $smof_data['woo_global_sidebar'] ) {
		if( $smof_data['woo_sidebar'] != 'None' ) {
			$sidebar_1 = array( $smof_data['woo_sidebar'] );
		} else {
			$sidebar_1 = '';
		}

		if( $smof_data['woo_sidebar_2'] != 'None' ) {
			$sidebar_2 = array( $smof_data['woo_sidebar_2'] );
		} else {
			$sidebar_2 = '';
		}
	}
} else if( ( is_page() || is_page_template() ) && ( ! is_page_template('100-width.php') && ! is_page_template('blank.php') ) ) {
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
}

if( is_array( $sidebar_1 ) && ! empty( $sidebar_1 ) && ( $sidebar_1[0] || $sidebar_1[0] == '0' ) && ! is_buddypress() && ! is_bbpress() && ! is_page_template('100-width.php') && ( ! class_exists('Woocommerce') || ( class_exists('Woocommerce') && ! is_cart() && ! is_checkout() && ! is_account_page() && ! ( get_option('woocommerce_thanks_page_id') && is_page( get_option( 'woocommerce_thanks_page_id') ) ) ) ) ) {
	$body_classes[] = 'has-sidebar';
}

if( is_array( $sidebar_1 ) && $sidebar_1[0] && is_array( $sidebar_2 ) && $sidebar_2[0] && ! is_buddypress() && ! is_bbpress() && ! is_page_template('100-width.php') && ( ! class_exists('Woocommerce') || ( class_exists('Woocommerce') && ! is_cart() && ! is_checkout() && ! is_account_page() && ! ( get_option('woocommerce_thanks_page_id') && is_page( get_option( 'woocommerce_thanks_page_id') ) ) ) ) ) {
	$body_classes[] = 'double-sidebars';
}

if( is_page_template( 'side-navigation.php' ) && is_array( $sidebar_2 ) && $sidebar_2[0] ) {
	$body_classes[] = 'double-sidebars';
}

if( is_home() ) {
	$sidebar_1 = $smof_data['blog_archive_sidebar'];
	$sidebar_2 = $smof_data['blog_archive_sidebar_2'];
	
	if( $sidebar_1 != 'None' ) {
		$body_classes[] = 'has-sidebar';
	}
	
	if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
		$body_classes[] = 'double-sidebars';
	}
}

if( is_archive() && ( ! is_buddypress() && ! is_bbpress() && ( class_exists('Woocommerce') && ! is_shop() ) || ! class_exists('Woocommerce') ) && ! is_tax( 'portfolio_category' ) && ! is_tax( 'portfolio_skills' )  && ! is_tax( 'portfolio_tags' ) && ! is_tax( 'product_cat') && ! is_tax( 'product_tag' ) ) {
	$sidebar_1 = $smof_data['blog_archive_sidebar'];
	$sidebar_2 = $smof_data['blog_archive_sidebar_2'];
	
	if( $sidebar_1 != 'None' ) {
		$body_classes[] = 'has-sidebar';
	}	
	
	if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
		$body_classes[] = 'double-sidebars';
	}
}

if( is_tax( 'portfolio_category' ) || is_tax( 'portfolio_skills' )  || is_tax( 'portfolio_tags' ) ) {
	$sidebar_1 = $smof_data['portfolio_archive_sidebar'];
	$sidebar_2 = $smof_data['portfolio_archive_sidebar_2'];
	
	if( $sidebar_1 != 'None' ) {
		$body_classes[] = 'has-sidebar';
	}	
	
	if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
		$body_classes[] = 'double-sidebars';
	}
}

if( is_tax( 'product_cat' )  || is_tax( 'product_tag' ) ) {
	$sidebar_1 = $smof_data['woocommerce_archive_sidebar'];
	$sidebar_2 = $smof_data['woocommerce_archive_sidebar_2'];
	
	if( $sidebar_1 != 'None' ) {
		$body_classes[] = 'has-sidebar';
	}
	
	if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
		$body_classes[] = 'double-sidebars';
	}
}

if( is_search() ) {
	$sidebar_1 = $smof_data['search_sidebar'];
	$sidebar_2 = $smof_data['search_sidebar_2'];
	
	if( $sidebar_1 != 'None' ) {
		$body_classes[] = 'has-sidebar';
	}	
	
	if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
		$body_classes[] = 'double-sidebars';
	}
}

if( ( is_bbpress() || is_buddypress() ) && ! bbp_is_forum_archive() && ! bbp_is_topic_archive() && ! bbp_is_user_home() && ! bbp_is_search() ) {
	$sidebar_1 = $smof_data['ppbress_sidebar'];
	$sidebar_2 = $smof_data['ppbress_sidebar_2'];

	$page_option_sidebar_1 = get_post_meta( $c_pageID, 'sbg_selected_sidebar_replacement', true );
	$page_option_sidebar_2 = get_post_meta( $c_pageID, 'sbg_selected_sidebar_2_replacement', true );

	if( $smof_data['bbpress_global_sidebar'] ) {
		$sidebar_1 = $smof_data['ppbress_sidebar'];
		$sidebar_2 = $smof_data['ppbress_sidebar_2'];
		
		if( $sidebar_1 != 'None' ) {
			$body_classes[] = 'has-sidebar';
		}		

		if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
			$body_classes[] = 'double-sidebars';
		}
	} else {
		$sidebar_1 = get_post_meta( $c_pageID, 'sbg_selected_sidebar_replacement', true );
		$sidebar_2 = get_post_meta( $c_pageID, 'sbg_selected_sidebar_2_replacement', true );
		
		if( is_array( $sidebar_1 ) && $sidebar_1[0] ) {
			$body_classes[] = 'has-sidebar';
		}
		
		if( is_array( $sidebar_1 ) && $sidebar_1[0] && is_array( $sidebar_2 ) && $sidebar_2[0] ) {
			$body_classes[] = 'double-sidebars';
		}
	}
}

if( ( is_bbpress() || is_buddypress() ) && ( bbp_is_forum_archive() || bbp_is_topic_archive() || bbp_is_user_home() || bbp_is_search() ) ) {
	$sidebar_1 = $smof_data['ppbress_sidebar'];
	$sidebar_2 = $smof_data['ppbress_sidebar_2'];
	
	if( $sidebar_1 != 'None' ) {
		$body_classes[] = 'has-sidebar';
	}		
	
	if( $sidebar_1 != 'None' && $sidebar_2 != 'None' ) {
		$body_classes[] = 'double-sidebars';
	}
}

if( class_exists( 'TribeEvents' ) && is_events_archive() ) {
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

	if( is_array( $sidebar_1 ) && $sidebar_1[0] && ! is_bbpress() && ! is_page_template('100-width.php') && ( ! class_exists('Woocommerce') || ( class_exists('Woocommerce') && ! is_cart() && ! is_checkout() && ! is_account_page() && ! ( get_option('woocommerce_thanks_page_id') && is_page( get_option( 'woocommerce_thanks_page_id') ) ) ) ) ) {
		$body_classes[] = 'has-sidebar';
	}

	if( is_array( $sidebar_1 ) && $sidebar_1[0] && is_array( $sidebar_2 ) && $sidebar_2[0] && ! is_bbpress() && ! is_page_template('100-width.php') && ( ! class_exists('Woocommerce') || ( class_exists('Woocommerce') && ! is_cart() && ! is_checkout() && ! is_account_page() && ! ( get_option('woocommerce_thanks_page_id') && is_page( get_option( 'woocommerce_thanks_page_id') ) ) ) ) ) {
		$body_classes[] = 'double-sidebars';
	}
}

if( get_post_meta( $c_pageID, 'pyre_display_header', true) != 'no' ) {
	if( $smof_data['header_position'] == 'Left' || $smof_data['header_position'] == 'Right' ) {
		$body_classes[] = 'side-header';
	}
	if( $smof_data['header_position'] == 'Left' ) {
		$body_classes[] = 'side-header-left';
	}
	if( $smof_data['header_position'] == 'Right' ) {
		$body_classes[] = 'side-header-right';
	}
}

$body_classes[] = 'mobile-menu-design-' . $smof_data['mobile_menu_design'];
?>
<body <?php body_class( $body_classes ); ?> data-spy="scroll">
	<?php $boxed_side_header_right = false; ?>
	<?php if( ( ( $smof_data['layout'] == 'Boxed' && ( get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'default' || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == '' ) ) || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'boxed' ) && $smof_data['header_position'] != 'Top' ): ?>
	<?php if( $smof_data['slidingbar_widgets'] && ! is_page_template( 'blank.php' ) && ( $smof_data['header_position'] == 'Right' || $smof_data['header_position'] == 'Left' ) ): ?>
	<?php get_template_part( 'slidingbar' ); ?>
	<?php $boxed_side_header_right = true; ?>
	<?php endif; ?>
	<div id="boxed-wrapper">
	<?php endif; ?>	
	<div id="wrapper" class="<?php echo $wrapper_class; ?>">
	<div id="home" style="position:relative;top:1px;"></div>
	<?php if( $smof_data['slidingbar_widgets'] && ! is_page_template( 'blank.php' ) && ! $boxed_side_header_right ): ?>
	<?php get_template_part( 'slidingbar' ); ?>
	<?php endif; ?>
	<?php
	if( strpos( $smof_data['footer_special_effects'], 'footer_sticky' ) !== FALSE ) {
		echo '<div class="above-footer-wrapper">';
	}	
	
	get_template_part( 'templates/header' );
	avada_header_template( 'Below' );
	if( $smof_data['header_position'] == 'Left' || $smof_data['header_position'] == 'Right' ) {
		avada_side_header();
	}
	?>
	<div id="sliders-container">
	<?php
	if( is_search() ) {
		$slider_page_id = '';
	}
	if( ! is_search() ) {
		// Layer Slider
		$slider_page_id = '';
		if ( ! is_home() && ! is_front_page() && ! is_archive() && isset( $object_id ) ) {
			$slider_page_id = $object_id;
		}
		if ( ! is_home() && is_front_page() && isset( $object_id ) ) {
			$slider_page_id = $object_id;
		}
		if ( is_home() && ! is_front_page() ) {
			$slider_page_id = get_option( 'page_for_posts' );
		}
		if ( class_exists( 'Woocommerce' ) ) {
			if ( is_shop() ) {
				$slider_page_id = get_option( 'woocommerce_shop_page_id' );
			}
		}
		avada_slider( $slider_page_id );
	}
	?>
	</div>
	<?php if(get_post_meta($slider_page_id, 'pyre_fallback', true)): ?>
		<div id="fallback-slide">
			<img src="<?php echo get_post_meta($slider_page_id, 'pyre_fallback', true); ?>" alt="" />
		</div>
	<?php endif; ?>
	<?php
		avada_header_template( 'Above' );

		if( has_action( 'avada_override_current_page_title_bar' ) ) {
			do_action( 'avada_override_current_page_title_bar', $c_pageID  );
		} else {		
			avada_current_page_title_bar( $c_pageID );
		}

	?>
	<?php if(is_page_template('contact.php') && $smof_data['recaptcha_public'] && $smof_data['recaptcha_private']): ?>
	<script type="text/javascript">
	 var RecaptchaOptions = {
		theme : '<?php echo $smof_data['recaptcha_color_scheme']; ?>'
	 };
 	</script>
 	<?php endif; ?>
	<?php if(is_page_template('contact.php') && $smof_data['gmap_address'] && !$smof_data['status_gmap']): ?>
	<?php
	if( ! $smof_data['map_popup'] ) {
		$map_popup = 'yes';
	} else {
		$map_popup = 'no';
	}
	if( ! $smof_data['map_scrollwheel'] ) {
		$map_scrollwheel = 'yes';
	} else {
		$map_scrollwheel = 'no';
	}
	if( ! $smof_data['map_scale'] ) {
		$map_scale = 'yes';
	} else {
		$map_scale = 'no';
	}
	if( ! $smof_data['map_zoomcontrol'] ) {
		$map_zoomcontrol = 'yes';
	} else {
		$map_zoomcontrol = 'no';
	}
	if( ! $smof_data['map_pin'] ) {
		$address_pin = 'yes';
	} else {
		$address_pin = 'no';
	}
	if ( $smof_data['gmap_pin_animation'] ) {
		$address_pin_animation = 'yes';
	} else {
		$address_pin_animation = 'no';
	}
	
	echo do_shortcode('[avada_map address="' . $smof_data['gmap_address'] . '" type="' . $smof_data['gmap_type'] . '" address_pin="' . $address_pin . '" animation="' .  $address_pin_animation . '" map_style="' . $smof_data['map_styling'] . '" overlay_color="' . $smof_data['map_overlay_color'] . '" infobox="' . $smof_data['map_infobox_styling'] . '" infobox_background_color="' . $smof_data['map_infobox_bg_color'] . '" infobox_text_color="' . $smof_data['map_infobox_text_color'] . '" infobox_content="' . htmlentities( $smof_data['map_infobox_content'] ) . '" icon="' . $smof_data['map_custom_marker_icon'] . '" width="' . $smof_data['gmap_width'] . '" height="' . $smof_data['gmap_height'] . '" zoom="' . $smof_data['map_zoom_level'] . '" scrollwheel="' . $map_scrollwheel . '" scale="' . $map_scale . '" zoom_pancontrol="' . $map_zoomcontrol . '" popup="' . $map_popup . '"][/avada_map]');
	?>
	<?php endif; ?>
	<?php if(is_page_template('contact-2.php') && $smof_data['gmap_address'] && !$smof_data['status_gmap']): ?>
	<?php
	if( $smof_data['map_popup'] ) {
		$map_popup = 'yes';
	} else {
		$map_popup = 'no';
	}
	if( ! $smof_data['map_scrollwheel'] ) {
		$map_scrollwheel = 'yes';
	} else {
		$map_scrollwheel = 'no';
	}
	if( ! $smof_data['map_scale'] ) {
		$map_scale = 'yes';
	} else {
		$map_scale = 'no';
	}
	if( ! $smof_data['map_zoomcontrol'] ) {
		$map_zoomcontrol = 'yes';
	} else {
		$map_zoomcontrol = 'no';
	}
	if ( $smof_data['gmap_pin_animation'] ) {
		$address_pin_animation = 'yes';
	} else {
		$address_pin_animation = 'no';
	}	
	echo do_shortcode('[avada_map address="' . $smof_data['gmap_address'] . '" type="' . $smof_data['gmap_type'] . '" map_style="' . $smof_data['map_styling'] . '" animation="' .  $address_pin_animation . '" overlay_color="' . $smof_data['map_overlay_color'] . '" infobox="' . $smof_data['map_infobox_styling'] . '" infobox_background_color="' . $smof_data['map_infobox_bg_color'] . '" infobox_text_color="' . $smof_data['map_infobox_text_color'] . '" infobox_content="' . $smof_data['map_infobox_content'] . '" icon="' . $smof_data['map_custom_marker_icon'] . '" width="' . $smof_data['gmap_width'] . '" height="' . $smof_data['gmap_height'] . '" zoom="' . $smof_data['map_zoom_level'] . '" scrollwheel="' . $map_scrollwheel . '" scale="' . $map_scale . '" zoom_pancontrol="' . $map_zoomcontrol . '" popup="' . $map_popup . '"][/avada_map]');
	?>
	<?php endif; ?>
	<?php
	$main_css = '';
	$row_css = '';
	$main_class = '';
	$page_template = '';

	if (is_woocommerce()) {
		$custom_fields = get_post_custom_values('_wp_page_template', $c_pageID);
		if(is_array($custom_fields) && !empty($custom_fields)) {
			$page_template = $custom_fields[0];
		} else {
			$page_template = '';
		}
	}

	if( is_page_template('100-width.php') || 
		is_page_template('blank.php') || 
		get_post_meta($slider_page_id, 'pyre_portfolio_width_100', true) == 'yes' || 
		( avada_is_portfolio_template() && get_post_meta($c_pageID, 'pyre_portfolio_width_100', true) == 'yes' ) || 
		$page_template == '100-width.php'
	) {
		$main_css = 'padding-left:0px;padding-right:0px;';
		if($smof_data['hundredp_padding'] && !get_post_meta($c_pageID, 'pyre_hundredp_padding', true)) {
			$main_css = 'padding-left:'.$smof_data['hundredp_padding'].';padding-right:'.$smof_data['hundredp_padding'];
		}
		if(get_post_meta($c_pageID, 'pyre_hundredp_padding', true)) {
			$main_css = 'padding-left:'.get_post_meta($c_pageID, 'pyre_hundredp_padding', true).';padding-right:'.get_post_meta($c_pageID, 'pyre_hundredp_padding', true);
		}
		$row_css = 'max-width:100%;';
		$main_class = 'width-100';
	}
	do_action('avada_before_main');
	?>
	<div id="main" class="clearfix <?php echo $main_class; ?>" style="<?php echo $main_css; ?>">
		<div class="fusion-row" style="<?php echo $row_css; ?>">