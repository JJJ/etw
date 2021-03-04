<?php
namespace AIOSEO\Plugin\Common\Social;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contains helper methods specific to the Social Meta.
 *
 * @since 4.0.0
 */
class Helpers {

	/**
	 * Returns all categories for a post.
	 *
	 * @since 4.0.0
	 *
	 * @param  int   $postId The post ID.
	 * @return array $names  The category names.
	 */
	public function getAllCategories( $postId = 0 ) {
		$names      = [];
		$categories = get_the_category( $postId );
		if ( $categories && count( $categories ) ) {
			foreach ( $categories as $category ) {
				$names[] = aioseo()->helpers->internationalize( $category->cat_name );
			}
		}
		return $names;
	}

	/**
	 * Returns all tags for a post.
	 *
	 * @since 4.0.0
	 *
	 * @param  int   $postId The post ID.
	 * @return array $names  The tag names.
	 */
	public function getAllTags( $postId = 0 ) {
		$names = [];

		$tags = get_the_tags( $postId );
		if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
			foreach ( $tags as $tag ) {
				if ( ! empty( $tag->name ) ) {
					$names[] = aioseo()->helpers->internationalize( $tag->name );
				}
			}
		}

		// Ultimate Tag Warrior integration.
		global $utw;
		if ( is_object( $utw ) ) {
			$tags = $utw->GetTagsForPost( $postId );
			if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
				foreach ( $tags as $tag ) {
					if ( ! empty( $tag->tag ) ) {
						$names[] = stripslashes( preg_replace( '#(-|_)#', $tag->tag ) );
					}
				}
			}
		}

		return $names;
	}
}