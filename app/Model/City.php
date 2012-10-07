<?php
App::uses('AppModel', 'Model');
/**
 * City Model
 *
 * @property Location $Location
 * @property Patient $Patient
 */
class City extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'city_id',
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
			'foreignKey' => 'city_id',
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
	
	public function searchCity($words){
		$result = $this->find('all',array('conditions'=>array("City.name  LIKE '".$words."%'"),'fields'=>array('City.id','City.name','City.state'),'order'=>array('City.name'),'limit'=>10));
		$cities=array();
		foreach($result as $val){
			$cities[]=array('id'=>$val['City']['id'],'label'=>$val['City']['name'],'state'=>$val['City']['state']);
		}
		return $cities;
	}
	function getCityId($words){
		$cityId='';
		$result = $this->find('first',array('conditions'=>array("City.name  = '".$words."'"),'fields'=>array('City.id')));
		if($result){
			$cityId=$result['City']['id'];
		}else{
			$this->save(array('name'=>$words));
			$cityId=$this->getLastInsertID();
		}
		return $cityId;
	}
}
