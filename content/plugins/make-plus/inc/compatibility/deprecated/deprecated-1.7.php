<?php
/**
 * @package Make Plus
 */

// Bail if this isn't being included inside of a MAKEPLUS_Compatibility_MethodsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKEPLUS_Compatibility_MethodsInterface ) {
	return;
}

if ( ! function_exists( 'ttfmp_get_app' ) ) :
/**
 * Instantiate or return the one TTFMP_App instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_App
 */
function ttfmp_get_app() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()' );
	return MakePlus();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_app', '1.7.0', 'MakePlus()' );
endif;

/**
 * Instantiate or return the one TTFMP_Admin_Notice instance.
 *
 * @since  1.6.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Admin_Notice
 */
function ttfmp_admin_notice() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->notice()' );
	return MakePlus()->notice();
}

/**
 * Wrapper function to register an admin notice.
 *
 * @since 1.6.0.
 * @deprecated 1.7.0.
 *
 * @param string    $id         A unique ID string for the admin notice.
 * @param string    $message    The content of the admin notice.
 * @param array     $args       Array of configuration parameters for the admin notice.
 * @return void
 */
function ttfmp_register_admin_notice( $id, $message, $args ) {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->notice()->register_admin_notice()' );
	MakePlus()->notice()->register_admin_notice( $id, $message, $args );
}

/**
 * Add notices to the Admin screens.
 *
 * @since 1.6.0.
 *
 * @return void
 */
function ttfmp_add_admin_notices() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
}

if ( ! function_exists( 'ttfmp_get_shop_settings' ) ) :
/**
 * Instantiate or return the one TTFMP_WooCommerce instance.
 *
 * @since  1.2.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_WooCommerce
 */
function ttfmp_get_shop_settings() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
	return new stdClass();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_shop_settings', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmp_get_shop_sidebar' ) ) :
/**
 * Instantiate or return the one TTFMP_Shop_Sidebar instance.
 *
 * @since  1.2.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Shop_Sidebar
 */
function ttfmp_get_shop_sidebar() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
	return new stdClass();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_shop_sidebar', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmp_get_duplicator' ) ) :
/**
 * Instantiate or return the one TTFMP_Duplicator instance.
 *
 * @since  1.1.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Duplicator
 */
function ttfmp_get_duplicator() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'duplicator\' )' );
	return MakePlus()->get_component( 'duplicator' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_duplicator', '1.7.0', 'MakePlus()->get_component( \'duplicator\' )' );
endif;

if ( ! function_exists( 'ttfmp_get_page_duplicator' ) ) :
/**
 * Instantiate or return the one TTFMP_Page_Duplicator instance.
 *
 * @since  1.1.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Page_Duplicator
 */
function ttfmp_get_page_duplicator() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'duplicator\' )->page_duplicator()' );
	return MakePlus()->get_component( 'duplicator' )->page_duplicator();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_page_duplicator', '1.7.0', 'MakePlus()->get_component( \'duplicator\' )->page_duplicator()' );
endif;

if ( ! function_exists( 'ttfmp_get_section_duplicator' ) ) :
/**
 * Instantiate or return the one TTFMP_Section_Duplicator instance.
 *
 * @since  1.2.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Section_Duplicator
 */
function ttfmp_get_section_duplicator() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'duplicator\' )->section_duplicator()' );
	return MakePlus()->get_component( 'duplicator' )->section_duplicator();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_section_duplicator', '1.7.0', 'MakePlus()->get_component( \'duplicator\' )->section_duplicator()' );
endif;

/**
 * Remove slashes from each value in a multidimensional array.
 *
 * Used as a callback for array_map().
 *
 * @since  1.2.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $item    Current array value item to process.
 * @param  string    $key     Current array key to process.
 * @return void
 */
function ttf_recursive_stripslashes( &$item, $key ) {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
}

if ( ! function_exists( 'ttfmp_get_edd' ) ) :
/**
 * Instantiate or return the one TTFMP_EDD instance.
 *
 * @since  1.1.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_EDD
 */
function ttfmp_get_edd() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'edd\' )' );
	return MakePlus()->get_component( 'edd' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_edd', '1.7.0', 'MakePlus()->get_component( \'edd\' )' );
endif;

if ( ! function_exists( 'ttfmp_edd_add_color_css' ) ) :
/**
 * Use Make's color options to override some of EDD's CSS styles
 *
 * @since 1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmp_edd_add_color_css() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_edd_add_color_css', '1.7.0' );
endif;

/**
 * Instantiate or return the one TTFMP_EDD_Section_Definitions instance.
 *
 * @since  1.1.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_EDD_Section_Definitions
 */
function ttfmp_edd_get_section_definitions() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'edd\' )' );
	return MakePlus()->get_component( 'edd' );
}

if ( ! function_exists( 'ttfmp_get_perpage' ) ) :
/**
 * Instantiate or return the one TTFMP_PerPage instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_PerPage
 */
