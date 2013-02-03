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
		$redirect = ($this->request->query["redirect"]) ?: "";
		$params = array(
				"scope" => "create_event,email",
				"redirect_uri" => Router::url("/users/fb_auth/".$redirect, true)
			);
		$url = $this->facebook->getLoginUrl($params);
		$this->set("fb_login", $url);
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
