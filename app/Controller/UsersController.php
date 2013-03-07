<?php
App::uses("AppController", "Controller");
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {
	
	public $uses = array("MailVerify", "User");
	/**
	 * ユーザトップページ
	 *
	 */
	public function index() {
		
		// 認証チェック
		$this->user_auth();
		$user_info = $this->Session->read("user_info");
		// フォームリクエスト
		if ($this->request->is("put") || $this->request->is("post")) {
			// パスワードの指定がない場合は変更しない
			if ($this->request->data["User"]["password"] == "" &&
				$this->request->data["User"]["confirm_password"] == "") {
				
				unset($this->request->data["User"]["password"]);
				unset($this->request->data["User"]["confirm_password"]);
			}
			$this->User->id = $user_info["User"]["id"];
			// 保存前にバリデーション確認
			if ($this->User->validates($this->request->data)) {

				// ログインIDは、本人確認後確定する
				$change_email = $this->request->data["User"]["login"];
				unset($this->request->data["User"]["login"]);

				// バリデーションなしで保存
				if ($this->User->save($this->request->data)) {
					// ログインID（メールアドレス）が変更
					if ($user_info["User"]["login"] != $change_email) {
						$url = $this->MailVerify->create(
							$user_info["User"]["id"],
							"change_login",
							array(
								"login" => $change_email
							),
							3600 * 24	// 24時間有効
						);
						// メール送信
						$email = new CakeEmail('default');
						$email->from(array('hiroyuki.kiyomizu@gmail.com' => 'たびつく'));
						$email->to($change_email);
						$email->subject('たびつく - ログインIDの変更確認');
						$email->send($url);
						$message = "ログイン用のメールアドレスが変更されました。変更先のメールアドレスに本人確認用のURLを送信しています。URLをクリックした後、確定されます。";

					// メール以外の情報変更
					} else {
						$message = "登録情報を変更しました。";
					}
					$this->Session->setFlash($message);
					$this->__resetUserInfo();
					$this->redirect("/users/index");
				}
			}

		} else {
			// セッション情報更新
			$user_info = $this->__resetUserInfo();
			$this->request->data = $user_info;
		}
		// Facebook連携なし
		if ($user_info["User"]["social_facebook"] == "") {
			$facebook_login_url = $this->__setSosialLoginUrl("/users/fb_connect");
			$this->set("facebook_login_url", $facebook_login_url);
		}
	}
	
	/**
	 * パスワード再設定
	 *
	 * @param unknown $key
	 * @todo 有効期限を設ける
	 */
	public function mail_verify($key) {
		if ($data = $this->MailVerify->confirm($key)) {
			$resut = false;
			switch ($data["type"]) {
				case "change_login" :
					$this->User->id = $data["user_id"];
					$data = array(
						'login' => $data["params"]["login"],
						);
					if (!$this->User->save($data)) {
						$this->Session->setFlash("ログインID（メールアドレス）の変更に失敗しました。");
					} else {
						$this->Session->setFlash("ログインID（メールアドレス）の変更が出来ました。");
						$resut = true;
					}
					break;
				default:
					$this->Session->setFlash("URLが無効です。メール本文の本人確認用のURLをご確認ください。");
					break;
			}
			// 処理が正常に完了した場合は、本人確認用のキーを破棄
			if ($resut == true) {
				$this->MailVerify->destory($key);
			}
		} else {
			$this->Session->setFlash("ログインIDの変更が出来ました。");
		}
		$this->redirect("/");
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
	 * facebook 連携
	 *
	 */
	public function fb_connect() {
		$user_info = $this->Session->read("user_info");
		$fb_user = $this->facebook->getUser();
		$user_profile = $this->facebook->api('/me');
		$this->log(array($fb_user, $user_profile));
		// 認証成功
		if ($user_info && $user_profile) {
			// 既に他のアカウントに紐付いていないか確認
			if ($this->User->find('count', array('conditions' => array('social_facebook' => $user_profile["id"]))) > 0) {
				$this->Session->setFlash("他のアカウントで、Facebookアカウントが利用されています。Facebookログインを行い、そのアカウントを解除した後で、連携設定を行なってください。");
			// 現在ログインしているアカウントに紐付け
			} else {
				$this->Session->setFlash("Facebookと連携しました。Facebookログインがご利用になれます。");
				$this->User->id = $user_info['User']['id'];
				$this->User->save(array("social_facebook" => $user_profile["id"]));
				$this->__resetUserInfo();
			}
		}
		$this->redirect("/users/index");
	}

	/**
	 * Enter description here ...
	 *
	 */
	public function fb_disconnect() {
		$user_info = $this->Session->read("user_info");
		$this->User->id = $user_info["User"]["id"];
		if ($this->User->save(array("User" => array("social_facebook" => "")))) {
			$this->Session->setFlash("Facebookアカウントと連携を解除しました。");
		}
		$this->__resetUserInfo();
		$this->redirect("/users/index");
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