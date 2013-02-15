<?php

class Login extends CakeMigration {
	
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
				'attachments' => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'length'  => 10,
						'key'     => 'primary'
					),
					'model'           => array(
						'type'    => 'string',
						'null'    => false,
						'default' => NULL,
						'length'  => 20,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'foreign_key'     => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL
					),
					'name'            => array(
						'type'    => 'string',
						'null'    => false,
						'default' => NULL,
						'length'  => 32,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'attachment'      => array(
						'type'    => 'string',
						'null'    => false,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'dir'             => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'type'            => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'charset' => 'utf8'
					),
					'size'            => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => '0'
					),
					'active'          => array(
						'type'    => 'boolean',
						'null'    => true,
						'default' => '1'
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
				'categories'  => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'key'     => 'primary'
					),
					'parent_id'       => array(
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
				'routes'      => array(
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
				'spots'       => array(
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
				'spots_tags'  => array(
					'spot_id'         => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'key'     => 'primary'
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
				'tags'        => array(
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
						'key'     => 'unique',
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
						'name'    => array(
							'column' => 'name',
							'unique' => 1
						),
					),
					'tableParameters' => array(
						'charset' => 'utf8',
						'collate' => 'utf8_general_ci',
						'engine'  => 'InnoDB'
					),
				),
				'tours'       => array(
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
					'prefecture'      => array(
						'type'    => 'string',
						'null'    => false,
						'default' => NULL,
						'length'  => 200,
						'collate' => 'utf8_general_ci',
						'comment' => '県名',
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
					'stay_time'       => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'comment' => '滞在時間'
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
					'start_lat'       => array(
						'type'    => 'float',
						'null'    => false,
						'default' => NULL
					),
					'start_lng'       => array(
						'type'    => 'float',
						'null'    => false,
						'default' => NULL
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
				'tours_tags'  => array(
					'tour_id'         => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'key'     => 'primary'
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
				'trees'       => array(
					'id'              => array(
						'type'    => 'integer',
						'null'    => false,
						'default' => NULL,
						'length'  => 10,
						'key'     => 'primary'
					),
					'parent_id'       => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'length'  => 10
					),
					'lft'             => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'length'  => 10
					),
					'rght'            => array(
						'type'    => 'integer',
						'null'    => true,
						'default' => NULL,
						'length'  => 10
					),
					'name'            => array(
						'type'    => 'string',
						'null'    => true,
						'collate' => 'utf8_general_ci',
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
				'users'       => array(
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
						'comment' => 'ログインID',
						'charset' => 'utf8'
					),
					'password'        => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'length'  => 64,
						'collate' => 'utf8_general_ci',
						'comment' => 'パスワード',
						'charset' => 'utf8'
					),
					'email'           => array(
						'type'    => 'string',
						'null'    => true,
						'default' => NULL,
						'collate' => 'utf8_general_ci',
						'comment' => 'メールアドレス',
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
						'comment' => 'プライバシー',
						'charset' => 'utf8'
					),
					'verify'          => array(
						'type'    => 'string',
						'null'    => false,
						'default' => NULL,
						'length'  => 64,
						'collate' => 'utf8_general_ci',
						'comment' => '本人確認用',
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
				'attachments',
				'categories',
				'routes',
				'spots',
				'spots_tags',
				'tags',
				'tours',
				'tours_tags',
				'trees',
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
