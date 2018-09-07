<?php

class Cornerstone_App_Permissions extends Cornerstone_Plugin_Component {

  protected $role_defaults;
  protected $cache = array();

  public function setup() {
    $this->role_defaults = apply_filters('cs_app_permission_defaults', $this->config_group( 'app/permission-role-defaults' ) );
  }

  public function get_user_permissions( $user_id = null ) {

    if ( ! $user_id ) {
      $user_id = get_current_user_id();
    }

    if ( ! $user_id ) {
      return array();
    }

    $user_key = "u$user_id";

    $roles = $this->get_user_roles( $user_id );

    if ( ! isset( $this->cache[$user_key] ) ) {
      $this->cache[$user_key] = $this->get_role_permissions( $roles );
      $this->cache[$user_key]['manage_options'] = user_can( $user_id, 'manage_options');
      $this->cache[$user_key]['unfiltered_html'] = user_can( $user_id, 'unfiltered_html');
    }

    $permissions = array();

    return $this->cache[$user_key];

  }

  public function user_can( $permission, $user_id = null ) {

    if ( ! is_string( $permission ) ) {
      return false;
    }

    $permissions = $this->get_user_permissions( $user_id );

    $parts = explode('.', $permission);

    $next = array();
    $dynamic = array(
      'content' => '{post-type}',
      'element' => '{id}'
    );

    $implicit = array( 'element', 'preference' );

    while ( count( $parts ) ) {

      $segment = array_shift( $parts );
      $check = implode('.', $next) . ".$segment";
      $check = trim($check, '.');

      if ( ! isset( $permissions[$check] ) && isset( $next[0] ) && isset( $dynamic[$next[0]] ) ) {
        $test = array( $next[0], $dynamic[$next[0]] );
        if ( count( $next ) > 1 ) {
          $test[] = $segment;
        }
        $check = implode('.', $test );

      }

      $next[] = $segment;

      $test = isset( $permissions[$check] ) ? $permissions[$check] : null;
      if ( ! in_array( $next[0], $implicit, true) ) {
        $test = (bool) $test;
      }

      if ( ! isset( $dynamic[$segment] ) && false === $test ) {
        return false;
      }

    }

    return true;

  }

  public function get_user_post_types( $user_id = null ) {

    $permissions = $this->get_user_permissions( $user_id = null );
    $types = array();

    foreach ($permissions as $key => $value) {

      if ( 0 !== strpos( $key, 'content.' ) ) {
        continue;
      }

      $parts = explode('.', $key);

      if ( count( $parts ) > 2 || in_array( $parts[1], array( '{post-type}', 'cs_global_block'), true ) ) {
        continue;
      }

      $types[] = $parts[1];

    }

    return $types;

  }

  public function user_can_access_post_type( $post = '', $user_id = null, $wp_cap = 'edit_post' ) {

    if ( is_string( $post ) ) {
      $post_type = $post;
    }

    if ( ! $post ) {
      $post = $this->plugin->common()->locate_post();
      if ( ! $post ) {
        return false;
      }
    }

    if ( is_a( $post, 'WP_Post' ) ) {
      $post_type_obj = get_post_type_object( $post->post_type );
      $caps = (array) $post_type_obj->cap;
      if ( is_null($user_id) && ! current_user_can( $caps[$wp_cap], $user_id ) ) {
        return false;
      }

      $post_type = $post->post_type;
    }

    $allowed = $this->plugin->component('App_Permissions')->get_user_post_types( $user_id );

		return in_array( $post_type, $allowed, true );

  }

  public function get_role_permissions( $roles ) {

    if ( is_string( $roles ) ) {
      $roles = array( $roles );
    }

    $stored = get_option('cs_permissions', array());
    $role_permissions = array();
    $merged = array();

    foreach ($roles as $role) {
      $default_role = isset( $this->role_defaults[$role] ) ? $this->role_defaults[$role] : array();
      $default_role = array_merge($this->role_defaults['_default'], $default_role );
      $stored_role = isset( $stored[$role] ) ? $stored[$role] : array();
      $role_permissions[$role] = array_merge($default_role,$stored_role);
    }

    // If a user has multiple roles, merge the permissions together.

    foreach ($role_permissions as $permissions) {

      ksort($permissions);

      foreach ($permissions as $key => $value) {

        $parts = explode('.', $key);

        // If multiple rows share a top level key allow either role to enable the feature
        if ( 1 !== count($parts) &&
          isset($merged[$parts[0]]) && // Only merge a nested permission if the parent of this role has turned it on
          $merged[$parts[0]] !== isset( $permissions[$parts[0]] )
        ) {
          continue;
        }

        $merged[$key] = ( isset($merged[$key])) ? $merged[$key] || $value : $value;

      }
    }

    ksort( $merged);

    return $merged;

  }

