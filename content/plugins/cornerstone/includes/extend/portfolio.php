<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PORTFOLIO.PHP
// -----------------------------------------------------------------------------
// Add Portfolio functionality for use with themes that enable it.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
// 01. Register Custom Post Type
// 02. Get the Page Link to First Portfolio Page
// 03. Get Parent Portfolio Link
// 04. Get Parent Portfolio Title
// 05. Output Portfolio Filters
// 06. Output Portfolio Item Project Link
// 07. Output Portfolio Item Tags
// 08. Output Portfolio Item Social
// 09. Portfolio Page Template Precedence
// 10. Portfolio Filter Shortcode
// 11. Theme Options
// 12. Meta Boxes
// =============================================================================

// Register Custom Post Type
// =============================================================================

function cs_portfolio_init() {

  $slug      = sanitize_title( x_get_option( 'x_custom_portfolio_slug' ) );

  //
  // Enable the custom post type.
  //

  $args = array(
    'labels'          => array(
      'name'               => __( 'Portfolio', 'cornerstone' ),
      'singular_name'      => __( 'Portfolio Item', 'cornerstone' ),
      'add_new'            => __( 'Add New Item', 'cornerstone' ),
      'add_new_item'       => __( 'Add New Portfolio Item', 'cornerstone' ),
      'edit_item'          => __( 'Edit Portfolio Item', 'cornerstone' ),
      'new_item'           => __( 'Add New Portfolio Item', 'cornerstone' ),
      'view_item'          => __( 'View Item', 'cornerstone' ),
      'search_items'       => __( 'Search Portfolio', 'cornerstone' ),
      'not_found'          => __( 'No portfolio items found', 'cornerstone' ),
      'not_found_in_trash' => __( 'No portfolio items found in trash', 'cornerstone' )
    ),
    'public'          => true,
    'show_ui'         => true,
    'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'author', 'custom-fields', 'revisions' ),
    'capability_type' => 'post',
    'hierarchical'    => false,
    'rewrite'         => array( 'slug' => $slug, 'with_front' => false ),
    'menu_position'   => 5,
    'menu_icon'       => 'dashicons-format-gallery',
    'has_archive'     => true
  );

  register_post_type( 'x-portfolio', apply_filters( 'portfolioposttype_args', $args ) );


  //
  // Portfolio tags taxonomy.
  //

  $taxonomy_portfolio_tag_args = array(
    'labels'           => array(
      'name'                       => __( 'Portfolio Tags', 'cornerstone' ),
      'singular_name'              => __( 'Portfolio Tag', 'cornerstone' ),
      'search_items'               => __( 'Search Portfolio Tags', 'cornerstone' ),
      'popular_items'              => __( 'Popular Portfolio Tags', 'cornerstone' ),
      'all_items'                  => __( 'All Portfolio Tags', 'cornerstone' ),
      'parent_item'                => __( 'Parent Portfolio Tag', 'cornerstone' ),
      'parent_item_colon'          => __( 'Parent Portfolio Tag:', 'cornerstone' ),
      'edit_item'                  => __( 'Edit Portfolio Tag', 'cornerstone' ),
      'update_item'                => __( 'Update Portfolio Tag', 'cornerstone' ),
      'add_new_item'               => __( 'Add New Portfolio Tag', 'cornerstone' ),
      'new_item_name'              => __( 'New Portfolio Tag Name', 'cornerstone' ),
      'separate_items_with_commas' => __( 'Separate portfolio tags with commas', 'cornerstone' ),
      'add_or_remove_items'        => __( 'Add or remove portfolio tags', 'cornerstone' ),
      'choose_from_most_used'      => __( 'Choose from the most used portfolio tags', 'cornerstone' ),
      'menu_name'                  => __( 'Portfolio Tags', 'cornerstone' )
    ),
    'public'            => true,
    'show_in_nav_menus' => true,
    'show_ui'           => true,
    'show_tagcloud'     => true,
    'hierarchical'      => false,
    'rewrite'           => array( 'slug' => $slug . '-tag', 'with_front' => false ),
    'show_admin_column' => true,
    'query_var'         => true
  );

  register_taxonomy( 'portfolio-tag', array( 'x-portfolio' ), $taxonomy_portfolio_tag_args );


  //
  // Portfolio categories taxonomy.
  //

  $taxonomy_portfolio_category_args = array(
    'labels'            => array(
      'name'                       => __( 'Portfolio Categories', 'cornerstone' ),
      'singular_name'              => __( 'Portfolio Category', 'cornerstone' ),
      'search_items'               => __( 'Search Portfolio Categories', 'cornerstone' ),
      'popular_items'              => __( 'Popular Portfolio Categories', 'cornerstone' ),
      'all_items'                  => __( 'All Portfolio Categories', 'cornerstone' ),
      'parent_item'                => __( 'Parent Portfolio Category', 'cornerstone' ),
      'parent_item_colon'          => __( 'Parent Portfolio Category:', 'cornerstone' ),
      'edit_item'                  => __( 'Edit Portfolio Category', 'cornerstone' ),
      'update_item'                => __( 'Update Portfolio Category', 'cornerstone' ),
      'add_new_item'               => __( 'Add New Portfolio Category', 'cornerstone' ),
      'new_item_name'              => __( 'New Portfolio Category Name', 'cornerstone' ),
      'separate_items_with_commas' => __( 'Separate portfolio categories with commas', 'cornerstone' ),
      'add_or_remove_items'        => __( 'Add or remove portfolio categories', 'cornerstone' ),
      'choose_from_most_used'      => __( 'Choose from the most used portfolio categories', 'cornerstone' ),
      'menu_name'                  => __( 'Portfolio Categories', 'cornerstone' ),
    ),
    'public'            => true,
    'show_in_nav_menus' => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'show_tagcloud'     => true,
    'hierarchical'      => true,
    'rewrite'           => array( 'slug' => $slug . '-category', 'with_front' => false ),
    'query_var'         => true
  );

  register_taxonomy( 'portfolio-category', array( 'x-portfolio' ), $taxonomy_portfolio_category_args );


  //
  // Flush rewrite rules if portfolio slug is updated.
  //

  if ( get_transient( 'cs_portfolio_slug_before' ) != get_transient( 'cs_portfolio_slug_after' ) ) {
    flush_rewrite_rules( false );
    delete_transient( 'cs_portfolio_slug_before' );
    delete_transient( 'cs_portfolio_slug_after' );
  }

}

