<?php
class Cornerstone_Builder_Renderer extends Cornerstone_Plugin_Component {

	public $dependencies = array( 'Front_End' );
  protected $ready = false;

  public function before_render() {

    if ( $this->ready ) {
      return;
    }

    $this->ready = true;

    add_shortcode( 'cs_render_wrapper', array( $this, 'wrapping_shortcode' ) );

		Cornerstone_Shortcode_Preserver::init();
		Cornerstone_Shortcode_Preserver::sandbox( 'cs_render_the_content' );

		add_filter('cs_preserve_shortcodes_no_wrap', '__return_true' );

    $this->orchestrator = $this->plugin->component( 'Element_Orchestrator' );
		$this->orchestrator->load_elements();

  }

	public function ajax_handler( $data ) {

		$this->before_render();

		global $post;
		if ( !isset( $data['post_id'] ) || ! $post = get_post( (int) $data['post_id'] ) ) {
      return cs_send_json_error( array( 'message' => 'post_id not set' ) );
		}

    $cap = $this->plugin->common()->get_post_capability( $post, 'edit_post' );
		if ( ! current_user_can( $cap, $data['post_id'] ) ) {
			return cs_send_json_error( array( 'message' => sprintf( '%s capability required.', $cap ) ) );
		}

    setup_postdata( $post );

    $this->enqueue_extractor = $this->plugin->loadComponent( 'Enqueue_Extractor' );
    $this->enqueue_extractor->start();

    if ( !isset( $data['batch'] ) )
			return cs_send_json_error( array('message' => 'No element data recieved' ) );

		$jobs = $this->batch( $data['batch'] );
		$scripts = $this->enqueue_extractor->get_scripts();
		$styles = $this->enqueue_extractor->get_styles();

		if ( is_wp_error( $jobs ) )
			return cs_send_json_error( array( 'message' => $jobs->get_error_message() ) );

		$result = array( 'jobs' => $jobs );

		if ( ! empty( $scripts ) ) {
			$result['scripts'] = $scripts;
		}

		if ( ! empty( $styles ) ) {
			$result['styles'] = $styles;
		}

		return cs_send_json_success( $result );

	}

	/**
	 * Run a batch of render jobs.
	 * This helps reduce AJAX request, as the javascript will send as many
	 * elements as it can to be rendered at once.
	 * @param  array $data list of jobs with element data
	 * @return array       finished jobs
	 */
	public function batch( $batch ) {

		$results = array();

		foreach ($batch as $job) {

			if ( !isset( $job['jobID'] ) || !isset( $job['data'] ) || !isset( $job['provider'] ) )
				return new WP_Error( 'cs_renderer', 'Malformed render job request');

			$markup =  $this->render_element( $job['data'] );

			$scripts = $this->enqueue_extractor->extract_scripts();
			$styles  = $this->enqueue_extractor->extract_styles();

			$results[$job['jobID']] = array( 'markup' => $markup, 'ts' => $job['ts'] );

			if ( ! empty( $scripts ) ) {
				$results[ $job['jobID'] ]['scripts'] = $scripts;
			}

			if ( ! empty( $styles ) ) {
				$results[ $job['jobID'] ]['styles'] = $styles;
			}

		}

		return $results;

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


		$markup = cs_noemptyp( apply_filters( 'cs_render_the_content', $markup ) );

		if ( ! is_string( $markup ) ) {
      $markup = '';
    }

    if ( ( ! isset( $flags['safe_container']) || ! $flags['safe_container'] ) &&
         ( ! isset( $flags['dynamic_child'])  || ! $flags['dynamic_child'] ) &&
         ( ! isset( $flags['attr_keys'] )     || empty( $flags['attr_keys'] ) ) ) {
      $markup = '{{base64content "' . base64_encode( $markup ) . '" }}';
    }

    if ( isset( $flags['safe_container'] ) && $flags['safe_container'] ) {
      return $markup;
    }

    $tag = 'div';

    if ( isset( $flags['wrapping_tag'] ) && $flags['wrapping_tag'] ) {
      $tag = $flags['wrapping_tag'];
    }

    return "<$tag class=\"cs-element-preview-wrapper\">$markup</$tag>";

	}

}
