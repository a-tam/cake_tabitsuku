<?php
class Cake extends CakeMigration {

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
			'create_table' => array(
				'attachments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'model' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'id'),
					'foreign_key' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'model'),
					'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'foreign_key'),
					'attachment' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'name'),
					'dir' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'attachment'),
					'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'dir'),
					'size' => array('type' => 'integer', 'null' => true, 'default' => '0', 'after' => 'type'),
					'active' => array('type' => 'boolean', 'null' => true, 'default' => '1', 'after' => 'size'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'spots_tags' => array(
					'spot_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'tag_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'spot_id'),
					'indexes' => array(
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'tours_tags' => array(
					'tour_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'tag_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'tour_id'),
					'indexes' => array(
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
				'trees' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
					'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'after' => 'id'),
					'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'after' => 'parent_id'),
					'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'after' => 'lft'),
					'name' => array('type' => 'string', 'null' => true, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'rght'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
				),
			),
			'create_field' => array(
				'categories' => array(
					'parent_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'comment' => '親ID', 'charset' => 'utf8', 'after' => 'id'),
				),
				'tags' => array(
					'indexes' => array(
						'name' => array('column' => 'name', 'unique' => 1),
					),
				),
				'tours' => array(
					'prefecture' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'comment' => '県名', 'charset' => 'utf8', 'after' => 'description'),
					'stay_time' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => '滞在時間', 'after' => 'end_time'),
					'start_lat' => array('type' => 'float', 'null' => false, 'default' => NULL, 'after' => 'topic'),
					'start_lng' => array('type' => 'float', 'null' => false, 'default' => NULL, 'after' => 'start_lat'),
				),
				'users' => array(
					'approval' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => '0:未承認, 1:本人確認済み', 'after' => 'privacy'),
				),
			),
			'drop_field' => array(
				'categories' => array('parent',),
				'spots' => array('tags',),
			),
			'alter_field' => array(
				'tags' => array(
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'タグ名', 'charset' => 'utf8'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'attachments', 'spots_tags', 'tours_tags', 'trees'
			),
			'drop_field' => array(
				'categories' => array('parent_id',),
				'tags' => array('', 'indexes' => array('name')),
				'tours' => array('prefecture', 'stay_time', 'start_lat', 'start_lng',),
				'users' => array('approval',),
			),
			'create_field' => array(
				'categories' => array(
					'parent' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45, 'collate' => 'utf8_general_ci', 'comment' => '親ID', 'charset' => 'utf8'),
				),
				'spots' => array(
					'tags' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'comment' => 'タグIDをカンマ区切りで保持（検索用のインデックス）', 'charset' => 'utf8'),
				),
			),
			'alter_field' => array(
				'tags' => array(
					'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'comment' => 'タグ名', 'charset' => 'utf8'),
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
