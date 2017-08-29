<?php
/**
 * The template used for displaying portfolio items in alternating blocks.
 *
 * @package Meteor
 */
 ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="portfolio-shadow clear">
        <div class="portfolio-block-left">
            <!-- Get the featured image -->
            <div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'meteor-portfolio-blocks' ); ?></a></div>
        </div>

        <div class="portfolio-block-right">
            <div class="portfolio-text">
                <?php meteor_portfolio_cats(); ?>

                <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

                <?php
                    add_filter( 'excerpt_length', 'meteor_portfolio_excerpt_length' );

                    echo '<div class="entry-excerpt">';
                        meteor_remove_sharing();
                        echo the_excerpt();
                    echo '</div>';

                    remove_filter( 'excerpt_length', 'meteor_portfolio_excerpt_length' );
                ?>

                <p class="more-link"><a href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'meteor' ); ?></a></p>
            </div><!-- .portfolio-text -->
        </div><!-- .portfolio-block-right -->
    </div><!-- .portfolio-shadow -->
</article><!-- .post -->
