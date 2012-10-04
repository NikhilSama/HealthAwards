<?php
class City extends AppModel
{
   
	public $useTable = 'cities';

    public $recursive = -1;

    public $belongsTo = array('State' =>
       array('className'  => 'State',
             'conditions' => '',
             'order'      => '',
             'foreignKey' => 'stateId'
       ),
		'Country' =>
       array('className'  => 'Country',
             'conditions' => '',
             'order'      => '',
             'foreignKey' => 'countryId'
       )
    );
	function getCitiesList($stateId){
		return $this->find('list',array('conditions'=>array('City.stateId'=>$stateId),'fields'=>array('City.id','City.name')));
	}
}
?>