<?php
App::uses('AppModel', 'Model');
/**
 * MailVerify Model
 *
 * @property User $User
 */
class MailVerify extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'mail_verify';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'verify' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'expired_time' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modifed' => array(
			'datetime' => array(
				'rule' => array('datetime'),
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
			'fields' => '',
			'order' => ''
		)
	);
	
	
	/**
	 * パラメタのシリアライズ
	 * @see Model::beforeSave()
	 */
	public function beforeSave($options = array()) {
		$this->log($this->data);
		$this->data[$this->name]["params"] = serialize($this->data[$this->name]["params"]);
		return true;
	}
	
	/**
	 * パラメタのデシリアライズ
	 * @see Model::afterFind()
	 */
	public function afterFind($results, $primary = false) {
		
		foreach ($results as $key => $val) {
			if (isset($val[$this->name]['params'])) {
				$results[$key][$this->name]['params'] = unserialize($val[$this->name]['params']);
			}
		}
		return $results;
	}
	
	/**
	 * メール本人確認用のアドレスを発行する
	 *
	 * @param unknown $user_id ユーザーID
	 * @param unknown $type 処理タイプ
	 * @param number $expire_time 有効期限（秒）
	 * @throws Exception
	 */
	public function getUrl($user_id, $type, $params = array(), $expire_time = 3600) {
		$verify = hash('sha256', uniqid());
		$url = Router::url("/users/mail_verify/".$verify, true);
		$data = array(
			"user_id"      => $user_id,
			"type"         => $type,
			"verify"       => $verify,
			"params"       => $params,
			"expired_time" => date("Y-m-d H:i:s", time() + $expire_time),
		);
		if (!$this->save($data)) {
			$this->log($this->validationErrors);
			return false;
		} else {
			return $url;
		}
	}
	
	/**
	 * 発行したキーの確認
	 * @param unknown $key
	 */
	public function confirm($key) {
		if ($data = $this->find("first", array('conditions' => array(
			$this->name.".verify" => $key
			)))) {
			if (strtotime($data[$this->name]["expired_time"]) > time()) {
				return $data[$this->name];
			}
		}
	}
	
	/**
	 * 処理が正常に完了したら明示的に破棄させる
	 *
	 */
	public function destory($key) {
		$this->deleteAll(array($this->name.".verify" => $key));
	}
	
	/**
	 * 有効期限を過ぎたものを全て破棄
	 *
	 */
	public function gc() {
		$this->deleteAll(array($this->name.".expired_time < " => date("Y-m-d H:i:s")));
	}
}
