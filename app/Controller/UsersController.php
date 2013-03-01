<?php
App::uses("AppController", "Controller");

class UsersController extends AppController {
	
	/**
	 * ユーザトップページ
	 *
	 */
	public function index() {
		
		// 認証チェック
		$this->user_auth();
		$user_info = $this->Session->read("user_info");
		$this->User->id = $user_info["User"]["id"];
		if ($this->request->is("put")) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash("登録情報を変更しました。");
			}
		} else {
			$user_info = $this->User->read();
			$this->request->data = $user_info;
		}
		unset($this->request->data["User"]["password"]);
		unset($this->request->data["User"]["confirm_password"]);
	}
	
	public function facebook() {
		if ($this->request->is('post')) {
			if ($this->request->data["action"] == "connect") {
				$this->Session->setFlash("Facebookアカウントと連携しました。Facebookのアカウントでログインできます。");
			} elseif ($this->request->data["action"] == "disconnect") {
				array("social_facebook" => "");
				$this->User->save();
				$this->Session->setFlash("Facebookアカウントと連携を解除しました。");
			}
		}
		$this->redirect("/users/index");
	}
		
	/**
	 * アカウント情報変更
	 *
	 */
	public function edit() {
		// 認証チェック
		$this->user_auth();
		
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
				$this->request->data = $data;
			}
		} else {
			throw new NotFoundException();
		}
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
					unset($user_info["User"]["password"]);
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