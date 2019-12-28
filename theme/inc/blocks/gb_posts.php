<?php
  
  add_action( 'acf/init', 'gb_posts' );
  function gb_posts() {
    
    // check function exists
    if ( function_exists( 'acf_register_block' ) ) {
      
      // register a testimonial block
      acf_register_block( array(
                            'name' => 'posts',
                            'title' => __( 'Zeige Posts','wiki' ),
                            'description'     => __( 'Zeige alle Posts.', 'wiki' ),
                            'render_callback' => 'acf_block_render_callback',
                            'category'        => 'wiki',
                            'mode'            => 'preview',
                            'icon'            => 'admin-comments',
                            'keywords'        => array(
                                              'kategorien',
                                              'Top'
                            ),
                          ) );
    }
  }
  