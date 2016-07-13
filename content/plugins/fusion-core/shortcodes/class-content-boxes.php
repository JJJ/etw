<?php
class FusionSC_ContentBoxes {

	private $content_box_counter = 1;
	private $column_counter = 1;
	private $num_of_columns = 1;

	public static $parent_args;
	public static $child_args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'fusion_attr_content-box-shortcode', array( $this, 'child_attr' ) );
		add_filter( 'fusion_attr_content-box-shortcode-content-wrapper', array( $this, 'content_wrapper_attr' ) );
		add_filter( 'fusion_attr_content-box-shortcode-heading-wrapper', array( $this, 'heading_wrapper_attr' ) );
		add_filter( 'fusion_attr_content-box-shortcode-content-container', array( $this, 'content_container_attr' ) );
		
		add_filter( 'fusion_attr_content-box-shortcode-link', array( $this, 'link_attr' ) );
		add_filter( 'fusion_attr_content-box-shortcode-icon', array( $this, 'icon_attr' ) );
		add_filter( 'fusion_attr_content-box-heading', array( $this, 'content_box_heading_attr' ) );
		add_shortcode( 'content_box', array( $this, 'render_child' ) );

		add_filter( 'fusion_attr_content-boxes-shortcode', array( $this, 'parent_attr' ) );
		add_shortcode( 'content_boxes', array( $this, 'render_parent' ) );

	}

	/**
	 * Render the shortcode
	 * 
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render_parent( $args, $content = '') {
		global $smof_data;

		$defaults =	FusionCore_Plugin::set_shortcode_defaults(
			array(
				'class'					=> '',			
				'id' 					=> '',
				'backgroundcolor' 		=> '',
				'circle'	 			=> '',
				'circlecolor' 			=> '',
				'circlebordercolor' 	=> '',
				'columns' 				=> '',
				'iconcolor' 			=> '',
				'icon_circle'			=> $smof_data['content_box_icon_circle'],
				'icon_size'				=> $smof_data['content_box_icon_size'],
				'icon_align'			=> '',
				'layout' 				=> 'icon-with-title',
				'margin_top' 			=> $smof_data['content_box_margin_top'],
				'margin_bottom' 		=> $smof_data['content_box_margin_bottom'],
				'title_size'			=> $smof_data['content_box_title_size'],
			), $args
		);

		extract( $defaults );

		self::$parent_args = $defaults;
		
		$this->column_counter = 1;
		
		if( ! $columns || 
			empty( $columns ) 
		) {
			preg_match_all( '/(\[content_box (.*?)\](.*?)\[\/content_box\])/s', $content, $matches );
			if( is_array( $matches ) && 
				! empty( $matches ) 
			) {
				$this->num_of_columns = count( $matches[0] );
				if( $this->num_of_columns > 6 ) {
					$this->num_of_columns = 6;
				}
			} else {
				$this->num_of_columns = 1;
			}
		} elseif( $columns > 6 ) {
			$this->num_of_columns = 6;
		} else {
			$this->num_of_columns = $columns;
		}

		$html = sprintf( '<div %s>%s<div class="fusion-clearfix"></div></div>', FusionCore_Plugin::attributes( 'content-boxes-shortcode' ), do_shortcode( $content ) );

		$this->content_box_counter++;

		return $html;

	}

	function parent_attr() {

		$attr['class'] = sprintf( 'fusion-content-boxes content-boxes columns fusion-columns-%s fusion-content-boxes-%s content-boxes-%s row content-%s', $this->num_of_columns, $this->content_box_counter, self::$parent_args['layout'], self::$parent_args['icon_align'] );

		if( self::$parent_args['class'] ) {
			$attr['class'] .= ' ' . self::$parent_args['class'];
		}

		if( self::$parent_args['id'] ) {
			$attr['id'] = self::$parent_args['id'];
		}

		$attr['style'] = sprintf( 'margin-top:%s;margin-bottom:%s;', self::$parent_args['margin_top'], self::$parent_args['margin_bottom'] );

		return $attr;

	}

	/**
	 * Render the child shortcode
	 * 
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render_child( $args, $content = '') {

		$defaults =	FusionCore_Plugin::set_shortcode_defaults(
			array(
				'class'					=> '',
				'id'					=> '',
				'backgroundcolor'		=> '',
				'circle'	 			=> '',
				'circlecolor' 			=> '',
				'circlebordercolor' 	=> '',
				'icon' 					=> '',
				'iconcolor' 			=> '',
				'iconflip'				=> '',
				'iconrotate'			=> '',
				'iconspin'				=> '',
				'image' 				=> '',
				'image_height' 			=> '35',				
				'image_width' 			=> '35',
				'link' 					=> '',
				'linktarget' 			=> '_self',
				'linktext' 				=> '',
				'textcolor'				=> '',
				'title' 				=> '',
				'animation_type' 		=> '',
				'animation_direction' 	=> 'left',
				'animation_speed' 		=> '0.1',
			), $args
		);

		extract( $defaults );

		self::$child_args = $defaults;

		$output = '';
		$icon_output = '';
		$title_output = '';
		$content_output = '';
		$link_output = '';
		$alt = '';

		if( $image && 
			$image_width && 
			$image_height
		) {
		
			$image_id = FusionCore_Plugin::get_attachment_id_from_url( $image );

			if( $image_id ) {
				$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			}
		
			$icon_output = sprintf( '<div %s><img src="%s" width="%s" height="%s" alt="%s" /></div>', FusionCore_Plugin::attributes( 'content-box-shortcode-icon' ), $image, $image_width, $image_height, $alt );
		} elseif( $icon ) {
			$icon_output = sprintf( '<div %s><i %s></i></div>', FusionCore_Plugin::attributes( 'icon' ), FusionCore_Plugin::attributes( 'content-box-shortcode-icon' ) );
		}

		if( $title ) {
			$title_output = sprintf( '<h2 %s>%s</h2>', FusionCore_Plugin::attributes( 'content-box-heading' ), $title );
		}
		
		if( ( self::$parent_args['layout'] == 'icon-on-side' || self::$parent_args['layout'] == 'icon-with-title' ) && self::$parent_args['icon_align'] == 'right' ) {
			$heading_content = $title_output . $icon_output;
		} else {
			$heading_content = $icon_output . $title_output;
		}
		
		if( $link ) {
			$heading_content = sprintf( '<a %s %s>%s</a>', FusionCore_Plugin::attributes( 'heading-link' ), 
										FusionCore_Plugin::attributes( 'content-box-shortcode-link' ), $heading_content );
		} else {
			
		}
		$heading = sprintf( '<div %s>%s</div>', FusionCore_Plugin::attributes( 'content-box-shortcode-heading-wrapper' ), $heading_content );

		if( $link &&  
			$linktext 
		) {
			$link_output = sprintf( '<a %s %s>%s</a><div class="fusion-clearfix"></div>', FusionCore_Plugin::attributes( 'fusion-read-more' ), FusionCore_Plugin::attributes( 'content-box-shortcode-link' ), $linktext );
		} 

		$content_output = sprintf( '<div class="fusion-clearfix"></div><div %s>%s</div>', FusionCore_Plugin::attributes( 'content-box-shortcode-content-container'), do_shortcode( $content ) . $link_output );

		$output = $heading . $content_output;

		$html = sprintf( '<div %s><div %s>%s</div></div>', FusionCore_Plugin::attributes( 'content-box-shortcode' ), 
						 FusionCore_Plugin::attributes( 'content-box-shortcode-content-wrapper' ), $output );

		$clearfix_test = $this->column_counter / $this->num_of_columns;

		if ( is_int( $clearfix_test ) ) {
			$html .= '<div class="fusion-clearfix"></div>';
		}

		$this->column_counter++;
		
		return $html;

	}

	function child_attr() {

		$columns = 12 / $this->num_of_columns;

		$attr['class'] = sprintf( 'fusion-column content-box-column content-box-column-%s col-lg-%s col-md-%s col-sm-%s', $this->column_counter, $columns, $columns, $columns );
		
		if( $this->num_of_columns == '5'  ) {
			$attr['class'] = 'fusion-column content-box-column col-lg-2 col-md-2 col-sm-2';
		}

		if( self::$child_args['class'] ) {
			$attr['class'] .= ' ' . self::$child_args['class'];
		}

		if( self::$child_args['id'] ) {
			$attr['id'] = self::$child_args['id'];
		}

		return $attr;

	}
	
	function content_wrapper_attr() {
	
		$attr['class'] = 'col content-wrapper';
		
		// set parent values if child values are unset to get downwards compatibility
		if( ! self::$child_args['backgroundcolor'] ) {
			self::$child_args['backgroundcolor'] = self::$parent_args['backgroundcolor'];
		}		
		
		if( self::$child_args['backgroundcolor'] ) {
			$attr['style'] = sprintf( 'background-color:%s;', self::$child_args['backgroundcolor'] );
			$attr['class'] .= '-background';
		}
		
		if( self::$parent_args['layout']  == 'icon-boxed' ) {
			$attr['class'] .= ' content-wrapper-boxed';
		}		
		
		if( self::$child_args['textcolor'] ) {
			$attr['style'] .= sprintf( 'color:%s;', self::$child_args['textcolor'] );
		}
		
		if( self::$child_args['animation_type'] ) {
			$animations = FusionCore_Plugin::animations( array(
				'type'	  => self::$child_args['animation_type'],
				'direction' => self::$child_args['animation_direction'],
				'speed'	 => self::$child_args['animation_speed'],
			) );

			$attr = array_merge( $attr, $animations );
			
			$attr['class'] .= ' ' . $attr['animation_class'];
			unset($attr['animation_class']);	 
		}
	
		return $attr;
	}
	
	
	function link_attr() {

		if( self::$child_args['link'] ) {
			$attr['href'] = self::$child_args['link'];
		}
		
		if( self::$child_args['linktarget'] ) {
			$attr['target'] = self::$child_args['linktarget'];
		}		

		return $attr;

	}	

	function heading_wrapper_attr() {

		$attr['class'] = 'heading';

		if( self::$child_args['icon'] || self::$child_args['image'] ) {
			$attr['class'] .= ' heading-with-icon';
		}
		
		if( self::$parent_args['icon_align'] ) {
			$attr['class'] .= ' icon-'.self::$parent_args['icon_align'];
		}

		return $attr;

	}

	function icon_attr() {
	
		$attr['style'] = '';
	
		if( self::$child_args['image'] ) {
			$attr['class'] = 'image';
			
			if( self::$parent_args['layout'] == 'icon-boxed' && 
				self::$child_args['image_width'] && 
				self::$child_args['image_height']
			) {
				$attr['style'] = sprintf( 'margin-left:-%spx;', self::$child_args['image_width'] / 2 );
				$attr['style'] .= sprintf( 'top:-%spx;', self::$child_args['image_height'] / 2 + 50 );
			}			
			
		} else if( self::$child_args['icon'] ) {

			$attr['class'] = sprintf( 'fa fontawesome-icon %s', FusionCore_Plugin::font_awesome_name_handler( self::$child_args['icon'] ) );
			
			// set parent values if child values are unset to get downwards compatibility
			if( ! self::$child_args['circle'] ) {
				self::$child_args['circle'] = self::$parent_args['circle'];
			}

			if( ! self::$child_args['circlebordercolor'] ) {
				self::$child_args['circlebordercolor'] = self::$parent_args['circlebordercolor'];
			}
			
			if( ! self::$child_args['circlecolor'] ) {
				self::$child_args['circlecolor'] = self::$parent_args['circlecolor'];
			}
			
			if( ! self::$child_args['iconcolor'] ) {
				self::$child_args['iconcolor'] = self::$parent_args['iconcolor'];
			}			
			
			if( self::$parent_args['icon_circle'] == 'yes' ) {

				$attr['class'] .= ' circle-yes';

				if( self::$child_args['circlebordercolor'] ) {
					$attr['style'] .= sprintf( 'border-color:%s;', self::$child_args['circlebordercolor'] );
				}

				if( self::$child_args['circlecolor'] ) {
					$attr['style'] .= sprintf( 'background-color:%s;', self::$child_args['circlecolor'] );
				}

				$attr['style'] .= sprintf( 'height:%spx;width:%spx;line-height:%spx;', self::$parent_args['icon_size'] * 2, self::$parent_args['icon_size'] * 2, self::$parent_args['icon_size'] * 2 );

				if( self::$parent_args['layout'] == 'icon-boxed' ) {
					$attr['style'] .= sprintf( 'top:-%spx;margin-left:-%spx;', 50 + ( ( self::$parent_args['icon_size'] * 2 ) / 2 ), ( self::$parent_args['icon_size'] * 2 ) / 2 );
				}
			} else {

				$attr['style'] .= sprintf( 'background-color:%s;border-color:%s;height:%s;width:%spx;line-height:%s;', 'transparent', 'transparent', 'auto', self::$parent_args['icon_size'], 'normal' );

				if( self::$parent_args['layout'] == 'icon-boxed' ) {
					$attr['style'] .= sprintf( 'position:%s;left:%s;right:%s;top:%s;margin-left:%s;margin-right:%s;', 'relative', 'auto', 'auto', 'auto', 'auto', 'auto' );
				}
			}

			if( self::$child_args['iconcolor'] ) {
				$attr['style'] .= sprintf( 'color:%s;', self::$child_args['iconcolor'] );
			}

			if( self::$child_args['iconflip'] ) {
				$attr['class'] .= ' fa-flip-' . self::$child_args['iconflip'];
			}		

			if( self::$child_args['iconrotate'] ) {
				$attr['class'] .= ' fa-rotate-' . self::$child_args['iconrotate'];
			}

			if( self::$child_args['iconspin'] == 'yes' ) {
				$attr['class'] .= ' fa-spin';
			}

			$attr['style'] .= sprintf( 'font-size:%spx;', FusionCore_Plugin::strip_unit( self::$parent_args['icon_size'] ) );
		}

		return $attr;

	}

	function content_container_attr() {
		$attr['class'] = 'content-container';
	
		if( self::$parent_args['layout'] == 'icon-on-side' && 
			self::$child_args['image'] && 
			self::$child_args['image_width'] && 
			self::$child_args['image_height']
		) {
			$attr['style'] = sprintf( 'padding-left:%spx;', self::$child_args['image_width'] + 10 );
		} else if ( self::$parent_args['layout'] == 'icon-on-side' && self::$child_args['icon'] ) {
			if ( self::$parent_args['icon_circle'] == 'yes' ) {
				$full_icon_size = self::$parent_args['icon_size'] * 2 + 20;
			} else {
				$full_icon_size = self::$parent_args['icon_size'] + 20;
			}
			
			$attr['style'] = sprintf( 'padding-left:%spx;', $full_icon_size );
			if ( $full_icon_size > self::$parent_args['title_size'] &&
				 $full_icon_size - self::$parent_args['title_size'] - 20 > 0
			) {
				$attr['style'] .= sprintf( 'margin-top:-%spx;', $full_icon_size - self::$parent_args['title_size'] - 20 );
			}			
		}
		
		if( self::$parent_args['icon_align'] == 'right' && isset ( $attr['style'] ) && ( self::$parent_args['layout'] == 'icon-on-side' || self::$parent_args['layout'] == 'icon-with-title' ) ) {
			$attr['style'] .= sprintf( ' text-align:%s', self::$parent_args['icon_align'] );
		} else if( self::$parent_args['icon_align'] == 'right' && !isset( $attr['style'] ) && ( self::$parent_args['layout'] == 'icon-on-side' || self::$parent_args['layout'] == 'icon-with-title' ) ) {
			$attr['style'] = sprintf( ' text-align:%s', self::$parent_args['icon_align'] );
		}

		return $attr;
		
	}

	function content_box_heading_attr() {
		$attr['class'] = 'content-box-heading';

		if( self::$parent_args['title_size'] ) {
			$font_size = FusionCore_Plugin::strip_unit( self::$parent_args['title_size'] );
		
			$attr['style'] = sprintf( 'font-size: %spx;line-height:%spx;', $font_size, $font_size + 2 );
		}

		return $attr;
	}
}

new FusionSC_ContentBoxes();