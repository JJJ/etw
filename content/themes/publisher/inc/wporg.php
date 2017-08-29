<?php
/**
 * Self-hosted functionality not to be included on WordPress.com
 *
 * @package Designer
 */


/**
 * Load the Getting Started page and Theme Update class
 */
if( is_admin() ) {

	if( file_exists( get_template_directory() . '/inc/admin/updater/theme-updater.php' ) ) {
		// Load Getting Started page and initialize EDD update class
		require_once( get_template_directory() . '/inc/admin/updater/theme-updater.php' );
	}

}

/**
 * Registers additional customizer controls
 */
function array_register_customizer_options( $wp_customize ) {

	//Custom textarea class for custom CSS
	class Publisher_Customize_Textarea_Control extends WP_Customize_Control {
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

	//Accent Color
	$wp_customize->add_setting( 'publisher_customizer_accent', array(
		'default'        => '#469AF6'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'publisher_customizer_accent', array(
		'label'          => __( 'Accent Color', 'publisher' ),
		'section'        => 'publisher_customizer_basic',
		'settings'       => 'publisher_customizer_accent',
		'priority'       => 2
	) ) );

	//Custom CSS
	$wp_customize->add_setting( 'publisher_customizer_css', array(
		'default'        => '',
	) );

	$wp_customize->add_control( new Publisher_Customize_Textarea_Control( $wp_customize, 'publisher_customizer_css', array(
		'label'          => __( 'Custom CSS', 'publisher' ),
		'section'        => 'publisher_customizer_basic',
		'settings'       => 'publisher_customizer_css',
		'priority'       => 3
	) ) );
}
add_action( 'customize_register', 'array_register_customizer_options' );

/**
 * Add Customizer CSS To Header
 */
function designer_customizer_css() {
	?>
	<style type="text/css">
		a, .post-navigation a:hover,
		#secondary .widget ul li:before,
		#secondary .widget ul li:hover:before,
		.block-titles .entry-date:hover,
		#respond .required,
		#comments .comment-edit-link:hover,
		#single-tabs .single-tab-nav li.active i,
		#single-tabs .single-tab-nav li a:hover i,
		.author-posts li a:hover,
		#content .block-text blockquote p:before,
		#content .block-text blockquote:before
		  {
			color: <?php echo get_theme_mod( 'publisher_customizer_accent', '#469AF6' );?>;
		}

		pre:before,
		.widget_blog_subscription input[type="submit"],
		#secondary #searchsubmit,
		#secondary .submit,
		.ribbon,
		.edit-link,
		.page-links a,
		#commentform #submit,
		#comment-nav-below a,
		.search #content-wrap .site-navigation a,
		.author-posts li span,
		.contact-form input[type='submit'],
		#content input[type='submit'],
		#wp-calendar tr th  {
			background: <?php echo get_theme_mod( 'publisher_customizer_accent', '#469AF6' );?>;
		}

		<?php echo get_theme_mod( 'publisher_customizer_css' );?>
	</style>
<?php
}
add_action( 'wp_head', 'designer_customizer_css' );
