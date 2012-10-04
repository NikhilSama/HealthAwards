<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for AOL Contacts          							|	
// | 																		|	
// +------------------------------------------------------------------------+

class aol  extends clsContactImporter
{
	public function ImportAolContacts()
	{
		global $cookie;
	    global $location;
	    global $cookiearr;
	    global $ch;
	    $display_array = array();
		$login=$this->strUserName;
		$passwd=$this->strPassword;
	
	   @list($username,$domain) = split('@',$login);
	   $browser_agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)"; //setting browser types
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_USERAGENT, $browser_agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
		curl_setopt($ch, CURLOPT_URL, "https://my.screenname.aol.com/_cqr/login/login.psp?mcState=initialized&seamless=novl&sitedomain=sns.webmail.aol.com&lang=en&locale=us&authLev=2&siteState=ver%3a2%7cac%3aWS%7cat%3aSNS%7cld%3awebmail.aol.com%7cuv%3aAOL%7clc%3aen-us");
		$html = curl_exec($ch);
	
		#parse the login form:
		preg_match('/<form name="AOLLoginForm".*?action="([^"]*).*?<\/form>/si', $html, $matches);
		$opturl = "https://my.screenname.aol.com/_cqr/login/login.psp";
		
		#get the hidden fields:
		$hiddens = array();
		preg_match_all('/<input type="hidden" name="([^"]*)" value="([^"]*)".*?>/si', $matches[0], $hiddens);
		$hiddennames = $hiddens[1];
		$hiddenvalues = $hiddens[2];
		
		
		$hcount = count($hiddennames);
		$params = "";
		for($i=0; $i<$hcount; $i++)
		{
			$params .= $hiddennames[$i] . "=" . urlencode($hiddenvalues[$i]) . "&";
		}
		
		
	    #attempt login:
		curl_setopt($ch, CURLOPT_URL, $opturl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params . "loginId=$username&password=$passwd");
		$html = curl_exec($ch);
	
		#check if login successful:
		if(!preg_match("/'loginForm', 'false', '([^']*)'/si", $html, $matches))
		{
			#return error if it's not
			return 1;
		}
	  
		$opturl = $matches[1];
		curl_close ($ch);
		$ch = curl_init();
		foreach ($cookiearr as $key=>$value)
		{
			$cookie .= "$key=$value; ";
		}
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_REFERER, $location);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
		curl_setopt($ch, CURLOPT_URL, $opturl);
		$html = curl_exec($ch);
	
		if (preg_match('/gTargetHost = "([^"]*)".*?gSuccessPath = "([^"]*)"/si', $html, $matches) || preg_match('/gPreferredHost = "([^"]*)".*?gSuccessPath = "([^"]*)"/si', $html, $matches))
		{
			$opturl = $matches[1];
			$opturl .= $matches[2];
			$opturl = "http://" . $opturl;
		}
		else
		{
			if(preg_match("/'loginForm', 'false', '([^']*)'/si", $html, $matches))
			{
				$opturl = $matches[1];
				curl_setopt($ch, CURLOPT_URL, $opturl);
				$html = curl_exec($ch);
				$opturl = $location;
			}
		}
	  
	
	   $opturl = explode("/", $opturl);
	   $opturl[count($opturl)-1]="AB";
	   $opturl = implode("/", $opturl);
	
	   preg_match('/\&uid:([^\&]*)\&/si', $cookiearr['Auth'], $matches);
	   $usr = $matches[1];
	
	   #get the address book:
	  
		$opturl .= "/addresslist-print.aspx?command=all&undefined&sort=LastFirstNick&sortDir=Ascending&nameFormat=FirstLastNick&user=$usr";
	  
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_URL, $opturl);
		$html = curl_exec($ch);
		curl_close ($ch);
	
	    #parse the emails and names:
		preg_match_all('/<span class="fullName">(.*?)<\/span>(.*?)<hr class="contactSeparator">/si', $html, $matches);
		$names = $matches[1];
		$emails = array_map("parse_emails", $matches[2]);
	    
        $email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$emails);
	    $dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$names);
		 #return the result:
	   foreach($email1 as $key=>$email)
	   {
			   $name=trim($dataname1[$key])!=''?$dataname1[$key]:$email;	
               if(trim($email)!="")
                  $display_array[] = array('ContactsEmail' => $email,'ContactsName' => $name);
	   }
	 
	  if(empty($display_array))
			return 3;
		else
			return $display_array;
	}


	function ImportContacts()
	{
		 // import AOL contacts
		 $strContacts = $this->ImportAolContacts();
		 return $strContacts;
    }
}
?>