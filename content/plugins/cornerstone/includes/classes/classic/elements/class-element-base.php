<?php

/**
 * LEGACY Class. Original Cornerstone elements will inherit from this class
 */

abstract class Cornerstone_Element_Base {

	/**
	 * Contains element data (id, title, callbacks etc.)
	 * @var array
	 */
	private $data;

	private $defaults;
	private $control_group;

	protected $loaded = false;
	public $native = false;

	/**
	 * Instantiate element with supplied data
	 */
	public function __construct() {

		$this->data = wp_parse_args( $this->data(), array(
			'name'              => '',
			'title'             => 'Generic Element',
			'section'           =>  'content',
			'description'       => 'Generic Element',
			'autofocus'         => '',
			'controls'          => array(),
			'empty'             => false,
			'context'           => 'all',
			'render'            => true,
			'htmlhint'          => false,
			'delegate'          => false,
      'alt_breadcrumb'    => '',
      'protected_keys'    => array(),
			'childType'         => false,
			'renderChild'       => false,
      'linked_child'      => false,
      'attr_keys'         => array(),
			'can_preview'       => true,
			'undefined_message' => false,
      'no_server_render'  => false,
      'safe_container'    => false,
      'wrapping_tag'      => 'div',
			'active'            => $this->is_active(),
		) );

	}

	public function register() {

	}

	public function load_controls() {

		if ( $this->loaded )
			return;

		$this->controls();
		$this->controlMixins();
		$this->convergeControlData();

		$this->loaded = true;
	}

	public function get_defaults() {
		$this->load_controls();
		return $this->defaults;
	}

	final public function model_data() {

		$this->load_controls();

		$ui = array( 'title' => $this->data['title'] );

		if ( isset( $this->data['autofocus'] ) ) {
			$ui['autofocus']	= $this->data['autofocus'];
		}

		if ( isset( $this->data['helpText'] ) ) {
			$ui['helpText']	= $this->data['helpText'];
		}

		if ( ! isset( $this->data['icon'] ) ) {

			if ( $this->native ) {
				$this->data['icon'] = 'elements/' . $this->data['name'];
			} else {
				$this->data['icon'] = 'elements/default';
			}

		}

		return array(
			'name'          => $this->data['name'],
			'active'        => $this->is_active(),
			'ui'            => $ui,
		  'flags'         => $this->flags(),
		  'icon'          => $this->data['icon'],
			'base_defaults' => $this->defaults,
			'defaults'      => $this->defaults,
			'controls'      => $this->control_group->model_data()
		 );

	}

	public function flags() {
		return array(
			'_v'                => 'mk1',
			'context'           => $this->data['context'],
			'child'             => $this->data['delegate'],
			'delegate'          => $this->data['delegate'],
      'alt_breadcrumb'    => $this->data['alt_breadcrumb'],
      'protected_keys'    => $this->data['protected_keys'],
			'childType'         => $this->data['childType'],
			'empty'             => $this->data['empty'],
			'render'            => $this->data['render'],
			'htmlhint'          => $this->data['htmlhint'],
			'attr_keys'         => $this->data['attr_keys'],
			'can_preview'       => $this->can_preview(),
			'manageChild'       => $this->data['renderChild'],
      'linked_child'      => $this->data['linked_child'],
			'undefined_message' => $this->data['undefined_message'],
      'no_server_render'  => $this->data['no_server_render'],
      'safe_container'    => $this->data['safe_container'],
      'wrapping_tag'      => $this->data['wrapping_tag'],
		);
	}

