<?php
/**
 * Template for the Quote post format.
 *
 * @package Publisher
 * @since Publisher 1.0
 */
?>

<div <?php post_class( 'block-quote' ); ?>>
	<?php if( is_home() ) { ?>
		<?php if ( '' != get_the_post_thumbnail() ) { ?>
			<!-- Opaque Page Background -->
			<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>
			<div class="featured-image-bg" style="background-image: url('<?php echo esc_url( $feat_image ); ?>')"></div>
		<?php } ?>
	<?php } ?>

	<?php
		// WP.com: Disable sharing and likes for the slider loop.
		if ( function_exists( 'post_flair_mute' ) )
			post_flair_mute();
	?>

	<?php the_content(); ?>

	<?php
		// WP.com: Turn sharing and likes back on for all other loops.
		if ( function_exists( 'post_flair_unmute' ) )
			post_flair_unmute();
	?>

</div>