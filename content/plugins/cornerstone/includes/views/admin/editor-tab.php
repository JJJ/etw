<div class="postarea wp-editor-expand" style="display:none;">
  <div class="wp-core-ui wp-editor-wrap cornerstone-active" style="padding-top: 21px;">
    <div class="wp-editor-tools">
      <div class="wp-editor-tabs">
        <button type="button" id="content-tmce" class="wp-switch-editor switch-tmce"><?php e_csi18n('admin.visual-tab'); ?></button>
        <button type="button" id="content-html" class="wp-switch-editor switch-html"><?php e_csi18n('admin.text-tab'); ?></button>
        <button type="button" id="content-cornerstone" class="wp-switch-editor switch-cornerstone"><?php e_csi18n('admin.cornerstone-tab'); ?></button>
      </div>
    </div>
    <div class="wp-editor-container">
      <div class="cs-editor-container <?php e_csi18n('admin.integration-mode') ?>">
        <div class="cs-logo"><?php $this->view( csi18n('admin.editor-tab-logo-path') ); ?></div>
        <button href="#" id="cs-edit-button" class="cs-edit-btn">
          <span><?php e_csi18n('admin.edit-with-cornerstone'); ?></span>
        </button>
      </div>
    </div>
  </div>
</div>
