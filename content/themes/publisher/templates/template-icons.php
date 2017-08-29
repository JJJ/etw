<?php
/**
 * Template for the icon toggles in the header.
 *
 * @package Publisher
 * @since Publisher 1.0
 */

?>

			<div class="header-search">
				<ul class="toggle-icons">
					<?php if ( get_option( 'publisher_customizer_icon_twitter' ) ||
						get_option( 'publisher_customizer_icon_facebook' ) ||
						get_option( 'publisher_customizer_icon_instagram' ) ||
						get_option( 'publisher_customizer_icon_tumblr' ) ||
						get_option( 'publisher_customizer_icon_dribbble' ) ||
						get_option( 'publisher_customizer_icon_flickr' ) ||
						get_option( 'publisher_customizer_icon_pinterest' ) ||
						get_option( 'publisher_customizer_icon_googleplus' ) ||
						get_option( 'publisher_customizer_icon_vimeo' ) ||
						get_option( 'publisher_customizer_icon_youtube' ) ||
						get_option( 'publisher_customizer_icon_linkedin' ) ||
						get_option( 'publisher_customizer_icon_facebook' ) ||
						get_option( 'publisher_customizer_icon_rss' ) ||
						get_option( 'publisher_customizer_icon_email' ) ||
						get_option( 'publisher_customizer_icon_github' ) ||
						get_option( 'publisher_customizer_icon_itunes' ) ) {
					?>
						<li><a class="toggle-social" href="#" title="<?php esc_attr_e( __( 'Links', 'publisher' ) ); ?>"><?php esc_html_e( 'Links', 'publisher' ); ?></a></li>
					<?php } ?>

					<li><a class="toggle-search" href="#" title="<?php esc_attr_e( __( 'Search', 'publisher' ) ); ?>"><?php esc_html_e( 'Search', 'publisher' ); ?></a></li>
				</ul>

				<div class="toggle-boxes">
					<?php if ( get_option( 'publisher_customizer_icon_twitter' ) ||
						get_option( 'publisher_customizer_icon_facebook' ) ||
						get_option( 'publisher_customizer_icon_instagram' ) ||
						get_option( 'publisher_customizer_icon_tumblr' ) ||
						get_option( 'publisher_customizer_icon_dribbble' ) ||
						get_option( 'publisher_customizer_icon_flickr' ) ||
						get_option( 'publisher_customizer_icon_pinterest' ) ||
						get_option( 'publisher_customizer_icon_googleplus' ) ||
						get_option( 'publisher_customizer_icon_vimeo' ) ||
						get_option( 'publisher_customizer_icon_youtube' ) ||
						get_option( 'publisher_customizer_icon_linkedin' ) ||
						get_option( 'publisher_customizer_icon_facebook' ) ||
						get_option( 'publisher_customizer_icon_rss' ) ||
						get_option( 'publisher_customizer_icon_email' ) ||
						get_option( 'publisher_customizer_icon_github' ) ||
						get_option( 'publisher_customizer_icon_itunes' ) ) {
					?>
						<div class="toggle-box toggle-box-social">
							<div class="icons">
								<div class="icons-widget">
									<div class="icon-links">
										<?php if ( get_option( 'publisher_customizer_icon_twitter' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_twitter' ) ); ?>" class="twitter-icon" title="<?php esc_attr_e( __( 'Twitter', 'publisher' ) ); ?>"><i class="fa fa-twitter-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_facebook' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_facebook' ) ); ?>" class="facebook-icon" title="<?php esc_attr_e( __( 'Facebook', 'publisher' ) ); ?>"><i class="fa fa-facebook-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_instagram' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_instagram' ) ); ?>" class="tumblr-instagram" title="<?php esc_attr_e( __( 'Instagram', 'publisher' ) ); ?>"><i class="fa fa-instagram"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_tumblr' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_tumblr' ) ); ?>" class="tumblr-icon" title="<?php esc_attr_e( __( 'Tumblr','publisher' ) ); ?>"><i class="fa fa-tumblr-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_dribbble' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_dribbble' ) ); ?>" class="dribbble-icon" title="<?php esc_attr_e( __( 'Dribbble', 'publisher' ) ); ?>"><i class="fa fa-dribbble"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_flickr' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_flickr' ) ); ?>" class="flickr-icon" title="<?php esc_attr_e( __( 'Flickr', 'publisher' ) ); ?>"><i class="fa fa-flickr"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_pinterest' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_pinterest' ) ); ?>" class="pinterest-icon" title="<?php esc_attr_e( __( 'Pinterest', 'publisher' ) ); ?>"><i class="fa fa-pinterest"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_googleplus' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_googleplus' ) ); ?>" class="google-icon" title="<?php esc_attr_e( __( 'Google+', 'publisher') ); ?>"><i class="fa fa-google-plus-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_vimeo' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_vimeo' ) ); ?>" class="vimeo-icon" title="<?php esc_attr_e( __( 'Vimeo', 'publisher' ) ); ?>"><i class="fa fa-vimeo-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_youtube' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_youtube' ) ); ?>" class="youtube-icon" title="<?php esc_attr_e( __( 'YouTube', 'publisher' ) ); ?>"><i class="fa fa-youtube-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_linkedin' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_linkedin' ) ); ?>" class="linkedin-icon" title="<?php esc_attr_e( __( 'LinkedIn', 'publisher' ) ); ?>"><i class="fa fa-linkedin-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_rss' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_rss' ) ); ?>" class="feed-icon" title="<?php esc_attr_e( __( 'RSS', 'publisher' ) ); ?>"><i class="fa fa-rss-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_email' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_email' ) ); ?>" class="email-icon" title="<?php esc_attr_e( __( 'Email', 'publisher' ) ); ?>"><i class="fa fa-envelope"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_github' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_github' ) ); ?>" class="github-icon" title="<?php esc_attr_e( __( 'Github', 'publisher' ) ); ?>"><i class="fa fa-github-square"></i></a>
										<?php } ?>

										<?php if ( get_option( 'publisher_customizer_icon_itunes' ) ) { ?>
											<a href="<?php echo esc_url( get_option( 'publisher_customizer_icon_itunes' ) ); ?>" class="itunes-icon" title="<?php esc_attr_e( __( 'iTunes', 'publisher' ) ); ?>"><i class="fa fa-apple"></i></a>
										<?php } ?>
									</div><!-- .icon-links -->
								</div><!-- .icons-widget -->
							</div><!-- .icons -->
						</div><!-- .toggle-box -->
					<?php } ?>

					<div class="toggle-box toggle-box-search">
						<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
							<label for="header-search-submit" class="assistive-text"><?php _e( 'Search', 'publisher' ); ?></label>
							<input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Type here and press enter.', 'publisher' ) ?>" class="header-search-input" />
						</form>
					</div><!-- .toggle-box -->

				</div><!-- .toggle-boxes -->
			</div><!-- .header-search -->