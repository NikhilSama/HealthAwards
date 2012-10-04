<?php
App::uses('AppModel', 'Model');
/**
 * SpecialtyDiseaseLinkType Model
 *
 * @property LinkSpecialtiesToDisease $LinkSpecialtiesToDisease
 */
class SpecialtyDiseaseLinkType extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'LinkSpecialtiesToDisease' => array(
			'className' => 'LinkSpecialtiesToDisease',
			'foreignKey' => 'specialty_disease_link_type_id',
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
