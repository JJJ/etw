/* Margins
// ========================================================================== */

<?php if ( $cs_v1_base_margin_extended == '1' ) : ?>
  #cs-content .x-text,
  #cs-content .x-raw-content,
<?php endif; ?>
#cs-content .x-accordion,
#cs-content .x-alert,
#cs-content .x-audio,
#cs-content .x-author-box,
#cs-content .x-base-margin,
#cs-content .x-block-grid,
#cs-content .x-card-outer,
#cs-content .x-code,
#cs-content .x-columnize,
#cs-content .x-entry-share,
#cs-content div.x-feature-box,
#cs-content .x-feature-list,
#cs-content .x-flexslider-shortcode-container,
#cs-content .x-gap,
#cs-content .x-img,
#cs-content .x-map,
#cs-content .x-promo,
#cs-content .x-prompt,
#cs-content .x-recent-posts,
#cs-content .x-section,
#cs-content .x-skill-bar,
#cs-content .x-tab-content,
#cs-content .x-video {
  margin-bottom: <?php echo $cs_v1_base_margin; ?>;
}

#cs-content .x-blockquote:not(.x-pullquote),
#cs-content .x-callout,
#cs-content .x-hr,
#cs-content .x-pricing-table {
  margin-top: <?php echo $cs_v1_base_margin; ?>;
  margin-bottom: <?php echo $cs_v1_base_margin; ?>;
}

@media (max-width: 767px) {
  #cs-content .x-pullquote.left,
  #cs-content .x-pullquote.right {
    margin-top: <?php echo $cs_v1_base_margin; ?>;
    margin-bottom: <?php echo $cs_v1_base_margin; ?>;
  }
}

@media (max-width: 480px) {
  #cs-content .x-toc.left,
  #cs-content .x-toc.right {
    margin-bottom: <?php echo $cs_v1_base_margin; ?>;
  }
}



/* Containers
// ========================================================================== */

#cs-content .x-container.width {
  width: <?php echo $cs_v1_container_width; ?>;
}

#cs-content .x-container.max {
  max-width: <?php echo $cs_v1_container_max_width; ?>;
}



/* Text Color
// ========================================================================== */

#cs-content .x-accordion-heading .x-accordion-toggle.collapsed,
#cs-content .x-nav-tabs > li > a,
#cs-content .x-recent-posts .h-recent-posts,
#cs-content .x-recent-posts .x-recent-posts-date {
  color: <?php echo $cs_v1_text_color; ?>;
}



/* Link Colors
// ========================================================================== */

#cs-content .x-accordion-heading .x-accordion-toggle.collapsed:hover,
#cs-content .x-accordion-heading .x-accordion-toggle,
#cs-content .x-nav-tabs > li > a:hover,
#cs-content .x-nav-tabs > .active > a,
#cs-content .x-nav-tabs > .active > a:hover,
#cs-content .x-recent-posts a:hover .h-recent-posts {
  color: <?php echo $cs_v1_link_color; ?>;
}

#cs-content a.x-img-thumbnail:hover {
  border-color: <?php echo $cs_v1_link_color; ?>;
}

#cs-content .x-dropcap,
#cs-content .x-highlight,
#cs-content .x-pricing-column.featured h2,
#cs-content .x-recent-posts .x-recent-posts-img:after {
  background-color: <?php echo $cs_v1_link_color; ?>;
}



/* Buttons
// ========================================================================== */

