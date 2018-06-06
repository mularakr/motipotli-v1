<?php
App::uses('Bid', 'Model');

/**
 * Bid Test Case
 */
class BidTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bid',
		'app.job',
		'app.category',
		'app.user',
		'app.jobimage'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bid = ClassRegistry::init('Bid');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bid);

		parent::tearDown();
	}

}
