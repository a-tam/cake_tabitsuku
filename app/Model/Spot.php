<?php
App::uses('AppModel', 'Model');

/**
 * Spot Model
 *
 * @property User $User
 * @property Route $Route
 */
class Spot extends AppModel {

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
			'name' => array(
					'maxlength' => array(
							'rule' => array('maxlength', 200),
							//'message' => 'Your custom message here',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'lat' => array(
					'numeric' => array(
							'rule' => array('numeric'),
							//'message' => 'Your custom message here',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'lng' => array(
					'numeric' => array(
							'rule' => array('numeric'),
							//'message' => 'Your custom message here',
							//'allowEmpty' => false,
							//'required' => false,
							//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),
			),
			'zoom' => array(
			'numeric' => array(
			'rule' => array('numeric'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			),
			'like_count' => array(
			'numeric' => array(
			'rule' => array('numeric'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			),
	);
	
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	*/
	public $belongsTo = array(
		'User' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields'     => array(
				'id',
				'name',
			),
			'order'      => '',
		)
	);
		
	/**
	 * hasMany associations
	 *
	 * @var array
	*/
	public $hasMany = array(
		'Route'
		/*
		 * 時間が在るときにでも研究してみる。
		 * https://github.com/josegonzalez/upload
		'Attachment' => array(
			'className'    => 'Attachment',
			'foreignKey'   => 'foreign_key',
			'conditions' => array(
				'Attachment.model' => 'Spot',
			),
		),
		*/
	);
	
	/**
	 *
	 * Enter description here ...
	 *
	 * @var unknown
	 */
	public $hasAndBelongsToMany = array(
		'Tag' => array(
			'className'             => 'Tag',
			'joinTable'             => 'spots_tags',
			'foreignKey'            => 'spot_id',
			'associationForeignKey' => 'tag_id',
			'unique'                => true,
			'fields'                => array('Tag.id', 'Tag.name'),
		)
	);
	
	// 検索対象のフィルタ
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
		'name'     => array('type' => 'like'),
		'keyword'  => array('type' => 'query', 'method' => 'findByKeyword'),
		'ne_lat'   => array('type' => 'query', 'method' => 'findByLatLng'),
		'category' => array('type' => 'like'),
		'tags'     => array('type' => 'like'),
	);
	public $base_condition = array('Spot.status' => '1');
	// 検索対象のフィールド設定
	public $presetVars = array(
			array('field' => 'id', 'type' => 'value'),
			array('field' => 'name', 'type' => 'like'),
			array('field' => 'description', 'type' => 'like'),
			array('field' => 'keyword', 'type' => 'like'),
	);
	
	public function findByKeyword($data = array()) {
		$cond = array();
		$keyword = $data["keyword"];
		if ($keyword) {
			$cond = array(
				'OR' => array(
					$this->alias . '.name LIKE' => '%' . $keyword . '%',
// 					$this->alias . '.description LIKE' => '%' . $keyword . '%',
				)
			);
		}
		return $cond;
	}
	
	public function findByLatLng($data = array()) {
		$cond = array();
		if ($data["ne_lat"] && $data["sw_lat"] && $data["ne_lng"] && $data["sw_lng"]) {
			$cond = array(
				'AND' => array(
					$this->alias . '.lat < '.$data["ne_lat"],
					$this->alias . '.lat > '.$data["sw_lat"],
					$this->alias . '.lng < '.$data["ne_lng"],
					$this->alias . '.lng > '.$data["sw_lng"],
				));
		}
		return $cond;
	}
	
	public function findByTags($data = array()) {
		$this->Tagged->Behaviors->attach('Containable', array('autoFields' => false));
		$this->Tagged->Behaviors->attach('Search.Searchable');
		$query = $this->Tagged->getQuery('all', array(
				'conditions' => array('Tag.name'  => $data['tags']),
				'fields' => array('foreign_key'),
				'contain' => array('Tag')
		));
		return $query;
	}
	
	/**
	 * 存在すれば更新、無ければ追加
	 * @param unknown $data
	 * @param string $validate
	 * @param unknown $fieldList
	 * @return Ambigous <mixed, boolean, multitype:>
	 */
	public function save($data, $validate = true, $fieldList = array()) {
		if (!$data[$this->name]["id"]) {
			// 追加
			$this->create();
			$data[$this->name]["status"] = "1";
		} else {
			// 更新
			$this->id = $data[$this->name]["id"];
		}
		return parent::save($data, $validate = true, $fieldList = array());
	}
	
	/**
	 * 保存前処理
	 * @see Model::beforeSave()
	 */
	public function beforeSave() {
		// 画像のサムネイル作成
		if ($this->data[$this->name]["image"]) {
			$file = $this->data[$this->name]["image"];
			if ($file["error"] == 0 && $file["size"] > 0) {
				$imageResizer = new ImageResizerComponent();
				$resize_type = array(
					"thumb" => array("width" => 320, "height" => 240),
					"middle" => array("width" => 800, "height" => 600),
				);
				$row_name = uniqid();
				$ext = substr($file["name"], strrpos($file["name"], '.') + 1);
				$file_name = $row_name.".".$ext;
				foreach ($resize_type as $type => $param) {
					try {
						$resize = array(
							'output' => ROOT."/".APP_DIR."/".WEBROOT_DIR."/uploads/spot/".$type."/" .$file_name,
							'maxHeight' => $param["height"],
							'maxWidth' => $param["width"]
						);
						$this->log($resize);
						$succeed = $imageResizer->resizeImage($file["tmp_name"], $resize);
					} catch (CakeException $error) {
						$this->log($error->getMessage());
					}
				}
				copy($file["tmp_name"], ROOT."/".APP_DIR."/".WEBROOT_DIR."/uploads/spot/origin/" .$file_name);
				$file_info = $imageResizer->file_info();
				$image_info = array(
					"file_name"    => $file_name,
					"file_type"    => $file_info['mime'],
					"raw_name"     => $row_name,
					"origin_name"  => $file["name"],
					"file_ext"     => "." .$ext,
					"file_size"    => $file["size"],
					"image_width"  => $file_info[0],
					"image_height" => $file_info[1],
				);
				$this->log($image_info);
				$this->data[$this->name]["image"] = serialize($image_info);
			}
		}
		if (isset($this->data["Tag"]["Tag"])) {
			$this->data["Tag"] = array_keys($this->Tag->set_list($this->data["Tag"]["Tag"]));
		}
	}
	
	/**
	 * シリアライズした情報を展開
	 * @see Model::afterFind()
	 */
	public function afterFind($results) {
		foreach ($results as $key => $val) {
			if (isset ($results[$key][$this->name]["image"]) && is_array ($results[$key][$this->name])) {
				$results[$key][$this->name]["image"] = unserialize($results[$key][$this->name]["image"]);
			}
		}
		return $results;
	}

}
