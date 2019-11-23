<?php
  
  /**
   * Class CustomPostType
   * Used to create a new Custom Post Type
   */
  class CustomPostType {
    public $menu_name;
    public $singular_name;
    public $plural_name;
    public $slug;
    public $args;
    public $labels;
    
    /**
     * Class constructor
     */
    public function __construct( $menu_name, $singular_name, $plural_name, $slug, $args = array(), $labels = array() ) {
      // Set some important variables
      $this->menu_name = $menu_name;
      $this->singular_name = $singular_name;
      $this->plural_name = $plural_name;
      $this->slug = $slug;
      $this->args = $args;
      $this->labels = $labels;
      
      // Add action to register the post type, if the post type does not already exist
      if( !post_type_exists( $this->slug ) ) {
        add_action( 'init', array( &$this, 'register_post_type' ) );
      } else {
        WPFunctionsHelper::addBackendWarning( 'Der Post-Type mit dem Slug ' . $this->slug . ' ist schon vorhanden!');
      }
    }
    
    /**
     * Method which registers the post type with the given data when creating the object
     */
    public function register_post_type() {
      // Set default labels and overwrite them with given labels.
      $labels = array_merge(
        array(
          'name'                  => _x( $this->plural_name, 'post type general name', 'glc' ),
          'singular_name'         => _x( $this->singular_name, 'post type singular name', 'glc' ),
          'add_new'               => _x( 'Neu hinzufügen', 'post type add new name', 'glc' ),
          'add_new_item'          => sprintf(_x( '%s neu hinzufügen', 'post type add new item name', 'glc' ), $this->singular_name),
          'edit_item'             => sprintf(_x( '%s bearbeiten', 'post type edit item name', 'glc' ), $this->singular_name),
          'new_item'              => sprintf(_x( 'Neue %s', 'post type new item name', 'glc' ), $this->singular_name),
          'all_items'             => sprintf(_x( 'Alle %s', 'post type all items name', 'glc' ), $this->plural_name),
          'view_item'             => sprintf(_x( 'Zeige %s', 'post type view item name', 'glc' ), $this->singular_name),
          'search_items'          => sprintf(_x( 'Suche %s', 'post type search items name', 'glc' ), $this->plural_name),
          'not_found'             => sprintf(_x( 'Keine %s gefunden', 'post type not found name', 'glc' ), $this->plural_name),
          'not_found_in_trash'    => sprintf(_x( 'Keine %s im Papierkorb gefunden', 'post type not found in trash name', 'glc' ), $this->plural_name),
          'parent_item_colon'     => '',
          'menu_name'             => _x($this->menu_name, 'post type menu name', 'glc')
        ),
        // Given labels
        $this->labels
      );
      
      // Set default args and overwrite them with given args.
      $args = array_merge(
      // Default
        array(
          'label'                 => $this->plural_name,
          'labels'                => $labels,
          'public'                => true,
          'show_ui'               => true,
          'supports'              => array( 'title', 'editor' ),
          'show_in_nav_menus'     => true,
          '_builtin'              => false,
        ),
        // Given args
        $this->args
      );
      
      // Register the post type
      register_post_type( $this->slug, $args );
    }
  }
