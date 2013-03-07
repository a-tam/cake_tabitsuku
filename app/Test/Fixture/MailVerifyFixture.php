<?php
/**
 * MailVerifyFixture
 *
 */
class MailVerifyFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'mail_verify';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'ユーザーID'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'comment' => '処理タイプ', 'charset' => 'utf8'),
		'verify' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => '本人確認用のキー', 'charset' => 'utf8'),
		'expired_time' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '有効期限'),
		'params' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '認証後に使用するパラメタ等', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '作成日時'),
		'modifed' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '更新日時'),
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
			'type' => 'Lorem ipsum dolor sit amet',
			'verify' => 'Lorem ipsum dolor sit amet',
			'expired_time' => '2013-03-07 15:38:05',
			'params' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2013-03-07 15:38:05',
			'modifed' => '2013-03-07 15:38:05'
		),
	);

}
