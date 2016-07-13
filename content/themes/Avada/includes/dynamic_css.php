<?php
global $smof_data;

if( strpos( $smof_data['site_width'], '%' ) === false && strpos( $smof_data['site_width'], 'px' ) === false ) {
	$smof_data['site_width'] = $smof_data['site_width'] . 'px';
}
$site_width = (int) $smof_data['site_width'];
$site_width_percent = false;
if( strpos( $smof_data['site_width'], '%' ) !== false ) {
	$site_width_percent = true;
}
?>
<?php	
$theme_info = wp_get_theme();
if ($theme_info->parent_theme) {
	$template_dir =  basename(get_template_directory());
	$theme_info = wp_get_theme($template_dir);
}
?>
<?php echo '.' . $theme_info->get( 'Name' ) . "_" . str_replace( '.', '', $theme_info->get( 'Version' ) ); ?>{color:green;}

<?php if( ( $isiPad && $smof_data['ipad_potrait'] ) || ! $smof_data['responsive'] ): ?>
.ua-mobile #wrapper{width: 100% !important; overflow: hidden !important;}
<?php endif; ?>
	
<?php
if ( $smof_data['header_position'] == 'Top' ) {
  $side_header_width = 0;
} else {
  $side_header_width = intval( $smof_data['side_header_width'] );
}
?>

<?php if( $smof_data['less_compiler'] == false ): ?>

<?php if( class_exists( 'Woocommerce' ) ): // is_woo ?>

<?php if( $smof_data['woocommerce_product_tab_design'] == 'horizontal' ): ?>
.woocommerce-tabs > .tabs {
  width: 100%;
  margin: 0px;
  border-bottom: 1px solid #dddddd;
}
.woocommerce-tabs > .tabs li {
  float: left;
}
.woocommerce-tabs > .tabs li a {
  border: none !important;
  padding: 10px 20px;
}
.woocommerce-tabs > .tabs .active {
  border: 1px solid #dddddd;
  height: 40px;
}
.woocommerce-tabs > .tabs .active:hover a {
  cursor: default;
}
.woocommerce-tabs .entry-content {
  float: left;
  margin: 0px;
  width: 100%;
  border-top: none;
}
@media all and (max-width: 965px) {
  .tabs {
    margin-bottom: 0px !important;
  }
  #wrapper .woocommerce-tabs .tabs,
  #wrapper .woocommerce-tabs .panel {
    float: left !important;
  }
}
@media all and (max-width: 470px) {
  .woocommerce-tabs > .tabs li {
    float: left;
    width: 100%;
    margin-bottom: 2px;
    border-bottom: 1px solid #dddddd;
    border-left: none !important;
    border-right: none !important;
    border-top: none !important;
  }
  .woocommerce-tabs > .tabs .active {
    height: auto;
  }
  .woocommerce-tabs .entry-content {
    float: left;
    width: 100%;
    margin-top: 20px !important;
    border-top: 1px solid #dddddd;
  }
  .woocommerce-tabs > .tabs {
    border-bottom: none;
  }
}
<?php endif; ?>

<?php if( $smof_data['timeline_bg_color'] != '' && $smof_data['timeline_bg_color'] != 'transparent' ): ?>
.products .product-list-view {
  padding-left: 20px;
  padding-right: 20px;
}
<?php endif; ?>

<?php endif; ?>

<?php if ( ! $smof_data['smooth_scrolling'] ): ?>
	@media only screen and ( min-width: 800px  ) {
		.no-overflow-y body{padding-right: 9px;}
		.no-overflow-y #slidingbar-area{right: 9px;}
	}
<?php endif; ?>

html, body, html body.custom-background, .woocommerce-tabs > .tabs .active a { background-color: <?php echo $smof_data['content_bg_color']; ?>; }


<?php if ( $smof_data['layout'] == 'Wide' ): ?>
	html, body, html body.custom-background, .woocommerce-tabs > .tabs .active a { background-color: <?php echo $smof_data['content_bg_color']; ?>; }
<?php endif; ?>

<?php if ( $smof_data['layout'] == 'Boxed' ): ?>
	html, body, html body.custom-background, .woocommerce-tabs > .tabs .active a { background-color: <?php echo $smof_data['bg_color']; ?>; }
<?php endif; ?>

<?php if ( ! $site_width_percent ): ?>
	.fusion-secondary-header, .sticky-header .sticky-shadow, .tfs-slider .slide-content, .header-v4 #small-nav, .header-v5 #small-nav, .fusion-footer-copyright-area, .fusion-footer-widget-area, #slidingbar, .fusion-page-title-bar{ padding-left: 30px; padding-right: 30px; }		
	#main { padding-left: 30px; padding-right: 30px; }

	<?php if ( $smof_data['responsive'] ): ?>
		@media only screen and (max-width: 800px ) {
			.fusion-mobile-menu-design-modern .fusion-secondary-header { padding-left: 0 !important; padding-right: 0 !important; }
			#side-header{width:auto;}
		}
	<?php endif; ?>

	@media only screen and (max-width: <?php echo $smof_data['site_width']; ?>) {
		.width-100#main { padding-left: 30px !important; padding-right: 30px !important; }
		.width-100 .fullwidth-box, .width-100 .fusion-section-separator {
			padding-left: 30px !important;
			padding-right: 30px !important;
		}
		.width-100 .fullwidth-box, .width-100 .fusion-section-separator {
			margin-left: -30px !important;
			margin-right: -30px !important;
		}
	}
<?php endif; ?>

.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li a { padding-left: 30px; padding-right: 30px; }

.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li a {
  padding-left: 30px;
  padding-right: 30px;
}
.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item .fusion-open-submenu {
  padding-right: 35px;
}
.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item a {
  padding-left: 30px;
  padding-right: 30px;
}
.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item li a {
  padding-left: 42px;
}
.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item li li a {
  padding-left: 55px;
}
.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item li li li a {
  padding-left: 68px;
}
.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item li li li li a {
  padding-left: 81px;
}
.rtl .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item .fusion-open-submenu {
  padding-left: 30px;
  padding-right: 15px;
}
.rtl .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item a {
  padding-left: 30px;
  padding-right: 30px;
}
.rtl .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item li a {
  padding-left: 0;
  padding-right: 42px;
}
.rtl .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item li li a {
  padding-left: 0;
  padding-right: 55px;
}
.rtl .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item li li li a {
  padding-left: 0;
  padding-right: 68px;
}
.rtl .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder .fusion-mobile-nav-item li li li li a {
  padding-left: 0;
  padding-left: 81px;
}


<?php if ( $smof_data['responsive'] ): ?>
	@media only screen and (min-width: <?php echo ( 850 + (int) $smof_data['side_header_width'] ) . 'px'; ?> ) and (max-width: <?php echo ( 930 + (int) $smof_data['side_header_width'] ) . 'px'; ?> ) {
		.grid-layout-6 .fusion-post-grid,
		.fusion-portfolio-six .fusion-portfolio-post {
			width: 20% !important;
		}

		.grid-layout-5 .fusion-post-grid,
		.fusion-portfolio-five .fusion-portfolio-post {
			width: 25% !important;
		}
	}

	@media only screen and (min-width: 800px ) and (max-width: <?php echo ( 850 + (int) $smof_data['side_header_width'] ) . 'px'; ?> ) {
		.grid-layout-6 .fusion-post-grid,
		.fusion-portfolio-six .fusion-portfolio-post {
			width: 25% !important;
		}

		.grid-layout-5 .fusion-post-grid,
		.fusion-portfolio-five .fusion-portfolio-post {
			width: 33.3333333333% !important;
		}

		.grid-layout-4 .fusion-post-grid,
		.fusion-portfolio-four .fusion-portfolio-post {
			width: 33.3333333333% !important;
		}
	}

	@media only screen and (min-width: 700px ) and (max-width: 800px ) {
		.fusion-blog-layout-grid-6 .fusion-post-grid,
		.fusion-portfolio-six .fusion-portfolio-post {
			width: 33.3333333333% !important;
		}

		.fusion-blog-layout-grid-5 .fusion-post-grid,
		.fusion-blog-layout-grid-4 .fusion-post-grid,
		.fusion-blog-layout-grid-3 .fusion-post-grid,
		.fusion-portfolio-five .fusion-portfolio-post,
		.fusion-portfolio-four .fusion-portfolio-post,
		.fusion-portfolio-three .fusion-portfolio-post,
		.fusion-portfolio-masonry .fusion-portfolio-post {
			width: 50% !important;
		}
	}

	@media only screen and (min-width: 640px ) and ( max-width: 700px ) {
		.fusion-blog-layout-grid-6 .fusion-post-grid,
		.fusion-blog-layout-grid-5 .fusion-post-grid,
		.fusion-blog-layout-grid-4 .fusion-post-grid,
		.fusion-blog-layout-grid-3 .fusion-post-grid,
		.fusion-portfolio-six .fusion-portfolio-post,
		.fusion-portfolio-five .fusion-portfolio-post,
		.fusion-portfolio-four .fusion-portfolio-post,
		.fusion-portfolio-three .fusion-portfolio-post,
		.fusion-portfolio-masonry .fusion-portfolio-post {
			width: 50% !important;
		}
	}

	@media only screen and (max-width: 640px ) {
		.fusion-blog-layout-grid .fusion-post-grid,
		.fusion-portfolio-post {
			width: 100% !important;
		}			
	}
	@media only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait) {
		.fusion-blog-layout-grid-6 .fusion-post-grid,
		.fusion-portfolio-six .fusion-portfolio-post {
			width: 33.3333333333% !important;
		}

		.fusion-blog-layout-grid-5 .fusion-post-grid,
		.fusion-blog-layout-grid-4 .fusion-post-grid,
		.fusion-blog-layout-grid-3 .fusion-post-grid,
		.fusion-portfolio-five .fusion-portfolio-post,
		.fusion-portfolio-four .fusion-portfolio-post,
		.fusion-portfolio-three .fusion-portfolio-post,
		.fusion-portfolio-masonry .fusion-portfolio-post {
			width: 50% !important;
		}

		<?php if ( $smof_data['footerw_bg_image'] && ( $smof_data['footer_special_effects'] == 'footer_parallax_effect' || $smof_data['footer_special_effects'] == 'footer_area_bg_parallax' || $smof_data['footer_special_effects'] == 'footer_sticky_with_parallax_bg_image' ) ): ?>
			.fusion-body #wrapper{ background-color: transparent; }
		<?php endif; ?>
	}
	
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape){
		<?php if ( $smof_data['footerw_bg_image'] && ( $smof_data['footer_special_effects'] == 'footer_parallax_effect' || $smof_data['footer_special_effects'] == 'footer_area_bg_parallax' || $smof_data['footer_special_effects'] == 'footer_sticky_with_parallax_bg_image' ) ): ?>
			.fusion-body #wrapper{ background-color: transparent; }
		<?php endif; ?>
	}
<?php endif; ?>

a:hover, .tooltip-shortcode {
	color: <?php echo $smof_data['primary_color']; ?>;
}
.fusion-footer-widget-area ul li a:hover,
.fusion-footer-widget-area .fusion-tabs-widget .tab-holder .news-list li .post-holder a:hover,
.fusion-footer-widget-area .fusion-accordian .panel-title a:hover,
#slidingbar-area ul li a:hover,
#slidingbar-area .fusion-accordian .panel-title a:hover,
.fusion-filters .fusion-filter.fusion-active a,
.project-content .project-info .project-info-box a:hover,
#main .post h2 a:hover,
#main .about-author .title a:hover,
span.dropcap,.fusion-footer-widget-area a:hover,#slidingbar-area a:hover,.fusion-copyright-notice a:hover,
.sidebar .widget_categories li a:hover,
.sidebar .widget li a:hover,
.fusion-date-and-formats .fusion-format-box i,
h5.toggle:hover a,
.tooltip-shortcode,.content-box-percentage,
.fusion-popover,
.woocommerce .address .edit:hover:after,
.my_account_orders .order-actions a:hover:after,
.more a:hover:after,.fusion-read-more:hover:after,.pagination-prev:hover:before,.pagination-next:hover:after,.bbp-topic-pagination .prev:hover:before,.bbp-topic-pagination .next:hover:after,
.single-navigation a[rel=prev]:hover:before,.single-navigation a[rel=next]:hover:after,
.sidebar .widget_nav_menu li a:hover:before,.sidebar .widget_categories li a:hover:before,
.sidebar .widget .recentcomments:hover:before,.sidebar .widget_recent_entries li a:hover:before,
.sidebar .widget_archive li a:hover:before,.sidebar .widget_pages li a:hover:before,
.sidebar .widget_links li a:hover:before,.side-nav .arrow:hover:after,.woocommerce-tabs .tabs a:hover .arrow:after,
#wrapper .jtwt .jtwt_tweet a:hover,
.star-rating:before,.star-rating span:before,.price ins .amount, .avada-order-details .shop_table.order_details tfoot tr:last-child .amount,
.price > .amount,.woocommerce-pagination .prev:hover,.woocommerce-pagination .next:hover,.woocommerce-pagination .prev:hover:before,.woocommerce-pagination .next:hover:after,
.woocommerce-tabs .tabs li.active a,.woocommerce-tabs .tabs li.active a .arrow:after,
#wrapper .cart-checkout a:hover,#wrapper .cart-checkout a:hover:before,
.widget_shopping_cart_content .total .amount,.widget_layered_nav li a:hover:before,
.widget_product_categories li a:hover:before,.woocommerce-side-nav li.active a,.woocommerce-side-nav li.active a:after,.my_account_orders .order-number a,.shop_table .product-subtotal .amount,
.cart_totals .order-total .amount,.checkout .shop_table tfoot .order-total .amount,#final-order-details .mini-order-details tr:last-child .amount,.rtl .more a:hover:before,.rtl .fusion-read-more:hover:before,#wrapper .sidebar .current_page_item > a,#wrapper .sidebar .current-menu-item > a,#wrapper .sidebar .current_page_item > a:before,#wrapper .sidebar .current-menu-item > a:before,#wrapper .fusion-footer-widget-area .current_page_item > a,#wrapper .fusion-footer-widget-area .current-menu-item > a,#wrapper .fusion-footer-widget-area .current_page_item > a:before,#wrapper .fusion-footer-widget-area .current-menu-item > a:before,#wrapper #slidingbar-area .current_page_item > a,#wrapper #slidingbar-area .current-menu-item > a,#wrapper #slidingbar-area .current_page_item > a:before,#wrapper #slidingbar-area .current-menu-item > a:before,.side-nav ul > li.current_page_item > a,.side-nav li.current_page_ancestor > a,
.gform_wrapper span.ginput_total,.gform_wrapper span.ginput_product_price,.ginput_shipping_price,
.bbp-topics-front ul.super-sticky a:hover, .bbp-topics ul.super-sticky a:hover, .bbp-topics ul.sticky a:hover, .bbp-forum-content ul.sticky a:hover, .fusion-accordian .panel-title a:hover{
	color: <?php echo $smof_data['primary_color']; ?>;
}
.fusion-content-boxes .heading-link:hover h2 {
	color: <?php echo $smof_data['primary_color']; ?> !important;
}
.fusion-content-boxes .heading-link:hover .icon i.circle-yes, .fusion-accordian .panel-title a:hover .fa-fusion-box {
	background-color: <?php echo $smof_data['primary_color']; ?> !important;
	border-color: <?php echo $smof_data['primary_color']; ?> !important;
}

.sidebar .fusion-image-wrapper .fusion-rollover .fusion-rollover-content a:hover { color: #333333; }
.star-rating:before,.star-rating span:before {
	color: <?php echo $smof_data['primary_color']; ?>;
}
.tagcloud a:hover,#slidingbar-area .tagcloud a:hover,.fusion-footer-widget-area .tagcloud a:hover{ color: #FFFFFF; text-shadow: none; -moz-text-shadow: none; -webkit-text-shadow: none; }

.reading-box,
.fusion-filters .fusion-filter.fusion-active a,
#wrapper .fusion-tabs-widget .tab-holder .tabs li.active a,
#wrapper .post-content blockquote,
.progress-bar-content,
.pagination .current,
.bbp-topic-pagination .current,
.pagination a.inactive:hover,
.woocommerce-pagination .page-numbers.current,
.woocommerce-pagination .page-numbers:hover,
#nav ul li > a:hover,#sticky-nav ul li > a:hover,.woocommerce-pagination .current,
.tagcloud a:hover,
#bbpress-forums div.bbp-topic-tags a:hover,
#wrapper .fusion-tabs.classic .nav-tabs > li.active .tab-link:hover, #wrapper .fusion-tabs.classic .nav-tabs > li.active .tab-link:focus, #wrapper .fusion-tabs.classic .nav-tabs > li.active .tab-link,#wrapper .fusion-tabs.vertical-tabs.classic .nav-tabs > li.active .tab-link {
	border-color: <?php echo $smof_data['primary_color']; ?>;
}
#wrapper .side-nav li.current_page_item a{
	border-right-color: <?php echo $smof_data['primary_color']; ?>;
	border-left-color: <?php echo $smof_data['primary_color']; ?>;
}
.fusion-accordian .panel-title .active .fa-fusion-box,
ul.circle-yes li:before,
.circle-yes ul li:before,
.progress-bar-content,
.pagination .current,
.bbp-topic-pagination .current,
.fusion-date-and-formats .fusion-date-box,.table-2 table thead,
.onsale,.woocommerce-pagination .current,
.woocommerce .social-share li a:hover i,
.price_slider_wrapper .ui-slider .ui-slider-range,
.tagcloud a:hover,.cart-loading,
#toTop:hover,
#bbpress-forums div.bbp-topic-tags a:hover,
#wrapper .search-table .search-button input[type="submit"]:hover,
ul.arrow li:before,
p.demo_store,
.avada-myaccount-data .digital-downloads li:before, .avada-thank-you .order_details li:before,
.sidebar .widget_layered_nav li.chosen, .sidebar .widget_layered_nav_filters li.chosen {
	background-color: <?php echo $smof_data['primary_color']; ?>;
}
.woocommerce .social-share li a:hover i {
	border-color: <?php echo $smof_data['primary_color']; ?>;
}
.bbp-topics-front ul.super-sticky, .bbp-topics ul.super-sticky, .bbp-topics ul.sticky, .bbp-forum-content ul.sticky	{
	background-color: #ffffe8;
	opacity: 1;
}


<?php if($smof_data['slidingbar_widgets']): ?>

<?php if($smof_data['slidingbar_bg_color']):
$rgb = fusion_hex2rgb($smof_data['slidingbar_bg_color']['color']);
$rgba = sprintf( 'rgba(%s,%s,%s,%s)', $rgb[0], $rgb[1], $rgb[2], $smof_data['slidingbar_bg_color']['opacity'] );
?>
#slidingbar {
	background-color:<?php echo $smof_data['slidingbar_bg_color']['color']; ?>;
	background-color:<?php echo $rgba ?>;
}
.sb-toggle-wrapper {
	border-top-color:<?php echo $smof_data['slidingbar_bg_color']['color']; ?>;
	border-top-color:<?php echo $rgba ?>;
}
#wrapper #slidingbar-area .fusion-tabs-widget .tab-holder .tabs li {
	border-color: <?php echo $smof_data['slidingbar_bg_color']['color']; ?>;
	border-color: <?php echo $rgba ?>;
}
<?php if($smof_data['slidingbar_top_border']): ?>
#slidingbar-area {
	border-bottom: 3px solid <?php echo $smof_data['slidingbar_bg_color']['color']; ?>;
	border-bottom: 3px solid <?php echo $rgba ?>;
}
.fusion-header-wrapper { margin-top: 3px; }
.admin-bar p.demo_store { padding-top: 13px; }
<?php endif; ?>

<?php if( ( ( $smof_data['layout'] == 'Boxed' && get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'default' ) || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'boxed' ) && $smof_data['header_position'] != 'Top' ): ?>
.side-header-right #slidingbar-area, .side-header-left #slidingbar-area { top: auto; }
<?php endif; ?>

<?php endif; ?>

<?php endif; ?>

#main,#wrapper,
.fusion-separator .icon-wrapper, html, body, .bbp-arrow, .woocommerce-tabs > .tabs .active a { background-color: <?php echo $smof_data['content_bg_color']; ?>; }

.fusion-footer-widget-area{
	background-color: <?php echo $smof_data['footer_bg_color']; ?>;
}
#wrapper .fusion-footer-widget-area .fusion-tabs-widget .tab-holder .tabs li {
	border-color: <?php echo $smof_data['footer_bg_color']; ?>;
}

.fusion-footer-widget-area{
	border-color: <?php echo $smof_data['footer_border_color']; ?>;
}

.fusion-footer-copyright-area{
	background-color: <?php echo $smof_data['copyright_bg_color']; ?>;
}

.fusion-footer-copyright-area{
	border-color: <?php echo $smof_data['copyright_border_color']; ?>;
}

.sep-boxed-pricing .panel-heading{
	background-color: <?php echo $smof_data['pricing_box_color']; ?>;
	border-color: <?php echo $smof_data['pricing_box_color']; ?>;
}
.fusion-pricing-table .panel-body .price .integer-part, .fusion-pricing-table .panel-body .price .decimal-part,
.full-boxed-pricing.fusion-pricing-table .standout .panel-heading h3{
	color: <?php echo $smof_data['pricing_box_color']; ?>;
}

<?php
$image_rollover_opacity = ( $smof_data['image_gradient_top_color']['opacity'] ) ? $smof_data['image_gradient_top_color']['opacity'] : 1;
$image_rollover_gradient_top_color = $smof_data['image_gradient_top_color']['color'];
$image_rollover_gradient_bottom_color = $smof_data['image_gradient_bottom_color'];

if ( $image_rollover_gradient_top_color != '' ) {
	$image_rollover_gradient_top = fusion_hex2rgb( $image_rollover_gradient_top_color );
	$image_rollover_gradient_top_color = sprintf( 'rgba(%s,%s,%s, %s)', $image_rollover_gradient_top[0], $image_rollover_gradient_top[1], $image_rollover_gradient_top[2], $image_rollover_opacity );
}

if ( $image_rollover_gradient_bottom_color != '' ) {
	$image_rollover_gradient_bottom = fusion_hex2rgb( $image_rollover_gradient_bottom_color );
	$image_rollover_gradient_bottom_color = sprintf( 'rgba(%s,%s,%s, %s)', $image_rollover_gradient_bottom[0], $image_rollover_gradient_bottom[1], $image_rollover_gradient_bottom[2], $image_rollover_opacity );
}
?>
.fusion-image-wrapper .fusion-rollover{
	background-image: linear-gradient(top, <?php echo $image_rollover_gradient_top_color; ?> 0%, <?php echo $image_rollover_gradient_bottom_color; ?> 100%);
	background-image: -o-linear-gradient(top, <?php echo $image_rollover_gradient_top_color; ?> 0%, <?php echo $image_rollover_gradient_bottom_color; ?> 100%);
	background-image: -moz-linear-gradient(top, <?php echo $image_rollover_gradient_top_color; ?> 0%, <?php echo $image_rollover_gradient_bottom_color; ?> 100%);
	background-image: -webkit-linear-gradient(top, <?php echo $image_rollover_gradient_top_color; ?> 0%, <?php echo $image_rollover_gradient_bottom_color; ?> 100%);
	background-image: -ms-linear-gradient(top, <?php echo $image_rollover_gradient_top_color; ?> 0%, <?php echo $image_rollover_gradient_bottom_color; ?> 100%);

	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, <?php echo $image_rollover_gradient_top_color; ?>),
		color-stop(1, <?php echo $image_rollover_gradient_bottom_color; ?>)
	);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $smof_data['image_gradient_top_color']['color']; ?>', endColorstr='<?php echo $smof_data['image_gradient_bottom_color']; ?>'), progid: DXImageTransform.Microsoft.Alpha(Opacity=0);
}
.no-cssgradients .fusion-image-wrapper .fusion-rollover{
	background: <?php echo $smof_data['image_gradient_top_color']['color']; ?>;
}
.fusion-image-wrapper:hover .fusion-rollover {
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $smof_data['image_gradient_top_color']['color']; ?>', endColorstr='<?php echo $smof_data['image_gradient_bottom_color']; ?>'), progid: DXImageTransform.Microsoft.Alpha(Opacity=100);
}

<?php
	$button_gradient_top_color = ( ! $smof_data['button_gradient_top_color'] ) ? 'transparent' : $smof_data['button_gradient_top_color'];
	$button_gradient_bottom_color = ( ! $smof_data['button_gradient_bottom_color'] ) ? 'transparent' : $smof_data['button_gradient_bottom_color'];
	$button_accent_color = ( ! $smof_data['button_accent_color'] ) ? 'transparent' : $smof_data['button_accent_color'];
	$button_gradient_top_hover_color = ( ! $smof_data['button_gradient_top_color_hover'] ) ? 'transparent' : $smof_data['button_gradient_top_color_hover'];
	$button_gradient_bottom_hover_color = ( ! $smof_data['button_gradient_bottom_color_hover'] ) ? 'transparent' : $smof_data['button_gradient_bottom_color_hover'];
	$button_accent_hover_color = ( ! $smof_data['button_accent_hover_color'] ) ? 'transparent' : $smof_data['button_accent_hover_color'];
?>


.fusion-portfolio-one .fusion-button,
#main .comment-submit,
#reviews input#submit,
.comment-form input[type="submit"],
.wpcf7-form input[type="submit"],.wpcf7-submit,
.bbp-submit-wrapper .button,
.button-default,
.fusion-button-default,
.button.default,
.price_slider_amount button,
.gform_wrapper .gform_button,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
.woocommerce .shipping-calculator-form .button,
.woocommerce .checkout #place_order,
.woocommerce .checkout_coupon .button,
.woocommerce .login .button,
.woocommerce .register .button,
.woocommerce .avada-order-details .order-again .button,
.woocommerce .avada-order-details .order-again .button,
.woocommerce .lost_reset_password input[type=submit],
#bbp_user_edit_submit,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button]{
	background: <?php echo $button_gradient_top_color; ?>;
	color: <?php echo $button_accent_color; ?>;
	
	background-image: -webkit-gradient( linear, left bottom, left top, from( <?php echo $button_gradient_bottom_color; ?> ), to( <?php echo $button_gradient_top_color; ?> ) );
	background-image: -webkit-linear-gradient( bottom,<?php echo $button_gradient_bottom_color; ?>, <?php echo $button_gradient_top_color; ?> );
	background-image:	-moz-linear-gradient( bottom, <?php echo $button_gradient_bottom_color; ?>, <?php echo $button_gradient_top_color; ?> );
	background-image:	  -o-linear-gradient( bottom, <?php echo $button_gradient_bottom_color; ?>, <?php echo $button_gradient_top_color; ?> );
	background-image: linear-gradient( to top, <?php echo $button_gradient_bottom_color; ?>, <?php echo $button_gradient_top_color; ?> );	

	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $button_gradient_top_color; ?>', endColorstr='<?php echo $button_gradient_bottom_color; ?>');
	
	-webkit-transition: all .2s;
	-moz-transition: all .2s;
	-ms-transition: all .2s;	
	-o-transition: all .2s;
	transition: all .2s;	
}
.no-cssgradients .fusion-portfolio-one .fusion-button,
.no-cssgradients #main .comment-submit,
.no-cssgradients #reviews input#submit,
.no-cssgradients .comment-form input[type="submit"],
.no-cssgradients .wpcf7-form input[type="submit"],
.no-cssgradients .wpcf7-submit,
.no-cssgradients .bbp-submit-wrapper .button,
.no-cssgradients .button-default,
.no-cssgradients .fusion-button-default,
.no-cssgradients .button.default,
.no-cssgradients .price_slider_amount button,
.no-cssgradients .gform_wrapper .gform_button,
.no-cssgradients .woocommerce .single_add_to_cart_button,
.no-cssgradients .woocommerce button.button,
.no-cssgradients .woocommerce .shipping-calculator-form .button,
.no-cssgradients .woocommerce .checkout #place_order,
.no-cssgradients .woocommerce .checkout_coupon .button,
.no-cssgradients .woocommerce .login .button,
.no-cssgradients .woocommerce .register .button,
.no-cssgradients .woocommerce .avada-order-details .order-again .button
.no-cssgradients .woocommerce .lost_reset_password input[type=submit],
.no-cssgradients #bbp_user_edit_submit,
.no-cssgradients .ticket-selector-submit-btn[type=submit],
.no-cssgradients .gform_page_footer input[type=button]{
	background: <?php echo $button_gradient_top_color; ?>;
}
.fusion-portfolio-one .fusion-button:hover,
#main .comment-submit:hover,
#reviews input#submit:hover,
.comment-form input[type="submit"]:hover,
.wpcf7-form input[type="submit"]:hover,.wpcf7-submit:hover,
.bbp-submit-wrapper .button:hover,
.button-default:hover,
.fusion-button-default:hover,
.button.default:hover,
.price_slider_amount button:hover,
.gform_wrapper .gform_button:hover,
.woocommerce .single_add_to_cart_button:hover,
.woocommerce .shipping-calculator-form .button:hover,
.woocommerce .checkout #place_order:hover,
.woocommerce .checkout_coupon .button:hover,
.woocommerce .login .button:hover,
.woocommerce .register .button:hover,
.woocommerce .avada-order-details .order-again .button:hover,
.woocommerce .lost_reset_password input[type=submit]:hover,
#bbp_user_edit_submit:hover,
.ticket-selector-submit-btn[type=submit]:hover,
.gform_page_footer input[type=button]:hover{
	background: <?php echo $button_gradient_top_hover_color; ?>;
	color: <?php echo $button_accent_hover_color; ?>;
		
	background-image: -webkit-gradient( linear, left bottom, left top, from( <?php echo $button_gradient_bottom_hover_color; ?> ), to( <?php echo $button_gradient_top_hover_color; ?> ) );
	background-image: -webkit-linear-gradient( bottom, <?php echo $button_gradient_bottom_hover_color; ?>, <?php echo $button_gradient_top_hover_color; ?> );
	background-image:	-moz-linear-gradient( bottom, <?php echo $button_gradient_bottom_hover_color; ?>, <?php echo $button_gradient_top_hover_color; ?> );
	background-image:	  -o-linear-gradient( bottom, <?php echo $button_gradient_bottom_hover_color; ?>, <?php echo $button_gradient_top_hover_color; ?> );
	background-image: linear-gradient( to top, <?php echo $button_gradient_bottom_hover_color; ?>, <?php echo $button_gradient_top_hover_color; ?> );

	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $button_gradient_top_hover_color; ?>', endColorstr='<?php echo $button_gradient_bottom_hover_color; ?>');
}
.no-cssgradients .fusion-portfolio-one .fusion-button:hover,
.no-cssgradients #main .comment-submit:hover,
.no-cssgradients #reviews input#submit:hover,
.no-cssgradients .comment-form input[type="submit"]:hover,
.no-cssgradients .wpcf7-form input[type="submit"]:hover,
.no-cssgradients .wpcf7-submit:hover,
.no-cssgradients .bbp-submit-wrapper .button:hover,
.no-cssgradients .button-default:hover,
.no-cssgradients .fusion-button-default:hover,
.no-cssgradinets .button.default:hover,
.no-cssgradients .price_slider_amount button:hover,
.no-cssgradients .gform_wrapper .gform_button:hover,
.no-cssgradients .woocommerce .single_add_to_cart_button:hover
.no-cssgradients .woocommerce .shipping-calculator-form .button:hover,
.no-cssgradients .woocommerce .checkout #place_order:hover,
.no-cssgradients .woocommerce .checkout_coupon .button:hover,
.no-cssgradients .woocommerce .login .button:hover,
.no-cssgradients .woocommerce .register .button:hover,
.no-cssgradients .woocommerce .avada-order-details .order-again .button:hover,
.no-cssgradients .woocommerce .lost_reset_password input[type=submit]:hover,
.no-cssgradients #bbp_user_edit_submit:hover,
.no-cssgradients .ticket-selector-submit-btn[type=submit]:hover,
.no-cssgradients .gform_page_footer input[type=button]:hover{
	background: <?php echo $button_gradient_top_hover_color; ?>;
}

