<?php

class Cornerstone_Element_Renderer extends Cornerstone_Plugin_Component {

  public $dependencies = array( 'Front_End' );
  public $zones = array();
  public $zone_output = array();
  public $inline_styling_handles = array();
  public $fonts = array();

  public function start( $context ) {

    $this->zones = $this->plugin->component('Common')->get_preview_zones();

    $this->setup_context_all();
    do_action('cs_element_rendering');

    if ( isset( $context['mode'] ) ) {
      $data = isset( $context['data'] ) ? $context['data'] : array();
      do_action('cs_element_rendering_' . $context['mode'], $data );
      $setup_context_method = array( $this, 'setup_context_' . $context['mode'] );
      if ( is_callable( $setup_context_method ) ) {
        call_user_func( $setup_context_method, $data );
      }
    }

    $this->enqueue_extractor = $this->plugin->component( 'Enqueue_Extractor' );
    $this->enqueue_extractor->start();

    add_action( 'cs_styling_add_styles', array( $this, 'track_inline_styling_handles' ) );
    add_action( 'cs_load_queued_fonts',  array( $this, 'track_fonts' ), 10, 2 );

  }

  public function zone_siphen_start() {
    ob_start();
  }

  public function zone_siphen_end() {

    $content = ob_get_clean();

    if ( $content ) {
      $this->zone_output[current_action()] = $this->restore_html( $content );
    }

  }

  public function end() {

  }

  public function get_extractions() {
    return array(
      'fonts'   => array_keys( $this->fonts ),
      'scripts' => $this->enqueue_extractor->get_scripts(),
      'styles'  => $this->enqueue_extractor->get_styles()
    );
  }

