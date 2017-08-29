<?php
/**
 * The template used for displaying portfolio items.
 *
 * @package Atomic
 */
 ?>
<div class="section-portfolio">
    <?php
        atomic_remove_sharing();
        the_content();
    ?>

    <?php
        if ( get_query_var( 'paged' ) ) :
            $paged = get_query_var( 'paged' );
        elseif ( get_query_var( 'page' ) ) :
            $paged = get_query_var( 'page' );
        else :
            $paged = 1;
        endif;

        if ( is_front_page() && is_page_template( 'templates/template-homepage.php' ) ) {
            $posts_per_page = get_theme_mod( 'atomic_home_portfolio_count', '4' );
        } else {
            $posts_per_page = get_option( 'jetpack_portfolio_posts_per_page', '10' );
        }

        $args = array(
            'post_type'      => 'jetpack-portfolio',
            'paged'          => $paged,
            'posts_per_page' => $posts_per_page,
        );

        $project_query = new WP_Query ( $args );

        if ( post_type_exists( 'jetpack-portfolio' ) && $project_query -> have_posts() ) :

            while ( $project_query -> have_posts() ) : $project_query -> the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'atomic-portfolio' ); ?></a></div>
                <?php } ?>

                <?php atomic_portfolio_cats(); ?>

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

                <p class="more-link"><a href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'atomic' ); ?></a></p>
            </article><!-- #post-## -->

            <?php endwhile;

            else : if ( current_user_can( 'publish_posts' ) ) : ?>

                <p><?php printf( __( 'Ready to publish your first portfolio item? <a href="%1$s">Get started here</a>. Read more about out how to set up the Portfolio section on your <a href="%2$s">Getting Started page</a>.', 'atomic' ), esc_url( admin_url( 'post-new.php?post_type=jetpack-portfolio' ) ), esc_url( admin_url( 'themes.php?page=atomic-license#portfolio' ) ) ); ?></p>

            <?php else : ?>

                <p><?php _e( 'No portfolio items have been added yet.', 'atomic' ); ?></p>

            <?php endif;

        endif;
    ?>
</div><!-- .section-portfolio -->

<?php
    if ( ! is_page_template( 'templates/template-homepage.php' ) ) {
        atomic_page_navs( $project_query );
    }

    wp_reset_postdata();
?>