.fusion-image-wrapper .fusion-rollover .fusion-rollover-link, .fusion-image-wrapper .fusion-rollover .fusion-rollover-gallery { background-color: <?php echo $smof_data['image_rollover_text_color']; ?>; }
.fusion-rollover .fusion-rollover-content .fusion-rollover-title, 
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-title a, 
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-categories, 
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-categories a,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content a
{ color: <?php echo $smof_data['image_rollover_text_color']; ?>; }

.fusion-page-title-bar{border-color: <?php echo $smof_data['page_title_border_color']; ?>;}

<?php if ( $smof_data['page_title_border_color'] == 'transparent' ): ?>
	.fusion-page-title-bar{ border: none; }
<?php endif; ?>

<?php if ( $smof_data['footer_sticky_height'] && ( $smof_data['footer_special_effects'] == 'footer_sticky' || $smof_data['footer_special_effects'] == 'footer_sticky_with_parallax_bg_image' ) ): ?>
	@media only screen and (min-width: 640px) {
		html, 
		body,
		#boxed-wrapper,
		#wrapper {
			height: 100%;
		}
		.above-footer-wrapper {
			min-height: 100%;
			margin-bottom: <?php echo ( (int) $smof_data['footer_sticky_height'] * (-1) ) . 'px'; ?>;
		}

		.above-footer-wrapper:after {
				content: "";
				display: block;
				height: <?php echo $smof_data['footer_sticky_height']; ?>;
			}
		}

		.fusion-footer {
			height: <?php echo $smof_data['footer_sticky_height']; ?>;
		}
	}
	
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) {
		html, 
		body,
		#boxed-wrapper,
		#wrapper {
			height: auto;
		}
		
		.above-footer-wrapper {
			min-height: none;
			margin-bottom: 0;
		}
		
		.above-footer-wrapper:after {
			height: auto;
		}
		
		.fusion-footer {
			height: auto;
		}		
	}
	
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait) {
		html, 
		body,
		#boxed-wrapper,
		#wrapper {
			height: auto;
		}
		
		.above-footer-wrapper {
			min-height: none;
			margin-bottom: 0;
		}
		
		.above-footer-wrapper:after {
			height: auto;
		}
		
		.fusion-footer {
			height: auto;
		}				
	}
<?php endif; ?>

.fusion-footer-widget-area{
	<?php if ( $smof_data['footerw_bg_image'] ): ?>
		background-image: url(<?php echo $smof_data['footerw_bg_image']; ?>);
		background-repeat: <?php echo $smof_data['footerw_bg_repeat']; ?>;
		background-position: <?php echo $smof_data['footerw_bg_pos']; ?>;

		<?php if ( $smof_data['footerw_bg_full'] ): ?>
			background-attachment:scroll;
			background-position:center center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $smof_data['footer_special_effects'] == 'footer_area_bg_parallax' || $smof_data['footer_special_effects'] == 'footer_sticky_with_parallax_bg_image' ): ?>
		background-attachment: fixed;
		background-position:top center;
	<?php endif; ?>

	padding-top: <?php echo $smof_data['footer_area_top_padding']; ?>;
	padding-bottom: <?php echo $smof_data['footer_area_bottom_padding']; ?>;
}


.fusion-footer-widget-area > .fusion-row, .fusion-footer-copyright-area > .fusion-row {
	padding-left: <?php echo $smof_data['footer_area_left_padding']; ?>;
	padding-right: <?php echo $smof_data['footer_area_right_padding']; ?>;
}


<?php if ( $smof_data['footer_100_width'] ): ?>
	.layout-wide-mode .fusion-footer-widget-area > .fusion-row, .layout-wide-mode .fusion-footer-copyright-area > .fusion-row {
		max-width: 100% !important;
	}
<?php endif; ?>

.fusion-footer-copyright-area{
	padding-top: <?php echo $smof_data['copyright_top_padding']; ?>;
	padding-bottom: <?php echo $smof_data['copyright_bottom_padding']; ?>;
}


.fontawesome-icon.circle-yes{
	background-color: <?php echo $smof_data['icon_circle_color']; ?>;
}

.fontawesome-icon.circle-yes{
	border-color: <?php echo $smof_data['icon_border_color']; ?>;
}

.fontawesome-icon,
.fontawesome-icon.circle-yes,
.avada-myaccount-data .digital-downloads li:before,
.avada-myaccount-data .digital-downloads li:after,
.avada-thank-you .order_details li:before,
.avada-thank-you .order_details li:after,
.post-content .error-menu li:before,
.post-content .error-menu li:after{
	color: <?php echo $smof_data['icon_color']; ?>;
}

.fusion-title .title-sep,.product .product-border{
	border-color: <?php echo $smof_data['title_border_color']; ?>;
}

.review blockquote q,.post-content blockquote,.checkout .payment_methods .payment_box{
	background-color: <?php echo $smof_data['testimonial_bg_color']; ?>;
}
.fusion-testimonials .author:after{
	border-top-color: <?php echo $smof_data['testimonial_bg_color']; ?>;
}

.review blockquote q,.post-content blockquote{
	color: <?php echo $smof_data['testimonial_text_color']; ?>;
}


<?php 
	$is_custom_font = ( isset( $smof_data['custom_font_woff'] ) && $smof_data['custom_font_woff'] ) &&
		   			  ( isset( $smof_data['custom_font_ttf'] ) && $smof_data['custom_font_ttf'] ) &&
		   			  ( isset( $smof_data['custom_font_svg'] ) && $smof_data['custom_font_svg'] ) &&
		   			  ( isset( $smof_data['custom_font_eot'] ) && $smof_data['custom_font_eot'] );

	if ( $is_custom_font ): ?>
	@font-face {
		font-family: 'MuseoSlab500Regular';
		src: url(<?php echo $smof_data['custom_font_eot']; ?>);
		src:
			url('<?php echo $smof_data['custom_font_eot']; ?>?#iefix') format('eot'),
			url(<?php echo $smof_data['custom_font_woff']; ?>) format('woff'),
			url(<?php echo $smof_data['custom_font_ttf']; ?>) format('truetype'),
			url('<?php echo $smof_data['custom_font_svg']; ?>#MuseoSlab500Regular') format('svg');
		font-weight: 400;
		font-style: normal;
	}
<?php endif; ?>

<?php
	if ( $smof_data['google_body'] != 'None' ) {
		$font = sprintf( '\'%s\'', $smof_data['google_body'] ) . ', Arial, Helvetica, sans-serif';
	} elseif ( $smof_data['standard_body'] != 'Select Font' ) {
		$font = $smof_data['standard_body'];
	}
?>

body, #nav ul li ul li a, #sticky-nav ul li ul li a,
.more,
.avada-container h3,
.meta .fusion-date,
.review blockquote q,
.review blockquote div strong,
.project-content .project-info h4,
.post-content blockquote,
.fusion-load-more-button,
.ei-title h3,
.comment-form input[type="submit"],
.wpcf7-form input[type="submit"],
.gform_wrapper .gform_button,
.woocommerce-success-message .button,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
.woocommerce .shipping-calculator-form .button,
.woocommerce .checkout #place_order,
.woocommerce .checkout_coupon .button,
.woocommerce .login .button,
.woocommerce .register .button,
.fusion-page-title-bar h3,
.fusion-blog-shortcode .fusion-timeline-date,
#reviews #comments > h2,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-title,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-categories,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content a,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .price,
#wrapper #nav ul li ul li > a, #wrapper #sticky-nav ul li ul li > a,
#bbp_user_edit_submit,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button]{
	font-family: <?php echo $font; ?>;
	font-weight: <?php echo $smof_data['font_weight_body']; ?>;
}

<?php
	if ( $smof_data['google_nav'] != 'None' ) {
		$nav_font = sprintf( '\'%s\'', $smof_data['google_nav'] ) . ', Arial, Helvetica, sans-serif';
	} elseif ( $smof_data['standard_nav'] != 'Select Font' ) {
		$nav_font = $smof_data['standard_nav'];
	}

	if ( $is_custom_font ) {
		$nav_font =  '\'MuseoSlab500Regular\', Arial, Helvetica, sans-serif';
	}
?>

.avada-container h3,
.review blockquote div strong,
.fusion-footer-widget-area h3,
#slidingbar-area  h3,
.project-content .project-info h4,
.fusion-load-more-button,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
.woocommerce .shipping-calculator-form .button,
.woocommerce .checkout #place_order,
.woocommerce .checkout_coupon .button,
.woocommerce .login .button,
.woocommerce .register .button,
.woocommerce .avada-order-details .order-again .button,
.comment-form input[type="submit"],
.wpcf7-form input[type="submit"],
.gform_wrapper .gform_button,
#bbp_user_edit_submit,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button]{
	font-weight: bold;
}
.meta .fusion-date,
.review blockquote q,
.post-content blockquote{
	font-style: italic;
}

.side-nav li a{
	font-family: <?php echo $nav_font; ?>;
	font-weight: <?php echo $smof_data['font_weight_menu']; ?>;
}

<?php
	if ( ! $is_custom_font && $smof_data['google_headings'] != 'None' ) {
		$headings_font = sprintf( '\'%s\'', $smof_data['google_headings'] ) . ', Arial, Helvetica, sans-serif';
	} elseif ( ! $is_custom_font && $smof_data['standard_headings'] != 'Select Font' ) {
		$headings_font = $smof_data['standard_headings'];
	} else {
		$headings_font = FALSE;
	}
?>

<?php if ( $headings_font ): ?>
	#main .reading-box h2,
	#main h2,
	.fusion-page-title-bar h1,
	.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-title,
	.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-title a,
	#main .post h2,
	.sidebar .widget h3,
	#wrapper .fusion-tabs-widget .tab-holder .tabs li a,
	.share-box h4,
	.project-content h3,
	.fusion-author .fusion-author-title,
	.fusion-pricing-table .title-row,
	.fusion-pricing-table .pricing-row,
	.fusion-person .person-desc .person-author .person-author-wrapper,
	.fusion-accordian .panel-title,
	.fusion-accordian .panel-heading a,
	.fusion-tabs .nav-tabs  li .fusion-tab-heading,
	.fusion-carousel-title,
	.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6,
	.ei-title h2,
	table th,.project-content .project-info h4,
	.woocommerce-success-message .msg,.product-title, .cart-empty,
	.main-flex .slide-content h2, .main-flex .slide-content h3,
	.fusion-modal .modal-title, .popover .popover-title,
	.fusion-flip-box .flip-box-heading-back,
	.fusion-header-tagline{
		font-family: <?php echo $headings_font; ?>;
	}
<?php endif; ?>

#main .reading-box h2,
#main h2,
.fusion-page-title-bar h1,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-title,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-title a,
#main .post h2,
.sidebar .widget h3,
#wrapper .fusion-tabs-widget .tab-holder .tabs li a,
.share-box h4,
.project-content h3,
.fusion-author .fusion-author-title,
.fusion-pricing-table .title-row,
.fusion-pricing-table .pricing-row,
.fusion-person .person-desc .person-author .person-author-wrapper,
.fusion-accordian .panel-title,
.fusion-accordian .panel-heading a,
.fusion-tabs .nav-tabs  li .fusion-tab-heading,
.fusion-carousel-title,
.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6,
.ei-title h2,
table th,
.woocommerce-success-message .msg,.product-title, .cart-empty,
.main-flex .slide-content h2, .main-flex .slide-content h3,
.fusion-modal .modal-title, .popover .popover-title,
.fusion-flip-box .flip-box-heading-back,
.fusion-header-tagline{
	font-weight: <?php echo $smof_data['font_weight_headings']; ?>;
}

<?php
	if ( $smof_data['google_footer_headings'] != 'None' ) {
		$footer_headings_font = sprintf( '\'%s\'', $smof_data['google_footer_headings'] ) . ', Arial, Helvetica, sans-serif';
	} elseif ( $smof_data['standard_footer_headings'] != 'Select Font' ) {
		$footer_headings_font = $smof_data['standard_footer_headings'];
	}
?>
.fusion-footer-widget-area h3,#slidingbar-area h3{
	font-family: <?php echo $footer_headings_font; ?>;
	font-weight: <?php echo $smof_data['font_weight_footer_headings']; ?>;
}

body,.sidebar .slide-excerpt h2, .fusion-footer-widget-area .slide-excerpt h2,#slidingbar-area .slide-excerpt h2,
.jtwt .jtwt_tweet, .sidebar .jtwt .jtwt_tweet {
	font-size: <?php echo $smof_data['body_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['body_font_size'] * 1.5 ); ?>px;
}
.project-content .project-info h4,.gform_wrapper label,.gform_wrapper .gfield_description,
.fusion-footer-widget-area ul, #slidingbar-area ul, .fusion-tabs-widget .tab-holder .news-list li .post-holder a,
.fusion-tabs-widget .tab-holder .news-list li .post-holder .meta{
	font-size: <?php echo $smof_data['body_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['body_font_size'] * 1.5 ); ?>px;
}
.fusion-blog-layout-timeline .fusion-timeline-date { font-size: <?php echo $smof_data['body_font_size']; ?>; }
.counter-box-content, .fusion-alert,.fusion-progressbar .sr-only, .post-content blockquote, .review blockquote q{ font-size: <?php echo $smof_data['body_font_size']; ?>px; }

body,.sidebar .slide-excerpt h2, .fusion-footer-widget-area .slide-excerpt h2,#slidingbar-area .slide-excerpt h2,.post-content blockquote, .review blockquote q,
.project-content .project-info h4,.fusion-accordian .panel-body, #side-header .fusion-contact-info, #side-header .header-social .top-menu {
	line-height: <?php echo $smof_data['body_font_lh']; ?>px;
}

.fusion-page-title-bar .fusion-breadcrumbs,.fusion-page-title-bar .fusion-breadcrumbs li,.fusion-page-title-bar .fusion-breadcrumbs li a{font-size: <?php echo $smof_data['breadcrumbs_font_size']; ?>px;}

.side-nav li a{font-size: <?php echo $smof_data['side_nav_font_size']; ?>px;}

.sidebar .widget h3{font-size: <?php echo $smof_data['sidew_font_size']; ?>px;}

#slidingbar-area h3{font-size: <?php echo $smof_data['slidingbar_font_size']; ?>px; line-height: <?php echo $smof_data['slidingbar_font_size']; ?>px;}

.fusion-footer-widget-area h3{font-size: <?php echo $smof_data['footw_font_size']; ?>px; line-height: <?php echo $smof_data['footw_font_size']; ?>px;}

.fusion-copyright-notice{font-size: <?php echo $smof_data['copyright_font_size']; ?>px;}

#main .fusion-row, .fusion-footer-widget-area .fusion-row,#slidingbar-area .fusion-row, .fusion-footer-copyright-area .fusion-row, .fusion-page-title-row, .tfs-slider .slide-content-container .slide-content { max-width: <?php echo $smof_data['site_width']; ?>; }

<?php if ( ! $smof_data['responsive'] ): ?>

	<?php if ( $smof_data['header_position'] == 'Top' ): ?>
		html,body { overflow-x: hidden; }
	<?php else: ?>
		.ua-mobile #wrapper { width: auto !important; }
	<?php endif; ?>
	
	@media screen and (max-width: 800px ) {
		.fullwidth-box { background-attachment: scroll !important; }
		.no-mobile-totop .to-top-container {display: none;}
		.no-mobile-slidingbar #slidingbar-area{display:none;}
	}
	
	@media screen and (max-width: 782px ) {
		body.admin-bar #wrapper #slidingbar-area, .admin-bar p.demo_store {
			top: 46px;
		}
		body.body_blank.admin-bar {
			top: 45px;
		}
		html #wpadminbar {
			z-index: 99999 !important;
			position: fixed !important;
		}
	}
		
	@media only screen and (min-device-width: 320px) and (max-device-width: 640px){
		.fullwidth-box { background-attachment: scroll !important; }
		.no-mobile-totop .to-top-container {display: none;}
		.no-mobile-slidingbar #slidingbar-area{display:none;}	
	}

	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait){
		.fullwidth-box { background-attachment: scroll !important; }
	}
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape){
		.fullwidth-box { background-attachment: scroll !important; }
	}
<?php endif; ?>

.post-content h1{
	font-size: <?php echo $smof_data['h1_font_size']; ?>px;
	line-height: <?php echo $smof_data['h1_font_lh']; ?>px;
}

#wrapper .post-content h2,#wrapper .fusion-title h2,#wrapper #main .post-content .fusion-title h2,#wrapper .title h2,#wrapper #main .post-content .title h2,#wrapper  #main .post h2, #wrapper  #main .post h2, #wrapper .woocommerce .checkout h3, #main .fusion-portfolio h2, h2.entry-title {
	font-size: <?php echo $smof_data['h2_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['h2_font_lh'] * 1.5 ); ?>px;
}

#wrapper .post-content h2,#wrapper .fusion-title h2,#wrapper #main .post-content .fusion-title h2,#wrapper .title h2,#wrapper #main .post-content .title h2,#wrapper #main .post h2, #wrapper  .woocommerce .checkout h3, .cart-empty, #main .fusion-portfolio h2, h2.entry-title{
	line-height: <?php echo $smof_data['h2_font_lh']; ?>px;
}

.post-content h3,.project-content h3,.product-title{
	font-size:  <?php echo $smof_data['h3_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['h3_font_lh'] * 1.5 ); ?>px;
}
p.demo_store,.fusion-modal .modal-title { font-size: <?php echo $smof_data['h3_font_size']; ?>; }

.post-content h3,.project-content h3,.product-title{
	line-height:  <?php echo $smof_data['h3_font_lh']; ?>px;
}


.post-content h4, .fusion-portfolio-post .fusion-portfolio-content h4, 
.fusion-rollover .fusion-rollover-content .fusion-rollover-title,
.fusion-person .person-author-wrapper .person-name, .fusion-person .person-author-wrapper .person-title, .fusion-carousel-title
{
	font-size: <?php echo $smof_data['h4_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['h4_font_lh'] * 1.5 ); ?>px;
}
#wrapper .fusion-tabs-widget .tab-holder .tabs li a,.person-author-wrapper, #reviews #comments > h2,
.popover .popover-title,.fusion-flip-box .flip-box-heading-back{
	font-size: <?php echo $smof_data['h4_font_size']; ?>px;
}
.fusion-accordian .panel-title,.fusion-sharing-box h4,
.fusion-tabs .nav-tabs > li .fusion-tab-heading
{font-size: <?php echo $smof_data['h4_font_size']; ?>px;}

.post-content h4, .fusion-portfolio-post .fusion-portfolio-content h4, 
.fusion-rollover .fusion-rollover-content .fusion-rollover-title,
.fusion-person .person-author-wrapper .person-name, .fusion-person .person-author-wrapper .person-title, .fusion-carousel-title
{
	line-height: <?php echo $smof_data['h4_font_lh']; ?>px;
}

.post-content h5{
	font-size: <?php echo $smof_data['h5_font_size']; ?>px;
	line-height: <?php echo $smof_data['h5_font_lh']; ?>px;
}

.post-content h6{
	font-size: <?php echo $smof_data['h6_font_size']; ?>px;
	line-height: <?php echo $smof_data['h6_font_lh']; ?>px;
}

.ei-title h2{
	font-size: <?php echo $smof_data['es_title_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['es_title_font_size'] * 1.5 ); ?>px;
}

.ei-title h3{
	font-size: <?php echo $smof_data['es_caption_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['es_caption_font_size'] * 1.5 ); ?>px;
}

.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-categories,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-rollover-categories a,
.fusion-recent-posts .columns .column .meta,
.fusion-carousel-meta,
.fusion-single-line-meta
{
	font-size: <?php echo $smof_data['meta_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['meta_font_size'] * 1.5 ); ?>px;
}
.post .fusion-meta-info, .fusion-recent-posts .columns .column .meta, .post .single-line-meta, .fusion-carousel-meta { font-size: <?php echo $smof_data['meta_font_size']; ?>px; }

.fusion-image-wrapper .fusion-rollover .fusion-rollover-content .fusion-product-buttons a, .product-buttons a {
	font-size: <?php echo $smof_data['woo_icon_font_size']; ?>px;
	line-height: <?php echo round( $smof_data['woo_icon_font_size'] * 1.5 ); ?>px;
}

.pagination, .page-links, .woocommerce-pagination, .pagination .pagination-next, .woocommerce-pagination .next, .pagination .pagination-prev, .woocommerce-pagination .prev 
{ font-size: <?php echo $smof_data['pagination_font_size']; ?>px; }

body,.post .post-content,.post-content blockquote,#wrapper .fusion-tabs-widget .tab-holder .news-list li .post-holder .meta,.sidebar .jtwt,#wrapper .meta,.review blockquote div,.search input,.project-content .project-info h4,.title-row,.fusion-rollover .price .amount,
.quantity .qty,.quantity .minus,.quantity .plus,.fusion-blog-timeline-layout .fusion-timeline-date, #reviews #comments > h2,
.sidebar .widget_nav_menu li, .sidebar .widget_categories li, .sidebar .widget_product_categories li, .sidebar .widget_meta li, .sidebar .widget .recentcomments, .sidebar .widget_recent_entries li, .sidebar .widget_archive li, .sidebar .widget_pages li, .sidebar .widget_links li, .sidebar .widget_layered_nav li, .sidebar .widget_product_categories li
{color: <?php echo $smof_data['body_text_color']; ?>;}

.post-content h1,.title h1,.woocommerce-success-message .msg, .woocommerce-message, .fusion-post-content h1{
	color: <?php echo $smof_data['h1_color']; ?>;
}

#main .post h2,.post-content h2,.fusion-title h2,.title h2,.woocommerce-tabs h2,.search-page-search-form h2, .cart-empty, .woocommerce h2, .woocommerce .checkout h3, .fusion-post-content h2{
	color: <?php echo $smof_data['h2_color']; ?>;
}

.post-content h3,.sidebar .widget h3,.project-content h3,.fusion-title h3,.title h3,.person-author-wrapper span,.product-title, .fusion-post-content h3{
	color: <?php echo $smof_data['h3_color']; ?>;
}

.post-content h4,.project-content .project-info h4,.share-box h4,.fusion-title h4,.title h4,#wrapper .fusion-tabs-widget .tab-holder .tabs li a, .fusion-accordian .panel-title a, .fusion-carousel-title,
.fusion-tabs .nav-tabs > li .fusion-tab-heading, .fusion-post-content h4 {
	color: <?php echo $smof_data['h4_color']; ?>;
}

.post-content h5,.fusion-title h5,.title h5, .fusion-post-content h5{
	color: <?php echo $smof_data['h5_color']; ?>;
}

.post-content h6,.fusion-title h6,.title h6, .fusion-post-content h6{
	color: <?php echo $smof_data['h6_color']; ?>;
}

.fusion-page-title-bar h1, .fusion-page-title-bar h3{
	color: <?php echo $smof_data['page_title_color']; ?>;
}

.sep-boxed-pricing .panel-heading h3{
	color: <?php echo $smof_data['sep_pricing_box_heading_color']; ?>;
}

.full-boxed-pricing.fusion-pricing-table .panel-heading h3{
	color: <?php echo $smof_data['full_boxed_pricing_box_heading_color']; ?>;
}

body a,
body a:before,
body a:after,
.single-navigation a[rel="prev"]:before,
.single-navigation a[rel="next"]:after,
.project-content .project-info .project-info-box a,.sidebar .widget li a, .sidebar .widget .recentcomments, .sidebar .widget_categories li, #main .post h2 a, .about-author .title a,
.shop_attributes tr th,.fusion-rollover a,.fusion-woo-featured-products-slider .price .amount,z.my_account_orders thead tr th,.shop_table thead tr th,.cart_totals table th,.checkout .shop_table tfoot th,.checkout .payment_methods label,#final-order-details .mini-order-details th,#main .product .product_title,.shop_table.order_details tr th,
.widget_layered_nav li.chosen a, .widget_layered_nav li.chosen a:before,.widget_layered_nav_filters li.chosen a,.widget_layered_nav_filters li.chosen a:before,.fusion-load-more-button
{color: <?php echo $smof_data['link_color']; ?>;}

body #toTop:before {color:#fff;}

.fusion-page-title-bar .fusion-breadcrumbs,.fusion-page-title-bar .fusion-breadcrumbs,.fusion-page-title-bar .fusion-breadcrumbs a
{color: <?php echo $smof_data['breadcrumbs_text_color']; ?>;}

#slidingbar-area h3{color: <?php echo $smof_data['slidingbar_headings_color']; ?>;}

#slidingbar-area,#slidingbar-area .fusion-column,#slidingbar-area .jtwt,#slidingbar-area .jtwt .jtwt_tweet{color: <?php echo $smof_data['slidingbar_text_color']; ?>;}

#slidingbar-area a, #slidingbar-area .jtwt .jtwt_tweet a, #wrapper #slidingbar-area .fusion-tabs-widget .tab-holder .tabs li a, #slidingbar-area .fusion-accordian .panel-title a
{color:<?php echo $smof_data['slidingbar_link_color']; ?>;}

.sidebar .widget h3, .sidebar .widget .heading h3{color: <?php echo $smof_data['sidebar_heading_color']; ?>;}

.fusion-footer-widget-area h3, .fusion-footer-widget-column .product-title{color: <?php echo $smof_data['footer_headings_color']; ?>;}

.fusion-footer-widget-area,.fusion-footer-widget-area article.col,.fusion-footer-widget-area .jtwt,.fusion-footer-widget-area .jtwt .jtwt_tweet,.fusion-copyright-notice
{color: <?php echo $smof_data['footer_text_color']; ?>;}

.fusion-footer-widget-area a,.fusion-footer-widget-area .jtwt .jtwt_tweet a,#wrapper .fusion-footer-widget-area .fusion-tabs-widget .tab-holder .tabs li a,.fusion-footer-widget-area .fusion-tabs-widget .tab-holder .news-list li .post-holder a,.fusion-copyright-notice a,
.fusion-footer-widget-area .fusion-accordian .panel-title a{color: <?php echo $smof_data['footer_link_color']; ?>;}

.ei-title h2{color: <?php echo $smof_data['es_title_color']; ?>;}
.ei-title h3{color: <?php echo $smof_data['es_caption_color']; ?>;}

.sep-single,.sep-double,.sep-dashed,.sep-dotted,.search-page-search-form,
.ls-avada, .avada-skin-rev,.es-carousel-wrapper.fusion-carousel-small .es-carousel ul li img,.fusion-accordian .fusion-panel,.progress-bar,
#small-nav,.fusion-filters,.single-navigation,.project-content .project-info .project-info-box,
.post .fusion-meta-info,.fusion-blog-layout-grid .post .post-wrapper,.fusion-blog-layout-grid .post .fusion-content-sep, 
.fusion-portfolio .fusion-portfolio-boxed .fusion-portfolio-post-wrapper, .fusion-portfolio .fusion-portfolio-boxed .fusion-content-sep, .fusion-portfolio-one .fusion-portfolio-boxed .fusion-portfolio-post-wrapper,
.fusion-blog-layout-grid .post .flexslider,.fusion-layout-timeline .post,.fusion-layout-timeline .post .fusion-content-sep,
.fusion-layout-timeline .post .flexslider,.fusion-timeline-date,.fusion-timeline-arrow,
.fusion-counters-box .fusion-counter-box .counter-box-border, tr td,
.table, .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td,
.table-1 table,.table-1 table th,.table-1 tr td,.tkt-slctr-tbl-wrap-dv table,.tkt-slctr-tbl-wrap-dv tr td
.table-2 table thead,.table-2 tr td,
.sidebar .widget li a,.sidebar .widget .recentcomments,.sidebar .widget_categories li,
#wrapper .fusion-tabs-widget .tab-holder,.commentlist .the-comment,
.side-nav,#wrapper .side-nav li a,.rtl .side-nav,h5.toggle.active + .toggle-content,
#wrapper .side-nav li.current_page_item li a,.tabs-vertical .tabset,
.tabs-vertical .tabs-container .tab_content,
.fusion-tabs.vertical-tabs.clean .nav-tabs li .tab-link,
.pagination a.inactive, .page-links a,.woocommerce-pagination .page-numbers,.bbp-topic-pagination .page-numbers,.rtl .woocommerce .social-share li,.fusion-author .fusion-author-social,
.side-nav li a,.sidebar .product_list_widget li,.sidebar .widget_layered_nav li,.price_slider_wrapper,.tagcloud a,
.sidebar .widget_nav_menu li, .sidebar .widget_categories li, .sidebar .widget_product_categories li, .sidebar .widget_meta li, .sidebar .widget .recentcomments, .sidebar .widget_recent_entries li, .sidebar .widget_archive li, .sidebar .widget_pages li, .sidebar .widget_links li,.widget_layered_nav li,.widget_product_categories li,
#customer_login_box,.avada_myaccount_user,#wrapper .myaccount_user_container span,
.woo-tabs-horizontal .woocommerce-tabs > .tabs .active, .woo-tabs-horizontal .woocommerce-tabs > .tabs,
.woocommerce-side-nav li a,.woocommerce-content-box,.woocommerce-content-box h2,.my_account_orders tr,.woocommerce .address h4,.shop_table tr,.cart_totals .total,.chzn-container-single .chzn-single,.chzn-container-single .chzn-single div,.chzn-drop,.checkout .shop_table tfoot,.input-radio,p.order-info,.panel.entry-content,
.woocommerce-tabs .tabs li a,.woocommerce .social-share,.woocommerce .social-share li,.quantity,.quantity .minus, .quantity .qty,.shop_attributes tr,.woocommerce-success-message,#reviews li .comment-text,
.cart-totals-buttons,.cart_totals, .shipping_calculator, .coupon, .woocommerce .cross-sells, #customer_login .col-1, #customer_login .col-2, .woocommerce-message, .woocommerce .checkout #customer_details .col-1, .woocommerce .checkout #customer_details .col-2,
.cart_totals h2, .shipping_calculator h2, .coupon h2, .woocommerce .checkout h3, #customer_login h2, .woocommerce .cross-sells h2, .order-total, .woocommerce .addresses .title, #main .cart-empty, #main .return-to-shop, .side-nav-left .side-nav,
.avada-order-details .shop_table.order_details tfoot,
#final-order-details .mini-order-details tr:last-child
{border-color: <?php echo $smof_data['sep_color']; ?>;}

.price_slider_wrapper .ui-widget-content
{background-color: <?php echo $smof_data['sep_color']; ?>;}
.gform_wrapper .gsection{border-bottom:1px dotted <?php echo $smof_data['sep_color']; ?>;}

<?php
	$load_more_bg_color_rgb = fusion_hex2rgb( $smof_data['load_more_posts_button_bg_color'] );
	$load_more_posts_button_bg_color_hover = sprintf( 'rgba(%s,%s,%s,0.8)', $load_more_bg_color_rgb[0], $load_more_bg_color_rgb[1], $load_more_bg_color_rgb[2] );
?>
.fusion-load-more-button { background-color: <?php echo $smof_data['load_more_posts_button_bg_color']; ?>; }
.fusion-load-more-button:hover { background-color: <?php echo $load_more_posts_button_bg_color_hover; ?>; }


.quantity .minus,.quantity .plus{background-color: <?php echo $smof_data['qty_bg_color']; ?>;}
.quantity .minus:hover,.quantity .plus:hover{background-color: <?php echo $smof_data['qty_bg_hover_color']; ?>;}


.sb-toggle-wrapper .sb-toggle:after{ color: <?php echo $smof_data['slidingbar_toggle_icon_color']; ?>; }

#slidingbar-area .widget_categories li a, #slidingbar-area li.recentcomments, #slidingbar-area ul li a, #slidingbar-area .product_list_widget li, #slidingbar-area .widget_recent_entries ul li 
{border-bottom-color: <?php echo $smof_data['slidingbar_toggle_icon_color']; ?>;}

#slidingbar-area .tagcloud a, 
#wrapper #slidingbar-area .fusion-tabs-widget .tab-holder, 
#wrapper #slidingbar-area .fusion-tabs-widget .tab-holder .news-list li,
#slidingbar-area .fusion-accordian .fusion-panel
{border-color: <?php echo $smof_data['slidingbar_divider_color']; ?>;}

.fusion-footer-widget-area .widget_categories li a, .fusion-footer-widget-area li.recentcomments, .fusion-footer-widget-area ul li a, .fusion-footer-widget-area .product_list_widget li, 
.fusion-footer-widget-area .tagcloud a,
#wrapper .fusion-footer-widget-area .fusion-tabs-widget .tab-holder, 
#wrapper .fusion-footer-widget-area .fusion-tabs-widget .tab-holder .news-list li, 
.fusion-footer-widget-area .widget_recent_entries li,
.fusion-footer-widget-area .fusion-accordian .fusion-panel
{border-color: <?php echo $smof_data['footer_divider_color']; ?>;}

.input-text, input[type="text"], textarea,
input.s,#comment-input input,#comment-textarea textarea,.comment-form-comment textarea, .post-password-form .password,
.wpcf7-form .wpcf7-text,.wpcf7-form .wpcf7-quiz,.wpcf7-form .wpcf7-number,.wpcf7-form textarea,.wpcf7-form .wpcf7-select,.wpcf7-captchar,.wpcf7-form .wpcf7-date,
.gform_wrapper .gfield input[type=text],.gform_wrapper .gfield input[type=email],.gform_wrapper .gfield textarea,.gform_wrapper .gfield select,
#bbpress-forums .bbp-search-form #bbp_search,.bbp-reply-form input#bbp_topic_tags,.bbp-topic-form input#bbp_topic_title, .bbp-topic-form input#bbp_topic_tags, .bbp-topic-form select#bbp_stick_topic_select, .bbp-topic-form select#bbp_topic_status_select,#bbpress-forums div.bbp-the-content-wrapper textarea.bbp-the-content,.bbp-login-form input,
.main-nav-search-form input,.search-page-search-form input,.chzn-container-single .chzn-single,.chzn-container .chzn-drop,
.avada-select-parent select,.avada-select-parent .select-arrow, #wrapper .select-arrow,
.avada-select .select2-container .select2-choice, .avada-select .select2-container .select2-choice2,
select,
#lang_sel_click a.lang_sel_sel,
#lang_sel_click ul ul a, #lang_sel_click ul ul a:visited,
#lang_sel_click a, #lang_sel_click a:visited,#wrapper .search-table .search-field input{
background-color: <?php echo $smof_data['form_bg_color']; ?>;}

.input-text, input[type="text"], textarea,
input.s,input.s .placeholder,#comment-input input,#comment-textarea textarea,#comment-input .placeholder,#comment-textarea .placeholder,.comment-form-comment textarea, .post-password-form .password,
.wpcf7-form .wpcf7-text,.wpcf7-form .wpcf7-quiz,.wpcf7-form .wpcf7-number,.wpcf7-form textarea,.wpcf7-form .wpcf7-select,.wpcf7-select-parent .select-arrow,.wpcf7-captchar,.wpcf7-form .wpcf7-date,
.gform_wrapper .gfield input[type=text],.gform_wrapper .gfield input[type=email],.gform_wrapper .gfield textarea,.gform_wrapper .gfield select,
.avada-select .select2-container .select2-choice, .avada-select .select2-container .select2-choice2,
select,
#bbpress-forums .bbp-search-form #bbp_search,.bbp-reply-form input#bbp_topic_tags,.bbp-topic-form input#bbp_topic_title, .bbp-topic-form input#bbp_topic_tags, .bbp-topic-form select#bbp_stick_topic_select, .bbp-topic-form select#bbp_topic_status_select,#bbpress-forums div.bbp-the-content-wrapper textarea.bbp-the-content,.bbp-login-form input,
.main-nav-search-form input,.search-page-search-form input,.chzn-container-single .chzn-single,.chzn-container .chzn-drop,.avada-select-parent select, #wrapper .search-table .search-field input
{color: <?php echo $smof_data['form_text_color']; ?>;}
input#s::-webkit-input-placeholder,#comment-input input::-webkit-input-placeholder,.post-password-form .password::-webkit-input-placeholder,#comment-textarea textarea::-webkit-input-placeholder,.comment-form-comment textarea::-webkit-input-placeholder,.input-text::-webkit-input-placeholder
{color: <?php echo $smof_data['form_text_color']; ?>;}
input#s:-moz-placeholder,#comment-input input:-moz-placeholder,.post-password-form .password::-moz-input-placeholder,#comment-textarea textarea:-moz-placeholder,.comment-form-comment textarea:-moz-placeholder,.input-text:-moz-placeholder,
input#s:-ms-input-placeholder,#comment-input input:-ms-input-placeholder,.post-password-form .password::-ms-input-placeholder,#comment-textarea textarea:-moz-placeholder,.comment-form-comment textarea:-ms-input-placeholder,.input-text:-ms-input-placeholder
{color: <?php echo $smof_data['form_text_color']; ?>;}

.input-text, input[type="text"], textarea,
input.s,#comment-input input,#comment-textarea textarea,.comment-form-comment textarea, .post-password-form .password,
.wpcf7-form .wpcf7-text,.wpcf7-form .wpcf7-quiz,.wpcf7-form .wpcf7-number,.wpcf7-form textarea,.wpcf7-form .wpcf7-select,.wpcf7-select-parent .select-arrow,.wpcf7-captchar,.wpcf7-form .wpcf7-date,
.gform_wrapper .gfield input[type=text],.gform_wrapper .gfield input[type=email],.gform_wrapper .gfield textarea,.gform_wrapper .gfield_select[multiple=multiple],.gform_wrapper .gfield select,.gravity-select-parent .select-arrow,.select-arrow,
#bbpress-forums .quicktags-toolbar,#bbpress-forums .bbp-search-form #bbp_search,.bbp-reply-form input#bbp_topic_tags,.bbp-topic-form input#bbp_topic_title, .bbp-topic-form input#bbp_topic_tags, .bbp-topic-form select#bbp_stick_topic_select, .bbp-topic-form select#bbp_topic_status_select,#bbpress-forums div.bbp-the-content-wrapper textarea.bbp-the-content,#wp-bbp_topic_content-editor-container,#wp-bbp_reply_content-editor-container,.bbp-login-form input,
#bbpress-forums .wp-editor-container, #wp-bbp_topic_content-editor-container, #wp-bbp_reply_content-editor-container,
.main-nav-search-form input,.search-page-search-form input,.chzn-container-single .chzn-single,.chzn-container .chzn-drop,
.avada-select-parent select,.avada-select-parent .select-arrow,
select,
#lang_sel_click a.lang_sel_sel,
#lang_sel_click ul ul a, #lang_sel_click ul ul a:visited,
#lang_sel_click a, #lang_sel_click a:visited,
#wrapper .search-table .search-field input,
.avada-select .select2-container .select2-choice, .woocommerce-checkout .select2-drop-active, 
.avada-select .select2-container .select2-choice .select2-arrow, .avada-select .select2-container .select2-choice2 .select2-arrow
{border-color: <?php echo $smof_data['form_border_color']; ?>;}

.select-arrow, .select2-arrow {color: <?php echo $smof_data['form_border_color']; ?>;}


<?php if ( $smof_data['avada_styles_dropdowns'] ): ?>
	select {background-color: <?php echo $smof_data['form_border_color']; ?>; color: <?php echo $smof_data['form_text_color']; ?>; border: 1px solid <?php echo $smof_data['form_border_color']; ?> font-size: 13px; height: 35px; text-indent: 5px; width: 100%;}
	select::-webkit-input-placeholder{color:<?php echo $smof_data['form_text_color']; ?>;}
	select:-moz-placeholder{color:<?php echo $smof_data['form_text_color']; ?>;}
<?php endif; ?>


.fusion-page-title-bar h1 {
	font-size: <?php echo $smof_data['page_title_font_size']; ?>px;
	line-height: normal;
}

.fusion-page-title-bar h3 {
	font-size: <?php echo $smof_data['page_title_subheader_font_size']; ?>px;
	line-height: <?php echo $smof_data['page_title_subheader_font_size'] + 12; ?>px;
}

<?php if($smof_data['content_width']): 
if( strpos( $smof_data['content_width'], '%' ) ) {
	$content_width = str_replace( '%', '', $smof_data['content_width'] );
	$content_unit = '%';
	$margin = 6;
} elseif( strpos( $smof_data['content_width'], 'px' ) ) {
	$content_width = str_replace( 'px', '', $smof_data['content_width'] );
	$content_unit = 'px';
	$margin = 100;
} else {
	$content_width = $smof_data['content_width'];
	$content_unit = '%';
	$margin = 6;
}
?>
#content{
	width:<?php echo $content_width - $margin . $content_unit; ?>;
}
<?php endif; ?>

<?php if($smof_data['sidebar_width']): 
if( strpos( $smof_data['sidebar_width'], '%' ) ) {
	$sidebar_width = str_replace( '%', '', $smof_data['sidebar_width'] );
	$sidebar_unit = '%';
} elseif( strpos( $smof_data['sidebar_width'], 'px' ) ) {
	$sidebar_width = str_replace( 'px', '', $smof_data['sidebar_width'] );
	$sidebar_unit = 'px';
} else {
	$sidebar_width = $smof_data['sidebar_width'];
	$sidebar_unit = '%';
}
?>
#main .sidebar{
	width:<?php echo $sidebar_width . $sidebar_unit; ?>;
}
<?php endif; ?>

<?php if($smof_data['content_width_2'] && $smof_data['sidebar_2_1_width'] && $smof_data['sidebar_2_2_width'] ):
if( strpos( $smof_data['content_width_2'], '%' ) ) {
	$content_width_2 = str_replace( '%', '', $smof_data['content_width_2'] );
	$content_2_unit = '%';
	$margin = 6;
} elseif( strpos( $smof_data['content_width_2'], 'px' ) ) {
	$content_width_2 = str_replace( 'px', '', $smof_data['content_width_2'] );
	$content_2_unit = 'px';
	$margin = 100;
} else {
	$content_width_2 = $smof_data['content_width_2'];
	$content_2_unit = '%';
	$margin = 6;
}

if( strpos( $smof_data['sidebar_2_1_width'], '%' ) ) {
	$sidebar_2_1_width = str_replace( '%', '', $smof_data['sidebar_2_1_width'] );
	$sidebar_2_1_unit = '%';
} elseif( strpos( $smof_data['sidebar_2_1_width'], 'px' ) ) {
	$sidebar_2_1_width = str_replace( 'px', '', $smof_data['sidebar_2_1_width'] );
	$sidebar_2_1_unit = 'px';
} else {
	$sidebar_2_1_width = $smof_data['sidebar_2_1_width'];
	$sidebar_2_1_unit = '%';
}

if( strpos( $smof_data['sidebar_2_2_width'], '%' ) ) {
	$sidebar_2_2_width = str_replace( '%', '', $smof_data['sidebar_2_2_width'] );
	$sidebar_2_2_unit = '%';
} elseif( strpos( $smof_data['sidebar_2_2_width'], 'px' ) ) {
	$sidebar_2_2_width = str_replace( 'px', '', $smof_data['sidebar_2_2_width'] );
	$sidebar_2_2_unit = 'px';
} else {
	$sidebar_2_2_width = $smof_data['sidebar_2_1_width'];
	$sidebar_2_2_unit = '%';
}
endif; ?>

<?php if($smof_data['content_width_2']): ?>
.double-sidebars #content {
	width:<?php echo $content_width_2 - $margin . $content_2_unit; ?>;
	margin-left: <?php echo $sidebar_2_1_width + $margin / 2 . $content_2_unit; ?>;
}
<?php endif; ?>

