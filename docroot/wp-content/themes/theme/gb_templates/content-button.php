<?php
  /**
   * Block Name: Testimonial
   *
   * This is the template that displays the testimonial block.
   */
  
  // get image field (array)
  $avatar = get_field('avatar');
  
  // create id attribute for specific styling
  $id = 'button-' . $block['id'];
  $text = get_field('blog_teaser');
  $btn_link = get_field('button_btn_link');
  
  // create align class ("alignwide") from block setting ("wide")
  $align_class = $block['align'] ? 'align' . $block['align'] : '';
?>

<div class="c-button <?php echo esc_attr( $align_class ) ?>">
  <div class="c-button__button o-button">
    <a href="<?php echo $btn_link['urk'] ?>" target="<?php echo $btn_link['target'] ?>"><?php echo $btn_link['title'] ?></a>
  </div>
</div>
