<?php

/**
 * Pseudo autoloading system.
 *
 * files:
 *     Groups of files to require at different points in WordPress execution
 *     Generally, these files should only contain class and function
 *     definitions without initiating any application logic.
 *
 * components:
 *     Groups of componenets to load into our main plugin at different points
 *     in WordPress execution. Component names must match their class name,
 *     prefixed by the plugin name for example:
 *     Class: Cornerstone_MyComponent
 *     Component: MyComponent
 */

return array(

  'files' => array(
    'preinit' => array(
      'tco/tco',
      'utility/helpers',
      'utility/api',
    ),
    'init' => array(
      'menu-item-custom-fields/menu-item-custom-fields',
      'menu-item-custom-fields/menu-item-custom-fields-map',
    )
  ),

  'components' => array(
    'preinit' => array(
      'Tco',
      'Common',
      'Updates',
      'Integration_Manager',
      'Options_Bootstrap',
      'CLI','Debug'
    ),
    'init' => array(
      'Legacy_Elements',
      'Shortcode_Generator',
      'Element_Orchestrator',
      'Core_Scripts',
      'Front_End',
      'Element_Front_End',
      'App_Boot',
      'Router',
      'Revision_Manager',
      'Template_Manager',
      'Global_Blocks_Manager',
      'Wpml'
    ),
    'after_theme_setup' => array(
      'Element_Manager',
      'Regions:theme-support:cornerstone_regions'
    ),
    'loggedin' => array(
      'Admin',
      'Wp_Export',
      'Options_Manager', // MOVE
      'App',
      'Preview_Frame_Loader',
      'Validation',
      'Builder',
      'Layout_Manager'
    ),

    'model/option' => array(
      'Header_Assignments',
      'Footer_Assignments',
      'Font_Manager',
      'Color_Manager'
    )
  ),

  'elements' => array(

    'base' => array(
      'shim',
      'helpers',
      'sample',
      'decorators',
      '_settings',
    ),

    'mixins' => array(
      '_margin',
      '_padding',
      '_border',
      '_border-radius',
      '_box-shadow',
      '_flex',
      '_flex-layout-css',
      '_flex-layout-attr',
      '_image',
      '_info',
      '_link',
      '_menu',
      '_text-format',
      '_text-shadow',
      '_text-style',
      'accordion',
      'alert',
      'anchor',
      'audio',
      'bg',
      'quote',
      'breadcrumbs',
      'cart',
      'column',
      'counter',
      'dropdown',
      'frame',
      'global-block',
      'graphic',
      'image',
      'line',
      'gap',
      'map',
      'mejs',
      'menu',
      'modal',
      'off-canvas',
      'omega',
      'particle',
      'row',
      'separator',
      'search',
      'section',
      'statbar',
      'tabs',
      'text',
      'toggle',
      'video',
    ),

    'definitions' => array(

      'button',
      'column',
      'content-area',
      'content-area-dropdown',
      'content-area-modal',
      'content-area-off-canvas',
      'global-block',
      'accordion',
      'accordion-item',
      // 'tabs',
      // 'tab',
      'image',
      'nav-collapsed',
      'nav-dropdown',
      'nav-inline',
      'nav-modal',
      'row',
      'search-inline',
      'search-dropdown',
      'search-modal',
      'section',
      'map',
      'audio',
      'video',
      'social',
      'text',
      'headline',
      'quote',
      'breadcrumbs',
      'alert',
      'counter',
      'statbar',
      'line',
      'gap',
      'widget-area',
      // 'tp-bbp-dropdown',
      // 'tp-bp-dropdown',
      'tp-wc-cart-dropdown',
      'tp-wc-cart-modal',
      'tp-wc-cart-off-canvas',
    )

  ),




  'classic-elements' => array(
    'mk2' => array( 'alert', 'block-grid', 'block-grid-item', 'column', 'icon-list', 'icon-list-item', 'pricing-table', 'pricing-table-column', 'responsive-text', 'row', 'section', 'text', 'undefined', ),
    'mk1' => array('accordion-item', 'accordion', 'author', 'blockquote', 'button', 'callout', 'card', 'clear', 'code', 'columnize', 'contact-form-7', 'counter', 'creative-cta', 'custom-headline', 'embedded-audio', 'embedded-video', 'envira-gallery', 'essential-grid', 'feature-box', 'feature-headline', 'feature-list-item', 'feature-list', 'gap', 'google-map-marker', 'google-map', 'gravity-forms', 'icon', 'image', 'layerslider', 'line', 'mailchimp', 'map-embed', 'promo', 'prompt', 'protect', 'raw-content', 'recent-posts', 'revolution-slider', 'search', 'self-hosted-audio', 'self-hosted-video', 'skill-bar', 'slide', 'slider', 'social-sharing', 'soliloquy', 'tab','tabs', 'text-type', 'toc-item', 'toc', 'visibility', 'widget-area' )
  )

);
