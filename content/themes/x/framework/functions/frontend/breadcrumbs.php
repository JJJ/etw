<?php

// =============================================================================
// FUNCTIONS/GLOBAL/BREADCRUMBS.PHP
// -----------------------------------------------------------------------------
// Sets up the breadcrumb navigation for the theme.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Breadcrumbs Output
//   02. Breadcrumbs Output Items
//   03. Breadcrumbs Data
// =============================================================================

// Breadcrumbs Output
// =============================================================================

if ( ! function_exists( 'x_breadcrumbs' ) ) :

  function x_breadcrumbs() {

    $args_items = array(
      'item_before'      => '',
      'item_after'       => '',
      'label_before'     => '',
      'label_after'      => '',
      'delimiter_before' => ' <span class="delimiter">',
      'delimiter_after'  => '</span> ',
      'delimiter_ltr'    => '<i class="x-icon-angle-right" data-x-icon-s="&#xf105;"></i>',
      'delimiter_rtl'    => '<i class="x-icon-angle-left" data-x-icon-s="&#xf104;"></i>',
      'current_class'    => 'current',
      'anchor_atts'      => array(),
      'include_meta'     => false,
    );

    $args_data = array(
      'home_label' => '<span class="home"><i class="x-icon-home" data-x-icon-s="&#xf015;"></i></span>',
    );

    if ( x_get_option( 'x_breadcrumb_display' ) ) {
      echo '<div class="x-breadcrumbs">' . x_breadcrumbs_items( x_breadcrumbs_data( $args_data ), $args_items ) . '</div>';
    }

  }

else :

  // Deprecated Functions
  // --------------------
  // Kept for legacy purposes. If a user happens to have x_breadcrumbs()
  // overwritten in a child theme from an older release that was using these
  // functions, then a fatal error could occur if they do not exist. Going
  // forward, if updates need to be made to breadcrumbs, we suggest looking
  // into the various $args and filters available for x_breadcrumbs_data() and
  // x_breadcrumbs_items(), which should give you all of the control you need
  // without having to overwrite the function directly.

  if ( ! function_exists( 'x_get_breadcrumb_delimiter' ) ) :
    function x_get_breadcrumb_delimiter() {
      $is_ltr = ! is_rtl();
      return ' <span class="delimiter"><i class="x-icon-angle-' . ( ( $is_ltr ) ? 'right' : 'left' ) . '" data-x-icon-s="&#x' . ( ( $is_ltr ) ? 'f105' : 'f104' ) . ';"></i></span> ';
    }
  endif;

  if ( ! function_exists( 'x_get_breadcrumb_home_text' ) ) :
    function x_get_breadcrumb_home_text() {
      return '<span class="home"><i class="x-icon-home" data-x-icon-s="&#xf015;"></i></span>';
    }
  endif;

  if ( ! function_exists( 'x_get_breadcrumb_current_before' ) ) :
    function x_get_breadcrumb_current_before() {
      return '<span class="current">';
    }
  endif;

  if ( ! function_exists( 'x_get_breadcrumb_current_after' ) ) :
    function x_get_breadcrumb_current_after() {
      return '</span>';
    }
  endif;

endif;



// Breadcrumbs Output Items
// =============================================================================