add_action( 'init', 'cs_portfolio_init' );



// Get the Page Link to First Portfolio Page
// =============================================================================

function cs_get_first_portfolio_page() {

  $results = get_pages( array(
    'meta_key'    => '_wp_page_template',
    'meta_value'  => 'template-layout-portfolio.php',
    'sort_order'  => 'ASC',
    'sort_column' => 'ID'
  ) );

  if ( count($results) > 0 && is_a( $results[0], 'WP_Post' ) ) {
    return $results[0];
  }

  return NULL;

}



// Get Parent Portfolio Link
// =============================================================================

function cs_get_parent_portfolio_link() {

  $portfolio_parent_id = get_post_meta( get_the_ID(), '_x_portfolio_parent', true );

  if ( $portfolio_parent_id && $portfolio_parent_id !== 'Default' ) {
    return get_permalink( $portfolio_parent_id );
  }

  $first_portfolio_page = cs_get_first_portfolio_page();

  if ( $first_portfolio_page ) {
    return get_page_link( $first_portfolio_page );
  }

  return '';

}



// Get Parent Portfolio Title
// =============================================================================

function cs_get_parent_portfolio_title() {

  $portfolio_parent_id = get_post_meta( get_the_ID(), '_x_portfolio_parent', true );

  if ( $portfolio_parent_id && $portfolio_parent_id !== 'Default' ) {
    return get_the_title( $portfolio_parent_id );
  }

  $first_portfolio_page = cs_get_first_portfolio_page();

  if ( $first_portfolio_page ) {
    return $first_portfolio_page->post_title;
  }

  return '';

}



// Output Portfolio Filters
// =============================================================================

