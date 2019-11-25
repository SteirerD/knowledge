<?php
  
  /**
   * Class CustomTaxonomy
   * Used to create a new Custom Taxonomy
   */
  class CustomTaxonomy {
    public $plural_name;
    public $singular_name;
    public $slug;
    public $args;
    public $labels;
    
    /**
     * Class constructor
     */
    public function __construct( $menu_name, $plural_name, $singular_name, $slug, $post_type, $args = array(), $labels = array() ) {
      // Set some important variables
      $this->menu_name = $menu_name;
      $this->plural_name = $plural_name;
      $this->singular_name = $singular_name;
      $this->slug = $slug;
      $this->post_type = $post_type;
      $this->args = $args;
      $this->labels = $labels;
      
      // Add action to register the custom taxonomy, if the custom taxonomy does not already exist
      if( !taxonomy_exists( $this->slug ) ) {
        add_action( 'init', array( &$this, 'register_custom_taxonomy' ) );
      } else {
        WPFunctionsHelper::addBackendWarning( 'Die Taxonomy mit dem Slug ' . $this->slug . ' ist schon vorhanden!');
      }
    }
    
    /**
     * Method which registers the custom taxonomy
     */
    public function register_custom_taxonomy() {
      // Set default labels and overwrite them with given labels.
      $labels = array_merge(
      // Default
        array(
          'name'                  => _x( $this->plural_name, 'taxonomy general name', 'wiki' ),
          'singular_name'         => _x( $this->singular_name, 'taxonomy singular name', 'wiki' ),
          'search_items'          => sprintf(_x( 'Suche %s', 'taxonomy search items name', 'wiki' ), $this->plural_name),
          'all_items'             => sprintf(_x( 'Alle %s', 'taxonomy all items name', 'wiki' ), $this->plural_name),
          'parent_item'           => sprintf(_x( 'Eltern-%s', 'taxonomy parent item name', 'wiki' ), $this->singular_name),
          'parent_item_colon'     => sprintf(_x( 'Eltern-%s:', 'taxonomy parent item colon name', 'wiki' ), $this->singular_name),
          'edit_item'             => sprintf(_x( '%s bearbeiten', 'taxonomy edit item name', 'wiki' ), $this->singular_name),
          'update_item'           => sprintf(_x( '%s aktualisieren', 'taxonomy update item name', 'wiki' ), $this->singular_name),
          'add_new_item'          => sprintf(_x( '%s hinzufügen', 'taxonomy add new item name', 'wiki' ), $this->singular_name),
          'new_item_name'         => sprintf(_x( 'Neuer %s Name', 'taxonomy new item name', 'wiki' ), $this->singular_name),
          'menu_name'             => __( $this->menu_name, 'wiki' ),
        ),
        // Given labels
        $this->labels
      );
      
      // Set default args and overwrite them with given args.
      $args = array_merge(
      // Default
        array(
          'hierarchical'          => true,
          'label'                 => $this->plural_name,
          'labels'                => $labels,
          'public'                => true,
          'show_ui'               => true,
          'show_in_nav_menus'     => true,
          '_builtin'              => false,
        ),
        // Given args
        $this->args
      );
      
      // Register the custom taxonomy
      register_taxonomy( $this->slug, $this->post_type, $args );
    }
  }
