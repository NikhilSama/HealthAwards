<?php
class User extends AppModel {
    public $name = 'User';
    public $useTable = 'users';
    

    function beforeSave() {
        /*if (!empty($this->data['User']) && isset($this->data['User']['id']) && $this->data['User']['id'] > 0) {
            $userId = $this->data['User']['id'];
            $qry = 'INSERT INTO user_history SELECT * FROM users WHERE id=\'' . $userId . '\'';
            $this->query($qry);
        }*/
        return true;
    }

    /**
     * This function is used for encrypt password
     * @ param array $data
     * @ return array
     */
    function hashPasswords($data) {
        if (is_array($data) && array_key_exists('User', $data) && array_key_exists('password', $data['User']))
            if (!array_key_exists('email', $data['User']))
                $data['User']['password'] = md5($data['User']['password']);
        return $data;
    }

    /**
     * This function is used for validate user submit data
     * @ param array $data
     * @ param integer $flag
     * @ param array $userdata
     * @ return array
     */

    function userValidation($data, $flag=null, $userdata=null) {
        if (isset($data['email'])) {
            if ($data['email'] == '') {
                $this->invalidate('useremail');
                $errors['email'] = 'E-mail id field is empty';
            } elseif (strpos(trim($data['email']), ' ')) {
                $this->invalidate('useremail');
                $errors['email'] = 'Email should not contain any spaces.';
            } elseif (strpos($data['email'], '/')!==false || strpos($data['email'], '#')!==false  || strpos($data['email'], '%')!==false ) {
                $this->invalidate('useremail');
                $errors['email'] = 'Email should not contain special character.';
            } elseif (($data['email'][0] == '@' || $data['email'][0] == '.')) {
                $this->invalidate('useremail');
                $errors['email'] = 'Email cannot start with "@" or "."';
            } elseif (strlen(substr($data['email'], strrpos($data['email'], '.') + 1)) < 2 || strlen(substr($data['email'], strrpos($data['email'], '.') + 1)) > 3) {
                $this->invalidate('useremail');
                $errors['email'] = 'Your E-mail id is not complete. It should be like abc@example<span class="textRed bold">.com</span>';
            } elseif (!strpos($data['email'], '.')) {
                $this->invalidate('useremail');
                $errors['email'] = 'You forgot to include .(dot) in your E-mail id. For eg. abc@example<span class="textRed bold">.</span>com';
            } elseif (!strpos($data['email'], '@')) {
                $this->invalidate('useremail');
                $errors['email'] = 'You forgot to include @ in your E-mail id. For eg. abc<span class="textRed bold">@</span>example.com';
            } elseif (strpos($data['email'], ',') || strpos($data['email'], ';')) {
                $this->invalidate('useremail');
                $errors['email'] = 'Email should not contain special characters like "," or ";"';
            } elseif (substr_count($data['email'], '@') > 1) {
                $this->invalidate('useremail');
                $errors['email'] = 'Your E-mail id cannot contain more than one <span class="textRed bold">@</span> character. For eg. abc@example.com';
            } elseif ($data['email'] == 'abc@example.com') {
                $this->invalidate('useremail');
                $errors['email'] = 'Please enter your own email id';
            } elseif (!preg_match(MERITNATION_VALID_EMAIL, $data['email'])) {
                $this->invalidate('useremail');
                $errors['email'] = 'Invalid E-mail id. E-mail should be like abc@example.com';
            } elseif ($flag == 1) {
                if ($this->findMaster('count', array('conditions' => array('User.email' => $data['email'])))) {
                    $this->invalidate('useremailExist');
                    $errors['email'] = 'You already have an account. <a id="forgotPwdLink" href="/users/forgotpassword/' . $data['email'] . '?mncid=regForgotLink"><u>Click here to get your password</u></a>';
                }
            }
        }
        if (isset($data['username'])) {
            if ($data['username'] == '') {
                $this->invalidate('userusername');
                $errors['username'] = 'Username Fiels is Empty';
            } elseif (!preg_match('/^[a-z]/i', $data['username'])) {
                $this->invalidate('userusername');
                $errors['username'] = 'Username must start with an alphabet. E.g. abcd_123';
            } elseif (!preg_match('/^[a-z]+([._-]{0,1}[a-z0-9])+$/i', $data['username'])) {
                $this->invalidate('userusername');
                $errors['username'] = 'Username is not valid. {Only alphabets, numbers, ., -, _ are allowed} E.g. abcd_123';
            } elseif (strlen($data['username']) < 5) {
                $this->invalidate('userusername');
                $errors['username'] = 'Username should be atleast 5 characters long.';
            } elseif (strlen($data['username']) > 20) {
                $this->invalidate('userusername');
                $errors['username'] = 'Username should not exceed more than 20 characters.';
            } elseif ($this->findMaster('count', array('conditions' => array('User.username' => $data['username'])))) {
                $this->invalidate('userusername');
                $errors['username'] = 'Username not available. This username is already taken by another user.';
            }
        }

        if (isset($data['password'])) {
            if ($data['password'] == '') {
                $this->invalidate('userpassword');
                $errors['password'] = 'Password field is empty';
            } elseif (strlen($data['password']) < 4) {
                $this->invalidate('userpassword');
                $errors['password'] = 'Password should have minimum 4 characters';
            } elseif (strlen(str_replace(chr(32), '', $data['password'])) != strlen($data['password'])) {
                $this->invalidate('userpassword');
                $errors['password'] = 'Spaces not allowed in password';
            } elseif (strlen($data['password']) > 20) {
                $this->invalidate('userpassword');
                $errors['password'] = 'Password should not exceed more than 20 characters';
            }
            // mismatch password....
            if ($data['password'] != $data['confirmpassword']) {
                $this->invalidate('confirmpasswordErr');
                $errors['confirmpassword'] = 'Passwords do not match';
            }
        }

        if (isset($errors))
            return $errors;
    }

