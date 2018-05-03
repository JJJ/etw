<?php

// Accordion
// =============================================================================
// 01. Assign linked group ID to GLOBAL so it can be accessed by items. This
//     GLOBAL is reset as each new accordion is populated on the page.
// 02. If accordion is linked, `uniqid()` is used to produce a unique ID for
//     the group ID. If the accordion is not linked, value is `NULL`.
// 03. Cleanup after ourselves.

function x_shortcode_accordion( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'    => '',
    'class' => '',
    'style' => '',
    'link'  => ''
  ), $atts, 'x_accordion' ) );

  GLOBAL $x_accordion_group_id; // 01

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'x-accordion ' . esc_attr( $class ) : 'x-accordion';
  $style = ( $style != '' ) ? 'style="' . $style . '"' : '';

  $x_accordion_group_id = ( $link === 'true' ) ? uniqid() : NULL; // 02

  $output = "<div {$id} class=\"{$class}\" {$style}>" . do_shortcode( $content ) . "</div>";

  $x_accordion_group_id = NULL; // 03

  return $output;
}

add_shortcode( 'x_accordion', 'x_shortcode_accordion' );



// Accordion Item
// =============================================================================

function x_shortcode_accordion_item( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'id'        => '',
    'class'     => '',
    'style'     => '',
    'parent_id' => '',
    'title'     => '',
    'open'      => ''
  ), $atts, 'x_accordion_item' ) );

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'x-accordion-group ' . esc_attr( $class ) : 'x-accordion-group';
  $style = ( $style != '' ) ? 'style="' . $style . '"' : '';
  $title = ( $title != '' ) ? $title : 'Make Sure to Set a Title';

  GLOBAL $x_accordion_group_id;

  $toggle_group_id      = ( $parent_id != '' ) ? $parent_id : ( ! is_null( $x_accordion_group_id ) ) ? $x_accordion_group_id : NULL;

  $toggleable_id        = uniqid();
  $attr_toggleable      = ' data-x-toggleable="' . $toggleable_id . '"';

  $class_toggle         = ( $open == 'true' ) ? '' : ' collapsed';
  $attr_id_toggle       = 'id="tab-' . $toggleable_id . '"';
  $attr_toggle_group    = ( ! is_null( $toggle_group_id ) ) ? ' data-x-toggle-group="' . $toggle_group_id . '"' : '';
  $attr_aria_selected   = ( $open == 'true' ) ? ' aria-selected="true"' : ' aria-selected="false"';
  $attr_aria_expanded   = ( $open == 'true' ) ? ' aria-expanded="true"' : ' aria-expanded="false"';
  $attr_aria_controls   = ' aria-controls="panel-' . $toggleable_id . '"';

  $class_body           = ( $open == 'true' ) ? '' : ' x-collapsed';
  $attr_id_body         = 'id="panel-' . $toggleable_id . '"';
  $attr_aria_hidden     = ( $open == 'true' ) ? ' aria-hidden="false"' : ' aria-hidden="true"';
  $attr_aria_labelledby = ' aria-labelledby="tab-' . $toggleable_id . '"';

  $output = "<div {$id} class=\"{$class}\" {$style}>"
            . '<div class="x-accordion-heading">'
              . "<a {$attr_id_toggle} class=\"x-accordion-toggle{$class_toggle}\" role=\"tab\" data-x-toggle=\"collapse-b\"{$attr_toggleable}{$attr_toggle_group}{$attr_aria_selected}{$attr_aria_expanded}{$attr_aria_controls}{$parent_id}>{$title}</a>"
            . '</div>'
            . "<div {$attr_id_body} class=\"x-accordion-body{$class_body}\" role=\"tabpanel\" data-x-toggle-collapse=\"1\"{$attr_toggleable}{$attr_aria_hidden}{$attr_aria_labelledby}>"
              . '<div class="x-accordion-inner">'
                . do_shortcode( $content )
              . '</div>'
            . '</div>'
          . '</div>';

  return $output;
}

add_shortcode( 'x_accordion_item', 'x_shortcode_accordion_item' );