<?php if($smof_data['sidebar_2_1_width']):
?>
.double-sidebars #main #sidebar{
	width:<?php echo $sidebar_2_1_width . $sidebar_2_1_unit; ?>;
	margin-left:-<?php echo $content_width_2 + $sidebar_2_1_width - $margin / 2 . $content_2_unit; ?>;
}
<?php endif; ?>
<?php if($smof_data['sidebar_2_2_width']): ?>
.double-sidebars #main #sidebar-2{
	width:<?php echo $sidebar_2_2_width . $sidebar_2_2_unit; ?>;
	margin-left: <?php echo $margin / 2 . $content_2_unit; ?>;
}
<?php endif; ?>

#main .sidebar{
	background-color: <?php echo $smof_data['sidebar_bg_color']; ?>;
	padding: <?php echo $smof_data['sidebar_padding']; ?>;
}

.fusion-accordian .panel-title a .fa-fusion-box{background-color: <?php echo $smof_data['accordian_inactive_color']; ?>;}

.progress-bar-content{background-color: <?php echo $smof_data['counter_filled_color']; ?>;border-color: <?php echo $smof_data['counter_filled_color']; ?>;}
.content-box-percentage{color: <?php echo $smof_data['counter_filled_color']; ?>;}

.progress-bar{background-color: <?php echo $smof_data['counter_unfilled_color']; ?>;border-color: <?php echo $smof_data['counter_unfilled_color']; ?>;}

#wrapper .fusion-date-and-formats .fusion-format-box{background-color: <?php echo $smof_data['dates_box_color']; ?>;}

.fusion-carousel .fusion-carousel-nav .fusion-nav-prev,
.fusion-carousel .fusion-carousel-nav .fusion-nav-next {
  background-color: <?php echo $smof_data['carousel_nav_color']; ?>;
}
.fusion-carousel .fusion-carousel-nav .fusion-nav-prev:hover,
.fusion-carousel .fusion-carousel-nav .fusion-nav-next:hover {
  background-color: <?php echo $smof_data['carousel_hover_color']; ?>;
}
.fusion-flexslider .flex-direction-nav .flex-prev,
.fusion-flexslider .flex-direction-nav .flex-next {
  background-color: <?php echo $smof_data['carousel_nav_color']; ?>;
}
.fusion-flexslider .flex-direction-nav .flex-prev:hover,
.fusion-flexslider .flex-direction-nav .flex-next:hover {
  background-color: <?php echo $smof_data['carousel_hover_color']; ?>;
}

.content-boxes .col{background-color: <?php echo $smof_data['content_box_bg_color']; ?>;}

#wrapper .sidebar .fusion-tabs-widget .tabs-container{background-color: <?php echo $smof_data['tabs_bg_color']; ?>;}
body .sidebar .fusion-tabs-widget .tab-hold .tabs li{border-right:1px solid <?php echo $smof_data['tabs_bg_color']; ?>;}
body.rtl #wrapper .sidebar .fusion-tabs-widget .tab-hold .tabset li{border-left-color: <?php echo $smof_data['tabs_bg_color']; ?>;}
body .sidebar .fusion-tabs-widget .tab-holder .tabs li a, .sidebar .fusion-tabs-widget .tab-holder .tabs li a{background: <?php echo $smof_data['tabs_inactive_color']; ?>;border-bottom:0;color: <?php echo $smof_data['body_text_color']; ?>;}
body .sidebar .fusion-tabs-widget .tab-hold .tabs li a:hover{background:<?php echo $smof_data['tabs_bg_color']; ?>;border-bottom:0;}
body .sidebar .fusion-tabs-widget .tab-hold .tabs li.active a, body .sidebar .fusion-tabs-widget .tab-holder .tabs li.active a{background:<?php echo $smof_data['tabs_bg_color']; ?>;border-bottom:0;}
body .sidebar .fusion-tabs-widget .tab-hold .tabs li.active a, body .sidebar .fusion-tabs-widget .tab-holder .tabs li.active a{border-top-color:<?php echo $smof_data['primary_color']; ?>;}

#wrapper .sidebar .fusion-tabs-widget .tab-holder,.sidebar .fusion-tabs-widget .tab-holder .news-list li{border-color: <?php echo $smof_data['tabs_border_color']; ?>;}

.fusion-sharing-box{background-color: <?php echo $smof_data['social_bg_color']; ?>;}

.fusion-blog-layout-grid .post .fusion-post-wrapper,.fusion-blog-layout-timeline .post, .fusion-portfolio.fusion-portfolio-boxed .fusion-portfolio-content-wrapper, .products li.product
{background-color: <?php echo ( $smof_data['timeline_bg_color'] ) ? $smof_data['timeline_bg_color'] : 'transparent'; ?>;}

.fusion-blog-layout-grid .post .flexslider,.fusion-blog-layout-grid .post .fusion-post-wrapper,.fusion-blog-layout-grid .post .fusion-content-sep,.products li,.product-details-container,.product-buttons,.product-buttons-container, .product .product-buttons,.fusion-blog-layout-timeline .fusion-timeline-line, .fusion-blog-timeline-layout .post,.fusion-blog-timeline-layout .post .fusion-content-sep,
.fusion-blog-timeline-layout .post .flexslider,.fusion-blog-layout-timeline .post,.fusion-blog-layout-timeline .post .fusion-content-sep,
.fusion-portfolio.fusion-portfolio-boxed .fusion-portfolio-content-wrapper, .fusion-portfolio.fusion-portfolio-boxed .fusion-content-sep,
.fusion-blog-layout-timeline .post .flexslider,.fusion-blog-layout-timeline .fusion-timeline-date
{border-color: <?php echo $smof_data['timeline_color']; ?>;}

.fusion-blog-layout-timeline .fusion-timeline-circle,.fusion-blog-layout-timeline .fusion-timeline-date,.fusion-blog-timeline-layout .fusion-timeline-circle,.fusion-blog-timeline-layout .fusion-timeline-date{background-color: <?php echo $smof_data['timeline_color']; ?>;}
.fusion-timeline-icon,.fusion-timeline-arrow:before,.fusion-blog-timeline-layout .fusion-timeline-icon,.fusion-blog-timeline-layout .fusion-timeline-arrow:before{color: <?php echo $smof_data['timeline_color']; ?>;}

#bbpress-forums li.bbp-header,
#bbpress-forums div.bbp-reply-header,#bbpress-forums #bbp-single-user-details #bbp-user-navigation li.current a,div.bbp-template-notice, div.indicator-hint{ background: <?php echo $smof_data['bbp_forum_header_bg']; ?>; }
#bbpress-forums .bbp-replies div.even { background: transparent; }

#bbpress-forums ul.bbp-lead-topic, #bbpress-forums ul.bbp-topics, #bbpress-forums ul.bbp-forums, #bbpress-forums ul.bbp-replies, #bbpress-forums ul.bbp-search-results,
#bbpress-forums li.bbp-body ul.forum, #bbpress-forums li.bbp-body ul.topic,
#bbpress-forums div.bbp-reply-content,#bbpress-forums div.bbp-reply-header,
#bbpress-forums div.bbp-reply-author .bbp-reply-post-date,
#bbpress-forums div.bbp-topic-tags a,#bbpress-forums #bbp-single-user-details,div.bbp-template-notice, div.indicator-hint,
.bbp-arrow{ border-color: <?php echo $smof_data['bbp_forum_border_color']; ?>; }

<?php if ( $smof_data['scheme_type'] == 'Dark' ): ?>
	.fusion-rollover .price .amount{color:#333333;}
	.meta li{border-color: <?php echo $smof_data['body_text_color']; ?>;}
	.error_page .oops {color: #2F2F30;}
	.bbp-arrow, #bbpress-forums .quicktags-toolbar { background-color:<?php echo $smof_data['content_bg_color']; ?>; }
	#toTop { background-color: #111111; }
	.chzn-container-single .chzn-single { background-image: none; box-shadow: none; }

	.catalog-ordering a, .order-dropdown > li:after,.order-dropdown ul li a {color: <?php echo $smof_data['form_text_color']; ?>;}

	.order-dropdown li,.order-dropdown .current-li,.order-dropdown > li:after,.order-dropdown ul li a,.catalog-ordering .order li a, .order-dropdown li, .order-dropdown .current-li,.order-dropdown ul,.order-dropdown ul li a,.catalog-ordering .order li a {background-color: <?php echo $smof_data['form_bg_color']; ?>;}

	.order-dropdown li:hover, .order-dropdown .current-li:hover, .order-dropdown ul li a:hover, .catalog-ordering .order li a:hover { background-color: #29292A; }
	.bbp-topics-front ul.super-sticky, .bbp-topics ul.super-sticky, .bbp-topics ul.sticky, .bbp-forum-content ul.sticky {
		background-color: #3E3E3E;
	}
	.bbp-topics-front ul.super-sticky a, .bbp-topics ul.super-sticky a, .bbp-topics ul.sticky a, .bbp-forum-content ul.sticky a {
		color: #FFFFFF;
	}

	.pagination-prev:before, .woocommerce-pagination .prev:before, .pagination-next:after, .woocommerce-pagination .next:after{
		color:#747474;
	}

	.table-1 table, .tkt-slctr-tbl-wrap-dv table{
		background-color: #313132;
		-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), inset 0 0 0 1px rgba(62, 62, 62, 0.5);
		-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), inset 0 0 0 1px rgba(62, 62, 62, 0.5);
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), inset 0 0 0 1px rgba(62, 62, 62, 0.5);	
	}
	.table-1 table th, .tkt-slctr-tbl-wrap-dv table th,
	.table-1 tbody tr:nth-child(2n), .tkt-slctr-tbl-wrap-dv tbody tr:nth-child(2n) {
		background-color: #212122;
		
	}
<?php endif; ?>

<?php if ( $smof_data['blog_grid_column_spacing'] || $smof_data['blog_grid_column_spacing'] === '0' ): ?>
	#posts-container.fusion-blog-layout-grid {
		margin: -<?php echo $smof_data['blog_grid_column_spacing'] / 2; ?>px -<?php echo $smof_data['blog_grid_column_spacing'] / 2; ?>px 0 -<?php echo $smof_data['blog_grid_column_spacing'] / 2; ?>px;
	}
	#posts-container.fusion-blog-layout-grid .fusion-post-grid {
		padding: <?php echo $smof_data['blog_grid_column_spacing'] / 2; ?>px;
	}
<?php endif; ?>

.quicktags-toolbar input {
	background: linear-gradient(to top, <?php echo $smof_data['content_bg_color']; ?>, <?php echo $smof_data['form_bg_color']; ?> ) #3E3E3E;
	background: -o-linear-gradient(to top, <?php echo $smof_data['content_bg_color']; ?>, <?php echo $smof_data['form_bg_color']; ?> ) #3E3E3E;
	background: -moz-linear-gradient(to top, <?php echo $smof_data['content_bg_color']; ?>, <?php echo $smof_data['form_bg_color']; ?> ) #3E3E3E;
	background: -webkit-linear-gradient(to top, <?php echo $smof_data['content_bg_color']; ?>, <?php echo $smof_data['form_bg_color']; ?> ) #3E3E3E;
	background: -ms-linear-gradient(to top, <?php echo $smof_data['content_bg_color']; ?>, <?php echo $smof_data['form_bg_color']; ?> ) #3E3E3E;
	background: linear-gradient(to top, <?php echo $smof_data['content_bg_color']; ?>, <?php echo $smof_data['form_bg_color']; ?> ) #3E3E3E;

	background-image: -webkit-gradient(
		linear,
		left top,
		left bottom,
		color-stop(0, <?php echo $smof_data['form_bg_color']; ?>),
		color-stop(1, <?php echo $smof_data['content_bg_color']; ?>)
	);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $smof_data['form_bg_color']; ?>', endColorstr='<?php echo $smof_data['content_bg_color']; ?>'), progid: DXImageTransform.Microsoft.Alpha(Opacity=0);

	border: 1px solid <?php echo $smof_data['form_border_color']; ?>;
	color: <?php echo $smof_data['form_text_color']; ?>;
}

.quicktags-toolbar input:hover {
	background: <?php echo $smof_data['form_bg_color']; ?>;
}

<?php if ( ! $smof_data['breadcrumb_mobile'] ): ?>
	@media only screen and (max-width: <?php echo ( 940 + (int) $smof_data['side_header_width'] ) . 'px'; ?> ) {	
		.fusion-body .fusion-page-title-bar .fusion-breadcrumbs{display:none;}
	}
	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait){
		.fusion-body .fusion-page-title-bar .fusion-breadcrumbs{display:none;}
	}
<?php endif; ?>

<?php if ( ! $smof_data['image_rollover'] ): ?>
	.fusion-rollover{display:none;}
<?php endif; ?>

<?php if ( $smof_data['image_rollover_direction'] == 'right' ): ?>
	.fusion-image-wrapper .fusion-rollover {
		-webkit-transform: translateX(100%);
		-moz-transform: translateX(100%);
		-o-transform: translateX(100%);
		-ms-transform: translateX(100%);
		transform: translateX(100%);
	}
<?php endif; ?>

<?php if ( $smof_data['image_rollover_direction'] == 'bottom' ): ?>
	.fusion-image-wrapper .fusion-rollover {
		-webkit-transform: translateY(100%);
		-moz-transform: translateY(100%);
		-o-transform: translateY(100%);
		-ms-transform: translateY(100%);
		transform: translateY(100%);
	}
	.fusion-image-wrapper:hover .fusion-rollover {
		-webkit-transform: translateY(0%);
		-moz-transform: translateY(0%);
		-o-transform: translateY(0%);
		-ms-transform: translateY(0%);
		transform: translateY(0%);
	}
<?php endif; ?>

<?php if ( $smof_data['image_rollover_direction'] == 'top' ): ?>
	.fusion-image-wrapper .fusion-rollover {
		-webkit-transform: translateY(-100%);
		-moz-transform: translateY(-100%);
		-o-transform: translateY(-100%);
		-ms-transform: translateY(-100%);
		transform: translateY(-100%);
	}
	.fusion-image-wrapper:hover .fusion-rollover {
		-webkit-transform: translateY(0%);
		-moz-transform: translateY(0%);
		-o-transform: translateY(0%);
		-ms-transform: translateY(0%);
		transform: translateY(0%);
	}
<?php endif; ?>

<?php if ( $smof_data['image_rollover_direction'] == 'center_horiz' ): ?>
	.fusion-image-wrapper .fusion-rollover {
		-webkit-transform: scaleX(0);
		-moz-transform: scaleX(0);
		-o-transform: scaleX(0);
		-ms-transform: scaleX(0);
		transform: scaleX(0);
	}
	.fusion-image-wrapper:hover .fusion-rollover {
		-webkit-transform: scaleX(1);
		-moz-transform: scaleX(1);
		-o-transform: scaleX(1);
		-ms-transform: scaleX(1);
		transform: scaleX(1);
	}
<?php endif; ?>

<?php if ( $smof_data['image_rollover_direction'] == 'center_vertical' ): ?>
	.fusion-image-wrapper .fusion-rollover {
		-webkit-transform: scaleY(0);
		-moz-transform: scaleY(0);
		-o-transform: scaleY(0);
		-ms-transform: scaleY(0);
		transform: scaleY(0);
	}
	.fusion-image-wrapper:hover .fusion-rollover {
		-webkit-transform: scaleY(1);
		-moz-transform: scaleY(1);
		-o-transform: scaleY(1);
		-ms-transform: scaleY(1);
		transform: scaleY(1);
	}
<?php endif; ?>

.ei-slider { width: <?php echo $smof_data['tfes_slider_width']; ?>; height: <?php echo $smof_data['tfes_slider_height']; ?>; }

<?php /// BUTTONS ?>