  public function get_role_list() {

    $wp_roles = wp_roles();
    $roles = array();

    foreach ($wp_roles->roles as $key => $value) {
      $roles[] = array( 'key' => $key, 'label' => $value['name'] );
    }

    return $roles;

  }

  public function update_stored_permissions( $update ) {
    return empty( $update ) ? delete_option('cs_permissions') : update_option('cs_permissions', $update);
  }

  public function get_user_roles( $user_id ) {

    $roles = array();

    global $wpdb;

    $caps = get_user_meta( $user_id, $wpdb->get_blog_prefix() . 'capabilities', true );

    $wp_roles = wp_roles();

		if ( is_array( $caps ) ) {
      $roles = array_filter( array_keys( $caps ), array( $wp_roles, 'is_role' ) );
    }

    if ( is_super_admin() && ! in_array( 'administrator', $roles, true ) ) {
      $roles[] = 'administrator';
    }

    return $roles;

  }

  protected function get_content_types() {

    if ( ! isset( $this->_content_types ) ) {

      $post_types = get_post_types( apply_filters( 'cs_get_content_types_args', array(
        'public'   => true,
        'show_ui' => true,
      ) ), 'objects' );

      unset( $post_types['attachment'] );

      $this->_content_types = array();

      foreach ( $post_types as $name => $post_type ) {
        $this->_content_types[$name] = ( isset( $post_type->labels->name ) ) ? $post_type->labels->name : $name;
      }

    }

    return $this->_content_types;

  }

  public function get_general_controls() {

    $hf_options = array( 'create', 'create_from_template', 'rename', 'delete', 'save_as_template', 'manage_assignments', 'elements_create', 'elements_delete', 'elements_move', 'elements_inspect', 'apply_presets', 'save_presets', 'design_controls', 'customize_controls', 'edit_custom_css', 'edit_custom_js' );
    $content_options = array( 'publish', 'manage_layout', 'insert_templates', 'save_templates', 'elements_create', 'elements_delete', 'elements_move', 'elements_inspect', 'apply_presets', 'save_presets', 'design_controls', 'customize_controls', 'edit_custom_css', 'edit_custom_js', 'settings', 'skeleton_mode' );
    $manager_options = array( 'create', 'change', 'rename', 'delete');

    $types = $this->get_content_types();

    $items = array(
      'headers' => csi18n('common.title.headers'),
      'content.page' => $types['page'],
    );

    unset( $types['page'] );

    foreach ($types as $name => $title) {
      $items["content.$name"] = $title;
    }

    $options_title = apply_filters( 'cornerstone_options_theme_title', false ) ? 'theme' : 'styling';

    $items = array_merge($items, array(
      'footers' => csi18n('common.title.footers'),
      'templates' => csi18n('common.title.templates'),
      'content.cs_global_block' => csi18n('common.title.global-blocks'),
      'colors' => csi18n('common.title.colors'),
      'fonts' => csi18n('common.title.fonts'),
      'theme_options' => csi18n( "common.title.options-$options_title" )
    ));

    $controls = array();

    foreach ($items as $key => $value) {
      $controls[] = array(
        'id'      => $key,
        'title'   => $value,
        'options' => $this->get_context_keys( $key )
      );
    }

    return $controls;

  }

  public function get_element_controls() {

    $controls = array();
    $context_defaults = $this->get_context_keys('element.{id}');
    $elements = CS()->component('Element_Manager')->get_public_definitions();

    foreach ( $elements as $element ) {

      $options = $context_defaults;

      $is_classic = $element->is_classic();

      if ( $is_classic ) {
        $options = array_diff($context_defaults, array( 'design_controls', 'customize_controls' ) );
      }

      $controls[] = array(
        'id'      => $element->get_type(),
        'title'   => $element->get_title(),
        'options' => $options,
        'classic' => $is_classic
      );

    }

    return $controls;

  }

  public function get_preference_controls() {

    $preference_controls = $this->plugin->component('App_Preferences')->get_preference_controls();
    $controls = array();

    foreach ($preference_controls as $control) {
      if ( 'toggle' === $control['type'] ) {
        $controls[] = array(
          'id' => $control['key'],
          'title' => $control['title'],
          'description' => $control['description'],
        );
      }
    }

    return $controls;
  }


