<?php

// Protect
// =============================================================================

function x_shortcode_protect( $atts, $content = null ) {
  extract( shortcode_atts( array(
    'heading' => '',
    'id'      => '',
    'class'   => '',
    'style'   => ''
  ), $atts, 'x_protect' ) );

  GLOBAL $user_login;

  $id    = ( $id    != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class = ( $class != '' ) ? 'x-protect ' . esc_attr( $class ) : 'x-protect';
  $style = ( $style != '' ) ? 'style="' . $style . '"' : '';

  if ( is_user_logged_in() ) {
    $output = do_shortcode( $content );
  } else {
	$heading = ( $heading != '' ) ?  $heading : csi18n('shortcodes.protect-heading');
    $output = "<div {$id} class=\"{$class}\" {$style}>"
              . '<form action="' . esc_url( site_url( 'wp-login.php' ) ) . '" method="post" class="mbn">'
                . '<h6 class="h-protect man">' . $heading . '</h6>'
                . '<div><label>' . csi18n('shortcodes.protect-username') . '</label><input type="text" name="log" id="log" value="' . esc_attr( $user_login ) . '" /></div>'
                . '<div><label>' . csi18n('shortcodes.protect-password') . '</label><input type="password" name="pwd" id="pwd" /></div>'
                . '<div><input type="submit" name="submit" value="' . csi18n('shortcodes.protect-login') . '" class="x-btn x-btn-protect" /></div>'
                . '<input type="hidden" name="redirect_to" value="' . esc_url( get_permalink() ) . '">'
              . '</form>'
            . '</div>';
  }

  return $output;
}

add_shortcode( 'x_protect', 'x_shortcode_protect' );
