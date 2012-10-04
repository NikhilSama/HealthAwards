<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for MySpace Contacts          						|	
// | 																		|	
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified
class myspace  extends clsContactImporter
{
   public function ImportMyspaceContacts()
	{
		$arrContacts = array();  
		$userName=$this->strUserName;  
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1"; //setting browser type

		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w');  
		fclose($strCookieFile);
		
		$this->strCookieJar = realpath("$strCookieName");  
		$strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		fclose($strCookieJarFile);
		
		$postfields = "__VIEWSTATE=wEPDwUKMTk3MDMyMDM1OWQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgIFMGN0bDAwJE1haW4kU3BsYXNoRGlzcGxheSRjdGwwMCRSZW1lbWJlcl9DaGVja2JveAUwY3RsMDAkTWFpbiRTcGxhc2hEaXNwbGF5JGN0bDAwJExvZ2luX0ltYWdlQnV0dG9u";
		$postfields .= "NextPage=&ctl00%24Main%24SplashDisplay%24ctl00%24nexturl=&ctl00%24Main%24SplashDisplay%24ctl00%24apikey=";
		$postfields .= "&ctl00%24Main%24SplashDisplay%24ctl00%24Email_Textbox=" .urlencode($this->strUserName);
		$postfields .= "&ctl00%24Main%24SplashDisplay%24ctl00%24Password_Textbox=" .urlencode($this->strPassword);
		$postfields .= '&ctl00%24Main%24SplashDisplay%24login%24loginbutton.x=38&ctl00%24Main%24SplashDisplay%24login%24loginbutton.y=15';
		$strURL     ="http://secure.myspace.com/index.cfm?fuseaction=login.process";
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,$strURL );
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$postfields);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$strLoginResult = curl_exec($curl);
	
		// find redirect url
		preg_match("/fuseaction=user&Mytoken=(.*)\"/",$strLoginResult,$token);
		
		$token = @$token[1];
		$redirPage="http://home.myspace.com/index.cfm?fuseaction=user&MyToken=$token";
		
		// do the redirect
		curl_setopt($curl, CURLOPT_REFERER,$redirPage);
		curl_setopt($curl, CURLOPT_URL,$redirPage);
		curl_setopt($curl, CURLOPT_POST, 0);
		$strResult = curl_exec($curl);
		
		// check login error
		
		if(strpos($strResult,"You Must Be Logged-In to do That!") !== false){
		   // login error
		   return false;
		}
		preg_match("/ id=\"ctl00_cpMain_Welcome.Skin_AddressBookHyperLink\" href=\"([^\"]+)\"/",$strResult,$redirPage);
	
		$redirPage = @$redirPage[1];
		if(trim($redirPage)=="")
		{
			$redirPage = "http://messaging.myspace.com/index.cfm?fuseaction=adb";
		}
		
		// go there (edit profile)
		curl_setopt($curl, CURLOPT_URL,$redirPage);
		$strResult = curl_exec($curl);
		
		$strResponse = str_replace("\n","",$strResult);     
		$friendsArray = array();  //this is the array for friends listing. We initialize it to NULL everytime
		$friendsArray = explode('<td class="NameCol" valign="top" onmouseover="ShowContextMenu(this,event)" >',$strResponse);
		$firstElement = array_shift($friendsArray);  //arrayshif used for remove the upper part of the array in the friend list
		
		$result=array();
		
		foreach($friendsArray as $key=>$value) 
		{
			$arr = explode('<br />', $value);
			$username = strip_tags($arr[0]);//striptags used for remove the a href in the name
			$names =  explode("&nbsp;&nbsp;",$username);
			
			$Name = array();
			$DiaplayName = array();
			$UserName = array();
			$i = 0;	
			$j = 0;
			if(trim($names[2])!="")	
			   $result['name'][]=trim($names[2]);
			else 
			   $result['name'][]="";  
		}
		
		$friendsArray = explode('hashJsonContacts.add(',$strResponse);
		$firstElement = array_shift($friendsArray);
		
		$i = 0;
		foreach($friendsArray as $key=>$value) 
		{
			
			$arr2 = explode('hashJsonContacts.add(', $value);
			$email = str_replace("\\"," ",$arr2[0]);
			$email1 = split('"Email ": "',$email);
			if(isset($email1[1])&& !empty($email1[1]))
			{
				 $extractEmail = split('"',$email1[1]);
				 $result['email'][$i]=$extractEmail[0];
			}
			else 
			{
				// If the email field blank then it replace with its name
				$result['email'][$i] = '';
			}
			$i++;
		 }
		 
          @unlink ($strCookieName);
          return $result;
	}
	
	
function ImportContacts()
{
	$mycookie = TMP.$this->strUserName.'.cookie'; 
	$strContacts = $this->ImportMyspaceContacts();
	
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
		   if(is_array($strContacts)){
		        $totalCnt=count($strContacts['name']);
				for($cnt=0;$cnt<$totalCnt;$cnt++){
				   if(trim($strContacts['email'][$cnt])!=''){
                       $name=trim($strContacts['name'][$cnt])=='' ? $strContacts['email'][$cnt] : $strContacts['name'][$cnt];
                       $result = array('ContactsEmail' => $strContacts['email'][$cnt],'ContactsName' => $name);
				       $display_array[] = $result;
             		}	
				}
		   }
    }
	
	@unlink($mycookie); // deleting cookie
	
	if(empty($display_array))
		return 3;
	else
		return $display_array;
}
}
?>