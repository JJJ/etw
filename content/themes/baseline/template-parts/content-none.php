<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Baseline
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<div class="container">
		<header class="entry-header entry-large">
			<?php if ( is_single() ) { ?>
				<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'baseline' ); ?></h1>
			<?php } else { ?>
				<h2 class="entry-title"><?php esc_html_e( 'Nothing Found', 'baseline' ); ?></h2>
			<?php } ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

				<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'baseline' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

			<?php else : ?>

				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'baseline' ); ?></p>

				<?php get_search_form(); ?>

			<?php endif; ?>
		</div><!-- .entry-content -->
	</div><!-- .container -->

</article><!-- #post-## -->
