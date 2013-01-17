<?php
/**
 * RouteFixture
 *
 */
class RouteFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'tour_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'comment' => 'イベントID'),
		'spot_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'comment' => 'ポイントID'),
		'stay_time' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => '滞在時間（フリップとは別に任意で変更可能）'),
		'sort' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'ソート順'),
		'info' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
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
			'tour_id' => 1,
			'spot_id' => 1,
			'stay_time' => 1,
			'sort' => 1,
			'info' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2013-01-17 18:58:20',
			'modified' => '2013-01-17 18:58:20'
		),
	);

}
