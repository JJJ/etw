<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_WooCommerce_Shortcode
 *
 * Display a grid of WooCommerce products based on criteria specified in shortcode parameters.
 *
 * @since 1.0.0.
 * @since 1.7.0. Changed class name from TTFMP_WooCommerce_Shortcode
 */
class MAKEPLUS_Component_WooCommerce_Shortcode extends MAKEPLUS_Util_Modules implements MAKEPLUS_Component_WooCommerce_ShortcodeInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKEPLUS_Compatibility_MethodsInterface',
		'wc'            => 'WooCommerce',
	);

	/**
	 * Product Grid columns
	 *
	 * @since 1.0.0.
	 *
	 * @var int $columns    The number of columns for the Product Grid shortcode
	 */
	private $columns = 0;

	/**
	 * An array of the actions/filters added before content output
	 *
	 * @since 1.0.0.
	 *
	 * @var array $removed    The array of added actions/filters
	 */
	private $added = array();

	/**
	 * An array of the actions/filters removed before content output
	 *
	 * @since 1.0.0.
	 *
	 * @var array $removed    The array of removed actions/filters
	 */
	private $removed = array();

	/**
	 * Add/remove callbacks from hooks and store their info so they can be reset later.
	 *
	 * @since 1.0.0.
	 *
	 * @param array $add       Array of actions/filters to add.
	 * @param array $remove    Array of actions/filters to remove.
	 *
	 * @return void
	 */
	private function adjust_hooks( $add = array(), $remove = array() ) {
		global $wp_filter;

		// Add
		if ( ! empty( $add ) ) {
			foreach ( $add as $item ) {
				if ( ! isset( $item['priority'] ) ) {
					$item['priority'] = 10;
				}
				if ( ! isset( $item['args'] ) ) {
					$item['args'] = 1;
				}

				if ( isset( $item['type'] ) && 'action' === $item['type'] ) {
					add_action( $item['hook'], $item['callback'], $item['priority'], $item['args'] );
				} else {
					add_filter( $item['hook'], $item['callback'], $item['priority'], $item['args'] );
				}

				$this->added[] = $item;
			}
		}

		// Remove
		if ( ! empty( $remove ) ) {
			foreach ( $remove as $item ) {
				if ( isset( $item['type'] ) && 'action' === $item['type'] ) {
					if ( $item['priority'] = has_action( $item['hook'], $item['callback'] ) ) {
						$item['args'] = $wp_filter[$item['hook']][$item['priority']][$item['callback']]['accepted_args'];
						remove_action( $item['hook'], $item['callback'], $item['priority'] );
						$this->removed[] = $item;
					}
				} else {
					if ( $item['priority'] = has_filter( $item['hook'], $item['callback'] ) ) {
						$item['args'] = $wp_filter[$item['hook']][$item['priority']][$item['callback']]['accepted_args'];
						remove_filter( $item['hook'], $item['callback'], $item['priority'] );
						$this->removed[] = $item;
					}
				}
			}
		}
	}

	/**
	 * Undo changes made by adjust_hooks().
	 *
	 * @since 1.0.0.
	 *
	 * @param array $added      Array of actions/filters to remove.
	 * @param array $removed    Array of actions/filters to add back.
	 *
	 * @return void
	 */
	private function reset_hooks( $added = array(), $removed = array() ) {
		// Added
		if ( ! empty( $added ) ) {
			foreach ( $added as $item ) {
				if ( isset( $item['type'] ) && 'action' === $item['type'] ) {
					remove_action( $item['hook'], $item['callback'], $item['priority'] );
				} else {
					remove_filter( $item['hook'], $item['callback'], $item['priority'] );
				}
			}
		}

		// Removed
		if ( ! empty( $removed ) ) {
			foreach ( $removed as $item ) {
				if ( isset( $item['type'] ) && 'action' === $item['type'] ) {
					add_action( $item['hook'], $item['callback'], $item['priority'], $item['args'] );
				} else {
					add_filter( $item['hook'], $item['callback'], $item['priority'], $item['args'] );
				}
			}
		}
	}

	/**
	 * Combine the given Product Grid shortcode attributes with the defaults.
	 *
	 * @since 1.0.0.
	 *
	 * @param array $atts    The attributes from the Product Grid shortcode.
	 *
 	 * @return array         The parsed attributes.
	 */
	private function parse_atts_product_grid( $atts ) {
		// Define defaults
		$defaults = array(
			'columns'  => 3,
			'type'     => 'all',
			'taxonomy' => 'all',
			'sortby'   => 'menu_order',
			'count'    => 9,
			'thumb'  => 1,
			'rating'  => 1,
			'price'  => 1,
			'addcart'  => 1,
		);
		$parsed_atts = shortcode_atts( $defaults, $atts, 'ttfmp_woocomerce_product_grid' );

		// Store the columns number for later
		$this->columns = ( 0 === absint( $parsed_atts['columns'] ) ) ? $defaults['columns'] : absint( $parsed_atts['columns'] );

		return $parsed_atts;
	}

	/**
	 * Use the Product Grid shortcode attributes to build an array of query arguments.
	 *
	 * @since 1.0.0.
	 *
	 * @param array $atts    The attributes from the Product Grid shortcode.
	 *
	 * @return array         The array of query arguments.
	 */
	private function query_args_product_grid( $atts ) {
		// Get the ordering arguments
		$ordering_args = $this->wc()->query->get_catalog_ordering_args( esc_attr( $atts['sortby'] ) );

		// Default arguments
		$args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => true,
			'orderby'             => $ordering_args['orderby'],
			'order'               => $ordering_args['order'],
			'posts_per_page'      => (int) $atts['count'],
			'meta_query'          => $this->wc()->query->get_meta_query(),
		);

		// Extra default argument, depending on ordering args
		if ( isset( $ordering_args['meta_key'] ) ) {
			$args['meta_key'] = $ordering_args['meta_key'];
		}

		// Type = featured
		if ( 'featured' === $atts['type'] ) {
			$args['meta_query'][] = array(
				'key' => '_featured',
				'value' => 'yes'
			);
		}

		// Type = sale
		if ( 'sale' === $atts['type'] ) {
			$product_ids_on_sale = wc_get_product_ids_on_sale();

			$args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
			$args['no_found_rows'] = 1;
		}

		// Taxonomy arguments
		if ( 'all' !== $atts['taxonomy'] ) {
			$term = explode( '_', $atts['taxonomy'], 2 );
			if ( 2 === count( $term ) ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'product_' . esc_attr( $term[0] ),
						'terms'    => array( esc_attr( $term[1] ) ),
						'field'    => 'slug',
						'operator' => 'IN'
					)
				);
			}
		}

		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_woocommerce_product_grid_query_args' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_woocommerce_product_grid_query_args',
				'1.7.0',
				sprintf(
					__( 'Use the %s hook instead.', 'make-plus' ),
					'<code>makeplus_woocommerce_product_grid_query_args</code>'
				)
			);

			/**
			 * Filter the query arguments for the Product Grid.
			 *
			 * @since 1.0.0.
			 * @deprecated 1.7.0.
			 *
			 * @param array $args    Query args
			 * @param array $atts    Shortcode attributes
			 */
			$args = apply_filters( 'ttfmp_woocommerce_product_grid_query_args', $args, $atts );
		}

		/**
		 * Filter: Modify the query arguments for the Product Grid.
		 *
		 * @since 1.7.0.
		 *
		 * @param array $args    Query args
		 * @param array $atts    Shortcode attributes
		 */
		return apply_filters( 'makeplus_woocommerce_product_grid_query_args', $args, $atts );
	}

	/**
	 * Render the markup for the Product Grid shortcode.
	 *
	 * @since 1.0.0.
	 *
	 * @param object $query    The query results to build the markup with.
	 * @param array  $atts     The attributes from the Product Grid shortcode.
	 *
	 * @return string          The markup.
	 */
	private function render_product_grid( $query, $atts ) {
		// Buffer the output
		ob_start();

		// Add a Columns filter
		$add = array(
			array(
				'type'     => 'filter',
				'hook'     => 'loop_shop_columns',
				'callback' => array( $this, 'loop_shop_columns' ),
			)
		);

		// Collect filters to remove
		$remove = array();

		// Product image
		if ( false === (bool) absint( $atts['thumb'] ) ) {
			$remove[] = array(
				'type'     => 'action',
				'hook'     => 'woocommerce_before_shop_loop_item_title',
				'callback' => 'woocommerce_show_product_loop_sale_flash',
			);
			$remove[] = array(
				'type'     => 'action',
				'hook'     => 'woocommerce_before_shop_loop_item_title',
				'callback' => 'woocommerce_template_loop_product_thumbnail',
			);
		} else {
			// Change the image size used for the product image
			$add[] = array(
				'type'     => 'action',
				'hook'     => 'woocommerce_before_shop_loop_item_title',
				'callback' => array( $this, 'product_grid_thumbnail' ),
			);
			$remove[] = array(
				'type'     => 'action',
				'hook'     => 'woocommerce_before_shop_loop_item_title',
				'callback' => 'woocommerce_template_loop_product_thumbnail',
			);
		}
		// Rating
		if ( false === (bool) absint( $atts['rating'] ) ) {
			$remove[] = array(
				'type'     => 'action',
				'hook'     => 'woocommerce_after_shop_loop_item_title',
				'callback' => 'woocommerce_template_loop_rating',
			);
		}
		// Price
		if ( false === (bool) absint( $atts['price'] ) ) {
			$remove[] = array(
				'type'     => 'action',
				'hook'     => 'woocommerce_after_shop_loop_item_title',
				'callback' => 'woocommerce_template_loop_price',
			);
		}
		// Add To Cart
		if ( false === (bool) absint( $atts['addcart'] ) ) {
			$remove[] = array(
				'type'     => 'action',
				'hook'     => 'woocommerce_after_shop_loop_item',
				'callback' => 'woocommerce_template_loop_add_to_cart',
			);
		}

		// Adjust actions/filters
		$this->adjust_hooks( $add, $remove );

		// Run the loop
		woocommerce_product_loop_start();

		while ( $query->have_posts() ) : $query->the_post();
			wc_get_template_part( 'content', 'product' );
		endwhile;

		woocommerce_product_loop_end();
		wp_reset_postdata();

		// Reset actions/filters
		$this->reset_hooks( $this->added, $this->removed );

		// Return the output
		return '<div class="woocommerce container columns-' . esc_attr( $atts['columns'] ) . '">' . ob_get_clean() . '</div>';
	}

	/**
	 * Filter to modify the number of columns in the Product Grid.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter loop_shop_columns
	 *
	 * @return int            The new number of columns.
	 */
	public function loop_shop_columns() {
		return $this->columns;
	}

	/**
	 * Wrapper function to allow for modification of Product Grid image size.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function product_grid_thumbnail() {
		/**
		 * Filter: Modify the image size used for product images in the Products section.
		 *
		 * @since 1.7.1.
		 *
		 * @param string $image_size    The name of the image size to use.
		 */
		$image_size = apply_filters( 'makeplus_woocommerce_product_grid_image_size', 'large' );

		echo woocommerce_get_product_thumbnail( $image_size );
	}

	/**
	 * Product Grid shortcode handler.
	 *
	 * @since 1.0.0.
	 *
	 * @param array $shortcode_atts    The attributes from the Product Grid shortcode.
	 *
	 * @return string                  The markup.
	 */
	public function shortcode_product_grid( $shortcode_atts ) {
		// Parse attributes
		$atts = $this->parse_atts_product_grid( $shortcode_atts );

		// Build query arguments
		$args = $this->query_args_product_grid( $atts );

		// Query
		$query = new WP_Query( $args );

		// Cache product thumbnails
		update_post_thumbnail_cache( $query );

		// Render
		$output = '';
		if ( $query->have_posts() ) {
			$output = $this->render_product_grid( $query, $atts );
		}

		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_woocommerce_product_grid_output' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_woocommerce_product_grid_output',
				'1.7.0',
				sprintf(
					__( 'Use the %s hook instead.', 'make-plus' ),
					'<code>makeplus_woocommerce_product_grid_output</code>'
				)
			);

			/**
			 * Filter the output for the Product Grid.
			 *
			 * @since 1.0.0.
			 * @deprecated 1.7.0.
			 *
			 * @param string $output
			 */
			$output = apply_filters( 'ttfmp_woocommerce_product_grid_output', $output );
		}

		/**
		 * Filter: Modify the output for the Product Grid.
		 *
		 * @since 1.7.0.
		 *
		 * @param string $output
		 */
		return apply_filters( 'makeplus_woocommerce_product_grid_output', $output );
	}
}
