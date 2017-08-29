<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<!-- Page title -->
				<h1 class="entry-title"><?php the_title(); ?></h1>

				<!-- Subtitle -->
				<?php if ( get_post_meta($post->ID, 'subtitle', true) ) { ?>
					<h3 class="entry-subtitle"><?php echo get_post_meta( $post->ID, 'subtitle', true ) ?></h3>
				<?php } ?>
			</div>
		</header>

		<section class="main">
			<div class="container clearfix">
				<div id="content">
					<div class="posts">
						<!-- Grab the posts -->
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

							<article <?php post_class('post'); ?>>
								<div class="box-wrap">
									<div class="box">
										<!-- Post content -->
										<div class="post-content">
											<?php the_content( __( 'Read More','north' ) ); ?>
										</div><!-- post content -->
									</div><!-- box -->
								</div><!-- box wrap -->
							</article><!-- post-->

						<?php endwhile; ?>
						<?php endif; ?>
					</div><!-- posts -->
				</div><!-- content -->
			</div><!-- container -->
		</section><!-- main -->

		<!-- Footer -->
		<?php get_footer(); ?>