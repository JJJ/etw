<?php

// =============================================================================
// FUNCTIONS/GLOBAL/CONDITIONALS.PHP
// -----------------------------------------------------------------------------
// Conditional functions to check the status of various locations.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Is Blank Page Template
//   02. Is Portfolio
//   03. Is Portfolio Item
//   04. Is Portfolio Category
//   05. Is Portfolio Tag
//   06. Is Shop
//   07. Is Product
//   08. Is Product Category
//   09. Is Product Tag
//   10. Is Product Index
//   11. Is bbPress
//   12. Is BuddyPress
//   13. Is BuddyPress Activity Directory
//   14. Is BuddyPress Groups Directory
//   15. Is BuddyPress Group
//   16. Is BuddyPress Members Directory
//   17. Is BuddyPress User
//   18. Is BuddyPress Blogs Directory
//   19. Is BuddyPress Component
// =============================================================================

// Is Blank Page Template
// =============================================================================

//
// Integers 1-8 are acceptible inputs.
//

function x_is_blank( $number ) {

  if ( is_page_template( 'template-blank-' . $number . '.php' ) ) {
    return true;
  } else {
    return false;
  }

}



// Is Portfolio
// =============================================================================

function x_is_portfolio() {
  return is_page_template( 'template-layout-portfolio.php' );
}



// Is Portfolio Item
// =============================================================================

function x_is_portfolio_item() {
  return is_singular( 'x-portfolio' );
}



// Is Portfolio Category
// =============================================================================

function x_is_portfolio_category() {
  return is_tax( 'portfolio-category' );
}



// Is Portfolio Tag
// =============================================================================

function x_is_portfolio_tag() {
  return is_tax( 'portfolio-tag' );
}



// Is Shop
// =============================================================================

function x_is_shop() {
  return function_exists( 'is_shop' ) && is_shop();
}



// Is Product
// =============================================================================

function x_is_product() {
  return function_exists( 'is_product' ) && is_product();
}



// Is Product Category
// =============================================================================

function x_is_product_category() {
  return function_exists( 'is_product_category' ) && is_product_category();
}



// Is Product Tag
// =============================================================================

function x_is_product_tag() {
  return function_exists( 'is_product_tag' ) && is_product_tag();
}



// Is Product Index
// =============================================================================

function x_is_product_index() {
  return x_is_shop() || x_is_product_category() || is_product_tag();
}



// Is bbPress
// =============================================================================

function x_is_bbpress() {
  return function_exists( 'is_bbpress' ) && is_bbpress();
}



// Is BuddyPress
// =============================================================================

function x_is_buddypress() {
  return function_exists( 'is_buddypress' ) && is_buddypress();
}
