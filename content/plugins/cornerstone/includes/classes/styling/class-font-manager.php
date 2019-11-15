<?php

class Cornerstone_Font_Manager extends Cornerstone_Plugin_Component {

  public $queue = array();
  public $custom_css_output = '';
  protected $font_items;
  protected $font_config;
  protected $previewing = false;

  public function setup() {
    add_filter( 'cornerstone_option_model_whitelist', array( $this, 'whitelist_options' ) );
    add_filter( 'cornerstone_option_model_defaults_cornerstone_font_items', array( $this, 'default_font_items' ) );
    add_filter( 'cornerstone_option_model_load_cornerstone_font_config', array( $this, 'config_load_transform' ) );
    add_filter( 'cornerstone_option_model_save_cornerstone_font_config', array( $this, 'config_save_transform' ) );
    add_filter( 'cornerstone_option_model_load_cornerstone_font_items', array( $this, 'items_load_transform' ) );
    add_filter( 'cornerstone_option_model_save_cornerstone_font_items', array( $this, 'items_save_transform' ) );
    add_filter( 'cornerstone_option_model_permissions_cornerstone_font_items', array( $this, 'item_permissions' ), 10, 2 );
    add_filter( 'cornerstone_option_model_permissions_cornerstone_font_config', array( $this, 'config_permissions' ), 10, 2 );

    add_filter('cs_css_post_process_font-family', array( $this, 'css_post_process_font_family') );
    add_filter('cs_css_post_process_font-weight', array( $this, 'css_post_process_font_weight') );

    if ( ! did_action('cs_before_preview_frame') ) {
      add_action( 'cornerstone_head_css', array( $this, 'output_typekit_loading_styles' ) );
      add_action( 'x_head_css', array( $this, 'output_typekit_loading_styles' ) );
    }

    add_filter( 'upload_mimes', array( $this, 'upload_mimes' ), 999 );
  }

  public function set_previewing() {
    $this->previewing = true;
  }

  public function default_font_items( $data ) {
    return array(
      array(
        '_id'     => bin2hex('Body Copy'),
        'title'   => csi18n( 'app.fonts.body-copy' ),
        'family'  => 'Helvetica',
        'stack'   => 'Helvetica, Arial, sans-serif',
        'weights' => array( '300', '300i', '400', '400i', '700', '700i' ),
        'source'  => 'system'
      ),
      array(
        '_id'     => bin2hex('Headings'),
        'title'   => csi18n( 'app.fonts.headings' ),
        'family'  => 'Helvetica',
        'stack'   => 'Helvetica, Arial, sans-serif',
        'weights' => array( '300', '300i', '400', '400i', '700', '700i' ),
        'source'  => 'system'
      ),
    );
  }
  public function whitelist_options( $keys ) {
    $keys[] = 'cornerstone_font_config';
    $keys[] = 'cornerstone_font_items';
    return $keys;
  }

  public function config_load_transform( $data ) {

    $data = ( is_null( $data ) ) ? array() : json_decode( wp_unslash( $data ), true );

    return wp_parse_args( $data, array(
      'googleSubsets' => array(),
      'typekitKitID' => '',
      'customFontItems' => array(),
      'customFontFaceCSS' => ''
    ) );

  }

  public function config_save_transform( $data ) {
    return wp_slash( cs_json_encode( $data ) );
  }


  public function items_load_transform( $data ) {
    return ( is_null( $data ) ) ? array() : json_decode( wp_unslash( $data ), true );
  }

  public function items_save_transform( $data ) {
    return wp_slash( cs_json_encode( $data ) );
  }

  public function get_fallback_font() {
    return  array(
      'family'  => 'Helvetica',
      'stack'   => 'Helvetica, Arial, sans-serif',
      'weights' => array( '400', '400i', '300', '300i', '700', '700i' ), // The first weight will be used when falling back
      'source'  => 'system'
    );
  }

  protected function get_font_items() {
    if ( ! $this->font_items ) {
      $this->font_items = $this->plugin->component('Model_Option')->lookup('cornerstone_font_items');
    }
    return $this->font_items;
  }

  protected function get_font_config() {
    if ( ! $this->font_config ) {
      $this->font_config = $this->plugin->component('Model_Option')->lookup('cornerstone_font_config');
    }
    return $this->font_config;
  }

