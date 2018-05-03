<?php

// =============================================================================
// FUNCTIONS/HEADER/HELPERS.PHP
// -----------------------------------------------------------------------------
// Header helper functions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Base Element
//   02. Render Bar Module
//   03. Render Bar Modules
//   04. Value: Default / Designation
//   05. Module Decorate
//   06. Get Partial Data
//   07. Module Conditions
//   08. Return Bar Mixin Values
//   09. Custom Menu Item Output
//   10. Generated Navigation
// =============================================================================

// Base Element
// =============================================================================

function x_element_base( $data ) {
  return CS()->component('Element_Manager')->native_element_base( $data );
}



// Render Bar Module
// =============================================================================

function x_render_bar_module( $module, $global = array(), $parent = null ) {

  $module['global'] = $global;

  if ( ! isset( $module['_modules'] ) ) {
    $module['_modules'] = array();
  }

  x_get_view( 'elements', $module['_type'], '', x_module_decorate( $module, $parent ) );

}



// Render Bar Modules
// =============================================================================

function x_render_bar_modules( $modules, $global = array(), $parent = null ) {

  // Used for content when modules are rendered via shortcodes
  if ( is_string( $modules ) ) {
    echo $modules;
    return;
  }

  if ( ! is_array( $modules ) ) {
    return;
  }

  foreach ( $modules as $module ) {
    if ( isset( $module['_type'] ) ) {
      x_render_bar_module( $module, $global, $parent );
    }
  }
}



// Value: Default / Designation / Protected
// =============================================================================

function x_module_value( $default = null, $designation = 'all', $protected = false ) {

  return array( 'default' => $default, 'designation' => $designation, 'protected' => $protected );

}



// Module Decorate
// =============================================================================

function x_module_decorate( $module, $parent = null ) {

  if ( isset( $module['_type'] ) ) {

    $decorator  = 'x_module_decorator_' . str_replace( '-', '_', $module['_type'] );
    $definition = cornerstone_get_element( $module['_type'] );

    $module     = x_module_decorator_base( $definition->apply_defaults( $module ) );

    if ( function_exists( $decorator ) ) {
      $module = call_user_func_array( $decorator, array( $module ) );
    }

    // Allow shadow elements to get parent keys
    // This only applies in direct content rendering like headers/footers
    if ( ! is_null( $parent ) && $definition->is_shadow() ) {
      $module['p_mod_id'] = $parent['mod_id'];
      foreach ($parent as $key => $value) {
        if ( ! isset( $module[$key] ) ) {
          $module[$key] = $value;
        }
      }
    }

  }

  return $module;

}



// Get Partial Data
// =============================================================================

function x_get_partial_data( $_custom_data, $args = array() ) {

  // Notes
  // -----
  // 01. ['pass_on'] - Grabs any top level data points from $_custom_data for
  //     use in the partial template.
  // 02. ['add_in'] - Introduces previously non-existent data for use in the
  //     partial template. Needs to be after 'pass_on' so things like 'id' or
  //     'class' can be overwritten as necessary.
  // 03. ['keep_out'] - Removes any top level data points from $_custom_data to
  //     avoid potential conflicts in the partial template.
  // 04. ['find_data'] - (a) Returns $_custom_data with a beginning that matches
  //     the $key and (b) that $_custom_data is cleaned to reflect the $value as
  //     the new beginning so it can be passed on to the partial template.

  $defaults = array(
    'pass_on'   => array( '_region', '_id', 'mod_id', 'id', 'class' ),
    'add_in'    => array(),
    'keep_out'  => array(),
    'find_data' => array(),
  );

  $args         = array_merge( $defaults, $args );
  $partial_data = array();

  foreach ( $args['pass_on'] as $key ) {
    $partial_data[$key] = $_custom_data[$key]; // 01
  }

  foreach ( $args['add_in'] as $key => $value ) {
    $partial_data[$key] = $value; // 02
  }

  foreach ( $args['keep_out'] as $key ) {
    unset( $_custom_data[$key] ); // 03
  }

  foreach ( $args['find_data'] as $begins_with => $update_to ) :

    foreach ( $_custom_data as $key => $value ) :
      if ( 0 === strpos( $key, $begins_with )  ) { // 04 a

        if ( ! empty( $update_to ) ) {
          $key = $update_to . substr( $key, strlen( $begins_with ) );
        }

        $partial_data[$key] = $value;

      }
    endforeach;

  endforeach;

  return $partial_data;

}



