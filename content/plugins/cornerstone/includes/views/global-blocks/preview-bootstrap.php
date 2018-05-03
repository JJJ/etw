<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php
    the_content();
    wp_footer();
  ?>
</body>
</html>
