<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOM-SIDEBARS.PHP
// -----------------------------------------------------------------------------
// Sets up functionality for unique page sidebars.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Register All Hooks
//   02. Display Sidebar
//   03. Add Options Page
//   04. Options Init
//   05. Options Admin Init
//   06. Callbacks
//   07. Validation
//   08. Add New Sidebar
//   09. Update Message
//   10. Checked List Item
//   11. Print Scripts in Footer
//   12. WPML
// =============================================================================

// Register All Hooks
// =============================================================================

//
// Filters.
//

add_filter( 'ups_sidebar', 'ups_display_sidebar' );


//
// Actions.
//

add_action( 'init', 'ups_options_init' );
add_action( 'admin_init', 'ups_options_admin_init' );
add_action( 'admin_menu', 'ups_options_add_page' );



// Display Sidebar
// =============================================================================

function ups_sidebar_defaults( $sidebar ) {
  return wp_parse_args( $sidebar, array(
    'pages' => array(),
    'post_types' => array(),
    'taxonomies' => array(),
    'children' => 'off',
    'index-blog' => 'off',
    'index-shop' => 'off'
  ));
}
//
// Displays the sidebar, which is attached to the page being viewed.
//

function ups_display_sidebar( $default_sidebar ) {

  $q_object = get_queried_object();
  $sidebars = get_option( 'ups_sidebars' );

  foreach ( $sidebars as $id => $sidebar ) {

    $sidebar = ups_sidebar_defaults( $sidebar );

    if ( is_singular() ) {
      if ( $sidebar['children'] == 'on' ) {
        $child = array_key_exists( $q_object->post_parent, $sidebar['pages'] );
      } else {
        $child = false;
      }
      if ( array_key_exists( $q_object->ID, $sidebar['pages'] ) || $child ) {
        return $id;
      }
    } elseif ( is_home() ) {
      if ( $sidebar['index-blog'] == 'on' ) {
        return $id;
      }
    } elseif ( is_tax() || is_category() || is_tag() ) {
      if ( array_key_exists( $q_object->term_id, $sidebar['taxonomies'] ) ) {
        return $id;
      }
    } elseif ( x_is_shop() ) {
      if ( $sidebar['index-shop'] == 'on' ) {
        return $id;
      }
    }

    if ( ! is_null( $q_object ) ) {
      $post_type = isset( $q_object->post_type ) ? $q_object->post_type : null;
      if ( is_a( $q_object, 'WP_Post_Type' ) ) {
        $post_type = $q_object->name;
      }
      if ( array_key_exists( $post_type, $sidebar['post_types'] ) ) {
        return $id;
      }
    }
  }

  return $default_sidebar;

}



// Add Options Page
// =============================================================================

function ups_options_add_page() {
  $label = __( 'Sidebars', 'cornerstone' );
  add_theme_page( $label, $label, 'edit_theme_options', 'ups_sidebars', 'ups_sidebars_do_page' );
}



// Options Init
// =============================================================================

//
// Registers all sidebars for use on the front-end and Widgets page.
//

function ups_options_init() {
  $sidebars = get_option( 'ups_sidebars' );
  if ( is_array( $sidebars ) ) {
    foreach ( (array) $sidebars as $id => $sidebar ) {
      unset( $sidebar['pages'] );
      $sidebar['id'] = $id;
      register_sidebar( $sidebar );
    }
  }
}



// Options Admin Init
// =============================================================================

//
// Adds the metaboxes to the main options page for the sidebars in the database.
//

function ups_options_admin_init() {

  wp_enqueue_script( 'common' );
  wp_enqueue_script( 'wp-lists' );
  wp_enqueue_script( 'postbox' );

  // Register setting to store all the sidebar options in the *_options table.
  register_setting( 'ups_sidebars_options', 'ups_sidebars', 'ups_sidebars_validate' );

  $sidebars = get_option( 'ups_sidebars' );

  if ( is_array( $sidebars ) && count ( $sidebars ) > 0 ) {
    foreach ( $sidebars as $id => $sidebar ) {
      add_meta_box(
        esc_attr( $id ),
        esc_html( $sidebar['name'] ),
        'ups_sidebar_do_meta_box',
        'ups_sidebars',
        'normal',
        'default',
        array(
          'id'      => esc_attr( $id ),
          'sidebar' => $sidebar
        )
      );
      unset( $sidebar['pages'] );
      $sidebar['id'] = esc_attr( $id );
      register_sidebar( $sidebar );
    }
  } else {
    add_meta_box( 'ups-sidebar-no-sidebars', __( 'No sidebars', 'cornerstone' ), 'ups_sidebar_no_sidebars', 'ups_sidebars', 'normal', 'default' );
  }


  //
  // Sidebar metaboxes.
  //

  add_meta_box( 'ups-sidebar-add-new-sidebar', 'Add a New Sidebar', 'ups_sidebar_add_new_sidebar', 'ups_sidebars', 'side', 'default' );

}

