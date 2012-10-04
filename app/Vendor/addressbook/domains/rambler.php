<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Rambler.ru Contacts          						|	
// | 																		|	
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified
class rambler  extends clsContactImporter
{
	public function ImportRamblerContacts()
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
		
		// step 1  --- Login form
		$strURL = "http://mail.rambler.ru/script/auth.cgi";
	    $strResult = $this->GetContacts($strURL,1);
		
		$strLoginURL = "http://mail.rambler.ru/script/auth.cgi?mode=login";
	    $strPostFields  = "from=&back=http://mail.rambler.ru&url=7&icqscreen=&login=".$this->strUserName."&passw=".$this->strPassword;
	    $strLoginResult = $this->DoLogin($strLoginURL,$strPostFields,1);
		
		// check for valid login
		preg_match_all('/<title>(.*?)<\/title>/si', $strLoginResult, $matches);
		$strLogin=@$matches[1][0];
		if(stristr($strLogin,$userName)==FALSE){
		    @unlink ($strCookieName);
		    return 1;
		 }  
		
		$strAddressBookLoginURL  = "http://mail.rambler.ru/mail/contacts.cgi";
		$strAddressBookResult = $this->GetContacts($strAddressBookLoginURL,1);
		
		preg_match('/<form name="contacts-form" method="post">(.*?)<\/form>/si', $strAddressBookResult, $matches);
		$strFormContent=@$matches[0];
		
		$arrTableTr=explode("</tr>",$strFormContent);
		 #parse all the table tr elements
  		 preg_match_all('/<tr class="vcard">(.*?)<\/tr>/si', $strFormContent, $matches);
		 $strTableTr = @$matches[0];
		 foreach($strTableTr as $strTr){
		         preg_match_all('/<a class="email"(.*?)>(.*?)<\/a>/si', $strTr, $matchMail);
				 $email=@$matchMail[2][0];
				
				 preg_match_all('/<td class="fn">(.*?)<\/td>/si', $strTr, $matchName);
				 $name=@$matchName[1][0];
				
				 $email = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
				 $name =  preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$name);
				 
				 if($email!="")
					    $arrResult[]=array("ContactsEmail"=>$email,"ContactsName"=>$name);
		}
		
		@unlink ($strCookieName);
         //---------------------------------------------------- return the contacts
		return $arrResult;
		 
	}

function ImportContacts()
{
	$mycookie = TMP.$this->strUserName.'.cookie'; 

	$strContacts = $this->ImportRamblerContacts();
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
	  $display_array=$strContacts;
	}		   
			   
	@unlink(TMP.$this->strUserName);//deleting csv file
	@unlink($mycookie); // deleting cookie
	
	if(empty($display_array))
		return 3;
	else
		return $display_array;
}		
}
?>