<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 */
class User extends AppModel {

	public $name = "User";
	
	public $useTable = "users";
	
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
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '入力必須です',
			),
			'maxLength' => array(
				'rule' => array('maxLength', 255),
				'message' => '255文字まで入力可能です',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'メールアドレスを指定してください',
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => '既に登録済みです',
			),
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '入力必須です',
			),
			'between' => array(
				'rule' => array('between', 6, 100),
				'message' => '6〜100文字で入力してください。',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alnumsymbol' => array(
				'rule' => array('alnumsymbol'),
				'message' => '半角英数記号のみ入力可能です。',
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'メールアドレス形式で入力してください',
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
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => '入力必須です'
			),
			'maxLength' => array(
				'rule' => array('maxLength', 200),
				'message' => '200文字まで入力可能です。',
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
				$data["User"] = array(
					"login"           => $user_profile["email"],
					"name"            => $user_profile["name"],
					"email"           => $user_profile["email"],
					"password"        => md5(uniqid()),
					"social_facebook" => $user_profile["id"],
				);
				$user_info = $this->save($data);
			}
		}
		return $user_info;
	}
	
	/**
	 * アカウント発行
	 * @param unknown $data
	 */
	/*
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
	*/
	
	public function save($data = null, $validate = true, $fieldList = array()) {
		// 新規
		if ($this->id == "") {
			$this->create();
			$data["status"] = 1;
			if (isset($data[$this->alias]["social_facebook"]) && $data[$this->alias]["social_facebook"]) {
				$data[$this->alias]["status"] = "1";
			} else {
				$data[$this->alias]["status"] = "0";
				$data[$this->alias]["verify"] = hash('sha256', uniqid());
			}
		}
		return parent::save($data, $validate, $fieldList);
	}
	
	/**
	 * 本人確認
	 * @param unknown $id
	 * @throws NotFoundException
	 * @return Ambigous <mixed, boolean, multitype:>
	 */
	public function approval($id) {
		// 存在確認
		if ($this->exists($id)) {
			$this->id = $id;
			return $this->save(array(
				"verify"   => "",
				"status"   => "1",
			));
		} else {
			throw new NotFoundException();
		}
	}
	
	public function login($id, $password) {
		if ($data = $this->find('first', array('conditions' => array(
			'login'    => $id,
			'password' => AuthComponent::password($password),
			'status'   => 1
			)))) {
			return $data;
		} else {
			return false;
		}
	}
	
	/**
	 * 解約
	 *
	 */
	public function cancel() {
		
	}
	
	public function beforeSave() {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
	
	public function alnumsymbol($field) {
		list($key, $val) = each($field);
		if (preg_match("/^[!-~]+$/", $val)){
			return true;
		} else {
			return false;
		}
	}
}
