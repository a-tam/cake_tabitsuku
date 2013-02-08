<?php
App::uses('AppController', 'Controller');

/**
 *
 * ツアー関連のコントローラー
 *
 * @author kiyomizu
 *
 */
class ToursController extends AppController {
	
	public $name = 'Tours';
	
	public $uses = array();
	
	public function index() {
		
	}
	
	public function show($id) {
		$this->Tour->id = $id;
		$this->Tour->recursive = 2;
		$this->Tour->Route->unbindModel(array("belongsTo" => array("Tour")));
		if (!$tour = $this->Tour->read()) {
			throw new NotFoundException();
		}
		$this->log($tour);
		$this->set("tour", $tour);
	}
	
	public function form($id = "") {
		if ($id) {
			$this->Tour->id = $id;
			$this->Tour->recursive = 2;
			$this->Tour->Route->unbindModel(array("belongsTo" => array("Tour")));
			if (!$this->request->data = $this->Tour->read()) {
				throw new NotFoundException();
			}
			$this->log($this->request->data);
		}
	}
	
	public function add() {
		
	}
	
	public function edit() {
		
	}
	
	public function delete() {
		
	}
}
