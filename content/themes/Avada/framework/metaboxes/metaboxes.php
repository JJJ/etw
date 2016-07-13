<?php
class PyreThemeFrameworkMetaboxes {

	public function __construct()
	{
		global $smof_data;
		$this->data = $smof_data;

		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'));
		add_action('admin_enqueue_scripts', array($this, 'admin_script_loader'));
	}

	// Load backend scripts
	function admin_script_loader() {
		global $pagenow;
		if (is_admin() && ($pagenow=='post-new.php' || $pagenow=='post.php')) {
			$theme_info = wp_get_theme();

			wp_enqueue_script('jquery.biscuit', get_template_directory_uri().'/framework/assets/js/jquery.biscuit.js', array('jquery'), $theme_info->get( 'Version' ));
			wp_register_script('avada_upload', get_template_directory_uri().'/framework/assets/js/upload.js', array('jquery'), $theme_info->get( 'Version' ));
			wp_enqueue_script('avada_upload');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
	   		wp_enqueue_style('thickbox');
		}
	}

	public function add_meta_boxes()
	{
		$post_types = get_post_types( array( 'public' => true ) );

		$disallowed = array( 'page', 'post', 'attachment', 'avada_portfolio', 'themefusion_elastic', 'product', 'wpsc-product', 'slide' );

		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type, $disallowed ) )
				continue;

			$this->add_meta_box('post_options', 'Avada Options', $post_type);
		}

		$this->add_meta_box('post_options', 'Fusion Page Options', 'post');

		$this->add_meta_box('page_options', 'Fusion Page Options', 'page');

		$this->add_meta_box('portfolio_options', 'Fusion Page Options', 'avada_portfolio');

		$this->add_meta_box('es_options', 'Elastic Slide Options', 'themefusion_elastic');

		$this->add_meta_box('woocommerce_options', 'Fusion Page Options', 'product');

		$this->add_meta_box('slide_options', 'Slide Options', 'slide');
	}

	public function add_meta_box($id, $label, $post_type)
	{
		add_meta_box(
			'pyre_' . $id,
			$label,
			array($this, $id),
			$post_type
		);
	}

	public function save_meta_boxes($post_id)
	{
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		foreach ( $_POST as $key => $value ) {
			if ( strstr( $key, 'pyre_') ) {
				update_post_meta( $post_id, $key, $value );
			}
		}
	}

	public function page_options()
	{
		$this->render_option_tabs( array( 'sliders', 'page', 'header', 'footer', 'sidebars', 'background', 'portfolio_page', 'pagetitlebar' ) );
	}
	
	public function post_options()
	{
		$this->render_option_tabs( array( 'post', 'page', 'sliders', 'header', 'footer', 'sidebars', 'background', 'pagetitlebar' ) );
	}	

	public function portfolio_options()
	{
		$this->render_option_tabs( array( 'portfolio_post', 'page', 'sliders', 'header', 'footer', 'sidebars', 'background', 'pagetitlebar' ) );
	}
	
	public function woocommerce_options()
	{
		$this->render_option_tabs( array( 'page', 'header', 'footer', 'sidebars', 'sliders', 'background', 'pagetitlebar' ), 'product' );
	}	

	public function es_options()
	{
		include 'options/options_es.php';
	}

	public function slide_options()
	{
		include 'options/options_slide.php';
	}
	
	public function render_option_tabs( $requested_tabs, $post_type = 'default' ) {
		$tabs_names = array(
			'sliders' 			=> __( 'Sliders', 'Avada' ),
			'page' 				=> __( 'Page', 'Avada' ),
			'post' 				=> __( 'Post', 'Avada' ),
			'header' 			=> __( 'Header', 'Avada' ),
			'footer' 			=> __( 'Footer', 'Avada' ),
			'sidebars' 			=> __( 'Sidebars', 'Avada' ),
			'background' 		=> __( 'Background', 'Avada' ),
			'portfolio' 		=> __( 'Portfolio', 'Avada' ),
			'pagetitlebar'		=> __( 'Page Title Bar', 'Avada' ),
			'portfolio_page' 	=> __( 'Portfolio', 'Avada' ),
			'portfolio_post' 	=> __( 'Portfolio', 'Avada' ),
			'product' 			=> __( 'Product', 'Avada' )
		);
	
		echo '<ul class="pyre_metabox_tabs">';
	
			foreach( $requested_tabs as $key => $tab_name ) {
				$class_active = '';
				if ( $key === 0 ) {
					$class_active = ' class="active"';
				}

				if ( $tab_name == 'page' && 
					 $post_type == 'product' 
				) {
					printf( '<li%s><a href="%s">%s</a></li>', $class_active, $tab_name, $tabs_names[$post_type] );
				} else {
					printf( '<li%s><a href="%s">%s</a></li>', $class_active, $tab_name, $tabs_names[$tab_name] );
				}
			}
		
		echo '</ul>';
		
		echo '<div class="pyre_metabox">';
		
		foreach( $requested_tabs as $key => $tab_name ) {
			printf( '<div class="pyre_metabox_tab" id="pyre_tab_%s">', $tab_name );
				require_once( sprintf( 'tabs/tab_%s.php', $tab_name ) );
			echo '</div>';
		}
		
		echo '</div>';
		echo '<div class="clear"></div>';
	}

	public function text($id, $label, $desc = '')
	{
		global $post;

		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<div class="pyre_desc">';
				$html .= '<label for="pyre_' . $id . '">';
				$html .= $label;
				$html .= '</label>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
			$html .= '<div class="pyre_field">';
				$html .= '<input type="text" id="pyre_' . $id . '" name="pyre_' . $id . '" value="' . get_post_meta($post->ID, 'pyre_' . $id, true) . '" />';
			$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	public function select($id, $label, $options, $desc = '')
	{
		global $post;

		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<div class="pyre_desc">';
				$html .= '<label for="pyre_' . $id . '">';
				$html .= $label;
				$html .= '</label>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
			$html .= '<div class="pyre_field">';
				$html .= '<div class="fusion-shortcodes-arrow">&#xf107;</div>';
				$html .= '<select id="pyre_' . $id . '" name="pyre_' . $id . '">';
				foreach($options as $key => $option) {
					if(get_post_meta($post->ID, 'pyre_' . $id, true) == $key) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}

					$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
				$html .= '</select>';
			$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	public function multiple($id, $label, $options, $desc = '')
	{
		global $post;

		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<div class="pyre_desc">';
				$html .= '<label for="pyre_' . $id . '">';
				$html .= $label;
				$html .= '</label>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
			$html .= '<div class="pyre_field">';
				$html .= '<select multiple="multiple" id="pyre_' . $id . '" name="pyre_' . $id . '[]">';
				foreach($options as $key => $option) {
					if(is_array(get_post_meta($post->ID, 'pyre_' . $id, true)) && in_array($key, get_post_meta($post->ID, 'pyre_' . $id, true))) {
						$selected = 'selected="selected"';
					} else {
						$selected = '';
					}

					$html .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
				$html .= '</select>';
			$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	public function textarea($id, $label, $desc = '', $default = '' )
	{
		global $post;

		$db_value = get_post_meta($post->ID, 'pyre_' . $id, true);

		if( metadata_exists( 'post', $post->ID, 'pyre_'. $id ) ) {
			$value = $db_value;
		} else {
			$value = $default;
		}

		$html = '';
		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<div class="pyre_desc">';
				$html .= '<label for="pyre_' . $id . '">';
				$html .= $label;
				$html .= '</label>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
			$html .= '<div class="pyre_field">';
				$rows = 10;
				if ( $id == 'heading' || 
					 $id == 'caption' 
				) {
					$rows = 5;
				} else if ( $id == 'page_title_custom_text' ||
							$id == 'page_title_custom_subheader'
				) {
					$rows = 1;
				}
				$html .= '<textarea cols="120" rows="' . $rows . '" id="pyre_' . $id . '" name="pyre_' . $id . '">' . $value . '</textarea>';
			$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	public function upload($id, $label, $desc = '')
	{
		global $post;

		$html = '';
		$html = '';
		$html .= '<div class="pyre_metabox_field">';
			$html .= '<div class="pyre_desc">';
				$html .= '<label for="pyre_' . $id . '">';
				$html .= $label;
				$html .= '</label>';
				if($desc) {
					$html .= '<p>' . $desc . '</p>';
				}
			$html .= '</div>';
			$html .= '<div class="pyre_field">';
				$html .= '<div class="pyre_upload">';
					$html .= '<div><input name="pyre_' . $id . '" class="upload_field" id="pyre_' . $id . '" type="text" value="' . get_post_meta($post->ID, 'pyre_' . $id, true) . '" /></div>';
					$html .= '<div class="fusion_upload_button_container"><input class="fusion_upload_button" type="button" value="Browse" /></div>';
				$html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

}

$metaboxes = new PyreThemeFrameworkMetaboxes;