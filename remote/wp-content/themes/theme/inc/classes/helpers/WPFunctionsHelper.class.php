<?php
  
  class WPFunctionsHelper {
  
    /**
     * Backend Notices Functions
     * Used to add a notice to the Wordpress Backend
     * Usage: addBackendNotice($msg);
     */
    
    protected static $backendNotices = array();
    
    public static function addBackendNotice($msg) {
      static::setBackendNoticesHook();
      static::$backendNotices[] = $msg;
    }
  
    protected static function setBackendNoticesHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_action('admin_notices', array(get_called_class(), '_a_setBackendNotices'));
    }
    
    public static function _a_setBackendNotices() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      if (!is_admin() || count(static::$backendNotices) == 0) return;
    
      foreach (static::$backendNotices as $msg) {
        echo '<div class="notice notice-success"><p>'.$msg.'</p></div>';
      }
    }
  
    /**
     * Backend Warning Functions
     * Used to add a warning to the Wordpress Backend
     * Usage: addBackendWarning($msg);
     */
  
    protected static $backendWarnings = array();
  
    public static function addBackendWarning( $msg) {
      static::setBackendWarningsHook();
      static::$backendWarnings[] = $msg;
    }
  
    protected static function setBackendWarningsHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_action('admin_notices', array(get_called_class(), '_a_setBackendWarnings'));
    }
  
    public static function _a_setBackendWarnings() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      if (!is_admin() || count(static::$backendWarnings) == 0) return;
    
      foreach (static::$backendWarnings as $msg) {
        echo '<div class="notice notice-warning"><p>'.$msg.'</p></div>';
      }
    }
  
  
    /**
     * Backend Errors Functions
     * Used to add a error message to the Wordpress Backend
     * Usage: addBackendError($msg);
     */
    
    protected static $backendErrors = array();
  
    public static function addBackendError($msg) {
      static::setBackendErrorsHook();
      static::$backendErrors[] = $msg;
    }
  
    protected static function setBackendErrorsHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_action('admin_notices', array(get_called_class(), '_a_setBackendErrors'));
    }
  
    public static function _a_setBackendErrors() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      if (!is_admin() || count(static::$backendErrors) == 0) return;
    
      foreach (static::$backendErrors as $msg) {
        echo '<div class="notice notice-error"><p>'.$msg.'</p></div>';
      }
    }
    
    /**
     * TinyMCE Functions
     */
    
    protected static $tinyMceButtonConfigs = array();
    protected static $tinyMceAcfButtonConfigs = array();
    protected static $tinyMceAllowedFormats = array();
  
    /**
     * Create / Overwrite TinyMCE Button Config
     *
     * @param array $rows – Contains an array for each row with strings for button names
     * @param string [$configName=_default] – name of the config as used in tinyMceSynchronizeAcfButtonConfig. leave empty to modify default wordpress TinyMCE button config
     *
     * example:
     * 	tinyMceSetButtonRows(array(
     * 		array(
     * 			'bold',
     * 			'strikethrough',
     * 			'bullist',
     * 			'wp_adv',
     * 		),
     * 		array(
     * 			'undo',
     * 			'redo',
     * 		),
     *	));
     */
    public static function tinyMceSetButtonRows($rows, $configName = 'wordpress') {
      static::$tinyMceButtonConfigs[$configName] = $rows;
      static::tinyMceCustomizeHook();
    }
  
    /**
     * Customize Wordpress and ACF TinyMCE according to config.
     * (set via tinyMceSetButtonRows and tinyMceSynchronizeAcfButtonConfig)
     */
    protected static function tinyMceCustomizeHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_filter('tiny_mce_before_init', array(get_called_class(), '_f_tinyMceCustomize'));
      add_filter('acf/fields/wysiwyg/toolbars', array(get_called_class(), '_f_tinyMceAcfCustomizeToolbars'));
    }
  
    /**
     * set allowed formats for tinymce
     *
     * @access public
     * @static
     * @param mixed $formatNames
     * @return void
     *
     * $formatNames supports 2 possible syntactic forms
     * 1) old syntax (TinyMCE < 4 used in WP < 3.8)
     * 	  tinyMceAllowedFormats('p', 'h1', 'h2', 'h3');
     *
     * 2) new syntax (TinyMCE >= 4 used in WP >= 3.8)
     *    see: http://www.tinymce.com/wiki.php/Configuration:block_formats
     *    tinyMceAllowedFormats(array(
     *    	//'Name' => 'tag',
     *    	'Paragraph' => 'p',
     *    	'Headline 1' => 'h1',
     *    	'Headline 2' => 'h2',
     *    	'Headline 3' => 'h3',
     *    ));
     */
    public static function tinyMceAllowedFormats($formatNames) {
      static::$tinyMceAllowedFormats = array_unique(array_merge($formatNames, static::$tinyMceAllowedFormats));
      static::tinyMceCustomizeHook();
    }
  
    public static function _f_tinyMceCustomize($init) {
      //blockformats
      if (count(static::$tinyMceAllowedFormats) > 0) {
        //check for used syntax
        if (PhpHelper::isArrayAssoc(static::$tinyMceAllowedFormats)) {
          //new syntax (TinyMCE >= 4 used in WP >= 3.8)
          $init['block_formats'] = PhpHelper::implodeAssoc(static::$tinyMceAllowedFormats, '=', ';', false);
        }
        else {
          //old syntax (TinyMCE < 4 used in WP < 3.8)
          $init['theme_advanced_blockformats'] = implode(',', static::$tinyMceAllowedFormats);
        }
      }
      else {
        $init['theme_advanced_blockformats'] = '';
      }
    
      //button config
      if (!empty(static::$tinyMceButtonConfigs['wordpress']) && PhpHelper::isLoopableArray(static::$tinyMceButtonConfigs['wordpress'])) {
        //$init['theme_advanced_disable'] = implode(',', static::$tinyMceDisableButtons);
      
        $i = 1;
        foreach (static::$tinyMceButtonConfigs['wordpress'] as $row) {
          $init['toolbar'.$i] = implode(',', $row);
          $i++;
        }
      }
    
      return $init;
    }
  
    public static function _f_tinyMceAcfCustomizeToolbars($toolbars) {
      if (PhpHelper::isLoopableArray(static::$tinyMceAcfButtonConfigs)) {
        foreach (static::$tinyMceAcfButtonConfigs as $configName) {
          $i = 1; // must be indexed with 1
          if (!empty(static::$tinyMceButtonConfigs[$configName])) {
            foreach (static::$tinyMceButtonConfigs[$configName] as $row) {
              $toolbars[$configName][$i] = $row;
              $i++;
            }
          }
        }
      }
    
      return $toolbars;
    }
    
    /*
     * Add a Dashboard Widget
     * Usage: addDashboardwidget(array(
     *    'title'       => 'Title',
     *    'slug'        => 'slug',
     *    'id'          => 'ID',
     *    'path'        => get_stylesheet_directory() . '/path/to/widget_content.php',
     *    'capability'  => 'administrator'
     * ));
     */
  
    protected static $dashboardWidgets = array();
  
    /**
     * @param $data array Associative array container meta-data for widget
     * @throws Exception
     */
    public static function addDashboardWidget($data) {
      if (!isset($data['slug'])) throw new Exception('Invalid dashboard widget data: slug missing');
      static::$dashboardWidgets[$data['slug']] = $data;
      static::addDashboardWidgetHook();
    }
  
    protected static function addDashboardWidgetHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_action('wp_dashboard_setup',array(get_called_class(), '_a_addDashboardWidgets'));
    }
  
    public static function _a_addDashboardWidgets() {
      foreach (static::$dashboardWidgets as $dashboardWgt) {
        if (current_user_can($dashboardWgt['capability'])) wp_add_dashboard_widget($dashboardWgt['slug'], $dashboardWgt['title'], array(get_called_class(), '_addDashboardWidget'));
      }
    }
  
    public static function _addDashboardWidget($post, $args) {
      if (empty($args['id']) || !isset(static::$dashboardWidgets[$args['id']])) return;
      $options = static::$dashboardWidgets[$args['id']];
    
      $path = $options['path'];
      if (file_exists($path)) require($path);
    }
    
    /*
     * Remove a Dashboard Widget
     */
  
    protected static $removedDashboardBoxes = array();
    
    public static function removeDashboardBox($name) {
      static::$removedDashboardBoxes[] = $name;
      static::removeDashboardBoxHook();
    }
  
    protected static function removeDashboardBoxHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_action('wp_dashboard_setup', array(get_called_class(), '_a_removeDashboardWidgets'));
    }
  
    public static function _a_removeDashboardWidgets() {
      global $wp_meta_boxes;
      foreach (static::$removedDashboardBoxes as $name) {
        if (isset($wp_meta_boxes['dashboard']['normal']['core'][$name])) unset($wp_meta_boxes['dashboard']['normal']['core'][$name]);
        else if (isset($wp_meta_boxes['dashboard']['side']['core'][$name])) unset($wp_meta_boxes['dashboard']['side']['core'][$name]);
      }
    }
    
    /*
     * Change Login Logo
     */
  
    protected static $backendLoginLogoUrl;
    
    public static function setBackendLoginLogo($url) {
      static::$backendLoginLogoUrl = $url;
      static::setBackendLoginLogoHook();
    }
  
    protected static function setBackendLoginLogoHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_action('login_head', array(get_called_class(), '_a_setBackendLoginLogo'));
    }
  
    public static function _a_setBackendLoginLogo() {
      if (!empty(static::$backendLoginLogoUrl)) echo '<style type="text/css">h1 a { background-image: url(\''.static::$backendLoginLogoUrl.'\') !important; background-size: contain !important; width: 120px !important; height: 120px !important; background-position: center !important;};</style>';
    }
    
    /*
     * Set Backend Footer Text
     */
    
    protected static $backendFooterText;
    
    public static function setBackendFooterText($text) {
      static::$backendFooterText = $text;
      add_filter('admin_footer_text', array(get_called_class(), '_f_setCustomBackendFooterText'));
    }
  
    public static function _f_setCustomBackendFooterText($text) {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return $text;
      return '<span id="footer-thankyou">'.static::$backendFooterText.'<span>';
    }
    
    /*
     * Disable Wordpress Core Functions
     */
  
    public static function disableAdminBarFrontend() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      if (!is_admin()) {
        remove_action('wp_footer','wp_admin_bar_render',1000);
        remove_action('admin_footer', 'wp_admin_bar_render', 1000);
        add_filter('show_admin_bar', create_function('$a', 'return false;'));
        add_action('init', array(get_called_class(), '_a_disableAdminBarFrontend'));
      }
    }
  
    public static function _a_disableAdminBarFrontend() {
      wp_deregister_script('admin-bar');
      wp_deregister_style('admin-bar');
    }
  
    public static function disableAdminBarFrontendCss() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_theme_support('admin-bar', array('callback' => '__return_false'));
    }
  
  
    public static function disableCoreUpdates() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      remove_action('load-update-core.php', 'wp_update_themes');
      add_filter('pre_site_transient_update_themes', '__return_false');
    }
  
    public static function disableThemeUpdates() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      wp_clear_scheduled_hook('wp_update_themes');
      add_filter('pre_site_transient_update_core', '__return_false');
      wp_clear_scheduled_hook('wp_version_check');
    }
  
    public static function disablePluginUpdates() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      remove_action('load-update-core.php', 'wp_update_plugins');
      add_filter('pre_site_transient_update_plugins', '__return_false');
      wp_clear_scheduled_hook('wp_update_plugins');
    }
  
    public static function removeRssCommentsFeed() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_filter('post_comments_feed_link', '__return_false');
    }
    
    /*
     * Add/Remove a supported Upload-Filetype
     */
    
    protected static $supportedUploadFiletypeAdded = array();
    protected static $supportedUploadFiletypeRemoved = array();
  
    public static function addSupportedUploadFiletype($extension, $mimeType) {
      static::$supportedUploadFiletypeAdded[$extension] = $mimeType;
      static::setUploadFiletypesHook();
    }
  
    public static function removeSupportedUploadFiletype($extension) {
      static::$supportedUploadFiletypeRemoved[] = $extension;
      static::setUploadFiletypesHook();
    }
  
    protected static function setUploadFiletypesHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_filter('upload_mimes', array(get_called_class(), '_f_setUploadFiletypes'));
    }
  
    public static function _f_setUploadFiletypes($mimes = array()) {
      if (count(static::$supportedUploadFiletypeAdded) > 0) {
        foreach (static::$supportedUploadFiletypeAdded as $extension => $mime) {
          $mimes[$extension] = $mime;
        }
      }
    
      if (count(static::$supportedUploadFiletypeRemoved) > 0) {
        foreach (static::$supportedUploadFiletypeRemoved as $extension) {
          unset($mimes[$extension]);
        }
      }
    
      return $mimes;
    }
  
    /*
     * Sanitize Upload Filenames
     */
  
    public static function sanitizeUploadFilenames() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_filter('sanitize_file_name', array(get_called_class(), '_f_sanitizeUploadFilenames'), 10);
    }
  
    public static function _f_sanitizeUploadFilenames($filename) {
      //extract extension
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      $filenameWithoutExt = !empty($ext) ? str_replace('.'.$ext, '', $filename) : $filename;
    
      //strip non ASCII characters
      $filenameWithoutExt = preg_replace('/[^(\x20-\x7F)]*/','', $filenameWithoutExt);
    
      //replace dot
      $filenameWithoutExt = str_replace('.', '-', $filenameWithoutExt);
    
      //lowercase
      $filenameWithoutExt = strtolower($filenameWithoutExt);
    
      //append ext
      $filename = !empty($ext) ? $filenameWithoutExt.'.'.$ext : $filenameWithoutExt;
    
      return $filename;
    }
    
    /*
     * Widgets
     */
    
    protected static $unregisteredWidgets = array();
  
    public static function unregisterWidget($widgetName) {
      static::$unregisteredWidgets[] = $widgetName;
      static::unregisterWidgetHook();
    }
  
    protected static function unregisterWidgetHook() {
      if (!PhpHelper::checkSetFirstCall(__METHOD__)) return;
      add_action('widgets_init', array(get_called_class(), '_a_unregisterWidgets'));
    }
  
    public static function _a_unregisterWidgets() {
      if (empty(static::$unregisteredWidgets)) return;
    
      foreach (static::$unregisteredWidgets as $widget) {
        unregister_widget($widget);
      }
    }
    
    /*
     * Enable Post Meta Search
     */
  
    public static function enablePostMetaSearch() {
      $priority = 100;
    
      if (!is_admin()) {
        add_filter('posts_join', array(get_called_class(), '_f_searchPostMetaJoin'), $priority);
        add_filter('posts_search', array(get_called_class(), '_f_searchPostMetaSearch'), $priority);
        add_filter('posts_groupby', array(get_called_class(), '_f_searchPostMetaGroupBy'), $priority);
      }
    }
  
    public static function _f_searchPostMetaJoin($sqlPart) {
      global $wpdb;
      if (!is_search() || !is_main_query()) return $sqlPart;
    
      $sqlPart .= " LEFT JOIN ".$wpdb->prefix."postmeta AS pm_search ON pm_search.post_id = ".$wpdb->prefix."posts.ID".PHP_EOL;
    
      return $sqlPart;
    }
  
    public static function _f_searchPostMetaSearch($sqlPart) {
      global $wpdb;
      if (!is_search() || !is_main_query()) return $sqlPart;
    
      preg_match_all('/%(.*?)%/', $sqlPart, $matches);
      if (empty($matches[1])) return $sqlPart;
    
      // iterate thru matches
      while (!empty($matches[1])) {
        $searchString = $matches[1][0];
        $part = " OR (pm_search.meta_value LIKE '%".$searchString."%')".PHP_EOL;
        $regEx = '/\'%'.preg_quote($searchString).'%\'\)\)/';
        $sqlPart = preg_replace($regEx, '\'%'.$searchString.'%\')'.$part.')', $sqlPart);
      
        // remove both occurences
        array_shift($matches[1]);
        array_shift($matches[1]);
      }
    
      return $sqlPart;
    }
  
    public static function _f_searchPostMetaGroupBy($sqlPart) {
      global $wpdb;
      if (!is_search() || !is_main_query()) return $sqlPart;
    
      $groupByClause = $wpdb->prefix."posts.ID";
      if (stristr($sqlPart, $groupByClause)) {
        // nothing
      }
      else if ($sqlPart) $sqlPart .= ", ".$groupByClause;
      else $sqlPart = $groupByClause;
      return $sqlPart;
    }
    
    /*
     * Enable Additional Menu Markup
     */
  
    public static function enableAdditionalNavMenuMarkup() {
      add_filter('wp_nav_menu_args', array(get_called_class(), '_f_addNavMenuLinkInnerElement'));
      add_filter('nav_menu_css_class', array(get_called_class(), '_f_addNavMenuCssClasses'), 20, 3);
      add_filter('nav_menu_link_attributes', array(get_called_class(), '_f_addNavMenuLinkAttributes'), 20, 3);
    }
  
    public static function _f_addNavMenuLinkInnerElement($args) {
      if (!WpHelper::isFrontend()) return $args;
    
      $args['link_before'] = '<span class="menu-item__title">';
      $args['link_after'] = '</span>';
      return $args;
    }
  
    public static function _f_addNavMenuCssClasses($classes, $item, $args) {
      if (!WpHelper::isFrontend()) return $classes;
    
      // unfortunately wordpress does add any information about the $depth to this filter
      // but level_0 can be obtained otherwise using the 'menu_item_parent'
      if (isset($item) && isset($item->menu_item_parent) && $item->menu_item_parent === '0') {
        $classes[] = 'menu-item--level_0';
      }
      return $classes;
    }
  
    public static function _f_addNavMenuLinkAttributes($atts, $item, $args) {
      if (!WpHelper::isFrontend()) return $atts;
    
      // move custom classes to the inner element
      $atts['class']  = 'menu-item__inner';
      return $atts;
    }
    
  }
