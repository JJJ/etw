<?php
/**
 * Template for the Image post format. Displays only the featured image in blocks.
 *
 * @package Publisher
 * @since Publisher 1.0
 */
?>

<div <?php post_class( 'block-standard' ); ?>>
	<?php if ( '' != get_the_post_thumbnail() ) { ?>
		<?php if( is_single() ) { ?>
			<div class="block-thumb"><?php the_post_thumbnail( 'image-format' ); ?></div>
		<?php } else { ?>
			<a class="block-thumb" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'publisher' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'block-thumb' ); ?></a>
		<?php } ?>
	<?php } ?>

	<!-- Show title and content only on single page, unless no image is specified. -->
	<?php if ( '' != get_the_post_thumbnail() && ! is_single() ) { } else { ?>
		<?php get_template_part( 'templates/template-titles' ); ?>
	<?php } ?>
</div>