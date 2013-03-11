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
	
	public $uses = array('User', 'Tag', 'Category', 'Tour', 'Spot', 'SpotTag', 'TourTag');
	
	public $helper = array("Tabitsuku");
	
	public $components = array('Tabitsuku');
	
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
				unset($data["User"]["password"]);
				$this->Session->write("user_info", $data);
				
				// リダイレクト
				switch ($this->request->data["Login"]["redirect"]) {
					// ツアー登録
					case "tour":
						$redirect_url = "/tours/form";
						break;
						// スポット登録
					case "spot":
						$redirect_url = "/spots/form";
						break;
						// マイページ
					case "mypage":
						$redirect_url = "/users/";
						break;
						// トップページ
					default:
						$redirect_url = "/";
				}
				
				$this->set("redirect_url", $redirect_url);
				// フレームから親フレームのページをリダイレクト
				$this->render("login_complete");
			} else {
				$this->Session->setFlash("パスワードが正しく有りません");
			}
		}
		// 認証後のページ遷移
		if ($this->request->is("get")) {
			$redirect = (isset($this->request->query["redirect"])) ? $this->request->query["redirect"] : "";
		} else {
			$redirect = $this->request->data["Login"]["redirect"];
		}
		$this->request->data["Login"]["redirect"] = $redirect;
		$url = $this->__setSosialLoginUrl("/users/fb_auth/", $redirect);
		$this->set("fb_login", $url);
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
				if ($data = $this->User->save($this->request->data)) {
					$message = Router::url("/users/verify/".$data["User"]["verify"], true);
					$this->log($message);
					// 確認メールメール送信
					$email = new CakeEmail('default');
					$email->from(array('hiroyuki.kiyomizu@gmail.com' => 'たびつく'));
					$email->to($this->request->data["User"]["login"]);
					$email->subject('たびつく - ユーザー登録');
					$email->send($message);
					// 登録完了ページに遷移
					$this->Session->setFlash("本人確認用のメールを送信しました。メール本文のURLをクリックしてください。");
					return $this->render("signin_complete");
				}
			} catch (Exception $e) {
				$this->log($e->getMessage());
			}
		}
		$url = $this->__setSosialLoginUrl("/users/fb_auth/", $redirect);
		$this->set("fb_login", $url);
		$this->render("login");
	}
	
	/**
	 * 「たびつくとは〜」ページ
	 *
	 */
	public function about() {
		
	}
	
	/**
	 * HOWTOページ
	 *
	 */
	public function howto() {
		
	}
	
	/**
	 * お問い合わせページ
	 *
	 */
	public function contact() {
		
	}
	
	/**
	 * 利用規約ページ表示
	 *
	 */
	public function rule() {
		
	}
	
	/**
	 * リマインダー
	 *
	 */
	public function reminder() {
		if ($this->request->is("post")) {
			// 有効な登録済みユーザーが存在するか確認
			if ($user = $this->User->find('first', array(
				'conditions' => array('login' => $this->request->data["User"]["login"])
				))) {
				// パスワード再設定用のキーを保存
				$this->User->id = $user["User"]["id"];
				$verify = hash('sha256', uniqid());
				$this->User->save(array("verify" => $verify));
				// 再設定用のメールを送信する
				$message = Router::url("/pages/reset_password/".$verify, true);
				$email = new CakeEmail('default');
				$email->from(array('hiroyuki.kiyomizu@gmail.com' => 'たびつく'));
				$email->to($user["User"]["login"]);
				$email->subject('たびつく - ユーザー登録');
				$email->send($message);
				// 登録完了ページに遷移
				$this->Session->setFlash("パスワード再設定用のメールを送信しました。URLをクリックして、パスワードを再設定してください。");
				$this->redirect("/");
				
			} else {
				$this->Session->setFlash("登録されていません");
			}
		}
	}
	
	/**
	 * パスワード再設定
	 *
	 * @param unknown $key
	 * @todo 有効期限を設ける
	 */
	public function reset_password($key) {
		// パスワード再発行用のキーを確認
		if ($data = $this->User->findByVerify($key)) {
			// 保存処理
			if ($this->request->is("post")) {
				try {
					// パスワードの変更を確定する
					$this->User->id = $data["User"]["id"];
					$this->request->data["User"]["verify"]   = "";
					$this->request->data["User"]["status"]   = "1";
					if ($this->User->save($this->request->data)) {
						$this->Session->setFlash("パスワードを変更しました。");
						$this->redirect("/");
					}
				} catch (Exception $e) {
					$this->log($e->getMessage());
					$this->Session->setFlash("パスワードの変更に失敗しました。");
				}
			}
		} else {
			$this->Session->setFlash("パスワード再発行用のURLが無効です。");
			$this->redirect("/");
		}
	}
	
	public function like() {
		$data = 0;
		if ($this->request->is("post")) {
			$mode = $this->request->data["mode"];
			$type = $this->request->data["type"];
			$user = $this->request->data["fb_user"];
			$id   = $this->request->data["id"];
			if ($mode == "plus") {
				$add = '+ 1';
			} elseif ($mode == "minus") {
				$add = '- 1';
			}
			if ($mode == "" || $type == "" || $user == "" || $id == "") {
				$this->log(array($mode, $type, $user, $id));
				throw new BadRequestException("パラメタが足りません");
			}
			switch ($type) {
				// ツアー
				case "tours":
					$this->Tour->updateAll(
						array('Tour.like_count' => 'Tour.like_count '.$add),
						array('Tour.id' => $id));
					$this->log(array('Tour.id' => $id, $add));
					break;
					
				// スポット
				case "spots":
					$this->Spot->updateAll(
						array('Spot.like_count' => 'Spot.like_count '.$add),
						array('Spot.id' => $id));
					$this->log(array('Spot.id' => $id, $add));
					break;
				
				default:
					throw new BadRequestException("リクエストが正しく有りません");
					break;
			}
			$data = 1;
		}
		$this->set('data', $data);
		$this->layout = null;
		$this->render('/General/Serialize/json');
	}

	/**
	 * Enter description here ...
	 *
	 */
	public function ranking() {

		$response = $this->Tabitsuku->get_ranking();
		$this->log($response);
		$this->set('data', $response);
		$this->layout = null;
		$this->render('/General/Serialize/json');
	}
}
