<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::import('Component','Qimage'); 
App::import('Model', 'DeviceToken');
App::import('Model', 'Document'); 
App::import('Model', 'Category');
App::import('Model', 'City');   
/**
 * User Model
 *
 * @property State $State
 * @property City $City
 * @property Bid $Bid
 * @property Company $Company
 * @property Job $Job
 * @property Rating $Rating
 */
class User extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	*/
	public $displayField = 'name';
 	public $actsAs = array('Containable');
 	public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'A username is required',
                'allowEmpty' => false
            ),
        ),
        'password' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'This field is required.',
                'allowEmpty' => false
            ),
        ),
        'email' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'This field is required.',
                'allowEmpty' => false
            ),
            'unique' => array(
                'rule'    => array('isUniqueEmail'),
                'message' => 'This email id is already in use'
            )
        )
	);  

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	*/
	public $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	*/
	public $hasMany = array(
		'Bid' => array(
			'className' => 'Bid',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Rating' => array(
			'className' => 'Rating',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),'UserToken' => array(
			'className' => 'UserToken',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	/** 
	 * [isUniqueUserName You can check if user name already exists in DB] 
	*/
	public function isUniqueUserName($check)
	{	
		$row=$this->find('first',array(
			'field'=>array(
				'User.id',
				'User.name'),
			'conditions'=>array(
				'User.name'=>$check),
				'recursive'=>-1)
		);	
		if(!empty($row))
		{			
			if($this->data[$this->alias]['id']!=$row['User']['id'])
			{
				return false;

			}else{
				
				return true;
			}
		}else{
			return true;
		}

	}

	/** 
	 * 
	 * [isUniqueEmail You can check if user email already exists in DB] 
	 */
	public function isUniqueEmail($check)
	{

		$row=$this->find('first',array(
			'feild'=>array(
				'User.id',
				'User.email'),
			'conditions'=>array(
				'User.email'=>$check),
				'recursive'=>-1)
		);
		if(!empty($row))
		{
			if($this->data[$this->alias]['id']!=$row['User']['id'])
			{
				return false;

			}else{
				
				return true;
			}
		}else{
		
			return true;
		}
	}


	public function alphaNumericDashUnderscore($check) {
	    // $data array is passed using the form field name as the key
	    // have to extract the value to make the function generic
	    $value = array_values($check);
	    $value = $value[0];
	    return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
	}

	/**
	* Before Save
	* @param array $options
	* @return boolean
	*/

	public function beforeSave($options = array()) {	
		if (!parent::beforeSave($options)) {
			return false;
		}
		if (isset($this->data[$this->alias]['password'])) {
			$hasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $hasher->hash($this->data[$this->alias]['password']);
		}
		return true;
	}


	/**
	* Return long-lived access token.
	*
	* @access protected
	*
	* @param int $id
	* @return string $token
	*/
	protected function _getAccessToken($id) 
	{
	    try {
	          // Make call to "_generateAccessToken" to get long-lived access token
	          $access_token = $this->_generateAccessToken($id);
	          // Update access token of user
	          //$this->_updateToken($id, $access_token);
	          // Return the newly created access token
	          return $access_token;
	    } catch (Exception $e) {
	          return $this->_returnJson(false, $e->getMessage());
	    }
	}

	/**
	* Generate unique access token to access APIs
	* It uses openssl_random_pseudo_bytes & SHA1 for generating access token
	*
	* @access protected
	*
	* @param int $id
	* @return string $token
	*/
	protected function _generateAccessToken($id) 
	{
	    try {
	          // Generate a random token
	          $token = bin2hex(openssl_random_pseudo_bytes(16)) . SHA1(($id * time()));
	          return $token;                  
	    } catch (Exception $e) {
	          return $this->_returnJson(false, $e->getMessage());
	    }
	}

	/**
	* This function update the access token and set the expiration date-time.
	*
	* @access protected
	*
	* @param int $id
	* @param string $access_token
	* @return void
	*/
	protected function _updateToken($id, $access_token) 
	{
		$this->User->id = $id;
		if ($this->User->exists()) 
		{
			// Set access token expiration date that will be in six month from the current moment
			$access_token_expiration = date('Y-m-d 00:00:00', strtotime('+6 months'));

			// Make array to update access token
			$temp = array(
				'User' => array(
					'id' => $id,
					'access_token' => $access_token,                             
				));
			$this->User->save($temp);
		}
	}

	


	/******************************************************************************* 
	 * 
	 * 						Model API Start Here
	 * 	
	*********************************************************************************/

	/**
	* @access public
	* @Method appSignUp.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :30_Oct_2017
	* @param string $Data    
	* @return User Details in Json Format
	*/
	
	public function appSignUp($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData);		
        $userName    = isset($name)  	?  strtolower($name)  	: '';
        $email       = isset($email) 	?  strtolower($email) 	: '';
        $password1    = isset($password) ?  $password : '';
        $phone       = isset($phone) 	?  $phone				: '';
        $address   	 = isset($address)  ? strtolower($address)  : '';
        $state_id    = isset($state_id) ? $state_id 			: '';
        $city_id     = isset($city_id) 	? $city_id 				: '';
        
        //$randN = rand(10000,time());
       $passvalue=explode("%",$password1);      
       $password=base64_decode($passvalue[1]);  
        if (empty($userName)) {
            $message = 'Please enter username';
            return false;
        }

        if((strlen($userName) < 5) || strlen($userName) >=50) {
            $message = 'Username must be between 5 to 50 characters';
            return false;
        }


        if (empty($email)) {
            $message ='Please enter email';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message ='Please enter a valid email';
             return false;
        }
       /* $emailPattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"; 
        if(!eregi($emailPattern, $email)){
            $message ='Please enter a valid email address like .com, .in, .net, .org etc..';
             return false;
        }*/
      //die('12');
      	if(empty($password)) {
            $message = 'Please enter password';
            return false;
        }

       /*if ($this->hasAny(array('User.name' => $userName))) {
            $message ='User name already exists.Please try with different user name';
             return false;           
        }*/
        if ($this->hasAny(array('User.email' => $email))) {
            $message ='An account already exists for this email';
             return false;          
        }

         if ($this->hasAny(array('User.phone' => $phone))) {
            $message ='An account already exists for this phone number';
             return false;          
        }

        $userArray['User']['name']      = $userName;       
        $userArray['User']['email']     = $email;
        $userArray['User']['password']  = $password;
        $userArray['User']['phone']     = $phone;
        $userArray['User']['address']  	= $address;
        $userArray['User']['state_id']  = $state_id;
        $userArray['User']['city_id']   = $city_id;
        $userArray['User']['city2_id']   = $city_id; 
        $userArray['User']['status']   = 1;
 
        //Genrate OTP for user
        $userArray['User']['otp']=substr(time(),4,6);
        $userArray['User']['otp_status']='1';     
 
        //changes code here
		$rndArr = range('a', 'z');
		$rand_code = $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)];
		$code = trim(md5($rand_code));
		$userArray['User']['activation_code'] = $code;
        if ($this->Save($userArray)) {
        	$message = 'Registration has been done successfully ! Check your email id for verification link';
            return $userArray;          
        } else {
            $message = 'Oops! Some error occurred, please try again';
            return false;
        } 	
	}

	/**
	* @access public
	* @Method appUserLogin.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 30_Oct_2017
	* @param 	 : string $Data    
	* @return User Details in Json Format
	*/
	
	public function appUserLogin($myArrayData=null, &$message='')
	{
		$DeviceToken = new DeviceToken();
		extract($myArrayData);
        $email       = isset($email) 	? strtolower($email) 	: '';
        $password1    = isset($password) ? $password : '';
        $login_type  = isset($login_type) ? strtolower($login_type) : '';   
	    $passvalue=explode("%",$password1);      
	    $password=base64_decode($passvalue[1]); 
        if (empty($email) && empty($password)) {
            $message = 'Invalid email or password. Try Again!';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message ='Please enter a valid email';
            return false;
        }

       /* $emailPattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"; 
        if(!eregi($emailPattern, $email)){
            $message ='Please enter a valid email address like .com, .in, .net, .org etc..';
            return false;
        }*/

        if(empty($password)) {
            $message = 'Please enter password';
            return false;
        }
        
        $loginArray = array('employer','employee');
        if (!in_array($login_type, $loginArray))
        {
        	$message ='Not a valid login type';
            return false;
        }
        //hashing the password for check it is valid or not
        $hashPassword = AuthComponent::password($password);
        
        //Get User Details by Email & Password
        $getUserDetails = $this->find('first', array(
        	'recursive' => 0,
            'conditions' => array(
                'User.email' => $email, 
                'User.password' => $hashPassword,				
                )
            ));
		//echo "<pre>";print_r($getUserDetails);die;

        if(!empty($getUserDetails))
        {	
        	/*if($getUserDetails['User']['is_loggedin'] == '1')
        	{
        		$message ='You\'ve already logged-in from other system';
            	return false;

        	}else */
        	if(($getUserDetails['User']['status'] == '0') && ($getUserDetails['User']['block'] == '0'))
			{
				// echo "<pre>";print_r($getUserDetails);die('1111');
				unset($this->validate['name']);
				unset($this->validate['email']);
				unset($this->validate['password']);	
				//$saveDetails['User']['access_token'] = $this->_getAccessToken($getUserDetails['User']['id']);
				$saveDetails['User']['id'] = $getUserDetails['User']['id'];	
				$saveDetails['User']['is_loggedin'] =1;					
				$this->Save($saveDetails);

				$saveDeviceTokenDetails['DeviceToken']['user_id']=$getUserDetails['User']['id'];
				$saveDeviceTokenDetails['DeviceToken']['token']= $this->_getAccessToken($getUserDetails['User']['id']);				
				$DeviceToken->save($saveDeviceTokenDetails); 

				unset($getUserDetails['User']['password']);      
				$message = 'You are logged-in successfully!';
				$getUserDetails['User']['login_type']=$login_type;
				$getUserDetails['User']['access_token']=$saveDeviceTokenDetails['DeviceToken']['token'];
				//$getUserDetails['User']['access_token']=$saveDetails['User']['access_token']; 
				$name=explode(" ",$getUserDetails['User']['name']); 				
				$getUserDetails['User']['name'] = $name[0]; 
				
				$getUserDetails['User']['otp_status']=$getUserDetails['User']['otp_status']; 
				$getUserDetails['User']['otp']=$getUserDetails['User']['otp'];
								
				return $getUserDetails;

			}else if(($getUserDetails['User']['status'] == '1') && ($getUserDetails['User']['block'] == '1')){
 				//echo "<pre>";print_r($getUserDetails);die('000');
				$message = 'Your Account is Still In-Active. Please Check Your Email and Authenticate Your Identity By Clicking The Verification Link!';
				return false;

			}else if(($getUserDetails['User']['status'] == '1') && ($getUserDetails['User']['block'] == '0')){

				$message = 'Your Account is In-Active state. Please try after sometime.';
				return false;

			}else if(($getUserDetails['User']['status'] == '0') && ($getUserDetails['User']['block'] == '1')){

				$message = 'Your Account is In-Active state. Please try after sometime.';
				return false;

			}
			
        }else{

        	$message = 'Invalid email or password. Try Again!';
            return false;
        }
	}
	/**
	* @access public
	* @Method appUserLogin.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 30_Oct_2017
	* @param 	 : string $Data    
	* @return User Details in Json Format
	*/
	
	public function appForgotPassword($myArrayData=null, &$message='')
	{

		extract($myArrayData);
        $email       = isset($email) 	? strtolower($email) 	: '';       
        if (empty($email)) {
            $message = 'Invalid email. Try Again!';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message ='Please enter a valid email';
            return false;
        }

        /*$emailPattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"; 
        if(!eregi($emailPattern, $email)){
            $message ='Please enter a valid email address like .com, .in, .net, .org etc..';
            return false;
        }*/
        if ($this->hasAny(array('User.email' => $email))) {

        	$userData = $this->find('first',array(
        		'recursive'=>-1,
        		'conditions'=>array(
        			'User.email'=>$email)
        		));

			$rndArr = range('a', 'z');
			$rand_code = $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)] . $rndArr[rand(0, 25)];
			$code = trim(md5($rand_code));			
			//$send_url = $this->pathvars["base_url"].'/users/reset_password/'.$code;			
			//echo "<pre>";print_r($base_url);die;
			$userArray['User']['id'] = $userData['User']['id'];
			$userArray['User']['verification_key'] = $code;
			$userArray['User']['verification_date'] = date("Y-m-d H:i:s");
			$emailUrl['User']['name']=$userData['User']['name'];
			$emailUrl['User']['email']=$email;
			$emailUrl['User']['code']=$code;			
			unset($this->validate['name']);                  
            unset($this->validate['password']);                  
            unset($this->validate['email']);            
            if($this->Save($userArray)){
            	$message ='Password reset information is sent to your registered email id';
            	return $emailUrl;

            }else{
            	$message ='Somthing went wrong';
            	return false;
            }			
        }else{
        	$message ='Invalid email, please enter correct email address';
            return false;  
        }
    }

    /**
	* @access public
	* @Method 	 :checkVerificationKey.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 31_Oct_2017
	* @param 	 : string $verification_key    
	* @return 	 : check verification key exists in db or not
	*/
	
	public function checkVerificationKey($myArrayData=null, &$message='')
	{
		extract($myArrayData);	
        $key       = isset($code) 	? strtolower($code) 	: '';
             
        if(empty($key))
        {
        	$message ='Please provide verification key';
            return false;
        }
        if ($this->hasAny(array('User.verification_key' => $key))) {
        	
        	if($this->_verifyDate($key))
        	{
        		$message ='Your Verification key is valid now you can set your new password';
            	return $key;
        	}else{
        		$message ='Sorry Url has been expired';
            	return false;
        	}    

        }else{        	
        	$message ='Verification key is not matching with our database';
            return false; 
        }
    }
    
    /**
	* @access public
	* @Method _verifyDate.
	* @Description: to verify the verification date for forgot password link
	* @Developer  : Rafi (Evon Technologies)
	* @Date       : 31_Oct_2017
	* @param      : string $verification_key    
	* @return     : 
	*/
	public function _verifyDate($verification_key)
	{
		$userData = $this->find('first',array('conditions'=>array('User.verification_key'=>$verification_key)));		
		$curr_date = strtotime(date("Y-m-d H:i:s"));
		$verification_date = $userData['User']['verification_date'];
		$valid_date = 30*24*60*60 + strtotime($verification_date);
		if($curr_date < $valid_date){ 
		      return true;
		}else{ 
		      return false;
		}
	}

	/**
	* @access public
	* @Method 	 : appChangePassword.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 31_Oct_2017
	* @param 	 : string $Data    
	* @return    : in Json Format
	*/
	
	public function appChangePassword($myArrayData=null, &$message='')
	{
		//extract comming array
		extract($myArrayData);
        $user_id      		= isset($user_id) 	? $user_id 			: ''; 
        $current_password1   = isset($old_pass) 	? $old_pass 		: ''; 
        $new_password1       = isset($new_pass) 	? $new_pass 		: '';
        $confirm_password1   = isset($conf_pass) ? $conf_pass 		: '';       
        
        /*
         password */
        $passvalue1=explode("%",$current_password1);      
        $current_password=base64_decode($passvalue1[1]);

        $passvalue2=explode("%",$new_password1);      
        $new_password=base64_decode($passvalue2[1]);

        $passvalue3=explode("%",$confirm_password1);      
        $confirm_password=base64_decode($passvalue3[1]);      
        if (empty($user_id)) {
            $message = 'Enetr User id. Try Again!';
            return false;
        }
        if (empty($current_password)) {
            $message = 'Enetr current password. Try Again!';
            return false;
        }
        if (empty($new_password)) {
            $message = 'Enetr new password. Try Again!';
            return false;
        }
        if ($confirm_password != $new_password) {
            $message = 'New & Confirm Password mismatch. Try Again!';
            return false;
        }

          $hasher = new SimplePasswordHasher();

        //Hash current password
       // $hashPassword = AuthComponent::password($current_password);                
		if (!$this->hasAny(array('User.id' => $user_id, 'User.password' =>$hasher->hash($current_password)))) {
			
			$message='Invalid current password. Please enter a correct password';
			return false;
		}	
		// Make an array to hold data
		$user = $this->findById($user_id);                 
        $user["User"]["password"] = $new_password; 

		unset($this->validate['name']);
		unset($this->validate['email']);
		unset($this->validate['password']);
		if ($this->Save($user)) {
			$message='Your password has been successfully updated';
			return true;			
		}else{
			$message='Failed to update password. Please try again!.';
			return false;
		}	
	}