  public function render_element( $model ) {

    /* internal switch for global block */
    if ( isset($model['global_block_id']) ) {
      $wpml = CS()->component('Wpml');
      $wpml->switch_lang($model['lang']);
    }

    $response = '';
    $this->zone_output = array();
    $this->inline_styling_handles = array();
    $inline_css = '';

    $render_data = array();
    $element_data = $model;
    $element_manager = CS()->component('Element_Manager');
    $definition = $element_manager->get_element( $model['_type'] );

    /**
     * Attach zone output siphens
     */

    foreach ( $this->zones as $zone ) {
      remove_all_actions( $zone );
      add_action( $zone, array( $this, 'zone_siphen_start' ), 0 );
    }

    $parent_attr_keys = array();
    $parent_attr_html_keys = array();
    $parent_html_keys = array();
    $attr_keys = $definition->get_designated_keys( 'attr' );
    $attr_html_keys = $definition->get_designated_keys( 'attr:html' );
    $markup_html_keys = $definition->get_designated_keys('markup:html' );


    // Does not support recursive shadowing
    if ( $definition->is_child() && isset( $model['_transient'] ) && isset( $model['_transient']['parent'] ) ) {

      $parent_definition = $element_manager->get_element( $model['_transient']['parent']['_type'] );
      $parent_data = x_element_decorate( $model['_transient']['parent'] );

      $parent_attr_keys = $parent_definition->get_designated_keys( 'attr' );
      $parent_attr_html_keys = $parent_definition->get_designated_keys( 'attr:html' );
      $parent_html_keys = $parent_definition->get_designated_keys('markup:html' );

      $element_data['p_mod_id'] = $parent_data['mod_id'];

      foreach ($parent_data as $key => $value) {
        if ( ! isset( $element_data[$key] ) ) {
          $element_data[$key] = $value;
        }
      }

    }

    $markup_html_keys = array_merge( $parent_html_keys, $markup_html_keys );

    // Don't allow classic elements to use HTML keys
    if ( 0 === strpos($definition->get_type(), 'classic:' ) ) {
      $markup_html_keys = array();
    }


    /**
     * Replace keys designated as attributes with {{model.atts.key_name}}
     */

    foreach ($attr_keys as $key) {
      $render_data[$key] = "{%%{data.$key}%%}";
    }

    foreach ($parent_attr_keys as $key) {
      $render_data[$key] = "{%%{parentData.$key}%%}";
    }

    foreach ($attr_html_keys as $key) {
      $render_data[$key] = "{%%{data.$key}%%}";
    }

    foreach ($parent_attr_html_keys as $key) {
      $render_data[$key] = "{%%{parentData.$key}%%}";
    }

    $this->html_cache = array();

    foreach ($element_data as $key => $value) {

      // attr keys are already set to handlebar template properties
      if ( in_array( $key, $attr_keys, true )
        || in_array( $key, $attr_html_keys, true )
        || in_array( $key, $parent_attr_keys, true )
        || in_array( $key, $parent_attr_html_keys, true )
      ) {
        continue;
      }

      // base64 encode HTML within handlebars helper
      if ( in_array($key, $markup_html_keys, true) ) {
        $render_data[$key] = $this->isolate_html( $key, $value );
        continue;
      }

      // Pass through other values
      $render_data[$key] = $value;

    }

    if ( isset( $model['_id'] ) ) {
      $render_data['_id'] = '{%%{_id}%%}';
    }

    if ( $definition->render_children() ) {

      add_filter('cornerstone_preview_container_output', '__return_false');
      $decorate_parent = x_element_decorate( $render_data );

      if ( isset( $model['_transient']['children'] ) ) {

        $render_data['_modules'] = array();

        foreach ($model['_transient']['children'] as $index => $child) {

          $child['_transient'] = array( 'parent' => $render_data );
          $child_render_data = x_element_decorate( $child, $decorate_parent );
          $child_definition = $element_manager->get_element( $model['_type'] );
          $child_markup_html_keys = $child_definition->get_designated_keys('markup:html');

          foreach ($child as $key => $value) {

            // base64 encode HTML within handlebars helper
            if ( in_array($key, $child_markup_html_keys, true) ) {
              $child_render_data[$key] = $this->isolate_html( "child_$key", $value );
              continue;
            }

          }

          $render_data['_modules'][] = $child_render_data;

        }

      }

    }

    /**
     * Render the module using a registered filter
     */

    $response = $definition->render( x_element_decorate( $render_data ) );

    /**
     * Restore Isolated HTML
     */

    $response = $this->restore_html( $response );

    /**
     * Capture output that was deffered into any registered zones
     */

    foreach ( $this->zones as $zone ) {
      add_action( $zone, array( $this, 'zone_siphen_end' ), 9999999 );
      do_action( $zone );
    }

    foreach ($this->zone_output as $key => $value) {
      $html = preg_replace('/<!--(.|\n)*?-->/', '', $value);
      $markup = base64_encode( apply_filters( 'cs_render_element_zone_output', $html ) );
      $response .= "{%%{portal name=$key content=$markup }%%}";
    }

    $styling = $this->plugin->component('Styling');
    foreach ($this->inline_styling_handles as $handle) {
      $inline_css .= $styling->get_generated_styles_by_handle( $handle ) . ' ';
    }

    $this->plugin->component('Font_Manager')->flush_queue();

    if ( $definition->render_children() ) {
      remove_filter('cornerstone_preview_container_output', '__return_false');
    }

    return array(
      'template'    => apply_filters( 'cs_render_element_template', $response ),
      'inline_css'  => $inline_css,
      'type'        => $model['_type'],
      'extractions' => $this->enqueue_extractor->extract()
    );
  }

  public function isolate_html( $key, $content ) {

    global $wp_embed;

    $content = apply_filters( 'cs_render_element_isolate_html', do_shortcode( $wp_embed->autoembed( $content ) ) );

    if ( ! $content ) {
      return '';
    }

    $this->html_cache[$key]  = $this->encode_base64( $content );
    return "{%%{isolated_html $key}%%}";
  }

