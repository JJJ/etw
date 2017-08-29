<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Candid
 */

// Get the post tags
$post_tags = get_the_tags();

	if ( is_single() && ( has_category() || $post_tags ) ) { ?>
		<div class="entry-meta">
			<ul class="meta-list">

				<!-- Categories -->
				<?php if ( has_category() ) { ?>

					<li class="meta-cat">
						<?php the_category( ', ' ); ?>
					</li>

				<?php } ?>

				<!-- Tags -->
				<?php if ( $post_tags  ) { ?>

					<li class="meta-tag">
						<?php the_tags( '' ); ?>
					</li>

				<?php } ?>

			</ul><!-- .meta-list -->
		</div><!-- .entry-meta -->
	<?php } ?>
