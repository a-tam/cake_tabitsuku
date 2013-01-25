<?php //
App::uses('AppController', 'Controller');

/**
 *
 * 特にログインを伴わないページ関連のコントローラー
 *
 * @author kiyomizu
 *
 */
class PagesController extends AppController {
	
	public $name = 'Pages';
	
	public $uses = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	public function home() {
		
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
		$params = array(
				"scope" => "create_event",
				"redirect_uri" => Router::url("/fb_auth", true)
			);
		$url = $this->facebook->getLoginUrl($params);
		$this->set("fb_login", $url);
	}
		
	/**
	 * ログアウト
	 *
	 */
	public function logout() {
		$this->Session->destroy();
		$this->redirect("/");
	}
	
	public function fb_auth($redirect = "") {
		$user = $this->facebook->getUser();
			if ($user) {
			try {
				$user_profile = $this->facebook->api('/me');
//				log_message('error',print_r($user_profile, true));
				if (isset($user_profile["id"])) {
//					$user_info = $this->User_model->oauth_login("facebook", $user_profile);
					$user_info = $result = array(
							"id"			=> 1,
							"login_id"		=> "kiyomizu",
							"facebook_id"	=> "1234567890",
							"name"			=> "清水",
							"email"			=> "hiroyuki.kiyomizu@gmail.com"
					);
						
					$this->Session->write("user_info", $user_info);
					switch ($redirect) {
						case "tour":
							$this->redirect("/tour/form");
							break;
							
						case "spot":
							$this->redirect("/spot/form");
							break;
							
						case "mypage":
							$this->redirect("/user");
							break;
							
						default:
							$this->redirect("/");
					}
				}
			} catch (FacebookApiException $e) {
				$user = null;
			}
		} else {
			// ログイン画面
			$this->login();
		}
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
}
