<?php

// =============================================================================
// FUNCTIONS/HEADER/HELPERS.PHP
// -----------------------------------------------------------------------------
// Header helper functions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Render Bar Modules
//   02. Decorate
//   03. Custom Menu Item Output
//   04. Generated Navigation
// =============================================================================

// Render Bar Elements
// =============================================================================

function x_render_elements( $elements, $parent = null ) {

  // Used for content when elements are rendered via shortcodes
  if ( is_string( $elements ) ) {
    echo $elements;
    return;
  }

  if ( ! is_array( $elements ) ) {
    return;
  }

  foreach ( $elements as $element ) {
    $decorated = x_element_decorate( $element, $parent );
    if ( isset( $decorated['_def'] ) ) {
      echo $decorated['_def']->render( $decorated );
    }
  }
}



// Decorate
// =============================================================================

function x_element_decorate( $element, $parent = null ) {

  if ( ! isset( $element['_type'] ) ) {
    return array();
  }

  if ( ! isset( $element['_modules'] ) ) {
    $element['_modules'] = array();
  }

  $definition = cs_get_element( $element['_type'] );

  $element = $definition->apply_defaults( $element );

  // Escape based on element value designations
  $element = $definition->escape( $element );

  $element['_def'] = $definition;

  if ( ! isset( $element['_region'] ) ) {
    $element['_region'] = 'top';
  }

  $unique_id = $element['_id'];

  if ( isset( $element['_p'] ) ) {
    $unique_id = $element['_p'] . '-' . $unique_id;
  }

  $element['mod_id'] = 'e' . $unique_id;

  if ( ! empty( $element['hide_bp'] ) ) {
    $hide_bps = explode( ' ', trim($element['hide_bp']) );
    foreach ( $hide_bps as $bp ) {
      if ( $bp == 'none' ) {
        continue;
      }
      $element['class'] .= ' x-hide-' . $bp;
    }
  }

  // Allow shadow elements to get parent keys
  // This only applies in direct content rendering like headers/footers
  if ( ! is_null( $parent ) && $definition->is_child() ) {

    $element['p_mod_id'] = $parent['mod_id'];

    foreach ($parent as $key => $value) {
      if ( ! isset( $element[$key] ) ) {
        $element[$key] = $value;
      }
    }
  }

  return $element;

}



// Custom Menu Item Output
// =============================================================================

class X_Walker_Nav_Menu extends Walker_Nav_Menu {

  public $x_menu_data;
  public $x_menu_type;
  public $x_menu_item_count;

  public function __construct( $x_menu_data = array() ) {
    $this->x_menu_data       = $x_menu_data;
    $this->x_menu_type       = ( isset( $x_menu_data['menu_type'] ) ) ? $x_menu_data['menu_type'] : 'inline';
    $this->x_menu_item_count = 0;
  }

  public function x_get_unique_id( $count = NULL, $id = NULL, $delim = NULL ) {

    $id    = ( ! empty( $id )    ) ? $id    : $this->x_menu_data['mod_id'];
    $delim = ( ! empty( $delim ) ) ? $delim : '-';
    $count = ( ! empty( $count ) ) ? $count : $this->x_menu_item_count;

    return $id . $delim . $count;
  }


  // start_lvl()
  // -----------

  public function start_lvl( &$output, $depth = 0, $args = array() ) {

    $ul_atts = array(
      'class' => 'sub-menu'
    );


    // Inline and Dropdown
    // -------------------

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


    // Collapsed
    // ---------

    if ( $this->x_menu_type === 'collapsed' ) {

      $ul_atts['id']                     = 'x-menu-collapsed-list-' . $this->x_get_unique_id();
      $ul_atts['class']                 .= ' x-collapsed';
      $ul_atts['aria-hidden']            = 'true';
      $ul_atts['aria-labelledby']        = 'x-menu-collapsed-anchor-' . $this->x_get_unique_id();
      $ul_atts['data-x-toggleable']      = $this->x_get_unique_id();
      $ul_atts['data-x-toggle-collapse'] = true;

    }


    // Layered
    // -------

    if ( $this->x_menu_type === 'modal' || $this->x_menu_type === 'layered' ) {

      $ul_atts['id']                    = 'x-menu-layered-list-' . $this->x_get_unique_id();
      $ul_atts['aria-hidden']           = 'true';
      $ul_atts['aria-labelledby']       = 'x-menu-layered-anchor-' . $this->x_get_unique_id();
      $ul_atts['data-x-toggleable']     = $this->x_get_unique_id();
      $ul_atts['data-x-toggle-layered'] = true;

    }


    // Increment `x_menu_item_count`
    // -----------------------------
    // 01. Always increment `x_menu_item_count` to be utilized as an internal
    //     counter when needed.

    $output .= '<ul ' . x_atts( $ul_atts ) . '>';

    if ( $this->x_menu_type === 'modal' || $this->x_menu_type === 'layered' ) {

      $layered_back_atts = array(
        'class'             => 'x-anchor x-anchor-layered-back',
        'aria-label'        => __( 'Go Back One Level', '__x__' ),
        'data-x-toggle'     => 'layered',
        'data-x-toggleable' => $this->x_get_unique_id(),
      );

      $output .= '<li>'
                 . '<a ' . x_atts( $layered_back_atts ) . '>'
                   . '<span class="x-anchor-content">'
                     . '<span class="x-anchor-text">'
                       . '<span class="x-anchor-text-primary">' . $this->x_menu_data['menu_layered_back_label'] . '</span>'
                     . '</span>'
                   . '</span>'
                 . '</a>'
               . '</li>';

    }

    $this->x_menu_item_count++; // 01

  }


