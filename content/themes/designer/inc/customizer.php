<?php
/**
 * Designer Theme Customizer
 *
 * Customizer color options can be found in inc/wporg.php.
 *
 * @package Designer
 */

add_action( 'customize_register', 'designer_customizer_register' );

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Category dropdown class
 */
class WP_Customize_Category_Control extends WP_Customize_Control {
    private $cats = false;

    public function __construct( $manager, $id, $args = array(), $options = array() ) {
        $this->cats = get_categories( $options );

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content() {

        if( !empty( $this->cats ) ) {
        ?>

            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <select <?php $this->link(); ?>>
                    <?php
                        // Add an empty default option
                        printf( '<option value=""> </option>' );

                        foreach ( $this->cats as $cat ) {
                            printf( '<option value="%s" %s>%s</option>', $cat->term_id, selected( $this->value(), $cat->term_id, false ), $cat->name );
                        }
                    ?>
            </select>
            </label>

        <?php }
    }
}

/**
 * Sanitize portfolio select option
 */
function designer_sanitize_portfolio_select( $layout ) {

    if ( ! in_array( $layout, array( 'tile', 'landscape', 'portrait', 'square' ) ) ) {
        $layout = 'tile';
    }
    return $layout;
}

/**
 * Sanitize toggle bar color
 */
function designer_sanitize_toggle_select( $input ) {
    $valid = array(
        'light'  => __( 'Light', 'designer' ),
        'dark'   => __( 'Dark', 'designer' )
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Sanitize blog style option
 */
function designer_sanitize_blog_select( $input ) {
    $valid = array(
        'default' => __( 'Default', 'designer' ),
        'minimal' => __( 'Minimal', 'designer' )
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Sanitize homepage post count option
 */
function designer_sanitize_homepage_count_select( $input ) {
    $valid = array(
        '1'  => __( '1', 'designer' ),
        '2'  => __( '2', 'designer' ),
        '3'  => __( '3', 'designer' ),
        '4'  => __( '4', 'designer' ),
        '5'  => __( '5', 'designer' ),
        '6'  => __( '6', 'designer' ),
        '7'  => __( '7', 'designer' ),
        '8'  => __( '8', 'designer' ),
        '9'  => __( '9', 'designer' ),
        '10' => __( '10', 'designer' )
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Sanitize text
 */
function designer_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize checkbox
 */
function designer_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

/**
 * @param WP_Customize_Manager $wp_customize
 */
function designer_customizer_register( $wp_customize ) {

    /**
     * Adds textarea support to the theme customizer
     */
    class Designer_Customize_Textarea_Control extends WP_Customize_Control {
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

    // Theme Options

	$wp_customize->add_section( 'designer_customizer_basic', array(
		'title'    => __( 'Theme Options', 'designer' ),
		'priority' => 1
	) );

    // Logo and header text options - only show if Site Logos is not supported
    if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
        $wp_customize->add_setting( 'designer_customizer_logo', array(
            'transport' => 'postMessage'
        ) );

    	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'designer_customizer_logo', array(
            'label'    => __( 'Logo Upload', 'designer' ),
            'section'  => 'title_tagline',
            'settings' => 'designer_customizer_logo'
    	) ) );
    }

    // Always show sidebar
    $wp_customize->add_setting( 'designer_show_sidebar', array(
        'default'           => '',
        'sanitize_callback' => 'designer_sanitize_checkbox',
        'transport'         => 'postMessage'
    ) );

    $wp_customize->add_control( 'designer_show_sidebar', array(
        'type'     => 'checkbox',
        'label'    => __( 'Always Show Sidebar', 'designer' ),
        'section'  => 'designer_customizer_basic',
        'priority' => 2
    ) );

    // Portfolio Style
    $wp_customize->add_setting( 'designer_customizer_portfolio', array(
        'default'           => 'tile',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
        'sanitize_callback' => 'designer_sanitize_portfolio_select'
    ));

    $wp_customize->add_control( 'designer_customizer_portfolio_select', array(
        'settings' => 'designer_customizer_portfolio',
        'label'    => __( 'Project Image Style', 'designer' ),
        'section'  => 'designer_customizer_basic',
        'type'     => 'select',
        'choices'  => array(
            'tile'      => __( 'Tiled', 'designer' ),
            'landscape' => __( 'Landscape', 'designer' ),
            'portrait'  => __( 'Portrait', 'designer' ),
            'square'    => __( 'Square', 'designer' )
        ),
        'priority'      => 3
    ) );


    // Homepage Portfolio Count
    $wp_customize->add_setting( 'designer_customizer_portfolio_number', array(
        'default'           => '10',
        'type'              => 'option',
        'sanitize_callback' => 'designer_sanitize_text'
    ) );

    $wp_customize->add_control( 'designer_customizer_portfolio_number', array(
        'label'    => __( 'Number of Projects on Homepage', 'designer' ),
        'section'  => 'designer_customizer_basic',
        'settings' => 'designer_customizer_portfolio_number',
        'type'     => 'text',
        'priority' => 4
    ) );


    // Portfolio Page Text
    $wp_customize->add_setting( 'designer_customizer_portfolio_text', array(
        'transport'         => 'postMessage',
        'sanitize_callback' => 'designer_sanitize_text'
    ) );

    $wp_customize->add_control(
        new Designer_Customize_Textarea_Control( $wp_customize, 'designer_customizer_portfolio_text',
            array(
                'label'     => __( 'Project Archive Text', 'designer' ),
                'section'   => 'designer_customizer_basic',
                'settings'  => 'designer_customizer_portfolio_text',
                'priority'  => 8
            )
        )
    );

    // Blog Style
    $wp_customize->add_setting( 'designer_customizer_blog_style', array(
        'default'           => 'default',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
        'sanitize_callback' => 'designer_sanitize_blog_select'
    ) );

    $wp_customize->add_control( 'designer_customizer_blog_select', array(
        'settings' => 'designer_customizer_blog_style',
        'label'    => __( 'Blog Index Style', 'designer' ),
        'section'  => 'designer_customizer_basic',
        'type'     => 'select',
        'choices'  => array(
            'default' => __( 'Default', 'designer' ),
            'minimal' => __( 'Minimal', 'designer' )
        ),
        'priority'     => 9
    ) );

}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function designer_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'designer_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function designer_customize_preview_js() {
	wp_enqueue_script( 'designer_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '201406213', true );
}
add_action( 'customize_preview_init', 'designer_customize_preview_js' );
