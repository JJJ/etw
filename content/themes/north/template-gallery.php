				<!-- Grab the video -->
				<?php if ( get_post_meta( $post->ID, 'video', true ) ) { ?>
					<div class="fitvid">
						<?php echo get_post_meta( $post->ID, 'video', true ) ?>
					</div>
				<?php } else { ?>

					<!-- Otherwise grab the gallery -->
					<?php if ( 'gallery' == get_post_format() ) { ?>
						<?php if ( function_exists( 'array_gallery' ) ) { array_gallery(); } ?>
					<?php } else { ?>

						<!-- If there is no gallery, just grab the featured image -->
						<?php if ( has_post_thumbnail() ) { ?>
							<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'north' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'large-image' ); ?></a>
						<?php } ?>

					<?php } ?>
				<?php } ?>