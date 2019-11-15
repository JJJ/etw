<?php

/**
 * Public API
 * These functions expose Cornerstone APIs, allowing it to be extended.
 * The processes represented here are otherwise handled internally.
 */

/**
 * Set which post types should be enabled by default when Cornerstone is first
 * activated.
 * @param  array $types Array of strings specifying post type names.
 * @return none
 */
function cornerstone_set_default_post_types( $types ) {
	// Deprecated
}

/**
 * Allows integrating themes to disable Themeco cross-promotion, and other
 * presentational items. Example:
 *
		cornerstone_theme_integration( array(
			'remove_global_validation_notice' => true,
			'remove_themeco_offers'           => true,
			'remove_purchase_link'            => true,
			'remove_support_box'              => true
		) );
 *
 * @param  array $args List of items to flag
 * @return none
 */
function cornerstone_theme_integration( $args ) {
	CS()->component( 'Integration_Manager' )->theme_integration( $args );
}



/**
 * Registers a class as a candidate for Cornerstone Integration
 * Call from within this hook: cornerstone_integrations (happens before init)
 * @param  string $name       unique handle
 * @param  string $class_name Class to test conditions for, and eventually load
 * @return  none
 */
function cornerstone_register_integration( $name, $class_name ) {
	CS()->component( 'Integration_Manager' )->register( $name, $class_name );
}

/**
 * Unregister an integration that's been added so far
 * Call from within this hook: cornerstone_integrations (happens before init)
 * You may need to call on a later priority to ensure it was already registered
 * @param  string $name       unique handle
 * @return  none
 */
function cornerstone_unregister_integration( $name ) {
	CS()->component( 'Integration_Manager' )->unregister( $name );
}

function cornerstone_register_element_styles( $id, $elements ) {
  return CS()->component( 'Element_Front_End' )->register_element_styles( $id, $elements );
}

function cornerstone_register_styles( $id, $css ) {
  return CS()->component( 'Styling' )->add_styles( $id, $css );
}

function cornerstone_options_register_option( $name, $default_value = null, $options = array() ) {
  $options_bootstrap = CS()->component( 'Options_Bootstrap' );
  $options_bootstrap->register_option( $name, $default_value, $options );
}

function cornerstone_options_register_options( $group, $options = array() ) {
  $options_bootstrap = CS()->component( 'Options_Bootstrap' );
  $options_bootstrap->register_options( $group, $options );
}

function cornerstone_options_get_defaults() {
  return CS()->component( 'Options_Bootstrap' )->get_defaults();
}

function cornerstone_options_get_default( $name ) {
  return CS()->component( 'Options_Bootstrap' )->get_default( $name );
}

function cornerstone_options_get_value( $name ) {
  return CS()->component( 'Options_Bootstrap' )->get_value( $name );
}

function cornerstone_options_update_value( $name, $value ) {
  return CS()->component( 'Options_Bootstrap' )->update_value( $name, $value );
}

function cornerstone_options_register_section( $name, $value = array() ) {
  return CS()->component( 'Options_Manager' )->register_section( $name, $value );
}

function cornerstone_options_register_sections( $groups ) {
  return CS()->component( 'Options_Manager' )->register_sections( $groups );
}

function cornerstone_options_register_control( $option_name, $control ) {
  return CS()->component( 'Options_Manager' )->register_control( $option_name, $control );
}

function cornerstone_options_unregister_option( $name ) {
  return CS()->component( 'Options_Bootstrap' )->unregister_option( $name );
}

function cornerstone_options_unregister_section( $name ) {
  return CS()->component( 'Options_Manager' )->unregister_section( $name );
}

function cornerstone_options_unregister_control( $option_name ) {
  return CS()->component( 'Options_Manager' )->unregister_control( $option_name );
}

function cornerstone_options_enable_custom_css( $option_name, $selector = '' ) {
  return CS()->component( 'Options_Manager' )->enable_custom_css( $option_name, $selector = '' );
}

function cornerstone_options_enable_custom_js( $option_name ) {
  return CS()->component( 'Options_Manager' )->enable_custom_js( $option_name );
}

function cornerstone_preview_container_output() {
  if ( apply_filters('cornerstone_preview_container_output', true ) ) {
    echo '{%%{children}%%}';
  }
}

/**
 * Returns the data for header currently assigned
 * Can be called as early as template_redirect
 * @return string
 */
function cornerstone_get_header_data( $fallback = false ) {
  $regions = CS()->component( 'Regions' );
  return ( $regions ) ? $regions->get_active_header_data( $fallback ) : '';
}


/**
 * Returns the data for header currently assigned
 * Can be called as early as template_redirect
 * @return string
 */
function cornerstone_get_footer_data( $fallback = false ) {
  $regions = CS()->component( 'Regions' );
  return ( $regions ) ? $regions->get_active_footer_data( $fallback ) : '';
}

function cornerstone_enqueue_custom_script( $id, $content, $type = 'text/javascript' ) {
	return CS()->component( 'Inline_Scripts' )->add_script( $id, $content, $type );
}

function cornerstone_dequeue_custom_script( $id ) {
	return CS()->component( 'Inline_Scripts' )->remove_script( $id );
}

function cornerstone_post_process_css( $css, $minify = false ) {
	CS()->component('Font_Manager');
  CS()->component('Color_Manager');
	return CS()->component( 'Styling' )->post_process( array( 'css' => $css, 'minify' => $minify ) );
}

function cornerstone_post_process_color( $value ) {
  CS()->component('Color_Manager');
	return apply_filters('cs_css_post_process_color', $value);
}

function cornerstone_cleanup_generated_styles() {
  return CS()->component('Cleanup')->clean_generated_styles();
}

function cornerstone_restore_import_starter_pack() {
  return CS()->component('Template_Manager')->unhide_starter_pack();
}

function cornerstone_queue_font( $font ) {
  return CS()->component('Font_Manager')->queue_font( $font );
}

function cornerstone_dynamic_content_register_field( $field ) {
  CS()->component('Dynamic_Content')->register_field( $field );
}

function cornerstone_dynamic_content_register_group( $group ) {
  CS()->component('Dynamic_Content')->register_group( $group );
}

function cs_dynamic_content( $content = '' ) {
  return apply_filters( 'cs_dynamic_content', $content );
}

/**
 * Deprecated
 */
function cornerstone_add_element( $class_name ) {
	CS()->component( 'Element_Orchestrator' )->add_mk1_element( $class_name );
}

function cornerstone_make_placeholder_image_uri( $height = '300', $width = '250', $color = '#eeeeee' ) {
	return CS()->common()->placeholderImage( $height, $width, $color );
}

function cornerstone_get_element( $name ) {
  return cs_get_element( $name );
}

function cornerstone_register_element( $type, $atts, $deprecated = null ) {
  if ( null !== $deprecated || is_string( $atts ) ) {
    /**
     * Override for old method. Register a new element
     * @param  $class_name Name of the class you've created in definition.php
     * @param  $name       slug name of the element. "alert" for example.
     * @param  $path       Path to the folder containing a definition.php file.
     */
  	CS()->component( 'Element_Orchestrator' )->add( $type, $atts, $deprecated );
    return;
  }

  cs_register_element( $type, $atts );
}

function cornerstone_remove_element( $name ) {
	CS()->component( 'Element_Orchestrator' )->remove( $name );
}
