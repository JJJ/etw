<?php

class Cornerstone_Shortcode_Generator extends Cornerstone_Plugin_Component {

  static $instance;
  private $shortcodes = array();
  private $sections = array();
  private $mapped = false;

  public function setup() {

    $settings = $this->plugin->settings();

    if ( ! $settings['use_shortcode_generator'] ) {
      return;
    }

		add_action( 'admin_init', array( $this, 'start' ) );
		add_action( 'cornerstone_load_builder', array( $this, 'start' ) );
    add_action( 'wp_ajax_csg_list_shortcodes', array( &$this, 'modelEndpoint' ) );

  }

  public function start() {

    add_action( 'media_buttons', array( $this, 'addMediaButton' ), 999 );
    add_action( 'cornerstone_generator_preview_before', array( $this, 'previewBefore' ) );

  }

  public function enqueue( ) {

	$this->plugin->component( 'Core_Scripts' )->register_scripts();

    wp_enqueue_style( 'cs-generator-css' , CS()->css( 'admin/generator' ), array(), CS()->version() );

    wp_register_script( 'cs-generator', CS()->js( 'admin/generator' ), array( 'backbone', 'jquery-ui-core', 'jquery-ui-accordion' ), CS()->version(), true );
    wp_localize_script( 'cs-generator', 'csgData', $this->getData() ) ;
    wp_enqueue_script( 'cs-generator' );

  }

  public function getData() {
    return array(
      'shortcodeCollectionUrl' => add_query_arg( array( 'action' => 'csg_list_shortcodes' ), admin_url( 'admin-ajax.php' ) ),
      'sectionNames'           => $this->get_sections(),
      'previewContentBefore' => $this->getPreviewContentBefore(),
      'previewContentAfter' => $this->getPreviewContentAfter(),
      'strings' => CS()->i18n_group( 'generator', false )
    );
  }

  public function getPreviewContentBefore() {
    ob_start();
    do_action('cornerstone_generator_preview_before');
    return ob_get_clean();
  }

  public function getPreviewContentAfter() {
    ob_start();
    do_action('cornerstone_generator_preview_after');
    return ob_get_clean();
  }

  public function previewBefore() {
    return '<p>' . __('Click the button below to check out a live example of this shortcode', 'cornerstone' ) . '</p>';
  }

  public function modelEndpoint() {
    wp_send_json( $this->get_collection() );
  }

  public function addMediaButton( $editor_id ) {
    $this->enqueue();
    $title = sprintf( __( 'Insert Shortcodes', 'cornerstone' ) );
    $contents = CS()->view( 'svg/nav-elements-solid', false );
    echo "<button href=\"#\" title=\"{$title}\" id=\"cs-insert-shortcode-button\" class=\"button cs-insert-btn\">{$contents}</button>";
  }


  public function add( $attributes ) {

    $attributes = apply_filters( 'cornerstone_generator_map', $attributes );

    if ( !isset($attributes['id'])|| !is_string($attributes['id']) ) {
      return _doing_it_wrong( 'xsg_add', 'Invalid `id` attribute', '2.7' );
    }

    $this->shortcodes[$attributes['id']] = $attributes;

    if ( isset($attributes['section']) && !in_array( $attributes['section'], $this->sections) )
      array_push($this->sections, $attributes['section']);

  }

  public function remove( $id ) {
    if ( is_string($id) && isset($this->shortcodes[$id]) )
      unset($this->shortcodes[$id]);
  }

  public function get( $id = '' ) {
    return isset( $this->shortcodes[$id] ) ? $this->shortcodes[$id] : false;
  }

  public function get_collection() {
	$this->mappings();
    return array_values( $this->shortcodes );
  }

  public function get_sections() {
	$this->mappings();
    return $this->sections;
  }


  //
  // Relegated functions.
  // These will go away when the shortcode generator uses the same
  // controls registered for the page buikder.
  //

  public static function map_default( $args = array() ) {
	return wp_parse_args( $args, array(
	    'param_name'  => 'generic',
	    'heading'     => __( 'Text', 'cornerstone' ),
	    'description' => __( 'Enter your text.', 'cornerstone' ),
	    'type'        => 'textfield',
	    'value'       => ''
	  ) );
  }

  public static function map_default_id( $args = array() ) {
	return wp_parse_args( $args, self::map_default( array(
	    'param_name'  => 'id',
	    'heading'     => __( 'ID', 'cornerstone' ),
	    'description' => __( '(Optional) Enter a unique ID.', 'cornerstone' ),
	    'type'        => 'textfield',
	    'advanced'    => true
	  ) ) );
  }

  public static function map_default_class( $args = array() ) {
	return wp_parse_args( $args, self::map_default( array(
	    'param_name'  => 'class',
	    'heading'     => __( 'Class', 'cornerstone' ),
	    'description' => __( '(Optional) Enter a unique class name.', 'cornerstone' ),
	    'type'        => 'textfield',
	    'advanced'    => true
	  ) ) );
  }

  public static function map_default_style( $args = array() ) {
	return wp_parse_args( $args, self::map_default( array(
	    'param_name'  => 'style',
	    'heading'     => __( 'Style', 'cornerstone' ),
	    'description' => __( '(Optional) Enter inline CSS.', 'cornerstone' ),
	    'type'        => 'textfield',
	    'advanced'    => true
	  ) ) );
  }





