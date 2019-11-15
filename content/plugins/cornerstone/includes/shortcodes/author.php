<?php

// Author
// =============================================================================

function x_shortcode_author( $atts ) {
  extract( shortcode_atts( array(
    'id'        => '',
    'class'     => '',
    'style'     => '',
    'title'     => '',
    'author_id' => ''
  ), $atts, 'x_author' ) );

  $id        = ( $id        != '' ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class     = ( $class     != '' ) ? 'x-author-box cf ' . esc_attr( $class ) : 'x-author-box cf';
  $style     = ( $style     != '' ) ? 'style="' . $style . '"' : '';
  $title     = ( $title     != '' ) ? $title : csi18n('shortcodes.author-title');
  $author_id = ( $author_id != '' ) ? $author_id : get_the_author_meta( 'ID' );

  $description  = get_the_author_meta( 'description', $author_id );
  $display_name = get_the_author_meta( 'display_name', $author_id );
  $facebook     = get_the_author_meta( 'facebook', $author_id );
  $twitter      = get_the_author_meta( 'twitter', $author_id );
  $googleplus   = get_the_author_meta( 'googleplus', $author_id );

  $facebook_title   = sprintf( __('Visit the Facebook Profile for %s', 'cornerstone'), $display_name);
  $twitter_title    = sprintf( __('Visit the Twitter Profile for %s', 'cornerstone'), $display_name);
  $googleplus_title = sprintf( __('Visit the Google+ Profile for %s', 'cornerstone'), $display_name);

  $target = cs_output_target_blank(false);

  $facebook_output   = ( $facebook )   ? "<a href=\"{$facebook}\" class=\"x-author-social\" title=\"{$facebook_title}\" $target ><i class=\"x-icon-facebook-square\" " . fa_data_icon('facebook') . "></i> Facebook</a>" : '';
  $twitter_output    = ( $twitter )    ? "<a href=\"{$twitter}\" class=\"x-author-social\" title=\"{$twitter_title}\" $target ><i class=\"x-icon-twitter-square\" " . fa_data_icon('twitter-square') . "></i> Twitter</a>" : '';
  $googleplus_output = ( $googleplus ) ? "<a href=\"{$googleplus}\" class=\"x-author-social\" title=\"{$googleplus_title}\" $target ><i class=\"x-icon-google-plus-square\" " . fa_data_icon('google-plus-square') . "></i> Google+</a>" : '';

  $output = "<div {$id} class=\"{$class}\" {$style}>"
            . "<h6 class=\"h-about-the-author\">{$title}</h6>"
            . get_avatar( $author_id, 180 )
            . '<div class="x-author-info">'
              . "<h4 class=\"h-author mtn\">{$display_name}</h4>"
                . $facebook_output
                . $twitter_output
                . $googleplus_output
              . "<p class=\"p-author mbn\">{$description}</p>"
            . '</div>'
          . '</div>';

  return $output;
}

add_shortcode( 'x_author', 'x_shortcode_author' );
