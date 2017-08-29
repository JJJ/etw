<?php
/**
 * Template Name: Portfolio
 *
 * @package North
 * @since 1.0
 */
?>

<?php get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<!-- Page title -->
				<h2 class="entry-title"><?php the_title(); ?></h2>

				<!-- Subtitle -->
				<?php if ( get_post_meta( $post->ID, 'subtitle', true ) ) { ?>
					<h3 class="entry-subtitle"><?php echo get_post_meta( $post->ID, 'subtitle', true ) ?></h3>
				<?php } ?>
			</div>
		</header>

		<section class="main">
			<div id="content">
				<div class="container">
					<div class="posts">
						<div class="post-box-wrap clearfix">
							<!-- Grab meta template -->
							<?php get_template_part( 'template-portfolio' ); ?>
						</div><!-- post box wrap -->
					</div><!-- posts -->
				</div><!-- container -->
			</div><!-- content -->
		</section><!-- main -->

		<!-- footer -->
		<?php get_footer(); ?>