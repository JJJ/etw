<?php

// ------------- Theme Customizer  ------------- //

add_action( 'customize_register', 'north_theme_customizer_register' );

function north_theme_customizer_register( $wp_customize ) {

	class North_Customize_Textarea_Control extends WP_Customize_Control {
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

	// Live preview
	if ( $wp_customize->is_preview() && ! is_admin() ) {
	    add_action( 'wp_footer', 'north_customize_preview', 21);
	}

	function north_customize_preview() {
	    ?>
	    <script type="text/javascript">
	        ( function( $ ) {
	            // Homepage title preview
	            wp.customize('north_homepage_title',function( value ) {
	                value.bind(function(to) {
	                    $('.home .entry-title').html(to);
	                });
	            });

	            // Homepage subtitle preview
	            wp.customize('north_homepage_subtitle',function( value ) {
	                value.bind(function(to) {
	                    $('.home .entry-subtitle').html(to);
	                });
	            });

	            // Header color
	            wp.customize('north_header_color',function( value ) {
	                value.bind(function(to) {
	                    $('.header-wrap').css('background-color', to );
	                });
	            });
	        } )( jQuery )
	    </script>
	    <?php
	}

	//North Customizer Options

	$wp_customize->add_section( 'north_customizer_options', array(
		'title' 	=> __( 'Theme Options', 'north' ),
		'priority' 	=> 1
	) );

	//Logo Image
	$wp_customize->add_setting( 'north_logo_upload', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'north_logo_upload', array(
		'label' 	=> __( 'Logo Upload', 'north' ),
		'section' 	=> 'north_customizer_options',
		'settings' 	=> 'north_logo_upload',
		'priority' 	=> 1
	) ) );

	//Header Color
	$wp_customize->add_setting( 'north_header_color', array(
		'default' 	=> '#32373b',
		'transport' => 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'north_header_color', array(
		'label'   	=> __( 'Header Color', 'north' ),
		'section' 	=> 'north_customizer_options',
		'settings'  => 'north_header_color',
		'priority' 	=> 2
	) ) );

	//Link Color
	$wp_customize->add_setting( 'north_link_color', array(
		'default' => '#48ADD8',
		'transport' => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'north_link_color', array(
		'label'   	=> __( 'Link Color', 'north' ),
		'section' 	=> 'north_customizer_options',
		'settings'  => 'north_link_color',
		'priority' 	=> 3
	) ) );

	//Accent Color
	$wp_customize->add_setting( 'north_accent_color', array(
		'default' 	=> '#48ADD8',
		'transport' => 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'north_accent_color', array(
		'label'   	=> __( 'Accent Color', 'north' ),
		'section' 	=> 'north_customizer_options',
		'settings'  => 'north_accent_color',
		'priority' 	=> 4
	) ) );

    //Custom CSS
	$wp_customize->add_setting( 'north_customizer_css', array(
        'default' 	=> '',
    ) );

    $wp_customize->add_control( new North_Customize_Textarea_Control( $wp_customize, 'north_customizer_css', array(
	    'label'   	=> __( 'Custom CSS', 'north' ),
	    'section' 	=> 'north_customizer_options',
	    'settings'  => 'north_customizer_css',
	    'priority' 	=> 5
	) ) );
}