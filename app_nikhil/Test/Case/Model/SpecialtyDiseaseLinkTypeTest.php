<?php
App::uses('SpecialtyDiseaseLinkType', 'Model');

/**
 * SpecialtyDiseaseLinkType Test Case
 *
 */
class SpecialtyDiseaseLinkTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.specialty_disease_link_type',
		'app.link_specialties_to_disease',
		'app.specialty',
		'app.link_doctors_to',
		'app.link_doctors_to_specialty',
		'app.ties_to_disease',
		'app.disease',
		'app.link_specialties_to'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SpecialtyDiseaseLinkType = ClassRegistry::init('SpecialtyDiseaseLinkType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SpecialtyDiseaseLinkType);

		parent::tearDown();
	}

}
