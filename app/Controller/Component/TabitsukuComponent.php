<?php

class TabitsukuComponent extends Component {
	
	public function initialize(Controller $controller) {
		$this->loadModel("SpotTag");
		$this->loadModel("Category");
		$this->loadModel("Spot");
		$this->loadModel("Tour");
	}
	
	private function loadModel($modelName) {
		
		if (!empty($this->{$modelName})) {
			// すでに存在すればそのままreturn
			return;
		} elseif (!empty($this->controller
			->{$modelName})) {
			// 呼び出し元のコントローラでusesしてあれば$this->{モデル名}に参照渡し
			$this->{$modelName} = $this->controller
				->{$modelName};
		} else {
			// コントローラでusesしていなければコンポーネントでモデルを読み込む
			App::uses($modelName, 'Model');
			$this->{$modelName} = new $modelName;
		}
	}
	
	public function get_ranking() {
		// 初期化
		$tag_ranking      = array();
		$category_ranking = array();
		$tour_ranking     = array();
		$spot_ranking     = array();
		
		// タグ
		$sql = "SELECT tag_id, tags.name, COUNT( tag_id ) AS cnt".
			" FROM (".
			" (SELECT tag_id FROM  `spots_tags`)".
			" UNION ALL".
			" (SELECT tag_id FROM  `tours_tags`)) AS tmp".
			" LEFT JOIN tags ON tmp.tag_id = tags.id".
			" GROUP BY tag_id".
			" ORDER BY cnt DESC".
			" LIMIT 5";
		$data = $this->SpotTag->query($sql);
		// 整形
		foreach($data as $row) {
			$tag_ranking[] = array(
				'tag_id' => $row['tmp']['tag_id'],
				'name' => $row['tags']['name'],
				'count' => $row[0]['cnt']
			);
		}
		
		// ルートノード取得
		$sql = "SELECT path, name FROM categories WHERE parent_id =  '' AND status = 1";
		$data = $this->Category->query($sql);
		foreach($data as $key => $row) {
			$sql = "SELECT SUM(cnt) as total FROM (".
				" (SELECT COUNT( * ) AS cnt FROM spots WHERE category LIKE ',".$row['categories']['path']."%')".
				" UNION ALL ".
				" (SELECT COUNT( * ) AS cnt FROM tours WHERE category LIKE ',".$row['categories']['path']."%')".
				" ) AS tmp";
			$total = $this->Category->query($sql);
			$category_ranking[] = array(
				'path' => $row['categories']['path'],
				'name' => $row['categories']['name'],
				'count' => $total[0][0]['total'],
			);
		}
		
		// ツアー
		$data = $this->Tour->find('all',
			array(
				'recursive'  => 0,
				'limit'  => 5,
				'fields' => array(
					'name',
					'like_count'
				),
				'order'  => array(
					'like_count' => 'DESC'
				)
			));
		// 整形
		foreach ($data as $row) {
			$tour_ranking[] = array(
				'tour_id' => $row['Tour']['id'],
				'name'    => $row['Tour']['name'],
				'count'   => $row['Tour']['like_count'],
			);
		}
		
		// スポット
		$data = $this->Spot->find('all',
			array(
				'recursive'  => 0,
				'limit'  => 5,
				'fields' => array(
					'name',
					'like_count'
				),
				'order'  => array(
					'like_count' => 'DESC'
				)
			));
		// 整形
		foreach ($data as $row) {
			$spot_ranking[] = array(
				'spot_id' => $row['Spot']['id'],
				'name'    => $row['Spot']['name'],
				'count'   => $row['Spot']['like_count'],
			);
		}
		
		$response = array(
			"tag"      => $tag_ranking,
			"category" => $category_ranking,
			"tour"     => $tour_ranking,
			"spot"     => $spot_ranking
		);
		return $response;
	}
}