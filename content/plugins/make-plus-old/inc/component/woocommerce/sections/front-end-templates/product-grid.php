<?php
/**
 * @package Make Plus
 */

global $ttfmake_section_data, $ttfmake_sections;

$defaults = array(
	'title' => ttfmake_get_section_default( 'title', 'woocommerce-product-grid' ),
	'background-image' => ttfmake_get_section_default( 'background-image', 'woocommerce-product-grid' ),
	'darken' => ttfmake_get_section_default( 'darken', 'woocommerce-product-grid' ),
	'background-style' => ttfmake_get_section_default( 'background-style', 'woocommerce-product-grid' ),
	'background-color' => ttfmake_get_section_default( 'background-color', 'woocommerce-product-grid' ),
	'columns' => ttfmake_get_section_default( 'columns', 'woocommerce-product-grid' ),
	'type' => ttfmake_get_section_default( 'type', 'woocommerce-product-grid' ),
	'taxonomy' => ttfmake_get_section_default( 'taxonomy', 'woocommerce-product-grid' ),
	'sortby' => ttfmake_get_section_default( 'sortby', 'woocommerce-product-grid' ),
	'count' => ttfmake_get_section_default( 'count', 'woocommerce-product-grid' ),
	'thumb' => ttfmake_get_section_default( 'thumb', 'woocommerce-product-grid' ),
	'rating' => ttfmake_get_section_default( 'rating', 'woocommerce-product-grid' ),
	'price' => ttfmake_get_section_default( 'price', 'woocommerce-product-grid' ),
	'addcart' => ttfmake_get_section_default( 'addcart', 'woocommerce-product-grid' ),
);
$data = wp_parse_args( $ttfmake_section_data, $defaults );

// Sanitize all the data
$title = apply_filters( 'the_title', $data['title'] );
$background_image = ttfmake_sanitize_image_id( $data['background-image'] );
$darken = absint( $data['darken'] );
$background_style = ttfmake_sanitize_section_choice( $data['background-style'], 'background-style', 'woocommerce-product-grid' );
$background_color = maybe_hash_hex_color( $data['background-color'] );
$columns = ttfmake_sanitize_section_choice( $data['columns'], 'columns', 'woocommerce-product-grid' );
$type = ttfmake_sanitize_section_choice( $data['type'], 'type', 'woocommerce-product-grid' );
$taxonomy = ttfmake_sanitize_section_choice( $data['taxonomy'], 'taxonomy', 'woocommerce-product-grid' );
$sortby = ttfmake_sanitize_section_choice( $data['sortby'], 'sortby', 'woocommerce-product-grid' );
$count = absint( $data['count'] );
$thumb = absint( $data['thumb'] );
$rating = absint( $data['rating'] );
$price = absint( $data['price'] );
$addcart = absint( $data['addcart'] );

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
	<?php if ( '' !== $data['title'] ) : ?>
	<h3 class="builder-woocommerce-product-grid-section-title">
		<?php echo $title; ?>
	</h3>
	<?php endif; ?>
	<div class="builder-section-content">
		[ttfmp_woocomerce_product_grid columns="<?php echo $columns; ?>" type="<?php echo $type; ?>" taxonomy="<?php echo $taxonomy; ?>" sortby="<?php echo $sortby; ?>" count="<?php echo $count; ?>" thumb="<?php echo $thumb; ?>" rating="<?php echo $rating; ?>" price="<?php echo $price; ?>" addcart="<?php echo $addcart; ?>"]
	</div>
	<?php if ( 0 !== $darken ) : ?>
	<div class="builder-section-overlay"></div>
	<?php endif; ?>
</section>