<?php
  /**
   * Block Name: Posts
   *
   * This is the template that displays the Top Categories.
   */
  
  $categories = get_categories();
  shuffle( $categories );
  $exc_cat = array();
  
  if ( !is_user_logged_in() ) { // if no user logged in remove private categories
    foreach ( $categories as $c => $category ) {
      if ( get_field( 'blog_private', $category ) ) {
        $exc_cat = $category->term_id;
        unset( $categories[$c] );
      }
    }
  }
  $cat_ids = array();
  
  foreach ( $categories as $category ) {
    $cat_ids = $category->term_id;
  }
  
  $post_count = get_field( 'posts_posts_count' ) ? get_field( 'posts_posts_count' ) : '10';
  
  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $post_count,
    'category__not_in' => $exc_cat,
  );
  $blog_query = new WP_Query( $args );
  
  
  // create align class ("alignwide") from block setting ("wide")
  $align_class = $block['align'] ? 'align' . $block['align'] : ''; ?>

<!--//show block title in WP-Backend-->
<?php if ( is_admin() ): ?>
  <div class="GutenbergTitleCustomBlock"><h3>Zeige Posts</h3></div>
<?php endif; ?>

<div class="c-posts <?php echo esc_attr( $align_class ) ?>">
  <div class="l-container">
    <div class="l-row">
      <div class="l-col l-col-8 l-col-m-12">
       <div class="c-posts__posts-outer-wrapper">
        <?php if ( $blog_query->have_posts() ) : ?>
          <?php while ( $blog_query->have_posts() ) :
            $blog_query->the_post(); ?>
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
            <?php endwhile; ?>
          <?php endif; ?>
          </div>
        </div>
        <div class="l-col l-col-4 l-col-m-hide">
          <div class="c-posts__categories-wrapper">
            <h3 class="c-posts__categories-heading"><?php _e('Kategorien', 'wiki') ?></h3>
            <ul class="c-posts__categories__ul">
              <?php
                foreach ($categories as $category) {
                  echo '<li class="c-posts__categories__ul-li">'.$category->name.'';
                  echo '<a href="'.get_term_link($category->term_id).'"></a></li>';
                }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>


