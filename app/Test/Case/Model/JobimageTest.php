<?php
App::uses('Jobimage', 'Model');

/**
 * Jobimage Test Case
 */
class JobimageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.jobimage',
		'app.job',
		'app.category',
		'app.user',
		'app.bid'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Jobimage = ClassRegistry::init('Jobimage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Jobimage);

		parent::tearDown();
	}

}
