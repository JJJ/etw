<?php

// =============================================================================
// REGISTRY.PHP
// -----------------------------------------------------------------------------
// Pseudo autoloading system.
//
// `files`:
// Contains groups of files to require at different points in WordPress
// execution. Generally, these files should only contain class and function
// definitions without initiating any application logic.
//
// `components`
// Groups of componenets to load into our main plugin at different points in
// WordPress execution. Component names must match their class name, prefixed
// by the plugin name for example:
//
//   Class: Cornerstone_MyComponent
//   Component: MyComponent
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Registry
//       a. Files
//       b. Components
//       c. Elements
//       d. Classic Elements
// =============================================================================

// Registry
// =============================================================================

return array(

  // Files
  // -----

  'files' => array(
    'preinit' => array(
      'tco/tco',
      'utility/helpers',
      'utility/element-api',
      'utility/api',
    ),
    'init' => array(
      'extend/menu-item-custom-fields/menu-item-custom-fields',
      'extend/menu-item-custom-fields/menu-item-custom-fields-map',
    ),
  ),


  // Components
  // ----------

  'components' => array(
    'preinit' => array(
      'Tco',
      'Common',
      'Updates',
      'Integration_Manager',
      'Options_Bootstrap',
      'CLI','Debug',
    ),
    'init' => array(
      'Legacy_Elements',
      'Shortcode_Generator',
      'Element_Orchestrator',
      'Dynamic_Content',
      'Front_End',
      'Element_Front_End',
      'App_Boot',
      'Router',
      'Revision_Manager',
      'Template_Manager',
      'Global_Blocks_Manager',
      'Wpml',
      'Search',
      'Social',
      'Yoast',
      'Shortcode_Finder',
      'WooCommerce',
      'Offload_S3'
    ),
    'after_theme_setup' => array(
      'Element_Manager'
    ),
    'loggedin' => array(
      'Admin',
      'Status',
      'Wp_Export',
      'Options_Manager',
      'App',
      'Preview_Frame_Loader',
      'Validation',
      'Layout_Manager',
      'Font_Manager',
    ),
    'model/option' => array(
      'Header_Assignments',
      'Footer_Assignments',
      'Color_Manager',
    ),
  ),


  // Elements
  // --------

  'elements' => array(
    'base' => array(
      'shim',
      'helpers',
      'sample',
    ),
    'control-partials' => array(
      'anchor',
      'bg',
      'cart',
      'content-area',
      'dropdown',
      'frame',
      'graphic',
      'icon',
      'image',
      'mejs',
      'menu',
      'modal',
      'off-canvas',
      'omega',
      'particle',
      'rating',
      'search',
      'separator',
      'text',
      'toggle'
    ),
    'definitions' => array(
      'button',
      'content-area',
      'content-area-dropdown',
      'content-area-modal',
      'content-area-off-canvas',
      'global-block',
      'accordion',
      'accordion-item',
      'tabs',
      'tab',
      'icon',
      'image',
      'nav-collapsed',
      'nav-dropdown',
      'nav-inline',
      'nav-modal',
      'nav-layered',
      'layout-row',
      'layout-column',
      // 'layout-grid',
      // 'layout-cell',
      // 'post',
      'search-inline',
      'search-dropdown',
      'search-modal',
      'card',
      'creative-cta',
      'map',
      'map-marker',
      'audio',
      'video',
      'social',
      'text',
      'headline',
      'quote',
      'testimonial',
      'breadcrumbs',
      'alert',
      'counter',
      'countdown',
      'rating',
      'raw-content',
      'statbar',
      'line',
      'gap',
      'widget-area',
      'tp-wc-cart-dropdown',
      'tp-wc-cart-modal',
      'tp-wc-cart-off-canvas',
      'section',
      'row',
      'column'
    ),
  ),


  // Classic Elements
  // ----------------

  'classic-elements' => array(
    'mk2' => array( 'alert', 'block-grid', 'block-grid-item', 'column', 'icon-list', 'icon-list-item', 'pricing-table', 'pricing-table-column', 'responsive-text', 'row', 'section', 'text', 'undefined' ),
    'mk1' => array( 'accordion-item', 'accordion', 'author', 'blockquote', 'button', 'callout', 'card', 'clear', 'code', 'columnize', 'contact-form-7', 'counter', 'creative-cta', 'custom-headline', 'embedded-audio', 'embedded-video', 'envira-gallery', 'essential-grid', 'feature-box', 'feature-headline', 'feature-list-item', 'feature-list', 'gap', 'google-map-marker', 'google-map', 'gravity-forms', 'icon', 'image', 'layerslider', 'line', 'mailchimp', 'map-embed', 'promo', 'prompt', 'protect', 'raw-content', 'recent-posts', 'revolution-slider', 'search', 'self-hosted-audio', 'self-hosted-video', 'skill-bar', 'slide', 'slider', 'social-sharing', 'soliloquy', 'tab','tabs', 'text-type', 'toc-item', 'toc', 'visibility', 'widget-area' ),
  ),

);
