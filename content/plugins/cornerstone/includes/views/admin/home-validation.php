<div class="tco-box tco-box-validation" data-tco-module="cs-validation">

  <input type="hidden" data-tco-module-target="preload-key" value="<?php echo CS()->component( 'Validation' )->preload_key(); ?>"/>

  <div class="tco-box-content">
    <div class="tco-validation" data-tco-module-processor>
      <div class="tco-validation-graphic">
        <?php cs_tco()->admin_icon( 'locked', 'tco-validation-graphic-icon' ); ?>
        <?php cs_tco()->admin_icon( 'arrow-right', 'tco-validation-graphic-icon' ); ?>
        <?php cs_tco()->admin_icon( 'key', 'tco-validation-graphic-icon' ); ?>
        <?php cs_tco()->admin_icon( 'arrow-right', 'tco-validation-graphic-icon' ); ?>
        <?php cs_tco()->admin_icon( 'unlocked', 'tco-validation-graphic-icon' ); ?>
      </div>
      <h1 class="tco-validation-title"><?php _e( 'You&apos;re almost finished!', 'cornerstone' ); ?></h1>
      <p class="tco-validation-text"><?php _e( 'Cornerstone is <strong class="tco-c-nope">not validated</strong>. Place your Envato purchase code or Themeco license for instant access to automatic updates, support, and custom templates. <a href="https://theme.co/apex/kb/product-validation/" target="_blank">Learn more</a> about product validation or <a href="https://theme.co/apex/licenses/" target="_blank">manage licenses</a> directly in your Themeco account.', 'cornerstone' ); ?></p>
    </div>
    <span class="tco-status-text"></span>
    <div class="tco-validation-overlay" data-tco-module-target="overlay">
      <div class="tco-vam-outer">
        <div class="tco-vam-inner">
          <p class="tco-validation-text" data-tco-module-target="message"></p>
          <a class="tco-btn tco-btn-lg" data-tco-module-target="button"></a>
        </div>
      </div>
    </div>
  </div>

  <form data-tco-module-target="form" action="">
    <input class="tco-form-control" type="text" placeholder="<?php _e( 'Input Code and Hit Enter', 'cornerstone' ); ?>" data-tco-module-target="input">
  </form>

</div>