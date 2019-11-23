<?php
/**
 * WpCustomColumns
 * 
 * Easily modify columns in the WordPress Admin Interface.
 * Works with default post types (post, page), custom post-types and attachments (media library)
 * in regular (GET) and "Quick Edit" mode (AJAX).
 *
 * 
 * Features:
 * 		add custom columns
 * 		move default columns
 * 		remove default columns
 * 		
 *
 * Author: EN GARDE (David Hell)
 * 
 * Example:
 * 
			$wpCustomColumns = WpCustomColumns::getInstance();
			$wpCustomColumns->addColumn('category', array(
				'name' => __('Gremien-Kategorien', 'theme'),
				'post_types' => array('pt-gremium'),
				'position' => 55,
				'content' => function($post) {
					$categories = wp_get_object_terms($post->ID, 'tx-gremium');
					if (empty($categories) || !is_array($categories)) return __('Noch nicht zugeordnet', 'theme');
					$return = '';
					foreach ($categories as $index => $category) {
						if ($index) $return .= ', ';
						$categoryLink = admin_url('edit.php?post_type=pt-gremium&tx-gremium=' . $category->slug);
						$return .= '<a href="' . $categoryLink . '">' . $category->name . '</a>';
					}
					return $return;
				},
				'sortable' => false,
			));
 * 
 * 
 * Version: 1.3
 *
 * Changelog:
 *  v1.3 : added content_args for content callbacks
 *  v1.2 : added example
 * 	v1.1 : added upload (media library) support (use post type 'attachment'), fixed sortable column bug
 * 	v1.0 : initial version
 */
class WpCustomColumns {
	private static $instance;

	protected $settings = array();
	protected $defaultSettings = array();
	protected $customColumns = array();
	protected $removeColumns = array();

	protected $columnPositions = array();


	// this class provides a simple way of adding custom fields
	// to the post list pages and optionally make them sortable

	// good reference: http://scribu.net/wordpress/custom-sortable-columns.html
	
	protected function __construct() {

		$this->defaultSettings = array(
			// display name of the column
			'name' => __('Eigene Spalte', 'glc'),

			// post types to show the column in
			'post_types' => array('post'),

			// position (where to show the column). default: to the rightmost
			'position' => null,

			// display the conten. ether a string (name of meta_key) or a function
			// 'content' => 'meta_key',
			'content' => function($post, $args = array()) {
				return '<em>' . __('Kein Content-Callback definiert', 'glc') . '</em>';
			},
			// parameters for content callbacks
			'content_args' => array(),

			// make column sortable
			'sortable' => false,

			// name of meta_key to sort by
			// slug will be used if omitted
			// 'sort_meta_key' => 'meta_key',

			// see wp_query->orderby
			// eg 'ID', 'modified', 'date', 'meta_value', 'meta_value_num'
			'sort_orderby' => 'ID',

			// add meta field name if orderby is 'meta_value_num' or 'meta_value'
			// 'sort_meta_key' => 'INSERT_META_KEY_HERE',
		);

		$this->columnPositions = array(
			'cb' => 0,
			'icon' => 5,
			'title' => 10,
			'author' => 20,
			'categories' => 30,
			'tags' => 40,
			'parent' => 25,
			'comments' => 50,
			'date' => 60,
			'wpseo_desc' => 90,
		);
		
		if (is_admin()) {

			if ($this->isAjaxRequest()) {
				add_action('admin_init', array(&$this, 'modifyBackend'));
			}
			else {
				add_action('wp', array(&$this, 'modifyBackend'));
			}

			// check request for sortable columns
			add_filter('request', array(&$this, 'sortColumn'));
		}

	}


	// ======================================================================
	// INTERNAL FUNCTIONS
	// ======================================================================

	protected function getCurrentPostType() {
		global $post;
		global $wp_query;
		$return = false;

		// try to get it from post
		if(isset($post) && isset($post->post_type) && !empty($post->post_type)) {
			$return = $post->post_type;
		}

		// try from wp_query
		else if (isset($wp_query) && isset($wp_query->query['post_type']) && !empty($wp_query->query['post_type'])) {
			$return = $wp_query->query['post_type'];
		}

		// try it from POST if AJAX request
		else if ($this->isAjaxRequest() && isset($_POST) && isset($_POST['post_ID']) && !empty($_POST['post_ID'])) {
			$return = (int) $_POST['post_ID'];
		}

		/*else {
			die('could not find post type');
		}*/

		return $return;
	}

	protected function isAjaxRequest() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	protected function updateColumnPosition($a, $b) {
		if(isset($this->columnPositions[$a]) && isset($this->columnPositions[$b])) {
			
			if ($this->columnPositions[$a] == $this->columnPositions[$b]){
				$return = 0;
			}
			else if ($this->columnPositions[$a] > $this->columnPositions[$b]) {
				$return = 1;
			}
			else {
				$return = -1;
			}
		}
		else if(isset($this->columnPositions[$a])) {
			$return = -1;
		}
		else if(isset($this->columnPositions[$b])) {
			$return = 1;
		}
		else {
			$return = 0;
		}
		return $return;
	}


