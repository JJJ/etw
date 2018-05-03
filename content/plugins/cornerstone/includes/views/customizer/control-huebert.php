<?php

$input_atts = array(
	'data-cs-customizer-control' => 'huebert',
	'type'                       => 'text',
	'id'                         => 'input_' . $this->id,
	'value'                      => $this->value(),
);

if ( $this->setting->default ) {
	$input_atts['data-huebert-default-value'] = $this->setting->default;
}

?>
<label>
	<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	<input <?php echo cs_atts( $input_atts ) . ' ';
	$this->link(); ?>/>
</label>

<script>
var options = { float: false };
<?php if ( $this->setting->default ) { ?>
	options.reset = 'default';
<?php } ?>
jQuery(document).ready(function($) { $('#input_<?php echo $this->id; ?>').huebert(options); });
</script>
