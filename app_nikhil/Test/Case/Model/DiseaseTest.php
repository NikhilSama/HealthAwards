<?php
App::uses('Disease', 'Model');

/**
 * Disease Test Case
 *
 */
class DiseaseTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.disease',
		'app.dslink'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Disease = ClassRegistry::init('Disease');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Disease);

		parent::tearDown();
	}

}
