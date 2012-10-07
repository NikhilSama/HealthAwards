<?php
App::uses('AppModel', 'Model');
/**
 * Doctor Model
 *
 * @property User $User
 * @property DoctorConsultLocation $DoctorConsultLocation
 * @property Experience $Experience
 * @property Qualification $Qualification
 * @property TorsToSpecialty $TorsToSpecialty
 */
class Doctor extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 *//*
	public $hasMany = array(
		'DoctorConsultLocation' => array(
			'className' => 'DoctorConsultLocation',
			'foreignKey' => 'doctor_id',
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
		'Experience' => array(
			'className' => 'Experience',
			'foreignKey' => 'doctor_id',
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
		'Qualification' => array(
			'className' => 'Qualification',
			'foreignKey' => 'doctor_id',
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
                'LinkDoctorsToSpecialty' => array(
                        'className' => 'LinkDoctorsToSpecialty',
                        'foreignKey' => 'doctor_id',
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

	);*/
	
	public function updateProfile($doctorId,$fieldName,$value){
		$this->updateAll(array($fieldName=>"'".$value."'"),array('user_id'=>$doctorId));
		return ;
	}
	function get_doctor_session_vars($doctorId, $isProductSession=null, $supportUserId = null) {
         $userdetail = $this->findById($doctorId,array('doctorId'=>'id','user_id','first_name','middle_name','last_name','email','image','last_login','awards'));
		 $this->updateAll(array('last_login'=>'now()'),array('user_id'=>$doctorId));
		 return ($userdetail['Doctor']);
    }

}
