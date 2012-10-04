<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Lycos Contacts          						|	
// | 																		|	
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified

class lycos  extends clsContactImporter
{

public function ImportLycosContacts()
	{
		$arrContacts = array();  
		$userName=$this->strUserName;  
		@list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1)"; //setting browser type

		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w');  
		fclose($strCookieFile);
		
		$this->strCookieJar = realpath("$strCookieName");  
		$strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		fclose($strCookieJarFile);
		
		 // step 1  -- fetch login form
		$strURL = "https://registration.lycos.com/login.php";
	    $arrResult = $this->GetContacts($strURL,1);
		
		// step 2 -- get each postable data
		$postData="";
		preg_match_all("/<input(.*?)name='m_PR'(.*?)value='(.*?)'(.*?)>/", $arrResult, $matches);
		$postData .="m_PR=".@$matches[3][0]; 
		
		preg_match_all("/<input(.*?)name='m_E'(.*?)value='(.*?)'(.*?)>/", $arrResult, $matches);
		$postData .="&m_E=".@$matches[3][0];
		
		preg_match_all("/<input(.*?)name='m_WS'(.*?)value='(.*?)'(.*?)>/", $arrResult, $matches);
		$postData .="&m_WS=".@$matches[3][0];
		
		$postData .="&m_U=".urlencode($this->strUserName)."&m_P=".urlencode($this->strPassword)."&action=login";
		
		// step 3  --- do login
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,$strURL );
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$postData);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$strLoginResult = curl_exec($curl);
		
		 // step 4 -- get data from CSV file 
		$strURL ="http://mail.lycos.com/lycos/addrbook/ExportAddr.lycos?ptype=act&fileType=EXPRESS";
		$postData ="ftype=EXPRESS";
		
		 curl_setopt($curl, CURLOPT_URL,$strURL);
		 curl_setopt($curl, CURLOPT_POST,1);
		 curl_setopt($curl, CURLOPT_POSTFIELDS,$postData);
		 curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		 curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		 $strResult = curl_exec($curl);
		 curl_close($curl);
		 
		 @unlink ($strCookieName);
         //---------------------------------------------------- return the contacts
		 return $strResult;
		 
	}
function ImportContacts()
{
	$mycookie = TMP.$this->strUserName.'.cookie'; 
	$strContacts = $this->ImportLycosContacts();
	
	if($strContacts == '1')
	{
		@unlink($mycookie); // deleting cookie		
		return 1;
	}
	elseif($strContacts == '3')
	{
		@unlink($mycookie); // deleting cookie		
		return 3;
	}
	else
	{
		//WRITING THE RESULTS TO A CSV FILE ON THE SERVER
		$myFile = TMP.$this->strUserName;
		$fh = fopen($myFile,'w') or die("can't open file");
		fwrite($fh,$strContacts);
		fclose($fh);

		// CHECKING IF LOGIN WAS SUCCESSFUL - by search of the @ sign in the csv

		preg_match_all("/@/",$strContacts,$array_at);
		
		$at_sign = $array_at[0];
		
		if (empty($at_sign)) 
		{
			@unlink($myFile);//deleting csv file
			@unlink($mycookie); // deleting cookie
			return 3;
		}
		else
		{
			$display_array=array();
			// OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY
			$fp = fopen($myFile,"r");
			while (!feof($fp)) 
			{
				$data = fgetcsv($fp,4100,",");//this uses the fgetcsv function to store the quote info in the array $data
             	$dataname=(trim($data[3])!='') ? $data[3] : ''; // check for alias name
				$dataname=(trim($dataname)=='') ? $data[0].' '.$data[1].' '.$data[2] : $dataname;  // first name, middle name last name
                
                $email = @$data[4];		// collect email
                if (trim($dataname)=='')   // if name does not exists than dispaly email address
					$dataname = $email;
               
                if (trim($email)!='') 
				{
					    //remove none characters
						$email_nw = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
						$dataname_nw = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);
						$result = array('ContactsEmail' =>trim($email_nw),'ContactsName' =>trim($dataname_nw));
                        $display_array[] = $result;
				}
			}
			
			if(!empty($display_array))
			    unset($display_array[0]);
			
			@unlink($myFile);//deleting csv file
			@unlink($mycookie); // deleting cookie
		}
	}
	@unlink($myFile);//deleting csv file
	@unlink($mycookie); // deleting cookie
	
	if(empty($display_array))
		return 3;
	else
		return $display_array;
}
}
?>