/**
	* @access public
	* @Method appGetUserDetailById.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :15_Nov_2017
	* @param string $Data    
	* @return User Details in Json Format
	*/
	
	public function appGetUserDetailById($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		$Category = new Category();
		$City = new City();
		extract($myArrayData); 
		$user_id      		= isset($id) 	? $id : ''; 
              
        /*if (empty($user_id)) {
            $message = 'Enetr User id. Try Again!';
            return false;
        } */ 
		if(!empty($user_id)){

			$getUserDetails = $this->find('first', array(
        	'recursive' => 0,
            'conditions' => array(
                'User.id' => $id,                 
                )
            ));       
            if(!empty($getUserDetails))
            {
            	$arrayData['id']					 =$getUserDetails['User']['id'];
            	$arrayData['name']					 =$getUserDetails['User']['name'];
            	$arrayData['email']					 =$getUserDetails['User']['email'];
            	$arrayData['phone']					 =$getUserDetails['User']['phone'];
            	$arrayData['address']					 =$getUserDetails['User']['address'];
            	$arrayData['address2']					 =$getUserDetails['User']['address2'];
            	$arrayData['state_id']				 =$getUserDetails['User']['state_id'];
            	$arrayData['city_id']				 =$getUserDetails['User']['city_id'];
            	$arrayData['city2_id']				 =$getUserDetails['User']['city2_id'];
            	$arrayData['company']				 =$getUserDetails['User']['company'];
            	$arrayData['location']				 =$getUserDetails['User']['location'];
            	$arrayData['state']					 =$getUserDetails['State']['name'];
            	$arrayData['city']					 =$getUserDetails['City']['city'];
            	$arrayData['bio']				 	 =$getUserDetails['User']['bio'];
            	$arrayData['pincode']				 =$getUserDetails['User']['pincode'];
            	$arrayData['category_id']				 =$getUserDetails['User']['category_id'];
            	$arrayData['profileimg']				 =$getUserDetails['User']['profileimg'];
            	
            	//multi select category code
            	if(!empty($getUserDetails['User']['category_id']))
            	{
            		$cat = explode(",", $getUserDetails['User']['category_id']);
            		foreach($cat as $value){
            			$catValue=$Category->findById($value);
            			
            			$catData['id']=$catValue['Category']['id'];
            			$catData['itemName']=$catValue['Category']['name'];
            			$finalCatArray[]=$catData;            		
            		}
            		$arrayData['category_id']=$finalCatArray;
            		//echo "<pre>";print_r($finalCatArray);die;
            	}else{
            		$arrayData['category_id']='';
            	}

            	//City Multi select 
            	//multi select category code
            	if(!empty($getUserDetails['User']['city_id']))
            	{
            		$city = explode(",", $getUserDetails['User']['city_id']);
            		foreach($city as $value){
            			$cityValue=$City->findById($value);
            			
            			$cityData['id']=$cityValue['City']['id'];
            			$cityData['itemName']=$cityValue['City']['city'];
            			$finalCityArray[]=$cityData;            		
            		}
            		$arrayData['city_id']=$finalCityArray;
            		//echo "<pre>";print_r($finalCatArray);die;
            	}else{
            		$arrayData['city_id']='';
            	}
				$returnData=$arrayData;
				$message = 'Successfully';
				return $returnData;	

            } else{
            	$message = 'no record found';
            	return false;

            }

		}

    }

	/**
	* @access public
	* @Method appUpdateProfile.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :15_Nov_2017
	* @param string $Data    
	* @return User Details in Json Format
	*/

	public function appUpdateProfile($myArrayData=null, &$message='')
	{
		//Extract Comming Data
		extract($myArrayData);		
		$user_id    = isset($user_id)  	?  strtolower($user_id)  	: '';
		$userName    = isset($name)  	?  strtolower($name)  	: '';
		$phone       = isset($phone) 	? $phone				: '';
		$address   	 = isset($address)  ? strtolower($address)  : '';
		$address2    = isset($address2) ? strtolower($address2) : '';
		$state_id    = isset($state_id) ? $state_id 			: '';
		$category_id = isset($category_id)  ? $category_id 		: '';
		$city_id     = isset($city_id) 	? $city_id 				: ''; 
		$city2_id     = isset($city2_id) 		? $city2_id 				: ''; 
		$pincode     = isset($pincode) 	? $pincode 				: ''; 
		$bio     	 = isset($bio) 		? $bio 					: ''; 
		$company     = isset($company) 		? $company 				: '';
		$location    = isset($location) 	? $location 				: '';		
		if(!empty($user_id)){
			$userDetails=$this->findById($user_id);
			/*if (empty($userName)) {
				$message = 'Please enter username';
				return false;
			}

			if((strlen($userName) < 5) || strlen($userName) >= 20) {
				$message = 'Username must be between 5 to 20 characters';
				return false;
			}*/

			$userArray['User']['id']        = $user_id;
			$userArray['User']['name']      = $userName;       	
			$userArray['User']['phone']     = $phone;		
			$userArray['User']['address']  	= $address;
			$userArray['User']['address2']  	= $address2;
			if(!empty($city_id))
			{
				
				$userArray['User']['city_id']   	= $city_id;
			}			
			$userArray['User']['city2_id']   	= $city2_id; 
			$userArray['User']['city_id']   = $city_id; 
			$userArray['User']['pincode']   = $pincode;
			$userArray['User']['bio']   	= $bio; 
			$userArray['User']['category_id']   = $category_id;
			$userArray['User']['company']   	= $company; 
			$userArray['User']['location']   	= $location; 
			//un-comment if using single select 
			//$userArray['User']['category_id']   = $category_id;
			if($userDetails['User']['phone'] != $phone)
			{
				$userArray['User']['otp']      	= substr(time(),4,6);
				$userArray['User']['otp_status'] = '1'; 	

			}else{

				$userArray['User']['otp']      	= null; 
				$userArray['User']['otp_status'] = '0'; 
			}
			//multi category update code
			if(!empty($MyValue))
			{
				foreach($MyValue as $value){
					$dataValue=json_decode($value, true);
					$id[]=$dataValue['id'];
				}
				$userArray['User']['category_id'] = implode(',', $id);
			}
			if(!empty($MyCityValue))
			{
				foreach($MyCityValue as $value){
					$dataValue=json_decode($value, true);
					$ValId[]=$dataValue['id'];
				}
				$userArray['User']['city_id'] = implode(',', $ValId);
			}
			unset($this->validate['name']);
			unset($this->validate['email']);
			unset($this->validate['password']);
			if ($this->Save($userArray)) {
			$message = 'Profile updated successfully';
			return $userArray;          
			} else {
			$message = 'Oops! Some error occurred, please try again';
			return false;
			} 
		}    

	    
	}
	
	//Not in use
	/**
	* @access public
	* @Method appUpdateProfile.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :15_Nov_2017
	* @param string $Data    
	* @return User Details in Json Format
	*/

	public function appUpdateUserFile($myArrayData=null, &$message='')
	{
		//Extract Comming Data
		
		if(!empty($myArrayData))
		{

			$imagename=$myArrayData['avatar']['name'];			
			if(empty($imagename))
			{
				$message = 'Invalid name';
				return false;
			}
			//Qimage Code
			$file=basename($imagename);
			$ext=pathinfo($file,PATHINFO_EXTENSION);
			if(strlen($myArrayData['avatar']['name'])) 
			{
				$file1= $myArrayData['avatar']['tmp_name'];
				
				$new_file_name = time().'.'.$ext;
				if(move_uploaded_file($file1, WWW_ROOT.'uploads/image/big/'.$new_file_name))
					{
						$this->Qimage->resize(array('height' => 100, 'width' => 120, 'file' => WWW_ROOT. '/uploads/image/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/image/thumb/'));
					}
				
				$imagename=$new_file_name;
			}

			$temp = array(
				'User' => array(
			    	'id' => 13,
			    	'profileimg' => $imagename,
			    ),
			);

			unset($this->validate['name']);
			unset($this->validate['email']);
			unset($this->validate['password']);
			if ($this->Save($temp)) {
			$message = 'Profile Image save successfully';
			return $temp;          
			} else {
			$message = 'Oops! Some error occurred, please try again';
			return false;
			} 


		}else{

			$message = 'Oops! Some error occurred, please try again';
			return false;

		}
		

	    
	}