.button.default,
.fusion-button.fusion-button-default,
.gform_wrapper .gform_button,
#comment-submit,
.woocommerce .checkout #place_order,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
#reviews input#submit,
.woocommerce .login .button,
.woocommerce .register .button,
.bbp-submit-wrapper button,
.wpcf7-form input[type="submit"],
.wpcf7-submit,
.bbp-submit-wrapper .button,
#bbp_user_edit_submit,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button] {
  border-color: <?php echo $smof_data['button_accent_color']; ?>;
}
.button.default:hover,
.fusion-button.fusion-button-default:hover,
.gform_wrapper .gform_button:hover,
#comment-submit:hover,
.woocommerce .checkout #place_order:hover,
.woocommerce .single_add_to_cart_button:hover,
.woocommerce button.button:hover,
#reviews input#submit:hover,
.woocommerce .login .button:hover,
.woocommerce .register .button:hover,
.bbp-submit-wrapper button:hover,
.wpcf7-form input[type="submit"]:hover,
.wpcf7-submit:hover,
.bbp-submit-wrapper .button:hover,
#bbp_user_edit_submit:hover,
.ticket-selector-submit-btn[type=submit]:hover,
.gform_page_footer input[type=button]:hover {
  border-color: <?php echo $smof_data['button_accent_hover_color']; ?>;
}
<?php
$button_size = strtolower( $smof_data['button_size'] );
?>
.button.default,
.fusion-button-default,
.woocommerce .checkout #place_order,
.wpcf7-form input[type="submit"],
.wpcf7-submit,
.fusion-body #main .gform_wrapper .gform_button,
.fusion-body #main .gform_wrapper .gform_footer .gform_button
{
  <?php if( $button_size == 'small' ): ?>
  padding: 9px 20px;
  line-height: 14px;
  font-size: 12px;
  <?php if( $smof_data['button_type'] == '3d' ): ?>
 -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  <?php endif; ?>
  <?php endif; ?>
  <?php if( $button_size == 'medium' ): ?>
  padding: 11px 23px;
  line-height: 16px;
  font-size: 13px;
  <?php if( $smof_data['button_type'] == '3d' ): ?>
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  <?php endif; ?>
  <?php endif; ?>
  <?php if( $button_size == 'large' ): ?>
  padding: 13px 29px;
  line-height: 17px;
  font-size: 14px;
  <?php if( $smof_data['button_type'] == '3d' ): ?>
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  <?php endif; ?>
  <?php endif; ?>
  <?php if( $button_size == 'xlarge' ): ?>
  padding: 17px 40px;
  line-height: 21px;
  font-size: 18px;
  <?php if( $smof_data['button_type'] == '3d' ): ?>
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  <?php endif; ?>
  <?php endif; ?>
}
.button.default.button-3d.button-small,
.fusion-button.button-small.button-3d,
.ticket-selector-submit-btn[type=submit],
.fusion-button.fusion-button-3d.fusion-button-small {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
}
.button.default.button-3d.button-small:active,
.fusion-button.button-small.button-3d:active,
.fusion-button.fusion-button-3d.fusion-button-small:active {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
}
.button.default.button-3d.button-medium,
.fusion-button.button-medium.button-3d,
.fusion-button.fusion-button-3d.fusion-button-medium {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
}
.button.default.button-3d.button-medium:active .fusion-button.button-medium.button-3d:active,
.fusion-button.fusion-button-3d.fusion-button-medium:active {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
}
.button.default.button-3d.button-large,
.fusion-button.button-large.button-3d,
.fusion-button.fusion-button-3d.fusion-button-large {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 6px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 6px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 6px 3px rgba(0, 0, 0, 0.3);
}
.button.default.button-3d.button-large:active,
.fusion-button.button-large.button-3d:active,
.fusion-button.fusion-button-3d.fusion-button-large:active {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
}
.button.default.button-3d.button-xlarge,
.fusion-button.button-xlarge.button-3d,
.fusion-button.fusion-button-3d.fusion-button-xlarge {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
}
.button.default.button-3d.button-xlarge:active,
.fusion-button.button-xlarge.button-3d:active,
.fusion-button.fusion-button-3d.fusion-button-xlarge:active {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
}
<?php if( $smof_data['button_type'] == '3d' ): ?>
.button.default.small,
.fusion-button.fusion-button-default.fusion-button-small,
#reviews input#submit,
.woocommerce .login .button,
.woocommerce .register .button,
.bbp-submit-wrapper .button,
.wpcf7-form input[type="submit"].fusion-button-small,
.wpcf7-submit.fusion-button-small,
#bbp_user_edit_submit,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button],
.gform_wrapper .gform_button {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
}
.button.default.small:active,
.fusion-button.fusion-button-default.fusion-button-small:active,
#reviews input#submit:active,
.woocommerce .login .button:active,
.woocommerce .register .button:active,
.bbp-submit-wrapper .button:active,
.wpcf7-form input[type="submit"].fusion-button-small:active,
.wpcf7-submit.fusion-button-small:active,
#bbp_user_edit_submit:active,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button]:active,
.gform_wrapper .gform_button:active {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 4px 4px 2px rgba(0, 0, 0, 0.3);
}
.button.default.medium,
.fusion-button.fusion-button-default.fusion-button-medium,
#comment-submit,
.woocommerce .checkout #place_order,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
.bbp-submit-wrapper .button.button-medium,
.wpcf7-form input[type="submit"].fusion-button-medium,
.wpcf7-submit.fusion-button-medium {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 3px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
}
.button.default.medium:active,
.fusion-button.fusion-button-default.fusion-button-medium:active,
#comment-submit:active,
.woocommerce .checkout #place_order:active,
.woocommerce .single_add_to_cart_button:active,
.woocommerce button.button:active,
.bbp-submit-wrapper .button.button-medium:active,
.wpcf7-form input[type="submit"].fusion-button-medium:active,
.wpcf7-submit.fusion-button-medium:active {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 5px 5px 3px rgba(0, 0, 0, 0.3);
}
.button.default.large,
.fusion-button.fusion-button-default.fusion-button-large,
.bbp-submit-wrapper .button.button-large,
.wpcf7-form input[type="submit"].fusion-button-large,
.wpcf7-submit.fusion-button-large {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 4px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
}
.button.default.large:active,
.fusion-button.fusion-button-default.fusion-button-large:active,
.bbp-submit-wrapper .button.button-large:active,
.wpcf7-form input[type="submit"].fusion-button-large:active,
.wpcf7-submit.fusion-button-large:active {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 1px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 6px 6px 3px rgba(0, 0, 0, 0.3);
}
.button.default.xlarge,
.fusion-button.fusion-button-default.fusion-button-xlarge,
.bbp-submit-wrapper .button.button-xlarge,
.wpcf7-form input[type="submit"].fusion-button-xlarge,
.wpcf7-submit.fusion-button-xlarge {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 5px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
}
.button.default.xlarge:active,
.fusion-button.fusion-button-default.fusion-button-xlarge:active,
.bbp-submit-wrapper .button.button-xlarge:active,
.wpcf7-form input[type="submit"].fusion-button-xlarge:active,
.wpcf7-submit.fusion-button-xlarge:active {
  -webkit-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
  box-shadow: inset 0px 1px 0px #ffffff, 0px 2px 0px <?php echo $smof_data['button_bevel_color']; ?>, 1px 7px 7px 3px rgba(0, 0, 0, 0.3);
}
<?php endif; ?>
.button.default,
.fusion-button,
.button-default,
.fusion-button-default,
.gform_wrapper .gform_button,
#comment-submit,
.woocommerce .checkout #place_order,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
#reviews input#submit,
.woocommerce .login .button,
.woocommerce .register .button,
.bbp-submit-wrapper .button,
.wpcf7-form input[type="submit"],
.wpcf7-submit,
#bbp_user_edit_submit,
.gform_page_footer input[type=button] {
  border-width: <?php echo $smof_data['button_border_width'];?>;
  border-style: solid;
}
.button.default:hover,
.fusion-button.button-default:hover,
.ticket-selector-submit-btn[type=submit] {
  border-width: <?php echo $smof_data['button_border_width'];?>;
  border-style: solid;
}
<?php if( $smof_data['button_shape'] == 'Pill' ): ?>
.button.default,
.button-default,
.fusion-button-default,
#comment-submit,
.woocommerce .checkout #place_order,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
#reviews input#submit,
.woocommerce .avada-shipping-calculator-form .button,
.woocommerce .login .button,
.woocommerce .register .button,
.bbp-submit-wrapper .button,
.wpcf7-form input[type="submit"],
.wpcf7-submit,
#bbp_user_edit_submit,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button],
.gform_wrapper .gform_button {
  border-radius: 25px;
}
<?php endif; ?>
<?php if( $smof_data['button_shape'] == 'Square' ): ?>
.button.default,
.button-default,
.fusion-button-default,
#comment-submit,
.woocommerce .checkout #place_order,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
#reviews input#submit,
.woocommerce .avada-shipping-calculator-form .button,
.woocommerce .login .button,
.woocommerce .register .button,
.bbp-submit-wrapper .button,
.wpcf7-form input[type="submit"],
.wpcf7-submit,
#bbp_user_edit_submit,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button],
.gform_wrapper .gform_button {
  border-radius: 0px;
}
<?php endif; ?>
<?php if( $smof_data['button_shape'] == 'Round' ): ?>
.button.default,
.button-default,
.fusion-button-default,
#comment-submit,
.woocommerce .checkout #place_order,
.woocommerce .single_add_to_cart_button,
.woocommerce button.button,
#reviews input#submit,
.woocommerce .avada-shipping-calculator-form .button,
.woocommerce .login .button,
.woocommerce .register .button,
.bbp-submit-wrapper .button,
.wpcf7-form input[type="submit"],
.wpcf7-submit,
#bbp_user_edit_submit,
.ticket-selector-submit-btn[type=submit],
.gform_page_footer input[type=button],
.gform_wrapper .gform_button {
  border-radius: 2px;
}
<?php endif; ?>

.reading-box{background-color: <?php echo $smof_data['tagline_bg']; ?>;}

.isotope .isotope-item {
  -webkit-transition-property: top, left, opacity;
	 -moz-transition-property: top, left, opacity;
	  -ms-transition-property: top, left, opacity;
	   -o-transition-property: top, left, opacity;
		  transition-property: top, left, opacity;
}

<?php if ( $smof_data['link_image_rollover'] ): ?>
	.fusion-rollover .link-icon{display:none !important;}
<?php endif; ?>

<?php if ( $smof_data['zoom_image_rollover'] ): ?>
	.fusion-rollover .gallery-icon{display:none !important;}
<?php endif; ?>

<?php if ( $smof_data['title_image_rollover'] ): ?>
	.fusion-rollover .fusion-rollover-title{display:none;}
<?php endif; ?>

<?php if ( $smof_data['cats_image_rollover'] ): ?>
	.fusion-rollover .fusion-rollover-categories{display:none;}
<?php endif; ?>

<?php if ( $smof_data['woocommerce_one_page_checkout'] ): ?>
	.woocommerce .checkout #customer_details .col-1,
	.woocommerce .checkout #customer_details .col-2 {
		box-sizing: border-box;-moz-box-sizing: border-box;border: 1px solid;overflow: hidden;padding: 30px;margin-bottom:30px;float:left;width:48%;margin-right: 4%;
	}
	.rtl .woocommerce form.checkout #customer_details .col-1, 
	.rtl .woocommerce form.checkout #customer_details .col-2 {
		float: right;
	}
	.rtl .woocommerce form.checkout #customer_details .col-1 {
		margin-left: 4%;
		margin-right: 0;
	}

	.woocommerce form.checkout #customer_details .col-1,
	.woocommerce form.checkout #customer_details .col-2 {
		border-color: <?php echo $smof_data['sep_color']; ?>
	}

	.woocommerce form.checkout #customer_details div:last-child { margin-right: 0; }

	.woocommerce form.checkout .avada-checkout-no-shipping #customer_details .col-1 {width:100%;margin-right:0;}
	.woocommerce form.checkout .avada-checkout-no-shipping #customer_details .col-2 {display:none;}
<?php else: ?>
	.woocommerce form.checkout .col-2, .woocommerce form.checkout #order_review_heading, .woocommerce form.checkout #order_review {
		display: none;
	}
<?php endif; ?>

<?php if ( ! $smof_data['responsive'] ): ?>
	#wrapper .fusion-megamenu-wrapper.col-span-1 {
		width: 235px;
	}
	#wrapper .fusion-megamenu-wrapper.col-span-2 {
		width: 470px;
	}
	#wrapper .fusion-megamenu-wrapper.col-span-3 {
		width: 705px;
	}
	#wrapper .fusion-megamenu-wrapper {
		width: 940px;
	}
	#wrapper .fusion-megamenu-wrapper {
		position: absolute;
		left: 0;
		z-index: 20000;
	}
	#wrapper .fusion-megamenu-wrapper a:hover {
		color: #333;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-holder {
		width: 100%;
		padding: 0;
		border-top: 3px solid <?php echo $smof_data['menu_hover_first_color']; ?>;
		background-color: #edebeb;
	}
	#wrapper .fusion-megamenu-wrapper .sub-menu {
		padding: 0;
		list-style: none;
	}
	#wrapper .fusion-megamenu-wrapper .sub-menu.deep-level a {
		padding-left: 49px ;
	}
	#wrapper .fusion-megamenu-wrapper .sub-menu.deep-level .deep-level a {
		padding-left: 64px;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu {
		display: table;
		padding: 0;
		width: 100%;
		list-style: none;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-border {
		border-bottom: 1px solid #dcd9d9;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-submenu {
		display: table-cell;
		float: none;
		padding: 29px 0;
		border-right: 1px solid;
	}
	#wrapper #nav .fusion-megamenu-wrapper li a,
	#wrapper #nav .fusion-megamenu-wrapper .fusion-megamenu-submenu li a,
	#wrapper #sticky-nav .fusion-megamenu-wrapper li a,
	#wrapper #sticky-nav .fusion-megamenu-wrapper .fusion-megamenu-submenu li a	{
		display: block;
		padding: 5px 34px;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-submenu li a:hover,
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-submenu .current-menu-item a {
		background-color: #f3f2f2;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-submenu .fusion-megamenu-icon img {
		margin-top: -3px;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-title {
		margin-top: 0;
		padding: 0 34px 15px 34px;
		font: 18px 'MuseoSlab500Regular', arial, helvetica, sans-serif;
		font-weight: normal;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-title a:hover {
		text-decoration: none;
		color: #000;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-icon,
	.fusion-megamenu-icon {
		display: inline;
		margin-right: 12px;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-icon img,
	.fusion-megamenu-icon img {
		margin-top: -2px;
		max-height: 15px;
		vertical-align: middle;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-bullet,
	.fusion-megamenu-bullet {
		display: block;
		float: left;
		margin-top: 0.5em;
		margin-right: 10px;
		border-top: 3px solid transparent;
		border-bottom: 3px solid transparent;
		border-left: 3px solid #333;
		height: 0;
		width: 0;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-widgets-container {
		margin-bottom: 10px;
		color: #333;
		font-size: 13px;
	}
	#wrapper .fusion-megamenu-wrapper .fusion-megamenu-widgets-container.second-level-widget {
		padding: 0 34px;
	}
<?php endif; ?>

<?php if ( $smof_data['responsive'] ): ?>
	<?php if ( ! $smof_data['ipad_potrait'] ): ?>
		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) {
			#wrapper .fusion-page-title-bar {
				height: <?php echo $smof_data['page_title_height']; ?> !important;
			}
		}
	<?php endif; ?>
<?php endif; ?>

<?php if ( $smof_data['page_title_100_width'] ): ?>
	.layout-wide-mode .fusion-page-title-row { max-width: 100%; }
<?php endif; ?>

<?php
	if ( $smof_data['google_button'] != 'None' ) {
		$button_font = sprintf( '\'%s\'', $smof_data['google_button'] ) . ', Arial, Helvetica, sans-serif';
	} elseif ( $smof_data['standard_button'] != 'Select Font' ) {
		$button_font = $smof_data['standard_button'];
	}
?>

.fusion-button {
	font-family: <?php echo $button_font; ?>;
	font-weight: <?php echo $smof_data['font_weight_button']; ?>;
	letter-spacing: <?php echo $smof_data['button_font_ls']; ?>px
}

.fusion-image-wrapper .fusion-rollover .fusion-rollover-link,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-gallery {
<?php if ( $smof_data['icon_circle_image_rollover'] ): ?>
	background: none;
	width: <?php echo $smof_data['image_rollover_icon_size'] * 0.5 + $smof_data['image_rollover_icon_size']; ?>px;
	height: <?php echo $smof_data['image_rollover_icon_size'] * 0.5 + $smof_data['image_rollover_icon_size']; ?>px;
<?php else: ?>
	width: <?php echo $smof_data['image_rollover_icon_size'] * 1.41 + $smof_data['image_rollover_icon_size']; ?>px;
	height: <?php echo $smof_data['image_rollover_icon_size'] * 1.41 + $smof_data['image_rollover_icon_size']; ?>px;
<?php endif; ?>
}
.fusion-image-wrapper .fusion-rollover .fusion-rollover-link:before,
.fusion-image-wrapper .fusion-rollover .fusion-rollover-gallery:before {
	font-size: <?php echo $smof_data['image_rollover_icon_size']; ?>px;
	color: <?php echo $smof_data['image_rollover_icon_color']; ?>;
	margin-left: -<?php echo $smof_data['image_rollover_icon_size'] / 2; ?>px;
<?php if ( $smof_data['icon_circle_image_rollover'] ): ?>
	line-height: <?php echo $smof_data['image_rollover_icon_size'] * 0.5 + $smof_data['image_rollover_icon_size']; ?>px;
<?php else: ?>
	line-height: <?php echo $smof_data['image_rollover_icon_size'] * 1.41 + $smof_data['image_rollover_icon_size']; ?>px;
<?php endif; ?>
}

.searchform .search-table .search-field input {
	height: <?php echo fusion_strip_unit( $smof_data['search_form_height'] ); ?>px;
}

.searchform .search-table .search-button input[type="submit"] {
	height: <?php echo fusion_strip_unit( $smof_data['search_form_height'] ); ?>px;
	width: <?php echo fusion_strip_unit( $smof_data['search_form_height'] ); ?>px;
	line-height: <?php echo fusion_strip_unit( $smof_data['search_form_height'] ); ?>px;
}


/* Headings
================================================================================================= */

h1, .fusion-title-size-one { margin-top: <?php echo $smof_data['h1_top_margin']; ?>em; margin-bottom: <?php echo $smof_data['h1_bottom_margin']; ?>em; }
h2, .fusion-title-size-two { margin-top: <?php echo $smof_data['h2_top_margin']; ?>em; margin-bottom: <?php echo $smof_data['h2_bottom_margin']; ?>em; }
h3, .fusion-title-size-three { margin-top: <?php echo $smof_data['h3_top_margin']; ?>em; margin-bottom: <?php echo $smof_data['h3_bottom_margin']; ?>em; }
h4, .fusion-title-size-four { margin-top: <?php echo $smof_data['h4_top_margin']; ?>em; margin-bottom: <?php echo $smof_data['h4_bottom_margin']; ?>em; }
h5, .fusion-title-size-five { margin-top: <?php echo $smof_data['h5_top_margin']; ?>em; margin-bottom: <?php echo $smof_data['h5_bottom_margin']; ?>em; }
h6, .fusion-title-size-six { margin-top: <?php echo $smof_data['h6_top_margin']; ?>em; margin-bottom: <?php echo $smof_data['h6_bottom_margin']; ?>em; }


<?php
// HEADER IS NUMBER 5
?>

/* Header Styles
================================================================================================= */
.fusion-logo {
  margin-top: <?php echo $smof_data['margin_logo_top']; ?>;
  margin-right: <?php echo $smof_data['margin_logo_right']; ?>;
  margin-bottom: <?php echo $smof_data['margin_logo_bottom']; ?>;
  margin-left: <?php echo $smof_data['margin_logo_left']; ?>;
}
<?php if( $smof_data['header_shadow'] ): ?>
.fusion-header-shadow:after {
  content: '';
  z-index: 99996;
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  pointer-events: none;
  -webkit-box-shadow: 0px 10px 50px -2px rgba(0, 0, 0, 0.14);
  -moz-box-shadow: 0px 10px 50px -2px rgba(0, 0, 0, 0.14);
  box-shadow: 0px 10px 50px -2px rgba(0, 0, 0, 0.14);
}
body.side-header-left #side-header.header-shadow:after {
  content: "";
  z-index: 99996;
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  pointer-events: none;
  -webkit-box-shadow: 10px 0px 50px -2px rgba(0, 0, 0, 0.14);
  -moz-box-shadow: 10px 0px 50px -2px rgba(0, 0, 0, 0.14);
  box-shadow: 10px 0px 50px -2px rgba(0, 0, 0, 0.14);
}
body.side-header-right #side-header.header-shadow:after {
  content: "";
  z-index: 99996;
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  pointer-events: none;
  -webkit-box-shadow: -10px 0px 50px -2px rgba(0, 0, 0, 0.14);
  -moz-box-shadow: -10px 0px 50px -2px rgba(0, 0, 0, 0.14);
  box-shadow: -10px 0px 50px -2px rgba(0, 0, 0, 0.14);
}
.fusion-is-sticky.fusion-header-shadow:after {
  display: none;
}
<?php endif; ?>
.fusion-header-wrapper .fusion-row {
  padding-left: <?php echo $smof_data['padding_header_left']; ?>;
  padding-right: <?php echo $smof_data['padding_header_right']; ?>;
  max-width: <?php echo $smof_data['site_width']; ?>;
}
.fusion-header-v2 .fusion-header,
.fusion-header-v3 .fusion-header,
.fusion-header-v4 .fusion-header,
.fusion-header-v5 .fusion-header {
  border-bottom-color: <?php echo $smof_data['header_border_color']; ?>;
}
.fusion-header .fusion-row {
  padding-top: <?php echo $smof_data['margin_header_top']; ?>;
  padding-bottom: <?php echo $smof_data['margin_header_bottom']; ?>;
}
.fusion-secondary-header {
  background-color: <?php echo $smof_data['header_top_bg_color']; ?>;
  font-size: <?php echo $smof_data['snav_font_size']; ?>px;
  color: <?php echo $smof_data['snav_color']; ?>;
  border-bottom-color: <?php echo $smof_data['header_border_color'] ?>;
}
.fusion-secondary-header a,
.fusion-secondary-header a:hover {
  color: <?php echo $smof_data['snav_color']; ?>;
}
.fusion-header-v2 .fusion-secondary-header {
  border-top-color: <?php echo $smof_data['primary_color']; ?>;
}
.fusion-mobile-menu-design-modern .fusion-secondary-header .fusion-alignleft {
  border-bottom-color: <?php echo $smof_data['header_border_color'] ?>;
}
.fusion-header-tagline {
  font-size: <?php echo $smof_data['tagline_font_size']; ?>px;
  color: <?php echo $smof_data['tagline_font_color']; ?>;
}
.fusion-secondary-main-menu,
.fusion-mobile-menu-sep {
  border-bottom-color: <?php echo $smof_data['header_border_color'] ?>;
}
#side-header {
  width: <?php echo $side_header_width; ?>px;
  padding-top: <?php echo $smof_data['margin_header_top']; ?>;
  padding-bottom: <?php echo $smof_data['margin_header_bottom']; ?>;
  border-color: <?php echo $smof_data['header_border_color'] ?>;
}
#side-header .side-header-content {
  padding-left: <?php echo $smof_data['padding_header_left']; ?>;
  padding-right: <?php echo $smof_data['padding_header_left']; ?>;
}
#side-header .fusion-main-menu > ul > li > a {
  padding-left: <?php echo $smof_data['padding_header_left']; ?>;
  padding-right: <?php echo $smof_data['padding_header_left']; ?>;
  border-top-color: <?php echo $smof_data['header_border_color'] ?>;
  border-bottom-color: <?php echo $smof_data['header_border_color'] ?>;
  text-align: <?php echo $smof_data['menu_text_align']; ?>;
}
#side-header .fusion-main-menu > ul > li.current-menu-ancestor > a,
#side-header .fusion-main-menu > ul > li.current-menu-item > a {
  color: <?php echo $smof_data['menu_hover_first_color']; ?>;
  border-right-color: <?php echo $smof_data['menu_hover_first_color']; ?>;
  border-left-color: <?php echo $smof_data['menu_hover_first_color']; ?>;
}
body.side-header-left #side-header .fusion-main-menu > ul > li > ul {
  left: <?php echo ( $side_header_width - 1 ); ?>px;
}
body.side-header-left #side-header .fusion-main-menu .fusion-custom-menu-item-contents {
  top: 0;
  left: <?php echo ( $side_header_width - 1); ?>px;
}
#side-header .fusion-main-menu .fusion-main-menu-search .fusion-custom-menu-item-contents {
  border-top-width: 1px;
  border-top-style: solid;
}
#side-header .side-header-content-1,
#side-header .side-header-content-2,
#side-header .fusion-secondary-menu > ul > li > a {
  color: <?php echo $smof_data['header_top_menu_sub_color']; ?>;
  font-size: <?php echo $smof_data['snav_font_size']; ?>px;
}
.side-header-left #side-header .fusion-main-menu > ul > li.current-menu-ancestor > a,
.side-header-left #side-header .fusion-main-menu > ul > li.current-menu-item > a {
  border-right-width: <?php echo $smof_data['nav_highlight_border']; ?>px;
}
.side-header-right #side-header .fusion-main-menu > ul > li.current-menu-ancestor > a,
.side-header-right #side-header .fusion-main-menu > ul > li.current-menu-item > a {
  border-left-width: <?php echo $smof_data['nav_highlight_border']; ?>px;
}
.side-header-right #side-header .fusion-main-menu ul .sub-menu li ul,
.side-header-right #side-header .fusion-main-menu ul .sub-menu {
  left: -<?php echo $smof_data['dropdown_menu_width']; ?>;
}
.side-header-right #side-header .fusion-main-menu-search .fusion-custom-menu-item-contents {
  left: -250px;
}
.side-header-right #side-header .fusion-main-menu-cart .fusion-custom-menu-item-contents {
  left: -180px;
}


/* Main Menu Styles
================================================================================================= */
.fusion-main-menu > ul > li {
  padding-right: <?php echo $smof_data['nav_padding']; ?>px;
}
.fusion-main-menu > ul > li > a {
  border-top: <?php echo $smof_data['nav_highlight_border']; ?>px solid transparent;
  height: <?php echo $smof_data['nav_height']; ?>px;
  line-height: <?php echo $smof_data['nav_height']; ?>px;
  font-family: <?php echo $nav_font; ?>;
  font-weight: <?php echo $smof_data['font_weight_menu'];?>;
  font-size: <?php echo $smof_data['nav_font_size']; ?>px;
  color: <?php echo $smof_data['menu_first_color']; ?>;
  letter-spacing: <?php echo $smof_data['menu_font_ls']; ?>px;
}
.fusion-main-menu > ul > li > a:hover {
  color: <?php echo $smof_data['menu_hover_first_color']; ?>;
  border-color: <?php echo $smof_data['menu_hover_first_color']; ?>;
}
#side-header .fusion-main-menu > ul > li > a {
  height: auto;
  min-height: <?php echo $smof_data['nav_height']; ?>px;
}
.fusion-main-menu .current_page_item > a,
.fusion-main-menu .current-menu-item > a,
.fusion-main-menu .current-menu-parent > a,
.fusion-main-menu .current-menu-ancestor > a {
  color: <?php echo $smof_data['menu_hover_first_color']; ?>;
  border-color: <?php echo $smof_data['menu_hover_first_color']; ?>;
}
.fusion-main-menu .fusion-main-menu-icon:after {
  color: <?php echo $smof_data['menu_first_color']; ?>;
  height: <?php echo $smof_data['nav_font_size']; ?>px;
  width: <?php echo $smof_data['nav_font_size']; ?>px;
}
<?php if( $smof_data['main_nav_icon_circle'] ): ?>
.fusion-main-menu .fusion-main-menu-icon:after {
  border: 1px solid #333333;
  padding: 5px;
}
<?php endif; ?>
.fusion-main-menu .fusion-main-menu-icon:hover {
  border-color: transparent;
}
.fusion-main-menu .fusion-main-menu-icon:hover:after {
  color: <?php echo $smof_data['menu_hover_first_color']; ?>;
}
<?php if( $smof_data['main_nav_icon_circle'] ): ?>
.fusion-main-menu .fusion-main-menu-icon:hover:after {
  border: 1px solid <?php echo $smof_data['menu_hover_first_color']; ?>;
}
<?php endif; ?>
.fusion-main-menu .fusion-main-menu-search-open .fusion-main-menu-icon:after,
.fusion-main-menu .fusion-main-menu-icon-active:after {
  color: <?php echo $smof_data['menu_hover_first_color']; ?>;
}
<?php if( $smof_data['main_nav_icon_circle'] ): ?>
.fusion-main-menu .fusion-main-menu-search-open .fusion-main-menu-icon:after,
.fusion-main-menu .fusion-main-menu-icon-active:after {
  border: 1px solid <?php echo $smof_data['menu_hover_first_color']; ?>;
}
<?php endif; ?>
.fusion-main-menu .sub-menu {
  background-color: <?php echo $smof_data['menu_sub_bg_color']; ?>;
  width: <?php echo $smof_data['dropdown_menu_width']; ?>;
  border-top: 3px solid <?php echo $smof_data['menu_hover_first_color']; ?>;
  font-family: <?php echo $font; ?>;
  font-weight: <?php echo $smof_data['font_weight_body']; ?>;
  <?php if( $smof_data['megamenu_shadow'] ): ?>
  -moz-box-shadow: 1px 1px 30px rgba(0, 0, 0, 0.06);
  -webkit-box-shadow: 1px 1px 30px rgba(0, 0, 0, 0.06);
  box-shadow: 1px 1px 30px rgba(0, 0, 0, 0.06);
  <?php endif; ?>
}
.fusion-main-menu .sub-menu ul {
  left: <?php echo $smof_data['dropdown_menu_width']; ?>;
  top: -3px;
}
.fusion-main-menu .sub-menu li a {
  border-bottom: 1px solid <?php echo $smof_data['menu_sub_sep_color']; ?>;
  color: <?php echo $smof_data['menu_sub_color']; ?>;
  font-family: <?php echo $font; ?>;
  font-weight: <?php echo $smof_data['font_weight_body']; ?>;
  font-size: <?php echo $smof_data['nav_dropdown_font_size']; ?>px;
}
.fusion-main-menu .sub-menu li a:hover {
  background-color: <?php echo $smof_data['menu_bg_hover_color']; ?>;
}
.fusion-main-menu .sub-menu .current_page_item > a,
.fusion-main-menu .sub-menu .current-menu-item > a,
.fusion-main-menu .sub-menu .current-menu-parent > a {
  background-color: <?php echo $smof_data['menu_bg_hover_color']; ?>;
}
.fusion-main-menu .fusion-custom-menu-item-contents {
  font-family: <?php echo $font; ?>;
  font-weight: <?php echo $smof_data['font_weight_body']; ?>;
}
.fusion-main-menu .fusion-main-menu-search .fusion-custom-menu-item-contents,
.fusion-main-menu .fusion-main-menu-cart .fusion-custom-menu-item-contents,
.fusion-main-menu .fusion-menu-login-box .fusion-custom-menu-item-contents {
  background-color: <?php echo $smof_data['menu_sub_bg_color']; ?>;
  border-color: <?php echo $smof_data['menu_sub_sep_color']; ?>;
}
.rtl .fusion-main-menu > ul > li {
  padding-right: 0;
  padding-left: <?php echo $smof_data['nav_padding']; ?>px;
}
.rtl .fusion-main-menu .sub-menu ul {
  left: auto;
  right: <?php echo $smof_data['dropdown_menu_width']; ?>;
}

/* Secondary Menu Styles
================================================================================================= */
.fusion-secondary-menu > ul > li {
  border-color: <?php echo $smof_data['header_top_first_border_color']; ?>;
}
.fusion-secondary-menu > ul > li > a {
  height: <?php echo $smof_data['sec_menu_lh']; ?>px;
  line-height: <?php echo $smof_data['sec_menu_lh']; ?>px;
}
.fusion-secondary-menu .sub-menu {
  width: <?php echo $smof_data['topmenu_dropwdown_width']; ?>;
  background-color: <?php echo $smof_data['header_top_sub_bg_color']; ?>;
  border-color: <?php echo $smof_data['header_top_menu_sub_sep_color']; ?>;
}
.fusion-secondary-menu .sub-menu a {
  border-color: <?php echo $smof_data['header_top_menu_sub_sep_color']; ?>;
  color: <?php echo $smof_data['header_top_menu_sub_color']; ?>;
}
.fusion-secondary-menu .sub-menu a:hover {
  background-color: <?php echo $smof_data['header_top_menu_bg_hover_color']; ?>;
  color: <?php echo $smof_data['header_top_menu_sub_hover_color']; ?>;
}
.fusion-secondary-menu > ul > li > .sub-menu .sub-menu {
  left: <?php echo $smof_data['topmenu_dropwdown_width']; ?>;
}
.fusion-secondary-menu .fusion-custom-menu-item-contents {
  background-color: <?php echo $smof_data['header_top_sub_bg_color']; ?>;
  border-color: <?php echo $smof_data['header_top_menu_sub_sep_color']; ?>;
  color: <?php echo $smof_data['header_top_menu_sub_color']; ?>;
}
.fusion-secondary-menu .fusion-secondary-menu-icon,
.fusion-secondary-menu .fusion-secondary-menu-icon:hover {
  color: <?php echo $smof_data['menu_first_color']; ?>;
}
.fusion-secondary-menu .fusion-menu-cart-items a {
  color: <?php echo $smof_data['header_top_menu_sub_color']; ?>;
}
.fusion-secondary-menu .fusion-menu-cart-item a {
  border-color: <?php echo $smof_data['header_top_menu_sub_sep_color']; ?>;
}
.fusion-secondary-menu .fusion-menu-cart-item img {
  border-color: <?php echo $smof_data['sep_color']; ?>;
}
.fusion-secondary-menu .fusion-menu-cart-item a:hover {
  background-color: <?php echo $smof_data['header_top_menu_bg_hover_color']; ?>;
  color: <?php echo $smof_data['header_top_menu_sub_hover_color']; ?>;
}
.fusion-secondary-menu .fusion-menu-cart-checkout {
  background-color: <?php echo $smof_data['woo_cart_bg_color']; ?>;
}
.fusion-secondary-menu .fusion-menu-cart-checkout a:before {
  color: <?php echo $smof_data['header_top_menu_sub_color']; ?>;
}
.fusion-secondary-menu .fusion-menu-cart-checkout a:hover,
.fusion-secondary-menu .fusion-menu-cart-checkout a:hover:before {
  color: <?php echo $smof_data['header_top_menu_sub_hover_color']; ?>;
}
.fusion-secondary-menu-icon {
  background-color: <?php echo $smof_data['woo_cart_bg_color']; ?>;
  color: <?php echo $smof_data['menu_first_color']; ?>;
}
.fusion-secondary-menu-icon:before,
.fusion-secondary-menu-icon:after {
  color: <?php echo $smof_data['menu_first_color']; ?>;
}
.rtl .fusion-secondary-menu > ul > li:first-child {
  border-left: 1px solid <?php echo $smof_data['header_top_first_border_color']; ?>;
}
.rtl .fusion-secondary-menu > ul > li > .sub-menu .sub-menu {
  left: auto;
  right: <?php echo $smof_data['topmenu_dropwdown_width']; ?>;
}

