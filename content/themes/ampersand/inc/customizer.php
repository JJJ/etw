<?php
/**
 * Theme options via the Customizer.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

add_action( 'customize_register', 'ampersand_customizer_register' );

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Add text description to social links area
 */
class Custom_Text_Control extends WP_Customize_Control {
	public $type  = 'customtext';
	public $extra = '';
	public function render_content() {
	?>
	<label>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<span><?php echo esc_html( $this->extra ); ?></span>
	</label>
	<?php
	}
}

/**
 * Sanitize header background select option
 */
function ampersand_sanitize_background_select( $header_bg ) {

    if( ! in_array( $header_bg, array( 'enable', 'disable' ) ) ) {
        $header_bg = 'enable';
    }
    return $header_bg;
}

/**
 * Sanitize text
 */
function ampersand_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize page drop down
 */
function ampersand_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

/**
 * Sanitize checkbox
 */
function ampersand_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

/**
 * @param WP_Customize_Manager $wp_customize
 */
function ampersand_customizer_register( $wp_customize ) {

	// General Theme Options

	$wp_customize->add_section( 'ampersand_customizer_basic', array(
		'title'        => __( 'Theme Options', 'ampersand' ),
		'priority'     => 1
	) );

	// Logo Image
	$wp_customize->add_setting( 'ampersand_customizer_logo', array(
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ampersand_customizer_logo', array(
		'label'    => __( 'Logo Upload', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_logo',
		'priority' => 1
	) ) );

	// Homepage Header Subtitle Text
	$wp_customize->add_setting( 'ampersand_customizer_header_subtitle_text', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_header_subtitle_text', array(
		'label'    => __( 'Homepage Header Subtitle Text', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_header_subtitle_text',
		'type'     => 'text',
		'priority' => 5
	) );

	// Homepage Header Button Link
	$wp_customize->add_setting( 'ampersand_customizer_header_page', array(
		'default'           => '',
		'sanitize_callback' => 'ampersand_sanitize_integer',
	) );

	$wp_customize->add_control( 'ampersand_customizer_header_page', array(
		'type'     => 'dropdown-pages',
		'label'    => 	__( 'Homepage Header Button Link', 'ampersand' ),
		'settings' => 'ampersand_customizer_header_page',
		'section'  => 'ampersand_customizer_basic',
		'priority' => 7
	));

	// Homepage Header Button Text
	$wp_customize->add_setting( 'ampersand_customizer_header_text', array(
		'default'           => __( 'Read More', 'ampersand' ),
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_header_text', array(
		'label'    => __( 'Homepage Header Button Text', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_header_text',
		'type'     => 'text',
		'priority' => 9
	) );

	// Header Background Effect
	$wp_customize->add_setting( 'ampersand_customizer_bg_disable', array(
		'default'           => 'enable',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_background_select'
    ));

    $wp_customize->add_control( 'ampersand_bg_select_box', array(
			'settings' 		=> 'ampersand_customizer_bg_disable',
			'label'   		=> __( 'Header Background Effect', 'ampersand' ),
			'section' 		=> 'ampersand_customizer_basic',
			'type'    		=> 'select',
			'choices'    	=> array(
			'enable' 	=> __( 'Enable', 'ampersand' ),
			'disable' 	=> __( 'Disable', 'ampersand' ),
			),
			'priority' 		=> 11
    ));

	// Social Description

    $wp_customize->add_setting('ampersand_social_desc', array(
			'default'    => '',
			'type'       => 'customtext',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ampersand_sanitize_text'
        )
    );
    $wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'customtext', array(
		'label'    => __( 'Social Media Links', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_social_desc',
		'extra'    => __( 'Add links to your various social media sites. These icons will appear in the footer.', 'ampersand' ),
		'priority' => 12
        ) )
    );

	// Social Icons

	// Twitter
	$wp_customize->add_setting( 'ampersand_customizer_icon_twitter', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_twitter', array(
		'label'    => __( 'Twitter URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_twitter',
		'type'     => 'text',
		'priority' => 14
	) );

	// Facebook
	$wp_customize->add_setting( 'ampersand_customizer_icon_facebook', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_facebook', array(
		'label'    => __( 'Facebook URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_facebook',
		'type'     => 'text',
		'priority' => 20
	) );

	// Instagram
	$wp_customize->add_setting( 'ampersand_customizer_icon_instagram', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_instagram', array(
		'label'    => __( 'Instagram URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_instagram',
		'type'     => 'text',
		'priority' => 20
	) );

	// Tumblr
	$wp_customize->add_setting( 'ampersand_customizer_icon_tumblr', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_tumblr', array(
		'label'    => __( 'Tumblr URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_tumblr',
		'type'     => 'text',
		'priority' => 30
	) );

	// Dribbble
	$wp_customize->add_setting( 'ampersand_customizer_icon_dribbble', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_dribbble', array(
		'label'    => __( 'Dribbble URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_dribbble',
		'type'     => 'text',
		'priority' => 40
	) );

	// Flickr
	$wp_customize->add_setting( 'ampersand_customizer_icon_flickr', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_flickr', array(
		'label'    => __( 'Flickr URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_flickr',
		'type'     => 'text',
		'priority' => 50
	) );

	// Pinterest
	$wp_customize->add_setting( 'ampersand_customizer_icon_pinterest', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_pinterest', array(
		'label'    => __( 'Pinterest URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_pinterest',
		'type'     => 'text',
		'priority' => 60
	) );

	// Google+
	$wp_customize->add_setting( 'ampersand_customizer_icon_googleplus', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_googleplus', array(
		'label'    => __( 'Google+ URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_googleplus',
		'type'     => 'text',
		'priority' => 70
	) );

	// Vimeo
	$wp_customize->add_setting( 'ampersand_customizer_icon_vimeo', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_vimeo', array(
		'label'    => __( 'Vimeo URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_vimeo',
		'type'     => 'text',
		'priority' => 80
	) );

	// YouTube
	$wp_customize->add_setting( 'ampersand_customizer_icon_youtube', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_youtube', array(
		'label'    => __( 'YouTube URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_youtube',
		'type'     => 'text',
		'priority' => 90
	) );

	//LinkedIn
	$wp_customize->add_setting( 'ampersand_customizer_icon_linkedin', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_linkedin', array(
		'label'    => __( 'LinkedIn URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_linkedin',
		'type'     => 'text',
		'priority' => 100
	) );

	// RSS
	$wp_customize->add_setting( 'ampersand_customizer_icon_rss', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_rss', array(
		'label'    => __( 'RSS URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_rss',
		'type'     => 'text',
		'priority' => 110
	) );

    // Snapchat
	$wp_customize->add_setting( 'ampersand_customizer_icon_snapchat', array(
		'default'           => '',
		'type'              => 'option',
		'sanitize_callback' => 'ampersand_sanitize_text'
	) );

	$wp_customize->add_control( 'ampersand_customizer_icon_snapchat', array(
		'label'    => __( 'Snapchat URL', 'ampersand' ),
		'section'  => 'ampersand_customizer_basic',
		'settings' => 'ampersand_customizer_icon_snapchat',
		'type'     => 'text',
		'priority' => 120
	) );

	// Hide site tagline
	$wp_customize->add_setting( 'ampersand_hide_tagline', array(
		'default'           => '1',
		'sanitize_callback' => 'ampersand_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'ampersand_hide_tagline', array(
		'type'    => 'checkbox',
		'label'   => __( 'Hide Site Tagline', 'ampersand' ),
		'section' => 'title_tagline'
	) );

}
