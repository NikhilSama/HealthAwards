<?php
class State extends AppModel
{
	public $recursive = -1;

    public $belongsTo = array('Country' =>
       array('className'  => 'Country',
             'conditions' => '',
             'order'      => '',
             'foreignKey' => 'countryId'
       )
    );
	
	function getStatesList($countryId){
		return $this->find('list',array('conditions'=>array('State.isActive'=>1,'State.countryId'=>$countryId),'fields'=>array('State.id','State.name')));
	}
}
?>