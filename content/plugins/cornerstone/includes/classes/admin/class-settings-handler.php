<?php

class Cornerstone_Settings_Handler extends Cornerstone_Plugin_Component {


	public function setup_controls() {

		$this->settings = CS()->settings();
		$controls = $this->plugin->config_group( 'admin/settings-controls' );

		foreach ($controls as $key => $value) {
			$controls[$key]['context'] = 'settings';
		}

		$this->controls = Cornerstone_Control_Group::factory( $controls );

	}

	public function render_form() {

		$controls = $this->controls->model_data();

		foreach ( $controls as $control ) {
			$this->view( 'admin/forms/field', true, array(
				'for'         => 'cs-control-' . $control['name'],
				'title'       => $control['ui']['title'],
				'description' => $control['ui']['description'],
				'control'     => $this->render_field( $control )
			), true );
		}

	}

	public function render_field( $control ) {
		return $this->view( $this->get_control_view( $control['type'] ), false, array(
			'name'    => $control['name'],
			'type'    => $control['type'],
			'value'   => $this->get_control_value( $control['name'] ),
			'options' => ( isset( $control['options'] ) ) ? $control['options'] : array()
		), true );
	}

	public function get_control_value( $name ) {
		if ( !isset( $this->transformed_settings ) ) {
			$this->transformed_settings = $this->controls->get_transformed_atts( $this->settings );
		}

		return ( isset( $this->transformed_settings[ $name ] ) ) ? $this->transformed_settings[ $name ] : null;

	}

	public function get_control_view( $type ) {

		if ( ! isset( $this->control_views ) ) {

			$this->control_views = array(
				'default'      => 'admin/forms/text',
				'checkbox'     => 'admin/forms/checkbox',
				'multi-select' => 'admin/forms/multi-select',
        'select'       => 'admin/forms/select',
        'text'         => 'admin/forms/text',
			);

		}

		return ( isset( $this->control_views[ $type ] ) ) ? $this->control_views[ $type ] : $this->control_views[ 'default' ];

	}

	public function get_role_choices() {

		$choices = array();

		$roles = get_editable_roles();
		$active_roles = array();

		foreach ( $roles as $name => $info ) {
			if ( 'administrator' === $name ) continue;
			$choices[] = array( 'value' => $name, 'label' => $info['name'] );
		}

		return $choices;

	}

	public function get_post_type_choices() {

		$choices = array();

		$post_types = get_post_types( array(
			'public'   => true,
			'show_ui' => true,
			'exclude_from_search' => false
		) , 'objects' );

		unset( $post_types['attachment'] );

		foreach ( $post_types as $name => $post_type ) {
			$choice = array( 'value' => $name );
			$choice['label'] = ( isset( $post_type->labels->name ) ) ? $post_type->labels->name : $name;
			$choices[] = $choice;
		}

		return $choices;

	}

	public function get_roles() {

		$roles = get_editable_roles();
		$active_roles = array();

		foreach ( $roles as $name => $info ) {
			if ( 'administrator' === $name ) continue;
			$active_roles[ $info['name'] ] = $name;
		}

		return $active_roles;
	}

	public function ajax_save( $data ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return cs_send_json_error();
		}

		$this->setup_controls();
		$data = $this->controls->sanitize( $data );

		if ( is_wp_error( $data ) ) {
			return cs_send_json_error( $data );
		}

		$settings = CS()->settings();

		foreach ( $data as $key => $value) {
			$settings[$key] = $value;
		}

    if ( isset( $settings['custom_app_slug'] ) ) {
      $settings['custom_app_slug'] = sanitize_title_with_dashes( $settings['custom_app_slug'] );
    }

		update_option( 'cornerstone_settings', $settings );

		return cs_send_json_success();

	}

}
