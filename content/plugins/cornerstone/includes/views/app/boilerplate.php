<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php csi18n('app.title-tag'); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $this->head(); ?>
</head>
<body<?php $this->body_classes(); ?>>
<?php
  $this->view( 'app/components/entry-preloader', true );
  $this->footer();
?>
</body>
</html>
