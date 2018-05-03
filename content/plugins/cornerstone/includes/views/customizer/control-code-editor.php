<?php

$textarea_atts = array(
	'data-cs-customizer-control' => 'cscodeeditor',
	'id'                         => 'cscodeeditor_text_' . $this->id,
	'class'                      => 'cscodeeditor-textarea',
);

$button_atts = array(
	'id'                         => 'cscodeeditor_button_' . $this->id,
	'class'                      => 'cscodeeditor-button',
);

$button_text = ( isset( $this->options['buttonText'] ) ) ? $this->options['buttonText'] : 'Edit Code';

?>

<label>
  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
  <button <?php echo cs_atts( $button_atts ); ?>><span><?php echo $button_text; ?></span></button>
</label>

<textarea <?php echo cs_atts( $textarea_atts ); $this->link(); ?> ><?php echo esc_textarea( $this->value() ); ?></textarea>

<script>

	jQuery( function($) {

		var options = JSON.parse( '<?php echo json_encode( $this->options ); ?>' );
		delete options.buttonText;

		var $ta     = $( '#cscodeeditor_text_<?php echo $this->id; ?>' );
		var $button = $( '#cscodeeditor_button_<?php echo $this->id; ?>' );

		$ta.csCodeEditor( options );

		$button.click( function( e ) {
			e.preventDefault();
			e.stopPropagation();
			$ta.csCodeEditorShow();
		} );

	} );

</script>
