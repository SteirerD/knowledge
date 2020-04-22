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
      <div class="l-container">
      <?php if ( have_posts() ) : ?>
      
        <header class="c-search__header">
            <h1 class="c-search__header-title">
              <?php
                /* translators: %s: search query. */
                printf( esc_html__( 'Suchergebnisse für: %s', 'wiki' ), '<span>' . get_search_query() . '</span>' );
              ?>
            </h1>
        </header><!-- .page-header -->
        <div class="c-posts__posts-outer-wrapper">
        <?php
        /* Start the Loop */
        while ( have_posts() ) :
          the_post();
      
          /**
           * Run the loop for the search to output the results.
           * If you want to overload this in a child theme then include a file
           * called content-search.php and that will be used instead.
           */
          
          //don´t show results which contain at least one private category
          $contains_private_cat = false;
          $cats = get_the_category();
          foreach ($cats as $cat) {
            if(get_field( 'blog_private', $cat))
            $contains_private_cat = true;
          }
          if( is_user_logged_in() || ! $contains_private_cat )
          get_template_part( 'template-parts/content', 'search' );
    
        endwhile;
    
        the_posts_navigation();
  
      else :
    
        get_template_part( 'template-parts/content', 'none' );
  
      endif;
      ?>

        </div>
      </div>
    </section>

  </main><!-- #main -->

<?php
get_footer();
