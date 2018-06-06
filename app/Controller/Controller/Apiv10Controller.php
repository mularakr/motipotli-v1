	<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'PHPMailer', array('file' => 'PHPMailer/PHPMailerAutoload.php'));
App::uses('File', 'Utility');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
* API Controller
*
* http://book.cakephp.org/2.0/en/core-utility-libraries/sanitize.html
* For Data Sanitization to block SQL injections in CakePHP.
* CakePHP handles SQL escaping on all parameters to Model::find() and Model::save().
* http://book.cakephp.org/2.0/en/contributing/cakephp-coding-conventions.html
*
* CakePHP version 2.x find query returns all values as data type string but those array element created by developer returns data type string or int. As requested by iPhone application developer, they need all values in string data type that's why we have explicitly converted data type of element of array to string.
*/
class Apiv10Controller extends AppController {


      public $uses = array('User','State','Bid','Bidmessage','Category','City','Document','Company','Job','Jobimage','Rating','DeviceToken','Message','Notification','JobComplete','CompanyDocument','PaymentHistory','PaymentOption','UserToken','Managelist','ContactQuery','Faq');      
      public $components = array('RequestHandler', 'Qimage', 'Paginator','Email', 'Auth','Mailer','SendNotification');
      public $autoRender = false; // Do not render any view in any action of this controller
      public $layout = null; // Set layout to null to every action of this controller
      public $autoLayout = false; // Set to false to disable automatically rendering the layout around views.
      public $current_user = array(); // Store user data after validating the access token
      public $jsonArray = array('status' => false, 'message' => 'Something went wrong'); // Set status & message.

      public function beforeFilter() 
      {
           
        parent::beforeFilter();
          
            //For Angular api hit
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: PUT, GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authorization");
		
            // Allow user to access all action without CakePHP Auth
            $this->Auth->allow();
             $allowedFunctions = array('ping', 'login','logout','app_signUp','app_login','app_forgotpassword','app_logout','app_resetPassword','app_getCategories','app_getStates','app_getCities','app_checkVerificationKey','app_checkUserActivationKey','app_getJobsByCategoryId','app_GetJobDetailsForGuest','app_getJobsByGeographicalSearch','success','failure','app_getPopularCity','app_getAboutUsPageDetails','app_sendContactQuery','app_gethireWorkersDetails','app_gettermsDetails','app_getjobPostContentDetails','app_getFaqDetailsPageDetails', 'app_gethowitworksDetails','app_getPrivacyPolicies');
            //'app_updateprofile','app_changepassword',
            // If a method doesn't exists in a class
            if (!method_exists($this, $this->params['action'])) {
                  header('HTTP/1.0 404 Not Found');
                  exit(json_encode(array('status' => false, 'message' => 'The requested api endpoint doesn\'t exist.')));
            }	     
            // Process all requests
            
            if (!in_array($this->params['action'], $allowedFunctions)) 
            {
                  // Fetch all HTTP request headers from the current request.
                   $requestHeaders = apache_request_headers();
                    if ($requestHeaders['Accept'] == '*/*' || $requestHeaders['Accept'] == 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8') {
                        return;
                    } 
                  if (isset($requestHeaders['Authorization']) && !empty($requestHeaders['Authorization'])) 
                  {

                        $authorizationHeader = $requestHeaders['Authorization'];

                        if (!$this->_authenticate($authorizationHeader)) {
                              header('HTTP/1.0 401 Unauthorized');
                              exit(json_encode(array('status' => false, 'message' => 'No valid access token provided.')));
                        }
                        }else {
                              header('HTTP/1.0 401 Unauthorized');
                              exit(json_encode(array('status' => false, 'message' => 'No authorization header sent.')));
                  }
            }
            
            if ($this->request->is('post') || $this->request->is('put')) {
                  array_walk_recursive($this->request->data, array($this, '_trimElementOfArray'));
            }

      }

      // Remove whitespaces from start and end of a string from element
      protected function _trimElementOfArray(&$item, &$key) {
            $item = trim($item);
      }

      /**
      * Output given data in JSON format.
      *
      * @access protected
      *
      * @param bool $status true|false
      * @param string $message
      * @param array $data The data to output in JSON format
      * @return object
      */
      protected function _returnJson($status = false, $message = null, $data = array())
      {

            // Set status
            $this->jsonArray['status'] = $status ? 'success' : 'failure';

            // Set message
            $this->jsonArray['message'] = $message;

            // Set data (if any)
            if ($data) {
                  
                  // Replace all the 'null' values with blank string
                  array_walk_recursive($data, array($this, '_replaceNullWithEmptyString'));

                  // Remove whitespaces from start and end of a string from element
                  array_walk_recursive($data, array($this, '_trimElementOfArray'));

                  $this->jsonArray['data'] = $data;
            }

            // Set the json-encoded data to be the body
            $this->response->body(json_encode($this->jsonArray));
            $this->response->statusCode(200);
            $this->response->type('application/json');

            return $this->response;
      }

      /**
      * Replace null value to blank string from all elements of associative array.
      * This function call recursively
      *
      * @access protected
      *
      * @param string|int|null $item
      * @param string $key
      * @return void
      */
      protected function _replaceNullWithEmptyString(&$item, $key) 
      {
            if ($item === null) {
                  $item = '';
            }
      }

      /**
      * Check against the database table if the access token is valid
      *
      * @access public
      *
      * @param string $access_token
      * @return bool true|false
      */
      protected function _authenticate($access_token) {
            return $this->_validateToken($access_token);
      }

      /**
      * This function validate token send by user.
      *
      * @access protected
      *
      * @param string $access_token
      * @return bool true|false
      */
      protected function _validateToken($access_token) 
      {            
            //$data = Set::map($this->User->find('first', array('conditions' => array('User.access_token' => $access_token), 'recursive' => -1)));
            $data = Set::map($this->DeviceToken->find('first', array('conditions' => array('DeviceToken.token' => $access_token), 'recursive' => -1)));
            if (!empty($data)) {
                  $this->current_user = $data;
                  return true;
            }
            return false;
      }

/******************************************************************************************
 *
 *
 *                                  API Start Here 
 *
 *
*******************************************************************************************/

      /**
       * Return api version.
       *
       * @access public
       *
       * @return json object
      */
      public function ping() {         
            return $this->_returnJson(TRUE,"api version v1.0"); 
      } 

      /**
      * @access public
      * @Method         : app_signUp.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return User Details in Json Format
      */
      public function app_signUp()
      {
            //echo 'here'; die;
            //{"name": "DummyUser","phone": "9219718840","Email": "rafi.ahmad@evontech.com","state_id": "","city_id": "","password": "","address":"dehradun"}// for testing purpose                       
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);           
            //send args to model function
            $registerUserData=$this->User->appSignUp($data, $message);
             
