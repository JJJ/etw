<?php

// =============================================================================
// MENU-ITEM-CUSTOM-FIELDS-MAP.PHP
// -----------------------------------------------------------------------------
// Map custom fields to the WordPress menu system.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. CS_Menu_Item_Custom_Fields_Map
//   02. Initialize
// =============================================================================

// CS_Menu_Item_Custom_Fields_Map
// =============================================================================

class CS_Menu_Item_Custom_Fields_Map {

  // Fields Property
  // ---------------

  protected static $fields = array();


  // Init
  // ----

  public static function init() {

    add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 4 );
    add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
    add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );

    self::$fields = array(
      'anchor_graphic_menu_item_display' => array(
        'type'  => 'select',
        'label' => __( 'Graphic Display', '__x__' ),
        'size'  => 'wide',
        'std'   => 'on',
        'desc'  => '',
        'choices' => array(
          'on'  => __( 'Keep Enabled for this Menu Item', '__x__' ),
          'off' => __( 'Disable for this Menu Item', '__x__' ),
        ),
      ),
      'anchor_graphic_icon' => array(
        'type'  => 'icon',
        'label' => __( 'Icon Primary', '__x__' ),
        'size'  => 'thin',
        'std'   => 'hand-pointer-o',
        'desc'  => '',
      ),
      'anchor_graphic_icon_alt' => array(
        'type'  => 'icon',
        'label' => __( 'Icon Secondary', '__x__' ),
        'size'  => 'thin',
        'std'   => 'hand-pointer-o',
        'desc'  => '',
      ),
      'anchor_graphic_image_src' => array(
        'type'  => 'text',
        'label' => __( 'Image Primary', '__x__' ),
        'size'  => 'thin',
        'std'   => '',
        'desc'  => '',
      ),
      'anchor_graphic_image_src_alt' => array(
        'type'  => 'text',
        'label' => __( 'Image Secondary', '__x__' ),
        'size'  => 'thin',
        'std'   => '',
        'desc'  => '',
      ),
      'anchor_graphic_image_width' => array(
        'type'  => 'text',
        'label' => __( 'Image Width (Required)', '__x__' ),
        'size'  => 'thin',
        'std'   => '',
        'desc'  => __( 'Input the unitless pixel width. E.G. If your image is 300px wide, write &ldquo;300&rdquo; in the input.', '__x__' ),
      ),
      'anchor_graphic_image_height' => array(
        'type'  => 'text',
        'label' => __( 'Image Height (Required)', '__x__' ),
        'size'  => 'thin',
        'std'   => '',
        'desc'  => __( 'Input the unitless pixel height. E.G. If your image is 150px tall, write &ldquo;150&rdquo; in the input.', '__x__' ),
      ),
    );

  }


  // Save Custom Field Value
  // -----------------------
  // 01. Sanitize.
  // 02. Do some checks here.
  // 03. Update.

  public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {

    if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ! isset( $_POST['update-nav-menu-nonce'])) {
      return;
    }

    check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

    foreach ( self::$fields as $_key => $data ) {

      $key = sprintf( 'menu-item-%s', $_key );

      if ( ! empty( $_POST[$key][$menu_item_db_id] ) ) { // 01
        $value = $_POST[$key][$menu_item_db_id]; // 02
      } else {
        $value = null;
      }

      if ( ! is_null( $value ) ) { // 03
        update_post_meta( $menu_item_db_id, $key, $value );
      } else {
        delete_post_meta( $menu_item_db_id, $key );
      }

    }

  }


  // Output Fields
  // -------------
  // 01. Get all item meta at once so we don't have to call it for each field.
  // 02. Get a copy of our keys so we can filter out WordPress' meta items.
  // 03. Will store an array of our meta keys with the associated value.
  // 04. While looping through all meta, if the key we're on matches a key in
  //     our field keys array, add that key and its value to our cleaned meta.
  // 05. Make sure current key is in the cleaned meta before setting a value.

  public static function _fields( $id, $item, $depth, $args ) {

    $all_meta      = get_post_meta( $item->ID, '', true ); // 01
    $our_meta_keys = array_keys( self::$fields );          // 02
    $cleaned_meta  = array();                              // 03

    foreach ( $all_meta as $key => $value ) {
      if ( in_array( str_replace( 'menu-item-', '', $key ), $our_meta_keys ) ) { // 04
        $cleaned_meta[$key] = $value[0];
      }
    }

    foreach ( self::$fields as $_key => $data ) :

      $key   = sprintf( 'menu-item-%s', $_key );
      $id    = sprintf( 'edit-%s-%s', $key, $item->ID );
      $name  = sprintf( '%s[%s]', $key, $item->ID );
      $meta  = ( isset( $cleaned_meta[$key] ) ) ? $cleaned_meta[$key] : null; // 05
      $value = ( empty( $meta ) ) ? $data['std'] : $meta;
      $class = sprintf( 'field-%s', $_key );
      $desc  = ( ! empty( $data['desc'] ) ) ? '<span class="description">' . $data['desc'] . '</span>' : '';

      if ( $data['type'] == 'select' ) :

      ?>

        <p class="description description-<?php echo $data['size']; ?> <?php echo esc_attr( $class ); ?>">
          <label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $data['label'] ); ?><br>
            <select id="<?php echo esc_attr( $id ); ?>" class="widefat <?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
              <?php foreach ( $data['choices'] as $o_key => $o_value ) : ?>
                <option value="<?php echo $o_key ?>" <?php echo selected( $o_key, $value, false ); ?>><?php echo $o_value; ?></option>
              <?php endforeach; ?>
            </select>
            <?php echo $desc; ?>
          </label>
        </p>

      <?php elseif ( $data['type'] == 'icon' ) :

        $value = CS()->common()->resolveFontAlias( $value );

        ?>

        <p class="description description-<?php echo $data['size']; ?> <?php echo esc_attr( $class ); ?>">
          <label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $data['label'] ); ?><br>
            <select id="<?php echo esc_attr( $id ); ?>" class="widefat <?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
              <!-- <option value="" <?php echo selected( '', $value, false ); ?>>&mdash; No Icon Assigned &mdash;</option> -->
              <?php foreach ( cs_fa_all() as $fa_slug ) : ?>
                <option value="<?php echo $fa_slug ?>" <?php echo selected( $fa_slug, $value, false ); ?>><?php echo $fa_slug; ?></option>
              <?php endforeach; ?>
            </select>
            <?php echo $desc; ?>
          </label>
        </p>

      <?php elseif ( $data['type'] == 'hr' ) : ?>

        <hr style="float: left; width: calc(100% - 13px); margin: 2px 0 7px; padding: 0; background-color: transparent;">

      <?php else : ?>

        <p class="description description-<?php echo $data['size']; ?> <?php echo esc_attr( $class ); ?>">
          <label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $data['label'] ); ?><br>
            <input type="text" id="<?php echo esc_attr( $id ); ?>" class="widefat <?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
            <?php echo $desc; ?>
          </label>
        </p>

      <?php

      endif;

    endforeach;

  }


  // Add Fields to Screen Options Toggle
  // -----------------------------------

  public static function _columns( $columns ) {

    // $new_columns = array();

    // foreach ( self::$fields as $_key => $data ) {
    //   if ( $data['type'] == 'hr' ) {
    //     continue;
    //   }
    //   $new_columns[$_key] = $data['label'];
    // }

    // $columns = array_merge( $columns, $new_columns );

    return $columns;

  }

}



// Initialize
// =============================================================================

CS_Menu_Item_Custom_Fields_Map::init();
