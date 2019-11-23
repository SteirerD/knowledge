<?php
  
  class WpHelper {
    
    protected static $calledHooks = array();
  
    /**
     * startRegisteringHooks function.
     * Has to be called as soon as possible to be aware of called hooks!
     *
     * @access public
     * @static
     * @return void
     */
    public static function startRegisteringHooks() {
      add_filter('all', array(get_class(), '_f_registerHookCall'));
    }
  
    public static function _f_registerHookCall($name) {
      if (!in_array($name, static::$calledHooks)) {
        static::$calledHooks[] = $name;
      }
    }
  
    public static function wasHookCalled($name) {
      return in_array($name, static::$calledHooks);
    }
  
    /**
     * Remove filters or actions added by other classes (for real!)
     *
     * Sometimes it is hard to remove an action or filter if it was added using array($this, 'callbackName') because $this might not be available in the current context. This function solves that issue. Additionally $priority and $accepted_args are not required.
     *
     * This function takes same $tag and $function parameters as remove_filter or remove_action respectively.
     *
     * ATTENTION:
     * You still cannot remove an action or filter before it has been added. So call this function on a hook afterwards.
     *
     * INFO:
     * actions and filters are treated the same by WordPress. remove_filter also removes the action. – that's convenient :)
     *
     * @param {string} $tag – the hook name
     * @param {string|function|array} $function – the originally given function
     *
     * @throws Exception
     *
     * @link https://stackoverflow.com/questions/19657940/removing-a-filter-added-by-a-class-from-a-plugin/43942428#43942428
     */
    public static function removeFilter($tag, $function) {
      global $wp_filter;
    
      if (!empty($wp_filter[$tag])) {
        $functionToRemoveInfo = PhpHelper::getFunctionInfo($function);
      
        foreach($wp_filter[$tag]->callbacks as $priority => $callbacks) {
          foreach ($callbacks as $cb => $cbData) {
          
            /**
             * remove if the functions are the same
             */
          
            if ($functionToRemoveInfo === PhpHelper::getFunctionInfo($cbData['function'])) {
              remove_filter($tag, $cbData['function'], $priority);
            }
          }
        }
      }
    }
    
    /*
     * Set Thumbnail Image Sizes
     */
    
    protected static $imageSizeData = array();
  
    public static function setImageSize($name, $width, $height, $cropped = false, $title = null, $description = null) { //cropped = true: images get sliced but will have exact size
      static::$imageSizeData[] = array(
        'name' => $name,
        'width' => $width,
        'height' => $height,
        'cropped' => $cropped,
        'title' => $title,
        'description' => $description,
      );
    
      switch ($name) {
        case 'thumbnail':
        case 'medium':
        case 'large':
          $croppedValue = ($cropped) ? 1 : 0;
          if (get_option($name.'_size_w') != $width) update_option($name.'_size_w', $width);
          if (get_option($name.'_size_h') != $height) update_option($name.'_size_h', $height);
          if (get_option($name.'_crop') != $croppedValue) update_option($name.'_crop', $croppedValue);
          break;
        default:
          add_image_size($name, $width, $height, $cropped);
          break;
      }
    }
  
    public static function getMediaMeta($attachmentId) {
      $attachment = get_post($attachmentId);
      return array(
        'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink($attachment->ID),
        'src' => $attachment->guid,
        'title' => $attachment->post_title,
      );
    }
  
    /*
     * Prevent Browser Caching
     */
    
    public static function preventBrowserCaching() {
      add_action('wp_head', array(get_class(), '_a_preventBrowserCaching'));
    }
  
    public static function _a_preventBrowserCaching() {
      echo '
			<meta http-equiv="cache-control" content="max-age=0" />
			<meta http-equiv="cache-control" content="no-cache" />
			<meta http-equiv="expires" content="0" />
			<meta http-equiv="expires" content="'.date('r').'" />
			<meta http-equiv="pragma" content="no-cache" />
		';
    }
    
    /*
     * IS-Functions
     */
  
    public static function isLoginPage() {
      global $pagenow;
      return in_array($pagenow, array('wp-login.php'));
    }
  
    public static function isRegisterPage() {
      global $pagenow;
      return in_array($pagenow, array('wp-register.php'));
    }
  
    public static function isActivatePage() {
      global $pagenow;
      return in_array($pagenow, array('wp-activate.php'));
    }
  
    public static function isFrontend() {
      return !is_admin() && !static::isLoginPage() && !static::isRegisterPage();
    }
  
    public static function isSingular() {
      return !is_archive() && (is_singular() || is_404());
    }
  
    public static function isPostsPage() {
      global $wp_query;
      return $wp_query->is_posts_page ? true : false;
    }
    
    /*
     * USER-Functions
     */
  
    public static function hasCurrentUserCap($cap) {
      if (is_user_logged_in()) {
        $user = wp_get_current_user();
        return $user->has_cap($cap);
      }
      else return false;
    }
  
    public static function setUserPassword($user, $newPassword, $resetActivationKey = true) {
      wp_set_password($newPassword, $user->data->ID);
    
      // set blank activation key
      if ($resetActivationKey) static::setNewUserActivationKey($user, true);
    }
  
    public static function setNewUserActivationKey($user, $setBlank = false) {
      // adapted from WP core
      global $wp_hasher;
      global $wpdb;
    
      if ($setBlank) {
        $wpdb->update($wpdb->users, array('user_activation_key' => ''), array('user_login' => $user->data->user_login));
        return '';
      }
    
      $key = wp_generate_password(20, false);
      do_action('retrieve_password_key', $user->data->user_login, $key);
    
      if (empty($wp_hasher)) {
        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash(8, true);
      }
      $hashedKey = $wp_hasher->HashPassword($key);
      $hashed = time() . ':' . $hashedKey;
    
      // insert new key in db
      $wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $user->data->user_login));
    
      return $key; // make sure to store key since it will get hashed!
    }
  
    public static function isValidUserActivationKey($user, $keyToCompare, $maxActivationKeyTtlSeconds = 172800) { // 60 * 60 * 24 * 2 days
      global $wp_hasher;
    
      // fetch key + timestamp
      $keyStored = $user->data->user_activation_key;
      if (!preg_match('/(\d+):(.+)/', $keyStored, $matches)) {
        return false;
      }
    
      // check activation timestamp lifetime
      $tsFrom = (int) $matches[1];
      if (time() - $tsFrom > $maxActivationKeyTtlSeconds) {
        return false;
      }
    
      // check hashes
      if (empty($wp_hasher)) {
        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash(8, true);
      }
      $hashedKey = $wp_hasher->HashPassword($keyToCompare);
    
      return $wp_hasher->CheckPassword($keyToCompare, $matches[2]);
    }
  
    public static function getUserByEmail($email) {
      $user = get_user_by('email', $email);
    
      if ($user && !is_wp_error($user)) {
        return $user;
      } else {
        return false;
      }
    }
  
    /**
     * @param $roleName
     * @param $user
     * @return bool
     * @throws Exception
     */
    public static function hasUserRole($roleName, $user) {
      if (!isset($user->roles)) throw new Exception('invalid user data');
    
      return in_array($roleName, (array) $user->roles);
    }
    
    /*
     * POSTMETA-Functions
     */
  
    /**
     * @param $sourcePostId
     * @param $targetPostId
     * @param bool $overrideExisting
     * @throws Exception
     */
    public static function copyPostCustomFields($sourcePostId, $targetPostId, $overrideExisting = true) {
      global $wpdb;
    
      $sourcePostId = (int) $sourcePostId;
      $targetPostId = (int) $targetPostId;
      if (!$sourcePostId || !$targetPostId) throw new Exception('invalid id(s)');
    
      // override existing
      if ($overrideExisting) {
        $sql = $wpdb->prepare("SELECT DISTINCT meta_key FROM " . $wpdb->prefix . "postmeta WHERE post_id = %d", $sourcePostId);
        $keys = $wpdb->get_col($sql);
        if ($keys) {
          $sql = $wpdb->prepare(
            "DELETE FROM " . $wpdb->prefix . "postmeta WHERE post_id = %d AND meta_key IN (%s);",
            $targetPostId,
            "'" . implode("','", $keys) . "'"
          );
          $wpdb->query($sql);
        }
      }
    
      $sql = $wpdb->prepare("INSERT INTO " . $wpdb->prefix . "postmeta (post_id, meta_key, meta_value) SELECT %d AS 'post_id', meta_key, meta_value FROM " . $wpdb->prefix . "postmeta WHERE post_id = %d;", $targetPostId, $sourcePostId);
      $wpdb->query($sql);
    }
    
    /*
     * SCRIPT-Functions
     */
  
    protected static function enableAsyncScripts() {
      add_filter('script_loader_tag', array(get_called_class(), '_f_enableAsyncScripts'), 10, 3);
    }
  
    public static function _f_enableAsyncScripts($tag, $handle, $src) {
      if (in_array($handle, static::$asyncScripts)) {
        $tag = str_replace('><', 'async defer ><', $tag);
      }
    
      return $tag;
    }
    
    protected static $asyncScripts = array();
  
    /**
     * Wrapper function for wp_enqueue_script that allows supplying additional arguments (e.g. async).
     * @param {string} $handle
     * @param {string} $src
     * @param {array} $args
     */
    public static function enqueueScript($handle, $src, $args = array()) {
      wp_enqueue_script($handle, $src, array_key_exists('deps', $args) ? $args['deps'] : array(), array_key_exists('ver', $args) ? $args['ver'] : false, array_key_exists('in_footer', $args) ? $args['in_footer'] : true);
    
      if (!empty($args['async'])) {
        static::$asyncScripts[] = $handle;
      }
    
      if (PhpHelper::checkSetFirstCall(__METHOD__, __CLASS__)) {
        static::enableAsyncScripts();
      }
    }
    
  }