  public function mappings() {

	if ( $this->mapped ) return;

	$this->mapped = true;

		//
		// These mappings will eventually be removed entirely, and the shortcode
		// generator will use the same controls registered for the page builder.
		//

		//
		// Horizontal rule.
		//

		$this->add(
		  array(
		    'id'        => 'x_line',
		    'title'        => __( 'Line', 'cornerstone' ),
		    'section'    => __( 'Structure', 'cornerstone' ),
		    'description' => __( 'Place a horizontal rule in your content', 'cornerstone' ),
		    'demo' => 'http://theme.co/x/demo/integrity/1/shortcodes/line/',
		    'params'      => array(
		      self::map_default_id( array( 'advanced' => false ) ),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Gap.
		//

		$this->add(
		  array(
		    'id'        => 'x_gap',
		    'title'        => __( 'Gap', 'cornerstone' ),
		    'section'    => __( 'Structure', 'cornerstone' ),
		    'description' => __( 'Insert a vertical gap in your content', 'cornerstone' ),
		    'demo' => 'http://theme.co/x/demo/integrity/1/shortcodes/gap/',
		  'params'      => array(
		      array(
		        'param_name'  => 'size',
		        'heading'     => __( 'Size', 'cornerstone' ),
		        'description' => __( 'Enter in the size of your gap. Pixels, ems, and percentages are all valid units of measurement.', 'cornerstone' ),
		        'type'        => 'textfield',
		        'value'       => '1.313em'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style(),
		    )
		  )
		);


		//
		// Clear.
		//

		$this->add(
		  array(
		    'id'        => 'x_clear',
		    'title'        => __( 'Clear', 'cornerstone' ),
		    'section'    => __( 'Structure', 'cornerstone' ),
		    'description' => __( 'Clear floated elements in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/clear/',
		  'params'      => array(
		      self::map_default_id( array( 'advanced' => false) ),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Blockquote.
		//

		$this->add(
		  array(
		    'id'        => 'x_blockquote',
		    'title'        => __( 'Blockquote', 'cornerstone' ),
		    'section'    => __( 'Typography', 'cornerstone' ),
		    'description' => __( 'Include a blockquote in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/blockquote/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'cite',
		        'heading'     => __( 'Cite', 'cornerstone' ),
		        'description' => __( 'Cite the person you are quoting.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Alignment', 'cornerstone' ),
		        'description' => __( 'Select the alignment of the blockquote.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'Left'   => 'left',
		          'Center' => 'center',
		          'Right'  => 'right'
		        )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Pullquote.
		//

		$this->add(
		  array(
		    'id'        => 'x_pullquote',
		    'title'        => __( 'Pullquote', 'cornerstone' ),
		    'section'    => __( 'Typography', 'cornerstone' ),
		    'description' => __( 'Include a pullquote in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/pullquote/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'cite',
		        'heading'     => __( 'Cite', 'cornerstone' ),
		        'description' => __( 'Cite the person you are quoting.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Alignment', 'cornerstone' ),
		        'description' => __( 'Select the alignment of the pullquote.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'Left'   => 'left',
		          'Right'  => 'right'
		        )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style(),
		    )
		  )
		);


		//
		// Alert.
		//

		$this->add(
		  array(
		    'id'        => 'x_alert',
		    'title'        => __( 'Alert', 'cornerstone' ),
		    'section'    => __( 'Information', 'cornerstone' ),
		    'description' => __( 'Provide information to users with alerts', 'cornerstone' ),
		    'demo' => 'http://theme.co/x/demo/integrity/1/shortcodes/alert/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'heading',
		        'heading'     => __( 'Heading', 'cornerstone' ),
		        'description' => __( 'Enter the heading of your alert.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Type', 'cornerstone' ),
		        'description' => __( 'Select the alert style.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'Success' => 'success',
		          'Info'    => 'info',
		          'Warning' => 'warning',
		          'Danger'  => 'danger',
		          'Muted'   => 'muted'
		        )
		      ),
		      array(
		        'param_name'  => 'close',
		        'heading'     => __( 'Close', 'cornerstone' ),
		        'description' => __( 'Select to display the close button.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Map.
		//

		$this->add(
		  array(
		    'id'        => 'x_map',
		    'title'        => __( 'Map (Embed)', 'cornerstone' ),
		    'section'    => __( 'Media', 'cornerstone' ),
		    'description' => __( 'Embed a map from a third-party provider', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/map/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Code (See Notes Below)', 'cornerstone' ),
		        'description' => __( 'Switch to the "text" editor and do not place anything else here other than your &lsaquo;iframe&rsaquo; or &lsaquo;embed&rsaquo; code.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'no_container',
		        'heading'     => __( 'No Container', 'cornerstone' ),
		        'description' => __( 'Select to remove the container around the map.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style(),
		    )
		  )
		);


		//
		// Google map.
		//

		$this->add(
		  array(
		    'id'            => 'x_google_map',
		    'container' => true,
		    'title'            => __( 'Google Map', 'cornerstone' ),
		    'weight'          => 530,
		    'icon'            => 'google-map',
		    'section'        => __( 'Media', 'cornerstone' ),
		    'description'     => __( 'Embed a customizable Google map', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/map/',
		  'params'          => array(
		      array(
		        'param_name'  => 'lat',
		        'heading'     => __( 'Latitude', 'cornerstone' ),
		        'description' => __( 'Enter in the center latitude of your map.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'lng',
		        'heading'     => __( 'Longitude', 'cornerstone' ),
		        'description' => __( 'Enter in the center longitude of your map.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'drag',
		        'heading'     => __( 'Draggable', 'cornerstone' ),
		        'description' => __( 'Select to allow your users to drag the map view.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'zoom',
		        'heading'     => __( 'Zoom Level', 'cornerstone' ),
		        'description' => __( 'Choose the initial zoom level of your map. This value should be between 1 and 18. 1 is fully zoomed out and 18 is right at street level.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'zoom_control',
		        'heading'     => __( 'Zoom Control', 'cornerstone' ),
		        'description' => __( 'Select to activate the zoom control for the map.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'height',
		        'heading'     => __( 'Height', 'cornerstone' ),
		        'description' => __( 'Choose an optional height for your map. If no height is selected, a responsive, proportional unit will be used. Any type of unit is acceptable (e.g. 450px, 30em, 40%, et cetera).', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'hue',
		        'heading'     => __( 'Custom Color', 'cornerstone' ),
		        'description' => __( 'Choose an optional custom color for your map.', 'cornerstone' ),
		        'type'        => 'colorpicker',
		      ),
		      array(
		        'param_name'  => 'no_container',
		        'heading'     => __( 'No Container', 'cornerstone' ),
		        'description' => __( 'Select to remove the container around the map.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      self::map_default_class(),
		      self::map_default_style(),
		    )
		  )
		);


		//
		// Google map marker.
		//

		$this->add(
		  array(
		    'id'            => 'x_google_map_marker',
		    'title'            => __( 'Google Map Marker', 'cornerstone' ),
		    'weight'          => 530,
		    'icon'            => 'google-map-marker',
		    'section'        => __( 'Media', 'cornerstone' ),
		    'description'     => __( 'Place a location marker on your Google map', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/map/',
		  'params'          => array(
		      array(
		        'param_name'  => 'lat',
		        'heading'     => __( 'Latitude', 'cornerstone' ),
		        'description' => __( 'Enter in the latitude of your marker.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'lng',
		        'heading'     => __( 'Longitude', 'cornerstone' ),
		        'description' => __( 'Enter in the longitude of your marker.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'info',
		        'heading'     => __( 'Additional Information', 'cornerstone' ),
		        'description' => __( 'Optional description text to appear in a popup when your marker is clicked on.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'image',
		        'heading'     => __( 'Custom Marker Image', 'cornerstone' ),
		        'description' => __( 'Utilize a custom marker image instead of the default provided by Google.', 'cornerstone' ),
		        'type'        => 'attach_image',
		      ),
		    )
		  )
		);


		//
		// Skill bar.
		//

		$this->add(
		  array(
		    'id'        => 'x_skill_bar',
		    'title'        => __( 'Skill Bar', 'cornerstone' ),
		    'section'    => __( 'Information', 'cornerstone' ),
		    'description' => __( 'Include an informational skill bar', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/skill-bar/',
		  'params'      => array(
		      array(
		        'param_name'  => 'heading',
		        'heading'     => __( 'Heading', 'cornerstone' ),
		        'description' => __( 'Enter the heading of your skill bar.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'percent',
		        'heading'     => __( 'Percent', 'cornerstone' ),
		        'description' => __( 'Enter the percentage of your skill and be sure to include the percentage sign (i.e. 90%).', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'bar_text',
		        'heading'     => __( 'Bar Text', 'cornerstone' ),
		        'description' => __( 'Enter in some alternate text in place of the percentage inside the skill bar.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Code.
		//

		$this->add(
		  array(
		    'id'        => 'x_code',
		    'title'        => __( 'Code', 'cornerstone' ),
		    'section'    => __( 'Typography', 'cornerstone' ),
		    'description' => __( 'Add a block of example code to your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/code/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Buttons.
		//

		$this->add(
		  array(
		    'id'        => 'x_button',
		    'title'        => __( 'Button', 'cornerstone' ),
		    'section'    => __( 'Marketing', 'cornerstone' ),
		    'description' => __( 'Add a clickable button to your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/buttons',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => '',
		      ),
		      array(
		        'param_name'  => 'shape',
		        'heading'     => __( 'Shape', 'cornerstone' ),
		        'description' => __( 'Select the button shape.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'Square'  => 'square',
		          'Rounded' => 'rounded',
		          'Pill'    => 'pill'
		        )
		      ),
		      array(
		        'param_name'  => 'size',
		        'heading'     => __( 'Size', 'cornerstone' ),
		        'description' => __( 'Select the button size.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Mini'        => 'mini',
		          'Small'       => 'small',
		          'Standard'    => 'regular',
		          'Large'       => 'large',
		          'Extra Large' => 'x-large',
		          'Jumbo'       => 'jumbo'
		        )
		      ),
		      array(
		        'param_name'  => 'float',
		        'heading'     => __( 'Float', 'cornerstone' ),
		        'description' => __( 'Optionally float the button.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'None'  => 'none',
		          'Left'  => 'left',
		          'Right' => 'right'
		        )
		      ),
		      array(
		        'param_name'  => 'block',
		        'heading'     => __( 'Block', 'cornerstone' ),
		        'description' => __( 'Select to make your button go fullwidth.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'circle',
		        'heading'     => __( 'Marketing Circle', 'cornerstone' ),
		        'description' => __( 'Select to include a marketing circle around your button.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'icon_only',
		        'heading'     => __( 'Icon Only', 'cornerstone' ),
		        'description' => __( 'Select if you are only using an icon in your button.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'href',
		        'heading'     => __( 'Href', 'cornerstone' ),
		        'description' => __( 'Enter in the URL you want your button to link to.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Enter in the title attribute you want for your button (will also double as title for popover or tooltip if you have chosen to display one).', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'target',
		        'heading'     => __( 'Target', 'cornerstone' ),
		        'description' => __( 'Select to open your button link in a new window.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'blank'
		      ),
		      array(
		        'param_name'  => 'info',
		        'heading'     => __( 'Info', 'cornerstone' ),
		        'description' => __( 'Select whether or not you want to add a popover or tooltip to your button.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'None'    => 'none',
		          'Popover' => 'popover',
		          'Tooltip' => 'tooltip'
		        )
		      ),
		      array(
		        'param_name'  => 'info_place',
		        'heading'     => __( 'Info Placement', 'cornerstone' ),
		        'description' => __( 'Select where you want your popover or tooltip to appear.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Top'    => 'top',
		          'Left'   => 'left',
		          'Right'  => 'right',
		          'Bottom' => 'bottom'
		        )
		      ),
		      array(
		        'param_name'  => 'info_trigger',
		        'heading'     => __( 'Info Trigger', 'cornerstone' ),
		        'description' => __( 'Select what actions you want to trigger the popover or tooltip.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Hover' => 'hover',
		          'Click' => 'click',
		          'Focus' => 'focus'
		        )
		      ),
		      array(
		        'param_name'  => 'info_content',
		        'heading'     => __( 'Info Content', 'cornerstone' ),
		        'description' => __( 'Extra content for the popover.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'lightbox_thumb',
		        'heading'     => __( 'Lightbox Thumbnail', 'cornerstone' ),
		        'description' => __( 'Use this option to select a thumbnail for your lightbox thumbnail navigation or to set an image if you are linking out to a video.', 'cornerstone' ),
		        'type'        => 'attach_image',

		      ),
		      array(
		        'param_name'  => 'lightbox_video',
		        'heading'     => __( 'Lightbox Video', 'cornerstone' ),
		        'description' => __( 'Select if you are linking to a video from this button in the lightbox.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'lightbox_caption',
		        'heading'     => __( 'Lightbox Caption', 'cornerstone' ),
		        'description' => __( 'Lightbox caption text.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Block grid.
		//

		$this->add(
		  array(
		    'id'            => 'x_block_grid',
		    'container' => true,
		    'title'            => __( 'Block Grid', 'cornerstone' ),
		    'weight'          => 880,
		    'icon'            => 'block-grid',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Include a block grid container in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/block-grid/',
		  'params'          => array(
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Type', 'cornerstone' ),
		        'description' => __( 'Select how many block grid items you want per row.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'Two'   => 'two-up',
		          'Three' => 'three-up',
		          'Four'  => 'four-up',
		          'Five'  => 'five-up'
		        )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Block grid item.
		//

		$this->add(
		  array(
		    'id'            => 'x_block_grid_item',
		    'title'            => __( 'Block Grid Item', 'cornerstone' ),
		    'weight'          => 870,
		    'icon'            => 'block-grid-item',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Include a block grid item in your block grid', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/block-grid/',
		  'params'          => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Images.
		//

		$this->add(
		  array(
		    'id'        => 'x_image',
		    'title'        => __( 'Image', 'cornerstone' ),
		    'section'    => __( 'Media', 'cornerstone' ),
		    'description' => __( 'Include an image in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/images/',
		  'params'      => array(
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Style', 'cornerstone' ),
		        'description' => __( 'Select the image style.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'None'      => 'none',
		          'Thumbnail' => 'thumbnail',
		          'Rounded'   => 'rounded',
		          'Circle'    => 'circle'
		        )
		      ),
		      array(
		        'param_name'  => 'float',
		        'heading'     => __( 'Float', 'cornerstone' ),
		        'description' => __( 'Optionally float the image.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'None'  => 'none',
		          'Left'  => 'left',
		          'Right' => 'right'
		        )
		      ),
		      array(
		        'param_name'  => 'src',
		        'heading'     => __( 'Src', 'cornerstone' ),
		        'description' => __( 'Enter your image.', 'cornerstone' ),
		        'type'        => 'attach_image',
		      ),
		      array(
		        'param_name'  => 'alt',
		        'heading'     => __( 'Alt', 'cornerstone' ),
		        'description' => __( 'Enter in the alt text for your image.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'link',
		        'heading'     => __( 'Link', 'cornerstone' ),
		        'description' => __( 'Select to wrap your image in an anchor tag.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'href',
		        'heading'     => __( 'Href', 'cornerstone' ),
		        'description' => __( 'Enter in the URL you want your image to link to. If using this image for a lightbox, enter the URL of your media here (e.g. YouTube embed URL, et cetera). Leave this field blank if you want to link to the image uploaded to the "Src" for your lightbox.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Enter in the title attribute you want for your image (will also double as title for popover or tooltip if you have chosen to display one).', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'target',
		        'heading'     => __( 'Target', 'cornerstone' ),
		        'description' => __( 'Select to open your image link in a new window.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'blank'
		      ),
		      array(
		        'param_name'  => 'info',
		        'heading'     => __( 'Info', 'cornerstone' ),
		        'description' => __( 'Select whether or not you want to add a popover or tooltip to your image.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'None'    => 'none',
		          'Popover' => 'popover',
		          'Tooltip' => 'tooltip'
		        )
		      ),
		      array(
		        'param_name'  => 'info_place',
		        'heading'     => __( 'Info Placement', 'cornerstone' ),
		        'description' => __( 'Select where you want your popover or tooltip to appear.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'Top'    => 'top',
		          'Left'   => 'left',
		          'Right'  => 'right',
		          'Bottom' => 'bottom'
		        )
		      ),
		      array(
		        'param_name'  => 'info_trigger',
		        'heading'     => __( 'Info Trigger', 'cornerstone' ),
		        'description' => __( 'Select what actions you want to trigger the popover or tooltip.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'Hover' => 'hover',
		          'Click' => 'click',
		          'Focus' => 'focus'
		        )
		      ),
		      array(
		        'param_name'  => 'info_content',
		        'heading'     => __( 'Info Content', 'cornerstone' ),
		        'description' => __( 'Extra content for the popover.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'lightbox_thumb',
		        'heading'     => __( 'Lightbox Thumbnail', 'cornerstone' ),
		        'description' => __( 'Use this option to select a different thumbnail for your lightbox thumbnail navigation or to set an image if you are linking out to a video. Will default to the "Src" image if nothing is set.', 'cornerstone' ),
		        'type'        => 'attach_image',
		      ),
		      array(
		        'param_name'  => 'lightbox_video',
		        'heading'     => __( 'Lightbox Video', 'cornerstone' ),
		        'description' => __( 'Select if you are linking to a video from this image in the lightbox.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'lightbox_caption',
		        'heading'     => __( 'Lightbox Caption', 'cornerstone' ),
		        'description' => __( 'Lightbox caption text.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'id',
		        'heading'     => __( 'ID', 'cornerstone' ),
		        'description' => __( '(Optional) Enter a unique ID.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Icon list.
		//

		$this->add(
		  array(
		    'id'            => 'x_icon_list',
		    'container' => true,
		    'title'            => __( 'Icon List', 'cornerstone' ),
		    'weight'          => 780,
		    'icon'            => 'icon-list',
		    'section'        => __( 'Typography', 'cornerstone' ),
		    'description'     => __( 'Include an icon list in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/icon-list/',
		  'params'          => array(
		      self::map_default_id( array( 'advanced' => false) ),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Icon list item.
		//

		$this->add(
		  array(
		    'id'            => 'x_icon_list_item',
		    'title'            => __( 'Icon List Item', 'cornerstone' ),
		    'weight'          => 770,
		    'icon'            => 'icon-list-item',
		    'section'        => __( 'Typography', 'cornerstone' ),
		    'description'     => __( 'Include an icon list item in your icon list', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/icon-list/',
		  'params'          => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Type', 'cornerstone' ),
		        'description' => __( 'Select your icon.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array_keys( fa_all_unicode() )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);



		//
		// Text columns.
		//

		$this->add(
		  array(
		    'id'        => 'x_columnize',
		    'title'        => __( 'Columnize', 'cornerstone' ),
		    'section'    => __( 'Content', 'cornerstone' ),
		    'description' => __( 'Split your text into multiple columns', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/columnize/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Video player.
		//

		$this->add(
		  array(
		    'id'        => 'x_video_player',
		    'title'        => __( 'Video (Self Hosted)', 'cornerstone' ),
		    'section'    => __( 'Media', 'cornerstone' ),
		    'description' => __( 'Include responsive video into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/responsive-video/',
		  'params'      => array(
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Aspect Ratio', 'cornerstone' ),
		        'description' => __( 'Select your aspect ratio.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          '16:9' => '16:9',
		          '5:3'  => '5:3',
		          '5:4'  => '5:4',
		          '4:3'  => '4:3',
		          '3:2'  => '3:2'
		        )
		      ),
		      array(
		        'param_name'  => 'm4v',
		        'heading'     => __( 'M4V', 'cornerstone' ),
		        'description' => __( 'Include and .m4v version of your video.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'ogv',
		        'heading'     => __( 'OGV', 'cornerstone' ),
		        'description' => __( 'Include and .ogv version of your video for additional native browser support.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'poster',
		        'heading'     => __( 'Poster Image', 'cornerstone' ),
		        'description' => __( 'Include a poster image for your self-hosted video.', 'cornerstone' ),
		        'type'        => 'attach_image',
		      ),
		      array(
		        'param_name'  => 'hide_controls',
		        'heading'     => __( 'Hide Controls', 'cornerstone' ),
		        'description' => __( 'Select to hide the controls on your self-hosted video.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'autoplay',
		        'heading'     => __( 'Autoplay', 'cornerstone' ),
		        'description' => __( 'Select to automatically play your self-hosted video.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'no_container',
		        'heading'     => __( 'No Container', 'cornerstone' ),
		        'description' => __( 'Select to remove the container around the video.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Video embed.
		//

		$this->add(
		  array(
		    'id'        => 'x_video_embed',
		    'title'        => __( 'Video (Embedded)', 'cornerstone' ),
		    'section'    => __( 'Media', 'cornerstone' ),
		    'description' => __( 'Include responsive video into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/responsive-video/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Code (See Notes Below)', 'cornerstone' ),
		        'description' => __( 'Switch to the "text" editor and do not place anything else here other than your &lsaquo;iframe&rsaquo; or &lsaquo;embed&rsaquo; code.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Aspect Ratio', 'cornerstone' ),
		        'description' => __( 'Select your aspect ratio.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          '16:9' => '16:9',
		          '5:3'  => '5:3',
		          '5:4'  => '5:4',
		          '4:3'  => '4:3',
		          '3:2'  => '3:2'
		        )
		      ),
		      array(
		        'param_name'  => 'no_container',
		        'heading'     => __( 'No Container', 'cornerstone' ),
		        'description' => __( 'Select to remove the container around the video.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Accordion.
		//

		$this->add(
		  array(
		    'id'            => 'x_accordion',
		    'container' => true,
		    'title'            => __( 'Accordion', 'cornerstone' ),
		    'weight'          => 930,
		    'icon'            => 'accordion',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Include an accordion into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/accordion/',
		  'params'          => array(
		      self::map_default_id( array( 'advanced' => false) ),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Accordion item.
		//

		$this->add(
		  array(
		    'id'            => 'x_accordion_item',
		    'title'            => __( 'Accordion Item', 'cornerstone' ),
		    'weight'          => 940,
		    'icon'            => 'accordion-item',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Include an accordion item in your accordion', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/accordion/',
		  'params'          => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'parent_id',
		        'heading'     => __( 'Parent ID', 'cornerstone' ),
		        'description' => __( 'Optionally include an ID given to the parent accordion to only allow one toggle to be open at a time.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Include a title for your accordion item.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'open',
		        'heading'     => __( 'Open', 'cornerstone' ),
		        'description' => __( 'Select for your accordion item to be open by default.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Tab nav.
		//

		$this->add(
		  array(
		    'id'            => 'x_tab_nav',
		    'container' => true,
		    'title'            => __( 'Tab Nav', 'cornerstone' ),
		    'weight'          => 920,
		    'icon'            => 'tab-nav',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Include a tab nav into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/tabbed-content/',
		  'params'          => array(
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Tab Nav Items Per Row', 'cornerstone' ),
		        'description' => __( 'If your tab nav is on top, select how many tab nav items you want per row.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'Two'   => 'two-up',
		          'Three' => 'three-up',
		          'Four'  => 'four-up',
		          'Five'  => 'five-up'
		        )
		      ),
		      array(
		        'param_name'  => 'float',
		        'heading'     => __( 'Tab Nav Position', 'cornerstone' ),
		        'description' => __( 'Select the position of your tab nav.', 'cornerstone' ),
		        'type'        => 'dropdown',
		        'value'       => array(
		          'None'  => 'none',
		          'Left'  => 'left',
		          'Right' => 'right'
		        )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Tab nav item.
		//

		$this->add(
		  array(
		    'id'            => 'x_tab_nav_item',
		    'title'            => __( 'Tab Nav Item', 'cornerstone' ),
		    'weight'          => 910,
		    'icon'            => 'tab-nav-item',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Include a tab nav item into your tab nav', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/tabbed-content/',
		  'params'          => array(
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Include a title for your tab nav item.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      array(
		        'param_name'  => 'active',
		        'heading'     => __( 'Active', 'cornerstone' ),
		        'description' => __( 'Select to make this tab nav item active.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Tabs.
		//

		$this->add(
		  array(
		    'id'            => 'x_tabs',
		    'container' => true,
		    'title'            => __( 'Tabs', 'cornerstone' ),
		    'weight'          => 900,
		    'icon'            => 'tabs',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Include a tabs container after your tab nav', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/tabbed-content/',
		  'params'          => array(
		      array(
		        'param_name'  => 'id',
		        'heading'     => __( 'ID', 'cornerstone' ),
		        'description' => __( '(Optional) Enter a unique ID.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Tab.
		//

		$this->add(
		  array(
		    'id'            => 'x_tab',
		    'title'            => __( 'Tab', 'cornerstone' ),
		    'weight'          => 890,
		    'icon'            => 'tab',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Include a tab into your tabs container', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/tabbed-content/',
		  'params'          => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',
		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'active',
		        'heading'     => __( 'Active', 'cornerstone' ),
		        'description' => __( 'Select to make this tab active.', 'cornerstone' ),
		        'type'        => 'checkbox',
		        'value'       => 'true'
		      ),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Responsive visibility.
		//

		$this->add(
		  array(
		    'id'            => 'x_visibility',
		    'container' => true,
		    'title'            => __( 'Visibility', 'cornerstone' ),
		    'weight'          => 850,
		    'icon'            => 'visibility',
		    'section'        => __( 'Content', 'cornerstone' ),
		    'description'     => __( 'Alter content based on screen size', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/responsive-visibility/',
		  'params'          => array(
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Visibility Type', 'cornerstone' ),
		        'description' => __( 'Select how you want to hide or show your content.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Hidden Phone'    => 'hidden-phone',
		          'Hidden Tablet'   => 'hidden-tablet',
		          'Hidden Desktop'  => 'hidden-desktop',
		          'Visible Phone'   => 'visible-phone',
		          'Visible Tablet'  => 'visible-tablet',
		          'Visible Desktop' => 'visible-desktop'
		        )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Slider.
		//

		$this->add(
		  array(
		    'id'            => 'x_slider',
		    'container' => true,
		    'title'            => __( 'Slider', 'cornerstone' ),
		    'weight'          => 590,
		    'icon'            => 'slider',
		    'section'        => __( 'Media', 'cornerstone' ),
		    'description'     => __( 'Include a slider in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/responsive-slider/',
		  'params'          => array(
		      array(
		        'param_name'  => 'animation',
		        'heading'     => __( 'Animation', 'cornerstone' ),
		        'description' => __( 'Select your slider animation.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Slide' => 'slide',
		          'Fade'  => 'fade'
		        )
		      ),
		      array(
		        'param_name'  => 'slide_time',
		        'heading'     => __( 'Slide Time', 'cornerstone' ),
		        'description' => __( 'The amount of time a slide will stay visible in milliseconds.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => '5000'
		      ),
		      array(
		        'param_name'  => 'slide_speed',
		        'heading'     => __( 'Slide Speed', 'cornerstone' ),
		        'description' => __( 'The amount of time to transition between slides in milliseconds.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => '650'
		      ),
		      array(
		        'param_name'  => 'slideshow',
		        'heading'     => __( 'Slideshow', 'cornerstone' ),
		        'description' => __( 'Select for your slides to advance automatically.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'random',
		        'heading'     => __( 'Random', 'cornerstone' ),
		        'description' => __( 'Select to randomly display your slides each time the page loads.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'control_nav',
		        'heading'     => __( 'Control Navigation', 'cornerstone' ),
		        'description' => __( 'Select to display the control navigation.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'prev_next_nav',
		        'heading'     => __( 'Previous/Next Navigation', 'cornerstone' ),
		        'description' => __( 'Select to display the previous/next navigation.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'no_container',
		        'heading'     => __( 'No Container', 'cornerstone' ),
		        'description' => __( 'Select to remove the container from your slider.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Slide.
		//

		$this->add(
		  array(
		    'id'            => 'x_slide',
		    'title'            => __( 'Slide', 'cornerstone' ),
		    'weight'          => 600,
		    'icon'            => 'slide',
		    'section'        => __( 'Media', 'cornerstone' ),
		    'description'     => __( 'Include a slide into your slider', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/responsive-slider/',
		  'params'          => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',

		        'value'       => ''
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Protected content.
		//

		$this->add(
		  array(
		    'id'        => 'x_protect',
		    'title'        => __( 'Protect', 'cornerstone' ),
		    'section'    => __( 'Content', 'cornerstone' ),
		    'description' => __( 'Protect content from non logged in users', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/protected-content/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',

		        'value'       => ''
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Recent posts.
		//

		$this->add(
		  array(
		    'id'        => 'x_recent_posts',
		    'title'        => __( 'Recent Posts', 'cornerstone' ),
		    'section'    => __( 'Social', 'cornerstone' ),
		    'description' => __( 'Display your most recent posts', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/recent-posts/',
		  'params'      => array(
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Post Type', 'cornerstone' ),
		        'description' => __( 'Choose between standard posts or portfolio posts.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Posts'     => 'post',
		          'Portfolio' => 'portfolio'
		        )
		      ),
		      array(
		        'param_name'  => 'count',
		        'heading'     => __( 'Post Count', 'cornerstone' ),
		        'description' => __( 'Select how many posts to display.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          '1' => '1',
		          '2' => '2',
		          '3' => '3',
		          '4' => '4'
		        )
		      ),
		      array(
		        'param_name'  => 'offset',
		        'heading'     => __( 'Offset', 'cornerstone' ),
		        'description' => __( 'Enter a number to offset initial starting post of your recent posts.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'category',
		        'heading'     => __( 'Category', 'cornerstone' ),
		        'description' => __( 'To filter your posts by category, enter in the slug of your desired category. To filter by multiple categories, enter in your slugs separated by a comma.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'orientation',
		        'heading'     => __( 'Orientation', 'cornerstone' ),
		        'description' => __( 'Select the orientation or your recent posts.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Horizontal' => 'horizontal',
		          'Vertical'   => 'vertical'
		        )
		      ),
		      array(
		        'param_name'  => 'no_image',
		        'heading'     => __( 'Remove Featured Image', 'cornerstone' ),
		        'description' => __( 'Select to remove the featured image.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'fade',
		        'heading'     => __( 'Fade Effect', 'cornerstone' ),
		        'description' => __( 'Select to activate the fade effect.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Audio player.
		//

		$this->add(
		  array(
		    'id'        => 'x_audio_player',
		    'title'        => __( 'Audio (Self Hosted)', 'cornerstone' ),
		    'section'    => __( 'Media', 'cornerstone' ),
		    'description' => __( 'Place audio files into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/audio/',
		  'params'      => array(
		      array(
		        'param_name'  => 'mp3',
		        'heading'     => __( 'MP3', 'cornerstone' ),
		        'description' => __( 'Include and .mp3 version of your audio.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'oga',
		        'heading'     => __( 'OGA', 'cornerstone' ),
		        'description' => __( 'Include and .oga version of your audio for additional native browser support.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Audio embed.
		//

		$this->add(
		  array(
		    'id'        => 'x_audio_embed',
		    'title'        => __( 'Audio (Embedded)', 'cornerstone' ),
		    'section'    => __( 'Media', 'cornerstone' ),
		    'description' => __( 'Place audio files into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/audio/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Code (See Notes Below)', 'cornerstone' ),
		        'description' => __( 'Switch to the "text" editor and do not place anything else here other than your &lsaquo;iframe&rsaquo; or &lsaquo;embed&rsaquo; code.', 'cornerstone' ),
		        'type'        => 'textarea_html',

		        'value'       => ''
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Pricing table.
		//

		$this->add(
		  array(
		    'id'            => 'x_pricing_table',
		    'container' => true,
		    'title'            => __( 'Pricing Table', 'cornerstone' ),
		    'weight'          => 680,
		    'icon'            => 'pricing-table',
		    'section'        => __( 'Marketing', 'cornerstone' ),
		    'description'     => __( 'Include a pricing table in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/responsive-pricing-table/',
		  'params'          => array(
		      array(
		        'param_name'  => 'columns',
		        'heading'     => __( 'Columns', 'cornerstone' ),
		        'description' => __( 'Select how many columns you want for your pricing table.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          '1' => '1',
		          '2' => '2',
		          '3' => '3',
		          '4' => '4',
		          '5' => '5'
		        )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Pricing table column.
		//

		$this->add(
		  array(
		    'id'            => 'x_pricing_table_column',
		    'title'            => __( 'Pricing Table Column', 'cornerstone' ),
		    'weight'          => 670,
		    'icon'            => 'pricing-table-column',
		    'section'        => __( 'Marketing', 'cornerstone' ),
		    'description'     => __( 'Include a pricing table column', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/responsive-pricing-table/',
		  'params'          => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',

		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Include a title for your pricing column.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'featured',
		        'heading'     => __( 'Featured', 'cornerstone' ),
		        'description' => __( 'Select to make this your featured offer.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'featured_sub',
		        'heading'     => __( 'Featured Sub Heading', 'cornerstone' ),
		        'description' => __( 'Include a sub heading for your featured column.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'currency',
		        'heading'     => __( 'Currency Symbol', 'cornerstone' ),
		        'description' => __( 'Enter in the currency symbol you want to use.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'price',
		        'heading'     => __( 'Price', 'cornerstone' ),
		        'description' => __( 'Enter in the price for this pricing column.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'interval',
		        'heading'     => __( 'Interval', 'cornerstone' ),
		        'description' => __( 'Enter in the time period that this pricing column is for.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => 'Per Month'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Callout.
		//

		$this->add(
		  array(
		    'id'        => 'x_callout',
		    'title'        => __( 'Callout', 'cornerstone' ),
		    'section'    => __( 'Marketing', 'cornerstone' ),
		    'description' => __( 'Include a marketing callout into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/callout/',
		  'params'      => array(
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Alignment', 'cornerstone' ),
		        'description' => __( 'Select the alignment for your callout.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Left'   => 'left',
		          'Center' => 'center',
		          'Right'  => 'right'
		        )
		      ),
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Enter the title for your callout.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'message',
		        'heading'     => __( 'Message', 'cornerstone' ),
		        'description' => __( 'Enter the message for your callout.', 'cornerstone' ),
		        'type'        => 'textarea',

		      ),
		      array(
		        'param_name'  => 'button_text',
		        'heading'     => __( 'Button Text', 'cornerstone' ),
		        'description' => __( 'Enter the text for your callout button.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'button_icon',
		        'heading'     => __( 'Button Icon', 'cornerstone' ),
		        'description' => __( 'Optionally enter the button icon.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array_keys( fa_all_unicode() )
		      ),
		      array(
		        'param_name'  => 'circle',
		        'heading'     => __( 'Marketing Circle', 'cornerstone' ),
		        'description' => __( 'Select to include a marketing circle around your button.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'href',
		        'heading'     => __( 'Href', 'cornerstone' ),
		        'description' => __( 'Enter in the URL you want your callout button to link to.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'target',
		        'heading'     => __( 'Target', 'cornerstone' ),
		        'description' => __( 'Select to open your callout link button in a new window.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'blank'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Promo.
		//

		$this->add(
		  array(
		    'id'        => 'x_promo',
		    'title'        => __( 'Promo', 'cornerstone' ),
		    'section'    => __( 'Marketing', 'cornerstone' ),
		    'description' => __( 'Include a marketing promo in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/promo/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',

		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'image',
		        'heading'     => __( 'Promo Image', 'cornerstone' ),
		        'description' => __( 'Include an image for your promo element.', 'cornerstone' ),
		        'type'        => 'attach_image',

		      ),
		      array(
		        'param_name'  => 'alt',
		        'heading'     => __( 'Alt', 'cornerstone' ),
		        'description' => __( 'Enter in the alt text for your promo image.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);



		//
		// Post author.
		//

		$this->add(
		  array(
		    'id'        => 'x_author',
		    'title'        => __( 'Author', 'cornerstone' ),
		    'section'    => __( 'Social', 'cornerstone' ),
		    'description' => __( 'Include post author information', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/author',
		  'params'      => array(
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Enter in a title for your author information.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => 'About the Author'
		      ),
		      array(
		        'param_name'  => 'author_id',
		        'heading'     => __( 'Author ID', 'cornerstone' ),
		        'description' => __( 'By default the author of the post or page will be output by leaving this input blank. If you would like to output the information of another author, enter in their user ID here.', 'cornerstone' ),
		        'type'        => 'textfield',
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Prompt.
		//

		$this->add(
		  array(
		    'id'        => 'x_prompt',
		    'title'        => __( 'Prompt', 'cornerstone' ),
		    'section'    => __( 'Marketing', 'cornerstone' ),
		    'description' => __( 'Include a marketing prompt into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/prompt/',
		  'params'      => array(
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Alignment', 'cornerstone' ),
		        'description' => __( 'Select the alignment of your prompt.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Left'  => 'left',
		          'Right' => 'right'
		        )
		      ),
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Enter the title for your prompt.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'message',
		        'heading'     => __( 'Message', 'cornerstone' ),
		        'description' => __( 'Enter the message for your prompt.', 'cornerstone' ),
		        'type'        => 'textarea',

		      ),
		      array(
		        'param_name'  => 'button_text',
		        'heading'     => __( 'Button Text', 'cornerstone' ),
		        'description' => __( 'Enter the text for your prompt button.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'button_icon',
		        'heading'     => __( 'Button Icon', 'cornerstone' ),
		        'description' => __( 'Optionally enter the button icon.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array_keys( fa_all_unicode() )
		      ),
		      array(
		        'param_name'  => 'circle',
		        'heading'     => __( 'Marketing Circle', 'cornerstone' ),
		        'description' => __( 'Select to include a marketing circle around your button.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'href',
		        'heading'     => __( 'Href', 'cornerstone' ),
		        'description' => __( 'Enter in the URL you want your prompt button to link to.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'target',
		        'heading'     => __( 'Target', 'cornerstone' ),
		        'description' => __( 'Select to open your prompt button link in a new window.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'blank'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Entry share.
		//

		$this->add(
		  array(
		    'id'        => 'x_share',
		    'title'        => __( 'Social Sharing', 'cornerstone' ),
		    'section'    => __( 'Social', 'cornerstone' ),
		    'description' => __( 'Include social sharing into your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/entry-share/',
		  'params'      => array(
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Enter in a title for your social links.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => 'Share this Post'
		      ),
		      array(
		        'param_name'  => 'facebook',
		        'heading'     => __( 'Facebook', 'cornerstone' ),
		        'description' => __( 'Select to activate the Facebook sharing link.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'twitter',
		        'heading'     => __( 'Twitter', 'cornerstone' ),
		        'description' => __( 'Select to activate the Twitter sharing link.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'google_plus',
		        'heading'     => __( 'Google Plus', 'cornerstone' ),
		        'description' => __( 'Select to activate the Google Plus sharing link.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'linkedin',
		        'heading'     => __( 'LinkedIn', 'cornerstone' ),
		        'description' => __( 'Select to activate the LinkedIn sharing link.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'pinterest',
		        'heading'     => __( 'Pinterest', 'cornerstone' ),
		        'description' => __( 'Select to activate the Pinterest sharing link.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'reddit',
		        'heading'     => __( 'Reddit', 'cornerstone' ),
		        'description' => __( 'Select to activate the Reddit sharing link.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      array(
		        'param_name'  => 'email',
		        'heading'     => __( 'Email', 'cornerstone' ),
		        'description' => __( 'Select to activate the email sharing link.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Table of contents.
		//

		$this->add(
		  array(
		    'id'            => 'x_toc',
		    'container' => true,
		    'title'            => __( 'Table of Contents', 'cornerstone' ),
		    'weight'          => 630,
		    'icon'            => 'toc',
		    'section'        => __( 'Information', 'cornerstone' ),
		    'description'     => __( 'Include a table of contents in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/table-of-contents/',
		  'params'          => array(
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Set the title of the table of contents.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => 'Table of Contents'
		      ),
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Alignment', 'cornerstone' ),
		        'description' => __( 'Select the alignment of your table of contents.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Left'      => 'left',
		          'Right'     => 'right',
		          'Fullwidth' => 'block'
		        )
		      ),
		      array(
		        'param_name'  => 'columns',
		        'heading'     => __( 'Columns', 'cornerstone' ),
		        'description' => __( 'Select a column count for your links if you have chosen "Fullwidth" as your alignment.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          '1' => '1',
		          '2' => '2',
		          '3' => '3'
		        )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Table of contents item.
		//

		$this->add(
		  array(
		    'id'            => 'x_toc_item',
		    'title'            => __( 'Table of Contents Item', 'cornerstone' ),
		    'weight'          => 620,
		    'icon'            => 'toc-item',
		    'section'        => __( 'Information', 'cornerstone' ),
		    'description'     => __( 'Include a table of contents item', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/table-of-contents/',
		  'params'          => array(
		      array(
		        'param_name'  => 'title',
		        'heading'     => __( 'Title', 'cornerstone' ),
		        'description' => __( 'Set the title of the table of contents item.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'page',
		        'heading'     => __( 'Page', 'cornerstone' ),
		        'description' => __( 'Set the page of the table of contents item.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Custom headline.
		//

		$this->add(
		  array(
		    'id'        => 'x_custom_headline',
		    'title'        => __( 'Custom Headline', 'cornerstone' ),
		    'section'    => __( 'Typography', 'cornerstone' ),
		    'description' => __( 'Include a custom headline in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/custom-headline/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',

		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Alignment', 'cornerstone' ),
		        'description' => __( 'Select which way to align the custom headline.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Left'   => 'left',
		          'Center' => 'center',
		          'Right'  => 'right'
		        )
		      ),
		      array(
		        'param_name'  => 'level',
		        'heading'     => __( 'Heading Level', 'cornerstone' ),
		        'description' => __( 'Select which level to use for your heading (e.g. h2).', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'h1' => 'h1',
		          'h2' => 'h2',
		          'h3' => 'h3',
		          'h4' => 'h4',
		          'h5' => 'h5',
		          'h6' => 'h6'
		        )
		      ),
		      array(
		        'param_name'  => 'looks_like',
		        'heading'     => __( 'Looks Like', 'cornerstone' ),
		        'description' => __( 'Select which level your heading should look like (e.g. h3).', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'h1' => 'h1',
		          'h2' => 'h2',
		          'h3' => 'h3',
		          'h4' => 'h4',
		          'h5' => 'h5',
		          'h6' => 'h6'
		        )
		      ),
		      array(
		        'param_name'  => 'accent',
		        'heading'     => __( 'Accent', 'cornerstone' ),
		        'description' => __( 'Select to activate the heading accent.', 'cornerstone' ),
		        'type'        => 'checkbox',

		        'value'       => 'true'
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);






		//
		// Feature headline.
		//

		$this->add(
		  array(
		    'id'        => 'x_feature_headline',
		    'title'        => __( 'Feature Headline', 'cornerstone' ),
		    'section'    => __( 'Typography', 'cornerstone' ),
		    'description' => __( 'Include a feature headline in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/feature-headline/',
		  'params'      => array(
		      array(
		        'param_name'  => 'content',
		        'heading'     => __( 'Text', 'cornerstone' ),
		        'description' => __( 'Enter your text.', 'cornerstone' ),
		        'type'        => 'textarea_html',

		        'value'       => ''
		      ),
		      array(
		        'param_name'  => 'type',
		        'heading'     => __( 'Alignment', 'cornerstone' ),
		        'description' => __( 'Select which way to align the feature headline.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'Left'   => 'left',
		          'Center' => 'center',
		          'Right'  => 'right'
		        )
		      ),
		      array(
		        'param_name'  => 'level',
		        'heading'     => __( 'Heading Level', 'cornerstone' ),
		        'description' => __( 'Select which level to use for your heading (e.g. h2).', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'h1' => 'h1',
		          'h2' => 'h2',
		          'h3' => 'h3',
		          'h4' => 'h4',
		          'h5' => 'h5',
		          'h6' => 'h6'
		        )
		      ),
		      array(
		        'param_name'  => 'looks_like',
		        'heading'     => __( 'Looks Like', 'cornerstone' ),
		        'description' => __( 'Select which level your heading should look like (e.g. h3).', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array(
		          'h1' => 'h1',
		          'h2' => 'h2',
		          'h3' => 'h3',
		          'h4' => 'h4',
		          'h5' => 'h5',
		          'h6' => 'h6'
		        )
		      ),
		      array(
		        'param_name'  => 'icon',
		        'heading'     => __( 'Icon', 'cornerstone' ),
		        'description' => __( 'Select the icon to use with your feature headline.', 'cornerstone' ),
		        'type'        => 'dropdown',

		        'value'       => array_keys( fa_all_unicode() )
		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Responsive text.
		//

		$this->add(
		  array(
		    'id'        => 'x_responsive_text',
		    'title'        => __( 'Responsive Text', 'cornerstone' ),
		    'section'    => __( 'Typography', 'cornerstone' ),
		    'description' => __( 'Include responsive text in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/responsive-text/',
		  'params'      => array(
		      array(
		        'param_name'  => 'selector',
		        'heading'     => __( 'Selector', 'cornerstone' ),
		        'description' => __( 'Enter in the selector for your responsive text (e.g. if your class is "h-responsive" enter ".h-responsive").', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'compression',
		        'heading'     => __( 'Compression', 'cornerstone' ),
		        'description' => __( 'Enter the compression for your responsive text (adjust up and down to desired level in small increments).', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => '1.0'
		      ),
		      array(
		        'param_name'  => 'min_size',
		        'heading'     => __( 'Minimum Size', 'cornerstone' ),
		        'description' => __( 'Enter the minimum size of your responsive text.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'max_size',
		        'heading'     => __( 'Maximum Size', 'cornerstone' ),
		        'description' => __( 'Enter the maximum size of your responsive text.', 'cornerstone' ),
		        'type'        => 'textfield',

		      )
		    )
		  )
		);


		//
		// Search.
		//

		$this->add(
		  array(
		    'id'        => 'x_search',
		    'title'        => __( 'Search', 'cornerstone' ),
		    'section'    => __( 'Content', 'cornerstone' ),
		    'description' => __( 'Include a search field in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/search/',
		  'params'      => array(
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);


		//
		// Counter.
		//

		$this->add(
		  array(
		    'id'        => 'x_counter',
		    'title'        => __( 'Counter', 'cornerstone' ),
		    'section'    => __( 'Information', 'cornerstone' ),
		    'description' => __( 'Include an animated number counter in your content', 'cornerstone' ),
		    'demo' =>   'http://theme.co/x/demo/integrity/1/shortcodes/counter/',
		  'params'      => array(
		      array(
		        'param_name'  => 'num_start',
		        'heading'     => __( 'Starting Number', 'cornerstone' ),
		        'description' => __( 'Enter in the number that you would like your counter to start from.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => '0'
		      ),
		      array(
		        'param_name'  => 'num_end',
		        'heading'     => __( 'Ending Number', 'cornerstone' ),
		        'description' => __( 'Enter int he number that you would like your counter to end at. This must be higher than your starting number.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => '100'
		      ),
		      array(
		        'param_name'  => 'num_speed',
		        'heading'     => __( 'Counter Speed', 'cornerstone' ),
		        'description' => __( 'The amount of time to transition between numbers in milliseconds.', 'cornerstone' ),
		        'type'        => 'textfield',

		        'value'       => '1500'
		      ),
		      array(
		        'param_name'  => 'num_prefix',
		        'heading'     => __( 'Number Prefix', 'cornerstone' ),
		        'description' => __( 'Prefix your number with a symbol or text.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'num_suffix',
		        'heading'     => __( 'Number Suffix', 'cornerstone' ),
		        'description' => __( 'Suffix your number with a symbol or text.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'num_color',
		        'heading'     => __( 'Number Color', 'cornerstone' ),
		        'description' => __( 'Select the color of your number.', 'cornerstone' ),
		        'type'        => 'colorpicker',

		      ),
		      array(
		        'param_name'  => 'text_above',
		        'heading'     => __( 'Text Above', 'cornerstone' ),
		        'description' => __( 'Optionally include text above your number.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'text_below',
		        'heading'     => __( 'Text Below', 'cornerstone' ),
		        'description' => __( 'Optionally include text below your number.', 'cornerstone' ),
		        'type'        => 'textfield',

		      ),
		      array(
		        'param_name'  => 'text_color',
		        'heading'     => __( 'Text Color', 'cornerstone' ),
		        'description' => __( 'Select the color of your text above and below the number if you have include any.', 'cornerstone' ),
		        'type'        => 'colorpicker',

		      ),
		      self::map_default_id(),
		      self::map_default_class(),
		      self::map_default_style()
		    )
		  )
		);

  }

}
