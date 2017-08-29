<?php
/**
 * Array Toolkit Admin Functions
 *
 * @since 1.0.0
 */


class Array_Toolkit_Admin {


	function __construct() {

		// Return early if not in the admin
		if( ! is_admin() )
			return;

		// Custom meta box library
		if ( ! class_exists( 'cmb_Meta_Box' ) ) {
			require_if_theme_supports( 'array_themes_metabox_support', ARRAY_TOOLKIT_INCLUDES . 'lib/metabox/init.php' );
		}

		// Hook into theme's Getting Started page
		// Saved for later use
		// add_action( 'array_toolkit_getting_started_theme_page', array( $this, 'getting_started_theme_page' ) );
	}



	/**
	 * Displays Toolkit info on theme's Getting Started page
	 *
	 * @since 1.0.0
	 */
	function getting_started_theme_page() {

		$output = '<div class="panel-aside">';
		$output .= '<h4>Array Toolkit</h4>';
		$output .= sprintf( '<p>' . __( 'You have successfully activated the Array Toolkit. Read the <a href="%1$s">help file</a> to learn more.', 'array-toolkit' ), 'https://array.is/articles/array-toolkit' . '</p>');
		$output .= '</div>';

		echo $output;
	}

}
$array_toolkit_admin = new Array_Toolkit_Admin;