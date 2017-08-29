<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Camera
 */
?>

		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="recent-posts" class="widget">
				<h2 class="widget-title"><?php _e( 'Latest Posts', 'camera' ); ?></h2>
				<?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 3, 'title' => ' ' ), array( 'before_widget' => '', 'after_widget' => '', 'before_title' => '', 'after_title' => '' ) ); ?>
			</aside>

			<aside id="archives" class="widget">
				<h2 class="widget-title"><?php _e( 'Archives', 'camera' ); ?></h2>
				<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
					<?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option' ) ); ?>
				</select>
			</aside>

			<aside id="meta" class="widget">
				<h2 class="widget-title"><?php _e( 'Meta', 'camera' ); ?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>
		<?php endif; // end sidebar widget area ?>
