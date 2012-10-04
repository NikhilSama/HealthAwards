<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for Plaxo Contacts          						    |	
// | 																		|	
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the username) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if username or password was not specified
class plaxo  extends clsContactImporter
{
 public function ImportPlaxoContacts()
	{
		$arrContacts = array();    
		$strDomainName = "https://www.plaxo.com";	//setting the site for refer
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7";	//setting browser type
		$strCookieName = TMP.$this->strUserName.'.cookie';
		$strCookieFile = fopen($strCookieName,'w'); 
		fclose($strCookieFile);
		$this->strCookieJar = realpath("$strCookieName"); 
		$strCookieJarFile = fopen($this->strCookieJar,'wb');	//this opens the file and resets it to zero length
		fclose($strCookieJarFile);

		$strPostFields = "signin.email=".$this->strUserName."&signin.password=".$this->strPassword;
		
		$strURL = 'https://www.plaxo.com/signin';
		$strResult = $this->DoLogin($strURL,$strPostFields,1);
		
		// Check for Incorrect Login
		if(strstr($strResult, "Password") || strstr($strResult, "Trouble"))
		{
		    @unlink($strCookieName);
			return 1;
		}
		else
		{
			//--------------------------------------------------- open export contacts page 
			$strURL = 'https://www.plaxo.com/export/';
			$strResult = $this->GetContacts($strURL,1);
			
			// to check , whether contact list is not empty
			if(!strstr($strResult,"folder_id"))
			{
    	    @unlink($strCookieName);
			return 3;

			}
			#parse all the hidden elements of the form


  		    preg_match_all('/<input type="?hidden"? name="?([^"]+)"?[\s]+value\="?([^"]*)"?[^>]*>/si', $strResult, $matches);

			$values = $matches[2];
		    $params = "";
		
		   $i=0;
		   foreach ($matches[1] as $name)
		   {
		     $params .= "$name=" . urlencode($values[$i]) . "&" ;
		    if(strstr($name,'folder_id'))
			   $params .=str_replace("folder_id", "checked", $name) . "=1&";
		       ++$i;
		    }
			
			//------------------------------------ download csv  ----------------------------------------//
			$strPostFields = $params.'type=O&ac=Export Contacts';
			$strURL = "https://www.plaxo.com/export/plaxo_ab_outlook.csv";

			$strResult = $this->DoLogin($strURL,$strPostFields,1);
			@unlink($strCookieName);
			// ----------------------------  Return the Final Result   ----------------------------------//
			return $strResult;
		 }
     }


function ImportContacts()
{

	// import plaxo contacts
	$strContacts = $this->ImportPlaxoContacts();

	if($strContacts == '1')
	{
		return 1;
	}
	// Write the results of contacts in a CSV file
	$myFile = TMP.$this->strUserName.'.csv';
	$fh = fopen($myFile,'w') or die("can't open file");
	fwrite($fh,$strContacts);
	fclose($fh);
	//////// To check , whether contact list in not empty
	if (!strstr($strContacts,"@")) 
	{
	   @unlink($myFile);	//deleting csv file
		return 3;			// Error - No contacts found, check your login details and try again
	}
	else 
	{
		//Opening Csv File For Processing
		$display_array='';
		$fp = fopen($myFile,"r");
		while (!feof($fp)) 
		{
			$data = fgetcsv($fp,4100,","); //this uses the fgetcsv function to store the quote info in the array $data
			
			if((strstr($data[5],"@")) || (strstr($data[6],"@")))
			{
			$email=trim($data[5]) ? trim($data[5]) : trim($data[6]);
			$dataname= trim($data[0])." ".trim($data[1])." ".trim($data[2])." ".trim($data[3]);
			$dataname = strlen(trim($dataname)) ? $dataname : $email;//if name is blank then it replace with its  email
					$result = array('ContactsEmail' => $email,'ContactsName' => $dataname);
					$display_array[] = $result;
		     }
		}
			
	}
		@unlink($myFile);	//deleting csv file

	if(empty($display_array))
		return 3;
	else
		return $display_array;
}
}
?>
