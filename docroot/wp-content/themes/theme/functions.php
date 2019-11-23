<?php
  /**
   * GLC functions and definitions
   *
   * @link https://developer.wordpress.org/themes/basics/theme-functions/
   *
   * @package GLC
   */
  
  if ( !function_exists( 'glc_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function glc_setup() {
      /*
       * Make theme available for translation.
       * Translations can be filed in the /languages/ directory.
       * If you're building a theme based on GLC, use a find and replace
       * to change 'glc' to the name of your theme in all the template files.
       */
      load_theme_textdomain( 'glc', get_template_directory() . '/languages' );
      
      // Add default posts and comments RSS feed links to head.
      add_theme_support( 'automatic-feed-links' );
      
      /*
       * Let WordPress manage the document title.
       * By adding theme support, we declare that this theme does not use a
       * hard-coded <title> tag in the document head, and expect WordPress to
       * provide it for us.
       */
      add_theme_support( 'title-tag' );
      
      /*
       * Enable support for Post Thumbnails on posts and pages.
       *
       * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
       */
      add_theme_support( 'post-thumbnails' );
      
      // This theme uses wp_nav_menu() in one location.
      register_nav_menus( array(
                            'mainmenu' => esc_html__( 'Hauptmenü', 'glc' ),
                          ) );
      
      /*
       * Switch default core markup for search form, comment form, and comments
       * to output valid HTML5.
       */
      add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
      ) );
      
      // Set up the WordPress core custom background feature.
      add_theme_support( 'custom-background', apply_filters( 'glc_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
      ) ) );
      
      // Add theme support for selective refresh for widgets.
      add_theme_support( 'customize-selective-refresh-widgets' );
      
      /**
       * Add support for core custom logo.
       *
       * @link https://codex.wordpress.org/Theme_Logo
       */
      add_theme_support( 'custom-logo', array(
        'height' => 250,
        'width' => 250,
        'flex-width' => true,
        'flex-height' => true,
      ) );
    }
  endif;
  add_action( 'after_setup_theme', 'glc_setup' );
  
  /**
   * Set the content width in pixels, based on the theme's design and stylesheet.
   *
   * Priority 0 to make it available to lower priority callbacks.
   *
   * @global int $content_width
   */
  function glc_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'glc_content_width', 640 );
  }
  
  add_action( 'after_setup_theme', 'glc_content_width', 0 );
  
  /**
   * Register widget area.
   *
   * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
   */
  function glc_widgets_init() {
    register_sidebar( array(
                        'name' => esc_html__( 'Sidebar', 'glc' ),
                        'id' => 'sidebar-1',
                        'description' => esc_html__( 'Widgets hier einfügen', 'glc' ),
                        'before_widget' => '<section id="%1$s" class="widget %2$s">',
                        'after_widget' => '</section>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>',
                      ) );
  }
  
  add_action( 'widgets_init', 'glc_widgets_init' );
  
  /**
  /**
   * Enqueue scripts and styles.
   */
  function glc_scripts() {
    wp_enqueue_style( 'glc-style', get_stylesheet_uri() );
    wp_enqueue_style( 'glc-style', get_template_directory_uri() . '/assets/css/slick.css' );
    wp_enqueue_style( 'glc-style', get_template_directory_uri() . '/assets/css/slick-theme.css' );
    
    wp_enqueue_script( 'glc-main', get_template_directory_uri() . '/assets/js/main.js', array(), '20151215', true );
    
    //wp_enqueue_script( 'glc-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
  
  add_action( 'wp_enqueue_scripts', 'glc_scripts' );
  
  /**
   * Implement the Custom Header feature.
   */
  require get_template_directory() . '/inc/custom-header.php';
  
  /**
   * Functions which enhance the theme by hooking into WordPress.
   */
  require get_template_directory() . '/inc/template-functions.php';
  
  /**
   * Custom template tags for this theme.
   */
  require get_template_directory() . '/inc/template-tags.php';
  //comment
  
  /**
   * Helpers
   */
  require get_template_directory() . '/inc/classes/helpers/PHPHelper.class.php';
  require get_template_directory() . '/inc/classes/helpers/SocialHelper.class.php';
  require get_template_directory() . '/inc/classes/helpers/WpHelper.class.php';
  require get_template_directory() . '/inc/classes/helpers/WPFunctionsHelper.class.php';
  
  /**
   * Custom classes
   */
  require get_template_directory() . '/inc/classes/CustomPostType.class.php';
  require get_template_directory() . '/inc/classes/CustomTaxonomy.class.php';
  require get_template_directory() . '/inc/classes/AcfFieldGroup.class.php';
  require get_template_directory() . '/inc/classes/VCElement.class.php';

  WPFunctionsHelper::sanitizeUploadFilenames();