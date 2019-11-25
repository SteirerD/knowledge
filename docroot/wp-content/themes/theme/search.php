<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wiki
 */

get_header();
?>

  <main class="c-main-site__content-area c-main-site__content-area--search">

    <section class="c-search">
  
      <?php if ( have_posts() ) : ?>

        <header class="c-search__header">
          <h1 class="c-search__header-title">
            <?php
              /* translators: %s: search query. */
              printf( esc_html__( 'Suchergebnisse für: %s', 'wiki' ), '<span>' . get_search_query() . '</span>' );
            ?>
          </h1>
        </header><!-- .page-header -->
    
        <?php
        /* Start the Loop */
        while ( have_posts() ) :
          the_post();
      
          /**
           * Run the loop for the search to output the results.
           * If you want to overload this in a child theme then include a file
           * called content-search.php and that will be used instead.
           */
          get_template_part( 'template-parts/content', 'search' );
    
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
