<?php
/**
 * @package Make Plus
 */

/**
 * Class TTFMP_Posts_List_Filter
 *
 * Methods for handling a dynamic list of filtering options. May include taxonomy terms and pages.
 */
class TTFMP_Posts_List_Filter {
	/**
	 * Initialize.
	 *
	 * @since 1.6.2.
	 */
	public function __construct() {
		if ( false === ttfmp_get_app()->passive ) {
			add_action( 'wp_ajax_ttfmp_posts_list_filter', array( $this, 'ajax_update_filter_list' ) );
		}
	}

	/**
	 * Get the array of value/label choice pairs for filtering a given post type.
	 *
	 * @since 1.6.2.
	 *
	 * @param  string    $post_type    The post type ID.
	 *
	 * @return array                   The array of choices.
	 */
	private function get_choice_list( $post_type ) {
		// No choices if post type doesn't exist / isn't public
		if ( ! in_array( $post_type, get_post_types( array( 'public' => true ) ) ) ) {
			return array();
		}

		$post_type_object = get_post_type_object( $post_type );
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		$is_hierarchical = is_post_type_hierarchical( $post_type );
		$choice_list = array(
			'all' => sprintf(
				__( 'All %s', 'make-plus' ),
				strtolower( $post_type_object->labels->name )
			)
		);
		$i = 1;

		// Child pages
		if ( true === $is_hierarchical ) {
			$post_type_plural = strtolower( $post_type_object->labels->name );
			$choice_list['postid:0'] = sprintf(
				__( 'Top-level %s', 'make-plus' ),
				$post_type_plural
			);

			$posts = get_posts( array(
				'post_type' => $post_type,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'posts_per_page' => 999
			) );
			if ( ! empty( $posts ) ) {
				$label = sprintf(
					__( 'Child %s of', 'make-plus' ),
					$post_type_plural
				);
				$choice_list[ 'ttfmp-disabled' . $i ] = '--- ' . $label . ' ---';
				$i++;

				$post_ids = wp_list_pluck( $posts, 'ID' );
				array_walk( $post_ids, array( $this, 'slug_prefix' ), 'postid' );
				$post_titles = wp_list_pluck( $posts, 'post_title' );
				$post_list = array_combine( $post_ids, $post_titles );

				$choice_list = array_merge( $choice_list, $post_list );
			}
		}

		// Taxonomies
		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $tax_name => $taxonomy ) {
				if ( 'post_format' === $tax_name && ! current_theme_supports( 'post-formats' ) ) {
					continue;
				}

				// Get all the terms for the taxonomy
				$terms = get_terms( $tax_name, array( 'hide_empty' => false ) );

				if ( ! empty( $terms ) ) {
					$label = $taxonomy->labels->singular_name;
					$choice_list[ 'ttfmp-disabled' . $i ] = '--- ' . $label . ' ---';
					$i++;

					$term_slugs = wp_list_pluck( $terms, 'slug' );
					array_walk( $term_slugs, array( $this, 'slug_prefix' ), $tax_name );
					$term_names = wp_list_pluck( $terms, 'name' );
					$term_list = array_combine( $term_slugs, $term_names );

					$choice_list = array_merge( $choice_list, $term_list );
				}
			}
		}

		/**
		 * Returns the choices available in the "From" dropdown that filters the posts returned in the query.
		 *
		 * @since 1.6.2
		 *
		 * @param array     $choice_list    The $value => $label array of choices.
		 * @param string    $post_type      The ID of the post type to retrieve filter choices for.
		 */
		return apply_filters( 'ttfmp_post_list_filter_choices', $choice_list, $post_type );
	}

	/**
	 * Callback for array_walk that prepends the taxonomy ID to a term ID.
	 *
	 * @since 1.6.2.
	 *
	 * @param  string    $value       The term ID.
	 * @param  int       $key         Unused.
	 * @param  string    $taxonomy    The taxonomy ID.
	 *
	 * @return string                 The modified term ID.
	 */
	private function slug_prefix( &$value, $key, $taxonomy ) {
		$value = $taxonomy . ':' . $value;
	}

	/**
	 * Render an array of choice pairs as a set of HTML option elements for a select box.
	 *
	 * @since 1.6.2.
	 *
	 * @param  string         $post_type        The post type ID.
	 * @param  string|null    $current_value    The current value of the select box.
	 *
	 * @return string                           HTML options.
	 */
	public function render_choice_list( $post_type, $current_value = null ) {
		$html = '';

		if ( ! is_null( $current_value ) ) {
			$current_value = $this->sanitize_filter_choice( $current_value, $post_type );
		}

		$choice_list = $this->get_choice_list( $post_type );
		if ( ! empty( $choice_list ) ) {
			foreach ( $choice_list as $value => $label ) {
				$selected = selected( $value, $current_value, false );
				$disabled = ( false !== strpos( $value, 'ttfmp-disabled' ) ) ? ' disabled="disabled"' : '';
				$html .= '<option value="' . esc_attr( $value ) . '"' . $selected . $disabled . '>' . esc_html( $label ) . '</option>';
			}
		}

		return $html;
	}

	/**
	 * Validate and sanitize a choice for the 'From' select box.
	 *
	 * @since 1.6.2.
	 *
	 * @param  string    $value        The value of the chosen option.
	 * @param  string    $post_type    The post type ID.
	 *
	 * @return string                  Sanitized value.
	 */
	public function sanitize_filter_choice( $value, $post_type ) {
		$choice_list = $this->get_choice_list( $post_type );
		$sanitized_value = 'all';

		// Compatibility with old category/tag filter
		$value = $this->upgrade_filter_choice( $value );

		if ( array_key_exists( $value, $choice_list ) ) {
			$sanitized_value = $value;
		}

		return $sanitized_value;
	}

	/**
	 * Upgrade a filter choice from a previous version to the new schema.
	 *
	 * @since 1.6.2.
	 *
	 * @param  string    $value    A filter choice.
	 *
	 * @return string              A possibly upgraded filter choice.
	 */
	public function upgrade_filter_choice( $value ) {
		if ( 0 === strpos( $value, 'cat_' ) ) {
			$value = 'category:' . substr( $value, 4 );
		}
		if ( 0 === strpos( $value, 'tag_' ) ) {
			$value = 'post_tag:' . substr( $value, 4 );
		}

		return $value;
	}

	/**
	 * Handle an Ajax request for the filter choice list for a particular post type.
	 *
	 * @since 1.6.2.
	 *
	 * @return void.
	 */
	public function ajax_update_filter_list() {
		$post_type = ( isset( $_POST['p'] ) ) ? sanitize_key( $_POST['p'] ) : null;
		$selected  = ( isset( $_POST['v'] ) ) ? esc_attr( $_POST['v'] ) : null;

		if ( $post_type ) {
			echo $this->render_choice_list( $post_type, $selected );
		}

		wp_die();
	}
}