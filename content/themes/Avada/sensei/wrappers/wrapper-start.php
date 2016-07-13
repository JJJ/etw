<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	Sensei/Templates
 * @version	 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $smof_data;

$template = get_option('template');

if($smof_data['default_sidebar_pos'] == 'Left') {
	$content_css = 'float:right;';
	$sidebar_css = 'float:left;';
} elseif($smof_data['default_sidebar_pos'] == 'Right') {
	$content_css = 'float:left;';
	$sidebar_css = 'float:right;';
}

switch( $template ) {

	// IF Twenty Eleven
	case 'twentyeleven' :
		echo '<div id="primary"><div id="content" role="main">';
		break;

	// IF Twenty Twelve
	case 'twentytwelve' :
		echo '<div id="primary" class="site-content"><div id="content" role="main">';
		break;

	// IF Twenty Fourteen
	case 'twentyfourteen' :
		echo '<div id="main-content" class="main-content"><div id="primary" class="content-area"><div id="content" class="site-content" role="main">';
		break;

	// IF Canvas
	case 'canvas' :
		echo '<div id="content" class="col-full"><div id="main-sidebar-container"><div id="main">';
		break;	

	// Default
	default :
		echo '<div class="sensei-container"><div id="content" style="'.$content_css.'">';
		break;
}

?>