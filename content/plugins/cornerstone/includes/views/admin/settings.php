<div class="tco-reset tco-wrap tco-wrap-settings tco-alt-cs" data-tco-module="cs-settings">
  <div class="tco-content">
    <div class="wrap"><h2>WordPress Wrap</h2></div>

    <form class="tco-form" data-tco-module-target="form">

      <div class="tco-main">
        <div class="tco-row">
          <div class="tco-column">
            <div class="tco-box">
              <header class="tco-box-header">
                <h2 class="tco-box-title"><?php e_csi18n('admin.dashboard-settings-title'); ?></h2>
              </header>
              <div class="tco-box-content tco-pan"> <?php $this->settings_handler->render_form(); ?> </div>
            </div>
          </div>
        </div>
        <div class="tco-row">
          <div class="tco-column">
            <div class="tco-box">
              <header class="tco-box-header">
                <h2 class="tco-box-title"><?php e_csi18n('admin.dashboard-settings-system-title'); ?></h2>
              </header>
              <div class="tco-box-content tco-pan">
                <div class="tco-form-setting" data-tco-module="cs-clear-style-cache">
                  <div class="tco-form-setting-info">
                    <label for="cs-control-custom_app_slug">
                      <strong><?php e_csi18n('admin.dashboard-settings-system-clear-style-cache-title'); ?></strong>
                      <span><?php e_csi18n('admin.dashboard-settings-system-clear-style-cache-description'); ?></span>
                    </label>
                  </div>
                  <div class="tco-form-setting-control">
                    <button data-tco-module-target="button" class="tco-btn"><?php e_csi18n('admin.dashboard-settings-system-clear-style-cache-button'); ?></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php $this->view( 'admin/settings-sidebar' ); ?>

    </form>

  </div>
</div>
