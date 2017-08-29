<?php
/**
 *
 * Adds the Customizer and options to Appearance -> Customize.
 *
 * @package Verb
 * @since Verb 1.0
 */

add_action( 'customize_register', 'verb_customizer_register' );

function verb_customizer_register( $wp_customize ) {

	class Verb_Customize_Textarea_Control extends WP_Customize_Control {
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
	    add_action( 'wp_footer', 'verb_customize_preview', 21);
	}

	function verb_customize_preview() {
	    ?>
	    <script type="text/javascript">
	        ( function( $ ) {
	            // Homepage title preview
	            wp.customize('verb_customizer_blocks_title',function( value ) {
	                value.bind(function(to) {
	                    $('.hero h2').html(to);
	                });
	            });

	            // Homepage subtitle preview
	            wp.customize('verb_customizer_blocks_subtitle',function( value ) {
	                value.bind(function(to) {
	                    $('.hero h3').html(to);
	                });
	            });

	            // Accent color
	            wp.customize('verb_customizer_accent',function( value ) {
	                value.bind(function(to) {
	                    $('.hero h3').css('background-color', to );
	                });
	            });
	        } )( jQuery )
	    </script>
	    <?php
	}

	//Verb Style Options
	$wp_customize->add_section( 'verb_customizer_basic', array(
		'title'    => __( 'Theme Options', 'verb' ),
		'priority' => 1
	) );

	//Logo Image
	$wp_customize->add_setting( 'verb_customizer_logo', array() );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'verb_customizer_logo', array(
		'label'    => __( 'Logo Upload', 'verb' ),
		'section'  => 'verb_customizer_basic',
		'settings' => 'verb_customizer_logo'
	) ) );

	//Accent Color
	$wp_customize->add_setting( 'verb_customizer_accent', array(
		'default' => '#F74F4F',
		'transport' => 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'verb_customizer_accent', array(
		'label'    => __( 'Accent Color', 'verb' ),
		'section'  => 'verb_customizer_basic',
		'settings' => 'verb_customizer_accent'
	) ) );

	//Block Titles
	$wp_customize->add_setting( 'verb_customizer_blocks_title', array(
		'default' => '',
		'transport' => 'postMessage'
	) );

	$wp_customize->add_control( 'verb_customizer_blocks_title', array(
		'label'   => __( 'Blocks Title', 'verb' ),
		'section' => 'verb_customizer_basic',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'verb_customizer_blocks_subtitle', array(
		'default' => '',
		'transport' => 'postMessage'
	) );

	$wp_customize->add_control( 'verb_customizer_blocks_subtitle', array(
		'label'   => __( 'Blocks Subtitle', 'verb' ),
		'section' => 'verb_customizer_basic',
		'type'    => 'text',
	) );

	//Custom CSS
	$wp_customize->add_setting( 'verb_customizer_css', array(
		'default' => '',
	) );

	$wp_customize->add_control( new Verb_Customize_Textarea_Control( $wp_customize, 'verb_customizer_css', array(
		'label'    => __( 'Custom CSS', 'verb' ),
		'section'  => 'verb_customizer_basic',
		'settings' => 'verb_customizer_css',
	) ) );

}