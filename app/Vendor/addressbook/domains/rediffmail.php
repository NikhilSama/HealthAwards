<?php
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for RediffMail Contacts          						|	
// | 																		|	
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+

#function ImportContacts, accepts as arguments $login (the login) and $password
#returns array of: array of the names and array of the emails if login successful
#otherwise returns 1 if login is invalid and 2 if login or password was not specified

class rediffmail extends clsContactImporter
{ 
	public function ImportRediffmailContacts()
	{
		//------------------------------------------------------------------REDIFF START-----------------------------------------------------------------			
          $arrContacts = array();    
		  @list($this->strUserName,$strMatches) = split('@',$this->strUserName);
		  $strRefferedSite = "http://www.rediff.com";//setting the site for refer
		  $this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//setting browser type   
		  $strCookieName = TMP.$this->strUserName.'.cookie';  
		  $strCookieFile = fopen($strCookieName,'w');  
		  fclose($strCookieFile);  
		  
		   $this->strCookieJar = realpath("$strCookieName");  
		   $strCookieJarFile = fopen($this->strCookieJar,'wb');  //this opens the file and resets it to zero length
		   fclose($strCookieJarFile);
		
		   //---------------------------------------------------STEP 1
		   $strRefererURL = "http://www.rediff.com";  
		   $arrLoginResult = $this->GetContacts($strRefererURL,1);
		
		   //---------------------------------------------------STEP 3
		    $loginurl = 'http://mail.rediff.com/cgi-bin/login.cgi';
		    $postdata = 'login='.$this->strUserName.'&passwd='.$this->strPassword.'&FormName=existing&x=14&y=9';
		
		    $curl = curl_init();  
			curl_setopt($curl,CURLOPT_URL,$loginurl);  
			curl_setopt($curl,CURLOPT_USERAGENT,$this->strUserAgent);  
			curl_setopt($curl,CURLOPT_POST,1);  
			curl_setopt($curl,CURLOPT_HEADER,1);  
			curl_setopt($curl,CURLOPT_POSTFIELDS,$postdata); 
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  
			curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);  
			curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);  
			curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);  
			curl_setopt($curl,CURLOPT_REFERER,$strRefererURL);
			curl_setopt($curl,CURLOPT_COOKIEFILE,$this->strCookieJar);
			curl_setopt($curl,CURLOPT_COOKIEJAR,$this->strCookieJar);
			$res = curl_exec($curl);
			
		    $myarr = explode("><U>Go to Inbox",$res);
			$myarr = explode('HREF=&quot;',htmlentities($myarr[0]));
		    preg_match_all("/&lt;meta http-equiv=&quot;Refresh&quot; content=&quot;0; url=(.*?)&quot;&gt;/", $myarr[0], $arrURL);
			// get session value
			if(isset($arrURL[1][0])) {
				preg_match_all("/&amp;session_id=(.*?)&amp;/", $arrURL[1][0], $arrSess);
				$strSession=$arrSess[1][0];
			}
			$startPos = strpos($myarr[0],"http://f");
			$strReturnCount = substr($myarr[0],$startPos+8,1);
			
            $strFirstHalfUrl = "http://f".$strReturnCount."plus.rediff.com";
			
			if(isset($strSession)){
				$strAddressBookRequestUrl = $strFirstHalfUrl."/iris/Main?do=getXmlAddressBook&sortorder=asc&sortfield=FirstName&startcount=0&displaycount=25&filter=all&displaygroup=0&groupname=&login=".$this->strUserName."&session_id=".$strSession;
				$strAddressBookRefererUrl = $strFirstHalfUrl."/iris/Main?do=dispaddress&login=".$this->strUserName."&session_id=".$strSession;
				$totalRecords=0;
				$addressBookURL="http://f".$strReturnCount."plus.rediff.com/bn/address.cgi?login=".$this->strUserName."&session_id=".$strSession;
			}
		 do
		  {
			 $last='';
			 $curl = curl_init();
			 if(isset($addressBookURL)) {
				curl_setopt($curl,CURLOPT_URL,$addressBookURL);
			 }
			 curl_setopt($curl,CURLOPT_USERAGENT,$this->strUserAgent);  
			 curl_setopt($curl,CURLOPT_HEADER,1);  
			 curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  
			 curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);  
			 curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);  
			 curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);  
			 curl_setopt($curl,CURLOPT_COOKIEFILE,$this->strCookieJar);
			 curl_setopt($curl,CURLOPT_COOKIEJAR,$this->strCookieJar);
			 $res2 = curl_exec($curl);
			 preg_match('/a HREF=".*Next/',$res2,$match1);
			 $match1=str_replace('a HREF="',$strFirstHalfUrl,@$match1[0]);
			 $match1=str_replace('">Next','',$match1);
			
			$last=$match1;
			$addressBookURL=$last;
			$first=stripos($res2,'<INPUT TYPE=hidden NAME=tempnicks VALUE="">');
			$first1=substr($res2,$first);
			$sList2 = explode("</TD>",$first1);
			
			//////////////////////////////////Display of contents ///////////////////////////////////////
		    $res=array();
			for ($i=0; $i < count($sList2); $i++)
				  {       
                                              
						$sList3 = explode("<TD class=sb2>&nbsp;&nbsp;", $sList2[$i]);
                        if (@$sList3[1]!="")
			            {
                                        
				     		$totalRecords= $totalRecords +1;
			              	$sList3[1]=str_replace("\n","",$sList3[1]);
			                $result['name'][]=$sList3[1];
			            }
			          
			            if (strpos($sList3[0],"@") && !strpos($sList3[0],"<input type=checkbox") && !strpos($sList3[0],"<TABLE") && $sList3)
			            {
			              	$sList3[0]=str_replace(array("<TD class=sb2>","\n"),"",$sList3[0]);
			           		$result['email'][]=$sList3[0];
			            }
						
			  }// End of for condition
			} while($last!='');
		
		     @unlink($strCookieName); // deleting cookie
			 if(isset($result)) {
				return $result;
			 }else{
				 return null;
			 }
	 }
	 
	 
function ImportContacts()
{
   // import Rediffmail contacts
	$strContacts = $this->ImportRediffmailContacts();
	$display_array="";
	if(is_null($strContacts)) { 
		return 1;
	}
	if(!empty($strContacts)){
		
		
						$count=count($strContacts['name']);

						for($c=0;$c<$count;$c++){
							if(strstr($strContacts['email'][$c],'@'))
							{
						     //remove none characters
						     $email = @preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$strContacts['email'][$c]);
						     $dataname = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$strContacts['name'][$c]);
							 $dataname = preg_replace("/img.*vspace0/","",$dataname);
						     $result = array('ContactsEmail' => $email,'ContactsName' => $dataname);
             			     $display_array[] = $result;
							}
		     			}
	 }
	 @unlink(TMP.$this->strUserName.'.cookie');
	if(empty($display_array))
		return 3;
	else
		return $display_array;
	
	// End of code
}
}
?>