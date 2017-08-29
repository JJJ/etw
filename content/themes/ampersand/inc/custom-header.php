<?php
/**
* Add custom header support, front-end styles and admin preview styles.
*
* @package Ampersand
* @since Ampersand 1.0
*/

add_theme_support( 'custom-header', apply_filters( 'ampersand_custom_header_args', array(
	'default-text-color'     => 'fff',
	'width'					 => 1200,
	'height'				 => 335,
	'wp-head-callback'       => 'ampersand_header_style',
	'admin-head-callback'    => 'ampersand_admin_header_style',
	'admin-preview-callback' => 'ampersand_admin_header_image',
) ) );


//Front end header styles

if ( ! function_exists( 'ampersand_header_style' ) ) :
function ampersand_header_style() {
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
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;


// Admin header preview

if ( ! function_exists( 'ampersand_admin_header_style' ) ) :
function ampersand_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg {
			padding: 75px 0 75px 50px;
			background-color: #2C343C;
			position: relative;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		#headimg h1 {
			margin: 0;
			font-size: 22px;
			font-weight: 400;
			font-family: 'Roboto', 'Helvetica Neue', Helvetica, sans-serif;
			letter-spacing: 1px;
			text-transform: uppercase;
			line-height: 1.4;
		}
		#headimg h1 a {
			color: #fff;
			position: relative;
			text-decoration: none;
		}

		#headimg h1 a:after {
			content: '';
			display: block;
			position: absolute;
			bottom: -3px;
			width: 100%;
			height: 3px;
			background: #33B26E;
			border-radius: 3px;
		}
		#desc {
			font-size: 11px;
			line-height: 16px;
			font-weight: bold;
			letter-spacing: 3px;
			color: #60656D !important;
			text-transform: uppercase;
			margin-top: 15px;
		}
		#headimg img {
			position: absolute;
			left: 0;
			top: -100%;
			opacity: .05;
			filter: gray;
			-webkit-filter: grayscale(100%);
		}
	</style>
<?php
}
endif;

//Admin preview callback

if ( ! function_exists( 'ampersand_admin_header_image' ) ) :
function ampersand_admin_header_image() {
	$style        = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$header_image = get_header_image();
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name" <?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<?php if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif;