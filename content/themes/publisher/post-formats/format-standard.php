<?php
/**
 * Template for the Standard (default) post format.
 *
 * @package Publisher
 * @since Publisher 1.0
 */
?>

<div <?php post_class( 'block-standard' ); ?>>
	<?php if ( '' != get_the_post_thumbnail() ) { ?>
		<?php if( is_single() ) { ?>
			<div class="block-thumb"><?php the_post_thumbnail( 'post-image' ); ?></div>
		<?php } else { ?>
			<a class="block-thumb" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'publisher' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'block-thumb' ); ?></a>
		<?php } ?>
	<?php } ?>


	<?php get_template_part( 'templates/template-titles' ); ?>
</div>