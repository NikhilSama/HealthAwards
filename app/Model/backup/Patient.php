<?php

class Patient extends AppModel {
   public $useTable="patient_profile";
   
	function seacrhQuery($doctorId,$words='',$sort=''){
		$where = 1;
		$orderby='';
		if($sort){
			$orderby ="order by ".$sort;
		}

		if($words){
			$where = "(pp.name LIKE '%".$words."%' OR pp.mobile_primary LIKE '%".$words."%' OR pp.mobile_wife LIKE '%".$words."%' OR pp.mobile_home LIKE '%".$words."%' OR pp.email_primary LIKE '%".$words."%' OR pp.email_wife LIKE '%".$words."%' OR pp.address_home LIKE '%".$words."%' OR pp.city_home LIKE '%".$words."%' OR pp.pin_home LIKE '%".$words."%' OR pp.address_work LIKE '%".$words."%' OR pp.city_work LIKE '%".$words."%' OR pp.pin_work LIKE '%".$words."%')";
		}
		$sql = "SELECT max(app.created) as lastAppointments, sum(if(app.`patient_id` is null,0,1)) as noOfAppointments,pp.email_primary, pp.name, pp.`pin_work`, pp.`mobile_primary`,pp.photo,pp.`user_id`
		FROM  `patient_profile` pp 
		Left JOIN `appointments` app  ON app.`patient_id`=pp.`user_id` AND  pp.`doctor_id`=app.`doctor_id`
		WHERE ".$where."
		 and pp.`doctor_id`='".$doctorId."'
		GROUP BY pp.`user_id` ".$orderby;
		
		return $sql;
	}
	public function searchPatients($doctorId,$words){
		$where = 1;
		$patients = array();
		$orderby='order by pp.name';
		if($words){
			$where = "(pp.name LIKE '%".$words."%' OR pp.mobile_primary LIKE '%".$words."%' OR pp.mobile_wife LIKE '%".$words."%' OR pp.mobile_home LIKE '%".$words."%' OR pp.email_primary LIKE '%".$words."%' OR pp.email_wife LIKE '%".$words."%' OR pp.address_home LIKE '%".$words."%' OR pp.city_home LIKE '%".$words."%' OR pp.pin_home LIKE '%".$words."%' OR pp.address_work LIKE '%".$words."%' OR pp.city_work LIKE '%".$words."%' OR pp.pin_work LIKE '%".$words."%')";
		}
		$sql = "SELECT pp.user_id,
		
		pp.email_primary, pp.name, pp.`pin_work`, pp.`mobile_primary`,pp.photo
		FROM  `patient_profile` pp 
		
		WHERE ".$where."
		 and pp.`doctor_id`='".$doctorId."'
		
		".$orderby." limit 20";
		$result = $this->query($sql);
		foreach($result as $val){
			$patients[]=array('id'=>$val['pp']['user_id'],'label'=>$val['pp']['name'],'email'=>$val['pp']['email_primary'],'mobile'=>$val['pp']['mobile_primary']);
		}
		
		return $patients;
	}
	public function getPatientInfo($doctorId,$patientId){
		return $this->find('first',array('conditions'=>array('doctor_id'=>$doctorId,'user_id'=>$patientId),'fields'=>array()));
	}
	public function updatePatientInfo($doctorId,$patientId,$fieldName,$value){
		$this->updateAll(array($fieldName=>"'".$value."'"),array('user_id'=>$patientId,'doctor_id'=>$doctorId));
		return ;
	}
	function PatientValidation($data,$flag=null) {
		
		// Name field is blank
        if(isset($data['name']) && $data['name'] == '') {
			$this->invalidate('name');
			$errors['name'] = 'Please enter the name';
		}elseif(isset($data['name']) && preg_match('/[^a-z \.]/i',$data['name'])) {
			$this->invalidate('name');
			$errors['name']= 'Name should contain a-z characters';
		}
		
		// validate mobile number
		
		if(isset($data['mobile_primary']) && $data['mobile_primary'] != '' && (!preg_match(HEALTHOS_VALID_MOBILENUMBER,$data['mobile_primary']) || !$this->validMobileNumber($data['mobile_primary']))) {
			$this->invalidate('mobile_primary');
			$errors['mobile_primary'] = 'Invalid primary mobile  number';
		}
		
		if(isset($data['mobile_wife']) && $data['mobile_wife'] != '' && (!preg_match(HEALTHOS_VALID_MOBILENUMBER,$data['mobile_wife']) || !$this->validMobileNumber($data['mobile_wife']))) {
			$this->invalidate('mobile_wife');
			$errors['mobile_wife'] = 'Invalid wife mobile  number';
		}
        if(isset($data['mobile_home']) && $data['mobile_home'] != '' && (!preg_match(HEALTHOS_VALID_MOBILENUMBER,$data['mobile_home']) || !$this->validMobileNumber($data['mobile_home']))) {
			$this->invalidate('mobile_home');
			$errors['mobile_home'] = 'Invalid home mobile  number';
		}
		
		if(isset($data['pin_home']) && $data['pin_home'] != '' && (!preg_match(HEALTHOS_VALID_PIN,$data['pin_home']) )) {
			$this->invalidate('pin_home');
			$errors['pin_home'] = 'Invalid  home pin';
		}
        if(isset($data['pin_work']) && $data['pin_work'] != '' && (!preg_match(HEALTHOS_VALID_PIN,$data['pin_work']) )) {
			$this->invalidate('pin_work');
			$errors['pin_work'] = 'Invalid work pin';
		}
        if(isset($errors))
			return $errors;
	}
	function validMobileNumber($mobile,$len=null){
		if(!$len)
			$len = 7;
		if ($len) {
            $numbers = "0123456789";
            $descending   = "9876543210";
            $start   = $len - 1;
            $seq     = "_" . substr($mobile,0, $start);
            $mobile_count=strlen($mobile);
			for ($i = $start; $i < $mobile_count; $i++) {
				$seq = substr($seq,1).$mobile[$i];
				if (strpos($numbers,$seq)!==false || strpos($descending,$seq)!==false) {
					return false;
				}
			}
		}
		return true;
	}
	function addPatient($data) {
        $errors = array();
        $userid = 0;
		
        $patientErrors = $this->PatientValidation($data['Patient'], 1);

       if (isset($patientErrors))
            $errors = $patientErrors;
			
        $password = 'paas'.time();
        $encryptedpassword = md5($password); // generate encoded password...
        $data['User']['password'] = $encryptedpassword;
		$data['User']['username'] ='ass'.time();
		$data['User']['role'] = 2;
		 App::import('model', 'User');
                $user = new User();
        if (count($errors) == 0) {
            $user->begin(); // Start Transaction queries
            if ($user->save($data['User'])) {
                $userid = $user->getLastInsertId();
                $errors['userid'] = $userid;
		       
                $data['Patient']['user_id'] = $userid;
                if ($this->save($data)) {
                    $user->commit(); // Persist the data
                    $errors['commit'] = 1;
                   
                } else {
                    $user->rollback();
                    $errors['commit'] = 0;
                }
            }
        }
        if ($userid > 0) {
            return $errors;
        } else {
            $errors['userid'] = 0;
            return $errors;
        }
    }
}
?>