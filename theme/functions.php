<?php
  /**
   * wiki functions and definitions
   *
   * @link https://developer.wordpress.org/themes/basics/theme-functions/
   *
   * @package wiki
   */
  
  if ( !function_exists( 'wiki_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function wiki_setup() {
      /*
       * Make theme available for translation.
       * Translations can be filed in the /languages/ directory.
       * If you're building a theme based on wiki, use a find and replace
       * to change 'wiki' to the name of your theme in all the template files.
       */
      load_theme_textdomain( 'wiki', get_template_directory() . '/languages' );
      
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
                            'mainmenu' => esc_html__( 'Hauptmenü', 'wiki' ),
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
      add_theme_support( 'custom-background', apply_filters( 'wiki_custom_background_args', array(
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
  add_action( 'after_setup_theme', 'wiki_setup' );
  
  /**
   * Set the content width in pixels, based on the theme's design and stylesheet.
   *
   * Priority 0 to make it available to lower priority callbacks.
   *
   * @global int $content_width
   */
  function wiki_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'wiki_content_width', 640 );
  }
  
  add_action( 'after_setup_theme', 'wiki_content_width', 0 );
  
  /**
   * Register widget area.
   *
   * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
   */
  function wiki_widgets_init() {
    register_sidebar( array(
                        'name' => esc_html__( 'Sidebar', 'wiki' ),
                        'id' => 'sidebar-1',
                        'description' => esc_html__( 'Widgets hier einfügen', 'wiki' ),
                        'before_widget' => '<section id="%1$s" class="widget %2$s">',
                        'after_widget' => '</section>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>',
                      ) );
  }
  
  add_action( 'widgets_init', 'wiki_widgets_init' );
  
  /**
  /**
   * Enqueue scripts and styles.
   */
  function wiki_scripts() {
    wp_enqueue_style( 'wiki-style', get_stylesheet_uri() );
    wp_enqueue_style( 'wiki-style', get_template_directory_uri() . '/assets/css/slick.css' );
    wp_enqueue_style( 'wiki-style', get_template_directory_uri() . '/assets/css/slick-theme.css' );
//    wp_enqueue_script( 'wiki-isotope', get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js', array('jquery') );
    wp_enqueue_script( 'querystring-js', get_template_directory_uri() . '/assets/js/query-string.js', array('jquery'), false, true );
    
    //wp_enqueue_script( 'wiki-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
    wp_enqueue_script( 'bodyscrolllock-js', get_template_directory_uri() . '/assets/js/bodyScrollLock.min.js', array('jquery'), false, true );
  
  
    wp_enqueue_script( 'wiki-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '20151215', true );
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
    
    
  
    $php_array = array(
      'home_url' => get_home_url(),
      'ajax_url' => admin_url( 'admin-ajax.php?'),
      'templateurl' => get_template_directory_uri(),
      'posts_per_page' => get_option( 'posts_per_page' )
    );
    wp_localize_script( 'wiki-main', 'php_array', $php_array );
  }
  
  add_action( 'wp_enqueue_scripts', 'wiki_scripts' );
  
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
   * Custom handler for ajax request
   */
  require get_template_directory() . '/inc/ajax-handler.php';
  
  
  /**
   * Gutenberg Blocks.
   */
  require get_template_directory() . '/inc/gutenberg-config.php';
  
  /**
   * Gutenberg Styling.
   */
  function _s_acf_enqueue_backend_block_styles() {
    wp_enqueue_style( 'wds-gutenberg-blocks', get_template_directory_uri() . '/gutenberg-blocks-style.css', array(), '1.0.0' );
  }
  add_action('admin_enqueue_scripts', '_s_acf_enqueue_backend_block_styles');
  
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
  
  /**
   * Add modals before closing body tag
   */
  function wiki_add_modals() {
    get_template_part( 'template-parts/modals' );
  }
  add_action( 'wp_footer', 'wiki_add_modals' );
  
  
  
  /**
  * ========================================
  *             ACF FIELD GROUPS
  * ========================================
   */
  // ============= BLOG =============
  
  $blog_fieldgroup = new AcfFieldGroup( 'blog_', 'Blog', 'taxonomy', 'category' );
  
  $blog_fieldgroup->addField( 'true_false', __('private Kategorie', 'wiki'), 'private', array(
    'instructions' => __( 'Kategorie ist nur für eingeloggte User sichtbar', 'wiki' ),
  ) );
  
  
  // ============= Gutenberg-Blöcke ====================================================================================
  
  
  // ============= Top Categories =============
  $block_top_categories_fieldgroup = new AcfFieldGroup( 'top_cat_', 'Top Categories', 'block', 'acf/topcategories' );
  
  $block_top_categories_fieldgroup->addField( 'true_false', __('zeige die neuesten Kategorien', 'wiki'), 'private', array(
    'instructions' => __( 'Es werden die neuesten Kategorien angezeigt.', 'wiki' ),
  ) );
  $block_top_categories_fieldgroup->addField( 'text', __('Anzahl der gezeigten Kategorien', 'wiki'), 'cat_count', array(
    'instructions' => __( 'Anzahl der Kategorien die angezeigt werden sollen.', 'wiki' ),
  ) );
  
  // ============= Posts =============
  $block_posts_fieldgroup = new AcfFieldGroup( 'posts_', 'Posts', 'block', 'acf/posts' );
  
  $block_posts_fieldgroup->addField( 'text', __('Anzahl der gezeigten Posts', 'wiki'), 'posts_count', array(
    'instructions' => __( 'Anzahl der Beiträge die initial angezeigt werden.', 'wiki' ),
  ) );
  
  // ============= BLOG =============
  
  $button_fieldgroup = new AcfFieldGroup( 'button_', 'Button', 'block', 'acf/button' );
  
  $button_fieldgroup->addField( 'link', 'Button-link', 'btn_link', array(
    'instructions' => __( 'Link', 'spl' ),
  ) );
  
  