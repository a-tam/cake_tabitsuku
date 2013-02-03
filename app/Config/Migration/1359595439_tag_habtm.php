<?php

class TagHabtm extends CakeMigration {
	
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
		'up'   => array(
			'create_table' => array(
				'spots_tags' => array(
					'spot_id'         => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL
					),
					'tag_id'          => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL
					),
					'indexes'         => array(),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_general_ci',
						'engine'  => 'InnoDB'
					),
				),
				'tours_tags' => array(
					'tour_id'         => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL
					),
					'tag_id'          => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL
					),
					'indexes'         => array(),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_general_ci',
						'engine'  => 'InnoDB'
					),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'spots_tags',
				'tours_tags',
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
