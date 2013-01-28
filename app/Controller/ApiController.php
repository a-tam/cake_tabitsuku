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
	
// 	public $components = array('RequestHandler', 'Search.Prg');
	public $components = array('RequestHandler');
	public $presetVars = true;
	
	public function beforeFilter() {
		
		$this->loadModel("Tour");
		$this->loadModel("Spot");
	}
	
	public function index() {
		
		$relation = array();
		$list = array();
		$output_var = array("count", "relation", "list");
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
	}
	
	public function spot_list() {
		
		/*
		$this->Spot->recursive = 0;
		$this->Prg->commonProcess();
		$this->paginate = array(
				'conditions' => $this->Spot->parseCriteria($this->passedArgs),
			);
		$list = $this->paginate();
			*/
		$relation = array();
		$list = $this->Spot->find('all');
		$count = $this->Spot->find('count');
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
	}
	
	public function spot_get() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		
	}
	
	public function spot_add() {
		
		$status = false;
		$result = array();
		if ($this->request->is("ajax")) {
			$this->Spot->create();
			$data = array(
				"name"       => $this->request->data["name"],
				"lat"        => $this->request->data["lat"],
				"lng"        => $this->request->data["lng"],
				"zoom"       => $this->request->data["zoom"]
			);
			if ($result = $this->Spot->save($data)) {
				$status = true;
			}
		}
		$output_var = array(
			"status",
			"result"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
	}
	
	public function spot_edit() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		
	}
	
	public function spot_delete() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
	}
	
	public function tour_list() {
		
		$relation = array();
		$list = $this->Tour->find('all');
		$count = $this->Tour->find('count');
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
	}
	
	public function tour_get() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		
	}
	
	public function tour_add() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		
	}
	
	public function tour_update() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		
	}
	
	public function tour_delete() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		
	}
	
	public function fb_event_add() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		
	}
	
	public function tag_list() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
	}
	
	public function tag_add() {
		
	}
	
	public function tag_remove($id) {
		
	}
	
	public function category_list() {
		
		$relation = array();
		$list = array();
		$output_var = array(
			"count",
			"relation",
			"list"
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		
	}
	
	
	function article_list () {
		$count = 3;
		$list = array("aaa", "bbb", "ccc");
		// 出力する変数名
		$output_var = array("count", "list");
		// compact関数が変数名を展開してくれる
		$this->set(compact($output_var));
		// _serialize にセットした値が JSON形式でシリアライズされ出力されます。
		$this->set('_serialize', $output_var);
	}
}
