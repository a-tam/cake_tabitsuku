<?php

class Init extends CakeMigration {
	
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
				'categories' => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'key'     => 'primary'
					),
					'parent'          => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 45,
						'collate' => 'utf8_general_ci',
						'comment' => '親ID',
						'charset' => 'utf8'
					),
					'path'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 221,
						'collate' => 'utf8_general_ci',
						'comment' => 'パス（最大カテゴリ数10億、10階層）',
						'charset' => 'utf8'
					),
					'sort'            => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'comment' => 'ソート（兄ノード）'
					),
					'name'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'comment' => 'カテゴリ名',
						'charset' => 'utf8'
					),
					'created'         => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '作成日時'
					),
					'modified'        => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '更新日時'
					),
					'status'          => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 45,
						'collate' => 'utf8_general_ci',
						'comment' => '０：無効、１：有効',
						'charset' => 'utf8'
					),
					'indexes'         => array(
						'PRIMARY' => array(
							'column' => 'id',
							'unique' => 1
						),
					),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_general_ci',
						'engine'  => 'InnoDB'
					),
				),
				'routes'     => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'key'     => 'primary'
					),
					'tour_id'         => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'length'  => 20,
						'comment' => 'イベントID'
					),
					'spot_id'         => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'length'  => 20,
						'comment' => 'ポイントID'
					),
					'stay_time'       => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'comment' => '滞在時間（フリップとは別に任意で変更可能）'
					),
					'sort'            => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'comment' => 'ソート順'
					),
					'info'            => array(
						'type'    => 'text',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'created'         => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '作成日時'
					),
					'modified'        => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '更新日時'
					),
					'indexes'         => array(
						'PRIMARY' => array(
							'column' => 'id',
							'unique' => 1
						),
					),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_general_ci',
						'engine'  => 'InnoDB'
					),
				),
				'spots'      => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'key'     => 'primary'
					),
					'user_id'         => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'length'  => 20,
						'comment' => '所有者'
					),
					'name'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'comment' => 'イベント名',
						'charset' => 'utf8'
					),
					'image'           => array(
						'type'    => 'text',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'description'     => array(
						'type'    => 'text',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'comment' => '説明',
						'charset' => 'utf8'
					),
					'stay_time'       => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'comment' => '滞在時間（分）'
					),
					'lat'             => array(
						'type'    => 'float',
						'null'    => true,
						'default' => NULL,
						'comment' => '緯度'
					),
					'lng'             => array(
						'type'    => 'float',
						'null'    => true,
						'default' => NULL,
						'comment' => '経度'
					),
					'prefecture'      => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'zoom'            => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL
					),
					'like_count'      => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'length'  => 20,
						'comment' => 'いいね！件数'
					),
					'category'        => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'comment' => 'カテゴリIDをカンマ区切りで登録(mongodbの配列カラムなどを最終的に使う)',
						'charset' => 'utf8'
					),
					'tags'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'comment' => 'タグIDをカンマ区切りで保持（検索用のインデックス）',
						'charset' => 'utf8'
					),
					'keyword'         => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'addition'        => array(
						'type'    => 'text',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'created'         => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '作成日時'
					),
					'modified'        => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '更新日時'
					),
					'status'          => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 45,
						'collate' => 'utf8_general_ci',
						'comment' => '０：無効、１：有効',
						'charset' => 'utf8'
					),
					'indexes'         => array(
						'PRIMARY' => array(
							'column' => 'id',
							'unique' => 1
						),
					),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_general_ci',
						'engine'  => 'InnoDB'
					),
				),
				'tags'       => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'length'  => 20,
						'key'     => 'primary'
					),
					'name'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'comment' => 'タグ名',
						'charset' => 'utf8'
					),
					'created'         => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 45,
						'collate' => 'utf8_general_ci',
						'comment' => '作成日時',
						'charset' => 'utf8'
					),
					'modified'        => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '更新日時'
					),
					'status'          => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 45,
						'collate' => 'utf8_general_ci',
						'comment' => '０：無効、１：有効',
						'charset' => 'utf8'
					),
					'indexes'         => array(
						'PRIMARY' => array(
							'column' => 'id',
							'unique' => 1
						),
					),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_general_ci',
						'engine'  => 'InnoDB'
					),
				),
				'tours'      => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'key'     => 'primary'
					),
					'user_id'         => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'comment' => '所有者'
					),
					'name'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'comment' => 'スケジュール名（例：オススメ東京観光旅行）',
						'charset' => 'utf8'
					),
					'description'     => array(
						'type'    => 'text',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'comment' => '説明',
						'charset' => 'utf8'
					),
					'start_time'      => array(
						'type'    => 'time',
						'null'    => true,
						'default' => NULL,
						'comment' => '開始時間'
					),
					'end_time'        => array(
						'type'    => 'time',
						'null'    => true,
						'default' => NULL,
						'comment' => '終了時間'
					),
					'image'           => array(
						'type'    => 'text',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'like_count'      => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 45,
						'collate' => 'utf8_general_ci',
						'comment' => 'いいね！件数',
						'charset' => 'utf8'
					),
					'category'        => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'tags'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'topic'           => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'lat_min'         => array(
						'type'    => 'float',
						'null'    => true,
						'default' => NULL
					),
					'lat_max'         => array(
						'type'    => 'float',
						'null'    => true,
						'default' => NULL
					),
					'lng_min'         => array(
						'type'    => 'float',
						'null'    => true,
						'default' => NULL
					),
					'lng_max'         => array(
						'type'    => 'float',
						'null'    => true,
						'default' => NULL
					),
					'created'         => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '作成日時'
					),
					'modified'        => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '更新日時'
					),
					'status'          => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 45,
						'collate' => 'utf8_general_ci',
						'comment' => '０：無効、１：有効',
						'charset' => 'utf8'
					),
					'indexes'         => array(
						'PRIMARY' => array(
							'column' => 'id',
							'unique' => 1
						),
					),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_general_ci',
						'engine'  => 'InnoDB'
					),
				),
				'users'      => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'key'     => 'primary'
					),
					'login'           => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'password'        => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 64,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'email'           => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'social_facebook' => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 50,
						'key'     => 'unique',
						'collate' => 'utf8_general_ci',
						'comment' => 'Facebook ID',
						'charset' => 'utf8'
					),
					'name'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'comment' => '名前',
						'charset' => 'utf8'
					),
					'privacy'         => array(
						'type'    => 'string',
						'null'    => false,
						'default' => NULL,
						'length'  => 1,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'created'         => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '作成日時'
					),
					'modified'        => array(
						'type'    => 'datetime',
						'null'    => true,
						'default' => NULL,
						'comment' => '更新日時'
					),
					'status'          => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 45,
						'collate' => 'utf8_general_ci',
						'comment' => '０：無効、１：有効',
						'charset' => 'utf8'
					),
					'indexes'         => array(
						'PRIMARY'            => array(
							'column' => 'id',
							'unique' => 1
						),
						'facebook_id_UNIQUE' => array(
							'column' => 'social_facebook',
							'unique' => 1
						),
					),
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
				'categories',
				'routes',
				'spots',
				'tags',
				'tours',
				'users'
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