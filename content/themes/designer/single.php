<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Designer
 */

get_header();

// Check for author description
$curauth = get_userdata( $post->post_author );
?>

	<div id="primary" class="content-area <?php if ( ! $curauth->description ) { echo "no-desc"; } ?>">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

			<!-- If author has a bio, show it. -->
			<?php if ( $curauth->description ) { ?>
				<header class="author-info">
					<div class="author-profile">
						<div class="author-avatar">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr_e( 'Posts by ', 'designer' ); ?> <?php echo esc_attr( get_the_author() ); ?>">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'designer_author_bio_avatar_size', 100 ) ); ?>
								</a>
						</div>

						<div class="author-description">
							<h2><?php printf( __( 'Published by %s', 'designer' ), get_the_author() ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
						</div>
					</div>
				</header><!-- author-info -->
			<?php } ?>

			<?php designer_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
