<?php
App::uses('AppModel', 'Model');
/**
 * PinCode Model
 *
 * @property Location $Location
 * @property Patient $Patient
 */
class PinCode extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'pin_code_id',
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
		'Patient' => array(
			'className' => 'Patient',
			'foreignKey' => 'pin_code_id',
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
	public function searchPinCode($words){
		$result = $this->find('all',array('conditions'=>array("PinCode.pin_code  LIKE '".$words."%'"),'fields'=>array('PinCode.id','PinCode.pin_code'),'order'=>array('PinCode.pin_code'),'limit'=>10));
		$cities=array();
		foreach($result as $val){
			$cities[]=array('id'=>$val['PinCode']['id'],'label'=>$val['PinCode']['pin_code']);
		}
		return $cities;
	}
	function getPinCodeId($words){
		$pinCodeId='';
		$result = $this->find('first',array('conditions'=>array("PinCode.pin_code  = '".$words."'"),'fields'=>array('PinCode.id')));
		if($result){
			$pinCodeId=$result['PinCode']['id'];
		}else{
			$this->save(array('pin_code'=>$words));
			$pinCodeId=$this->getLastInsertID();
		}
		return $pinCodeId;
	}
}
