<?php

/**
 * Element Shortcode: Icon List
 */

$atts = cs_atts( array(
	'id' => $id,
	'class' => trim( 'x-ul-icons ' . $class ),
	'style' => $style
) );

echo "<ul {$atts} >" . do_shortcode( $content ) . "</ul>";