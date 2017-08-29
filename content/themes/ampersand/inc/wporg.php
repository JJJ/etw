<?php
/**
 * Self-hosted functionality not to be included on WordPress.com
 *
 * @package Ampersand
 */

if( is_admin() ) {

	// Add custom metabox for page subtitles
	require_once( get_template_directory() . '/inc/admin/metabox/metabox.php' );

	// Load Getting Started page and initialize EDD update class
	require_once( get_template_directory() . '/inc/admin/updater/theme-updater.php' );
}


/**
 * Registers additional customizer controls
 */
function array_register_customizer_options( $wp_customize ) {

		//Accent Color
		$wp_customize->add_setting( 'ampersand_customizer_accent', array(
			'default'           => '#33B26E',
			'sanitize_callback' => 'sanitize_hex_color'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ampersand_customizer_accent', array(
			'label'    => __( 'Accent Color', 'ampersand' ),
			'section'  => 'colors',
			'settings' => 'ampersand_customizer_accent',
			'priority' => 3
		) ) );

		//Header and Footer Color
		$wp_customize->add_setting( 'ampersand_customizer_header', array(
			'default'           => '#2C343C',
			'sanitize_callback' => 'sanitize_hex_color'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ampersand_customizer_header', array(
			'label'    => __( 'Header & Footer Background Color', 'ampersand' ),
			'section'  => 'colors',
			'settings' => 'ampersand_customizer_header',
			'priority' => 4
		) ) );

		//Header and Footer Text Color
		$wp_customize->add_setting( 'ampersand_customizer_header_text_color', array(
			'default'           => '#7D838B',
			'sanitize_callback' => 'sanitize_hex_color'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ampersand_customizer_header_text_color', array(
			'label'    => __( 'Header & Footer Text Color', 'ampersand' ),
			'section'  => 'colors',
			'settings' => 'ampersand_customizer_header_text_color',
			'priority' => 4
		) ) );

}
add_action( 'customize_register', 'array_register_customizer_options' );


/* Customizer Accent Color Output */
function ampersand_customizer_css() {
	?>
	<style type="text/css">
		a, #cancel-comment-reply i, #secondary a:hover, .menu-toggle i, #secondary .portfolio-nav a:hover, #respond .required {
			color: <?php echo get_theme_mod( 'ampersand_customizer_accent', '#33B26E' ); ?>;
		}

		.cta-red, .site-title a:after, #searchsubmit, #commentform #submit, .contact-form input[type='submit'], #content input[type='submit'], .flexslider:hover .flex-next:hover, .flexslider:hover .flex-prev:hover {
			background: <?php echo get_theme_mod( 'ampersand_customizer_accent', '#33B26E' ) ;?>;
		}

		.main-navigation ul li.current-menu-item > a, .main-navigation ul > li:hover > a, #content .edit-link a, #secondary .edit-link a, .post-content .more-link, .blog-left-excerpt .more-link, .portfolio-column-text .more-link, .index-navigation a, #content .edit-link a:hover, #secondary .edit-link a:hover, .post-content .more-link:hover, .portfolio-column-text .more-link:hover, .post-meta a:hover {
			border-bottom-color: <?php echo get_theme_mod( 'ampersand_customizer_accent', '#33B26E' ) ;?>;
		}

		.site-header, .site-footer {
			background-color: <?php echo get_theme_mod( 'ampersand_customizer_header', '#2C343C' ) ;?>;
		}

		.main-navigation a, .menu-search-toggle, .hero-title h3, .site-footer {
			color: <?php echo get_theme_mod( 'ampersand_customizer_header_text_color', '#7D838B' ) ;?>;
		}

		<?php echo get_theme_mod( 'ampersand_customizer_css', '' ); ?>
	</style>
<?php
}
add_action( 'wp_head', 'ampersand_customizer_css' );


/**
 * Displays post subtitles
 */
function ampersand_do_subtitle() {

	global $post;

	if( is_singular() && ! is_page_template( 'homepage.php' ) ) {

		$ampersand_subtitle = get_post_meta( $post->ID, '_ampersand_subtitle_value', true );

		if ( ! empty ( $ampersand_subtitle ) ) { ?>
			<p>
				<?php echo $ampersand_subtitle; ?>
			</p>
		<?php }
	}

	if( is_home() ) {

		$blog_page_ID = get_option( 'page_for_posts', true );

		$ampersand_subtitle = get_post_meta( $blog_page_ID, '_ampersand_subtitle_value', true );

		if ( ! empty ( $ampersand_subtitle ) ) { ?>
			<p>
				<?php echo $ampersand_subtitle; ?>
			</p>
		<?php }
	}
}
