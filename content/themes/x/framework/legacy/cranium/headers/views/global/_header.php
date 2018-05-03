<?php

// =============================================================================
// VIEWS/GLOBAL/_HEADER.PHP
// -----------------------------------------------------------------------------
// Declares the DOCTYPE for the site and includes the <head>.
// =============================================================================

?>

<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <div id="x-root" class="x-root">

    <?php do_action( 'x_before_site_begin' ); ?>

    <div id="top" class="site">

    <?php do_action( 'x_after_site_begin' ); ?>