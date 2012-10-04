<?php
class DoctorsController extends AppController {
	public $helpers = array('Html', 'Session','Calendar','Paginator','Util','Form');
	//public $layout=null;
	public $components = array('Email','RequestHandler','Upload');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Appointment','Patient','Doctor','DoctorContact','DoctorAddress');
	
	public function my_profile(){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		//$doctorId=1;
		$address = $this->DoctorAddress->getDoctorAddresses($doctorId);
		$contacts=$this->DoctorContact->getDoctorContacts($doctorId);
		$this->set('address',$address);
		$this->set('contacts',$contacts);
		$this->set('user',$user);
	}
	public function update_contact(){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		$tmp = explode('-',$this->data['field_name']);
		$contactId = $tmp[1];
		$field_name = $tmp[0];
		if($this->DoctorContact->hasField($field_name)){
			$this->DoctorContact->updateContact($doctorId,$contactId,$field_name,trim($this->data['value']));
			echo ($this->data['value']);die;
		}
		die;
	}
	public function delete_contact($contactId){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		$this->DoctorContact->deleteContact($doctorId,$contactId);
		die;
	}
	public function add_contact(){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		echo $this->DoctorContact->addContact($doctorId);
		die;
	}
	public function update_profile(){ 
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		if($this->Doctor->hasField($this->data['field_name'])){
			$this->Doctor->updateProfile($doctorId,$this->data['field_name'],trim($this->data['value']));
			if($this->Session->check('User.userInfo.'.$this->data['field_name'])){
				$this->Session->write('User.userInfo.'.$this->data['field_name'], trim($this->data['value']));
			}
			echo ($this->data['value']);die;
		}
		
	}
	function update_photo(){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		$destination = realpath('../../app/webroot/img/doctors_pics/') . '/';
		$file = $_FILES['myfile'];
		// upload the image using the upload component
		$result = $this->Upload->upload($file, $destination, null, array('type' => 'resizecrop', 'size' => array('200', '150'), 'output' => 'jpg'),array('jpg','jpeg','gif','JPG','JPEG'));

		if ($this->Upload->result){
		
			$this->Doctor->updateProfile($doctorId,'photo',trim($this->Upload->result));
			//if($this->Session->check('User.userInfo.photo')){
				$this->Session->write('User.userInfo.photo', trim($this->Upload->result));
			//}
			$info['Patient']['photo'] = $this->Upload->result;
			echo "/img/doctors_pics/".$this->Upload->result;
		} else {
			// display error
			$errors = $this->Upload->errors;
			pr($errors);
		}
		die;
	}
	function manage_timings($addressId=null){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		$address = $this->DoctorAddress->getDoctorAddresses($doctorId);
		if($addressId){
			$selectedAddress = $this->DoctorAddress->getDoctorAddressById($doctorId,$addressId);
			
			$this->set('selectedAddress',$selectedAddress);
		}
		$this->set('address',$address);
		
	}
	function dashboard(){
	}
	
