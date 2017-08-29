<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Camera
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

	<!-- Get the carousel gallery or featured image -->
	<?php if ( has_post_format( 'gallery' ) && get_post_gallery() ) {
		get_template_part( 'content', 'carousel-gallery' );
	} else if ( has_post_thumbnail() ) { ?>
		<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
	<?php } ?>

	<div class="container content-container">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>

			<?php if ( $post->post_excerpt ) { ?>
				<div class="entry-subtitle">
					<?php the_excerpt(); ?>
				</div>
			<?php } ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php if( $post->post_content == "" ) { ?>
				<p><?php printf( __( 'This page is blank. Add content by clicking the Edit Page link below.', 'camera' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
			<?php } else { ?>
				<?php the_content(); ?>
			<?php } ?>

			<?php edit_post_link( __( 'Edit Page', 'camera' ) ); ?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'camera' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	</div>
</article><!-- #post-## -->
