<?php
App::uses('Tour', 'Model');

/**
 * Tour Test Case
 *
 */
class TourTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tour',
		'app.user',
		'app.route',
		'app.spot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tour = ClassRegistry::init('Tour');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tour);

		parent::tearDown();
	}

}
