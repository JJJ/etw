<?php
/**
 * The template for displaying Comments.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments">
	<div class="comments-wrap">
		<?php if ( have_comments() ) : ?>
			<h3 id="comments-title">
				<?php _e( 'Join the conversation!', 'ampersand' ); ?>
				<span>
					<?php
						printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'ampersand' ),
						number_format_i18n( get_comments_number() ) );
					?>
				</span>
			</h3>
		<?php endif; ?>

		<ol class="commentlist">
			<?php wp_list_comments( "callback=ampersand_comment" ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below" role="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'ampersand' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'ampersand' ) ); ?></div>
			</nav>
		<?php endif; // check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="no-comments"><?php _e( 'Comments are closed.' , 'ampersand' ); ?></p>
		<?php endif; ?>

		<?php comment_form(); ?>
	</div><!-- .comments-wrap -->
</div><!-- #comments -->