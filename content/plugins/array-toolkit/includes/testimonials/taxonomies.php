<?php
/**
 * Registers the testimonial_category taxonomy for the testimonial post type.
 *
 * This is based on the WordPress community-curated standards for common post types, taxonomies, and metadata.
 * @see https://github.com/justintadlock/content-type-standards
 *
 * @package Array Toolkit
 * @since 1.1.0
 */
function array_toolkit_testimonials_register_taxonomies() {

	/* Register the Testimonial Category taxonomy. */

	register_taxonomy(
		'testimonial_category',
		array( 'testimonial' ),
		array(
			'public'            => true,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'query_var'         => 'testimonial_category',

			/* The rewrite handles the URL structure. */
			'rewrite' => array(
				'slug'         => 'testimonials/category',
				'with_front'   => false,
				'hierarchical' => true,
				'ep_mask'      => EP_NONE
			),

			/* Labels used when displaying taxonomy and terms. */
			'labels' => array(
				'name'                       => __( 'Testimonial Categories', 'example-textdomain' ),
				'singular_name'              => __( 'Testimonial Category',   'example-textdomain' ),
				'menu_name'                  => __( 'Categories',             'example-textdomain' ),
				'name_admin_bar'             => __( 'Category',               'example-textdomain' ),
				'search_items'               => __( 'Search Categories',      'example-textdomain' ),
				'popular_items'              => __( 'Popular Categories',     'example-textdomain' ),
				'all_items'                  => __( 'All Categories',         'example-textdomain' ),
				'edit_item'                  => __( 'Edit Category',          'example-textdomain' ),
				'view_item'                  => __( 'View Category',          'example-textdomain' ),
				'update_item'                => __( 'Update Category',        'example-textdomain' ),
				'add_new_item'               => __( 'Add New Category',       'example-textdomain' ),
				'new_item_name'              => __( 'New Category Name',      'example-textdomain' ),
				'parent_item'                => __( 'Parent Category',        'example-textdomain' ),
				'parent_item_colon'          => __( 'Parent Category:',       'example-textdomain' ),
				'separate_items_with_commas' => null,
				'add_or_remove_items'        => null,
				'choose_from_most_used'      => null,
				'not_found'                  => null,
			)
		)
	);
}
add_action( 'init', 'array_toolkit_testimonials_register_taxonomies' );