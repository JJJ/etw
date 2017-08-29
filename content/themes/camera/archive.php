<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Camera
 */

get_header();

// Check for author description
$author = get_userdata( $post->post_author );
?>

	<section id="primary" class="content-area">

		<?php if ( have_posts() ) : ?>

			<?php
				// Check for taxonomy description
				$term_description = term_description();
				if ( ! empty( $term_description ) ) {
					$tax_desc = 'has-description';
				} else {
					$tax_desc = 'no-description';
				}
			?>

			<?php
				// Check for author bios for author archive page
				if ( is_author() && $author->description ) {
					$author_bio = 'has-bio';
				} else {
					$author_bio = 'no-bio';
				}
			?>

			<header class="page-header container <?php echo esc_attr( $tax_desc ); ?> <?php echo esc_attr( $author_bio ); ?>">
				<h1 class="page-title">
					<?php if ( is_author() ) { ?>
						<span><?php _e( 'All Posts by', 'camera' ); ?></span>
					<?php } ?>

					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'camera' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'camera' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'camera' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'camera' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'camera' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'camera' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries', 'camera');

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'camera');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'camera' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'camera' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'camera' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses', 'camera' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios', 'camera' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats', 'camera' );

						else :
							_e( 'Archives', 'camera' );

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

				<?php
					// Show an optional author bio.
					if ( is_author() && $author->description ) { ?>

					<div class="taxonomy-description">
						<?php the_author_meta( 'description' ); ?>
					</div>
				<?php } ?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */

					/* Show the minimal blog loop if selected in the customizer. */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php camera_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</section><!-- #primary -->

<?php get_footer(); ?>
