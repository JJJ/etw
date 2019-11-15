<?php

// =============================================================================
// VIEWS/BARS/TP-BBP-DROPDOWN.PHP
// -----------------------------------------------------------------------------
// bbPress (dropdown) element.
// =============================================================================

$classes = x_attr_class( array( $mod_id, 'x-mod-container', $class ) );


// Prepare Atts
// ------------

$atts = array(
  'class' => $classes
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Prepare Content
// ---------------

ob_start();

if ( X_BBPRESS_IS_ACTIVE ) {

  $submenu_items  = '';
  $submenu_items .= '<li><a href="' . bbp_get_search_url() . '"><span>' . __( 'Forums Search', 'cornerstone' ) . '</span></a></li>';

  if ( is_user_logged_in() ) {
    $submenu_items .= '<li><a href="' . bbp_get_favorites_permalink( get_current_user_id() ) . '"><span>' . __( 'Favorites', 'cornerstone' ) . '</span></a></li>';
    $submenu_items .= '<li><a href="' . bbp_get_subscriptions_permalink( get_current_user_id() ) . '"><span>' . __( 'Subscriptions', 'cornerstone' ) . '</span></a></li>';
  }

  if ( ! X_BUDDYPRESS_IS_ACTIVE ) {
    if ( ! is_user_logged_in() ) {
      $submenu_items .= '<li><a href="' . wp_login_url() . '"><span>' . __( 'Log in', 'cornerstone' ) . '</span></a></li>';
    } else {
      $submenu_items .= '<li><a href="' . bbp_get_user_profile_url( get_current_user_id() ) . '"><span>' . __( 'Profile', 'cornerstone' ) . '</span></a></li>';
    }
  }

} else {
  $submenu_items = '';
}

echo $submenu_items;

$dropdown_content = ob_get_clean();


// Data: Partials
// --------------

$data_toggle   = cs_extract( $_view_data, array( 'toggle_anchor' => 'anchor', 'toggle' => '' ) );
$data_dropdown = cs_extract( $_view_data, array( 'dropdown' => '' ) );


// Set Dropdown Content
// --------------------

$dropdown_content = array( 'dropdown_content' => $dropdown_content );
$data_dropdown    = array_merge( $data_dropdown, $dropdown_content );


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo cs_get_partial_view( 'anchor', $data_toggle ); ?>
  <?php echo cs_get_partial_view( 'dropdown', $data_dropdown ); ?>
</div>
