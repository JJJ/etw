<?php
/**
 * Self-hosted functionality not to be included on WordPress.com
 *
 * @package Camera
 */

/**
 * Load the Getting Started page and Theme Update class
 */
if( is_admin() ) {

	// Add Getting Started page
	require_once( get_template_directory() . '/inc/admin/updater/theme-updater.php' );

	// TGM Activation class
	require_once( get_template_directory() . '/inc/admin/tgm/tgm-activation.php' );
}

/**
 * Registers additional customizer controls
 */
function array_register_customizer_options( $wp_customize ) {

	/**
	 * Adds textarea support to the theme customizer
	 */
	class Camera_Customize_Textarea_Control extends WP_Customize_Control {
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

	// Logo and header text options - only show if Site Logos is not supported
	if ( ! function_exists( 'the_site_logo' ) ) {
		$wp_customize->add_setting( 'camera_customizer_logo', array(
			'transport' => 'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'camera_customizer_logo', array(
			'label'    => __( 'Logo Upload', 'camera' ),
			'section'  => 'title_tagline',
			'settings' => 'camera_customizer_logo'
		) ) );
	}

	// Custom CSS
	$wp_customize->add_section( 'camera_custom_css', array(
		'description' => __( 'Enter your styles in the box below.', 'camera' ),
		'title'       => __( 'Custom CSS', 'camera' ),
		'priority'    => 90
	) );

	$wp_customize->add_setting( 'camera_customizer_css' );

	$wp_customize->add_control(
		new Camera_Customize_Textarea_Control( $wp_customize, 'camera_customizer_css',
			array(
				'section'  => 'camera_custom_css',
				'settings' => 'camera_customizer_css',
				'priority' => 11
			)
		)
	);
}
add_action( 'customize_register', 'array_register_customizer_options' );

/**
 * Add Customizer CSS To Header
 */
function camera_customizer_css() {
	?>
	<style type="text/css">
		<?php echo get_theme_mod( 'camera_customizer_css' ); ?>
	</style>
<?php
}
add_action( 'wp_head', 'camera_customizer_css' );


/**
 * Add infinite-scroll class if active
 */
function camera_is_class( $classes ) {
	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		$classes[] = 'infinite-scroll';
	}

	return $classes;
}
add_filter( 'body_class', 'camera_is_class' );
