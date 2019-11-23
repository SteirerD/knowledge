<?php
  
  class PHPHelper {
    
    public static function redirect($url, $type = null) {
      if (headers_sent()) throw new Exception('redirection impossible: headers sent');
    
      switch ($type) {
        case 301:
          header('HTTP/1.1 301 Moved Permanently');
          break;
        case 302:
          header('HTTP/1.1 302 Found');
          break;
        case 303:
          header('Cache-Control: no-cache, must-revalidate');
          header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // some date in the past
          header('Location:'.$url, true, 303); // 303 -> MUST NOT cache
          die;
          break;
        case 307:
          header('HTTP/1.1 307 Temporary Redirect');
          break;
        default:
      }
    
      header('Location:'.$url);
      die;
    }
  
    protected static $functionCallIds = array();
    
    /**
     * Registers calls by its name and an optional namespace.
     * Usage for executing a function only once
     * if (!PhpHelper::checkSetFirstCall(__METHOD__, __CLASS__)) return;
     *
     * @param string $fn Function name
     * @param string $ns Namespace name to group function calls together
     * @return bool
     */
    public static function checkSetFirstCall($fn, $ns = null) {
      $id = !is_null($ns) ? $fn : $ns.'::'.$fn;
      $output = !in_array($id, static::$functionCallIds);
      static::$functionCallIds[] = $id;
      return $output;
    }
  
    /**
     * Return information about a function, such as the class name and the function name
     * Can be used to easily compare two functions even if they are not called in the same way
     *
     * @param {string|function|array} $function – the name of a (global) function, an anonymous function or an array('SomeClass', 'someFunction')
     * @return {array} – class name and function name or object
     *
     * @example
     * getFunctionInfo('someGlobalFunction')
     * return: array('class' => null, 'function' => 'someGlobalFunction')
     *
     * @example
     * getFunctionInfo(array('someClass', 'someFunction'))
     * return: array('class' => 'someClass', 'function' => 'someFunction')
     *
     * @example
     * getFunctionInfo(array($this, 'someFunction'))
     * return: array('class' => 'className', 'function' => 'someFunction')
     *
     * @example
     * getFunctionInfo(function())
     * return: array('class' => null, 'function' => function())
     *
     * @throws Exception
     */
    public static function getFunctionInfo(&$function) {
      $info = array(
        'class' => null,
        'function' => null,
      );
    
      /**
       * function is defined as an array
       * @example array(&$this, 'someFunction')
       * @example array(get_called_class(), 'someFunction')
       * @example array('SomeClass', 'someFunction')
       */
      if (is_array($function)) {
        $info['class'] = gettype($function[0]) === 'object' ? get_class($function[0]) : $function[0];
        $info['function'] = $function[1];
      }
    
      /**
       * anonymous function
       * @example function() {}
       */
      else if (gettype($function) === 'object') {
        $info['function'] = $function;
      }
    
      /**
       * function defined as string
       * @example 'someGlobalFunction'
       */
      else if (is_string($function)) {
        $info['function'] = $function;
      }
    
      /**
       * there might be other ways to define functions
       * throw an exception in that case so it can be added here
       */
      else {
        throw new Exception('invalid function type. don\'t know how to handle that :(');
      }
    
      return $info;
    }
  
    /**
     * http://stackoverflow.com/a/8891890
     *
     * @return string
     */
    public static function getCurrentUrl($appendRequestUri = true, $useForwardedHost = false) {
      $s = $_SERVER;
      $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
      $sp = strtolower($s['SERVER_PROTOCOL']);
      $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
      $port = $s['SERVER_PORT'];
      $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
      $host = ($useForwardedHost && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
      $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
      $output = $protocol . '://' . $host;
      if ($appendRequestUri) $output .= $s['REQUEST_URI'];
    
      return $output;
    }
  
    /*
     * OUTPUT-Functions
     */
  
    public static function outputJson($data, $die = true, $charset = 'UTF-8', $prettyPrint = false) {
      if (!headers_sent()) {
        header('Content-Type: application/json; charset='.$charset);
      }
      $options = 0;
      if ($prettyPrint && defined('JSON_PRETTY_PRINT')) $options = JSON_PRETTY_PRINT;
      echo json_encode($data, $options);
      if ($die) die;
    }
  
    public static function outputFile($path, $fileName = null, $die = true) {
      if (headers_sent()) throw new Exception('headers already sent');
      if (!file_exists($path)) throw new Exception('file not found: ' . $path);
    
      if (!$fileName) $fileName = basename($path);
    
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . $fileName . '"');
      header("Content-Length: " . filesize($path));
    
      echo file_get_contents($path);
    
      if ($die) die;
    }
    
    /*
     * FILE-Functions
     */
    
    public static function removeFilesFromDir($dir) {
      $files = glob($dir.'/*');
      foreach ($files as $file){
        if (is_file($file)) unlink($file);
      }
    }
  
    public static function copyFilesFromDir($dirSource, $dirTarget) {
      $dir = opendir($dirSource);
      //@mkdir($dirTarget);
      while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
          if ( is_dir($dirSource . '/' . $file) ) {
            recurse_copy($dirSource . '/' . $file, $dirTarget . '/' . $file);
          }
          else {
            copy($dirSource . '/' . $file, $dirTarget . '/' . $file);
          }
        }
      }
      closedir($dir);
    }
  
    public static function getFilenameExtension($path) {
      return pathinfo($path, PATHINFO_EXTENSION);
    }
  
    public static function getDirectorySize($directoryPath) {
      $size = 0;
    
      foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directoryPath)) as $file) {
        $size += $file->getSize();
      }
    
      return $size;
    }
  
    /*
     * ZIP-Functions
     */
  
    /**
     * generateZipArchiveFromFolder function.
     *
     * @access public
     * @static
     * @param string $zipPath
     * @param string $dirFiles
     * @param bool $rootFiles (default: false) all files become root if true, otherwise the corresponding directories will appear in archive
     * @return void
     * @throws Exception
     */
    public static function generateZipArchiveFromFolder($zipPath, $dirFiles, $rootFiles = false) {
      $zip = new ZipArchive();
    
      if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
        $zip->close();
        throw new Exception('zip file could not be created: '.$zipPath);
      }
    
      $files = glob($dirFiles.'/*');
      if ($files) {
        foreach ($files as $file) {
          $filename = basename($file);
          if ($rootFiles) {
            $zip->addFile($file, '/'.$filename);
          }
          else {
            $zip->addFile($file);
          }
        }
      }
    
      $zip->close();
    }
    
    /*
     * STRING-Functions
     */
  
    public static function startsWith($haystack, $needle) {
      return !strncmp($haystack, $needle, strlen($needle));
    }
  
    public static function endsWith($haystack, $needle) {
      return $needle === '' || substr($haystack, -strlen($needle)) === $needle;
    }
  
    public static function trailingslashit($string, $nothingIfEmpty = false) {
      if ($nothingIfEmpty && empty($string)) return;
    
      return static::untrailingslashit($string) . '/';
    }
  
    public static function untrailingslashit($string) {
      return rtrim($string, '/\\');
    }
    
    /*
     * GET-Funcitons
     */
    
    public static function getFullUrl($server = null) {
      if ($server === null) $server = $_SERVER;
    
      $ssl = (!empty($server['HTTPS']) && $server['HTTPS'] == 'on') ? true:false;
      $sp = strtolower($server['SERVER_PROTOCOL']);
      $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
      $port = $server['SERVER_PORT'];
      $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
      $host = isset($server['HTTP_X_FORWARDED_HOST']) ? $server['HTTP_X_FORWARDED_HOST'] : isset($server['HTTP_HOST']) ? $server['HTTP_HOST'] : $server['SERVER_NAME'];
    
      return $protocol . '://' . $host . $port . $server['REQUEST_URI'];
    }
  
    public static function getIP() {
      if (isset($_SERVER['REMOTE_ADDR'])) return $_SERVER['REMOTE_ADDR'];
      else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
      else if (isset($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    }
    
    /*
     * IS-Functions
     */
  
    public static function isLocal() {
      return $_SERVER['SERVER_PORT'] == 8000 || preg_match('/(localhost|\.local$)/', $_SERVER['SERVER_NAME']);
    }
  
    public static function isAjax() {
      return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
  
    public static function isHttps() {
      return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? true : false;
    }
  
    public static function isUrlAbsolute($url) {
      return preg_match('/^http(s?)\:\/\//', $url) ? true : false;
    }
  
    public static function isLoopableArray($array) {
      return is_array($array) && count($array) > 0;
    }
  
    public static function isArrayAssoc($array) {
      return array_keys($array) !== range(0, count($array) - 1);
    }
  
    public static function isValidEmail($email) {
      return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,7})$/i', $email) ? true: false;
    }
  
    public static function isStringSerialized($string) {
      $data = @unserialize($string);
    
      return $string === 'b:0;' || $data !== false;
    }
    
    /*
     * ARRAY-Functions
     */
  
    public static function implodeAssoc($array = array(), $keyGlue = '', $lineGlue = '', $addLineGlueOnLastLine = false) {
      $return = '';
    
      $i = 0;
      $count = count($array);
    
      foreach($array as $key => $value) {
        $return .= $key . $keyGlue . $value;
        if ($i <= $count - 1) $return .= $lineGlue;
        else if ($addLineGlueOnLastLine) $return .= $lineGlue;
        $i++;
      }
    
      return $return;
    }
    
  }
