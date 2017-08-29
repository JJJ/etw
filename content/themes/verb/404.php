<?php
/**
 *
 * Template for showing the 404 - Page Not Found message.
 *
 * @package Verb
 * @since Verb 1.0
 */

get_header(); ?>
		
		<div id="content">
			<div class="posts">
				
				<!-- grab the posts -->
				<article class="post">
					<div class="box-wrap">
						<div class="box">
							<header>
								<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e('Page Not Found','verb'); ?></a></h1>
							</header>
							
							<!-- post content -->
							<div class="post-content">
								<div class="intro"><?php _e('Sorry, but the page you are looking for has moved or no longer exists. Please use the search below, or the menu above to locate the missing page.','verb'); ?></div>
								
								<?php get_search_form();?>
								
								<div id="archive">
									<div class="archive-col">
										<div class="archive-box">
											<h3><?php _e('Latest Posts','verb'); ?></h3>
											<ul>
												<?php wp_get_archives('type=postbypost&limit=10'); ?>
											</ul>
										</div>
										
										<div class="archive-box">
											<h3><?php _e('Pages','verb'); ?></h3>
											<ul>
												<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
											</ul>
										</div>
										
										<div class="archive-box">
											<h3><?php _e('Categories','verb'); ?></h3>
											<ul>
												<?php wp_list_categories('orderby=name&title_li='); ?> 
											</ul>
										</div>
										
										<div class="archive-box">
											<h3><?php _e('Archive By Day','verb'); ?></h3>
											<ul>
												<?php wp_get_archives('type=daily&limit=15'); ?>
											</ul>
										</div>
										
										<div class="archive-box">
											<h3><?php _e('Archive By Month','verb'); ?></h3>
											<ul>
												<?php wp_get_archives('type=monthly&limit=12'); ?>
											</ul>
										</div>
										
										<div class="archive-box">
											<h3><?php _e('Archive By Year','verb'); ?></h3>
											<ul>
												<?php wp_get_archives('type=yearly&limit=12'); ?>
											</ul>
										</div>
										
										<div class="archive-box">
											<h3><?php _e('Contributors','verb'); ?></h3>
											<ul>
												<?php wp_list_authors('show_fullname=1&optioncount=0&orderby=post_count&order=DESC'); ?>
											</ul>
										</div>
									</div><!-- column -->
								</div><!-- archive -->
							</div><!-- post content -->
						</div><!-- box -->
					</div><!-- box wrap -->
				</article><!-- post-->	
			</div>
		</div><!-- content -->
		
		<!-- sidebar -->
		<?php get_sidebar(); ?>
	
		<!-- footer -->
		<?php get_footer(); ?>