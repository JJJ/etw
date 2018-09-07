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
      'utility/api',
    ),
    'init' => array(
      'menu-item-custom-fields/menu-item-custom-fields',
      'menu-item-custom-fields/menu-item-custom-fields-map',
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
      'Front_End',
      'Element_Front_End',
      'App_Boot',
      'Router',
      'Revision_Manager',
      'Template_Manager',
      'Global_Blocks_Manager',
      'Wpml',
    ),
    'after_theme_setup' => array(
      'Element_Manager'
    ),
    'loggedin' => array(
      'Admin',
      'Wp_Export',
      'Options_Manager',
      'App',
      'Preview_Frame_Loader',
      'Validation',
      'Layout_Manager',
    ),
    'model/option' => array(
      'Header_Assignments',
      'Footer_Assignments',
      'Font_Manager',
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
      'decorators',
      '_settings',
    ),
    'mixins_controls' => array(
      'border-radius',
      'border',
      'box-shadow',
      'flex-layout-attr',
      'flex-layout-css',
      'flex',
      'image',
      'info',
      'link',
      'margin',
      'menu',
      'padding',
      'text-format',
      'text-shadow',
      'text-style',
    ),
    'mixins_includes' => array(
      '_',
      '_anchor',
      '_bg',
      '_cart',
      '_content-area',
      '_dropdown',
      '_frame',
      '_graphic',
      '_image',
      '_mejs',
      '_menu',
      '_modal',
      '_off-canvas',
      '_omega',
      '_particle',
      '_search',
      '_separator',
      '_text',
      '_toggle',
      'accordion-item',
      'accordion',
      'alert',
      'audio',
      'breadcrumbs',
      'column',
      'counter',
      'gap',
      'global-block',
      'line',
      'map-marker',
      'map',
      'quote',
      'row',
      'section',
      'statbar',
      'tabs',
      'tab',
      'video',
      'widget-area',
    ),
    'mixins_elements' => array(
      'accordion-item',
      'accordion',
      'alert',
      'audio',
      'breadcrumbs',
      'button',
      'column',
      'content-area',
      'content-area-dropdown',
      'content-area-modal',
      'content-area-off-canvas',
      'counter',
      'gap',
      'global-block',
      'headline',
      'image',
      'line',
      'map-marker',
      'map',
      'nav-collapsed',
      'nav-dropdown',
      'nav-inline',
      'nav-layered',
      'nav-modal',
      'quote',
      'row',
      'search-dropdown',
      'search-inline',
      'search-modal',
      'section',
      'social',
      'statbar',
      'tabs',
      'tab',
      'text',
      'tp-wc-cart-dropdown',
      'tp-wc-cart-modal',
      'tp-wc-cart-off-canvas',
      'video',
      'widget-area',
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
      'image',
      'nav-collapsed',
      'nav-dropdown',
      'nav-inline',
      'nav-modal',
      'nav-layered',
      'search-inline',
      'search-dropdown',
      'search-modal',
      'map',
      'map-marker',
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
      'tp-wc-cart-dropdown',
      'tp-wc-cart-modal',
      'tp-wc-cart-off-canvas',
      'section',
      'row',
      'column',
      // 'tp-bbp-dropdown',
      // 'tp-bp-dropdown',
    ),
  ),


  // Classic Elements
  // ----------------

  'classic-elements' => array(
    'mk2' => array( 'alert', 'block-grid', 'block-grid-item', 'column', 'icon-list', 'icon-list-item', 'pricing-table', 'pricing-table-column', 'responsive-text', 'row', 'section', 'text', 'undefined' ),
    'mk1' => array( 'accordion-item', 'accordion', 'author', 'blockquote', 'button', 'callout', 'card', 'clear', 'code', 'columnize', 'contact-form-7', 'counter', 'creative-cta', 'custom-headline', 'embedded-audio', 'embedded-video', 'envira-gallery', 'essential-grid', 'feature-box', 'feature-headline', 'feature-list-item', 'feature-list', 'gap', 'google-map-marker', 'google-map', 'gravity-forms', 'icon', 'image', 'layerslider', 'line', 'mailchimp', 'map-embed', 'promo', 'prompt', 'protect', 'raw-content', 'recent-posts', 'revolution-slider', 'search', 'self-hosted-audio', 'self-hosted-video', 'skill-bar', 'slide', 'slider', 'social-sharing', 'soliloquy', 'tab','tabs', 'text-type', 'toc-item', 'toc', 'visibility', 'widget-area' ),
  ),

);
