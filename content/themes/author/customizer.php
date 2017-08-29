<?php
/**
 * Theme options via the Customizer.
 *
 * @package Author
 * @since Author 1.0
 */

// ------------- Theme Customizer  ------------- //

add_action( 'customize_register', 'author_customizer_register' );

function author_customizer_register( $wp_customize ) {

	class Author_Customize_Textarea_Control extends WP_Customize_Control {
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

	$wp_customize->add_section( 'author_customizer_basic', array(
		'title'       => __( 'Theme Options', 'author' ),
		'description' => __( 'Add your logo and social media links below.', 'author' ),
		'priority'    => 1
	) );

	//Logo Image
	$wp_customize->add_setting( 'author_customizer_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'author_customizer_logo', array(
		'label'    => __( 'Logo Upload', 'author' ),
		'section'  => 'author_customizer_basic',
		'settings' => 'author_customizer_logo',
		'priority' => 1
	) ) );

	//Accent Color
	$wp_customize->add_setting( 'author_customizer_accent', array(
		'default' => '#55BEE6'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'author_customizer_accent', array(
		'label'    => __( 'Accent Color', 'author' ),
		'section'  => 'author_customizer_basic',
		'settings' => 'author_customizer_accent',
		'priority' => 3
	) ) );

	//Excerpt Slider
	$wp_customize->add_setting( 'author_customizer_slider_disable', array(
		'default'    => 'enable',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
	) );

	$wp_customize->add_control( 'author_slider_select_box', array(
		'settings' => 'author_customizer_slider_disable',
		'label'    => __( 'Homepage Excerpt Slider', 'author' ),
		'section'  => 'author_customizer_basic',
		'type'     => 'select',
		'choices'  => array(
			'enable'  => __( 'Enable', 'author' ),
			'disable' => __( 'Disable', 'author' ),
			),
		'priority' => 6
	) );

	//Custom CSS
	$wp_customize->add_setting( 'author_customizer_css', array(
		'default' 	=> '',
	) );

	$wp_customize->add_control( new Author_Customize_Textarea_Control( $wp_customize, 'author_customizer_css', array(
		'label'   	=> __( 'Custom CSS', 'author' ),
		'section' 	=> 'author_customizer_basic',
		'settings'  => 'author_customizer_css',
	) ) );

}
