<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Camera
 */

?>
	<?php if ( is_single() ) { ?>
		<ul class="entry-meta">
			<!-- Categories -->
			<?php if ( has_category() ) { ?>

				<li class="meta-cat">
					<span><?php _e( 'Category', 'camera' ); ?></span><br/>
					<?php the_category( ', ' ); ?>
				</li>

			<?php } ?>

			<!-- Tags -->
			<?php
			// Get the post tags
			$post_tags = get_the_tags();

			if ( $post_tags ) { ?>

				<li class="meta-tag">
					<span><?php _e( 'Tag', 'camera' ); ?></span><br/>
					<?php the_tags( '' ); ?>
				</li>

			<?php } ?>

			<!-- Post navigation -->
			<?php camera_post_nav(); ?>
		</ul>
	<?php } ?>