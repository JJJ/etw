<?php

// =============================================================================
// WOOCOMMERCE/SINGLE-PRODUCT-REVIEWS.PHP
// -----------------------------------------------------------------------------
// @version 3.6.0
// =============================================================================

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
  return;
}

global $product;

$stack         = x_get_stack();
$stack_comment = 'x_' . $stack . '_comment';

if ( $stack == 'ethos' ) {
  $placeholder_name    = ' placeholder="' . __( 'Your Name *', 'woocommerce' ) . '"';
  $placeholder_email   = ' placeholder="' . __( 'Your Email *', 'woocommerce' ) . '"';
  $placeholder_comment = ' placeholder="' . __( 'Your Comment *', 'woocommerce' ) . '"';
} else {
  $placeholder_name    = '';
  $placeholder_email   = '';
  $placeholder_comment = '';
}

?>

<div id="reviews" class="woocommerce-Reviews">
  <div id="comments" class="x-comments-area">

    <h2 class="woocommerce-Reviews-title">
      <?php
      $count = $product->get_review_count();
      if ( $count && wc_review_ratings_enabled() ) {
        /* translators: 1: reviews count 2: product name */
        $reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
        echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
      } else {
        esc_html_e( 'Reviews', 'woocommerce' );
      }
      ?>
    </h2>

    <?php if ( have_comments() ) : ?>
      <ol class="x-comments-list">
        <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => $stack_comment ) ) ); ?>
      </ol>
      <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <nav class="x-pagination">
          <?php
          paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'type'      => 'list',
          ) ) );
          ?>
        </nav>
      <?php endif; ?>
    <?php else : ?>
      <p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
    <?php endif; ?>

  </div>

  <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

    <div id="review_form_wrapper">
      <div id="review_form">

        <?php

        $commenter = wp_get_current_commenter();

        $comment_form = array(
          'title_reply'          => have_comments() ? __( '<span>Add a Review</span>', 'woocommerce' ) : __( 'Be the First to Review', 'woocommerce' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
          'title_reply_to'       => __( 'Leave a Reply to %s', 'woocommerce' ),
          'comment_notes_before' => '',
          'comment_notes_after'  => '',
          'fields'               => array(
            'author' => '<p class="comment-form-author">'
                        . '<label for="author">' . __( 'Name', 'woocommerce' ) . ' <span class="required">*</span></label>'
                        . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $placeholder_name . ' /></p>',
            'email'  => '<p class="comment-form-email">'
                        . '<label for="email">' . __( 'Email', 'woocommerce' ) . ' <span class="required">*</span></label>'
                        . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $placeholder_email . ' /></p>',
          ),
          'label_submit'  => __( 'Submit Review', 'woocommerce' ),
          'logged_in_as'  => '',
          'comment_field' => ''
        );

        if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {

          $comment_form['comment_field'] = '<select name="rating" id="rating">
                                              <option value="">'  . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
                                              <option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
                                              <option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
                                              <option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
                                              <option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
                                              <option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
                                            </select>';

        }

        $comment_form['comment_field'] .= '<p class="comment-form-comment">'
                                          // . '<label for="comment">' . __( 'Your Review', 'woocommerce' ) . '</label>'
                                          . '<textarea id="comment" name="comment" cols="45" rows="8"' . $placeholder_comment . '></textarea></p>';

        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );

        ?>

      </div>
    </div>

  <?php else : ?>

    <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

  <?php endif; ?>

  <div class="clear"></div>
</div>
