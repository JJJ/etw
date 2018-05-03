<?php

	$atts = array(
		'id'              => 'cs-control-' . $name,
		'name'            => $name,
		'value'           => 'enabled',
		'class'           => 'tco-form-control tco-form-control-max',
		'type'            => 'checkbox',
		'data-cs-control' => $type,
	);

	if ( 'true' === $value ) {
		$atts['checked'] = null;
	}

?>

<label class="tco-rc tco-checkbox" for="cs-control-<?php echo $name;?>">
  <input <?php cs_atts( $atts, true ); ?>>
  <span class="tco-form-control-indicator"></span>
  <span class="tco-form-control-indicator-label">Enable</span>
</label>