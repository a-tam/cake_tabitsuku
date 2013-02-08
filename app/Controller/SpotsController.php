<?php
App::uses('AppController', 'Controller');

/**
 *
 * スポット関連のコントローラー
 *
 * @author kiyomizu
 *
 */
class SpotsController extends AppController {

	public $name = 'Spots';

	public $uses = array();
	
	public function index() {
		
	}
	
	public function show($id) {
		$this->Spot->id = $id;
		if (!$spot = $this->Spot->read()) {
			throw new NotFoundException();
		}
		$this->set("spot", $spot);
	}
	
	public function form($id = "") {
		if ($id) {
			$this->Spot->id = $id;
			if (!$this->request->data = $this->Spot->read()) {
				throw new NotFoundException();
			}
		}
		$this->log($this->request->data);
	}
	
	public function add() {
	
	}
	
	public function edit() {
	
	}
	
	public function delete() {
	
	}
	
}