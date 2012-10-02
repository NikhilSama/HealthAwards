<?php
App::uses('Location', 'Model');

/**
 * Location Test Case
 *
 */
class LocationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.location',
		'app.city',
		'app.patient',
		'app.country',
		'app.pin_code',
		'app.experience',
		'app.doctor',
		'app.user',
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
		$this->Location = ClassRegistry::init('Location');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Location);

		parent::tearDown();
	}

}
