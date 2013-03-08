<?php
class FbLikeButton extends CakeMigration {

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
					'like_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'comment' => 'いいね！件数'),
				),
				'tours' => array(
					'like_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20, 'comment' => 'いいね！件数'),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'spots' => array(
					'like_count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20, 'comment' => 'いいね！件数'),
				),
				'tours' => array(
					'like_count' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'comment' => 'いいね！件数', 'charset' => 'utf8'),
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
