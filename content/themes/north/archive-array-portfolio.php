<?php
/**
 * The template for display portfolio post archives
 *
 * @since 3.0
 */
get_header(); ?>

		<header class="page-titles">
			<div class="container clearfix">
				<!-- Page title -->
				<h2 class="entry-title"><?php _e( 'Category', 'north' ); ?> / <?php post_type_archive_title(); ?></h2>
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