<?php
/**
 * Functions used throughout the theme
 *
 * @package Atomic
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
if ( ! function_exists( 'atomic_title_logo' ) ) :
function atomic_title_logo() { ?>
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
 * Custom comment output
 */
function atomic_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class( 'clearfix' ); ?> id="li-comment-<?php comment_ID() ?>">

	<div class="comment-block" id="comment-<?php comment_ID(); ?>">

		<div class="comment-wrap">
			<?php echo get_avatar( $comment->comment_author_email, 75 ); ?>

			<div class="comment-info">
				<cite class="comment-cite">
				    <?php comment_author_link() ?>
				</cite>

				<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf( esc_html__( '%1$s at %2$s', 'atomic' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'atomic' ), '&nbsp;', '' ); ?>
			</div>

			<div class="comment-content">
				<?php comment_text() ?>
				<p class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
				</p>
			</div>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'atomic' ) ?></em>
			<?php endif; ?>
		</div>
	</div>
<?php
}


/**
 * Output categories for portfolio items
 *
 * * @since atomic 1.2.1
 */
if ( ! function_exists( 'atomic_portfolio_cats' ) ) :
function atomic_portfolio_cats() {
	global $post;

	$categories = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', _x('', '', 'designer' ), '' );

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
 * * @since atomic 1.2.1
 */
if ( ! function_exists( 'atomic_grid_cats' ) ) :
function atomic_grid_cats() {
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
 * @since atomic 1.0
 */
if ( ! function_exists( 'atomic_page_navs' ) ) :
function atomic_page_navs( $query = false ) {

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
				'next_text' => esc_html__( '&rarr;', 'atomic' ),
				'prev_text' => esc_html__( '&larr;', 'atomic' )
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
 * @since atomic 1.0
 */
 if ( ! function_exists( 'atomic_post_navs' ) ) :
 function atomic_post_navs( $query = false ) {
 	// Previous/next post navigation.
 	$next_post = get_next_post();
 	$previous_post = get_previous_post();

 	the_post_navigation( array(
 		'next_text' => '<span class="meta-nav-text meta-title">' . esc_html__( 'Next:', 'atomic' ) . '</span> ' .
 		'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'atomic' ) . '</span> ' .
 		'<span class="post-title">%title</span>',
 		'prev_text' => '<span class="meta-nav-text meta-title">' . esc_html__( 'Previous:', 'atomic' ) . '</span> ' .
 		'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'atomic' ) . '</span> ' .
 		'<span class="post-title">%title</span>',
 	) );
 } endif;


/**
 * Author post widget
 *
 * @since 1.0
 */
if ( ! function_exists( 'atomic_author_box' ) ) :
function atomic_author_box() {
	global $post, $current_user;
	$author = get_userdata( $post->post_author );
	if ( $author && ! empty( $author->description ) ) {
	?>
	<div class="author-profile">

		<a class="author-profile-avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Posts by %s', 'atomic' ), get_the_author() ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'atomic_author_bio_avatar_size', 65 ) ); ?></a>

		<div class="author-profile-info">
			<h3 class="author-profile-title">
				<?php if ( is_archive() ) { ?>
					<?php echo esc_html( sprintf( esc_html__( 'All posts by %s', 'atomic' ), get_the_author() ) ); ?>
				<?php } else { ?>
					<?php echo esc_html( sprintf( esc_html__( 'Posted by %s', 'atomic' ), get_the_author() ) ); ?>
				<?php } ?>
			</h3>

			<div class="author-description">
				<p><?php the_author_meta( 'description' ); ?></p>
			</div>

			<div class="author-profile-links">
				<a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?>"><i class="fa fa-pencil-square-o"></i> <?php esc_html_e( 'All Posts', 'atomic' ); ?></a>

				<?php if ( $author->user_url ) { ?>
					<?php printf( '<a href="%1$s"><i class="fa fa-external-link"></i> %2$s</a>', esc_url( $author->user_url ), 'Website', 'atomic' ); ?>
				<?php } ?>
			</div>
		</div><!-- .author-drawer-text -->
	</div><!-- .author-profile -->

<?php } } endif;


/**
 * Count our number of active panels.
 *
 * Primarily used to see if we have any panels active, duh.
 */
function atomic_panel_count() {

	$panel_count = 0;

	/**
	 * Filter number of front page sections
	 */
	$num_sections = apply_filters( 'atomic_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		if ( get_theme_mod( 'panel_' . $i ) ) {
			$panel_count++;
		}
	}

	return $panel_count;
}


/**
 * Display a front page section.
 *
 * @param $partial WP_Customize_Partial Partial associated with a selective refresh request.
 * @param $id integer Front page section to display.
 */
function atomic_front_page_section( $partial = null, $id = 0 ) {
	if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
		// Find out the id and set it up during a selective refresh.
		global $atomiccounter;
		$id = str_replace( 'panel_', '', $partial->id );
		$atomiccounter = $id;
	}

	global $post; // Modify the global post object before setting up post data.
	global $atomiccounter;
	if ( get_theme_mod( 'panel_' . $id ) ) {
		global $post;
		$post = get_post( get_theme_mod( 'panel_' . $id ) );
		setup_postdata( $post );
		set_query_var( 'panel', $id );

		// grab post template value
		$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
		?>
		<div class="home-section container" id="panel<?php echo $atomiccounter; ?>">
			<div class="content-left">
				<header class="entry-header">
					<!-- Post title -->
					<h2 class="entry-title"><?php the_title(); ?></h2>

					<?php if( is_single() ) { atomic_post_byline(); } ?>

					<?php if ( has_excerpt() ) { ?>
						<div class="entry-subtitle">
							<?php
								atomic_remove_sharing();
								the_excerpt();
							?>
						</div>
					<?php } ?>

					<?php edit_post_link(); ?>
				</header>
			</div><!-- .content-left -->

			<div class="content-right">
				<?php
					// Retreive the homepage section templates
					if ( $page_template == 'templates/template-team.php' ) {
						get_template_part( 'template-parts/content-team' );
					} else if ( $page_template == 'templates/template-portfolio.php' ) {
						get_template_part( 'template-parts/content-portfolio' );
					} else if ( $page_template == 'templates/template-blog.php' ) {
						get_template_part( 'template-parts/content-blog' );
					} else if ( $page_template == 'templates/template-services.php' ) {
						get_template_part( 'template-parts/content-services' );
					} else if ( $page_template == 'templates/template-testimonials.php' ) {
						get_template_part( 'template-parts/content-testimonials' );
					} else {
						get_template_part( 'template-parts/content-section' );
					}

					wp_reset_postdata();
 				?>
			</div><!-- .content-right -->
		</div><!-- .home-section-->
		<?php

	} elseif ( is_customize_preview() ) {
		// The output placeholder anchor.
		echo '<article class="placeholder-section container" id="panel' . $id . '"><h2>' . sprintf( __( 'Section %1$s Placeholder', 'atomic' ), $id ) . '</h2></article>';
	}
}

function atomic_post_byline() { ?>
	<?php
		// Get the post author
		global $post;
		$author_id = $post->post_author;
	?>
	<p class="entry-byline">
		<!-- Create an avatar link -->
		<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'Posts by %s', 'atomic' ), get_the_author() ) ); ?>">
			<?php echo get_avatar( $author_id, apply_filters( 'atomic_author_bio_avatar', 44 ) ); ?>
		</a>

		<!-- Create an author post link -->
		<a class="entry-byline-author" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
			<?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?>
		</a>
		<span class="entry-byline-on"><?php esc_html_e( 'on', 'atomic' ); ?></span>
		<span class="entry-byline-date"><?php echo get_the_date(); ?></span>
	</p>
<?php }


/**
 * Get a list of child pages
 */
if ( ! function_exists( 'atomic_list_child_pages' ) ) :
function atomic_list_child_pages() {
	global $post;

	if ( is_page() && $post->post_parent ) {
		$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
	}

	if ( isset( $childpages ) ) {
		$string = '<ul class="meta-list">' . $childpages . '</ul>';
		return $string;
	}
}
endif;


/**
 * Modify the archive title prefix
 */
 function atomic_modify_archive_title( $title ) {
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
add_filter( 'get_the_archive_title', 'atomic_modify_archive_title' );
