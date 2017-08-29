<?php
/**
* The template for displaying Comments.
*
* The area of the page that contains both current comments
* and the comment form. The actual display of comments is
* handled by a callback to transmit_comments() which is
* located in the functions.php file.
*
* @package WordPress
* @subpackage Transmit
* @since Transmit 1.0
*/


if ( !empty($_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
	die ('Please do not load this page directly. Thanks, dude!' );

if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'transmit'); ?></p>
<?php
	return;
}
?>

<div id="comments" class="comments">
	<?php if ( have_comments() ) : ?>
		<h3 id="comments-title">
			<?php
				printf( _nx( __( '1 Comment', 'transmit' ), __( '%1$s Comments', 'transmit' ), get_comments_number(), 'comments title', 'transmit' ),
				number_format_i18n( get_comments_number() ) );
			?>
		</h3>
	<?php endif; ?>
	
	<div class="comments-wrap">
		<ol class="commentlist">
			<!-- Calling custom comments layout from bottom of functions.php -->
			<?php wp_list_comments( "callback=transmit_comments" ); ?>
		</ol>
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'author' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'author' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>
	
		<?php comment_form(); ?>
	</div><!-- .comments-wrap -->
</div><!-- #comments -->