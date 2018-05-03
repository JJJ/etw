<?php

// =============================================================================
// VIEWS/BARS/TABS.PHP
// -----------------------------------------------------------------------------
// Tabs element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Atts: Tabs
// ----------

$atts_tabs = array(
  'class' => x_attr_class( array( $mod_id, 'x-tabs', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts_tabs['id'] = $id;
} else {
  $atts_tabs['id'] = 'x-tabs-' . $mod_id;
}


// Output
// ------

?>

<div <?php echo x_atts( $atts_tabs ); ?>>

  <div class="x-tablist">
    <ul role="tablist">

      <?php foreach ( $_custom_data['_modules'] as $key => $tab ) : ?>

        <?php

        $tab_atts = array(
          'id'                  => 'tab-' . $tab['_id'],
          'role'                => 'tab',
          'aria-selected'       => ( $key === 0 ) ? 'true' : 'false',
          'aria-controls'       => 'panel-' . $tab['_id'],
          'data-x-toggle'       => 'tab',
          'data-x-toggleable'   => 'tab-item-' . $tab['_id'],
          'data-x-toggle-group' => 'tab-group-' . $tab['_p'],
        );

        if ( $key === 0 ) {
          $tab_atts['class'] = 'x-active';
        }

        ?>

        <li role="presentation">
          <button <?php echo x_atts( $tab_atts ); ?>>
            <?php echo do_shortcode( $tab['tab_label'] ); ?>
          </button>
        </li>

      <?php endforeach; ?>

    </ul>
  </div>

  <div class="x-tab-panels">

    <?php foreach ( $_custom_data['_modules'] as $key => $tab ) : ?>

      <?php

      $panel_atts = array(
        'id'                => 'panel-' . $tab['_id'],
        'class'             => 'x-tab-panel',
        'role'              => 'tabpanel',
        'aria-labelledby'   => 'tab-' . $tab['_id'],
        'aria-hidden'       => ( $key === 0 ) ? 'false' : 'true',
        'data-x-toggleable' => 'tab-item-' . $tab['_id'],
      );

      if ( $key === 0 ) {
        $panel_atts['class'] .= ' x-active';
      }

      ?>

      <div <?php echo x_atts( $panel_atts ); ?>>
        <?php echo do_shortcode( $tab['tab_content'] ); ?>
      </div>

    <?php endforeach; ?>

  </div>

</div>