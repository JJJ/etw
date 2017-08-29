<?php
/**
 * The template for displaying the Portfolio archive page.
 *
 * @package Meteor
 */

 get_header();

 $archive_style = get_theme_mod( 'meteor_portfolio_archive_style', 'grid' );

 if ( $archive_style == 'grid' ) {
     $section_class = 'section-portfolio-grid';
 } else if ( $archive_style == 'masonry' ) {
     $section_class = 'section-portfolio-grid section-portfolio-masonry';
 } else if ( $archive_style == 'blocks' ) {
     $section_class = 'section-portfolio-blocks';
 }
 ?>

 <div id="primary" class="content-area">
     <main id="main" class="site-main">

         <div class="section-portfolio <?php echo $section_class; ?>">
         <?php
             if ( have_posts() ) :

             while ( have_posts() ) : the_post();

                 if ( $archive_style == 'grid' ) {
                     get_template_part( 'template-parts/content-portfolio-grid' );
                 } else if ( $archive_style == 'masonry' ) {
                     get_template_part( 'template-parts/content-portfolio-masonry' );
                 } else if ( $archive_style == 'blocks' ) {
                     get_template_part( 'template-parts/content-portfolio-block' );
                 }

             endwhile;

             else :

             get_template_part( 'template-parts/content-none' );

             endif;
         ?>
         </div><!-- .section-portfolio -->

         <?php
              meteor_page_navs();
              wp_reset_postdata();
         ?>

     </main><!-- #main -->
 </div><!-- #primary -->

 <?php get_footer(); ?>
