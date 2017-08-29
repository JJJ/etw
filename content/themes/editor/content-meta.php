<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Editor
 */
?>

<div class="entry-meta">
	<?php if ( $post->post_excerpt ) { ?>
		<div class="entry-excerpt">
			<?php the_excerpt(); ?>
		</div>
	<?php } ?>

	<ul class="meta-list">
		<?php if ( has_category() ) { ?>
			<li class="meta-cat"><?php the_category( ', ' ); ?></li>
		<?php } ?>
		<?php $posttags = get_the_tags(); if ( $posttags ) { ?>
			<li class="meta-tag"><?php the_tags( '' ); ?></li>
		<?php } ?>
		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<li class="meta-comment">
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'editor' ), __( '1 Comment', 'editor' ), __( '% Comments', 'editor' ) ); ?></span>
		</li>
		<?php endif; ?>
		<?php edit_post_link( __( 'Edit', 'editor' ), '<li class="meta-edit">', '</li>' ); ?>
	</ul>
</div>