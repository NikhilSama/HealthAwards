<?php
App::uses('AppModel', 'Model');
/**
 * Disease Model
 *
 * @property LinkSpecialtiesTo $LinkSpecialtiesTo
 */
class Disease extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'LinkSpecialtiesToDisease' => array(
			'className' => 'LinkSpecialtiesToDisease',
			'joinTable' => 'link_specialties_to_diseases',
			'foreignKey' => 'disease_id',
			'associationForeignKey' => 'link_specialties_to_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
