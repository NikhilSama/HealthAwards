<?php
App::uses('CountriesController', 'Controller');

/**
 * CountriesController Test Case
 *
 */
class CountriesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.country',
		'app.location',
		'app.city',
		'app.patient',
		'app.user',
		'app.appointment',
		'app.doctor',
		'app.doctor_consult_location',
		'app.consult_location_type',
		'app.consult_timing',
		'app.consult_type',
		'app.experience',
		'app.qualification',
		'app.degree',
		'app.link_doctors_to_specialty',
		'app.specialty',
		'app.link_specialties_to_disease',
		'app.disease',
		'app.specialty_disease_link_type',
		'app.post_feedback',
		'app.post',
		'app.question',
		'app.question_follower',
		'app.pin_code'
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
