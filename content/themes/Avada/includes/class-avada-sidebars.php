<?php

class Avada_Sidebars {

    public function __construct() {
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );
    }

    /**
     * Register our sidebars
     */
    public function widgets_init() {

    	register_sidebar( array(
    		'name'          => __( 'Blog Sidebar', 'Avada' ),
    		'id'            => 'avada-blog-sidebar',
    		'description'   => __( 'Default Sidebar of Avada', 'Avada' ),
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<div class="heading"><h3>',
    		'after_title'   => '</h3></div>',
    	) );

        // Register he footer widgets
        for ( $i = 1; $i < 7; $i++ ) {

            register_sidebar( array(
                'name'          => sprintf( __( 'Footer Widget %s', 'Avada' ), $i ),
    			'id'            => 'avada-footer-widget-' . $i,
    			'before_widget' => '<div id="%1$s" class="fusion-footer-widget-column widget %2$s">',
    			'after_widget'  => '<div style="clear:both;"></div></div>',
    			'before_title'  => '<h3>',
    			'after_title'   => '</h3>',
    		) );

        }

        // Register the slidingbar widgets
        for ( $i = 1; $i < 7; $i++ ) {

    		register_sidebar( array(
                'name'          => sprintf( __( 'Slidingbar Widget %s', 'Avada' ), $i ),
    			'id'            => 'avada-slidingbar-widget-' . $i,
    			'before_widget' => '<div id="%1$s" class="fusion-slidingbar-widget-column widget %2$s">',
    			'after_widget'  => '<div style="clear:both;"></div></div>',
    			'before_title'  => '<h3>',
    			'after_title'   => '</h3>',
    		) );

    	}

    }

}
