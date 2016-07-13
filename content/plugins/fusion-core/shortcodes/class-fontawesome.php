<?php
class FusionSC_FontAwesome {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'fusion_attr_fontawesome-shortcode', array( $this, 'attr' ) );
		add_shortcode( 'fontawesome', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * 
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {

		$defaults =	shortcode_atts(
			array(
				'class'					=> '',
				'id'					=> '',
				'circle'				=> 'yes',				
				'circlecolor' 			=> '',
				'circlebordercolor' 	=> '',
				'flip'					=> '',
				'icon'  				=> '',
				'iconcolor' 			=> '',
				'rotate'				=> '',
				'size' 					=> 'large',
				'spin'					=> 'no',
				'animation_type' 		=> '',
				'animation_direction' 	=> 'down',
				'animation_speed' 		=> '0.1',
				'alignment'	  		=> '',
			), $args
		);

		extract( $defaults );

		self::$args = $defaults;

		$html = sprintf( '<i %s>%s</i>', FusionCore_Plugin::attributes( 'fontawesome-shortcode' ), do_shortcode( $content ) );

		if( $alignment ) {
			$html = sprintf( '<div class="align%s">%s</div>', $alignment, $html );
		}

		return $html;

	}

	function attr() {

		$attr['class'] = sprintf( 'fa fontawesome-icon %s size-%s %2$s circle-%s', FusionCore_Plugin::font_awesome_name_handler( self::$args['icon'] ), self::$args['size'], self::$args['circle'] );
		$attr['style'] = '';
		
		if( self::$args['circle'] == 'yes' ) {
			
			if( self::$args['circlebordercolor'] ) {
				$attr['style'] .= sprintf( 'border-color:%s;', self::$args['circlebordercolor'] );
			}
			
			if( self::$args['circlecolor'] ) {
				$attr['style'] .= sprintf( 'background-color:%s;', self::$args['circlecolor'] );
			}
			
		}
		
		if( self::$args['iconcolor'] ) {
			$attr['style'] .= sprintf( 'color:%s;', self::$args['iconcolor'] );
		}
		
		if( self::$args['flip'] ) {
			$attr['class'] .= ' fa-flip-' . self::$args['flip'];
		}		
		
		if( self::$args['rotate'] ) {
			$attr['class'] .= ' fa-rotate-' . self::$args['rotate'];
		}
		
		if( self::$args['spin'] == 'yes' ) {
			$attr['class'] .= ' fa-spin';
		}		

		if( self::$args['animation_type'] ) {
			$animations = FusionCore_Plugin::animations( array(
				'type'	  => self::$args['animation_type'],
				'direction' => self::$args['animation_direction'],
				'speed'	 => self::$args['animation_speed'],
			) );

			$attr = array_merge( $attr, $animations );
			
			$attr['class'] .= ' ' . $attr['animation_class'];
			unset($attr['animation_class']);	 
		}
		
		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		return $attr;

	}

}

new FusionSC_FontAwesome();