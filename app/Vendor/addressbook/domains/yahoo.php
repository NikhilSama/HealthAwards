<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Yahoo Contacts          						|	
// | 																		|	
#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified

class yahoo extends clsContactImporter
{ 
	public function ImportYahooContacts()
	{
		$arrContacts = array();    
		$strDomainName = "http://yahoo.com/";    
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
		$strCookieName = TMP.$this->strUserName.'.cookie';
		$strCookieFile = fopen($strCookieName,'w');
		fclose($strCookieFile);
		$this->strCookieJar = realpath("$strCookieName");
		$strCookieJarFile = fopen($this->strCookieJar,'wb');
		fclose($strCookieJarFile);
		$strURL = "https://login.yahoo.com/config/mail?.intl=us";
		$arrLoginResult =$this->GetContacts($strURL,1);
		preg_match_all("/name=\".tries\" value=\"(.*?)\"/", $arrLoginResult, $R43BB41B52862F1BA2D9C274074D0C31C);
		$R567E196FE02BA1F867C8D7FB7099E5AA = $R43BB41B52862F1BA2D9C274074D0C31C[1][0];
		preg_match_all("/name=\".src\" value=\"(.*?)\"/", $arrLoginResult, $R8518FD4BC0DA31048BD649F3B066E6A4);
		$RD3B80590765F70E4A0B4AAB08087EEF0 = $R8518FD4BC0DA31048BD649F3B066E6A4[1][0];
		preg_match_all("/name=\".u\" value=\"(.*?)\"/", $arrLoginResult, $RC4A5B5E310ED4C323E04D72AFAE39F53);
		$R9492EA65068A5CDCF81944737D4A40B5 = $RC4A5B5E310ED4C323E04D72AFAE39F53[1][0];
		preg_match_all("/name=\".v\" value=\"(.*?)\"/", $arrLoginResult, $RA3D52E52A48936CDE0F5356BB08652F2);
		$R27506CA932BBAD563D1E72C2233997B2 = $RA3D52E52A48936CDE0F5356BB08652F2[1][0];
		preg_match_all("/name=\".challenge\" value=\"(.*?)\"/", $arrLoginResult, $R4A2D2C025B7EB2EFE6F269A970073156);
		$R2014047C857E8CA808A24F0CFF35E88C = $R4A2D2C025B7EB2EFE6F269A970073156[1][0];
		$strPostFields ='.tries='.$R567E196FE02BA1F867C8D7FB7099E5AA.'&.src='.$RD3B80590765F70E4A0B4AAB08087EEF0.'&.md5=&.hash=&.js=&.last=&promo=&.intl=us&.bypass=&.partner=&.u=6bu841h2d7p4o&.v=0&.challenge='.$R2014047C857E8CA808A24F0CFF35E88C.'&.yplus=&.emailCode=&pkg=&stepid=&.ev=&hasMsgr=1&.chkP=Y&.done=http://mail.yahoo.com&.pd=ym_ver%253d0&login='.$this->strUserName.'&passwd='.urlencode($this->strPassword);  $strURL = 'https://login.yahoo.com/config/login?';  
		$strResult =$this->DoLogin($strURL,$strPostFields,1);  

		// Check for Incorrect Login
		if(strstr($strResult, "Invalid ID or password."))
		{
			return 1;
		}
		else
		{
			preg_match_all("/replace\(\"(.*?)\"/", $strResult, $arrMatches);  
			$strURL = $arrMatches[1][0];        
			$strResult =$this->GetContacts($strURL,1); 
			$strURL = 'http://us.rd.yahoo.com/mail_us/pimnav/ab/*http://address.mail.yahoo.com';
			$strResult =$this->GetContacts($strURL,1);
			$strURL = 'http://address.mail.yahoo.com';
			$strResult =$this->GetContacts($strURL,1);
			preg_match_all("/rand=(.*?)\"/", $strResult, $arrMatches);
			if(isset($arrMatches[0][0])) {
				$strMatches = str_replace('"', '', $arrMatches[0][0]);
				$strURL = 'http://address.mail.yahoo.com/?1&VPC=import_export&A=B&.rand='.@$R114D989894EAA02BB031568A5730A57E;
				$strResult =$this->GetContacts($strURL,1);
				preg_match_all("/id=\"crumb1\" value=\"(.*?)\"/", $strResult, $arrMatches);
				$strMatches = $arrMatches[1][0];
			}
			IF (empty($strMatches))
			{        
				return 3;
			}
			ELSE
			{             
				$strPostFields ='.crumb='.$strMatches.'&VPC=import_export&A=B&submit%5Baction_export_yahoo%5D=Export+Now';
				$strURL = 'http://address.mail.yahoo.com/index.php';  
				$strResult =$this->DoLogin($strURL,$strPostFields,1);
				@unlink ($strCookieName);
				return $strResult;
			}
		}
	}
	
function ImportContacts()
{
	$mycookie = TMP.$this->strUserName.'.cookie'; 

	// import Yahoo contacts
	$strContacts = $this->ImportYahooContacts();

	if($strContacts == '1')
	{
		@unlink($mycookie);
		return 1;
	}
	elseif($strContacts == '3')
	{
		@unlink($mycookie);
		return 3;
	}
	else
	{
		//Writing Output To Csv File
					
		$myFile =  TMP.$this->strUserName.'.txt';
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $strContacts);
		fclose($fh);


		//Opening Csv File For Processing
		$fp = fopen ($myFile,"r");

		while (!feof($fp))
		{
			//this uses the fgetcsv function to store the quote info in the array $data
			$data = fgetcsv ($fp, 4100, ","); 



			$dataname = $data[0];

			IF (empty($dataname))
			{
				$dataname = $data[2];                 
			}

			IF (empty($dataname))
				$dataname = $data[3];                

			IF (empty($dataname))
				$dataname = "None";                 

			$email = $data[4];

			IF (empty($email))
			{  //Skip table if email is blank
			}
			ELSE
			{
				$email = $data[4];    

				IF ($dataname == "None")
					$dataname = $email;
				IF ($dataname != "First")
				{  
					// skiping table to remove first line of csv file
					//remove none characters
					$email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
					$dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);

					$result = array('ContactsEmail' => $email1,'ContactsName' => $dataname1);
					$display_array[] = $result;
				}
			}
		}
		@unlink($myFile);//deleting csv file
		@unlink($mycookie);
		if(empty($display_array))
			return 3;
		else
			return $display_array;
	}
}
}
?>