function ttfmp_get_perpage() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'perpage\' )' );
	return MakePlus()->get_component( 'perpage' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_perpage', '1.7.0', 'MakePlus()->get_component( \'perpage\' )' );
endif;

if ( ! function_exists( 'ttfmp_get_perpage_options' ) ) :
/**
 * Instantiate or return the one TTFMP_PerPage_Options instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_PerPage_Options
 */
function ttfmp_get_perpage_options() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'perpage\' )->settings()' );
	return MakePlus()->get_component( 'perpage' )->settings();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_perpage_options', '1.7.0', 'MakePlus()->get_component( \'perpage\' )->settings()' );
endif;

if ( ! function_exists( 'ttfmp_get_perpage_metabox' ) ) :
/**
 * Instantiate or return the one TTFMP_PerPage_Metabox instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_PerPage_Metabox
 */
function ttfmp_get_perpage_metabox() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'perpage\' )->metabox()' );
	return MakePlus()->get_component( 'perpage' )->metabox();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_perpage_metabox', '1.7.0', 'MakePlus()->get_component( \'perpage\' )->metabox()' );
endif;

if ( ! function_exists( 'ttfmp_get_post_list' ) ) :
/**
 * Instantiate or return the one TTFMP_Post_List instance.
 *
 * @since  1.2.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Post_List
 */
function ttfmp_get_post_list() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'postslist\' )' );
	return MakePlus()->get_component( 'postslist' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_post_list', '1.7.0', 'MakePlus()->get_component( \'postslist\' )' );
endif;

/**
 * Instantiate or return the one TTFMP_Post_List_Section_Definitions instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Post_List_Section_Definitions
 */
function ttfmp_post_list_get_section_definitions() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'postslist\' )' );
	return MakePlus()->get_component( 'postslist' );
}

if ( ! class_exists( 'TTFMP_Post_List_Widget' ) ) :
/**
 * Class TTFMP_Post_List_Widget
 *
 * @since 1.2.0.
 * @deprecated 1.7.0.
 */
class TTFMP_Post_List_Widget extends MAKEPLUS_Component_PostsList_Widget {
	public function __construct() {
		if ( MakePlus()->has_module( 'theme' ) ) {
			MakePlus()->theme()->error()->add_error(
				'makeplus_postslist_widget_deprecated',
				sprintf(
					esc_html__( 'The %1$s widget class is deprecated. Use %2$s instead.', 'make' ),
					'<code>TTFMP_Post_List_Widget</code>',
					'<code>MAKEPLUS_Component_PostsList_Widget</code>'
				)
			);
		}

		parent::__construct();
	}
}
endif;

if ( ! function_exists( 'ttfmp_get_quick_start' ) ) :
/**
 * Instantiate or return the one TTFMP_Quick_Start instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Quick_Start
 */
function ttfmp_get_quick_start() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
	return new stdClass();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_quick_start', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmp_get_template_url' ) ) :
/**
 * Generate a URL for adding a builder page template.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string    $template_name    The ID for a registered template.
 * @param  int       $post_id          The ID for a post if replacing content.
 * @return string                      The composed link.
 */
function ttfmp_get_template_url( $template_name, $post_id = 0 ) {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
	return '';
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_template_url', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmp_sideload_image' ) ) :
/**
 * Add an image as a WordPress attachment.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  string        $file_path    The path to the image.
 * @param  string        $desc         An optional image description.
 * @return int|object                  WP_Error on failure; Post ID on success.
 */
function ttfmp_sideload_image( $file_path, $desc = '' ) {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
	return 0;
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_sideload_image', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmp_get_template_collector' ) ) :
/**
 * Instantiate or return the one TTFMP_Template_Collector instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Template_Collector
 */
function ttfmp_get_template_collector() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
	return new stdClass();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_template_collector', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmp_register_template' ) ) :
/**
 * Add a template to the collector.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  TTTFMP_Template    $template    The template as a TTTFMP_Template object.
 * @return void
 */
function ttfmp_register_template( $template ) {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_register_template', '1.7.0' );
endif;


if ( ! function_exists( 'ttfmp_get_style_kits' ) ) :
/**
 * Instantiate or return the one TTFMP_Style_Kits instance.
 *
 * @since  1.1.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Style_Kits
 */
function ttfmp_get_style_kits() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
	return new stdClass();
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_style_kits', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmp_style_kit_definitions' ) ) :
/**
 * Define the settings for each Style Kit.
 *
 * @since 1.1.0.
 * @deprecated 1.7.0.
 *
 * @return array    The array of settings for each kit.
 */
function ttfmp_style_kit_definitions() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_style_kit_definitions', '1.7.0' );
endif;

if ( has_filter( 'ttfmp_style_kit_definitions' ) ) {
	MakePlus()->compatibility()->deprecated_hook( 'ttfmp_style_kit_definitions', '1.7.0' );
}

if ( has_filter( 'ttfmp_style_kit_allowed_option_keys' ) ) {
	MakePlus()->compatibility()->deprecated_hook( 'ttfmp_style_kit_allowed_option_keys', '1.7.0' );
}

if ( ! function_exists( 'ttfmp_get_text_column_layout' ) ) :
/**
 * Instantiate or return the one TTFMP_Text_Column_Layout instance.
 *
 * @since  1.3.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Text_Column_Layout
 */
