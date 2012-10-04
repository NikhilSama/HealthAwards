<?php
//  
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Class to import the contacts from other sites  						|	
// | Base Class																		|	
// +------------------------------------------------------------------------+
class clsContactImporter  
{
	public $strUserName;
    public $strPassword;
    public $strURL;
	public $strPostFields;
	public $strFollowLocation;
	public $strCookieJar;
	public $strUserAgent;
	public $strDomainName;
	public $strCookieName;
	public $strCookieFile;
	public $strCookieJarFile;
	public $strPPFTValue;
	public $strPPSXValue;
	public $strPwdPadValue;
	public $strPostData;
	public $strResult;
	public $strBase;
	public $strOb;
	public $strLoginOptionsValue;
	public $strMatches;
	public $strRefererURL;
	public $strLiveMailURL;
	public $strTempURL;
	public $arrContacts = array();
	public $arrLoginResult = array();
	public $arrPPFT = array();
	public $arrPPSX = array();
	public $arrPwdPad = array();
	public $arrPostData = array();
	public $arrLoginOptions = array();
	public $arrMatches = array();

	public function __construct($pstrUserName, $pstrPassword)
	{
		$this->strUserName = trim($pstrUserName);
		$this->strPassword = trim($pstrPassword);
	}

	public function DoLogin($pstrURL,$pstrPostFields,$pstrFollowLocation)
	{
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,$pstrURL);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$pstrPostFields);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl,CURLOPT_COOKIEJAR,$this->strCookieJar);
		curl_setopt($curl,CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION,$pstrFollowLocation);
		curl_setopt($curl,CURLOPT_USERAGENT, $this->strUserAgent);
		$strResult = curl_exec($curl);
		curl_close($curl);
		

		return $strResult; 
	}

	public function GetContacts($pstrURL,$pstrFollowLocation)
	{
		$curl=curl_init(); 
		curl_setopt($curl,CURLOPT_URL,$pstrURL);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false); 
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl,CURLOPT_COOKIEJAR,$this->strCookieJar);
		curl_setopt($curl,CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION,$pstrFollowLocation);
		curl_setopt($curl,CURLOPT_USERAGENT, $this->strUserAgent);

		$strResult = curl_exec($curl); 
		curl_close($curl);
        return $strResult;
	}
 }

   #parse_emails needs to be included to be able to get the emails
	function parse_emails($str)
	{
	  $matches = array();
		preg_match('/<span>Email 1:<\/span> <span>([^<]*)<\/span>/si', $str, $matches) || preg_match('/<span>Primary Email:<\/span> <span>([^<]*)<\/span>/si', $str, $matches);
	  return @$matches[1];
	}
   
   #read_header is essential as it processes all cookies and keeps track of the current location url
   #leave unchanged, include it with get_contacts
  
   function read_header($ch, $string)
     {
			global $location;
			global $cookiearr;
			global $ch;
		  	$length = strlen($string);
			if(!strncmp($string, "Location:", 9))
			{
			  $location = trim(substr($string, 9, -1));
			}
			if(!strncmp($string, "Set-Cookie:", 11))
			{
			  $cookiestr = trim(substr($string, 11, -1));
			  $cookie = explode(';', $cookiestr);
			  $cookie = explode('=', $cookie[0]);
			  $cookiename = trim(array_shift($cookie)); 
			  $cookiearr[$cookiename] = trim(implode('=', $cookie));
			}
			$cookie = "";
	
			if(trim($string) == "") 
			{
			 if(is_array($cookiearr))
			  foreach($cookiearr as $key => $value)
			  {
				$cookie .= "$key=$value; ";
			  }
			  curl_setopt($ch, CURLOPT_COOKIE, $cookie);
			}
	     	return $length;
}
?>