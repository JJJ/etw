<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Designer
 */

get_header();

// Check for author description
$curauth = get_userdata( $post->post_author );
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main blocks-page" role="main">
			<div id="post-wrapper">
				<?php if ( have_posts() ) : ?>

					<?php
						// Check for taxonomy description
						$term_description = term_description();
						if ( ! empty( $term_description ) || is_post_type_archive( 'jetpack-portfolio' ) && get_theme_mod( 'designer_customizer_portfolio_text' ) ) {
							$tax_desc = 'has-description';
						} else {
							$tax_desc = 'no-description';
						}
					?>

					<?php
						// Check for author bios for author archive page
						if ( is_author() && $curauth->description ) {
							$author_bio = 'has-bio';
						} else {
							$author_bio = 'no-bio';
						}
					?>

					<header class="page-header <?php echo esc_attr( $tax_desc ); ?> <?php echo esc_attr( $author_bio ); ?>">
						<h1 class="page-title">
							<?php
								if ( is_category() ) :
									single_cat_title();

								elseif ( is_tag() ) :
									single_tag_title();

								elseif ( is_author() ) :
									printf( '<span class="vcard">' . get_the_author() . '</span>' );

								elseif ( is_day() ) :
									printf( __( 'Day: %s', 'designer' ), '<span>' . get_the_date() . '</span>' );

								elseif ( is_month() ) :
									printf( __( 'Month: %s', 'designer' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'designer' ) ) . '</span>' );

								elseif ( is_year() ) :
									printf( __( 'Year: %s', 'designer' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'designer' ) ) . '</span>' );

								elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
									_e( 'Asides', 'designer' );

								elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
									_e( 'Galleries', 'designer');

								elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
									_e( 'Images', 'designer');

								elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
									_e( 'Videos', 'designer' );

								elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
									_e( 'Quotes', 'designer' );

								elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
									_e( 'Links', 'designer' );

								elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
									_e( 'Statuses', 'designer' );

								elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
									_e( 'Audios', 'designer' );

								elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
									_e( 'Chats', 'designer' );

								elseif ( is_post_type_archive( 'jetpack-portfolio' ) ) :
									_e( 'Projects', 'designer' );

								elseif ( is_tax( array( 'jetpack-portfolio-type', 'jetpack-portfolio-tag' ) ) ) :
									single_term_title();

								else :
									_e( 'Archives', 'designer' );

								endif;
							?>
						</h1>
						<?php
							// Show an optional term description.
							$term_description = term_description();
							if ( ! empty( $term_description ) ) :
								printf( '<div class="taxonomy-description">%s</div>', $term_description );
							endif;
						?>

						<?php if ( is_post_type_archive( 'jetpack-portfolio' ) && get_theme_mod( 'designer_customizer_portfolio_text' ) ) { ?>
							<!-- Portfolio page text from customizer -->
							<div class="taxonomy-description">
								<?php echo get_theme_mod( 'designer_customizer_portfolio_text' ); ?>
							</div>
						<?php } ?>

						<?php if ( is_author() && $curauth->description ) { ?>
							<!-- Author bio block -->
							<header class="author-info">
								<div class="author-profile">
									<div class="author-avatar">
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr_e( 'Posts by ', 'designer' ); ?> <?php the_author(); ?>">
											<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'designer_author_bio_avatar_size', 100 ) ); ?>
										</a>
									</div>

									<div class="author-description">
										<h2><?php printf( __( 'Posts by %s', 'designer' ), get_the_author() ); ?></h2>
										<?php the_author_meta( 'description' ); ?>
									</div>
								</div>
							</header><!-- author-info -->
						<?php } ?>
					</header><!-- .page-header -->

					<?php
					// Prepare portfolio items for masonry
					if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( array( 'jetpack-portfolio-type', 'jetpack-portfolio-tag' ) ) ) : ?>

						<div id="post-wrapper" class="portfolio-wrapper <?php echo esc_attr( get_option( 'designer_customizer_portfolio', 'tile' ) ); ?>">

							<?php while ( have_posts() ) : the_post();

								get_template_part( 'content', 'portfolio-thumbs' );

							endwhile; ?>

						</div><!-- .portfolio-wrapper -->

					<?php else :

						while ( have_posts() ) : the_post();

							get_template_part( 'content', get_post_format() );

						endwhile;

					endif;

					designer_paging_nav( $post->max_num_pages );

				else :

					get_template_part( 'content', 'none' );

				endif; ?>
			</div><!-- #post-wrapper -->
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
