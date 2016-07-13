<?php
class FusionSC_SharingBox {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'fusion_attr_sharingbox-shortcode', array( $this, 'attr' ) );
		add_filter( 'fusion_attr_sharingbox-shortcode-tagline', array( $this, 'tagline_attr' ) );
		add_filter( 'fusion_attr_sharingbox-shortcode-social-networks', array( $this, 'social_networks_attr' ) );
		add_filter( 'fusion_attr_sharingbox-shortcode-icon', array( $this, 'icon_attr' ) );

		add_shortcode( 'sharing', array( $this, 'render' ) );

	}

	/**
	 * Render the parent shortcode
	 * @param  array $args	Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {
		global $smof_data;
	   
		$defaults = FusionCore_Plugin::set_shortcode_defaults(
			array(
				'class' 				=> '',
				'id' 					=> '',			
				'backgroundcolor' 		=> strtolower( $smof_data['sharing_box_bg_color'] ),
				'description'			=> '',
				'icon_colors'			=> strtolower( $smof_data['sharing_social_links_icon_color'] ),
				'box_colors'			=> strtolower( $smof_data['sharing_social_links_box_color'] ),	
				'icons_boxed'			=> strtolower( $smof_data['sharing_social_links_boxed'] ),
				'icons_boxed_radius'	=> strtolower( $smof_data['sharing_social_links_boxed_radius'] ),		
				'link' 					=> '',
				'pinterest_image' 		=> '',
				'social_networks'		=> $this->get_theme_options_settings(),
				'tagline' 				=> __( 'Share This Story, Choose Your Platform!', 'fusion-core' ),
				'tagline_color'			=> strtolower( $smof_data['sharing_box_tagline_text_color'] ),
				'title' 				=> '',
				'tooltip_placement'		=> strtolower( $smof_data['sharing_social_links_tooltip_placement'] ),
			), $args
		);	

		extract( $defaults );

		self::$args = $defaults;

		$social_networks = explode( '|', $social_networks );	
		
		$icon_colors = explode( '|', $icon_colors );
		$num_of_icon_colors = count( $icon_colors );
		
		$box_colors = explode( '|', $box_colors );
		$num_of_box_colors = count( $box_colors );		
		
		$icons = '';

		if( isset( $smof_data['social_sorter'] ) && $smof_data['social_sorter'] ) {
			$order = $smof_data['social_sorter'];
			$ordered_array = explode(',', $order);
			
			if( isset( $ordered_array ) && $ordered_array && is_array( $ordered_array ) ) {
				foreach( $social_networks as $reorder_social_network ) {
					$social_networks_old[$reorder_social_network] = $reorder_social_network;
				}
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

					$social_networks[] = $social_networks_old[$field_name];
				}
			}
		}


		for( $i = 0; $i < count( $social_networks ); $i++ ) {
			if( $num_of_icon_colors == 1 ) {
				$icon_colors[$i] = $icon_colors[0];
			}
			
			
			if( $num_of_box_colors == 1 ) {
				$box_colors[$i] = $box_colors[0];
			}
			
			$icon_options = array( 
				'social_network' 	=> $social_networks[$i], 
				'icon_color' 		=> $i < count( $icon_colors ) ? $icon_colors[$i] : '',
				'box_color' 		=> $i < count( $box_colors ) ? $box_colors[$i] : '',
			);
		
			$icons .= sprintf( '<a %s></a>', FusionCore_Plugin::attributes( 'sharingbox-shortcode-icon', $icon_options ) );
		}

		$html = sprintf( '<div %s><h4 %s>%s</h4><div %s>%s</div></div>', FusionCore_Plugin::attributes( 'sharingbox-shortcode' ), FusionCore_Plugin::attributes( 'sharingbox-shortcode-tagline' ), 
						 $tagline, FusionCore_Plugin::attributes( 'sharingbox-shortcode-social-networks' ), $icons );

		return $html;

	}

	function attr() {

		$attr = array();

		$attr['class'] = 'share-box fusion-sharing-box';
		
		if( self::$args['icons_boxed'] == 'yes' ) {
			$attr['class'] .= ' boxed-icons';
		}
		
		if( self::$args['backgroundcolor'] ) {
			$attr['style'] = sprintf( 'background-color:%s;', self::$args['backgroundcolor'] );
		}

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		$attr['data-title'] = self::$args['title'];
		$attr['data-description'] = self::$args['description'];
		$attr['data-link'] = self::$args['link'];
		$attr['data-image'] = self::$args['pinterest_image'];

		return $attr;

	}
	   
	function tagline_attr() {

		$attr['class'] = 'tagline';

		if( self::$args['tagline_color'] ) {
			$attr['style'] = sprintf( 'color:%s;', self::$args['tagline_color'] );
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
	
		$description = self::$args['description'];
		$link = self::$args['link'];
		$title = self::$args['title'];	
		$image = rawurlencode( self::$args['pinterest_image'] );

		$attr['class'] = sprintf( 'fusion-social-network-icon fusion-tooltip fusion-%s fusion-icon-%s', $args['social_network'], $args['social_network'] );	
	
		$social_link = '';
		switch( $args['social_network'] ) {
			case 'facebook':
				$social_link = 'http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;=' . $link . '&p&#91;images&#93;&#91;0&#93;=' . wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) . '&p&#91;title&#93;=' . rawurlencode( $title );
				break;
			case 'twitter':
				$social_link = 'https://twitter.com/share?text=' . rawurlencode( $title ) . '&url=' . $link;
				break;
			case 'linkedin':
				$social_link = 'http://linkedin.com/shareArticle?mini=true&amp;url='.$link.'&amp;title='.$title;
				break;
			case 'reddit':
				$social_link = 'http://reddit.com/submit?url='.$link.'&amp;title='.$title;
				break;
			case 'tumblr':
				$social_link = 'http://www.tumblr.com/share/link?url='.rawurlencode($link).'&amp;name='.rawurlencode($title).'&amp;description='.rawurlencode($description);
				break;
			case 'googleplus':
				$social_link = 'https://plus.google.com/share?url='.$link.'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;';
				break;
			case 'pinterest':
				$social_link = 'http://pinterest.com/pin/create/button/?url='.rawurlencode( $link ).'&amp;description='.rawurlencode( $description ).'&amp;media='.$image;
				break;
			case 'vk':
				$social_link = sprintf( 'http://vkontakte.ru/share.php?url=%s&amp;title=%s&amp;description=%s', rawurlencode( $link ), rawurlencode( $title ), rawurlencode( $description ) );
				break;			
			case 'mail':
				$social_link = sprintf( 'mailto:?subject=%s&amp;body=%s', rawurlencode( $title ), rawurlencode( $link ) );
				break;
		}
		
		$attr['href'] = $social_link;
		
		if( $smof_data['social_icons_new'] ) {
			$target = '_blank';
		} else {
			$target = '_self';
		}
		
		if( $args['social_network'] == 'mail' ) {
			$target = '_self';
		}		
		
		$attr['target'] = $target;
		
		if( $smof_data['nofollow_social_links'] ) {
			$attr['rel'] = 'nofollow';
		}

		$attr['style'] = '';
		if( $args['icon_color'] ) {
			$attr['style'] = sprintf( 'color:%s;', $args['icon_color'] );
		}
		
		if( isset( self::$args['icons_boxed'] ) && self::$args['icons_boxed'] == 'yes' && 
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
		
		$attr['data-placement'] = self::$args['tooltip_placement'];
		$tooltip = $args['social_network'];
		if( $tooltip == 'googleplus' ) {
			$tooltip = 'Google+';
		}
		$attr['data-title'] = ucfirst( $tooltip );
		$attr['title'] = ucfirst( $tooltip );

		if( self::$args['tooltip_placement'] != 'none' ) {
			$attr['data-toggle'] = 'tooltip';
		}	

		return $attr;

	} 
	
	function get_theme_options_settings() {
		global $smof_data;
		$social_media = '';
		
			if( $smof_data['sharing_facebook'] ) {
				$social_media .= 'facebook|';
			}

			if( $smof_data['sharing_twitter'] ) {
				$social_media .= 'twitter|';
			}

			if( $smof_data['sharing_linkedin'] ) {
				$social_media .= 'linkedin|';
			}
			
			if( $smof_data['sharing_reddit'] ) {
				$social_media .= 'reddit|';
			}
			
			if( $smof_data['sharing_tumblr'] ) {
				$social_media .= 'tumblr|';
			}
			
			if( $smof_data['sharing_google'] ) {
				$social_media .= 'googleplus|';
			}
			
			if( $smof_data['sharing_pinterest'] ) {
				$social_media .= 'pinterest|';
			}
			
			if( $smof_data['sharing_vk'] ) {
				$social_media .= 'vk|';
			}			

			if( $smof_data['sharing_email'] ) {
				$social_media .= 'mail|';
			}
			
			$social_media = rtrim( $social_media, '|' );
			
			return $social_media;
	}
}

new FusionSC_SharingBox();