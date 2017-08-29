<?php

// ------------- Theme Customizer  ------------- //

add_action( 'customize_register', 'medium_customizer_register' );

function medium_customizer_register( $wp_customize ) {

	class Medium_Customize_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';

	    public function render_content() {
	        ?>
	        <label>
		        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	        </label>
	        <?php
	    }
	}

	//Style Options

	$wp_customize->add_section( 'medium_customizer_basic', array(
		'title' 	=> __( 'Theme Options', 'medium' ),
		'priority' 	=> 1
	) );

	//Logo Image
	$wp_customize->add_setting( 'medium_customizer_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'medium_customizer_logo', array(
		'label' 	=> __( 'Logo Upload', 'medium' ),
		'section' 	=> 'medium_customizer_basic',
		'settings' 	=> 'medium_customizer_logo',
		'priority' 	=> 1
	) ) );

	//Accent Color
	$wp_customize->add_setting( 'medium_customizer_accent', array(
		'default' 	=> '#3ac1e8'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'medium_customizer_accent', array(
		'label'   	=> __( 'Accent Color', 'medium' ),
		'section' 	=> 'medium_customizer_basic',
		'settings'  => 'medium_customizer_accent'
	) ) );

	//Link Color
	$wp_customize->add_setting( 'medium_customizer_link', array(
		'default' 	=> '#3ac1e8'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'medium_customizer_link', array(
		'label'   	=> __( 'Link Color', 'medium' ),
		'section' 	=> 'medium_customizer_basic',
		'settings'  => 'medium_customizer_link'
	) ) );

	//Infinite Scroll
	$wp_customize->add_setting( 'medium_customizer_infinite', array(
        'default'   => 'disabled',
        'capability' => 'edit_theme_options',
        'type'      => 'option',
    ) );

    $wp_customize->add_control( 'infinite_select_box', array(
        'settings' 	=> 'medium_customizer_infinite',
        'label'   	=> __( 'Infinite Scrolling', 'medium' ),
        'section' 	=> 'medium_customizer_basic',
        'type'    	=> 'select',
        'choices'   => array(
            'enabled' 	=> __( 'Enabled', 'medium' ),
            'disabled' 	=> __( 'Disabled', 'medium' )
        ),
    ) );

    //Custom CSS
	$wp_customize->add_setting( 'medium_customizer_css', array(
        'default' 	=> '',
    ) );

    $wp_customize->add_control( new Medium_Customize_Textarea_Control( $wp_customize, 'medium_customizer_css', array(
	    'label'   	=> __( 'Custom CSS', 'medium' ),
	    'section' 	=> 'medium_customizer_basic',
	    'settings'  => 'medium_customizer_css',
	) ) );

}