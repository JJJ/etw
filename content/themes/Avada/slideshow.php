<?php
/**
 * Fusion Framework
 *
 * WARNING: This file is part of the Fusion Core Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @package  Fusion/Template
 * @author   ThemeFusion
 * @link     http://theme-fusion.com
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    die;
}

// Don't duplicate me!
if( ! class_exists( 'FusionTemplateSlideshow' ) ) {

    /**
     * @since 4.0.0
     */
    class FusionTemplateSlideshow {

    	function __construct() {

            add_action( 'fusion_post_slideshow', array( $this, 'slideshow' ) );
            add_action( 'fusion_before_slideshow', array( $this, 'before_slideshow' ) );
            add_action( 'fusion_end_slideshow', array( $this, 'end_slideshow' ) );
            add_action( 'fusion_attr_slideshow', array( $this, 'slideshow_attr' ) );

    	} // end __construct();

        function slideshow( $args ) {

            $defaults = array(
                'images' => array(),
                'video' => '',
                'size' => 'full',
            );

            $args = wp_parse_args( $args, $defaults );

            if( count( $args['images'] ) >= 1 || $args['video'] ) {

                do_action( 'fusion_before_slideshow' );

                if( $args['video'] ) {

                    echo $this->add_slide( array(
                        'type'          => 'video',
                        'video_code'    => $args['video'],
                    ) );

                }

                foreach( $args['images'] as $image_id ) {

                    echo $this->add_slide( array(
                        'type'      => 'image',
                        'id'        => (int) $image_id,
                        'link'      => true,
                        'lightbox'  => true,
                        'size' => $args['size'],
                    ) );

                }

				do_action( 'fusion_end_slideshow' );

            }

        } // end slideshow()

        function before_slideshow() {

            echo '<div ' . fusion_attr( 'slideshow', get_the_ID() ) . '>' . "\n";
            echo '<ul class="slides">';

        } // before_slideshow()

        function end_slideshow() {

            echo '</ul>';
            echo '</div>' . "\n";

        } // end_slideshow()

       function slideshow_attr( $post_id ) {

            $attr['class'] = 'post-slideshow fusion-flexslider flexslider fusion-flexslider-loading';

            return $attr;

        } // end slideshow_attr()

        function add_slide( $args ) {

            $defaults = array(
                'type' => 'image',
                'id' => '',
                'link' => true,
                'lightbox' => true,
                'size' => 'full',
                'video_code' => '',
            );

            $args = wp_parse_args( $args, $defaults );

            $html = '<li>';

            if( $args['type'] == 'image' ) {

                $image_url = wp_get_attachment_image_src( $args['id'], $args['size'] );
                $lightbox_image_url = wp_get_attachment_image_src( $args['id'], 'full' );
                $title = get_post_field( 'post_excerpt', $args['id'] );
                $alt = get_post_meta( $args['id'], '_wp_attachment_image_alt', true );

                $image = sprintf( '<img src="%s" alt="%s" />', $image_url[0], $alt );
                $html .= $link = sprintf( '<a href="%s" class="%s" data-title="%s" data-caption="%s">%s</a>', $lightbox_image_url[0], 'lightbox', $title, $alt, $image );

            } elseif( $args['type'] == 'video' ) {

                $html .= '<div class="full-video">'.$args['video_code'].'</div>';

            }

            $html .= '</li>';

            return $html;

        } // end add_slide()

    } // end FusionTemplateSlideshow() class

}