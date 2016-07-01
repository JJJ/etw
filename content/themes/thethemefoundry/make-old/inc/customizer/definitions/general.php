<?php
/**
 * @package Make
 */

// Bail if this isn't being included inside of a MAKE_Customizer_ControlsInterface.
if ( ! isset( $this ) || ! $this instanceof MAKE_Customizer_ControlsInterface ) {
	return;
}

// Panel ID
$panel = $this->prefix . 'general';

// Logo
if ( $this->logo()->custom_logo_is_supported() ) {
	$this->add_section_definitions( 'logo', array(
		'panel'    => $panel,
		'title'    => __( 'Logo', 'make' ),
		'controls' => array(
			'logo-notice' => array(
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Html',
					'label'        => __( 'Regular & Retina Logos', 'make' ),
					'description'  => esc_html__( '
						These settings have been deprecated in favor of the Site Logo setting provided by WordPress core.
						Please visit the Site Identity section to configure your site icon.
					', 'make' ),
				),
			),
		)
	) ); // Overwrite to add additional controls to the section
} else {
	$this->add_section_definitions( 'logo', array(
		'panel'    => $panel,
		'title'    => __( 'Logo', 'make' ),
		'controls' => array(
			'logo-regular' => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'WP_Customize_Image_Control',
					'label'        => __( 'Regular Logo', 'make' ),
					'context'      => $this->prefix . 'logo-regular',
				),
			),
			'logo-retina'  => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'WP_Customize_Image_Control',
					'label'        => __( 'Retina Logo (2x)', 'make' ),
					'description'  => esc_html__( 'The Retina Logo should be twice the size of the Regular Logo.', 'make' ),
					'context'      => $this->prefix . 'logo-retina',
				),
			),
		),
	) );
}

// Deprecated Site Icon controls
if ( function_exists( 'has_site_icon' ) ) {
	$this->add_section_definitions( 'logo', array(
		'controls' => array(
			'logo-icons-notice' => array(
				'control' => array(
					'control_type' => 'MAKE_Customizer_Control_Html',
					'label'        => __( 'Favicon & Apple Touch Icon', 'make' ),
					'description'  => __( 'These settings have been deprecated in favor of the Site Icon setting provided by WordPress core. Please visit the Site Identity section to configure your site icon.', 'make' ),
				),
			),
		)
	), true ); // Overwrite to add additional controls to the section
} else {
	$this->add_section_definitions( 'logo', array(
		'controls' => array(
			'logo-favicon'     => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'WP_Customize_Image_Control',
					'label'        => __( 'Favicon', 'make' ),
					'description'  => __( 'File must be <strong>.png</strong> or <strong>.ico</strong> format. Optimal dimensions: <strong>32px x 32px</strong>.', 'make' ),
					'context'      => $this->prefix . 'logo-favicon',
					'extensions'   => array( 'png', 'ico' ),
				),
			),
			'logo-apple-touch' => array(
				'setting' => true,
				'control' => array(
					'control_type' => 'WP_Customize_Image_Control',
					'label'        => __( 'Apple Touch Icon', 'make' ),
					'description'  => __( 'File must be <strong>.png</strong> format. Optimal dimensions: <strong>152px x 152px</strong>.', 'make' ),
					'context'      => $this->prefix . 'logo-apple-touch',
					'extensions'   => array( 'png' ),
				),
			),
		)
	), true ); // Overwrite to add additional controls to the section
}

// Labels
$this->add_section_definitions( 'labels', array(
	'panel'    => $panel,
	'title'    => __( 'Labels', 'make' ),
	'controls' => array(
		'label-search-field'      => array(
			'setting' => array(
				'transport' => 'postMessage',
			),
			'control' => array(
				'label' => __( 'Search Field Label', 'make' ),
				'type'  => 'text',
			),
		),
		'navigation-mobile-label' => array(
			'setting' => array(
				'theme_supports' => 'menus',
				'transport'      => 'postMessage',
			),
			'control' => array(
				'label'       => __( 'Mobile Menu Label', 'make' ),
				'description' => __( 'Resize your browser window to preview the mobile menu label.', 'make' ),
				'type'        => 'text',
			),
		),
		'general-sticky-label'    => array(
			'setting' => array(
				'transport' => 'postMessage',
			),
			'control' => array(
				'label' => __( 'Sticky Label', 'make' ),
				'type'  => 'text',
			),
		),
	),
) );

// Only show the Read More label option if no filters have been added to the deprecated filter hook.
// has_filter() can't be used here because of the hook-prefixing filters added for back compatibility.
/** This filter is documented in inc/template-tags.php */
if ( false === apply_filters( 'make_read_more_text', false ) ) {
	$this->add_section_definitions( 'labels', array(
		'controls' => array(
			'label-read-more' => array(
				'setting' => array(
					'transport' => 'postMessage',
				),
				'control' => array(
					'label' => __( 'Read More Label', 'make' ),
					'type'  => 'text',
				),
			)
		)
	), true ); // Overwrite to add additional controls to the section
}

// Social Profiles
$this->add_section_definitions( 'social', array(
	'panel'       => $panel,
	'title'       => __( 'Social Icons', 'make' ),
	'controls'    => array(
		'social-icons'  => array(
			'setting' => true,
			'control' => array(
				'control_type' => 'MAKE_Customizer_Control_SocialIcons',
				'description' => __( 'Add a link to each of your social profiles and we&#8217;ll add the icon to match — it&#8217;s that simple. Drag and drop to rearrange.', 'make' )
			),
		),
	),
) );

// Check for deprecated filters
foreach ( array( 'make_customizer_general_sections' ) as $filter ) {
	if ( has_filter( $filter ) ) {
		$this->compatibility->deprecated_hook(
			$filter,
			'1.7.0',
			sprintf(
				esc_html__( 'To add or modify Customizer sections and controls, use the %1$s hook instead, or the core %2$s methods.', 'make' ),
				'<code>make_customizer_sections</code>',
				'<code>$wp_customize</code>'
			)
		);
	}
}
