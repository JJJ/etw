<?php

class Cornerstone_Updates extends Cornerstone_Plugin_Component {

	protected $plugin_file =  'cornerstone/cornerstone.php';

	public function setup() {

		if ( ! is_admin() ) return;

    add_filter( 'http_request_args', array( $this, 'http_request_args' ), 10, 2 );

		add_filter( 'themeco_update_api', array( $this, 'register' ), -100 );
    add_filter( 'themeco_update_cache', array( $this, 'cache_updates' ), 10, 2 );

		if ( isset( $_GET['force-check'] ) ) {
			delete_site_transient( 'update_plugins' );
		}

		add_action( 'plugins_api', array( $this, 'plugins_api' ), 100, 3 );
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'pre_set_site_transient_update_plugins' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'add_script_data' ), -100 );

	}

	public function add_script_data() {
		$this->plugin->component( 'Admin' )->add_script_data( 'cs-updates', array( $this, 'script_data' ) );
	}

  public function ajax_update_check() {

  	if ( ! current_user_can( 'update_plugins' ) ) {
      return cs_send_json_error();
    }

    delete_site_transient( 'update_plugins' );
    cs_tco()->updates()->refresh();
    $errors = cs_tco()->updates()->get_errors();

    if ( empty( $errors ) ) {
      return cs_send_json_success( array(
        'latest' => esc_html( $this->get_latest_version() )
      ) );
    }

    return cs_send_json_error( array( 'errors' => $errors ) );

  }

  public function script_data() {
    return array(
      'complete'    => csi18n('admin.plugin-update-nothing'),
      'completeNew' => csi18n('admin.plugin-update-new'),
      'error'       => csi18n('admin.plugin-update-error'),
      'checking'    => csi18n('admin.plugin-update-checking'),
      'latest'      => esc_html( $this->get_latest_version() )
    );
  }

	public function get_plugin_data( $use_local_defaults = true ) {

		$data = cs_tco()->updates()->get_update_cache();

		$cornerstone = ( isset( $data['plugins'] ) && isset( $data['plugins'][ $this->plugin_file ] ) ) ? $data['plugins'][ $this->plugin_file ] : array();
		$defaults = array();

		if ( $use_local_defaults ) {
			$defaults = array(
				'slug' => 'cornerstone',
				'name' => $this->plugin->common()->properTitle(),
				'new_version' => CS()->version(),
				'author' => '<a href="http://theme.co/cornerstone/">Themeco</a>'
			);
		}

		return wp_parse_args( $cornerstone, $defaults );

	}

	public function get_latest_version() {

		$data = $this->get_plugin_data();
		return $data['new_version'];

  }

	public function plugins_api( $res, $action, $args ) {

		if ( ! isset( $args->slug ) || 'cornerstone' !== $args->slug ) {
			return $res;
		}

		$data = $this->get_plugin_data();

		$result = array(
			'slug'    => $data['slug'],
			'name'    => $data['name'],
			'author'  => $data['author'],
			'version' => $data['new_version'],
			'sections' => array(
				'changelog' => csi18n('admin.plugin-update-changelog')
			)
		);

		if ( 'query_plugins' === $action || 'plugin_information' === $action ) {
			$result = (object) $result;
		}

		return $result;

	}

	public function pre_set_site_transient_update_plugins( $data ) {

		cs_tco()->updates()->refresh();
		$remote = $this->get_plugin_data();

		if ( empty( $remote ) ) {
			return $data;
		}

		include_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		$installed_plugins = get_plugins();

		if ( ! isset( $installed_plugins[ $this->plugin_file ] ) ) {
			return $data;
		}

		$local = $installed_plugins[ $this->plugin_file ];

		// Version check
		if ( version_compare( $remote['new_version'], $local['Version'], '>' ) ) {

			if ( ! $remote['package'] ) {
				$remote['upgrade_notice'] = sprintf( csi18n('admin.plugin-update-notice'), admin_url( 'admin.php?page=cornerstone-home' ) );
			}

			$data->response[ $this->plugin_file ] = (object) $remote;

		}

		return $data;

	}

	public function register( $args ) {

		$args['api-key'] = esc_attr( get_option( 'cs_product_validation_key', '' ) );
		$args['cs-version'] = CS()->version();
		$args['php-version'] = PHP_VERSION;

		return $args;
  }

  public function cache_updates( $updates, $data ) {

		if ( !isset( $updates['plugins'] ) ) {
			$updates['plugins'] = array();
		}

    if ( isset( $data['error'] ) ) {
      delete_option( 'cs_product_validation_key' );
      delete_site_transient( 'update_plugins' );
    }

		$plugin_updates = array();

		if ( isset( $data['plugins'] ) && isset( $data['plugins']['cornerstone'] ) ) {
			$plugin = $data['plugins']['cornerstone'];
			$plugin_updates[$plugin['plugin']] = $plugin;
		}

		$updates['plugins'] = array_merge( $updates['plugins'], $plugin_updates );

		return $updates;

  }

	public function decode( $data ) {
		return $this->api->is_serial ? (array) unserialize( $data ) : json_decode( $data, true );
	}

	public function encode( $data ) {
		if ( $this->api->is_serial ) {
			return serialize( $this->api->is_plugin ? (object) $data : $data );
		}
		return json_encode( $data );
	}

	public function http_request_args( $request_args, $url ) {
		$this->api = $this->get_api( $url );
		if ( empty( $this->api ) ) {
			return $request_args;
		}
		$data = $this->decode( $request_args['body'][ $this->api->type ] );
		if ( $this->api->is_plugin ) {
			$data = $this->filter_plugins( $data );
		} elseif ( $this->api->is_theme ) {
			$data = $this->filter_themes( $data );
		}
		$request_args['body'][ $this->api->type ] = $this->encode( $data );
		return $request_args;
	}

	public function get_api( $url ) {
		static $regex = '#://api\.wordpress\.org/(?P<type>plugins|themes)/update-check/(?P<version>[0-9.]+)/#';
		$match = preg_match( $regex, $url, $api );
		if ( $match ) {
			$api['is_serial'] = ( 1.0 == (float) $api['version'] );
			$api['is_plugin'] = ( 'plugins' === $api['type'] );
			$api['is_theme']  = ( 'themes' === $api['type'] );
			return (object) $api;
		}
		return false;
	}

	public function filter_plugins( $data ) {
		foreach ( $data['plugins'] as $file => $plugin ) {
			$path = trailingslashit( WP_PLUGIN_DIR . '/' . dirname( $file ) ); // TODO files without dir?
      if ( in_array( $file, array($this->plugin_file), true ) ) {
				unset( $data['plugins'][ $file ] );
				unset( $data['active'][ array_search( $file, $data['active'] ) ] );
			}
		}
		return $data;
	}

	public function filter_themes( $data ) {
		foreach ( $data['themes'] as $slug => $theme ) {
			$path = trailingslashit( wp_get_theme( $slug )->get_stylesheet_directory() );
      if ( in_array( $slug, array('x', 'pro'), true ) ) {
				unset( $data['themes'][ $slug ] );
			}
		}
		return $data;
	}
}
