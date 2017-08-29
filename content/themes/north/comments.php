<?php
/**
* The template for displaying Comments.
*
* The area of the page that contains both current comments
* and the comment form. The actual display of comments is
* handled by a callback to north_comment() which is
* located in the functions.php file.
*
* @package WordPress
* @subpackage North
* @since North 1.0
*/


if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'north'); ?></p>
<?php
	return;
}
?>

<div id="comments">
	<div class="comments-wrap clearfix">
		<?php if (get_comments_number()==0) { } else { ?>
			<h3 id="comments-title">
				<span><?php _e('Join the conversation!','north'); ?></span> <?php comments_number(__('Leave A Comment','north'),__('1 Comment','north'),__( '% Comments','north') );?>
			</h3>
		<?php } ?>

		<ol class="commentlist">
			<?php wp_list_comments("callback=north_comment"); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'north' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'north' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php comment_form(); ?>
	</div><!-- .comments-wrap -->
</div><!-- #comments -->