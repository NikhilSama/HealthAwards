<?php
App::uses('User', 'Model');

/**
 * User Test Case
 *
 */
class UserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user',
		'app.appointment',
		'app.doctor',
		'app.doctor_consult_location',
		'app.location',
		'app.city',
		'app.patient',
		'app.pin_code',
		'app.country',
		'app.experience',
		'app.qualification',
		'app.degree',
		'app.doctor_consult',
		'app.consult_location_type',
		'app.consult_timing',
		'app.consult_type',
		'app.tors_to_specialty',
		'app.link_doctors_to_specialty',
		'app.post_feedback',
		'app.post',
		'app.question',
		'app.question_follower'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}

}