.fusion-contact-info {
	line-height: <?php echo $smof_data['sec_menu_lh']; ?>px;
}

/* Common Menu Styles
================================================================================================= */
.fusion-menu-cart-items {
  font-size: <?php echo $smof_data['woo_icon_font_size'] ?>px;
  line-height: <?php echo round( $smof_data['woo_icon_font_size'] ) * 1.5; ?>px;
}
.fusion-menu-cart-items a {
  color: <?php echo $smof_data['menu_sub_color']; ?>;
}
.fusion-menu-cart-item a {
  border-color: <?php echo $smof_data['menu_sub_sep_color']; ?>;
}
.fusion-menu-cart-item img {
  border-color: <?php echo $smof_data['sep_color']; ?>;
}
.fusion-menu-cart-item a:hover {
  background-color: <?php echo $smof_data['menu_bg_hover_color']; ?>;
}
.fusion-menu-cart-checkout {
  background-color: <?php echo $smof_data['woo_cart_bg_color']; ?>;
}
.fusion-menu-cart-checkout a:before {
  color: <?php echo $smof_data['menu_sub_color']; ?>;
}
.fusion-menu-cart-checkout a:hover,
.fusion-menu-cart-checkout a:hover:before {
  color: <?php echo $smof_data['primary_color']; ?>;
}

/* Megamenu Styles
================================================================================================= */
.fusion-megamenu-holder {
  border-color: <?php echo $smof_data['menu_hover_first_color']; ?>;
}
.fusion-megamenu {
  background-color: <?php echo $smof_data['menu_sub_bg_color']; ?>;
  <?php if( $smof_data['megamenu_shadow'] ): ?>
  -webkit-box-shadow: 0 2px 2px #999;
  -moz-box-shadow: 0 2px 2px #999;
  box-shadow: 0 2px 2px #999;
  <?php endif; ?>
}
.fusion-megamenu-wrapper .fusion-megamenu-submenu {
  border-color: <?php echo $smof_data['menu_sub_sep_color']; ?>;
}

.fusion-megamenu-wrapper .fusion-megamenu-submenu > a:hover {
	background-color: <?php echo $smof_data['menu_bg_hover_color']; ?>;
	color: <?php echo $smof_data['menu_sub_color']; ?>;
	font-family: <?php echo $font; ?>;
	font-weight: <?php echo $smof_data['font_weight_body']; ?>;
	font-size: <?php echo $smof_data['nav_dropdown_font_size']; ?>;
}

.fusion-megamenu-title {
  <?php if( $headings_font ): ?>
  font-family: <?php echo $headings_font; ?>;
  <?php endif; ?>
  font-weight: <?php echo $smof_data['font_weight_headings']; ?>;
  font-size: <?php echo fusion_strip_unit( $smof_data['megamenu_title_size'] ) ?>px;;
  color: <?php echo $smof_data['menu_first_color']; ?>;
}
.fusion-megamenu-title a {
  color: <?php echo $smof_data['menu_first_color']; ?>;
}
.fusion-megamenu-bullet {
  border-left-color: <?php echo $smof_data['menu_sub_color']; ?>;
}
.rtl .fusion-megamenu-bullet {
  border-right-color: <?php echo $smof_data['menu_sub_color']; ?>;
}
.fusion-megamenu-widgets-container {
  color: <?php echo $smof_data['menu_sub_color']; ?>;
  font-family: <?php echo $font; ?>;
  font-weight: <?php echo $smof_data['font_weight_body']; ?>;
  font-size: <?php echo $smof_data['nav_dropdown_font_size']; ?>px;
}

.rtl .fusion-megamenu-wrapper .fusion-megamenu-submenu .sub-menu ul {
	right: auto;
}

/* Sticky Header Styles
================================================================================================= */
<?php
$sticky_header_bg = $smof_data['header_sticky_bg_color']['color'];
if( $smof_data['header_sticky_bg_color']['color'] != '' ) {
  $rgba = fusion_hex2rgb( $smof_data['header_sticky_bg_color']['color'] );
  $sticky_header_bg = sprintf( 'rgba(%s,%s,%s, %s)', $rgba[0], $rgba[1], $rgba[2], $smof_data['header_sticky_bg_color']['opacity'] );
}
?>
.fusion-header-wrapper.fusion-is-sticky .fusion-header,
.fusion-header-wrapper.fusion-is-sticky .fusion-secondary-main-menu {
  background-color: <?php echo $sticky_header_bg; ?>
}
.no-rgba .fusion-header-wrapper.fusion-is-sticky .fusion-header,
.no-rgba .fusion-header-wrapper.fusion-is-sticky .fusion-secondary-main-menu {
  background-color: <?php echo $sticky_header_bg; ?>;
  opacity: <?php echo $smof_data['header_sticky_bg_color']['opacity']; ?>;
  filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $smof_data['header_sticky_bg_color']['opacity'] * 100; ?>);
}
.fusion-is-sticky .fusion-main-menu > ul > li {
  padding-right: <?php echo $smof_data['header_sticky_nav_padding'] ?>px;
}
.fusion-is-sticky .fusion-main-menu > ul > li:last-child {
  padding-right: 0;
}
.fusion-is-sticky .fusion-main-menu > ul > li > a {
  font-size: <?php echo $smof_data['header_sticky_nav_font_size']; ?>px;
}
.rtl .fusion-is-sticky .fusion-main-menu > ul > li {
  padding-right: 0;
  padding-left: <?php echo $smof_data['header_sticky_nav_padding'] ?>px;
}
.rtl .fusion-is-sticky .fusion-main-menu > ul > li:last-child {
  padding-left: 0;
}

/* Mobile Menu Styles
================================================================================================= */
.fusion-mobile-selector {
  background-color: <?php echo $smof_data['mobile_menu_background_color']; ?>;
  border-color: <?php echo $smof_data['mobile_menu_border_color']; ?>;
  font-size: <?php echo $smof_data['mobile_menu_font_size']; ?>px;
  height: <?php echo $smof_data['mobile_menu_nav_height']; ?>px;
  line-height: <?php echo $smof_data['mobile_menu_nav_height']; ?>px;
  color: <?php echo $smof_data['mobile_menu_font_color']; ?>;
}
.fusion-selector-down,
.rtl .fusion-selector-down {
  height: <?php echo $smof_data['mobile_menu_nav_height'] - 2; ?>px;
  line-height: <?php echo $smof_data['mobile_menu_nav_height'] - 2; ?>px;
  border-color: <?php echo $smof_data['mobile_menu_border_color']; ?>;
}
.fusion-selector-down:before,
.rtl .fusion-selector-down:before {
  color: <?php echo $smof_data['mobile_menu_border_color']; ?>;
}
<?php if( $smof_data['mobile_menu_font_size'] > 35 ): ?>
  .fusion-selector-down {
    font-size: 30px;
  }
<?php endif; ?>
.fusion-mobile-nav-holder > ul,
.fusion-mobile-menu-design-modern .fusion-mobile-nav-holder > ul {
  border-color: <?php echo $smof_data['mobile_menu_border_color']; ?>;
}
.fusion-mobile-nav-item a {
  color: <?php echo $smof_data['mobile_menu_font_color']; ?>;
  font-size: <?php echo $smof_data['mobile_menu_font_size']; ?>px;
  background-color: <?php echo $smof_data['mobile_menu_background_color']; ?>;
  border-color: <?php echo $smof_data['mobile_menu_border_color']; ?>;
  height: <?php echo $smof_data['mobile_menu_nav_height']; ?>px;
  line-height: <?php echo $smof_data['mobile_menu_nav_height']; ?>px;
}
.fusion-mobile-nav-item a:hover {
  background-color: <?php echo $smof_data['mobile_menu_hover_color']; ?>;
}
.fusion-mobile-nav-item a:before {
  color: <?php echo $smof_data['mobile_menu_font_color']; ?>;
}
.fusion-mobile-current-nav-item > a {
  background-color: <?php echo $smof_data['mobile_menu_hover_color']; ?>;
}
.fusion-mobile-menu-icons {
  margin-top: <?php echo $smof_data['mobile_menu_icons_top_margin']; ?>;
}
.fusion-mobile-menu-icons a {
  color: <?php echo $smof_data['mobile_menu_toggle_color']; ?>;
}
.fusion-mobile-menu-icons a:before {
  color: <?php echo $smof_data['mobile_menu_toggle_color']; ?>;
}
.fusion-open-submenu {
  font-size: <?php echo $smof_data['mobile_menu_font_size']; ?>px;
  height: <?php echo $smof_data['mobile_menu_nav_height']; ?>px;
  line-height: <?php echo $smof_data['mobile_menu_nav_height']; ?>px;
}
<?php if( $smof_data['mobile_menu_font_size'] > 30 ): ?>
  .fusion-open-submenu {
    font-size: 20px;
  }
<?php endif; ?>
.fusion-open-submenu:hover {
  color: <?php echo $smof_data['primary_color']; ?>
}
/* Shortcodes
================================================================================================= */
#wrapper .post-content .content-box-heading {
  font-size: <?php echo $smof_data['content_box_title_size']; ?>px;
  line-height: <?php echo $smof_data['h2_font_lh']; ?>px;
}
/* Social Links
================================================================================================= */
.fusion-social-links-header .fusion-social-networks a {
  font-size: <?php echo $smof_data['header_social_links_font_size']; ?>px;
}
.fusion-social-links-header .fusion-social-networks.boxed-icons a {
  padding: <?php echo $smof_data['header_social_links_boxed_padding']; ?>px;
}
.fusion-social-links-footer .fusion-social-networks a {
  font-size: <?php echo $smof_data['footer_social_links_font_size']; ?>px;
}
.fusion-social-links-footer .fusion-social-networks.boxed-icons a {
  padding: <?php echo $smof_data['footer_social_links_boxed_padding']; ?>px;
}
.fusion-sharing-box .fusion-social-networks a {
  font-size: <?php echo $smof_data['sharing_social_links_font_size']; ?>px;
}
.fusion-sharing-box .fusion-social-networks.boxed-icons a {
  padding: <?php echo $smof_data['sharing_social_links_boxed_padding']; ?>px;
}
.post-content .fusion-social-links .fusion-social-networks a {
  font-size: <?php echo $smof_data['social_links_font_size']; ?>px;
}
.post-content .fusion-social-links .fusion-social-networks.boxed-icons a {
  padding: <?php echo $smof_data['social_links_boxed_padding']; ?>px;
}

<?php if( class_exists( 'Woocommerce' ) ): // is_woo ?>
/* Woocommerce - Dynamic Styling
  ================================================================================================= */
.product-images .crossfade-images {
  background: <?php echo $smof_data['title_border_color']; ?>;
}
.products .product-list-view {
  border-color: <?php echo $smof_data['sep_color']; ?>;
}
.products .product-list-view .product-excerpt-container,
.products .product-list-view .product-details-container {
  border-color: <?php echo $smof_data['sep_color']; ?>;
}
.order-dropdown {
  color: <?php echo $smof_data['woo_dropdown_text_color']; ?>;
}
.order-dropdown > li:after {
  border-color: <?php echo $smof_data['woo_dropdown_border_color']; ?>;
}
.order-dropdown a,
.order-dropdown a:hover {
  color: <?php echo $smof_data['woo_dropdown_text_color']; ?>;
}
.order-dropdown .current-li,
.order-dropdown ul li a {
  background-color: <?php echo $smof_data['woo_dropdown_bg_color']; ?>;
  border-color: <?php echo $smof_data['woo_dropdown_border_color']; ?>;
}
.order-dropdown ul li a:hover {
  color: <?php echo $smof_data['woo_dropdown_text_color']; ?>;
  <?php if( $smof_data['woo_dropdown_bg_color'] ): ?>
  background-color: <?php echo fusion_color_luminance( $smof_data['woo_dropdown_bg_color'], 0.1 ); ?>;
  <?php endif; ?>
}
.catalog-ordering .order li a {
  color: <?php echo $smof_data['woo_dropdown_text_color']; ?>;
  background-color: <?php echo $smof_data['woo_dropdown_bg_color']; ?>;
  border-color: <?php echo $smof_data['woo_dropdown_border_color']; ?>;
}
.fusion-grid-list-view {
  border-color: <?php echo $smof_data['woo_dropdown_border_color']; ?>;
}
.fusion-grid-list-view li {
  background-color: <?php echo $smof_data['woo_dropdown_bg_color']; ?>;
  border-color: <?php echo $smof_data['woo_dropdown_border_color']; ?>;
}
.fusion-grid-list-view a {
  color: <?php echo $smof_data['woo_dropdown_text_color']; ?>;
}
.fusion-grid-list-view li a:hover {
  color: <?php echo $smof_data['woo_dropdown_text_color']; ?>;
  <?php if( $smof_data['woo_dropdown_bg_color'] ): ?>
  background-color: <?php echo fusion_color_luminance( $smof_data['woo_dropdown_bg_color'], 0.1 ); ?>;
  <?php endif; ?>
}
.fusion-grid-list-view li.active-view {
  <?php if( $smof_data['woo_dropdown_bg_color'] ): ?>
  background-color: <?php echo fusion_color_luminance( $smof_data['woo_dropdown_bg_color'], 0.05 ); ?>;
  <?php endif; ?>
}
.fusion-grid-list-view li.active-view a i {
  <?php if( $smof_data['woo_dropdown_text_color'] ): ?>
  color: <?php echo fusion_color_luminance( $smof_data['woo_dropdown_text_color'], 0.95 ); ?>;
  <?php endif; ?>
}
<?php endif; ?>

<?php if( $smof_data['responsive'] ): // is responsive ?>
/* Media
  ================================================================================================= */
