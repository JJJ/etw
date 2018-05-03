<?php
/**
 * This class manages all Dashboard related activity.
 * It handles the Options page, and adds the "Edit with Cornerstone"
 * links to the list table screens, and the toolbar.
 */

class Cornerstone_Wp_Export extends Cornerstone_Plugin_Component {

  protected $meta_skip_list = array( '_cs_generated_styles' );

  protected $meta_slash_list = array(
    '_cornerstone_settings',
    '_cornerstone_data'
  );

  public function setup() {
    add_filter( 'wxr_export_skip_postmeta', array( $this, 'meta_filter'), 10, 3 );
  }

  public function meta_filter( $skip, $meta_key, $meta ) {

    if ( in_array( $meta_key, $this->meta_skip_list, true ) ) {
      return true;
    }

    if ( in_array( $meta_key, $this->meta_slash_list, true ) ) { ?>
      <wp:postmeta>
        <wp:meta_key><?php echo wxr_cdata( $meta->meta_key ); ?></wp:meta_key>
        <wp:meta_value><?php echo wxr_cdata( wp_slash( $meta->meta_value ) ); ?></wp:meta_value>
      </wp:postmeta>
      <?php return true;
    }

    return $skip;

  }

}
