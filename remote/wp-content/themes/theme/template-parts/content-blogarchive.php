<?php
  $template = get_field( 'blog_template' );
  $image = get_the_post_thumbnail(get_the_ID() , 'blog' );
  $classes = array( 'c-blog-element__post', 'c-blog-element__post--' . $template );
?>

<div class="l-col l-col-20 l-col-xl-30 l-col-s-60">
  <article <?php post_class( $classes ); ?>>
    <?php if( $template == 'imagebgtextabove' ) : ?>
      <div class="c-blog-element__post-bg" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID() , 'blog' ) ;?>')"></div>
    <?php endif; ?>
    
    <?php if( $template == 'imagewithtext' ) : ?>
      <a href="<?php the_permalink(); ?>" class="c-blog-element__post-image">
        <?php echo $image; ?>
      </a>
    <?php endif; ?>

    <div class="c-blog-element__post-meta">
      <div class="c-blog-element__post-categories">
        <?php
          $postcategories = get_the_category();
          foreach( $postcategories as $postcategory ) :
            printf('<span class="c-blogteaser__category">%s</span>',$postcategory->name );
          endforeach;?>
      </div>
      <div class="c-blog-element__post-date"><?php echo date_i18n( get_option( 'date_format' ), get_the_time( 'U' ) ); ?></div>
    </div>

    <div class="c-blog-element__post-title">
      <?php echo the_title(); ?>
    </div>
    <?php $teasertext = get_field('blog_teaser');
      if($teasertext): ?>
        <div class="c-blogteaser__teaser">
          <!--              --><?php //echo strip_shortcodes(apply_filters( 'the_excerpt', get_the_excerpt() )); ?>
          <?php echo $teasertext; ?>
        </div>
      <?php endif; ?>
    <div class="c-blog-element__post-button-wrapper">
      <a class="c-blog-element__post-button o-button <?php echo ($template == 'imagebgtextabove') ? 'o-button--white' : 'o-button--nearly-black'; ?>" href="<?php echo get_post_permalink(); ?>"><?php _e( 'Mehr erfahren', 'spl' ); ?></a>
    </div>
  </article>
</div>