<?php
/**
 * Template for the post navigation and archive pagination.
 *
 * @package Author
 * @since Author 1.0
 */
?>

<!-- next and previous posts -->
<?php if( is_single() ) { ?>
	<div class="next-prev">
		<?php previous_post_link( '<div class="prev-post"><strong class="next-prev-title">' . __( 'Previous Post', 'author' ) . '</strong><span>%link</span></div>' ); ?>
		<?php next_post_link( '<div class="next-post"><strong class="next-prev-title">' . __( 'Next Post', 'author' ) . '</strong><span>%link</span></div>' ); ?>
	</div><!-- next prev -->
<?php } ?>

<!-- post navigation -->
<?php if( author_page_has_nav() ) : ?>
	<div class="post-nav">
		<div class="postnav-left"><?php previous_posts_link( __( 'Newer Posts', 'author' ) ) ?></div>
		<div class="postnav-right"><?php next_posts_link( __( 'Older Posts', 'author' ) ) ?></div>
	</div><!-- end post navigation -->
<?php endif; ?>