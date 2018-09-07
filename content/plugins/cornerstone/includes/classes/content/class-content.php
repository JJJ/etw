<?php

class Cornerstone_Content {

  protected $id = null;
  protected $title;
  protected $post_type = 'post';
  protected $post_status = 'post';
  protected $permalink = '';
  protected $data = array();
  // protected $new;
  // protected $dirty;
  // protected $modified;

  public function __construct( $post ) {

    if ( is_array( $post ) ) {
      if ( isset( $post['id'] ) ) {
        $post = $post['id'];
      } else {
        $this->create_new( $post );
      }
    } else {
      $this->load_from_post( $post );
    }

  }

  protected function create_new( $data ) {

    $this->set_title( isset( $data['title'] ) ? $data['title'] : false );
    $this->set_post_type( isset( $data['post_type'] ) ? $data['post_type'] : 'page' );
    $this->set_post_status( isset( $data['post_status'] ) ? $data['post_status'] : 'draft' );

    $this->set_elements( isset( $data['elements'] ) ? $data['elements'] : array( 'data' => '') );
    $this->set_settings( isset( $data['settings'] ) ? $data['settings'] : array() );

  }

  protected function load_from_post( $post ) {

    if ( is_int( $post ) ) {
      $post = get_post( $post );
    }

    if ( ! is_a( $post, 'WP_POST' ) ) {
      throw new Exception( 'Unable to load content from post.' );
    }

    $this->id = $post->ID;
    $this->set_title( $post->post_title ? $post->post_title : '' );
    $this->post_type = $post->post_type;
    $this->post_status = $post->post_status;

    $wpml = CS()->component('Wpml');
    $wpml->before_get_permalink();
    $this->permalink = apply_filters( 'wpml_permalink', get_permalink( $post ), apply_filters('cs_locate_wpml_language', null, $post ) );
    $wpml->after_get_permalink();


    $elements = cs_get_serialized_post_meta( $this->id, '_cornerstone_data', true, 'cs_content_load_serialized_content' );

    if ( ! is_array( $elements ) ) {
      $elements = array( 'data' => '' );
    }

    // TODO: Load Settings from manager
    $settings = cs_get_serialized_post_meta( $this->id, '_cornerstone_settings', true );

    if ( ! is_array( $settings ) ) {
      $settings = array();
    }

    $this->set_elements( $elements );
    $this->set_settings( $settings );

  }

  protected function normalize_elements( $elements ) {

    if ( ! isset( $elements['data'] ) ) {

      $migrations = CS()->component('Element_Migrations');
      $elements = array(
        'data' => $migrations->migrate_classic( $elements )
      );

    }

    return $elements;
  }

  protected function normalize_settings( $settings ) {
    return $settings;
  }

  public function save() {

    $post_type_object = get_post_type_object( $this->post_type );
    $caps = (array) $post_type_object->cap;

    $authorized = is_null( $this->id ) ? current_user_can( $caps['create_posts'] ) : current_user_can( $caps['edit_post'], $this->id );

    if ( ! $authorized ) {
      throw new Exception( 'Unauthorized' );
    }

    if ( is_null( $this->id) ) {

      $id = wp_insert_post( array(
        'post_title' => $this->title,
        'post_type' => $this->post_type,
        'post_status' => $this->post_status,
      ));

      if ( is_wp_error( $id ) ) {
        return $id;
      }

      if ( 0 === $id ) {
        return new WP_Error('cs-content', "Unable to save content: $id");
      }

      $this->id = $id;

    }

    $settings = $this->update_settings( $this->get_settings() );

    if ( is_wp_error( $settings ) ) {
      throw new Exception( 'Error saving content settings: ' . $settings->get_error_message() );
    }

    $elements = $this->get_elements();
    $update_elements = $this->update_elements( $elements['data'] );

    if ( is_wp_error( $update_elements ) ) {
      throw new Exception( 'Error saving content elements: ' . $update_elements->get_error_message() );
    }

    return $this->serialize();

  }

