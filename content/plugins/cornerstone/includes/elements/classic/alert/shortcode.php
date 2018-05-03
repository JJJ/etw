<?php

/**
 * Element Shortcode: Alert
 */

$close_class = ( $close ) ? 'fade in' : 'x-alert-block';

$atts = cs_atts( array(
	'id' => $id,
	'class' => trim( "x-alert x-alert-$type " . $close_class . ' ' . $class ),
	'style' => $style
) );
$heading = cs_decode_shortcode_attribute( $heading );

$button = ( $close ) ? "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" : '';
$heading = ( $heading ) ? "<h6 class=\"h-alert\">{$heading}</h6>" : '';

echo "<div {$atts}>{$button}{$heading}" . do_shortcode($content) . "</div>";
