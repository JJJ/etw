<?php

// =============================================================================
// VIEWS/BARS/ACCORDION-ITEM.PHP
// -----------------------------------------------------------------------------
// Accordion element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Atts: Accordion Item
// --------------------

$atts_accordion_item = array(
  'class' => x_attr_class( array( $mod_id, 'x-acc-item', $class ) ),
);


// Atts: Accordion Header
// ----------------------

$accordion_item_header_class = array( 'x-acc-header' );

if ( $accordion_item_starts_open ) {
  $accordion_item_header_class[] = 'x-active';
}

$atts_accordion_header = array(
  'id'                => 'tab-' . $mod_id,
  'class'             => x_attr_class( $accordion_item_header_class ),
  'role'              => 'tab',
  'type'              => 'button',
  'aria-selected'     => ( $accordion_item_starts_open ) ? 'true' : 'false',
  'aria-expanded'     => ( $accordion_item_starts_open ) ? 'true' : 'false',
  'aria-controls'     => 'panel-' . $mod_id,
  'data-x-toggle'     => 'collapse',
  'data-x-toggleable' => $mod_id,
);

if ( $accordion_grouped ) {
  if ( ! empty( $accordion_group ) ) {
    $atts_accordion_header['data-x-toggle-group'] = $accordion_group;
  } else {
    $atts_accordion_header['data-x-toggle-group'] = $p_mod_id;
  }
}


// Atts: Accordion Collapse
// ------------------------

$atts_accordion_collapse = array(
  'id'                     => 'panel-' . $mod_id,
  'role'                   => 'tabpanel',
  'aria-hidden'            => ( $accordion_item_starts_open ) ? 'false' : 'true',
  'aria-labelledby'        => 'tab-' . $mod_id,
  'data-x-toggleable'      => $mod_id,
  'data-x-toggle-collapse' => true,
);

if ( ! $accordion_item_starts_open ) {
  $atts_accordion_collapse['class'] = 'x-collapsed';
}


// Header Indicator
// ----------------

$accordion_header_indicator_content = '';

if ( $accordion_header_indicator === true ) {
  $accordion_header_indicator_content = ( $accordion_header_indicator_type === 'text' ) ? $accordion_header_indicator_text : x_get_view( 'partials', 'icon', '', x_get_partial_data( $_custom_data, array( 'find_data' => array( 'accordion_header_indicator_icon' => 'icon' ) ) ), false );
  $accordion_header_indicator_content = '<span class="x-acc-header-indicator">' . $accordion_header_indicator_content . '</span>';
}


// Output
// ------

?>

<div <?php echo x_atts( $atts_accordion_item ); ?>>
  <button <?php echo x_atts( $atts_accordion_header ); ?>>
    <span class="x-acc-header-content">
      <?php echo $accordion_header_indicator_content; ?>
      <span class="x-acc-header-text"><?php echo do_shortcode( $accordion_item_header_content ); ?></span>
    </span>
  </button>
  <div <?php echo x_atts( $atts_accordion_collapse ); ?>>
    <div class="x-acc-content">
      <?php echo do_shortcode( $accordion_item_content ); ?>
    </div>
  </div>
</div>
