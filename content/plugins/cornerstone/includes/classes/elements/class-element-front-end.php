<?php

class Cornerstone_Element_Front_End extends Cornerstone_Plugin_Component {

  public $element_data;
  public $target_post_id = null;
  protected $previous_target_stack = array();
  protected $ancestor_data = array();

  public function setup() {

    add_filter( 'x_locate_template', array( $this, 'template_locator'), 0, 5 );
    add_action( 'cs_late_template_redirect', array( $this, 'post_loaded' ), 9998, 0 );
    add_action( 'wp_loaded', array( $this, 'register_shortcodes') );

  }

  public function post_loaded() {

    $this->load_element_data( get_the_ID() );

  }

  public function register_shortcodes() {

    $elements = $this->plugin->loadComponent('Element_Manager')->get_element_names();

    add_shortcode( 'cs_context', array( $this, 'shortcode_output' ) );
    add_shortcode( 'cs_gb', array( $this, 'global_block_shortcode_output' ) );

    foreach ($elements as $name) {
      if ( false === strpos($name, 'classic:' ) ) {
        $tag = "cs_element_" . str_replace('-', '_', $name );
        add_shortcode( $tag, array( $this, 'shortcode_output' ) );
      }
    }

  }

  public function load_element_data( $post_id ) {

    $regions = $this->plugin->loadComponent('Regions');

    $elements = $regions->get_content_elements( (int) $post_id );

    $handle = "p$post_id";

    if ( $elements ) {
      $this->element_data[$handle] = $regions->flatten_elements( $elements );
    }

    $this->register_element_styles( $post_id, $elements );

  }

  public function register_element_styles( $id, $elements ) {
    $styling = $this->plugin->loadComponent( 'Styling' );
    if ( ! $styling->has_styles( $id ) ) {
      $styling->add_styles( $id, $this->get_generated_styles( $id, $elements ) );
    }
  }

  public function lookup_element_data( $element_id, $post_id = null, $fallback_to_current_id = true ) {

    if ( ! $post_id && $fallback_to_current_id ) {
      $post_id = get_the_ID();
    }

    if ( $post_id && ! isset( $this->element_data[ 'p' . $post_id ] ) ) {
      $this->load_element_data( $post_id );
    }

    return ( isset( $this->element_data[ 'p' . $post_id ] ) &&
      isset( $this->element_data[ 'p' . $post_id ][ 'el' . $element_id ] ) ) ?
        $this->element_data[ 'p' . $post_id ][ 'el' . $element_id ] : array();

  }

  public function shortcode_output( $atts, $content, $tag ) {

    $data = array();
    $parent_atts = end( $this->ancestor_data );

    if ( isset( $atts['_p'] ) ) {
      array_push($this->previous_target_stack, $this->target_post_id);
      $this->target_post_id = $atts['_p'];
    }

    $target_id = $this->target_post_id;

    if ( is_null( $target_id ) ) {
      $target_id = get_the_ID();
    }

    if ( isset( $atts['_id'] ) ) {
      $data = $this->lookup_element_data( $atts['_id'], $target_id );
    }

    $type = ( isset( $atts['_type'] ) ) ? $atts['_type'] : isset( $data['_type'] ) ? $data['_type'] : null;

    if ( ! $type ) {

      $output = do_shortcode( $content );

      if ( isset( $atts['_p'] ) ) {
        $this->target_post_id = array_pop($this->previous_target_stack);
      }

      return $output;
    }

    $definition = $this->plugin->component('Element_Manager')->get_element($type);

    if ( ! $definition ) {
      return '';
    }

    if ( $definition->is_shadow() && is_array( $parent_atts ) ) {

      $parent_atts = x_module_decorate( $parent_atts );

      $data['p_mod_id'] = $parent_atts['mod_id'];

      foreach ($parent_atts as $key => $value) {
        if ( ! isset( $data[$key] ) ) {
          $data[$key] = $value;
        }
      }
      $data['_transient'] = array(
        'parent' => $parent_atts
      );

    }

    $element = array_merge( $atts, $data );

    $element['_p'] = $target_id;

    $this->ancestor_data[] = $element;
    $element['_modules'] = ( isset( $content ) ) ? do_shortcode($content) : '';
    array_pop($this->ancestor_data);

    ob_start();

    $definition->render( $element );

    $output = ob_get_clean();
    if ( isset( $atts['_p'] ) ) {
      $this->target_post_id = array_pop($this->previous_target_stack);
    }

    return $output;
  }


