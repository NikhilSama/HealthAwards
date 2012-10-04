<?php
App::uses('LinkDoctorsToSpecialty', 'Model');

/**
 * LinkDoctorsToSpecialty Test Case
 *
 */
class LinkDoctorsToSpecialtyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.link_doctors_to_specialty',
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
		'app.specialty'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinkDoctorsToSpecialty = ClassRegistry::init('LinkDoctorsToSpecialty');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinkDoctorsToSpecialty);

		parent::tearDown();
	}

}
