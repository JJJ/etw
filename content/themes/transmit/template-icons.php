 <?php
/**
 * Template for the social media icons.
 *
 * @package Transmit
 * @since Transmit 1.0
 */

?>


							<?php if ( get_option('transmit_customizer_icon_twitter') ||
								get_option('transmit_customizer_icon_facebook') ||
								get_option('transmit_customizer_icon_instagram') ||
								get_option('transmit_customizer_icon_tumblr') ||
								get_option('transmit_customizer_icon_dribbble') ||
								get_option('transmit_customizer_icon_flickr') ||
								get_option('transmit_customizer_icon_pinterest') ||
								get_option('transmit_customizer_icon_googleplus') ||
								get_option('transmit_customizer_icon_vimeo') ||
								get_option('transmit_customizer_icon_youtube') ||
								get_option('transmit_customizer_icon_linkedin') ||
								get_option('transmit_customizer_icon_facebook') ||
								get_option('transmit_customizer_icon_rss') ) {
							?>
								<div class="social-cards">
									<div class="cards">
										<?php if ( get_option('transmit_customizer_icon_twitter') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_twitter'); ?>" class="card card-twitter">
												<span class="card-link centerHorizontal centerVertical">
													<i class="fa fa-twitter"></i>
													<div class="card-text"><?php _e('Twitter','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_dribbble') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_dribbble'); ?>" class="card card-dribbble">
												<span class="card-link">
													<i class="fa fa-dribbble"></i>
													<div class="card-text"><?php _e('Dribbble','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_facebook') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_facebook'); ?>" class="card card-facebook">
												<span class="card-link">
													<i class="fa fa-facebook"></i>
													<div class="card-text"><?php _e('Facebook','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_github') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_github'); ?>" class="card card-github">
												<span class="card-link">
													<i class="fa fa-github"></i>
													<div class="card-text"><?php _e('Github','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_instagram') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_instagram'); ?>" class="card card-instagram">
												<span class="card-link">
													<i class="fa fa-instagram"></i>
													<div class="card-text"><?php _e('Instagram','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_vimeo') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_vimeo'); ?>" class="card card-vimeo">
												<span class="card-link">
													<i class="fa fa-play"></i>
													<div class="card-text"><?php _e('Vimeo','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_tumblr') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_tumblr'); ?>" class="card card-tumblr">
												<span class="card-link">
													<i class="fa fa-tumblr"></i>
													<div class="card-text"><?php _e('Tumblr','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_linkedin') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_linkedin'); ?>" class="card card-linkedin">
												<span class="card-link">
													<i class="fa fa-linkedin"></i>
													<div class="card-text"><?php _e('LinkedIn','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_flickr') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_flickr'); ?>" class="card card-flickr">
												<span class="card-link">
													<i class="fa fa-flickr"></i>
													<div class="card-text"><?php _e('Flickr','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_googleplus') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_googleplus'); ?>" class="card card-google">
												<span class="card-link">
													<i class="fa fa-google-plus"></i>
													<div class="card-text"><?php _e('Google+','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_rss') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_rss'); ?>" class="card card-rss">
												<span class="card-link">
													<i class="fa fa-rss"></i>
													<div class="card-text"><?php _e('RSS','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_youtube') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_youtube'); ?>" class="card card-youtube">
												<span class="card-link">
													<i class="fa fa-youtube"></i>
													<div class="card-text"><?php _e('YouTube','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>

										<?php if ( get_option('transmit_customizer_icon_pinterest') ) { ?>
											<a href="<?php echo get_option('transmit_customizer_icon_pinterest'); ?>" class="card card-pinterest">
												<span class="card-link">
													<i class="fa fa-pinterest"></i>
													<div class="card-text"><?php _e('Pinterest','transmit'); ?></div>
												</span>
											</a>
										<?php } ?>
									</div><!-- cards -->
								</div><!-- section -->
							<?php } ?>