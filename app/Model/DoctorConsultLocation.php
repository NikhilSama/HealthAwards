<?php
App::uses('AppModel', 'Model');
/**
 * DoctorConsultLocation Model
 *
 * @property Location $Location
 * @property Doctor $Doctor
 * @property ConsultLocationType $ConsultLocationType
 * @property ConsultTiming $ConsultTiming
 */
class DoctorConsultLocation extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'location_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'doctor_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'consult_location_type_id' => array(
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
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		/*'Doctor' => array(
			'className' => 'Doctor',
			'foreignKey' => 'doctor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),*/
		'ConsultLocationType' => array(
			'className' => 'ConsultLocationType',
			'foreignKey' => 'consult_location_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ConsultTiming' => array(
			'className' => 'ConsultTiming',
			'foreignKey' => 'doctor_consult_location_id',
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
	
	function getDoctorConsultLocation($doctorId){
		return $this->find('all',array('conditions'=>array('DoctorConsultLocation.doctor_id'=>$doctorId),'fields'=>array(),'recursive'=>2));
	}
	
	function getDoctorAddressById($doctorId,$addressId){
		return $this->find('first',array('conditions'=>array('DoctorAddress.id'=>$addressId,'DoctorAddress.doctor_id'=>$doctorId,'DoctorAddress.isActive'=>1),'fields'=>array('DoctorAddress.id','DoctorAddress.address','DoctorAddress.city','DoctorAddress.pin')));
	
	}
}
