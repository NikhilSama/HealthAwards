<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Indiatimes Contacts          						|	
// | 																		|	
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+

class indiatimes extends clsContactImporter
{ 
public function ImportIndiatimesContacts()
	{
		 $arrContacts = array();    
		 @list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		 $strURL = "http://integra.indiatimes.com/Times/Logon.aspx?ru=".urlencode('http://infinite.indiatimes.com/cgi-bin/gateway')."&IS=058f3c27-6793-41c7-a676-81e3f3594a5c&NS=email&HS=kSVLJ96CWWzEmTwPZa1LD6YR7NM=";   
		 $this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";   
		 
		 $strPostFields = "op=login&login=".$this->strUserName."&passwd=".$this->strPassword."&rememberme=&rememberPwd=&Sign+In=";
		 
		 $strCookieName = TMP.$this->strUserName.'.cookie';  
		 $strCookieFile = fopen($strCookieName,'w');  
		 fclose($strCookieFile);    
		 $this->strCookieJar = realpath("$strCookieName");  
		 $strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		 fclose($strCookieJarFile);       
   	
		///////////////////////////////////////  login to India Times
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$strURL);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$strPostFields);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch,CURLOPT_COOKIEJAR,"temp/cookie.txt");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$strResult = curl_exec($ch);
		
		////////////////////if User name/ password do not match /////////////////////////////////
		if(strstr($strResult, "Invalid"))
		{
			@unlink($strCookieName);
			@unlink("temp/cookie.txt");
			return 1;
		}
		else
		{
		 $nxtUrl =split("Location: http://",$strResult);
		 $nxtUrl =split("\/",$nxtUrl[1]);
		 $rlink = $nxtUrl[0];
	 	 $totalLength=strlen($strResult);
         $pos=stripos($strResult,"<html>");
         $header = substr($strResult,0,$pos);
         $body =substr($strResult,$pos,$totalLength-1);
         $body=str_replace("\n","",$body);
         $body=str_replace("\r","",$body);
         $body = str_replace(" ","",$body);
		 
		 ////////   to set the Cookies   ///////////////////////////////////////////
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
			
	        $strCookieName1=implode(";",$cookie);
			
		// get content from CSV file 
        $url =$rlink.'/home/'.$this->strUserName.'/Contacts.csv';
        $ch1 = curl_init();
        curl_setopt($ch1,CURLOPT_URL,$url);
		curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch1, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($ch1,CURLOPT_HEADER,1);
		curl_setopt($ch1,CURLOPT_COOKIE,$strCookieName1);
		curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, 1);
		$strResult = curl_exec($ch1);
        
        $arrCSVoutput=split("keep-alive",$strResult);
        $strCSVContent=isset($arrCSVoutput[1])?trim($arrCSVoutput[1]):'';

        @unlink($strCookieName);
	
		return $strCSVContent;
	   }
    }	
	
	
function ImportContacts()
{
	$mycookie = $this->strUserName.'.cookie'; 
	
	// import Indiatimes contacts
	$strContacts = $this->ImportIndiatimesContacts();

   if($strContacts == '1')
	{
	    @unlink($strCookieName);
    	@unlink("temp/cookie.txt");
		return 1;
	}
	elseif($strContacts == '3')
	{
	    @unlink($strCookieName);
		@unlink("temp/cookie.txt");
		return 3;
	}
	else
	{ 
 
            //WRITING THE RESULTS TO A CSV FILE ON THE SERVER
		    $myFile = TMP.$this->strUserName.'.txt';
		    $fh = fopen($myFile,'w') or die("can't open file");
		    fwrite($fh,$strContacts);
		    fclose($fh);

		    $display_array=array();
			// OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY
			$fp = fopen($myFile,"r");
			$cnt=0;
            while (!feof($fp)) 
			{
				 $data = fgetcsv($fp,4100,",");//this uses the fgetcsv function to store the quote info in the array $data
				 if($cnt==0){
						 // get the index of each email fields
						 $keyEmail=array_keys($data,'email');
						 $keyEmail2=array_keys($data,'email2');
						 $keyEmail3=array_keys($data,'email3');
						 // get the index of each name fields
						 $keyFirstName=array_keys($data,'firstName');
						 $keyLastName=array_keys($data,'lastName');
						 $keyMiddleName=array_keys($data,'middleName');
						 $keyNickName=array_keys($data,'nickname');
				 }
                 $cnt++;
 
                if(@$data[$keyEmail[0]]!="")
                    $email = @$data[$keyEmail[0]];
                elseif(@$data[$keyEmail2[0]]!="")
                    $email = @$data[$keyEmail2[0]];
                elseif(@$data[$keyEmail3[0]]!="") 
                    $email = @$data[$keyEmail3[0]];	

                 $dataname = @$data[$keyFirstName[0]].' '.@$data[$keyMiddleName[0]].' '.@$data[$keyLastName[0]];		// collect full name
				 if(trim($dataname)=="")
					$dataname = @$data[$keyNickName[0]];
                
				 if(trim($dataname)=="")
					 $dataname =$email;
                  
                 if (!empty($email)) 
				{
					    //remove none characters
						$email_nw = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
						$dataname_nw = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);
						$result = array('ContactsEmail' =>$email_nw,'ContactsName' =>$dataname_nw);
                        $display_array[] = $result;
				 }
			}
			
            //array_shift($display_array);
			if(!empty($display_array))
				unset($display_array[0]);

			   	@unlink('temp/cookie.txt');
				@unlink($myFile);
			if(empty($display_array))
				return 3;
			else
				return $display_array;
     }	  
  }
}
?>