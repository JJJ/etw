<?php
/**
 * The template part for displaying the post meta information
 *
 * @package Meteor
 */
 // Get the Jetpack portfolio tags
 $portfolio_tags = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag', '', _x(', ', '', 'meteor' ), '' );

 // Get the Jetpack portfolio categories
 $portfolio_cats = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', _x(', ', '', 'meteor' ), '' );
?>
	<?php
	// Get the post meta
	if( ! is_page() ) { ?>
		<ul class="meta-list">
			<?php
			// Post categories
			if ( has_category() ) { ?>
				<li>
					<span class="meta-title"><?php echo esc_html_e( 'Category:', 'meteor' ); ?></span>

					<?php the_category( ', ' ); ?>
				</li>
			<?php } ?>

			<?php
			// Post tags
			$tags = get_the_tags();
			if ( ! empty( $tags ) ) { ?>
				<li>
					<span class="meta-title"><?php echo esc_html_e( 'Tag:', 'meteor' ); ?></span>
					<?php the_tags( '' ); ?>
				</li>
			<?php } ?>

			<?php
			// Portfolio categories
			if ( get_post_type() == 'jetpack-portfolio' && $portfolio_cats ) { ?>
				<li>
					<span class="meta-title"><?php echo esc_html_e( 'Category:', 'meteor' ); ?></span>
					<?php if ( 'jetpack-portfolio' == get_post_type() ) {
						echo $portfolio_cats;

					} else {
						the_category( ', ' );

					} ?>
				</li>
			<?php } ?>

			<?php
			// Portfolio tags
			if ( get_post_type() == 'jetpack-portfolio' && $portfolio_tags ) { ?>
				<li>
					<span class="meta-title"><?php echo esc_html_e( 'Tag:', 'meteor' ); ?></span>
					<?php if ( 'jetpack-portfolio' == get_post_type() ) {
						echo $portfolio_tags;
					} ?>
				</li>
			<?php } ?>
		</ul><!-- .meta-list -->
	<?php } ?>
