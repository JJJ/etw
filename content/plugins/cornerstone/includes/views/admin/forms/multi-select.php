<?php

	$atts = array(
		'id'              => 'cs-control-' . $name,
		'name'            => $name,
		'value'           => $value,
		'class'           => 'tco-form-control tco-form-control-max',
		'type'            => 'text',
		'data-cs-control' => $type,
		'data-cs-options' => wp_json_encode( $options ),
	);

	if ( isset( $options['placeholder'] ) ) {
		$atts['placeholder'] = $options['placeholder'];
	}

?>
<input <?php cs_atts( $atts, true ); ?>>