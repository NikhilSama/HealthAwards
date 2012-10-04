<?php
class UsersController extends AppController {

	public $uses = array('User', 'Paging',  'UserDetail', 'Country','State','City');

	public $helpers = array('Html','Form','Ajax','Javascript','Util','Time');
	public $components = array('Encrypt','Cookie','Session','Email','RequestHandler');
	//public $layout=null;
	public function beforeFilter() {
		parent::beforeFilter();
	}
	public function index(){
		if($this->Session->check('User')){
		}else{
			$this->redirect('login');
		}
		exit();
	}
	public function logout() {
		$this->Session->setFlash('','flashSuccess',array("You've successfully logged out."));
		$this->Session->delete('User');
		$this->redirect('/users/login');exit();
	}

	public function login($controller=null,$action=null) {
		if($this->Session->check('User')){
			$this->redirect('/users/index');
			exit();
		}
		if (!empty($this->request->data)) { 
			$username = $this->request->data['User']['username'];
			$password = $this->request->data['User']['password'];
			
			$sql = 'select User.id,User.role from users User 
			where User.username = \''.$username.'\' and User.password = \''.md5($password).'\' and User.isActive=1';
			$userData = $this->Paging->query($sql);

            if(!empty($userData)) { 
				$userData = $userData[0]; 				
				
				$userRole = $userData['User']['role'];
				if($userRole==1){
					$this->_writeDoctorSession($userData['User']['id'],$username,$userRole);
					$this->redirect('/doctors/my_profile');
				}else{
					$this->redirect('/patients/dashboard');
				}
				$url = implode("/",$this->request->params['pass']);
				$this->redirect('/'.$url);
			}else {
				$errors[] = 'Invalid User email/password';
			}
			if($errors) {
				$this->request->data['User']['password']='';
				$this->Session->setFlash('', 'flash', $errors, 'flash');
			}
		}
	}
	 /**
     * this method is used for login 
     * @return redirect page to according to user registration
     */
    function registration() {
		
		//if user already logged then it is redirect it home page
        if ($this->Session->check('User')) {
            $this->redirect('/');
            exit();
        }
        
        $enterSiteUrl = '';
        if(!empty($this->request->params['pass'])){
			$url = implode("/",$this->request->params['pass']);
			$enterSiteUrl = '/'.$url;
		}
        $redirectResubmission = 0;
        if (!empty($this->data)) { 
		
            $password = $this->data['User']['password'];
            $mobileno = $this->request->data['UserDetail']['mobile'] = trim($this->data['UserDetail']['mobile']);
            App::uses('Sanitize', 'Utility');

            if (isset($this->data['UserDetail']['fullname'])) {
                $fullname =trim($this->data['UserDetail']['fullname']);
            }

            if(!isset($this->data['UserDetail']['company']))    
                    $this->request->data['UserDetail']['company']='';
            if(!isset($this->data['UserDetail']['url']))    
                    $this->request->data['UserDetail']['url']='';
            $userids = $this->User->registration($this->request->data);
            $userid = $userids['userid'];
            if ($userid != 0) {
                if (isset($userids['commit']) && $userids['commit'] == 1) {
                    // **** This code is using for campaign conversion tracking by different SEOs ************
                    $this->request->data['UserDetail']['userId'] = $userid;
                   
                    $data['data']['password'] = $this->data['User']['password'];
                    $data['data']['email'] = $this->data['User']['email'];
                    $data['data']['username'] = '';
                    $data['data']['fname'] = '';
                    $data['data']['lname'] = '';
					$data['data']['fullname'] = (isset($fullname)?$fullname:'User');

                    $data['data']['subject'] = "Welcome to the world of testing.com";
                    $domainName = 'http://' . $_SERVER['HTTP_HOST'] . '/';
                    $data['data']['url'] = $domainName;
                    
                    $template = 'registeruser';
                    $this->sendEmail($this->data['User']['email'], $data['data']['subject'], $template , $data['data']);
                                        
                    $this->_writeUserSession($userid);
					
                    if (!empty($this->request->params['pass'])) {
                        $redirectUrl = '/' . implode("/", $this->request->params['pass']);
                    } else {
                        $redirectUrl = '/users/dashboard/';
                    }
                    
                    $this->redirect($redirectUrl);
                    exit();
                } else {
                    $posteddata = $this->data;
                    $this->request->data['User']['password'] = $password;
                }
            } else {
                $this->set('errors', $userids);
                $posteddata = $this->data;
                $this->request->data['User']['password'] = $password;
            }
        } else {
            
        }
        $this->set('enterSiteUrl', $enterSiteUrl);
    }
    
