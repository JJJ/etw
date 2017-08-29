<?php
/**
 * @package Candid
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

	<header class="entry-header">
		<?php if ( is_single() ) { ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php } else { ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php } ?>

		<div class="byline">
			<span><?php the_author_posts_link(); ?></span>
			<span><?php echo get_the_date(); ?></span>
			<span>
				<a href="<?php the_permalink(); ?>#comments" title="<?php esc_attr_e( 'Comments on', 'candid' ); ?> <?php the_title(); ?>">
					<?php
						printf(
						esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'candid' ) ),
						number_format_i18n( get_comments_number() ), get_the_title() );
					?>
				</a>
			</span>
		</div>
	</header><!-- .entry-header -->

	<!-- Grab the video -->
	<?php if ( get_post_meta( $post->ID, 'array-video', true ) ) { ?>
		<div class="featured-video">
			<?php echo get_post_meta( $post->ID, 'array-video', true ) ?>
		</div>
	<?php } else if ( has_post_thumbnail() ) { ?>
		<!-- Grab the featured image -->
		<div class="featured-image fadeInUpImage"><?php the_post_thumbnail( 'candid-full-width' ); ?></div>
	<?php } ?>

	<!-- Grab the excerpt to use as a byline -->
	<?php if ( has_excerpt() ) { ?>
		<div class="entry-excerpt">
			<?php the_excerpt(); ?>
		</div>
	<?php } ?>

	<div class="entry-content">
		<?php the_content( esc_html__( 'Read More', 'candid' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'candid' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'template-parts/content-meta' ); ?>

</article><!-- #post-## -->
