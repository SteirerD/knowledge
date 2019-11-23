<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GLC
 */

get_header();
?>

  <main class="c-main-site__content-area c-main-site__content-area--archive">

    <section class="c-archive c-archive--<?php echo get_post_type(); ?>">
      
      <?php if ( have_posts() ) : ?>
        
        <?php
        /* Start the Loop */
        while ( have_posts() ) : the_post();
          
          /*
           * Include the Post-Type-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Type name) and that will be used instead.
           */
          get_template_part( 'template-parts/content', get_post_type() );
          ?>
          <div class="testslider">
            <div class="slider">
              <h1>slider 1</h1>
              <img src="https://glc.steirer.info/wp-content/uploads/2019/09/canstockphoto7734492.jpg">
            </div>
            <div class="slider">
              <h1>slider 2</h1>
              <img src="https://glc.steirer.info/wp-content/uploads/2019/09/canstockphoto7480444.jpg">
            </div>
            <div class="slider">
              <h1>slider 3</h1>
              <img src="https://glc.steirer.info/wp-content/uploads/2019/09/canstockphoto7252686.jpg">
            </div>
            <div class="slider">
              <h1>slider 4</h1>
              <img src="https://glc.steirer.info/wp-content/uploads/2019/09/canstockphoto7734492.jpg">
            </div>
            <div class="slider">
              <h1>slider 5</h1>
              <img src="https://glc.steirer.info/wp-content/uploads/2019/09/canstockphoto7480444.jpg">
            </div>
            <div class="slider">
              <h1>slider 6</h1>
              <img src="https://glc.steirer.info/wp-content/uploads/2019/09/canstockphoto7252686.jpg">
            </div>
          </div>
          <?php
        
        endwhile;
        
      else :
        
        get_template_part( 'template-parts/content', 'none' );
      
      endif;
      ?>

    </section>

  </main><!-- #main -->

<?php
get_footer();