#cs-content .x-btn {

  color: <?php echo $cs_v1_button_color; ?>;
  border-color: <?php echo $cs_v1_button_border_color; ?>;
  background-color: <?php echo $cs_v1_button_bg_color; ?>;

  <?php if ( $cs_v1_button_style == 'real' ) : ?>
    margin-bottom: 0.25em;
    text-shadow: 0 0.075em 0.075em rgba(0, 0, 0, 0.5);
    box-shadow: 0 0.25em 0 0 <?php echo $cs_v1_button_bottom_color; ?>, 0 4px 9px rgba(0, 0, 0, 0.75);
  <?php elseif ( $cs_v1_button_style == 'flat' ) : ?>
    text-shadow: 0 0.075em 0.075em rgba(0, 0, 0, 0.5);
  <?php elseif ( $cs_v1_button_style == 'transparent' ) : ?>
    border-width: 3px;
    text-transform: uppercase;
    background-color: transparent;
  <?php endif; ?>

  <?php if ( $cs_v1_button_shape == 'rounded' ) : ?>
    border-radius: 0.25em;
  <?php elseif ( $cs_v1_button_shape == 'pill' ) : ?>
    border-radius: 100em;
  <?php endif; ?>

  <?php if ( $cs_v1_button_size == 'mini' ) : ?>
    padding: 0.385em 0.923em 0.538em;
    font-size: 13px;
  <?php elseif ( $cs_v1_button_size == 'small' ) : ?>
    padding: 0.429em 1.143em 0.643em;
    font-size: 14px;
  <?php elseif ( $cs_v1_button_size == 'large' ) : ?>
    padding: 0.579em 1.105em 0.842em;
    font-size: 19px;
  <?php elseif ( $cs_v1_button_size == 'x-large' ) : ?>
    padding: 0.714em 1.286em 0.952em;
    font-size: 21px;
  <?php elseif ( $cs_v1_button_size == 'jumbo' ) : ?>
    padding: 0.643em 1.429em 0.857em;
    font-size: 28px;
  <?php endif; ?>

}

#cs-content a.x-btn:hover {

  color: <?php echo $cs_v1_button_color_hover; ?>;
  border-color: <?php echo $cs_v1_button_border_color_hover; ?>;
  background-color: <?php echo $cs_v1_button_bg_color_hover; ?>;

  <?php if ( $cs_v1_button_style == 'real' ) : ?>
    margin-bottom: 0.25em;
    text-shadow: 0 0.075em 0.075em rgba(0, 0, 0, 0.5);
    box-shadow: 0 0.25em 0 0 <?php echo $cs_v1_button_bottom_color_hover; ?>, 0 4px 9px rgba(0, 0, 0, 0.75);
  <?php elseif ( $cs_v1_button_style == 'flat' ) : ?>
    text-shadow: 0 0.075em 0.075em rgba(0, 0, 0, 0.5);
  <?php elseif ( $cs_v1_button_style == 'transparent' ) : ?>
    border-width: 3px;
    text-transform: uppercase;
    background-color: transparent;
  <?php endif; ?>

}


/*
// Button Style - Real
*/

#cs-content .x-btn.x-btn-real,
#cs-content .x-btn.x-btn-real:hover {
  margin-bottom: 0.25em;
  text-shadow: 0 0.075em 0.075em rgba(0, 0, 0, 0.65);
}

#cs-content .x-btn.x-btn-real {
  box-shadow: 0 0.25em 0 0 <?php echo $cs_v1_button_bottom_color; ?>, 0 4px 9px rgba(0, 0, 0, 0.75);
}

#cs-content .x-btn.x-btn-real:hover {
  box-shadow: 0 0.25em 0 0 <?php echo $cs_v1_button_bottom_color_hover; ?>, 0 4px 9px rgba(0, 0, 0, 0.75);
}


/*
// Button Style - Flat
*/

#cs-content .x-btn.x-btn-flat,
#cs-content .x-btn.x-btn-flat:hover {
  margin-bottom: 0;
  text-shadow: 0 0.075em 0.075em rgba(0, 0, 0, 0.65);
  box-shadow: none;
}


/*
// Button Style - Transparent
*/

#cs-content .x-btn.x-btn-transparent,
#cs-content .x-btn.x-btn-transparent:hover {
  margin-bottom: 0;
  border-width: 3px;
  text-shadow: none;
  text-transform: uppercase;
  background-color: transparent;
  box-shadow: none;
}