<?php
class FusionSC_Person {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'fusion_attr_person-shortcode', array( $this, 'attr' ) );
		add_filter( 'fusion_attr_person-shortcode-image-container', array( $this, 'image_container_attr' ) );
		add_filter( 'fusion_attr_person-shortcode-href', array( $this, 'href_attr' ) );
		add_filter( 'fusion_attr_person-shortcode-img', array( $this, 'img_attr' ) );
		add_filter( 'fusion_attr_person-shortcode-author', array( $this, 'author_attr' ) );
		add_filter( 'fusion_attr_person-shortcode-social-networks', array( $this, 'social_networks_attr' ) );	
		add_filter( 'fusion_attr_person-shortcode-icon', array( $this, 'icon_attr' ) );	
		
		add_shortcode( 'person', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args	Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {
		global $smof_data;

		$defaults = FusionCore_Plugin::set_shortcode_defaults(
			array(
				'class'						=> '',			
				'id'						=> '',
				'lightbox'					=> 'no',
				'linktarget'				=> '_self',
				'name'						=> '',
				'social_icon_boxed'			=> strtolower( $smof_data['social_links_boxed'] ),
				'social_icon_boxed_colors'	=> strtolower( $smof_data['social_links_box_color'] ),					
				'social_icon_boxed_radius' 	=> strtolower( $smof_data['social_links_boxed_radius'] ),
				'social_icon_colors'		=> strtolower( $smof_data['social_links_icon_color'] ),			
				'social_icon_order'			=> '',
				'social_icon_tooltip'		=> strtolower( $smof_data['social_links_tooltip_placement'] ),
				'pic_bordercolor'			=> strtolower( $smof_data['person_border_color'] ),				
				'pic_borderradius'			=> strtolower( $smof_data['person_border_radius'] ),
				'pic_bordersize'			=> strtolower( $smof_data['person_border_size'] ),
				'pic_link'					=> '',
				'pic_style'					=> 'none',
				'pic_style_color'			=> strtolower( $smof_data['person_style_color'] ),
				'picture'					=> '',
				'title'						=> '',
				
				'facebook' => '', 'twitter' => '', 'instagram' => '', 'linkedin' => '', 'dribbble' => '', 'rss' => '', 'youtube' => '', 'pinterest' => '', 'flickr' => '', 'vimeo' => '', 
				'tumblr' => '', 'google' => '', 'googleplus' => '', 'digg' => '', 'blogger' =>'', 'skype' => '', 'myspace' => '', 'deviantart' => '', 'yahoo' => '',
				'reddit' => '', 'forrst' => '', 'paypal' => '', 'dropbox' => '', 'soundcloud' => '', 'vk' => '', 'email' => '',
			), $args 
		);
		
		if( $defaults['pic_borderradius'] != "0px" && ! empty( $defaults['pic_borderradius'] ) && $defaults['pic_style'] == 'bottomshadow' ) {
			$defaults['pic_style'] = 'none';
		}
		
		if( $defaults['pic_borderradius'] == 'round' ) {
			$defaults['pic_borderradius'] = '50%';
		}		

		extract( $defaults );

		self::$args = $defaults;

		self::$args['styles'] = '';

		$rgb = FusionCore_Plugin::hex2rgb( $defaults['pic_style_color'] );
	
		if( $pic_style == 'glow' ) {
			self::$args['styles'] .= "-moz-box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
				-webkit-box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
				box-shadow: 0 0 3px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);";
		}
		
		if( $pic_style == 'dropshadow' ) {
			self::$args['styles'] .= "
				-moz-box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
				-webkit-box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);
				box-shadow: 2px 3px 7px rgba({$rgb[0]},{$rgb[1]},{$rgb[2]},.3);";
		}
		
		if( $pic_borderradius ) {
			self::$args['styles'] .= sprintf( '-webkit-border-radius:%s;-moz-border-radius:%s;border-radius:%s;', self::$args['pic_borderradius'], self::$args['pic_borderradius'], self::$args['pic_borderradius'] );
		}			

		$inner_content = '';
		$social_icons_content = '';
		
		if( $picture ) {
			$picture = sprintf( '<img %s />', FusionCore_Plugin::attributes( 'person-shortcode-img' ) ) ;
		
			if ( $pic_link ) {
				$picture = sprintf( '<a %s>%s</a>', FusionCore_Plugin::attributes( 'person-shortcode-href' ), $picture ) ;
			}
			
			$picture =  sprintf( '<div %s><div %s>%s</div></div>', FusionCore_Plugin::attributes( 'person-shortcode-image-wrapper' ), 
								 FusionCore_Plugin::attributes( 'person-shortcode-image-container' ), $picture ) ;
			
		}
		
		if( $name || $title || $content ) {

			$social_networks = $this->get_social_links_array();

			if( ! is_array( $social_icon_order ) ) {
				$social_icon_order = explode( '|', $social_icon_order );
			}			
			//$social_networks = FusionCore_Plugin::order_array_like_array( $social_networks, $social_icon_order );
			
			$social_icon_colors = explode( '|', $social_icon_colors );
			$num_of_icon_colors = count( $social_icon_colors );
			
			$social_icon_boxed_colors = explode( '|', $social_icon_boxed_colors );
			$num_of_box_colors = count( $social_icon_boxed_colors );			
			
			$icons = '';

			if( isset( $smof_data['social_sorter'] ) && $smof_data['social_sorter'] ) {
				$order = $smof_data['social_sorter'];
				$ordered_array = explode(',', $order);
				
				if( isset( $ordered_array ) && $ordered_array && is_array( $ordered_array ) ) {
					$social_networks_old = $social_networks;
					$social_networks = array();
					foreach( $ordered_array as $key => $field_order ) {
						$field_order_number = str_replace(  'social_sorter_', '', $field_order );
						$find_the_field = $smof_data['social_sorter_' . $field_order_number];
						$field_name = str_replace( '_link', '', $smof_data['social_sorter_' . $field_order_number] );
						
						if( $field_name == 'google' ) {
							$field_name = 'googleplus';
						} elseif($field_name == 'email' ) {
							$field_name = 'mail';
						}

						if( ! isset( $social_networks_old[$field_name] ) ) {
							continue;
						}

						$social_networks[$field_name] = $social_networks_old[$field_name];
					}
				}
			}

			for( $i = 0; $i < count( $social_networks ); $i++ ) {
				if( $num_of_icon_colors == 1 ) {
					$social_icon_colors[$i] = $social_icon_colors[0];
				}
				
				if( $num_of_box_colors == 1 ) {
					$social_icon_boxed_colors[$i] = $social_icon_boxed_colors[0];
				}				
			}

			$i = 0;
			foreach( $social_networks as $network => $link ) {

				$icon_options = array( 
					'social_network' 	=> $network, 
					'social_link' 		=> $link, 
					'icon_color' 		=> $i < count( $social_icon_colors ) ? $social_icon_colors[$i] : '',
					'box_color' 		=> $i < count( $social_icon_boxed_colors ) ? $social_icon_boxed_colors[$i] : '',
				);

				$icons .= sprintf( '<a %s></a>', FusionCore_Plugin::attributes( 'person-shortcode-icon', $icon_options ) );
				$i++;
			}
			
			if( count( $social_networks ) > 0 ) {
				$social_icons_content = sprintf( '<div %s>%s</div>', FusionCore_Plugin::attributes( 'person-shortcode-social-networks' ), $icons );
			}
			
			$inner_content .= sprintf( '<div %s><div %s><div %s><span %s>%s</span><span %s>%s</span></div>%s</div><div %s>%s</div></div>', 
									   FusionCore_Plugin::attributes( 'person-desc' ), FusionCore_Plugin::attributes( 'person-shortcode-author' ), 
									   FusionCore_Plugin::attributes( 'person-author-wrapper' ), FusionCore_Plugin::attributes( 'person-name' ), $name,
									   FusionCore_Plugin::attributes( 'person-title' ), $title, $social_icons_content,
							  		   FusionCore_Plugin::attributes( 'person-content fusion-clearfix' ), do_shortcode( $content ) );				

		}
		
		$html = sprintf( '<div %s>%s%s</div>', FusionCore_Plugin::attributes( 'person-shortcode' ), $picture, $inner_content );

		return $html;

	}

	function attr() {

		$attr = array();

		$attr['class'] = 'fusion-person person';

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class']; 
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id']; 
		}

		return $attr;
		
	}
	
	function image_container_attr() {

		$attr = array();

		$attr['class'] = 'person-imgage-container';
		
		if( self::$args['pic_style'] == 'glow' ) {
			$attr['class'] .= ' glow';
		} else if( self::$args['pic_style'] == 'dropshadow' ) {
			$attr['class'] .= ' dropshadow';
		} else if( self::$args['pic_style'] == 'bottomshadow' ) {
			$attr['class'] .= ' element-bottomshadow';
		}

		$attr['style'] = self::$args['styles'];

		return $attr;
		
	}	
	
	function href_attr() {

		$attr = array();

		$attr['href'] = self::$args['pic_link'];
		
		if( self::$args['lightbox'] == 'yes' ) {
			$attr['class'] = 'lightbox-shortcode';
			$attr['href'] = self::$args['picture'];
		} else {
			$attr['target'] = self::$args['linktarget'];
		}

		return $attr;
		
	}
	
	function img_attr() {

		$attr = array();

		$attr['class'] = 'person-img img-responsive';
		
		$attr['style'] = '';
		
		if ( self::$args['pic_borderradius'] ) {
			$attr['style'] .= sprintf( '-webkit-border-radius:%s;-moz-border-radius:%s;border-radius:%s;', self::$args['pic_borderradius'], self::$args['pic_borderradius'], self::$args['pic_borderradius'] );
		}
		
		if ( self::$args['pic_bordersize'] ) {
			$attr['style'] .= sprintf( 'border:%s solid %s;', self::$args['pic_bordersize'], self::$args['pic_bordercolor'] );
		}

		$attr['src'] = self::$args['picture']; 

		$attr['alt'] = self::$args['name']; 

		return $attr;
		
	}

	function author_attr() {

		$attr = array();
		
		$attr['class'] = sprintf( 'person-author' );

		return $attr;
		
	}
	
	function social_networks_attr() {

		$attr['class'] = 'fusion-social-networks';
		
		if( self::$args['social_icon_boxed'] == 'yes' ) {
			$attr['class'] .= ' boxed-icons';
		}		

		return $attr;

	}	
	
	function icon_attr( $args ) {
		global $smof_data;

		$attr['class'] = sprintf( 'fusion-social-network-icon fusion-tooltip fusion-%s fusion-icon-%s', $args['social_network'], $args['social_network'] );	
	
		$link = $args['social_link'];
		
		if( $smof_data['social_icons_new'] ) {
			$target = '_blank';
		} else {
			$target = '_self';
		}	
		
		if( $args['social_network'] == 'mail' ) {
			$link = 'mailto:' . str_replace( 'mailto:', '', $args['social_link'] );
			$target = '_self';
		}
		
		$attr['href'] = $link;
		$attr['target'] = $target;
		
		if( $smof_data['nofollow_social_links'] ) {
			$attr['rel'] = 'nofollow';
		}
		
		$attr['style'] = '';
		
		if( $args['icon_color'] ) {
			$attr['style'] = sprintf( 'color:%s;', $args['icon_color'] );
		}
		
		if( self::$args['social_icon_boxed'] == 'yes' && 
			$args['box_color']
		) {
			$attr['style'] .= sprintf( 'background-color:%s;border-color:%s;', $args['box_color'], $args['box_color'] );	
		}		
		
		if( self::$args['social_icon_boxed'] == 'yes' &&
			self::$args['social_icon_boxed_radius'] || self::$args['social_icon_boxed_radius'] === '0'
		) {
			if( self::$args['social_icon_boxed_radius'] == 'round' ) {
				self::$args['social_icon_boxed_radius'] = '50%';
			}
		
			$attr['style'] .= sprintf( 'border-radius:%s;', self::$args['social_icon_boxed_radius'] );
		}			
		
		$attr['data-placement'] = self::$args['social_icon_tooltip'];
		$tooltip = $args['social_network'];
		if( $tooltip == 'googleplus' ) {
			$tooltip = 'Google+';
		}
		$attr['data-title'] = ucfirst( $tooltip );
		$attr['title'] = ucfirst( $tooltip );
		
		if( self::$args['social_icon_tooltip'] != 'none' ) {
			$attr['data-toggle'] = 'tooltip';
		}

		return $attr;

	}	 
	
	function get_social_links_array() {
	
		$social_links_array = array();
	
		if( self::$args['facebook'] ) {
			$social_links_array['facebook'] = self::$args['facebook'];
		}
		if( self::$args['twitter'] ) {
			$social_links_array['twitter'] = self::$args['twitter'];
		}
		if( self::$args['instagram'] ) {
			$social_links_array['instagram'] = self::$args['instagram'];
		}
		if( self::$args['linkedin'] ) {
			$social_links_array['linkedin'] = self::$args['linkedin'];
		}
		if( self::$args['dribbble'] ) {
			$social_links_array['dribbble'] = self::$args['dribbble'];
		}
		if( self::$args['rss'] ) {
			$social_links_array['rss'] = self::$args['rss'];
		}
		if( self::$args['youtube'] ) {
			$social_links_array['youtube'] = self::$args['youtube'];
		}
		if( self::$args['pinterest'] ) {
			$social_links_array['pinterest'] = self::$args['pinterest'];
		}
		if( self::$args['flickr'] ) {
			$social_links_array['flickr'] = self::$args['flickr'];
		}
		if( self::$args['vimeo'] ) {
			$social_links_array['vimeo'] = self::$args['vimeo'];
		}
		if( self::$args['tumblr'] ) {
			$social_links_array['tumblr'] = self::$args['tumblr'];
		}
		if( self::$args['googleplus'] ) {
			$social_links_array['googleplus'] = self::$args['googleplus'];
		}
		if( self::$args['google'] ) {
			$social_links_array['googleplus'] = self::$args['google'];
		}	
		if( self::$args['digg'] ) {
			$social_links_array['digg'] = self::$args['digg'];
		}
		if( self::$args['blogger'] ) {
			$social_links_array['blogger'] = self::$args['blogger'];
		}
		if( self::$args['skype'] ) {
			$social_links_array['skype'] = self::$args['skype'];
		}
		if( self::$args['myspace'] ) {
			$social_links_array['myspace'] = self::$args['myspace'];
		}
		if( self::$args['deviantart'] ) {
			$social_links_array['deviantart'] = self::$args['deviantart'];
		}
		if( self::$args['yahoo'] ) {
			$social_links_array['yahoo'] = self::$args['yahoo'];
		}
		if( self::$args['reddit'] ) {
			$social_links_array['reddit'] = self::$args['reddit'];
		}
		if( self::$args['forrst'] ) {
			$social_links_array['forrst'] = self::$args['forrst'];
		}
		if( self::$args['paypal'] ) {
			$social_links_array['paypal'] = self::$args['paypal'];
		}	
		if( self::$args['dropbox'] ) {
			$social_links_array['dropbox'] = self::$args['dropbox'];
		}	
		if( self::$args['soundcloud'] ) {
			$social_links_array['soundcloud'] = self::$args['soundcloud'];
		}					
		if( self::$args['vk'] ) {
			$social_links_array['vk'] = self::$args['vk'];
		}		
		if( self::$args['email'] ) {
			$social_links_array['mail'] = self::$args['email'];
		}
	
		return $social_links_array;
	
	} 

}

new FusionSC_Person();