function cs_portfolio_filters() {

  $stack           = x_get_stack();
  $filters         = get_post_meta( get_the_ID(), '_x_portfolio_category_filters', true );
  $disable_filters = get_post_meta( get_the_ID(), '_x_portfolio_disable_filtering', true );
  $one_filter      = count( $filters ) == 1;
  $all_categories  = in_array( 'All Categories', $filters );

  //
  // 1. If one filter is selected and that filter is "All Categories."
  // 2. If more than one category filter is selected.
  //

  if ( $one_filter && $all_categories ) { // 1

    $terms = get_terms( 'portfolio-category' );

  } else { // 2

    $terms = array();
    foreach ( $filters as $filter ) {
      $parent   = array( $filter );
      $children = get_term_children( $filter, 'portfolio-category' );
      $terms    = array_merge( $parent, $terms );
      $terms    = array_merge( $children, $terms );
    }
    $terms = get_terms( 'portfolio-category', array( 'include' => $terms ) );

  }


  //
  // Main filter button content.
  //

  if ( $stack == 'integrity' ) {
    $button_content = '<i class="x-icon-sort" data-x-icon-s="&#xf0dc;"></i> <span>' . x_get_option( 'x_integrity_portfolio_archive_sort_button_text' ) . '</span>';
  } elseif ( $stack == 'ethos' ) {
    $button_content = '<i class="x-icon-chevron-down" data-x-icon-s="&#xf078;"></i>';
  } else {
    $button_content = '<i class="x-icon-plus" data-x-icon-s="&#xf067;"></i>';
  }


  //
  // Filters.
  //

  if ( $disable_filters != 'on' ) {
    if ( $stack != 'ethos' ) {

    ?>

      <ul class="option-set unstyled" data-option-key="filter">
        <li>
          <a href="#" class="x-portfolio-filters"><?php echo $button_content; ?></a>
          <ul class="x-portfolio-filters-menu unstyled">
            <li><a href="#" data-option-value="*" class="x-portfolio-filter selected"><?php _e( 'All', 'cornerstone' ); ?></a></li>
            <?php foreach ( $terms as $term ) { ?>
              <li><a href="#" data-option-value=".x-portfolio-<?php echo md5( $term->slug ); ?>" class="x-portfolio-filter"><?php echo $term->name; ?></a></li>
            <?php } ?>
          </ul>
        </li>
      </ul>

    <?php } elseif ( $stack == 'ethos' ) { ?>

      <ul class="option-set unstyled" data-option-key="filter">
        <li>
          <a href="#" class="x-portfolio-filters cf">
            <span class="x-portfolio-filter-label"><?php _e( 'Filter by Category', 'cornerstone' ); ?></span>
            <?php echo $button_content; ?>
          </a>
          <ul class="x-portfolio-filters-menu unstyled">
            <li><a href="#" data-option-value="*" class="x-portfolio-filter selected"><?php _e( 'All', 'cornerstone' ); ?></a></li>
            <?php foreach ( $terms as $term ) { ?>
              <li><a href="#" data-option-value=".x-portfolio-<?php echo md5( $term->slug ); ?>" class="x-portfolio-filter"><?php echo $term->name; ?></a></li>
            <?php } ?>
          </ul>
        </li>
      </ul>

    <?php

    }
  }

}



// Output Portfolio Item Project Link
// =============================================================================

function cs_portfolio_item_project_link() {

  $project_link  = get_post_meta( get_the_ID(), '_x_portfolio_project_link', true );
  $launch_title  = x_get_option( 'x_portfolio_launch_project_title' );
  $launch_button = x_get_option( 'x_portfolio_launch_project_button_text' );

  if ( $project_link ) :

  ?>

  <h2 class="h-extra launch"><?php echo $launch_title; ?></h2>
  <a href="<?php echo $project_link; ?>" title="<?php echo $launch_button; ?>" class="x-btn x-btn-block" <?php x_output_target_blank(); ?>><?php echo $launch_button; ?></a>

  <?php

  endif;

}



// Output Portfolio Item Tags
// =============================================================================

function cs_portfolio_item_tags() {

  $stack     = x_get_stack();
  $tag_title = x_get_option( 'x_portfolio_tag_title' );

  if ( has_term( NULL, 'portfolio-tag', NULL ) ) :

    echo '<h2 class="h-extra skills">' . $tag_title . '</h2>';
    call_user_func( 'x_' . $stack . '_portfolio_tags');

  endif;

}



// Output Portfolio Item Social
// =============================================================================

