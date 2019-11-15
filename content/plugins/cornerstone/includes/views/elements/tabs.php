<?php

// =============================================================================
// VIEWS/BARS/TABS.PHP
// -----------------------------------------------------------------------------
// Tabs element.
// =============================================================================

$mod_id      = ( isset( $mod_id ) ) ? $mod_id : '';
$class       = ( isset( $class )  ) ? $class  : '';
$set_initial = ! did_action( 'cs_element_rendering' );



// Atts: Tabs
// ----------

$atts_tabs = array(
  'class' => x_attr_class( array( $mod_id, 'x-tabs', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts_tabs['id'] = $id;
}


$atts_tabs = array_merge( $atts_tabs, cs_element_js_atts( 'tabs', array( 'equalPanelHeight' => $tabs_panels_equal_height ) ) );


// Custom data
$context_id = ( isset( $_view_data['_p'] ) ) ? $_view_data['_p'] . '-' : '';

// Output
// ------

?>

<div <?php echo x_atts( $atts_tabs ); ?>>

  <div class="x-tabs-list">
    <ul role="tablist">

      <?php foreach ( $_view_data['tabs'] as $key => $tab ) : ?>

        <?php

        // create mod_id for tab link
        $tab_mod_id = $context_id . $tab['_id'];

        if (isset($tab['id']) && !empty($tab['id'])) {
          $tab_id = $tab['id'];
        }else{
          $tab_id = $tab_mod_id; // prevent collision
        }

        // automatic class
        $tab_class  = 'e' . $tab_mod_id;
        // Add "x-active" conditionally
        $tab_class .= $key === 0 && $set_initial ? ' x-active' : '';

        $tab_atts = array(
          'id'                  => 'tab-' . $tab_id,
          'class'               => $tab_class,
          'role'                => 'tab',
          'aria-selected'       => ( $key === 0 && $set_initial ) ? 'true' : 'false',
          'aria-controls'       => 'panel-' . $tab_id,
          'data-x-toggle'       => 'tab',
          'data-x-toggleable'   => 'tab-item-' . $tab_id,
          'data-x-toggle-group' => 'tab-group-' . $mod_id,
        );

        // if (isset($tab['id'])) {
        //   $tab_atts['id'] = $tab['id'];
        // }

        if ( ! empty( $tab['toggle_hash'] ) ) {
          $tab_atts['data-x-toggle-hash'] = $tab['toggle_hash'];
        }

        if (isset($tab['class'])) {
          $tab_atts['class'] .= ' ' . $tab['class'];
        }

        ?>

        <li role="presentation">
          <button <?php echo x_atts( $tab_atts ); ?>>
            <span><?php echo do_shortcode( $tab['tab_label_content'] ); ?></span>
          </button>
        </li>

      <?php endforeach; ?>

    </ul>
  </div>

  <div class="x-tabs-panels">

    <?php foreach ( $_view_data['tabs'] as $key => $tab ) : ?>

      <?php

      // create mod_id for tab link
      $tab_mod_id = $context_id . $tab['_id'];

      if (isset($tab['id']) && !empty($tab['id'])) {
        $tab_id = $tab['id'];
      }else{
        $tab_id = $tab_mod_id; // prevent collision
      }

      // automatic class
      $tab_class  = 'e' . $tab_mod_id;

      $panel_atts = array(
        'class'             => $tab_class . ' x-tabs-panel ',
        'role'              => 'tabpanel',
        'aria-labelledby'   => 'tab-' . $tab_id,
        'aria-hidden'       => ( $key === 0 && $set_initial ) ? 'false' : 'true',
        'data-x-toggleable' => 'tab-item-' . $tab_id
      );


      $panel_atts['id'] = 'panel-' . $tab_id;


      if ( $key === 0 && $set_initial ) {
        $panel_atts['class'] .= ' x-active';
      }

      if (isset($tab['class'])) {
        $panel_atts['class'] .= ' ' . $tab['class'];
      }

      ?>

      <div <?php echo x_atts( $panel_atts ); ?>>
        <?php echo do_shortcode( $tab['tab_content'] ); ?>
      </div>

    <?php endforeach; ?>

  </div>

</div>
