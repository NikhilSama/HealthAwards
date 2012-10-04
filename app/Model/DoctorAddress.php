<?php

class DoctorAddress extends AppModel {
   public $useTable="doctor_addresses";
   public $hasMany = array('DoctorTiming' =>
        array('className' => 'DoctorTiming',
            'conditions' => '',
            'order' => '',
            'dependent' => true,
            'foreignKey' => 'address_id',
            'type' => 'left',
			'fields'=>array('id','days','time_form','time_to','details')
        )
    );
	
	function getDoctorAddresses($doctorId){
		return $this->find('all',array('conditions'=>array('DoctorAddress.doctor_id'=>$doctorId,'DoctorAddress.isActive'=>1),'fields'=>array('DoctorAddress.id','DoctorAddress.address','DoctorAddress.city','DoctorAddress.pin')));
	}
	
	function getDoctorAddressById($doctorId,$addressId){
		return $this->find('first',array('conditions'=>array('DoctorAddress.id'=>$addressId,'DoctorAddress.doctor_id'=>$doctorId,'DoctorAddress.isActive'=>1),'fields'=>array('DoctorAddress.id','DoctorAddress.address','DoctorAddress.city','DoctorAddress.pin')));
	
	}
	
}
?>