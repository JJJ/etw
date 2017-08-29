<?php
/**
 * The template for displaying the Portfolio archive page.
 *
 * @package Atomic
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main">

        <!-- Load standard posts -->
        <?php if ( have_posts() ) : ?>

            <div class="content-left">
                <header class="entry-header">
                    <?php
                        echo '<h1 class="entry-title">' . esc_html__( 'Portfolio', 'atomic' ) . '</h1>';
                    ?>
                </header>
            </div><!-- .content-left -->

            <div class="content-right">
                <div id="post-wrapper">
                    <div class="section-portfolio">
                    <?php
                        // Get the post content
                        while ( have_posts() ) : the_post(); ?>

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
                    ?>
                    </div><!-- .index-posts -->

                    <?php atomic_page_navs(); ?>
                </div><!-- #post-wrapper -->
            </div><!-- .content-right -->

            <?php else :

            get_template_part( 'template-parts/content-none' );

        endif; ?>

    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>
