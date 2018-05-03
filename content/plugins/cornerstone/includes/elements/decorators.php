<?php

// =============================================================================
// ELEMENTS/_DECORATORS.PHP
// -----------------------------------------------------------------------------
// Bar module decorators.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Mixin: Base
//   02. Mixin: Anchor href
//   03. Mixin: ARIA
//   04. Mixin: Flex Layout Attr
//   05. Mixin: Dropdown
//   06. Decorator: Content Area
//   07. Decorator: Content Area (Dropdown)
//   08. Decorator: Content Area (Modal)
//   09. Decorator: Content Area (Off Canvas)
//   10. Decorator: Image
//   11. Decorator: Text
//   12. Decorator: Headline
//   13. Decorator: Breadcrumbs
//   14. Decorator: Counter
//   15. Decorator: Line
//   16. Decorator: Gap
//   17. Decorator: Alert
//   18. Decorator: Nav (Inline)
//   19. Decorator: Nav (Dropdown)
//   20. Decorator: Nav (Collapsed)
//   21. Decorator: Nav (Modal)
//   22. Decorator: Button
//   23. Decorator: Social
//   24. Decorator: Search (Inline)
//   25. Decorator: Search (Dropdown)
//   26. Decorator: Search (Modal)
//   27. Decorator: Map
//   28. Decorator: Audio
//   29. Decorator: Video
//   30. Decorator: Accordion
//   31. Decorator: Tabs
//   32. Decorator: Statbar
//   33. Decorator: Quote
//   34. Decorator: Login (Modal)
//   35. Decorator: Third Party (bbPress: Dropdown)
//   36. Decorator: Third Party (BuddyPress: Dropdown)
//   37. Decorator: Third Party (WooCommerce Cart: Dropdown)
//   38. Decorator: Third Party (WooCommerce Cart: Modal)
//   39. Decorator: Third Party (WooCommerce Cart: Off Canvas)
// =============================================================================

// Mixin: Base
// =============================================================================

function x_module_decorator_base( $module ) {

  if ( ! isset( $module['_region'] ) ) {
    $module['_region'] = 'top';
  }

  $unique_id = $module['_id'];

  if ( isset( $module['_p'] ) ) {
    $unique_id = $module['_p'] . '-' . $unique_id;
  }

  $module['mod_id'] = 'e' . $unique_id;

  if ( ! empty( $module['hide_bp'] ) ) {
    $hide_bps = explode( ' ', $module['hide_bp'] );
    foreach ( $hide_bps as $bp ) {
      if ( $bp == 'none' ) {
        continue;
      }
      $module['class'] .= ' x-hide-' . $bp;
    }
  }

  return $module;

}



// Mixin: Anchor href
// =============================================================================

function x_module_decorator_mixin_anchor( $anchor_href ) {

  $decorations = array(
    'anchor_href' => $anchor_href,
  );

  return $decorations;

}



// Mixin: ARIA
// =============================================================================

function x_module_decorator_mixin_aria( $k_pre = 'anchor', $aria = array(), $id, $mod_id ) {

  $decorations = array();
  $k_pre       = ( ! empty( $k_pre ) ) ? $k_pre . '_' : '';

  if ( isset( $aria['controls'] ) ) {

    $the_id   = ( ! empty( $id ) ) ? $id : $mod_id;
    $the_type = '-' . $aria['controls'];

    $decorations[$k_pre . 'aria_controls'] = $the_id . $the_type;

  }

  if ( isset( $aria['expanded'] ) ) {
    $decorations[$k_pre . 'aria_expanded'] = $aria['expanded'];
  }

  if ( isset( $aria['selected'] ) ) {
    $decorations[$k_pre . 'aria_selected'] = $aria['selected'];
  }

  if ( isset( $aria['haspopup'] ) ) {
    $decorations[$k_pre . 'aria_haspopup'] = $aria['haspopup'];
  }

  if ( isset( $aria['label'] ) ) {
    $decorations[$k_pre . 'aria_label'] = $aria['label'];
  }

  if ( isset( $aria['labelledby'] ) ) {
    $decorations[$k_pre . 'aria_labelledby'] = $aria['labelledby'];
  }

  if ( isset( $aria['hidden'] ) ) {
    $decorations[$k_pre . 'aria_hidden'] = $aria['hidden'];
  }

  if ( isset( $aria['orientation'] ) ) {
    $decorations[$k_pre . 'aria_orientation'] = $aria['orientation'];
  }

  return $decorations;

}