    /**
     * This function is used for get user seesion value
     * @ param integer $userid
     * @ param integer $isProductSession
     * @ param integer $supportUserId
     * @ return array
     */
    function get_user_session_vars($userId) {
        $userdetail = $this->findById($userId);
		
		$joins[] = array('table' => 'user_details', 'alias' => 'UserDetail', 'type' => 'INNER', 'conditions' => array('User.id = UserDetail.userId'));

        $userdetail = $this->findMaster('first', array('joins' => $joins, 'conditions' => array('User.id' => $userId), 'fields' => array('User.email,User.username,UserDetail.country,UserDetail.state,UserDetail.city,UserDetail.address,UserDetail.fname, UserDetail.lname, UserDetail.userImage,UserDetail.phone, UserDetail.mobile,  Country.name, State.name, City.name'), 'recursive' => '-1'));
        $userVar['fname'] = $userdetail['UserDetail']['fname'];
        $userVar['lname'] = $userdetail['UserDetail']['lname'];
        $userVar['countryId'] = $userdetail['UserDetail']['country'];
        $userVar['stateId'] = $userdetail['UserDetail']['state'];
        $userVar['cityId'] = $userdetail['UserDetail']['city'];
		$userVar['countryName'] = $userdetail['Country']['name'];
        $userVar['stateName'] = $userdetail['State']['name'];
        $userVar['cityName'] = $userdetail['City']['name'];
        $userVar['address'] = $userdetail['UserDetail']['address'];
        $userVar['phone'] = $userdetail['UserDetail']['phone'];
        $userVar['email'] = $userdetail['User']['email'];
        $userVar['username'] = $userdetail['User']['username'];    
        $userVar['mobile'] = $userdetail['UserDetail']['mobile'];
        $userVar['userImage'] = $userdetail['UserDetail']['userImage'];

        return $userVar;
    }
	/**
     * This function is used for display user name
     * @ param array $userdetail
     * @ return string
     */
    function _displayUsername($userdetail) {
        if (!is_array($userdetail) || !isset($userdetail['email']))
            return false;
        if (!isset($userdetail['fname']))
            $userdetail['fname'] = '';
        if (!isset($userdetail['lname']))
            $userdetail['lname'] = '';
        if (!isset($userdetail['username']))
            $userdetail['username'] = '';
        $email_array = explode('@', $userdetail['email']);
        if (!empty($userdetail['fname']) && !empty($userdetail['lname']))
            $userfullname = $userdetail['fname'] . ' ' . $userdetail['lname'];
        else if (!empty($userdetail['fname']) && empty($userdetail['lname']))
            $userfullname = $userdetail['fname'];
        elseif (!empty($userdetail['username']))
            $userfullname = $userdetail['username'];
        else
            $userfullname = $email_array[0] . '...';
        return $userfullname;
    }


