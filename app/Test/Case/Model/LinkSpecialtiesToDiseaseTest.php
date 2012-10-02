<?php
App::uses('LinkSpecialtiesToDisease', 'Model');

/**
 * LinkSpecialtiesToDisease Test Case
 *
 */
class LinkSpecialtiesToDiseaseTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.link_specialties_to_disease',
		'app.specialty',
		'app.disease',
		'app.link_specialties_to',
		'app.specialty_disease_link_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LinkSpecialtiesToDisease = ClassRegistry::init('LinkSpecialtiesToDisease');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LinkSpecialtiesToDisease);

		parent::tearDown();
	}

}