  public function get_id() {
    return $this->id;
  }

  public function get_post() {
    return get_post( $this->id );
  }

  public function get_title() {
    return $this->title;
  }

  public function get_elements() {
    if ( ! isset( $this->data['elements'] ) ) {
      $this->data['elements'] = array( 'data' => '' );
    }
    return $this->data['elements'];
  }

  public function get_settings() {
    if ( ! isset( $this->data['settings'] ) ) {
      $this->data['settings'] = array();
    }
    return $this->data['settings'];
  }

  public function serialize() {
    return array(
      'id' => $this->id,
      'title' => $this->get_title(),
      'post_type' => $this->post_type,
      'permalink' => $this->permalink,
      'elements'  => $this->get_elements(),
      'settings' => $this->get_settings()
    );
  }

  public function set_title( $title ) {
    return $this->title = sanitize_text_field( $title, sprintf( csi18n('common.untitled-entity'), csi18n('common.entity-content') ) );
  }

  public function set_post_type( $post_type ) {
    $this->post_type = $post_type;
  }

  public function set_post_status( $post_status ) {
    $this->post_status = $post_status;
  }

  public function set_settings( $settings ) {
    $this->data['settings'] = $this->normalize_settings( $settings );
  }

  public function set_elements( $elements ) {
    $this->data['elements'] = $this->normalize_elements( $elements );
  }

  public function delete() {

    if ( ! current_user_can( CS()->common()->get_post_type_capability( $this->post_type, 'delete_posts' ), $this->id ) ) {
      throw new Exception( 'Unauthorized' );
    }

    do_action('cornerstone_delete_content', $this->id );

    return wp_delete_post( $this->id, true );

  }


  public function update_elements( $elements ) {

    if ( ! is_array( $elements ) ) {
      return;
    }

    CS()->component( 'Element_Orchestrator' )->load_elements();

    $output = $this->build_output( $elements );

		if ( is_wp_error( $output ) ) {
			return $output;
		}

    do_action( 'cornerstone_before_save_content', $this->id );

		$old_version = get_post_meta( $this->id, '_cornerstone_version', true );
    update_post_meta( $this->id, '_cornerstone_version', CS()->version() );

		cs_update_serialized_post_meta( $this->id, '_cornerstone_data', $output['data'], '', false, 'cs_content_update_serialized_content' );
		delete_post_meta( $this->id, '_cornerstone_override' );
    delete_post_meta( $this->id, '_cs_generated_styles');

		$post_content = apply_filters( 'cornerstone_save_post_content', $output['content'] );

		$id = wp_update_post( array(
			'ID'           => $this->id,
      'title'        => $this->get_title(),
      'post_type'    => $this->post_type,
      'post_status'  => $this->post_status,
      'post_content' => wp_slash( '[cs_content]' . $post_content . '[/cs_content]' ),
		) );

    if ( is_wp_error( $id ) ) {
      return $id;
    }

    if ( 0 === $id ) {
      return new WP_Error('cs-content', "Unable to save content: $id");
    }

		$post_type = get_post_type( $this->id );

		if ( false !== $post_type && post_type_supports( $post_type, 'excerpt' ) ) {
			update_post_meta( $this->id, '_cornerstone_excerpt', cs_derive_excerpt( "[cs_content _p={$id} no_wrap=true]{$post_content}[/cs_content]" ) );
		}

    do_action( 'cornerstone_after_save_content', $this->id );

    return true;
  }

  public function build_output( $elements ) {

    // Generate shortcodes
    $buffer = '';
    $sanitized = array();

    $elements = CS()->component('Regions')->populate_modules( $this->id, $elements, 'content');

    foreach ( $elements as $element ) {
      $output = $this->build_element_output( $element );
      if ( is_wp_error( $output ) ) {
        return $output;
      }
      $buffer .= $output['content'];
      $sanitized[] = $output['data'];
    }


    return array(
      'content' => $buffer,
      'data' => $sanitized
    );
  }