/**
	* @access public
	* @Method 	 : appResetPassword.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 31_Oct_2017
	* @param 	 : string $Data    
	* @return    : in Json Format
	*/
	
	public function appResetPassword($myArrayData=null, &$message='')
	{
		//extract comming array
		extract($myArrayData);
        $verification_key      		= isset($verification_key) 	? $verification_key 			: '';       
        $new_password1       = isset($new_pass) 	? $new_pass 		: '';
        $confirm_password1  = isset($conf_pass) ? $conf_pass 		: '';
       
       /*
         password */
        $passvalue1=explode("%",$new_password1);      
        $new_password=base64_decode($passvalue1[1]);

        $passvalue2=explode("%",$confirm_password1);      
        $confirm_password=base64_decode($passvalue2[1]);
       
        if (empty($new_password)) {
            $message = 'Enetr new password. Try Again!';
            return false;
        }
        if ($confirm_password != $new_password) {
            $message = 'New & Confirm Password mismatch. Try Again!';
            return false;
        }

        $getUserDetails = $this->find('first', array(
        	'recursive' => 0,
            'conditions' => array(
                'User.verification_key' => $verification_key,                 
                )
            )); 
		 if(!empty($getUserDetails))
        {
			$temp = array(
			'User' => array(
				'id' => $getUserDetails['User']['id'],
				'password' => $new_password,	
				'verification_key'=>null,
				'verification_date'=>null
				),
			);
			unset($this->validate['name']);
			unset($this->validate['email']);
			if ($this->Save($temp)) {
				$message='Your password has been successfully updated';
				return true;			
			}else{
				$message='Failed to update password. Please try again!.';
				return false;
			}	

        }else{

        	$message='Invalid Varification Key';
			return true;
        }
	}