/* =================================================================================================
Table of Contents
----------------------------------------------------------------------------------------------------
  01 Side Header Mobile Styles
  02 only screen and ( max-width: 800px )
    # Layout
    # General Styles
    # Responsive Headers
    # Page Title Bar
    # Blog Layouts
    # Author Page - Info
  03 only screen and ( max-width: 640px )
    # General Styles
    # Page Title Bar
    # Blog Layouts
    # Filters
  04 only screen and ( min-device-width: 320px ) and ( max-device-width: 640px )
    # General Styles
    # Page Title Bar
  05 media.css CSS
  
================================================================================================= */
/* Side Header Mobile Styles
================================================================================================= */
@media only screen and (max-width: <?php echo $smof_data['side_header_break_point']; ?>) {
  body.side-header #wrapper {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }
  #side-header {
    position: static;
    height: auto;
    width: 100% !important;
    padding: 20px 30px 20px 30px !important;
    margin: 0 !important;
    border: none !important;
  }
  #side-header .side-header-wrapper {
    padding-bottom: 0;
  }
  body.rtl #side-header {
    position: static !important;
  }
  #side-header .header-social,
  #side-header .header-v4-content {
    display: none;
  }
  #side-header .fusion-logo {
    margin: 0 !important;
    float: left;
  }
  #side-header .side-header-content {
    padding: 0 !important;
  }
  #side-header.fusion-mobile-menu-design-classic .fusion-logo {
    float: none;
    text-align: center;
  }
  body.side-header #wrapper #side-header.header-shadow:after,
  body #wrapper .header-shadow:after {
    position: static;
    height: auto;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
  }
  /* Side Header */
  #side-header .fusion-main-menu,
  #side-header .side-header-content-1-2,
  #side-header .side-header-content-3 {
    display: none;
  }
  #side-header .fusion-logo {
    margin: 0;
  }
  #side-header.fusion-mobile-menu-design-classic .fusion-main-menu-container .fusion-mobile-nav-holder {
    display: block;
    margin-top: 20px;
  }
  #side-header.fusion-mobile-menu-design-classic .fusion-main-menu-container .fusion-mobile-sticky-nav-holder {
    display: none;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-logo {
    float: left;
    margin: 0;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-logo-left {
    float: left;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-logo-right {
    float: right;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-logo-center {
    float: left;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-mobile-menu-icons {
    display: block;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-logo-menu-right .fusion-mobile-menu-icons {
    float: left;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-logo-menu-left .fusion-mobile-menu-icons {
    float: right;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-logo-menu-left .fusion-mobile-menu-icons a:last-child {
    margin-left: 0;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-main-menu-container .fusion-mobile-nav-holder {
    padding-top: 20px;
    margin-left: -30px;
    margin-right: -30px;
    margin-bottom: -20px;
  }
  #side-header.fusion-mobile-menu-design-modern .fusion-main-menu-container .fusion-mobile-nav-holder > ul {
    display: block;
    border-right: 0;
    border-left: 0;
    border-bottom: 0;
  }
  #side-header.fusion-is-sticky.fusion-sticky-menu-1 .fusion-mobile-nav-holder {
    display: none;
  }
  #side-header.fusion-is-sticky.fusion-sticky-menu-1 .fusion-mobile-sticky-nav-holder {
    display: block;
  }
}
/* only screen and ( max-width: 800px )
================================================================================================= */
@media only screen and (max-width: <?php echo ( $side_header_width + 800 ) . 'px'; ?>) {
  /* Layout */
  .no-overflow-y {
    overflow-y: visible !important;
  }
  .fusion-layout-column {
    margin-left: 0;
    margin-right: 0;
  }
  .fusion-layout-column:nth-child(5n),
  .fusion-layout-column:nth-child(4n),
  .fusion-layout-column:nth-child(3n),
  .fusion-layout-column:nth-child(2n) {
    margin-left: 0;
    margin-right: 0;
  }
  .fusion-layout-column.fusion-spacing-no {
    margin-bottom: 0;
    width: 100%;
  }
  .fusion-layout-column.fusion-spacing-yes {
    width: 100%;
  }
  /* General Styles */
  .fusion-filters {
    border-bottom: 0;
  }
  .fusion-body .fusion-filter {
    float: none;
    margin: 0;
    border-bottom: 1px solid #E7E6E6;
  }
  /* Responsive Headers */
  .fusion-header .fusion-row {
    padding-left: 0;
    padding-right: 0;
  }
  .fusion-header-wrapper .fusion-header,
  .fusion-header-wrapper #side-header,
  .fusion-header-wrapper .fusion-secondary-main-menu {
    background-color: <?php echo $smof_data['mobile_header_bg_color']; ?>;
  }
  .fusion-header-wrapper .fusion-row {
    padding-left: 0;
    padding-right: 0;
  }
  .fusion-footer-widget-area > .fusion-row,
  .fusion-footer-copyright-area > .fusion-row {
    padding-left: 0;
    padding-right: 0;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v1 .fusion-header,
  .fusion-mobile-menu-design-classic.fusion-header-v2 .fusion-header,
  .fusion-mobile-menu-design-classic.fusion-header-v3 .fusion-header {
    padding-top: 20px;
    padding-bottom: 20px;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v1 .fusion-logo,
  .fusion-mobile-menu-design-classic.fusion-header-v2 .fusion-logo,
  .fusion-mobile-menu-design-classic.fusion-header-v3 .fusion-logo,
  .fusion-mobile-menu-design-classic.fusion-header-v1 .fusion-logo a,
  .fusion-mobile-menu-design-classic.fusion-header-v2 .fusion-logo a,
  .fusion-mobile-menu-design-classic.fusion-header-v3 .fusion-logo a {
    float: none;
    text-align: center;
    margin: 0 !important;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v1 .fusion-main-menu,
  .fusion-mobile-menu-design-classic.fusion-header-v2 .fusion-main-menu,
  .fusion-mobile-menu-design-classic.fusion-header-v3 .fusion-main-menu {
    display: none;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v1 .fusion-mobile-nav-holder,
  .fusion-mobile-menu-design-classic.fusion-header-v2 .fusion-mobile-nav-holder,
  .fusion-mobile-menu-design-classic.fusion-header-v3 .fusion-mobile-nav-holder {
    display: block;
    margin-top: 20px;
  }
  .fusion-mobile-menu-design-classic .fusion-secondary-header {
    padding: 10px;
  }
  .fusion-mobile-menu-design-classic .fusion-secondary-header .fusion-mobile-nav-holder {
    margin-top: 0;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-header,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .fusion-header {
    padding-top: 20px;
    padding-bottom: 20px;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-secondary-main-menu,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .fusion-secondary-main-menu {
    padding-top: 6px;
    padding-bottom: 6px;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-main-menu,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .fusion-main-menu {
    display: none;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-mobile-nav-holder,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .fusion-mobile-nav-holder {
    display: block;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-logo,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .fusion-logo,
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-logo a,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .fusion-logo a {
    float: none;
    text-align: center;
    margin: 0 !important;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .searchform,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .searchform {
    display: block;
    float: none;
    width: 100%;
    margin: 0;
    margin-top: 13px;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .search-table,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .search-table {
    width: 100%;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-logo a {
    float: none;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-header-banner {
    margin-top: 10px;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-secondary-main-menu .searchform {
    display: none;
  }
  .fusion-mobile-menu-design-classic .fusion-alignleft {
    margin-bottom: 10px;
  }
  .fusion-mobile-menu-design-classic .fusion-alignleft,
  .fusion-mobile-menu-design-classic .fusion-alignright {
    float: none;
    width: 100%;
    line-height: normal;
    display: block;
  }
  .fusion-mobile-menu-design-classic .fusion-contact-info {
    text-align: center;
    line-height: normal;
  }
  .fusion-mobile-menu-design-classic .fusion-secondary-menu {
    display: none;
  }
  .fusion-mobile-menu-design-classic .fusion-social-links-header {
    max-width: 100%;
    margin-top: 10px;
    margin-bottom: 5px;
    text-align: center;
  }
  .fusion-mobile-menu-design-classic .fusion-header-tagline {
    float: none;
    text-align: center;
    margin-top: 10px;
    line-height: 24px;
  }
  .fusion-mobile-menu-design-classic .fusion-header-banner {
    float: none;
    text-align: center;
    margin: 0 auto;
    width: 100%;
    margin-top: 20px;
    clear: both;
  }
  .fusion-mobile-menu-design-modern .ubermenu-responsive-toggle, 
  .fusion-mobile-menu-design-modern .ubermenu-sticky-toggle-wrapper {
  	clear: both;
  }
  
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-main-menu,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-main-menu,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-main-menu,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-main-menu,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-main-menu {
    display: none;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-header,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-header,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-header,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-header,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-header {
    padding-top: 20px;
    padding-bottom: 20px;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-header .fusion-row,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-header .fusion-row,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-header .fusion-row,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-header .fusion-row,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-header .fusion-row {
    width: 100%;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-logo {
    margin: 0 !important;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v1 .modern-mobile-menu-expanded .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .modern-mobile-menu-expanded .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .modern-mobile-menu-expanded .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .modern-mobile-menu-expanded .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .modern-mobile-menu-expanded .fusion-logo {
    margin-bottom: 20px !important;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-mobile-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-mobile-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-mobile-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-mobile-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-mobile-nav-holder {
    padding-top: 20px;
    margin-left: -30px;
    margin-right: -30px;
    margin-bottom: -20px;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-mobile-sticky-nav-holder {
    display: none;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-mobile-menu-icons,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-mobile-menu-icons,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-mobile-menu-icons,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-mobile-menu-icons,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-mobile-menu-icons {
    display: block;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-mobile-nav-holder > ul,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-mobile-nav-holder > ul,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-mobile-nav-holder > ul,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-mobile-nav-holder > ul,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-mobile-nav-holder > ul {
    display: block;
  }
  .fusion-mobile-menu-design-modern .fusion-secondary-header {
    padding: 0px;
  }
  .fusion-mobile-menu-design-modern .fusion-secondary-header .fusion-row {
    padding-left: 0px;
    padding-right: 0px;
  }
  .fusion-mobile-menu-design-modern .fusion-social-links-header {
    max-width: 100%;
    text-align: center;
  }
  .fusion-mobile-menu-design-modern .fusion-social-links-header a {
    margin-right: 20px;
    margin-bottom: 5px;
  }
  .fusion-mobile-menu-design-modern .fusion-alignleft {
    border-bottom: 1px solid transparent;
  }
  .fusion-mobile-menu-design-modern .fusion-alignleft,
  .fusion-mobile-menu-design-modern .fusion-alignright {
    width: 100%;
    float: none;
    text-align: center;
    display: block;
  }
  .fusion-mobile-menu-design-modern .fusion-secondary-menu > ul > li {
    display: inline-block;
    float: none;
    text-align: left;
  }
  .fusion-mobile-menu-design-modern .fusion-secondary-menu-cart {
    border-right: 0;
  }
  .fusion-mobile-menu-design-modern .fusion-secondary-menu-icon {
    background-color: transparent;
    padding-left: 10px;
    padding-right: 7px;
    min-width: 100%;
  }
  .fusion-mobile-menu-design-modern .fusion-secondary-menu-icon:after {
    display: none;
  }
  .fusion-mobile-menu-design-modern .fusion-secondary-menu .fusion-secondary-menu-icon,
  .fusion-mobile-menu-design-modern .fusion-secondary-menu .fusion-secondary-menu-icon:hover,
  .fusion-mobile-menu-design-modern .fusion-secondary-menu-icon:before {
    color: <?php echo $smof_data['snav_color']; ?>;
  }
  .fusion-mobile-menu-design-modern .fusion-header-tagline {
    margin-top: 10px;
    float: none;
    line-height: 24px;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-logo {
    width: 50%;
    float: left;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-logo a {
    float: none;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-logo .searchform {
    float: none;
    display: none;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-header-banner {
    margin-top: 10px;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v5.fusion-logo-center .fusion-logo {
    float: left;
  }
  .rtl .fusion-mobile-menu-design-modern.fusion-header-v5.fusion-logo-center .fusion-logo {
    float: right;
  }
  .rtl .fusion-mobile-menu-design-modern.fusion-header-v5.fusion-logo-center .fusion-mobile-menu-icons {
    float: left;
  }
  .rtl .fusion-mobile-menu-design-modern.fusion-header-v5.fusion-logo-center .fusion-mobile-menu-icons a {
    float: left;
    margin-left: 0;
    margin-right: 15px;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-mobile-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-mobile-nav-holder {
    padding-top: 0;
    margin-left: -30px;
    margin-right: -30px;
    margin-bottom: 0;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-secondary-main-menu,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-secondary-main-menu {
    position: static;
    border: 0;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-secondary-main-menu .fusion-mobile-nav-holder > ul,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-secondary-main-menu .fusion-mobile-nav-holder > ul {
    border: 0;
  }
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-secondary-main-menu .searchform,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-secondary-main-menu .searchform {
    float: none;
  }
  .fusion-is-sticky .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-sticky-header-wrapper,
  .fusion-is-sticky .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-sticky-header-wrapper {
    position: fixed;
    width: 100%;
  }
  .fusion-mobile-menu-design-modern.fusion-logo-right.fusion-header-v4 .fusion-logo,
  .fusion-mobile-menu-design-modern.fusion-logo-right.fusion-header-v5 .fusion-logo {
    float: right;
  }
  .fusion-mobile-menu-design-modern.fusion-sticky-menu-only.fusion-header-v4 .fusion-secondary-main-menu,
  .fusion-mobile-menu-design-modern.fusion-sticky-menu-only.fusion-header-v5 .fusion-secondary-main-menu {
    position: static;
  }
  .fusion-mobile-menu-design-modern.fusion-sticky-menu-only.fusion-header-v4 .fusion-header-tagline,
  .fusion-mobile-menu-design-modern.fusion-sticky-menu-only.fusion-header-v5 .fusion-header-tagline {
    display: none;
  }
  .fusion-mobile-menu-design-classic.fusion-header-v1 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v1 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-classic.fusion-header-v2 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v2 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-classic.fusion-header-v3 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v3 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-classic.fusion-header-v4 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v4 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-classic.fusion-header-v5 .fusion-mobile-sticky-nav-holder,
  .fusion-mobile-menu-design-modern.fusion-header-v5 .fusion-mobile-sticky-nav-holder {
    display: none;
  }
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v1.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-modern.fusion-header-v1.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v2.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-modern.fusion-header-v2.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v3.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-modern.fusion-header-v3.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v4.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-modern.fusion-header-v4.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v5.fusion-sticky-menu-1 .fusion-mobile-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-modern.fusion-header-v5.fusion-sticky-menu-1 .fusion-mobile-nav-holder {
    display: none;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-item,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-item,
  .fusion-mobile-menu-design-classic .fusion-mobile-selector,
  .fusion-mobile-menu-design-modern .fusion-mobile-selector {
    <?php if( $smof_data['mobile_menu_text_align'] == 'left' ): ?>
      text-align: left;
    <?php endif; ?>

    <?php if( $smof_data['mobile_menu_text_align'] == 'center' ): ?>
      text-align: center;
    <?php endif; ?>

    <?php if( $smof_data['mobile_menu_text_align'] == 'right' ): ?>
      text-align: right;
    <?php endif; ?>
  }
  <?php if( $smof_data['mobile_menu_text_align'] == 'right' ): ?>
  .fusion-mobile-menu-design-classic .fusion-selector-down,
  .fusion-mobile-menu-design-modern .fusion-selector-down {
    left: 7px;
    right: 0px;
    border-left: 0px;
    border-right-width: 1px;
    border-right-style: solid;
  }
  .fusion-mobile-menu-design-classic .fusion-selector-down:before,
  .fusion-mobile-menu-design-modern .fusion-selector-down:before {
    margin-left: 0;
    margin-right: 12px;
  }
  .fusion-mobile-menu-design-classic .fusion-open-submenu,
  .fusion-mobile-menu-design-modern .fusion-open-submenu {
    right: auto;
    left: 0;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item a:before,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item a:before {
    display: none;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item li a,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item li a {
    padding-right: 27px;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item li a:after,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item li a:after {
    content: "-";
    margin-right: -6px;
    margin-left: 2px;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li a,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li a {
    padding-right: 40px;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li a:after,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li a:after {
    content: "--";
    margin-right: -10px;
    margin-left: 2px;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li li a,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li li a {
    padding-right: 53px;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li li a:after,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li li a:after {
    content: "---";
    margin-right: -14px;
    margin-left: 2px;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li li li a,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li li li a {
    padding-right: 66px;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li li li a:after,
  .fusion-mobile-menu-design-modern .fusion-mobile-nav-holder li.fusion-mobile-nav-item li li li li a:after {
    content: "----";
    margin-right: -18px;
    margin-left: 2px;
  }
  <?php endif; ?>
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v1.fusion-sticky-menu-1 .fusion-mobile-sticky-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v2.fusion-sticky-menu-1 .fusion-mobile-sticky-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v3.fusion-sticky-menu-1 .fusion-mobile-sticky-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v4.fusion-sticky-menu-1 .fusion-mobile-sticky-nav-holder,
  .fusion-is-sticky .fusion-mobile-menu-design-classic.fusion-header-v5.fusion-sticky-menu-1 .fusion-mobile-sticky-nav-holder {
    display: block;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder .fusion-secondary-menu-icon {
    text-align: inherit;
  }
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder .fusion-secondary-menu-icon:before,
  .fusion-mobile-menu-design-classic .fusion-mobile-nav-holder .fusion-secondary-menu-icon:after {
    display: none;
  }
  /* Page Title Bar */
  .fusion-body .fusion-page-title-bar {
    <?php if( $smof_data['page_title_mobile_height'] != 'auto' ): ?>
      padding-top: 5px;
      padding-bottom: 5px;
      min-height: <?php echo fusion_strip_unit( $smof_data['page_title_mobile_height'] ) - 10; ?>px;
      height: auto;
    <?php endif ?>

    <?php if( $smof_data['page_title_mobile_height'] == 'auto' ): ?>
      padding-top: 10px;
      padding-bottom: 10px;
      height: auto;
    <?php endif; ?>
  }
  
	.fusion-page-title-row {
		height: auto;
	}  
  
  .fusion-page-title-bar-left .fusion-page-title-captions,
  .fusion-page-title-bar-right .fusion-page-title-captions,
  .fusion-page-title-bar-left .fusion-page-title-secondary,
  .fusion-page-title-bar-right .fusion-page-title-secondary {
    display: block;
    float: none;
    width: 100%;
    line-height: normal;
  }
  .fusion-page-title-bar-left .fusion-page-title-secondary {
    text-align: left;
  }
  .fusion-page-title-bar-left .searchform {
    display: block;
  }
  .fusion-page-title-bar-left .searchform {
    max-width: 100%;
  }
  .fusion-page-title-bar-right .fusion-page-title-secondary {
    text-align: right;
  }
  .fusion-page-title-bar-right .searchform {
    max-width: 100%;
  }
  <?php if( $smof_data['page_title_mobile_height'] != 'auto' ): ?>
  .fusion-page-title-row {
    display: table;
    width: 100%;
    min-height: <?php echo fusion_strip_unit( $smof_data['page_title_mobile_height'] ) - 20; ?>px;
  }
  
  .fusion-page-title-bar-center .fusion-page-title-row {
  	width: auto;
  }
  
  .fusion-page-title-wrapper {
    display: table-cell;
    vertical-align: middle;
  }
  <?php endif; ?>
  /* Blog medium alternate layout */
  .fusion-body .fusion-blog-layout-medium-alternate .fusion-post-content,
  .fusion-body .fusion-blog-layout-medium-alternate .has-post-thumbnail .fusion-post-content {
    float: none;
    clear: both;
    margin: 0;
    padding-top: 20px;
  }
  /* Author Page - Info */
  .fusion-author .fusion-social-networks {
    text-align: center;
  }
  .fusion-author .fusion-social-networks .fusion-social-network-icon:first-child {
    margin-left: 0;
  }
  .fusion-author-tagline {
    float: none;
    text-align: center;
    max-width: 100%;
  }
  /* Mobile Logo */
  .fusion-mobile-logo-1 .fusion-standard-logo,
  #side-header .fusion-mobile-logo-1 .fusion-standard-logo {
    display: none;
  }
  .fusion-mobile-logo-1 .fusion-mobile-logo-1x,
  #side-header .fusion-mobile-logo-1 .fusion-mobile-logo-1x {
    display: inline-block;
  }
  .fusion-secondary-menu-icon {
    min-width: 100%;
  }
}
@media only screen and (max-width: <?php echo ( $side_header_width + 800 ) . 'px'; ?>) and (-webkit-min-device-pixel-ratio: 1.5), only screen and (max-width: <?php echo ( $side_header_width + 800 ) . 'px'; ?>) and (min-resolution: 144dpi), only screen and (max-width: <?php echo ( $side_header_width + 800 ) . 'px'; ?>) and (min-resolution: 1.5dppx) {
  .fusion-mobile-logo-1 .fusion-mobile-logo-1x,
  #side-header .fusion-mobile-logo-1 .fusion-mobile-logo-1x {
    display: none;
  }
  .fusion-mobile-logo-1 .fusion-mobile-logo-2x,
  #side-header .fusion-mobile-logo-1 .fusion-mobile-logo-2x {
    display: inline-block;
  }
}
/* only screen and ( max-width: 640px )
================================================================================================= */
@media only screen and (max-width: <?php echo ( $side_header_width + 640 ) . 'px'; ?>) {
  /* Page Title Bar */
  .fusion-body .fusion-page-title-bar {
    max-height: none;
  }
  .fusion-body .fusion-page-title-bar h1 {
    margin: 0;
  }
  .fusion-body .fusion-page-title-secondary {
    margin-top: 2px;
  }
  /* Blog general styles */
  .fusion-blog-layout-large .fusion-meta-info .fusion-alignleft,
  .fusion-blog-layout-medium .fusion-meta-info .fusion-alignleft,
  .fusion-blog-layout-large .fusion-meta-info .fusion-alignright,
  .fusion-blog-layout-medium .fusion-meta-info .fusion-alignright {
    display: block;
    float: none;
    margin: 0;
    width: 100%;
  }
  /* Blog medium layout */
  .fusion-body .fusion-blog-layout-medium .fusion-post-slideshow {
    float: none;
    margin: 0 0 20px 0;
    height: auto;
    width: auto;
  }
  /* Blog large alternate layout */
  .fusion-blog-layout-large-alternate .fusion-date-and-formats {
    margin-bottom: 55px;
  }
  .fusion-body .fusion-blog-layout-large-alternate .fusion-post-content {
    margin: 0;
  }
  /* Blog medium alternate layout */
  .fusion-blog-layout-medium-alternate .has-post-thumbnail .fusion-post-slideshow {
    display: inline-block;
    float: none;
    margin-right: 0;
    max-width: 197px;
  }
  /* Blog grid layout */
  .fusion-blog-layout-grid .fusion-post-grid {
    position: static;
    width: 100%;
  }
}
/* media.css CSS
================================================================================================= */
@media only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait) {
  .fusion-secondary-header .fusion-row,
  .fusion-header .fusion-row,
  .footer-area > .fusion-row,
  #footer > .fusion-row {
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
}
@media only screen and (max-width: <?php echo ( $side_header_width + 1000 ) . 'px'; ?>) {
  .no-csstransforms .sep-boxed-pricing .column {
    margin-left: 1.5% !important;
  }
}
@media only screen and (max-width: <?php echo ( $side_header_width + 965 ) . 'px'; ?>) {
  #wrapper .woocommerce-tabs .tabs,
  #wrapper .woocommerce-tabs .panel {
    float: none;
    margin-left: auto;
    margin-right: auto;
    width: 100% !important;
  }
  .woocommerce-tabs .tabs,
  .woocommerce-side-nav {
    margin-bottom: 25px;
  }
  .coupon .input-text {
    width: 100% !important;
  }
  .coupon .button {
    margin-top: 20px;
  }
}
@media only screen and (max-width: <?php echo ( $side_header_width + 900 ) . 'px'; ?>) {
  .woocommerce #customer_login .login .form-row,
  .woocommerce #customer_login .login .lost_password {
    float: none;
  }
  .woocommerce #customer_login .login .inline,
  .woocommerce #customer_login .login .lost_password {
    display: block;
    margin-left: 0;
    margin-right: 0;
  }
}
@media only screen and (min-width: 800px) {
  body.side-header-right.layout-boxed-mode #side-header {
    position: absolute;
    top: 0;
  }
  body.side-header-right.layout-boxed-mode #side-header .side-header-wrapper {
    position: fixed;
  }
}
@media only screen and (max-width: 800px) {
  .fusion-columns-5 .fusion-column:first-child,
  .fusion-columns-4 .fusion-column:first-child,
  .fusion-columns-3 .fusion-column:first-child,
  .fusion-columns-2 .fusion-column:first-child,
  .fusion-columns-1 .fusion-column:first-child {
    margin-left: 0;
  }
  .fusion-columns-5 .col-lg-2,
  .fusion-columns-5 .col-md-2,
  .fusion-columns-5 .col-sm-2 {
    width: 100%;
  }
  .fusion-columns .fusion-column {
    float: none;
    width: 100% !important;
    margin: 0 0 50px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  
	.rtl .fusion-column {
		float: none;
	}  
  
  .avada-container .columns {
    float: none;
    width: 100%;
    margin-bottom: 20px;
  }
  .avada-container .columns .col {
    float: left;
  }
  .avada-container .col img {
    display: block;
    margin: 0 auto;
  }
  #wrapper {
    width: auto !important;
    /*overflow-x: hidden;*/
  }
  #main {
    padding-bottom: 50px;
  }
  .create-block-format-context {
    display: none;
  }
  .review {
    float: none;
    width: 100%;
  }
  .fusion-copyright-notice,
  .fusion-body .fusion-social-links-footer {
    display: block;
    text-align: center;
  }
  .fusion-social-links-footer {
    width: auto;
  }
  .fusion-social-links-footer .fusion-social-networks {
    display: inline-block;
    float: none;
    margin-top: 0;
  }
  .fusion-copyright-notice {
    padding: 0 0 15px;
  }
  .fusion-copyright-notice:after,
  .fusion-social-networks:after {
    content: "";
    display: block;
    clear: both;
  }
  .fusion-social-networks li,
  .fusion-copyright-notice li {
    float: none;
    display: inline-block;
  }
  .fusion-title {
    margin-top: 0px !important;
    margin-bottom: 20px !important;
  }
  #main .cart-empty {
    float: none;
    text-align: center;
    border-top: 1px solid;
    border-bottom: none;
    width: 100%;
    line-height: normal !important;
    height: auto !important;
    margin-bottom: 10px;
    padding-top: 10px;
  }
  #main .return-to-shop {
    float: none;
    border-top: none;
    border-bottom: 1px solid;
    width: 100%;
    text-align: center;
    line-height: normal !important;
    height: auto !important;
    padding-bottom: 10px;
  }
  .woocommerce .checkout_coupon .promo-code-heading {
    display: block;
    margin-bottom: 10px !important;
    float: none;
    text-align: center;
  }
  .woocommerce .checkout_coupon .coupon-contents {
    display: block;
    float: none;
    margin: 0;
  }
  .woocommerce .checkout_coupon .coupon-input {
    display: block;
    width: auto !important;
    float: none;
    text-align: center;
    margin-right: 0;
    margin-bottom: 10px !important;
  }
  .woocommerce .checkout_coupon .coupon-button {
    display: block;
    margin-right: 0;
    float: none;
    text-align: center;
  }
  #content.full-width {
    margin-bottom: 0;
  }
  .sidebar .social_links .social li {
    width: auto;
    margin-right: 5px;
  }
  #comment-input {
    margin-bottom: 0;
  }
  #comment-input input {
    width: 90%;
    float: none !important;
    margin-bottom: 10px;
  }
  #comment-textarea textarea {
    width: 90%;
  }
  .widget.facebook_like iframe {
    width: 100% !important;
    max-width: none !important;
  }
  .pagination {
    margin-top: 40px;
  }
  .portfolio-one .portfolio-item .image {
    float: none;
    width: auto;
    height: auto;
    margin-bottom: 20px;
  }
  h5.toggle span.toggle-title {
    width: 80%;
  }
  #wrapper .sep-boxed-pricing .panel-wrapper {
    padding: 0;
  }
  #wrapper .full-boxed-pricing .column,
  #wrapper .sep-boxed-pricing .column {
    float: none;
    margin-bottom: 10px;
    margin-left: 0;
    width: 100%;
  }
  .share-box {
    height: auto;
  }
  #wrapper .share-box h4 {
    float: none;
    line-height: 20px !important;
    margin-top: 0;
    padding: 0;
  }
  .share-box ul {
    float: none;
    overflow: hidden;
    padding: 0 25px;
    padding-bottom: 15px;
    margin-top: 0px;
  }
  .project-content .project-description {
    float: none !important;
  }
  .project-content .fusion-project-description-details {
    margin-bottom: 50px;
  }
  .project-content .project-description,
  .project-content .project-info {
    width: 100% !important;
  }
  .portfolio-half .flexslider {
    width: 100% !important;
  }
  .portfolio-half .project-content {
    width: 100% !important;
  }
  #style_selector {
    display: none;
  }
  .ls-avada .ls-nav-prev,
  .ls-avada .ls-nav-next {
    display: none !important;
  }
  #footer .social-networks {
    width: 100%;
    margin: 0 auto;
    position: relative;
    left: -11px;
  }
  .tab-holder .tabs {
    height: auto !important;
    width: 100% !important;
  }
  .shortcode-tabs .tab-hold .tabs li {
    width: 100% !important;
  }
  body .shortcode-tabs .tab-hold .tabs li,
  body.dark .sidebar .tab-hold .tabs li {
    border-right: none !important;
  }
  .error-message {
    line-height: 170px;
    margin-top: 20px;
  }
  .error_page .useful_links {
    width: 100%;
    padding-left: 0;
  }
  .fusion-google-map {
    width: 100% !important;
    margin-bottom: 20px !important;
  }
  .social_links_shortcode .social li {
    width: 10% !important;
  }
  #wrapper .ei-slider {
    width: 100% !important;
  }
  #wrapper .ei-slider {
    height: 200px !important;
  }
  .progress-bar {
    margin-bottom: 10px !important;
  }
  #wrapper .content-boxes-icon-boxed .content-wrapper-boxed {
    min-height: inherit !important;
    padding-bottom: 20px;
    padding-left: 3%;
    padding-right: 3%;
  }
  #wrapper .content-boxes-icon-on-top .content-box-column,
  #wrapper .content-boxes-icon-boxed .content-box-column {
    margin-bottom: 55px;
  }
  .fusion-counters-box .fusion-counter-box {
    margin-bottom: 20px;
    padding: 0 15px;
  }
  .fusion-counters-box .fusion-counter-box:last-child {
    margin-bottom: 0;
  }
  .popup {
    display: none !important;
  }
  .share-box .social-networks {
    text-align: left;
  }
  .fusion-body .products li {
    width: 225px;
  }
  .products li,
  #wrapper .catalog-ordering > ul,
  #main .products li:nth-child(3n),
  #main .products li:nth-child(4n),
  #main .has-sidebar .products li,
  .avada-myaccount-data .addresses .col-1,
  .avada-myaccount-data .addresses .col-2,
  .avada-customer-details .addresses .col-1,
  .avada-customer-details .addresses .col-2 {
    float: none !important;
    margin-left: auto !important;
    margin-right: auto !important;
  }
  .avada-myaccount-data .addresses .col-1,
  .avada-myaccount-data .addresses .col-2,
  .avada-customer-details .addresses .col-1,
  .avada-customer-details .addresses .col-2 {
    margin: 0 !important;
    width: 100%;
  }
  #wrapper .catalog-ordering {
    margin-bottom: 50px;
  }
  #wrapper .catalog-ordering .order {
    width: 33px;
  }
  #wrapper .catalog-ordering > ul,
  .catalog-ordering .order {
    margin-bottom: 10px;
  }
  #wrapper .order-dropdown > li:hover > ul {
    display: block;
    position: relative;
    top: 0;
  }
  #wrapper .orderby-order-container {
    overflow: hidden;
    margin: 0 auto;
    width: 215px;
    margin-bottom: 10px;
    float: none;
  }
  #wrapper .orderby.order-dropdown {
    float: left;
    margin-right: 6px;
  }
  #wrapper .sort-count.order-dropdown {
    width: 215px;
  }
  #wrapper .sort-count.order-dropdown ul a {
    width: 215px;
  }
  #wrapper .catalog-ordering .order {
    float: left;
    margin: 0;
  }
  .rtl #wrapper .orderby.order-dropdown {
    float: right;
    margin: 0;
  }
  .rtl #wrapper .catalog-ordering .order {
    float: right;
    margin-right: 6px;
  }
  .fusion-grid-list-view {
    width: 74px;
  }
  .woocommerce #customer_login .login .form-row,
  .woocommerce #customer_login .login .lost_password {
    float: none;
  }
  .woocommerce #customer_login .login .inline,
  .woocommerce #customer_login .login .lost_password {
    display: block;
    margin-left: 0;
  }
  .avada-myaccount-data .my_account_orders .order-number {
    padding-right: 8px;
  }
  .avada-myaccount-data .my_account_orders .order-actions {
    padding-left: 8px;
  }
  .shop_table .product-name {
    width: 35%;
  }
  form.checkout .shop_table tfoot th {
    padding-right: 20px;
  }
  #wrapper .product .images,
  #wrapper .product .summary.entry-summary,
  #wrapper .woocommerce-tabs .tabs,
  #wrapper .woocommerce-tabs .panel,
  #wrapper .woocommerce-side-nav,
  #wrapper .woocommerce-content-box,
  #wrapper .shipping-coupon,
  #wrapper .cart-totals-buttons,
  #wrapper #customer_login .col-1,
  #wrapper #customer_login .col-2,
  #wrapper .woocommerce form.checkout #customer_details .col-1,
  #wrapper .woocommerce form.checkout #customer_details .col-2 {
    float: none;
    margin-left: auto;
    margin-right: auto;
    width: 100% !important;
  }
  #customer_login .col-1,
  .coupon {
    margin-bottom: 20px;
  }
  .shop_table .product-thumbnail {
    float: none;
  }
  .product-info {
    margin-left: 0;
    margin-top: 10px;
  }
  .product .entry-summary div .price {
    float: none;
  }
  .product .entry-summary .woocommerce-product-rating {
    float: none;
    margin-left: 0;
  }
  .woocommerce-tabs .tabs,
  .woocommerce-side-nav {
    margin-bottom: 25px;
  }
  .woocommerce-tabs .panel {
    width: 91% !important;
    padding: 4% !important;
  }
  #reviews li .avatar {
    display: none;
  }
  #reviews li .comment-text {
    width: 90% !important;
    margin-left: 0 !important;
    padding: 5% !important;
  }
  .woocommerce-container .social-share {
    overflow: hidden;
  }
  .woocommerce-container .social-share li {
    display: block;
    float: left;
    margin: 0 auto;
    border-right: 0 !important;
    border-left: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    width: 50%;
  }
  .has-sidebar .woocommerce-container .social-share li {
    width: 50%;
  }
  .myaccount_user_container span {
    width: 100%;
    float: none;
    display: block;
    padding: 5px 0px;
    border-right: 0;
  }
  .myaccount_user_container span.username {
    margin-top: 10px;
  }
  .myaccount_user_container span.view-cart {
    margin-bottom: 10px;
  }
  .rtl .myaccount_user_container span {
    border-left: 0;
  }
  .shop_table .product-thumbnail img,
  .shop_table .product-thumbnail .product-info,
  .shop_table .product-thumbnail .product-info p {
    float: none;
    width: 100%;
    margin: 0 !important;
    padding: 0;
  }
  .shop_table .product-thumbnail {
    padding: 10px 0px;
  }
  .product .images {
    margin-bottom: 30px;
  }
  #customer_login_box .button {
    float: left;
    margin-bottom: 15px;
  }
  #customer_login_box .remember-box {
    clear: both;
    display: block;
    padding: 0;
    width: 125px;
    float: left;
  }
  #customer_login_box .lost_password {
    float: left;
  }
  .wpcf7-form .wpcf7-text,
  .wpcf7-form .wpcf7-quiz,
  .wpcf7-form .wpcf7-number,
  .wpcf7-form textarea {
    float: none !important;
    width: 100% !important;
    box-sizing: border-box;
  }
  .gform_wrapper .right_label input.medium,
  .gform_wrapper .right_label select.medium,
  .gform_wrapper .left_label input.medium,
  .gform_wrapper .left_label select.medium {
    width: 35% !important;
  }
  .product .images #slider .flex-direction-nav,
  .product .images #carousel .flex-direction-nav {
    display: none !important;
  }
  .myaccount_user_container span.msg,
  .myaccount_user_container span:last-child {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }
  .fullwidth-box {
    background-attachment: scroll !important;
  }
  #toTop {
    bottom: 30px;
    border-radius: 4px;
    height: 40px;
    z-index: 10000;
  }
  #toTop:before {
    line-height: 38px;
  }
  #toTop:hover {
    background-color: #333333;
  }
  .no-mobile-totop .to-top-container {
    display: none;
  }
  .no-mobile-slidingbar #slidingbar-area {
    display: none;
  }
  .no-mobile-slidingbar.mobile-logo-pos-left .mobile-menu-icons {
    margin-right: 0;
  }
  .rtl.no-mobile-slidingbar.mobile-logo-pos-right .mobile-menu-icons {
    margin-left: 0;
  }
  .tfs-slider .slide-content-container .btn {
    min-height: 0 !important;
    padding-left: 30px;
    padding-right: 30px !important;
    height: 26px !important;
    line-height: 26px !important;
  }
  .fusion-soundcloud iframe {
    width: 100%;
  }
  .ua-mobile .fusion-page-title-bar,
  .ua-mobile .footer-area,
  .ua-mobile body,
  .ua-mobile #main {
    background-attachment: scroll !important;
  }
  .fusion-revslider-mobile-padding {
    padding-left: 30px !important;
    padding-right: 30px !important;
  }
}
@media screen and (max-width: 782px) {
  body.admin-bar #wrapper #slidingbar-area,
  body.layout-boxed-mode.side-header-right #slidingbar-area,
  .admin-bar p.demo_store {
    top: 46px;
  }
  body.body_blank.admin-bar {
    top: 45px;
  }
  html #wpadminbar {
    z-index: 99999 !important;
    position: fixed !important;
  }
}
@media screen and (max-width: 768px) {
  .fusion-tabs.vertical-tabs .tab-pane {
    max-width: none !important;
  }
}
@media screen and (max-width: 767px) {
  #content {
    width: 100% !important;
    margin-left: 0px !important;
  }
  .sidebar {
    width: 100% !important;
    float: none !important;
    margin-left: 0 !important;
    padding: 0 !important;
    clear: both;
  }
}
@media only screen and (min-device-width: 320px) and (max-device-width: 640px) {
  #wrapper {
    width: auto !important;
    overflow-x: hidden !important;
  }
  #main {
    padding-bottom: 50px;
  }
  .fusion-columns .fusion-column {
    float: none;
    width: 100% !important;
    margin: 0 0 50px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .footer-area .fusion-columns .fusion-column,
  #slidingbar-area .fusion-columns .fusion-column {
    float: left;
    width: 98% !important;
  }
  .avada-container .columns {
    float: none;
    width: 100%;
    margin-bottom: 20px;
  }
  .avada-container .columns .col {
    float: left;
  }
  .avada-container .col img {
    display: block;
    margin: 0 auto;
  }
  .review {
    float: none;
    width: 100%;
  }
  .social-networks,
  .copyright {
    float: none;
    padding: 0 0 15px;
    text-align: center;
  }
  .copyright:after,
  .social-networks:after {
    content: "";
    display: block;
    clear: both;
  }
  .social-networks li,
  .copyright li {
    float: none;
    display: inline-block;
  }
  .continue {
    display: none;
  }
  .mobile-button {
    display: block !important;
    float: none;
  }
  .title {
    margin-top: 0px !important;
    margin-bottom: 20px !important;
  }
  #content {
    width: 100% !important;
    float: none !important;
    margin-left: 0 !important;
    margin-bottom: 50px;
  }
  #content.full-width {
    margin-bottom: 0;
  }
  .sidebar {
    width: 100% !important;
    float: none !important;
  }
  .sidebar .social_links .social li {
    width: auto;
    margin-right: 5px;
  }
  #comment-input {
    margin-bottom: 0;
  }
  #comment-input input {
    width: 90%;
    float: none !important;
    margin-bottom: 10px;
  }
  #comment-textarea textarea {
    width: 90%;
  }
  .widget.facebook_like iframe {
    width: 100% !important;
    max-width: none !important;
  }
  .pagination {
    margin-top: 40px;
  }
  .portfolio-one .portfolio-item .image {
    float: none;
    width: auto;
    height: auto;
    margin-bottom: 20px;
  }
  h5.toggle span.toggle-title {
    width: 80%;
  }
  #wrapper .sep-boxed-pricing .panel-wrapper {
    padding: 0;
  }
  #wrapper .full-boxed-pricing .column,
  #wrapper .sep-boxed-pricing .column {
    float: none;
    margin-bottom: 10px;
    margin-left: 0;
    width: 100%;
  }
  .share-box {
    height: auto;
  }
  #wrapper .share-box h4 {
    float: none;
    line-height: 20px !important;
    margin-top: 0;
    padding: 0;
  }
  .share-box ul {
    float: none;
    overflow: hidden;
    padding: 0 25px;
    padding-bottom: 25px;
    margin-top: 0px;
  }
  .project-content .project-description {
    float: none !important;
  }
  .project-content .fusion-project-description-details {
    margin-bottom: 50px;
  }
  .project-content .project-description,
  .project-content .project-info {
    width: 100% !important;
  }
  .portfolio-half .flexslider {
    width: 100% !important;
  }
  .portfolio-half .project-content {
    width: 100% !important;
  }
  #style_selector {
    display: none;
  }
  .ls-avada .ls-nav-prev,
  .ls-avada .ls-nav-next {
    display: none !important;
  }
  #footer .social-networks {
    width: 100%;
    margin: 0 auto;
    position: relative;
    left: -11px;
  }
  .recent-works-items a {
    max-width: 64px;
  }
  .footer-area .flickr_badge_image img,
  #slidingbar-area .flickr_badge_image img {
    max-width: 64px;
    padding: 3px !important;
  }
  .tab-holder .tabs {
    height: auto !important;
    width: 100% !important;
  }
  .shortcode-tabs .tab-hold .tabs li {
    width: 100% !important;
  }
  body .shortcode-tabs .tab-hold .tabs li,
  body.dark .sidebar .tab-hold .tabs li {
    border-right: none !important;
  }
  .error_page .useful_links {
    width: 100%;
    padding-left: 0;
  }
  .fusion-google-map {
    width: 100% !important;
    margin-bottom: 20px !important;
  }
  .social_links_shortcode .social li {
    width: 10% !important;
  }
  #wrapper .ei-slider {
    width: 100% !important;
  }
  #wrapper .ei-slider {
    height: 200px !important;
  }
  .progress-bar {
    margin-bottom: 10px !important;
  }
  #wrapper .content-boxes-icon-boxed .content-wrapper-boxed {
    min-height: inherit !important;
    padding-bottom: 20px;
    padding-left: 3% !important;
    padding-right: 3% !important;
  }
  #wrapper .content-boxes-icon-on-top .content-box-column,
  #wrapper .content-boxes-icon-boxed .content-box-column {
    margin-bottom: 55px;
  }
  .share-box .social-networks {
    text-align: left;
  }
  #content {
    width: 100% !important;
    margin-left: 0px !important;
  }
  .sidebar {
    width: 100% !important;
    float: none !important;
    margin-left: 0 !important;
    padding: 0 !important;
    clear: both;
  }
}
@media only screen and (max-width: 640px) {
  .avada-container .columns .col,
  .footer-area .fusion-columns .fusion-column,
  #slidingbar-area .columns .col {
    float: none;
    width: 100%;
  }
  .wooslider-direction-nav,
  .wooslider-pauseplay,
  .flex-direction-nav {
    display: none;
  }
  .share-box ul li {
    margin-bottom: 10px;
    margin-right: 15px;
  }
  .buttons a {
    margin-right: 5px;
  }
  .ls-avada .ls-nav-prev,
  .ls-avada .ls-nav-next {
    display: none !important;
  }
  #wrapper .ei-slider {
    width: 100% !important;
  }
  #wrapper .ei-slider {
    height: 200px !important;
  }
  .progress-bar {
    margin-bottom: 10px !important;
  }
  #wrapper .content-boxes-icon-boxed .content-wrapper-boxed {
    min-height: inherit !important;
    padding-bottom: 20px;
    padding-left: 3% !important;
    padding-right: 3% !important;
  }
  #wrapper .content-boxes-icon-on-top .content-box-column,
  #wrapper .content-boxes-icon-boxed .content-box-column {
    margin-bottom: 55px;
  }
  #wrapper .content-boxes-icon-boxed .content-box-column .heading h2 {
    margin-top: -5px;
  }
  #wrapper .content-boxes-icon-boxed .content-box-column .more {
    margin-top: 12px;
  }
  .page-template-contact-php .fusion-google-map {
    height: 270px !important;
  }
  .share-box .social-networks li {
    margin-right: 20px !important;
  }
  .timeline-icon {
    display: none !important;
  }
  .timeline-layout {
    padding-top: 0 !important;
  }
  .fusion-counters-circle .counter-circle-wrapper {
    display: block;
    margin-right: auto;
    margin-left: auto;
  }
  .post-content .wooslider .wooslider-control-thumbs {
    margin-top: -10px;
  }
  body .wooslider .overlay-full.layout-text-left .slide-excerpt {
    padding: 20px !important;
  }
  .content-boxes-icon-boxed .col {
    box-sizing: border-box;
  }
  .social_links_shortcode li {
    height: 40px !important;
  }
  .products-slider .es-nav span {
    -webkit-transform: scale(0.5) !important;
    -moz-transform: scale(0.5) !important;
    -o-transform: scale(0.5) !important;
    transform: scale(0.5) !important;
  }
  .shop_table .product-quantity {
    display: none;
  }
  .shop_table .filler-td {
    display: none;
  }
  .my_account_orders .order-status {
    display: none;
  }
  .my_account_orders .order-date {
    display: none;
  }
  .my_account_orders .order-number time {
    display: block !important;
    font-size: 10px;
    line-height: normal;
  }
  .portfolio-masonry .portfolio-item {
    width: 100% !important;
  }
  #bbpress-forums #bbp-single-user-details #bbp-user-avatar img.avatar {
    width: 80px !important;
    height: 80px !important;
  }
  #bbpress-forums #bbp-single-user-details #bbp-user-avatar {
    width: 80px !important;
  }
  #bbpress-forums #bbp-single-user-details #bbp-user-navigation {
    margin-left: 110px !important;
  }
  #bbpress-forums #bbp-single-user-details #bbp-user-navigation .first-col {
    width: 47% !important;
  }
  #bbpress-forums #bbp-single-user-details #bbp-user-navigation .second-col {
    margin-left: 53% !important;
    width: 47% !important;
  }
  .table-1 table,
  .tkt-slctr-tbl-wrap-dv table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
  }
  .table-1 td,
  .table-1 th,
  .tkt-slctr-tbl-wrap-dv td,
  .tkt-slctr-tbl-wrap-dv th {
    white-space: nowrap;
  }
  .table-2 table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
  }
  .table-2 td,
  .table-2 th {
    white-space: nowrap;
  }
  .page-title-bar,
  .footer-area,
  body,
  #main {
    background-attachment: scroll !important;
  }
  .tfs-slider[data-animation="slide"] {
    height: auto !important;
  }
  #wrapper .share-box h4 {
    display: block;
    float: none;
    line-height: 20px !important;
    margin-top: 0;
    padding: 0;
    margin-bottom: 10px;
  }
  .fusion-sharing-box .fusion-social-networks {
    float: none;
    display: block;
    width: 100%;
    text-align: left;
  }
  #content {
    width: 100% !important;
    margin-left: 0px !important;
  }
  .sidebar {
    width: 100% !important;
    float: none !important;
    margin-left: 0 !important;
    padding: 0 !important;
    clear: both;
  }
  .fusion-hide-on-mobile {
    display: none;
  }
  /* Blog timeline layout */
  .fusion-blog-layout-timeline {
    padding-top: 0;
  }
  .fusion-blog-layout-timeline .fusion-post-timeline {
    float: none;
    width: 100%;
  }
  .fusion-blog-layout-timeline .fusion-timeline-date {
    margin-bottom: 0;
    margin-top: 2px;
  }
  .fusion-timeline-icon,
  .fusion-timeline-line,
  .fusion-timeline-circle,
  .fusion-timeline-arrow {
    display: none;
  }
}
@media only screen and (max-width: 480px) {
  #bbpress-forums .bbp-body div.bbp-reply-author {
    width: 71% !important;
  }
  .bbp-arrow {
    display: none;
  }
  div.bbp-submit-wrapper {
    float: right !important;
  }
}
@media only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait) {
  #wrapper .ei-slider {
    width: 100%;
  }
  .fullwidth-box,
  .page-title-bar,
  .fusion-footer-widget-area,
  body,
  #main {
    background-attachment: scroll !important;
  }
}
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) {
  #wrapper .ei-slider {
    width: 100%;
  }
  .fullwidth-box,
  .page-title-bar,
  .fusion-footer-widget-area,
  body,
  #main {
    background-attachment: scroll !important;
  }
}
@media only screen and (min-device-width: 768px) and (max-device-width: 1366px) {
  #wrapper .ei-slider {
    width: 100%;
  }
}
@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
  #wrapper .ei-slider {
    width: 100%;
  }
}
@media all and (max-width: 480px), all and (max-device-width: 480px) {
  body.fusion-body .gform_wrapper .ginput_container,
  body.fusion-body .gform_wrapper div.ginput_complex,
  body.fusion-body .gform_wrapper div.gf_page_steps,
  body.fusion-body .gform_wrapper div.gf_page_steps div,
  body.fusion-body .gform_wrapper .ginput_container input.small,
  body.fusion-body .gform_wrapper .ginput_container input.medium,
  body.fusion-body .gform_wrapper .ginput_container input.large,
  body.fusion-body .gform_wrapper .ginput_container select.small,
  body.fusion-body .gform_wrapper .ginput_container select.medium,
  body.fusion-body .gform_wrapper .ginput_container select.large,
  body.fusion-body .gform_wrapper .ginput_container textarea.small,
  body.fusion-body .gform_wrapper .ginput_container textarea.medium,
  body.fusion-body .gform_wrapper .ginput_container textarea.large,
  body.fusion-body .gform_wrapper .ginput_complex .ginput_right input[type=text],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_right input[type=url],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_right input[type=email],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_right input[type=tel],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_right input[type=number],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_right input[type=password],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_left input[type=text],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_left input[type=url],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_left input[type=email],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_left input[type=tel],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_left input[type=number],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_left input[type=password],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_full input[type=text],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_full input[type=url],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_full input[type=email],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_full input[type=tel],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_full input[type=number],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_full input[type=password],
  body.fusion-body .gform_wrapper .ginput_complex .ginput_full select,
  body.fusion-body .gform_wrapper input.gform_button.button,
  body.fusion-body .gform_wrapper input[type=submit],
  body.fusion-body .gform_wrapper .gfield_time_hour input,
  body.fusion-body .gform_wrapper .gfield_time_minute input,
  body.fusion-body .gform_wrapper .gfield_date_month input,
  body.fusion-body .gform_wrapper .gfield_date_day input,
  body.fusion-body .gform_wrapper .gfield_date_year input,
  .gfield_time_ampm .gravity-select-parent,
  body.fusion-body .gform_wrapper .ginput_complex input[type=text],
  body.fusion-body .gform_wrapper .ginput_complex input[type=url],
  body.fusion-body .gform_wrapper .ginput_complex input[type=email],
  body.fusion-body .gform_wrapper .ginput_complex input[type=tel],
  body.fusion-body .gform_wrapper .ginput_complex input[type=number],
  body.fusion-body .gform_wrapper .ginput_complex input[type=password],
  body.fusion-body .gform_wrapper .ginput_complex .gravity-select-parent,
  body.fusion-body .gravity-select-parent {
    width: 100% !important;
  }
  .gform_wrapper .gform_page_footer input[type=button],
  .gform_wrapper .gform_button {
    padding-left: 0;
    padding-right: 0;
  }
}

