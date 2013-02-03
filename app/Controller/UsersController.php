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
	 * サインアップ
	 *
	 */
	function signup() {
		$this->_set_validation($this->form_data);
		if ($this->form_validation->run() == FALSE) {
			return $this->login_form();
		}
		$user_info = $this->User_model->signup($this->input->post());
		$this->phpsession->set("user_info", $user_info);
		redirect("user/top", $data);
	}
	
	/**
	 * 本人認証
	 *
	 */
	public function approval() {
		
	}
	
	
	/**
	 * ログイン
	 *
	 */
	function login() {
		$login_id = $this->input->post("login_id");
		$password = $this->input->post("password");
		if (!$user_info = $this->User_model->login($login_id, $password)) {
			return $this->login_form();
		}
		$this->phpsession->set("user_info", $user_info);
		redirect("user/top");
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
					$this->log(array($user_profile, $user_info));
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