<?php
class FusionSC_Title {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'fusion_attr_title-shortcode', array( $this, 'attr' ) );
		add_filter( 'fusion_attr_title-shortcode-heading', array( $this, 'heading_attr' ) );
		add_filter( 'fusion_attr_title-shortcode-sep', array( $this, 'sep_attr' ) );

		add_shortcode('title', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {
		global $smof_data;

		$defaults =	FusionCore_Plugin::set_shortcode_defaults(
			array(
				'class'			=> '',
				'id'			=> '',
				'content_align'	=> 'left',				
				'sep_color' 	=> '',
				'size'			=> 1,
				'style_type'	=> $smof_data['title_style_type'],
			), $args
		);

		extract( $defaults );

		self::$args = $defaults;

		if ( ! $style_type || 
			 $style_type == 'default'
		) {
			self::$args['style_type'] = $style_type = $smof_data['title_style_type'];
		}

		if ( strpos( $style_type, 'underline' ) || 
			 strpos( $style_type, 'none' )
		) {
		
			$html = sprintf( '<div %s><h%s %s>%s</h%s></div>', FusionCore_Plugin::attributes( 'title-shortcode' ), $size, 
							 FusionCore_Plugin::attributes( 'title-shortcode-heading' ), do_shortcode( $content ), $size );		

		} else {

			if( self::$args['content_align'] == 'right' ) {
			
				$html = sprintf( '<div %s><div %s><div %s></div></div><h%s %s>%s</h%s></div>', FusionCore_Plugin::attributes( 'title-shortcode' ), 
								FusionCore_Plugin::attributes( 'title-sep-container' ), FusionCore_Plugin::attributes( 'title-shortcode-sep' ), $size, 
								FusionCore_Plugin::attributes( 'title-shortcode-heading' ), do_shortcode( $content ), $size );			

			} else {

				$html = sprintf( '<div %s><h%s %s>%s</h%s><div %s><div %s></div></div></div>', FusionCore_Plugin::attributes( 'title-shortcode' ), $size, 
								 FusionCore_Plugin::attributes( 'title-shortcode-heading' ), do_shortcode( $content ), $size, 
								 FusionCore_Plugin::attributes( 'title-sep-container' ), FusionCore_Plugin::attributes( 'title-shortcode-sep' ) );
			}

		}

		return $html;

	}

	function attr() {

		$attr = array();

		$attr['class'] = 'fusion-title title';

		if( strpos( self::$args['style_type'], 'underline' ) !== false ) {
			$styles = explode( ' ', self::$args['style_type'] );

			foreach ( $styles as $style ) {
				$attr['class'] .= ' sep-' . $style;
			}

			if( self::$args['sep_color'] ) {
				$attr['style'] = sprintf( 'border-bottom-color:%s;', self::$args['sep_color'] );
			}
		}

		if( self::$args['size'] == '1' ) {
			$title_size = 'one';
		} else if( self::$args['size'] == '2' ) {
			$title_size = 'two';
		} else if( self::$args['size'] == '3' ) {
			$title_size = 'three';
		} else if( self::$args['size'] == '4' ) {
			$title_size = 'four';
		} else if( self::$args['size'] == '5' ) {
			$title_size = 'five';
		} else if( self::$args['size'] == '6' ) {
			$title_size = 'six';
		} else {
			$title_size = 'two';
		}

		$attr['class'] .= ' fusion-title-size-' . $title_size;

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		return $attr;

	}
	
	function heading_attr() {

		$attr = array();

		$attr['class'] = sprintf( 'title-heading-%s', self::$args['content_align'] );

		return $attr;

	}	

	function sep_attr() {

		$attr = array();

		$attr['class'] = 'title-sep';

		$styles = explode( ' ', self::$args['style_type'] );

		foreach ( $styles as $style ) {
			$attr['class'] .= ' sep-' . $style;
		}

		if( self::$args['sep_color'] ) {
			$attr['style'] = sprintf( 'border-color:%s;', self::$args['sep_color'] );
		}

		return $attr;

	}

}

new FusionSC_Title();