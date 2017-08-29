<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Camera
 */

get_header(); ?>

	<section id="primary" class="content-area">

		<?php if ( have_posts() ) : ?>

			<header class="page-header container">
				<h1 class="page-title"><?php printf( __( 'Results for: %s', 'camera' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content' ); ?>

			<?php endwhile; ?>

			<?php camera_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
