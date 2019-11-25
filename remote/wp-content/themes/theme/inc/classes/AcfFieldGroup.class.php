<?php
  
  class AcfFieldGroup {
    
    private $groupSlug;
    private $groupTitle;
    private $location_param;
    private $location_value;
    private $fieldgroup;
    private $fields;
    
    /**
     * AcfFieldGroup constructor.
     *
     * @param $groupSlug string Group slug for the field group
     * @param $groupTitle string Group title for the field group
     * @param $location_param string Location type, e.g. post_type
     * @param $location_value mixed Value to be checked depending on location type, e.g. post, can be array for multiple post-types
     */
    public function __construct( $groupSlug, $groupTitle, $location_param, $location_value ) {
      $this->groupSlug = $groupSlug;
      $this->groupTitle = $groupTitle;
      $this->location_param = $location_param;
      $this->location_value = $location_value;
      $this->fields = [];
      
      require_once get_template_directory() . '/inc/classes/AcfConfig.class.php';
      
      if(is_array($this->location_value)) {
        
        $location = [];
        foreach($this->location_value as $value){
          $location[] = array( array (
            'param' => $this->location_param,
            'operator' => '==',
            'value' => $value,
          ));
        }
        
        $this->fieldgroup = array(
          'key' => AcfConfig::getGroupKey( $this->groupSlug ),
          'title' => $this->groupTitle,
          'location' => $location,
          'style' => 'seamless'
        );
        
      } else {
        $this->fieldgroup = array(
          'key' => AcfConfig::getGroupKey( $this->groupSlug ),
          'title' => $this->groupTitle,
          'location' => array (
            array (
              array (
                'param' => $this->location_param,
                'operator' => '==',
                'value' => $this->location_value,
              ),
            ),
          ),
          'style' => 'seamless'
        );
      }

      
      // Check if ACF Plugin is installed and active
      add_action( 'admin_init', array( &$this, 'checkACFPluginStatus' ) );
      
      // Enable ACF Field Group
      add_action('acf/init', array( &$this, 'doAddFieldGroup' ));
    }
    
    /**
     * Show an error message in backend when ACF is not installed and activated
     */
    public function checkACFPluginStatus(){
      if(!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
        WPFunctionsHelper::addBackendError('Das Plugin "Advanced Custom Fields Pro" muss installiert und aktiviert sein!');
      }
    }
    
    /**
     * Add a field to the field group
     * @param $type string ACF field type which should be used
     * @param $label string Label that describes the field
     * @param $name string Name from which data can be retrieved
     * @param array $args array other key=>value arguments that define the field type even more
     * @return string Key of the field
     */
    public function addField( $type, $label, $name, $args = array() ){
      
      $key = AcfConfig::getFieldKey( $this->groupSlug . $name );
      
      $field_definition = array (
        'key' => $key,
        'label' => __( $label, 'test' ),
        'name' => $this->groupSlug . $name,
        'type' => $type
      );
      
      $field_definition = array_merge($field_definition, $args);
      
      $this->fields[] = $field_definition;
      
      return $key;
      
    }
    
    /**
     * Add a subfield to the defined key field
     * @param $key string Field-Key of the parent field
     * @param $type string ACF field type which should be added
     * @param $label string Label that describes the field
     * @param $name string Name from which data can be retrieved
     * @param array $args array other key=>value arguments that define the field type even more
     * @return bool|string New subfield key, false if the sub_field couldn't be added
     */
    public function addSubfield( $key, $type, $label, $name, $args = array()) {
      
      $subfield_key = false;
      
      foreach($this->fields as &$parent_field):
        
        $new_subfield_key = $this->recursiveAddSubField($parent_field, $key, $type, $label, $name, $args);
        
        if($new_subfield_key){
          $subfield_key = $new_subfield_key;
        }
      
      endforeach;
      
      return $subfield_key;
    }
  
    /**
     * Perform the acf_add_local_field_group function with the data defined in the object
     */
    public function doAddFieldGroup(){
      $data = $this->fieldgroup;
      $data['fields'] = $this->fields;
      
      if(function_exists('acf_add_local_field_group')){
        acf_add_local_field_group($data);
      }
    }
  
    /**
     * Recursive add Sub-Field function
     * @param $parent_field array The current field instance
     * @param $key string the Field-Key we want to add the sub_field to
     * @param $type string ACF field type which should be added
     * @param $label string Label that describes the field
     * @param $name string Name from which data can be retrieved
     * @param array $args array other key=>value arguments that define the field type even more
     * @return bool|string
     */
    private function recursiveAddSubField(&$parent_field, $key, $type, $label, $name, $args) {
      
      $new_key = false;
      
      // Check if the current field has sub_fields and trigger recursiveAddSubField on these if there are any
      if(isset($parent_field['sub_fields']) && is_array($parent_field['sub_fields']) && sizeof($parent_field['sub_fields']) > 0):
        
        // Go through all sub_fields recursively
        foreach($parent_field['sub_fields'] as &$sub_field):
          $recursive_new_key = $this->recursiveAddSubField($sub_field, $key, $type, $label, $name, $args);
          if($recursive_new_key){
            $new_key = $recursive_new_key;
          }
        endforeach;
      
      endif;
  
      // Check if the parent_key is equal to the key given
      // This means check if the current parent_field from the loop is equal to the parent_field we want to add the subfield to
      $parent_field_key = $parent_field['key'];
  
      if($parent_field_key == $key):
    
        $new_key = AcfConfig::getFieldKey( $this->groupSlug . $name );
    
        $field_definition = array (
          'key' => $new_key,
          'label' => __( $label, 'wiki' ),
          'name' => $this->groupSlug . $name,
          'type' => $type
        );
    
        $field_definition = array_merge($field_definition, $args);
    
        $parent_field['sub_fields'][] = $field_definition;
  
      endif;
      
      return $new_key;
      
    }
    
  }
