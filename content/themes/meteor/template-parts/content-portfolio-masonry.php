<?php
/**
 * The template used for displaying portfolio items in a masonry grid.
 *
 * @package Meteor
 */
 ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="portfolio-shadow">
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'meteor-portfolio-masonry' ); ?></a></div>
        <?php } ?>

        <div class="portfolio-text">
            <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

            <?php meteor_portfolio_cats(); ?>
        </div>
    </div>
</article><!-- .post -->