            if(!$registerUserData) {

                  return $this->_returnJson(false,$message);
            }
            else {
                  
                  // Send welcome email to user after Registration with username and password
                  $emailArray =array();
                  $mailContent            = file_get_contents(WWW_ROOT. "/templates/userVerification.html");
                  $emailArray['username'] =$registerUserData['User']['name'];
                  $emailArray['email']    =$registerUserData['User']['email'];
                  //$emailArray['password'] =$registerUserData['User']['password'];
                  //changes from here
                  $code = $registerUserData['User']['activation_code'];             
                  //$emailArray['send_url']='http://52.55.215.33/motipotlipro/userActivation?code='.$code; 
                  //unset($registerData['pass']); 
                  $emailArray['send_url']=FULL_BASE_URL.'/userActivation?code='.$code; 
                  $this->userVarificationMail($registerUserData['User']['email'], $mailContent, $emailArray); 
                   $this->send_otp_number($registerUserData['User']['phone'],$registerUserData['User']['otp']);                 
                  return $this->_returnJson(true,$message);
            } 
      }

      /**
      * @access public
      * @Method         : app_signUp.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return User Details in Json Format
      */
      public function app_login()
      {
		  
		  
            //{"email": "rafi.ahmad@evontech.com","password": "123456","login_type":"employer"}// for testing purpose           
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            //send args to model function
            $loginData=$this->User->appUserLogin($data, $message);            
            if(!$loginData) {
                  return $this->_returnJson(false, $message);
            }
            else {                  
                  return $this->_returnJson(true,$message,$loginData);
            } 

      }

       /**
      * @access public
      * @Method         : app_logout.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return User Details in Json Format
      */
      public function app_logout()
      {
            //{"id": "47"}// for testing purpose           
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);

            //send args to model function
            $loginData=$this->DeviceToken->appUserLogout($data, $message);            
            if(!$loginData) {
                  return $this->_returnJson(false, $message);
            }
            else {                  
                  return $this->_returnJson(true,$message);
            } 

      }
      

      /**
      * @access public
      * @Method         : app_signUp.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return User Details in Json Format
      */
      public function app_forgotpassword()
      {
            //{"email": "rafi.ahmad@evontech.com"}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            //return $this->_returnJson(true,$message,$data);die;
            //send args to model function
            $userForgotData=$this->User->appForgotPassword($data, $message);            
            if(!$userForgotData) {
                  return $this->_returnJson(false, $message);
            }
            else {

                  // Send forgot email to user with email and code
                  $emailArray =array();
                  $mailContent            = file_get_contents(WWW_ROOT. "/templates/forgetPassword.html");
                  $email=$userForgotData['User']['email'];
                  $code =$userForgotData['User']['code'];
                  $emailArray['name'] =$userForgotData['User']['name'];
                  //Server
                  //$emailArray['send_url']='http://52.55.215.33/motipotlipro/resetPassword?code='.$code;
                  //$emailArray['send_url']='https://www.motipotli.com/resetPassword?code='.$code;
                  $emailArray['send_url']=FULL_BASE_URL.'/resetPassword?code='.$code;
                  
                  $this->forgetPasswordMail($email, $mailContent,$emailArray);
                  return $this->_returnJson(true,$message);
            } 

      }

      /**
      * @access public
      * @Method app_checkVerificationKey.
      * @Description: Reset user password 
      * @Developer  : Rafi (Evon Technologies)
      * @Date       : 31_Oct_2017
      * @param      : string $Data    
      * @return     : Reset user password 
      */
    
      public function app_checkVerificationKey()
      {
            //{"verification_key":"83a8b0107f2f1f5a73a684a71ecc8b75"}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            //return $this->_returnJson(true,'ok');die;
            $checkVerification=$this->User->checkVerificationKey($data, $message); 
            if(!$checkVerification) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message);
            }
      }


      /**
      * @access public
      * @Method 	.
      * @Description: Reset user password 
      * @Developer  : Rafi (Evon Technologies)
      * @Date       : 
      * @param      : string $code    
      * @return     : check user activation code
      */
    
      public function app_checkUserActivationKey()
      {
            //{"activationKey":"83a8b0107f2f1f5a73a684a71ecc8b75"}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            //return $this->_returnJson(true,'ok');die;
            $checkActivationKey=$this->User->checkUserActivationKey($data, $message); 
            if(!$checkActivationKey) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message);
            }
      }


      /**
      * @access public
      * @Method app_resetpassword.
      * @Description: Reset user password 
      * @Developer  : Rafi (Evon Technologies)
      * @Date       : 31_Oct_2017
      * @param      : string $Data    
      * @return     : Reset user password 
      */
    
      public function app_resetPassword()
      {
            //{"new_pass":"","conf_pass":"",verification_key":"83a8b0107f2f1f5a73a684a71ecc8b75"}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $checkVerification=$this->User->appResetPassword($data, $message); 
            if(!$checkVerification) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message);
            }
      }
      
     /**
      * @access public
      * @Method         : app_updateprofile.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         updateprofile Details in Json Format
      */
      public function app_updateprofile()
      {
            //{"user_id":"",name": "DummyUser","phone": "9219718840","bio": "","state_id": "","city_id": "","pincode": "","address1":"dehradun","address2":"dehradun","image":""}// for testing purpose
            $requestArgs = $this->request->data;
            $updateUserData=$this->User->appUpdateProfile($requestArgs,$message);  
            if(!$updateUserData) {
                  
                  return $this->_returnJson(false, $message);
            }
            else {            
                   /**
                   Add user Documents   file                              
                   */
                  if(!empty($_FILES['MyFile']['name']))
                  {
                        $fileCount=count($_FILES['MyFile']['name']);
                        for($i = 0;$i <$fileCount;$i++)
                        {
                              $imagename=$_FILES['MyFile']['name'][$i];
                              $file=basename($imagename);
                              $ext=pathinfo($file,PATHINFO_EXTENSION);
                              $file1= $_FILES['MyFile']['tmp_name'][$i];
                              $new_file_name = time().'_'.$i.'.'.$ext;
                              if(move_uploaded_file($file1, WWW_ROOT.'uploads/doc_file/big/'.$new_file_name))
                              {
                                    //$this->Qimage->resize(array('height' => 150, 'width' => 150, 'file' => WWW_ROOT. '/uploads/job/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/job/thumb/'));
                              }
                              $docDetails['Document']['doc_file']=$new_file_name;
                              $docDetails['Document']['user_id']=$updateUserData['User']['id']; 
                              $this->Document->save($docDetails);
                              $this->Document->clear();                             
                        }    
                  }
                   if($updateUserData['User']['otp_status'] =='1')
                  {
                      $this->send_otp_number($updateUserData['User']['phone'],$updateUserData['User']['otp']);  
                  }                 
                  return $this->_returnJson(true,$message,$updateUserData);
            } 

      }

      /**
      * @access public
      * @Method         : app_updateFile.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return         updateprofile Details in Json Format
      */
      public function app_updateUserFile(&$id='')
      {     
          // echo "<pre>";print_r($this->params->query['id']);die;
            $this->loadModel('User');
            $id=$this->params->query['id'];  
            $userDetails=$this->User->findById($id);      
            $imagename=$_FILES['avatar']['name']; 
			$imageArray=array();
            if(empty($imagename))
            {
                  $message = 'Invalid name';
                  return $this->_returnJson(false, $message);
            }
            //Qimage Code
            $file=basename($imagename);
            $ext=pathinfo($file,PATHINFO_EXTENSION);
            if(strlen($_FILES['avatar']['name'])) 
            {
                  $file1= $_FILES['avatar']['tmp_name'];
                  
                  $new_file_name = time().'.'.$ext;
                   //15Dec
                  if(!empty($userDetails['User']['profileimg']))
                  {
                        unlink( WWW_ROOT . 'uploads/profile_image/big/' . $userDetails['User']['profileimg']);
                        unlink( WWW_ROOT . 'uploads/profile_image/thumb/' . $userDetails['User']['profileimg']);
                   }
                    //15Dec
                   if(move_uploaded_file($file1, WWW_ROOT.'uploads/profile_image/big/'.$new_file_name))
                        {
                              $this->Qimage->resize(array('height' => 100, 'width' => 120, 'file' => WWW_ROOT. '/uploads/profile_image/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/profile_image/thumb/'));
                        }                
                 /* if(move_uploaded_file($file1, WWW_ROOT.'uploads/image/big/'.$new_file_name))
                        {
                              $this->Qimage->resize(array('height' => 100, 'width' => 120, 'file' => WWW_ROOT. '/uploads/image/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/image/thumb/'));
                        }                  */
                  //$imagename=$new_file_name;
                  $imageArray['User']['profileimg']=$new_file_name;
            }  
			$imageArray['User']['id']=$userDetails['User']['id'];
            unset($this->validate['name']);
            unset($this->validate['email']);
            unset($this->validate['password']); 			
            
            if ($this->User->save($imageArray)) {
                  $message = 'Profile Image save successfully';
                  return $this->_returnJson(true, $message);
                 // return $temp;          
            } else {
                  $message = 'Oops! Some error occurred, please try again';
                  return $this->_returnJson(false, $message);                
            } 
      }
      /**
      * @access public
      * @Method         : app_getCategories.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 31_Oct_2017
      * @description    : get all categories details
      * @return         : details in Json Format
      */
     
      public function app_getCategories()
      {     
            $data=array();
            $categories= $this->Category->appGetCategories($data,$message);
            if(!empty($categories))
            {    
                  return $this->_returnJson(true,$message,$categories);

            }else{
                  return $this->_returnJson(false,$message,$data);
            }           
      }

       /**
      * @access public
      * @Method         : app_getCategories.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 31_Oct_2017
      * @description    : get all categories details
      * @return         : details in Json Format
      */
     
      public function app_changepassword()
      {     
            //{"user_id":"13","old_pass":"admin","new_pass": "admin1","conf_pass": "admin1"}// for testing purpose
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            //send args to model function
            $changeUserPassword=$this->User->appChangePassword($data, $message);  
            if(!$changeUserPassword) {
                  return $this->_returnJson(false, $message);
            }else {
                  return $this->_returnJson(true,$message);
            }         
      }
      
	/**
	* @access public
	* @Method         : app_getStates.
	* @Developer      : Rafi Ahmad(Evon Technologies)
	* @Date           : 03_Nov_2017
	* @description    : get all states details
	* @return         : details in Json Format
	*/

	public function app_getStates()
	{     
      	$data=array();
      	$stateDetails= $this->State->appGetStates($data,$message);          
      	if(!empty($stateDetails))
      	{    
      	     return $this->_returnJson(true,$message,$stateDetails);

      	}else{

      	     return $this->_returnJson(false,$message,$data);
      	}           
	}
      /**
      * @access public
      * @Method         : app_getCities.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 08_Nov_2017
      * @description    : get all City Based on State details
      * @return         : details in Json Format
      */
      public function app_getCities()
      {     
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $dataNew=array();
            $cityDetails= $this->City->appGetCities($data,$message);  
                
            if(!empty($cityDetails))
            {    
                 return $this->_returnJson(true,$message,$cityDetails);

            }else{
                  
                 return $this->_returnJson(false,$message,$dataNew);
            }           
      }
      
      /**
      * @access public
      * @Method         : app_getAllUserCities.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 08_Nov_2017
      * @description    : get all City Based on State details
      * @return         : details in Json Format
      */
      public function app_getAllUserCities()
      {     
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $dataNew=array();
            $cityDetails= $this->City->appGetUserCities($data,$message);  
                
            if(!empty($cityDetails))
            {    
                 return $this->_returnJson(true,$message,$cityDetails);

            }else{
                  
                 return $this->_returnJson(false,$message,$dataNew);
            }           
      }


      /**
      * @access public
      * @Method         : app_signUp.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return User Details in Json Format
      */
      public function app_GetUserDetailById()
      {
           // {"id": "rafi.ahmad@evontech.com","password": "123456","login_type":"employer"}// for testing purpose
                                                                                          
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $userData=$this->User->appGetUserDetailById($data, $message);            
            if(!$userData) {
                  return $this->_returnJson(false, $message);
            }
            else {     
				if(!empty($userData['profileimg']))
				{
					$userData['profileimg']= $this->fullurl($userData['profileimg'],"uploads/profile_image/thumb/"); 
				}else{
					$image='user.png';
					$userData['profileimg']= $this->fullurl($image,"uploads/profile_image/"); 
				}
				
                  return $this->_returnJson(true,$message,$userData);
            } 

      }

      /**
      * @access public
      * @Method         : app_getCompanyDetailByCurrentUserId.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 24_Nov_2017
      * @description    :
      * @return Company Detail By Current User in Json Format
      */
      public function app_getCompanyDetailByCurrentUserId()
      {
           // {"userId": "69"}// for testing purpose
                
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $companyData=$this->Company->appCompanyDetailByCurrentUserId($data, $message);            
            if(!$companyData) {
                  return $this->_returnJson(false, $message);
            }
            else {  

                  return $this->_returnJson(true,$message,$companyData);
            } 

      }
	  
	  /**
      * @access public
      * @Method         : app_getCompanyDetailByCurrentUserId.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 24_Nov_2017
      * @description    :
      * @return Company Detail By Current User in Json Format
      */
      public function app_getCompanyDetailByCurrentUserId1()
      {
           // {"userId": "69"}// for testing purpose
              
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $companyData=$this->Company->appCompanyDetailByCurrentUserId1($data, $message);            
            if(!$companyData) {
                  return $this->_returnJson(false, $message);
            }
            else {  

                  return $this->_returnJson(true,$message,$companyData);
            } 

      }

      /**
      * @access public
      * @Method         : app_addCompany.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return User Details in Json Format
      */
        public function app_addCompany()
        {    
            $requestArgs = $this->request->data;
            $file_full = WWW_ROOT.'uploads/company_logo/big/';
            $file_thumb = WWW_ROOT.'uploads/company_logo/thumb/';                   
            if(!empty($requestArgs['title']))
            {
                  $userDetails = array();           
                  $companyId  = isset($requestArgs['companyId'])  ?  $requestArgs['companyId']     : '';
                  $user_id    = isset($requestArgs['user_id'])  ?  $requestArgs['user_id']     : '';
                  $title      = isset($requestArgs['title'])  ?    $requestArgs['title']   : '';
                  $bio        = isset($requestArgs['bio']) ?       $requestArgs['bio'] : '';
                  $address1   = isset($requestArgs['address1'])  ? $requestArgs['address1']  : '';
                  $address2   = isset($requestArgs['address2'])  ? $requestArgs['address2']  : '';
                  $state_id   = isset($requestArgs['state_id']) ? $requestArgs['state_id']    : '';
                  $city_id    = isset($requestArgs['city_id'])     ? $requestArgs['city_id']  : '';
                  $phone      = isset($requestArgs['phone']) ? $requestArgs['phone'] : ''; 
                  $pincode    = isset($requestArgs['pincode']) ? $requestArgs['pincode'] : ''; 

                  if($companyId!='undefined')
                  {                       
                        $userDetails1=$this->Company->findById($companyId);
                        $fileName=$userDetails1['Company']['logo'];
                       
                        if(!empty($_FILES['avatar']['name']))
                        {     
                              if(!empty($fileName))
                              {
                                    unlink($file_full . $fileName); 
                                    unlink($file_thumb . $fileName); 
                              }
                              $imagename=$_FILES['avatar']['name'];                        
                              //Qimage Code 
                              $file = basename($imagename); 
                              $ext = pathinfo($file,PATHINFO_EXTENSION);                              
                              if(strlen($_FILES['avatar']['name'])) 
                              { 
                                    $file1 = $_FILES['avatar']['tmp_name']; 
                                    $new_file_name = time().'.'.$ext; 
                                    if(move_uploaded_file($file1, WWW_ROOT.'uploads/company_logo/big/'.$new_file_name)) 
                                    //if(move_uploaded_file($file1,$file_full.$new_file_name))
                                    {
                                      $this->Qimage->resize(array('height' => 100, 'width' => 120, 'file' => WWW_ROOT. '/uploads/company_logo/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/company_logo/thumb/'));
                                    }
                                $userDetails['Company']['logo'] = $new_file_name;
                              }                  
                        }
                        //echo "<pre>";print_r($userDetails);die;

                        $userDetails['Company']['id']        = $companyId;
                        $userDetails['Company']['user_id']   = $user_id;       
                        $userDetails['Company']['title']     = $title;
                        $userDetails['Company']['bio']       = $bio;
                        $userDetails['Company']['phone']     = $phone;
                        $userDetails['Company']['address1']    = $address1;
                        $userDetails['Company']['address2']  = $address2;
                        $userDetails['Company']['state_id']   = $state_id;
                        $userDetails['Company']['city_id']   = $city_id;
                        $userDetails['Company']['phone']   = $phone;
                        $userDetails['Company']['pincode']   = $pincode;               
                  }else{

                        if(!empty($_FILES['avatar']['name']))
                        {                            
                              $imagename=$_FILES['avatar']['name'];                        
                              //Qimage Code 
                              $file = basename($imagename); 
                              $ext = pathinfo($file,PATHINFO_EXTENSION); 
                              if(strlen($_FILES['avatar']['name'])) 
                              { 
                                    $file1 = $_FILES['avatar']['tmp_name']; 
                                    $new_file_name = time().'.'.$ext; 
                                    if(move_uploaded_file($file1, WWW_ROOT.'uploads/company_logo/big/'.$new_file_name)) 
                                    {
                                    $this->Qimage->resize(array('height' => 100, 'width' => 120, 'file' => WWW_ROOT. '/uploads/company_logo/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/company_logo/thumb/'));
                                    }
                                $userDetails['Company']['logo'] = $new_file_name;
                              }                  
                        }

                        $userDetails['Company']['user_id']   = $user_id;       
                        $userDetails['Company']['title']     = $title;
                        $userDetails['Company']['bio']       = $bio;
                        $userDetails['Company']['phone']     = $phone;
                        $userDetails['Company']['address1']    = $address1;
                        $userDetails['Company']['address2']  = $address2;
                        $userDetails['Company']['state_id']   = $state_id;
                        $userDetails['Company']['city_id']   = $city_id;
                        $userDetails['Company']['phone']   = $phone;
                        $userDetails['Company']['pincode']   = $pincode;
                  }

                  if ($this->Company->save($userDetails)) {
                        if($companyId!='undefined')
                        {
                               //if request for update data then set company id 
                              $lastId=$companyId;

                        }else{
                              //if request for add new data then set last company id 
                              $lastId=$this->Company->getLastInsertID();
                        }                      
                        /**
                         Add company Documents
                         */
                        if(!empty($_FILES['MyFile']))
                        {
                              $fileCount=count($_FILES['MyFile']['name']);
                              for($i = 0;$i <$fileCount;$i++)
                              {
                                    $imagename=$_FILES['MyFile']['name'][$i];
                                    $file=basename($imagename);
                                    $ext=pathinfo($file,PATHINFO_EXTENSION);
                                    $file1= $_FILES['MyFile']['tmp_name'][$i];
                                    $new_file_name = time().'_'.$i.'.'.$ext;
                                    if(move_uploaded_file($file1, WWW_ROOT.'uploads/company_doc/big/'.$new_file_name))
                                    {
                                          //$this->Qimage->resize(array('height' => 150, 'width' => 150, 'file' => WWW_ROOT. '/uploads/job/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/job/thumb/'));
                                    }
                                    $docDetails['CompanyDocument']['doc_name']=$new_file_name;
                                    $docDetails['CompanyDocument']['company_id']=$lastId; 
                                    $this->CompanyDocument->save($docDetails);
                                    $this->CompanyDocument->clear();                             
                              }    
                        } 

                        
                        //$this->Company->clear();
                        $message = 'Company Details Added Successfully';
                        return $this->_returnJson(true, $message,$userDetails);
                       // return $temp;          
                  } else {
                        $message = 'Oops! Some error occurred, please try again';
                        return $this->_returnJson(false, $message);
                  }
            }            
           
      }

      /**
      * @access public
      * @Method         : app_GetOpenJobs.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return User Details in Json Format
      */
        public function app_GetOpenJobs()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $openJobData = $this->Job->appGetOpenJobs($data, $message);            
            if(!$openJobData) {
                  return $this->_returnJson(false, $message);
            }
            else {                  
                  return $this->_returnJson(true,$message,$openJobData);
            }
       }

       /**
      * @access public
      * @Method         : app_GetBookedJobs.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Nov_2017
      * @description    :
      * @return User Details in Json Format
      */
        public function app_GetBookedJobs()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                
            $bookedJobData = $this->Job->appGetBookedJobs($data, $message);            
            if(!$bookedJobData) {
                  return $this->_returnJson(false, $message);
            }
            else {                  
                  return $this->_returnJson(true,$message,$bookedJobData);
            }
       }


       /**
      * @access public
      * @Method         : app_jobPost.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return app job Post
      */
      public function app_jobPost(){
        $requestArgs = $this->request->data;  
        $createJob=$this->Job->appJobPost($requestArgs, $message);  
       if(!$createJob) {
            return $this->_returnJson(false, $message);
       }else {
            $lastJobId=$createJob['id'];		
            if(!empty($_FILES['MyFile']))
            {
            	$fileCount=count($_FILES['MyFile']['name']);
            	for($i = 0;$i <$fileCount;$i++)
            	{
            		$imagename=$_FILES['MyFile']['name'][$i];
            		$file=basename($imagename);
            		$ext=pathinfo($file,PATHINFO_EXTENSION);
            		$file1= $_FILES['MyFile']['tmp_name'][$i];
            		$new_file_name = time().'_'.$i.'.'.$ext;
            		if(move_uploaded_file($file1, WWW_ROOT.'uploads/job/big/'.$new_file_name))
					{
						//$this->Qimage->resize(array('height' => 150, 'width' => 150, 'file' => WWW_ROOT. '/uploads/job/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/job/thumb/'));
					}
					$jobDetails['Jobimage']['images']=$new_file_name;
					$jobDetails['Jobimage']['job_id']=$lastJobId; 
					$this->Jobimage->save($jobDetails);
					$this->Jobimage->clear();					
            	}    
            }       
            return $this->_returnJson(true,$message);
       } 
    }


	/**
      * @access public
      * @Method         : app_GetJobDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 01_Dec_2017
      * @description    :
      * @return Job in Json Format
      */
        public function app_GetJobDetails()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                
            $jobDetails = $this->Job->appGetJobDetails($data, $message);            
            if(!$jobDetails) {
                  return $this->_returnJson(false, $message);
            }
            else {                  
           
            	  foreach($jobDetails['imageArray'] as $value){
						$dataImage1['images']=$this->fullurl($value['images'],"uploads/job/big/");
                        $dataImage1['id']=$value['id'];
                        $dataImage[]=$dataImage1; 
            	  	
            	  }
            	  $jobDetails['imageArray']=$dataImage;            	
                  return $this->_returnJson(true,$message,$jobDetails);
            }
       }

