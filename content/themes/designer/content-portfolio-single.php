<?php
/**
 * The template for displaying content on single projects.
 *
 * @package Designer
 */

/**
 * Make content width larger on project pages.
 */
if ( isset( $GLOBALS['content_width'] ) ) :
	$GLOBALS['content_width'] = 936;
endif;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post portfolio-post' ); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Read More &rarr;', 'designer' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'designer' ),
				'after'  => '</div>',
			) );
		?>
		<?php edit_post_link( __( 'Edit', 'designer' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'content', 'meta' ); ?>

</article><!-- #post-## -->