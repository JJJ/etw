<?php

return array(
  'bbpress' => array(
    'slug'        => 'bbpress',
    'plugin'      => 'bbpress/bbpress.php',
    'title'       => 'bbPress',
    'description' => 'Have you ever been frustrated with forum or bulletin board software that was slow, bloated and always got your server hacked? bbPress is focused on ease of integration, ease of use, web standards, and speed.',
    'logo_url'    => '//theme.co/media/x_extensions/200-200-no-title-bbpress.png',
    'author'      => 'bbPress',
    'is_callable' => 'bbpress'
  ),
  'buddypress' => array(
    'slug'        => 'buddypress',
    'plugin'      => 'buddypress/bp-loader.php',
    'title'       => 'BuddyPress',
    'description' => 'Are you looking for modern, robust, and sophisticated social network software? BuddyPress is a suite of components that are common to a typical social network, and allows for great add-on features through WordPress&apos;s extensive plugin system.',
    'logo_url'    => '//theme.co/media/x_extensions/200-200-no-title-buddypress.png',
    'author'      => 'BuddyPress',
    'is_callable' => 'buddypress'
  ),
  'contact-form-7' => array(
    'slug'        => 'contact-form-7',
    'plugin'      => 'contact-form-7/wp-contact-form-7.php',
    'title'       => 'Contact Form 7',
    'description' => 'Contact Form 7 can manage multiple contact forms, plus you can customize the form and the mail contents flexibly with simple markup. The form supports Ajax-powered submitting, CAPTCHA, Akismet spam filtering and so on.',
    'logo_url'    => '//theme.co/media/x_extensions/200-200-no-title-contact-form-7.png',
    'author'      => 'Takayuki Miyoshi',
    'is_callable' => 'wpcf7'
  ),
  'mailpoet' => array(
    'slug'        => 'mailpoet',
    'plugin'      => 'mailpoet/mailpoet.php',
    'title'       => 'MailPoet',
    'description' => 'Create and send newsletters, post notifications and welcome emails from your WordPress.',
    'logo_url'    => '//theme.co/media/x_extensions/200-200-no-title-mailpoet.png',
    'author'      => 'MailPoet',
    'is_callable' => 'mailpoet_deactivate_plugin'
  ),
  'woocommerce' => array(
    'slug'        => 'woocommerce',
    'plugin'      => 'woocommerce/woocommerce.php',
    'title'       => 'WooCommerce',
    'description' => 'WooCommerce is a free eCommerce plugin that allows you to sell anything, beautifully. Built to integrate seamlessly with WordPress, WooCommerce is the world’s favorite eCommerce solution that gives both store owners and developers complete control.',
    'logo_url'    => '//theme.co/media/x_extensions/200-200-no-title-woocommerce.png',
    'author'      => 'WooThemes',
    'is_callable' => 'wc'
  ),
  'leadin' => array(
    'slug'        => 'leadin',
    'plugin'      => 'leadin/leadin.php',
    'title'       => 'HubSpot',
    'description' => 'HubSpot All-In-One Marketing is the ultimate free plugin for WordPress if you want to grow your email list, manage your contacts, and send marketing emails all through HubSpot’s free CRM.',
    'logo_url'    => '//theme.co/media/x_extensions/200-200-no-title-hubspot.png',
    'author'      => 'HubSpot',
    'is_callable' => 'leadin_init'
  )
);
