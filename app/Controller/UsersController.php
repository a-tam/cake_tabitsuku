<?php
App::uses("AppController", "Controller");

class UsersController extends AppController {
	
	/**
	 * ユーザトップページ
	 *
	 */
	public function index() {
		
	}
	
	/**
	 * アカウント情報変更
	 *
	 */
	public function edit() {
		
	}

	/**
	 * 本人認証
	 *
	 */
	public function verify($key) {
		
		if ($data = $this->User->findByVerify($key)) {
			if ($this->request->is("post")) {
				$this->log(array($data["User"]["password"], AuthComponent::password($this->request->data["User"]["password"])));
				if ($data["User"]["password"] == AuthComponent::password($this->request->data["User"]["password"])) {
					// 認証
					$this->User->approval($data["User"]["id"]);
					unset($data["User"]["password"]);
					$this->Session->write("user_info", $data);
					$this->redirect("/");
				} else {
					$this->Session->setFlash("パスワードが正しく有りません");
				}
			} else {
				unset($data["User"]["password"]);
				$this->log($data);
				$this->request->data = $data;
			}
		} else {
			throw new NotFoundException();
		}
	}
	
	/**
	 * reminder
	 *
	 */
	public function reminder() {
		
	}
	
	/**
	 * Facebook 認証
	 * @param string $redirect
	 */
	public function fb_auth($redirect = "") {
		$user = $this->facebook->getUser();
		if ($user) {
			try {
				$user_profile = $this->facebook->api('/me');
				if (isset($user_profile["id"])) {
					$user_info = $this->User->oauth_login("facebook", $user_profile);
					$this->Session->write("user_info", $user_info);
					switch ($redirect) {
						case "tour":
							$this->redirect("/tours/form");
							break;
								
						case "spot":
							$this->redirect("/spots/form");
							break;
								
						case "mypage":
							$this->redirect("/users/");
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
			//$this->redirect("login_form");
		}
	}
	
	/**
	 * ログアウト
	 *
	 */
	public function logout() {
		$this->Session->destroy();
		$this->redirect("/");
	}
}
?>