function ups_sidebar_no_sidebars() {
  echo '<p>';
  _e( 'You haven&rsquo;t added any sidebars yet. Add one using the form on the right hand side.', 'cornerstone' );
  echo '</p>';
}



// Callbacks
// =============================================================================

//
// Creates the theme page and adds a spot for the metaboxes.
//

function ups_sidebars_do_page() {
  ?>
  <div class="wrap x-sidebars">
    <h2><?php _e( 'Manage Sidebars', 'cornerstone' ); ?></h2>
    <?php ups_sidebar_update_message(); ?>
    <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">
        <div id="post-body-content">
          <form method="post" action="options.php">
            <?php settings_fields( 'ups_sidebars_options' ); ?>
            <?php do_meta_boxes( 'ups_sidebars', 'normal', null ); ?>
          </form>
        </div>
        <div id="postbox-container-1" class="postbox-container">
          <?php do_meta_boxes( 'ups_sidebars', 'side', null ); ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}


//
// Adds the content of the metaboxes for each sidebar.
//

function ups_sidebar_do_meta_box( $post, $metabox ) {

  $sidebars   = get_option( 'ups_sidebars' );
  $sidebar_id = esc_attr( $metabox['args']['id'] );
  $sidebar    = ups_sidebar_defaults( $sidebars[$sidebar_id] );

  $before_title = __( 'Before Title', 'cornerstone' );

  $options_fields = array(
    'name'          => array( __( 'Name', 'cornerstone' ), '' ),
    'description'   => array( __( 'Description', 'cornerstone' ), '' ),
    'sidebar-id'    => array( __( 'ID', 'cornerstone' ), '' ),
    'before_title'  => array( $before_title, '<h4 class="h-widget">' ),
    'after_title'   => array( $before_title, '</h4>' ),
    'before_widget' => array( $before_title, '<div id="%1$s" class="widget %2$s">' ),
    'after_widget'  => array( __( 'After Widget', 'cornerstone' ), '</div>' ),
    'children'      => array( __( 'Child Page Display', 'cornerstone' ), '' ),
    'index-blog'    => array( __( 'Blog Display', 'cornerstone' ), '' ),
    'index-shop'    => array( __( 'Shop Display', 'cornerstone' ), '' )
  );

  $get_posts = new WP_Query;

  $posts = $get_posts->query( array(
    'offset'                 => 0,
    'order'                  => 'ASC',
    'orderby'                => 'title',
    'posts_per_page'         => apply_filters( 'cs_query_limit', 2500 ),
    'post_type'              => array( 'page', 'post' ),
    'suppress_filters'       => true,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false
  ) );

  if ( X_WOOCOMMERCE_IS_ACTIVE ) {
    $taxonomies = get_terms( array(
      'category',
      'post_tag',
      'portfolio-category',
      'portfolio-tag',
      'product_cat',
      'product_tag'
    ) );
  } else {
    $taxonomies = get_terms( array(
      'category',
      'post_tag',
      'portfolio-category',
      'portfolio-tag'
    ) );
  }

  $post_type_objects = get_post_types(array(), 'objects');
  $post_types = array();

  foreach ($post_type_objects as $obj) {
    $post_types[$obj->name] = $obj->label;
  }

  ?>

  <div class="x-entry-and-taxonomy-lists">
    <div class="wp-tab-wrapper">
      <ul class="wp-tab-bar">
        <li class="wp-tab-active"><?php _e( 'All Pages and Posts', 'cornerstone' ); ?></li>
      </ul>
      <div class="wp-tab-panel">
        <ul id="entry-checklist" class="entry-checklist categorychecklist">
          <?php foreach ( $posts as $post ) : ?>
          <li>
            <label>
            <?php $checked = ups_checked_list_item( $post->ID, $sidebar['pages'] ); ?>
            <input type="checkbox" class="menu-item-checkbox" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][pages][<?php echo esc_attr( $post->ID ); ?>]" value="<?php echo esc_attr( $post->post_title ); ?>"<?php echo $checked; ?>>
            <?php echo esc_html( $post->post_title ); ?>
            </label>
          </li>
          <?php endforeach; wp_reset_postdata(); ?>
        </ul>
      </div>
    </div>
    <div class="wp-tab-wrapper">
      <ul class="wp-tab-bar">
        <li class="wp-tab-active"><?php _e( 'All Taxonomies', 'cornerstone' ); ?></li>
      </ul>
      <div class="wp-tab-panel">
        <ul id="taxonomy-checklist" class="taxonomy-checklist categorychecklist">
          <?php foreach ( $taxonomies as $taxonomy ) : ?>
          <li>
            <label>
            <?php $checked = ups_checked_list_item( $taxonomy->term_id, $sidebar['taxonomies'] ); ?>
            <input type="checkbox" class="menu-item-checkbox" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][taxonomies][<?php echo esc_attr( $taxonomy->term_id ); ?>]" value="<?php echo esc_attr( $taxonomy->name ); ?>"<?php echo $checked; ?>>
            <?php echo esc_html( $taxonomy->name ); ?>
            </label>
          </li>
          <?php endforeach; wp_reset_postdata(); ?>
        </ul>
      </div>
    </div>

    <div class="wp-tab-wrapper">
      <ul class="wp-tab-bar">
        <li class="wp-tab-active"><?php _e( 'Post Types', 'cornerstone' ); ?></li>
      </ul>
      <div class="wp-tab-panel">
        <ul id="post-type-checklist" class="post-type-checklist categorychecklist">
          <?php foreach ( $post_types as $name => $label ) : ?>
          <li>
            <label>
            <?php $checked = ups_checked_list_item( $name, $sidebar['post_types'] ); ?>
            <input type="checkbox" class="menu-item-checkbox" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][post_types][<?php echo esc_attr( $name ); ?>]" value="<?php echo esc_attr( $label ); ?>"<?php echo $checked; ?>>
            <?php echo esc_html( $label ); ?>
            </label>
          </li>
          <?php endforeach; wp_reset_postdata(); ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="x-sidebar-options">
    <table class="form-table">
      <?php foreach ( $options_fields as $id => $label ) : ?>
      <tr valign="top">
        <?php if ( $id == 'before_title' || $id == 'after_title' || $id == 'before_widget' || $id == 'after_widget' ) : ?>
          <th class="hidden" scope="row"><label for="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]"><?php echo esc_html( $label[0] ); ?></label></th>
          <td class="hidden"><input id="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" class="regular-text" type="text" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_html( $label[1] ); ?>" readonly></td>
        <?php else : ?>
          <th scope="row"><label for="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]"><?php echo esc_html( $label[0] ); ?></label></th>
          <td>
            <?php if ( $id == 'children' || $id == 'index-blog' || $id == 'index-shop' ) : ?>
              <?php $checked = ( array_key_exists( $id, $sidebar ) ) ? checked( $sidebar[$id], 'on', false ) : ''; ?>
              <label>
                <input type="checkbox" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" value="on" id="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" <?php echo $checked; ?>>
                <?php if ( $id == 'children' ) : ?>
                  <span class="description"><?php _e( 'Enable parent page sidebar on child pages', 'cornerstone' ); ?></span>
                <?php elseif ( $id == 'index-blog' ) : ?>
                  <span class="description"><?php _e( 'Enable sidebar on blog index page', 'cornerstone' ); ?></span>
                <?php elseif ( $id == 'index-shop' ) : ?>
                  <span class="description"><?php _e( 'Enable sidebar on shop index page', 'cornerstone' ); ?></span>
                <?php endif; ?>
              </label>
            <?php elseif ( $id == 'sidebar-id' ) : ?>
              <input id="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" class="regular-text" type="text" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_html( $sidebar[$id] ); ?>" readonly>
            <?php else : ?>
              <input id="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" class="regular-text" type="text" name="ups_sidebars[<?php echo esc_attr( $sidebar_id ); ?>][<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_html( $sidebar[$id] ); ?>">
            <?php endif; ?>
          </td>
        <?php endif; ?>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <div class="sidebar-submit-box">
    <input type="submit" class="button-primary" value="<?php _e( 'Update Sidebar', 'cornerstone' ); ?>">
    <label><input type="checkbox" name="ups_sidebars[delete]" value="<?php echo esc_attr( $sidebar_id ); ?>"> <?php _e( 'Delete this sidebar?', 'cornerstone' ); ?></label>
    <br>
  </div>
  <?php
}



