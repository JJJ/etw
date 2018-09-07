<?php

// =============================================================================
// CONFIG/COMMON/SAMPLE-NAV.PHP
// -----------------------------------------------------------------------------
//
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Supported Keys
//   02. Navs
// =============================================================================

// Supported Keys
// =============================================================================

// 'title'       => '',
// 'description' => '',
// 'attr_title'  => '',
// 'target'      => '',
// 'xfn'         => '',
// 'url'         => '',
// 'classes'     => array(),
// 'meta'        => array(),



// Recycled Content
// =============================================================================

// Icons
// -----

$icon_home            = 'bookmark-o';
$icon_home_alt        = 'bookmark';

$icon_work            = 'folder-open-o';
$icon_work_alt        = 'folder-open';

$icon_project         = 'file-o';
$icon_project_1_alt   = 'file-image-o';
$icon_project_2_alt   = 'file-audio-o';
$icon_project_2_1_alt = 'file-text-o';
$icon_project_2_2_alt = 'file-archive-o';
$icon_project_3_alt   = 'file-video-o';

$icon_shop            = 'square-o';
$icon_shop_alt        = 'check-square';

$icon_blog            = 'file-o';
$icon_blog_alt        = 'file-text-o';

$icon_about           = 'circle-thin';
$icon_about_alt       = 'info-circle';

$icon_contact         = 'envelope-o';
$icon_contact_alt     = 'envelope';


// Images
// ------

$image_home        = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(244, 67, 54, 0.85)' );
$image_home_alt    = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(244, 67, 54, 0.35)' );

$image_work        = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(33, 150, 243, 0.85)' );
$image_work_alt    = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(33, 150, 243, 0.35)' );

$image_shop        = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(76, 175, 80, 0.85)' );
$image_shop_alt    = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(76, 175, 80, 0.35)' );

$image_blog        = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(63, 81, 181, 0.85)' );
$image_blog_alt    = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(63, 81, 181, 0.35)' );

$image_about       = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(255, 193, 7, 0.85)' );
$image_about_alt   = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(255, 193, 7, 0.35)' );

$image_contact     = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(156, 39, 176, 0.85)' );
$image_contact_alt = cornerstone_make_placeholder_image_uri( 48, 48, 'rgba(156, 39, 176, 0.35)' );

$image_w           = 48;
$image_h           = 48;



// Navs
// =============================================================================

