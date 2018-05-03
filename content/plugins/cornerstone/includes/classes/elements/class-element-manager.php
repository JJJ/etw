<?php

class Cornerstone_Element_Manager extends Cornerstone_Plugin_Component {

  protected $elements = array();

  public function setup() {

    $this->register_native_elements();
    $this->upgrade_classic_elements();
    do_action('cs_register_elements');

    add_action('x_render_children', 'x_render_bar_modules', 10, 3 );

  }

  public function register_element( $name, $element ) {

    if ( ! $element ) {
      return;
    }

    if ( isset( $this->elements[ $name ] ) ) {
      $this->elements[ $name ]->update( $element );
    }

    $this->elements[ $name ] = new Cornerstone_Element_Definition( $name, $element );

  }

  public function unregister_element( $name ) {
    unset( $this->elements[ $name ] );
  }

  public function get_element( $name ) {
    return isset( $this->elements[ $name ] ) ? $this->elements[ $name ] : $this->elements['undefined'];
  }

  public function get_element_names() {
    return array_keys( $this->elements );
  }

  public function get_elements() {
    $elements = array();

    foreach ($this->elements as $element) {
      $elements[] = $element->serialize();
    }

    return $elements;
  }

  public function register_native_elements() {

    $this->register_element('undefined', array(
      'title' => csi18n('elements.undefined-title')
    ) );

    $this->register_element('root', array() );
    $this->register_element('region', array() );

    $this->register_element('bar', array(
      'title' => csi18n('elements.bar-title')
    ) );

    $this->register_element('container', array(
      'title' => csi18n('elements.container-title')
    ) );

    $this->load_files($this->plugin->get_registry('elements', 'base'), $this->path( 'includes/elements' ));
    $this->load_files($this->plugin->get_registry('elements', 'mixins'), $this->path( 'includes/elements/mixins' ));
    $this->load_files($this->plugin->get_registry('elements', 'definitions'), $this->path( 'includes/elements/definitions' ));

  }

  public function load_files( $files, $path ) {
    foreach ($files as $file) {
      $filename = "$path/$file.php";
      if ( file_exists($filename) ) {
        require_once( $filename );
      }
    }
  }

  public function upgrade_classic_elements() {

    $classic_elements = $this->plugin->loadComponent( 'Element_Orchestrator' )->getModels();

    foreach ($classic_elements as $element) {
      $this->register_element( 'classic:' . $element['name'], $this->upgrade_classic_element( $element ) );
    }

  }

  public function upgrade_classic_element( $element ) {

    $values = array();
    $options_to_migrate = array( 'alt_breadcrumb', 'can_preview' );
    $options = array(
      'is_classic' => true,
      'classic'   => $element['flags'],
      'debounce'  => apply_filters( 'cornerstone_render_debounce', 200 )
    );

    if ( ( isset( $options['classic']['delegate']) && $options['classic']['delegate'] )
        || isset( $options['classic']['no_server_render']) && $options['classic']['no_server_render']) {
      $options['no_server_render'] = true;
    }

    $protected_keys = ( isset( $options['classic']['protected_keys'] ) && is_array( $options['classic']['protected_keys'] ) ) ? $options['classic']['protected_keys'] : array();

    foreach ($options_to_migrate as $key) {
      if ( isset($options['classic'][$key] ) ) {
        $options[$key] = $options['classic'][$key];
      }
    }

    $attr_keys = isset( $options['classic']['attr_keys'] ) ? $options['classic']['attr_keys'] : array();
    $html_keys = array();

    $controls = $this->upgrade_classic_element_controls( $element['controls'] );
    foreach ($controls as $control) {
      if ( $control['_allow_html'] ) {
        $html_keys[] = $control['key'];
      }
    }

    foreach ($element['defaults'] as $key => $value) {
      if ( 'elements' === $key ) {
        $options['default_children'] = CS()->loadComponent('Element_Migrations')->migrate_classic($value);
        continue;
      }
      $designation = 'markup';
      if ( in_array($key, $html_keys, true) ) {
        $designation = 'markup:html';
      } elseif ( in_array($key, $attr_keys, true) ) {
        $designation = 'attr';
      }
      $values[$key] = array( 'default' => $value, 'designation' => $designation, 'protected' => in_array( $key, $protected_keys, true ) );
    }

    return array(
      'title'          => sprintf( csi18n('common.classic'), $element['ui']['title']),
      'values'         => $values,
      'style'          => '__return_empty_string',
      'render'         => array( $this, 'upgrade_classic_element_render' ),
      'icon'           => $element['icon'],
      'control_groups' => array(),
      'options'        => $options,
      'controls'       => $controls,
      'active'         => $element['active']
    );
  }


