<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Baseline
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<div class="comments-inside">
		<div class="container">
			<?php // You can start editing here -- including this comment! ?>

			<?php if ( have_comments() ) : ?>
				<h3 class="comments-title">
					<span><?php
						printf(
							esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'baseline' ) ),
							number_format_i18n( get_comments_number() ),
							'<span>' . get_the_title() . '</span>'
						);
					?></span>
				</h3>

				<ol class="comment-list">
					<?php
						wp_list_comments( array(
							'style'       => 'ol',
							'short_ping'  => true,
							'avatar_size' => 50,
							'callback'    => 'baseline_comment'
						) );
					?>
				</ol><!-- .comment-list -->

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
				<nav id="comment-nav-above" class="comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'baseline' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'baseline' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'baseline' ) ); ?></div>
				</nav><!-- #comment-nav-above -->
				<?php endif; // check for comment navigation ?>

			<?php endif; // have_comments() ?>

			<?php
				// If comments are closed and there are comments, let's leave a little note, shall we?
				if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'baseline' ); ?></p>
			<?php endif; ?>

			<?php comment_form(); ?>
		</div><!-- .container -->
	</div>
</div><!-- #comments -->
