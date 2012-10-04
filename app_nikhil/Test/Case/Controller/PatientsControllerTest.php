<?php
App::uses('PatientsController', 'Controller');

/**
 * PatientsController Test Case
 *
 */
class PatientsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.patient',
		'app.user',
		'app.appointment',
		'app.doctor',
		'app.doctor_consult_location',
		'app.location',
		'app.city',
		'app.country',
		'app.pin_code',
		'app.experience',
		'app.qualification',
		'app.degree',
		'app.consult_location_type',
		'app.consult_timing',
		'app.consult_type',
		'app.link_doctors_to_specialty',
		'app.specialty',
		'app.link_specialties_to_disease',
		'app.disease',
		'app.specialty_disease_link_type',
		'app.post_feedback',
		'app.post',
		'app.question',
		'app.question_follower'
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
	}

}
