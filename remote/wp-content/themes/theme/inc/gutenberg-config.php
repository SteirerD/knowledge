<?php


function wiki_block_category( $categories, $post ) {
  return array_merge( $categories, array(
                                   array(
                                     'slug' => 'wiki',
                                     'title' => __( 'Daniel´s Wiki', 'wiki' ),
                                   ),
                                 ) );
}

add_filter( 'block_categories', 'wiki_block_category', 10, 2 );


require get_template_directory() . '/inc/blocks/gb_button.php';
require get_template_directory() . '/inc/blocks/gb_topcategories.php';
require get_template_directory() . '/inc/blocks/gb_posts.php';

function acf_block_render_callback( $block ) {
  // convert name ("acf/testimonial") into path friendly slug ("testimonial")
  $slug = str_replace('acf/', '', $block['name']);
  
  // include a template part from within the "template-parts/block" folder
  if( file_exists( get_theme_file_path("/gb_templates/content-{$slug}.php") ) ) {
    include( get_theme_file_path("/gb_templates/content-{$slug}.php") );
  }
}