  public function get_context_keys( $context ) {

    $dynamic = array(
      'element' => 'element.{id}',
      'content' => 'content.{post-type}'
    );

    $context_keys = array();

    $keys = array_keys( $this->role_defaults['_default'] );

    $parts = explode('.', $context);

    foreach ($keys as $key) {

      if ( 0 === strpos( $key, "$context." ) ) {
        $context_keys[] = str_replace("$context.", "",$key );
      }

      if ( isset($dynamic[$parts[0]]) && 0 === strpos( $key, $dynamic[$parts[0]] . '.' ) ) {
        $context_keys[] = str_replace( $dynamic[$parts[0]] . '.', "",$key );
      }

    }

    return array_values( array_unique( $context_keys ) );
  }

  public function get_macros() {

    $text_only = array(
      'headers'                 => false,
      'footers'                 => false,
      'templates'               => false,
      'content.page'            => true,
      'content.cs_global_block' => false,
      'colors'                  => false,
      'fonts'                   => false,
      'theme_options'           => false,
    );

    $enable_v2_elements = array();
    $disable_v2_elements = array();
    $enable_classic_elements = array();
    $disable_classic_elements = array();

    $disable_preferences = array(
      'preference.advanced_mode'   => false,
      'preference.show_wp_toolbar' => false,
      'preference.help_text.user'  => false
    );

    $content_types = array_keys( $this->get_content_types() );
    $text_only_contexts = array( 'headers', 'footers', 'content.cs_global_block' );

    foreach ( $content_types as $type ) {
      $text_only_contexts[] = "content.$type";
    }

    foreach ( $text_only_contexts as $context ) {

      $context_keys = CS()->component('App_Permissions')->get_context_keys($context);
      $text_only_remove = array_diff( $context_keys, array('elements_inspect', 'publish') );

      foreach ($text_only_remove as $key) {
        $text_only["$context.$key"] = false;
      }

      $text_only["$context.elements_inspect"] = true;

    }

    $elements           = CS()->component('Element_Manager')->get_public_definitions();
    $v2_elements        = array();
    $classic_elements   = array();
    $text_only_elements = array( 'button', 'accordion', 'tabs', 'text', 'headline', 'quote', 'alert', 'counter', 'statbar' );

    foreach ( $elements as $element ) {

      $id = $element->get_type();

      if ( $element->is_classic() ) {
        $classic_elements[] = "element.$id";
      } else {
        $v2_elements[] = "element.$id";
      }

      if ( in_array( $id, $text_only_elements ) ) {
        $text_only["element.$id"] = true;
        $text_only["element.$id.design_controls"] = false;
        $text_only["element.$id.customize_controls"] = false;
        $text_only["element.$id.apply_preset"] = false;
        $text_only["element.$id.save_preset"] = false;
      } else {
        $text_only["element.$id"] = false;
      }

    }

    foreach ( $v2_elements as $element ) {
      $disable_v2_elements[$element] = false;
      $enable_v2_elements[$element]  = true;
    }

    foreach ( $classic_elements as $element ) {
      $disable_classic_elements[$element] = false;
      $enable_classic_elements[$element]  = true;
    }

    return apply_filters('cs_app_permission_macros', array(
      'text-only'                => array( 'actions' => $text_only,                'label' => 'i18n' ),
      'disable-preferences'      => array( 'actions' => $disable_preferences,      'label' => 'i18n' ),
      'enable-v2-elements'       => array( 'actions' => $enable_v2_elements,       'label' => 'i18n' ),
      'disable-v2-elements'      => array( 'actions' => $disable_v2_elements,      'label' => 'i18n' ),
      'enable-classic-elements'  => array( 'actions' => $enable_classic_elements,  'label' => 'i18n' ),
      'disable-classic-elements' => array( 'actions' => $disable_classic_elements, 'label' => 'i18n' ),
      'reset'                    => array( 'command' => 'reset',                   'label' => 'i18n' ),
    ) );
  }

  public function get_app_data() {
    return array(
      'i18n'        => $this->i18n_group('admin', false, 'permissions'),
      'roles'       => $this->get_role_list(),
      'permissions' => get_option('cs_permissions', array()),
      'defaults'    => $this->role_defaults,
      'macros'      => $this->get_macros(),
      'controls'    => array(
        'general'    => $this->get_general_controls(),
        'preferences' => $this->get_preference_controls(),
        'elements'   => $this->get_element_controls()
      )
    );
  }

}
