<?php
/**
 * 1. Setup definition.php with `ui` function
 * 2. Create defaults.php with keys for the attributes to be used
 * 3. Create controls.php to map controls. If dynamic options are needed, use
 * 		`$this->control_options('key_name')` so they can be fetched later
 * 4. Setup a condition_filter method returning true/false for every key in defaults
 * 5. Setup get_data method returning any information already stored (don't return defaults)
 */

class CS_Settings_General {

	public $priority = 10;
	public $manager;

	public function ui() {
		return array( 'title' => __( 'General', 'cornerstone' ) );
	}

	public function condition_filter( $key ) {

		global $post;

		if ( 'custom_js' === $key ) {
			return current_user_can( 'unfiltered_html' );
		}

		if ( 'post_title' === $key ) {
			return post_type_supports( $post->post_type, 'title' );
		}

		if ( 'post_status' === $key ) {
			return current_user_can( $this->manager->post_type_object->cap->publish_posts );
		}

		if ( 'manual_excerpt' === $key ) {
			return post_type_supports( $post->post_type, 'excerpt' );
		}

		if ( 'allow_comments' === $key ) {
			return post_type_supports( $post->post_type, 'comments' );
		}

		$has_page_attributes = post_type_supports( $post->post_type, 'page-attributes' );

		if ( 'post_parent' === $key ) {
			return ( $has_page_attributes && $this->manager->post_type_object->hierarchical );
		}

		if ( 'page_template' === $key ) {
			return ( $has_page_attributes && count( wp_get_theme()->get_page_templates( $post ) ) > 0 );
		}

		// Give a pass to anything else (custom_css)
		return true;

	}

	public function get_data( $key ) {

		global $post;

		$settings = array();

		if ( isset( $this->manager->post_meta['_cornerstone_settings'] ) ) {
			$settings = cs_maybe_json_decode( maybe_unserialize( $this->manager->post_meta['_cornerstone_settings'][0] ) );
			$settings = ( is_array( $settings ) ) ? $settings : array();
		}

		if ( 'custom_css' === $key && isset( $settings['custom_css'] ) ) {
			return $settings['custom_css'];
		}

		if ( 'custom_js' === $key && isset( $settings['custom_js'] ) ) {
			return $settings['custom_js'];
		}

		if ( 'post_title' === $key && isset( $post->post_title ) ) {
			return $post->post_title;
		}

		if ( 'post_status' === $key && isset( $post->post_status ) ) {
			return $post->post_status;
		}

		if ( 'allow_comments' === $key && isset( $post->comment_status ) ) {
			return ( 'open' === $post->comment_status );
		}

		if ( 'manual_excerpt' === $key && isset( $post->post_excerpt ) ) {
			return ( $post->post_excerpt );
		}

		if ( 'post_parent' === $key && isset( $post->post_parent ) ) {
			return "{$post->post_parent}";
		}

		if ( 'page_template' === $key && isset( $this->manager->post_meta['_wp_page_template'] ) ) {
			return $this->manager->post_meta['_wp_page_template'][0];
		}

		return null;

	}

	public function post_status_choices() {

		if ( ! $this->manager->can_use( 'post_status' ) ) {
			return null;
		}

		global $post;
		$choices = array();

		$choices[] = array( 'value' => 'publish', 'label' => __( 'Publish', 'cornerstone' ) );

		switch ($post->post_status) {
			case 'private':
				$choices[] = array( 'value' => 'private', 'label' => __( 'Privately Published', 'cornerstone' ) );
				break;
			case 'future':
				$choices[] = array( 'value' => 'future', 'label' => __( 'Scheduled', 'cornerstone' ) );
				break;
			case 'pending':
				$choices[] = array( 'value' => 'pending', 'label' => __( 'Pending Review', 'cornerstone' ) );
				break;
			default:
				$choices[] = array( 'value' => 'draft', 'label' => __( 'Draft', 'cornerstone' ) );
				break;
		}

		return $choices;

	}

	public function post_parent_markup() {

		if ( ! $this->manager->can_use( 'post_status' ) ) {
			return null;
		}

		global $post;

		$dropdown_args = array(
			'post_type'        => $post->post_type,
			'exclude_tree'     => $post->ID,
			'selected'         => $post->post_parent,
			'name'             => 'parent_id',
			'show_option_none' => __( '(no parent)', 'cornerstone' ),
			'sort_column'      => 'menu_order, post_title',
			'echo'             => 0,
		);

		return wp_dropdown_pages( apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post ) );

	}

	public function page_template_choices() {

		if ( ! $this->manager->can_use( 'post_status' ) ) {
			return null;
		}

		global $post;

		$choices = array();
		$page_templates = wp_get_theme()->get_page_templates( $post );
		ksort( $page_templates );

		$choices[] = array( 'value' => 'default', 'label' => apply_filters( 'default_page_template_title',  __( 'Default Template' ), 'cornerstone' ) );

		foreach ($page_templates as $value => $label) {
			$choices[] = array( 'value' => $value, 'label' => $label );
		}

		return $choices;

	}

	public function handler( $data, $content = null ) {

		global $post;
		$settings = CS()->common()->get_post_settings( $post->ID );

		$update = array();

		if ( isset( $data['post_title'] ) ) {
			$update['post_title'] = $data['post_title'];
		}

		if ( isset( $data['allow_comments'] ) ) {
			$update['comment_status'] = ( true === $data['allow_comments'] ) ? 'open' : 'closed';
		}

		if ( post_type_supports( $post->post_type, 'excerpt' ) && isset( $data['manual_excerpt'] ) ) {
			$update['post_excerpt'] = $data['manual_excerpt'];
		}

		if ( isset( $data['post_status'] ) && current_user_can( $this->manager->post_type_object->cap->publish_posts ) ) {
      $content->set_post_status( $data['post_status'] );
		}

		if ( post_type_supports( $post->post_type, 'page-attributes' ) ) {

			$page_templates = wp_get_theme()->get_page_templates( $post );

			$update['page_template'] = 'default';

			if ( isset( $data['page_template'] ) && isset( $page_templates[ $data['page_template'] ] ) ) {
				$update['page_template'] = $data['page_template'];
			}

			if ( isset( $data['post_parent'] ) ) {
				$update['post_parent'] = (int) $data['post_parent'];
			}

		}

		if ( isset( $data['custom_css'] ) ) {
			$settings['custom_css'] = $data['custom_css'];
		}

		// Update Custom JS
		if ( isset( $data['custom_js'] ) && current_user_can( 'unfiltered_html' ) ) {
			$settings['custom_js'] = $data['custom_js'];
		}

		if ( ! empty( $update ) ) {

			$update['ID'] = $post->ID;
			$result = wp_update_post( $update, true );

			if ( is_wp_error( $result ) ) {
				return $result;
			}

		}

		cs_update_serialized_post_meta( $post->ID, '_cornerstone_settings', $settings );

	}

}
