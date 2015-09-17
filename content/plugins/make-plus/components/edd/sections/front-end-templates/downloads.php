<?php
/**
 * @package Make Plus
 */

global $ttfmake_section_data, $ttfmake_sections;

$defaults = array(
	'title' => ttfmake_get_section_default( 'title', 'edd-downloads' ),
	'background-image' => ttfmake_get_section_default( 'background-image', 'edd-downloads' ),
	'darken' => ttfmake_get_section_default( 'darken', 'edd-downloads' ),
	'background-style' => ttfmake_get_section_default( 'background-style', 'edd-downloads' ),
	'background-color' => ttfmake_get_section_default( 'background-color', 'edd-downloads' ),
	'columns' => ttfmake_get_section_default( 'columns', 'edd-downloads' ),
	'taxonomy' => ttfmake_get_section_default( 'taxonomy', 'edd-downloads' ),
	'sortby' => ttfmake_get_section_default( 'sortby', 'edd-downloads' ),
	'count' => ttfmake_get_section_default( 'count', 'edd-downloads' ),
	'thumb' => ttfmake_get_section_default( 'thumb', 'edd-downloads' ),
	'price' => ttfmake_get_section_default( 'price', 'edd-downloads' ),
	'addcart' => ttfmake_get_section_default( 'addcart', 'edd-downloads' ),
	'details' => ttfmake_get_section_default( 'details', 'edd-downloads' ),
);
$data = wp_parse_args( $ttfmake_section_data, $defaults );

// Sanitize all the data
$title = apply_filters( 'the_title', $data['title'] );
$background_image = ttfmake_sanitize_image_id( $data['background-image'] );
$darken = absint( $data['darken'] );
$background_style = ttfmake_sanitize_section_choice( $data['background-style'], 'background-style', 'edd-downloads' );
$background_color = maybe_hash_hex_color( $data['background-color'] );
$columns = ttfmake_sanitize_section_choice( $data['columns'], 'columns', 'edd-downloads' );
$taxonomy = ttfmake_sanitize_section_choice( $data['taxonomy'], 'taxonomy', 'edd-downloads' );
$sortby = ttfmake_sanitize_section_choice( $data['sortby'], 'sortby', 'edd-downloads' );
$count = (int) $data['count'];
$thumb = ( absint( $data['thumb'] ) ) ? 'true' : 'false';
$price = ( absint( $data['price'] ) ) ? 'yes' : 'no';
$addcart = ( absint( $data['addcart'] ) ) ? 'yes' : 'no';
$details = ttfmake_sanitize_section_choice( $data['details'], 'details', 'edd-downloads' );

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

// Parse taxonomy option
$taxonomy_att = '';
if ( 'all' !== $taxonomy ) {
	$term = explode( '_', $taxonomy, 2 );
	if ( 'cat' === $term[0] ) {
		$taxonomy_att = " category=\"{$term[1]}\"";
	} else if ( 'tag' === $term[0] ) {
		$taxonomy_att = " tags=\"{$term[1]}\"";
	}
}

// Parse sortby option
$sortby_att = ' order="DESC" orderby="post_date"';
if ( 'post_date-desc' !== $sortby ) {
	$sort = explode( '-', $sortby, 2 );
	if ( ! isset( $sort[1] ) ) {
		$sortby_att = " orderby=\"{$sort[0]}\"";
	} else {
		$sort[1] = strtoupper( $sort[1] );
		$sortby_att = " order=\"{$sort[1]}\" orderby=\"{$sort[0]}\"";
	}
}

// Parse details option
$details_att = ' excerpt="no" full_content="no"';
if ( 'none' !== $details ) {
	if ( 'full' === $details ) {
		$details_att = ' excerpt="no" full_content="yes"';
	} else if ( 'excerpt' === $details ) {
		$details_att = ' excerpt="yes" full_content="no"';
	}
}

// Section ID
$section_id = 'builder-section-' . $ttfmake_section_data['id'];
if ( method_exists( 'TTFMAKE_Builder_Save', 'section_html_id' ) ) :
	$section_id = ttfmake_get_builder_save()->section_html_id( $ttfmake_section_data );
endif;
?>

<section id="<?php echo esc_attr( $section_id ); ?>" class="<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $style ); ?>">
	<?php if ( '' !== $data['title'] ) : ?>
	<h3 class="builder-edd-downloads-section-title">
		<?php echo $title; ?>
	</h3>
	<?php endif; ?>
	<div class="builder-section-content">
		[downloads columns="<?php echo $columns; ?>" number="<?php echo $count; ?>" thumbnails="<?php echo $thumb; ?>" price="<?php echo $price; ?>" buy_button="<?php echo $addcart; ?>"<?php echo $taxonomy_att; echo $sortby_att; echo $details_att; ?>]
	</div>
	<?php if ( 0 !== $darken ) : ?>
	<div class="builder-section-overlay"></div>
	<?php endif; ?>
</section>