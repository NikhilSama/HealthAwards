<?php
App::uses('Qualification', 'Model');

/**
 * Qualification Test Case
 *
 */
class QualificationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.qualification',
		'app.doctor',
		'app.user',
		'app.doctor_consult_location',
		'app.location',
		'app.city',
		'app.patient',
		'app.pin_code',
		'app.country',
		'app.experience',
		'app.doctor_consult',
		'app.consult_location_type',
		'app.consult_timing',
		'app.consult_type',
		'app.tors_to_specialty',
		'app.link_doctors_to_specialty',
		'app.degree'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Qualification = ClassRegistry::init('Qualification');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Qualification);

		parent::tearDown();
	}

}