/**
	* @access public
	* @Method 	 :checkUserActivationKey.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 
	* @param 	 : string $activation_key    
	* @return 	 : check activation key exists in db or not
	*/
	
	public function checkUserActivationKey($myArrayData=null, &$message='')
	{
		extract($myArrayData);	
        $key       = isset($activationKey) 	? strtolower($activationKey) 	: '';
            
        if(empty($key))
        {
        	$message ='Please provide activation key';
            return false;
        }
        $checkDetails=$this->find('first',array(
        	'recursive'=>-1,
        	'conditions'=>array(
        		'activation_code'=>$key,
        		)

        	));
         //echo "<pre>";print_r($checkDetails);die;
        if(!empty($checkDetails))
        {
        	if($checkDetails['User']['block']==1){
        		$userArray=array();
        		//$checkDetails['User']['block']='0';
        		$userArray['User']['block']='0';
        		$userArray['User']['status']='0';
        		$userArray['User']['id']=$checkDetails['User']['id'];
        		//$userArray['User']['activation_code']='';			
        		unset($this->validate['name']);
				unset($this->validate['email']);
				unset($this->validate['password']);
        		if ($this->Save($userArray)) {
					$message='Congratulations, You are a Valid User Now. You can go to Sign In page and can login with your Login Credentials';
					return true;			
				}else{
					$message='Failed. Please try again!.';
					return false;
				}
        	}else{
        		$message='You are already a valid user';
				return true;	

        	}
        }else{
        	$message='You are not a valid user';
			return false;

        }
    }


