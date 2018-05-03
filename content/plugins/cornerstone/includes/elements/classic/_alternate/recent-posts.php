<?php

class CS_Recent_Posts extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'recent-posts',
      'title'       => __('Recent Posts', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Recent Posts description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'protected_keys' => array( 'post_type' )
    );
  }

  public function controls() {

    $allowed_post_types = apply_filters( 'cs_recent_posts_post_types', array( 'post' => 'post' ) );

    if ( count($allowed_post_types) > 1 ) {

      $choices = array();

      foreach ($allowed_post_types as $key => $value) {
        $obj = get_post_type_object( $value );
        if ( ! is_null( $obj ) && isset( $obj->labels ) ) {
          $choices[] = array( 'value' => $key, 'label' => $obj->labels->name );
        }
      }

      $this->addControl(
        'post_type',
        'select',
        __( 'Post Type', 'cornerstone' ),
        __( 'Choose between standard posts or portfolio posts.', 'cornerstone' ),
        'post',
        array(
          'choices' => $choices
        )
      );
    }

    $this->addControl(
      'count',
      'select',
      __( 'Post Count', 'cornerstone' ),
      __( 'Select how many posts to display.', 'cornerstone' ),
      '2',
      array(
        'choices' => array(
          array( 'value' => '1', 'label' => __( '1', 'cornerstone' ) ),
          array( 'value' => '2', 'label' => __( '2', 'cornerstone' ) ),
          array( 'value' => '3', 'label' => __( '3', 'cornerstone' ) ),
          array( 'value' => '4', 'label' => __( '4', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'offset',
      'text',
      __( 'Offset', 'cornerstone' ),
      __( 'Enter a number to offset initial starting post of your Recent Posts.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'category',
      'text',
      __( 'Category', 'cornerstone' ),
      __( 'To filter your posts by category, enter in the slug of your desired category. To filter by multiple categories, enter in your slugs separated by a comma.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'orientation',
      'choose',
      __( 'Orientation', 'cornerstone' ),
      __( 'Select the orientation or your Recent Posts.', 'cornerstone' ),
      'horizontal',
      array(
        'columns' => '2', 'choices' => array(
          array( 'value' => 'horizontal', 'label' => __( 'Horizontal', 'cornerstone' ), 'icon' => fa_entity( 'arrows-h' ) ),
          array( 'value' => 'vertical',   'label' => __( 'Vertical', 'cornerstone' ),   'icon' => fa_entity( 'arrows-v' ) )
        )
      )
    );

    $this->addControl(
      'no_sticky',
      'toggle',
      __( 'Ignore Sticky Posts', 'cornerstone' ),
      __( 'Select to ignore sticky posts.', 'cornerstone' ),
      true
    );

    $this->addControl(
      'no_image',
      'toggle',
      __( 'Remove Featured Image', 'cornerstone' ),
      __( 'Select to remove the featured image.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'fade',
      'toggle',
      __( 'Fade Effect', 'cornerstone' ),
      __( 'Select to activate the fade effect.', 'cornerstone' ),
      false
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $type = ( isset( $post_type ) ) ? 'type="' . $post_type . '"' : '';

    $shortcode = "[x_recent_posts $type count=\"$count\" offset=\"$offset\" category=\"$category\" orientation=\"$orientation\" no_sticky=\"$no_sticky\" no_image=\"$no_image\" fade=\"$fade\"{$extra}]";

    return $shortcode;

  }

}