	/*
	function forgot_password(){
		if($this->Session->check('User')) {
			$this->redirect('/');
			exit();
		}
		$errors=array();
		if(isset($this->request->data) ) {
			if(!isset($this->request->data['User']['email']) || $this->request->data['User']['email']=='') {
				$errors['email'] = 'Please enter the emailId';  
			}
			if(!$errors){
				{
					$email =  $this->request->data['User']['email'];
					$row = $this->User->forgetpassword($email);
					if($row){
						$subuser = 'temp';
						$rand = rand(4,9999);
						$password = $subuser.$rand;
						$encodeduserpassword = md5($password);
						$username=$row['username'];
						$data['id']=$row['id'];
						$data['password']=$encodeduserpassword;
						$this->User->save($data);
						$mail['data']['type'] = 'schooluserpassword';
						$mail['data']['subject'] = "New Password";
						$mail['data']['password'] = $password;
						$mail['data']['username'] = $username;
						$mail['data']['email'] = $email;
						$domainName = 'http://'.$_SERVER['HTTP_HOST'].'/';
						$mail['data']['url'] = $domainName.'/teachers/login';
						$this->sendEmail($mail['data']['email'],$mail['data']['subject'],'forgotpassword',$mail['data']);
						$this->Session->setFlash('','flashSuccess',array("Your password have been sent in your email id please check the mail box."));
						
					}else{
						$errors['email']= 'EmailId not found';  
					}
				}
			}
			if($errors){
			$this->set('errors',$errors);
		    $this->Session->setFlash('','flash',$errors);
			}
		}
	}
	
	
	function change_password(){
		
		$user = $this->_checkUserSession();
		if(!empty($this->request->data)) {
			if(isset($this->request->data['User']['Cancel'])) {
				$this->redirect('/users/my-profile');
				exit(0);
			}
			$oldpassword = $this->request->data['User']['oldpassword'];
			$newpassword = $this->request->data['User']['newpassword'];
			$confirmpassword = $this->request->data['User']['confirmpassword'];

			if($oldpassword == '') {
				$this->User->invalidate('emptyoldpassword');
				$errors[0] = 'old password is blank';
			}

			if($newpassword == '') {
				$this->User->invalidate('emptypassword');
				$errors[1] = 'new password is blank';

			}elseif((strlen($newpassword)<6 || strlen($newpassword)>20) || (strlen($confirmpassword)<6 || strlen($confirmpassword)>20)) {
				$this->User->invalidate('emptypassword');
				$errors[1] = 'password should be atleast 6 characters and not more than 20 characters';
			}elseif((strlen(str_replace(chr(32),'',$newpassword)) != strlen($newpassword)) || (strlen(str_replace(chr(32),'',$confirmpassword)) != strlen($confirmpassword))) {
                $this->User->invalidate('emptypassword');
                $errors[1] = 'Space is not allowed in password';
            }
			if($newpassword != $confirmpassword) {
			   $this->User->invalidate('missmathpassword');
			   $errors[2] = 'entered passwords mismatch';

			}
			
			$userid = $user['id'];
			$userpasssword = $this->User->field("password","User.id='".$userid."'");
			if(md5($oldpassword) != $userpasssword && $oldpassword != '') {
				$this->User->invalidate('wrongpassword');
				$errors[3] = 'wrong password entered';

			}
			$data['User']['password'] = md5($newpassword);
			$data['User']['id'] = $userid;
			if($this->User->save($data['User'])) {

				$this->Session->setFlash('','flashSuccess',array("You've successfully changed password."));
				$this->redirect('/users/my_profile');exit();
			}else {
				$this->set('errors',$errors);
				$this->Session->setFlash('','flash',$errors);
				$this->render('change_password');
			}
		}
	}
	public function termsandcondition(){
	}*/
}
?>