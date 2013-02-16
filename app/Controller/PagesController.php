<?php //
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 *
 * 特にログインを伴わないページ関連のコントローラー
 *
 * @author kiyomizu
 *
 */
class PagesController extends AppController {
	
	public $name = 'Pages';
	
	public $uses = array("User");
	
	public $helper = array("Tabitsuku");
	
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	/**
	 * トップページ
	 *
	 */
	public function top() {
		
	}
	
	/**
	 * ログイン
	 *
	 */
	public function login() {
		//
		if ($this->request->is("post")) {
			$login_id = $this->request->data["Login"]["login"];
			$password = $this->request->data["Login"]["password"];
			if ($data = $this->User->login($login_id, $password)) {
				$this->Session->write("user_info", $data);
				$this->render("/pages/login_complete");
			} else {
				$this->Session->setFlash("パスワードが正しく有りません");
			}
		}
		$this->__setSosialLoginUrl();
	}
	
	/**
	 * サインアップ
	 *
	 */
	public function signup() {
		//
		if ($this->request->is("post")) {
			try {
				// メールアドレスをログインIDに指定
				$this->request->data["User"]["email"] = $this->request->data["User"]["login"];
				if ($data = $this->User->save($this->request->data)) {
					$message = Router::url("/users/verify/".$data["User"]["verify"], true);
					$this->log($message);
					// 確認メールメール送信
					$email = new CakeEmail('default');
					$email->from(array('hiroyuki.kiyomizu@gmail.com' => 'たびつく'));
					$email->to($this->request->data["User"]["email"]);
					$email->subject('たびつく - ユーザー登録');
					$email->send($message);
					// 登録完了ページに遷移
					return $this->render("/pages/signin_complete");
				}
			} catch (Exception $e) {
				$this->log($e->getMessage());
			}
		}
		$this->__setSosialLoginUrl();
		$this->render("login");
	}
	
	/**
	 * Enter description here ...
	 *
	 */
	public function about() {
		
	}
	
	public function howto() {
		
	}
	
	public function contact() {
		
	}
	
	public function rule() {
		
	}

	private function __setSosialLoginUrl () {
		
		if ($this->request->is("get")) {
			$redirect = (isset($this->request->query["redirect"])) ? $this->request->query["redirect"] : "";
		} else {
			$redirect = (isset($this->request->data["redirect"])) ? $this->request->data["redirect"] : "";
		}
		
		$params = array(
			"scope" => "create_event,email",
			"redirect_uri" => Router::url("/users/fb_auth/".$redirect, true)
		);
		$url = $this->facebook->getLoginUrl($params);
		$this->set("fb_login", $url);
	}
}