/**
	* @access public
	* @Method 	 :appVarifyOTP.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 
	* @param 	 : string $appVarifyOTP    
	* @return 	 : check OTP key exists in db or not
	*/
	
	public function appVarifyOTP($myArrayData=null, &$message='')
	{
	
		extract($myArrayData);	
        $user_id        = isset($user_id) 	? $user_id 	: '';
        $otp       		= isset($otp) 	? $otp 	: '';
        if(!empty($user_id))
        {
        	$checkOtpDetails=$this->find('first',array(
        	'recursive'=>-1,
        	'conditions'=>array(
        		'User.id'=>$user_id,
        		'User.otp'=>$otp)

        	));
        	//echo "<pre>";print_r($checkOtpDetails);die;
        	if(!empty($checkOtpDetails))
        	{
        		unset($this->validate['name']);
				unset($this->validate['email']);
				unset($this->validate['password']);
				$userArray['User']['otp']=null;
        		$userArray['User']['otp_status']='0';
        		$userArray['User']['id']=$user_id;
        		if ($this->Save($userArray)) {
					$message='Congratulations, You are a Valid User Now.';
					return true;			
				}else{
					$message='Failed. Please try again!.';
					return false;
				}

        	}else{
        		
        		$message='Invalid OTP ,please resend OTP';
				return false;

        	}


        }          
        
    }

