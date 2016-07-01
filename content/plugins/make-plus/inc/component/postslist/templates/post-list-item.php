<?php
/**
 * @package Make Plus
 */

global $post, $ttfmp_data;

// Are we rendering a widget?
$is_widget = ( isset( $ttfmp_data['is-widget'] ) && true === $ttfmp_data['is-widget'] );

// Thumbnail
$thumbnail = trim( $ttfmp_data['thumbnail'] );

/**
 * Filter: Modify the image size used for featured images in a Posts List instance.
 *
 * @since 1.3.0.
 *
 * @param string    $thumbnail_size    The image size to use. E.g. thumbnail, medium, large, full.
 * @param array     $ttfmp_data        The array of data specific to the Posts List instance.
 */
$thumbnail_size = apply_filters( 'ttfmp_posts_list_thumbnail_size', 'large', $ttfmp_data );

$aspect = trim( $ttfmp_data['aspect'] );
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size );
$image_style = ( isset( $featured_image[0] ) ) ? ' style="background-image: url(' . addcslashes( esc_url_raw( $featured_image[0] ), '"' ) . ');"' : '';

// Excerpt length
$excerpt_length = absint( $ttfmp_data['excerpt-length'] );

// True/false options
$display_keys = array(
	'show-title', 'show-date',
	'show-excerpt', 'show-author',
	'show-categories', 'show-tags',
	'show-comments',
);
$d = array();
foreach ( $display_keys as $key ) {
	$d[$key] = ( isset( $ttfmp_data[$key] ) ) ? absint( $ttfmp_data[$key] ) : 0;
}

// Title element
$t_wrap = 'h3';
if ( $is_widget || in_array( $thumbnail, array( 'left', 'right' ) ) ) {
	$t_wrap = 'strong';
}
/**
 * Filter: Modify the element used to wrap post titles in a Posts List instance.
 *
 * @since 1.6.6.
 *
 * @param string    $t_wrap        The element name. E.g. h3, strong, div
 * @param array     $ttfmp_data    The array of data specific to the Posts List instance.
 */
$t_wrap = apply_filters( 'ttfmp_post_list_post_title_element', $t_wrap, $ttfmp_data );
?>

<?php if ( 'none' !== $thumbnail || $d['show-title'] || $d['show-date'] || $d['show-author'] ) : ?>
<header class="ttfmp-post-list-item-header">
	<?php if ( 'none' !== $thumbnail ) : ?>
	<figure class="ttfmp-post-list-item-thumb position-<?php echo esc_attr( $thumbnail ); ?>">
		<?php if ( 'none' === $aspect ) : ?>
			<?php if ( get_post_thumbnail_id() ) : ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( $thumbnail_size ); ?>
			</a>
			<?php endif; ?>
		<?php else : ?>
		<div class="ttfmp-post-list-item-image aspect-<?php echo esc_attr( $aspect ); ?>"<?php echo $image_style; ?>>
			<a href="<?php the_permalink(); ?>">
				<?php if ( get_post_thumbnail_id() ) : ?>
					<span class="screen-reader-text">
						<?php echo strip_tags( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>
					</span>
				<?php endif; ?>
			</a>
		</div>
		<?php endif; ?>
	</figure>
	<?php endif; ?>
	<?php if ( $d['show-title'] ) : ?>
	<<?php echo sanitize_key( $t_wrap ); ?> class="ttfmp-post-list-item-title">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</<?php echo sanitize_key( $t_wrap ); ?>>
	<?php endif; ?>
	<?php if ( $d['show-date'] ) : ?>
	<span class="ttfmp-post-list-item-date">
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php echo get_the_date(); ?>
		</a>
	</span>
	<?php endif; ?>
</header>
<?php endif; ?>
<?php if ( $d['show-excerpt'] ) : ?>
<div class="ttfmp-post-list-item-content">
	<?php echo MakePlus()->get_component( 'postslist' )->get_excerpt( $excerpt_length ); ?>
</div>
<?php endif; ?>
<?php if ( $d['show-author'] ) : ?>
<span class="ttfmp-post-list-item-author">
	<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
</span>
<?php endif; ?>
<?php if ( $d['show-categories'] || $d['show-tags'] || $d['show-comments'] ) : ?>
<footer class="ttfmp-post-list-item-footer">
	<?php
	$categorized_blog = true;
	if ( function_exists( 'ttfmake_categorized_blog' ) ) :
		$categorized_blog = ttfmake_categorized_blog();
	endif;
	if ( ( $d['show-categories'] && has_category() && $categorized_blog ) || ( $d['show-tags'] && has_tag() ) ) : ?>
		<?php
		$category_list   = get_the_category_list();
		$tag_list        = get_the_tag_list( '<ul class="post-tags"><li>', "</li>\n<li>", '</li></ul>' ); // Replicates category output
		$taxonomy_output = '';

		// Categories
		if ( $d['show-categories'] && $category_list ) :
			// Translators: this HTML markup will display an icon representing blog categories.
			$taxonomy_output .= __( '<i class="fa fa-file"></i> ', 'make-plus' ) . '%1$s';
		endif;

		// Tags
		if ( $d['show-tags'] && $tag_list ) :
			// Translators: this HTML markup will display an icon representing blog tags.
			$taxonomy_output .= __( '<i class="fa fa-tag"></i> ', 'make-plus' ) . '%2$s';
		endif;

		// Output
		printf(
			$taxonomy_output,
			$category_list,
			$tag_list
		);
		?>
	<?php endif; ?>
	<?php if ( $d['show-comments'] && ( comments_open() || get_comments_number() > 0 ) ) : ?>
	<a class="ttfmp-post-list-item-comment-link" href="<?php the_permalink(); ?>">
		<?php
		printf(
			esc_html( _n( '%d comment', '%d comments', get_comments_number(), 'make-plus' ) ),
			number_format_i18n( get_comments_number() )
		);
		?>
	</a>
	<?php endif; ?>
</footer>
<?php endif; ?>