if ( ! function_exists( 'x_breadcrumbs_items' ) ) :
  function x_breadcrumbs_items( $data, $args = array() ) {

    $args = apply_filters( 'x_breadcrumbs_items_args', wp_parse_args( $args, array(
      'item_before'      => '<li class="x-crumbs-list-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">',
      'item_after'       => '</li>',
      'label_before'     => '<span itemprop="name">',
      'label_after'      => '</span>',
      'delimiter_before' => '<span class="x-crumbs-delimiter">',
      'delimiter_after'  => '</span>',
      'delimiter_ltr'    => '&rarr;',
      'delimiter_rtl'    => '&larr;',
      'current_class'    => 'x-crumbs-current',
      'anchor_atts'      => array( 'class' => 'x-crumbs-link', 'itemscope' => '', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item' ),
      'include_meta'     => true,
    ) ) );

    $output           = '';
    $breadcrumbs      = $data;
    $breadcrumb_count = count( $breadcrumbs );
    $delimiter        = ( is_rtl() ) ? $args['delimiter_rtl'] : $args['delimiter_ltr'];
    $delimiter_markup = ( empty( $delimiter ) ) ? '' : $args['delimiter_before'] . $delimiter . $args['delimiter_after'];

    $i = 1;

    foreach ( $breadcrumbs as $breadcrumb ) {

      $args['anchor_atts']['href'] = $breadcrumb['url'];

      if ( $i === $breadcrumb_count ) {
        if ( isset( $args['anchor_atts']['class'] ) ) {
          $args['anchor_atts']['class'] .= ' ' . $args['current_class'];
        } else {
          $args['anchor_atts']['class'] = $args['current_class'];
        }
        $args['anchor_atts']['title'] = __( 'You Are Here', '__x__' );
      }

      $output .= $args['item_before'];
        $output .= '<a ' . x_atts( $args['anchor_atts'] ) . '>';
          $output .= $args['label_before'] . $breadcrumb['label'] . $args['label_after'];
        $output .= '</a>';
        if ( $i !== $breadcrumb_count ) {
          $output .= $delimiter_markup;
        }
        if ( $args['include_meta'] ) {
          $output .= '<meta itemprop="position" content="' . $i . '">';
        }
      $output .= $args['item_after'];

      $i++;

    }

    return apply_filters( 'x_breadcrumbs_items', $output, $args );

  }
endif;



// Breadcrumbs Data
// =============================================================================

if ( ! function_exists( 'x_breadcrumbs_data' ) ) :
  function x_breadcrumbs_data( $args = array() ) {

    GLOBAL $wp;


    // Label - Blog
    // ------------

    $page_for_posts_id = get_option( 'page_for_posts' );
    $blog_label        = __( 'Blog', '__x__' );

    if ( ! $page_for_posts_id ) {

      $stack = function_exists('x_get_stack') ? x_get_stack() : '';

      if ( 'integrity' === $stack ) {
        $blog_label = x_get_option('x_integrity_blog_title', $blog_label );
      } elseif ( 'renew' === $stack ) {
        $blog_label = x_get_option('x_renew_blog_title', $blog_label );
      }

    } else {
      $blog_label = get_the_title( $page_for_posts_id );
    }


    // Label - Shop
    // ------------

    $shop_label = '';

    if ( X_WOOCOMMERCE_IS_ACTIVE ) {
      if ( function_exists( 'wc_get_page_id' ) ) {
        $shop_label = get_the_title( wc_get_page_id( 'shop' ) );
      } else {
        $shop_label = get_the_title( woocommerce_get_page_id( 'shop' ) );
      }
    }


    // Label - Events
    // --------------

    $events_label = '';

    if ( X_MEC_IS_ACTIVE ) {
      $events_options = get_option( 'mec_options' );
      $events_label   = $events_options['settings']['archive_title'];
    }


    // Data Args
    // ---------

    $args = apply_filters( 'x_breadcrumbs_data_args', wp_parse_args( $args, array(
      'home_label'            => __( 'Home', '__x__' ),
      'blog_label'            => $blog_label,
      'search_label'          => __( 'Search Results', '__x__' ),
      '404_label'             => __( '404 (Page Not Found)', '__x__' ),
      'shop_label'            => $shop_label,
      'portfolio_label'       => x_get_parent_portfolio_title(),
      'events_label'          => $events_label,
      'archive_default_label' => __( 'Archives', '__x__' ),
    ) ) );


    // Begin Breadcrumbs
    // -----------------

    $crumbs = array(
      array(
        'type'  => 'home',
        'url'   => home_url( '/' ),
        'label' => $args['home_label'],
      )
    );

    if ( is_front_page() ) {
      return $crumbs;
    }

    $q_obj = get_queried_object();


    // Add Breadcrumbs
    // ---------------

    if ( is_home() ) {

      $crumbs[] = array(
        'type'  => 'blog',
        'url'   => get_permalink( get_option( 'page_for_posts' ) ),
        'label' => $args['blog_label'],
      );

    } elseif ( is_search() ) {

      $crumbs[] = array(
        'type'  => 'search',
        'url'   => add_query_arg( $wp->query_string, '', home_url( '/' ) ),
        'label' => $args['search_label'],
      );

    } elseif ( is_404() ) {

      $crumbs[] = array(
        'type'  => '404',
        'url'   => home_url( $wp->request . '/' ),
        'label' => $args['404_label'],
      );

    } elseif ( is_author() ) {

      GLOBAL $author;

      $crumbs[] = array(
        'type'  => 'author',
        'url'   => get_author_posts_url( $author ),
        'label' => __( 'Posts by ', '__x__' ) . '&#8220;' . get_the_author() . '&#8221;',
      );

    } elseif ( x_is_buddypress() ) {

      if ( bp_is_group() ) {

        $crumbs[] = array(
          'type'  => 'bp_group',
          'url'   => bp_get_groups_directory_permalink(),
          'label' => x_get_option( 'x_buddypress_groups_title' ),
        );

      } elseif ( bp_is_user() ) {

        $crumbs[] = array(
          'type'  => 'bp_user',
          'url'   => bp_get_members_directory_permalink(),
          'label' => x_get_option( 'x_buddypress_members_title' ),
        );

      }

      $crumbs[] = array(
        'type'  => 'bp',
        'url'   => home_url( $wp->request . '/' ),
        'label' => x_buddypress_get_the_title(),
      );

    } elseif ( x_is_bbpress() ) {

      add_filter( 'bbp_get_breadcrumb', 'x_bbpress_get_breadcrumb', 10, 2 );
      remove_filter( 'bbp_no_breadcrumb', '__return_true' );

      if ( bbp_is_forum_archive() ) {

        $crumbs[] = array(
          'type'  => 'bbp',
          'url'   => home_url( $wp->request . '/' ),
          'label' => bbp_get_forum_archive_title(),
        );

      } else {

        $bbpress_crumbs      = bbp_get_breadcrumb();
        $final_bbpress_crumb = array_pop( $bbpress_crumbs );

        foreach ( $bbpress_crumbs as $bbpress_crumb ) {

          preg_match( '/<a.+?href="(.+?)".*?class="(.*?)".*?>(.*?)<\/a>/', $bbpress_crumb, $matches );

          $crumbs[] = array(
            'type'  => isset( $matches[2] ) ? $matches[2] : '',
            'url'   => isset( $matches[1] ) ? $matches[1] : '',
            'label' => isset( $matches[3] ) ? $matches[3] : '',
          );

        }

        $crumbs[] = array(
          'type'  => 'bbp-current',
          'url'   => home_url( $wp->request . '/' ),
          'label' => $final_bbpress_crumb,
        );

      }

      add_filter( 'bbp_no_breadcrumb', '__return_true' );
      remove_filter( 'bbp_get_breadcrumb', 'x_bbpress_get_breadcrumb', 10,2 );

    } elseif ( ! empty( $q_obj ) ) {

      // Notes
      // -----
      // Each block checks for and adds an archive index link (if present),
      // ancestor links (if present), and the current page.
      //
      // 01. Archive.
      // 02. Post types.
      // 03. Taxonomies.

      if ( property_exists( $q_obj, 'name' ) && property_exists( $q_obj, 'label' ) ) { // 01

        switch ( $q_obj->name ) {
          case 'post' :
            $archive_label = $args['blog_label'];
            break;
          case 'product' :
            $archive_label = $args['shop_label'];
            break;
          case 'x-portfolio' :
            $archive_label = $args['portfolio_label'];
            break;
          case 'mec-events' :
            $archive_label = $args['events_label'];
            break;
          default :
            $archive_label = $q_obj->label;
            break;
        }

        $crumbs[] = array(
          'type'  => 'archive',
          'url'   => get_post_type_archive_link( $q_obj->name ),
          'label' => $archive_label,
        );

      } elseif ( property_exists( $q_obj, 'post_parent' ) ) { // 02

        $ancestor_archive_link = get_post_type_archive_link( $q_obj->post_type );

        if ( $ancestor_archive_link ) {

          switch ( $q_obj->post_type ) {
            case 'post' :
              $ancestor_archive_label = $args['blog_label'];
              break;
            case 'product' :
              $ancestor_archive_label = $args['shop_label'];
              break;
            case 'x-portfolio' :
              $ancestor_archive_link  = x_get_parent_portfolio_link();
              $ancestor_archive_label = $args['portfolio_label'];
              break;
            case 'mec-events' :
              $ancestor_archive_label = $args['events_label'];
              break;
            default :
              $post_type_obj          = get_post_type_object( $q_obj->post_type );
              $ancestor_archive_label = $post_type_obj->label;
              break;
          }

          $crumbs[] = array(
            'type'  => 'archive',
            'url'   => $ancestor_archive_link,
            'label' => $ancestor_archive_label,
          );

        }

        $post_ancestors = array_reverse( get_ancestors( $q_obj->ID, $q_obj->post_type, 'post_type' ) );

        foreach ( $post_ancestors as $ancestor_id ) {
          $crumbs[] = array(
            'type'  => $q_obj->post_type,
            'url'   => get_permalink( $ancestor_id ),
            'label' => get_the_title( $ancestor_id ),
          );
        }

        $crumbs[] = array(
          'type'  => $q_obj->post_type,
          'url'   => get_permalink( $q_obj->ID ),
          'label' => $q_obj->post_title,
        );

      } elseif ( property_exists( $q_obj, 'parent' ) ) { // 03

        $archive_tax = get_taxonomy( $q_obj->taxonomy );

        if ( $archive_tax ) {

          foreach ( $archive_tax->object_type as $archive_post_type ) {

            $ancestor_archive_link = get_post_type_archive_link( $archive_post_type );

            if ( $ancestor_archive_link ) {

              switch ( $archive_post_type ) {
                case 'post' :
                  $ancestor_archive_label = $args['blog_label'];
                  break;
                case 'product' :
                  $ancestor_archive_label = $args['shop_label'];
                  break;
                case 'x-portfolio' :
                  $ancestor_archive_link  = x_get_parent_portfolio_link();
                  $ancestor_archive_label = $args['portfolio_label'];
                  break;
                case 'mec-events' :
                  $ancestor_archive_label = $args['events_label'];
                  break;
                default :
                  $post_type_obj          = get_post_type_object( $archive_post_type );
                  $ancestor_archive_label = $post_type_obj->label;
                  break;
              }

              $crumbs[] = array(
                'type'  => 'archive',
                'url'   => $ancestor_archive_link,
                'label' => $ancestor_archive_label,
              );

            }

          }

        }

        $tax_ancestors = array_reverse( get_ancestors( $q_obj->term_id, $q_obj->taxonomy, 'taxonomy' ) );

        foreach ( $tax_ancestors as $ancestor_id ) {
          $term     = get_term( $ancestor_id );
          $crumbs[] = array(
            'type'  => $q_obj->taxonomy . '_' . $q_obj->slug,
            'url'   => get_term_link( $term->term_id ),
            'label' => $term->name,
          );
        }

        $crumbs[] = array(
          'type'  => $q_obj->taxonomy . '_' . $q_obj->slug,
          'url'   => get_term_link( $q_obj->term_id ),
          'label' => $q_obj->name,
        );

      }

    } elseif ( is_date() ) {

      $y = get_query_var( 'year' );
      $m = get_query_var( 'monthnum' );
      $d = get_query_var( 'day' );

      if ( $y != 0 ) {
        $crumbs[] = array(
          'type'  => 'year',
          'url'   => get_year_link( $y ),
          'label' => $y,
        );
      }

      if ( $m != 0 ) {
        $crumbs[] = array(
          'type'  => 'month',
          'url'   => get_month_link( $y, $m ),
          'label' => get_the_date( 'F' ),
        );
      }

      if ( $d != 0 ) {
        $crumbs[] = array(
          'type'  => 'day',
          'url'   => get_day_link( $y, $m, $d ),
          'label' => $d,
        );
      }

    } elseif ( is_archive() ) {

      $crumbs[] = array(
        'type'  => 'archive_default',
        'url'   => home_url( $wp->request . '/' ),
        'label' => $args['archive_default_label'],
      );

    }


    // Output
    // ------

    return apply_filters( 'x_breadcrumbs_data', $crumbs, $args );

  }

  function x_bbpress_get_breadcrumb( $trail, $crumbs ) {
    return $crumbs;
  }
endif;
