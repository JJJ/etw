<?php
/**
 * Functions used throughout the theme
 *
 * @package Meteor
 */


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
if ( ! function_exists( 'meteor_title_logo' ) ) :
function meteor_title_logo() { ?>
	<div class="site-title-wrap" itemscope itemtype="http://schema.org/Organization">
		<!-- Use the Site Logo feature, if supported -->
		<?php if ( function_exists( 'the_custom_logo' ) && the_custom_logo() ) {

			the_custom_logo();
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
		</div>
	</div><!-- .site-title-wrap -->
<?php } endif;


/**
 * Output paeg titles, subtitles and archive descriptions
 */
if ( ! function_exists( 'meteor_page_titles' ) ) :
function meteor_page_titles() { ?>
	<h1>
		<?php
			if ( is_category() ) :
				single_cat_title();

			elseif ( is_tag() ) :
				single_tag_title();

			elseif ( is_author() ) :
				the_post();
				printf( __( 'Author: %s', 'meteor' ), '' . get_the_author() . '' );
				rewind_posts();

			elseif ( is_day() ) :
				printf( __( 'Day: %s', 'meteor' ), '<span>' . get_the_date() . '</span>' );

			elseif ( is_month() ) :
				printf( __( 'Month: %s', 'meteor' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

			elseif ( is_year() ) :
				printf( __( 'Year: %s', 'meteor' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

			elseif ( is_404() ) :
				_e( 'Page Not Found', 'meteor' );

			elseif ( is_search() ) :
				printf( __( 'Search Results for: %s', 'meteor' ), '<span>' . get_search_query() . '</span>' );

			// Title for portfolio archive
			elseif ( is_post_type_archive( 'jetpack-portfolio' ) ) :
				 post_type_archive_title();

			// Title for portfolio categories and tags
			elseif ( is_tax( array(
					'jetpack-portfolio', 'jetpack-portfolio-type' ) ) ) :
						single_term_title();

			elseif ( is_tax( array(
					'jetpack-portfolio', 'jetpack-portfolio-tag' ) ) ) :
						single_term_title();

			elseif ( is_home() || is_page_template( 'templates/template-portfolio-split.php' ) ) :

			elseif ( is_single() ) :
				the_title();
			else :
				single_post_title();

			endif;
		?>
	</h1>

	<?php
	// Get the page excerpt or archive description for a subtitle
	$archive_description = get_the_archive_description();
	$page_excerpt        = get_the_excerpt();

	if ( is_archive() && $archive_description ) {
		$subtitle = get_the_archive_description();
	}

	if ( is_page() && $page_excerpt || is_singular( 'jetpack-portfolio' ) && $page_excerpt ) {
		$subtitle = '<p>' . get_the_excerpt() . '</p>';
	}

	// Show the subtitle
	if ( ! empty( $subtitle ) && ! is_singular( 'post' ) ) { ?>
		<div class="entry-subtitle">
			<?php
				meteor_remove_sharing();
				echo $subtitle;
			?>
		</div>
	<?php }

	// Get the byline on single post pages
	if ( is_singular( 'post' ) ) {
		meteor_post_byline();
	}
} endif;


/**
 * Custom comment output
 */
function meteor_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID() ?>">

	<div class="comment-block" id="comment-<?php comment_ID(); ?>">

		<div class="comment-wrap">
			<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

			<div class="comment-info">
				<cite class="comment-cite">
				    <?php comment_author_link() ?>
				</cite>

				<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( esc_html__( '%1$s at %2$s', 'meteor' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'meteor' ), '&nbsp;', '' ); ?>
			</div>

			<div class="comment-content">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</p>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'meteor' ) ?></em>
			<?php endif; ?>
		</div>
	</div>
<?php
}


/**
 * Output categories for portfolio items
 *
 * * @since meteor 1.2.1
 */
if ( ! function_exists( 'meteor_portfolio_cats' ) ) :
function meteor_portfolio_cats() {
	global $post;

	$categories = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', _x('', '', 'meteor' ), '' );

	if ( $categories ) {
		// Limit the number of categories output to 3 to keep things tidy
		$i = 0;

		echo '<div class="grid-cats">';
			echo $categories;
		echo '</div>';
	}
} endif;


/**
 * Output categories for the grid items
 *
 * * @since meteor 1.2.1
 */
if ( ! function_exists( 'meteor_grid_cats' ) ) :
function meteor_grid_cats() {
	global $post;

	$categories = get_the_category( $post->ID );

	if ( $categories ) {
		// Limit the number of categories output to 2 to keep things tidy on the grid
		$i = 0;

		echo '<div class="grid-cats">';
			foreach( ( get_the_category( $post->ID ) ) as $cat ) {
				echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . esc_html( $cat->cat_name ) . '</a>';
				if ( ++$i == 2 ) {
					break;
				}
			}
		echo '</div>';
	}
} endif;


/**
 * Displays post pagination links
 *
 * @since meteor 1.0
 */
if ( ! function_exists( 'meteor_page_navs' ) ) :
function meteor_page_navs( $query = false ) {

	global $wp_query;
	if( $query ) {
		$temp_query = $wp_query;
		$wp_query = $query;
	}

	// Return early if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	} ?>
	<div class="page-navigation">
		<?php
			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var('paged') ),
				'total'     => $wp_query->max_num_pages,
				'next_text' => esc_html__( '&rarr;', 'meteor' ),
				'prev_text' => esc_html__( '&larr;', 'meteor' )
			) );
		?>
	</div>
	<?php
	if( isset( $temp_query ) ) {
		$wp_query = $temp_query;
	}
} endif;


