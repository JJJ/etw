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

if ( $tabs_panels_equal_height === true ) {
  $atts_tabs = array_merge( $atts_tabs, cs_element_js_atts( 'tabs', array( 'equalPanelHeight' => $tabs_panels_equal_height ) ) );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts_tabs ); ?>>

  <div class="x-tabs-list">
    <ul role="tablist">

      <?php foreach ( $_custom_data['_modules'] as $key => $tab ) : ?>

        <?php

        $tab_atts = array(
          'id'                  => 'tab-' . $tab['_id'],
          'role'                => 'tab',
          'aria-selected'       => ( $key === 0 && $set_initial ) ? 'true' : 'false',
          'aria-controls'       => 'panel-' . $tab['_id'],
          'data-x-toggle'       => 'tab',
          'data-x-toggleable'   => 'tab-item-' . $tab['_id'],
          'data-x-toggle-group' => 'tab-group-' . $mod_id,
        );

        if ( $key === 0 && $set_initial  ) {
          $tab_atts['class'] = 'x-active';
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

    <?php foreach ( $_custom_data['_modules'] as $key => $tab ) : ?>

      <?php

      $panel_atts = array(
        'id'                => 'panel-' . $tab['_id'],
        'class'             => 'x-tabs-panel',
        'role'              => 'tabpanel',
        'aria-labelledby'   => 'tab-' . $tab['_id'],
        'aria-hidden'       => ( $key === 0 && $set_initial ) ? 'false' : 'true',
        'data-x-toggleable' => 'tab-item-' . $tab['_id'],
      );

      if ( $key === 0 && $set_initial ) {
        $panel_atts['class'] .= ' x-active';
      }

      ?>

      <div <?php echo x_atts( $panel_atts ); ?>>
        <?php echo do_shortcode( $tab['tab_content'] ); ?>
      </div>

    <?php endforeach; ?>

  </div>

</div>
