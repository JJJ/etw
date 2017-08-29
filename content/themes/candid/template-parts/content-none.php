<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Candid
 */
?>

<section class="no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html__( 'Nothing Found', 'candid' ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'candid' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>


		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'candid' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'candid' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .entry-content -->
</section><!-- .no-results -->
