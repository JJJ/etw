<?php
/**
 * Theme options via the Customizer.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

// ------------- Theme Customizer  ------------- //

add_action( 'customize_register', 'publisher_customizer_register' );

function publisher_customizer_register( $wp_customize ) {

	//Custom class for adding descriptions
	class Custom_Text_Control extends WP_Customize_Control {
        public $type = 'customtext';
        public $extra = ''; // for the extra description
        public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <span><?php echo esc_html( $this->extra ); ?></span>
        </label>
        <?php
        }
    }

	//General Theme Options

	$wp_customize->add_section( 'publisher_customizer_basic', array(
		'title' 		=> __( 'Theme Options', 'publisher' ),
		'description' 	=> __( 'Add your logo and social media links below.', 'publisher' ),
		'priority' 		=> 1
	) );

	//Logo Image
	$wp_customize->add_setting( 'publisher_customizer_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'publisher_customizer_logo', array(
		'label' 		=> __( 'Logo Upload', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_logo',
		'priority' 		=> 1
	) ) );

	//Post Background Effect
	$wp_customize->add_setting( 'publisher_customizer_bg_disable', array(
        'default'       => 'disable',
        'capability'    => 'edit_theme_options',
        'type'          => 'option',
    ));

    $wp_customize->add_control( 'publisher_bg_select_box', array(
        'settings' 		=> 'publisher_customizer_bg_disable',
        'label'   		=> __( 'Featured Image as Post Background', 'publisher' ),
        'section' 		=> 'publisher_customizer_basic',
        'type'    		=> 'select',
        'choices'    	=> array(
            'enable' 	=> __( 'Enable', 'publisher' ),
            'disable' 	=> __( 'Disable', 'publisher' ),
        ),
        'priority' 		=> 2
    ));

	//Social Description

    $wp_customize->add_setting( 'publisher_social_desc', array(
            'default' 	=> '',
            'type' 		=> 'customtext',
            'capability'=> 'edit_theme_options'
        )
    );
    $wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'customtext', array(
        'label' 		=> __( 'Social Media Links', 'publisher' ),
        'section' 		=> 'publisher_customizer_basic',
        'settings' 		=> 'publisher_social_desc',
        'extra' 		=> __( 'Add links to your various social media sites. These icons will appear in the header.', 'publisher' ),
        'priority' 		=> 4
        ) )
    );

	//Social Icons

	//Twitter
	$wp_customize->add_setting( 'publisher_customizer_icon_twitter', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_twitter', array(
		'label' 		=> __( 'Twitter URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_twitter',
		'type' 			=> 'text',
		'priority' 		=> 10
	) );

	//Facebook
	$wp_customize->add_setting( 'publisher_customizer_icon_facebook', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_facebook', array(
		'label' 		=> __( 'Facebook URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_facebook',
		'type' 			=> 'text',
		'priority' 		=> 20
	) );

	//Instagram
	$wp_customize->add_setting( 'publisher_customizer_icon_instagram', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_instagram', array(
		'label' 		=> __( 'Instagram URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_instagram',
		'type' 			=> 'text',
		'priority' 		=> 20
	) );

	//Tumblr
	$wp_customize->add_setting( 'publisher_customizer_icon_tumblr', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_tumblr', array(
		'label' 		=> __( 'Tumblr URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_tumblr',
		'type' 			=> 'text',
		'priority' 		=> 30
	) );

	//Dribbble
	$wp_customize->add_setting( 'publisher_customizer_icon_dribbble', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_dribbble', array(
		'label' 		=> __( 'Dribbble URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_dribbble',
		'type' 			=> 'text',
		'priority' 		=> 40
	) );

	//Flickr
	$wp_customize->add_setting( 'publisher_customizer_icon_flickr', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_flickr', array(
		'label' 		=> __( 'Flickr URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_flickr',
		'type' 			=> 'text',
		'priority' 		=> 50
	) );

	//Pinterest
	$wp_customize->add_setting( 'publisher_customizer_icon_pinterest', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_pinterest', array(
		'label' 		=> __( 'Pinterest URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_pinterest',
		'type' 			=> 'text',
		'priority' 		=> 60
	) );

	//Google+
	$wp_customize->add_setting( 'publisher_customizer_icon_googleplus', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_googleplus', array(
		'label' 		=> __( 'Google+ URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_googleplus',
		'type' 			=> 'text',
		'priority' 		=> 70
	) );

	//Vimeo
	$wp_customize->add_setting( 'publisher_customizer_icon_vimeo', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_vimeo', array(
		'label' 		=> __( 'Vimeo URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_vimeo',
		'type' 			=> 'text',
		'priority' 		=> 80
	) );

	//YouTube
	$wp_customize->add_setting( 'publisher_customizer_icon_youtube', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_youtube', array(
		'label' 		=> __( 'YouTube URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_youtube',
		'type' 			=> 'text',
		'priority' 		=> 90
	) );

	//LinkedIn
	$wp_customize->add_setting( 'publisher_customizer_icon_linkedin', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_linkedin', array(
		'label' 		=> __( 'LinkedIn URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_linkedin',
		'type' 			=> 'text',
		'priority' 		=> 100
	) );

	//RSS
	$wp_customize->add_setting( 'publisher_customizer_icon_rss', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_rss', array(
		'label' 		=> __( 'RSS URL', 'publisher' ),
		'section'		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_rss',
		'type' 			=> 'text',
		'priority' 		=> 110
	) );

	//Email
	$wp_customize->add_setting( 'publisher_customizer_icon_email', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_email', array(
		'label' 		=> __( 'Email Address', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_email',
		'type' 			=> 'text',
		'priority' 		=> 120
	) );

	//Github
	$wp_customize->add_setting( 'publisher_customizer_icon_github', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_github', array(
		'label'          => __( 'GitHub URL', 'publisher' ),
		'section'        => 'publisher_customizer_basic',
		'settings'       => 'publisher_customizer_icon_github',
		'type'           => 'text',
		'priority'       => 130
	) );

	//iTunes
	$wp_customize->add_setting( 'publisher_customizer_icon_itunes', array(
		'default' 		=> '',
		'type' 			=> 'option'
	) );

	$wp_customize->add_control( 'publisher_customizer_icon_itunes', array(
		'label' 		=> __( 'iTunes URL', 'publisher' ),
		'section' 		=> 'publisher_customizer_basic',
		'settings' 		=> 'publisher_customizer_icon_itunes',
		'type' 			=> 'text',
		'priority' 		=> 150
	) );

}