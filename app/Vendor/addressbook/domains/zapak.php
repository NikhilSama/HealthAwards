<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Zapak												|	
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified

class zapak  extends clsContactImporter
{
	public function ImportZapakContacts()
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
		$strURL = "http://www.zapak.com/login.zpk";
	    $strResult = $this->GetContacts($strURL,1);
		
		$strLoginURL    = "http://www.zapak.com/authenticateuser.zpk";
		$strPostFields  = "redirect=&explicit=&regflag=0&uid=".$this->strUserName."&password=".urlencode($this->strPassword);
	    $strLoginResult = $this->DoLogin($strLoginURL,$strPostFields,1);
		
		$arrResult=array();
		$strAddressBookLoginURL  = "http://www.zapak.com/mc.z";
		$start=15;
		$max=30;
		do
		 {
			$last='';
			$strAddressBookResult = $this->GetContacts($strAddressBookLoginURL,1);
						
			preg_match_all('/<a style="cursor:pointer" class="b_text" href="([^\"]+)">Next/',$strAddressBookResult,$match1);
			$strSubURL='';
			$last=@$match1[1][0]; 
			
			if($last!='')
			  $strSubURL= "?startval=$start&maxval=$max";
			
			$strAddressBookLoginURL="http://www.zapak.com/mc.z".$strSubURL;
			
			preg_match('/<div class="clearfix">(.*?)<\/div>/si', $strAddressBookResult, $matches);
			$strDivContent=@$matches[0];
			
			$arrTableTr=explode("</tr>",$strDivContent);
			$cnt=count($arrTableTr);
			
			//remove all extra content
			for($i=$cnt-1;$i>$cnt-7;$i--)
			   unset($arrTableTr[$i]);
			 
			  foreach($arrTableTr as $content){
			         preg_match_all('/<input type="checkbox"(.*?)value="([^"]*)"(.*?)>/si', $content, $matchMail);
					 $arrEmail=explode("|",@$matchMail[2][0]);
					 $email=@$arrEmail[0];
					
					preg_match_all('/<strong>(.*?)<\/strong>/si', $content, $matchName);
					$name=strip_tags(@$matchName[0][0]);
					 //remove none characters
					$email = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
					$name = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$name);
                    $email = preg_replace("/nbsp/i","",$email);
                    $name = preg_replace("/nbsp/i","",$name); 
                    $name= (trim($name)=='') ? $email : $name;
                    
                   if(trim($email)!="")
					    $arrResult[]=array("ContactsEmail"=>trim($email),"ContactsName"=>trim($name));
			 }
			 
			 $start+=15;
		     $max+=15;
			 
	    }while($last!='');
		@unlink ($strCookieName);
         //---------------------------------------------------- return the contacts
		return $arrResult;
		 
	}
function ImportContacts()
{
	$mycookie = TMP.$this->strUserName.'.cookie'; 

	$strContacts = $this->ImportZapakContacts();
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
			   
	@unlink($mycookie); // deleting cookie
	
	if(empty($display_array))
		return 3;
	else
		return $display_array;
}		
}
?>