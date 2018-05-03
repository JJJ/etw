<?php

// =============================================================================
// VIEWS/BARS/BREADCRUMBS.PHP
// -----------------------------------------------------------------------------
// Breadcrumbs element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Attr Values
// -------------------

$breadcrumbs_atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-crumbs', $class ) ),
  'role'  => 'navigation',
);

if ( isset( $id ) && ! empty( $id ) ) {
  $breadcrumbs_atts['id'] = $id;
}

$breadcrumbs_list_atts = array(
  'class'      => 'x-crumbs-list',
  'itemscope'  => '',
  'itemtype'   => 'http://schema.org/BreadcrumbList',
  'aria-label' => 'Breadcrumb Navigation',
);


// Prepare $args_items
// -------------------

$delimiter_ltr = ( $breadcrumbs_delimiter === true ) ? ${"breadcrumbs_delimiter_ltr_" . $breadcrumbs_delimiter_type} : '';
$delimiter_rtl = ( $breadcrumbs_delimiter === true ) ? ${"breadcrumbs_delimiter_rtl_" . $breadcrumbs_delimiter_type} : '';

if ( $breadcrumbs_delimiter_type === 'icon' ) {
  $delimiter_ltr = x_get_view( 'partials', 'icon', '', x_get_partial_data( $_custom_data, array( 'add_in' => array( 'icon' => $delimiter_ltr ) ) ), false );
  $delimiter_rtl = x_get_view( 'partials', 'icon', '', x_get_partial_data( $_custom_data, array( 'add_in' => array( 'icon' => $delimiter_rtl ) ) ), false );
}

$args_items = array(
  'delimiter_ltr' => $delimiter_ltr,
  'delimiter_rtl' => $delimiter_rtl,
);


// Prepare $args_data
// ------------------

$home_label = ${"breadcrumbs_home_label_" . $breadcrumbs_home_label_type};

if ( $breadcrumbs_home_label_type === 'icon' ) {
  $home_label = x_get_view( 'partials', 'icon', '', x_get_partial_data( $_custom_data, array( 'add_in' => array( 'icon' => $home_label ) ) ), false );
}

$args_data = array(
  'home_label' => $home_label,
);


// Output
// ------

?>

<nav <?php echo x_atts( $breadcrumbs_atts ); ?>>
  <ol <?php echo x_atts( $breadcrumbs_list_atts ); ?>>
    <?php echo x_breadcrumbs_items( x_breadcrumbs_data( $args_data ), $args_items ); ?>
  </ol>
</nav>