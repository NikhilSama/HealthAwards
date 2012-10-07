<?php
class Doctor extends AppModel {
    public $useTable="doctors";
	
	public function updateProfile($doctorId,$fieldName,$value){
		$this->updateAll(array($fieldName=>"'".$value."'"),array('user_id'=>$doctorId));
		return ;
	}
	function get_doctor_session_vars($doctorId, $isProductSession=null, $supportUserId = null) {
         $userdetail = $this->findById($doctorId,array('doctorId'=>'id','user_id','first_name','middle_name','last_name','email','image','last_login'));
		 $this->updateAll(array('last_login'=>'now()'),array('user_id'=>$doctorId));
		 return ($userdetail['Doctor']);
    }
}

?>