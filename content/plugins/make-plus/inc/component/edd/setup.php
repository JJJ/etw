<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_EDD_Setup
 *
 * Integrate the Easy Digital Downloads plugin into Make's theme settings and Builder.
 *
 * @since 1.1.0.
 * @since 1.7.0. Changed class name from TTFMP_EDD.
 */
final class MAKEPLUS_Component_EDD_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'theme' => 'MAKE_APIInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Enqueue front end
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend' ), 20 );

		// Add template path
		add_filter( 'edd_template_paths', array( $this, 'filter_template_paths' ) );

		// Filter the download item class
		add_filter( 'edd_download_class', array( $this, 'edd_download_class' ), 10, 4 );

		// Define Shop view
		add_filter( 'makeplus_view_is_shop', array( $this, 'is_shop' ) );

		// Define Product view
		add_filter( 'makeplus_view_is_product', array( $this, 'is_product' ) );
		add_filter( 'makeplus_admin_view_is_product', array( $this, 'admin_is_product' ) );

		// E-Commerce support
		add_action( 'makeplus_components_loaded', array( $this, 'add_ecommerce_support' ) );

		// Layout: Shop description
		add_filter( 'makeplus_ecommerce_layoutshop_description', array( $this, 'layoutshop_description' ) );

		// Layout: Product description
		add_filter( 'makeplus_ecommerce_layoutproduct_description', array( $this, 'layoutproduct_description' ) );

		// Highlight Color description
		add_filter( 'makeplus_ecommerce_colorhighlight_description', array( $this, 'colorhighlight_description' ) );

		// Set values for layout settings that don't have controls
		add_filter( 'make_settings_thememod_current_value', array( $this, 'thememod_value' ), 10, 2 );

		// Add styles
		add_action( 'make_style_loaded', array( $this, 'add_styles' ), 10, 3 );

		// Add the section styles and scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );

		// Add JS fix for "Insert download" button
		add_action( 'admin_footer-post.php', array( $this, 'admin_inline_script' ) );
		add_action( 'admin_footer-post-new.php', array( $this, 'admin_inline_script' ) );

		// Add Downloads section settings
		add_filter( 'make_section_defaults', array( $this, 'section_defaults' ) );
		add_filter( 'make_section_choices', array( $this, 'section_choices' ), 10, 3 );

		// Add section
		if ( is_admin() ) {
			add_action( 'after_setup_theme', array( $this, 'register_downloads_section' ), 11 );
		}

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Enqueue styles and scripts
	 *
	 * @since 1.1.0.
	 *
	 * @hooked action wp_enqueue_scripts
	 *
	 * @return void
	 */
	public function enqueue_frontend() {
		// Styles
		wp_enqueue_style(
			'makeplus-edd-frontend',
			makeplus_get_plugin_directory_uri() . 'css/edd/frontend.css',
			array( 'edd-styles' ),
			MAKEPLUS_VERSION
		);

		// If current theme is a child theme of Make, load the stylesheet
		// before the child theme stylesheet so styles can be customized.
		if ( $this->has_module( 'theme' ) && is_child_theme() ) {
			$this->theme()->scripts()->add_dependency( 'make-main', 'makeplus-edd-frontend', 'style' );
		}
	}

	/**
	 * Add the plugin module path as the first path to search for EDD template files.
	 *
	 * @since 1.1.0.
	 *
	 * @hooked filter edd_template_paths
	 *
	 * @param array $file_paths    The original array of file paths.
	 *
	 * @return array               The modified array of file paths.
	 */
	public function filter_template_paths( $file_paths ) {
		$new_path = array( makeplus_get_plugin_directory() . 'inc/component/edd/templates' );
		return array_merge( $new_path, $file_paths );
	}

	/**
	 * Add additional download item classes.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked filter edd_download_class
	 *
	 * @param string $class    The download item classes.
	 * @param int    $id       The download post ID.
	 * @param array  $atts     The shortcode atts.
	 * @param int    $i        The output counter.
	 *
	 * @return string          The modified download item classes.
	 */
	public function edd_download_class( $class, $id, $atts, $i ) {
		if ( ! isset( $atts['columns'] ) || 1 == $atts['columns'] || is_null( $i ) ) {
			return $class;
		}

		if ( 0 === (int) $i % absint( $atts['columns'] ) ) {
			$class .= ' last';
		}

		return $class;
	}

	/**
	 * Define the conditions for the view to be "Shop".
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter makeplus_view_is_shop
	 *
	 * @param bool $is_shop
	 *
	 * @return bool
	 */
	public function is_shop( $is_shop ) {
		if (
			is_post_type_archive( 'download' )
			||
			is_tax( 'download_category' )
			||
			is_tax( 'download_tag' )
		) {
			$is_shop = true;
		}

		return $is_shop;
	}

	/**
	 * Define the conditions for the view to be "Product".
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter makeplus_view_is_product
	 *
	 * @param bool $is_product
	 *
	 * @return bool
	 */
	public function is_product( $is_product ) {
		$post = get_post();
		$parent_post_type = ( $post instanceof WP_Post ) ? get_post_type( $post->post_parent ) : '';

		if (
			is_singular( 'download' )
			||
			( is_attachment() && 'download' === $parent_post_type )
		) {
			$is_product = true;
		}

		return $is_product;
	}

	/**
	 * Define the conditions for the admin view to be "Product".
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter makeplus_admin_view_is_product
	 *
	 * @param bool $is_product
	 *
	 * @return bool
	 */
	public function admin_is_product( $is_product ) {
		global $typenow;

		if ( isset( $typenow ) && 'download' === $typenow ) {
			$is_product = true;
		}

		return $is_product;
	}

	/**
	 * Add theme support for various Ecommerce enhancements.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action makeplus_components_loaded
	 *
	 * @return void
	 */
	public function add_ecommerce_support() {
		// Layout: Shop
		add_theme_support( 'makeplus-ecommerce-layoutshop' );

		// Layout: Product
		add_theme_support( 'makeplus-ecommerce-layoutproduct' );

		// Shop Sidebar
		add_theme_support( 'makeplus-ecommerce-sidebar' );

		// Highlight color
		add_theme_support( 'makeplus-ecommerce-colorhighlight' );
	}

	/**
	 * Add a description to the Layout: Shop section.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked filter makeplus_ecommerce_layoutshop_description
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	public function layoutshop_description( $text ) {
		$description = __( 'For Easy Digital Downloads, this view consists of download archives and related category and tag archives.', 'make-plus' );

		if ( '' !== $text ) {
			$text .= '<br />';
		}

		return $text . $description;
	}

	/**
	 * Add a description to the Layout: Product section.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked filter makeplus_ecommerce_layoutproduct_description
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	public function layoutproduct_description( $text ) {
		$description = __( 'For Easy Digital Downloads, this view consists of single downloads.', 'make-plus' );

		if ( '' !== $text ) {
			$text .= '<br />';
		}

		return $text . $description;
	}

	/**
	 * Add a description to the Highlight Color control.
	 *
	 * @since 1.5.0.
	 *
	 * @hooked filter makeplus_ecommerce_colorhighlight_description
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	public function colorhighlight_description( $text ) {
		$description = __( 'For Easy Digital Downloads, used for prices and alerts.', 'make-plus' );

		if ( '' !== $text ) {
			$text .= '<br />';
		}

		return $text . $description;
	}

	/**
	 * Return a specific value depending on the current filter.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter make_settings_thememod_current_value
	 *
	 * @param string $value    The current value of the setting.
	 *
	 * @return string          The modified value of the setting.
	 */
	public function thememod_value( $value, $setting_id ) {
		switch ( $setting_id ) {
			case 'layout-shop-featured-images' :
				$value = 'thumbnail';
				break;
			case 'layout-product-featured-images' :
				$value = 'post-header';
				break;
			case 'layout-shop-post-author' :
			case 'layout-product-post-author' :
				$value = 'none';
				break;
		}

		return $value;
	}

	/**
	 * Use Make's color settings to override some of EDD's CSS styles
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action make_style_loaded
	 *
	 * @param MAKE_Style_ManagerInterface $style
	 *
	 * @return void
	 */
	public function add_styles( MAKE_Style_ManagerInterface $style ) {
		// Get setting values
		$color_secondary = $style->thememod()->get_value( 'color-secondary' );
		$color_highlight = $style->thememod()->get_value( 'color-highlight' );

		// Output the rules
		$style->css()->add( array(
			'selectors'    => array(
				'.edd-submit.button.blue',
				'#edd-purchase-button',
				'.edd-submit',
				'input[type=submit].edd-submit',
				'#edd_checkout_cart a.edd-cart-saving-button',
				'.edd-submit.button.blue.active',
				'.edd-submit.button.blue:focus',
				'.edd-submit.button.blue:hover',
				'#edd_checkout_form_wrap #edd_final_total_wrap'
			),
			'declarations' => array(
				'background-color' => $color_secondary
			)
		) );
		$style->css()->add( array(
			'selectors'    => array(
				'#edd_checkout_cart td',
				'#edd_checkout_cart th',
				'#edd_checkout_form_wrap fieldset'
			),
			'declarations' => array(
				'border-color' => $color_secondary
			)
		) );
		$style->css()->add( array(
			'selectors'    => array(
				'.edd_price',
				'.edd-cart-added-alert',
			),
			'declarations' => array(
				'color' => $color_highlight
			)
		) );

		// Remove action so the styles don't get added more than once
		remove_action( 'make_style_loaded', __FUNCTION__ );
	}

	/**
	 * Enqueue the JS and CSS for the admin.
	 *
	 * @since 1.1.0.
	 *
	 * @hooked action admin_enqueue_scripts
	 *
	 * @param string $hook_suffix    The suffix for the screen.
	 *
	 * @return void
	 */
	public function admin_enqueue( $hook_suffix ) {
		// Have to be careful with this test because this function was introduced in Make 1.2.0.
		$post_type_supports_builder = ( function_exists( 'ttfmake_post_type_supports_builder' ) ) ? ttfmake_post_type_supports_builder( get_post_type() ) : false;

		// Only load resources if they are needed on the current page
		if (
			in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )
			&&
			( $post_type_supports_builder || 'page' === get_post_type() )
		) {
			// Add the section CSS
			wp_enqueue_style(
				'makeplus-edd-sections',
				makeplus_get_plugin_directory_uri() . 'css/edd/sections.css',
				array(),
				MAKEPLUS_VERSION
			);
		}
	}

	/**
	 * This script fixes the "Chosen" download select used by EDD's "Insert download" button for
	 * custom TinyMCE instances.
	 *
	 * @since 1.2.0.
	 * @since 1.6.1. Updated to work with the TinyMCE overlay.
	 *
	 * @hooked action admin_footer-post.php
	 * @hooked action admin_footer-post-new.php
	 *
	 * @return void
	 */
	public function admin_inline_script() {
		// Have to be careful with this test because this function was introduced in Make 1.2.0.
		$post_type_supports_builder = ( function_exists( 'ttfmake_post_type_supports_builder' ) ) ? ttfmake_post_type_supports_builder( get_post_type() ) : false;

		if (
			( $post_type_supports_builder || 'page' === get_post_type() )
			&&
			defined( 'EDD_VERSION' )
		) {
			?>
			<script type="application/javascript">
				(function($){
					// This fixes the Chosen box being 0px wide when the thickbox is opened
					$('#ttfmake-tinymce-overlay').on('click', '.edd-thickbox', function() {
						$('.edd-select-chosen').css('width', '100%');
					});
				}(jQuery));
			</script>
		<?php
		}
	}

	/**
	 * Add new section defaults.
	 *
	 * @since 1.1.0.
	 *
	 * @hooked filter make_section_defaults
	 *
	 * @param array $defaults    The default section defaults.
	 *
	 * @return array             The augmented section defaults.
	 */
	public function section_defaults( $defaults ) {
		$new_defaults = array(
			'edd-downloads-title'            => '',
			'edd-downloads-background-image' => 0,
			'edd-downloads-darken'           => 0,
			'edd-downloads-background-style' => 'tile',
			'edd-downloads-background-color' => '',
			'edd-downloads-columns'          => 3,
			'edd-downloads-taxonomy'         => 'all',
			'edd-downloads-sortby'           => 'post_date-desc',
			'edd-downloads-count'            => 9,
			'edd-downloads-thumb'            => 1,
			'edd-downloads-price'            => 1,
			'edd-downloads-addcart'          => 1,
			'edd-downloads-details'          => 'excerpt',
		);

		return array_merge( $defaults, $new_defaults );
	}

	/**
	 * Add new section choices.
	 *
	 * @since 1.1.0.
	 *
	 * @hooked filter make_section_choices
	 *
	 * @param array  $choices         The existing choices.
	 * @param string $key             The key for the section setting.
	 * @param string $section_type    The section type.
	 *
	 * @return array                  The choices for the particular section_type / key combo.
	 */
	public function section_choices( $choices, $key, $section_type ) {
		if ( count( $choices ) > 1 || ! in_array( $section_type, array( 'edd-downloads' ) ) ) {
			return $choices;
		}

		$choice_id = "$section_type-$key";

		switch ( $choice_id ) {
			case 'edd-downloads-background-style' :
				$choices = array(
					'tile'  => __( 'Tile', 'make-plus' ),
					'cover' => __( 'Cover', 'make-plus' ),
				);
				break;
			case 'edd-downloads-columns' :
				$choices = array(
					1 => __( '1', 'make-plus' ),
					2 => __( '2', 'make-plus' ),
					3 => __( '3', 'make-plus' ),
					4 => __( '4', 'make-plus' ),
				);
				break;
			case 'edd-downloads-taxonomy' :
				// Default
				$choices = array( 'all' => __( 'All download categories/tags', 'make-plus' ) );
				// Categories
				$product_category_terms = get_terms( 'download_category' );
				if ( ! empty( $product_category_terms ) ) {
					$category_slugs = array_map( array( $this, 'prefix_cat' ), wp_list_pluck( $product_category_terms, 'slug' ) );
					$category_names = wp_list_pluck( $product_category_terms, 'name' );
					$category_list = array_combine( $category_slugs, $category_names );
					$choices = array_merge(
						$choices,
						array( 'ttfmp-disabled1' => '--- ' . __( 'Download categories', 'make-plus' ) . ' ---' ),
						$category_list
					);
				}
				// Tags
				$product_tag_terms = get_terms( 'download_tag' );
				if ( ! empty( $product_tag_terms ) ) {
					$tag_slugs = array_map( array( $this, 'prefix_tag' ), wp_list_pluck( $product_tag_terms, 'slug' ) );
					$tag_names = wp_list_pluck( $product_tag_terms, 'name' );
					$tag_list = array_combine( $tag_slugs, $tag_names );
					$choices = array_merge(
						$choices,
						array( 'ttfmp-disabled2' => '--- ' . __( 'Download tags', 'make-plus' ) . ' ---' ),
						$tag_list
					);
				}
				break;
			case 'edd-downloads-sortby' :
				$choices = array(
					'post_date-desc' => __( 'Date: newest first', 'make-plus' ),
					'post_date-asc'  => __( 'Date: oldest first', 'make-plus' ),
					'title-asc'      => __( 'Name: A to Z', 'make-plus' ),
					'title-desc'     => __( 'Name: Z to A', 'make-plus' ),
					'price-asc'      => __( 'Price: low to high', 'make-plus' ),
					'price-desc'     => __( 'Price: high to low', 'make-plus' ),
					'random'         => __( 'Random', 'make-plus' ),
				);
				break;
			case 'edd-downloads-details' :
				$choices = array(
					'full'    => __( 'Full content', 'make-plus' ),
					'excerpt' => __( 'Excerpt', 'make-plus' ),
					'none'    => __( 'None', 'make-plus' ),
				);
				break;
		}

		return $choices;
	}

	/**
	 * Add a category prefix to a value.
	 *
	 * @since 1.1.0.
	 *
	 * @param string $value    The original value.
	 *
	 * @return string          The modified value.
	 */
	private function prefix_cat( $value ) {
		return 'cat_' . $value;
	}

	/**
	 * Add a tag prefix to a value.
	 *
	 * @since 1.1.0.
	 *
	 * @param string value    The original value.
	 *
	 * @return string         The modified value.
	 */
	private function prefix_tag( $value ) {
		return 'tag_' . $value;
	}

	/**
	 * Register the Downloads section.
	 *
	 * @since 1.1.0.
	 *
	 * @hooked action after_setup_theme
	 *
	 * @return void
	 */
	public function register_downloads_section() {
		ttfmake_add_section(
			'downloads',
			__( 'Downloads', 'make-plus' ),
			makeplus_get_plugin_directory_uri() . 'css/edd/images/edd.png',
			__( 'Display your Easy Digital Downloads products in a grid layout.', 'make-plus' ),
			array( $this, 'save_downloads' ),
			'sections/builder-templates/downloads',
			'sections/front-end-templates/downloads',
			830,
			makeplus_get_plugin_directory() . 'inc/component/edd',
			array(
				100 => array(
					'type'  => 'section_title',
					'name'  => 'title',
					'label' => __( 'Enter section title', 'make-plus' ),
					'class' => 'ttfmake-configuration-title ttfmake-section-header-title-input',
					'default' => ttfmake_get_section_default( 'title', 'edd-downloads' ),
				),
				200 => array(
					'type'  => 'image',
					'name'  => 'background-image',
					'label' => __( 'Background image', 'make-plus' ),
					'class' => 'ttfmake-configuration-media',
					'default' => ttfmake_get_section_default( 'background-image', 'edd-downloads' ),
				),
				300 => array(
					'type'    => 'checkbox',
					'label'   => __( 'Darken background to improve readability', 'make-plus' ),
					'name'    => 'darken',
					'default' => ttfmake_get_section_default( 'darken', 'edd-downloads' ),
				),
				400 => array(
					'type'    => 'select',
					'name'    => 'background-style',
					'label'   => __( 'Background style', 'make-plus' ),
					'default' => ttfmake_get_section_default( 'background-style', 'edd-downloads' ),
					'options' => ttfmake_get_section_choices( 'background-style', 'edd-downloads' ),
				),
				500 => array(
					'type'    => 'color',
					'label'   => __( 'Background color', 'make-plus' ),
					'name'    => 'background-color',
					'class'   => 'ttfmake-text-background-color ttfmake-configuration-color-picker',
					'default' => ttfmake_get_section_default( 'background-color', 'edd-downloads' ),
				),
			)
		);
	}

	/**
	 * Save the data for the Product Grid section.
	 *
	 * @since 1.1.0.
	 *
	 * @param array $data    The data from the $_POST array for the section.
	 *
	 * @return array         The cleaned data.
	 */
	public function save_downloads( $data ) {
		// Checkbox fields will not be set if they are unchecked.
		$checkboxes = array( 'thumb', 'price', 'addcart' );
		foreach ( $checkboxes as $key ) {
			if ( ! isset( $data[$key] ) ) {
				$data[$key] = 0;
			}
		}
		// Data to sanitize and save
		$defaults = array(
			'title'            => ttfmake_get_section_default( 'title', 'edd-downloads' ),
			'background-image' => ttfmake_get_section_default( 'background-image', 'edd-downloads' ),
			'darken'           => ttfmake_get_section_default( 'darken', 'edd-downloads' ),
			'background-style' => ttfmake_get_section_default( 'background-style', 'edd-downloads' ),
			'background-color' => ttfmake_get_section_default( 'background-color', 'edd-downloads' ),
			'columns'          => ttfmake_get_section_default( 'columns', 'edd-downloads' ),
			'taxonomy'         => ttfmake_get_section_default( 'taxonomy', 'edd-downloads' ),
			'sortby'           => ttfmake_get_section_default( 'sortby', 'edd-downloads' ),
			'count'            => ttfmake_get_section_default( 'count', 'edd-downloads' ),
			'thumb'            => ttfmake_get_section_default( 'thumb', 'edd-downloads' ),
			'price'            => ttfmake_get_section_default( 'price', 'edd-downloads' ),
			'addcart'          => ttfmake_get_section_default( 'addcart', 'edd-downloads' ),
			'details'          => ttfmake_get_section_default( 'details', 'edd-downloads' ),
		);
		$parsed_data = wp_parse_args( $data, $defaults );

		$clean_data = array();

		// Title
		$clean_data['title'] = $clean_data['label'] = apply_filters( 'title_save_pre', $parsed_data['title'] );

		// Background image
		$clean_data['background-image'] = ttfmake_sanitize_image_id( $parsed_data['background-image']['image-id'] );

		// Darken
		$clean_data['darken'] = absint( $parsed_data['darken'] );

		// Background style
		$clean_data['background-style'] = ttfmake_sanitize_section_choice( $parsed_data['background-style'], 'background-style', 'edd-downloads' );

		// Background color
		$clean_data['background-color'] = maybe_hash_hex_color( $parsed_data['background-color'] );

		// Columns
		$clean_data['columns'] = ttfmake_sanitize_section_choice( $parsed_data['columns'], 'columns', 'edd-downloads' );

		// Taxonomy
		$clean_data['taxonomy'] = ttfmake_sanitize_section_choice( $parsed_data['taxonomy'], 'taxonomy', 'edd-downloads' );

		// Sortby
		$clean_data['sortby'] = ttfmake_sanitize_section_choice( $parsed_data['sortby'], 'sortby', 'edd-downloads' );

		// Count
		$clean_data['count'] = (int) $parsed_data['count'];
		if ( $clean_data['count'] < -1 ) {
			$clean_data['count'] = abs( $clean_data['count'] );
		}

		// Thumb
		$clean_data['thumb'] = absint( $parsed_data['thumb'] );

		// Price
		$clean_data['price'] = absint( $parsed_data['price'] );

		// Add to cart
		$clean_data['addcart'] = absint( $parsed_data['addcart'] );

		// Sortby
		$clean_data['details'] = ttfmake_sanitize_section_choice( $parsed_data['details'], 'details', 'edd-downloads' );

		return $clean_data;
	}
}