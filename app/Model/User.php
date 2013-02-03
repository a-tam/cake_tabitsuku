<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

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
		'login' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'between' => array(
				'rule' => array('between', 6, 255),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'between' => array(
				'rule' => array('between', 6, 255),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'social_facebook' => array(
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
				'rule' => array('maxlength', 200),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'privacy' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	/**
	 * Enter description here ...
	 * @param string $type
	 * @param array $user_profile
	 * @return multitype:
	 */
	public function oauth_login($type, $user_profile) {
		$user_info = array();
		if ($type == "facebook") {
			$cond["social_facebook"] = $user_profile["id"];
			if (!$user_info = $this->find('first', array("conditions" => $cond))) {
				// 初回の認証
				$data = array(
					"login"           => md5(uniqid()),
					"name"            => $user_profile["name"],
					"email"           => $user_profile["email"],
					"password"        => md5(uniqid()),
					"social_facebook" => $user_profile["id"],
					"approval"        => 1,			// 本人確認済み
				);
				$this->create();
				$user_info = $this->save($data);
			}
		}
		return $user_info;
	}
	
	/**
	 * アカウント発行
	 * @param unknown $data
	 */
	public function singup($data) {
		$result = false;
		$data = array(
				"login_id"		=> $input["login_id"],
				"name"			=> $input["name"],
				"email"			=> $input["email"],
				"password"	=> $this->hash_password($input["password"]),
				"status"	=> USER_STATUS_APPROVAL,
		);
		if ($id = parent::insert($data)) {
			$result = array(
					"id"			=> $id,
					"login_id"		=> $input["login_id"],
					"facebook_id"	=> $input["facebook_id"],
					"name"			=> $input["name"],
					"email"			=> $input["email"]
			);
		}
	}
	
	/**
	 * アカウント認証
	 *
	 */
	public function approval() {
		
	}
	
	/**
	 * 解約
	 *
	 */
	public function cancel() {
		
	}
}