  protected function locate_font( $_id ) {
    $this->get_font_items();
    foreach ($this->font_items as $font) {
      if ( isset( $font['_id'] ) && $_id === $font['_id'] ) {
        return $font;
      }
    }
    return array(
      'family' => 'inherit',
      'stack' => 'inherit',
      'weights' => array( 'inherit' ),
      'source' => 'system'
    );
  }

  public function queue_font( $font ) {

    if ( 'system' === $font['source'] ) {
      return;
    }

    if ( isset( $this->queue[$font['stack']] ) ) {
      $this->queue[$font['stack']]['weights'] = array_merge( $this->queue[$font['stack']]['weights'], $font['weights'] );
    } else {
      $this->queue[$font['stack']] = $font;
    }

    if ( ! isset( $this->queue[$font['stack']]['weights'] ) ) {
      $this->queue[$font['stack']]['weights'] = array();
    }

    $this->should_flush_queue();

  }

  protected function should_flush_queue() {

    $method = array( $this, 'flush_queue' );

    $hooks = array( 'cs_head_late', 'wp_footer' );

    foreach ($hooks as $hook) {
      if ( ! has_action( $hook, $method ) ) {
        add_action( $hook, array( $this, 'flush_queue' ) );
      }
    }

  }

  protected function queue_font_weight( $font, $weight ) {
    $this->queue_font( $font );
    $this->queue[$font['stack']]['weights'][] = $weight;
    $this->queue[$font['stack']]['weights'][] = $weight . 'i';
  }

  public function css_post_process_font_family( $value ) {
    $font = $this->locate_font($value);
    $this->queue_font( $font );
    return $font['stack'];
  }

  protected function normalize_weight( $value ) {
    return ( false === strpos($value, ':' ) ) ? 'inherit:' . $value : $value;
  }

  public function css_post_process_font_weight( $value ) {
    $value = $this->normalize_weight( $value );
    $parts = explode(':', $value );

    if ( 'inherit' === $parts[0] ) {
      return $parts[1];
    }

    $font = $this->locate_font($parts[0]);
    $weight = ( in_array( $parts[1], $font['weights'], true ) ) ? $parts[1] : $font['weights'][0];
    $this->queue_font_weight( $font, $weight );

    return $weight;
  }

  public function load_queued_fonts() {

    $sources = array();

    foreach ($this->queue as $font) {
      if ( ! isset( $font['source'] ) ) {
        continue;
      }
      if ( ! isset( $sources[$font['source'] ] ) ) {
        $sources[$font['source']] = array();
      }
      $sources[$font['source']][] = array(
        'family' => $font['family'],
        'weights' => $font['weights']
      );
    }

    ksort($sources);

    do_action( 'cs_load_queued_fonts', $this->queue, $sources );

    if ( $this->previewing ) {
      return;
    }

    foreach ($sources as $source => $fonts) {
      $method = array( $this, "load_fonts_$source" );
      if ( is_callable( $method ) ) {
        call_user_func_array( $method, array( $fonts ) );
      }
    }

  }


  public function flush_queue() {

    $method = array( $this, 'flush_queue' );
    remove_action( 'cs_head_late', $method );
    remove_action( 'wp_footer', $method );

    $this->load_queued_fonts();
    $this->queue = array();

  }

  public function load_fonts_google( $fonts ) {

    if ( ! apply_filters('cs_load_google_fonts', '__return_true' ) ) {
      return;
    }

    $in_footer = 'wp_footer' === current_action();

    $config = apply_filters( 'cs_google_font_config', wp_parse_args($this->get_font_config(), array(
      'googleSubsets' => array()
    ) ) );

    $subsets = array_merge( array('latin', 'latin-ext'), $config['googleSubsets'] );
    $subsets = array_unique($subsets);

    $family_strings = array();

    foreach ($fonts as $font) {
      $weights = array_unique( $font['weights'] );
      $family_strings[] = str_replace(' ', '+', $font['family'] ) . ':' . implode(',', $weights );
    }

    $request = esc_url( add_query_arg( array(
      'family' => implode('|', $family_strings),
      'subset' => implode(',', $subsets )
    ), apply_filters('cs_google_fonts_uri', '//fonts.googleapis.com/css' ) ) );

    $atts = cs_atts( array(
      'rel'   => 'stylesheet',
      'href'  => apply_filters( 'cs_google_fonts_href', $request ),
      'type'  => 'text/css',
      'media' => 'all',
      'data-x-google-fonts' => null,
    ) );

    $output = "<link $atts/>";

    if ( $in_footer ) {
      $output = $this->late_google_font_script( $output );
    }

    echo $output;

  }

