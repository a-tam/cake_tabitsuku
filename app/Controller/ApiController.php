<?php
App::uses('AppController', 'Controller');
App::import("Model", "Tag");

/**
 *
 * Api関連のコントローラー
 *
 * @author kiyomizu
 *
 */
class ApiController extends AppController {
	
	public $name = 'Api';
	
	public $uses = array('Spot', 'Tour', 'Tag', 'Category');
	
	public $components = array('RequestHandler', 'Search.Prg', 'ImageResizer.ImageResizer');
	public $presetVars = array();
	
	public function spot_list() {

		// 初期化
		$list = array();
		$count = 0;
		$this->presetVars = $this->Spot->presetVars;
		$this->Prg->commonProcess();
		$cond = $this->Spot->parseCriteria($this->request->query);
		$cond = Set::merge($cond, $this->Spot->base_condition);
		$defaults = array(
			"limit"     => 10,
			"page"      => 1,
			"sort_key"  => "Spot.name",
			"sort_type" => "asc"
		);
		foreach($defaults as $_key => $_val) {
			$$_key = $this->request->$_key ?: $_val;
		}
		if ($count = $this->Spot->find('count', array('conditions' => $cond))) {
			$list = $this->Spot->find('all',
				array(
					"conditions" => $cond,
					"order"      => array(
						$sort_key => $sort_type
					),
					"limit"      => $limit,
					"page"       => $page,
				)
			);
		}
		$output_var = array(
			"count",
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
	
	/**
	 * スポット追加
	 *
	 */
	public function spot_save() {

		// 初期化
		$status = false;
		$result = array();

		// ログインユーザ情報
		$user_info = $this->Session->read("user_info");
		$this->request->data["Spot"]["user_id"] = $user_info["User"]["id"];
		$this->log($this->request->data);
		if ($this->request->is("ajax")) {
			if ($result = $this->Spot->save($this->request->data)) {
				$status = true;
			}
		}

		// 結果出力
		$output_var = array(
			"status",
			"result"
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
		
		$list = array();
		$this->presetVars = $this->Tour->presetVars;
		$this->Prg->commonProcess();
		$cond = $this->Tour->parseCriteria($this->request->query);
		
		$cond = Set::merge($cond, $this->Tour->base_condition);
		if ($count = $this->Tour->find('count', array('conditions' => $cond))) {
			$this->Tour
				->unbindModel(array(
					"hasMany"   => array(
						"Route"
					),
					"belongsTo" => array(
						"Spot"
					)
				));
//			$this->Tour->recursive = 2;
			$list = $this->paginate('Tour', $cond);
		}
		$output_var = array(
			"count",
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
	
	public function tour_save() {
		
		// 初期化
		$status = false;
		$result = array();
		
		// ログインユーザ情報
		$user_info = $this->Session->read("user_info");
		$this->request->data["Tour"]["user_id"] = $user_info["User"]["id"];
		// 登録
		if ($this->request->is("ajax")) {
			if (!$this->request->data["Tour"]["id"]) {
				// 追加
				$this->Tour->create();
				$this->request->data["Tour"]["status"] = "1";
			} else {
				// 更新
				$this->Tour->id = $data["Tour"]["id"];
			}
			if ($result = $this->Tour->save($this->request->data)) {
				$status = true;
			}
		}
		
		// 結果出力
		$output_var = array(
			"status",
			"result"
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

		$list = $this->Tag->find('list', array("conditions" => array("Tag.name LIKE" => $this->request->query["term"]."%")));
		$output_var = array(
			"list",
		);
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
	}
	
	public function tag_add() {
		
	}
	
	public function tag_remove($id) {
		
	}
	
	public function category_list($id = "") {

		$list = $this->Category
			->find("list", array(
				"conditions" => array(
					"parent_id" => $id,
					"status"    => 1
				)
			));
		$output_var = array(
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