  public function template_locator( $template, $view, $directory, $file_base, $file_extension ) {

    if ( ! $template ) {

      $base_path = null;

      if ( 'styles/elements' === $directory ) {
        $base_path = 'styles/elements';
      }

      if ( 'elements' === $directory ) {
        $base_path = 'elements';
      }

      if ( 'partials' === $directory ) {
        $base_path = 'partials';
      }

      if ( $base_path ) {
        $view = $base_path . '/' . $file_base;

        if ( '' !== $file_extension ) {
          $view .= "-$file_extension";
        }

        $view = $this->locate_view( $view );

        if ( $view ) {
          $template = $view;
        }
      }

    }

    return $template;
  }


  public function generate_styles( $id, $elements ) {

     $elements = $this->expand_shadows( $elements );
     $sorted = $this->sort_into_types( $elements );
     $element_css = array();

     $coalescence = $this->plugin->loadComponent( 'Coalescence' )->start();


     foreach ($sorted as $type => $elements) {

        // Load the style template for each type being used
        $type_definition = $this->plugin->component('Element_Manager')->get_element( $type );
        $coalescence->add_template( $type, $type_definition->get_style_template() );

        // Preprocess styles.
        // This applies defaults and wraps retroactive properties
        // in a way that they can be expanded later
        foreach ($elements as $index => $data) {
          $data['_p'] = $id;
          $element_data = $type_definition->preprocess_style( $data );
          if ( isset( $element_data['css'] ) && $element_data['css'] ) {
            $element_css[] = str_replace('$el', '.' . $element_data['_el'], $element_data['css']);
            unset( $element_data['css'] );
          }
          $sorted[$type][$index] = $element_data;
        }

        $coalescence->add_items( $type, $sorted[$type] );
     }

    return $coalescence->run() . ' ' . implode(' ', $element_css);

  }

  public function expand_shadows( $elements, $parent_data = null ) {

    foreach ($elements as $index => $element) {
      if ( isset( $elements[$index]['_modules'] ) && is_array($elements[$index]['_modules'] ) ) {
        $elements[$index]['_modules'] = $this->expand_shadows( $elements[$index]['_modules'], $elements[$index] );
      }

      if ( is_array( $parent_data ) ) {

        $definition = $this->plugin->component('Element_Manager')->get_element( $elements[$index]['_type'] );

        if ( $definition->is_shadow() ) {

          // mod_id not required for styling because style data is never decorated
          // $elements[$index]['p_mod_id'] = $parent_data['mod_id'];

          foreach ($parent_data as $key => $value) {
            if ( ! isset( $elements[$index][$key] ) ) {
              $elements[$index][$key] = $value;
            }
          }
        }
      }

    }

    return $elements;
  }

  public function sort_into_types( $elements ) {

    $this->sorting_sets = array();

    $walker = new Cornerstone_Walker( array(
      '_modules' => $elements
    ) );

    $walker->walk( array( $this, 'sort_into_types_callback' ) );
    ksort($this->sorting_sets);

    $sorting_sets = $this->sorting_sets;
    unset($this->sorting_sets);

    return $sorting_sets;

  }

  public function sort_into_types_callback( $walker ) {
    $data = $walker->data();
    if ( ! isset( $data['_type'] ) ) {
      return;
    }

    if ( ! isset( $this->sorting_sets[$data['_type']] ) ) {
      $this->sorting_sets[$data['_type']] = array();
    }

    unset($data['_modules']);
    $this->sorting_sets[$data['_type']][] = $data;

  }

  public function get_generated_styles( $id, $elements, $force = false ) {

    $generated = get_post_meta( $id, '_cs_generated_styles', true );

    if ( ! $generated || $force ) {
      if ( ! $elements ) {
        return '';
      }
      $generated = $this->generate_styles( $id, $elements );
      update_post_meta( $id, '_cs_generated_styles', $generated );
    }

    return $generated;
  }

  public function global_block_shortcode_output( $atts ) {

    extract( shortcode_atts( array(
      'id'    => '',
      'class'    => '',
    ), $atts, 'cs_gb' ) );

    $definition = $this->plugin->component('Element_Manager')->get_element( 'global-block' );

    ob_start();

    $definition->render( array(
      '_id'             => '',
      '_type'           => 'global-block',
      'global_block_id' => $id,
      'class'           => $class
    ) );

    return ob_get_clean();

  }

}