  public function late_google_font_script( $output ) {

    ob_start();

    ?>
    <script>
      (function($){
        if ( ! $ ) return;
        var $gf = $('<?php echo $output; ?>');
        $('head').append($gf);
      })(jQuery);
    </script>
    <?php

    return ob_get_clean();

  }

  public function load_fonts_typekit( $fonts ) {
    add_action( did_action('cs_head_late_after') ? 'wp_footer' : 'cs_head_late_after', array( $this, 'output_typekit_script') );
  }

  public function load_fonts_custom( $fonts ) {

    $config = apply_filters( 'cs_custom_font_config', wp_parse_args($this->get_font_config(), array(
      'customFontItems' => array()
    ) ) );

    $load = array();
    $buffer = '';

    foreach ($fonts as $font) {
      $load[] = $font['family'];
    }

    foreach ($config['customFontItems'] as $item) {
      if (in_array($item['family'], $load)) {
        $buffer .= $item['css'];
      }
    }

    if ( $buffer ) {
      CS()->component( 'Styling' )->add_styles( 'cs-custom-fonts', $buffer );
    }

  }

  public function output_typekit_script() {

    $config = $this->get_font_config();

    if ( ! $config['typekitKitID'] ) {
      return;
    }

    ?>
    <script id="cs-typekit-loader">
      (function(doc){
        var config = { kitId:'<?php echo $config['typekitKitID'];?>', async:true }

        var timer = setTimeout(function(){
          doc.documentElement.className = doc.documentElement.className.replace(/\bwf-loading\b/g,"") + " wf-inactive";
        }, 3000)

        var tk = doc.createElement("script")
        var loaded = false
        var firstScript = doc.getElementsByTagName("script")[0]

        doc.documentElement.className += " wf-loading"

        tk.src = 'https://use.typekit.net/' + config.kitId + '.js'
        tk.async = true
        tk.onload = tk.onreadystatechange = function(){
          if (loaded || this.readyState && this.readyState != "complete" && this.readyState != "loaded") return
          loaded = true
          clearTimeout(timer)
          try { Typekit.load(config) } catch(e){}
        }

        firstScript.parentNode.insertBefore(tk, firstScript)
      })(window.document)
    </script>
    <?php

  }

  public function output_typekit_loading_styles() {

    $config = $this->get_font_config();

    if ( ! $config['typekitKitID'] ) {
      return;
    }

    echo '.wf-loading a, .wf-loading p, .wf-loading ul, .wf-loading ol, .wf-loading dl, .wf-loading h1, .wf-loading h2, .wf-loading h3, .wf-loading h4, .wf-loading h5, .wf-loading h6, .wf-loading em, .wf-loading pre, .wf-loading cite, .wf-loading span, .wf-loading table, .wf-loading strong, .wf-loading blockquote { visibility: hidden !important; }';

  }

  public function item_permissions( $value, $operation ) {

    $permissions = $this->plugin->component('App_Permissions');

    if ( 'update' === $operation ) {
      return $permissions->user_can('fonts.create') || $permissions->user_can('fonts.change') || $permissions->user_can('fonts.rename');
    }

    if ( 'delete' === $operation ) {
      return $permissions->user_can('fonts.delete');
    }

    return true;

  }

  public function config_permissions( $value, $operation ) {

    $permissions = $this->plugin->component('App_Permissions');

    if ( 'update' === $operation ) {
      return $permissions->user_can('fonts.manage-google') || $permissions->user_can('fonts.manage-adobe-fonts');
    }

    return 'delete' !== $operation;

  }

  public function upload_mimes( $mime_types ) {

    $new_types = $this->mime_types();

    foreach ($new_types as $ext => $type) {
      if (! isset($mime_types[$ext])) {
        $mime_types[$ext] = $type;
      }
    }


    return $mime_types;
  }

  public function mime_types() {

    $mime_types = array(
      'woff2' => 'font/woff2',
      'woff' => 'font/woff',
      'ttf' => 'application/x-font-ttf'
    );

    if ( apply_filters('cs_font_manager_add_legacy_mime_types', false) ) {
      $mime_types['svg'] = 'image/svg+xml';
      $mime_types['eot'] = 'application/vnd.ms-fontobject';
    }

    return apply_filters( 'cs_font_manager_mime_types', $mime_types );

  }

}
