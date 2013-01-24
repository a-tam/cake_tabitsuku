<?php
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
	
	public function home() {
		
		$path = func_get_args();
		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;
		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
	
	public function top() {
		
	}
	
	public function about() {
		
	}
	
	public function howto() {
		
	}
	
	public function contact() {
		
	}
	
	public function rule() {
		
	}
}