// Module Conditions
// =============================================================================
// Replaced array_keys( $condition, array() ) with array_keys( $condition ) as
// it was wrapping an extra array too many times. Will need to check this with
// all elements to ensure that it hasn't adversely affected anything.

function x_module_conditions( $condition ) {

  // $condition = ( count( array_keys( $condition ) ) > 0 ) ? $condition : array( $condition ); // 01
  $condition = ( count( array_keys( $condition, array() ) ) > 0 ) ? $condition : array( $condition ); // 01

  return $condition;

}



// Return Bar Mixin Values
// =============================================================================

function x_bar_mixin_values( $values, $settings ) {

  $theme = ( isset( $settings['theme'] ) && is_array( $settings['theme'] ) ) ? $settings['theme']       : array();
  $k_pre = ( isset( $settings['k_pre'] )                                   ) ? $settings['k_pre'] . '_' : '';

  $new_values = array();

  foreach ( $theme as $key => $value ) {
    $new_values[$k_pre . $key] = $value;
  }

  return wp_parse_args( $new_values, $values );

}



// Custom Menu Item Output
// =============================================================================

class X_Walker_Nav_Menu extends Walker_Nav_Menu {

  public $x_menu_data;
  public $x_menu_type;

  public function __construct( $x_menu_data = array() ) {
    $this->x_menu_data = $x_menu_data;
    $this->x_menu_type = ( isset( $x_menu_data['menu_type'] ) ) ? $x_menu_data['menu_type'] : 'inline';
  }


  // start_lvl()
  // -----------

  public function start_lvl( &$output, $depth = 0, $args = array() ) {

    $ul_atts = array(
      'class' => 'sub-menu'
    );

    if ( in_array( $this->x_menu_type, array( 'inline', 'dropdown' ), true ) ) {

      $ul_atts['data-x-depth'] = $depth;
      $ul_atts['class']       .= ' x-dropdown';
      $ul_atts['data-x-stem']  = NULL;


      // Notes: "data-x-stem-top" Attribute
      // ----------------------------------
      // This "data-x-stem-top" logic is implemented in the bars helper.php
      // file for "inline" navigation and in the menu partial for "dropdown"
      // navigation as their first dropdown is contextually different (e.g.
      // the first dropdown for "inline" navigation is at $depth === 0 in the
      // helper walker, but the first dropdown for "dropdown" navigation is the
      // menu partial itself (these notes duplicated in both spots).
      //
      // "r" to reverse direction
      // "h" to begin flowing horizontally

      if ( $depth === 0 && $this->x_menu_type === 'inline' ) {

        $ul_atts['data-x-stem-top'] = NULL;

        if ( isset( $this->x_menu_data['_region'] ) ) {

          if ( $this->x_menu_data['_region'] === 'left' ) {
            $ul_atts['data-x-stem-top'] = 'h';
          }

          if ( $this->x_menu_data['_region'] === 'right' ) {
            $ul_atts['data-x-stem-top'] = 'rh';
          }

        }

      }

    }

    $output .= '<ul ' . x_atts( $ul_atts ) . '>';

  }


