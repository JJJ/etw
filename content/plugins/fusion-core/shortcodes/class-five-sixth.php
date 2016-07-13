<?php
class FusionSC_FiveSixth {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'fusion_attr_five-sixth-shortcode', array( $this, 'attr' ) );
		add_filter( 'fusion_attr_five-sixth-shortcode-wrapper', array( $this, 'wrapper_attr' ) );		
		add_shortcode( 'five_sixth', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * 
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {
		global $smof_data;

		$defaults =	shortcode_atts(
			array(
				'class'					=> '',
				'id'					=> '',
				'background_color'		=> '',
				'background_image'		=> '',
				'background_position' 	=> 'left top',				
				'background_repeat' 	=> 'no-repeat',				
				'border_color'			=> '',
				'border_size'			=> '',
				'border_style'			=> 'solid',
				'center_content'		=> 'no',				
				'last'  				=> 'no',
				'margin_top'			=> $smof_data['col_top_margin'],
				'margin_bottom'			=> $smof_data['col_bottom_margin'],
				'padding'				=> '',
				'spacing'				=> 'yes',
				'animation_type' 		=> '',
				'animation_direction' 	=> 'left',
				'animation_speed' 		=> '0.1',			
			), $args
		);

		extract( $defaults );

		if( $defaults['margin_top'] == '' ) {
			$defaults['margin_top'] = $smof_data['col_top_margin'];
		}

		if( $defaults['margin_bottom'] == '' ) {
			$defaults['margin_bottom'] = $smof_data['col_bottom_margin'];
		}
		
		self::$args = $defaults;
		
		// After the last column we need a clearing div
		$clearfix = '';
		if ( self::$args['last'] == 'yes' ) {
			$clearfix = sprintf( '<div %s></div>', FusionCore_Plugin::attributes( 'fusion-clearfix' ) );
		}	

		$inner_content = do_shortcode( $content );

		// If content should be centered, add needed markup
		if ( $center_content == 'yes' ) {
			$inner_content = sprintf( '<div class="fusion-column-table"><div class="fusion-column-tablecell">%s</div></div>', $inner_content );
		}		

		$html = sprintf( '<div %s><div %s>%s</div></div>%s', FusionCore_Plugin::attributes( 'five-sixth-shortcode' ), FusionCore_Plugin::attributes( 'five-sixth-shortcode-wrapper' ), $inner_content, $clearfix );

		return $html;

	}

	function attr() {

		$attr['class'] = 'fusion-five-sixth fusion-layout-column';
			
		// Set the last class on the rightmost column to supress margin
		if ( self::$args['last'] == 'yes' ) {
			$attr['class'] .= ' fusion-column-last';
		}

		// Set spacing class for correct widths
		$attr['class'] .= ' fusion-spacing-' . self::$args['spacing'];

		// User specific class and id
		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		$attr['style'] = sprintf( 'margin-top:%s;margin-bottom:%s;', self::$args['margin_top'], self::$args['margin_bottom'] );

		return $attr;

	}
	
	function wrapper_attr() {
		$attr = array();
	
		$attr['class'] = 'fusion-column-wrapper';

		$attr['style'] = '';

		// Set custom background styles
		if ( self::$args['background_image'] ) {
			$attr['style'] .= sprintf( 'background:url(%s) %s %s %s;', self::$args['background_image'], self::$args['background_position'], self::$args['background_repeat'], self::$args['background_color']  );
			
			if ( self::$args['background_repeat'] == 'no-repeat') {
				$attr['style'] .= '-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;';
			}	
			
			$attr['data-bg-url'] = self::$args['background_image'];
		} elseif ( self::$args['background_color'] ) {
			$attr['style'] .= sprintf( 'background-color:%s;', self::$args['background_color'] );
		}
		
		// Set custom border styles
		if ( self::$args['border_color'] && 
			 self::$args['border_size'] && 
			 self::$args['border_style'] 
		) {
			if ( FusionCore_Plugin::is_transparent_color( self::$args['border_color'] ) ) {
				$attr['style'] .= sprintf( 'outline:%s %s %s;', self::$args['border_size'], self::$args['border_style'], self::$args['border_color'] );
				$attr['style'] .= sprintf( 'outline-offset: -%s;', self::$args['border_size'] );
			} else {
				$attr['style'] .= sprintf( 'border:%s %s %s;', self::$args['border_size'], self::$args['border_style'], self::$args['border_color'] );
			}
		}
	
		// Set custom padding
		if ( self::$args['padding'] ) {
			$attr['style'] .= sprintf( 'padding:%s;', self::$args['padding'] );
		}
		
		// Animations
		if ( self::$args['animation_type'] ) {
			$animations = FusionCore_Plugin::animations( array(
				'type'	  	=> self::$args['animation_type'],
				'direction' => self::$args['animation_direction'],
				'speed'	 	=> self::$args['animation_speed'],
			) );

			$attr = array_merge( $attr, $animations );
			
			$attr['class'] .= ' ' . $attr['animation_class'];
			unset( $attr['animation_class'] );	 
		}		
			
		return $attr;
	}	

}

new FusionSC_FiveSixth();