/**
 * Displays post next/previous navigations
 *
 * @since meteor 1.0
 */
 if ( ! function_exists( 'meteor_post_navs' ) ) :
 function meteor_post_navs( $query = false ) {
 	// Previous/next post navigation.
 	$next_post = get_next_post();
 	$previous_post = get_previous_post();

 	the_post_navigation( array(
 		'next_text' => '<span class="meta-nav-text meta-title">' . esc_html__( 'Next:', 'meteor' ) . '</span> ' .
 		'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'meteor' ) . '</span> ' .
 		'<span class="post-title">%title</span>',
 		'prev_text' => '<span class="meta-nav-text meta-title">' . esc_html__( 'Previous:', 'meteor' ) . '</span> ' .
 		'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'meteor' ) . '</span> ' .
 		'<span class="post-title">%title</span>',
 	) );
 } endif;


/**
 * Author post widget
 *
 * @since 1.0
 */
if ( ! function_exists( 'meteor_author_box' ) ) :
function meteor_author_box() {
	global $post, $current_user;
	$author = get_userdata( $post->post_author );
	if ( $author && ! empty( $author->description ) ) {
	?>
	<div class="author-profile">

		<a class="author-profile-avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Posts by %s', 'meteor' ), get_the_author() ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'meteor_author_bio_avatar_size', 65 ) ); ?></a>

		<div class="author-profile-info">
			<h3 class="author-profile-title">
				<?php if ( is_archive() ) { ?>
					<?php echo esc_html( sprintf( esc_html__( 'All posts by %s', 'meteor' ), get_the_author() ) ); ?>
				<?php } else { ?>
					<?php echo esc_html( sprintf( esc_html__( 'Posted by %s', 'meteor' ), get_the_author() ) ); ?>
				<?php } ?>
			</h3>

			<div class="author-description">
				<p><?php the_author_meta( 'description' ); ?></p>
			</div>

			<div class="author-profile-links">
				<a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?>"><i class="fa fa-pencil-square-o"></i> <?php esc_html_e( 'All Posts', 'meteor' ); ?></a>

				<?php if ( $author->user_url ) { ?>
					<?php printf( '<a href="%1$s"><i class="fa fa-external-link"></i> %2$s</a>', esc_url( $author->user_url ), 'Website', 'meteor' ); ?>
				<?php } ?>
			</div>
		</div><!-- .author-drawer-text -->
	</div><!-- .author-profile -->

<?php } } endif;


/**
 * Post byline
 */
function meteor_post_byline() { ?>
	<?php
		// Get the post author
		global $post;
		$author_id = $post->post_author;
	?>
	<p class="entry-byline">
		<!-- Create an avatar link -->
		<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'Posts by %s', 'meteor' ), get_the_author() ) ); ?>">
			<?php echo get_avatar( $author_id, apply_filters( 'meteor_author_bio_avatar', 44 ) ); ?>
		</a>

		<!-- Create an author post link -->
		<a class="entry-byline-author" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
			<?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?>
		</a>
		<span class="entry-byline-on"><?php esc_html_e( 'on', 'meteor' ); ?></span>
		<span class="entry-byline-date"><?php echo get_the_date(); ?></span>
	</p>
<?php }


/**
 * Modify the archive title prefix
 */
 function meteor_modify_archive_title( $title ) {
	// Skip if the site isn't LTR, this is visual, not functional.
	if ( is_rtl() ) {
		return $title;
	}

	// Split the title into parts so we can wrap them with spans.
	$title_parts = explode( ': ', $title, 2 );

	// Glue it back together again.
	if ( ! empty( $title_parts[1] ) ) {
		$title = wp_kses(
			$title_parts[1],
			array(
				'span' => array(
					'class' => array(),
				),
			)
		);
		$title = '<span class="screen-reader-text">' . esc_html( $title_parts[0] ) . ': </span>' . $title;
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'meteor_modify_archive_title' );
