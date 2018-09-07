<?php

/**
 * Element Shortcode: Icon List Item
 */

$atts = cs_atts( array(
	'id' => $id,
	'class' => trim( 'x-li-icon ' . $class ),
	'style' => $style
) );

$icon_style = ( $icon_color != '' ) ? "color: $icon_color;" : '';

$icon_atts = array(
	'class' => 'x-icon-' . $type,
	'aria-hidden' => 'true',
	'style' => $icon_style
);

$icon_attr = fa_get_attr( $type );
$icon_atts[$icon_attr['attr']] = $icon_attr['entity'];

$icon_atts = cs_atts( $icon_atts );

$link_begin = '';
$link_end   = '';

if ( $link_enabled ) {

	$link_atts = cs_atts( array(
		'href'   => $link_url,
		'title'  => $link_title,
		'target' => ( $link_new_tab) ? '_blank' : ''
	) );

	$link_begin = "<a {$link_atts}>";
	$link_end   = "</a>";

}

echo "<li {$atts} ><i {$icon_atts} ></i>" . $link_begin . do_shortcode( $content ) .  $link_end . "</li>";
