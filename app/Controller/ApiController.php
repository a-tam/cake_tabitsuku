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
	
	public $components = array('RequestHandler');
	
	public function index() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function spot_list() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function spot_get() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function spot_add() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function spot_edit() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function spot_delete() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function tour_list() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function tour_get() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function tour_add() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function tour_update() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function tour_delete() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
	public function fb_event_add() {
		
		$relation = array();
		$list = array();
		$this->set("list", $list);
		$this->set("relation", $relation);
		$this->set('_serialize', array("relation", "list"));
		
	}
	
}
