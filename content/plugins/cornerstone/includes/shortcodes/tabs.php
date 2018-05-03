<?php

// Tab Navigation
// =============================================================================
// 01. Assign linked group ID to GLOBAL so it can be accessed by items. This
//     GLOBAL is reset as each new tab nav is populated on the page.
// 02. `uniqid()` is used to produce a unique ID for the group ID.
// 03. Cleanup after ourselves.

function x_shortcode_tab_nav( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => '',
    'type'  => '',
    'float' => ''
  ), $atts, 'x_tab_nav' ) );

  GLOBAL $x_tabs_group_id; // 01

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'x-nav x-nav-tabs ' . esc_attr( $class ) : 'x-nav x-nav-tabs';
  $style = ( $style != '' ) ? 'style="' . $style . '"' : '';
  $type  = ( $type  != '' ) ? ' ' . $type : '';
  $float = ( $float != '' ) ? ' ' . $float : ' top';

  $js_params = array(
    'orientation' => ( ' top' === $float ) ? 'horizontal' : 'vertical'
  );

  $data = cs_generate_data_attributes( 'tab_nav', $js_params );

  $x_tabs_group_id = uniqid(); // 02

  $output = "<ul {$id} class=\"{$class}{$type}{$float}\" {$style} {$data} role=\"tablist\">" . do_shortcode( $content ) . "</ul>";

  $x_tabs_group_id = NULL; // 03

  return $output;
}

add_shortcode( 'x_tab_nav', 'x_shortcode_tab_nav' );



// Tab Navigation Item
// =============================================================================

function x_shortcode_tab_nav_item( $atts ) {
  extract( shortcode_atts( array(
    'id'     => '',
    'class'  => '',
    'style'  => '',
    'title'  => '',
    'active' => ''
  ), $atts, 'x_tab_nav_item' ) );

  $id     = ( $id     != ''     ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class  = ( $class  != ''     ) ? 'x-nav-tabs-item ' . esc_attr( $class ) : 'x-nav-tabs-item';
  $style  = ( $style  != ''     ) ? 'style="' . $style . '"' : '';
  $title  = ( $title  != ''     ) ? $title : 'Make Sure to Set a Title';
  $active = ( $active == 'true' ) ? ' active' : '';

  static $count = 0; $count++;

  GLOBAL $x_tabs_group_id;

  $toggleable_id = $count;

  $attr_id            = 'id="x-legacy-tab-' . $toggleable_id . '"';
  $attr_aria_selected = ( $active == ' active' ) ? ' aria-selected="true"' : ' aria-selected="false"';
  $attr_aria_controls = ' aria-controls="x-legacy-panel-' . $toggleable_id . '"';
  $attr_toggleable    = ' data-x-toggleable="' . $toggleable_id . '"';
  $attr_toggle_group  = ' data-x-toggle-group="' . $x_tabs_group_id . '"';

  $output = "<li {$id} class=\"{$class}{$active}\" {$style} role=\"presentation\">"
            . "<a {$attr_id}{$attr_aria_selected}{$attr_aria_controls} role=\"tab\" data-x-toggle=\"tab\"{$attr_toggleable}{$attr_toggle_group}>{$title}</a>"
          . "</li>";

  return $output;
}

add_shortcode( 'x_tab_nav_item', 'x_shortcode_tab_nav_item' );



// Tabs
// =============================================================================

function x_shortcode_tabs( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => ''
  ), $atts, 'x_tabs' ) );

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'x-tab-content ' . esc_attr( $class ) : 'x-tab-content';
  $style = ( $style != '' ) ? 'style="' . $style . '"' : '';

  $output = "<div {$id} class=\"{$class}\" {$style}>" . do_shortcode( $content ) . "</div>";

  return $output;
}

add_shortcode( 'x_tabs', 'x_shortcode_tabs' );



// Tab
// =============================================================================

function x_shortcode_tab( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'class'  => '',
    'style'  => '',
    'active' => ''
  ), $atts, 'x_tab' ) );

  $class  = ( $class  != ''     ) ? 'x-tab-pane ' . esc_attr( $class ) : 'x-tab-pane';
  $style  = ( $style  != ''     ) ? 'style="' . $style . '"' : '';
  $active = ( $active == 'true' ) ? ' active' : '';

  static $count = 0; $count++;

  $toggleable_id = $count;

  $attr_id              = 'id="x-legacy-panel-' . $toggleable_id . '"';
  $attr_aria_hidden     = ( $active == ' active' ) ? ' aria-hidden="false"' : ' aria-hidden="true"';
  $attr_aria_labelledby = ' aria-labelledby="x-legacy-tab-' . $toggleable_id . '"';
  $attr_toggleable      = ' data-x-toggleable="' . $toggleable_id . '"';

  $output = "<div {$attr_id} class=\"{$class}{$active}\" {$style}{$attr_aria_hidden}{$attr_aria_labelledby} role=\"tabpanel\"{$attr_toggleable}>" . do_shortcode( $content ) . "</div>";

  return $output;
}

add_shortcode( 'x_tab', 'x_shortcode_tab' );