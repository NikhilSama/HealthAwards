<?php
App::uses('Patient', 'Model');

/**
 * Patient Test Case
 *
 */
class PatientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.patient',
		'app.user',
		'app.city',
		'app.location',
		'app.country',
		'app.pin_code',
		'app.experience',
		'app.doctor',
		'app.doctor_consult_location',
		'app.consult_location_type',
		'app.consult_timing',
		'app.consult_type',
		'app.qualification',
		'app.tors_to_specialty',
		'app.link_doctors_to_specialty',
		'app.doctor_consult'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Patient = ClassRegistry::init('Patient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Patient);

		parent::tearDown();
	}

}
