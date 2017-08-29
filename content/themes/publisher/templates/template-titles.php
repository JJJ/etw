<?php
/**
 * Template for block and single post titles.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

?>

<div class="block-titles-wrap">
	<div class="block-titles">
		<?php if( is_single() ) { ?>
			<div class="block-date">
				<?php echo get_the_date(); ?><span class="date-sep"> &mdash; </span><?php the_author_posts_link(); ?>
			</div>
		<?php } ?>

		<?php if( is_single() ) { ?>
			<h1 class="block-entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php } else { ?>
			<h2 class="block-entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php } ?>
	</div><!-- .block-titles -->

	<div class="block-text">
		<?php if( is_single() ) { ?>
			<?php the_content( __( 'Read More', 'publisher' ) ); ?>
			<?php wp_link_pages(); ?>
			<?php edit_post_link( __( 'Edit', 'publisher' ), '<span class="edit-link"><i class="icon-edit-sign"></i>', '</span>' ); ?>
		<?php } else { ?>
			<!-- Bring in galleries or objects before more tag -->
			<?php
				// Check the content for the more text
				$ismore = strpos( $post->post_content, '<!--more-->' );

				if( $ismore ) {
					if ( function_exists( 'post_flair_mute' ) )
						post_flair_mute();

					the_content(__( 'Continue reading <span class="meta-nav">&rarr;</span>','publisher' ));

					if ( function_exists( 'post_flair_unmute' ) )
						post_flair_unmute();
				}
				else {
					the_excerpt();
				}
			?>
		<?php } ?>
	</div><!-- .block-text -->
</div><!-- .block-titles-wrap -->