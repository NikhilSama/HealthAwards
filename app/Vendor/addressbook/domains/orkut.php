<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Mail.com Contacts   						      	|
// | 																		|	
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified

class orkut  extends clsContactImporter
{
 public function ImportOrkutContacts()
	{
        global $location;
		global $cookieArr;
		global $ch;
	
	    $matches = array();
		$actionArr = array();
		$filename='"temp/cookies.txt';
	    $userName=$this->strUserName;  
		@list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		$strDomainName = "http://www.orkut.com/Home.aspx";		//setting the site for refer
		 #initialize the curl session
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$strDomainName);	
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION,'read_header');	
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$html = curl_exec($ch);
	    #parse the login form:
	    #parse all the hidden elements of the form
		preg_match_all('/<input type\="hidden" name\="([^"]+)".*?value\="([^"]*)"[^>]*>/si', $html, $matches);
		$values = $matches[2];
		$params = "";
		
		$i=0;
		foreach ($matches[1] as $name)
		{
		  $params .= "$name=" . urlencode($values[$i]) . "&";
		  ++$i;
		}
	       
	    #get the html from gmail.com
		$action = "https://www.google.com/accounts/ServiceLoginAuth";
		$strPostFields="Email=".$userName."&Passwd=".urlencode($this->strPassword)."&PersistentCookie=";

	    #submit the login form:
		curl_setopt($ch, CURLOPT_URL,$action);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params.$strPostFields);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$html = curl_exec($ch);
		
	    if (preg_match('/url=([^"]*)/', $html, $actionArr)!=0)
		{
			$location = $actionArr[1];
		}
		else
		{
			return 1;
		}
         		
		$location = str_replace("&quot;", '', $location);
        $location = str_replace("&#39;", '', $location);
		$location = str_replace("&amp;", '&', $location);
		$location = trim ($location,"'\"");
        
		//$fp = fopen($filename, "w+");  
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_URL, $location);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$h = curl_exec($ch);
		
		$ork_cookie = explode("orkut_state=",$h);
		$orkut_cookie = split(";",$ork_cookie[1]);
		$orkut_state = "orkut_state=".$orkut_cookie[0];
 	   
		$location = "http://www.orkut.com/Friends.aspx";
		#follow the location specified after login
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_URL, "$location");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIE,$orkut_state);
			
		$html = curl_exec($ch);

        preg_match_all("|Friends.aspx\?show=all&pno=[0-9]+|m", $html, $arrFrdmatches); 
        $intCount=count(@$arrFrdmatches[0]); 
      
        preg_match("/<b>([0-9]+)<\/b>/", $html, $arrFrdmatches);  
		$noOfContacts = $arrFrdmatches[1];  
        $noOfPages = ceil(($noOfContacts / 20));//find out the no of pages of friends

	    for ($i = 1 ; $i <= $noOfPages ; $i++)
		{
			$friendsPage = "http://www.orkut.com/Friends.aspx?show=all&pno=$i";
			$html = "";
			$ch6 = "";
			$ch6 = curl_init();
			curl_setopt($ch6, CURLOPT_URL, $friendsPage);
			curl_setopt($ch6, CURLOPT_REFERER, true);
			curl_setopt($ch6, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch6, CURLOPT_HEADER, true);
			curl_setopt($ch6, CURLOPT_COOKIE,  $orkut_state);
			$html = curl_exec($ch6);
		//	echo('<textarea rows=90 col=40>'.$html.'</textarea>');
		//	die;            
			$html = str_replace("\n","",$html);     
			$friendsArray = array();  //this is the array for friends listing. We initialize it to NULL everytime
			$friendsArray = explode('<h3 class="smller">',$html);
			$firstElement = array_shift($friendsArray);  //arrayshif used for remove the upper part of the array in the friend list
	        foreach($friendsArray as $key=>$value) 
			{
			
				$arr = explode('</h3>', $value);
				$username = trim(strip_tags($arr[0]));//striptags used for remove the a href in the name
				$emailE = explode('<br>', $arr[1],2);
				$emails = trim(strip_tags($emailE[0]));	 
				$domain = strstr($emails,"@");
				if(isset($domain) && !empty($domain))
				{
					$result['name'][]=$username; 
		            $result['email'][]=$emails;
				}
			}
		} 
		curl_close($ch);
		@unlink($filename);
		if(isset($result)) {
			return $result;
		}else{
			return null;
		}
	}
	

function ImportContacts()
{
	$mycookie = TMP.$this->strUserName.'.cookie'; 
	$strContacts = $this->ImportOrkutContacts();

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
	{	if(isset($strContacts['email'])) {
			foreach($strContacts['email'] as $key=>$value)
			 {
			  $display_array[] = array('ContactsEmail' => $value,'ContactsName' => $strContacts['name'][$key]);
			 }
		}

		if(empty($display_array))
		   return 3;
		else
		   return $display_array;
   }	
}
}


?>