/**
	* @access public
	* @Method 	 :appRegenerateMobileOTP.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 
	* @param 	 : string $appRegenerateMobileOTP    
	* @return 	 : RegenerateMobileOTP 
	*/
	
	public function appRegenerateMobileOTP($myArrayData=null, &$message='')
	{
		extract($myArrayData);	
        $user_id        = isset($id) 	? $id 	: '';      
        if(!empty($user_id))
        {      

        	$checkOtpDetails=$this->findById($user_id);
        	//echo "<pre>";print_r($checkOtpDetails);die;
        	if(!empty($checkOtpDetails))
        	{
        		unset($this->validate['name']);
				unset($this->validate['email']);
				unset($this->validate['password']);
				$userArray['User']['otp']=substr(time(),4,6);
        		$userArray['User']['otp_status']='1'; 
        		$userArray['User']['id']=$user_id;
        		if ($this->Save($userArray)) {
        			
        			$details=$this->findById($user_id);
					$message='An OTP has been sent to your Mobile Number,please check you mobile';
					return $details;			
				}else{
					$message='Failed. Please try again!.';
					return false;
				}

        	}else{
        		
        		$message='Invalid user ,Please try again';
				return false;

        	}


        }          
        
    }
	
	/**
	* @access public
	* @Method 	 :appUpdateMobileForOTP.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 
	* @param 	 : string $appUpdateMobileForOTP    
	* @return 	 : check OTP key exists in db or not
	*/
	
