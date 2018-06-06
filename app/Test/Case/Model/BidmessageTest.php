<?php
App::uses('Bidmessage', 'Model');

/**
 * Bidmessage Test Case
 */
class BidmessageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bidmessage'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bidmessage = ClassRegistry::init('Bidmessage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bidmessage);

		parent::tearDown();
	}

}
