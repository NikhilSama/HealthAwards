<?php
class SendsmsComponent extends Component {
    
    function __construct(ComponentCollection $Collection, $settings = array()) {}

	public function send(array $messageArr) {
		$data ="%3C?xml%20version=%221.0%22%20encoding=%22ISO-8859-1%22?%3E%3C!DOCTYPE%20MESSAGE%20SYSTEM%20%22http://127.0.0.1/psms/dtd/messagev12.dtd%22%20%3E%3CMESSAGE%20VER=%221.2%22%3E%3CUSER%20USERNAME=%22".MN_VFIRST_USERNAME."%22%20PASSWORD=%22".MN_VFIRST_PASSWORD."%22/%3E";
		
		
		

	   $ret=array();
	   foreach ($messageArr as $key=>$val){
			$user_mobile_number = str_replace(array('_','-',')','(','+',' '),array('','','','','',''),$val['mobile'])
			$user_mobile_number = substr($user_mobile_number,-12);
			
			if(!is_numeric($user_mobile_number))
				$user_mobile_number = '91'.substr($mobileNo,-10);		
			
			$message = str_replace(array('%', '*', '#', '<','>', '+', '#13#10', ' '), array('%25', '%2A', '%23', '%3C', '%3E', '%2B', '%0D%0A', '%20'),$val['message']);

			$data ="%3CSMS%20%20UDH=%220%22%20CODING=%221%22%20TEXT=%22".$message."%22%20PROPERTY=%220%22%20ID=%221%22%3E%3CADDRESS%20FROM=%22".MN_VFIRST_FROM."%22%20TO=%22".$user_mobile_number."%22%20SEQ=%221%22%20TAG=%22some%20clientside%20random%20data%22%20/%3E%3C/SMS%3E";

	   }	
	   	$data .="%3C/MESSAGE%3E";
		$url="http://api.myvaluefirst.com/psms/servlet/psms.Eservice2?data=".$data."&action=send";
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
		$xml=simplexml_load_string($data);

		if(isset($xml->GUID)){
			$arr=(array)$xml->GUID;
			if(isset($arr['@attributes'])){
				return true;
				
			}
		}
        return false;
   }
   	
 
}
?>
