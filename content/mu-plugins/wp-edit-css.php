<?php

add_filter( 'map_meta_cap', function( $caps, $cap, $user_id, $args ) {
        if (  'edit_css' === $cap ) {
                $caps = array( 'edit_theme_options' );
        }

        return $caps;
}, 10, 4 );