    /**
     * This function is used for user registration
     * @ param array $data
     * @ return array
     */
    function registration($data) {
        $errors = array();
        $userid = 0;
        $data['User']['password'] = isset($data['User']['password']) ? $data['User']['password'] : '';
        if (isset($data['User']['indexpage'])) {
            $data['User']['confirmpassword'] = $data['User']['password'];
        } else {
            $data['User']['confirmpassword'] = ($data['User']['confirmpassword']);
        }
        $data['User']['email'] = trim($data['User']['email']);
        $userErrors = $this->userValidation($data['User'], 1);
        App::import('model', 'UserDetail');
        $UserDetail = new UserDetail();
        $userDetailsErrors = $UserDetail->userDetailValidation($data['UserDetail'], 1);
        if ($data['User']['termsCondition'] == '0') {
            $this->invalidate('invalidVerificationcode');
            $errors['termsCondition'] = 'accept terms and condition';
        }
        if (isset($userErrors) && isset($errors) && isset($userDetailsErrors))
            $errors = $userErrors + $userDetailsErrors + $errors;
        elseif (isset($userErrors) && isset($userDetailsErrors))
            $errors = $userErrors + $userDetailsErrors;
        elseif (isset($userErrors) && isset($errors))
            $errors = $userErrors + $errors;
        elseif (isset($errors) && isset($userDetailsErrors))
            $errors = $userDetailsErrors + $errors;
        elseif (isset($userErrors))
            $errors = $userErrors;
        elseif (isset($userDetailsErrors))
            $errors = $userDetailsErrors;
        $password = $data['User']['password'];
        $encryptedpassword = md5($password); // generate encoded password...
        $data['User']['password'] = $encryptedpassword;
       
        if (count($errors) == 0) {
            $this->begin(); // Start Transaction queries
            if ($this->save($data['User'])) {
                $userid = $this->getLastInsertId();
                $errors['userid'] = $userid;
		         App::import('model', 'UserDetail');
                $UserDetail = new UserDetail();
                $data['UserDetail']['userId'] = $userid;
                if ($UserDetail->save($data)) {
                    $this->commit(); // Persist the data
                    $errors['commit'] = 1;
                   
                } else {
                    $this->rollback();
                    $errors['commit'] = 0;
                }
            }
        }
        if ($userid > 0) {
            return $errors;
        } else {
            $errors['userid'] = 0;
            return $errors;
        }
    }

    /**
     * This function is used for forget password it is search username, email name etc 
     * @ param string $username
     * @ return array
     */
    function forgetpassword($username) {
        $username = mysql_escape_string($username);
        $data = array();
        $user = $this->find('first', array('conditions' => array('User.username = \'' . $username . '\' or User.email = \'' . $username . '\''), 'fields' => array('User.id', 'User.username', 'User.email', 'UserDetail.fname', 'UserDetail.lname', 'User.isActive', 'User.password')));
        if ($user) {
            $data['username'] = $user['User']['username'];
            $data['email'] = $user['User']['email'];
            $data['fname'] = $user['UserDetail']['fname'];
            $data['lname'] = $user['UserDetail']['lname'];
            $data['isActive'] = $user['User']['isActive'];
            $data['id'] = $user['User']['id'];
        }
        return $data;
    }
    /**
     * This function is used for get activation code
     * @ param integer $userId
     * @ return array
     */
    function send_activation_code($userId) {
        return $this->field('activationCode', array('User.id' => $userId));
    }

    /**
     * This function is used for mobile validation
     * @ param string $mobile
     * @ return string
     */
    function is_valid_mobile($mobile) {
        $response = 1;
        if ($mobile == '') {
            $response = 'Type your mobile number';
        } elseif (!preg_match(MERITNATION_VALID_MOBILENUMBER, $mobile) || preg_match(REPEATED_MOBILENUMBER, $mobile) || preg_match(INCREMENT_MOBILENUMBER, $mobile)) {
            $response = 'Invalid mobile number';
        }
        return $response;
    }

    /**
     * Method used to get the user details of a particualr user
     * @param integer $userid
     * @param integer $type
     * @return array 
     */
    function get_user_details($userid, $type=1, $basicInfo=null) {
           if (is_null($basicInfo)) {
            
            $joins[] = array('table' => 'user_details', 'alias' => 'UserDetail', 'type' => 'INNER', 'conditions' => array('UserDetail.userId=User.id'));
            $joins[] = array('table' => 'cities', 'alias' => 'City', 'type' => 'Inner', 'conditions' => array('UserDetail.city= City.id'));
			$joins[] = array('table' => 'states', 'alias' => 'State', 'type' => 'Inner', 'conditions' => array('UserDetail.state = State.id'));
			$joins[] = array('table' => 'countries', 'alias' => 'Country', 'type' => 'Inner', 'conditions' => array('UserDetail.country = Country.id'));

			$fields = array('User.email,User.username,UserDetail.country,UserDetail.state,UserDetail.city,UserDetail.address,UserDetail.fname, UserDetail.lname, UserDetail.userImage,UserDetail.phone, UserDetail.mobile,  Country.name, State.name, City.name');
            return $this->findMaster('first', array('joins' => $joins, 'conditions' => array('User.id' => $userid), 'fields' => $fields));
        } else {
            return $this->findMaster('first', array('conditions' => array('User.id' => $userid)));
        }
    }

