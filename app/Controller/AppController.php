<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::import('Vendor', 'facebook/src/facebook');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	function beforeFilter() {
//		$category = $this->Category_model->get_list("");
		$this->set("root_category", array());
		$this->set("title_for_layout", __("旅つく"));
		$this->facebook = new Facebook( array(
				'appId' => Configure::read("facebook.app_id"),
				'secret' => Configure::read("facebook.secret"),
				'cookie' => Configure::read("facebook.cookie")
		));
	}
	
	/**
	 * Enter description here ...
	 * @param unknown $scope
	 * @return boolean
	 */
	function isScope($scope){
		if (!$uid = $this->facebook->getUser()) {
			return false;
		}
		$_ispermit = true;
		$access_token = $this->facebook->getAccessToken();
		try {
			$fql = 'SELECT '.$scope .' FROM permissions WHERE uid ="'.$uid .'"';
			$scopes = $this->facebook->api(array(
				'method' => 'fql.query',
				'access_token' => $access_token,
				'query' => $fql
			));
			if ($scopes[0]) {
				foreach($scopes[0] as $k=>$v) {
					if($v === '0') {
						$_ispermit = false;
					}
				}
			} else {
				$_ispermit = false;
			}
		} catch (FacebookApiException $e) {
			// エラー処理
			error_log("error", $e->getMessage());
			print $e->getMessage();
			$this->isError;
			exit;
		}
		return $_ispermit;
	}
	
	
}
