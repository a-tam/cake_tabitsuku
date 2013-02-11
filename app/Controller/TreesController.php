<?php
class TreesController extends AppController {

	public function index() {
		$data = $this->Category->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;');
		debug($data); die;
	}
	
	public function save() {
		$data['Tree']['parent_id'] = "";
		$data['Tree']['name'] = 'Root';
		$this->Tree->save($data);
	}
}