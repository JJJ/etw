<?php

  $atts = array(
    'id'              => 'cs-control-' . $name,
    'name'            => $name,
    'value'           => $value,
    'class'           => 'tco-form-control tco-form-control-max',
    'type'            => 'text',
    'data-cs-control' => $type
  );

  if ( isset( $options['placeholder'] ) ) {
    $atts['placeholder'] = $options['placeholder'];
  }

?>
<input <?php echo cs_atts( $atts); ?>>
