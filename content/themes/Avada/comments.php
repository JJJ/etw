<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="no-comments"><?php echo __('This post is password protected. Enter the password to view comments.', 'Avada'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>

	<div id="comments" class="comments-container">
		<?php
			ob_start();
			comments_number(__('No Comments', 'Avada'), __('One Comment', 'Avada'), '% '.__('Comments', 'Avada'));
			echo do_shortcode( sprintf( '[title size="2" content_align="left" style_type="default"]%s[/title]', ob_get_clean() ) ); 			
		?>
		<ol class="commentlist">
			<?php wp_list_comments('callback=avada_comment'); ?>
		</ol>

		<div class="comments-navigation">
			<div class="alignleft"><?php previous_comments_link(); ?></div>
			<div class="alignright"><?php next_comments_link(); ?></div>
		</div>
	</div>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="no-comments"><?php echo __('Comments are closed.', 'Avada'); ?></p>

	<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>

	<?php
	function modify_comment_form_fields($fields){
		$commenter = wp_get_current_commenter();
		$req	   = get_option( 'require_name_email' );

		$fields['author'] = '<div id="comment-input"><input type="text" name="author" id="author" value="'. esc_attr( $commenter['comment_author'] ) .'" placeholder="'. __("Name (required)", "Avada").'" size="22" tabindex="1" '. ( $req ? 'aria-required="true"' : '' ).' class="input-name" />';

		$fields['email'] = '<input type="text" name="email" id="email" value="'. esc_attr( $commenter['comment_author_email'] ) .'" placeholder="'. __("Email (required)", "Avada").'" size="22" tabindex="2" '. ( $req ? 'aria-required="true"' : '' ).' class="input-email"  />';

		$fields['url'] = '<input type="text" name="url" id="url" value="'. esc_attr( $commenter['comment_author_url'] ) .'" placeholder="'. __("Website", "Avada").'" size="22" tabindex="3" class="input-website" /></div>';

		return $fields;
	}
	add_filter('comment_form_default_fields','modify_comment_form_fields');	
				
	$comments_args = array(
		'title_reply' => do_shortcode( sprintf( '[title size="2" content_align="left" style_type="default"]%s[/title]', __("Leave A Comment", "Avada") ) ),
		'title_reply_to' => do_shortcode( sprintf( '[title size="2" content_align="left" style_type="default"]%s[/title]', __("Leave A Comment", "Avada") ) ),
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( "You must be %slogged in%s to post a comment.", "Avada" ), '<a href="'.wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ).'">', '</a>' ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . __( "Logged in as","Avada" ).' <a href="' .admin_url( "profile.php" ).'">'.$user_identity.'</a>. <a href="' .wp_logout_url(get_permalink()).'" title="' . __("Log out of this account", "Avada").'">'. __("Log out &raquo;", "Avada").'</a></p>',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'comment_field' => '<div id="comment-textarea"><textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment" placeholder="'. __("Comment...", "Avada").'"></textarea></div>',
		'id_submit' => 'comment-submit',
		'class_submit' => 'fusion-button fusion-button-default',
		'label_submit'=> __("Post Comment", "Avada"),
	);

	comment_form($comments_args);
	?>

<?php endif; // if you delete this the sky will fall on your head ?>