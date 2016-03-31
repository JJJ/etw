<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Customizer_ControlsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Customizer_ControlsInterface ) {
	return;
}

// Navigation section is deprecated in WP 4.3 in favor of Menu panel
// so bail if it exists.
if ( class_exists( 'WP_Customize_Nav_Menus' ) ) {
	return;
}

// Section ID
$section_id = 'nav';

// The Navigation section only exists if custom menus have been created.
if ( ! isset( $wp_customize->get_section( $section_id )->title ) ) {
	$wp_customize->add_section( 'nav' );
}
$section = $wp_customize->get_section( $section_id );

$priority = new MAKE_Util_Priority( 10, 5 );

// Move Navigation section to General panel
$section->panel = $this->prefix . 'general';

// Set Navigation section priority
$logo_priority = $wp_customize->get_section( $this->prefix . 'logo' )->priority;
$section->priority = $logo_priority + 5;

/**
 * Adjust Navigation section description
 *
 * Since the Social Profile Links item gets moved to another section, the part of the description that
 * states the number of menu locations is misleading.
 *
 * Only show this description if a custom menu has been created, thus exposing the menu location options.
 */
$primary_menu = $wp_customize->get_control( 'nav_menu_locations[primary]' );
if ( $primary_menu instanceof WP_Customize_Control ) {
	$section->description = __( 'Select which menu appears in each location. You can edit your menu content on the Menus screen in the Appearance section.', 'make' );
}