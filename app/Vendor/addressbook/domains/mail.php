<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Mail.com Contacts          						|	
// | 																		|	
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified
class mail extends clsContactImporter
{ 
public function ImportMailContacts()
	{
		//------------------------------------------------------------------MAIL START
		$arrContacts = array();  
		$userName=$this->strUserName;  
		@list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		
		$strDomainName = "http://mail.com/";	//setting the site for refer
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";	//setting browser type
		
		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w');  
		fclose($strCookieFile);
		
		$this->strCookieJar = realpath("$strCookieName");  
		$strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		fclose($strCookieJarFile);   
		
		
		//---------------------------------------------------STEP 1
		$strURL = "http://www.mail.com"; 
		$arrLoginResult = $this->GetContacts($strURL,1);
		
		//---------------------------------------------------STEP 2
		$strPostFields = 'login='.$userName.'&password='.$this->strPassword.'&redirlogin=1&siteselected=normal';
		$strURL = 'http://www2.mail.com/scripts/common/proxy.main?signin=1&lang=us';
		$strResult = $this->DoLogin($strURL,$strPostFields,1,0);
		
		preg_match_all("/url=(.*?)\/templates/", $strResult, $arrMatches);
		$strBase = @$arrMatches[1][0];
		//---------------------------------------------------Open Address Book
		$strURL = $strBase.'/scripts/addr/addressbook.cgi?showaddressbook=1';
		$strResult = $this->GetContacts($strURL,1);
	    preg_match_all("/ob=(.*?)&gab=1/", $strResult, $arrMatches); 
		$strOb = @$arrMatches[1][1];
       //---------------------------------------------------Open Address Book
		$strURL = $strBase.'/scripts/addr/external.cgi?.ob='.$strOb.'&gab=1';
		$strResult = $this->GetContacts($strURL,1);
		
		//---------------------------------------------------Export Address Book in CSV
		$strPostFields ='showexport=showexport&action=export&format=csv';
		$strURL = $strBase.'/scripts/addr/external.cgi?.ob='.$strOb.'&gab=1';
		$strResult = $this->DoLogin($strURL,$strPostFields,1,0);
        @unlink ($strCookieName);
        //---------------------------------------------------- return the contacts
		return $strResult;
	}
	
function ImportContacts()
{
	$mycookie = TMP.$this->strUserName.'.cookie'; 
	// make an object
	//$objContactImporter = new clsContactImporter($login,$passwd);

	// import Mail.com contacts
	$strContacts = $this->ImportMailContacts();
	
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
		$myFile = TMP.$this->strUserName.'.txt';
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
			// OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY
			$fp = fopen($myFile,"r");
			while (!feof($fp)) 
			{
				$data = fgetcsv($fp,4100,",");	//this uses the fgetcsv function to store the quote info in the array $data
                $dataname=(trim($data[3])!='') ? $data[3] : ''; // check for alias name 
                $dataname=(trim($dataname)=='') ? $data[0].' '.$data[1].' '.$data[2] : $dataname;  // first name, middle name last name
              
               $email = $data[4];		// collect email

               if (trim($dataname)=='')   // if name does not exists than dispaly email address
					$dataname = $email;

				if (trim($email)!='') 
				{
					   //remove none characters
						$email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
						$dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);
						$result = array('ContactsEmail' =>trim($email1),'ContactsName' => trim($dataname1));

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