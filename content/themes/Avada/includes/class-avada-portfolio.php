<?php

class Avada_Portfolio {

    /**
     * The class constructor
     */
    public function __construct() {
        add_filter( 'pre_get_posts', array( $this, 'set_post_filters' ) );
    }

    /**
     * Modify the query (using the 'pre_get_posts' filter)
     */
    function set_post_filters( $query ) {
        global $smof_data;

        if ( $query->is_main_query() && ( is_tax( 'portfolio_category' ) || is_tax( 'portfolio_skills' ) || is_tax( 'portfolio_tags' ) ) ) {
            $query->set( 'posts_per_page', $smof_data['portfolio_items'] );
        }

        return $query;

    }

}
