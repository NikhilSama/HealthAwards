<?php
class DoctorContact extends AppModel {
    public $useTable="doctor_contacts";
	
	public function getDoctorContacts($doctorId){
		return $this->find('all',array('conditions'=>array('doctor_id'=>$doctorId,'isActive'=>1),'fields'=>array('id','contact_type','mobile','email')));
	}	
	public function updateContact( $doctorId,$contactId, $fieldName,$value){
		$this->updateAll(array($fieldName=>"'".$value."'"),array('doctor_id'=>$doctorId,'id'=>$contactId));
		return ;
	}
	public function deleteContact($doctorId,$contactId){
		$this->deleteAll(array('doctor_id'=>$doctorId,'id'=>$contactId));
		return ;
	}
	public function addContact($doctorId){
		$this->save(array('doctor_id'=>$doctorId,'isActive'=>1));
		return $this->getLastInsertID();
	}
}

?>