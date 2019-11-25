<?php
  class AcfConfig {
    public static function getFieldKey( $slug ) {
      return 'field_' . md5( $slug );
    }
    
    public static function getGroupKey( $slug ) {
      return 'group_' . md5( $slug );
    }
    
    public static function registerConfig($config) {
      if (!function_exists('register_field_group')) throw new Exception('ACF missing');
      
      register_field_group($config);
    }
  }
