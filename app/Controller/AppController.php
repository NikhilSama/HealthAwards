<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
        

	public $components = array('Session'/*,'DebugKit.Toolbar'*/);
	public $helpers = array('Html', 'Form', 'Session', 'Js');
	public $webExpertise = array();
	public $genderList = array();
	public $productList = array('3'=>'werr');
    function beforeFilter() {
        $this->request->params['controller'] = str_replace('-', '_', $this->request->params['controller']);
        $this->request->params['action'] = str_replace('-', '_', $this->request->params['action']);
        header('Cache-Control: no-store, no-cache, must-revalidate');     // HTTP/1.1 
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
    }
    
    function beforeRender(){
        $this->view = str_replace('-', '_', $this->view);
    }
    function sendEmail($to, $subject, $template, $data=null, $format='html', $from=HEALTHOS_EMAIL, $attachments=null, $cc=null) {
        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail('smtp');
        if ($data != null) {
            $email->viewVars($data);
        }
        if ($from != HEALTHOS_EMAIL)
            $replyTo = $from;
        else {
            $from = unserialize(HEALTHOS_EMAIL);
            $replyTo = 'noreply@healthos.com';
        }
        if (!is_null($attachments))
            $email->attachments($attachments);
        if (!is_null($cc))
            $email->cc($cc);
        $email->template($template);
        $email->emailFormat($format);
        $email->to($to);
        $email->replyto($replyTo);
        $email->from($from);
        $email->subject($subject);
        try {
            $email->send();
            return true;
        } catch (Exception $e) {
            return true;
        }
    }
    /* set meta Keywords */
	public function setMetaKeywords($pageKeywords) {

		$toSet = SEO_SITE_KEYWORDS;

        if (isset($this->sectionKeywords))
            $toSet.=$this->sectionKeywords;

        if ($pageKeywords != null)
            $toSet.=$pageKeywords;

		$this->set('metakeywords_for_layout',$toSet);
	}

    /* set meta description */
    function setMetaDescription($pageDescription) {

        if ($pageDescription != null)
            $this->set('metadescription_for_layout',$pageDescription);
    }
    
	public function setPageTitle($pageTitle) {
        if ($pageTitle != null)
            $this->pageTitle = SEO_PAGE_TITLE_PREFIX.$pageTitle;
    }
	

	public function _checkDoctorSession() {

		if (!$this->Session->check('User') || $this->Session->check('User.role')!=1) {
			$logoutUrl=LOGOUT_URL;			
			if($this->request->is('ajax')){
				echo "You have been logged out, Please again login! <a href='".$logoutUrl."'>Login</a>";
				exit;
			}
			$url = $this->request->url;
			$errors[] = 'You need to login to access this page';
			$this->Session->setFlash('','flash',$errors);
			$this->redirect('/users/login/'.$url);
			exit();
		}else {
			$userSession= $this->Session->read('User');
			
			return $userSession;
		}
	}
	public function _checkPatientSession() { 
		if (!$this->Session->check('User') || $this->Session->check('User.role')!=2) {
			$logoutUrl=LOGOUT_URL;			
			if($this->request->is('ajax')){
				echo "You have been logged out, Please again login! <a href='".$logoutUrl."'>Login</a>";
				exit;
			}
			$url = $this->request->url;
			$errors[] = 'You need to login to access this page';
			$this->Session->setFlash('','flash',$errors);
			$this->redirect('/users/login/'.$url);
			exit();
		}else {
			$userSession= $this->Session->read('User');
			
			return $userSession;
		}
	}

	public function _writeDoctorSession($userid,$username,$role) {
		$this->loadModel('Doctor');
		$userVar = $this->Doctor->get_doctor_session_vars($userid);
		$userdata['id'] = $userid;
		$userdata['username'] = $username;
		$userdata['role'] = $role;
		$userdata['userInfo'] = $userVar;
		$this->Session->write('User', $userdata);
	}
    
	
	public function array2json($arr) {
		if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
		$parts = array();
		$is_list = false;
		
		//Find out if the given array is a numerical array
		$keys = array_keys($arr);
		$max_length = count($arr)-1;
		if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
			$is_list = true;
			for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
				if($i != $keys[$i]) { //A key fails at position check.
					$is_list = false; //It is an associative array.
					break;
				}
			}
		}
		
		foreach($arr as $key=>$value) {
			if(is_array($value)) { //Custom handling for arrays
				if($is_list) 
					$parts[] = array2json($value); /* :RECURSION: */
				else 
					$parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
			} else {
				$str = '';
				if(!$is_list) $str = '"' . $key . '":';
				
				//Custom handling for multiple data types
				if(is_numeric($value)) $str .= $value; //Numbers
				elseif($value === false) $str .= 'false'; //The booleans
				elseif($value === true) $str .= 'true';
				else $str .= '"' . addslashes($value) . '"'; //All other things
				// :TODO: Is there any more datatype we should be in the lookout for? (Object?)
				
				$parts[] = $str;
			}
		}
		$json = implode(',',$parts);

		if($is_list) return '[' . $json . ']';//Return numerical JSON
		return '{' . $json . '}';//Return associative JSON
	} 
}
