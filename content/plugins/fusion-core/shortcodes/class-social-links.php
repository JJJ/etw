<?php
class FusionSC_SocialLinks {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'fusion_attr_social-links-shortcode', array( $this, 'attr' ) );
		add_filter( 'fusion_attr_social-links-shortcode-social-networks', array( $this, 'social_networks_attr' ) );	
		add_filter( 'fusion_attr_social-links-shortcode-icon', array( $this, 'icon_attr' ) );	
		
		add_shortcode( 'social_links', array( $this, 'render' ) );

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
				'class'					=> '',			
				'id'					=> '',
				'icons_boxed'			=> strtolower( $smof_data['social_links_boxed'] ),
				'icons_boxed_radius' 	=> strtolower( $smof_data['social_links_boxed_radius'] ),
				'icon_colors'			=> strtolower( $smof_data['social_links_icon_color'] ),
				'box_colors'			=> strtolower( $smof_data['social_links_box_color'] ),
				'icon_order'			=> '',
				'show_custom'			=> 'no',
				'alignment'	  		=> '',
				'tooltip_placement'		=> strtolower( $smof_data['social_links_tooltip_placement'] ),
				'facebook' => '', 'twitter' => '', 'instagram' => '', 'linkedin' => '', 'dribbble' => '', 'rss' => '', 'youtube' => '', 'pinterest' => '', 'flickr' => '', 'vimeo' => '', 
				'tumblr' => '', 'google' => '', 'googleplus' => '', 'digg' => '', 'blogger' =>'', 'skype' => '', 'myspace' => '', 'deviantart' => '', 'yahoo' => '',
				'reddit' => '', 'forrst' => '', 'paypal' => '', 'dropbox' => '', 'soundcloud' => '', 'vk' => '', 'email' => '',
			), $args 
		);

		extract( $defaults );

		self::$args = $defaults;
		
		if( $smof_data['social_icons_new'] ) {
			self::$args['linktarget'] = '_blank';
		} else {
			self::$args['linktarget'] = '_self';
		}

		$social_networks = $this->get_social_links_array();
		if( ! is_array( $icon_order ) ) {
			$icon_order = explode( '|', $icon_order );
		}
		//$social_networks = FusionCore_Plugin::order_array_like_array( $social_networks, $icon_order );

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
			
		$icon_colors = explode( '|', $icon_colors );
		$num_of_icon_colors = count( $icon_colors );
		
		$box_colors = explode( '|', $box_colors );
		$num_of_box_colors = count( $box_colors );
		
		$icons = '';

		for( $i = 0; $i < count( $social_networks ); $i++ ) {
			if( $num_of_icon_colors == 1 ) {
				$icon_colors[$i] = $icon_colors[0];
			}
			
			if( $num_of_box_colors == 1 ) {
				$box_colors[$i] = $box_colors[0];
			}			
		}

		if( isset( $social_networks_old['custom'] ) && $social_networks_old['custom'] && $defaults['show_custom'] == 'yes' ) {
			$social_networks['custom'] = $social_networks_old['custom'];
		} else {
			unset( $social_networks['custom'] );
		}

		$i = 0;
		foreach( $social_networks as $network => $link ) {
			$custom = '';
			if( $network == 'custom' ) {
				$custom = sprintf( '<img src="%s" alt="%s" />', $smof_data['custom_icon_image'], $smof_data['custom_icon_name'] );
				
				$network = 'custom_' . $smof_data['custom_icon_name'];
				
			}			

			$icon_options = array( 
				'social_network' 	=> $network, 
				'social_link' 		=> $link, 
				'icon_color' 		=> $i < count( $icon_colors ) ? $icon_colors[$i] : '',
				'box_color' 		=> $i < count( $box_colors ) ? $box_colors[$i] : '',		
			);

			$icons .= sprintf( '<a %s>%s</a>', FusionCore_Plugin::attributes( 'social-links-shortcode-icon', $icon_options ), $custom );
			$i++;
		}
			
		$html = sprintf( '<div %s><div %s>%s</div></div>', FusionCore_Plugin::attributes( 'social-links-shortcode' ), FusionCore_Plugin::attributes( 'social-links-shortcode-social-networks' ), $icons );

		if( $alignment ) {
			$html = sprintf( '<div class="align%s">%s</div>', $alignment, $html );
		}

		return $html;

	}

	function attr() {

		$attr = array();

		$attr['class'] = 'fusion-social-links';

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class']; 
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id']; 
		}

		return $attr;
		
	}
	
	function social_networks_attr() {

		$attr['class'] = 'fusion-social-networks';
		
		if( self::$args['icons_boxed'] == 'yes' ) {
			$attr['class'] .= ' boxed-icons';
		}		

		return $attr;

	}	
	
	function icon_attr( $args ) {
		global $smof_data;

		$attr = array();
		$attr['class'] = '';
		
		if( substr( $args['social_network'], 0, 7 ) === 'custom_' ) {
			$attr['class'] .= 'custom ';
			$tooltip = str_replace( 'custom_', '', $args['social_network'] );
			$args['social_network'] = strtolower( $tooltip );
		} else {
			$tooltip = ucfirst( $args['social_network'] );
		}

		$attr['class'] .= sprintf( 'fusion-social-network-icon fusion-tooltip fusion-%s fusion-icon-%s', $args['social_network'], $args['social_network'] );			

		$link = $args['social_link'];

		$attr['target'] = self::$args['linktarget'];

		if( $args['social_network'] == 'mail' ) {
			$link = 'mailto:' . str_replace( 'mailto:', '', $args['social_link'] );
			$attr['target'] = '_self';
		}

		$attr['href'] = $link;
		
		if( $smof_data['nofollow_social_links'] ) {
			$attr['rel'] = 'nofollow';
		}
	
		if( $args['icon_color'] ) {
			$attr['style'] = sprintf( 'color:%s;', $args['icon_color'] );
		}
		
		if( self::$args['icons_boxed'] == 'yes' && 
			$args['box_color']
		) {
				$attr['style'] .= sprintf( 'background-color:%s;border-color:%s;', $args['box_color'], $args['box_color'] );	
		}	
		
		if( self::$args['icons_boxed'] == 'yes' &&
			self::$args['icons_boxed_radius'] || self::$args['icons_boxed_radius'] === '0'
		) {
			if( self::$args['icons_boxed_radius'] == 'round' ) {
				self::$args['icons_boxed_radius'] = '50%';
			}
		
			$attr['style'] .= sprintf( 'border-radius:%s;', self::$args['icons_boxed_radius'] );
		}			
				
		if( strtolower( self::$args['tooltip_placement'] ) != 'none' ) {
			$attr['data-placement'] = strtolower( self::$args['tooltip_placement'] );
			if( $tooltip == 'Googleplus' ) {
				$tooltip = 'Google+';
			}			
			$attr['data-title'] = $tooltip;
			$attr['data-toggle'] = 'tooltip';
		}
		
		$attr['title'] = $tooltip;

		return $attr;

	}	 
	
	function get_social_links_array() {
		global $smof_data;
	
		$social_links_array = array();
	
		if( isset( self::$args['facebook'] ) && self::$args['facebook'] ) {
			$social_links_array['facebook'] = self::$args['facebook'];
		}
		if( isset( self::$args['twitter'] ) && self::$args['twitter'] ) {
			$social_links_array['twitter'] = self::$args['twitter'];
		}
		if( isset( self::$args['linkedin'] ) && self::$args['linkedin'] ) {
			$social_links_array['linkedin'] = self::$args['linkedin'];
		}
		if( isset( self::$args['dribbble'] ) && self::$args['dribbble'] ) {
			$social_links_array['dribbble'] = self::$args['dribbble'];
		}
		if( isset( self::$args['rss'] ) && self::$args['rss'] ) {
			$social_links_array['rss'] = self::$args['rss'];
		}
		if( isset( self::$args['youtube'] ) && self::$args['youtube'] ) {
			$social_links_array['youtube'] = self::$args['youtube'];
		}
		if( isset( self::$args['instagram'] ) && self::$args['instagram'] ) {
			$social_links_array['instagram'] = self::$args['instagram'];
		}			
		if( isset( self::$args['pinterest'] ) && self::$args['pinterest'] ) {
			$social_links_array['pinterest'] = self::$args['pinterest'];
		}
		if( isset( self::$args['flickr'] ) && self::$args['flickr'] ) {
			$social_links_array['flickr'] = self::$args['flickr'];
		}
		if( isset( self::$args['vimeo'] ) && self::$args['vimeo'] ) {
			$social_links_array['vimeo'] = self::$args['vimeo'];
		}
		if( isset( self::$args['tumblr'] ) && self::$args['tumblr'] ) {
			$social_links_array['tumblr'] = self::$args['tumblr'];
		}
		if( isset( self::$args['googleplus'] ) && self::$args['googleplus'] ) {
			$social_links_array['googleplus'] = self::$args['googleplus'];
		}
		if( isset( self::$args['google'] ) && self::$args['google'] ) {
			$social_links_array['googleplus'] = self::$args['google'];
		}	
		if( isset( self::$args['digg'] ) && self::$args['digg'] ) {
			$social_links_array['digg'] = self::$args['digg'];
		}
		if( isset( self::$args['blogger'] ) && self::$args['blogger'] ) {
			$social_links_array['blogger'] = self::$args['blogger'];
		}
		if( isset( self::$args['skype'] ) && self::$args['skype'] ) {
			$social_links_array['skype'] = self::$args['skype'];
		}
		if( isset( self::$args['myspace'] ) && self::$args['myspace'] ) {
			$social_links_array['myspace'] = self::$args['myspace'];
		}
		if( isset( self::$args['deviantart'] ) && self::$args['deviantart'] ) {
			$social_links_array['deviantart'] = self::$args['deviantart'];
		}
		if( isset( self::$args['yahoo'] ) && self::$args['yahoo'] ) {
			$social_links_array['yahoo'] = self::$args['yahoo'];
		}
		if( isset( self::$args['reddit'] ) && self::$args['reddit'] ) {
			$social_links_array['reddit'] = self::$args['reddit'];
		}
		if( isset( self::$args['forrst'] ) && self::$args['forrst'] ) {
			$social_links_array['forrst'] = self::$args['forrst'];
		}
		if( isset( self::$args['paypal'] ) && self::$args['paypal'] ) {
			$social_links_array['paypal'] = self::$args['paypal'];
		}	
		if( isset( self::$args['dropbox'] ) && self::$args['dropbox'] ) {
			$social_links_array['dropbox'] = self::$args['dropbox'];
		}	
		if( isset( self::$args['soundcloud'] ) && self::$args['soundcloud'] ) {
			$social_links_array['soundcloud'] = self::$args['soundcloud'];
		}			
		if( isset( self::$args['vk'] ) && self::$args['vk'] ) {
			$social_links_array['vk'] = self::$args['vk'];
		}		
		if( self::$args['email'] ) {
			$social_links_array['mail'] = self::$args['email'];
		}
		if( self::$args['show_custom'] ) {
			$social_links_array['custom'] = $smof_data['custom_icon_link'];
		}
		
		return $social_links_array;
	
	}  

}

new FusionSC_SocialLinks();