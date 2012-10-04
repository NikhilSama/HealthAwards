<?php
class Country extends AppModel
{
   
    public $useTable = 'countries';
	function getCoutriesList(){
		return $this->find('list',array('conditions'=>array('Country.isActive'=>1),'fields'=>array('Country.id','Country.name')));
	}
}
?>