function cs_portfolio_item_social() {

  $share_project_title = x_get_option( 'x_portfolio_share_project_title' );
  $enable_facebook     = x_get_option( 'x_portfolio_enable_facebook_sharing' );
  $enable_twitter      = x_get_option( 'x_portfolio_enable_twitter_sharing' );
  $enable_google_plus  = x_get_option( 'x_portfolio_enable_google_plus_sharing' );
  $enable_linkedin     = x_get_option( 'x_portfolio_enable_linkedin_sharing' );
  $enable_pinterest    = x_get_option( 'x_portfolio_enable_pinterest_sharing' );
  $enable_reddit       = x_get_option( 'x_portfolio_enable_reddit_sharing' );
  $enable_email        = x_get_option( 'x_portfolio_enable_email_sharing' );

  $share_url     = urlencode( get_permalink() );
  $share_title   = urlencode( get_the_title() );
  $share_source  = urlencode( get_bloginfo( 'name' ) );
  $share_content = urlencode( get_the_excerpt() );
  $share_image   = urlencode( x_get_featured_image_with_fallback_url() );

  $facebook    = ( $enable_facebook == '1' )    ? "<a href=\"#share\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-trigger=\"hover\" class=\"x-share\" title=\"" . __( 'Share on Facebook', 'cornerstone' ) . "\" onclick=\"window.open('http://www.facebook.com/sharer.php?u={$share_url}&amp;t={$share_title}', 'popupFacebook', 'width=650, height=270, resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0'); return false;\"><i class=\"x-icon-facebook-square\" data-x-icon-b=\"&#xf082;\"></i></a>" : '';
  $twitter     = ( $enable_twitter == '1' )     ? "<a href=\"#share\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-trigger=\"hover\" class=\"x-share\" title=\"" . __( 'Share on Twitter', 'cornerstone' ) . "\" onclick=\"window.open('https://twitter.com/intent/tweet?text={$share_title}&amp;url={$share_url}', 'popupTwitter', 'width=500, height=370, resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0'); return false;\"><i class=\"x-icon-twitter-square\" data-x-icon-b=\"&#xf081;\"></i></a>" : '';
  $google_plus = ( $enable_google_plus == '1' ) ? "<a href=\"#share\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-trigger=\"hover\" class=\"x-share\" title=\"" . __( 'Share on Google+', 'cornerstone' ) . "\" onclick=\"window.open('https://plus.google.com/share?url={$share_url}', 'popupGooglePlus', 'width=650, height=226, resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0'); return false;\"><i class=\"x-icon-google-plus-square\" data-x-icon-b=\"&#xf0d4;\"></i></a>" : '';
  $linkedin    = ( $enable_linkedin == '1' )    ? "<a href=\"#share\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-trigger=\"hover\" class=\"x-share\" title=\"" . __( 'Share on LinkedIn', 'cornerstone' ) . "\" onclick=\"window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url={$share_url}&amp;title={$share_title}&amp;summary={$share_content}&amp;source={$share_source}', 'popupLinkedIn', 'width=610, height=480, resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0'); return false;\"><i class=\"x-icon-linkedin-square\" data-x-icon-b=\"&#xf08c;\"></i></a>" : '';
  $pinterest   = ( $enable_pinterest == '1' )   ? "<a href=\"#share\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-trigger=\"hover\" class=\"x-share\" title=\"" . __( 'Share on Pinterest', 'cornerstone' ) . "\" onclick=\"window.open('http://pinterest.com/pin/create/button/?url={$share_url}&amp;media={$share_image}&amp;description={$share_title}', 'popupPinterest', 'width=750, height=265, resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0'); return false;\"><i class=\"x-icon-pinterest-square\" data-x-icon-b=\"&#xf0d3;\"></i></a>" : '';
  $reddit      = ( $enable_reddit == '1' )      ? "<a href=\"#share\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-trigger=\"hover\" class=\"x-share\" title=\"" . __( 'Share on Reddit', 'cornerstone' ) . "\" onclick=\"window.open('http://www.reddit.com/submit?url={$share_url}', 'popupReddit', 'width=875, height=450, resizable=0, toolbar=0, menubar=0, status=0, location=0, scrollbars=0'); return false;\"><i class=\"x-icon-reddit-square\" data-x-icon-b=\"&#xf1a2;\"></i></a>" : '';
  $email       = ( $enable_email == '1' )       ? "<a href=\"mailto:?subject=" . urlencode( get_the_title() ) . "&amp;body=" . urlencode( __( 'Hey, thought you might enjoy this! Check it out when you have a chance:', 'cornerstone' ) ) . " " . get_permalink() . "\" data-toggle=\"tooltip\" data-placement=\"bottom\" data-trigger=\"hover\" class=\"x-share email\" title=\"" . __( 'Share via Email', 'cornerstone' ) . "\"><span><i class=\"x-icon-envelope-square\" data-x-icon-s=\"&#xf199;\"></i></span></a>" : '';

  if ( $enable_facebook == '1' || $enable_twitter == '1' || $enable_google_plus == '1' || $enable_linkedin == '1' || $enable_pinterest == '1' || $enable_reddit == '1' || $enable_email == '1' ) :

    ?>

    <div class="x-entry-share man">
      <div class="x-share-options">
        <p><?php echo $share_project_title; ?></p>
        <?php echo $facebook . $twitter . $google_plus . $linkedin . $pinterest . $reddit . urldecode( $email ); ?>
      </div>
    </div>

    <?php

  endif;

}


