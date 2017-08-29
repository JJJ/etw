<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Designer
 */


// Get the post tags
$post_tags = get_the_tags();

// Get the Jetpack portfolio tags
$portfolio_tags = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag', '', _x(', ', '', 'designer' ), '' );

// Get the portfolio categories
$portfolio_cats = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', _x(', ', '', 'designer' ), '' );

?>

	<div class="entry-meta">
		<ul class="meta-list">
			<!-- Published date -->
			<li>
				<strong><?php _e( 'Published', 'designer' ); ?></strong>
				<?php echo get_the_date(); ?>
			</li>

			<!-- Author posts link -->
			<li>
				<strong><?php _e( 'Author', 'designer' ); ?></strong>
				<?php the_author_posts_link(); ?>
			</li>

			<!-- Categories for posts and portfolio items -->
			<?php if ( has_category() || $portfolio_cats ) { ?>

				<li class="meta-cat">
					<strong><?php _e( 'Category', 'designer' ); ?></strong>
					<?php if ( 'jetpack-portfolio' == get_post_type() ) {
						echo $portfolio_cats;

					} else {
						the_category( ', ' );

					} ?>
				</li>

			<?php } ?>

			<!-- Tags for posts and portfolio items -->
			<?php if ( is_single() && $post_tags || 'jetpack-portfolio' == get_post_type() && $portfolio_tags ) { ?>

				<li class="meta-tag">
					<strong><?php _e( 'Tags', 'designer' ); ?></strong>
					<?php if ( 'jetpack-portfolio' == get_post_type() ) {
						echo $portfolio_tags;

					} else {
						the_tags( '' );

					} ?>
				</li>

			<?php } ?>

			<!-- Comments -->
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>

				<li class="meta-comment">
					<strong><?php _e( 'Comments', 'designer' ); ?></strong>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave Comment', 'designer' ), __( '1 Comment', 'designer' ), __( '% Comments', 'designer' ) ); ?></span>
				</li>

			<?php endif; ?>

		</ul><!-- .meta-list -->
	</div><!-- .entry-meta -->