  // start_el()
  // ----------

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    // Begin WP Formatting
    // -------------------
    // Section outputting $attributes was removed in favor of merging $atts
    // into our own x_atts() function.

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;
    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
    $li_classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );

    // To be removed when Modal navigation supports multiple levels
    if ( 'modal' === $this->x_menu_type ) {
      $has_children_class = array_search('menu-item-has-children', $li_classes);
      if (false !== $has_children_class) {
          unset($li_classes[$has_children_class]);
      }
    }

    $li_atts = array( 'class' => join( ' ', $li_classes ) );
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    if ( $id ) { $li_atts['id'] = $id; }
    if ( 'collapsed' === $this->x_menu_type && in_array( 'menu-item-has-children', $item->classes ) ) {
      $li_atts['data-x-collapse'] = 'closed';
    }
    $output .= '<li ' . x_atts( $li_atts ) .'>';
    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );


    // Begin X Formatting
    // ------------------
    // 01. Merge meta from the WP menu system into our main data to complete
    //     the whole picture.
    // 02. Sub anchors with unique styling need to have their keys cleaned as
    //     well as ensuring $x_menu_meta_data still persists.

    if ( isset( $item->meta) ) {
      $x_item_meta = array();
      foreach ($item->meta as $key => $value) {
        $x_item_meta["menu-item-$key"] = array( $value );
      }
    } else {
      $x_item_meta = get_post_meta( $item->ID, '', true );
    }

    $x_anchor_graphic_icon          = ( isset( $x_item_meta['menu-item-anchor_graphic_icon'] )          ) ? $x_item_meta['menu-item-anchor_graphic_icon'][0] : '';
    $x_anchor_graphic_icon_alt      = ( isset( $x_item_meta['menu-item-anchor_graphic_icon_alt'] )      ) ? $x_item_meta['menu-item-anchor_graphic_icon_alt'][0] : '';
    $x_anchor_graphic_image_src     = ( isset( $x_item_meta['menu-item-anchor_graphic_image_src'] )     ) ? $x_item_meta['menu-item-anchor_graphic_image_src'][0] : '';
    $x_anchor_graphic_image_src_alt = ( isset( $x_item_meta['menu-item-anchor_graphic_image_src_alt'] ) ) ? $x_item_meta['menu-item-anchor_graphic_image_src_alt'][0] : '';
    $x_anchor_graphic_image_width   = ( isset( $x_item_meta['menu-item-anchor_graphic_image_width'] )   ) ? $x_item_meta['menu-item-anchor_graphic_image_width'][0] : '';
    $x_anchor_graphic_image_height  = ( isset( $x_item_meta['menu-item-anchor_graphic_image_height'] )  ) ? $x_item_meta['menu-item-anchor_graphic_image_height'][0] : '';

    $x_menu_meta_data = array(
      'anchor_text_primary_content'   => $title,
      'anchor_text_secondary_content' => $item->description,
      'anchor_graphic_icon'           => $x_anchor_graphic_icon,
      'anchor_graphic_icon_alt'       => $x_anchor_graphic_icon_alt,
      'anchor_graphic_image_src'      => $x_anchor_graphic_image_src,
      'anchor_graphic_image_src_alt'  => $x_anchor_graphic_image_src_alt,
      'anchor_graphic_image_width'    => $x_anchor_graphic_image_width,
      'anchor_graphic_image_height'   => $x_anchor_graphic_image_height,
      'atts'                          => array_filter( $atts ),
    );

    $x_has_unique_sub_styles = in_array( $this->x_menu_type, array( 'inline', 'collapsed' ), true ) && $depth !== 0;
    $k_pre                   = ( $x_has_unique_sub_styles ) ? 'sub_' : '';

    if ( $this->x_menu_data[$k_pre . 'anchor_text_primary_content'] !== 'on' ) {
      $x_menu_meta_data['anchor_text_primary_content'] = '';
    }

    if ( $this->x_menu_data[$k_pre . 'anchor_text_secondary_content'] !== 'on' ) {
      $x_menu_meta_data['anchor_text_secondary_content'] = '';
    }

    $x_anchor_data = array_merge( $this->x_menu_data, $x_menu_meta_data ); // 01

    unset( $x_anchor_data['sub_anchor_text_primary_content'] );
    unset( $x_anchor_data['sub_anchor_text_secondary_content'] );

    if ( $x_has_unique_sub_styles ) {

      $x_data_args = array(
        'pass_on'   => array_merge( array_keys( $x_menu_meta_data ), array( '_region', '_id', 'mod_id', 'id', 'class' ) ),
        'find_data' => array( 'sub_anchor' => 'anchor' ),
      );

      $x_anchor_data = x_get_partial_data( $x_anchor_data, $x_data_args ); // 02

    }


    // Item Output
    // -----------

    $item_output  = isset( $args->before ) ? $args->before : '';
    $item_output .= x_get_view( 'partials', 'anchor', '', $x_anchor_data, false );

    if ( isset( $args->after ) ) {
      $item_output .= $args->after;
    }



    // Final Output
    // ------------

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

  }


  // end_el()
  // --------

  public function end_el( &$output, $object, $depth = 0, $args = array() ) {
    $output .= '</li>';
  }


  // end_lvl()
  // --------

  public function end_lvl( &$output, $depth = 0, $args = array() ) {
    $output .= '</ul>';
  }

}



