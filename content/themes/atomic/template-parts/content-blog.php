<?php
/**
 * The template used for displaying blog posts on the homepage.
 *
 * @package Atomic
 */
 ?>

<div class="section-blog clear">
    <div class="index-posts">
        <?php
            if ( is_front_page() && is_page_template( 'templates/template-homepage.php' ) ) {
                $posts_per_page = get_theme_mod( 'atomic_home_blog_count', '4' );
            } else {
                $posts_per_page = get_option( 'posts_per_page' );
            }

            $blog_list_args = array(
                'posts_per_page' => $posts_per_page
            );
            $blog_list_posts = new WP_Query( $blog_list_args );
        ?>

        <?php
        if ( $blog_list_posts->have_posts() ) :
        while( $blog_list_posts->have_posts() ) : $blog_list_posts->the_post() ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'atomic-portfolio' ); ?></a></div>
                <?php } ?>

                <?php atomic_grid_cats(); ?>

                <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

                <?php
                    // WP.com: Disable sharing and likes for this excerpt area
                    if ( function_exists( 'post_flair_mute' ) )
                        post_flair_mute();

                    add_filter( 'excerpt_length', 'atomic_portfolio_excerpt_length' );

                    echo '<div class="entry-excerpt">';
                        atomic_remove_sharing();
                        echo the_excerpt();
                    echo '</div>';

                    remove_filter( 'excerpt_length', 'atomic_portfolio_excerpt_length' );

                    // WP.com: Turn sharing and likes back on for all other loops.
                    if ( function_exists( 'post_flair_unmute' ) )
                        post_flair_unmute();
                ?>

                <?php atomic_post_byline(); ?>

                <p class="more-link"><a href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'atomic' ); ?></a></p>
            </article><!-- #post-## -->
        <?php
            endwhile;

            else : ?>

            <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>. Read more about out how to set up the Blog section on your <a href="%2$s">Getting Started page</a>.', 'atomic' ), esc_url( admin_url( 'post-new.php' ) ), esc_url( admin_url( 'themes.php?page=atomic-license#blog' ) ) ); ?></p>

            <?php endif;
        ?>
        <?php wp_reset_postdata(); ?>
    </div><!-- .index-posts-->
</div><!-- .section-blog -->
