<?php
/**
 * The template for displaying post meta
 */
 ?>
									<div class="meta-wrap">
										<ul class="meta">
											<li><?php _e( 'Posted In:', 'north' ); ?> <?php the_category(', '); ?></li>
											<?php
											$posttags = get_the_tags();
											if ($posttags) { ?>
												<li><?php _e( 'Tags:', 'north' ); ?> <?php the_tags( '', ', ', '' ); ?></li>
											<?php } ?>
										</ul>

										<ul class="share">
											<li>
												<a class="share-toggle" href="#"><?php _e( 'Share Post', 'north' ); ?></a>
												<ul class="share-list">
													<li class="share-twitter"><a onclick="window.open('http://twitter.com/home?status=<?php the_title_attribute(); ?> - <?php the_permalink(); ?>','twitter','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://twitter.com/home?status=<?php the_title_attribute(); ?> - <?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="blank"><span><?php _e( 'Twitter', 'north' ); ?></span> <i class="fa fa-twitter-square"></i></a></li>
													<li class="share-facebook"><a onclick="window.open('http://www.facebook.com/share.php?u=<?php the_permalink(); ?>','facebook','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"  target="blank"><span><?php _e( 'Facebook', 'north' ); ?></span> <i class="fa fa-facebook-square"></i></a></li>
													<li class="share-google"><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','gplusshare','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;"><span><?php _e( 'Google', 'north' ); ?></span> <i class="fa fa-google-plus-square"></i></a></li>
												</ul>
											</li>
										</ul><!-- share -->
									</div><!-- meta wrap -->