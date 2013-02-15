<?php
App::uses('AppModel', 'Model');
/**
 * Tag Model
 *
 */
class Tag extends AppModel {

	public $name = "Tag";
	
	public $useTable = "tags";
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'name' => array(
			'notEmpty',
		),
	);
	
	/**
	 * 存在しないタグを追加し、ID一覧を取得する
	 * @param unknown $tags
	 */
	public function set_list($tags = array()) {
		if (!is_array($tags)) {
			// 空にする場合はこの値を返すらしい
			return array(false);
		}
		$exists_tags = $this->find('list',
			array(
				"conditions" => array(
				$this->alias .
				".name" => $tags
			)
		));
		foreach ($tags as $tag_name) {
			if (!array_search($tag_name, $exists_tags)) {
				$this->create();
				if ($this->save(array("name" => $tag_name))) {
					$exists_tags[$this->getInsertID()] = $tag_name;
				}
			}
		}
		return $exists_tags;
	}
}
