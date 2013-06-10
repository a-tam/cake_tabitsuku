<?php
class FloatToDouble extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'spots' => array(
					'lat' => array('type' => 'double', 'null' => true, 'default' => NULL, 'comment' => '緯度(Google)'),
					'lng' => array('type' => 'double', 'null' => true, 'default' => NULL, 'comment' => '経度(Google)'),
				),
				'tours' => array(
					'start_lat' => array('type' => 'double', 'null' => false, 'default' => NULL, 'comment' => '開始地点（緯度）'),
					'start_lng' => array('type' => 'double', 'null' => false, 'default' => NULL, 'comment' => '開始地点（経度）'),
					'lat_min' => array('type' => 'double', 'null' => true, 'default' => NULL, 'comment' => '最小緯度'),
					'lat_max' => array('type' => 'double', 'null' => true, 'default' => NULL, 'comment' => '最高緯度'),
					'lng_min' => array('type' => 'double', 'null' => true, 'default' => NULL, 'comment' => '最小経度'),
					'lng_max' => array('type' => 'double', 'null' => true, 'default' => NULL, 'comment' => '最大経度'),
				),
				'trees' => array(
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'spots' => array(
					'lat' => array('type' => 'double', 'null' => true, 'default' => NULL, 'comment' => '緯度'),
					'lng' => array('type' => 'double', 'null' => true, 'default' => NULL, 'comment' => '経度'),
				),
				'tours' => array(
					'start_lat' => array('type' => 'double', 'null' => false, 'default' => NULL),
					'start_lng' => array('type' => 'double', 'null' => false, 'default' => NULL),
					'lat_min' => array('type' => 'double', 'null' => true, 'default' => NULL),
					'lat_max' => array('type' => 'double', 'null' => true, 'default' => NULL),
					'lng_min' => array('type' => 'double', 'null' => true, 'default' => NULL),
					'lng_max' => array('type' => 'double', 'null' => true, 'default' => NULL),
				),
				'trees' => array(
					'name' => array('type' => 'string', 'null' => true, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
