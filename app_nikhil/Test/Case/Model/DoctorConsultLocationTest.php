<?php
App::uses('DoctorConsultLocation', 'Model');

/**
 * DoctorConsultLocation Test Case
 *
 */
class DoctorConsultLocationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.doctor_consult_location',
		'app.location',
		'app.doctor',
		'app.consult_location_type',
		'app.consult_timing',
		'app.consult_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DoctorConsultLocation = ClassRegistry::init('DoctorConsultLocation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DoctorConsultLocation);

		parent::tearDown();
	}

}
