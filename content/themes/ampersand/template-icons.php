<?php
/**
 * Template for the icon toggles in the footer.
 *
 * @package Ampersand
 * @since Ampersand 1.0
 */

?>


							<?php if (
								get_option( 'ampersand_customizer_icon_twitter' ) ||
								get_option( 'ampersand_customizer_icon_facebook' ) ||
								get_option( 'ampersand_customizer_icon_instagram' ) ||
								get_option( 'ampersand_customizer_icon_tumblr' ) ||
								get_option( 'ampersand_customizer_icon_dribbble' ) ||
								get_option( 'ampersand_customizer_icon_flickr' ) ||
								get_option( 'ampersand_customizer_icon_pinterest' ) ||
								get_option( 'ampersand_customizer_icon_googleplus' ) ||
								get_option( 'ampersand_customizer_icon_vimeo' ) ||
								get_option( 'ampersand_customizer_icon_youtube' ) ||
								get_option( 'ampersand_customizer_icon_linkedin' ) ||
								get_option( 'ampersand_customizer_icon_facebook' ) ||
								get_option( 'ampersand_customizer_icon_snapchat' ) ||
								get_option( 'ampersand_customizer_icon_rss' ) ) {
							?>
								<div class="icons">
									<div class="icons-widget">
										<div class="fa fa-links">
											<?php if ( get_option( 'ampersand_customizer_icon_twitter' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_twitter' ) ); ?>" class="twitter-icon" title="<?php esc_attr_e( 'Twitter','ampersand' ); ?>"><i class="fa fa-twitter-square"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_facebook' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_facebook' ) ); ?>" class="facebook-icon" title="<?php esc_attr_e( 'Facebook','ampersand' ); ?>"><i class="fa fa-facebook-square"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_instagram' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_instagram' ) ); ?>" class="tumblr-instagram" title="<?php esc_attr_e( 'Instagram','ampersand' ); ?>"><i class="fa fa-instagram"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_tumblr' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_tumblr' ) ); ?>" class="tumblr-icon" title="<?php esc_attr_e( 'Tumblr','ampersand' ); ?>"><i class="fa fa-tumblr-square"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_dribbble' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_dribbble' ) ); ?>" class="dribbble-icon" title="<?php esc_attr_e( 'Dribbble','ampersand' ); ?>"><i class="fa fa-dribbble"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_flickr' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_flickr' ) ); ?>" class="flickr-icon" title="<?php esc_attr_e( 'Flickr','ampersand' ); ?>"><i class="fa fa-flickr"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_pinterest' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_pinterest' ) ); ?>" class="pinterest-icon" title="<?php esc_attr_e( 'Pinterest','ampersand' ); ?>"><i class="fa fa-pinterest"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_googleplus' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_googleplus' ) ); ?>" class="google-icon" title="<?php esc_attr_e( 'Google+','ampersand' ); ?>"><i class="fa fa-google-plus-square"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_vimeo' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_vimeo' ) ); ?>" class="vimeo-icon" title="<?php esc_attr_e( 'Vimeo','ampersand' ); ?>"><i class="fa fa-play"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_youtube' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_youtube' ) ); ?>" class="youtube-icon" title="<?php esc_attr_e( 'YouTube','ampersand' ); ?>"><i class="fa fa-youtube-square"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_linkedin' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_linkedin' ) ); ?>" class="linkedin-icon" title="<?php esc_attr_e( 'LinkedIn','ampersand' ); ?>"><i class="fa fa-linkedin-square"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_snapchat' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_snapchat' ) ); ?>" class="snapchat-icon" title="<?php esc_attr_e( 'Snapchat','ampersand' ); ?>"><i class="fa fa-snapchat"></i></a>
											<?php } ?>

											<?php if ( get_option( 'ampersand_customizer_icon_rss' ) ) { ?>
												<a href="<?php echo esc_url( get_option( 'ampersand_customizer_icon_rss' ) ); ?>" class="feed-icon" title="<?php esc_attr_e( 'RSS','ampersand' ); ?>"><i class="fa fa-rss-square"></i></a>
											<?php } ?>
										</div><!-- .fa fa-links -->
									</div><!-- .icons-widget -->
								</div><!-- .icons -->
							<?php } ?>