  public function upgrade_classic_element_controls( $controls ) {
    $upgraded = array();

    foreach ($controls as $key => $control ) {
      $upgrade_control = $this->upgrade_classic_element_control( $control );
      if ( $upgrade_control ) {
        $upgraded[] = $upgrade_control;
      }
    }

    return $upgraded;
  }

  public function upgrade_classic_element_control( $control ) {

    if ( in_array( $control['context'], array( '_layout' ), true ) ) {
      return false;
    }

    $conditions = array();

    if ( isset( $control['condition'] ) && is_array( $control['condition'] ) ){
      foreach ($control['condition'] as $key => $value) {
        $conditions[] = $this->upgrade_classic_element_control_condition( $key, $value );
      }
    }

    return array(
      'type'        => 'classic/' . $control['type'],
      'key'         => $control['key'],
      'label'       => ( isset( $control['ui']) && isset( $control['ui']['title'] ) ) ? $control['ui']['title'] : '',
      // 'tooltip'  => $control['ui']['tooltip'],
      'options'     => ( isset( $control['options'] ) ) ? $control['options'] : array(),
      'group'       => ( isset( $control['ui']['group'] ) ) ? $control['ui']['group'] : 'all',
      'conditions'  => $conditions,
      '_allow_html' => $this->upgrade_classic_element_control_allow_html( $control )
    );
  }


  public function upgrade_classic_element_control_allow_html( $control ) {
    return in_array($control['type'], array('code-editor', 'date', 'editor', 'text', 'textarea', 'title' ), true);
  }

  public function upgrade_classic_element_control_condition( $key, $value ) {

    $not = ':not' === substr($key, -strlen(':not'));

    if ( is_array( $value ) ) {
      $op = ( $not ) ? 'NOT IN' : 'IN';
    } else {
      $op = ( $not ) ? '!=' : '==';
    }

    return array(
      'key' => str_replace(':not', '', $key ),
      'value' => $value,
      'op' => $op
    );
  }

  public function upgrade_classic_element_render( $element ) {

    $render_data = $element;

    $render_data['_type'] = str_replace('classic:', '', $render_data['_type']);

    echo $this->plugin->loadComponent('Builder_Renderer')->render_element( $render_data, '{{yield}}' );
  }

  public function sanitize_element( $data ) {
    $definition = $this->get_element( isset( $data['_type'] ) ? $data['_type'] : 'undefined' );
    return $definition->sanitize( $data );
  }

  public function sanitize_elements( $elements ) {
    $sanitized = array();
    foreach ($elements as $element) {
      if ( isset( $element['_modules'] ) ) {
        $element['_modules'] = $this->sanitize_elements( $element['_modules'] );
      }
      $sanitized[] = $this->sanitize_element( $element );
    }
    return $sanitized;
  }

  public function native_element_base( $data ) {
    return array_merge( array(
      'builder' => array( $this, 'native_builder_setup' ),
      'style'   => array( $this, 'native_style_loader' ),
      'render'  => 'x_render_bar_module',
      'icon'    => 'native'
    ), $data );
  }

  public function native_style_loader( $type ) {
    return x_get_view( 'styles/elements', $type, 'css', array(), false );
  }

  public function native_builder_setup( $type ) {
    $function = 'x_element_builder_setup_' . str_replace( '-', '_', $type );
    return is_callable( $function ) ? call_user_func( $function ) : array();
  }

}
