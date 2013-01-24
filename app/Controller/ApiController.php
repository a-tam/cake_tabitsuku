<?php
App::uses('AppController', 'Controller');

/**
 *
 * Api関連のコントローラー
 *
 * @author kiyomizu
 *
 */
class ApiController extends AppController {

	public $name = 'Api';

	public $uses = array();

	public function index() {
		$output->error = array(
				array('code' => '101', 'msg' => 'GET method is not supported')
		);
		$this->set('output', $output);
	}
}