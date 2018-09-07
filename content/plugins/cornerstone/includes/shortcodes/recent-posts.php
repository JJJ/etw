<?php

// Recent Posts
// =============================================================================

function x_shortcode_recent_posts( $atts ) {
  extract( shortcode_atts( array(
    'id'           => '',
    'class'        => '',
    'style'        => '',
    'type'         => 'post',
    'count'        => '',
    'category'     => '',
    'offset'       => '',
    'orientation'  => '',
    // 'show_excerpt' => 'true',
    'no_sticky'    => '',
    'no_image'     => '',
    'fade'         => ''
  ), $atts, 'x_recent_posts' ) );

  $allowed_post_types = apply_filters( 'cs_recent_posts_post_types', array( 'post' => 'post' ) );
  $type = ( isset( $allowed_post_types[$type] ) ) ? $allowed_post_types[$type] : 'post';

  $id            = ( $id           != ''     ) ? 'id="' . esc_attr( $id ) . '"' : '';
  $class         = ( $class        != ''     ) ? 'x-recent-posts cf ' . esc_attr( $class ) : 'x-recent-posts cf';
  $style         = ( $style        != ''     ) ? 'style="' . $style . '"' : '';
  $count         = ( $count        != ''     ) ? $count : 3;
  $category      = ( $category     != ''     ) ? $category : '';
  $category_type = ( $type         == 'post' ) ? 'category_name' : 'portfolio-category';
  $offset        = ( $offset       != ''     ) ? $offset : 0;
  $orientation   = ( $orientation  != ''     ) ? ' ' . $orientation : ' horizontal';
  // $show_excerpt  = ( $show_excerpt == 'true' );
  $no_sticky     = ( $no_sticky    == 'true' );
  $no_image      = ( $no_image     == 'true' ) ? $no_image : '';
  $fade          = ( $fade         == 'true' ) ? $fade : 'false';

  $js_params = array(
    'fade' => ( $fade == 'true' )
  );

  $data = cs_generate_data_attributes( 'recent_posts', $js_params );

  $posts = get_posts( array(
    'orderby'             => 'date',
    'post_type'           => "{$type}",
    'posts_per_page'      => "{$count}",
    'offset'              => "{$offset}",
    "{$category_type}"    => "{$category}",
    'ignore_sticky_posts' => $no_sticky
  ) );

  $output = "<div {$id} class=\"{$class}{$orientation}\" {$style} {$data} data-fade=\"{$fade}\" >";

    foreach ($posts as $post) {

      if ( $no_image == 'true' ) {
        $image_output       = '';
        $image_output_class = 'no-image';
      } else {
        $image              = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'entry-cropped' );
        $bg_image           = ( $image[0] != '' ) ? ' style="background-image: url(' . $image[0] . ');"' : '';
        $image_output       = '<div class="x-recent-posts-img"' . $bg_image . '></div>';
        $image_output_class = 'with-image';
      }

      $output .= '<a class="x-recent-post' . $count . ' ' . $image_output_class . '" href="' . get_permalink( $post->ID ) . '" title="' . esc_attr( sprintf( csi18n('shortcodes.recent-posts-permalink'), the_title_attribute( array( 'echo' => false, 'post' => $post->ID ) ) ) ) . '">'
                 . '<article id="post-' . $post->ID . '" class="' . implode( ' ', get_post_class('', $post->ID) ) . '">'
                   . '<div class="entry-wrap">'
                     . $image_output
                     . '<div class="x-recent-posts-content">'
                       . '<h3 class="h-recent-posts">' . get_the_title( $post->ID ) . '</h3>'
                       . '<span class="x-recent-posts-date">' . get_the_date( '', $post->ID ) . '</span>'
                     . '</div>'
                   . '</div>'
                 . '</article>'
               . '</a>';

    }

  $output .= '</div>';

  return $output;
}

add_shortcode( 'x_recent_posts', 'x_shortcode_recent_posts' );
