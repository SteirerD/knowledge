<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wiki
 */

get_header();
?>

  <main class="c-main-site__content-area c-main-site__content-area--page">
    <div class="l-container">
    
    <?php
      while ( have_posts() ) : the_post();
  
        get_template_part( 'template-parts/content', get_post_type() );
  
        //the_post_navigation();
        
      
      endwhile; // End of the loop.
    ?>
    </div>
  </main><!-- #main -->

<?php
//get_sidebar();
get_footer();
