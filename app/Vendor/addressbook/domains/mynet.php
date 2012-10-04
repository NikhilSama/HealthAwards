<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Mynet.com Contacts          						|	
// | 																		|	
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified
class mynet  extends clsContactImporter
{

	public function ImportMynetContacts()
	{
		//------------------------------------------------------------------MAIL START
		$arrContacts = array();  
		$userName=$this->strUserName;  
		list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";	//setting browser type
		
		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w');  
		fclose($strCookieFile);
		
		$this->strCookieJar = realpath("$strCookieName");  
		$strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		fclose($strCookieJarFile);   
		
		$strURL="http://uyeler.mynet.com/login/";
		$strResult = $this->GetContacts($strURL,1);
		
		preg_match_all("/<form(.*?)action=\"(.*?)\"(.*?)name=myform(.*?)>/",$strResult, $matches);
		$strLoginURL=$matches[2][0];
		$strPostFields="nameofservice=member&pageURL=http://uyeler.mynet.com/login/login.asp?&faultCount=&faultyUser=&loginRequestingURL=&rememberstate=&username=".$this->strUserName."&password=".$this->strPassword;
		$strLoginResult = $this->DoLogin($strLoginURL,$strPostFields,1);
		
		// adress book page
		preg_match_all('/<meta http-equiv="Refresh"(.*?)url=(.*?)"(.*?)>/',$strLoginResult, $matches);
        $strRedirectURL=$matches[2][0];
    	$strResult = $this->GetContacts($strRedirectURL,1);
		
		$strAdressBookURL="http://adresdefteri.mynet.com/Exim/EximPage.aspx";
		$strAdressBookResult = $this->GetContacts($strAdressBookURL,1);
		
		$strCSVURL="http://adresdefteri.mynet.com/Exim/ExportFileDownload.aspx";
		$strPostFields="format=microsoft_csv";
		$strCSVResult = $this->DoLogin($strCSVURL,$strPostFields,1);
		// delete cookie
		@unlink($strCookieName);
		return $strCSVResult;
  }
	
function ImportContacts()
{
	$mycookie =  TMP.$this->strUserName.'.cookie'; 

	$strContacts = $this->ImportMynetContacts();
	
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
		$myFile =  TMP.$this->strUserName;
		$fh = fopen($myFile,'w') or die("can't open file");
		fwrite($fh,$strContacts);
		fclose($fh);

		// CHECKING IF LOGIN WAS SUCCESSFUL - by search of the @ sign in the csv

		preg_match_all("/@/",$strContacts,$array_at);
		
		$at_sign = @$array_at[0];
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
             	 $dataname = @$data[0];		// collect full name
				
				 if(!empty($dataname))
				 {
					$dataname = @$data[0];		// collect first name
					if(@$data['1'])
						$dataname .= " " .@$data[1];	// collect last name
				 }

				if (empty($dataname))
					$dataname = "None";

				$email="";
				if(@$data[9]!="")
				   $email = @$data[9];	
				        
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