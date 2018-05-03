<?php

/**
 * Localize strings for javascript
 */

$accept  = __( 'Yes, proceed', 'cornerstone' );
$decline = __( 'No, take me back', 'cornerstone' );

return array(

  // 'integration-mode'         => 'pro',
  'editor-tab-logo-path'        => 'svg/logo-flat-custom', // Pro: 'svg/logo-flat-content'
	'edit-with-cornerstone'       => __( 'Edit with Cornerstone', 'cornerstone' ),
  'visual-tab'                  => __( 'Visual', 'cornerstone' ),
  'text-tab'                    => __( 'Text', 'cornerstone' ),
	'cornerstone-tab'             => __( 'Cornerstone', 'cornerstone' ),
	'insert-cornerstone'          => __( 'Insert Shortcode', 'cornerstone' ),
	'updating'                    => __( 'Updating', 'cornerstone' ),
	'confirm-yep'                 => __( 'Yep', 'cornerstone' ),
	'confirm-nope'                => __( 'Nope', 'cornerstone' ),
	'manual-edit-warning'         => __( 'Hold up! You&apos;re welcome to make changes to the content. However, these will not be reflected in Cornerstone. If you edit the page in Cornerstone again, any changes made here will be overwritten. Do you wish to continue?', 'cornerstone' ),
	'overwrite-warning'           => __( 'Hold up! The content has been modified outside of Cornerstone. Editing in Cornerstone will replace the current content. Do you wish to continue?', 'cornerstone' ),
	'manual-edit-accept'          => $accept,
	'manual-edit-decline'         => $decline,
	'overwrite-accept'            => $accept,
	'overwrite-decline'           => $decline,
	'default-title'               => __( 'Cornerstone Draft', 'cornerstone'),

  'dashboard-title'                  => CS()->common()->properTitle(),
  'dashboard-menu-title'             => __( 'Home', 'cornerstone'),
  'dashboard-settings-title'         => __( 'Settings', 'cornerstone' ),
  'dashboard-settings-path'          => 'cornerstone-settings',
  'dashboard-settings-update'        => __( 'Update', 'cornerstone' ),

  'dashboard-settings-save-title'    => __( 'Save Settings', 'cornerstone' ),
  'dashboard-settings-save-update'   => __( 'Update', 'cornerstone' ),
  'dashboard-settings-save-info'     => __( 'Once you are satisfied with your settings, click the button below to save them.', 'cornerstone' ),
  'dashboard-settings-save-updating' => __( 'Updating&hellip;', 'cornerstone' ),
  'dashboard-settings-save-updated'  => __( 'Settings Saved!', 'cornerstone' ),
  'dashboard-settings-save-error'    => __( 'Sorry! Unable to Save', 'cornerstone' ),

  'dashboard-settings-system-title' => __( 'System', 'cornerstone' ),

  'dashboard-settings-system-clear-style-cache-title' => __( 'Clear Style Cache', 'cornerstone' ),
  'dashboard-settings-system-clear-style-cache-description' => __( 'For quicker page loads V2 Elements will remember the CSS generated when they were last saved. This is automatically cleared when Cornerstone is updated. It may be useful to clear manually if any V2 Elements are missing styling.', 'cornerstone' ),
  'dashboard-settings-system-clear-style-cache-button'      => __( 'Clear Style Cache', 'cornerstone' ),
  'dashboard-settings-system-clear-style-cache-button-clearing' => __( 'Clearing&hellip;', 'cornerstone' ),
  'dashboard-settings-system-clear-style-cache-button-cleared'  => __( 'Cleared!', 'cornerstone' ),
  'dashboard-settings-system-clear-style-cache-button-error'    => __( 'Unable to clear!', 'cornerstone' ),


  'plugin-update-nothing'   => __( 'Nothing to report.', 'cornerstone' ),
  'plugin-update-new'       => __( 'New version available!', 'cornerstone' ),
  'plugin-update-error'     => __( 'Unable to check for updates. Try again later.', 'cornerstone' ),
  'plugin-update-checking'  => __( 'Checking&hellip;', 'cornerstone' ),
  'plugin-update-changelog' => __( 'Visit the <a href="http://theme.co/changelog/#cornerstone">Themeco Changelog</a> for more information.', 'cornerstone' ),
  'plugin-update-notice'    => __( '<a href="%s">Validate to enable automatic updates</a>', 'cornerstone' ),

  'validation-global-notice'   => __( 'This Cornerstone license is ​<strong>not validated</strong>​. <a href="%s">Fix</a>.', 'cornerstone' ),
  'validation-verifying'       => __( 'Verifying license&hellip;', 'cornerstone' ),
  'validation-couldnt-verify'  => __( '<strong>Uh oh</strong>, we couldn&apos;t check if this license was valid. <a data-tco-error-details href="#">Details.</a>', 'cornerstone' ),
  'validation-congrats'        => __( '<strong>Congratulations!</strong> Cornerstone is now validated for this site!', '__x__ ' ),
  'validation-go-back'         => __( 'Go Back', 'cornerstone' ),
  'validation-login'           => __( 'Login or Register', 'cornerstone' ),
  'validation-manage-licenses' => __( 'Manage Licenses', 'cornerstone'),
  'validation-revoke-confirm'  => __( 'By revoking validation, you will no longer receive automatic updates. The site will still be linked in your Themeco account, so you can re-validate at anytime.<br/><br/> Visit "Licenses" in your Themeco account to transfer a license to another site.', 'cornerstone' ),
  'validation-revoke-accept'   => __( 'Yes, revoke validation', 'cornerstone' ),
  'validation-revoke-decline'  => __( 'Stay validated', 'cornerstone' ),
  'validation-revoking'        => __( 'Revoking&hellip;', 'cornerstone' ),
  'validation-revoked'         => __( '<strong>Validation revoked.</strong> You can re-assign licenses from <a href="%s" target="_blank">Manage Licenses</a>.', 'cornerstone' ),
  'validation-msg-invalid'     => __( 'We&apos;ve checked the code, but it <strong>doesn&apos;t appear to be an Cornerstone purchase code or Themeco license.</strong> Please double check the code and try again.', 'cornerstone' ),
  'validation-msg-new-code'    => __( 'This looks like a <strong>brand new purchase code that hasn&apos;t been added to a Themeco account yet.</strong> Login to your existing account or register a new one to continue.', 'cornerstone' ),
  'validation-msg-cant-link'   => __( 'Your code is valid, but <strong>we couldn&apos;t automatically link it to your site.</strong> You can add this site from within your Themeco account.', 'cornerstone' ),
  'validation-msg-in-use'      => __( 'Your code is valid but looks like it has <strong>already been used on another site.</strong> You can revoke and re-assign within your Themeco account.', 'cornerstone' ),

  'tco-connection-error' => __( 'Could not establish connection. For assistance, please start by reviewing our article on troubleshooting <a href="https://theme.co/apex/kb/connection-issues/">connection issues.</a>', 'cornerstone' ),

  'huebert-select-color' => __( 'Select Color', 'cornerstone' ),

  'x-shortcodes-notice' => __( '<strong>X &ndash; Shortcodes has been deactivated</strong>. This plugin is no longer a requirement of X, and can safely be deleted.', 'cornerstone' ),

);