// Mixin: Flex Layout Attr
// =============================================================================

function x_module_decorator_flex_layout_attr( $_region, $flex_attr_prefix = '', $row_flex_attr, $col_flex_attr ) {

  $flex_layout_attr = ( $_region == 'left' || $_region == 'right' ) ? $col_flex_attr          : $row_flex_attr;
  $k_pre            = ( ! empty( $flex_attr_prefix )              ) ? $flex_attr_prefix . '_' : '';

  $decorations = array(
    $k_pre . 'flex_layout_attr' => $flex_layout_attr
  );

  return $decorations;

}



// Mixin: Dropdown
// =============================================================================

function x_module_decorator_mixin_dropdown( $dropdown_is_list = true ) {

  $decorations = array(
    'dropdown_is_list' => $dropdown_is_list,
  );

  return $decorations;

}



// Decorator: Content Area
// =============================================================================

// function x_module_decorator_content_area( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Content Area (Dropdown)
// =============================================================================

function x_module_decorator_content_area_dropdown( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'dropdown',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Dropdown Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id )
  );

  // x_dump( $module );

  return $module;

}



// Decorator: Content Area (Modal)
// =============================================================================

function x_module_decorator_content_area_modal( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'modal',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Modal Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id )
  );

  return $module;

}



// Decorator: Content Area (Off Canvas)
// =============================================================================

function x_module_decorator_content_area_off_canvas( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'off-canvas',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Off Canvas Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id),
    x_module_decorator_mixin_dropdown( false )
  );

  return $module;

}



// Decorator: Image
// =============================================================================

// function x_module_decorator_image( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Text
// =============================================================================

// function x_module_decorator_text( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Headline
// =============================================================================

// function x_module_decorator_headline( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Breadcrumbs
// =============================================================================

// function x_module_decorator_breadcrumbs( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Counter
// =============================================================================

// function x_module_decorator_counter( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Line
// =============================================================================

// function x_module_decorator_line( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Gap
// =============================================================================

// function x_module_decorator_gap( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Alert
// =============================================================================

// function x_module_decorator_alert( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Nav (Inline)
// =============================================================================

// Notes
// -----
// 01. Previous flex layout attribute mixin:
//     x_module_decorator_flex_layout_attr( $_region, 'bar', $bar_row_flex_layout_attr, $bar_col_flex_layout_attr )

// function x_module_decorator_nav_inline( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//     // 01
//   );
//
//   return $module;
//
// }



// Decorator: Nav (Dropdown)
// =============================================================================

function x_module_decorator_nav_dropdown( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'dropdown',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Dropdown Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id),
    x_module_decorator_mixin_dropdown( true )
  );

  return $module;

}



// Decorator: Nav (Collapsed)
// =============================================================================

function x_module_decorator_nav_collapsed( $module ) {

  extract( $module );

  $module = array_merge(
    $module
    // x_module_decorator_mixin_aria( 'toggle_anchor', array( 'controls' => 'nav-collapsed' ), $id, $mod_id )
  );

  return $module;

}



// Decorator: Nav (Modal)
// =============================================================================

function x_module_decorator_nav_modal( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'modal',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Modal Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id )
  );

  return $module;

}



// Decorator: Button
// =============================================================================

// function x_module_decorator_button( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Social
// =============================================================================

