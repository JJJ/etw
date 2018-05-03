<div class="tco-overlay tco-overlay-box-content">
	<a class="tco-overlay-close" href="#" data-tco-toggle="<?php echo $box_class; ?> .tco-overlay"><?php cs_tco()->admin_icon( 'no' ); ?></a>

<?php

if ( has_action( '_cornerstone_validation_overlay' ) ) :

	do_action( '_cornerstone_validation_overlay' );
	echo '</div>';
	return;

endif; ?>

	<h4 class="tco-box-content-title"><?php _e( 'How do I unlock this feature?', 'cornerstone' ); ?></h4>
	<p><?php _e( 'If you have already purchased Cornerstone from CodeCanyon, you can find your purchase code <a href="https://theme.co/apex/images/find-cornerstone-purchase-code.png" target="_blank">here</a>. If you do not have a license or need to get another, you can <a href="https://theme.co/go/join-validation-cs.php" target="_blank">purchase</a> one.', 'cornerstone' ); ?></p>
	<h4 class="tco-box-content-title"><?php _e( 'Where do I enter my purchase code?', 'cornerstone' ); ?></h4>
	<p><?php printf( __( 'Once you have a purchase code you can <a %s href="#">enter</a> it in the input at the top of this page.', 'cornerstone' ), 'data-tco-focus="validation-input"' ) ; ?></p>
</div>