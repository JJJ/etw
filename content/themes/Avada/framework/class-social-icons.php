<?php
/**
 * Social Icons Class
 *
 * WARNING: This file is part of the Fusion Core Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @package  Fusion/Framework
 * @author   ThemeFusion
 * @link	 http://theme-fusion.com
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	die;
}

// Don't duplicate me!
if( ! class_exists( 'Avada_SocialIcons' ) ) {

	class Avada_SocialIcons {

		public $args = array(
			'icon_order' => '',
			'icon_colors' => '',
			'box_colors' => '',
		);

		/**
		 * Initiate the class
		 */
		public function __construct() {

			add_filter( 'fusion_attr_social-icons-class-social-networks', array( $this, 'social_networks_attr' ) );	
			add_filter( 'fusion_attr_social-icons-class-icon', array( $this, 'icon_attr' ) );			

		}

		/**
		 * Renders all soical icons not belonging to shortcodes
		 *
		 * @since 3.5.0
		 * @param  array   $args Holding all necessarry data for social icons
		 * @return string  The HTML mark up for social icons, incl. wrapping container
		 */
		public function render_social_icons( $args ) {
			global $smof_data;
			
			$this->args = $args;

			if( isset( $this->args['sharingbox'] ) && $this->args['sharingbox'] == 'yes' ) {
				$social_networks = $this->get_sharingbox_social_links_array( $this->args );
			} elseif( isset( $this->args['authorpage'] ) && $this->args['authorpage'] == 'yes' ) {
				$social_networks = $this->get_authorpage_social_links_array( $this->args );
			} else {
				$social_networks = $this->get_social_links_array();		
			}
			
			/*if( ! array_key_exists( 'custom', $smof_data['social_icon_ordering'] ) ) {
				$smof_data['social_icon_ordering']['custom'] = array();
			}*/
			
			//$social_networks = $this->order_array_like_array( $social_networks, $smof_data['social_icon_ordering']['custom'] );
			//
			
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

			if( isset( $social_networks_old['custom'] ) && $social_networks_old['custom'] ) {
				$social_networks['custom'] = $social_networks_old['custom'];
			}

			$icon_colors = explode( '|', $this->args['icon_colors'] );
			$num_of_icon_colors = count( $icon_colors );

			$box_colors = explode( '|', $this->args['box_colors'] );
			$num_of_box_colors = count( $box_colors );		

			$html = $icons = '';

			for( $i = 0; $i < count( $social_networks ); $i++ ) {
				if( $num_of_icon_colors == 1 ) {
					$icon_colors[$i] = $icon_colors[0];
				}

				if( $num_of_box_colors == 1 ) {
					$box_colors[$i] = $box_colors[0];
				}				
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
				);

				if( isset( $icon_colors[$i] ) && $icon_colors[$i] ) {
					$icon_options['icon_color'] = $icon_colors[$i];
				} else {
					$icon_options['icon_color'] = '';
				}

				if( isset( $box_colors[$i] ) && $box_colors[$i] ) {
					$icon_options['box_color'] = $box_colors[$i];
				} else {
					$icon_options['box_color'] = '';
				}
				
				$icons .= sprintf( '<a %s>%s</a>', fusion_attr( 'social-icons-class-icon', $icon_options ), $custom );
				$i++;
			}			
			
			if( $icons ) {
				if( isset( $this->args['position'] ) && ( $this->args['position'] == 'header' ||
					$this->args['position'] == 'footer' )
				) {
					$html = sprintf( '<div %s>%s</div>', fusion_attr( 'social-icons-class-social-networks' ), $icons );	
				} else {
					$html = sprintf( '<div %s>%s<div class="fusion-clearfix"></div></div>', fusion_attr( 'social-icons-class-social-networks' ), $icons );	
				}
			}

			return $html;
		}

		function social_networks_attr() {

			$attr['class'] = 'fusion-social-networks';

			if( $this->args['icon_boxed'] == 'Yes' ) {
				$attr['class'] .= ' boxed-icons';
			}		

			return $attr;

		} 	

		function icon_attr( $args ) {
			global $smof_data;

			$attr = array();
			$attr['class'] = '';
			$attr['style'] = '';

			if( substr( $args['social_network'], 0, 7 ) === 'custom_' ) {
				$attr['class'] .= 'custom ';
				$tooltip = str_replace( 'custom_', '', $args['social_network'] );
				$args['social_network'] = strtolower( $tooltip );
			} else {
				$tooltip = ucfirst( $args['social_network'] );
			}

			$attr['class'] .= sprintf( 'fusion-social-network-icon fusion-tooltip fusion-%s fusion-icon-%s', $args['social_network'], $args['social_network'] );			

			$link = $args['social_link'];

			if( $this->args['linktarget'] ) {
				$attr['target'] = '_blank';
			}
			
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

			if( strtolower( $this->args['icon_boxed'] ) == 'yes' && 
				$args['box_color']
			) {
					$attr['style'] .= sprintf( 'background-color:%s;border-color:%s;', $args['box_color'], $args['box_color'] );	
			}			

			if( strtolower( $this->args['icon_boxed'] ) == 'yes' &&
				$this->args['icon_boxed_radius'] || $this->args['icon_boxed_radius'] === '0'
			) {
				if( $this->args['icon_boxed_radius'] == 'round' ) {
					$this->args['icon_boxed_radius'] = '50%';
				}

				$attr['style'] .= sprintf( 'border-radius:%s;', $this->args['icon_boxed_radius'] );
			}			

			if( strtolower( $this->args['tooltip_placement'] ) != 'none' ) {
				$attr['data-placement'] = strtolower( $this->args['tooltip_placement'] );
				if( $tooltip == 'Googleplus' ) {
					$tooltip = 'Google+';
				}
				$attr['data-title'] = $tooltip;
				$attr['data-toggle'] = 'tooltip';
			}
			
			$attr['title'] = $tooltip;

			return $attr;

		}	

		/**
		 * Sets up the array for social links that don't belong to sharing box.
		 *
		 * @since 3.5.0
		 * @return array  The social links array containing the social media and links to them.
		 */
		function get_social_links_array() {
			global $smof_data;

			$social_links_array = array();

			if( isset( $smof_data['facebook_link'] ) && $smof_data['facebook_link'] ) {
				$social_links_array['facebook'] = $smof_data['facebook_link'];
			}
			if( isset( $smof_data['twitter_link'] ) && $smof_data['twitter_link'] ) {
				$social_links_array['twitter'] = $smof_data['twitter_link'];
			}
			if( isset( $smof_data['linkedin_link'] ) && $smof_data['linkedin_link'] ) {
				$social_links_array['linkedin'] = $smof_data['linkedin_link'];
			}
			if( isset( $smof_data['dribbble_link'] ) && $smof_data['dribbble_link'] ) {
				$social_links_array['dribbble'] = $smof_data['dribbble_link'];
			}
			if( isset( $smof_data['rss_link'] ) && $smof_data['rss_link'] ) {
				$social_links_array['rss'] = $smof_data['rss_link'];
			}
			if( isset( $smof_data['youtube_link'] ) && $smof_data['youtube_link'] ) {
				$social_links_array['youtube'] = $smof_data['youtube_link'];
			}
			if( isset( $smof_data['instagram_link'] ) && $smof_data['instagram_link'] ) {
				$social_links_array['instagram'] = $smof_data['instagram_link'];
			}			
			if( isset( $smof_data['pinterest_link'] ) && $smof_data['pinterest_link'] ) {
				$social_links_array['pinterest'] = $smof_data['pinterest_link'];
			}
			if( isset( $smof_data['flickr_link'] ) && $smof_data['flickr_link'] ) {
				$social_links_array['flickr'] = $smof_data['flickr_link'];
			}
			if( isset( $smof_data['vimeo_link'] ) && $smof_data['vimeo_link'] ) {
				$social_links_array['vimeo'] = $smof_data['vimeo_link'];
			}
			if( isset( $smof_data['tumblr_link'] ) && $smof_data['tumblr_link'] ) {
				$social_links_array['tumblr'] = $smof_data['tumblr_link'];
			}
			if( isset( $smof_data['google_link'] ) && $smof_data['google_link'] ) {
				$social_links_array['googleplus'] = $smof_data['google_link'];
			}  
			if( isset( $smof_data['digg_link'] ) && $smof_data['digg_link'] ) {
				$social_links_array['digg'] = $smof_data['digg_link'];
			}
			if( isset( $smof_data['blogger_link'] ) && $smof_data['blogger_link'] ) {
				$social_links_array['blogger'] = $smof_data['blogger_link'];
			}
			if( isset( $smof_data['skype_link'] ) && $smof_data['skype_link'] ) {
				$social_links_array['skype'] = $smof_data['skype_link'];
			}
			if( isset( $smof_data['myspace_link'] ) && $smof_data['myspace_link'] ) {
				$social_links_array['myspace'] = $smof_data['myspace_link'];
			}
			if( isset( $smof_data['deviantart_link'] ) && $smof_data['deviantart_link'] ) {
				$social_links_array['deviantart'] = $smof_data['deviantart_link'];
			}
			if( isset( $smof_data['yahoo_link'] ) && $smof_data['yahoo_link'] ) {
				$social_links_array['yahoo'] = $smof_data['yahoo_link'];
			}
			if( isset( $smof_data['reddit_link'] ) && $smof_data['reddit_link'] ) {
				$social_links_array['reddit'] = $smof_data['reddit_link'];
			}
			if( isset( $smof_data['forrst_link'] ) && $smof_data['forrst_link'] ) {
				$social_links_array['forrst'] = $smof_data['forrst_link'];
			}
			if( isset( $smof_data['paypal_link'] ) && $smof_data['paypal_link'] ) {
				$social_links_array['paypal'] = $smof_data['paypal_link'];
			}	
			if( isset( $smof_data['dropbox_link'] ) && $smof_data['dropbox_link'] ) {
				$social_links_array['dropbox'] = $smof_data['dropbox_link'];
			}	
			if( isset( $smof_data['soundcloud_link'] ) && $smof_data['soundcloud_link'] ) {
				$social_links_array['soundcloud'] = $smof_data['soundcloud_link'];
			}				
			if( isset( $smof_data['vk_link'] ) && $smof_data['vk_link'] ) {
				$social_links_array['vk'] = $smof_data['vk_link'];
			}			
			if( isset( $smof_data['email_link'] ) && $smof_data['email_link'] ) {
				$social_links_array['mail'] = $smof_data['email_link'];
			}
			if( $smof_data['custom_icon_name'] && $smof_data['custom_icon_image'] && $smof_data['custom_icon_link'] ) {
				$social_links_array['custom'] = $smof_data['custom_icon_link'];
			}

			return $social_links_array;
		}

		/**
		 * Set up the array for sharing box social networks.
		 *
		 * @since 3.5.0
		 * @param  array  $args Holding all necessarry data for social icons
		 * @return array  The social links array containing the social media and links to them.
		 */
		function get_sharingbox_social_links_array( $args ) {	
			global $smof_data;

			$social_links_array = array();

				if( $smof_data['sharing_facebook'] ) {
					$social_link = 'http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;=' . $args['link'] . '&p&#91;images&#93;&#91;0&#93;=' . wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) . '&p&#91;title&#93;=' . rawurlencode( $args['title'] );
					$social_links_array['facebook'] = $social_link;
				}

				if( $smof_data['sharing_twitter'] ) {
					$social_link = 'https://twitter.com/share?text=' . rawurlencode( $args['title'] ) . '&url=' . rawurlencode( $args['link'] );
					$social_links_array['twitter'] = $social_link;
				}

				if( $smof_data['sharing_linkedin'] ) {
					$social_link = 'http://linkedin.com/shareArticle?mini=true&amp;url=' . $args['link'] . '&amp;title=' . rawurlencode( $args['title'] );
					$social_links_array['linkedin'] = $social_link;
				}

				if( $smof_data['sharing_reddit'] ) {
					$social_link = 'http://reddit.com/submit?url=' . $args['link'] . '&amp;title=' . rawurlencode( $args['title'] );
					$social_links_array['reddit'] = $social_link;
				}

				if( $smof_data['sharing_tumblr'] ) {
					$social_link = 'http://www.tumblr.com/share/link?url=' . rawurlencode( $args['link'] ) . '&amp;name=' . rawurlencode( $args['title'] ) .'&amp;description=' . rawurlencode( $args['description'] );
					$social_links_array['tumblr'] = $social_link;
				}

				if( $smof_data['sharing_google'] ) {
					$social_link = 'https://plus.google.com/share?url=' . $args['link'] . '" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;';
					$social_links_array['googleplus'] = $social_link;
				}

				if( $smof_data['sharing_pinterest'] ) {
					$social_link = 'http://pinterest.com/pin/create/button/?url=' . urlencode( $args['link'] ) . '&amp;description=' . rawurlencode( $args['description'] ) . '&amp;media=' . rawurlencode( $args['pinterest_image'] );
					$social_links_array['pinterest'] = $social_link;
				}

				if( $smof_data['sharing_vk'] ) {
					$social_link = sprintf( 'http://vkontakte.ru/share.php?url=%s&amp;title=%s&amp;description=%s', rawurlencode( $args['link'] ), rawurlencode( $args['title'] ), rawurlencode( $args['description'] ) );
					$social_links_array['vk'] = $social_link;
				}

				if( $smof_data['sharing_email'] ) {
					$social_link = 'mailto:?subject=' . $args['title'] . '&amp;body=' . $args['link'];
					$social_links_array['mail'] = $social_link;
				}

				return $social_links_array;
		}
		
		/**
		 * Set up the array for author page social networks.
		 *
		 * @since 3.5.0
		 * @param  array  $args Holding all necessarry data for social icons
		 * @return array  The social links array containing the social media and links to them.
		 */
		function get_authorpage_social_links_array( $args ) {	
			global $smof_data;

			$social_links_array = array();

				if( get_the_author_meta( 'author_facebook', $args['author_id'] ) ) {
					$social_links_array['facebook'] = get_the_author_meta( 'author_facebook', $args['author_id'] );
				}

				if( get_the_author_meta( 'author_twitter', $args['author_id'] ) ) {
					$social_links_array['twitter'] = get_the_author_meta( 'author_twitter', $args['author_id'] );
				}

				if( get_the_author_meta( 'author_linkedin', $args['author_id'] ) ) {
					$social_links_array['linkedin'] = get_the_author_meta( 'author_linkedin', $args['author_id'] );
				}
				
				if( get_the_author_meta( 'author_dribble', $args['author_id'] ) ) {
					$social_links_array['dribbble'] = get_the_author_meta( 'author_dribble', $args['author_id'] );
				}				

				if( get_the_author_meta( 'author_gplus', $args['author_id'] ) ) {
					$social_links_array['googleplus'] = get_the_author_meta( 'author_gplus', $args['author_id'] );
				}

				if( get_the_author_meta( 'email', $args['author_id'] ) ) {
					$social_links_array['mail'] = 'mailto:' . get_the_author_meta( 'email', $args['author_id'] );
				}

				return $social_links_array;
		}		

		/**
		 * Reorder a given array by the indices of another given array.
		 *
		 * @since 3.5.0
		 * @param  array  $to_be_ordered The array that will be reordered.
		 * @return array  $order_like The array that gives the ordering structure for $to_be_ordered.
		 */
		function order_array_like_array( Array $to_be_ordered, Array $order_like ) {
			$ordered = array();

			return $ordered;
		}	

	}
}
