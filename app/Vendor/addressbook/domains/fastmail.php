<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for FastMail.fm Contacts          					|	
// | 																		|	
// +------------------------------------------------------------------------+

class fastmail  extends clsContactImporter
{
  
  public function ImportFastmailContacts()
  {
		$arrContacts = array();  
		$userName=$this->strUserName;  
		if(strstr('@',$this->strUserName))
			list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1)"; //setting browser type

		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w');  
		fclose($strCookieFile);
		
		$this->strCookieJar = realpath("$strCookieName");  
		$strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		fclose($strCookieJarFile);
		
		 // step 1  -- fetch login form
		$strURL = "http://www.fastmail.fm/mail/";
	    $arrResult = $this->GetContacts($strURL,1);
		
		// step 2 -- get each postable data
		$postData="";
		
		preg_match_all('/<form name="memail" action="(.*?)" (.*?)>/', $arrResult, $matches);
		$strURL =$matches[1][0];
		
		preg_match_all('/<input(.*?)value="(.*?)"(.*?)name="MLS"(.*?)>/', $arrResult, $matches);
		$postData .="MLS=".@$matches[2][0];
		$postData .="&FLN-UserName=".urlencode($this->strUserName)."&FLN-Password=".urlencode($this->strPassword)."&FLN-Security=0";
		
		// step 3  --- do login
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL,$strURL);
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
		
		
		preg_match_all('/<meta(.*?)content="0;url=(.*?)"(.*?)>/', $strLoginResult, $matches);
		$redirectURL =$matches[2][0];
		
		// do the redirect
		curl_setopt($curl, CURLOPT_REFERER,$redirectURL);
		curl_setopt($curl, CURLOPT_URL,$redirectURL);
		curl_setopt($curl, CURLOPT_POST, 0);
		$strResult = curl_exec($curl);
		
		preg_match_all('/<a href="(.*?)"(.*?)accesskey="C"(.*?)><u>C<\/u>ompose<\/a>/',$strResult,$matches);
		$strAddressBook =@$matches[1][0];
		
		if($strAddressBook==''){
		    @unlink ($strCookieName);
		    return 1;
		}
		
		$strAddressBook=str_replace("MSignal=MC","MSignal=AD",$strAddressBook);
		
		$arrBase=explode("/mail/",$strURL);
		$addressBookURL=$arrBase[0].$strAddressBook;
		
		curl_setopt($curl, CURLOPT_URL,$addressBookURL);
		curl_setopt($curl, CURLOPT_POST, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$strAddressBookResult = curl_exec($curl);
		
		// parse form action
		preg_match('/<form.*?action="([^"]*)".*?name="memail">/', $strAddressBookResult, $arrAction);
		$actionURL=$arrAction[1];
		
		#parse the login form:
		preg_match('/<form(.*?)name="memail">(.*?)<\/form>/si', $strAddressBookResult, $matches);
			
		#get the hidden fields:
		$hiddens = array();
		preg_match_all('/<input value="([^"]*)" name="([^"]*)" type="hidden".*?>/si', $matches[0], $hiddens);
		$hiddennames = $hiddens[2];
		$hiddenvalues = $hiddens[1];
		$hcount = count($hiddennames);
		$params = "";
		for($i=0; $i<$hcount; $i++)
		{
			$params .= $hiddennames[$i] . "=" .urlencode($hiddenvalues[$i]) . "&";
		}
		
		//fetch all rest fields 
		$params .="FAD-ST=";
		$params .="&MSignal_UA-*U-1=Upload/Download";
		$params .="&FAD-Group=-1";
		$params .="&FAD-AL-SortBy=SNM";
		$params .="&FAD-NF=";
		$params .="&FAD-NF=";
		$params .="&FAD-NL="; 
		$params .="&FAD-NN=";
		$params .="&FAD-NE=";
		$params .="&FAD-NP="; 
		$params .="&FAD-NPT=1";
		
		
		curl_setopt($curl, CURLOPT_URL,$actionURL);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$params);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$strAdrResult = curl_exec($curl);
		
		// now start to parse hidden values
		
		// parse form action
		preg_match('/<form.*?action="([^"]*)".*?name="memail">/',$strAdrResult, $arrAction);
		$csvURL=$arrAction[1];
		
		#parse the login form:
		preg_match('/<form(.*?)name="memail">(.*?)<\/form>/si', $strAdrResult, $matches);
		#get the hidden fields:
		$hiddens = array();
		preg_match_all('/<input value="([^"]*)" name="([^"]*)" type="hidden".*?>/si', $matches[0], $hiddens);
		$hiddennames = $hiddens[2];
		$hiddenvalues = $hiddens[1];
		$hcount = count($hiddennames);
		$params = "";
		for($i=0; $i<$hcount; $i++)
		{
			$params .= $hiddennames[$i] . "=" .urlencode($hiddenvalues[$i]) . "&";
		}
		
		//fetch all rest fields 
		$params .="FUA-Group=0";
		$params .="&FUA-DownloadFormat=OL";
		$params .="&MSignal_UA-Download*=Download";
		
		curl_setopt($curl, CURLOPT_URL,$csvURL);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$params);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $this->strCookieJar);
		curl_setopt($curl, CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->strUserAgent);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$strCSVResult = curl_exec($curl);
		curl_close($curl);
		
		@unlink ($strCookieName);
         //---------------------------------------------------- return the contacts
		return $strCSVResult;
		 
	}

	function ImportContacts()
	{
		$mycookie = TMP.$this->strUserName.'.cookie'; 
		// make an object
		$strContacts = $this->ImportFastmailContacts();

		if($strContacts == '1')
		{
			@unlink($mycookie); // deleting cookie		
			return 1;
		}
		else
		{
			//WRITING THE RESULTS TO A CSV FILE ON THE SERVER
			$myFile = TMP.$this->strUserName;
			$fh = fopen($myFile,'w') or die("can't open file");
			fwrite($fh,$strContacts);
			fclose($fh);

			$display_array=array();
			// OPENING THE STORED CSV FILE AND TURING IT INTO AN ARRAY
			$fp = fopen($myFile,"r");
			while (!feof($fp)) 
			{
				$data = fgetcsv($fp,4100,",");//this uses the fgetcsv function to store the quote info in the array $data
				$dataname = @$data[1];		// collect full name
				if(!empty($dataname))
				{
					$dataname = @$data[1];		// collect first name
					if(@$data['2'])
						$dataname .= " " .@$data[2];	// collect middle name
				}

				if (empty($dataname))
					$dataname = "None";

				if(@$data[34]!="")
				   $email = @$data[34];	
				elseif(@$data[35]!="") 
				   $email = @$data[35];	
				elseif(@$data[36]!="")  
				   $email = @$data[36];	   
				   
				$email = @$data[34];		// collect email
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
				   
		@unlink($myFile);//deleting csv file
		@unlink($mycookie); // deleting cookie
		
		if(empty($display_array))
			return 3;
		else
			return $display_array;
	}		
}
?>