/**
      * @access public
      * @Method         : app_getCompanyAddress.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 04 Dec2017
      * @description    :
      * @return Company Detail By company id in Json Format
      */
      public function app_getCompanyAddress()
      {
           // {"company_id": "3"}// for testing purpose
             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $companyData=$this->Company->appGetCompanyAddress($data, $message);            
            if(!$companyData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
					if(!empty($companyData['company_logo']))
					{
						$companyData['company_logo']= $this->fullurl($companyData['company_logo'],"uploads/company_logo/thumb/");
					}else{
						$companyData['company_logo']='';
					}
                               	 
                  return $this->_returnJson(true,$message,$companyData);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_editPost.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Edit job details in Json Format
      */
      public function app_editPost(){

        //$requestArgs = $this->request->input();
       $requestArgs = $this->request->data;    
       $editJob=$this->Job->appEditPost($requestArgs, $message);  
       if(!$editJob) {
            return $this->_returnJson(false, $message);
       }else {
            $lastJobId=$requestArgs['job_id'];
            if(!empty($_FILES['MyFile']))
            {
            	$fileCount=count($_FILES['MyFile']['name']);
            	for($i = 0;$i <$fileCount;$i++)
            	{
            		$imagename=$_FILES['MyFile']['name'][$i];
            		$file=basename($imagename);
            		$ext=pathinfo($file,PATHINFO_EXTENSION);
            		$file1= $_FILES['MyFile']['tmp_name'][$i];
            		$new_file_name = time().'_'.$i.'.'.$ext;
            		if(move_uploaded_file($file1, WWW_ROOT.'uploads/job/big/'.$new_file_name))
					{
						//$this->Qimage->resize(array('height' => 150, 'width' => 150, 'file' => WWW_ROOT. '/uploads/job/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/job/thumb/'));
					}
					$jobDetails['Jobimage']['images']=$new_file_name;
					$jobDetails['Jobimage']['job_id']=$lastJobId; 
					$this->Jobimage->save($jobDetails);
					$this->Jobimage->clear();					
            	}    
            }
            return $this->_returnJson(true,$message,$editJob);
       } 
    }
    
    /**
      * @access public
      * @Method         : app_GetJobBidDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return job bid details in Json Format
      */
      public function app_GetJobBidDetails()
      {
           // {"job_Id": "19"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $bidData=$this->Bid->appGetJobBidDetails($data, $message);            
            if(!$bidData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$bidData);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_GetAcceptBidDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Accept job bid details in Json Format
      */
      public function app_GetAcceptBidDetails()
      {
           // {"job_Id": "19"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $acceptBidData=$this->Bid->appGetAcceptBidDetails($data, $message);            
            if(!$acceptBidData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$acceptBidData);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_GetAcceptBidDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Accept job bid details in Json Format
      */
      public function app_deleteJobDetails()
      {
           // {"id": "19"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $deleteJobData=$this->Job->appDeleteJobDetails($data, $message);            
            if(!$deleteJobData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_updateUserDocFile.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         update doc file Details in Json Format
      */
      public function app_updateUserDocFile(&$id='')
      {     
          // echo "<pre>";print_r($this->params->query['id']);die;
           // $this->loadModel('User');
            $file_full = WWW_ROOT.'uploads/doc_file/big/';            
            $id=$this->params->query['id'];
            $userDetails=$this->User->findById($id) ;            
            $imagename=$_FILES['avatar']['name'];    

            if(empty($imagename))
            {
                  $message = 'Invalid name';
                  return $this->_returnJson(false, $message);
            } 
            if(!empty($id))
            {
                  if(!empty($userDetails['Document']))
                  {
                        $docId=$userDetails['Document'][0]['id'];
                        $file=basename($imagename);
                        $ext=pathinfo($file,PATHINFO_EXTENSION);                       
                        //Delete Ext File Form DB and dir
                        if(!empty($userDetails['Document'][0]['doc_file']))
                        {                        
                              unlink($file_full. $userDetails['Document'][0]['doc_file']);                       
                        }
                        $file1= $_FILES['avatar']['tmp_name'];
                        $new_file_name = time().'.'.$ext;
                        if(move_uploaded_file($file1, WWW_ROOT.'uploads/doc_file/big/'.$new_file_name))
                        {
                              //$this->Qimage->resize(array('height' => 100, 'width' => 120, 'file' => WWW_ROOT. '/uploads/doc_file/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/doc_file/thumb/'));
                        }
                        //$imagename=$new_file_name;            
                        $userDetails['Document']['id']=$docId;
                        $userDetails['Document']['doc_file']=$new_file_name;
                        //we are updating single file


                  }else{

                        $file=basename($imagename);
                        $ext=pathinfo($file,PATHINFO_EXTENSION);
                        $file1= $_FILES['avatar']['tmp_name'];
                        $new_file_name = time().'.'.$ext;
                        if(move_uploaded_file($file1, WWW_ROOT.'uploads/doc_file/big/'.$new_file_name))
                        {
                              //$this->Qimage->resize(array('height' => 100, 'width' => 120, 'file' => WWW_ROOT. '/uploads/doc_file/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/doc_file/thumb/'));
                        }
                        //$imagename=$new_file_name;
                        $userDetails['Document']['user_id']=$id;
                        $userDetails['Document']['doc_file']=$new_file_name;
                  } 

                  if ($this->Document->save($userDetails)) {
                        $message = 'Document save successfully';
                        return $this->_returnJson(true, $message,$userDetails);   

                  } else {
                        $message = 'Oops! Some error occurred, please try again';
                        return $this->_returnJson(false, $message);                
                  } 

            }
            
      }
      
      /**
      * @access public
      * @Method         : app_GetUserDocDetailById.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return User Doc Details in Json Format
      */
      public function app_GetUserDocDetailById()
      {
           // {"id": ""}// for testing purpose
                                                                                          
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);  
            extract($data);       
            $user_id                = isset($id)      ? $id : ''; 
           if(!empty($user_id))
            {
                  $getDocDetails = $this->Document->find('all', array(
                        'recursive' => -1,
                        'conditions' => array(
                            'Document.user_id' => $user_id,                 
                            )
                        ));
                  if(!empty($getDocDetails)){
                        
                        foreach($getDocDetails as $value){

                              $ext = pathinfo($value['Document']['doc_file'], PATHINFO_EXTENSION);
                              if(in_array(strtolower($ext), array('jpg', 'jpeg', 'gif','png','bmp','tife')))
                              {
                                    $dataImage1['ext']='image';

                              }else if(in_array(strtolower($ext), array('doc', 'docx','msword'))){
                                    
                                    $dataImage1['ext']='doc';

                              }else{

                                    $dataImage1['ext']='pdf';
                              }
                              $dataImage1['images']=$this->fullurl($value['Document']['doc_file'],"uploads/doc_file/big/");
                              $dataImage1['id']=$value['Document']['id'];
                            
                              $dataImage[]=$dataImage1;
                        }                    
                    $docDetails['imageArray']=$dataImage;
                    return $this->_returnJson(true,'Successfully',$docDetails);
            
                  }else{

                  return $this->_returnJson(false,'No record found');
                  }
            }             
      }
      
      /**
      * @access public
      * @Method         : app_deleteCompanyDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : delete Company Details
      */
      public function app_deleteCompanyDetails()
      {
           // {"id": "19"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $deleteCompanyData=$this->Company->appDeleteCompanyDetails($data, $message);            
            if(!$deleteCompanyData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_GetJobDetailsByCompanyId.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return app Get Job Details By CompanyId
      */
        public function app_GetJobDetailsByCompanyId()
        {
            
            // {"companyid": "19","uId":""}// for testing purpose         
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                
            $filterData = $this->Job->appGetJobDetailsByCompanyId($data, $message);            
            if(!$filterData) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$filterData);
            }
       }
       
       /**
      * @access public
      * @Method         : app_GetBookedJobDetailsByCompanyId.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return app Get Booked Job Details By CompanyId
      */
        public function app_GetBookedJobDetailsByCompanyId()
        {
            
            // {"companyid": "19","uId":""}// for testing purpose         
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                
            $filterBookedData = $this->Job->appGetBookedJobDetailsByCompanyId($data, $message);            
            if(!$filterBookedData) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$filterBookedData);
            }
       }
       
       /**
      * @access public
      * @Method         : app_GetUserJobDetailByCategoryId.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return User jobs Details in Json Format
      */
      public function app_getEmployeeJobsByCategoryId()
      {
           // {"category_id": ""}// for testing purpose
                                                                                          
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $employeeJobDetails=$this->Job->appGetEmployeeJobsByCategoryId($data, $message);            
            if(!$employeeJobDetails) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message,$employeeJobDetails);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_GetUserJobBidDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return          User job bid details in Json Format
      */
      public function app_GetUserJobBidDetails()
      {
           // {"jobId": "11","UserId":"47"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $userBidData=$this->Bid->appGetUserJobBidDetails($data, $message);             
            if(!$userBidData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$userBidData);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_placeBid.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return 
      */
      public function app_placeBid()
      {
            //{"user_id": "","job_id": "","bid_value":""}// for testing purpose           
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);           
            //send args to model function
            $bidData=$this->Bid->appPlaceBid($data, $message);            
            if(!$bidData) {
                  
                  return $this->_returnJson(false, $message);
            }
            else {                  
                  return $this->_returnJson(true,$message);
            } 

      }
      
      /**
      * @access public
      * @Method         : Deletes Last Bid of employee.
      * @Developer      : Ayush Gupta(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return 
      */
      public function app_deleteLastBid(){

            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true); 
            //send args to model function
            $bidData=$this->Bid->appDeleteLastBid($data, $message);            
            if(!$bidData) {
                  
                  return $this->_returnJson(false, $message);
            }
            else {                  
                  return $this->_returnJson(true,$message);
            } 
      }
      
      /**
      * @access public
      * @Method         : app_bidAcceptRejectData.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return 
      */
      public function app_bidAcceptRejectData()
      {
             

            //{"emp_id": "","job_id": "","message":"","status":""}// for testing purpose           
            $requestArgs = $this->request->input();            
            $data       = json_decode($requestArgs,true);          
            //send args to model function
            $bidStatusData=$this->Bid->appBidAcceptReject($data, $message);            
            if(!$bidStatusData) {
                  
                  return $this->_returnJson(false, $message);
            }
            else {                  
                  return $this->_returnJson(true,$message);
            } 

      }

      /**
      * @access public
      * @Method         : app_GetUserDocCount.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return 
      */
        public function app_GetUserDocCount()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                
            $docData = $this->Document->appGetUserDocCount($data, $message);            
            if(!$docData) {
                  
                  return $this->_returnJson(false, $message);
            }
            else {       

                  return $this->_returnJson(true,$message,$docData);
            }
       }


	/** New code 05 Jan 2018*/
	
	 /**
      * @access public
      * @Method         : app_GetUserNotificationById.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Notification Details in Json Format
      */
      public function app_GetUserNotificationById()
      {
           // {"id": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $notificationData=$this->Notification->appGetUserNotificationById($data, $message);
            if(!$notificationData) {

                  return $this->_returnJson(false, $message);
            }
            else {  

                  return $this->_returnJson(true,$message,$notificationData);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_updateUnreadNotification.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Notification Details in Json Format
      */
      public function app_updateUnreadNotification()
      {
           // {"id": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $notificationData=$this->Notification->appUpdateUnreadNotification($data, $message);
            if(!$notificationData) {

                  return $this->_returnJson(false, $message);
            }
            else {  

                  return $this->_returnJson(true,$message,$notificationData);
            } 

      }

 /**
      * @access public
      * @Method         : app_getJobsByCategoryId.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return User jobs Details in Json Format
      */
      public function app_getJobsByCategoryId()
      {
           // {"category_id": ""}// for testing purpose
                                                                                          
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $employeeJobDetails=$this->Job->appGetJobsByCategoryId($data, $message);            
            if(!$employeeJobDetails) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message,$employeeJobDetails);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_GetJobDetailsForGuest.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Job in Json Format
      */
        public function app_GetJobDetailsForGuest()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                
            $jobDetails = $this->Job->appGetJobDetails($data, $message);            
            if(!$jobDetails) {
                  return $this->_returnJson(false, $message);
            }
            else {                  
           
                    foreach($jobDetails['imageArray'] as $value){
                        $dataImage[]['images']=$this->fullurl($value['images'],"uploads/job/big/"); 
                        
                    }
                    $jobDetails['imageArray']=$dataImage;               
                  return $this->_returnJson(true,$message,$jobDetails);
            }
       }
       
       /**
      * @access public
      * @Method         : app_GetOpenJobsByCalendar.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Job Details in Json Format
      */
        public function app_GetOpenJobsByCalendar()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);  
            //echo "<pre>";print_r($data);die;
            $calendarJobData = $this->Job->appGetOpenJobsByCalendar($data, $message);
            if(!$calendarJobData) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$calendarJobData);
            }
       }

	   /*
	   12 Jan 2018
	   */
	    /**
      * @access public
      * @Method         : app_deleteJobImage.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return app delete Job Image
      */
      public function app_deleteJobImage()
      {
           // {"id": "19"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $deleteJobImage=$this->Jobimage->appDeleteJobImage($data, $message);       
            if(!$app_deleteJobImage) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message);
            } 

      }
	  
	  /**
      * @access public
      * @Method         : app_GetOpenJobsByCalendar.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Job Details in Json Format
      */
        public function app_GetBookedJobsByCalendar()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);  
            //echo "<pre>";print_r($data);die;
            $calendarBookedJobData = $this->Job->appGetBookedJobsByCalendar($data, $message);
            if(!$calendarBookedJobData) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$calendarBookedJobData);
            }
       }
	   
	   /**
      * @access public
      * @Method         : app_GetOpenJobsForEmployeeByCalendar.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Job Details in Json Format
      */
        public function app_GetOpenJobsForEmployeeByCalendar()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);  
            //echo "<pre>";print_r($data);die;
            $calendarJobDataForEmployee = $this->Job->appGetOpenJobsForEmployeeByCalendar($data, $message);
            if(!$calendarJobDataForEmployee) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$calendarJobDataForEmployee);
            }
       }
	   
	   
	   /**
      * @access public
      * @Method         : app_getEmployeeMyJobs.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return User jobs Details in Json Format
      */
      public function app_getEmployeeMyJobs()
      {
           // {"user_id": ""}// for testing purpose
                                                                                          
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $employeeMyJobDetails=$this->Bid->appGetEmployeeMyJobs($data, $message);            
            if(!$employeeMyJobDetails) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message,$employeeMyJobDetails);
            } 

      }
	   
	   /**
      * @access public
      * @Method         : app_getJobsByGeographicalSearch.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : jobs Details in Json Format
      */
      public function app_getJobsByGeographicalSearch()
      {
           // {"category_id": ""}// for testing purpose
                                                                                          
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);               
            $JobDetailsArray=$this->Job->appGetJobsByGeographicalSearch($data, $message);      
            if(!$JobDetailsArray) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message,$JobDetailsArray);
            } 

      }

	/**
      * @access public
      * @Method         : app_updateMarkJobComplete.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : update Mark Job Complete Status
      */
      public function app_updateMarkJobComplete()
      {
           // {"category_id": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $JobDetailsArray=$this->JobComplete->appUpdateMarkJobComplete($data, $message);
            if(!$JobDetailsArray) {
                  return $this->_returnJson(false, $message);
            }
            else {

                  return $this->_returnJson(true,$message,$JobDetailsArray);
            } 

      }


      /**
      * @access public
      * @Method         : app_getMarkJobComployeeList.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : Get Mark Job Complete by job id
      */
      public function app_getMarkJobEmployeeList()
      {
           // {"id": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $JobDetailsArray=$this->JobComplete->appGetMarkJobEmployeeList($data, $message);
            if(!$JobDetailsArray) {                  
                  return $this->_returnJson(false, $message);
            }
            else {
                  return $this->_returnJson(true,$message,$JobDetailsArray);
            } 

      }



      /**
      * @access public
      * @Method         : app_sendMessage.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return app_sendMessage
      */
      public function app_sendMessage()
      {
           // {"id": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $sendMessageData=$this->Notification->appSendMessage($data, $message);
            if(!$sendMessageData) {

                  return $this->_returnJson(false, $message);
            }
            else {  

                  return $this->_returnJson(true,$message);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_getCompanyDocuments.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return get Company Documents in Json Format
      */
        public function app_getCompanyDocuments()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            extract($data);

            $companyID=isset($company_id) ? $company_id : '';

            if(!empty($companyID))
            {
                 $companyDocDetails =$this->CompanyDocument->find('all',array(
                  'conditions'=>array(
                        'CompanyDocument.company_id'=>$companyID)));
                 if(!empty($companyDocDetails))
                 {
                  
                  //echo"<pre>";print_r($value);die;
                  foreach($companyDocDetails as $value){
						$ext = pathinfo($value['CompanyDocument']['doc_name'], PATHINFO_EXTENSION);
                        if(in_array(strtolower($ext), array('jpg', 'jpeg', 'gif','png','bmp','tife')))
                        {
                              $dataImage1['ext']='image';

                        }else if(in_array(strtolower($ext), array('doc', 'docx','msword'))){
                              
                              $dataImage1['ext']='doc';

                        }else{
                              $dataImage1['ext']='pdf';
                        }
                        $dataImage1['images']=$this->fullurl($value['CompanyDocument']['doc_name'],"uploads/company_doc/big/");
                        $dataImage1['id']=$value['CompanyDocument']['id'];
                        $dataImage[]=$dataImage1;
                    }                    
                    $docDetails['imageArray']=$dataImage;
                    return $this->_returnJson(true,'Successfully',$docDetails);
                 }else{
                        return $this->_returnJson(false,'No record found');
                 }
            }           
       }


      /**
      * @access public
      * @Method         : app_deleteCompanyDocDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : delete Company Doc Details
      */
      public function app_deleteCompanyDocDetails()
      {
           // {"id": "19"}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $deleteCompanyDocData=$this->CompanyDocument->appDeleteCompanyDocDetails($data, $message);            
            if(!$deleteCompanyDocData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message);
            } 

      }
	  
	  /**
      * @access public
      * @Method         : app_GetJobsForEmployeeByCalendar.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Job Details in Json Format
      */
        public function app_GetJobsForEmployeeByCalendar()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);  
            //echo "<pre>";print_r($data);die;
            $calendarJobDataForEmployee = $this->Bid->appGetJobsForEmployeeByCalendar($data, $message);
            if(!$calendarJobDataForEmployee) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$calendarJobDataForEmployee);
            }
       }
       
       /**
      * @access public
      * @Method         : app_deleteUserDocFile
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : delete User Doc Details
      */
      public function app_deleteUserDocFile()
      {
           // {"id": "19"}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $deleteUserDocData=$this->Document->appDeleteUserDocDetails($data, $message);            
            if(!$deleteUserDocData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_getSearchEmployeeJobs.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :app get all jobs search by employee SEARCH JOB Page
      * @return 
      */
      public function app_getSearchEmployeeJobs()
      {
           // {"user_id": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $employeeSearchJobDetails=$this->Job->appGetSearchEmployeeJobs($data, $message);            
            if(!$employeeSearchJobDetails) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message,$employeeSearchJobDetails);
            } 

      }

      /**
      * @access public
      * @Method         : app_getEmployeeMyBidsJobs.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return User bids Details in Json Format
      */
      public function app_getEmployeeMyBidsJobs()
      {
           // {"user_id": ""}// for testing purpose
                                                                                          
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            $employeeMyJobDetails=$this->Bid->appGetEmployeeMyBidsJobs($data, $message);            
            if(!$employeeMyJobDetails) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message,$employeeMyJobDetails);
            } 

      }


      /**
      * @access public
      * @Method         : app_GetMyBidsForEmployeeByCalendar.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return My Bids Details in Json Format
      */
        public function app_GetMyBidsForEmployeeByCalendar()
        {

            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);              
            $calendarMyBidsDataForEmployee = $this->Bid->appGetMyBidsForEmployeeByCalendar($data, $message);
            if(!$calendarMyBidsDataForEmployee) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$calendarMyBidsDataForEmployee);
            }
       }
       
       //08Feb
       
        /**
      * @access public
      * @Method         : app_getMarkJobDetailsForEmployerByID.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : Get Mark Job Complete by id 
      */
      public function app_getMarkJobDetailsForEmployerByID()
      {
           // {"id": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $markJobDetailsArray=$this->JobComplete->appGetMarkJobDetailsForEmployerByID($data, $message);
            if(!$markJobDetailsArray) {                  
                  return $this->_returnJson(false, $message);
            }
            else {
                  return $this->_returnJson(true,$message,$markJobDetailsArray);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_ganratedDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : genrate hash code and set user details
      */

      public function app_ganratedDetails()
      {            

            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);            
            if(!empty($data['markjob_id']))
            {
                    //genrate random number
                    $txnid=$this->randomTxnId();                   
                    $bidDetails=$this->Bid->find('first',array(
                        'conditions'=>array(
                              'Bid.user_id'=>$data['markjob_id']['User']['id'],
                              'Bid.job_id'=>$data['markjob_id']['Job']['id'],
                              'Bid.status'=>1),
                              'order' => array('Bid.id DESC'),
                        ));       
                        //Employee Id 
                    $employeeID=$data['markjob_id']['User']['id'];
                    $jobID=$data['markjob_id']['Job']['id'];
                    $payu['lastname']=  $employeeID.','.$jobID;                  
                    $payu['txnid'] = $txnid;
                    $payu['key'] = Configure::read('PAYU_MERCHANT_KEY');                    
                    $payu['firstname'] = $data['markjob_id']['User']['name'];
                    $payu['email'] =$data['markjob_id']['User']['email'];
                    $payu['phone'] = $data['markjob_id']['User']['phone'];   
                    $payu['amount'] =$bidDetails['Bid']['bid_amount'];                 
                    $payu['productinfo'] =$data['markjob_id']['Job']['description'];     // Product Info                    
                    $payu['surl'] = Router::url('/api/v1.0/success/',true);   // Success Url
                    $payu['furl'] = Router::url('/api/v1.0/failure/',true);   // Fail Url*/
                    $data=$this->generateHash($payu);
                    $payu['hash']=$data;
                    return $this->_returnJson(true,'Successfully',$payu);                                        
            }            
      }

      /**
      * @access public
      * @Method         : generateHash.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : genrate hash code 
      */
      private function generateHash($posted = []) {
        $salt          = Configure::read('PAYU_MERCHANT_SALT');
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }
        $hash_string .= $salt;
         return $this->hash = strtolower(hash('sha512', $hash_string));

      }


      /**
      * @access public
      * @Method         : randomTxnId.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : genrate hash code 
      */

      public function randomTxnId() {
        // Generate random transaction id
        return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
      }

      /**
      * @access public
      * @Method         : success.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : Payment success route 
      */
     
      public function success()
      {

           // {"id": ""}// for testing purpose
           
           //in last name first is user_id , 2nd is job_id
            $requestArgs = $this->request->data;            
           // echo "<pre>";print_r($requestArgs);die;
            $paymentHistoryDetailsArray=$this->PaymentHistory->savePaymentHistory($requestArgs, $message);
            if(!$paymentHistoryDetailsArray) {                  
                  return $this->_returnJson(false, $message);
            }
            else {
                 
                  $this->redirect("".Configure::read('MOTIPOTLI_URL')."paymentStatus/".$paymentHistoryDetailsArray);
            }          

      }
      
      /**
      * @access public
      * @Method         : failure.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : Save comming data in db and set Payment failure route 
      */
     
      public function failure()
      {
            //$idd='37982739287';           
            //in last name first is user_id , 2nd is job_id
            $requestArgs = $this->request->data;  
           // echo "<pre>";print_r($requestArgs);die;                     
            $paymentHistoryDetailsArray=$this->PaymentHistory->savePaymentHistory($requestArgs, $message);
            if(!$paymentHistoryDetailsArray) {                  
                  return $this->_returnJson(false, $message);
            }
            else {
                                          
                  //$this->redirect("".Configure::read('MOTIPOTLI_URL')."paymentStatus?txnid=".$paymentHistoryDetailsArray);                 
                  $this->redirect("".Configure::read('MOTIPOTLI_URL')."paymentStatus/".$paymentHistoryDetailsArray);                 
                  //$this->redirect('http://google.com');                  
            }

      }



      /**
      * @access public
      * @Method         : app_getPaymentTransactionStatus.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : app get Payment Transaction Status 
      */
      public function app_getPaymentTransactionStatus()
      {
           // {"txnid": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $transactionStatus=$this->PaymentHistory->appGetPaymentTransactionStatus($data, $message);
            if(!$transactionStatus) {                  
                  return $this->_returnJson(false, $message);
            }
            else {
                  return $this->_returnJson(true,$message,$transactionStatus);
            } 

      }
      
      //16Feb
      
      /**
      * @access public
      * @Method         : app_sendMailStartEndNotification.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         :
      */
     //code replace
	  public function app_sendMailStartEndNotification()
      {      
            
            if (!$this->request->is('POST')) {
                  echo 'Invalid Request.';die;
            }
 
            $curDate=DATE('Y-m-d');
            $getAllJobs=$this->Job->find('all',array(
                    'conditions'=>array(
                        'AND'=>array(                           
                                'OR'=>array(
                                    'Job.startdate' => array($curDate),
                                    'Job.enddate' => array($curDate),
                                     'Job.job_status'=>0,
                                     'Job.job_status'=>1,
                                    )
                        ))
                  ));
            
            if(!empty($getAllJobs))
            {
                  foreach($getAllJobs as $jobValue)
                  {
                       
                        if($jobValue['Job']['startdate'] == $curDate)
                        {
                              
                              
                                  //notificatio code
                                  $to_id = $jobValue['Job']['user_id'] ; //if where notification will save
                                  $messageDate = date('Y-m-d H:i:s');
                                  $notificationMessage = 'Your job <b>'.' '.$jobValue['Job']['title'].'</b> '.'under <b>'.' '.$jobValue['Category']['name'].' '.'</b> Category is being started today .' ;
                                  $notificationArray['Notification']['from_id'] ='';
                                  $notificationArray['Notification']['to_id']=$to_id;
                                  $notificationArray['Notification']['job_id']= $jobValue['Job']['id'];
                                  $notificationArray['Notification']['message'] = $notificationMessage;
                                  $notificationArray['Notification']['type']='startjob';
                                  $notificationArray['Notification']['login_type']='employer';
                                  $notificationArray['Notification']['message_date']= $messageDate;
                                  $this->Notification->save($notificationArray);
                                  $this->Notification->clear();
                            
                              $tokenDetails=$this->UserToken->find('all',array(
                                  'recursive'=>-1,
                                  'conditions'=>array(
                                      'UserToken.user_id'=>$jobValue['Job']['user_id'])));
                              //Get User Details for send notification if he allow notification
                              
                              if(!empty($tokenDetails))
                              {
                                    foreach($tokenDetails as $tokenValue)
                                    {
                                          $tokenSend1[]=$tokenValue['UserToken']['device_token'];
                                    }                                        
                                    $this->Notification->find('count', array(
                                          'conditions' => array(
                                                'Notification.to_id' => $to_id,
                                                'Notification.read_status'=>0
                                                )));                                   
                                    $this->SendNotification->send_notification($tokenSend1, $badge);
                              }
                        }else if($jobValue['Job']['enddate'] == $curDate){
                              
                             
                                  $to_id = $jobValue['Job']['user_id'] ; //if where notification will save
                                  $messageDate = date('Y-m-d H:i:s');
                                  $notificationMessage = 'Your job <b>'.' '.$jobValue['Job']['title'].'</b> '.'under <b>'.' '.$jobValue['Category']['name'].' '.'</b> Category is being end today .' ;
                                  //echo $notificationMessage; die('aaa');
                                  $notificationArray['Notification']['from_id'] = '';
                                  $notificationArray['Notification']['to_id']=$to_id;
                                  $notificationArray['Notification']['job_id']= $jobValue['Job']['id'];
                                  $notificationArray['Notification']['message'] = $notificationMessage;
                                  $notificationArray['Notification']['type']='endjob';
                                  $notificationArray['Notification']['login_type']='employer';
                                  $notificationArray['Notification']['message_date']= $messageDate;
                                  $this->Notification->save($notificationArray);
                                  $this->Notification->clear();
                                  $tokenDetails=$this->UserToken->find('all',array(
                                        'recursive'=>-1,
                                        'conditions'=>array(
                                            'UserToken.user_id'=>$jobValue['Job']['user_id'])));

                                    if(!empty($tokenDetails))
                                    {      	                             
      	                              foreach($tokenDetails as $tokenValue)
      	                              {
      	                                    $tokenSend1[]=$tokenValue['UserToken']['device_token'];
      	                              }                                        
      	                              $this->Notification->find('count', array(
      	                                    'conditions' => array(
      	                                          'Notification.to_id' => $to_id,
      	                                          'Notification.read_status'=>0
      	                                          )));                                   
      	                              $this->SendNotification->send_notification($tokenSend1, $badge);
                                    }

                                  $getAllAcceptedUserDetails=$this->Bid->find('all',array(
                                    'conditions'=>array(
                                          'Bid.job_id'=>$jobValue['Job']['id'],
                                          'Bid.status'=>1),
                                    ));
                                  if(!empty($getAllAcceptedUserDetails))
                                  {
                                    foreach($getAllAcceptedUserDetails as $bidUser){
                                        
                                              $to_id = $bidUser['Bid']['user_id']; //if where notification will save
                                              $messageDate = date('Y-m-d H:i:s');
                                              $notificationMessage = 'Your job <b>'.' '.$jobValue['Job']['title'].'</b> '.'under <b>'.' '.$jobValue['Category']['name'].' '.'</b> Category is being end today .Mark your job as complete' ;
                                          
                                              //echo $notificationMessage; die('aaa');
                                              $notificationArray['Notification']['from_id'] =$bidUser['Job']['user_id'];
                                              $notificationArray['Notification']['to_id']=$to_id;
                                              $notificationArray['Notification']['job_id']= $jobValue['Job']['id'];
                                              $notificationArray['Notification']['message'] = $notificationMessage;
                                              $notificationArray['Notification']['type']='endjob';
                                              $notificationArray['Notification']['login_type']='employee';
                                              $notificationArray['Notification']['message_date']= $messageDate; 
                                            
                                              $this->Notification->save($notificationArray);
                                              $this->Notification->clear();
                                              
                                               $tokenDetails=$this->UserToken->find('all',array(
                                                    'recursive'=>-1,
                                                    'conditions'=>array(
                                                        'UserToken.user_id'=>$to_id)));

                                                if(!empty($tokenDetails))
                                                {                                                     
                                                      foreach($tokenDetails as $tokenValue)
                                                      {
                                                            $tokenSend1[]=$tokenValue['UserToken']['device_token'];
                                                      }                                        
                                                      $this->Notification->find('count', array(
                                                            'conditions' => array(
                                                                  'Notification.to_id' => $to_id,
                                                                  'Notification.read_status'=>0
                                                                  )));                                   
                                                      $this->SendNotification->send_notification($tokenSend1, $badge);
                                                }

                                          }

                                    }                          
                        }                       
                  }
            }
         
      }
     /* public function app_sendMailStartEndNotification()
      {      

            if (!$this->request->is('POST')) {
                  echo 'Invalid Request.';die;
            }

            $curDate=DATE('Y-m-d');
            $getAllJobs=$this->Job->find('all',array(
                    'conditions'=>array(
                        'AND'=>array(
                            'Job.job_status'=>0,
                                'OR'=>array(
                                    'Job.startdate' => array($curDate),
                                    'Job.enddate' => array($curDate),
                                    )
                        ))
                  ));
            if(!empty($getAllJobs))
            {
                  foreach($getAllJobs as $jobValue)
                  {
                       
                        if($jobValue['Job']['startdate'] == $curDate)
                        {
                            $tokenDetails=$this->UserToken->find('all',array(
                                  'recursive'=>-1,
                                  'conditions'=>array(
                                      'UserToken.user_id'=>$jobValue['Job']['user_id'])));
                             // echo "<pre>";print_r($tokenDetails);die;
                              //Get User Details for send notification if he allow notification
                              
                              if(!empty($tokenDetails))
                              {

                                  //notificatio code
                                  $to_id = $jobValue['Job']['user_id'] ; //if where notification will save
                                  $messageDate = date('Y-m-d H:i:s');
                                  $notificationMessage = 'Your job <b>'.' '.$jobValue['Job']['title'].'</b> '.'under <b>'.' '.$jobValue['Category']['name'].' '.'</b> Category is being started today .' ;
                                 // echo $notificationMessge; die;
                                  $notificationArray['Notification']['from_id'] ='';
                                  $notificationArray['Notification']['to_id']=$to_id;
                                  $notificationArray['Notification']['job_id']= $jobValue['Job']['id'];
                                  $notificationArray['Notification']['message'] = $notificationMessage;
                                  $notificationArray['Notification']['type']='startjob';
                                  $notificationArray['Notification']['login_type']='employer';
                                  $notificationArray['Notification']['message_date']= $messageDate;
                                  $this->Notification->save($notificationArray);
                                  $this->Notification->clear();
                              foreach($tokenDetails as $tokenValue)
                              {
                                    $tokenSend1[]=$tokenValue['UserToken']['device_token'];
                              }                                        
                              $this->Notification->find('count', array(
                                    'conditions' => array(
                                          'Notification.to_id' => $to_id,
                                          'Notification.read_status'=>0
                                          )));                                   
                              $this->SendNotification->send_notification($tokenSend1, $badge);
                              }
                          
                        }else if($jobValue['Job']['enddate'] == $curDate){

                            $tokenDetails=$this->UserToken->find('all',array(
                                  'recursive'=>-1,
                                  'conditions'=>array(
                                      'UserToken.user_id'=>$jobValue['Job']['user_id'])));
                              if(!empty($tokenDetails))
                              {

                                  $to_id = $jobValue['Job']['user_id'] ; //if where notification will save
                                  $messageDate = date('Y-m-d H:i:s');
                                  $notificationMessage = 'Your job <b>'.' '.$jobValue['Job']['title'].'</b> '.'under <b>'.' '.$jobValue['Category']['name'].' '.'</b> Category is being end today .' ;
                                  //echo $notificationMessage; die('aaa');
                                  $notificationArray['Notification']['from_id'] = '';
                                  $notificationArray['Notification']['to_id']=$to_id;
                                  $notificationArray['Notification']['job_id']= $jobValue['Job']['id'];
                                  $notificationArray['Notification']['message'] = $notificationMessage;
                                  $notificationArray['Notification']['type']='endjob';
                                  $notificationArray['Notification']['login_type']='employer';
                                  $notificationArray['Notification']['message_date']= $messageDate;
                              $this->Notification->save($notificationArray);
                              $this->Notification->clear();
                              foreach($tokenDetails as $tokenValue)
                              {
                                    $tokenSend1[]=$tokenValue['UserToken']['device_token'];
                              }                                        
                              $this->Notification->find('count', array(
                                    'conditions' => array(
                                          'Notification.to_id' => $to_id,
                                          'Notification.read_status'=>0
                                          )));                                   
                              $this->SendNotification->send_notification($tokenSend1, $badge);
                              }

                        }
                        //$this->Notification->save($notificationArray);
                       // $this->Notification->clear();
                  }
            }
         
      }*/


      /**
      * @access public
      * @Method         : app_setRatingData.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : 
      */
      public function app_setRatingData()
      {
           // {"txnid": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            //echo "<pre>";print_r($data);die;
            $ratingDetails=$this->Rating->appSetRatingData($data, $message);
            if(!$ratingDetails) {                  
                  return $this->_returnJson(false, $message);
            }
            else {
                  return $this->_returnJson(true,$message);
            } 

      }


      /**
      * @access public
      * @Method         : app_getRatingInfo.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : 
      */
      public function app_getRatingInfo()
      {
           // {"txnid": ""}// for testing purpose
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);      
            $ratingInfo=$this->Rating->appGetRatingInfo($data, $message);
            if(!$ratingInfo) {                  
                  return $this->_returnJson(false, $message);
            }
            else {
                 // echo "<pre>";print_r($ratingInfo);die;
                  return $this->_returnJson(true,$message,$ratingInfo);
            } 

      }

      /**
      * @access public
      * @Method         : app_getSearchEmployeeJobsByFilter.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : jobs Details in Json Format
      */
      public function app_getSearchEmployeeJobsByFilter()
      {
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);               
           // echo "<pre>";print_r($data);die;
            $searchJobDetailsArray=$this->Job->appGetSearchEmployeeJobsByFilter($data, $message);      
            if(!$searchJobDetailsArray) {
                  return $this->_returnJson(false, $message);
            }
            else {     
                  //echo "<pre>";print_r($searchJobDetailsArray);die;
                  return $this->_returnJson(true,$message,$searchJobDetailsArray);
            } 

      }

       /**
      * @access public
      * @Method         : app_getRegisteredEmployeeUserForMessage.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : 
      */
      public function app_getRegisteredEmployeeUserForMessage()
      {
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $searchEmployeeDetailsArray=$this->Bid->appGetRegisteredEmployeeUserForMessage($data, $message);      
            if(!$searchEmployeeDetailsArray) {
                  return $this->_returnJson(false, $message);
            }
            else {     
                  return $this->_returnJson(true,$message,$searchEmployeeDetailsArray);
            } 

      }

      /**
      * @access public
      * @Method         : app_payAmountByCash.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : 
      */
      public function app_payAmountByCash()
      {
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
            $paymentDetailsArray=$this->PaymentHistory->appPayAmountByCash($data, $message);      
            if(!$paymentDetailsArray) {
                  return $this->_returnJson(false, $message);
            }
            else {     
                  return $this->_returnJson(true,$message);
            } 

      }

	/**
      * @access public
      * @Method         : app_UserRatingForCurrentJobDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return          User job bid details in Json Format
      */
      public function app_UserRatingForCurrentJobDetails()
      {
           // {"jobId": "11","UserId":"47"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $userRatingData=$this->Rating->appGetUserRatingForCurrentJobDetails($data, $message);             
            if(!$userRatingData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$userRatingData);
            } 

      }
      
         /**
      * @access public
      * @Method         : app_checkUserPaymentStatusForCurrentJob.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return          User job bid details in Json Format
      */
      public function app_checkUserPaymentStatusForCurrentJob()
      {
           // {"jobId": "11","UserId":"47"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $userPaymentData=$this->PaymentHistory->appCheckUserPaymentStatusForCurrentJob($data, $message);             
            if(!$userPaymentData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$userPaymentData);
            } 

      }
      
       /**
      * @access public
      * @Method         : app_confirmPaymentByEmployee.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return          app confirm Payment By Employee
      */
      public function app_confirmPaymentByEmployee()
      {
           // {"jobId": "11","UserId":"47"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $confirmUserPaymentData=$this->PaymentHistory->appConfirmPaymentByEmployee($data, $message);             
            if(!$confirmUserPaymentData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$confirmUserPaymentData);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_getEmployerTransactionHistory.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return          
      */
      public function app_getEmployerTransactionHistory()
      {
           // {"employer_Id": "11"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $confirmEmployerTransactionHistoryData=$this->PaymentHistory->appGetEmployerTransactionHistory($data, $message);             
            if(!$confirmEmployerTransactionHistoryData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$confirmEmployerTransactionHistoryData);
            } 

      }
      
      
      /**
      * @access public
      * @Method         : app_getEmployeeTransactionHistory.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return          
      */
      public function app_getEmployeeTransactionHistory()
      {
           // {"employee_Id": "11"}// for testing purpose             
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                       
            $confirmEmployeeTransactionHistoryData=$this->PaymentHistory->appGetEmployeeTransactionHistory($data, $message);             
            if(!$confirmEmployeeTransactionHistoryData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$confirmEmployeeTransactionHistoryData);
            } 

      }
      
       /**
      * @access public
      * @Method         : app_getAllPaymentOptionsDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return          
      */
      public function app_getAllPaymentOptionsDetails()
      {
           // {"flag": "1"}// for testing purpose 

            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);  
            $allPaymentOptionsData=$this->PaymentOption->appGetAllPaymentOptionsDetails($data, $message);             
            if(!$allPaymentOptionsData) {
                  return $this->_returnJson(false, $message);
            }
            else {  
                   
                  return $this->_returnJson(true,$message,$allPaymentOptionsData);
            } 

      }
      
       /**
      * @access public
      * @Method         : app_searchEmployerTransactionHistory.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : app search Employer Transaction History  in Json Format
      */
      public function app_searchEmployerTransactionHistory()
      {
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                          
            $searchEmployerTransactionArray=$this->PaymentHistory->appSearchEmployerTransactionHistory($data, $message);      
            if(!$searchEmployerTransactionArray) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message,$searchEmployerTransactionArray);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_searchEmployeeTransactionHistory.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : app search Employee Transaction History  in Json Format
      */
      public function app_searchEmployeeTransactionHistory()
      {
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                          
            $searchEmployeeTransactionArray=$this->PaymentHistory->appSearchEmployeeTransactionHistory($data, $message);      
            if(!$searchEmployeeTransactionArray) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message,$searchEmployeeTransactionArray);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_varifyOTP.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : app varify OTP
      */
      public function app_varifyOTP()
      {
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                          
            $checkOTP=$this->User->appVarifyOTP($data, $message);      
            if(!$checkOTP) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  return $this->_returnJson(true,$message);
            } 

      }
      
      /**
      * @access public
      * @Method         : app_regenerateMobileOTP.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return         : app varify OTP
      */
      public function app_regenerateMobileOTP()
      {

            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                          
            $regenerateMobileOTP=$this->User->appRegenerateMobileOTP($data, $message);      
            if(!$regenerateMobileOTP) {
                  return $this->_returnJson(false, $message);
            }
            else {     

                  $this->send_otp_number($regenerateMobileOTP['User']['phone'],$regenerateMobileOTP['User']['otp']);            
                  return $this->_returnJson(true,$message);
            } 

      }               
    
    /**
      * @access public
      * @Method         : app_getPopularCity.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 03_Nov_2017
      * @description    : get all Popular cities details
      * @return         : details in Json Format
      */

      public function app_getPopularCity()
      {     
            $data=array();
            $popularCitiesDetails= $this->City->appGetPopularCity($data,$message);  
            //echo "<pre>";print_r($popularCitiesDetails);die;
            if(!$popularCitiesDetails)
            {                   
                 return $this->_returnJson(false,$message);

            }else{

                 return $this->_returnJson(true,$message,$popularCitiesDetails);
            }           
      }
      
      /**
      * @access public
      * @Method         : app_populerCityByStateAPI.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 08_Nov_2017
      * @description    : get all City Based on State details
      * @return         : details in Json Format
      */
      public function app_populerCityByStateAPI()
      {     
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);          
            $cityDetails= $this->City->appPopulerCityByStateAPI($data,$message);  
                
            if(!empty($cityDetails))
            {    
                 return $this->_returnJson(true,$message,$cityDetails);

            }else{
                  
                 return $this->_returnJson(false,$message);
            }           
      }
      
      
      
      /**
      * @access public
      * @Method         : app_userTokenForNotification.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 12_Nov_2017
      * @description    :Save user notification Token
      * @return         : details in Json Format
      */
      public function app_userTokenForNotification()
      {     

            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                     
            $tokenDetails= $this->UserToken->appUserTokenForNotification($data,$message);  
                
            if(!empty($tokenDetails))
            {    
                 return $this->_returnJson(true,$message);

            }else{
                  
                 return $this->_returnJson(false,$message);
            }           
      }


     /**
      * @access public
      * @Method         : app_getAboutUsPageDetails.
      * @Created by      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    : Get about us page details
      * @return         : details in Json Format
      */
      public function app_getAboutUsPageDetails()
      {     

            $condition = array('Managelist.type' => array('about','contact'));
            $getDetails=$this->Managelist->find('all',array(
                  'conditions'=> $condition ));
            
            if(!empty($getDetails)) {
                  
                  foreach ($getDetails as $getvalue) {
                        $type = $getvalue['Managelist']['type'];
                        $arrayValue[$type]['id']=$getvalue['Managelist']['id'];
                        $arrayValue[$type]['listitem']=$getvalue['Managelist']['listitem'];
                        $arrayValue[$type]['content']=$getvalue['Managelist']['content'];
                  }      
                  return $this->_returnJson(true,'ok',$arrayValue);
            }
            else {
                  return $this->_returnJson(false, 'no record found');                     
            }             
      }
      
      /**
      * @access public
      * @Method         : app_sendContactQuery.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    : app send Contact Query
      * @return 
      */
      public function app_sendContactQuery()
      {

            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
           // echo "<pre>";print_r($data['name']);die;
            $userName    = isset($data['name'])       ?  strtolower($data['name'])    : '';
            $email       = isset($data['email'])      ?  strtolower($data['email'])   : '';             
            $message     = isset($data['message'])    ? $data['message']              : '';
            if(!empty($email))
            {
                  //send email to admin
                 $emailArray =array();
                 $emailArray['to']='amit.luthra@evontech.com'; //amit.luthra@evontech.com
                 $emailArray['body']=$message;
                 $emailArray['subject']='Motipotli Contact Form Query';
                 ///save email into dp 
                 $saveArray['ContactQuery']['name']=$userName;
                 $saveArray['ContactQuery']['email']=$email;
                 $saveArray['ContactQuery']['message']=$message; 

                 if ($this->ContactQuery->save($saveArray)) {
                        $this->send_mail($emailArray);
                        $message = 'Thank You for your inquiry. We will get back to you ASAP';
                        return $this->_returnJson(true, $message);
                  } else {
                        $message = 'Oops! Some error occurred, please try again';
                        return $this->_returnJson(false, $message);                
                  }

            }      
      }
       /**
      * @access public
      * @Method         : app_gethireWorkersDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    : Get hire Workers Details 
      * @return         : details in Json Format
      */
      public function app_gethireWorkersDetails()
      {     

            $getDetails=$this->Managelist->find('first',array(
                  'conditions'=>array(
                        'Managelist.type'=>'hire')));          

            if(!empty($getDetails)) {
                  
                  $arrayValue['id']=$getDetails['Managelist']['id'];
                  $arrayValue['listitem']=$getDetails['Managelist']['listitem'];
                  $arrayValue['content']=$getDetails['Managelist']['content'];
                  return $this->_returnJson(true,'ok',$arrayValue);
                 
            }
            else {  

                  return $this->_returnJson(false, 'no record found');   
                  //echo "<pre>";print_r($searchJobDetailsArray);die;
                  
            }             
      }
      
      /**
      * @access public
      * @Method         : app_gethowitworksDetails.
      * @Created by      : Ayush Gupta(Evon Technologies)
      * @Date           : 
      * @description    : Get hire Workers Details 
      * @return         : details in Json Format
      */
      public function app_gethowitworksDetails()
      {     

            $getDetails=$this->Managelist->find('first',array(
                  'conditions'=>array(
                        'Managelist.type'=>'howitworks')));          

            if(!empty($getDetails)) {
                  
                  $arrayValue['id']=$getDetails['Managelist']['id'];
                  $arrayValue['listitem']=$getDetails['Managelist']['listitem'];
                  $arrayValue['content']=$getDetails['Managelist']['content'];
                  return $this->_returnJson(true,'ok',$arrayValue);
                 
            }
            else {  

                  return $this->_returnJson(false, 'no record found');   
                  //echo "<pre>";print_r($searchJobDetailsArray);die;
                  
            }              
      }
    
        
        /**
      * @access public
      * @Method         : app_gethowitworksDetails.
      * @Created by      : Ayush Gupta(Evon Technologies)
      * @Date           : 
      * @description    : Get Privacy Policies Details 
      * @return         : details in Json Format
      */
      public function app_getPrivacyPolicies()
      {     

            $getDetails=$this->Managelist->find('first',array(
                  'conditions'=>array(
                        'Managelist.type'=>'privacy')));          

            if(!empty($getDetails)) {
                  
                  $arrayValue['id']=$getDetails['Managelist']['id'];
                  $arrayValue['listitem']=$getDetails['Managelist']['listitem'];
                  $arrayValue['content']=$getDetails['Managelist']['content'];
                  return $this->_returnJson(true,'ok',$arrayValue);
                 
            }
            else {  

                  return $this->_returnJson(false, 'no record found');   
                  //echo "<pre>";print_r($searchJobDetailsArray);die;
                  
            }              
      }

      /**
      * @access public
      * @Method         : app_gettermsDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    : Get app_get termsDetails
      * @return         : details in Json Format
      */
      public function app_gettermsDetails()
      {     

            $getDetails=$this->Managelist->find('first',array(
                  'conditions'=>array(
                        'Managelist.type'=>'terms')));          

            if(!empty($getDetails)) {
                  
                  $arrayValue['id']=$getDetails['Managelist']['id'];
                  $arrayValue['listitem']=$getDetails['Managelist']['listitem'];
                  $arrayValue['content']=$getDetails['Managelist']['content'];
                  return $this->_returnJson(true,'ok',$arrayValue);
                 
            }
            else {  

                  return $this->_returnJson(false, 'no record found');   
                  //echo "<pre>";print_r($searchJobDetailsArray);die;
                  
            }             
      }

       /**
      * @access public
      * @Method         : app_getjobPostContentDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    : Get app_getjobPostContentDetails
      * @return         : details in Json Format
      */
      public function app_getjobPostContentDetails()
      {     

            $getDetails=$this->Managelist->find('first',array(
                  'conditions'=>array(
                        'Managelist.type'=>'newjob')));          

            if(!empty($getDetails)) {
                  
                  $arrayValue['id']=$getDetails['Managelist']['id'];
                  $arrayValue['listitem']=$getDetails['Managelist']['listitem'];
                  $arrayValue['content']=$getDetails['Managelist']['content'];
                  return $this->_returnJson(true,'ok',$arrayValue);
                 
            }
            else {  

                  return $this->_returnJson(false, 'no record found');   
                  //echo "<pre>";print_r($searchJobDetailsArray);die;
                  
            }             
      }
	  
	  /**
      * @access public
      * @Method         : app_getFaqDetailsPageDetails.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    : Get app_getFaqDetailsPageDetails
      * @return         : details in Json Format
      */
      public function app_getFaqDetailsPageDetails()
      {     

            $getDetails=$this->Faq->find('all',array(
                  'conditions'=>array('Faq.status'=>1),
                  'order'=>array('Faq.id ASC')
                  ));          
           
            if(!empty($getDetails)) {
                 
                  foreach($getDetails as $value)
                  {

                        $arrayValue['id']=$value['Faq']['id'];
                        $arrayValue['question']=$value['Faq']['question'];
                        $arrayValue['answer']=$value['Faq']['answer'];                    
                        $return[]= $arrayValue;                      
                  }
                // echo "<pre>";print_r($return);
                  return $this->_returnJson(true,'successfully',$return);
            }
            else {  

                  return $this->_returnJson(false, 'no record found');   
                  //echo "<pre>";print_r($searchJobDetailsArray);die;                 
            }        
      }
      
      /**
 * 26 March 
 */


      /**
      * @access public
      * @Method         : app_sendMailStartEndNotification.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    : Update job status if job expired or booked
      * @return         :
      */
     
      public function app_updateJobExpireStatus()
      {      
	//die('111');
            if (!$this->request->is('POST')) {
                  echo 'Invalid Request.';die;
            }
            /**
             $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
            $prev_date = date('Y-m-d', strtotime($date .' -1 day'));
            $next_date = date('Y-m-d', strtotime($date .' +1 day'));
             */
            $curDate=DATE('Y-m-d');    
            $prev_date = date('Y-m-d', strtotime($curDate .' -1 day'));   
           
            $getAllJobs=$this->Job->find('all',array(
                 // 'recursive'=>-1,
                    'conditions'=>array(
                        'AND'=>array(
                            'Job.job_status'=>0,
                                'OR'=>array(                             
                                    'Job.enddate' =>$prev_date,
                                    )
                        )),
                    'order'=>array('Job.id DESC')
                  ));

            
            //If the job is an open state and has no bid yet and job reached at their end date, then it should go to expired jobs.

            //if the job is an open state and has 1 accepted bid  and job reached at their end date, then it should go to booked job.
           
            //echo "<pre>";print_r($getAllJobs);die('end');
            if(!empty($getAllJobs))
            {
                  foreach($getAllJobs as $value){     
                        //if job has bid
                        if(!empty($value['Bid'])){
                             //$myarray[]=$value;                              
                              // get total accepted bid for this job
                               $getAcceptedBidDetails=$this->Bid->find('first',array(
                                    'conditions'=>array(
                                          'Bid.job_id'=>$value['Job']['id'],
                                          'Bid.status'=>1,
                                          ),'order'=>array('Bid.id DESC'))
                                    );  
                                                   
                               if(!empty($getAcceptedBidDetails)){
                                              
                                    //set job as booked                        
                                    $jobArrayStatus['Job']['job_status']='1'; //job booked
                                    $jobArrayStatus['Job']['id']=$value['Job']['id']; 
                                    
                               }else{
                                    //if no bid accpted and job reached at end date
                                    //Get all
                                    $getAllBidDetails=$this->Bid->find('all',array(
                                          'conditions'=>array(
                                                'Bid.job_id'=>$value['Job']['id'],
                                                'Bid.status'=>0,
                                                ),'order'=>array('Bid.id DESC'))
                                          );
                                     
                                     if(!empty($getAllBidDetails)){
                                          foreach($getAllBidDetails as $bidVal){

                                                //send notification to employee for job filling    
                                                $notificationMessage= $this->Bid->setBookedJobNotification($value,$bidVal);
                                                $messageDate = date('Y-m-d H:i:s');
                                                $notificationArray['Notification']['from_id'] = $value['Job']['user_id'] ;
                                                $notificationArray['Notification']['to_id']=$bidVal['Bid']['user_id'];
                                                $notificationArray['Notification']['job_id']= $value['Job']['id'];
                                                $notificationArray['Notification']['message'] = $notificationMessage;
                                                $notificationArray['Notification']['type']='filled';
                                                $notificationArray['Notification']['login_type']='employee';
                                                $notificationArray['Notification']['message_date']= $messageDate;
                                                $this->Notification->save($notificationArray);
                                                $this->Notification->clear();
                                               
                                                //change bid status pening to filled
                                                $bidChangeStatusArray['Bid']['id']=$bidVal['Bid']['id'];
                                                $bidChangeStatusArray['Bid']['status']='3';// as job filled 
                                                $this->Bid->save($bidChangeStatusArray);
                                                $this->Bid->clear();
                                                 //send notification to allow user 
                                                $tokenDetails=$this->UserToken->find('all',array(
                                                    'recursive'=>-1,
                                                    'conditions'=>array(
                                                        'UserToken.user_id'=>$bidVal['Bid']['user_id'])));

                                                if(!empty($tokenDetails))
                                                {
                                                      foreach($tokenDetails as $tokenValue)
                                                      {
                                                            $tokenSend1[]=$tokenValue['UserToken']['device_token'];
                                                      }                                        
                                                      $this->Notification->find('count', array(
                                                      'conditions' => array(
                                                            'Notification.to_id' => $to_id,
                                                            'Notification.read_status'=>0
                                                            )));                                   
                                                      $this->SendNotification->send_notification($tokenSend1, $badge);
                                                }
                                          }
                                    }

                                    $jobArrayStatus['Job']['job_status']='3'; //job expired
                                    $jobArrayStatus['Job']['id']=$value['Job']['id']; 
                               }                              
                               //save job details 
                              $this->Job->save($jobArrayStatus);
                              $this->Job->clear();


                        }else{
                            //  die('no bid');
                             
                              $jobArrayStatus['Job']['job_status']='3'; //job expired
                              $jobArrayStatus['Job']['id']=$value['Job']['id'];
                              $this->Job->save($jobArrayStatus);
                              $this->Job->clear();
                        } 
                  }

            }
         
      }

      /**
      * @access public
      * @Method         : app_GetExpiredJobs.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return job Details in Json Format
      */
        public function app_GetExpiredJobs()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                
            $openJobData = $this->Job->appGetExpiredJobs($data, $message);            
            if(!$openJobData) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$openJobData);
            }
       }

       /**
      * @access public
      * @Method         : app_GetExpiredJobDetailsByCompanyId.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 30_Oct_2017
      * @description    :
      * @return app Get expired Job Details By CompanyId
      */
        public function app_GetExpiredJobDetailsByCompanyId()
        {
            
            // {"companyid": "19","uId":""}// for testing purpose         
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);                
            $filterData = $this->Job->appGetExpiredJobDetailsByCompanyId($data, $message);            
            if(!$filterData) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$filterData);
            }
       }

      /**
      * @access public
      * @Method         : app_GetExpiredJobsByCalendar.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Job Details in Json Format
      */
        public function app_GetExpiredJobsByCalendar()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);  
            //echo "<pre>";print_r($data);die;
            $calendarJobData = $this->Job->appGetExpiredJobsByCalendar($data, $message);
            if(!$calendarJobData) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                  return $this->_returnJson(true,$message,$calendarJobData);
            }
       }
	   
	   /**
      * @access public
      * @Method         : app_updateMobileForOTP.
      * @Developer      : Rafi Ahmad(Evon Technologies)
      * @Date           : 
      * @description    :
      * @return Otp Details in Json Format
      */
        public function app_updateMobileForOTP()
        {
            
            $requestArgs = $this->request->input();
            $data       = json_decode($requestArgs,true);
             //8758748667         
            $otpbData = $this->User->appUpdateMobileForOTP($data, $message);
            if(!$otpbData) {
                  return $this->_returnJson(false, $message);
            }
            else {            
                               
                  $this->send_otp_number($otpbData['User']['phone'],$otpbData['User']['otp']);
                  return $this->_returnJson(true,$message);
                  //return $this->_returnJson(true,$message,$otpbData);
            }
       }
	   
	    public function app_cronTest()
        {
            
           $saveArray['User']['id']='185';
           $saveArray['User']['status']='1';
           $this->User->save($saveArray);
           $this->User->clear();
       }
      
      
      
      
      

}//class end
