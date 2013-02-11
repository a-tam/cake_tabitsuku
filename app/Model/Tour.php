<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Spot');
App::import('Model', 'Category');
/**
 * Tour Model
 *
 * @property User $User
 * @property Route $Route
 */
class Tour extends AppModel {

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
		'lat_min' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lat_max' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lng_min' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lng_max' => array(
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
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => array('id','name'),
			'order' => ''
		),
	);

	/**
	* hasMany associations
	*
	* @var array
	*/
	public $hasMany = array(
		'Route'
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
					'joinTable'             => 'tours_tags',
					'foreignKey'            => 'tour_id',
					'associationForeignKey' => 'tag_id',
					'unique'                => true,
					'fields'                => array('Tag.id', 'Tag.name'),
			)
	);
	// 検索対象のフィルタ
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
			'name' => array('type' => 'like'),
			'keyword' => array('type' => 'like'),
	);
	public $base_condition = array('Tour.status' => 1);
	// 検索対象のフィールド設定
	public $presetVars = array(
			array('field' => 'id', 'type' => 'value'),
			array('field' => 'name', 'type' => 'like'),
	);
	
	/**
	 * 存在すれば更新、無ければ追加
	 * @param unknown $data
	 * @param string $validate
	 * @param unknown $fieldList
	 * @return Ambigous <mixed, boolean, multitype:>
	 */
	public function save($data, $validate = true, $fieldList = array()) {
		$stay_time = 0;
		$lat_min = null;
		$lat_max = null;
		$lng_min = null;
		$lng_max = null;
		$prefecture = "";
		$image = null;
		$spot_model = new Spot;
		foreach($data["Route"] as $key => $spot) {
			$stay_time += $data["Route"][$key]["stay_time"];
			if ($spot["spot_id"] > 0) {
				// 県名
				if (!isset($data["Tour"]["prefecture"])) {
					$prefecture = $spot_model
						->find('first',
							array(
								"condition" => array(
									"id" => $spot["spot_id"]
								),
								"recursive"  => 0,
								"fields" => array("Spot.prefecture")
							));
					$data["Tour"]["prefecture"] = $prefecture["Spot"]["prefecture"];
				}
				// ツアーの範囲を取得
				if (is_null($lat_min)) {
					$lat_min = $spot["lat"];
					$lat_max = $spot["lat"];
					$lng_min = $spot["lng"];
					$lng_max = $spot["lng"];
					$start_lat = $spot["lat"];
					$start_lng = $spot["lng"];
				}
				if ($lat_min > $spot["lat"]) $lat_min = $spot["lat"];
				if ($lat_max < $spot["lat"]) $lat_max = $spot["lat"];
				if ($lng_min > $spot["lng"]) $lng_min = $spot["lng"];
				if ($lng_max < $spot["lng"]) $lng_max = $spot["lng"];
				// 選択した画像のシリアライズデータを埋め込む
				if ($data["Tour"]["image"] == $spot["spot_id"]) {
					$image = $spot_model
						->find('first',
							array(
								"condition" => array(
									"id" => $spot["spot_id"]
								),
								"recursive" => 0,
								"fields"    => array(
									"Spot.image"
								)
							));
					$image["Spot"]["image"]["spot_id"] = $spot["spot_id"];
				}
			}
		}
		// 画像
		if (isset($data["Tour"]["image"])) {
			if ($image) {
				$data["Tour"]["image"] = serialize($image["Spot"]["image"]);
			} else {
				$data["Tour"]["image"] = serialize(null);
			}
		}
		$data["Tour"]["start_lat"] = $start_lat;
		$data["Tour"]["start_lng"] = $start_lng;
		$data["Tour"]["lat_min"] = $lat_min;
		$data["Tour"]["lat_max"] = $lat_max;
		$data["Tour"]["lng_min"] = $lng_min;
		$data["Tour"]["lng_max"] = $lng_max;
		$data["Tour"]["staty_time"] = $stay_time;
		$time = explode(":", $data["Tour"]["start_time"]);
		$end_time = ($time[0] * 60) + $time[1] + $stay_time;
		$data["Tour"]["end_time"] = sprintf("%02d", floor($end_time / 60)).":".sprintf("%02d", $end_time % 60);
		if (!$data[$this->name]["id"]) {
			// 追加
			$this->create();
			$data[$this->name]["status"] = "1";
		} else {
			// 更新
			$this->id = $data[$this->name]["id"];
		}
		$this->log($data);
		return parent::save($data, $validate = true, $fieldList = array());
	}
	
	public function afterSave() {
		foreach ($this->data["Route"] as $key => $data) {
			$this->data["Route"][$key]["tour_id"] = $this->data["Tour"]["id"];
		}
		$this->Route->deleteAll(array("tour_id" => $this->data["Tour"]["id"]));
		$ret = $this->Route->saveAll($this->data["Route"]);
	}
	
	/**
	 * 保存前処理
	 * @see Model::beforeSave()
	 */
	public function beforeSave() {
		// タグ情報
		if (isset($this->data["Tag"]["Tag"])) {
			$this->data["Tag"] = array_keys($this->Tag->set_list($this->data["Tag"]["Tag"]));
		}
		// 検索用に前後に区切り文字を付与
		if (isset($this->data[$this->name]["category"]) && is_array($this->data[$this->name]["category"])) {
			$this->data[$this->name]["category"] = ",".implode(",", $this->data[$this->name]["category"]).",";
		}
		return true;
	}
	
	/**
	 * シリアライズした情報を展開
	 * @see Model::afterFind()
	 */
	public function afterFind($results) {
		$categoryModel = new Category();
		foreach ($results as $key => $val) {
			if (isset ($results[$key][$this->name]["image"]) && is_array ($results[$key][$this->name])) {
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