// Portfolio Page Template Precedence
// =============================================================================

//
// Allows a user to set their Custom Portfolio Slug to the same value as their
// page slug. When the x-portfolio post type is found, it gives precedence to
// the portfolio template page instead of the archive page.
//

function cs_portfolio_page_template_precedence( $request ) {
  global $wp;

  if ( array_key_exists( 'post_type', $request ) && 'x-portfolio' == $request['post_type'] ) {
    if ( x_get_option( 'x_custom_portfolio_slug' ) === $wp->request && get_page_by_path( $wp->request ) ) {
      unset( $request['post_type'] );
      $request['pagename'] = $wp->request;
    }
  }

  return $request;

}

add_filter( 'request', 'cs_portfolio_page_template_precedence' );



// Portfolio Filter Shortcode
// =============================================================================

function cs_portfolio_filters_shortcode( $atts ) {

  ob_start();

  if ( get_post_meta( get_the_ID(), '_x_portfolio_category_filters', true ) ) {
    cs_portfolio_filters();
  }

  return ob_get_clean();

}

add_shortcode( 'cs_portfolio_filters', 'cs_portfolio_filters_shortcode' );
add_shortcode( 'x_portfolio_filters', 'cs_portfolio_filters_shortcode' );


// Theme Options
// =============================================================================


//
// Before Theme Options Save
//

function cs_theme_options_set_transients_before_save() {
  set_transient( 'cs_portfolio_slug_before', x_get_option( 'x_custom_portfolio_slug' ), 60 );
}

add_action( 'cs_theme_options_before_save', 'cs_theme_options_set_transients_before_save' );


//
// After Theme Options Save
//

function cs_theme_options_set_transients_after_save() {
  set_transient( 'cs_portfolio_slug_after', x_get_option( 'x_custom_portfolio_slug' ), 60 );
}

add_action( 'cs_theme_options_after_save', 'cs_theme_options_set_transients_after_save' );



// Meta Boxes
// =============================================================================

