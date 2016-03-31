<?php
/**
 * @package Make Plus
 */

global $ttfmake_section_data, $ttfmake_sections;

// The data in $ttfmake_section_data is already sanitized
$d = $ttfmake_section_data;

// Filter the title for front-end output
$title = apply_filters( 'the_title', $d['title'] );

// Background options
$background_image = ttfmake_sanitize_image_id( $d['background-image'] );
$darken = absint( $d['darken'] );
$background_style = ttfmake_sanitize_section_choice( $d['background-style'], 'background-style', 'post-list' );
$background_color = maybe_hash_hex_color( $d['background-color'] );

// Build shortcode parameters
$parameters = '';
$keys = array(
	'columns', 'type',
	'sortby', 'keyword', 'count', 'offset',
	'taxonomy', 'show-title', 'show-date',
	'show-excerpt', 'excerpt-length', 'show-author',
	'show-categories', 'show-tags', 'show-comments', 'thumbnail', 'aspect',
);
foreach ( $keys as $key ) {
	if ( isset( $d[$key] ) ) {
		$param = str_replace( '-', '_', $key );
		$value = esc_attr( $d[$key] );
		$parameters .= " $param=\"$value\"";
	}
}

// Section ID
$section_id = 'builder-section-' . $ttfmake_section_data['id'];
if ( method_exists( 'TTFMAKE_Builder_Save', 'section_html_id' ) ) :
	$section_id = ttfmake_get_builder_save()->section_html_id( $ttfmake_section_data );
endif;

// Classes
$classes = 'builder-section ';
$classes .= ttfmake_get_builder_save()->section_classes( $ttfmake_section_data, $ttfmake_sections );
if ( ! empty( $background_color ) || 0 !== $background_image ) {
	$classes .= ' has-background';
}

// Style
$style = '';
if ( ! empty( $background_color ) ) {
	$style .= 'background-color:' . $background_color . ';';
}
if ( 0 !== $background_image ) {
	$image_src = ttfmake_get_image_src( $background_image, 'full' );
	if ( isset( $image_src[0] ) ) {
		$style .= 'background-image: url(\'' . addcslashes( esc_url_raw( $image_src[0] ), '"' ) . '\');';
	}
}
if ( 'cover' === $background_style  ) {
	$style .= 'background-size: cover;';
}
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $style ); ?>">
	<?php if ( '' !== $title ) : ?>
	<h3 class="builder-post-list-section-title">
		<?php echo $title; ?>
	</h3>
	<?php endif; ?>
	<div class="builder-section-content container">
		[ttfmp_post_list<?php echo $parameters; ?>]
	</div>
	<?php if ( 0 !== $darken ) : ?>
	<div class="builder-section-overlay"></div>
	<?php endif; ?>
</section>