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
				unset($data["User"]["password"]);
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
				return $this->render("/pages/reminder_complete");
			} else {
				$this->Session->setFlash("登録されていません");
			}
		}
	}
	
	/**
	 * パスワード再設定
	 *
	 */
	public function reset_password($key) {
		if ($data = $this->User->findByVerify($key)) {
			if ($this->request->is("post")) {
				$this->User->id = $data["User"]["id"];
				$this->request->data["User"]["verify"]   = "";
				$this->request->data["User"]["status"]   = "1";
				if ($this->User->save($this->request->data)) {
					$this->redirect("/");
				}
			} else {
				$this->Session->setFlash("パスワード変更用");
			}
		} else {
			$this->Session->setFlash("パスワード再発行用のURLが無効です。");
			$this->redirect("/");
		}
	}

}