	// ======================================================================
	// PUBLIC FUNCTIONS
	// ======================================================================

	// use this function to add a new column
	public function addColumn($slug, $settings = array()) {
		if(!isset($slug) || empty($slug)) return false;

		$this->customColumns[$slug] = array_merge($this->defaultSettings, $settings);
		$this->columnPositions[$slug] = $this->customColumns[$slug]['position'];

		return true;
	}

	public function removeColumn($slug) {
		if(!isset($slug) || empty($slug)) return false;

		if(isset($this->customColumns[$slug])) unset($this->customColumns[$slug]);
		else $this->removeColumns[$slug] = false;

		return true;
	}

	public function changeColumnPosition($slug, $position) {
		if(!isset($slug) || empty($slug) || !isset($position) || empty($position)) return false;
		if(!isset($this->columnPositions[$slug])) return false;

		$this->columnPositions[$slug] = $position;
	}

	// ======================================================================
	// HOOK FUNCTIONS
	// ======================================================================

	public function modifyBackend() {
		if($this->isActionNecessary()) {

			// register columns (add the header)
			add_filter('manage_posts_columns', array(&$this, 'registerColumns')); // posts and post types, except pages
			add_filter('manage_page_posts_columns', array(&$this, 'registerColumns')); // only wordpress default pages
			add_filter('manage_upload_columns', array(&$this, 'registerColumnsUpload')); // media library

			// display content
			add_filter('manage_posts_custom_column', array(&$this, 'displayContent')); // posts and post types, except pages
			add_filter('manage_page_posts_custom_column', array(&$this, 'displayContent')); // only wordpress default pages
			add_filter('manage_media_custom_column', array(&$this, 'displayContent')); // media library
			
			// register sortable columns
			// because post_type independent version does not exist, find out the current post_type and create a variable hook/filter that always fires
			add_filter('manage_edit-' . $this->getCurrentPostType() . '_sortable_columns', array(&$this, 'registerSortableColumns'));
			add_filter('manage_upload_sortable_columns', array(&$this, 'registerSortableColumns'));

		}
	}


	public function registerColumns($all_columns, $postType = null) {
		if ($postType === null) $postType = $this->getCurrentPostType();
		foreach($this->customColumns as $slug => $column) {
			// check if column should be added for this post_type
			if(in_array($postType, $column['post_types'])) {
				$all_columns[$slug] = $column['name'];
			}
		}

		// remove columns
		if(count($this->removeColumns) > 0) {
			$all_columns = array_diff_key($all_columns, $this->removeColumns);
		}

		// reorder columns
		uksort($all_columns, array(&$this, 'updateColumnPosition'));

		return $all_columns;
	}

	public function registerColumnsUpload($all_columns, $postType = null) {
		return $this->registerColumns($all_columns, 'attachment');
	}

	public function displayContent($current_column) {
		// see if the current column comes from this class
		global $post;

		if (isset($this->customColumns[$current_column])) {

			if (is_callable($this->customColumns[$current_column]['content'])) {
				$content = call_user_func($this->customColumns[$current_column]['content'], $post, $this->customColumns[$current_column]['content_args']);
			} else {
				// get meta field with the name supplied
				$content = get_post_meta($post->ID, $this->customColumns[$current_column]['content'], true);
			}

			echo $content;
		}
	}


	public function registerSortableColumns($all_columns) {
		foreach($this->customColumns as $slug => $column) {
			global $post;

			// check if column is sortable
			if($column['sortable']) {
				$all_columns[$slug] = $slug;
			}
		}

		return $all_columns;
	}


	public function sortColumn($query_vars) {
		// check if the current orderby field comes from this class, ...
		if(isset($query_vars['orderby']) && isset($this->customColumns[$query_vars['orderby']])) {
			$slug = $query_vars['orderby'];
			$column = $this->customColumns[$slug];

			// ... if it's tagged as sortable and has the right post_type
			if($column['sortable'] === true && in_array($query_vars['post_type'], $column['post_types'])) {

				$query_vars['orderby'] = $column['sort_orderby'];

				if(isset($column['sort_meta_key']) && !empty($column['sort_meta_key']))
					$query_vars['meta_key'] = $column['sort_meta_key'];
			}
		}
		return $query_vars;
	}



	// ======================================================================
	// ON/OFF SWITCH
	// ======================================================================
	// this function checks if taking action is actually necassary

	protected function isActionNecessary() {
		if(count($this->customColumns) > 0 || count($this->removeColumns) > 0)
			return true;
		else
			return false;
	}



	// ======================================================================
	// SINGLETON
	// ======================================================================

	public static function getInstance() {
		if (self::$instance === null) {
			$class = get_called_class();
			self::$instance = new $class();
		}
		
		return self::$instance;
	}
}
