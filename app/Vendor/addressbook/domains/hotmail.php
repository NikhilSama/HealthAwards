<?php
set_time_limit (0);
// +------------------------------------------------------------------------+
// | PHP version 5.0 					                                  	|
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Description:													      	|
// | Importing script for HotMail and Live Contacts          						|
// +------------------------------------------------------------------------+
class hotmail extends clsContactImporter
{
	function ImportHotmailContacts()
	{
	    set_time_limit(100); 
        $arrContacts = array();    
		$strDomainName = "http://mail.live.com/";   //setting the site for refer
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";	//setting browser type
		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w');  
		fclose($strCookieFile);
		$this->strCookieJar = realpath($strCookieName); 
		$strCookieJarFile = fopen($this->strCookieJar,'wb'); //this opens the file and resets it to zero length
		fclose($strCookieJarFile);

		//---------------------------------------------------STEP 1
		$strURL = "http://login.live.com/login.srf?id=2&vv=400&lc=1033";
		$arrLoginResult = $this->GetContacts($strURL,1);
       

       	preg_match_all("/name=\"PPFT\" id=\"i0327\" value=\"(.*?)\"/", $arrLoginResult, $arrPPFT);
		$strPPFTValue = $arrPPFT[1][0];
		
		preg_match_all("/.*?name=\"PPSX\".*?value=\"(.*?)\"/", $arrLoginResult, $arrPPSX);
		$strPPSXValue = $arrPPSX[1][0];
		
		preg_match_all("/.*?name=\"PwdPad\".*?value=\"(.*?)\"/", $arrLoginResult, $arrPwdPad);
		$strPwdPadValue= @$arrPwdPad[1][0];
		preg_match_all("/.*?method=\"POST\".*?action=\"(.*?)\"/", $arrLoginResult, $arrPostData);
		$strPostData = $arrPostData[1][0];
		
		preg_match_all("/.*?name=\"LoginOptions\".*?value=\"(.*?)\"/", $arrLoginResult, $arrLoginOptions);
		
        $strLoginOptionsValue = $arrLoginOptions[1][0];
		//---------------------------------------------------STEP 2
		
		$strPostFields = "LoginOptions=1258520306&CS=&FedState=&PPSX=".@$strPPSXValue."&type=11&login=".@$this->strUserName."&passwd=".urlencode(@$this->strPassword)."&remMe=1&NewUser=1&PPFT=".@$strPPFTValue."&i1=0&i2=2";
		$strURL = $strPostData; 
		$strResult = $this->DoLogin($strURL,$strPostFields,1); 
       preg_match_all("/replace\(\"(.*?)\"/", $strResult, $arrMatches);
		
		if(isset($arrMatches[1][0])) {
			$strMatches = $arrMatches[1][0];
		}

       //---------------------------------------------------STEP 3
		if(empty($strMatches))
			 return 1;
		else
		{
			$display_array=array();
            $strReplaceResult = $this->GetContacts($strMatches,1);
			preg_match('/id="UIFrame"([^>]*)src="([^"]*)"/si', $strReplaceResult, $arrSRC);
			$strSRC =$arrSRC[2]; 
            $strSRC =str_replace('&#58;' , ':' , $strSRC);
            $strSRC =str_replace('&#47;' , '/' , $strSRC);
			$strSRC =str_replace('&#63;' , '?' , $strSRC);
			$strSRC =str_replace('&#38;' , '&' , $strSRC);
            $strSRC =str_replace('&#61;' , '=' , $strSRC);
            $strReplaceResult = $this->GetContacts($strSRC,1);
            $arrDomain =parse_url($strSRC);
   
            if($arrDomain['host'] !='')
               $strDomain ='http://'.$arrDomain['host'];  
            else 
               $strDomain ='http://bl119w.blu119.mail.live.com'; 
       
            $i=1;
            $page=1; 
            
            do{     $strContactURL=$strDomain."/mail/ContactMainLight.aspx?n=&Page=".$i;
                    $strContactResult = $this->GetContacts($strContactURL,1);
                    if($i==1){
						 preg_match("/<div id=\"idConLstHdr\">(.*?)<\/div>/s", $strContactResult, $arrPage);
						 $strDiv=@$arrPage[0]; 
						 preg_match("/<span([^>]*)>(.*?)<\/span>/", $strDiv, $arrSpn);
						 $strSpn=@$arrSpn[2];
                         $strSpn=str_replace('&#x200e;','',$strSpn);   
                         $numeric = '/(\d+)/'; 
						 preg_match($numeric, $strSpn, $arrCnt);
						 $total=(int)$arrCnt[0]; 
						 $page=!empty($total) ? ceil($total/25) : 1;  
					}
                  
                    preg_match_all('/<array(.*?)class=["\']?cxp_ic_name cxp_ic_name_m["\']?(.*?)href="(.*?)"([^>]+)>(.*?)<\/a>/i', $strContactResult, $arrContacts); 
	                $arrName=isset($arrContacts[5]) ? preg_replace('/<span(.*?)>|<\/span>/','',$arrContacts[5]) :  array();  // name
					$arrCNT= isset($arrContacts[3]) ? $arrContacts[3] :  array();  // url
					if(!preg_match('/^http/i',@$arrCNT[0]) && !empty($arrCNT[0])){
                         foreach($arrCNT as $k=>$cnt)
                            $arrCNT[$k]="http://bl119w.blu119.mail.live.com/mail/".$cnt;
                    }
                   
                   foreach($arrName as $k=>$name){
                               /* if(!preg_match("/(\&\#64\;)|@/",$name)){ 
                                          $strViewResult = $this->GetContacts($arrCNT[$k],1); 
										  preg_match('/<iframe(.*?)src="([^"]*)"([^>]*)>/si', $strViewResult, $arrFrm);
                                            
                                          if(isset($arrFrm[2])){
											  $strFrameURL=$arrFrm[2];
											  $strFrameURL=str_replace('&#58;',':',$strFrameURL);
											  $strFrameURL=str_replace('&#47;','/',$strFrameURL);
											  $strFrameURL=str_replace('&#63;','?',$strFrameURL);
											  $strFrameURL=str_replace('&#61;','=',$strFrameURL);
											  $strFrameURL=str_replace('&#38;','&',$strFrameURL);   
											  $strViewResult = $this->GetContacts($strFrameURL,1);
                                          }

                                          preg_match_all('/<div id="cCollapsedView" class="ClearBoth">(.*?)<div class="cDetailsSeparator">/si', $strViewResult, $arrContactDiv);  
										  $strDiv=@$arrContactDiv[1][0]; 
										  preg_match_all('/<td class="Value"[ ]+><a[ ]+href="EditMessageLight.aspx(.*?)">(.*?)<\/a><\/td>/si', $strDiv, $arrContactTd); 
										  pr($arrContactDiv);
										  $strEmail=@$arrContactTd[2][0];  
										  if(!empty($strEmail)){
											   $strName=str_replace('&#64;','@',$arrName[$k]);
											   $strName=str_replace('&#8203;','',$strName); 
											   $display_array[] =array('ContactsEmail' => $strEmail,'ContactsName' =>$strName);
										   } 
                                  }
                                else {
                                        $name=str_replace('&#64;','@',$name); 
									    $name=str_replace('&#8203;','',$name);
                                        $display_array[] =array('ContactsEmail' => $name,'ContactsName' =>$name); 
                                     }   */  
							$display_array[] =array('ContactsEmail' => $name,'ContactsName' =>$name); 
                    } // end of foreach

               $i++; 
             } while($i<=$page);
            
            @unlink($strCookieName);
			return $display_array;
			
		}
	}
	