function x_module_decorator_social( $module ) {

  extract( $module );

  $module = array_merge(
    $module
    // x_module_decorator_mixin_aria( 'toggle_anchor', array( 'controls' => 'social' ), $id, $mod_id )
  );

  return $module;

}



// Decorator: Search (Inline)
// =============================================================================

// function x_module_decorator_search_inline( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Search (Dropdown)
// =============================================================================

function x_module_decorator_search_dropdown( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'dropdown',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Dropdown Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id )
  );

  return $module;

}



// Decorator: Search (Modal)
// =============================================================================

function x_module_decorator_search_modal( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'modal',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Modal Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id )
  );

  return $module;

}



// Decorator: Map
// =============================================================================

// function x_module_decorator_map( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Audio
// =============================================================================

// function x_module_decorator_audio( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Video
// =============================================================================

// function x_module_decorator_video( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Accordion
// =============================================================================

// function x_module_decorator_accordion( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Tabs
// =============================================================================

// function x_module_decorator_tabs( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Statbar
// =============================================================================

// function x_module_decorator_statbar( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Quote
// =============================================================================

// function x_module_decorator_quote( $module ) {
//
//   extract( $module );
//
//   $module = array_merge(
//     $module
//   );
//
//   return $module;
//
// }



// Decorator: Login (Modal)
// =============================================================================

function x_module_decorator_login_modal( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'modal',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Modal Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id )
  );

  return $module;

}



// Decorator: Third Party (bbPress: Dropdown)
// =============================================================================

function x_module_decorator_tp_bbp_dropdown( $module ) {

  extract( $module );

  // $anchor_href = get_post_type_archive_link( bbp_get_forum_post_type() );
  $anchor_href = '';

  $aria_args = array(
    'controls' => 'dropdown',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Dropdown Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_anchor( $anchor_href ),
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id),
    x_module_decorator_mixin_dropdown( true )
  );

  return $module;

}



// Decorator: Third Party (BuddyPress: Dropdown)
// =============================================================================

function x_module_decorator_tp_bp_dropdown( $module ) {

  extract( $module );

  if ( bp_is_active( 'activity' ) ) {
    $logged_out_link = bp_get_activity_directory_permalink();
  } else if ( bp_is_active( 'groups' ) ) {
    $logged_out_link = bp_get_groups_directory_permalink();
  } else {
    $logged_out_link = bp_get_members_directory_permalink();
  }

  $anchor_href = ( is_user_logged_in() ) ? bp_loggedin_user_domain() : $logged_out_link;

  $aria_args = array(
    'controls' => 'dropdown',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Dropdown Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_anchor( $anchor_href ),
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id),
    x_module_decorator_mixin_dropdown( true )
  );

  return $module;

}



// Decorator: Third Party (WooCommerce Cart: Dropdown)
// =============================================================================

function x_module_decorator_tp_wc_cart_dropdown( $module ) {

  extract( $module );

  if ( function_exists( 'wc_get_cart_url' ) ) {
    $href = wc_get_cart_url();
  } else {
    $href = '';
  }

  $aria_args = array(
    'controls' => 'dropdown',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Dropdown Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_anchor( $href ),
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id),
    x_module_decorator_mixin_dropdown( false )
  );

  return $module;

}



// Decorator: Third Party (WooCommerce Cart: Modal)
// =============================================================================

function x_module_decorator_tp_wc_cart_modal( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'modal',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Modal Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id )
  );

  return $module;

}



// Decorator: Third Party (WooCommerce Cart: Off Canvas)
// =============================================================================

function x_module_decorator_tp_wc_cart_off_canvas( $module ) {

  extract( $module );

  $aria_args = array(
    'controls' => 'off-canvas',
    'haspopup' => 'true',
    'expanded' => 'false',
    'label'    => __( 'Toggle Off Canvas Content', '__x__' ),
  );

  $module = array_merge(
    $module,
    x_module_decorator_mixin_aria( 'toggle_anchor', $aria_args, $id, $mod_id )
  );

  return $module;

}