// Validation
// =============================================================================

//
// Handles all the post data (adding, updating, deleting sidebars).
//

function ups_sidebars_validate( $input ) {

  if ( isset( $input['add_sidebar'] ) ) {

    $sidebars = get_option( 'ups_sidebars' );

    if ( ! empty( $input['add_sidebar'] ) ) {
      $sidebar_id_slug = 'ups-sidebar-' . sanitize_title_with_dashes( remove_accents( $input['add_sidebar'] ) );
      $sidebars[$sidebar_id_slug] = array(
        'name'          => esc_html( $input['add_sidebar'] ),
        'description'   => '',
        'sidebar-id'    => $sidebar_id_slug,
        'before_title'  => '<h4 class="h-widget">',
        'after_title'   => '</h4>',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'pages'         => array(),
        'taxonomies'    => array(),
        'children'      => 'off',
        'index-blog'    => 'off',
        'index-shop'    => 'off'
      );
    }

    // Remove array index from old versions that doesn't need to be there.
    if ( array_key_exists( 'sidebar-id', $sidebars ) ) {
      unset( $sidebars['sidebar-id'] );
    }

    return $sidebars;

  }

  if ( isset( $input['delete'] ) ) {
    foreach ( (array) $input['delete'] as $delete_id ) {
      unset( $input[$delete_id] );
    }
    unset( $input['delete'] );
    return $input;
  }

  return $input;

}



