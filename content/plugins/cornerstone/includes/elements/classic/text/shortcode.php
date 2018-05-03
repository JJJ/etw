<?php

/**
 * Element Shortcode: Text
 */

$class = ( ( '' == $text_align ) ? 'x-text' : 'x-text ' . $text_align ) . ' ' . esc_attr( $class );

$atts = cs_atts( array(
	'id' => $id,
	'class' => trim( $class ),
	'style' => $style
) );

echo "<div {$atts} >" . do_shortcode( wpautop( $content ) ) ."</div>";