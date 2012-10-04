<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Gmail Contacts          						    |	
// +------------------------------------------------------------------------+

class gmail extends clsContactImporter
{ 
   function ImportGmailContacts()
	{

		global $location;
		global $cookiearr;
		global $ch;
        
		$arrContacts = array();

		$strDomainName = "http://mail.google.com/mail/";	//setting the site for refer
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";	//setting browser type

		#initialize the curl session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strDomainName);
        curl_setopt($ch, CURLOPT_REFERER, "");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header_value');
       	curl_setopt($ch, CURLOPT_HEADER, 1);
        $html = curl_exec($ch);
      

	    $matches = array();
        $action = "https://www.google.com/accounts/ServiceLoginAuth?service=mail";
        #parse the login form:
        #parse all the hidden elements of the form
        preg_match_all('/<input type="hidden"[^>]*name\="([^"]+)"[^>]*value\="([^"]*)"[^>]*>/si', $html, $matches);
        $values = $matches[2];
        $params = "";
        
        $i=0;
        foreach ($matches[1] as $name)
        {
          $params .= "$name=" . urlencode($values[$i]) . "&";
          ++$i;
        }
        
        $this->strUserName = urlencode($this->strUserName);
        $this->strPassword = urlencode($this->strPassword);

        curl_setopt($ch, CURLOPT_URL,$action);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params ."Email=$this->strUserName&Passwd=$this->strPassword&PersistentCookie=");
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $html = curl_exec($ch);
                  
        #test if login was successful:
		if (!isset($cookiearr['GALX']) && (!isset($cookiearr['LSID']) || $cookiearr['LSID'] == "EXPIRED"))
		{
             return 1;
		 } 

        $strCSVUrl="http://mail.google.com/mail/contacts/data/export?exportType=ALL&groupToExport=&out=OUTLOOK_CSV";
        curl_setopt($ch, CURLOPT_URL, $strCSVUrl);
        curl_setopt($ch, CURLOPT_POST, 0);    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $strResult =curl_exec($ch); 
		
        /*preg_match_all('/Server\: GFE\/1\.3([^,]*),(.*)/s',$strResult,$arrMatches);
		return @$arrMatches[2][0];*/
		$a = explode(",",$strResult);
        foreach($a as $key=>$value){
			if(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{3}/is',$value,$email)){
				$emails[] = $email;
			}
		}
		
		foreach($emails as $key=>$value){
			$result[] = $value[0];
		}
		return $result;
    }

  		
	
	function getCookies($header)
	    { 
	    	$cookies=array();
	        $cookie=""; 
	        $returnar=explode("\r\n",$header);
	        for($ind=0;$ind<count($returnar);$ind++) 
	        {
	        	 if(ereg("Set-Cookie: ",$returnar[$ind]) || ereg("Cookies ",$returnar[$ind])) 
	           	 {
	            	$cookie=str_replace("Set-Cookie: ","",$returnar[$ind]);
	                $cookie=explode(";",$cookie);
	                $cookies[trim($cookie[0])]=trim($cookie[0]);
	             }
			}
	            
	        $cookie=array();
	        foreach ($cookies as $key=>$value)
	        {
	        	array_push($cookie,"$value");
			}
	        $cookie=implode(";",$cookie);
	        return $cookie; 
	    }       
	    
	 
	function getLocation($header)
	    {
	    	$returnar=explode("\r\n",$header);
            $location='';
	        for($ind=0;$ind<count($returnar);$ind++) 
	        {
	        	if(ereg("Location: ",$returnar[$ind])) 
	            {
					$location=str_replace("Location: ","",$returnar[$ind]);
	                $location = trim($location);
	                break;
	            }

	           // $this->splitPage($response='', &$header, &$body);
	            $cookies_phase1 =$this->getCookies($header);
	        }
	        return $location;
	    }
		
  function splitPage($response,$header,$body)
	    {
	    	$totalLength=strlen($response);
	        $pos=stripos($response,"<html>");
	        $header = substr($response,0,$pos);
	        $body =substr($response,$pos,$totalLength-1);
	        $body=str_replace("\n","",$body);
	        $body=str_replace("\r","",$body);
	        $body = str_replace(" ","",$body);
	    }

	function trimvals($val)
	  {
	        return trim ($val, "\" \n");
	  }

function ImportContacts()
 {

	// import Gmail contacts
    $strContacts = $this->ImportGmailContacts(); 
	return  $strContacts;

	/*if($strContacts == '1')
	{
		return 1;
	}

	else 
	{
	
        //WRITING THE RESULTS TO A CSV FILE ON THE SERVER
        $uName=split('%40|@',$this->strUserName);
		$myFile =  TMP.@$uName[0].'.csv'; 
        $fh = fopen($myFile,'w') or die("can't open file");
        fwrite($fh,$strContacts);
   
        // CHECKING IF LOGIN WAS SUCCESSFUL - by search of the @ sign in the csv
        preg_match_all("/@/",$strContacts,$array_at);
        $at_sign =$array_at[0];
		if(empty($at_sign))
		   {
                @unlink($myFile); //deleting csv file  
                return 3;
           }
        else
           {
              $display_array=array(); 
              $fp = fopen($myFile,"r");
               while (!feof($fp)) 
			   {  
                  $data = fgetcsv($fp,4100,",");//this uses the fgetcsv function to store the quote info in the array $data
				  $dataname = @$data[4];		// collect  name
                  $dataname=  trim($dataname)=='' ? @$data[5] : $dataname;
				  $email = @$data[13];		    // collect  email
                  $email=  trim($email)=='' ? @$data[14] : $email;
                  $email=  trim($email)=='' ? @$data[15] : $email;

                  $dataname=  trim($dataname)=='' ? $email : $dataname;
                  if(trim($email)!=''){ 
                        $display_array[] =array('ContactsEmail' =>$email,'ContactsName' => $dataname);
                   }
                }
			} 
       
        if(!empty($display_array))
		   unset($display_array[0]);

        @unlink($myFile); //deleting csv file  
		return $display_array;
	 }*/
  }
}



function read_header_value($ch, $string)
{
    global $location;
    global $cookiearr;
    global $ch;
    
    //$cookiearr=array();
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
      if(count($cookiearr)>=1){
		  foreach ($cookiearr as $key=>$value)
		  {
			$cookie .= "$key=$value; ";
		  }
       } 
      curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }

    return $length;
}

?>
