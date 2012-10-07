<?php
App::uses('AppModel', 'Model');
/**
 * Country Model
 *
 * @property Location $Location
 * @property Patient $Patient
 */
class Country extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'country_id',
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
			'foreignKey' => 'country_id',
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
	public function searchCountry($words){
		$result = $this->find('all',array('conditions'=>array("Country.name  LIKE '".$words."%'"),'fields'=>array('Country.id','Country.name'),'order'=>array('Country.name'),'limit'=>10));
		$cities=array();
		foreach($result as $val){
			$cities[]=array('id'=>$val['Country']['id'],'label'=>$val['Country']['name']);
		}
		return $cities;
	}
	function getCountryId($words){
		$countryId='';
		$result = $this->find('first',array('conditions'=>array("Country.name  = '".$words."'"),'fields'=>array('Country.id')));
		if($result){
			$countryId=$result['Country']['id'];
		}else{
			$this->save(array('name'=>$words));
			$countryId=$this->getLastInsertID();
		}
		return $countryId;
	}
}