<?php if( ! $smof_data['ipad_potrait'] ): ?>
@media only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait) {
  .fusion-columns-5 .fusion-column:first-child,
  .fusion-columns-4 .fusion-column:first-child,
  .fusion-columns-3 .fusion-column:first-child,
  .fusion-columns-2 .fusion-column:first-child,
  .fusion-columns-1 .fusion-column:first-child {
    margin-left: 0;
  }
  .fusion-column:nth-child(5n),
  .fusion-column:nth-child(4n),
  .fusion-column:nth-child(3n),
  .fusion-column:nth-child(2n),
  .fusion-column {
    margin-right: 0;
  }
  #wrapper {
    width: auto !important;
    overflow-x: hidden;
  }
  #main {
    padding-bottom: 50px;
  }
  .create-block-format-context {
    display: none;
  }
  .columns .col {
    float: none;
    width: 100% !important;
    margin: 0 0 20px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .avada-container .columns {
    float: none;
    width: 100%;
    margin-bottom: 20px;
  }
  .avada-container .columns .col {
    float: left;
  }
  .avada-container .col img {
    display: block;
    margin: 0 auto;
  }
  .review {
    float: none;
    width: 100%;
  }
  .fusion-social-networks,
  .fusion-social-links-footer {
    display: block;
    text-align: center;
  }
  .fusion-social-links-footer {
    width: auto;
  }
  .fusion-social-links-footer .fusion-social-networks {
    display: inline-block;
    float: none;
  }
  .fusion-social-links-footer .fusion-social-networks .fusion-social-network-icon:first-child {
    margin-left: 0;
    margin-right: 0;
  }
  .fusion-social-networks {
    padding: 0 0 15px;
  }
  .fusion-author .fusion-author-ssocial .fusion-author-tagline {
    float: none;
    text-align: center;
    max-width: 100%;
  }
  .fusion-author .fusion-author-ssocial .fusion-social-networks {
    text-align: center;
  }
  .fusion-author .fusion-author-ssocial .fusion-social-networks .fusion-social-network-icon:first-child {
    margin-left: 0;
  }
  .fusion-social-networks:after,
  .fusion-social-networks:after {
    content: "";
    display: block;
    clear: both;
  }
  .fusion-social-networks li,
  .fusion-social-networks li {
    float: none;
    display: inline-block;
  }
  .fusion-reading-box-container .reading-box.reading-box-center,
  .fusion-reading-box-container .reading-box.reading-box-right {
    text-align: left;
  }
  .fusion-reading-box-container .continue {
    display: block;
  }
  .fusion-reading-box-container .mobile-button {
    display: none;
    float: none;
  }
  .fusion-title {
    margin-top: 0px !important;
    margin-bottom: 20px !important;
  }
  #main .cart-empty {
    float: none;
    text-align: center;
    border-top: 1px solid;
    border-bottom: none;
    width: 100%;
    line-height: normal !important;
    height: auto !important;
    margin-bottom: 10px;
    padding-top: 10px;
  }
  #main .return-to-shop {
    float: none;
    border-top: none;
    border-bottom: 1px solid;
    width: 100%;
    text-align: center;
    line-height: normal !important;
    height: auto !important;
    padding-bottom: 10px;
  }
  .woocommerce .checkout_coupon .promo-code-heading {
    display: block;
    margin-bottom: 10px !important;
    float: none;
    text-align: center;
  }
  .woocommerce .checkout_coupon .coupon-contents {
    display: block;
    float: none;
    margin: 0;
  }
  .woocommerce .checkout_coupon .coupon-input {
    display: block;
    width: auto !important;
    float: none;
    text-align: center;
    margin-right: 0;
    margin-bottom: 10px !important;
  }
  .woocommerce .checkout_coupon .coupon-button {
    display: block;
    margin-right: 0;
    float: none;
    text-align: center;
  }
  /* Page Title Bar */
  .fusion-body .fusion-page-title-bar {
    <?php if( $smof_data['page_title_mobile_height'] != 'auto' ): ?>
      height: <?php echo $smof_data['page_title_mobile_height']; ?>;
    <?php endif ?>

    <?php if( $smof_data['page_title_mobile_height'] == 'auto' ): ?>
      padding-top: 10px;
      padding-bottom: 10px;
      height: auto;
    <?php endif; ?>
  }
  .fusion-page-title-bar-left .fusion-page-title-captions,
  .fusion-page-title-bar-right .fusion-page-title-captions,
  .fusion-page-title-bar-left .fusion-page-title-secondary,
  .fusion-page-title-bar-right .fusion-page-title-secondary {
    display: block;
    float: none;
    width: 100%;
    line-height: normal;
  }
  .fusion-page-title-bar-left .fusion-page-title-secondary {
    text-align: left;
  }
  .fusion-page-title-bar-left .searchform {
    display: block;
  }
  .fusion-page-title-bar-left .searchform {
    max-width: 100%;
  }
  .fusion-page-title-bar-right .fusion-page-title-secondary {
    text-align: right;
  }
  .fusion-page-title-bar-right .searchform {
    max-width: 100%;
  }
  <?php if( $smof_data['page_title_mobile_height'] != 'auto' ): ?>
  .fusion-page-title-row {
    display: table;
    width: 100%;
    min-height: <?php echo fusion_strip_unit( $smof_data['page_title_mobile_height'] ) - 20; ?>px;
  }
  .fusion-page-title-wrapper {
    display: table-cell;
    vertical-align: middle;
  }
  <?php endif; ?>
  .sidebar .social_links .social li {
    width: auto;
    margin-right: 5px;
  }
  #comment-input {
    margin-bottom: 0;
  }
  #comment-input input {
    width: 90%;
    float: none !important;
    margin-bottom: 10px;
  }
  #comment-textarea textarea {
    width: 90%;
  }
  .pagination {
    margin-top: 40px;
  }
  .portfolio-one .portfolio-item .image {
    float: none;
    width: auto;
    height: auto;
    margin-bottom: 20px;
  }
  h5.toggle span.toggle-title {
    width: 80%;
  }
  #wrapper .sep-boxed-pricing .panel-wrapper {
    padding: 0;
  }
  #wrapper .full-boxed-pricing .column,
  #wrapper .sep-boxed-pricing .column {
    float: none;
    margin-bottom: 10px;
    margin-left: 0;
    width: 100%;
  }
  .share-box {
    height: auto;
  }
  #wrapper .share-box h4 {
    float: none;
    line-height: 20px !important;
    padding: 0;
  }
  .share-box ul {
    float: none;
    overflow: hidden;
    padding: 0 25px;
    padding-bottom: 15px;
    margin-top: 0px;
  }
  .project-content .project-description {
    float: none !important;
  }
  .project-content .fusion-project-description-details {
    margin-bottom: 50px;
  }
  .project-content .project-description,
  .project-content .project-info {
    width: 100% !important;
  }
  .portfolio-half .flexslider {
    width: 100%;
  }
  .portfolio-half .project-content {
    width: 100% !important;
  }
  #style_selector {
    display: none;
  }
  .portfolio-tabs,
  .faq-tabs {
    height: auto;
    border-bottom-width: 1px;
    border-bottom-style: solid;
  }
  .portfolio-tabs li,
  .faq-tabs li {
    float: left;
    margin-right: 30px;
    border-bottom: 0;
  }
  .ls-avada .ls-nav-prev,
  .ls-avada .ls-nav-next {
    display: none !important;
  }
  nav#nav,
  nav#sticky-nav {
    margin-right: 0;
  }
  #footer .social-networks {
    width: 100%;
    margin: 0 auto;
    position: relative;
    left: -11px;
  }
  .tab-holder .tabs {
    height: auto !important;
    width: 100% !important;
  }
  .shortcode-tabs .tab-hold .tabs li {
    width: 100% !important;
  }
  body .shortcode-tabs .tab-hold .tabs li,
  body.dark .sidebar .tab-hold .tabs li {
    border-right: none !important;
  }
  .error-message {
    line-height: 170px;
    margin-top: 20px;
  }
  .error_page .useful_links {
    width: 100%;
    padding-left: 0;
  }
  .fusion-google-map {
    width: 100% !important;
    margin-bottom: 20px !important;
  }
  .social_links_shortcode .social li {
    width: 10% !important;
  }
  #wrapper .ei-slider {
    width: 100% !important;
  }
  #wrapper .ei-slider {
    height: 200px !important;
  }
  .progress-bar {
    margin-bottom: 10px !important;
  }
  .fusion-blog-layout-medium-alternate .fusion-post-content {
    float: none;
    width: 100% !important;
    margin-top: 20px;
  }
  #wrapper .content-boxes-icon-boxed .content-wrapper-boxed {
    min-height: inherit !important;
    padding-bottom: 20px;
    padding-left: 3%;
    padding-right: 3%;
  }
  #wrapper .content-boxes-icon-on-top .content-box-column,
  #wrapper .content-boxes-icon-boxed .content-box-column {
    margin-bottom: 55px;
  }
  .fusion-counters-box .fusion-counter-box {
    margin-bottom: 20px;
    padding: 0 15px;
  }
  .fusion-counters-box .fusion-counter-box:last-child {
    margin-bottom: 0;
  }
  .popup {
    display: none !important;
  }
  .share-box .social-networks {
    text-align: left;
  }
  .catalog-ordering .order,
  .avada-myaccount-data .addresses .col-1,
  .avada-myaccount-data .addresses .col-2,
  .avada-customer-details .addresses .col-1,
  .avada-customer-details .addresses .col-2 {
    float: none !important;
    margin-left: auto !important;
    margin-right: auto !important;
  }
  #wrapper .catalog-ordering > .fusion-grid-list-view {
    float: left !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
  }
  .avada-myaccount-data .addresses .col-1,
  .avada-myaccount-data .addresses .col-2,
  .avada-customer-details .addresses .col-1,
  .avada-customer-details .addresses .col-2 {
    margin: 0 !important;
    width: 100%;
  }
  .catalog-ordering {
    margin-bottom: 50px;
  }
  .catalog-ordering .order {
    width: 33px;
  }
  .catalog-ordering > ul,
  .catalog-ordering .order {
    margin-bottom: 10px;
  }
  .order-dropdown > li:hover > ul {
    display: block;
    position: relative;
    top: 0;
  }
  #wrapper .orderby-order-container {
    overflow: visible;
    width: auto;
    margin-bottom: 10px;
    float: left;
  }
  #wrapper .orderby.order-dropdown {
    float: left;
    margin-right: 7px;
  }
  #wrapper .catalog-ordering .sort-count.order-dropdown {
    width: 215px;
    float: left !important;
    margin-left: 7px !important;
    margin-right: 7px !important;
  }
  #wrapper .sort-count.order-dropdown ul a {
    width: 215px;
  }
  #wrapper .catalog-ordering .order {
    float: left !important;
    margin-bottom: 0 !important;
  }
  .products-2 li:nth-child(2n+1),
  .products-3 li:nth-child(3n+1),
  .products-4 li:nth-child(4n+1),
  .products-5 li:nth-child(5n+1),
  .products-6 li:nth-child(6n+1) {
    clear: none !important;
  }
  #main .products li:nth-child(3n+1) {
    clear: both !important;
  }
  .products li,
  #main .products li:nth-child(3n),
  #main .products li:nth-child(4n) {
    width: 32.3% !important;
    float: left !important;
    margin-right: 1% !important;
  }
  .woocommerce #customer_login .login .form-row,
  .woocommerce #customer_login .login .lost_password {
    float: none;
  }
  .woocommerce #customer_login .login .inline,
  .woocommerce #customer_login .login .lost_password {
    display: block;
    margin-left: 0;
  }
  .avada-myaccount-data .my_account_orders .order-number {
    padding-right: 8px;
  }
  .avada-myaccount-data .my_account_orders .order-actions {
    padding-left: 8px;
  }
  .shop_table .product-name {
    width: 35%;
  }
  #wrapper .woocommerce-side-nav,
  #wrapper .woocommerce-content-box,
  #wrapper .shipping-coupon,
  #wrapper .cart_totals,
  #wrapper #customer_login .col-1,
  #wrapper #customer_login .col-2,
  #wrapper .woocommerce form.checkout #customer_details .col-1,
  #wrapper .woocommerce form.checkout #customer_details .col-2 {
    float: none;
    margin-left: auto;
    margin-right: auto;
    width: 100% !important;
  }
  #customer_login .col-1,
  .coupon {
    margin-bottom: 20px;
  }
  .shop_table .product-thumbnail {
    float: none;
  }
  .product-info {
    margin-left: 0;
    margin-top: 10px;
  }
  .product .entry-summary div .price {
    float: none;
  }
  .product .entry-summary .woocommerce-product-rating {
    float: none;
    margin-left: 0;
  }
  .woocommerce-tabs .tabs,
  .woocommerce-side-nav {
    margin-bottom: 25px;
  }
  .woocommerce-tabs .panel {
    width: 91% !important;
    padding: 4% !important;
  }
  #reviews li .avatar {
    display: none;
  }
  #reviews li .comment-text {
    width: 90% !important;
    margin-left: 0 !important;
    padding: 5% !important;
  }
  .woocommerce-container .social-share {
    overflow: hidden;
  }
  .woocommerce-container .social-share li {
    display: block;
    float: left;
    margin: 0 auto;
    border-right: 0 !important;
    border-left: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    width: 25%;
  }
  .has-sidebar .woocommerce-container .social-share li {
    width: 50%;
  }
  .myaccount_user_container span {
    width: 100%;
    float: none;
    display: block;
    padding: 10px 0px;
    border-right: 0;
  }
  .rtl .myaccount_user_container span {
    border-left: 0;
  }
  .shop_table .product-thumbnail img,
  .shop_table .product-thumbnail .product-info,
  .shop_table .product-thumbnail .product-info p {
    float: none;
    width: 100%;
    margin: 0 !important;
    padding: 0;
  }
  .shop_table .product-thumbnail {
    padding: 10px 0px;
  }
  .product .images {
    margin-bottom: 30px;
  }
  #customer_login_box .button {
    float: left;
    margin-bottom: 15px;
  }
  #customer_login_box .remember-box {
    clear: both;
    display: block;
    padding: 0;
    width: 125px;
    float: left;
  }
  #customer_login_box .lost_password {
    float: left;
  }
  body #small-nav {
    visibility: visible !important;
  }
  #wrapper .product .images,
  #wrapper .product .summary.entry-summary {
    width: 50% !important;
    float: left !important;
  }
  #wrapper .product .summary.entry-summary {
    width: 48% !important;
    margin-left: 2% !important;
  }
  #wrapper .woocommerce-tabs .tabs {
    width: 24% !important;
    float: left !important;
  }
  #wrapper .woocommerce-tabs .panel {
    float: right !important;
    width: 70% !important;
    padding: 4% !important;
  }
  .gform_wrapper .ginput_complex .ginput_left,
  .gform_wrapper .ginput_complex .ginput_right,
  .wpcf7-form .wpcf7-text,
  .wpcf7-form .wpcf7-quiz,
  .wpcf7-form .wpcf7-number,
  .gform_wrapper .gfield input[type=text],
  .wpcf7-form textarea,
  .gform_wrapper .gfield textarea {
    float: none !important;
    width: 100% !important;
    box-sizing: border-box;
  }
  .product .images #slider .flex-direction-nav,
  .product .images #carousel .flex-direction-nav {
    display: none !important;
  }
  .myaccount_user_container span.msg,
  .myaccount_user_container span:last-child {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }
  #nav-uber #megaMenu {
    width: 100%;
  }
  .fullwidth-box {
    background-attachment: scroll;
  }
  #toTop {
    bottom: 30px;
    border-radius: 4px;
    height: 40px;
    z-index: 10000;
  }
  #toTop:before {
    line-height: 38px;
  }
  #toTop:hover {
    background-color: #333333;
  }
  .no-mobile-totop .to-top-container {
    display: none;
  }
  .no-mobile-slidingbar #slidingbar-area {
    display: none;
  }
  .tfs-slider .slide-content-container .btn {
    min-height: 0 !important;
    padding-left: 20px;
    padding-right: 20px !important;
    height: 26px !important;
    line-height: 26px !important;
  }
  .fusion-soundcloud iframe {
    width: 100%;
  }
  .fusion-columns-2 .fusion-column,
  .fusion-columns-2 .fusion-flip-box-wrapper,
  .fusion-columns-4 .fusion-column,
  .fusion-columns-4 .fusion-flip-box-wrapper {
    width: 50% !important;
    float: left !important;
  }
  .fusion-columns-2 .fusion-column:nth-child(3n),
  .fusion-columns-2 .fusion-flip-box-wrapper:nth-child(3n),
  .fusion-columns-4 .fusion-column:nth-child(3n),
  .fusion-columns-2 .fusion-flip-box-wrapper:nth-child(3n) {
    clear: both;
  }
  .fusion-columns-3 .fusion-column,
  .fusion-columns-3 .fusion-flip-box-wrapper,
  .fusion-columns-5 .fusion-column,
  .fusion-columns-5 .fusion-flip-box-wrapper,
  .fusion-columns-6 .fusion-column,
  .fusion-columns-6 .fusion-flip-box-wrapper,
  .fusion-columns-5 .col-lg-2,
  .fusion-columns-5 .col-md-2,
  .fusion-columns-5 .col-sm-2 {
    width: 33.33% !important;
    float: left !important;
  }
  .fusion-columns-3 .fusion-column:nth-child(4n),
  .fusion-columns-3 .fusion-flip-box-wrapper:nth-child(4n),
  .fusion-columns-5 .fusion-column:nth-child(4n),
  .fusion-columns-5 .fusion-flip-box-wrapper:nth-child(4n),
  .fusion-columns-6 .fusion-column:nth-child(4n),
  .fusion-columns-6 .fusion-flip-box-wrapper:nth-child(4n) {
    clear: both;
  }
  .footer-area .fusion-column,
  #slidingbar .fusion-column {
    margin-bottom: 40px;
  }
  .fusion-layout-column.fusion-one-sixth,
  .fusion-layout-column.fusion-five-sixth,
  .fusion-layout-column.fusion-one-fifth,
  .fusion-layout-column.fusion-two-fifth,
  .fusion-layout-column.fusion-three-fifth,
  .fusion-layout-column.fusion-four-fifth,
  .fusion-layout-column.fusion-one-fourth,
  .fusion-layout-column.fusion-three-fourth,
  .fusion-layout-column.fusion-one-third,
  .fusion-layout-column.fusion-two-third,
  .fusion-layout-column.fusion-one-half {
    position: relative;
    float: left;
    margin-right: 4%;
    margin-bottom: 20px;
  }
  .fusion-layout-column.fusion-one-sixth {
    width: 13.3333%;
  }
  .fusion-layout-column.fusion-five-sixth {
    width: 82.6666%;
  }
  .fusion-layout-column.fusion-one-fifth {
    width: 16.8%;
  }
  .fusion-layout-column.fusion-two-fifth {
    width: 37.6%;
  }
  .fusion-layout-column.fusion-three-fifth {
    width: 58.4%;
  }
  .fusion-layout-column.fusion-four-fifth {
    width: 79.2%;
  }
  .fusion-layout-column.fusion-one-fourth {
    width: 22%;
  }
  .fusion-layout-column.fusion-three-fourth {
    width: 74%;
  }
  .fusion-layout-column.fusion-one-third {
    width: 30.6666%;
  }
  .fusion-layout-column.fusion-two-third {
    width: 65.3333%;
  }
  .fusion-layout-column.fusion-one-half {
    width: 48%;
  }
  /* No spacing Columns */
  .fusion-layout-column.fusion-spacing-no {
    margin-left: 0;
    margin-right: 0;
  }
  .fusion-layout-column.fusion-one-sixth.fusion-spacing-no {
    width: 16.6666666667% !important;
  }
  .fusion-layout-column.fusion-five-sixth.fusion-spacing-no {
    width: 83.333333333% !important;
  }
  .fusion-layout-column.fusion-one-fifth.fusion-spacing-no {
    width: 20% !important;
  }
  .fusion-layout-column.fusion-two-fifth.fusion-spacing-no {
    width: 40% !important;
  }
  .fusion-layout-column.fusion-three-fifth.fusion-spacing-no {
    width: 60% !important;
  }
  .fusion-layout-column.fusion-four-fifth.fusion-spacing-no {
    width: 80% !important;
  }
  .fusion-layout-column.fusion-one-fourth.fusion-spacing-no {
    width: 25% !important;
  }
  .fusion-layout-column.fusion-three-fourth.fusion-spacing-no {
    width: 75% !important;
  }
  .fusion-layout-column.fusion-one-third.fusion-spacing-no {
    width: 33.33333333% !important;
  }
  .fusion-layout-column.fusion-two-third.fusion-spacing-no {
    width: 66.66666667% !important;
  }
  .fusion-layout-column.fusion-one-half.fusion-spacing-no {
    width: 50% !important;
  }
  .fusion-layout-column.fusion-column-last {
    clear: right;
    zoom: 1;
    margin-left: 0;
    margin-right: 0;
  }
  .fusion-column.fusion-spacing-no {
    margin-bottom: 0;
    width: 100% !important;
  }
  .sidebar {
    margin-left: 0 !important;
    width: 25% !important;
  }
  #content {
    margin-left: 0 !important;
  }
  .has-sidebar #main #content,
  #main #content.with-sidebar,
  .has-sidebar .project-content .project-description {
    width: 72% !important;
  }
  .sidebar-position-left .sidebar {
    float: left !important;
  }
  .sidebar-position-left #content {
    float: right !important;
  }
  .sidebar-position-right .sidebar {
    float: right !important;
  }
  .sidebar-position-right #content {
    float: left !important;
  }
  #sidebar-2 {
    clear: left;
  }
  .ua-mobile .page-title-bar,
  .ua-mobile .fusion-footer-widget-area,
  .ua-mobile body,
  .ua-mobile #main {
    background-attachment: scroll !important;
  }
  .fusion-secondary-header .fusion-row,
  .fusion-header .fusion-row,
  .footer-area > .fusion-row,
  #footer > .fusion-row,
  #header-sticky .fusion-row {
    padding-left: 0px !important;
    padding-right: 0px !important;
  }
  .error-message {
    font-size: 130px;
  }
}
<?php endif; ?>

<?php endif; ?>

<?php if( ! $smof_data['responsive'] ): ?>
.ua-mobile #wrapper{width: 100% !important; overflow: hidden !important;}
<?php endif; ?>

<?php endif; // end less_compiler check ?>

<?php
//IE11
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false):
?>
.avada-select-parent .select-arrow,.select-arrow, 
.wpcf7-select-parent .select-arrow{height:33px;line-height:33px;}
.gravity-select-parent .select-arrow{height:24px;line-height:24px;}

#wrapper .gf_browser_ie.gform_wrapper .button,
#wrapper .gf_browser_ie.gform_wrapper .gform_footer input.button{ padding: 0 20px; }
<?php endif; ?>

/*IE11 hack */
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
	.avada-select-parent .select-arrow,.select-arrow, 
	.wpcf7-select-parent .select-arrow{height:33px;line-height:33px;}
	.gravity-select-parent .select-arrow{height:24px;line-height:24px;}
	
	#wrapper .gf_browser_ie.gform_wrapper .button,
	#wrapper .gf_browser_ie.gform_wrapper .gform_footer input.button{ padding: 0 20px; }
}
<?php
$hundredp_padding = $smof_data['hundredp_padding'];
$hundredp_padding_int = (int) $hundredp_padding;
if( get_post_meta( $c_pageID, 'pyre_hundredp_padding', true ) ) {
	$hundredp_padding = get_post_meta( $c_pageID, 'pyre_hundredp_padding', true );
	$hundredp_padding_int = (int) $hundredp_padding;		
}
if($site_width_percent):
?>
.fusion-secondary-header, .header-v4 #small-nav, .header-v5 #small-nav, #main { padding-left: 0px; padding-right: 0px; }
#slidingbar .fusion-row, #sliders-container .tfs-slider .slide-content, #main .fusion-row, .fusion-page-title-bar, .fusion-header, .fusion-footer-widget-area, .fusion-footer-copyright-area, .fusion-secondary-header .fusion-row { padding-left: <?php echo $hundredp_padding; ?>; padding-right: <?php echo $hundredp_padding; ?>; }
.fullwidth-box, .fullwidth-box .fusion-row .fusion-full-width-sep { margin-left: -<?php echo $hundredp_padding_int; ?>px; margin-right: -<?php echo $hundredp_padding_int; ?>px; }
#main.width-100 > .fusion-row { padding-left: 0; padding-right: 0; }
<?php endif; ?>

<?php if($smof_data['layout'] == 'Boxed'): ?>
html, body {
	<?php if(get_post_meta($c_pageID, 'pyre_page_bg_color', true)): ?>
	background-color:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_color', true); ?>;
	<?php else: ?>
	background-color:<?php echo $smof_data['bg_color']; ?>;
	<?php endif; ?>
}
body{
	<?php if(get_post_meta($c_pageID, 'pyre_page_bg_color', true)): ?>
	background-color:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_color', true); ?>;
	<?php else: ?>
	background-color:<?php echo $smof_data['bg_color']; ?>;
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_bg', true)): ?>
	background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_page_bg', true); ?>);
	background-repeat:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_repeat', true); ?>;
		<?php if(get_post_meta($c_pageID, 'pyre_page_bg_full', true) == 'yes'): ?>
		background-attachment:fixed;
		background-position:center center;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>
	<?php elseif($smof_data['bg_image']): ?>
	background-image:url(<?php echo $smof_data['bg_image']; ?>);
	background-repeat:<?php echo $smof_data['bg_repeat']; ?>;
		<?php if($smof_data['bg_full']): ?>
		background-attachment:fixed;
		background-position:center center;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>
	<?php endif; ?>
}
<?php if($smof_data['bg_pattern_option'] && $smof_data['bg_pattern'] && !(get_post_meta($c_pageID, 'pyre_page_bg_color', true) || get_post_meta($c_pageID, 'pyre_page_bg', true))): ?>
html, body {
	background-image:url("<?php echo get_template_directory_uri() . '/assets/images/patterns/' . $smof_data['bg_pattern'] . '.png'; ?>");
	background-repeat:repeat;
}
<?php endif; ?>		
#wrapper, 
.fusion-footer-parallax {
	max-width:<?php if( $site_width_percent ) { echo $smof_data['site_width']; } else { echo ( $site_width + 60 ) .  'px'; } ?>;
	margin:0 auto;
}
.wrapper_blank { display: block; }

@media (min-width: 1014px) {
	body #header-sticky.sticky-header {
		width:<?php if( $site_width_percent ) { echo $smof_data['site_width']; } else { echo ( $site_width + 60 ) .  'px'; } ?>;
		left: 0;
		right: 0;
		margin:0 auto;
	}	
}

<?php if($smof_data['responsive'] && $site_width_percent): ?>
#main .fusion-row, .fusion-footer-widget-area .fusion-row,#slidingbar-area .fusion-row, .fusion-footer-copyright-area .fusion-row, .fusion-page-title-row, .fusion-secondary-header .fusion-row, #small-nav .fusion-row, .fusion-header .fusion-row{ max-width: none; padding: 0 10px; }
<?php endif; ?>

<?php if( $smof_data['responsive'] ): ?>
@media only screen and (min-width: 801px) and (max-width: 1014px){
	#wrapper{
		width:auto;
	}
}
@media only screen and (min-device-width: 801px) and (max-device-width: 1014px){
	#wrapper{
		width:auto;
	}
}
<?php endif; ?>
<?php endif; ?>