  // start_el()
  // ----------
  // Section outputting $attributes was removed in favor of merging $atts
  // into our own x_atts() function.
  //
  // 01. Utilize x_atts() to include <li> attributes.

  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;
    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
    $li_classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );
    $li_atts = array( 'class' => join( ' ', $li_classes ) );
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    if ( $id ) { $li_atts['id'] = $id; }
    $output .= '<li ' . x_atts( $li_atts ) . '>'; // 01
    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );


    // Get Item Meta
    // -------------

    if ( isset( $item->meta ) ) {
      $x_item_meta = array();
      foreach ( $item->meta as $key => $value ) {
        $x_item_meta['menu-item-' . $key] = array( $value );
      }
    } else {
      $x_item_meta = get_post_meta( $item->ID, '', true );
    }


    // Assign Item Meta
    // ----------------

    $x_anchor_graphic_icon              = ( isset( $x_item_meta['menu-item-anchor_graphic_icon'] )              ) ? $x_item_meta['menu-item-anchor_graphic_icon'][0]              : '';
    $x_anchor_graphic_icon_alt          = ( isset( $x_item_meta['menu-item-anchor_graphic_icon_alt'] )          ) ? $x_item_meta['menu-item-anchor_graphic_icon_alt'][0]          : '';
    $x_anchor_graphic_image_src         = ( isset( $x_item_meta['menu-item-anchor_graphic_image_src'] )         ) ? $x_item_meta['menu-item-anchor_graphic_image_src'][0]         : '';
    $x_anchor_graphic_image_src_alt     = ( isset( $x_item_meta['menu-item-anchor_graphic_image_src_alt'] )     ) ? $x_item_meta['menu-item-anchor_graphic_image_src_alt'][0]     : '';
    $x_anchor_graphic_image_alt         = ( isset( $x_item_meta['menu-item-anchor_graphic_image_alt'] )         ) ? $x_item_meta['menu-item-anchor_graphic_image_alt'][0]         : '';
    $x_anchor_graphic_image_alt_alt     = ( isset( $x_item_meta['menu-item-anchor_graphic_image_alt_alt'] )     ) ? $x_item_meta['menu-item-anchor_graphic_image_alt_alt'][0]     : '';
    $x_anchor_graphic_image_width       = ( isset( $x_item_meta['menu-item-anchor_graphic_image_width'] )       ) ? $x_item_meta['menu-item-anchor_graphic_image_width'][0]       : '';
    $x_anchor_graphic_image_height      = ( isset( $x_item_meta['menu-item-anchor_graphic_image_height'] )      ) ? $x_item_meta['menu-item-anchor_graphic_image_height'][0]      : '';
    $x_anchor_graphic_menu_item_display = ( isset( $x_item_meta['menu-item-anchor_graphic_menu_item_display'] ) ) ? $x_item_meta['menu-item-anchor_graphic_menu_item_display'][0] : '';

    $x_menu_meta_data = array(
      'anchor_text_primary_content'      => $title,
      'anchor_text_secondary_content'    => $item->description,
      'anchor_graphic_icon'              => $x_anchor_graphic_icon,
      'anchor_graphic_icon_alt'          => $x_anchor_graphic_icon_alt,
      'anchor_graphic_image_src'         => $x_anchor_graphic_image_src,
      'anchor_graphic_image_src_alt'     => $x_anchor_graphic_image_src_alt,
      'anchor_graphic_image_alt'         => $x_anchor_graphic_image_alt,
      'anchor_graphic_image_alt_alt'     => $x_anchor_graphic_image_alt_alt,
      'anchor_graphic_image_width'       => $x_anchor_graphic_image_width,
      'anchor_graphic_image_height'      => $x_anchor_graphic_image_height,
      'anchor_graphic_menu_item_display' => $x_anchor_graphic_menu_item_display,
      'atts'                             => array_filter( $atts ),
    );


    // Collapsed
    // ---------
    // 01. Allows the collapsed nav's sub menus to be triggered either by
    //     clicking on the anchor as a whole (which does not allow navigation
    //     to that link but affords a larger click area), or the sub indicator,
    //     (which allows navigation to the main link but has a smaller click
    //     area that users must target).

    if ( $this->x_menu_type === 'collapsed' && in_array( 'menu-item-has-children', $item->classes ) ) {

      $x_menu_meta_data['atts']['id']                       = 'x-menu-collapsed-anchor-' . $this->x_get_unique_id();
      $x_menu_meta_data['anchor_aria_label']                = __( 'Toggle Collapsed Sub Menu', '__x__' );
      $x_menu_meta_data['anchor_aria_haspopup']             = 'true';
      $x_menu_meta_data['anchor_aria_expanded']             = 'false';
      $x_menu_meta_data['anchor_aria_controls']             = 'x-menu-collapsed-list-' . $this->x_get_unique_id();
      $x_menu_meta_data['atts']['data-x-toggle']            = 'collapse';
      $x_menu_meta_data['atts']['data-x-toggleable']        = $this->x_get_unique_id();
      $x_menu_meta_data['anchor_sub_menu_trigger_location'] = $this->x_menu_data['menu_sub_menu_trigger_location']; // 01

    }


    // Layered
    // -------
    // 01. Allows the layered nav's sub menus to be triggered either by
    //     clicking on the anchor as a whole (which does not allow navigation
    //     to that link but affords a larger click area), or the sub indicator,
    //     (which allows navigation to the main link but has a smaller click
    //     area that users must target).

    if ( ( $this->x_menu_type === 'modal' || $this->x_menu_type === 'layered' ) && in_array( 'menu-item-has-children', $item->classes ) ) {

      $x_menu_meta_data['atts']['id']                       = 'x-menu-layered-anchor-' . $this->x_get_unique_id();
      $x_menu_meta_data['anchor_aria_label']                = __( 'Toggle Layered Sub Menu', '__x__' );
      $x_menu_meta_data['anchor_aria_haspopup']             = 'true';
      $x_menu_meta_data['anchor_aria_expanded']             = 'false';
      $x_menu_meta_data['anchor_aria_controls']             = 'x-menu-layered-list-' . $this->x_get_unique_id();
      $x_menu_meta_data['atts']['data-x-toggle']            = 'layered';
      $x_menu_meta_data['atts']['data-x-toggleable']        = $this->x_get_unique_id();
      $x_menu_meta_data['anchor_sub_menu_trigger_location'] = $this->x_menu_data['menu_sub_menu_trigger_location']; // 01

    }


    // Setup "Active" Links
    // --------------------
    // 01. Current menu item highlighting.
    // 02. Ancestor menu item highlighting.
    // 03. Pass on graphic and particle status for active links.

    if ( array_keys( $classes, 'current-menu-item' ) ) { // 01
      if ( $this->x_menu_data['menu_active_links_highlight_current'] === true ) {
        $x_menu_meta_data['anchor_is_active'] = true;
        $x_menu_meta_data['class']            = 'x-always-active';
      }
    }

    if ( array_keys( $classes, 'current-menu-ancestor' ) ) { // 02
      if ( $this->x_menu_data['menu_active_links_highlight_ancestors'] === true ) {
        $x_menu_meta_data['anchor_is_active'] = true;
        $x_menu_meta_data['class']            = 'x-always-active';
      }
    }

    $x_menu_meta_data['anchor_graphic_always_active']            = $this->x_menu_data['menu_active_links_show_graphic']; // 03
    $x_menu_meta_data['anchor_primary_particle_always_active']   = $this->x_menu_data['menu_active_links_show_primary_particle']; // 03
    $x_menu_meta_data['anchor_secondary_particle_always_active'] = $this->x_menu_data['menu_active_links_show_secondary_particle']; // 03


    // Get Sub Link Options
    // --------------------

    $x_has_unique_sub_styles = in_array( $this->x_menu_type, array( 'inline', 'collapsed' ), true ) && $depth !== 0;
    $key_prefix              = ( $x_has_unique_sub_styles ) ? 'sub_' : '';


    // Menu Item Text Output
    // ---------------------
    // 01. Merge meta from the WP menu system into our main data to complete
    //     the whole picture.

    if ( $this->x_menu_data[$key_prefix . 'anchor_text_primary_content'] !== 'on' ) {
      $x_menu_meta_data['anchor_text_primary_content'] = '';
    }

    if ( $this->x_menu_data[$key_prefix . 'anchor_text_secondary_content'] !== 'on' ) {
      $x_menu_meta_data['anchor_text_secondary_content'] = '';
    }

    $x_anchor_data = array_merge( $this->x_menu_data, $x_menu_meta_data ); // 01

    unset( $x_anchor_data['sub_anchor_text_primary_content'] );
    unset( $x_anchor_data['sub_anchor_text_secondary_content'] );


    // Merge Sub Link Options
    // ----------------------
    // 01. Sub anchors with unique styling need to have their keys cleaned as
    //     well as ensuring $x_menu_meta_data still persists.

    if ( $x_has_unique_sub_styles ) {

      $top_level = array_intersect_key( $x_anchor_data, array_flip( array_keys( $x_menu_meta_data ) ) );

      $x_anchor_data = array_merge( $top_level, cs_extract( $x_anchor_data, array( 'sub_anchor' => 'anchor' ) ) ); // 01

      unset( $x_anchor_data['_type'] );
      unset( $x_anchor_data['_modules'] );

    }


    // Item Output
    // -----------


    $item_output  = isset( $args->before ) ? $args->before : '';
    $item_output .= cs_get_partial_view( 'anchor', $x_anchor_data );

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