function ttfmp_get_text_column_layout() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'columnsize\' )' );
	return MakePlus()->get_component( 'columnsize' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_text_column_layout', '1.7.0', 'MakePlus()->get_component( \'columnsize\' )' );
endif;

if ( ! function_exists( 'ttfmp_get_typekit' ) ) :
/**
 * Instantiate or return the one TTFMP_Typekit instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Typekit
 */
function ttfmp_get_typekit() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'typekit\' )' );
	return MakePlus()->get_component( 'typekit' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_typekit', '1.7.0', 'MakePlus()->get_component( \'typekit\' )' );
endif;

if ( ! function_exists( 'ttfmp_get_typekit_customizer' ) ) :
/**
 * Instantiate or return the one TTFMP_Typekit_Customizer instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Typekit_Customizer
 */
function ttfmp_get_typekit_customizer() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'typekit\' )' );
	return MakePlus()->get_component( 'typekit' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_typekit_customizer', '1.7.0', 'MakePlus()->get_component( \'typekit\' )' );
endif;

if ( ! function_exists( 'ttfmp_get_widget_area' ) ) :
/**
 * Instantiate or return the one TTFMP_Widget_Area instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Widget_Area
 */
function ttfmp_get_widget_area() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'widgetareas\' )' );
	return MakePlus()->get_component( 'widgetareas' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_widget_area', '1.7.0', 'MakePlus()->get_component( \'widgetareas\' )' );
endif;

if ( ! function_exists( 'ttfmp_get_sidebar_management' ) ) :
/**
 * Instantiate or return the one TTFMP_Sidebar_Management instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_Sidebar_Management
 */
function ttfmp_get_sidebar_management() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'widgetareas\' )' );
	return MakePlus()->get_component( 'widgetareas' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_sidebar_management', '1.7.0', 'MakePlus()->get_component( \'widgetareas\' )' );
endif;

if ( ! function_exists( 'ttfmp_register_sidebar' ) ) :
/**
 * Adds a sidebar via the component pieces.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  int       $page_id       The ID of the page.
 * @param  string    $section_id    The section ID. Value is numeric, but will be greater than the max int value.
 * @param  int       $column_id     The column number.
 * @param  string    $label         The label for the sidebar.
 * @return void
 */
function ttfmp_register_sidebar( $page_id, $section_id, $column_id, $label ) {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_register_sidebar', '1.7.0' );
endif;

if ( ! function_exists( 'ttfmp_get_woocommerce' ) ) :
/**
 * Instantiate or return the one TTFMP_WooCommerce instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_WooCommerce
 */
function ttfmp_get_woocommerce() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'woocommerce\' )' );
	return MakePlus()->get_component( 'woocommerce' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_get_woocommerce', '1.7.0', 'MakePlus()->get_component( \'woocommerce\' )' );
endif;

/**
 * Instantiate or return the one TTFMP_WooCommerce_Section_Definitions instance.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_WooCommerce_Section_Definitions
 */
function ttfmp_woocommerce_get_section_definitions() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'woocommerce\' )' );
	return MakePlus()->get_component( 'woocommerce' );
}

if ( ! function_exists( 'ttfmp_woocommerce_product_grid_shortcode' ) ) :
/**
 * Wrapper function for the Product Grid method.
 *
 * @since  1.0.0.
 * @deprecated 1.7.0.
 *
 * @param  array     $atts    The attributes from the Product Grid shortcode.
 * @return string             The markup.
 */
function ttfmp_woocommerce_product_grid_shortcode( $atts ) {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'woocommerce\' )->handle_shortcode' );
	return MakePlus()->get_component( 'woocommerce' )->handle_shortcode( $atts );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_woocommerce_product_grid_shortcode', '1.7.0', 'MakePlus()->get_component( \'woocommerce\' )->handle_shortcode' );
endif;

/**
 * Instantiate or return the one TTFMP_WooCommerce_Legacy_Color instance.
 *
 * @since 1.5.0.
 * @deprecated 1.7.0.
 *
 * @return TTFMP_WooCommerce_Legacy_Color
 */
function ttfmp_woocommerce_legacy_color() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'woocommerce\' )->legacy_color()' );
	return MakePlus()->get_component( 'woocommerce' )->legacy_color();
}

if ( ! function_exists( 'ttfmp_woocommerce_add_color_css' ) ) :
/**
 * Use Make's color options to override some of WooCommerce's CSS styles
 *
 * @since 1.0.0.
 * @deprecated 1.7.0.
 *
 * @return void
 */
function ttfmp_woocommerce_add_color_css() {
	MakePlus()->compatibility()->deprecated_function( __FUNCTION__, '1.7.0', 'MakePlus()->get_component( \'woocommerce\' )->legacy_color()->add_styles' );
}
else :
	MakePlus()->compatibility()->deprecated_function( 'ttfmp_woocommerce_add_color_css', '1.7.0', 'MakePlus()->get_component( \'woocommerce\' )->legacy_color()->add_styles' );
endif;