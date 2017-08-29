<?php
/**
 * Theme options via the Customizer.
 *
 * @package Transmit
 * @since Transmit 1.0
 */

// ------------- Theme Customizer  ------------- //

add_action( 'customize_register', 'transmit_customizer_register' );

function transmit_customizer_register( $wp_customize ) {

	class Okay_Customize_Textarea_Control extends WP_Customize_Control {
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

	//General Theme Options

	$wp_customize->add_section( 'transmit_customizer_basic', array(
		'title'             => __( 'Theme Options', 'transmit' ),
		'priority'          => 1
	) );

	//Logo Image
	$wp_customize->add_setting( 'transmit_customizer_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'transmit_customizer_logo', array(
		'label'             => __( 'Logo Upload', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_logo',
		'priority'          => 1
	) ) );

	//Accent Color
	$wp_customize->add_setting( 'transmit_customizer_accent', array(
		'default'           => '#EB4949'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'transmit_customizer_accent', array(
		'label'             => __( 'Accent Color', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_accent',
		'priority'          => 2
	) ) );

	//Custom CSS
	$wp_customize->add_setting( 'transmit_customizer_css', array(
		'default'           => '',
	) );

	$wp_customize->add_control( new Okay_Customize_Textarea_Control( $wp_customize, 'transmit_customizer_css', array(
		'label'             => __( 'Custom CSS', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_css',
		'priority'          => 7
	) ) );

	//Social Icons

	//Twitter
	$wp_customize->add_setting( 'transmit_customizer_icon_twitter', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_twitter', array(
		'label'             => __( 'Twitter URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_twitter',
		'type'              => 'text',
		'priority'          => 10
	) );

	//Facebook
	$wp_customize->add_setting( 'transmit_customizer_icon_facebook', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_facebook', array(
		'label'             => __( 'Facebook URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_facebook',
		'type'              => 'text',
		'priority'          => 20
	) );

	//Instagram
	$wp_customize->add_setting( 'transmit_customizer_icon_instagram', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_instagram', array(
		'label'             => __( 'Instagram URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_instagram',
		'type'              => 'text',
		'priority'          => 30
	) );

	//Tumblr
	$wp_customize->add_setting( 'transmit_customizer_icon_tumblr', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_tumblr', array(
		'label'             => __( 'Tumblr URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_tumblr',
		'type'              => 'text',
		'priority'          => 40
	) );

	//Dribbble
	$wp_customize->add_setting( 'transmit_customizer_icon_dribbble', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_dribbble', array(
		'label'             => __( 'Dribbble URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_dribbble',
		'type'              => 'text',
		'priority'          => 50
	) );

	//Flickr
	$wp_customize->add_setting( 'transmit_customizer_icon_flickr', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_flickr', array(
		'label'             => __( 'Flickr URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_flickr',
		'type'              => 'text',
		'priority'          => 60
	) );

	//Pinterest
	$wp_customize->add_setting( 'transmit_customizer_icon_pinterest', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_pinterest', array(
		'label'             => __( 'Pinterest URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_pinterest',
		'type'              => 'text',
		'priority'          => 70
	) );

	//Google+
	$wp_customize->add_setting( 'transmit_customizer_icon_googleplus', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_googleplus', array(
		'label'             => __( 'Google+ URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_googleplus',
		'type'              => 'text',
		'priority'          => 80
	) );

	//Vimeo
	$wp_customize->add_setting( 'transmit_customizer_icon_vimeo', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_vimeo', array(
		'label'             => __( 'Vimeo URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_vimeo',
		'type'              => 'text',
		'priority'          => 90
	) );

	//YouTube
	$wp_customize->add_setting( 'transmit_customizer_icon_youtube', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_youtube', array(
		'label'             => __( 'YouTube URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_youtube',
		'type'              => 'text',
		'priority'          => 100
	) );

	//LinkedIn
	$wp_customize->add_setting( 'transmit_customizer_icon_linkedin', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_linkedin', array(
		'label'             => __( 'LinkedIn URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_linkedin',
		'type'              => 'text',
		'priority'          => 110
	) );

	//RSS
	$wp_customize->add_setting( 'transmit_customizer_icon_rss', array(
		'default'           => '',
		'type'              => 'option'
	) );

	$wp_customize->add_control( 'transmit_customizer_icon_rss', array(
		'label'             => __( 'RSS URL', 'transmit' ),
		'section'           => 'transmit_customizer_basic',
		'settings'          => 'transmit_customizer_icon_rss',
		'type'              => 'text',
		'priority'          => 120
	) );

	//Background Image
	$wp_customize->add_setting( 'transmit_customizer_bg', array(
		'default'           => 'enable',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'default'           => 'mountains.jpg'
	) );

	$wp_customize->add_control( 'transmit_customizer_bg_box', array(
		'settings'          => 'transmit_customizer_bg',
		'label'             => __( 'Transmit Backgrounds', 'transmit' ),
		'section'           => 'background_image',
		'type'              => 'select',
		'choices'           => array(
			''              => __( 'Disable', 'transmit' ),
			'mountains.jpg' => __( 'Mountains', 'transmit' ),
			'wood.jpg'      => __( 'Wood', 'transmit' ),
			'desk.jpg'      => __( 'Desk', 'transmit' ),
		),
		'priority'          => 6
	) );

}