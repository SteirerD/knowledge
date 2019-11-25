<?php
  
  class VCElement {
    
    private $name;
    private $base;
    private $category;
    private $params;
    private $element;
  
    /**
     * VCElement constructor.
     * @param $name string the bame of the VC Element
     * @param $base string the base of the VC Element
     * @param $category string the category in which this VC Element should be placed
     * @param $later boolean true to include the VC Element at a later hook so custom taxonomies and translations are working correctly
     */
    public function __construct( $name, $base, $category, $later = false ) {
      $this->name = $name;
      $this->base = $base;
      $this->category = $category;
      $this->params = [];
    
      $this->element = array(
        'name'        => __( $this->name, 'wiki' ),
        'base'        => $this->base,
        'category'    => __($this->category, 'wiki'),
      );
      
      // Check if VC Plugin is installed and active
      add_action( 'admin_init', array( &$this, 'checkVCStatus' ) );
  
      // Enable VC Element
      if($later) {
        add_action('after_setup_theme', array( &$this, 'doVCMap' ));
      } else {
        add_action('vc_before_init', array( &$this, 'doVCMap' ));
      }
    }
  
    /**
     * Check if the WPBakery Page Builder Plugin is installed and active.
     * If not, show an Error Message in the Wordpress Backend
     */
    public function checkVCStatus(){
      if(!is_plugin_active('js_composer/js_composer.php')) {
        WPFunctionsHelper::addBackendWarning( 'Das Plugin "WPBakery Page Builder" muss installiert und aktiviert sein!');
      }
    }
  
    /**
     * Add a param to the VC Element
     * @param $type string Type of the field
     * @param $heading string Heading used to describe the field
     * @param $param_name string Parameter name used to retrieve the data
     * @param $args array other key=>value params depending on the used type
     * @return string Parameter name
     */
    public function addParam($type, $heading, $param_name, $args = []){
      $data = array(
        'type' => $type,
        'heading' => __( $heading, 'wiki' ),
        'param_name' => $param_name,
      );
  
      $data = array_merge($data, $args);
  
      $this->params[] = $data;
      
      return $param_name;
    }
  
    /**
     * Add a sub_param to a given param_name
     * @param $name string The param_name we want to add the sub_param to
     * @param $type string Type of the sub_field
     * @param $heading string Heading used to describe the sub_field
     * @param $param_name string Parameter name used to retrieve the data of the sub_field
     * @param $args array other key=>value params depending on the used type
     * @return bool|string
     */
    public function addSubParam($name, $type, $heading, $param_name, $args =[]){
  
      $new_param_name = false;
  
      foreach($this->params as &$parent_param):
    
        $new_param_name = $this->resursiveAddSubParam($parent_param, $name, $type, $heading, $param_name, $args);
  
      endforeach;
  
      return $new_param_name;
      
    }
  
    /**
     * Recursive add Sub-Param function
     * @param $parent_param array The current param instance
     * @param $param_name_to_check string The param_name we want to add the subfield to
     * @param $type string The param_type of the sub_param we want to add
     * @param $heading string The heading of the sub_param we want to add
     * @param $param_name string The param_name of the sub_param we want to add
     * @param $args $args array of key=>value arguments that define the sub_param even more
     * @return bool|string param_name of the sub_field, false if it couldn't be added
     */
    private function resursiveAddSubParam(&$parent_param, $param_name_to_check, $type, $heading, $param_name, $args){
  
      $new_param_name = false;
      
      // Check if the current field has sub_fields and trigger recursiveAddSubField on these if there are any
      if(isset($parent_param['params']) && is_array($parent_param['params']) && sizeof($parent_param['params']) > 0):
    
        // Go through all sub_fields recursively
        foreach($parent_param['params'] as &$sub_field):
          $recursive_new_param_name = $this->resursiveAddSubParam($sub_field, $param_name_to_check, $type, $heading, $param_name, $args);
          if($recursive_new_param_name){
            $new_param_name = $recursive_new_param_name;
          }
        endforeach;
  
      endif;
  
      // Check if the parent_param is equal to the param_name_to_check
      // This means check if the current parent_field from the loop is equal to the parent_field we want to add the subfield to
      $parent_param_name = $parent_param['param_name'];
  
      if($parent_param_name == $param_name_to_check):
      
        $new_param_name = $param_name;
        
        $data = array(
          'type' => $type,
          'heading' => __( $heading, 'wiki' ),
          'param_name' => $new_param_name,
        );
  
        $data = array_merge($data, $args);
  
        $parent_param['params'][] = $data;
  
      endif;
  
      return $new_param_name;
    }
  
    /**
     * Add the defined VC-Element to the Wordpress-Backend
     */
    public function doVCMap(){
      $element = $this->element;
      $element['params'] = $this->params;
    
      if(function_exists('vc_map')){
        vc_map($element);
      }
      
      // Since you can't declare a PHP Class in another PHP Class we have to kind of "trick" PHP
      $class_definition = sprintf("class WPBakeryShortCode_%s extends WPBakeryShortCode {}", $this->base);
      eval($class_definition);
      
    }
    
    /**
     * =======================================
     *            STATIC FUNCTIONS
     * =======================================
     */
  
    /**
     * Add a parementer to an existing VC-Element
     * @param $elem string Base-Name of the existing VC-Element we want to add something to
     * @param $type string Type of the field
     * @param $heading string Heading used to describe the field
     * @param $param_name string Parameter name used to retrieve the data of the field
     * @param $args array other key=>value params depending on the used type
     */
    public static function addParamToExistingElem($elem, $type, $heading, $param_name, $args ){
      $data = array(
        'type' => $type,
        'heading' => __( $heading, 'wiki' ),
        'param_name' => $param_name,
      );
  
      $data = array_merge($data, $args);
  
      vc_add_param( $elem, $data);
    }
  
    /**
     * Remove a parameter from an existing VC-Element
     * @param $elem string Base-Name of the existing VC-Element
     * @param $param_name string Parameter-Name we want to remove
     */
    public static function removeParamFromExistingElem($elem, $param_name){
      vc_remove_param($elem, $param_name);
    }
  
    /**
     * Remove an existing VC-Element
     * @param $elem string Base-Name of the existing VC-Element
     */
    public static function removeExistingElement($elem){
      vc_remove_element($elem);
    }
  }
