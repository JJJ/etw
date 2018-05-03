<?php

  $atts = array(
    'id'              => 'cs-control-' . $name,
    'name'            => $name,
    'value'           => $value,
    'class'           => 'tco-form-control tco-form-control-max',
    'type'            => 'text',
    'data-cs-control' => $type
  );

  $choices = isset( $options['choices'] ) ? $options['choices'] : array();

?>
<select <?php echo cs_atts( $atts ); ?>>
  <?php foreach ( $choices as $option_value => $label ) : ?>
    <option value="<?php echo $option_value; ?>" <?php selected( $option_value, $value ); ?> ><?php echo $label ?></option>
  <?php endforeach; ?>
</select>
