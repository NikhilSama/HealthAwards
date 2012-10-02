<?php
App::uses('PinCode', 'Model');

/**
 * PinCode Test Case
 *
 */
class PinCodeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.pin_code',
		'app.location',
		'app.city',
		'app.patient',
		'app.user',
		'app.country',
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
		$this->PinCode = ClassRegistry::init('PinCode');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PinCode);

		parent::tearDown();
	}

}
