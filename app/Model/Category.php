<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 */
class Category extends AppModel {
	
	public $name = "Category";
	
	public $useTable = "categories";

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'sort' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'maxlength' => array(
				'rule' => array('maxlength'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	public function get_list($id) {

		$sql = "SELECT node.*".
			", (SELECT COUNT(parent_id)".
			" FROM categories".
			" WHERE parent_id = node.id) AS child_cnt".
			" FROM categories AS node WHERE id IN".
			" (SELECT id FROM `categories` WHERE parent_id = ? AND status = ?)".
			" ORDER BY sort ASC";
		
		$db = $this->getDataSource();
		$data = $db->fetchAll($sql, array($id, 1));
		return $data;
	}
	
	public function get_category_info($category) {
		static $list = null;
		$result = array();
		
		if (!$category) {
			return array();
		}
		
		if (is_null($list)) {
			$list = $this->find("list");
		}
		
		foreach(explode(",", $category) as $path) {
			if ($path) {
				preg_match_all("/\d+/", $path, $category_ids);
				$data = array();
				foreach ($category_ids[0] as $category_id) {
					$data[] = array(
						"id" => $category_id,
						"name" => $list[$category_id]
						);
				}
				$result[] = array(
					"path" => $path,
					"info" => $data
				);
			}
		}
		return $result;
	}
}
