<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for KataMail.com Contacts          					|	
// | 																		|	
// +------------------------------------------------------------------------+

class katamail  extends clsContactImporter
{
public function ImportKatamailContacts()
	{
		$arrContacts = array();  
		$strUserName=$this->strUserName;  
		@list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7"; //setting browser type

		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w');  
		fclose($strCookieFile);
		
		$this->strCookieJar = realpath("$strCookieName");  
		$strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		fclose($strCookieJarFile);
		
		$strURL = "http://www.kataweb.it/";
		$pageResult = $this->GetContacts($strURL,1);
		
		preg_match_all("/<form name='login' action=\"(.*?)\" (.*?)>/", $pageResult, $matches);
		$strLoginURL=$matches[1][0];
		
		// fetch login form
		preg_match_all("/<form name='login'.*?<\/form>/si", $pageResult, $formMatches);
		
		// fetch all hidden values
		$hiddens = array();
		preg_match_all('/<input type="hidden" name="([^"]*)" value="([^"]*)".*?>/si',@$formMatches[0][0], $hiddens);
		$hiddennames = $hiddens[1];
		$hiddenvalues = $hiddens[2];
		$hcount = count($hiddennames);
		$params = "";
		for($i=0; $i<$hcount; $i++)
		{
			$params .= $hiddennames[$i] . "=".urlencode($hiddenvalues[$i]) . "&";
		}
		
		//over-write values
		$params=str_replace("email=","email=".$strUserName,$params);
		$params=str_replace("LoginType=","LoginType=xp",$params);
		
		// user name and password
		$params .="username=".$this->strUserName."&password=".$this->strPassword;
		
		// do login
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,$strLoginURL);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$params);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$strLoginResult = curl_exec($curl);
		
		preg_match_all("/<FORM name='login' action=\"(.*?)\" (.*?)>/", $strLoginResult, $matches);
		$strNextLoginURL=@$matches[1][0];
		
		// secon attempt for login
		curl_setopt($curl, CURLOPT_URL,$strNextLoginURL);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$params);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$strNextLoginResult = curl_exec($curl);
		
		preg_match_all("/<script>location.href='(.*?)'(.*?)<\/script>/", $strNextLoginResult, $matches);
		$strRedirect=@$matches[1][0];
		
		preg_match('@^(?:http://)?([^/]+)@i',$strNextLoginURL, $hostMatches);
		$baseURL=@$hostMatches[0];
		$redirectURL=$baseURL.'/'.$strRedirect;
		
		curl_setopt($curl, CURLOPT_URL,$redirectURL);
		curl_setopt($curl, CURLOPT_POST,0);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		$strResult = curl_exec($curl);
		
		$adressbookURL=$baseURL.'/parse.php?file=html/$this->Language/xul/xulabook.html&XUL=1';
		curl_setopt($curl, CURLOPT_URL,$adressbookURL);
		curl_setopt($curl, CURLOPT_POST,0);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$strAdrResult = curl_exec($curl); 
		
		$adressbookExportURL=$baseURL.'/abook.php?func=export&abookview=0';
		curl_setopt($curl, CURLOPT_URL,$adressbookExportURL);
		curl_setopt($curl, CURLOPT_POST,0);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$strCSVResult = curl_exec($curl);
		curl_close($curl);
			
		@unlink ($strCookieName);
         //---------------------------------------------------- return the contacts
		 return $strCSVResult;
		 
	}

function ImportContacts()
{
	$mycookie = TMP.$this->strUserName.'.cookie'; 

	$strContacts = $this->ImportKatamailContacts();
	
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
             	 $dataname = @$data[6];		// collect full name
				 if(!empty($dataname))
				 {
					$dataname = @$data[6];		// collect first name
					if(@$data['18'])
						$dataname .= " " .@$data[18];	// collect middle name
				 }

				if (empty($dataname))
					$dataname = "None";

				$email="";
				if(@$data[1]!="")
				   $email = @$data[1];	
				elseif(@$data[2]!="") 
				   $email = @$data[2];	
				elseif(@$data[3]!="")  
				   $email = @$data[3];	
				elseif(@$data[4]!="")  
				   $email = @$data[4];
				elseif(@$data[5]!="")  
				   $email = @$data[5];         
				   
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