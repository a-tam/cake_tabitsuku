<?php
App::uses('Spot', 'Model');

/**
 * Spot Test Case
 *
 */
class SpotTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.spot',
		'app.user',
		'app.route',
		'app.tour'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Spot = ClassRegistry::init('Spot');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Spot);

		parent::tearDown();
	}

}
