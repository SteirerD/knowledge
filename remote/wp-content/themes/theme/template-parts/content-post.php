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
        <div class="c-single-post__date">
          <?php echo get_the_author_meta('first_name'), ' ', get_the_author_meta('last_name'),', ';?>
          <?php echo date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ); ?>
        </div>
        <h1 class="c-single-post__title"><?php the_title(); ?></h1>
      </header>
      
      <div class="c-single-post__content">
        <?php the_content();?>
      </div>
    
    </div>
  
  </div><!-- #post-<?php the_ID(); ?> -->

</div>

