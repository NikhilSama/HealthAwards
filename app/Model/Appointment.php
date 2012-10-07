<?php
class Appointment extends AppModel {
	public $useTable = 'appointments';
	
	function getCalendarByRange($id,$doctorId){
		$row = array();
		try{
			$rows = $this->query("select Appointment.*, Patient.* from appointments Appointment inner join patients Patient on Appointment.patient_id = Patient.user_id where Appointment.id='".$id."' and Appointment.doctor_id='".$doctorId."'");
			
			if($rows) {
				$row = $rows[0];
				
			}
		}catch(Exception $e){
		}
		//pr($row);
		return $row;
	}
	/*function addCalendar($st, $et, $sub, $ade){
		$ret = array();
		try{
			$data['subject']=mysql_real_escape_string($sub);
			$data['starttime']=$this->php2MySqlTime($this->js2PhpTime($st));
			$data['endtime']=$this->php2MySqlTime($this->js2PhpTime($et));
			$data['isalldayevent']=mysql_real_escape_string($ade);
			$this->save($data);
			$ret['IsSuccess'] = true;
			$ret['Msg'] = 'add success';
			$ret['Data'] = $this->getLastInsertID();
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}*/


	function addDetailedCalendar($doctorId, $appointmentDetails){ 
			
		$ret = array();
		try{
			$data['doctor_id'] = $doctorId;
			$data['patient_id'] = $appointmentDetails['patient_id'];
			$data['patient_notify_sms'] = mysql_real_escape_string($appointmentDetails['patient_notify_sms']);
			$data['patient_notify_email'] = mysql_real_escape_string($appointmentDetails['patient_notify_email']);
			$data['doctor_notify_sms'] = mysql_real_escape_string($appointmentDetails['doctor_notify_sms']);
			$data['doctor_notify_email'] = mysql_real_escape_string($appointmentDetails['doctor_notify_email']);
			$data['treatments'] = mysql_real_escape_string($appointmentDetails['treatments']);
			$data['starttime'] = $this->php2MySqlTime($this->js2PhpTime($appointmentDetails['starttime']));
			$data['endtime'] = $this->php2MySqlTime($this->js2PhpTime($appointmentDetails['endtime']));
			$data['isalldayevent'] = mysql_real_escape_string($appointmentDetails['isalldayevent']);
			
			/*$data['subject']=mysql_real_escape_string($sub);
			$data['starttime']=$this->php2MySqlTime($this->js2PhpTime($st));
			$data['endtime']=$this->php2MySqlTime($this->js2PhpTime($et));
			$data['isalldayevent']=mysql_real_escape_string($ade);
			$data['treatments']=mysql_real_escape_string($dscr);
			$data['location']=mysql_real_escape_string($loc);
			$data['color']=mysql_real_escape_string($color);*/
			$this->save($data);
			$ret['IsSuccess'] = true;
			$ret['Msg'] = 'add success';
			$ret['Data'] = $this->getLastInsertID();
			
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	function listCalendarByRange($doctorId,$sd, $ed){
		$ret = array();
		$ret['events'] = array();
		$ret["issort"] =true;
		$ret["start"] = $this->php2JsTime($sd);
		$ret["end"] = $this->php2JsTime($ed);
		$ret['error'] = null;
		try{			
			$sql = "select * from `appointments` Appointment
			inner join patients PP on Appointment.patient_id=PP.user_id
			where Appointment.doctor_id='".$doctorId."' and `starttime` between '"
			.$this->php2MySqlTime($sd)."' and '". $this->php2MySqlTime($ed)."'";
			$handle = $this->query($sql);
			foreach($handle as $row){
				$ret['events'][] = array(
					$row['Appointment']['id'],
					$row['PP']['first_name']." ".$row['PP']['last_name'],
					$this->php2JsTime($this->mySql2PhpTime($row['Appointment']['starttime'])),
					$this->php2JsTime($this->mySql2PhpTime($row['Appointment']['endtime'])),
					$row['Appointment']['isalldayevent'],
					0,
					0,
					$row['PP']['first_name']." ".$row['PP']['last_name'],
					1,
					$row['PP']['phone'], 
					''
				);
			}
		}catch(Exception $e){
			$ret['error'] = $e->getMessage();
		}
		return $ret;
	}

	
	function updateCalendar($doctorId,$id, $st, $et){
		$ret = array();
		try{
			$data['starttime'] = $this->php2MySqlTime($this->js2PhpTime($st));
			$data['endtime'] = $this->php2MySqlTime($this->js2PhpTime($et));
			
			$this->updateAll($data,array('id'=>$id,'doctor_id'=>$doctorId));
			$ret['IsSuccess'] = true;
			$ret['Msg'] = 'Succefully';
			
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	function updateDetailedCalendar($doctorId,$id, $appointmentDetails){
		$ret = array();
			
		try{
			$data['doctor_id'] = $doctorId;
			$data['patient_id'] = mysql_real_escape_string($appointmentDetails['patient_id']);
			$data['patient_notify_sms'] = mysql_real_escape_string($appointmentDetails['patient_notify_sms']);
			$data['patient_notify_email'] = mysql_real_escape_string($appointmentDetails['patient_notify_email']);
			$data['doctor_notify_sms'] = mysql_real_escape_string($appointmentDetails['doctor_notify_sms']);
			$data['doctor_notify_email'] = mysql_real_escape_string($appointmentDetails['doctor_notify_email']);
			$data['treatments'] = "'".mysql_real_escape_string($appointmentDetails['treatments'])."'";
			$data['starttime'] = "'".$this->php2MySqlTime($this->js2PhpTime($appointmentDetails['starttime']))."'";
			$data['endtime'] = "'".$this->php2MySqlTime($this->js2PhpTime($appointmentDetails['endtime']))."'";
			$data['isalldayevent'] = mysql_real_escape_string($appointmentDetails['isalldayevent']);
			
			$this->updateAll($data,array('id'=>$id,'doctor_id'=>$doctorId));
		
			$ret['IsSuccess'] = true;
			$ret['Msg'] = 'Succefully';
			
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}

	function removeCalendar($doctorId,$id){
		$ret = array();
		try{
			$sql = "delete from `appointments` where doctor_id='".$doctorId."' and `id`=" . $id;
			$this->query($sql);
			$ret['IsSuccess'] = true;
			$ret['Msg'] = 'Succefully';
			
		}catch(Exception $e){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = $e->getMessage();
		}
		return $ret;
	}
	function listCalendar($doctorId,$day, $type){
		$phpTime = $this->js2PhpTime($day);
		switch($type){
			case "month":
				$st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
			break;
			case "week":
				//suppose first day of a week is monday 
				$monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
				$st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
				$et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
			break;
			case "day":
				$st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
				$et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
			break;
		}
		return $this->listCalendarByRange($doctorId,$st, $et);
	}

	function js2PhpTime($jsdate){
	  if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1){
		$ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
	  }else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
		$ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
	  }
	  return $ret;
	}

	function php2JsTime($phpDate){
		return date("m/d/Y H:i", $phpDate);
	}

	function php2MySqlTime($phpDate){
		return date("Y-m-d H:i:s", $phpDate);
	}

	function mySql2PhpTime($sqlDate){
		$arr = date_parse($sqlDate);
		return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);
	}
}
?>

<?php
App::uses('AppModel', 'Model');
/**
 * Appointment Model
 *
 * @property User $User
 */
class Appointment1 extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
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
		'is_all_day' => array(
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
		)
	);
}
