<?php

class Avada_Blog {

    public function construct() {

        add_filter( 'excerpt_length', array( $this, 'excerpt_length' ), 999 );
        add_action( 'pre_get_posts', array( $this, 'alert_search_loop' ) );

        if ( ! is_admin() ) {
            add_filter( 'pre_get_posts', array( $this, 'search_filter' ) );
            add_filter( 'pre_get_posts', array( $this, 'empty_search_filter' ) );
        }

    }

    /**
     * Modify the default excerpt length
     */
    public function excerpt_length( $length ) {

        global $smof_data;

        // Normal blog posts excerpt length
        if ( isset( $smof_data['excerpt_length_blog'] ) ) {
            $length = $smof_data['excerpt_length_blog'];
    	}

        // Search results excerpt length
        if ( is_search() ) {
            $length = $smof_data['excerpt_length_blog'];
        }

        return $length;

    }

    /**
     * Apply post per page on search pages
     */
    function alert_search_loop( $query ) {
        global $smof_data;

        if ( $query->is_main_query() && $query->is_search() && $smof_data['search_results_per_page'] ) {
            $query->set( 'posts_per_page', $smof_data['search_results_per_page'] );
        }

    }

    /**
     * Apply filters to the search query.
     * Determines if we only want to display posts/pages and changes the query accordingly
     */
    function search_filter( $query ) {

        global $smof_data;

        if ( is_search() && $query->is_search ) {

            // Show only posts in search results
            if ( $smof_data['search_content'] == 'Only Posts' ) {
                $query->set('post_type', 'post');
            }
            // Show only pages in search results
            elseif ( $smof_data['search_content'] == 'Only Pages' ) {
                $query->set( 'post_type', 'page' );
            }

        }

    	return $query;

    }

    /**
     * make wordpress respect the search template on an empty search
     */
    function empty_search_filter( $query ) {

        if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) && $query->is_main_query() ) {
            $query->is_search = true;
    		$query->is_home   = false;
    	}

    	return $query;

    }

}
