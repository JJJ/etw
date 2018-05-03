<?php

return array(

  'title-tag'          => CS()->common()->properTitle(),
  'powered-by-themeco' => __( 'Powered by Themeco', 'cornerstone' ),

  // Messaging
  'welcome-app'       => __( '<strong>Howdy!</strong> What would you like to launch?', 'cornerstone' ),
  'save'              => __( 'Save', 'cornerstone' ),
  'loading'           => __( 'Loading&hellip;', 'cornerstone' ),
  'unauthorized'      => __( 'You don&apos;t have permission to do that.', 'cornerstone' ),
  'exit-to-dashboard' => __( 'Exit to Dashboard', 'cornerstone' ),
  'unsaved-warning'   => __( 'You have unsaved changes that will be lost if you continue. Are you sure you wish to leave?', 'cornerstone' ),

  'streamline-nav-unsaved'   => __( 'Would you like to edit this {{context}}? You have unsaved changes that will be lost if you continue.', 'cornerstone' ),
  'streamline-nav'           => __( 'Would you like to edit this {{context}}? You can safely leave as there are no unsaved changes.', 'cornerstone' ),

  // General Purpose
  'copy-of'    => __( 'Copy of {{title}}', 'cornerstone' ),
  'copy-of-numeric'    => __( '{{title}} ({{index}})', 'cornerstone' ),
  'indexed' => __( '{{label}} {{index}}', 'cornerstone'),
  'search' => __( 'Search', 'cornerstone' ),
  'back-to' => __( 'Back to {{to}}', 'cornerstone' ),
  'item' => __( 'Item', 'cornerstone'),
  'add-item' => __( 'Add Item', 'cornerstone' ),
  'add-label' => __( 'Add {{label}}', 'cornerstone' ),

  // Formatting
  'formatting-colon' => __( '{{prefix}}: {{content}}', '__x__'),

  // Preview Sizer
  'preview-sizer-abbr-xl' => __( 'XL', 'cornerstone' ),
  'preview-sizer-abbr-lg' => __( 'LG', 'cornerstone' ),
  'preview-sizer-abbr-md' => __( 'MD', 'cornerstone' ),
  'preview-sizer-abbr-sm' => __( 'SM', 'cornerstone' ),
  'preview-sizer-abbr-xs' => __( 'XS', 'cornerstone' ),
  'preview-sizer-desc-xl'  => __( '1200px &amp; Up', 'cornerstone' ),
  'preview-sizer-desc-lg'  => __( '980px-1199px', 'cornerstone' ),
  'preview-sizer-desc-md'  => __( '768px-979px', 'cornerstone' ),
  'preview-sizer-desc-sm'  => __( '481px-767px', 'cornerstone' ),
  'preview-sizer-desc-xs'  => __( '480px &amp; Smaller', 'cornerstone' ),

  // Titles
  'home.title'          => __( 'Home', 'cornerstone' ),
  'options.title'       => __( 'Options', 'cornerstone' ),
  'headers.title'       => __( 'Headers', 'cornerstone' ),
  'footers.title'       => __( 'Footers', 'cornerstone' ),
  'content.title'       => __( 'Content', 'cornerstone' ),
  'fonts.title'         => __( 'Fonts', 'cornerstone' ),
  'managers.title'      => __( 'Managers', 'cornerstone' ),
  'templates.title'     => __( 'Templates', 'cornerstone' ),
  'layout.title'        => __( 'Layout', 'cornerstone' ),
  'inspector.title'     => __( 'Inspector', 'cornerstone' ),
  'settings.title'      => __( 'Settings', 'cornerstone' ),
  'elements.title'      => __( 'Elements', 'cornerstone' ),
  'global-blocks.title' => __( 'Global Blocks', 'cornerstone' ),

  'template-manager.title'       => __( 'Template Manager', 'cornerstone' ),
  'design-cloud.title'           => __( 'Design Cloud', 'cornerstone' ),
  'font-manager.title'           => __( 'Font Manager', 'cornerstone' ),
  'color-manager.title'          => __( 'Color Manager', 'cornerstone' ),
  'element-manager.title'        => __( 'Element Manager', 'cornerstone' ),
  'template-manager-short.title' => __( 'Template', 'cornerstone' ),
  'font-manager-short.title'     => __( 'Font', 'cornerstone' ),
  'color-manager-short.title'    => __( 'Color', 'cornerstone' ),
  'element-manager-short.title'  => __( 'Element', 'cornerstone' ),

  // Inspector
  'inspector.na-title' => __( 'Nothing Selected', 'cornerstone' ),
  'inspector.search'   => __( 'Search Inspector...', 'cornerstone' ),
  'inspector.apply-preset-warning' => __( 'This action will replace all element styling. Proceed?', 'cornerstone' ),

  // Controls
  'controls-previous-missing'                 => __( 'Previous Value Unavailable', 'cornerstone' ),
  'controls-font-family-select'               => __( '{{family}} ({{source}})', 'cornerstone' ),
  'controls-text-editor-click-to-edit'        => __( 'Click to Edit', 'cornerstone' ),
  'controls-text-editor-html-mode-label'      => __( 'HTML', 'cornerstone' ),
  'controls-text-editor-rich-text-mode-label' => __( 'Rich Text', 'cornerstone' ),

  // Notifications
  'notification-notice'  => __( 'Hey!', 'cornerstone' ),
  'notification-success' => __( 'Awesome!', 'cornerstone' ),
  'notification-error'   => __( 'Uh oh!', 'cornerstone' ),

  'notification-refreshing-preview'   => __( 'Refreshing preview.', 'cornerstone' ),
  'notification-refreshing-preview-save-reminder'   => __( 'Refreshing preview. Don\'t forget to save.', 'cornerstone' ),


  // Assignments
  'assignments.global'               => __( 'Global', 'cornerstone' ),
  'assignments.unassigned'           => __( 'Unassigned', 'cornerstone' ),
  'assignments.tagged'               => __( '{{tag}}: {{title}}', 'cornerstone' ),
  'assignments.multiple-assignments' => __( 'Multiple Assignments', 'cornerstone' ),

  // Elements
  'elements-confirm-delete' => __( 'Are you sure you want to delete this {{title}}? This can not be undone.', 'cornerstone' ),
  'elements-confirm-erase' => __( 'Are you sure you want to delete this element&apos;s contents? This can not be undone.', 'cornerstone' ),
  'elements-undefined-preview' => __( 'This element could not render because its definition is missing. You might need to activate a plugin.', 'cornerstone' ),
  'elements-preview-unavailable' => __( 'No Preview Available (<a href="#">View Live</a>)', 'cornerstone' ),
  'elements-undefined-inspector-title' => __( 'Undefined Element', 'cornerstone' ),
  'elements-undefined-inspector-message' => __( 'The definition for this element could not be located. You may need to activate a plugin. The type declared for this element is: <strong>{{type}}</strong>', 'cornerstone' ),

  // Confirm
  'confirm-yep'  => __( 'Yes, Proceed', 'cornerstone' ),
  'confirm-nope' => __( 'No, Go Back', 'cornerstone' ),
  'confirm-back' => __( 'Back', 'cornerstone' ),


  // Options
  'options.launch-headers' => __( 'Launch Header Builder', 'cornerstone' ),
  'options.launch-footers' => __( 'Launch Footer Builder', 'cornerstone' ),
  'options.confirm-header-switch-back' => __( 'Are you sure you wish to switch back to Original Headers? This will unassign remove your global Pro Header.', 'cornerstone' ),
  'options.confirm-footer-switch-back' => __( 'Are you sure you wish to switch back to Original Footers? This will unassign remove your global Pro Footer.', 'cornerstone' ),

  // Manage
  'manage.welcome' => __( 'Manage all of your templates, fonts, and colors from one central location!', 'cornerstone' ),

  // Templates
  'templates.blank-welcome'   => __( 'Begin with a blank slate.', 'cornerstone'),

  'templates.download-label' => array(
    'one' => __( 'Download Template', 'cornerstone'),
    'other' => __( 'Download {{count}} Templates', 'cornerstone'),
  ),

  'templates.delete-label' => array(
    'one' => __( 'Delete Template', 'cornerstone'),
    'other' => __( 'Delete {{count}} Templates', 'cornerstone'),
  ),

  'templates.delete-popover' => array(
    'one' => __( 'Are you sure you want to delete the selected template?', 'cornerstone'),
    'other' => __( 'Are you sure you want to delete the {{count}} selected templates?', 'cornerstone'),
  ),

  'templates.filter-all' => __( 'All', 'cornerstone'),
  'templates.filter-header' => __( 'Headers', 'cornerstone'),
  'templates.filter-footer' => __( 'Footers', 'cornerstone'),
  'templates.filter-content' => __( 'Content', 'cornerstone'),
  'templates.filter-preset' => __( 'Presets', 'cornerstone'),
  'templates.filter-my-templates' => __( 'My Templates', 'cornerstone'),
  'templates.filter-themeco-templates' => __( 'Themeco Templates', 'cornerstone'),
  'templates.design-cloud'   => __( 'Design Cloud', 'cornerstone'),

  'templates.type-header'    => __( 'Header', 'cornerstone'),
  'templates.type-footer'    => __( 'Footer', 'cornerstone'),
  'templates.type-content'   => __( 'Content', 'cornerstone'),
  'templates.type-preset'    => __( 'Preset', 'cornerstone'),
  'templates.subtype-format' => __( '<strong>{{type}}</strong>: {{subtype}}', 'cornerstone'),

  'templates.upload-error'   => __( 'Sorry! Your file is not properly formatted.', 'cornerstone' ),

  'templates.element-defaults-save' => __( 'Element defaults updated!', 'cornerstone' ),
  'templates.element-defaults-error' => __( 'Unable to save element default.', 'cornerstone' ),

  // Fonts
  'fonts.new-title' => __( 'Font {{index}}', 'cornerstone' ),

  // Colors
  'colors.new-title'     => __( 'Color {{index}}', 'cornerstone' ),
  'colors.empty-message' => __( 'Click "Add New" to create a color selection.', 'cornerstone' ),

  // Font Weights
  'font-weight.100'       => __( '100 &ndash; Ultra Light', 'cornerstone' ),
  'font-weight.100italic' => __( '100 &ndash; Ultra Light (Italic)', 'cornerstone' ),
  'font-weight.200'       => __( '200 &ndash; Light', 'cornerstone' ),
  'font-weight.200italic' => __( '200 &ndash; Light (Italic)', 'cornerstone' ),
  'font-weight.300'       => __( '300 &ndash; Book', 'cornerstone' ),
  'font-weight.300italic' => __( '300 &ndash; Book (Italic)', 'cornerstone' ),
  'font-weight.400'       => __( '400 &ndash; Regular', 'cornerstone' ),
  'font-weight.400italic' => __( '400 &ndash; Regular (Italic)', 'cornerstone' ),
  'font-weight.500'       => __( '500 &ndash; Medium', 'cornerstone' ),
  'font-weight.500italic' => __( '500 &ndash; Medium (Italic)', 'cornerstone' ),
  'font-weight.600'       => __( '600 &ndash; Semi-Bold', 'cornerstone' ),
  'font-weight.600italic' => __( '600 &ndash; Semi-Bold (Italic)', 'cornerstone' ),
  'font-weight.700'       => __( '700 &ndash; Bold', 'cornerstone' ),
  'font-weight.700italic' => __( '700 &ndash; Bold (Italic)', 'cornerstone' ),
  'font-weight.800'       => __( '800 &ndash; Extra Bold', 'cornerstone' ),
  'font-weight.800italic' => __( '800 &ndash; Extra Bold (Italic)', 'cornerstone' ),
  'font-weight.900'       => __( '900 &ndash; Ultra Bold', 'cornerstone' ),
  'font-weight.900italic' => __( '900 &ndash; Ultra Bold (Italic)', 'cornerstone' ),

  // Choices
  'choices.menu-named'    => __('Menu: %s', 'cornerstone'),
  'choices.menu-location' => __('Location: %s', 'cornerstone'),

  // Sort
  'sort.new-old' => __( 'Newest', 'cornerstone' ),
  'sort.old-new' => __( 'Oldest', 'cornerstone' ),
  'sort.a-z'     => __( 'A-Z', 'cornerstone' ),
  'sort.z-a'     => __( 'Z-A', 'cornerstone' ),
  'sort.popular' => __( 'Popular', 'cornerstone' ),

  // Actions
  'duplicate'     => __( 'Duplicate', 'cornerstone' ),
	'delete'        => __( 'Delete', 'cornerstone' ),
	'really-delete' => __( 'Really Delete?', 'cornerstone' ),

  // Errors
  'preview-error.missing-zone.x_masthead' => __('No suitable preview area found. This is most common when you are using a "No Header" page template. Try changing the page template, or assigning this header to a context where the template allows the header output.', 'cornerstone'),
  'preview-error.missing-zone.x_colophon' => __('No suitable preview area found. This is most common when you are using a "No Footer" page template. Try changing the page template, or assigning this footer to a context where the template allows the footer output.', 'cornerstone'),
  'preview-error.missing-zone.content'    => __('No suitable preview area found. This could happen when a third party plugin is overrinding the content area.', 'cornerstone'),

  'preview-error.load.default'        => __('The preview could not load. This is most often related to a plugin conflict or aggressive page cacheing. Checking the developer console for errors could indicate what went wrong.', 'cornerstone'),
  'preview-error.load.https-mismatch' => __('The preview could not load due to a http/https mismatch. Please check that HTTPS is properly configured on your site.', 'cornerstone'),
  'preview-error.load.cross-origin'   => __('The preview could not load due to misconfigured URLs. This could happen if you are using multiple environments and the site URL was not updated after migrating.', 'cornerstone'),
  'preview-error.load.incomplete'      => __('The preview could not load due to the iframe response being incomplete. This is most often related to a plugin conflict, or customizations introducing a PHP error.', 'cornerstone'),
  'preview-error.load.timeout'        => __('The preview was unresponsive after loading. This is most often related to a plugin conflict or aggressive page cacheing.', 'cornerstone'),

  'preview-error.loading.incomplete-html' => __('The preview HTML did not include a closing </html>; tag. It may fail to load or work properly.', 'cornerstone'),
);
