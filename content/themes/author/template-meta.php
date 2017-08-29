<?php
/**
 * Template for the post meta, which includes share links, tags and categories.
 *
 * @package Author
 * @since Author 1.0
 */
?>


	<div class="bar">
		<div class="bar-frame clearfix">
			<div class="share">
				<!-- google plus -->
				<a class="share-google" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','gplusshare','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;"><i class="fa fa-google-plus-square"></i></a>

				<!-- facebook -->
				<a class="share-facebook" onclick="window.open('http://www.facebook.com/share.php?u=<?php the_permalink(); ?>','facebook','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"  target="blank"><i class="fa fa-facebook-square"></i></a>

				<!-- twitter -->
				<a class="share-twitter" onclick="window.open('http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>','twitter','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="blank"><i class="fa fa-twitter-square"></i></a>
			</div><!-- share -->

			<?php if( is_page() ) {} else { ?>
				<div class="bar-categories">
					<?php if ( has_category() ) { ?>
						<div class="categories">
							<i class="fa fa-list-ul"></i>
							<?php the_category(', '); ?>
						</div>
					<?php } ?>

				  	<?php the_tags('<div class="tags">
				  		<i class="fa fa-tag"></i>
				  		',', ','
				  	</div>'); ?>
			  	</div><!-- bar categories -->
		  	<?php } ?>
		</div><!-- bar frame -->
	</div><!-- bar -->