return array(

  'default' => array(
    array(
      'title'       => 'Home',
      'description' => 'Start Here',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_home,
        'anchor_graphic_icon_alt'      => $icon_home_alt,
        'anchor_graphic_image_src'     => $image_home,
        'anchor_graphic_image_src_alt' => $image_home_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'Work',
      'description' => 'See Projects',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_work,
        'anchor_graphic_icon_alt'      => $icon_work_alt,
        'anchor_graphic_image_src'     => $image_work,
        'anchor_graphic_image_src_alt' => $image_work_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
      'children' => array(
        array(
          'title'       => 'Project 1',
          'description' => 'An Illustrative Blurb',
          'meta'        => array(
            'anchor_graphic_icon'          => $icon_project,
            'anchor_graphic_icon_alt'      => $icon_project_1_alt,
            'anchor_graphic_image_src'     => $image_work,
            'anchor_graphic_image_src_alt' => $image_work_alt,
            'anchor_graphic_image_width'   => $image_w,
            'anchor_graphic_image_height'  => $image_h,
          ),
        ),
        array(
          'title'       => 'Project 2',
          'description' => 'A Descriptive Line',
          'meta'        => array(
            'anchor_graphic_icon'          => $icon_project,
            'anchor_graphic_icon_alt'      => $icon_project_2_alt,
            'anchor_graphic_image_src'     => $image_work,
            'anchor_graphic_image_src_alt' => $image_work_alt,
            'anchor_graphic_image_width'   => $image_w,
            'anchor_graphic_image_height'  => $image_h,
          ),
          'children' => array(
            array(
              'title'       => 'About',
              'description' => 'Learn More',
              'meta'        => array(
                'anchor_graphic_icon'          => $icon_project,
                'anchor_graphic_icon_alt'      => $icon_project_2_1_alt,
                'anchor_graphic_image_src'     => $image_work,
                'anchor_graphic_image_src_alt' => $image_work_alt,
                'anchor_graphic_image_width'   => $image_w,
                'anchor_graphic_image_height'  => $image_h,
              ),
            ),
            array(
              'title'       => 'The End',
              'description' => 'No More to See Here',
              'meta'        => array(
                'anchor_graphic_icon'          => $icon_project,
                'anchor_graphic_icon_alt'      => $icon_project_2_2_alt,
                'anchor_graphic_image_src'     => $image_work,
                'anchor_graphic_image_src_alt' => $image_work_alt,
                'anchor_graphic_image_width'   => $image_w,
                'anchor_graphic_image_height'  => $image_h,
              ),
            ),
          ),
        ),
        array(
          'title'       => 'Project 3',
          'description' => 'More Expressive Text',
          'meta'        => array(
            'anchor_graphic_icon'          => $icon_project,
            'anchor_graphic_icon_alt'      => $icon_project_3_alt,
            'anchor_graphic_image_src'     => $image_work,
            'anchor_graphic_image_src_alt' => $image_work_alt,
            'anchor_graphic_image_width'   => $image_w,
            'anchor_graphic_image_height'  => $image_h,
          ),
        ),
      ),
    ),
    array(
      'title'       => 'Shop',
      'description' => 'Buy Stuff',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_shop,
        'anchor_graphic_icon_alt'      => $icon_shop_alt,
        'anchor_graphic_image_src'     => $image_shop,
        'anchor_graphic_image_src_alt' => $image_shop_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'About',
      'description' => 'Learn More',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_about,
        'anchor_graphic_icon_alt'      => $icon_about_alt,
        'anchor_graphic_image_src'     => $image_about,
        'anchor_graphic_image_src_alt' => $image_about_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'Contact',
      'description' => 'Reach Out',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_contact,
        'anchor_graphic_icon_alt'      => $icon_contact_alt,
        'anchor_graphic_image_src'     => $image_contact,
        'anchor_graphic_image_src_alt' => $image_contact_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
  ),

  'default_no_dropdowns' => array(
    array(
      'title'       => 'Home',
      'description' => 'Start Here',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_home,
        'anchor_graphic_icon_alt'      => $icon_home_alt,
        'anchor_graphic_image_src'     => $image_home,
        'anchor_graphic_image_src_alt' => $image_home_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'Work',
      'description' => 'See Projects',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_work,
        'anchor_graphic_icon_alt'      => $icon_work_alt,
        'anchor_graphic_image_src'     => $image_work,
        'anchor_graphic_image_src_alt' => $image_work_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'Shop',
      'description' => 'Buy Stuff',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_shop,
        'anchor_graphic_icon_alt'      => $icon_shop_alt,
        'anchor_graphic_image_src'     => $image_shop,
        'anchor_graphic_image_src_alt' => $image_shop_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'About',
      'description' => 'Learn More',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_about,
        'anchor_graphic_icon_alt'      => $icon_about_alt,
        'anchor_graphic_image_src'     => $image_about,
        'anchor_graphic_image_src_alt' => $image_about_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'Contact',
      'description' => 'Reach Out',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_contact,
        'anchor_graphic_icon_alt'      => $icon_contact_alt,
        'anchor_graphic_image_src'     => $image_contact,
        'anchor_graphic_image_src_alt' => $image_contact_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
  ),

  'default_split_1' => array(
    array(
      'title'       => 'Home',
      'description' => 'Start Here',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_home,
        'anchor_graphic_icon_alt'      => $icon_home_alt,
        'anchor_graphic_image_src'     => $image_home,
        'anchor_graphic_image_src_alt' => $image_home_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'Work',
      'description' => 'See Projects',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_work,
        'anchor_graphic_icon_alt'      => $icon_work_alt,
        'anchor_graphic_image_src'     => $image_work,
        'anchor_graphic_image_src_alt' => $image_work_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
      'children' => array(
        array(
          'title'       => 'Project 1',
          'description' => 'An Illustrative Blurb',
          'meta'        => array(
            'anchor_graphic_icon'          => $icon_project,
            'anchor_graphic_icon_alt'      => $icon_project_1_alt,
            'anchor_graphic_image_src'     => $image_work,
            'anchor_graphic_image_src_alt' => $image_work_alt,
            'anchor_graphic_image_width'   => $image_w,
            'anchor_graphic_image_height'  => $image_h,
          ),
        ),
        array(
          'title'       => 'Project 2',
          'description' => 'A Descriptive Line',
          'meta'        => array(
            'anchor_graphic_icon'          => $icon_project,
            'anchor_graphic_icon_alt'      => $icon_project_2_alt,
            'anchor_graphic_image_src'     => $image_work,
            'anchor_graphic_image_src_alt' => $image_work_alt,
            'anchor_graphic_image_width'   => $image_w,
            'anchor_graphic_image_height'  => $image_h,
          ),
          'children' => array(
            array(
              'title'       => 'About',
              'description' => 'Learn More',
              'meta'        => array(
                'anchor_graphic_icon'          => $icon_project,
                'anchor_graphic_icon_alt'      => $icon_project_2_1_alt,
                'anchor_graphic_image_src'     => $image_work,
                'anchor_graphic_image_src_alt' => $image_work_alt,
                'anchor_graphic_image_width'   => $image_w,
                'anchor_graphic_image_height'  => $image_h,
              ),
            ),
            array(
              'title'       => 'The End',
              'description' => 'No More to See Here',
              'meta'        => array(
                'anchor_graphic_icon'          => $icon_project,
                'anchor_graphic_icon_alt'      => $icon_project_2_2_alt,
                'anchor_graphic_image_src'     => $image_work,
                'anchor_graphic_image_src_alt' => $image_work_alt,
                'anchor_graphic_image_width'   => $image_w,
                'anchor_graphic_image_height'  => $image_h,
              ),
            ),
          ),
        ),
        array(
          'title'       => 'Project 3',
          'description' => 'More Expressive Text',
          'meta'        => array(
            'anchor_graphic_icon'          => $icon_project,
            'anchor_graphic_icon_alt'      => $icon_project_3_alt,
            'anchor_graphic_image_src'     => $image_work,
            'anchor_graphic_image_src_alt' => $image_work_alt,
            'anchor_graphic_image_width'   => $image_w,
            'anchor_graphic_image_height'  => $image_h,
          ),
        ),
      ),
    ),
    array(
      'title'       => 'Shop',
      'description' => 'Buy Stuff',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_shop,
        'anchor_graphic_icon_alt'      => $icon_shop_alt,
        'anchor_graphic_image_src'     => $image_shop,
        'anchor_graphic_image_src_alt' => $image_shop_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
  ),

  'default_split_2' => array(
    array(
      'title'       => 'Blog',
      'description' => 'Read Things',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_blog,
        'anchor_graphic_icon_alt'      => $icon_blog_alt,
        'anchor_graphic_image_src'     => $image_blog,
        'anchor_graphic_image_src_alt' => $image_blog_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'About',
      'description' => 'Learn More',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_about,
        'anchor_graphic_icon_alt'      => $icon_about_alt,
        'anchor_graphic_image_src'     => $image_about,
        'anchor_graphic_image_src_alt' => $image_about_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
    array(
      'title'       => 'Contact',
      'description' => 'Reach Out',
      'meta'        => array(
        'anchor_graphic_icon'          => $icon_contact,
        'anchor_graphic_icon_alt'      => $icon_contact_alt,
        'anchor_graphic_image_src'     => $image_contact,
        'anchor_graphic_image_src_alt' => $image_contact_alt,
        'anchor_graphic_image_width'   => $image_w,
        'anchor_graphic_image_height'  => $image_h,
      ),
    ),
  ),

);