<?php if($smof_data['layout'] == 'Wide'): ?>
#wrapper{
	width:100%;
	max-width: none;
}
@media only screen and (min-width: 801px) and (max-width: 1014px){
	#wrapper{
		width:auto;
	}
}
@media only screen and (min-device-width: 801px) and (max-device-width: 1014px){
	#wrapper{
		width:auto;
	}
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_page_bg_layout', true) == 'boxed'): ?>
html, body {
	<?php if(get_post_meta($c_pageID, 'pyre_page_bg_color', true)): ?>
	background-color:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_color', true); ?>;
	<?php else: ?>
	background-color:<?php echo $smof_data['bg_color']; ?>;
	<?php endif; ?>
}
body{
	<?php if(get_post_meta($c_pageID, 'pyre_page_bg_color', true)): ?>
	background-color:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_color', true); ?>;
	<?php else: ?>
	background-color:<?php echo $smof_data['bg_color']; ?>;
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_bg', true)): ?>
	background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_page_bg', true); ?>);
	background-repeat:<?php echo get_post_meta($c_pageID, 'pyre_page_bg_repeat', true); ?>;
		<?php if(get_post_meta($c_pageID, 'pyre_page_bg_full', true) == 'yes'): ?>
		background-attachment:fixed;
		background-position:center center;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>
	<?php elseif($smof_data['bg_image']): ?>
	background-image:url(<?php echo $smof_data['bg_image']; ?>);
	background-repeat:<?php echo $smof_data['bg_repeat']; ?>;
		<?php if($smof_data['bg_full']): ?>
		background-attachment:fixed;
		background-position:center center;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>
	<?php endif; ?>

	<?php if($smof_data['bg_pattern_option'] && $smof_data['bg_pattern'] && !(get_post_meta($c_pageID, 'pyre_page_bg_color', true) || get_post_meta($c_pageID, 'pyre_page_bg', true))): ?>
	background-image:url("<?php echo get_template_directory_uri() . '/assets/images/patterns/' . $smof_data['bg_pattern'] . '.png'; ?>");
	background-repeat:repeat;
	<?php endif; ?>
}

#wrapper,
.fusion-footer-parallax {
	width:<?php if( $site_width_percent ) { echo $smof_data['site_width']; } else { echo ( $site_width + 60 ) .  'px'; } ?>;
	margin:0 auto;
	max-width: 100%;
}
.wrapper_blank { display: block; }
@media (min-width: 1014px) {
	body #header-sticky.sticky-header {
		width:<?php if( $site_width_percent ) { echo $smof_data['site_width']; } else { echo ( $site_width + 60 ) .  'px'; } ?>;
		left: 0;
		right: 0;
		margin:0 auto;
	}	
}
@media only screen and (min-width: 801px) and (max-width: 1014px){
	#wrapper{
		width:auto;
	}
}
@media only screen and (min-device-width: 801px) and (max-device-width: 1014px){
	#wrapper{
		width:auto;
	}
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_page_bg_layout', true) == 'wide'): ?>
#wrapper{
	width:100%;
	max-width: none;
}
@media only screen and (min-width: 801px) and (max-width: 1014px){
	#wrapper{
		width:auto;
	}
}
@media only screen and (min-device-width: 801px) and (max-device-width: 1014px){
	#wrapper{
		width:auto;
	}
}
body #header-sticky.sticky-header {
	width: 100%;
	left: 0;
	right: 0;
	margin:0 auto;
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_page_bg', true) || $smof_data['bg_image'] ): ?>
html { background: none; }
<?php endif; ?>		

<?php if( $smof_data['mobile_nav_padding'] ): ?>
@media only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait){
	.fusion-main-menu > ul > li{ padding-right: <?php echo $smof_data['mobile_nav_padding']; ?>px; }
}
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape){
	.fusion-main-menu > ul > li{ padding-right: <?php echo $smof_data['mobile_nav_padding']; ?>px; }
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_bg', true)): ?>
.fusion-page-title-bar{
	background-image:url('<?php echo get_post_meta($c_pageID, 'pyre_page_title_bar_bg', true); ?>');
}
<?php elseif($smof_data['page_title_bg']): ?>
.fusion-page-title-bar{
	background-image:url('<?php echo $smof_data['page_title_bg']; ?>');
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_bg_color', true)): ?>
.fusion-page-title-bar{
	background-color:<?php echo get_post_meta($c_pageID, 'pyre_page_title_bar_bg_color', true); ?>;
}

<?php elseif($smof_data['page_title_bg_color']): ?>
.fusion-page-title-bar{
	background-color:<?php echo $smof_data['page_title_bg_color']; ?>;
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_borders_color', true)): ?>
.fusion-page-title-bar{
	border-color: <?php echo get_post_meta($c_pageID, 'pyre_page_title_bar_borders_color', true); ?>;
}
<?php endif; ?>

.fusion-header, #side-header{
	<?php if($smof_data['header_bg_image']): ?>
	background-image:url('<?php echo $smof_data['header_bg_image']; ?>');
	<?php if($smof_data['header_bg_repeat'] == 'repeat-y' || $smof_data['header_bg_repeat'] == 'no-repeat'): ?>
	background-position: center center;
	<?php endif; ?>
	background-repeat:<?php echo $smof_data['header_bg_repeat']; ?>;
		<?php if($smof_data['header_bg_full']): ?>
		<?php if( $smof_data['header_position'] == 'Top' ): ?>
		background-attachment:scroll;
		<?php endif; ?>
		background-position:center center;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>

	<?php if($smof_data['header_bg_parallax'] && $smof_data['header_position'] == 'Top') : ?>
	background-attachment: fixed;
	background-position:top center;
	<?php endif; ?>
	<?php endif; ?>
}

.fusion-header, #side-header, .layout-boxed-mode .side-header-wrapper {
	<?php if(get_post_meta($c_pageID, 'pyre_header_bg_color', true)):
	if( get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) != '' ) {
		$header_bg_opacity = get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true );
	} else if( $smof_data['header_bg_color'] ) {
		$header_bg_opacity = $smof_data['header_bg_color']['opacity'];
	} else {
		$header_bg_opacity = 1;
	}	
	$header_bg_color_rgb = fusion_hex2rgb( get_post_meta($c_pageID, 'pyre_header_bg_color', true) );
	if( get_post_meta($c_pageID, 'pyre_header_bg_color', true) ):
	?>
	background-color:<?php echo get_post_meta($c_pageID, 'pyre_header_bg_color', true); ?>;
	<?php if( ! is_archive() && ! is_404() && ! is_search() ): ?>
	background-color:<?php echo sprintf( 'rgba(%s,%s,%s,%s)', $header_bg_color_rgb[0], $header_bg_color_rgb[1], $header_bg_color_rgb[2], $header_bg_opacity ); ?>;
	<?php
	endif;
	endif;
	elseif( $smof_data['header_bg_color'] ):
	if( get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) != '' ) {
		$header_bg_opacity = get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true );
	} else if( $smof_data['header_bg_color'] ) {
		$header_bg_opacity = $smof_data['header_bg_color']['opacity'];
	} else {
		$header_bg_opacity = 1;
	}
	?>
	<?php $header_bg_color_rgb = fusion_hex2rgb( $smof_data['header_bg_color']['color'] );
	if( $smof_data['header_bg_color']['color'] ):
	?>
	background-color:<?php echo $smof_data['header_bg_color']['color']; ?>;
	<?php if( ! is_archive() && ! is_404() && ! is_search() ): ?>
	background-color:<?php echo sprintf( 'rgba(%s,%s,%s,%s)', $header_bg_color_rgb[0], $header_bg_color_rgb[1], $header_bg_color_rgb[2], $header_bg_opacity ); ?>;
	<?php
	endif;
	endif;
	endif; ?>
}


.fusion-secondary-main-menu {
	<?php if( $smof_data['menu_h45_bg_color'] ):
	if( get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) != '' ) {
		$header_bg_opacity = get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true );
	} else if( $smof_data['menu_h45_bg_color'] ) {
		$header_bg_opacity = $smof_data['header_bg_color']['opacity'];
	} else {
		$header_bg_opacity = 1;
	}
	?>
	<?php $header_bg_color_rgb = fusion_hex2rgb( $smof_data['menu_h45_bg_color'] );
	if( $smof_data['menu_h45_bg_color'] ): ?>
	background-color:<?php echo $smof_data['menu_h45_bg_color']; ?>;
	<?php if( ! is_archive() ): ?>		
	background-color:<?php echo sprintf( 'rgba(%s,%s,%s,%s)', $header_bg_color_rgb[0], $header_bg_color_rgb[1], $header_bg_color_rgb[2], $header_bg_opacity ); ?>;		
	<?php
	endif;
	endif;
	endif; ?>
}


.fusion-header, #side-header{	
	<?php if(get_post_meta($c_pageID, 'pyre_header_bg', true)): ?>
	background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_header_bg', true); ?>);
	<?php if(get_post_meta($c_pageID, 'pyre_header_bg_repeat', true) == 'repeat-y' || get_post_meta($c_pageID, 'pyre_header_bg_repeat', true) == 'no-repeat'): ?>
	background-position: center center;
	<?php endif; ?>
	background-repeat:<?php echo get_post_meta($c_pageID, 'pyre_header_bg_repeat', true); ?>;
		<?php if(get_post_meta($c_pageID, 'pyre_header_bg_full', true) == 'yes'): ?>
		<?php if( $smof_data['header_position'] == 'Top' ): ?>
		background-attachment:fixed;
		<?php endif; ?>
		background-position:center center;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>
	<?php if($smof_data['header_bg_parallax'] && $smof_data['header_position'] == 'Top') : ?>
	background-attachment: fixed;
	background-position:top center;
	<?php endif; ?>
	<?php endif; ?>
}

<?php if( ( ( $smof_data['header_bg_color']['opacity'] < 1 && ! get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) ) || ( get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) != '' && get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) < 1 ) ) 
		  && ! is_search() 
		  && ! is_404()
		  && ! is_author()
		  && ( ! is_archive() || ( class_exists('Woocommerce') && is_shop() ) )
): ?>
	@media only screen and (min-width: 800px){
		.fusion-header, .fusion-secondary-header {border-top:none;}
		.fusion-header-v1 .fusion-header, .fusion-secondary-main-menu {border:none;}

		<?php if(fusion_get_option( 'layout', 'page_bg_layout', $c_pageID ) == 'boxed'): ?>
		<?php if( $site_width_percent ): ?>
		.fusion-header-wrapper{position: absolute;width:<?php echo $smof_data['site_width']; ?>;z-index: 10000;}
		<?php else: ?>
		.fusion-header-wrapper{position: absolute;width: <?php echo ( $site_width + 60 ); ?>px;z-index: 10000;}
		<?php endif; ?>	
		<?php else: ?>
		.fusion-header-wrapper{position: absolute;left:0;right:0;z-index: 10000;}
		<?php endif; ?>	
	}
<?php endif; ?>	

<?php if ( get_post_meta($c_pageID, 'pyre_avada_rev_styles', true) == 'no' || 
			( ! $smof_data['avada_rev_styles'] && get_post_meta($c_pageID, 'pyre_avada_rev_styles', true) != 'yes' ) ) : ?>

.rev_slider_wrapper{
	position:relative
}

<?php if( ( $smof_data['header_bg_color']['opacity'] == '1' && ! get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) ) || ( get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) && get_post_meta( $c_pageID, 'pyre_header_bg_opacity', true ) == 1 ) ): ?>
.rev_slider_wrapper .shadow-left{
	position:absolute;
	pointer-events:none;
	background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/shadow-top.png);
	background-repeat:no-repeat;
	background-position:top center;
	height:42px;
	width:100%;
	top:0;
	z-index:99;
}

.rev_slider_wrapper .shadow-left{top:-1px;}

<?php endif; ?>

.rev_slider_wrapper .shadow-right{
	position:absolute;
	pointer-events:none;
	background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/shadow-bottom.png);
	background-repeat:no-repeat;
	background-position:bottom center;
	height:32px;
	width:100%;
	bottom:0;
	z-index:99;
}

.avada-skin-rev{
	border-top: 1px solid #d2d3d4;
	border-bottom: 1px solid #d2d3d4;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
}

.tparrows{border-radius:0;}

.rev_slider_wrapper .tp-leftarrow, .rev_slider_wrapper .tp-rightarrow{
	opacity:0.8;
	position: absolute;
	top: 50% !important;
	margin-top:-31px !important;	
	width: 63px !important;
	height: 63px !important;
	background:none;
	background-color: rgba(0, 0, 0, 0.5) ;	
	color:#fff;
}

.rev_slider_wrapper .tp-leftarrow:before{
	content:"\e61e";
	-webkit-font-smoothing: antialiased;
}

.rev_slider_wrapper .tp-rightarrow:before{
	content:"\e620";
	-webkit-font-smoothing: antialiased;
}

.rev_slider_wrapper .tp-leftarrow:before, .rev_slider_wrapper .tp-rightarrow:before{
	position: absolute;
	padding:0;
	width: 100%;
	line-height: 63px;
	text-align: center;
	font-size: 25px;
	font-family: 'icomoon';

}

.rev_slider_wrapper .tp-leftarrow:before{
	margin-left: -2px;
}

.rev_slider_wrapper .tp-rightarrow:before{
	margin-left: -1px;
}

.rev_slider_wrapper .tp-rightarrow{
	left:auto;
	right:0;
}

.no-rgba .rev_slider_wrapper .tp-leftarrow, .no-rgba .rev_slider_wrapper .tp-rightarrow{
	background-color:#ccc ;
}

.rev_slider_wrapper:hover .tp-leftarrow,.rev_slider_wrapper:hover .tp-rightarrow{
	display:block;
	opacity:0.8;
}

.rev_slider_wrapper .tp-leftarrow:hover, .rev_slider_wrapper .tp-rightarrow:hover{
	opacity:1;
}

.rev_slider_wrapper .tp-leftarrow{
	background-position: 19px 19px ;
	left: 0;
	margin-left:0;
	z-index:100;
}

.rev_slider_wrapper .tp-rightarrow{
	background-position: 29px 19px ;
	right: 0;
	margin-left:0;
	z-index:100;
}

.rev_slider_wrapper .tp-leftarrow.hidearrows,
.rev_slider_wrapper .tp-rightarrow.hidearrows {
	opacity: 0;
}

.tp-bullets .bullet.last{
	clear:none;
}
<?php endif; ?>	

#main{
	<?php if($smof_data['content_bg_image'] && !get_post_meta($c_pageID, 'pyre_wide_page_bg_color', true)): ?>
	background-image:url(<?php echo $smof_data['content_bg_image']; ?>);
	background-repeat:<?php echo $smof_data['content_bg_repeat']; ?>;
		<?php if($smof_data['content_bg_full']): ?>
		background-attachment:fixed;
		background-position:center center;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>
	<?php endif; ?>

	<?php if($smof_data['main_top_padding'] && !get_post_meta($c_pageID, 'pyre_main_top_padding', true)): ?>
	padding-top: <?php echo $smof_data['main_top_padding']; ?>;
	<?php endif; ?>

	<?php if($smof_data['main_bottom_padding'] && !get_post_meta($c_pageID, 'pyre_main_bottom_padding', true)): ?>
	padding-bottom: <?php echo $smof_data['main_bottom_padding']; ?>;
	<?php endif; ?>
}

<?php if(get_post_meta($c_pageID, 'pyre_page_bg_layout', true) == 'wide' && get_post_meta($c_pageID, 'pyre_wide_page_bg_color', true)): ?>
html, body, #wrapper {
	background-color:<?php echo get_post_meta($c_pageID, 'pyre_wide_page_bg_color', true); ?>;
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_wide_page_bg_color', true)): ?>
#main,#wrapper,
.fusion-separator .icon-wrapper, .bbp-arrow {
	background-color:<?php echo get_post_meta($c_pageID, 'pyre_wide_page_bg_color', true); ?>;
}
<?php endif; ?>

#main{
	<?php if(get_post_meta($c_pageID, 'pyre_wide_page_bg', true)): ?>
	background-image:url(<?php echo get_post_meta($c_pageID, 'pyre_wide_page_bg', true); ?>);
	background-repeat:<?php echo get_post_meta($c_pageID, 'pyre_wide_page_bg_repeat', true); ?>;
		<?php if(get_post_meta($c_pageID, 'pyre_wide_page_bg_full', true) == 'yes'): ?>
		background-attachment:fixed;
		background-position:center center;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		<?php endif; ?>
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_main_top_padding', true)): ?>
	padding-top:<?php echo get_post_meta($c_pageID, 'pyre_main_top_padding', true); ?>;
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_main_bottom_padding', true)): ?>
	padding-bottom:<?php echo get_post_meta($c_pageID, 'pyre_main_bottom_padding', true); ?>;
	<?php endif; ?>

}

<?php if ( get_post_meta( $c_pageID, 'pyre_sidebar_bg_color', true ) ): ?>
#main .sidebar { background-color: <?php echo get_post_meta($c_pageID, 'pyre_sidebar_bg_color', true); ?>; }
<?php endif; ?>

.fusion-page-title-bar{
	<?php if($smof_data['page_title_bg_full']): ?>
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_bg_full', true) == 'yes'): ?>
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	<?php elseif(get_post_meta($c_pageID, 'pyre_page_title_bar_bg_full', true) == 'no'): ?>
	-webkit-background-size: auto;
	-moz-background-size: auto;
	-o-background-size: auto;
	background-size: auto;
	<?php endif; ?>

	<?php if($smof_data['page_title_bg_parallax']): ?>
	background-attachment: fixed;
	background-position:top center;
	<?php endif; ?>

	<?php if(get_post_meta($c_pageID, 'pyre_page_title_bg_parallax', true) == 'yes'): ?>
	background-attachment: fixed;
	background-position:top center;
	<?php elseif(get_post_meta($c_pageID, 'pyre_page_title_bg_parallax', true) == 'no'): ?>
	background-attachment: scroll;
	<?php endif; ?>
}

<?php if(get_post_meta($c_pageID, 'pyre_page_title_height', true)): ?>
.fusion-page-title-bar{
	height:<?php echo get_post_meta($c_pageID, 'pyre_page_title_height', true); ?>;
}
<?php elseif($smof_data['page_title_height']): ?>
.fusion-page-title-bar{
	height:<?php echo $smof_data['page_title_height']; ?>;
}
<?php endif; ?>

<?php if( get_post_meta( $c_pageID, 'pyre_page_title_mobile_height', true) ): ?>
<?php endif; ?>

<?php if(is_single() && get_post_meta($c_pageID, 'pyre_fimg_width', true)): ?>
<?php if(get_post_meta($c_pageID, 'pyre_fimg_width', true) != 'auto'): ?>
#post-<?php echo $c_pageID; ?> .fusion-post-slideshow {max-width:<?php echo get_post_meta($c_pageID, 'pyre_fimg_width', true); ?>;}
<?php else: ?>
.fusion-post-slideshow .flex-control-nav{position:relative;text-align:left;margin-top:10px;}
<?php endif; ?>
#post-<?php echo $c_pageID; ?> .fusion-post-slideshow img{max-width:<?php echo get_post_meta($c_pageID, 'pyre_fimg_width', true); ?>;}
	<?php if(get_post_meta($c_pageID, 'pyre_fimg_width', true) == 'auto'): ?>
	#post-<?php echo $c_pageID; ?> .fusion-post-slideshow img{width:<?php echo get_post_meta($c_pageID, 'pyre_fimg_width', true); ?>;}
	<?php endif; ?>
<?php endif; ?>

<?php if(is_single() && get_post_meta($c_pageID, 'pyre_fimg_height', true)): ?>
#post-<?php echo $c_pageID; ?> .fusion-post-slideshow, #post-<?php echo $c_pageID; ?> .fusion-post-slideshow img{max-height:<?php echo get_post_meta($c_pageID, 'pyre_fimg_height', true); ?>;}
#post-<?php echo $c_pageID; ?> .fusion-post-slideshow .slides { max-height: 100%; }
<?php endif; ?>


<?php if(get_post_meta($c_pageID, 'pyre_page_title_bar_bg_retina', true)): ?>
@media only screen and ( -webkit-min-device-pixel-ratio: 1.5 ), 
		only screen and ( min-resolution: 144dpi ), 
		only screen and ( min-resolution: 1.5dppx )
{
	.fusion-page-title-bar {
		background-image: url(<?php echo get_post_meta($c_pageID, 'pyre_page_title_bar_bg_retina', true); ?>);
		-webkit-background-size:cover;
		   -moz-background-size:cover;
			 -o-background-size:cover;
				background-size:cover;
	}
}
<?php elseif($smof_data['page_title_bg_retina']): ?>
@media only screen and ( -webkit-min-device-pixel-ratio: 1.5 ), 
		only screen and ( min-resolution: 144dpi ), 
		only screen and ( min-resolution: 1.5dppx )
{
	.fusion-page-title-bar {
		background-image: url(<?php echo $smof_data['page_title_bg_retina']; ?>);
		-webkit-background-size:cover;
		   -moz-background-size:cover;
			 -o-background-size:cover;
				background-size:cover;
	}
}
<?php endif; ?>

<?php if ( ( $smof_data['page_title_bar'] == 'content_only' && ( get_post_meta( $c_pageID, 'pyre_page_title', true ) == 'default' || ! get_post_meta( $c_pageID, 'pyre_page_title', true ) ) ) || get_post_meta( $c_pageID, 'pyre_page_title', true ) == 'yes_without_bar' ): ?>
.fusion-page-title-bar {
	background: none;
	border: none;
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_hundredp_padding', true)): ?>
.width-100 .fullwidth-box, .width-100 .fusion-section-separator {
	margin-left: -<?php echo get_post_meta($c_pageID, 'pyre_hundredp_padding', true); ?>; margin-right: -<?php echo get_post_meta($c_pageID, 'pyre_hundredp_padding', true); ?>;
}
<?php elseif($smof_data['hundredp_padding']): ?>
.width-100 .fullwidth-box, .width-100 .fusion-section-separator {
	margin-left: -<?php echo $smof_data['hundredp_padding'] ?>; margin-right: -<?php echo $smof_data['hundredp_padding'] ?>;
}
<?php endif; ?>

<?php if((float) $wp_version < 3.8): ?>
#wpadminbar *{color:#ccc;}
#wpadminbar .hover a, #wpadminbar .hover a span{color:#464646;}
<?php endif; ?>

.woocommerce-invalid:after { content: '<?php echo __('Please enter correct details for this required field.', 'Avada'); ?>'; display: inline-block; margin-top: 7px; color: red; }

<?php if(get_post_meta($c_pageID, 'pyre_fallback', true)): ?>
@media only screen and (max-width: 940px){
	#sliders-container{display:none;}
	#fallback-slide{display:block;}
}
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait){
	#sliders-container{display:none;}
	#fallback-slide{display:block;}
}
<?php endif; ?>

<?php if($smof_data['side_header_width'] && get_post_meta( get_queried_object_id(), 'pyre_display_header', true) != 'no' ):
$side_header_width = $smof_data['side_header_width'];
$side_header_width = (int) str_replace('px', '', $side_header_width);
?>
body.side-header-left #wrapper, .side-header-left .fusion-footer-parallax{margin-left:<?php echo $smof_data['side_header_width']; ?>;}
body.side-header-right #wrapper, .side-header-right .fusion-footer-parallax{margin-right:<?php echo $smof_data['side_header_width']; ?>;}
body.side-header-left #side-header #nav > ul > li > ul, body.side-header-left #side-header #nav .login-box, body.side-header-left #side-header #nav .cart-contents, body.side-header-left #side-header #nav .main-nav-search-form{left:<?php echo ($side_header_width - 1); ?>px;}
body.rtl #boxed-wrapper{ position: relative; }
body.rtl.layout-boxed-mode.side-header-left #side-header{ position: absolute; left: 0; top: 0; margin-left:0px; }
body.rtl.side-header-left #side-header .side-header-wrapper{ position: fixed; width:<?php echo $smof_data['side_header_width']; ?>;}

<?php if( $smof_data['layout'] != 'Boxed' && get_post_meta($c_pageID, 'pyre_page_bg_layout', true) != 'boxed'): ?>
body.side-header-left #slidingbar .avada-row,
body.side-header-right #slidingbar .avada-row{max-width: none;}
<?php endif; ?>

<?php endif; ?>

<?php if( ( ( $smof_data['layout'] == 'Boxed' && get_post_meta( $c_pageID, 'pyre_page_bg_layout', true) != 'wide' ) || get_post_meta( $c_pageID, 'pyre_page_bg_layout', true ) == 'boxed' ) && $smof_data['header_position'] != 'Top' ): ?>
<?php if( ! $site_width_percent ): ?>
#boxed-wrapper,
.fusion-body .fusion-footer-parallax {
	margin: 0 auto;
	max-width: <?php echo (int) $smof_data['site_width'] + $smof_data['side_header_width'] + 60; ?>px;
}
#slidingbar-area .fusion-row{max-width: <?php echo (int) $smof_data['site_width'] + $smof_data['side_header_width']; ?>px;}
<?php else: ?>
#boxed-wrapper,
#slidingbar-area .fusion-row,
.fusion-footer-parallax {
	margin: 0 auto;
	max-width: -webkit-calc(<?php echo $smof_data['site_width'] . ' + ' . $smof_data['side_header_width']; ?>);
	max-width: -moz-calc(<?php echo $smof_data['site_width'] .  '+ ' . $smof_data['side_header_width']; ?>);
	max-width: -o-calc(<?php echo $smof_data['site_width'] . ' + ' . $smof_data['side_header_width']; ?>);
	max-width: calc(<?php echo $smof_data['site_width'] . ' + ' . $smof_data['side_header_width']; ?>);
}    
#wrapper {
   	max-width: none;
}
<?php endif; ?>	

<?php if( $smof_data['header_position'] == 'Left' ): ?>
body.side-header-left #side-header { 
    left: auto;
    margin-left: -<?php echo $smof_data['side_header_width'] ; ?>;
}

.side-header-left .fusion-footer-parallax{margin: 0 auto; padding-left:<?php echo $smof_data['side_header_width']; ?>;}
<?php else: ?>
#boxed-wrapper {
	position: relative;
}
body.admin-bar #wrapper #slidingbar-area {
    top: 0;
}

.side-header-right .fusion-footer-parallax{margin: 0 auto; padding-right:<?php echo $smof_data['side_header_width']; ?>;}

@media only screen and (min-width: 800px) {
    body.side-header-right #side-header { 
        position: absolute;
        top: 0;
    }    
    body.side-header-right #side-header .side-header-wrapper { 
        position: fixed;
    	width: <?php echo $smof_data['side_header_width'] ; ?>;
    }
}
<?php endif; ?>	

<?php endif; ?>	

<?php if(is_page_template('contact.php') && $smof_data['gmap_address'] && !$smof_data['status_gmap']): ?>
.avada-google-map{
	width:<?php echo $smof_data['gmap_width']; ?>;
	margin:0 auto;
	<?php if($smof_data['gmap_width'] != '100%'): ?>
	<?php if($smof_data['gmap_topmargin']): ?>
	margin-top:<?php echo $smof_data['gmap_topmargin']; ?>;
	<?php else: ?>
	margin-top:55px;
	<?php endif; ?>
	<?php endif; ?>

	<?php if($smof_data['gmap_height']): ?>
	height:<?php echo $smof_data['gmap_height']; ?>;
	<?php else: ?>
	height:415px;
	<?php endif; ?>
}
<?php endif; ?>

<?php if(is_page_template('contact-2.php') && $smof_data['gmap_address'] && !$smof_data['status_gmap']): ?>
.avada-google-map{
	margin:0 auto;
	margin-top:55px;
	height:415px !important;
	width:940px !important;		
}
<?php endif; ?>

<?php
if(get_post_meta($c_pageID, 'pyre_footer_100_width', true) == 'yes'): ?>
.layout-wide-mode .fusion-footer-widget-area > .fusion-row, .layout-wide-mode .fusion-footer-copyright-area > .fusion-row {
	max-width: 100% !important;
}
<?php elseif(get_post_meta($c_pageID, 'pyre_footer_100_width', true) == 'no'): ?>
.layout-wide-mode .fusion-footer-widget-area > .fusion-row, .layout-wide-mode .fusion-footer-copyright-area > .fusion-row {
	max-width: <?php echo $smof_data['site_width']; ?> !important;
}
<?php endif; ?>

<?php if( get_post_meta($c_pageID, 'pyre_page_title_font_color', true) && get_post_meta($c_pageID, 'pyre_page_title_font_color', true) != '' ): ?>
.fusion-page-title-bar h1, .fusion-page-title-bar h3{
	color:<?php echo get_post_meta( $c_pageID, 'pyre_page_title_font_color', true ); ?>;
}
<?php endif; ?>

<?php if( get_post_meta($c_pageID, 'pyre_page_title_text_size', true) && get_post_meta($c_pageID, 'pyre_page_title_text_size', true) != '' ): ?>
.fusion-page-title-bar h1{
	font-size:<?php echo get_post_meta( $c_pageID, 'pyre_page_title_text_size', true ); ?>;
	line-height:normal;
}
<?php endif; ?>

<?php if( get_post_meta($c_pageID, 'pyre_page_title_custom_subheader_text_size', true) && get_post_meta($c_pageID, 'pyre_page_title_custom_subheader_text_size', true) != '' ): ?>
.fusion-page-title-bar h3{
	font-size:<?php echo get_post_meta( $c_pageID, 'pyre_page_title_custom_subheader_text_size', true ); ?>;
	line-height: <?php echo intval($smof_data['page_title_subheader_font_size']) + 12;?>px;
}
<?php endif; ?>

<?php if( $smof_data['responsive'] && ! $smof_data['ipad_potrait'] && get_post_meta($c_pageID, 'pyre_page_title_height', true) ): ?>
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: portrait) {
	#wrapper .fusion-page-title-bar{
		height:<?php echo get_post_meta($c_pageID, 'pyre_page_title_height', true); ?> !important;
	}
}
<?php endif; ?>

<?php if(get_post_meta($c_pageID, 'pyre_page_title_100_width', true) == 'yes'): ?>
.layout-wide-mode .fusion-page-title-row { max-width: 100%; }
<?php elseif(get_post_meta($c_pageID, 'pyre_page_title_100_width', true) == 'no'): ?>
.layout-wide-mode .fusion-page-title-row { max-width: <?php echo $site_width; ?>; }
<?php endif; ?>

<?php
$header_width = $smof_data['header_100_width'];
if(get_post_meta($c_pageID, 'pyre_header_100_width', true) == 'yes') {
	$header_width = true;
} elseif(get_post_meta($c_pageID, 'pyre_header_100_width', true) == 'no') {
	$header_width = false;
}
if($header_width): ?>
.layout-wide-mode .fusion-header-wrapper .fusion-row { max-width: 100%; }
<?php endif; ?>
@media only screen and (min-device-width: 768px) and (max-device-width: 1366px) and (orientation: portrait){
    .products .product-list-view { width: 100% !important; min-width:100% !important;}
}

<?php
$button_text_color_brightness = fusion_calc_color_brightness( $smof_data['button_accent_color'] );
if ( $button_text_color_brightness > 140 ): ?>
<?php endif;

$button_hover_text_color_brightness = fusion_calc_color_brightness( $smof_data['button_accent_hover_color'] );
if ( $button_hover_text_color_brightness > 140 ) {
	$text_shadow_color = '#333';
} else {
	$text_shadow_color = '#fff';
}
?>

<?php if( get_post_meta( $c_pageID, 'pyre_page_title_mobile_height', true ) ): ?>
@media only screen and ( max-width: 800px ) {
	<?php if( get_post_meta( $c_pageID, 'pyre_page_title_mobile_height', true ) != 'auto' ): ?>
	.fusion-body .fusion-page-title-bar {
		height: <?php echo get_post_meta( $c_pageID, 'pyre_page_title_mobile_height', true ); ?>
	}

	.fusion-page-title-row {
		display: table;
	}
	
	.fusion-page-title-wrapper {
		display: table-cell;
		vertical-align: middle;
	}
	<?php endif; ?>

	<?php if( get_post_meta( $c_pageID, 'pyre_page_title_mobile_height', true ) == 'auto' ): ?>
	.fusion-body .fusion-page-title-bar {
		padding-top: 10px;
		padding-bottom: 10px;
		height: auto;
	}
	<?php endif; ?>
}
<?php endif; ?>

<?php echo $smof_data['custom_css']; ?>