	// For Live Contacts 
	public function ImportLiveContacts()
	{
		$arrContacts = array();    
		
		$strDomainName = "http://mail.live.com/"; //setting the site for refer  
		$this->strUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//setting browser type 
		
		$strCookieName = TMP.$this->strUserName.'.cookie';  
		$strCookieFile = fopen($strCookieName,'w'); 
		fclose($strCookieFile);  
		
		$this->strCookieJar = realpath("$strCookieName"); 
		$strCookieJarFile = fopen($this->strCookieJar,'wb');//this opens the file and resets it to zero length
		fclose($strCookieJarFile); 

		//---------------------------------------------------STEP 1

		$strURL = "http://login.live.com/login.srf?id=64855";
		$arrLoginResult = $this->GetContacts($strURL,1);
		preg_match_all("/name=\"PPFT\" id=\"i0327\" value=\"(.*?)\"/",$arrLoginResult,$arrPPFT);
		$strPPFTValue = $arrPPFT[1][0];	
		preg_match_all("/srf_uPost='(.*?)';var/",$arrLoginResult,$arrPPSX);
		$strPPSXValue = $arrPPSX[1][0];
		
		//---------------------------------------------------STEP 2

		$strPostFields = 'idsbho=1&PwdPad=IfYouAreReadingThisYouHaveTooMuc&LoginOptions=3&login='.  $this->strUserName.'&passwd='.urlencode($this->strPassword).'&NewUser=1&PPFT='.$strPPFTValue;
		$strURL = $strPPSXValue;
		$strResult = $this->DoLogin($strURL,$strPostFields,1);
		// [pick up forwarding url]
		preg_match_all("/replace\(\"(.*?)\"/",$strResult,$arrMatches);
		$strPwdPadValue = $arrMatches[1][0];

		//---------------------------------------------------STEP 3

		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,$strPwdPadValue);
		curl_setopt($curl,CURLOPT_USERAGENT,$this->strUserAgent);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($curl,CURLOPT_REFERER,@$strRefererURL);
		curl_setopt($curl,CURLOPT_COOKIEFILE,$this->strCookieJar);
		curl_setopt($curl,CURLOPT_COOKIEJAR,$this->strCookieJar);
		$arrLoginResult = curl_exec($curl);
		curl_close($curl);
		preg_match_all("/href=\"(.*?)\"/",$arrLoginResult,$arrMatches);
		$strPostData = $arrMatches[1][0];

