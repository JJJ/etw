<?php
/**
 * The template used for displaying search results
 *
 * @package Meteor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) { ?>
		<div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'meteor-portfolio-square' ); ?></a></div>
	<?php } ?>

	<div class="post-content">
		<?php if( ! is_single() ) { ?>
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php meteor_post_byline(); ?>
			</header>
		<?php } ?>

		<div class="entry-content">
			<?php add_filter( 'excerpt_length', 'meteor_search_excerpt_length' ); ?>

			<?php echo wp_strip_all_tags( get_the_excerpt(), true ); ?>

			<?php remove_filter( 'excerpt_length', 'meteor_search_excerpt_length' ); ?>
		</div><!-- .entry-content -->
	</div><!-- .post-content-->

</article><!-- #post-## -->
