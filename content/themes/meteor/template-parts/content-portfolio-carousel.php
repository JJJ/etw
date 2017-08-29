<?php
/**
 * The template used for displaying portfolio items in a carousel.
 *
 * @package Meteor
 */
 ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'meteor-portfolio-carousel' ); ?></a></div>
    <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
</article><!-- .post -->
