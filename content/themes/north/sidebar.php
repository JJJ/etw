<?php
/**
 * Template for the sidebar and its widgets.
 *
 * @package North
 * @since 1.0
 */
 ?>
			<div id="sidebar">
				<?php dynamic_sidebar( 'sidebar' ); ?>

				<?php if ( ! is_active_sidebar( 'sidebar' ) ) : ?>
					<div id="archives" class="widget">
						<h2 class="widget-title"><?php _e( 'Archives', 'pubilsher' ); ?></h1>
						<ul>
							<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
						</ul>
					</div>

					<div id="meta" class="widget">
						<h2 class="widget-title"><?php _e( 'Meta', 'pubilsher' ); ?></h1>
						<ul>
							<?php wp_register(); ?>
							<li><?php wp_loginout(); ?></li>
							<?php wp_meta(); ?>
						</ul>
					</div>
				<?php endif; // end sidebar widget area ?>
			</div>