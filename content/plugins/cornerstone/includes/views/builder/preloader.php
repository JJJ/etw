<div class="cs-preloader-logo">
  <?php $is_pro = 'pro' === $this->config_item('common/setup', 'integration-mode'); ?>
  <?php $this->view( $is_pro ? 'svg/logo-flat-content' : 'svg/logo-flat-original' ); ?>
</div>
<div class="cs-preloader-text"><?php e_csi18n('app.powered-by-themeco'); ?></div>
