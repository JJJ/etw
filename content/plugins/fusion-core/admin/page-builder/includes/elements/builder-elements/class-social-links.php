<?php
/**
 * SocialLinks element implementation, it extends DDElementTemplate like all other elements
 */
	class TF_SocialLinks extends DDElementTemplate {
		public function __construct() {
			
			parent::__construct();
		} 
		
		// Implementation for the element structure.
		public function create_element_structure() {
			
			// Add name of the class to deserialize it again when the element is sent back to the server from the web page
			$this->config['php_class'] 		= get_class($this);
			// element id
			$this->config['id']	   		= 'social_links';
			// element name
			$this->config['name']	 		= __('Social Links', 'fusion-core');
			// element icon
			$this->config['icon_url']  		= "icons/sc-text_block.png";
			// css class related to this element
			$this->config['css_class'] 		= "fusion_element_box";
			// element icon class
			$this->config['icon_class']		= 'fusion-icon builder-options-icon fusiona-link';
			// tooltip that will be displyed upon mouse over the element
			//$this->config['tool_tip']  		= 'Creates a Social Links Element';
			// any special html data attribute (i.e. data-width) needs to be passed
			// drop_level: elements with higher drop level can be dropped in elements with lower drop_level, 
			// i.e. element with drop_level = 2 can be dropped in element with drop_level = 0 or 1 only.
			$this->config['data'] 			= array("drop_level"   => "4");
		}

		// override default implemenation for this function as this element have special view
		public function create_visual_editor( $params ) {
			
			
			$innerHtml  = '<div class="fusion_iconbox textblock_element textblock_element_style">';
			$innerHtml .= '<div class="bilder_icon_container"><span class="fusion_iconbox_icon"><i class="fusiona-link"></i><sub class="sub">'.__('Social Links', 'fusion-core').'</sub></span></div>';
			$innerHtml .= '</div>';
			$this->config['innerHtml'] = $innerHtml;
		}
		
		//this function defines TextBlock sub elements or structure
		function popup_elements() {
			
			$reverse_choices			= FusionHelper::get_shortcode_choices_with_default();
			
			$this->config['subElements'] = array(
					 

				array("name" 			=> __('Boxed Social Icons', 'fusion-core'),
					  "desc" 			=> __('Choose to get a boxed icons. Choose default for theme option selection.', 'fusion-core'),
					  "id" 				=> "fusion_iconboxed",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "",
					  "allowedValues" 	=> $reverse_choices 
					  ),
					  
				array("name" 			=> __('Social Icon Box Radius', 'fusion-core'),
					  "desc" 			=> __('Choose the radius of the boxed icons. In pixels (px), ex: 1px, or "round". Leave blank for theme option selection.', 'fusion-core'),
					  "id" 				=> "fusion_iconboxedradius",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> "4px"
					  ),
					  
				array("name" 			=> __('Social Icon Custom Colors', 'fusion-core'),
					  "desc" 			=> __('Specify the color of social icons. Use one for all or separate by | symbol. ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 'fusion-core'),
					  "id" 				=> "fusion_iconcolor",
					  "type" 			=> ElementTypeEnum::TEXTAREA,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Social Icon Custom Box Colors', 'fusion-core'),
					  "desc" 			=> __('Specify the box color of social icons. Use one for all or separate by | symbol. ex: #AA0000|#00AA00|#0000AA. Leave blank for theme option selection.', 'fusion-core'),
					  "id" 				=> "fusion_boxcolor",
					  "type" 			=> ElementTypeEnum::TEXTAREA,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Social Icon Tooltip Position', 'fusion-core'),
					  "desc" 			=> __('Choose the display position for tooltips. Choose default for theme option selection.', 'fusion-core'),
					  "id" 				=> "fusion_icontooltip",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "",
					  "allowedValues" 	=> array('' 			=> 'Default',
												 'top' 			=> __('Top', 'fusion-core'),
												 'bottom' 		=> __('Bottom', 'fusion-core'),
												 'left' 		=> __('Left', 'fusion-core'),
												 'Right' 		=> __('Right', 'fusion-core')) 
					 ),
					 
					  
				array("name" 			=> __('Facebook Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Facebook link', 'fusion-core'),
					  "id" 				=> "fusion_facebook",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Twitter Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Twitter link', 'fusion-core'),
					  "id" 				=> "fusion_twitter",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),

		array("name"	  => __('Instagram Link', 'fusion-core'),
					  "desc"	  => __('Insert your custom Instagram link', 'fusion-core'),
					  "id"		=> "fusion_instagram",
					  "type"	  => ElementTypeEnum::INPUT,
					  "value"	   => ""
			),

				array("name" 			=> __('Dribbble Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Dribbble link', 'fusion-core'),
					  "id" 				=> "fusion_dribbble",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Google+ Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Google+ link', 'fusion-core'),
					  "id" 				=> "fusion_google",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('LinkedIn Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom LinkedIn link', 'fusion-core'),
					  "id" 				=> "fusion_linkedin",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Blogger Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Blogger link', 'fusion-core'),
					  "id" 				=> "fusion_blogger",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Tumblr Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Tumblr link', 'fusion-core'),
					  "id" 				=> "fusion_tumblr",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Reddit Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Reddit link', 'fusion-core'),
					  "id" 				=> "fusion_reddit",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Yahoo Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Yahoo link', 'fusion-core'),
					  "id" 				=> "fusion_yahoo",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Deviantart Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Deviantart link', 'fusion-core'),
					  "id" 				=> "fusion_deviantart",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Vimeo Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Vimeo link', 'fusion-core'),
					  "id" 				=> "fusion_vimeo",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Youtube Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Youtube link', 'fusion-core'),
					  "id" 				=> "fusion_youtube",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Pinterest Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Pinterest link', 'fusion-core'),
					  "id" 				=> "fusion_pinterest",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('RSS Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom RSS link', 'fusion-core'),
					  "id" 				=> "fusion_rss",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Digg Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Digg link', 'fusion-core'),
					  "id" 				=> "fusion_digg",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Flickr Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Flickr link', 'fusion-core'),
					  "id" 				=> "fusion_flickr",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Forrst Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Forrst link', 'fusion-core'),
					  "id" 				=> "fusion_forrst",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Myspace Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Myspace link', 'fusion-core'),
					  "id" 				=> "fusion_myspace",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),
					  
				array("name" 			=> __('Skype Link', 'fusion-core'),
					  "desc" 			=> __('Insert your custom Skype link', 'fusion-core'),
					  "id" 				=> "fusion_skype",
					  "type"			=> ElementTypeEnum::INPUT,
					  "value" 			=> ""
					  ),

		array("name"	  => __('PayPal Link', 'fusion-core'),
					  "desc"	  => __('Insert your custom PayPal link', 'fusion-core'),
					  "id"		=> "fusion_paypal",
					  "type"	  => ElementTypeEnum::INPUT,
					  "value"	   => ""
			),

		array("name"	  => __('Dropbox Link', 'fusion-core'),
					  "desc"	  => __('Insert your custom Dropbox link', 'fusion-core'),
					  "id"		=> "fusion_dropbox",
					  "type"	  => ElementTypeEnum::INPUT,
					  "value"	   => ""
			),

		array("name"	  => __('SoundCloud Link', 'fusion-core'),
					  "desc"	  => __('Insert your custom Soundcloud link', 'fusion-core'),
					  "id"		=> "fusion_soundcloud",
					  "type"	  => ElementTypeEnum::INPUT,
					  "value"	   => ""
			),

		array("name"	  => __('VK Link', 'fusion-core'),
					  "desc"	  => __('Insert your custom VK link', 'fusion-core'),
					  "id"		=> "fusion_vk",
					  "type"	  => ElementTypeEnum::INPUT,
					  "value"	   => ""
			),

		  array("name"	  => __('Email Address', 'fusion-core'),
					  "desc"	  => __('Insert an email address to display the email icon', 'fusion-core'),
					  "id"		=> "fusion_email",
					  "type"	  => ElementTypeEnum::INPUT,
					  "value"	   => ""
			),
					  
				array("name" 			=> __('Show Custom Social Icon', 'fusion-core'),
					  "desc" 			=> __('Show the custom social icon specified in Theme Options', 'fusion-core'),
					  "id" 				=> "fusion_show_custom",
					  "type" 			=> ElementTypeEnum::SELECT,
					  "value" 			=> "no",
					  "allowedValues" 	=> $reverse_choices 
					  ),

		  array("name"	  => __('Alignment', 'fusion-core'),
					  "desc"	  => __('Select the icon\'s alignment.', 'fusion-core'),
					  "id"		=> "fusion_alignment",
					  "type"	  => ElementTypeEnum::SELECT,
			"value"	   => "",
					  "allowedValues"   => array(''	  => __('Default', 'fusion-core'),
						   'left'	 => __('Left', 'fusion-core'),
											   'center'	  => __('Center', 'fusion-core'),
						 'right'	=> __('Right', 'fusion-core')) 
		   ),
					  
				array("name" 			=> __('CSS Class', 'fusion-core'),
					  "desc"			=> __('Add a class to the wrapping HTML element.', 'fusion-core'),
					  "id" 				=> "fusion_class",
					  "type" 			=> ElementTypeEnum::INPUT,
					  "value" 			=> "" 
					  ),
					  
				array("name" 			=> __('CSS ID', 'fusion-core'),
					  "desc"			=> __('Add an ID to the wrapping HTML element.', 'fusion-core'),
					  "id" 				=> "fusion_id",
					  "type" 			=> ElementTypeEnum::INPUT,
					  "value" 			=> "" 
					  ),
					 
				);
		}
	}