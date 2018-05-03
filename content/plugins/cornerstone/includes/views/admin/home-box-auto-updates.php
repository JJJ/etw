<div class="tco-box tco-box-min-height tco-box-automatic-updates" data-tco-module="cs-updates">
  <header class="tco-box-header">
    <?php echo $status_icon_dynamic; ?>
    <h2 class="tco-box-title"><?php _e( 'Automatic Updates', 'cornerstone' ); ?></h2>
  </header>
  <div class="tco-box-content">
  <?php if ( $is_validated ) : ?>

    <?php $changelog = __( 'Changelog', 'cornerstone' ); ?>

    <ul class="tco-box-features">
      <li>
        <?php cs_tco()->admin_icon( 'dl-laptop', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Installed Version', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php echo CS()->version(); ?> <a class="tco-automatic-updates-changelog" href="https://theme.co/changelog/" target="_blank"><?php echo $changelog; ?></a></span>
        </div>
      </li>
      <li>
        <?php cs_tco()->admin_icon( 'bullhorn', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Latest Version Available', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><span data-tco-module-target="latest-available"><?php echo CS()->version(); ?></span> <a class="tco-automatic-updates-changelog" href="https://theme.co/changelog/" target="_blank"><?php echo $changelog; ?></a></span>
        </div>
      </li>
      <li>
        <?php cs_tco()->admin_icon( 'refresh', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Checked Every 12 Hours', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text" data-tco-module-target="check-now"><a class="tco-automatic-updates-check-now" href="#"><?php _e( 'Check Now', 'cornerstone' ); ?></a></span>
        </div>
      </li>
    </ul>
  <?php else : ?>
    <ul class="tco-box-features">
      <li>
        <?php cs_tco()->admin_icon( 'bell', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Admin Notifications', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Get updates in WordPress', 'cornerstone' ); ?></span>
        </div>
      </li>
      <li>
        <?php cs_tco()->admin_icon( 'refresh', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Stay Up to Date', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Use the latest features right away', 'cornerstone' ); ?></span>
        </div>
      </li>
      <li>
        <?php cs_tco()->admin_icon( 'dl-desktop', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Manual No More', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Say goodbye to your FTP client', 'cornerstone' ); ?></span>
        </div>
      </li>
    </ul>
    <a class="tco-btn tco-btn-nope" href="#" data-tco-toggle=".tco-box-automatic-updates .tco-overlay"><?php _e( 'Setup Now', 'cornerstone' ); ?></a>
  <?php endif; ?>
  </div>
  <footer class="tco-box-footer">
    <div class="tco-box-bg" style="background-image: url(<?php cs_tco()->admin_image( 'box-automatic-updates-tco-box-bg-cs.jpg' ); ?>);"></div>
    <?php if ( ! $is_validated ) :

    $box_class = '.tco-box-automatic-updates';
    include( $this->locate_view( 'admin/home-validate-overlay' ) );

    endif; ?>
  </footer>
</div>