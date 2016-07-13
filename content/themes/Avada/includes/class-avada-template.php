<?php

class Avada_Template {

    public function __construct() {

        global $content_width;
        if ( ! isset( $content_width ) || empty( $content_width ) ) {
        	$content_width = '669';
        }

    }

    public static function comment_template( $comment, $args, $depth ) { ?>
    	<?php $add_below = ''; ?>
    	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
            <div class="the-comment">
                <div class="avatar"><?php echo get_avatar( $comment, 54 ); ?></div>
                <div class="comment-box">
                    <div class="comment-author meta">
                        <strong><?php echo get_comment_author_link(); ?></strong>
                        <?php printf( __( '%1$s at %2$s', 'Avada' ), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( ' - Edit', 'Avada' ),'  ','' ); ?><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( ' - Reply', 'Avada' ), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </div>
                    <div class="comment-text">
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em><?php _e( 'Your comment is awaiting moderation.', 'Avada' ); ?></em>
                            <br />
                        <?php endif; ?>
                        <?php comment_text() ?>
                    </div>
                </div>
            </div>
        <?php
    }

}
