<?php

class Cornerstone_Font_Manager extends Cornerstone_Plugin_Component {

  public $queue = array();
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

    add_filter('cornerstone_css_post_process_font-family', array( $this, 'css_post_process_font_family') );
    add_filter('cornerstone_css_post_process_font-weight', array( $this, 'css_post_process_font_weight') );

    add_action( 'cornerstone_head_css', array( $this, 'output_typekit_loading_styles' ) );
    add_action( 'x_head_css', array( $this, 'output_typekit_loading_styles' ) );
  }

  public function set_previewing() {
    $this->previewing = true;
  }

  public function default_font_items( $data ) {
    return array(
      array(
        '_id'     => bin2hex('Body Copy'),
        'title'   => 'Body Copy',
        'family'  => 'Helvetica',
        'stack'   => 'Helvetica, Arial, sans-serif',
        'weights' => array( '300', '300i', '400', '400i', '700', '700i' ),
        'source'  => 'system'
      ),
      array(
        '_id'     => bin2hex('Headings'),
        'title'   => 'Headings',
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
      $this->font_items = $this->plugin->loadComponent('Model_Option')->lookup('cornerstone_font_items');
    }
    return $this->font_items;
  }

  protected function get_font_config() {
    if ( ! $this->font_config ) {
      $this->font_config = $this->plugin->loadComponent('Model_Option')->lookup('cornerstone_font_config');
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

  protected function queue_font( $font ) {
    if ( 'system' === $font['source'] || isset( $this->queue[$font['stack']] ) ) {
      return;
    }

    $this->queue[$font['stack']] = $font;
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
    $this->queue[$font['stack']]['queued_weights'][] = $weight;
    $this->queue[$font['stack']]['queued_weights'][] = $weight . 'i';
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
        'weights' => array_intersect($font['weights'], $font['queued_weights'])
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

    $in_footer = 'wp_footer' === current_action();

    $config = $this->get_font_config();
    $additional_subsets = is_array( $config['googleSubsets'] ) ? $config['googleSubsets'] : array();
    $subsets = array_merge( array('latin', 'latin-ext'), $additional_subsets );

    $family_strings = array();

    foreach ($fonts as $font) {
      $family_strings[] = str_replace(' ', '+', $font['family'] ) . ':' . implode(',', $font['weights'] );
    }

    $request = add_query_arg( array(
      'family' => implode('|', $family_strings),
      'subset' => implode(',', $subsets )
    ), '//fonts.googleapis.com/css' );

    $url = add_query_arg( array(
      'ver' => $this->plugin->version(),
    ), esc_url( $request ) );

    $atts = cs_atts( array(
      'rel'   => 'stylesheet',
      'href'  => $url,
      'type'  => 'text/css',
      'media' => 'all',
      'data-x-google-fonts' => null,
    ));

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

  public function output_typekit_script() {

    $config = $this->get_font_config();

    if ( ! $config['typekitKitID'] ) {
      return;
    }

    ?>
    <script id="cs-typekit-loader">(function(d){var config={kitId:'<?php echo $config['typekitKitID']; ?>',scriptTimeout:3000,async:true},h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)})(document);</script>
    <?php

  }

  public function output_typekit_loading_styles() {

    $config = $this->get_font_config();

    if ( ! $config['typekitKitID'] ) {
      return;
    }

    echo '.wf-loading a, .wf-loading p, .wf-loading ul, .wf-loading ol, .wf-loading dl, .wf-loading h1, .wf-loading h2, .wf-loading h3, .wf-loading h4, .wf-loading h5, .wf-loading h6, .wf-loading em, .wf-loading pre, .wf-loading cite, .wf-loading span, .wf-loading table, .wf-loading strong, .wf-loading blockquote { visibility: hidden !important; }';

  }

}
