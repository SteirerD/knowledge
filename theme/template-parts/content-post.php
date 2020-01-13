<?php
  /**
   * Template part for displaying posts
   *
   * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
   *
   * @package Vinoble Cosmetics
   */

?>
<div class="c-single-post">
  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <div class="c-single-post__image">
      <?php the_post_thumbnail( 'post-detail' ); ?>
    </div>
    
    <div class="c-single-post__inner">
      
      <header class="c-single-post__header">
        <h1 class="c-single-post__title"><?php the_title(); ?></h1>
      </header>
      <div class="c-posts__categories"><?php
          $cats = get_the_category();
          foreach ( $cats as $cat ) {
            echo '<a class="c-posts__categories-category" href="' . get_term_link( $cat->term_id ) . '">' . $cat->name . '</a>';
          }
        ?>
      </div>
      
      <div class="c-single-post__content">
        <?php the_content();?>
      </div>
    
    </div>
  
  </div><!-- #post-<?php the_ID(); ?> -->

</div>

