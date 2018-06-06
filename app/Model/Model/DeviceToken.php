<?php
App::uses('AppModel', 'Model');
App::import('Model', 'UserToken');
/**
 * DeviceToken Model
 *
 * @property Job $Job
 */
class DeviceToken extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	/*public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);*/

/******************************************************************************* 
	 * 
	 * 						Model API Start Here
	 * 	
	*********************************************************************************/


/**
	* @access public
	* @Method appUserLogout.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 
	* @param 	 : string $Data    
	* @return 
	*/
	
	public function appUserLogout($myArrayData=null, &$message='')
	{		
		$UserToken = new UserToken();
		extract($myArrayData);
        $userId       = isset($id) 	? $id 	: '';
        $token       = isset($access_token) 	? $access_token 	: '';
        $notificationToken       = isset($notification_token) 	? $notification_token 	: '';        

       
        if(!empty($userId))
        {
        	
        	 $details=$this->find('first',array(
        		'conditions'=>array(
        			'DeviceToken.token'=>$token,
        			'DeviceToken.user_id'=>$userId)));  
        			
			$getNotificationTokenDetails=$UserToken->find('first',array(
			        		'conditions'=>array(
			        			'UserToken.device_token'=>$notificationToken,
			        			'UserToken.user_id'=>$userId)
			        		));
        	if(!empty($details))
        	{        		
				if(!empty($getNotificationTokenDetails)){
					//echo '<pre>';print_r($notificationToken);
					$UserToken->delete($getNotificationTokenDetails['UserToken']['id']);
				}
				$this->delete($details['DeviceToken']['id']);
				//clear();
				$message = 'logout';
            	return ture;

        	}        	
        }
    }

}
