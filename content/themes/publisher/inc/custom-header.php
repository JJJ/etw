<?php
/**
* Add custom header support, front-end styles and admin preview styles.
*
* @package Publisher
* @since Publisher 1.0
*/

add_theme_support( 'custom-header', apply_filters( 'publisher_custom_header_args', array(
	'default-image' 		 => get_template_directory_uri() . '/images/trees.jpg',
	'default-text-color'     => 'fff',
	'width'					 => 1440,
	'flex-width'			 => true,
	'height'				 => 405,
	'flex-height'			 => true,
	'wp-head-callback'       => 'publisher_header_style',
	'admin-head-callback'    => 'publisher_admin_header_style',
	'admin-preview-callback' => 'publisher_admin_header_image',
) ) );


//Front end header styles

if ( ! function_exists( 'publisher_header_style' ) ) :
function publisher_header_style() {
	$header_text_color = get_header_textcolor();

	if ( HEADER_TEXTCOLOR == $header_text_color )
		return;
	?>

	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a {
			color: #<?php echo $header_text_color; ?>;
			border-color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;


// Admin header preview

if ( ! function_exists( 'publisher_admin_header_style' ) ) :
function publisher_admin_header_style() {
	$header_text_color = get_header_textcolor();
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg {
			text-align:center;
			padding: 50px 0 50px 0;
			background-color: #272a33;
			position: relative;
		}
		#headimg h1,
		#desc {
			position: relative;
			z-index: 10;
			font-family: 'Helvetica Neue', 'Helvetica', sans-serif;
		}
		#headimg h1 {
		    padding: 0 10px;
		    display: inline-block;
		    margin: 0 auto;
		    text-transform: uppercase;
		    font-size: 24px;
		    line-height: 43px;
		    font-weight: bold;
		}
		#headimg h1 a {
			color: #fff;
			text-decoration: none;
			border-color: #<?php echo $header_text_color; ?>;
		}
		#desc {
			font-size: 11px;
			line-height: 16px;
			font-weight: bold;
			letter-spacing: 3px;
			color: #777 !important;
    		color: rgba(255, 255, 255, 0.3) !important;
			text-transform: uppercase;
			margin-top: 15px;
		}
		#headimg img {
			position: absolute;
			left: 0;
			top: 0;
		}
	</style>
<?php
}
endif;

//Admin preview callback

if ( ! function_exists( 'publisher_admin_header_image' ) ) :
function publisher_admin_header_image() {
	$style        = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$header_image = get_header_image();
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif;