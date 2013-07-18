<?php
App::uses('AppController', 'Controller');
App::uses('TabitsukuComponent', 'Controller/Component');
/**
 *
 * ツアー関連のコントローラー
 *
 * @author kiyomizu
 *
 */
class ToursController extends AppController {
	
	public $name = 'Tours';
	
	public $uses = array('User', 'Tag', 'Category', 'Tour', 'Spot', 'SpotTag', 'TourTag');
	
	public $components = array('Tabitsuku');
	
	public function index() {
		$ranking = $this->Tabitsuku->get_ranking();
		$this->set("ranking", $ranking);
	}
	
	public function show($id) {
		$this->Tour->id = $id;
		$this->Tour->recursive = 2;
		$this->Tour->Route->unbindModel(array("belongsTo" => array("Tour")));
		if (!$tour = $this->Tour->read()) {
			throw new NotFoundException();
		}
		if (!$data["fb_event_permission"] = $this->isScope("create_event")) {
			$fb_permission_url = $this->facebook->getLoginUrl(array('scope' => 'create_event'));
			$this->set("fb_permission_url", $fb_permission_url);
		}
		$this->set("tour", $tour);
	}
	
	/**
	 * 
	 * @param string $id
	 * @throws NotFoundException
	 */
	public function form($id = "") {
		// 認証チェック
		$this->user_auth();
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
	
	/**
	 * コピー
	 * @param unknown $id
	 */
	public function copy($id) {
		// 認証チェック
		$this->user_auth();
		if ($id) {
			$this->Tour->id = $id;
			$this->Tour->recursive = 2;
			$this->Tour->Route->unbindModel(array("belongsTo" => array("Tour")));
			if (!$this->request->data = $this->Tour->read()) {
				throw new NotFoundException();
			}
			unset($this->request->data["Tour"]["id"]);
		}
		$this->render("form");
	}
}
