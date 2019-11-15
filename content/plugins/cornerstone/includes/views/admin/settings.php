<div class="tco-reset tco-wrap tco-wrap-settings tco-alt-cs" data-tco-module="cs-settings">
  <div class="tco-content">
    <div class="wrap"></div>

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
          <div class="tco-column" data-tco-module="cs-role-manager"></div>
        </div>
      </div>
      <?php $this->view( 'admin/settings-sidebar' ); ?>

    </form>

  </div>
</div>
