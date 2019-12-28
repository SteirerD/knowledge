<?php
  
  add_action( 'acf/init', 'gb_topcategories' );
  function gb_topcategories() {
    
    // check function exists
    if ( function_exists( 'acf_register_block' ) ) {
      
      // register a testimonial block
      acf_register_block( array(
                            'name' => 'topcategories',
                            'title' => __( 'Zeige 3 Top Kategorien','wiki' ),
                            'description'     => __( 'Block Button.', 'wiki' ),
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
  