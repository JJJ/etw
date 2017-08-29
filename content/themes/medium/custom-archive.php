<?php
/*
Template Name: Custom Archive
*/
?>

<?php get_header(); ?>

		<div id="content">
			<div class="posts">

				<!-- grab the posts -->
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<article <?php post_class('post'); ?>>

					<!-- grab the featured image -->
					<?php if ( has_post_thumbnail() ) { ?>
						<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
					<?php } ?>

					<div class="box-wrap">
						<div class="box">
							<div class="title-meta">
								<div class="title-meta-left">
									<?php if ( get_post_meta( $post->ID, 'pagetitle', true ) ) { ?>
										<?php echo get_post_meta( $post->ID, 'pagetitle', true ) ?>
									<?php } else { ?>
										<?php _e( 'Last modified', 'medium' ); ?> <?php the_modified_date(); ?> <?php _e( 'by', 'medium' ); ?> <?php the_author_posts_link(); ?>
									<?php } ?>
								</div>
							</div>

							<header>
								<?php if( is_single() || is_page() ) { ?>
									<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
								<?php } else { ?>
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
								<?php } ?>
							</header>

							<!-- post content -->
							<div class="post-content">
								<?php the_content( __( 'Read More', 'medium' ) ); ?>

								<div id="archive">
									<div class="archive-col">
										<div class="archive-box">
											<h4><?php _e( 'Archive By Day', 'medium' ); ?></h4>
											<ul>
												<?php wp_get_archives( 'type=daily&limit=15' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h4><?php _e( 'Archive By Month', 'medium' ); ?></h4>
											<ul>
												<?php wp_get_archives( 'type=monthly&limit=12' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h4><?php _e( 'Archive By Year', 'medium' ); ?></h4>
											<ul>
												<?php wp_get_archives( 'type=yearly&limit=12' ); ?>
											</ul>
										</div>
									</div><!-- column -->

									<div class="archive-col">
										<div class="archive-box">
											<h4><?php _e( 'Latest Posts', 'medium' ); ?></h4>
											<ul>
												<?php wp_get_archives( 'type=postbypost&limit=20' ); ?>
											</ul>
										</div>
									</div><!-- column -->

									<div class="archive-col">
										<div class="archive-box">
											<h4><?php _e( 'Pages', 'medium' ); ?></h4>
											<ul>
												<?php wp_list_pages( 'sort_column=menu_order&title_li=' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h4><?php _e( 'Categories', 'medium' ); ?></h4>
											<ul>
												<?php wp_list_categories( 'orderby=name&title_li=' ); ?>
											</ul>
										</div>

										<div class="archive-box">
											<h4><?php _e( 'Contributors', 'medium' ); ?></h4>
											<ul>
												<?php wp_list_authors( 'show_fullname=1&optioncount=1&orderby=post_count&order=DESC' ); ?>
											</ul>
										</div>
									</div><!-- column -->
								</div><!-- archive -->
							</div><!-- post content -->
						</div><!-- box -->
					</div><!-- box wrap -->
				</article><!-- post-->

				<?php endwhile; ?>
				<?php endif; ?>
			</div>

		</div><!-- content -->

		<!-- footer -->
		<?php get_footer(); ?>