	/**
	 * Basic validation consists of requiring a string id
	 * @return boolean  true if data is valid
	 */
	public function is_valid() {

		if ( '' == $this->data['name'] )
			return new WP_Error( 'cornerstone_add_element', 'Missing Name' );

		$reserved = array( 'title', 'columnLayout', 'builder', 'elements', 'parentElement', 'active', 'size', 'rank', 'name', 'elType', 'section', 'icon', 'description', 'controls', 'supports', 'defaultValue', 'options', 'tooltip' );
		$whitelist = array( 'title', 'sortable' );

		$names = array();
		foreach( $this->data['controls'] as $control ) {

			if ( in_array($control['controlType'], $whitelist) )
				continue;

			$names[] = $control['name'];
		}

		if ( isset( $names['name'] ) )

		if ( count( array_intersect( $names, $reserved ) ) > 0 )
				return new WP_Error( 'cornerstone_add_element', 'Control names can not use a reserved keyword: ' . implode( ', ', $reserved ) );

		return true;
	}

	/**
	 * Gets element name
	 * @return string name from element data
	 */
	public function name() {
		return $this->data['name'];
	}

	/**
	 * Gets element childType
	 * @return string childType from element data
	 */
	public function childType() {
		return $this->data['childType'];
	}

	/**
	 * Gets element empty condition
	 * @return string childType from element data
	 */
	public function emptyCondition() {
		return $this->data['empty'];
	}

	/**
	 * Get the element data after it's been
	 * @return array element data
	 */
	public function getData() {
		return $this->data;
	}


	/**
	 * Call from the elements's control method. Map controls in order you'd like them in the inspector pane.
	 * @param string $name     Required. Control name - will become an attribute name for the element
	 * @param string $type     Type of view used to create the UI for this control
	 * @param string $title    Localized title. Set null to compact this control
	 * @param string $tooltip  Localized tooltip. Only visible if title is set
	 * @param array  $default  Values used to populate the control if the element doesn't have values of its own
	 * @param array  $options  Information specific to this control. For example, the names and data of items in a dropdown
	 */
	public function addControl( $name, $type, $title = null, $tooltip = null, $default = array(), $options = array() ) {
		$control = array( 'name' => $name, 'controlType' => $type, 'controlTitle' => $title, 'controlTooltip' => $tooltip, 'defaultValue' => $default, 'options' => $options );
		$this->data['controls'][] = $control;
	}

	/**
	 * Allow a mixin to be added inline. This allows you to determine its position
	 * in the order of mapped controls.
	 * @param string $support name of the mixin
	 */
	public function addSupport( $support ) {

		$numargs = func_num_args();
		$count = 0;

		$mixin_controls = apply_filters( '_cornerstone_control_mixin_' . $support, array() );
		if ( !empty( $mixin_controls ) ) {
			foreach ($mixin_controls as $mixin) {

				$override = ( $numargs > ++$count ) ? func_get_arg($count) : array();
				$control = wp_parse_args( $override, $mixin );

				if ( isset( $override['options'] ) && isset( $mixin['options'] ) ) {
					$control['options'] = wp_parse_args( $override['options'], $mixin['options'] );
				}

				$this->data['controls'][] = $control;

			}
		}
	}

	/**
	 * Add control mixins. Looks for a 'supports' array, and adds additional controls.
	 * Don't use `_cornerstone_control_mixin_$name` filter. Use `cornerstone_control_mixins` instead
	 * @return none
	 */
	public function controlMixins() {

		if ( !isset( $this->data['supports'] ) || !is_array( $this->data['supports'] ) )
			return;

		foreach ( $this->data['supports'] as $support ) {
			$mixin_controls = apply_filters( '_cornerstone_control_mixin_' . $support, array() );
			if ( !empty( $mixin_controls ) ) {
				foreach ($mixin_controls as $mixin) {
					$this->data['controls'][] = $mixin;
				}
			}
		}

	}

	/**
	 * Takes the old API data points and separate controls from defaults.
	 */
	final public function convergeControlData() {

		$control_objects = array();
		$defaults = array();

		foreach ($this->data['controls'] as $item ) {
			$name = $item['name'];

			$condition = null;

			if ( isset($item['options']['condition'] ) ) {
				$condition = $item['options']['condition'];
				unset($item['options']['condition']);
			}

			$config = array(
				'type' => $item['controlType'],
				'ui' => array(),
				'options' => $item['options'],
				'suggest' => $item['defaultValue']
			);

			if ( !is_null( $condition ) ) {
				$config['condition'] = $condition;
			}

			if ( !is_null( $item['controlTitle'] ) )
				$config['ui']['title'] = $item['controlTitle'];

			if ( !is_null( $item['controlTooltip'] ) )
				$config['ui']['tooltip'] = $item['controlTooltip'];

			$control_objects[$name] = $config;

		}

		$this->control_group = Cornerstone_Control_Group::factory( $control_objects );

		foreach ($this->control_group->controls as $control) {
			$defaults[ $control->name ] = $control->suggest;
		}

		$this->defaults = $defaults;

	}

