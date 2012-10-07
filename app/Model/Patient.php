<?php
App::uses('AppModel', 'Model');
/**
 * Patient Model
 *
 * @property User $User
 * @property City $City
 * @property PinCode $PinCode
 * @property Country $Country
 */
class Patient extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $recursive=0;
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'city_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pin_code_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'country_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PinCode' => array(
			'className' => 'PinCode',
			'foreignKey' => 'pin_code_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function seacrhQuery($doctorId,$words='',$sort=''){
		$where = 1;
		$orderby='';
		if($sort){
			$orderby ="order by ".$sort;
		}
		//# and pp.`doctor_id`='".$doctorId."' #AND  pp.`doctor_id`=app.`doctor_id`
		if($words){
			$where = "(pp.first_name LIKE '%".$words."%' OR pp.last_name LIKE '%".$words."%' OR pp.phone LIKE '%".$words."%'  OR pp.email LIKE '%".$words."%'  OR pp.address LIKE '%".$words."%' OR City.name LIKE '%".$words."%' OR PinCode.pin_code LIKE '%".$words."%' )";
		}
		$sql = "SELECT max(app.created) as lastAppointments, sum(if(app.`patient_id` is null,0,1)) as noOfAppointments,pp.email,pp.phone, pp.first_name, pp.last_name,pp.image,pp.`user_id`
		FROM  `patients` pp 
		Left join cities City on pp.city_id=City.id
		Left join pin_codes PinCode on PinCode.id=pp.pin_code_id
		Left JOIN `appointments` app  ON app.`patient_id`=pp.`user_id` 
		WHERE ".$where."
		
		GROUP BY pp.`user_id` ".$orderby;
		
		return $sql;
	}
	public function searchPatients($doctorId,$words){
		$where = 1;
		$patients = array();
		$orderby='order by pp.first_name,pp.last_name';
		// #and pp.`doctor_id`='".$doctorId."'
		if($words){
			$where = "(pp.first_name LIKE '%".$words."%' OR pp.last_name LIKE '%".$words."%' OR pp.phone LIKE '%".$words."%'  OR pp.email LIKE '%".$words."%'  OR pp.address LIKE '%".$words."%' OR City.name LIKE '%".$words."%' OR PinCode.pin_code LIKE '%".$words."%')";
		}
		$sql = "SELECT pp.user_id,pp.email, pp.first_name, pp.last_name, PinCode.pin_code, pp.`phone`,pp.image
		FROM  `patients` pp 
		Left join cities City on pp.city_id=City.id	
		Left join pin_codes PinCode on PinCode.id=pp.pin_code_id		
		WHERE ".$where."
		
		
		".$orderby." limit 20";
		$result = $this->query($sql);
		foreach($result as $val){
			$patients[]=array('id'=>$val['pp']['user_id'],'label'=>$val['pp']['first_name'].' '.$val['pp']['first_name'],'email'=>$val['pp']['email'],'mobile'=>$val['pp']['phone']);
		}
		
		return $patients;
	}
	public function getPatientInfo($doctorId,$patientId){//'doctor_id'=>$doctorId,
		
		return $this->find('first',array('conditions'=>array('user_id'=>$patientId),'fields'=>array()));
	}
	public function updatePatientInfo($doctorId,$patientId,$fieldName,$value){//,'doctor_id'=>$doctorId
		if(!$this->PatientValidation(array($fieldName=>$value))){
			$this->unbindModel( array('belongsTo' => array('User','City','PinCode','Country')) );
			
			if($fieldName == 'fullname') {
					$tmp = explode(" ",$value,2);
					$data['Patient']['first_name'] = $tmp[0];
					$data['Patient']['last_name'] = $tmp[1];
					$this->updateAll(array('first_name'=>"'".$tmp[0]."'",'last_name'=>"'".$tmp[1]."'"),array('user_id'=>$patientId));
			}else{
				$this->updateAll(array($fieldName=>"'".$value."'"),array('user_id'=>$patientId));
			}
		}
		return ;
	}
	function PatientValidation($data,$flag=null) {
		
		// Name field is blank
        if(isset($data['fullname']) && $data['fullname'] == '') {
			$this->invalidate('fullname');
			$errors['fullname'] = 'Please enter the name';
		}elseif(isset($data['fullname']) && preg_match('/[^a-z \.]/i',$data['fullname'])) {
			$this->invalidate('fullname');
			$errors['fullname']= 'Name should contain a-z characters';
		}
		
		// validate mobile number
		
		if(isset($data['phone']) && $data['phone'] != '' && (!preg_match(HEALTHOS_VALID_MOBILENUMBER,$data['phone']) || !$this->validMobileNumber($data['phone']))) {
			$this->invalidate('phone');
			$errors['phone'] = 'Invalid primary mobile  number';
		}
		
		if(isset($data['pin_code_id']) && $data['pin_code_id'] != '' && (!preg_match(HEALTHOS_VALID_PIN,$data['pin_code_id']) )) {
			$this->invalidate('pin_code_id');
			$errors['pin_code_id'] = 'Invalid  home pin';
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
	function addPatient($data) { //pr($data); die;
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
				if(!$data['Patient']['city_id']){$data['Patient']['city_id']=1;}
				if(!$data['Patient']['pin_code_id']){$data['Patient']['pin_code_id']=1;}
				if(!$data['Patient']['country_id']){$data['Patient']['country_id']=1;}
				
				if(isset($data['Patient']['fullname']) && $data['Patient']['fullname'] != '') {
					$tmp = explode(" ",$data['Patient']['fullname'],2);
					$data['Patient']['first_name'] = $tmp[0];
					$data['Patient']['last_name'] = $tmp[1];
				}
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
