<?php
App::uses('AppModel', 'Model');
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
		)
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
	
	public function afterSave() {
		$tour_id = $this->log($this->getId());
		foreach($this->data["Route"] as $key => $data) {
			$this->data["Route"][$key]["tour_id"] = $tour_id;
		}
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
	}
}