  public function restore_html( $content ) {
    return preg_replace_callback( "/{%%{isolated_html (\w+)}%%}/s", array( $this, 'restore_html_callback' ), $content );
  }

  public function restore_html_callback($matches) {
    return $this->html_cache[$matches[1]];
  }

  public function setup_context_all() {
    $this->setup_context_all_register_hooks();
    add_action( '_cs_rendering_global_block_begin', array( $this, 'setup_context_all_teardown_hooks' ) );
    add_action( '_cs_rendering_global_block_end',   array( $this, 'setup_context_all_register_hooks' ) );
    add_action( 'cs_dynamic_rendering', array($this, 'dynamic_rendering_filter') );
    add_filter( 'cs_preview_decode_markup', array( $this, 'decode_base64' ) );
    add_filter( 'cs_preview_encode_markup', array( $this, 'encode_base64' ) );
  }

  public function setup_context_all_register_hooks() {
    add_filter( 'x_breadcrumbs_data', 'x_bars_sample_breadcrumbs', 10, 2 );
    add_action( 'x_render_children', 'cornerstone_preview_container_output' );
  }

  public function setup_context_all_teardown_hooks() {
    remove_filter( 'x_breadcrumbs_data', 'x_bars_sample_breadcrumbs', 10, 2 );
    remove_action( 'x_render_children', 'cornerstone_preview_container_output' );
  }

  public function setup_context_content_register_hooks() {
    add_action( 'x_section', 'cornerstone_preview_container_output' );
    add_action( 'x_row', 'cornerstone_preview_container_output' );
    add_action( 'x_column', 'cornerstone_preview_container_output' );
    add_action( 'x_layout_column', 'cornerstone_preview_container_output' );
    add_action( 'x_layout_row', 'cornerstone_preview_container_output' );
    add_action( 'x_layout_cell', 'cornerstone_preview_container_output' );
  }

  public function setup_context_content_teardown_hooks() {
    remove_action( 'x_section', 'cornerstone_preview_container_output' );
    remove_action( 'x_row', 'cornerstone_preview_container_output' );
    remove_action( 'x_column', 'cornerstone_preview_container_output' );
    remove_action( 'x_layout_row', 'cornerstone_preview_container_output' );
    remove_action( 'x_layout_column', 'cornerstone_preview_container_output' );
    remove_action( 'x_layout_cell', 'cornerstone_preview_container_output' );
  }

  public function setup_context_content( $data ) {

    if ( ! isset($data['post_id']) ) {
      return;
    }

    $this->setup_context_content_register_hooks();
    add_action( '_cs_rendering_global_block_begin', array( $this, 'setup_context_content_teardown_hooks' ) );
    add_action( '_cs_rendering_global_block_end',   array( $this, 'setup_context_content_register_hooks' ) );

    global $post;

    $post = get_post( (int) $data['post_id'] );

    if ( ! is_null( $post ) ) {
      setup_postdata( $post );
    }

  }

  public function track_inline_styling_handles( $handle ) {
    $this->inline_styling_handles[] = $handle;
  }

  public function track_fonts( $fonts, $sources ) {
    foreach ($fonts as $font) {
      $this->fonts[$font['_id']] = true;
    }
  }

  //
  // Dynamic Rendering
  // We don't want the content to be base64 encoded.
  //

  public function dynamic_rendering_filter($content) {
    return $this->unwrap_base64($this->restore_html($content));
  }

  public function decode_base64( $content ) {
    return $this->unwrap_base64($this->restore_html($content));
  }

  public function encode_base64( $content ) {
    return '{%%{base64content ' . base64_encode( $content ) . '}%%}';
  }

  public function unwrap_base64($content) {
    return preg_replace_callback('/{%%{base64content (.*?)\s*?}%%}/', array($this, 'unwrap_base64_cb'), $content);
  }

  public function unwrap_base64_cb($match) {
    return $this->unwrap_base64(base64_decode($match[1]));
  }

}
