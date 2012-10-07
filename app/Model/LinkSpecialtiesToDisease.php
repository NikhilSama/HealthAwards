<?php
App::uses('AppModel', 'Model');
/**
 * LinkSpecialtiesToDisease Model
 *
 * @property Specialty $Specialty
 * @property Disease $Disease
 * @property SpecialtyDiseaseLinkType $SpecialtyDiseaseLinkType
 */
class LinkSpecialtiesToDisease extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'specialty_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'disease_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'specialty_disease_link_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Specialty' => array(
			'className' => 'Specialty',
			'foreignKey' => 'specialty_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Disease' => array(
			'className' => 'Disease',
			'foreignKey' => 'disease_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SpecialtyDiseaseLinkType' => array(
			'className' => 'SpecialtyDiseaseLinkType',
			'foreignKey' => 'specialty_disease_link_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
