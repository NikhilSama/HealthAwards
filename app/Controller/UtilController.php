<?php
class UtilController extends AppController {
	public $uses = array('User', 'Paging','Country','PinCode','City');
	public $helpers = array('Html','Form','Ajax','Javascript','Util');
	public $components = array('Encrypt','Cookie','Session','Email','RequestHandler');
	
	public function beforeFilter() {
		parent::beforeFilter();		
	}
	function city_search_json(){
		$cities = $this->City->searchCity($_GET['term']);
		echo $this->array2json($cities);
		die;
	}
	function country_search_json(){
		$countries = $this->Country->searchCountry($_GET['term']);
		echo $this->array2json($countries);
		die;
	}
	function pincode_search_json(){
		$pincodes = $this->PinCode->searchPinCode($_GET['term']);
		echo $this->array2json($pincodes);
		die;
	}
	/*public function gat_state_list($country,$divId){
		$statesList = $this->State->getStatesList($country);
		$statesList = array('0'=>'Select State') + $statesList;
		echo "<select name='data[UserDetail][city]' id='UserDetailCity' onchange='changeCity(this.value,\"".$divId."\")'>";
		foreach ($statesList as $key =>$val){
			echo "<option value='".$key."'>".$val."</option>";
		}
		echo "</select>";
		die;
	}
	public function gat_city_list($stateId){
		$citiesList = $this->City->getCitiesList($stateId);
		$citiesList = array('0'=>'Select City') + $citiesList;
		echo "<select name='data[UserDetail][city]' id='UserDetailCity'>";
		foreach ($citiesList as $key =>$val){
			echo "<option value='".$key."'>".$val."</option>";
		}
		echo "</select>";
		die;
	}
	public function checkAvalibility(){
		if(isset($_POST['email']))
			$email=$_POST['email'];

		$errorArr = $this->User->userValidation(array('email' => trim($email)), 1);
        if (isset($errorArr['email'])) {
            $error = $errorArr['email'];
        }
        if(isset($error)){
            echo '<span class="text10 errMsg">' . $error . '</span>';
			exit();
        }
		echo 'success';
        exit();
	}*/
	
	public function getUserImage($src=''){
		$src = "../webroot/img/patient_pics/".$_POST['src'];
		$con=file_get_contents($src);
		$en=base64_encode($con);
		$mime='image/gif';
		echo $binary_data='data:' . $mime . ';base64,' . $en ;
		die;
	}
}
?>