  public function build_element_output( $element, $parent = null ) {

    if ( ! isset( $element['_type'] ) ) {
      return new WP_Error( 'Cornerstone_Save_Handler', 'Element _type not set: ' . maybe_serialize( $element ) );
    }

    if ( 0 === strpos( $element['_type'], 'classic:' ) ) {
      return $this->build_classic_element_output( $element, $parent );
    }

    //
    // Build V2 element
    //

    $definition = CS()->component( 'Element_Manager' )->get_element( $element['_type'] );

    $buffer = '';
    $atts = array();

    if ( isset( $element['_modules'] ) ) {
      $sanitized = array();
      if ( $definition->render_children() ) {
        $children = array();
        foreach ( $element['_modules'] as $child ) {
          $children[] = $child['_id'];
          $sanitized[] = $child;
        }
        $atts['_modules'] = implode(',', $children);
      } else {
        foreach ( $element['_modules'] as $child ) {
          $output = $this->build_element_output( $child, $element );
          if ( is_wp_error( $output ) ) {
            return $output;
          }
          $buffer .= $output['content'];
          $sanitized[] = $output['data'];
        }

      }

      $element['_modules'] = $sanitized;
    }

    $content = '';
    if ( ! isset( $element['_active'] ) || $element['_active'] ) {
      $content = $definition->save( $element, $buffer, $atts );
    }

    unset($element['_id']);
    unset($element['_region']);

    return array(
      'content' => $content,
      'data' => $element
    );

  }

  public function build_classic_element_output( $element, $parent = null ) {

    $element['_type'] = str_replace('classic:', '', $element['_type'] );
    $definition = CS()->component( 'Element_Orchestrator' )->get( $element['_type'] );
    $element = $definition->sanitize( $element );

    if ( 'mk1' === $definition->version() ) {
      return CS()->component( 'Legacy_Renderer' )->save_element( $element );
    }

    $flags = $definition->flags();

    if ( ! isset( $flags['child'] ) || ! $flags['child'] ) {
      $parent = null;
    }

    $buffer = '';

    if ( isset( $element['_modules'] ) ) {
      $sanitized = array();
      foreach ( $element['_modules'] as $child ) {
        $output = $this->build_element_output( $child, $definition->compose( $element ) );
        if ( is_wp_error( $output ) ) {
          return $output;
        }
        $buffer .= $output['content'];
        $sanitized[] = $output['data'];
      }
      $element['_modules'] = $sanitized;
    }


    $content = '';
    if ( ! isset( $element['_active']) || $element['_active'] ) {
      if ( isset($element['_modules'] ) ) {
        $element['elements'] = $element['_modules'];
      }
      $content = $definition->build_shortcode( $element, $buffer, $parent );

      // <!--nextpage--> support for classic sections
      if ( 'section' === $element['_type'] ) {
        // Move all <!--nextpage--> directives to outside their section.
        $content = preg_replace( '#(?:<!--nextpage-->.*?)(\[\/cs_section\])#', '$0<!--nextpage-->', $content );

        //Strip all <!--nextpage--> directives still within sections
        $content = preg_replace( '#(?<!\[\/cs_section\])<!--nextpage-->#', '', $content );

        $content = str_replace( '<!--more-->', '', $content );
      }

      unset($element['elements']);
    }

    $element['_type'] = 'classic:' . $element['_type'];
    unset($element['_id']);
    unset($element['_region']);

    return array(
      'content' => $content,
      'data' => $element
    );

  }

  public function update_settings( $settings ) {

    $setting_manager = CS()->component( 'Settings_Manager' );
    $setting_manager->load();

		foreach ( $settings as $section => $data ) {

  		if ( $section_manager = $setting_manager->get( $section ) ) {

        $result = $section_manager->save( $data, $this );

        if ( is_wp_error( $result ) ) {
  				return $result;
  			}

  		}

		}

		return true;
	}

}
