<?php
/**
 * エラーコード
 * -1 認証エラー
 * -2 DBエラー
 * -99 例外エラー
 * -100	コンテンツが見つからない
 * -101	アクセス権がない
 * -102	操作権がない
 * -103	リクエストが正しくない
 * -2**** アプリケーション個別のエラー（2+API番号2桁+エラーコード2桁）
 */
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
	
	public $uses = array('Spot', 'Tour', 'Tag', 'Category', 'User', 'Route');
	
	public $components = array('RequestHandler', 'Search.Prg', 'ImageResizer.ImageResizer');
	public $presetVars = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
	}
	
	/**
	 * ログイン処理
	 */
	public function login() {
		try {
			$login_id = $this->request->query["user_id"];
			$password = $this->request->query["password"];
			// リクエストエラー
			if (!$login_id || !$password) {
				return $this->__output(-103, array(), "ID, PWの指定がありませんでした。");
			}
			// 認証
			if (!$_user_info = $this->User->login($login_id, $password)) {
				return $this->__output(-20100, array(), "ID、PWが正しくありません。");
			}
			$this->Session->write("user_info", $_user_info);
			$user_info = array(
				"id"      => $_user_info["User"]["id"],
				"name"    => $_user_info["User"]["name"],
				"privacy" => $_user_info["User"]["privacy"]
			);
			unset($user_info["User"]["name"]);
			$session = $this->Session->id();
			$output_var = array(
				"session",
				"user_info",
			);
			$this->set(compact($output_var));
			$this->set('_serialize', $output_var);
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * ユーザー情報取得
	 * @return boolean
	 */
	function user_info() {
		try {
			// 認証処理
			if (!$user_info = $this->__auth()) {
				return false;
			}
			$this->__output(0, $user_info);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * ログアウト
	 *
	 */
	public function logout() {
		try {
			// 認証処理
			if (!$user_info = $this->__auth()) {
				return false;
			}
			$this->Session->destroy();
			$this->__output(0);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * スポット一覧
	 */
	public function spot_list() {
		try {
			// 初期化
			$list = array();
			$count = 0;
			$this->presetVars = $this->Spot->presetVars;
			$this->Prg->commonProcess();
			if (isset($this->request->query["owner"]) && $this->request->query["owner"] == "mydata") {
				// 認証処理
				if (!$user_info = $this->__auth()) {
					return false;
				}
			} else {
				// ユーザー検索
				if (isset($this->request->query["user_id"])) {
					if ($user_id = $this->User->find("first", array(
						"conditions" => array(
							"OR" => array(
								"login" => $this->request->query["user_id"],
								"id" => $this->request->query["user_id"],
							)
						)
					))) {
						$this->request->query["user_id"] = $user_id["User"]["id"];
					} else {
						$this->request->query["user_id"] = "0";
					}
				}
			}
			$cond = $this->Spot->parseCriteria($this->request->query);
			$cond = Set::merge($cond, $this->Spot->base_condition);
			$this->log($cond);

			$defaults = array(
				"limit"     => 10,
				"page"      => 1,
				"sort_key"  => "Spot.name",
				"sort_type" => "asc"
			);
			foreach($defaults as $_key => $_val) {
				$$_key = $this->request->query[$_key] ?: $_val;
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
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * スポット詳細
	 * @param unknown $id
	 */
	public function spot_get($id) {
		try {
			$this->Spot->id = $id;
			// 使用しているツアー一覧を取得
			if (isset($this->request->query["has_tour"]) && $this->request->query["has_tour"] == 1) {
				$data = $this->Spot->read();
				$use_tour_list = array();
				foreach ($data["Route"] as $route) {
					$use_tour_list[] = $route["tour_id"];
				}
				$tour_list = $this->Tour->find("all", array(
					"conditions" => array("Tour.id" => $use_tour_list),
					"recursive"  => 0,
					"limit"      => 20,
				));
				$data["UseTour"] = $tour_list;
				unset($data["Route"]);
			} else {
				$this->Spot->unbindModel(array("hasMany" => array("Route")));
				$data = $this->Spot->read();
			}
			$output_var = array(
				"data"
			);
			$this->set(compact($output_var));
			$this->set('_serialize', $output_var);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * スポット追加
	 *
	 */
	public function spot_save() {
		try {
			// 認証処理
			if (!$user_info = $this->__auth()) {
				return false;
			}
			// 初期化
			$status = false;
			$result = array();
			
			$this->request->data["Spot"]["user_id"] = $user_info["User"]["id"];
			if ($this->request->is("ajax")) {
				$this->Spot->setResizeComponent($this);
				
				if (!$this->request->data["Spot"]["id"]) {
					// 追加
					$this->Spot->create();
					$this->request->data["Spot"]["status"] = "1";
				} else {
					// 更新
					$this->Spot->id = $this->request->data["Spot"]["id"];
					$spot_info = $this->Spot->find('first',
							array(
									"conditions" => array(
											"Spot.id" => $this->Spot->id,
											"Spot.status" => "1",
									),
									"recursive" => 0,
									"fields" => array("Spot.user_id")
							)
					);
					// コンテンツ無し
					if (!$spot_info) {
						return $this->__output(-100);
					}
					// 所有者ではない
					if ($spot_info["Spot"]["user_id"] != $user_info["User"]["id"]) {
						return $this->__output(-102);
					}
				}
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
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * スポット削除
	 */
	public function spot_delete($id) {
		try {
			// 認証処理
			if (!$user_info = $this->__auth()) {
				return false;
			}
			// 指定なし
			if (!$id) {
				return $this->__output(-103);
			}
			// コンテンツ取得
			$spot_info = $this->Spot->find('first',
				array(
					"conditions" => array(
						"Spot.id" => $id,
						"Spot.status" => 1,
					),
					"recursive" => 0,
					"fields" => array("Spot.user_id")
				)
			);
			// コンテンツ無し
			if (!$spot_info) {
				return $this->__output(-100);
			}
			// 所有者ではない
			if ($spot_info["Spot"]["user_id"] != $user_info["User"]["id"]) {
				return $this->__output(-102);
			}
			// スポットを保存
			$this->Spot->id = $id;
			$this->Spot->saveField("status", "0");
			return $this->__output(0);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * ツアー一覧取得
	 * @return boolean
	 */
	public function tour_list() {
		try {
			$list = array();
			$this->presetVars = $this->Tour->presetVars;
			$this->Prg->commonProcess();
			if (isset($this->request->query["owner"]) && $this->request->query["owner"] == "mydata") {
				// 認証処理
				if (!$user_info = $this->__auth()) {
					return false;
				}
			} else {
				if (isset($this->request->query["user_id"])) {
					if ($user_id = $this->User->find("first", array(
						"conditions" => array(
							"OR" => array(
								"login" => $this->request->query["user_id"],
								"id" => $this->request->query["user_id"],
							)
						)
					))) {
						$this->request->query["user_id"] = $user_id["User"]["id"];
					} else {
						$this->request->query["user_id"] = "0";
					}
				}
			}
			$cond = $this->Tour->parseCriteria($this->request->query);
			$cond = Set::merge($cond, $this->Tour->base_condition);
			$this->log($cond);
	
			$defaults = array(
				"limit"     => 10,
				"page"      => 1,
				"sort_key"  => "Tour.name",
				"sort_type" => "asc"
			);
			foreach($defaults as $_key => $_val) {
				$$_key = isset($this->request->query[$_key]) ? $this->request->query[$_key] : $_val;
			}
			if ($count = $this->Tour->find('count', array('conditions' => $cond))) {
				$unbind = array(
					"hasMany"   => array("Route"),
					"belongsTo" => array("Spot")
					);
				if (isset($this->request->query["route"]) && $this->request->query["route"] == 1) {
					$this->Tour->recursive = 2;
					unset($unbind["hasMany"]);
					$this->Tour->Route->unbindModel(array("belongsTo" => array("Tour")));
				}
				$this->Tour->unbindModel($unbind);
				$this->paginate = array(
					'conditions' => $cond,
					"order"      => array(
						$sort_key => $sort_type
					),
					"limit"      => $limit,
					"page"       => $page,
				);
				$list = $this->paginate('Tour');
			}
			$output_var = array(
				"count",
				"list"
			);
			$this->set(compact($output_var));
			$this->set('_serialize', $output_var);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * ツアー詳細
	 * @param unknown $id
	 */
	public function tour_get($id) {
		try {
			$this->Tour->id = $id;
			$this->Tour->recursive = 1;
			$data = $this->Tour->read();
			$this->Route->unbindModel(array("belongsTo" => array("Tour")));
			$routes = $this->Route->find("all", array(
				"conditions" => array(
					"Route.tour_id" => $id
				),
				"recursive" => 0,
				"order" => array("Route.sort")
			));
			$time = strtotime($data["Tour"]["start_time"]);
			$route_start = null;
			$route_end = null;
			foreach($routes as $key => $route) {
				if ($route["spot_id"]) {
					if (is_null($route_start)) {
						$route_start = $route["Spot"]["name"];
					}
					$route_end = $route["Spot"]["name"];
				}
				$routes[$key]["Route"]["start_time"] = date("H:i", $time);
				$time += $route["Route"]["stay_time"] * 60;
				$routes[$key]["Route"]["end_time"] = date("H:i", $time); 
			}
			$data["Route"] = $routes;
			$output_var = array(
				"data"
			);
			$this->set(compact($output_var));
			$this->set('_serialize', $output_var);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * ツアー情報保存
	 * @return boolean
	 */
	public function tour_save() {
		try {
			// 認証処理
			if (!$user_info = $this->__auth()) {
				return false;
			}
			// 初期化
			$status = false;
			$result = array();
			
			$this->request->data["Tour"]["user_id"] = $user_info["User"]["id"];
			// 登録
			if ($this->request->is("ajax")) {
				if (!$this->request->data["Tour"]["id"]) {
					// 追加
					$this->Tour->create();
					$this->request->data["Tour"]["status"] = "1";
				} else {
					// 更新
					$this->Tour->id = $this->request->data["Tour"]["id"];
					$tour_info = $this->Tour->find('first',
							array(
									"conditions" => array(
											"Tour.id" => $this->Tour->id,
											"Tour.status" => "1",
									),
									"recursive" => 0,
									"fields" => array("Tour.user_id")
							)
					);
					// コンテンツ無し
					if (!$tour_info) {
						return $this->__output(-100);
					}
					// 所有者ではない
					if ($tour_info["Tour"]["user_id"] != $user_info["User"]["id"]) {
						return $this->__output(-102);
					}
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
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * ツアー削除
	 * @return boolean
	 */
	public function tour_delete($id) {
		try {
			// 認証処理
			if (!$user_info = $this->__auth()) {
				return false;
			}
			// 指定なし
			if (!$id) {
				return $this->__output(-103);
			}
			// コンテンツ取得
			$tour_info = $this->Tour->find('first',
				array(
					"conditions" => array(
						"Tour.id" => $id,
						"Tour.status" => "1",
					),
					"recursive" => 0,
					"fields" => array("Tour.user_id")
				)
			);
			// コンテンツ無し
			if (!$tour_info) {
				return $this->__output(-100);
			}
			// 所有者ではない
			if ($tour_info["Tour"]["user_id"] != $user_info["User"]["id"]) {
				return $this->__output(-102);
			}
			// スポットを保存
			$this->Tour->id = $id;
			$this->Tour->saveField("status", "0");
			return $this->__output(0);
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * facebook イベント追加
	 */
	public function fb_event_add() {
		try {
			$relation = array();
			$list = array();
			$output_var = array(
				"count",
				"relation",
				"list"
			);
			$this->set(compact($output_var));
			$this->set('_serialize', $output_var);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * タグ一覧
	 */
	public function tag_list() {
		try {
			$list = $this->Tag->find('list', array("conditions" => array("Tag.name LIKE" => $this->request->query["term"]."%")));
			$output_var = array(
				"list",
			);
			$this->set(compact($output_var));
			$this->set('_serialize', $output_var);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * カテゴリ一覧
	 * @param string $id
	 */
	public function category_list($id = "") {
		try {
			if ($id) {
				$list = $this->Category->find("list", array(
						"conditions" => array(
							"parent_id" => $id,
							"status"    => 1
						)
					));
			} else {
				// 全カテゴリ
				$list = $this->Category->find("list", array(
						"conditions" => array(
							"status"    => 1
						)
				));
			}
			$output_var = array(
				"list"
			);
			$this->set(compact($output_var));
			$this->set('_serialize', $output_var);
		// 例外
		} catch (Exception $e) {
			return $this->__output(-99);
		}
	}
	
	/**
	 * ユーザー認証チェック
	 */
	private function __auth() {
		if (!$user_info = $this->Session->read("user_info")) {
			$this->__output(-1);
			return false;
		} else {
			return $user_info;
		}
	}
	
	/**
	 * json データ出力
	 * @param number $error
	 * @param unknown $result
	 * @param string $message
	 * @return boolean
	 */
	private function __output($error = 0, $result = array(), $message = "") {
		$output_var = array(
			"error",
			"message",
			"result"
		);
		if (!$message) {
			switch ($error) {
				case -1:
					$message = "認証エラー";
					break;
				case -2:
					$message = "DBエラー";
					break;
				case -100:
					$message = "コンテンツが見つかりませんでした";
					break;
				case -101:
					$message = "アクセス権がありません";
					break;
				case -102:
					$message = "操作権がありません";
					break;
				case -103:
					$message = "リクエストが正しくありません";
					break;
			}
		}
		$this->set(compact($output_var));
		$this->set('_serialize', $output_var);
		return false;
	}
	
}
