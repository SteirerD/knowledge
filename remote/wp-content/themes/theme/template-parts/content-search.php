<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wiki
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('c-entry c-entry--search'); ?>>
  <div class="c-posts__post-wrapper">

    <h3 class="c-posts__heading"><?php echo the_title() ?></h3>
    <div class="c-posts__categories"><?php
        $cats = get_the_category();
        foreach ( $cats as $cat ) {
          echo '<a class="c-posts__categories-category" href="' . get_term_link( $cat->term_id ) . '">' . $cat->name . '</a>';
        }
      ?>
    </div>
    <div class="c-posts__excerpt"><?php echo the_excerpt(); ?></div>
    <a class="o-button o-button--small" href="<?php echo get_the_permalink()?>"><?php _e('mehr erfahren', 'wiki') ?></a>
  </div>
</article><!-- #post-<?php the_ID(); ?> -->
