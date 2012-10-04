<?php
App::uses('ConsultLocationType', 'Model');

/**
 * ConsultLocationType Test Case
 *
 */
class ConsultLocationTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.consult_location_type',
		'app.doctor_consult_location'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ConsultLocationType = ClassRegistry::init('ConsultLocationType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ConsultLocationType);

		parent::tearDown();
	}

}