// Generated Navigation
// =============================================================================

function cs_pre_wp_nav_menu( $menu, $args ) { // 02

  if ( isset( $args->sample_menu ) ) {
    return cs_wp_nav_menu_fallback( array_merge( (array) $args, array( 'echo' => false ) ) );
  }

  return $menu;

}

add_filter( 'pre_wp_nav_menu', 'cs_pre_wp_nav_menu', 10, 2 );


function cs_wp_nav_menu_fallback( $args ) { // 02

  $fallback = new CS_Generated_Nav_Menu( $args );

  return $fallback->output();

}


class CS_Generated_Nav_Menu { // 02

  protected $args;
  protected $walker;

  public function __construct( $args ) {
    $this->args = $args;
    $this->walker = ( is_a( $args['walker'], 'X_Walker_Nav_Menu' ) ) ? $args['walker'] : new X_Walker_Nav_Menu;
  }

  protected function get_nav_items() {

    $samples = apply_filters('x_sample_menus', CS()->config_group( 'common/sample-nav') );

    if ( isset( $this->args['sample_menu'] ) && isset( $samples[$this->args['sample_menu']] ) ) {
      $items = $samples[$this->args['sample_menu']];
    } else {
      $items = $this->default_nav_items();
    }

    return $this->normalize_menu_items( $items );
  }

  public function default_nav_items() {
    return array(
      array(
        'title' => csi18n('common.menu-fallback'),
        'url'   => admin_url( 'nav-menus.php' )
      )
    );
  }

  public function output() {

    $items = $this->get_nav_items();

    if ( empty( $items ) ) {
      return false;
    }

    $item_output = '';

    if ( is_array( $items ) ) {
      foreach ( $items as $item ) {
        call_user_func_array( array( $this, 'display_nested_element' ), array( &$item_output, $item, -1 ) );
      }
    }

    $class  = $this->args['menu_class'] ? esc_attr( $this->args['menu_class'] ) : '';
    $output = sprintf( $this->args['items_wrap'], '', $class, $item_output );

    if ( $this->args['echo'] ) {
      echo $output;
    }

    return $output;

  }

  public function display_nested_element( &$output, $element, $depth ) {

    $depth++;

    call_user_func_array( array( $this->walker, 'start_el' ), array( &$output, $element, $depth, $this->args ) );
    $max_depth = ( isset( $this->args['depth'] ) && $this->args['depth'] === $depth + 1 );
    if ( ! $max_depth && isset( $element->children ) && ! empty( $element->children ) ) {
      call_user_func_array( array( $this->walker, 'start_lvl' ), array( &$output, $depth, $this->args ) );
      foreach ( $element->children as $child ) {
        call_user_func_array( array( $this, 'display_nested_element' ), array( &$output, $child, $depth, $this->args ) );
      }
      call_user_func_array( array( $this->walker, 'end_lvl' ), array( &$output, $depth, $this->args ));
    }
    call_user_func_array( array( $this->walker, 'end_el' ), array( &$output, $element, $depth, $this->args ));

    return $output;

  }

  public function normalize_menu_items( $items ) {

    if ( empty( $items ) ) {
      return array();
    }

    static $id_counter = 0;

    $defaults = array(
      'ID'          => 'sample',
      'title'       => '',
      'description' => '',
      'attr_title'  => '',
      'target'      => '',
      'xfn'         => '',
      'url'         => '',
      'type'        => 'sample',
      'object_id'   => 'sample',
      'classes'     => array(),
      'meta'        => array()
    );

    $default_classes  = array( 'menu-item', 'menu-item-type-custom', 'menu-item-object-custom' );
    $normalized_items = array();

    foreach ( $items as $item ) {

      $normalized            = wp_parse_args($item, $defaults);
      $normalized['ID']     .= '-' . $id_counter++ ;
      $normalized['classes'] = array_merge( $normalized['classes'], $default_classes );

      if ( isset( $normalized['children'] ) ) {
        $normalized['children']  = $this->normalize_menu_items( $normalized['children'] );
        $normalized['classes'][] = 'menu-item-has-children';
      }

      $normalized_items[] = (object) $normalized;

    }

    return $normalized_items;

  }

}
