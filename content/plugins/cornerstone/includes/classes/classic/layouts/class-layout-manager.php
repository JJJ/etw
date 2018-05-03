<?php
class Cornerstone_Layout_Manager extends Cornerstone_Plugin_Component {

	private $registry = array();
	protected $data_controller;
	protected $loaded = false;

	public function setup() {

		register_post_type( 'cs_user_templates', array(
			'public'          => false,
			'capability_type' => 'page',
			'supports'        => false
		));

    $this->element_migrations = $this->plugin->loadComponent( 'Element_Migrations' );
	}

	public function load() {
		$this->source_path = $this->path( 'includes/templates/' );
		$this->loadNativeBlocks();
		$this->loadNativePages();
		$this->loadUserLayouts();
		do_action( 'cornerstone_load_layout_templates', $this );
		$this->loaded = true;
	}

	public function ajax_templates() {
		return cs_send_json_success( $this->get_all() );
	}

	public function ajax_template_migration( $data ) {

		$result = $this->data_migration( $data );

		if ( is_wp_error( $result ) )
			return cs_send_json_error( array( 'message' => $result->get_error_message() ) );

		return cs_send_json_success( $result );

	}

	public function data_migration( $data ) {

		if ( !isset( $data['elements'] ) )
			return new WP_Error( 'cornerstone', 'Elements missing.' );

		$version = isset( $data['version'] ) ? $data['version'] : 0;

		$migrated = $this->element_migrations->migrate_classic( $data['elements'], $version );

		if ( is_wp_error( $migrated ) )
			return $migrated;

		return array( 'elements' => $migrated );

	}

	public function loadNativeBlocks() {

		if ( ! $this->plugin->common()->is_validated() ) return;

		foreach ( glob( $this->source_path . "block-*.php" ) as $filename ) {

			if ( !file_exists( $filename) )
				continue;

			$data = include( $filename );
			$data['type'] = 'block';
			$data['slug'] = 'themeco-' . trim( str_replace('.php', '', basename( $filename ) ) );
			$data['section'] = 'themeco-blocks';
			$version = ( isset( $data['version'] ) ) ? $data['version'] : 0;
			$data['elements'] = $this->element_migrations->migrate_classic( $data['elements'], $version );
			$this->registry[] = $data;

		}

	}

	public function loadNativePages() {

		if ( ! $this->plugin->common()->is_validated() ) return;

		foreach ( glob( $this->source_path . "page-*.php" ) as $filename ) {

			if ( !file_exists( $filename) )
				continue;

			$data = include( $filename );
			$data['type'] = 'page';
			$data['slug'] = 'themeco-' . trim( str_replace('.php', '', basename( $filename ) ) );
			$data['section'] = 'themeco-pages';
			$version = ( isset( $data['version'] ) ) ? $data['version'] : 0;
			$data['elements'] = $this->element_migrations->migrate_classic( $data['elements'], $version );
			$this->registry[] = $data;

		}

	}

	public function register( $data ) {
		if ( !is_array($data)
			|| !isset($data['slug'])
			|| !isset($data['type'])
			|| !isset($data['title'])
			||
			 !isset($data['elements']) ) {
			return new WP_Error( 'cornerstone', 'Template improperly formatted' );

		}

		$data['type'] =  ( $data['type'] == 'page' ) ? 'pages' : 'block';
		$post['section'] = ( $data['type'] == 'page' ) ? 'user-pages' : 'user-blocks';
		$version = ( isset( $data['version'] ) ) ? $data['version'] : 0;
		$data['elements'] = $this->element_migrations->migrate_classic( $data['elements'], $version );
		$this->registry[] = $data;

	}

	public function get_all() {
		if ( ! $this->loaded ) {
			$this->load();
		}
		return ( isset( $this->registry ) ) ? $this->registry : array();
	}

	public function ajax_save( $post ) {

		if ( ! current_user_can( 'edit_pages' ) ) {
			return cs_send_json_error( 'Capability mismatch.' );
		}

		if ( !isset( $post['elements'] ) )
			return cs_send_json_error( 'Missing element data.' );

		if ( !isset( $post['type'] ) )
			$post['type'] = 'block';

		if ( !isset( $post['title'] ) )
			$post['title'] = csi18n('common.untitled');

		$post['slug'] = uniqid( sanitize_key( $post['title'] ) . '_' );

		$title = $post['title'];
		$duplicates = 1;
		while ( !is_null( get_page_by_title( $title, ARRAY_N, 'cs_user_templates' ) ) ) {
			$title = sprintf( csi18n('common.ammended-title'), $post['title'], (string) $duplicates++ );
		}
		$post['title'] = $title;

		// SAVE
		$post_id = wp_insert_post( array(
			'post_title'  => $post['title'],
			'post_name'   => $post['slug'],
			'post_type'   => 'cs_user_templates',
			'post_status' => 'publish'
		) );

		update_post_meta( $post_id, 'cs_template_title', $post['title'] );
		update_post_meta( $post_id, 'cs_template_elements', $post['elements'] );
		update_post_meta( $post_id, 'cs_template_type', $post['type'] );
		update_post_meta( $post_id, 'cs_template_slug', $post['slug'] );
		update_post_meta( $post_id, 'cs_template_version', $this->plugin->version() );

		// Set section before responding so it can be added immediately
		$post['section'] = ( $post['type'] == 'page' ) ? 'user-pages' : 'user-blocks';

		$result = array( 'template' => $post );

		// Suppress PHP error output unless debugging
		return cs_send_json_success( $result );

	}

	public function ajax_delete( $post ) {

		if ( ! current_user_can( 'edit_pages' ) ) {
			return cs_send_json_error( 'Capability mismatch.' );
		}

		if ( !isset( $post['slug'] ) )
			return cs_send_json_error( 'Invalid request.' );

		$query = new WP_Query( array(
			'post_type'  => 'cs_user_templates',
			'meta_key'   => 'cs_template_slug',
			'meta_value' => $post['slug'],
			'posts_per_page' => 999,
			'post_status' => 'any'
		) );

		if ( $query->post && wp_delete_post( $query->post->ID, true ) ) {
			return cs_send_json_success();
		}

		return cs_send_json_error( 'Unable to delete template.' );

	}

	public function loadUserLayouts() {

		$query = new WP_Query( array(
			'post_type' => 'cs_user_templates',
			'posts_per_page' => 999,
			'post_status' => 'any'
		) );

		//var_dump($query->posts);die();

		foreach ($query->posts as $post) {
			$template = array(
				'title'    => get_post_meta( $post->ID, 'cs_template_title', true ),
				'elements' => get_post_meta( $post->ID, 'cs_template_elements', true ),
				'type'     => get_post_meta( $post->ID, 'cs_template_type', true ),
				'slug'     => get_post_meta( $post->ID, 'cs_template_slug', true ),

			);
			$version = get_post_meta( $post->ID, 'cs_template_version', true );
			$template['section'] = ( $template['type'] == 'page' ) ? 'user-pages' : 'user-blocks';
			$this->register( $template );
		}

		wp_reset_postdata();

	}
}
