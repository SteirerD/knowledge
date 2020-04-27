<?php
  /**
   * Block Name: Top Categories
   *
   * This is the template that displays the Top Categories.
   */
  
  $categories = get_categories();
  shuffle($categories);
 // var_dump($categories);
  
  if(! is_user_logged_in()) { // if no user logged in remove private categories
    foreach ($categories as $c => $category) {
      if(get_field('blog_private', $category) ) {
        unset($categories[$c]);
      }
    }
  }
  
  $cat_count = get_field('top_cat_cat_count') ? get_field('top_cat_cat_count') : '3';
  // create align class ("alignwide") from block setting ("wide")
  $align_class = $block['align'] ? 'align' . $block['align'] : '';
?>
<?php if(is_admin()): ?>
  <div class="GutenbergTitleCustomBlock"><h3>Top Kategorien</h3></div>
<?php endif; ?>
<div class="c-topcategories <?php echo esc_attr( $align_class )?>">
  <div class="l-container">
    <div class="c-topcategories__inner-wrapper l-row">
  <?php for ($i = 1; $i <= $cat_count; $i++):
    $args = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => 5,
      'cat' => $categories[$i]->term_id,
    );
    $blog_query = new WP_Query( $args );
    ?>
      <div class="c-topcategories_block_outerwrapper l-col l-col-4 l-col-m-12">
        <div class="c-topcategories_block_innerwrapper">
          <?php echo '<h3 class="c-topcategories__category">'.$categories[$i]->name.'</h3>';
          echo '<ul class="c-topcategories__category-list list-item-white">';
          if ( $blog_query->have_posts() ) :
            while ( $blog_query->have_posts() ) : $blog_query->the_post();
            echo '<li class="c-topcategories__blog-title">'.get_the_title().'';
            echo '<a class="c-topcategories__blog-title-link" href="'.get_the_permalink().'"></a>';
            echo '<div class="c-topcategories__blog-title-preview" style="opacity: 0; visibility: hidden">';
            echo the_excerpt();
            echo '<a class="c-topcategories__blog-title-link-preview o-button" href="'.get_the_permalink().'">'.__("mehr erfahren", "wiki").'</a>';
            echo '</div>';
            echo '</li>';
          endwhile;
          echo '</ul>';
          endif;?>
          
        </div>
      </div>
      <?php
      wp_reset_postdata();
    endfor; ?>
    </div>
  </div>
</div>


