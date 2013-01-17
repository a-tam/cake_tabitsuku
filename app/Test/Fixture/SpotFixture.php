<?php
/**
 * SpotFixture
 *
 */
class SpotFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'comment' => '所有者'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'comment' => 'イベント名', 'charset' => 'utf8'),
		'image' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '説明', 'charset' => 'utf8'),
		'stay_time' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '滞在時間（分）'),
		'lat' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => '緯度'),
		'lng' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => '経度'),
		'prefecture' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'zoom' => array('type' => 'integer', 'null' => true, 'default' => null),
		'like_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'comment' => 'いいね！件数'),
		'category' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'comment' => 'カテゴリIDをカンマ区切りで登録(mongodbの配列カラムなどを最終的に使う)', 'charset' => 'utf8'),
		'tags' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'comment' => 'タグIDをカンマ区切りで保持（検索用のインデックス）', 'charset' => 'utf8'),
		'keyword' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'addition' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
		'status' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'comment' => '０：無効、１：有効', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'image' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'stay_time' => 1,
			'lat' => 1,
			'lng' => 1,
			'prefecture' => 'Lorem ipsum dolor sit amet',
			'zoom' => 1,
			'like_count' => 1,
			'category' => 'Lorem ipsum dolor sit amet',
			'tags' => 'Lorem ipsum dolor sit amet',
			'keyword' => 'Lorem ipsum dolor sit amet',
			'addition' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2013-01-17 19:15:39',
			'modified' => '2013-01-17 19:15:39',
			'status' => 'Lorem ipsum dolor sit amet'
		),
	);

}