/*	public function appUpdateMobileForOTP($myArrayData=null, &$message='')
	{	
		//echo "<pre>";print_r($myArrayData);die;
		extract($myArrayData);	
        $user_id        = isset($user_id) 	? $user_id 	: '';
        $phone       		= isset($phone) 	? $phone 	: '';
        if(!empty($user_id))
        {

        	$saveMobileOtpDetails=$this->findById($user_id);
        	if(!empty($saveMobileOtpDetails)){
        		$saveMobileOtpDetails['User']['phone']=$phone;
        		$saveMobileOtpDetails['User']['otp']=substr(time(),4,6);
        		$saveMobileOtpDetails['User']['otp_status']='1';
        		
        		
                unset($this->validate['name']);
        		unset($this->validate['email']);
        		unset($this->validate['password']);
        		
        		
        		if ($this->Save($saveMobileOtpDetails)) {
        			
        			$details=$this->findById($user_id);
					$message='An OTP has been sent to your Mobile Number,please check you mobile number';
					return $details;

				}else{
					$message='Failed. Please try again!.';
					return false;
				}        	
        	}else{

        		$message='Failed. Please try again!.';
			    return false;

        	}
        }
    }*/
    
    /**
	* @access public
	* @Method 	 :appUpdateMobileForOTP.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 
	* @param 	 : string $appUpdateMobileForOTP    
	* @return 	 : check OTP key exists in db or not
	*/
    
    public function appUpdateMobileForOTP($myArrayData=null, &$message='')
	{	
		//echo "<pre>";print_r($myArrayData);die;
		extract($myArrayData);	
        $user_id        = isset($user_id) 	? $user_id 	: '';
        $phone       		= isset($phone) 	? $phone 	: '';
        if(!empty($user_id))
        {

        	$saveMobileOtpDetails=$this->findById($user_id);
        	if(!empty($saveMobileOtpDetails)){
        		$saveMobileOtpDetails1['User']['id']=$user_id;
        		$saveMobileOtpDetails1['User']['phone']=$phone;
        		$saveMobileOtpDetails1['User']['otp']=substr(time(),4,6);
        		$saveMobileOtpDetails1['User']['otp_status']='1'; 
        		unset($this->validate['name']);
				unset($this->validate['email']);
				unset($this->validate['password']);    		
        		if ($this->Save($saveMobileOtpDetails1)) {
        			
        			$details=$this->findById($user_id);
					$message='An OTP has been sent to your Mobile Number,please check you mobile';
					return $details;

				}else{
					$message='Failed. Please try again!.';
					return false;
				}        	
        	}else{

        		$message='Failed. Please try again!.';
			    return false;

        	}
        }
    }
}
