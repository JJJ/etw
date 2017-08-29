<?php
/**
 * Template for displaying pages.
 *
 * @package Typable
 * @since 1.0
 */
get_header(); ?>

		<div id="content">
			<div class="posts">
				<article <?php post_class( 'post' ); ?>>
					<div class="box-wrap">
						<div class="box">
							<header>
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							</header>

							<!-- post content -->
							<div class="post-content">
								<?php the_content( __( 'Read More', 'typable' ) ); ?>
							</div><!-- post content -->
						</div><!-- box -->
					</div><!-- box wrap -->
				</article><!-- post -->
			</div><!-- posts -->
		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>