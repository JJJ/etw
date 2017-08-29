<?php
/**
 * Template Name: Full Width
 *
 * Full width page template.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

get_header(); ?>

		<div id="main" class="site-main clearfix">
			<div id="primary" class="content-area">
				<div id="content" class="site-content container clearfix" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
							<header class="entry-header">
								<div class="hgroup">
									<h1 class="entry-title"><?php the_title(); ?></h1>
								</div>
							</header><!-- .entry-header -->

							<div class="block-text">
								<div class="content-section">
									<div id="content-wrap">
										<?php the_content(); ?>
										<?php wp_link_pages('before=<span class="page-links">&after=</span>'); ?>
										<?php edit_post_link( __( 'Edit', 'publisher' ), '<span class="edit-link"><i class="fa fa-edit"></i>', '</span>' ); ?>
									</div><!-- #content-wrap -->
								</div><!-- content section -->
							</div>
					<?php endwhile; // end of the loop. ?>

					<!-- Comments and sharing tabs -->
					<div class="single-tab">
						<div id="single-tabs">
							<!-- If comments are open or we have at least one comment, load up the comment template. -->
							<?php if ( comments_open() || '0' != get_comments_number() ) { ?>
								<div id="tab-1" class="comments-section post-tab clearfix">
									<?php comments_template(); ?>
								</div><!-- comment section -->
							<?php } ?>
						</div><!-- #single-tabs -->
					</div><!-- .single-tab -->

				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div><!-- #main .site-main -->

<?php get_footer(); ?>