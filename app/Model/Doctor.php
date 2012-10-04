<?php
class Doctor extends AppModel {
    public $useTable="doctor_profile";
	
	public function updateProfile($doctorId,$fieldName,$value){
		$this->updateAll(array($fieldName=>"'".$value."'"),array('user_id'=>$doctorId));
		return ;
	}
	function get_doctor_session_vars($doctorId, $isProductSession=null, $supportUserId = null) {
         $userdetail = $this->findById($doctorId,array('user_id','name','education','awards','photo','last_login'));
		 $this->updateAll(array('last_login'=>'now()'),array('user_id'=>$doctorId));
		 return ($userdetail['Doctor']);
    }
}

?>