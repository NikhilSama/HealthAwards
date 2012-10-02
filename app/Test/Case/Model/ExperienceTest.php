<?php
App::uses('Experience', 'Model');

/**
 * Experience Test Case
 *
 */
class ExperienceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.experience',
		'app.doctor',
		'app.user',
		'app.doctor_consult_location',
		'app.location',
		'app.consult_location_type',
		'app.consult_timing',
		'app.consult_type',
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
		$this->Experience = ClassRegistry::init('Experience');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Experience);

		parent::tearDown();
	}

}
