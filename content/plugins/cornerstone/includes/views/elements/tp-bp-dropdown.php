<?php

// =============================================================================
// VIEWS/BARS/TP-BP-DROPDOWN.PHP
// -----------------------------------------------------------------------------
// BuddyPress (dropdown) element.
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

if ( X_BUDDYPRESS_IS_ACTIVE ) {

  if ( bp_is_active( 'activity' ) ) {
    $logged_out_link = bp_get_activity_directory_permalink();
  } else if ( bp_is_active( 'groups' ) ) {
    $logged_out_link = bp_get_groups_directory_permalink();
  } else {
    $logged_out_link = bp_get_members_directory_permalink();
  }

  $top_level_link = ( is_user_logged_in() ) ? bp_loggedin_user_domain() : $logged_out_link;
  $submenu_items  = '';

  if ( bp_is_active( 'activity' ) ) {
    $submenu_items .= '<li><a href="' . bp_get_activity_directory_permalink() . '"><span>' . x_get_option( 'x_buddypress_activity_title' ) . '</span></a></li>';
  }

  if ( bp_is_active( 'groups' ) ) {
    $submenu_items .= '<li><a href="' . bp_get_groups_directory_permalink() . '"><span>' . x_get_option( 'x_buddypress_groups_title' ) . '</span></a></li>';
  }

  if ( is_multisite() && bp_is_active( 'blogs' ) ) {
    $submenu_items .= '<li><a href="' . bp_get_blogs_directory_permalink() . '"><span>' . x_get_option( 'x_buddypress_blogs_title' ) . '</span></a></li>';
  }

  $submenu_items .= '<li><a href="' . bp_get_members_directory_permalink() . '"><span>' . x_get_option( 'x_buddypress_members_title' ) . '</span></a></li>';

  if ( ! is_user_logged_in() ) {
    if ( bp_get_signup_allowed() ) {
      $submenu_items .= '<li><a href="' . bp_get_signup_page() . '"><span>' . x_get_option( 'x_buddypress_register_title' ) . '</span></a></li>';
      $submenu_items .= '<li><a href="' . bp_get_activation_page() . '"><span>' . x_get_option( 'x_buddypress_activate_title' ) . '</span></a></li>';
    }
    $submenu_items .= '<li><a href="' . wp_login_url() . '"><span>' . __( 'Log in', 'cornerstone' ) . '</span></a></li>';
  } else {
    $submenu_items .= '<li><a href="' . bp_loggedin_user_domain() . '"><span>' . __( 'Profile', 'cornerstone' ) . '</span></a></li>';
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
