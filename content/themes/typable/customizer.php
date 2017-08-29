<?php

// ------------- Theme Customizer  ------------- //

add_action( 'customize_register', 'typable_customizer_register' );

function typable_customizer_register( $wp_customize ) {

	//Custom CSS Textarea

	class Typable_Customize_Textarea_Control extends WP_Customize_Control {
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

	//Typable Style Options

	$wp_customize->add_section( 'typable_customizer_options', array(
		'title'        => __( 'Theme Options', 'typable' ),
		'priority'     => 1
	) );

	//Logo Image
	$wp_customize->add_setting( 'typable_customizer_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'typable_customizer_logo', array(
		'label'        => __( 'Logo Upload', 'typable' ),
		'section'      => 'typable_customizer_options',
		'settings'     => 'typable_customizer_logo',
		'priority'     => 1
	) ) );

	//Accent Color
	$wp_customize->add_setting( 'typable_customizer_accent', array(
		'default'      => '#00A9E0'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'typable_customizer_accent', array(
		'label'        => __( 'Accent Color', 'typable' ),
		'section'      => 'typable_customizer_options',
		'settings'     => 'typable_customizer_accent',
		'priority'     => 2
	) ) );

	//Toggle AJAX
	$wp_customize->add_setting('typable_customizer_ajax_toggle', array(
		'default'      => 'enabled',
		'capability'   => 'edit_theme_options',
		'type'         => 'option',
	));

	$wp_customize->add_control( 'typable_theme_ajax_select_box', array(
		'settings'     => 'typable_customizer_ajax_toggle',
		'label'        => __( 'AJAX Load Posts', 'typable' ),
		'section'      => 'typable_customizer_options',
		'type'         => 'select',
		'choices'      => array(
			'enabled'  => __( 'Enabled', 'typable' ),
			'disabled' => __( 'Disabled', 'typable' ),
		),
		'priority'     => 2
	));

	//Enable BW Effect
	$wp_customize->add_setting('typable_customizer_enable_bw', array(
		'default'      => 'enabled',
		'capability'   => 'edit_theme_options',
		'type'         => 'option',
	));

	$wp_customize->add_control( 'enable_bw_select_box', array(
		'settings'     => 'typable_customizer_enable_bw',
		'label'        => __( 'Featured Image BW Effect', 'typable' ),
		'section'      => 'typable_customizer_options',
		'type'         => 'select',
		'choices'      => array(
			'enabled'  => __( 'Enabled', 'typable' ),
			'disabled' => __( 'Disabled', 'typable' ),
		),
		'priority'     => 3
	));

	//Custom CSS
	$wp_customize->add_setting( 'typable_customizer_css', array(
		'default'      => '',
	) );

	$wp_customize->add_control( new Typable_Customize_Textarea_Control( $wp_customize, 'typable_customizer_css', array(
		'label'        => __( 'Custom CSS', 'typable' ),
		'section'      => 'typable_customizer_options',
		'settings'     => 'typable_customizer_css',
		'priority'     => 4
	) ) );


	//Real Time Settings Preview

	$wp_customize->get_setting('blogname')->transport='postMessage';

	if ( $wp_customize->is_preview() && ! is_admin() )
	add_action( 'wp_footer', 'typable_customizer_preview', 21);

	function typable_customizer_preview() {
		?>
		<script type="text/javascript">
		( function( $ ){

		wp.customize('blogname',function( value ) {
			value.bind(function(to) {
				$('.logo-text a').html(to);
			});
		});

		wp.customize('blogdescription',function( value ) {
			value.bind(function(to) {
				$('h2.logo-subtitle').html(to);
			});
		});

		// Header color
		wp.customize('typable_customizer_accent',function( value ) {
			value.bind(function(to) {
				$('.header').css('background', to );
			});
		});

		} )( jQuery )
		</script>
		<?php
	}

}