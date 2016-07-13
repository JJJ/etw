<?php
if ( ! defined( 'ABSPATH' ) )
	exit; //exit if accessed directly

function nm_is_news_archive( $datetype = '' ) {
	global $wp_query;

	if ( ! is_post_type_archive( 'news' ) )
		return FALSE;

	if ( $datetype === '' )
		return TRUE;

	if ( ! empty( $wp_query->query_vars['news_ondate'] ) ) {
		$date = explode( '/', $wp_query->query_vars['news_ondate'] );

		if ( (($a = count( $date )) === 1 && $datetype === 'year') || ($a === 2 && $datetype === 'month') || ($a === 3 && $datetype === 'day') )
			return TRUE;
	}

	return FALSE;
}

function nm_get_news_date_link( $year = 0, $month = 0, $day = 0 ) {
	global $wp_rewrite;

	$archive = get_post_type_archive_link( 'news' );

	$year = (int) $year;
	$month = (int) $month;
	$day = (int) $day;

	if ( $year === 0 && $month === 0 && $day === 0 )
		return $archive;

	$nm_year = $year;
	$nm_month = str_pad( $month, 2, '0', STR_PAD_LEFT );
	$nm_day = str_pad( $day, 2, '0', STR_PAD_LEFT );

	if ( $day !== 0 )
		$link_date = compact( 'nm_year', 'nm_month', 'nm_day' );
	elseif ( $month !== 0 )
		$link_date = compact( 'nm_year', 'nm_month' );
	else
		$link_date = compact( 'nm_year' );

	if ( ! empty( $archive ) && $wp_rewrite->using_mod_rewrite_permalinks() && ($permastruct = $wp_rewrite->get_extra_permastruct( 'news_ondate' )) ) {
		$archive = apply_filters( 'post_type_archive_link', home_url( str_replace( '%news_ondate%', implode( '/', $link_date ), $permastruct ) ), 'news' );
	} else
		$archive = add_query_arg( 'news_ondate', implode( '-', $link_date ), $archive );

	return apply_filters( 'nm_news_date_link', $archive );
}

function nm_get_taxonomy_name( $tax ) {
	$options = get_option( 'news_manager_general' );

	if ( $tax === 'category' ) {
		if ( $options['use_categories'] === TRUE ) {
			if ( $options['builtin_categories'] === FALSE )
				return 'news-category';
			else
				return 'category';
		} else
			return FALSE;
	}
	elseif ( $tax === 'tag' ) {
		if ( $options['use_tags'] === TRUE ) {
			if ( $options['builtin_tags'] === FALSE )
				return 'news-tag';
			else
				return 'post_tag';
		} else
			return FALSE;
	}
}

function nm_display_news_categories( $args = array() ) {
	if ( ($tax = nm_get_taxonomy_name( 'category' )) !== FALSE )
		return nm_get_news_taxonomy( $tax, $args );
	else
		return FALSE;
}

function nm_display_news_tags( $args = array() ) {
	if ( ($tax = nm_get_taxonomy_name( 'tag' )) !== FALSE )
		return nm_get_news_taxonomy( $tax, $args );
	else
		return FALSE;
}

function nm_get_news_taxonomy( $taxonomy = '', $args = array() ) {
	$defaults = array(
		'display_as_dropdown'	 => FALSE,
		'show_hierarchy'		 => TRUE,
		'order_by'				 => 'name',
		'order'					 => 'desc',
		'hide_empty'			 => TRUE
	);

	$args = array_merge( $defaults, $args );

	if ( $args['display_as_dropdown'] === FALSE ) {
		return wp_list_categories(
			array(
				'orderby'		 => $args['order_by'],
				'order'			 => $args['order'],
				'hide_empty'	 => $args['hide_empty'],
				'hierarchical'	 => (bool) $args['show_hierarchy'],
				'taxonomy'		 => $taxonomy,
				'echo'			 => FALSE,
				'style'			 => 'list',
				'title_li'		 => ''
			)
		);
	} else {
		return wp_dropdown_categories(
			array(
				'orderby'		 => $args['order_by'],
				'order'			 => $args['order'],
				'hide_empty'	 => $args['hide_empty'],
				'hierarchical'	 => (bool) $args['show_hierarchy'],
				'taxonomy'		 => $taxonomy,
				'hide_if_empty'	 => FALSE,
				'echo'			 => FALSE
			)
		);
	}
}