		$strLiveMailURL = preg_replace("/\/mail.*/",'',$strPostData);
		$strURL = $strLiveMailURL.'/mail/mail.aspx';

		//---------------------------------------------------STEP 4

		$arrLoginResult = $this->GetContacts($strURL,1);
		preg_match_all("/\"\/(.*?)\"/",$arrLoginResult,$arrMatches);  
		$strMatches = @$arrMatches[1][0];
		$strTempURL = $strLiveMailURL.'/'.$strMatches;
		
		//---------------------------------------------------STEP 5

		$strURL = $strTempURL;
		$arrLoginResult = $this->GetContacts($strURL,1);
		preg_match_all("/InboxLight.aspx.n=(.*?)\"/",$arrLoginResult,$arrMatches);
		$strMatches = @$arrMatches[1][0];
		$strTempURL = $strLiveMailURL.'/mail/InboxLight.aspx?n='.$strMatches;

		//---------------------------------------------------STEP 6

		$strURL = $strTempURL;
		$arrLoginResult = $this->GetContacts($strURL,1);

		//---------------------------------------------------STEP 7

		$strURL = $strTempURL;
		$arrLoginResult = $this->GetContacts($strURL,1);
		preg_match_all("/EditMessageLight.aspx._ec=1&n.(.*?)\"/",$arrLoginResult,$arrMatches);
		$strMatches = @$arrMatches[1][0]; 
		$strTempURL = $strLiveMailURL.'/mail/EditMessageLight.aspx?_ec=1&n='.$strMatches;

		//---------------------------------------------------STEP 8

		$strURL = $strTempURL;
		$arrLoginResult = $this->GetContacts($strURL,1);
		preg_match_all("/href=\"javascript:pickContact.'(.*?)', '(.*?)'/",$arrLoginResult, $arrMatches,PREG_SET_ORDER);

		@unlink ($this->strCookieJar);

		return $arrMatches;
	}
	
  function ImportContacts()
  {
	$mycookie = $this->strUserName.'.cookie';  

	## import hotmail contacts
	 $arrHtContacts = $this->ImportHotmailContacts();
 
    if($arrHtContacts == '1')
	{
		@unlink($mycookie);
		return 1;
	}
	else
	{
		
       if(empty($arrHtContacts))
		{
			$arrContacts = $this->ImportLiveContacts(); 
           if(empty($arrContacts['0']['0']))
			{
				@unlink($mycookie);
				return 3;
			}
			else
			{
				$i = 0; 
				//  Results - Start Of Contacts List &#8203;
				while(isset($arrContacts[$i])):
					$name = $arrContacts[$i][2];
					$dataname = $name;
					$dataname = str_replace('&#32','',$dataname);
					$dataname = str_replace('&#64','',$dataname);
                    $dataname = str_replace('%40','@',$dataname);
				    $dataname = str_replace('x40','@',$dataname);
                   
                   if (empty($dataname)) 
					{
						 $dataname = str_replace('%40','@',($arrContacts[$i][1]));
						 $dataname = str_replace('x40','@',($dataname));
                         $dataname = str_replace('&#32','',$dataname);
						 $dataname = str_replace('&#64','',$dataname);
					}
                    $email = str_replace('%40','@',($arrContacts[$i][1]));
					$email = str_replace('x40','@',($email));
					$email = str_replace('&#32','',$email);
					$email = str_replace('&#64','',$email);

					//remove none characters
					$email1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$email);
					$dataname1 = preg_replace("/[^a-z0-9A-Z_-\s@\.]/","",$dataname);

					$result = array('ContactsEmail' => $email1,'ContactsName' => $dataname1);
					
					$display_array[] = $result;
                    
                    $i++;
				endwhile;
				@unlink($mycookie);
                @unlink($myFile);//deleting csv file
				return $display_array;
			}
		}
		else
		{   
            return $arrHtContacts;
		}
	}


	@unlink($mycookie);
	if(empty($display_array))
		return 3;
	else
		return $display_array;
}
}
?>
