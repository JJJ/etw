<!DOCTYPE html>
<html <?php language_attributes(); ?> class="cs-ui-theme-<?php echo $data['theme'];?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $this->head(); ?>
</head>
<body<?php $this->body_classes(); ?>>
  <div class="cs-entry-preloader">
    <div class="cs-pre-loader cs-pre-loader-fixed cs-active">
      <div class="cs-loading-indicator" style="font-size: 150px;">&hellip;</div>
    </div>
  </div>
  <?php $this->footer(); ?>
</body>
</html>
