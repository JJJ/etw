<?php

class Cornerstone_Enqueue_Extractor extends Cornerstone_Plugin_Component {

	protected $previous_scripts;
	protected $script_handles;
	protected $style_delta;
	protected $scripts;
  public $counter = 0;

	public function setup() {
		add_filter( 'script_loader_tag', array( $this, 'preview_script_element' ), 10, 3 );
		add_filter( 'style_loader_tag', array( $this, 'preview_style_element' ), 10, 3 );
	}

	public function preview_script_element( $tag, $handle, $src ) {
    $this->counter++;
		return str_replace('src=', 'data-cs-handle="' . esc_attr( $handle ) . '" src=', $tag );
	}

	public function preview_style_element( $tag, $handle, $href ) {
    $this->counter++;
		return str_replace('href=', 'data-cs-handle="' . esc_attr( $handle ) . '" href=', $tag );
	}

	public function start() {


		$this->previous_scripts = wp_scripts();
		$wp_scripts = new WP_Scripts();
		$this->script_handles = array();

		$this->previous_styles = wp_styles();
		$wp_styles = new WP_Styles();
		$this->style_handles = array();

	}

	public function extract_scripts() {
		$wp_scripts = wp_scripts();
		$isolated = array_diff( $wp_scripts->queue, $this->script_handles );
		$this->script_handles = array_unique( array_merge( $isolated, $this->script_handles ) );
		return $isolated;
	}

	public function extract_styles() {
		$wp_styles = wp_styles();
		$isolated = array_diff( $wp_styles->queue, $this->style_handles );
		$this->style_handles = array_unique( array_merge( $isolated, $this->style_handles ) );
		return $isolated;
	}


	public function get_scripts() {

		$wp_scripts = wp_scripts();
		$this->scripts = array();
		add_filter( 'script_loader_tag', array( $this, 'catch_script_tags' ), 99, 3 );

		ob_start();
		$wp_scripts->do_items( $this->script_handles );
		ob_get_clean();

		global $wp_scripts;
		$wp_scripts = $this->previous_scripts;

		return $this->scripts;

	}

	public function get_styles() {

		$wp_styles = wp_styles();
		$this->styles = array();
		add_filter( 'style_loader_tag', array( $this, 'catch_style_tags' ), 99, 3 );

		ob_start();
		$wp_styles->do_items( $this->style_handles );
		ob_get_clean();

		global $wp_styles;
		$wp_styles = $this->previous_styles;

		return $this->styles;

	}

	public function catch_script_tags( $tag, $handle, $src ) {

		$scripts = wp_scripts();
		$obj = $scripts->registered[ $handle ];

		$before = '';
		$conditional = isset( $obj->extra['conditional'] ) ? $obj->extra['conditional'] : '';
		$has_conditional_data = $conditional && $scripts->get_data( $handle, 'data' );

		if ( $has_conditional_data ) {
			$before .= "<!--[if {$conditional}]>\n";
		}

		$extra_data = $scripts->print_extra_script( $handle, false );
		if ( $extra_data ) {
			$before .= $extra_data;
		}

		if ( $has_conditional_data ) {
			$before .= "<![endif]-->\n";
		}

		$new_script = array(
			'tag' => $tag,
			'src' => $src,
			'obj' => $obj,
		);

		if ( $before ) {
			$new_script['before'] = $before;
		}

		$this->scripts[$handle] = $new_script;

		return $tag;

	}

	public function catch_style_tags( $tag, $handle, $href ) {

		$styles = wp_styles();

		$this->styles[$handle] = array(
			'tag' => $tag,
			'href' => $href,
			'obj' => $styles->registered[ $handle ]
		);

		return $tag;

	}

}
