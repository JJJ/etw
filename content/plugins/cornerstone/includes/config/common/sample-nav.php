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



// Navs
// =============================================================================

return array(

  'default' => array(
    array(
      'title'       => 'Home',
      'description' => 'Start Here',
      'meta'        => array(
        'anchor_graphic_icon'     => 'bookmark-o',
        'anchor_graphic_icon_alt' => 'bookmark',
      ),
    ),
    array(
      'title'       => 'Work',
      'description' => 'See Projects',
      'meta'        => array(
        'anchor_graphic_icon'     => 'folder-open-o',
        'anchor_graphic_icon_alt' => 'folder-open',
      ),
      'children' => array(
        array(
          'title'       => 'Project 1',
          'description' => 'An Illustrative Blurb',
          'meta'        => array(
            'anchor_graphic_icon'     => 'file-o',
            'anchor_graphic_icon_alt' => 'file-image-o',
          ),
        ),
        array(
          'title'       => 'Project 2',
          'description' => 'A Descriptive Line',
          'meta'        => array(
            'anchor_graphic_icon'     => 'file-o',
            'anchor_graphic_icon_alt' => 'file-audio-o',
          ),
          'children' => array(
            array(
              'title'       => 'About',
              'description' => 'Learn More',
              'meta'        => array(
                'anchor_graphic_icon'     => 'file-o',
                'anchor_graphic_icon_alt' => 'file-text-o',
              ),
            ),
            array(
              'title'       => 'The End',
              'description' => 'No More to See Here',
              'meta'        => array(
                'anchor_graphic_icon'     => 'file-o',
                'anchor_graphic_icon_alt' => 'file-archive-o',
              ),
            ),
          ),
        ),
        array(
          'title'       => 'Project 3',
          'description' => 'More Expressive Text',
          'meta'        => array(
            'anchor_graphic_icon'     => 'file-o',
            'anchor_graphic_icon_alt' => 'file-video-o',
          ),
        ),
      ),
    ),
    array(
      'title'       => 'Shop',
      'description' => 'Buy Stuff',
      'meta'        => array(
        'anchor_graphic_icon'     => 'square-o',
        'anchor_graphic_icon_alt' => 'check-square',
      ),
    ),
    // array(
    //   'title'       => 'Blog',
    //   'description' => 'Read Things',
    //   'meta'        => array(
    //     'anchor_graphic_icon'     => 'file-o',
    //     'anchor_graphic_icon_alt' => 'file-text-o',
    //   ),
    // ),
    array(
      'title'       => 'About',
      'description' => 'Learn More',
      'meta'        => array(
        'anchor_graphic_icon'     => 'circle-thin',
        'anchor_graphic_icon_alt' => 'info-circle',
      ),
    ),
    array(
      'title'       => 'Contact',
      'description' => 'Reach Out',
      'meta'        => array(
        'anchor_graphic_icon'     => 'envelope-o',
        'anchor_graphic_icon_alt' => 'envelope',
      ),
    ),
  ),

  'default_no_dropdowns' => array(
    array(
      'title'       => 'Home',
      'description' => 'Start Here',
      'meta'        => array(
        'anchor_graphic_icon'     => 'bookmark-o',
        'anchor_graphic_icon_alt' => 'bookmark',
      ),
    ),
    array(
      'title'       => 'Work',
      'description' => 'See Projects',
      'meta'        => array(
        'anchor_graphic_icon'     => 'folder-open-o',
        'anchor_graphic_icon_alt' => 'folder-open',
      ),
    ),
    array(
      'title'       => 'Shop',
      'description' => 'Buy Stuff',
      'meta'        => array(
        'anchor_graphic_icon'     => 'square-o',
        'anchor_graphic_icon_alt' => 'check-square',
      ),
    ),
    // array(
    //   'title'       => 'Blog',
    //   'description' => 'Read Things',
    //   'meta'        => array(
    //     'anchor_graphic_icon'     => 'file-o',
    //     'anchor_graphic_icon_alt' => 'file-text-o',
    //   ),
    // ),
    array(
      'title'       => 'About',
      'description' => 'Learn More',
      'meta'        => array(
        'anchor_graphic_icon'     => 'circle-thin',
        'anchor_graphic_icon_alt' => 'info-circle',
      ),
    ),
    array(
      'title'       => 'Contact',
      'description' => 'Reach Out',
      'meta'        => array(
        'anchor_graphic_icon'     => 'envelope-o',
        'anchor_graphic_icon_alt' => 'envelope',
      ),
    ),
  ),

  'default_split_1' => array(
    array(
      'title'       => 'Home',
      'description' => 'Start Here',
      'meta'        => array(
        'anchor_graphic_icon'     => 'bookmark-o',
        'anchor_graphic_icon_alt' => 'bookmark',
      ),
    ),
    array(
      'title'       => 'Work',
      'description' => 'See Projects',
      'meta'        => array(
        'anchor_graphic_icon'     => 'folder-open-o',
        'anchor_graphic_icon_alt' => 'folder-open',
      ),
      'children' => array(
        array(
          'title'       => 'Project 1',
          'description' => 'An Illustrative Blurb',
          'meta'        => array(
            'anchor_graphic_icon'     => 'file-o',
            'anchor_graphic_icon_alt' => 'file-image-o',
          ),
        ),
        array(
          'title'       => 'Project 2',
          'description' => 'A Descriptive Line',
          'meta'        => array(
            'anchor_graphic_icon'     => 'file-o',
            'anchor_graphic_icon_alt' => 'file-audio-o',
          ),
          'children' => array(
            array(
              'title'       => 'About',
              'description' => 'Learn More',
              'meta'        => array(
                'anchor_graphic_icon'     => 'file-o',
                'anchor_graphic_icon_alt' => 'file-text-o',
              ),
            ),
            array(
              'title'       => 'The End',
              'description' => 'No More to See Here',
              'meta'        => array(
                'anchor_graphic_icon'     => 'file-o',
                'anchor_graphic_icon_alt' => 'file-archive-o',
              ),
            ),
          ),
        ),
        array(
          'title'       => 'Project 3',
          'description' => 'More Expressive Text',
          'meta'        => array(
            'anchor_graphic_icon'     => 'file-o',
            'anchor_graphic_icon_alt' => 'file-video-o',
          ),
        ),
      ),
    ),
    array(
      'title'       => 'Shop',
      'description' => 'Buy Stuff',
      'meta'        => array(
        'anchor_graphic_icon'     => 'square-o',
        'anchor_graphic_icon_alt' => 'check-square',
      ),
    ),
  ),

  'default_split_2' => array(
    array(
      'title'       => 'Blog',
      'description' => 'Read Things',
      'meta'        => array(
        'anchor_graphic_icon'     => 'file-o',
        'anchor_graphic_icon_alt' => 'file-text-o',
      ),
    ),
    array(
      'title'       => 'About',
      'description' => 'Learn More',
      'meta'        => array(
        'anchor_graphic_icon'     => 'circle-thin',
        'anchor_graphic_icon_alt' => 'info-circle',
      ),
    ),
    array(
      'title'       => 'Contact',
      'description' => 'Reach Out',
      'meta'        => array(
        'anchor_graphic_icon'     => 'envelope-o',
        'anchor_graphic_icon_alt' => 'envelope',
      ),
    ),
  ),

);
