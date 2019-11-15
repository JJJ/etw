<?php

class CS_Settings_X_Settings extends Cornerstone_Legacy_Setting_Section {

  public function data() {
    return array(
      'name'        => 'x-settings',
      'title'       => __( 'Meta Settings', 'cornerstone' ),
      'priority' => '20'
    );
  }

  public function condition() {
    return ( apply_filters( 'x_settings_pane', false ) );
  }

  public function controls() {

    global $post;

    if ( $post->post_type == 'post') {
      $this->postControls();
    } elseif ( $post->post_type == 'page') {
      $this->pageControls();
    } elseif ( $post->post_type == 'x-portfolio') {
      $this->portfolioControls();
    }

  }

  public function postControls() {

    global $post;

    $this->addControl(
      'body_css_class',
      'text',
      __( 'Body CSS Class(es)', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_body_css_class', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'fullwidth_post_layout',
      'toggle',
      __( 'Fullwidth Post Layout', 'cornerstone' ),
      '',
      ( get_post_meta( $post->ID, '_x_post_layout', true ) == 'on' ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'alternate_index_title',
      'text',
      __( 'Alternate Index Title', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_alternate_index_title', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'bg_image_full',
      'text',
      __( 'Background Image(s)', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_bg_image_full', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_fade', true );
    $default = ( $meta == '' ) ? '750' : $meta;

    $this->addControl(
      'bg_image_full_fade',
      'text',
      __( 'Background Image(s) Fade', 'cornerstone' ),
      '',
      $default,
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_duration', true );
    $default = ( $meta == '' ) ? '7500' : $meta;

    $this->addControl(
      'bg_image_full_duration',
      'text',
      __( 'Background Images Duration', 'cornerstone' ),
      '',
      $default,
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

  }

  public function pageControls() {

    global $post;

    $this->addControl(
      'body_css_class',
      'text',
      __( 'Body CSS Class(es)', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_body_css_class', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'alternate_index_title',
      'text',
      __( 'Alternate Index Title', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_alternate_index_title', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'disable_page_title',
      'toggle',
      __( 'Disable Page Title', 'cornerstone' ),
      '',
      ( get_post_meta( $post->ID, '_x_entry_disable_page_title', true ) == 'on' ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $meta = get_post_meta( $post->ID, '_x_page_one_page_navigation', true );

    $deactivated_label = __( 'Deactivated', 'cornerstone' );
    $default = ( $meta == '' ) ? $deactivated_label : $meta;

    $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
    $choices = array();
    $choices[] = array( 'value' => 'Deactivated', 'label' => $deactivated_label );
    foreach ( $menus as $menu ) {
      $choices[] = array( 'value' => $menu->name, 'label' => $menu->name );
    }

    $this->addControl(
      'one_page_navigation',
      'select',
      __( 'One Page Navigation', 'cornerstone' ),
      '',
      $default,
      array(
        'choices' => $choices,
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'bg_image_full',
      'text',
      __( 'Background Image(s)', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_bg_image_full', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_fade', true );
    $default = ( $meta == '' ) ? '750' : $meta;

    $this->addControl(
      'bg_image_full_fade',
      'text',
      __( 'Background Image(s) Fade', 'cornerstone' ),
      '',
      $default,
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_duration', true );
    $default = ( $meta == '' ) ? '7500' : $meta;

    $this->addControl(
      'bg_image_full_duration',
      'text',
      __( 'Background Images Duration', 'cornerstone' ),
      '',
      $default,
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

  }

  public function portfolioControls() {

    global $post;

    $this->addControl(
      'body_css_class',
      'text',
      __( 'Body CSS Class(es)', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_body_css_class', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'alternate_index_title',
      'text',
      __( 'Alternate Index Title', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_alternate_index_title', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $pages = get_pages( array(
      'meta_key'    => '_wp_page_template',
      'meta_value'  => 'template-layout-portfolio.php',
      'sort_order'  => 'ASC',
      'sort_column' => 'ID'
    ) );

    if ( ! empty($pages) ) {

      $current = get_post_meta( $post->ID, '_x_portfolio_parent', true );

      ob_start();
      echo '<select name="portfolio_parent" >';
      echo '<option value="Default">Default</option>';
      foreach ( $pages as $page ) {
        echo '<option value="' . $page->ID . '"';
        if ( $current == $page->ID ) {
          echo ' selected="selected"';
        }
        echo'>' . $page->post_title . '</option>';
      }
      echo '</select>';

      $markup = ob_get_clean();
      $this->addControl(
        'portfolio_parent',
        'wpselect',
        __('Portfolio Parent', 'cornerstone' ),
        '',
        "{$current}",
        array(
          'markup' => $markup,
          'trigger' => 'settings-theme-changed'
        )
      );
    }

    $this->addControl(
      'media_type',
      'select',
      __( 'Media Type', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_portfolio_media', true ),
      array(
        'choices' => array(
          array( 'value' => 'Image',   'label' => __( 'Image', 'cornerstone' ) ),
          array( 'value' => 'Gallery', 'label' => __( 'Gallery', 'cornerstone' ) ),
          array( 'value' => 'Video',   'label' => __( 'Video', 'cornerstone' ) ),
        ),
        'trigger' => 'settings-theme-changed'
      )
    );

    $current_video_aspect_ratio = get_post_meta( $post->ID, '_x_portfolio_aspect_ratio', true );
    $this->addControl(
      'video_aspect_ratio',
      'select',
      __( 'Video Aspect Ratio', 'cornerstone' ),
      '',
      ($current_video_aspect_ratio == '' ) ? '16:9' : $current_video_aspect_ratio,
      array(
        'choices' => array(
          array( 'value' => '16:9',   'label' => '16:9' ),
          array( 'value' => '5:3', 'label' => '5:3' ),
          array( 'value' => '5:4',   'label' => '5:4' ),
          array( 'value' => '4:3',   'label' => '4:3' ),
          array( 'value' => '3:2',   'label' => '3:2' ),
        ),
        'condition' => array(
          'media_type' => 'Video',
        ),
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'm4v_file_url',
      'text',
      __( 'M4V File URL', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_portfolio_m4v', true ),
      array(
        'condition' => array(
          'media_type' => 'Video',
        ),
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'ogv_file_url',
      'text',
      __( 'OGV File URL', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_portfolio_ogv', true ),
      array(
        'condition' => array(
          'media_type' => 'Video',
        ),
        'trigger' => 'settings-theme-changed'
      )
    );

    if (current_user_can( 'unfiltered_html' ) ) {

      $this->addControl(
        'embedded_video_code',
        'textarea',
        __( 'Embedded Video Code', 'cornerstone' ),
        '',
        get_post_meta( $post->ID, '_x_portfolio_embed', true ),
        array(
          'condition' => array(
            'media_type' => 'Video',
          ),
          'trigger' => 'settings-theme-changed'
        )
      );
    }

    $this->addControl(
      'featured_content',
      'select',
      __( 'Featured Content', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_portfolio_index_media', true ),
      array(
        'choices' => array(
          array( 'value' => 'Thumbnail', 'label' => __( 'Thumbnail', 'cornerstone' ) ),
          array( 'value' => 'Media',     'label' => __( 'Media', 'cornerstone' ) ),
        ),
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'project_link',
      'text',
      __( 'Project Link', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_portfolio_project_link', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'bg_image_full',
      'text',
      __( 'Background Image(s)', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_entry_bg_image_full', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_fade', true );
    $default = ( $meta == '' ) ? '750' : $meta;

    $this->addControl(
      'bg_image_full_fade',
      'text',
      __( 'Background Image(s) Fade', 'cornerstone' ),
      '',
      $default,
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $meta = get_post_meta( $post->ID, '_x_entry_bg_image_full_duration', true );
    $default = ( $meta == '' ) ? '7500' : $meta;

    $this->addControl(
      'bg_image_full_duration',
      'text',
      __( 'Background Images Duration', 'cornerstone' ),
      '',
      $default,
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

  }

  public function handler( $post, $atts ) {

  	extract( $atts );

  	$classes = explode(' ', $body_css_class );
  	array_map('sanitize_html_class', $classes);
  	$body_css_class = implode(' ', $classes );

  	update_post_meta( $post->ID, '_x_entry_body_css_class', $body_css_class );
  	update_post_meta( $post->ID, '_x_entry_alternate_index_title', sanitize_text_field( $alternate_index_title ) );
  	update_post_meta( $post->ID, '_x_entry_bg_image_full', $bg_image_full );
    update_post_meta( $post->ID, '_x_entry_bg_image_full_fade', $bg_image_full_fade );
    update_post_meta( $post->ID, '_x_entry_bg_image_full_duration', $bg_image_full_duration );

    if ( $post->post_type == 'post') {

	    update_post_meta( $post->ID, '_x_post_layout', ( $fullwidth_post_layout == 'true' ) ? 'on' : '' );

    } elseif ( $post->post_type == 'page') {

	    update_post_meta( $post->ID, '_x_entry_disable_page_title', ( $disable_page_title == 'true' ) ? 'on' : '' );
	    update_post_meta( $post->ID, '_x_page_one_page_navigation', $one_page_navigation );

    } elseif ( $post->post_type == 'x-portfolio') {

	    update_post_meta( $post->ID, '_x_portfolio_parent', $portfolio_parent );
	    update_post_meta( $post->ID, '_x_portfolio_media', $media_type );
	    update_post_meta( $post->ID, '_x_portfolio_aspect_ratio', $video_aspect_ratio );
	    update_post_meta( $post->ID, '_x_portfolio_m4v', $m4v_file_url );
	    update_post_meta( $post->ID, '_x_portfolio_ogv', $ogv_file_url );
	    update_post_meta( $post->ID, '_x_portfolio_embed', $embedded_video_code );
	    update_post_meta( $post->ID, '_x_portfolio_index_media', $featured_content );
	    update_post_meta( $post->ID, '_x_portfolio_project_link', $project_link );

    }

  }

}
