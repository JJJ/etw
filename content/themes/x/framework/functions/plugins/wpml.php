<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/WPML.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Add Missing Navigation Class
//	 02. Add template override to force WPML to use the correct templates
// =============================================================================

// Add Missing Navigation Class
// =============================================================================

function x_wpml_add_classes_for_language_switcher( $menu_items ) {

  $menu_items = preg_replace( '/(menu-item-language )(?=.*?<a href="#" onclick="return false">)/', 'menu-item-has-children menu-item-language ', $menu_items );

  return $menu_items;

}

add_filter( 'wp_nav_menu_items', 'x_wpml_add_classes_for_language_switcher' );



// Translate page and term ids in custom sidebar settings
// ======================================================================================

function x_wpml_translate_ups_sidebar_settings( $sidebars ) {
	foreach ( $sidebars as $id => &$sidebar ) {
		if ( array_key_exists( 'pages', $sidebar ) ) {
			$pages = array();
			foreach ( $sidebar['pages'] as $id => $title ) {
				$id = apply_filters( 'wpml_object_id', $id, get_post_type( $id ) );
				$pages[ $id ] = $title;
			}
			$sidebar['pages']= $pages;
		}
		if ( array_key_exists( 'taxonomies', $sidebar ) ) {
			$taxonomies = array();
			foreach ( $sidebar['taxonomies'] as $id => $title ) {
				$term = get_term( $id );
				$id = apply_filters( 'wpml_object_id', $id, $term->taxonomy );
				$taxonomies[ $id ] = $term->name;
			}
			$sidebar['taxonomies'] = $taxonomies;
		}
	}
	return $sidebars;
}

add_filter( 'option_ups_sidebars', 'x_wpml_translate_ups_sidebar_settings' );
