<?php
  
  add_action( 'acf/init', 'gb_button' );
  function gb_button() {
    
    // check function exists
    if ( function_exists( 'acf_register_block' ) ) {
      
      // register a testimonial block
      acf_register_block( array(
                            'name' => 'button',
                            'title' => __( 'Button' ),
                            'description' => __( 'Block Button.' ),
                            'render_callback' => 'acf_block_render_callback',
                            'category' => 'wiki',
                            'icon' => 'admin-comments',
                            'keywords' => array(
                              'testimonial',
                              'quote'
                            ),
                          ) );
    }
  }
  