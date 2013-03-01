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
				try {
					$user_info = $this->Session->read("user_info");
					$this->User->id = $user_info["User"]["id"];
					if ($this->User->save(array("User" => array("social_facebook" => "")))) {
						$this->Session->setFlash("Facebookアカウントと連携を解除しました。");
					}
				} catch (Exception $e) {
					$this->log($e->getMessage());
				}
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
	
	public function fb_connect() {
		$user = $this->facebook->getUser();
		
	}
	
	/**
	 * Facebook 認証
	 *
	 * @param string $redirect
	 */
	public function fb_auth($redirect = "") {
		// FBユーザー情報取得
		$user = $this->facebook->getUser();
		// 認証成功
		if ($user) {
			// FBユーザー情報取得
			$user_profile = $this->facebook->api('/me');
			// ユーザー情報が取得できない
			if ($user_profile) {
				
				// たびつくアカウントへログイン（初回ログイン時は、アカウント発行）
				if ($user_info = $this->User->oauth_login("facebook", $user_profile)) {
					
					// パスワードを除いてログインセッションに記述
					unset($user_info["User"]["password"]);
					$this->Session->write("user_info", $user_info);
					
					// リダイレクト
					switch ($redirect) {
						// ツアー登録
						case "tour":
							$this->redirect("/tours/form");
							break;
						// スポット登録
						case "spot":
							$this->redirect("/spots/form");
							break;
						// マイページ
						case "mypage":
							$this->redirect("/users/");
							break;
						// トップページ
						default:
							$this->redirect("/");
					}

				// ログイン、アカウント作成エラー
				} else {
					// 既に連携済み
					if ($user_info === false) {
						$this->log(__LINE__);
						$this->Session->setFlash("すでにFacebookアカウントと同じメールアドレスでのアカウントをお持ちの場合、こちらから通常ログインをおこないFacebook連携設定に進んでください。");
					// たびつくにログイン失敗
					} elseif ($user_info === null) {
						$this->log(__LINE__);
						$this->Session->setFlash("旅つくのログインに失敗しました。");
					}
				}
			// FB情報取得エラー
			} elseif ($user_info === null) {
				$this->log(__LINE__);
				$this->Session->setFlash("Facebookのユーザー情報の取得に失敗しました。");
			}
		// 認証エラー
		} elseif ($user_info === null) {
			$this->log(__LINE__);
			$this->Session->setFlash("Facebookのログインに失敗しました。");
		}
		// ログイン失敗
		$this->redirect("/");
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