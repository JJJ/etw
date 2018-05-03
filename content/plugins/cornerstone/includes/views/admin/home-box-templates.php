<div class="tco-box tco-box-min-height tco-box-templates" >
  <header class="tco-box-header">
    <?php echo $status_icon_dynamic; ?>
    <h2 class="tco-box-title"><?php _e( 'Themeco Templates', 'cornerstone' ); ?></h2>
  </header>
  <div class="tco-box-content">
  <?php if ( $is_validated ) : ?>
    <ul class="tco-box-features">
      <li>
        <?php cs_tco()->admin_icon( 'layout', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Now Available', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Professional Themeco designs', 'cornerstone' ); ?></span>
        </div>
      </li>
      <li>
        <?php cs_tco()->admin_icon( 'search', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Access in Cornerstone', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Locate under Layout &rarr; Templates', 'cornerstone' ); ?></span>
        </div>
      </li>
      <li>
        <?php cs_tco()->admin_icon( 'gift', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'More to Come', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Keep your eyes peeled', 'cornerstone' ); ?></span>
        </div>
      </li>
    </ul>
  <?php else : ?>
    <ul class="tco-box-features">
      <li>
        <?php cs_tco()->admin_icon( 'layout', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Professionally Designed', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Replace with your own content', 'cornerstone' ); ?></span>
        </div>
      </li>
      <li>
        <?php cs_tco()->admin_icon( 'tools', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'Pages and Blocks', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Create layouts quickly and easily', 'cornerstone' ); ?></span>
        </div>
      </li>
      <li>
        <?php cs_tco()->admin_icon( 'gift', 'tco-box-feature-icon' ); ?>
        <div class="tco-box-feature-info">
          <h4 class="tco-box-content-title"><?php _e( 'More to Come', 'cornerstone' ); ?></h4>
          <span class="tco-box-content-text"><?php _e( 'Keep your eyes peeled', 'cornerstone' ); ?></span>
        </div>
      </li>
    </ul>
    <a class="tco-btn tco-btn-nope" href="#" data-tco-toggle=".tco-box-templates .tco-overlay"><?php _e( 'Unlock Templates', 'cornerstone' ); ?></a>
  <?php endif; ?>
  </div>
  <footer class="tco-box-footer">
    <?php if ( ! $is_validated ) : ?>
    	<div class="tco-box-bg" style="background-image: url(<?php cs_tco()->admin_image( 'box-templates-locked-tco-box-bg.jpg' ); ?>);"></div>
      <?php $box_class = '.tco-box-templates';
      include( $this->locate_view( 'admin/home-validate-overlay' ) );
    else : ?>
    <div class="tco-box-bg" style="background-image: url(<?php cs_tco()->admin_image( 'box-templates-unlocked-tco-box-bg.jpg' ); ?>);"></div>
  <?php endif; ?>
  </footer>
</div>