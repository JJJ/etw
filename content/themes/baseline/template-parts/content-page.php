<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Baseline
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
		<!-- Grab the featured image without link -->
		<div class="featured-image"><?php the_post_thumbnail( 'baseline-full-width' ); ?></div>
	<?php } ?>

	<div class="container">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'baseline' ),
				'after'  => '</div>',
			) );

			if ( $post->post_content=="" ) {
				edit_post_link( esc_html__( 'This page is empty. Click here to edit this page.', 'baseline' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' );
			}
			?>
		</div><!-- .entry-content -->
	</div><!-- .container-->
</article><!-- #post-## -->
