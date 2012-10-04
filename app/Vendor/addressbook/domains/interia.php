<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Interia.pl Contacts          						|	
// | 																		|	
// +------------------------------------------------------------------------+

class interia  extends clsContactImporter
{
public function ImportInteriaContacts()
	{
		//------------------------MAIL START--------------------------------------------
		$arrContacts = array();  
		$userName=$this->strUserName;  
		@list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		
	
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";	//setting browser type
		
		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w');  
		fclose($strCookieFile);
		
		$this->strCookieJar = realpath("$strCookieName");  
		$strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		fclose($strCookieJarFile);   
		
		$strURL="http://poczta.interia.pl/";
		$strResult = $this->GetContacts($strURL,1);
		
		$strLoginURL="http://ssl.interia.pl/login.html";
		$strPostFields="referer=http://poczta.interia.pl/poczta/&domain=interia.pl&login=".$this->strUserName."&pass=".$this->strPassword;
		$strLoginResult = $this->DoLogin($strLoginURL,$strPostFields,1);
		
		// start to check for valid login
		preg_match('/<span id="spanLogin">(.*?)<\/span>/si',$strLoginResult,$matches);
		if(@$matches[1]!=$userName){
		     @unlink($strCookieName);
		     return 1; //invalid login
		}
		
		preg_match('/<a href="([^"]+)">pomoc<\/a>/si',$strLoginResult,$matches);
        $URL=@$matches[1];
		$strUserId=substr($URL,-16);
		
		$strAddressBookURL="http://poczta.interia.pl/kontakty/?uid=".$strUserId;
		$strAddressBookResult = $this->GetContacts($strAddressBookURL,1);
		
		preg_match('/<table id="tableListContacts"(.*?)>(.*?)<\/table>/si',$strAddressBookResult,$matchesTable);
      	$strTable=@$matchesTable[2];
		$strTableTr=explode("</tr>",$strTable);
		array_pop($strTableTr);
		$arrResult=array();
		foreach($strTableTr as $content){
		           // start to get name 
					preg_match('/<span class="name">(.*?)<\/span>/si',$content,$matchesName);
					$arrName=explode(',',@$matchesName[1]);
					$name="";
					if(sizeof($arrName)==2){
					     $name .=$arrName[1];
					     $name .=" ".$arrName[0];
					}
					else
					   $name .=$arrName[0];
					
					 // start to get Email address 
					 preg_match('/<a title="Napisz maila"(.*?)>(.*?)<\/a>/si',$content,$matchesEmail);
					 $email=@$matchesEmail[2];
					 if($email!=""){
							$email = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
							$name = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$name);
							$result = array('ContactsEmail' =>$email,'ContactsName' =>$name);
							$arrResult[] = $result;
					 }
		}
		
		
		if(empty($arrResult)){
		   @unlink($strCookieName);
		   return 3;
		}
		
		// delete cookie
		@unlink($strCookieName);
		return $arrResult;
	}


function ImportContacts()
{
	 // import Interia contacts
	 $strContacts = $this->ImportInteriaContacts();
	 return $strContacts;
}		
}
?>