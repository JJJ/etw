<?php

// =============================================================================
// VIEWS/PARTIALS/VIDEO.PHP
// -----------------------------------------------------------------------------
// Video partial.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';


// Content
// -------

switch ( $video_type ) {

  // Embed
  // -----

  case 'embed' :
    $video_content = ( ! empty( $video_embed_code ) ) ? $video_embed_code : '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_image_uri( 1, 1, 'rgba(0, 0, 0, 0.35)' ) . '" width="1" height="1" alt="Placeholder">';
    break;


  // Player
  // ------

  case 'player' :

    wp_enqueue_script( 'mediaelement' );


    // Variable Markup
    // ---------------

    $mejs_bg_start = ( $video_is_bg ) ? '<script type="text/template">' : '';
    $mejs_bg_end   = ( $video_is_bg ) ? '</script>' : '';

    if ( is_numeric( $mejs_poster ) ) {
      $mejs_poster_info = wp_get_attachment_image_src( $mejs_poster, 'full' );
      $mejs_poster      = $mejs_poster_info[0];
    }


    // Build Source Elements
    // ---------------------

    $mejs_source_files      = explode( "\n", esc_attr( $mejs_source_files ) );
    $mejs_source_elements   = array();
    $mejs_source_is_vimeo   = false;
    $mejs_source_is_youtube = false;

    foreach( $mejs_source_files as $file ) {

      if ( ! $file ) {
        continue;
      }

      if ( ! preg_match( '#webm|mp4|ogv#', $file ) ) {
        $mejs_source_is_vimeo   = preg_match( '#^https?://(.+\.)?vimeo\.com/.*#', $file );
        $mejs_source_is_youtube = preg_match( '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#', $file );
      }

      if ( $mejs_source_is_vimeo ) {
        wp_enqueue_script( 'froogaloop' );
        $mime = array( 'type' => 'video/vimeo' );
      } else if ( $mejs_source_is_youtube ) {
        $mime = array( 'type' => 'video/youtube' );
      } else {
        $parts  = parse_url( $file );
        $scheme = isset( $parts['scheme'] ) ? $parts['scheme'] . '://' : '//';
        $host   = isset( $parts['host'] )   ? $parts['host']           : '';
        $path   = isset( $parts['path'] )   ? $parts['path']           : '';
        $mime   = wp_check_filetype( $scheme . $host . $path, wp_get_mime_types() );
      }

      $mejs_source_element_atts = array(
        'src'  => esc_url( $file ),
        'type' => $mime['type']
      );

      $mejs_source_elements[] = '<source ' . x_atts( $mejs_source_element_atts ) . '>';

    }


    // Build Video Element
    // -------------------
    // 01. Check if current v4.9 is greater than current WordPress version and
    //     include legacy class if so. Needed due to MEJS library update in
    //     v4.9, which includes updated styling and APIs.

    if ( ! empty( $mejs_source_elements ) ) {

      $mejs_classes = array( 'x-mejs' );

      if ( $mejs_advanced_controls ) $mejs_classes[] = 'advanced-controls';

      GLOBAL $wp_version;

      if ( version_compare( '4.9', $wp_version, '>' ) ) {
        $mejs_classes[] = 'x-mejs-legacy-compat'; // 01
      }

      $mejs_element_atts = array(
        'class'   => x_attr_class( $mejs_classes ),
        'poster'  => $mejs_poster,
        'preload' => $mejs_preload,
      );

      if ( $mejs_loop )  $mejs_element_atts['loop']  = '';
      if ( $mejs_muted ) $mejs_element_atts['muted'] = '';

      $video_content = $mejs_bg_start
                       . '<video ' . x_atts( $mejs_element_atts ) . '>'
                         . implode( '', $mejs_source_elements )
                       . '</video>'
                     . $mejs_bg_end;

    } else {

      $video_content = $mejs_bg_start
                       . '<img style="object-fit: cover; width: 100%; height: 100%;" src="' . cornerstone_make_placeholder_image_uri( 1, 1, 'rgba(0, 0, 0, 0.35)' ) . '" width="1" height="1" alt="Placeholder">'
                     . $mejs_bg_end;

    }

    break;


  // Fallback
  // --------

  default :

    $video_content = '';

    break;

}


// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'x-video', 'x-video-' . $video_type );

if ( $video_type === 'player' ) {
  if ( $video_is_bg )            $classes[] = 'x-video-bg';
  if ( $mejs_hide_controls )     $classes[] = 'hide-controls';
  if ( $mejs_autoplay )          $classes[] = 'autoplay';
  if ( $mejs_loop )              $classes[] = 'loop';
  if ( $mejs_muted )             $classes[] = 'muted';
  if ( $mejs_source_is_vimeo )   $classes[] = 'vimeo';
  if ( $mejs_source_is_youtube ) $classes[] = 'youtube';
}

$classes[] = $class;


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

if ( $video_type === 'player' ) {
  $atts = array_merge( $atts, cs_element_js_atts( 'x_mejs', array( 'poster' => $mejs_poster ) ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo do_shortcode( $video_content ); ?>
</div>
