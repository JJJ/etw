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
      <?php $this->view( 'admin/editor-tab-content' ); ?>
    </div>
  </div>
</div>
