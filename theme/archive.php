<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wiki
 */

get_header();
?>

  <main class="c-main-site__content-area c-main-site__content-area--archive">

    <section class="c-archive c-archive--<?php echo get_post_type(); ?>">
  
      <?php if ( have_posts() ) : ?>

        <?php
        $page_id = get_queried_object_id();
        var_dump(get_field('blog_private', get_category($page_id)));?>
        <header class="c-page-header">
          <?php
            the_archive_title( '<h1 class="c-page-header__title">', '</h1>' );
            the_archive_description( '<div class="c-page-header__description">', '</div>' );
          ?>
        </header><!-- .page-header -->
    
        <?php
        /* Start the Loop */
        while ( have_posts() ) :
          the_post();
      
          /*
           * Include the Post-Type-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Type name) and that will be used instead.
           */
          get_template_part( 'template-parts/content', get_post_type() );
    
        endwhile;
    
        the_posts_navigation();
  
      else :
    
        get_template_part( 'template-parts/content', 'none' );
  
      endif;
      ?>
      
    </section>

  </main><!-- #main -->

<?php
get_sidebar();
get_footer();