function nm_display_news_archives( $args = array() ) {
	global $wp_locale;

	$defaults = array(
		'display_as_dropdown'	 => FALSE,
		'show_post_count'		 => TRUE,
		'type'					 => 'monthly',
		'order'					 => 'desc',
		'limit'					 => 0
	);

	$archives = $counts = array();
	$args = array_merge( $defaults, $args );
	$cut = ($args['type'] === 'yearly' ? 4 : 7);

	$news = get_posts(
		array(
			'post_type'			 => 'news',
			'suppress_filters'	 => FALSE,
			'posts_per_page'	 => ($args['limit'] === 0 ? -1 : $args['limit'])
		)
	);

	foreach ( $news as $single_news ) {
		$start = substr( $single_news->post_date, 0, $cut );
		$archives[] = $start;

		if ( isset( $counts[$start] ) )
			$counts[$start] ++;
		else
			$counts[$start] = 1;
	}

	$archives = array_unique( $archives, SORT_STRING );
	natsort( $archives );

	$elem_m = ($args['display_as_dropdown'] === TRUE ? 'select' : 'ul');
	$elem_i = ($args['display_as_dropdown'] === TRUE ? '<option value="%s">%s%s</option>' : '<li><a href="%s">%s</a>%s</li>');
	$html = sprintf( '<%s>', $elem_m );

	foreach ( array_slice( ($args['order'] === 'desc' ? array_reverse( $archives ) : $archives ), 0, ($args['limit'] === 0 ? NULL : $args['limit'] ) ) as $archive ) {
		if ( $args['type'] === 'yearly' ) {
			$link = nm_get_news_date_link( $archive );
			$display = $archive;
		} else {
			$date = explode( '-', $archive );
			$link = nm_get_news_date_link( $date[0], $date[1] );
			$display = $wp_locale->get_month( $date[1] ) . ' ' . $date[0];
		}

		$html .= sprintf(
			$elem_i, $link, $display, ($args['show_post_count'] === TRUE ? ' (' . $counts[$archive] . ')' : '' )
		);
	}

	$html .= sprintf( '</%s>', $elem_m );

	return apply_filters( 'nm_display_news_archives', $html, $args );
}

function nm_display_news( $args = array() ) {
	$defaults = array(
		'number_of_news'		 => 5,
		'tags'					 => 'all',
		'categories'			 => 'all',
		'order_by'				 => 'publish',
		'order'					 => 'ASC',
		'show_news_thumbnail'	 => TRUE,
		'show_news_excerpt'		 => FALSE,
		'news_thumbnail_size'	 => 'thumbnail',
		'no_news_message'		 => __( 'No News found.', 'news-manager' )
	);

	$args = array_merge( $defaults, $args );

	$news_args = array(
		'post_type'			 => 'news',
		'suppress_filters'	 => FALSE,
		'posts_per_page'	 => ($args['number_of_news'] === 0 ? -1 : $args['number_of_news']),
		'order'				 => $args['order']
	);

	if ( ! empty( $args['tags'] ) ) {
		$news_args['tax_query'][] = array(
			'taxonomy'			 => nm_get_taxonomy_name( 'tag' ),
			'field'				 => 'id',
			'terms'				 => $args['tags'],
			'include_children'	 => FALSE,
			'operator'			 => 'IN'
		);
	}

	if ( ! empty( $args['categories'] ) ) {
		$news_args['tax_query'][] = array(
			'taxonomy'			 => nm_get_taxonomy_name( 'category' ),
			'field'				 => 'id',
			'terms'				 => $args['categories'],
			'include_children'	 => FALSE,
			'operator'			 => 'IN'
		);
	}

	if ( $args['order_by'] === 'publish' )
		$news_args['orderby'] = 'post_date';
	else
		$news_args['orderby'] = 'title';

	$news_args = apply_filters( 'nm_display_news_args', $news_args );
	$news = new WP_Query( $news_args );

	if ( $news->have_posts() ) {
		$html = '
		<ul>';

		while ( $news->have_posts() ) {
			$news->the_post();

			$html .= '
			<li>';

			if ( $args['show_news_thumbnail'] === TRUE && has_post_thumbnail() ) {
				$html .= '
				<span class="news-thumbnail post-thumbnail">
					' . get_the_post_thumbnail( $news->post->ID, $args['news_thumbnail_size'] ) . '
				</span><br />';
			}

			$html .= '
				<a class="news-title post-title" href="' . get_permalink() . '">' . get_the_title() . '</a><br />';

			$html .= '
				<span class="news-date post-date">
					<abbr class="dtstart" title="' . get_the_date() . '">' . get_the_date() . '</abbr>
				</span><br />';

			if ( $args['show_news_excerpt'] === TRUE )
				$html .= '
				<span class="news-excerpt post-excerpt">
					' . get_the_excerpt() . '
				</span>';

			$html .= '
			</li>';
		}

		$html .= '
		</ul>';
	} else
		$html = $args['no_news_message'];

	wp_reset_postdata();

	return apply_filters( 'nm_display_news', $html, $args );
}