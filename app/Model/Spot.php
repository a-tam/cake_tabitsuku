<?php
App::uses('AppModel', 'Model');
App::import('Model','Category');
App::import('Model','Tag');

/**
 * Spot Model
 *
 * @property User $User
 * @property Route $Route
 */
class Spot extends AppModel {

	public $name = "Spot";
	
	public $useTable = "spots";
		
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
	public $actsAs = array('Search.Searchable', 'Tabitsuku');
	
	public $filterArgs = array(
		'name'     => array('type' => 'like'),
		'keyword'  => array('type' => 'query', 'method' => 'findByKeyword'),
		'ne_lat'   => array('type' => 'query', 'method' => 'findByLatLng'),
		'category' => array('type' => 'like'),
		'tag'      => array('type' => 'query', 'method' => 'findByTags'),
		'user_id'  => array('type' => 'value'),  
	);
	// 検索条件として必ず指定される項目
	public $base_condition = array('Spot.status' => '1');
	// 検索対象のフィールド設定
	public $presetVars = array(
			array('field' => 'id'         , 'type' => 'value'),
			array('field' => 'name'       , 'type' => 'like'),
			array('field' => 'description', 'type' => 'like'),
			array('field' => 'keyword'    , 'type' => 'like'),
	);
	// ファイルサイズの変更
	public function setResizeComponent(Controller $controller) {
		$this->ImageResizer = $controller->ImageResizer;
	}

	// キーワード検索
	public function findByKeyword($data = array()) {
		$cond = array();
		$keyword = $data["keyword"];
		if ($keyword) {
			$cond = array(
				'OR' => array(
					$this->alias . '.name LIKE' => '%' . $keyword . '%',
					$this->alias . '.keyword LIKE' => '%' . $keyword . '%',
				)
			);
		}
		return $cond;
	}
	
	/**
	 * 位置情報で検索
	 *
	 * @param unknown $data
	 * @return Ambigous <multitype:, multitype:multitype:string  >
	 */
	public function findByLatLng($data = array()) {
		$cond = array();
		if ($data["ne_lat"] && $data["sw_lat"] && $data["ne_lng"] && $data["sw_lng"]) {
			$cond = array(
				'AND' => array(
					$this->alias . '.lat < '.$data["ne_lat"],
					$this->alias . '.lng < '.$data["ne_lng"],
					$this->alias . '.lat > '.$data["sw_lat"],
					$this->alias . '.lng > '.$data["sw_lng"],
				));
		}
		return $cond;
	}
	
	/**
	 * タグ名で検索（空白区切りの検索は余りにも重いので行わない）
	 *
	 * @param unknown $data
	 * @return multitype:multitype:
	 */
	public function findByTags($data = array()) {
		$tag = $data["tag"];
		$spot_list = $this->filterByTagSpot($tag);
		$cond = array(
				$this->alias . '.id' => array_values($spot_list)
		);
		return $cond;
	}
	
	/**
	 * 存在すれば更新、無ければ追加
	 *
	 * @param unknown $data
	 * @param string $validate
	 * @param unknown $fieldList
	 * @return Ambigous <mixed, boolean, multitype:>
	 */
	public function save($data = null, $validate = true, $fieldList = array()) {
		if (!$data[$this->name]["id"]) {
			// 追加
			$this->create();
			$data[$this->name]["status"] = "1";
		} else {
			// 更新
			$this->id = $data[$this->name]["id"];
		}
		return parent::save($data, $validate, $fieldList);
	}
	
	/**
	 * 保存前処理
	 *
	 * @see Model::beforeSave()
	 */
	public function beforeSave($options = array()) {
		// 画像のサムネイル作成
		if (isset($this->data[$this->name]["image"])) {
			$file = $this->data[$this->name]["image"];
			if ($file["error"] == 0 && $file["size"] > 0) {
				// リサイズ
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
						$succeed = $this->ImageResizer->resizeImage($file["tmp_name"], $resize);
					} catch (CakeException $error) {
						$this->log($error->getMessage());
					}
				}
				copy($file["tmp_name"], ROOT."/".APP_DIR."/".WEBROOT_DIR."/uploads/spot/origin/" .$file_name);
				$file_info = $this->ImageResizer->file_info();
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
		// 検索用に前後に区切り文字を付与
		if (isset($this->data[$this->name]["category"]) && is_array($this->data[$this->name]["category"])) {
			$this->data[$this->name]["category"] = ",".implode(",", $this->data[$this->name]["category"]).",";
		}
	}
	
	/**
	 * シリアライズした情報を展開
	 * @see Model::afterFind()
	 */
	public function afterFind($results, $primary = false) {
		$categoryModel = new Category();
		foreach ($results as $key => $val) {
			if (isset ($results[$key][$this->name]["image"]) && is_array($results[$key][$this->name])) {
				$results[$key][$this->name]["image"] = unserialize($results[$key][$this->name]["image"]);
			}
			// カテゴリ
			if (isset($results[$key][$this->name]["category"])) {
				$results[$key][$this->name]["category"] = $categoryModel->get_category_info(
						$results[$key][$this->name]["category"]);
			}
		}
		return $results;
	}

}
