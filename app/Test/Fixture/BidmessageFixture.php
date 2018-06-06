<?php
/**
 * Bidmessage Fixture
 */
class BidmessageFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'bidamount' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'message' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'from_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'to_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'bidamount' => 1,
			'message' => 'Lorem ipsum dolor sit amet',
			'from_id' => 1,
			'to_id' => 1
		),
	);

}
