<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Sapo Contacts          						    |	
// | 																		|	
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the username) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if username or password was not specified

class sapo  extends clsContactImporter
{
  public function ImportSapoContacts()
	{
	    $arrContacts = array();    
		$strDomainName = "http://mail.sapo.pt/login/";	//setting the site for refer
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";	//setting browser type
		$strCookieName = TMP.$this->strUserName.'.cookie';
		$strCookieFile = fopen($strCookieName,'w'); 
		fclose($strCookieFile);
		$this->strCookieJar = realpath("$strCookieName"); 
		$strCookieJarFile = fopen($this->strCookieJar,'wb');	//this opens the file and resets it to zero length
		fclose($strCookieJarFile);
		$strPostFields="imapuser=".$this->strUserName."&pass=".$this->strPassword;
		
		////////////////////////////// step - 1 ///////////////// Try to login /////////////////////////////////
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'http://mail.sapo.pt/imp/redirect.php');
		curl_setopt($ch, CURLOPT_USERAGENT,$this->strUserAgent);		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 4);		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch,CURLOPT_COOKIEJAR,$this->strCookieJar);
		curl_setopt($ch,CURLOPT_COOKIEFILE,$this->strCookieJar);
		
		$strResult = curl_exec($ch);
		// Check for Incorrect Login
		if(strstr($strResult, "logout_reason"))
		{
		    @unlink($strCookieName);
			return 1;
		}
		else
		{		
		///////////////////////////// to find the URL value /////////////////////////////
		preg_match_all("/Location: (.*)\r\nContent-Length:/s", $strResult, $matches);
		$strURL=trim($matches[1][0]);

		curl_setopt($ch, CURLOPT_URL, $strURL);
		curl_setopt($ch, CURLOPT_USERAGENT,$this->strUserAgent);		
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt ($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_HEADER, 1);
	  
	     $strResult = curl_exec($ch);
		
	     preg_match_all("/Location: (.*)\r\nContent-Length:/s", $strResult, $matches);
	   
	   // to get full URL Name in previous $url;
	     preg_match_all("/(.*)\/imp/s", $strURL, $matches1);
		
		
		/////////////////////////////// To download the csv file /////////////////////////////////
	    $strURL=trim($matches1[1][0]).'/turba/data.php/contactos?fn_ext=%2Fcontactos.csv';
	    $strPostFields="actionID=export&exportID=104&source=localsql";
		curl_setopt($ch, CURLOPT_URL, $strURL);
		curl_setopt($ch, CURLOPT_USERAGENT,$this->strUserAgent);		
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt ($ch, CURLOPT_POST, 3);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_HEADER, 1); 
		$strResult = curl_exec($ch);
		 @unlink($strCookieName);
		return  $strResult;
		}

	}
function ImportContacts()
{
	$strContacts = $this->ImportSapoContacts();
	unlink(TMP.$this->strUserName.'.cookie');
	if($strContacts == '1')
	{
		return 1;
	}
	// Write the results of contacts in a CSV file
	$myFile = TMP.$this->strUserName.'.csv';
	$fh = fopen($myFile,'w') or die("can't open file");
	fwrite($fh,$strContacts);
	fclose($fh);
//////// To check , whether contact list in not empty
	if (!strstr($strContacts,"@")) 
	{
	   @unlink($myFile);	//deleting csv file
		return 3;			// Error - No contacts found, check your login details and try again
	}
	else 
	{
		//Opening Csv File For Processing
		$display_array='';
		$fp = fopen($myFile,"r");
		while (!feof($fp)) 
		{
			$data = fgetcsv($fp,4100,","); //this uses the fgetcsv function to store the quote info in the array $data
			if(@strstr($data[1],"@"))
			{
			$email=trim($data[1]);
			$dataname= trim($data[0]);
			
					$result = array('ContactsEmail' => $email,'ContactsName' => $dataname);
					$display_array[] = $result;
		     }
		}
			
	}
		@unlink($myFile);	//deleting csv file

	if(empty($display_array))
		return 3;
	else
		return $display_array;
}
}
?>
















