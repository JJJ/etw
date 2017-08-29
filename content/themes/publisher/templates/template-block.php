<?php

/**
 * Template for individual blocks.
 *
 * Each individual 'block', or post summary, is displayed in a grid on the home and archive pages
 *
 * @package Publisher
 * @since Publisher 1.0
 */

$classes = array(
	'post',
	'block',
	'animated',
	'fadeIn'
);
?>

<div <?php post_class( $classes ); ?> data-postid="<?php the_ID(); ?>">
	<?php if( is_sticky() ) { ?>
		<div class="ribbon-wrap"><div class="ribbon"><i class="fa fa-thumb-tack"></i></div></div>
	<?php } ?>

	<!-- uses the post format -->
	<?php
  		$format = get_post_format();

		if( 'image' == $format || 'quote' == $format ) {
			get_template_part( 'post-formats/format', get_post_format() );
		} else {
			get_template_part( 'post-formats/format', 'standard' );
		};
	?>

	<div class="block-meta">
		<div class="block-comments">
			<a href="<?php the_permalink(); ?>#single-tabs" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s comments', 'publisher' ), the_title_attribute( 'echo=0' ) ) ); ?>"><i class="fa fa-comments"></i> <?php comments_number( __('0', 'publisher'), __('1', 'publisher'), __( '%', 'publisher' ) );?></a>
		</div>

		<div class="block-author-link">
			<i class="icon-pencil"></i> <?php the_author_posts_link(); ?>
		</div>

		<a class="block-permalink" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'publisher' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><i class="fa fa-link"></i></a>
	</div><!-- .block-meta -->
</div><!-- .block -->