	public function sanitize( $element ) {
		$this->load_controls();
		return $this->control_group->sanitize( $element );
	}


	/**
	 * Helper function used in render methods.
	 * This creates a string that can be used to speed up shortcode building.
	 * @param  array $params
	 * @return string
	 */
	public function extra( $atts ) {

		$extra = '';

		if ( isset($atts['id']) && $atts['id'] != '' )
			$extra .= " id=\"{$atts['id']}\"";

		if ( isset($atts['class']) && $atts['class'] != '' ) {
			$class = esc_attr( $atts['class'] );
			$extra .= " class=\"{$class}\"";
		}

		if ( isset($atts['style']) && $atts['style'] != '' )
			$extra .= " style=\"{$atts['style']}\"";

		return $extra;
	}

	public function shouldRender() {
		return $this->data['delegate'];
	}

	public function renderElement( $atts ) {
		return $this->render( $this->injectAtts( $atts ) );
	}

	/**
	 * Perform common operations such as mixin class injection
	 * @param  array $atts
	 * @return array
	 */
	public function injectAtts( $atts ) {

		add_filter( 'cornerstone_control_mixin_expanders_dynamic', array( $this, 'add_mixin_expander' ) );
		$atts = apply_filters( 'cornerstone_control_injections', $atts );
		remove_filter( 'cornerstone_control_mixin_expanders_dynamic', array( $this, 'add_mixin_expander' ) );

    if ( $atts['content'] ) {
      $atts['content'] = apply_filters( 'cs_element_update_build_shortcode_content', $atts['content'], null );
    }

		$atts['extra'] = $this->extra( $atts );

    return $atts;
	}

	public function add_mixin_expander( $expanders ) {
		$expanders['undefined'] = array( $this, 'mixin_expander' );
		return $expanders;
	}

	public function mixin_expander( $inject, $atts ) {
		return $this->attribute_injections( $inject, $atts );
	}

	public function attribute_injections( $inject, $atts ) {
		return $inject;
	}

	/**
	 * Helper function used in render methods.
	 * This creates a string that can be used to speed up shortcode building.
	 * @param  array  $width
	 * @param  string $style
	 * @param  string $color
	 * @return string
	 */
	public function borderStyle( $width, $style, $color ) {

		$width = 'border-width: ' . implode( ' ', $width ) . '; ';
		$style = 'border-style: ' . $style . '; ';
		$color = 'border-color: ' . $color . ';';

		return $width . $style . $color;

	}


	/**
	 * Data provider. Override in child class to set element data
	 * This is for SETUP ONLY. To access element data later on, use Cornerstone_Element_Base::getData
	 * Should contain: name, title, section, icon, description
	 * @return array element data
	 */
	public function data(){
		return array();
	}


	/**
	 * Stub controls. This should be overriden in the child element, and contain calls to addControl
	 * @return none
	 */
	public function controls() { }

	public function is_active() { return true; }

	public function sg_map( $map ) {
		CS()->component( 'Shortcode_Generator' )->add( $map );
	}

	public function can_preview() {
		return $this->data['can_preview'];
	}

	public function migrate( $element, $version ) {
		return $element;
	}

	public function preview_enqueue() { }

	public function preview($element, $orchestrator, $parent = null, $transient = null, $inception = false ) {
    return CS()->loadComponent( 'Legacy_Renderer' )->renderElement( $element );
  }


	final public function version() {
		return 'mk1';
	}

}
