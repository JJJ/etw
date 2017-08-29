<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Camera
 */

get_header();

// Check for author description
$author = get_userdata( $post->post_author );
?>

	<div id="primary" class="content-area <?php if ( ! $author->description ) { echo "no-desc"; } ?>">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

			<div class="comments-wrap">
				<div class="comments-inside container">
					<div class="comments-left">
						<!-- Author bio -->
						<div class="author-info">
							<div class="author-profile">
								<div class="author-avatar">
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr_e( 'Posts by ', 'camera' ); ?> <?php echo esc_attr( get_the_author() ); ?>">
											<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'author-bio-avatar', 100 ) ); ?>
										</a>
								</div>

								<h2 class="author-title"><span><?php _e( 'About the author', 'camera' ); ?></span> <?php echo esc_html( get_the_author() ); ?></h2>

								<?php if ( empty( $author->description ) && current_user_can( 'manage_options' ) ) { ?>
									<div class="author-description">
										<p><?php printf( __( 'Add a brief bio about yourself to be shown here! <br/><a href="%1$s">Edit your profile &rarr;</a>', 'camera' ), esc_url( admin_url( 'profile.php/#description' ) ) ); ?></p>
									</div>
								<?php } else if ( $author->description ) { ?>
									<div class="author-description">
										<p><?php the_author_meta( 'description' ); ?></p>
									</div>
								<?php } ?>

								<ul class="author-posts">
									<?php camera_author_posts(); ?>
								</ul>

								<a class="all-posts" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php _e( 'All posts by', 'camera' ); ?> <?php the_author_meta( 'display_name' ); ?> &rarr;</a>
							</div><!-- .author-profile .container -->
						</div><!-- .author-info -->
					</div><!-- .comments-left -->

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					?>
				</div><!-- .comments-inside -->
			</div><!-- .comments-wrap -->

		<?php endwhile; // end of the loop. ?>

	</div><!-- #primary -->

<?php get_footer(); ?>