    /**
     * Get ids for given emails 
     * @param array $correctEmail
     * @return array 
     */
    function get_users_ids($correctEmail) {
        $correctEmailString = implode(',', $correctEmail);
        return $this->find('all', array('conditions' => array('User.email in (' . $correctEmailString . ')'), 'fields' => array('User.id,User.email')));
    }

    
    /**
     * Method used to check whether the email is valid or not
     * @param string $email
     * @return string/int 
     */
    function is_valid_email($email, $isDBcheck=true) {
        $response = 1;
        if ($email == '') {
            $response = 'E-mail id field is empty';
        } elseif (strpos(trim($email), ' ')) {
            $response = 'Email should not contain any spaces.';
        } elseif (strpos($email, '/')!==false || strpos($email, '#')!==false  || strpos($email, '%')!==false ) {
            $response = 'Email should not contain special character.';
        } elseif ($email[0] == '@' || $email[0] == '.') {
            $response = 'Email cannot start with "@" or "."';
        } elseif (strlen(substr($email, strrpos($email, '.') + 1)) < 2 || strlen(substr($email, strrpos($email, '.') + 1)) > 3) {
            $response = 'Your E-mail id is not complete. It should be like abc@example<span class="textRed bold">.com</span>';
        } elseif (!strpos($email, '.')) {
            $response = 'You forgot to include .(dot) in your E-mail id. For eg. abc@example<span class="textRed bold">.</span>com';
        } elseif (!strpos($email, '@')) {
            $response = 'You forgot to include @ in your E-mail id. For eg. abc<span class="textRed bold">@</span>example.com';
        } elseif (strpos($email, ',') || strpos($email, ';')) {
            $response = 'Email should not contain special characters like "," or ";"';
        } elseif (substr_count($email, '@') > 1) {
            $response = 'Your E-mail id cannot contain more than one <span class="textRed bold">@</span> character. For eg. abc@example.com';
        } elseif ($email == 'abc@example.com') {
            $response = 'Please enter your own email id';
        } elseif (!preg_match(MERITNATION_VALID_EMAIL, $email)) {
            $response = 'Invalid E-mail id. E-mail should be like abc@example.com';
        } elseif ($isDBcheck && $this->hasAnyMaster(array('User.email' => $email))) {
            $response = 'Email already in use';
        }

        return $response;
    }

    function update_user($data) {
        $this->save($data);
    }

    function get_user_password($userid) {
        return $this->find('first', array('conditions' => array('User.id' => $userid), 'fields' => array('User.password')));
    }

    function get_users($conditions, $limit = null, $userIdIndex = false) {
        $usersDetail = $this->find('all', array('conditions' => $conditions, 'fields' => array('User.id', 'User.username', 'User.email', 'UserDetail.userImage', 'UserDetail.fname', 'UserDetail.lname'), 'limit' => $limit));
        $users = array();
        foreach ($usersDetail as $key => $value) {
            if ($userIdIndex) {
                $users[$value['User']['id']]['displayName'] = $this->_displayUsername(array('email' => $value['User']['email'], 'username' => $value['User']['username'], 'fname' => $value['UserDetail']['fname'], 'lname' => $value['UserDetail']['lname']));
                $users[$value['User']['id']]['username'] = $value['User']['username'];
                $users[$value['User']['id']]['userImage'] = $value['UserDetail']['userImage'];
            } else {
                $users[$key]['displayName'] = $this->_displayUsername(array('email' => $value['User']['email'], 'username' => $value['User']['username'], 'fname' => $value['UserDetail']['fname'], 'lname' => $value['UserDetail']['lname']));
                $users[$key]['username'] = $value['User']['username'];
                $users[$key]['userId'] = $value['User']['id'];
                $users[$key]['userImage'] = $value['UserDetail']['userImage'];
            }
        }
        return $users;
    }

  
    function getUniqueEmail($email) {
        if (!$this->hasAnyMaster(array('User.email' => $email)))
            return $email;
        $emailArr = explode('@', $email);
        App::import('Component', 'Util');
        $Collection = new ComponentCollection();
        $Util = new UtilComponent($Collection);
        while (true) {
            $email = $emailArr[0] . strtolower($Util->randomStringGenerator(4)) . '@' . $emailArr[1];
            if (!$this->hasAnyMaster(array('User.email' => $email))) {
                break;
            }
        }
        return $email;
    }

  
}

?>