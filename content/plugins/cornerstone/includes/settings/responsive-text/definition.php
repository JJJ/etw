<?php
class CS_Settings_Responsive_Text {

	public $priority = 30;
  public $shortcode_output = '';

	public function ui() {
		return array( 'title' => __( 'Responsive Text', 'cornerstone' ) );
	}

	public function defaults() {
		return array(
			'elements' => array()
		);
	}

	public function controls() {
		return array(
			'elements' => array(
				'type' => 'sortable',
				'options' => array(
					'element' => 'responsive-text'
				)
			)
		);
	}

	public function get_data( $key ) {

		global $post;

		$settings = array();

		if ( isset( $this->manager->post_meta['_cornerstone_settings'] ) ) {
			$settings = cs_maybe_json_decode( maybe_unserialize( $this->manager->post_meta['_cornerstone_settings'][0] ) );
			$settings = ( is_array( $settings ) ) ? $settings : array();
		}

		if ( in_array( $key, array( 'elements', '_modules', '_elements'), true ) && isset( $settings['responsive_text'] ) ) {
      return $settings['responsive_text'];
		}

		return null;

	}

	public function handler( $data ) {

    global $post;

    $settings = CS()->common()->get_post_settings( $post->ID );
    $settings['responsive_text'] = ( isset( $data['elements'] ) ) ? $data['elements'] : array();

    cs_update_serialized_post_meta( $post->ID, '_cornerstone_settings', $settings );

    //
    $buffer = '';
    $orchestrator = CS()->loadComponent( 'Element_Orchestrator' );
    $definition = $orchestrator->get( 'responsive-text' );
    foreach ($settings['responsive_text'] as $element ) {
      $buffer .= $definition->build_shortcode( $definition->sanitize( $element ), '', null );
    }

    $this->shortcode_output = $buffer;
    add_filter('cornerstone_save_post_content', array( $this, 'append_shortcodes' ) );

	}

  public function append_shortcodes( $content ) {
    $content .= $this->shortcode_output;
    $this->shortcode_output = '';
    remove_filter('cornerstone_save_post_content', array( $this, 'append_shortcodes' ) );
    return $content;
  }

}
