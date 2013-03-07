<?php
App::uses('MailVerify', 'Model');

/**
 * MailVerify Test Case
 *
 */
class MailVerifyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.mail_verify',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MailVerify = ClassRegistry::init('MailVerify');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MailVerify);

		parent::tearDown();
	}

}
