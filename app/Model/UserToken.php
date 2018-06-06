<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::import('Component','Qimage');  
App::import('Model', 'DeviceToken'); 
App::import('Model', 'Document'); 
App::import('Model', 'Category');

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
class UserToken extends AppModel {

	
	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	*/
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

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
	
	public function appUserTokenForNotification($myArrayData=null, &$message='')
	{   
 		
		//Extract Comming Data
		extract($myArrayData);		
        $user_id    = isset($user_id)  	?  $user_id  	: '';
        $device_token       = isset($device_token) 	?  $device_token 	: '';
		$device_type       = isset($device_type) 	?  $device_type 	: '';
          
        if(!empty($user_id))
        {
        	$userData = $this->find('first',array(
	    											'recursive'=>-1,
	    											'conditions'=>array(
	    													'UserToken.user_id'=>$user_id,
	    													'UserToken.device_token'=>$device_token
	    												)
													));
        	if(empty($userData)){

	        	$tokenArray['UserToken']['user_id']      = $user_id;       
	        	$tokenArray['UserToken']['device_token']     = $device_token;
	        	$tokenArray['UserToken']['device_type']     = $device_type;
				if ($this->Save($tokenArray)) {
					$message = 'Token has been save successfully';
				    return true;          
				} else {
				    $message = 'Oops! Some error occurred, please try again';
				    return false;
				}
			}
        }     
    }

}