	function calendar(){
	
	}
	function edit_calendar($id=null){
		$this->layout=null;
		if(isset($_GET['start']) && strtotime( $_GET['start'])){
			$start = date('Y-m-d h:i:s',strtotime( $_GET['start']));//		10/3/2012 03:00
			$this->set('startTime',$start);
		}
		if(isset($_GET['start']) && strtotime( $_GET['start'])){
			$end = date('Y-m-d h:i:s',strtotime($_GET['end']));// => 10/3/2012 04:00
			$this->set('endTime',$end);
		}
    
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		if($id){
			$event = $this->Appointment->getCalendarByRange($id,$doctorId);
			
			if($event)
			$this->set('event',$event);
		}
	}
	function calendar_datafeed($method=null){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		$ret = array();
		switch ($method) {
			/*case "add":
				$ret = $this->Appointment->addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
				break;*/
			case "list":
				$ret = $this->Appointment->listCalendar($doctorId,$_POST["showdate"], $_POST["viewtype"]);
				break;
			case "update":
				$ret = $this->Appointment->updateCalendar($doctorId,$_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
				break; 
			case "remove":
				$ret = $this->Appointment->removeCalendar( $doctorId,$_POST["calendarId"]);
				break;
			case "adddetails":
				$st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				$et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
				$appointmentDetails['patient_notify_sms'] = isset($_POST['patient_notify_sms'])?1:0;
				$appointmentDetails['patient_notify_email'] = isset($_POST['patient_notify_email'])?1:0;
				$appointmentDetails['doctor_notify_sms'] = isset($_POST['doctor_notify_sms'])?1:0;
				$appointmentDetails['doctor_notify_email'] = isset($_POST['doctor_notify_email'])?1:0;
				$appointmentDetails['treatments'] = $_POST['treatments'];
				$appointmentDetails['patient_id'] = $_POST['patient_id'];
				$appointmentDetails['starttime'] = $st;
				$appointmentDetails['endtime'] = $et;
				$appointmentDetails['isalldayevent'] = isset($_POST["isalldayevent"])?1:0;
				if(isset($_GET["id"])){
					$appointmentDetails['patient_id'] = $_GET["id"];
					$ret = $this->Appointment->updateDetailedCalendar($doctorId,$_GET["id"], $appointmentDetails);
				}else{
					$ret = $this->Appointment->addDetailedCalendar($doctorId,$appointmentDetails);
				}        
				break; 


		}
		echo json_encode($ret); die;
	}
	function patients_list(){
		$sortTypeArr=array(1=>array('sName'=>'ASC','dName'=>'Acending'),2=>array('sName'=>'DESC','dName'=>'Decending'));
		$sortByArr=array(1=>array('cName'=>'pp.name','dName'=>'Name'),2=>array('cName'=>'lastAppointments','dName'=>'Last Visit'),3=>array('cName'=>'pp.created','dName'=>'Last Added'));
		
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		$this->Patient->recursive = 0;
		$limit=10;
		$page=1;
		$sort = $words ='';
		if(isset($_POST['searchword']) && trim($_POST['searchword'])){
			$words= trim($_POST['searchword']);
		}
		
		if(isset($_POST['sortType']) && isset($sortTypeArr[$_POST['sortType']]) && isset($_POST['sortBy'])  && isset($sortTypeArr[$_POST['sortBy']])){
			$sort = $sortByArr[$_POST['sortBy']]['cName']." ".$sortTypeArr[$_POST['sortType']]['sName'];
		}else{
			$sort = $sortByArr[1]['cName']." ".$sortTypeArr[1]['sName'];
		}
		
		
		$sql=$this->Patient->seacrhQuery($doctorId,$words,$sort);
		
		$this->modelClass = 'Paging';
        $this->paginate=array('limit' =>$limit, 'page' => $page);
        $patients = $this->paginate(null,array($sql));

		$this->set('patients', $patients); // set the view variable
		$this->set('sortTypeArr', $sortTypeArr); // set the view variable
		$this->set('sortByArr', $sortByArr); // set the view variable

		if ($this->RequestHandler->isAjax()) {  
			$this->render('/doctors/ajax_patients_paging');  // Render a special view for ajax pagination
			return;  // return the ajax paginated content without a layout
		}
	}
	
	function add_patient($patientId=null){
		$this->layout=null;
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		if($patientId){	
			$patientInfo = $this->Patient->getPatientInfo($doctorId,$patientId);
			$this->set('patientInfo',$patientInfo);
			if($patientInfo){
				$this->render('edit_patient');return;
			}
		}
		if (!empty($this->request->data)) { 
			$info = $this->request->data;
			// set the upload destination folder
			$destination = realpath('../../app/webroot/img/patient_pics/') . '/';

			// grab the file
			$file = $info['Patient']['photo'];
			// upload the image using the upload component
			$result = $this->Upload->upload($file, $destination, null, array('type' => 'resizecrop', 'size' => array('50', '50'), 'output' => 'jpg'),array('jpg','jpeg','gif','JPG','JPEG'));
			//pr($this->Upload->result);
			//pr($result);die;
			if ($this->Upload->result){
				$info['Patient']['photo'] = $this->Upload->result;
			} else {
				// display error
				$errors = $this->Upload->errors;
			}
			if(!isset($errors)){
			$info['Patient']['doctor_id']=$doctorId;
			$userids = $this->Patient->addPatient($info);
            $userid = $userids['userid'];
            if ($userid != 0) {
                if (isset($userids['commit']) && $userids['commit'] == 1) {
                    // **** This code is using for campaign conversion tracking by different SEOs ************
                    
                    /*$data['data']['password'] = $this->data['User']['password'];
                    $data['data']['email'] = $this->data['Patient']['email'];
                    $data['data']['username'] = '';
					$data['data']['fullname'] = $this->data['Patient']['name'];

                    $data['data']['subject'] = "Welcome to the world of testing.com";
                    $domainName = 'http://' . $_SERVER['HTTP_HOST'] . '/';
                    $data['data']['url'] = $domainName;
                    
                    $template = 'register_patient';
                    $this->sendEmail($this->data['User']['email'], $data['data']['subject'], $template , $data['data']);
                                        
                    */
                    $redirectUrl = '/doctors/patients_list/';
                    $this->Session->setFlash('', 'flash', array('Patient add succesfully'), 'flash');
                    
                    $this->redirect($redirectUrl);
                    exit();
                } else {
                    $this->request->data['User']['password'] = $password;
                }
            } else {
                $this->set('errors', $userids);
				unset($userids['userid']);
				$this->Session->setFlash('', 'flash', $userids, 'flash');
            }
			}else{
			$this->Session->setFlash('', 'flash', $errors, 'flash');
			}
		}
		
	}
	public function update_patient_info(){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		if($this->Patient->hasField($this->data['field_name'])){
			$this->Patient->updatePatientInfo($doctorId,$this->data['patient_id'],$this->data['field_name'],trim($this->data['value']));
			echo ($this->data['value']);die;
		}
	}
	public function patient_search_json(){
		$user = $this->_checkDoctorSession();
		$doctorId=$user['id'];
		$patients = $this->Patient->searchPatients($doctorId,$_GET['term']);
		echo $this->array2json($patients);
		die;
	}
}
