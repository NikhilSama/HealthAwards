<?php
App::uses('AppModel', 'Model');
/**
 * ConsultTiming Model
 *
 * @property ConsultType $ConsultType
 * @property DoctorConsultLocation $DoctorConsultLocation
 */
class ConsultTiming extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'consult_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'doctor_consult_location_id' => array(
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
		'ConsultType' => array(
			'className' => 'ConsultType',
			'foreignKey' => 'consult_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		/*'DoctorConsultLocation' => array(
			'className' => 'DoctorConsultLocation',
			'foreignKey' => 'doctor_consult_location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)*/
	);
}
