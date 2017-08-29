<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Baseline
 */


/**
 * Displays post pagination links
 *
 * @since baseline 1.0
 */
if ( ! function_exists( 'baseline_pagination' ) ) :
function baseline_pagination( $query = false ) {
	global $wp_query;
	if( $query ) {
		$temp_query = $wp_query;
		$wp_query = $query;
	}

	// Return early if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>
	<div class="pagination">
		<div class="container">
		<?php
			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var('paged') ),
				'total'     => $wp_query->max_num_pages,
				'next_text' => esc_html__( '&rarr;', 'baseline' ),
				'prev_text' => esc_html__( '&larr;', 'baseline' )
			) );
		?>
		</div>
	</div>
	<?php
	if( isset( $temp_query ) ) {
		$wp_query = $temp_query;
	}
} endif;


if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'baseline' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'baseline' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'baseline' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'baseline' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'baseline' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'baseline' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'baseline' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'baseline' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'baseline' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'baseline' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'baseline' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'baseline' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'baseline' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'baseline' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'baseline' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'baseline' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'baseline' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'baseline' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'baseline' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'baseline' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'baseline' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );
	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;


if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {

	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;


/**
 * Display the author description on author archive
 */
function the_author_archive_description( $before = '', $after = '' ) {

	$author_description  = get_the_author_meta( 'description' );

	if ( ! empty( $author_description ) ) {
		/**
		 * Get the author bio
		 */
		echo $author_description;
	}
}


/**
 * Site title and logo
 */
if ( ! function_exists( 'baseline_title_logo' ) ) :
function baseline_title_logo() { ?>
	<!-- Use the Site Logo feature, if supported -->
	<?php if ( function_exists( 'jetpack_the_site_logo' ) ) {

		jetpack_the_site_logo();

	} else {
		// Use the standard Customizer logo
		$logo = get_theme_mod( 'baseline_customizer_logo' );
		if ( ! empty( $logo ) ) {

			if ( is_front_page() && is_home() ) { ?>
				<h1 class="site-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
				</h1>
 			<?php } else { ?>
				<p class="site-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
				</p>
 			<?php }
		}
	} ?>

	<div class="titles-wrap">
		<?php if ( is_front_page() && is_home() ) { ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php } else { ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php } ?>

		<?php if ( get_bloginfo( 'description' ) ) { ?>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
		<?php } ?>
	</div><!-- .titles-wrap -->
<?php } endif;


/**
 * Custom comment output
 */
function baseline_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID() ?>">

	<div class="comment-block" id="comment-<?php comment_ID(); ?>">

		<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

		<div class="comment-wrap">
			<div class="comment-info">
				<cite class="comment-cite">
				    <?php comment_author_link() ?>
				</cite>

				<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( esc_html__( '%1$s at %2$s', 'baseline' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'baseline' ), '&nbsp;&nbsp;', '' ); ?>
			</div>

			<div class="comment-content">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</p>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'baseline' ) ?></em>
			<?php endif; ?>
		</div>
	</div>
<?php
}


/**
 * Post byline
 */
if ( ! function_exists( 'baseline_byline' ) ) :
function baseline_byline() { ?>
	<div class="byline">
		<span>
			<?php
				// Get the post author outside the loop
				global $post;
				$author_id   = $post->post_author;
			?>
			<!-- Get the avatar -->
			<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" title="<?php esc_attr_e( 'Posts by ', 'baseline' ); ?> <?php esc_attr( get_the_author() ); ?>">
				<?php echo get_avatar( $author_id, apply_filters( 'baseline_author_avatar', 24 ) ); ?>
			</a>
			<?php the_author_posts_link(); ?>
		</span>
		<span><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo get_the_date(); ?></a></span>
		<?php if ( have_comments() || is_single() ) : ?>
		<span>
			<a href="<?php the_permalink(); ?>#comments" title="<?php esc_attr_e( 'Comments on', 'baseline' ); ?> <?php the_title(); ?>">
				<?php
					printf(
					esc_html( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'baseline' ) ),
					number_format_i18n( get_comments_number() ), get_the_title() );
				?>
			</a>
		</span>
		<?php endif; // have_comments() ?>
	</div>
<?php
}
endif;

/**
 * Limit category output to three
 */
if ( ! function_exists( 'baseline_list_cats' ) ) :
function baseline_list_cats( $type ='grid' ) {
	global $post;

	$categories = get_the_category( $post->ID );

	if ( $categories ) {
		// Limit the number of categories output to 3 to keep things tidy
		$i = 0;

		echo '<ul class=" '. $type . '-cats meta-list">';
			foreach( ( get_the_category( $post->ID ) ) as $cat ) {
				echo '<li><a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a></li>';
				if ( ++$i == 3 ) {
					break;
				}
			}
		echo '</ul>';
	}
} endif;


/**
 * Get the image caption
 */
function baseline_featured_caption() {
	global $post;

	$thumbnail_id    = get_post_thumbnail_id( $post->ID );
	$thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment' ) );

	if ( $thumbnail_image && isset( $thumbnail_image[0] ) ) {
		echo '<span>' . $thumbnail_image[0]->post_excerpt . '</span>';
	}
}


/**
 * Next/previous post links
 */
function baseline_post_navigation() { ?>
	<!-- Next and previous post links -->
	<?php
	$next_post = get_next_post();
	$prev_post = get_previous_post();

	if ( $next_post || $prev_post ) { ?>

		<!-- Next and previous post links -->
		<nav class="post-navigation clear">
			<div class="post-navigation-links">
				<?php
					if( $prev_post ) {
						$prev_post_link_url = get_permalink( get_adjacent_post( false,'',true )->ID );

						$prev_post_date = mysql2date( get_option( 'date_format' ), $prev_post->post_date );

						echo '<div class="nav-prev nav-post">';
							echo '<span class="nav-label"><i class="fa fa-angle-left"></i> ' . esc_html__( 'Previous', 'baseline' ) . '</span>';
							echo '<div class="nav-title">';
								previous_post_link( '%link', '%title' );
							echo '</div>';

							echo '<span class="nav-date">' . esc_html( $prev_post_date ) . '</span>';
						echo '</div>';
				} ?>

				<?php
					if( $next_post ) {
						$next_post_link_url = get_permalink( get_adjacent_post( false,'',false )->ID );

						$next_post_date = mysql2date( get_option( 'date_format' ), $next_post->post_date );

						echo '<div class="nav-next nav-post">';
							echo '<span class="nav-label">' . esc_html__( 'Next', 'baseline' ) . ' <i class="fa fa-angle-right"></i></span>';
							echo '<div class="nav-title">';
								next_post_link( '%link', '%title' );
							echo '</div>';
							echo '<span class="nav-date">' . esc_html( $next_post_date ) . '</span>';
						echo '</div>';
				} ?>
			</div>
		</nav><!-- .post-navigation -->
	<?php }
}
