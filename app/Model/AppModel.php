<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	/**
	 * タグで一致したスポット一覧をフィルタリング
	 *
	 * @param unknown $tag_name タグ名
	 * @param string $match_type "like" : あいまい検索 / "prefix": 前方一致 / "suffix": 後方一致 / "equal": 完全一致
	 */
	public function filterByTagSpot($tag_name, $match = "like") {
		App::import('Model','Tag');
		App::import('Model','SpotsTag');
		$conditions = $this->__condition("Tag.name", $tag_name, "like");
		$tag_list = $this->Tag->find("list", array(
			"conditions" => $conditions
		));
		$spot_list = $this->SpotsTag->find("list", array(
			"conditions" => array(
				"SpotsTag.tag_id" => array_keys($tag_list)
			),
			"group" => "SpotsTag.spot_id"
		));
		return $spot_list;
	}
	
	public function filterByTagTour($name) {
		App::import('Model','Tag');
		App::import('Model','ToursTag');
		$conditions = $this->__condition("Tag.name", $tag_name, "like");
		$tag_list = $this->Tag->find("list", array(
			"conditions" => $conditions
		));
		$spot_list = $this->ToursTag->find("list", array(
			"conditions" => array(
				"ToursTag.tag_id" => array_keys($tag_list)
			),
			"group" => "ToursTag.spot_id"
		));
		return $tour_list;
	}
	
	public function filterByCategorySpot() {
	
	}
	
	public function filterByCategoryTour() {
	
	}
	
	/**
	 * 全角を含むスペース区切りで検索キーワードを配列で返す
	 *
	 * @param unknown $keyword
	 */
	public function splitKeyword($keyword) {
		if (!$keyword) {
			return false;
		}
		$keyword = mb_convert_kana($keyword, 's');
		return preg_split('/[\s]+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
	}
	
	/**
	 * Enter description here ...
	 * @param unknown $pattern
	 * 文字列検索 "like" : あいまい検索 / "prefix": 前方一致 / "suffix": 後方一致 / "equal": 完全一致
	 * 数値検索
	 * 範囲検索
	 * 複数指定
	 * @param unknown $column
	 * @param unknown $value
	 */
	private function __conditions($params = array()) {
		$conditions = array();
		foreach($params as $param) {
			$this->__condition($param["key"], $param["value"], $param["type"]);
		}
		return $conditions;
	}
	
	private function __condition($key, $value, $type = "equal") {
		$condition = array();
		switch ($type) {
			// 前後方一致
			case "like":
				$condition[$key." like"] = "%".$value."%";
				break;
				// 前方一致
			case "prefix":
				$condition[$key." like"] = $value."%";
				break;
				// 後方一致
			case "suffix":
				$condition[$key." like"] = "%".$value;
				break;
				// 完全一致
			case "equal":
				$condition[$key] = $value;
				break;
		}
		return $condition;
	}
}
