<?php
/**
 * The template part for displaying the post and page sidebar
 *
 * @package Atomic
 */
?>
	<div class="content-left">
		<div class="entry-meta">
			<header class="entry-header">
				<?php
				// Post and page title
				if ( is_single() || is_page() ) { ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php } else { ?>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php } ?>

				<?php
				// Get the excerpt for a page subtitle
				if( is_page() ) {
					if ( has_excerpt() ) {

						echo '<div class="entry-subtitle">';
							atomic_remove_sharing();
							the_excerpt();
						echo '</div>';
					}
				} ?>
			</header>

            <?php
        	// Post meta sidebar
        	get_template_part( 'template-parts/content-meta' ); ?>

			<?php
				// Get the child pages
				echo atomic_list_child_pages();
			?>
		</div><!-- .entry-meta -->
	</div><!-- .entry-left -->
