<?php
  /**
   * Functions which enhance the theme by hooking into WordPress
   *
   * @package wiki
   */
  
  /**
   * Adds custom classes to the array of body classes.
   *
   * @param array $classes Classes for the body element.
   * @return array
   */
  function wiki_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( !is_singular() ) {
      $classes[] = 'hfeed';
    }
    
    // Adds a class of no-sidebar when there is no sidebar present.
    if ( !is_active_sidebar( 'sidebar-1' ) ) {
      $classes[] = 'no-sidebar';
    }
    
    return $classes;
  }
  
  add_filter( 'body_class', 'wiki_body_classes' );
  
  /**
   * Add a pingback url auto-discovery header for single posts, pages, or attachments.
   */
  function wiki_pingback_header() {
    if ( is_singular() && pings_open() ) {
      echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
  }
  
  add_action( 'wp_head', 'wiki_pingback_header' );
  
  /**
   * Exclude private Categories from search, if no user logged in
   */
  function wcs_exclude_category_search( $query ) {
    if ( is_admin() || !$query->is_main_query() )
      return;
  
    $categories = get_categories();
    $exc_cats = array();
  
    if ( !is_user_logged_in() ) { // if no user logged in remove private categories
      foreach ( $categories as $c => $category ) {
        if ( get_field( 'blog_private', $category ) ) {
          $exc_cats[] = $category->term_id;
          unset( $categories[$c] );
        }
      }
    }
    
    $cat_ids = array();
    foreach ( $categories as $category ) {
      $cat_ids[] = $category->term_id;
    }
    
    if ( $query->is_search ) {
      $query->set( 'cat', $cat_ids );
    }
    
  }
  
  add_action( 'pre_get_posts', 'wcs_exclude_category_search', 1 );
