<?php
/*--------------------------------------------------
 | CAST 128 Encryption/Decryption Class
 | By Devin Doucette
 | Copyright (c) 2004 Devin Doucette
 | Email: darksnoopy@shaw.ca
 +--------------------------------------------------
 | Email bugs/suggestions to darksnoopy@shaw.ca
 +--------------------------------------------------
 | This script has been created and released under
 | the GNU GPL and is free to use and redistribute
 | only if this copyright statement is not removed
 +--------------------------------------------------*/

class EncryptComponent extends Component {

    var $source = array('+','/','=','&','?','#');
    var $target = array('_p_','_s_','_e_','_a_','_q_','_h_'); // in future use __pls__
    
    var $key = "E4HD9h4DhS23DYfhHemkS3Nf";
    
    function __construct() {}

	function mnEncrypt($data, $encryption=MN_ENABLE_ENCRYPTION)
	{
		if(''==$data){
			return $data;
		}
        if ($encryption == 1) {
            $temp = $this->encrypt($data, CONCAT_CODE); 
            return str_replace($this->source, $this->target, $temp);
		} else {
            return '{'.$data.'}';
        }
	}

	function mnDecrypt($data, $encryption=MN_ENABLE_ENCRYPTION)
	{
		if(''==$data){
			return $data;
		}
        if ($encryption == 1) {
			$temp = str_replace($this->target, $this->source, $data);
			$temp = $this->decrypt($temp,CONCAT_CODE);
			return $temp;
		} else {
            return substr($data, 1, strlen($data)-2);
		}
	}

	function encrypt($text,$key=null) {
        // source: http://in2.php.net/crypt [RIJNDAEL_encrypt]
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);        
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $text, MCRYPT_MODE_ECB, $iv));
    }

	function decrypt($encrypted_text,$key=null) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
       	   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        //I used trim to remove trailing spaces
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted_text), MCRYPT_MODE_ECB, $iv));
    }


} ?>