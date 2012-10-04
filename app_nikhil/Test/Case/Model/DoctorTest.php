<?php
App::uses('Doctor', 'Model');

/**
 * Doctor Test Case
 *
 */
class DoctorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.doctor',
		'app.user',
		'app.doctor_consult_location',
		'app.location',
		'app.consult_location_type',
		'app.consult_timing',
		'app.consult_type',
		'app.experience',
		'app.qualification',
		'app.tors_to_specialty',
		'app.link_doctors_to_specialty'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Doctor = ClassRegistry::init('Doctor');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Doctor);

		parent::tearDown();
	}

}