// Add New Sidebar
// =============================================================================

//
// Handles the content of the metabox, which allows adding new sidebars.
//

function ups_sidebar_add_new_sidebar() {
  ?>
  <form method="post" action="options.php" id="add-new-sidebar">
    <?php settings_fields( 'ups_sidebars_options' ); ?>
    <p><?php _e( 'Enter in the name of a new sidebar below. This name will be used as part of a unique identifier for each sidebar you create.', 'cornerstone' ); ?></p>
    <input id="ups_sidebars[add_sidebar]" class="text" type="text" name="ups_sidebars[add_sidebar]" value="">
    <input type="submit" class="button-primary" value="<?php _e( 'Add Sidebar', 'cornerstone' ); ?>">
  </form>
  <?php
}



// Update Message
// =============================================================================

function ups_sidebar_update_message() {

  if ( ! isset( $_REQUEST['settings-updated'] ) ) :
    $_REQUEST['settings-updated'] = false;
  endif;

  if ( $_REQUEST['settings-updated'] !== false ) :
    echo '<div class="updated fade"><p>' . sprintf( __( '<strong>Your sidebar settings have been saved!</strong> You can now go manage the <a href="%s">widgets</a> for the sidebars that you have created.', 'cornerstone' ), get_admin_url() . 'widgets.php' ) . '</p></div>';
  endif;

}



// Checked List Item
// =============================================================================

function ups_checked_list_item( $needle, $haystack ) {

  if ( array_key_exists( $needle, $haystack ) ) {
    $output = ' checked="checked"';
  } else {
    $output = '';
  }

  return $output;

}



// Print Scripts in Footer
// =============================================================================

function ups_print_scripts_in_footer() {
  echo '<script>jQuery(document).ready(function(){ postboxes.add_postbox_toggles(pagenow); });</script>';
}

add_action( 'admin_footer-appearance_page_ups_sidebars', 'ups_print_scripts_in_footer' );


// WPML
// =============================================================================

if ( defined( 'ICL_SITEPRESS_VERSION' ) ) :

  //
  // Translate page and term ids in custom sidebar settings
  //

  function cs_wpml_translate_ups_sidebar_settings( $sidebars ) {
    foreach ( $sidebars as $id => $sidebar ) {
      if ( array_key_exists( 'pages', $sidebar ) ) {
        $pages = array();
        foreach ( $sidebar['pages'] as $id => $title ) {
          $id = apply_filters( 'wpml_object_id', $id, get_post_type( $id ) );
          $pages[ $id ] = $title;
        }
        $sidebar['pages']= $pages;
      }
      if ( array_key_exists( 'taxonomies', $sidebar ) ) {
        $taxonomies = array();
        foreach ( $sidebar['taxonomies'] as $id => $title ) {
          $term = get_term( $id );
          $id = apply_filters( 'wpml_object_id', $id, $term->taxonomy );
          $taxonomies[ $id ] = $term->name;
        }
        $sidebar['taxonomies'] = $taxonomies;
      }
    }
    return $sidebars;
  }

  add_filter( 'option_ups_sidebars', 'cs_wpml_translate_ups_sidebar_settings' );

endif;
