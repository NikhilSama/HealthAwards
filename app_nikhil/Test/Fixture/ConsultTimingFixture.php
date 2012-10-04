<?php
/**
 * ConsultTimingFixture
 *
 */
class ConsultTimingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'monday' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'tuesday' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'wednesday' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'thursday' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'friday' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'saturday' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'sunday' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'start' => array('type' => 'time', 'null' => true, 'default' => null),
		'end' => array('type' => 'time', 'null' => true, 'default' => null),
		'consult_type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'doctor_consult_location_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_consult_timings_consult_types1_idx' => array('column' => 'consult_type_id', 'unique' => 0),
			'fk_consult_timings_consult_locations1_idx' => array('column' => 'doctor_consult_location_id', 'unique' => 0)
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
			'monday' => 1,
			'tuesday' => 1,
			'wednesday' => 1,
			'thursday' => 1,
			'friday' => 1,
			'saturday' => 1,
			'sunday' => 1,
			'start' => '18:38:29',
			'end' => '18:38:29',
			'consult_type_id' => 1,
			'doctor_consult_location_id' => 1,
			'phone' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'created' => '2012-09-30 18:38:29',
			'modified' => '2012-09-30 18:38:29'
		),
	);

}