function cs_add_portfolio_item_meta_boxes() {

  if ( ! function_exists('x_register_meta_box') ) {
    return;
  }

  x_register_meta_box( array(
    'id'          => 'x-meta-box-portfolio-item',
    'title'       => __( 'Portfolio Item Settings', '__x__' ),
    'description' => __( 'Select the appropriate options for your portfolio item.', '__x__' ),
    'page'        => 'x-portfolio',
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
      array(
        'name' => __( 'Body CSS Class(es)', '__x__' ),
        'desc' => __( 'Add a custom CSS class to the &lt;body&gt; element. Separate multiple class names with a space.', '__x__' ),
        'id'   => '_x_entry_body_css_class',
        'type' => 'text',
        'std'  => ''
      ),
      array(
        'name' => __( 'Alternate Index Title', '__x__' ),
        'desc' => __( 'Filling out this text input will replace the standard title on all index pages (i.e. blog, category archives, search, et cetera) with this one.', '__x__' ),
        'id'   => '_x_entry_alternate_index_title',
        'type' => 'text',
        'std'  => ''
      ),
      array(
        'name' => __( 'Portfolio Parent', '__x__' ),
        'desc' => __( 'Assign the parent portfolio page for this portfolio item. This will be used in various places throughout the theme such as your breadcrumbs. If "Default" is selected then the first page with the "Layout - Portfolio" template assigned to it will be used.', '__x__' ),
        'id'   => '_x_portfolio_parent',
        'type' => 'select-portfolio-parent',
        'std'  => 'Default'
      ),
      array(
        'name'    => __( 'Media Type', '__x__' ),
        'desc'    => __( 'Select which kind of media you want to display for your portfolio. If selecting a "Gallery," simply upload your images to this post and organize them in the order you want them to display.', '__x__' ),
        'id'      => '_x_portfolio_media',
        'type'    => 'radio',
        'std'     => 'Image',
        'options' => array( 'Image', 'Gallery', 'Video' )
      ),
      array(
        'name'    => __( 'Featured Content', '__x__' ),
        'desc'    => __( 'Select "Media" if you would like to show your video or gallery on the index page in place of the featured image. Note: will always use "Thumbnail" in Ethos due to Stack styling.', '__x__' ),
        'id'      => '_x_portfolio_index_media',
        'type'    => 'radio',
        'std'     => 'Thumbnail',
        'options' => array( 'Thumbnail', 'Media' )
      ),
      array(
        'name' => __( 'Project Link', '__x__' ),
        'desc' => __( 'Provide an external link to the project you worked on if one is available.', '__x__' ),
        'id'   => '_x_portfolio_project_link',
        'type' => 'text',
        'std'  => ''
      ),
      array(
        'name' => __( 'Background Image(s)', '__x__' ),
        'desc' => __( 'Click the button to upload your background image(s), or enter them in manually using the text field above. Loading multiple background images will create a slideshow effect. To clear, delete the image URLs from the text field and save your page.', '__x__' ),
        'id'   => '_x_entry_bg_image_full',
        'type' => 'uploader',
        'std'  => ''
      ),
      array(
        'name' => __( 'Background Image(s) Fade', '__x__' ),
        'desc' => __( 'Set a time in milliseconds for your image(s) to fade in. To disable this feature, set the value to "0."', '__x__' ),
        'id'   => '_x_entry_bg_image_full_fade',
        'type' => 'text',
        'std'  => '750'
      ),
      array(
        'name' => __( 'Background Images Duration', '__x__' ),
        'desc' => __( 'Only applicable if multiple images are selected, creating a background image slider. Set a time in milliseconds for your images to remain on screen.', '__x__' ),
        'id'   => '_x_entry_bg_image_full_duration',
        'type' => 'text',
        'std'  => '7500'
      )
    )
  ) );


  //
  // Video.
  //

  x_register_meta_box( array(
    'id'          => 'x-meta-box-portfolio-item-video',
    'title'       => __( 'Video Portfolio Item Settings', '__x__' ),
    'description' => __( 'These settings enable you to embed videos into your portfolio items.', '__x__' ),
    'page'        => 'x-portfolio',
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
      array(
        'name'    => __( 'Video Aspect Ratio', '__x__' ),
        'desc'    => __( 'If selecting "Video," choose the aspect ratio you would like for your video.', '__x__' ),
        'id'      => '_x_portfolio_aspect_ratio',
        'type'    => 'select',
        'std'     => '16:9',
        'options' => array( '16:9', '5:3', '5:4', '4:3', '3:2' )
      ),
      array(
        'name' => __( 'M4V File URL', '__x__' ),
        'desc' => __( 'If selecting "Video," place the URL to your .m4v video file here.', '__x__' ),
        'id'   => '_x_portfolio_m4v',
        'type' => 'text',
        'std'  => ''
      ),
      array(
        'name' => __( 'OGV File URL', '__x__' ),
        'desc' => __( 'If selecting "Video," place the URL to your .ogv video file here.', '__x__' ),
        'id'   => '_x_portfolio_ogv',
        'type' => 'text',
        'std'  => ''
      ),
      array(
        'name' => __( 'Embedded Video Code', '__x__' ),
        'desc' => __( 'If you are using something other than self hosted video such as YouTube, Vimeo, or Wistia, paste the embed code here. This field will override the above.', '__x__' ),
        'id'   => '_x_portfolio_embed',
        'type' => 'textarea',
        'std'  => ''
      )
    )
  ) );

}

add_action( 'add_meta_boxes', 'cs_add_portfolio_item_meta_boxes' );
