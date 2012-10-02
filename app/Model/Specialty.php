<?php
App::uses('AppModel', 'Model');
/**
 * Specialty Model
 *
 * @property LinkDoctorsToSpecialty $LinkDoctorsToSpecialty
 * @property LinkSpecialtiesToDisease $LinkSpecialtiesToDisease
 */
class Specialty extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'LinkDoctorsToSpecialty' => array(
			'className' => 'LinkDoctorsToSpecialty',
			'foreignKey' => 'specialty_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'LinkSpecialtiesToDisease' => array(
			'className' => 'LinkSpecialtiesToDisease',
			'foreignKey' => 'specialty_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
