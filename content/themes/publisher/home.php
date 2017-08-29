<?php
/**
 * Template for the homepage blocks.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

get_header(); ?>

		<div id="main" class="site-main blocks-page clearfix">
			<div id="primary" class="blocks-template">
				<div id="content" class="site-content blocks-content" role="main">
					<div class="blocks-wrap clearfix">

						<!-- Grab Blocks Template -->
						<?php get_template_part( 'templates/template-blocks' ); ?>

					</div><!-- .blocks-wrap -->
				</div><!-- #content .site-content -->
			</div><!-- #primary .content-area -->
		</div><!-- #main .site-main -->

<?php get_footer(); ?>