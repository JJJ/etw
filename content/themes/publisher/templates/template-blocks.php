<?php
/**
 * Template for the blocks.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

?>

						<div class="block-container-wrap">
							<div class="block-container-inside clearfix">
								<section id="block-container">
									<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

									<?php get_template_part( 'templates/template-block' ); ?>

									<?php endwhile; ?>
									<?php endif; ?>
								</section><!-- #block-container -->
							</div><!-- .block_container-inside -->
						</div><!-- .block_container-wrap -->