<?php
class Cornerstone_Classic_Renderer extends Cornerstone_Plugin_Component {

	public $dependencies = array( 'Front_End' );
  protected $ready = false;

  public function before_render() {

    if ( $this->ready ) {
      return;
    }

    $this->ready = true;

		Cornerstone_Shortcode_Preserver::init();
		Cornerstone_Shortcode_Preserver::sandbox( 'cs_render_the_content' );

		add_filter('cs_preserve_shortcodes_no_wrap', '__return_true' );

    $this->orchestrator = $this->plugin->component( 'Element_Orchestrator' );
		$this->orchestrator->load_elements();

  }

	/**
	 * Return an element that has been rendered with data formatted for the preview window
	 * @param  array   $data   element data
	 * @param  boolean $legacy Whether or not to use the old render system.
	 * @return string          shortcode to be processed for preview window
	 */
	public function render_element( $element, $inception = false ) {

    $this->before_render();

		$transient = array();
		if ( isset( $element['_transient'] ) ) {
			$transient = $element['_transient'];
			unset( $element['_transient'] );
		}

    $parent = ( isset( $transient['parent'] ) ) ? $transient['parent'] : null;

		if ( isset( $transient['children'] ) ) {
			$element['elements'] = $transient['children'];
		}

		$definition = $this->orchestrator->get( $element['_type'] );
    $flags = $definition->flags();

    if ( $definition->is_active() ) {
      $markup = $definition->preview( $element, $this->orchestrator, $parent, $transient, $inception );
    } else {
      $message = ( $flags['undefined_message']) ? $flags['undefined_message'] : csi18n('app.elements-undefined-preview');
      $markup = "<div class=\"cs-empty-element cs-undefined-element\"><p class=\"cs-empty-element-message\">$message</p></div>";
    }

		$markup = apply_filters( 'cs_render_the_content', cs_noemptyp($markup) );

		if ( ! is_string( $markup ) ) {
      $markup = '';
    }

    if ( ( ! isset( $flags['safe_container']) || ! $flags['safe_container'] ) &&
         ( ! isset( $flags['dynamic_child'])  || ! $flags['dynamic_child'] ) &&
         ( ! isset( $flags['attr_keys'] )     || empty( $flags['attr_keys'] ) ) ) {
      $markup = '{%%{base64content ' . base64_encode( $markup ) . ' }%%}';
    }

    if ( isset( $flags['safe_container'] ) && $flags['safe_container'] ) {
      return $markup;
    }

    $tag = 'div';

    if ( isset( $flags['wrapping_tag'] ) && $flags['wrapping_tag'] ) {
      $tag = $flags['wrapping_tag'];
    }

    return "<$tag class=\"cs-element-preview-classic {%%{class}%%}\">$markup</$tag>";

	}

}
