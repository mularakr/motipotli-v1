<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Job');
App::import('Model', 'User');
App::import('Component','SendNotification');
App::import('Model', 'UserToken');
App::import('Model', 'Notification');
/**
 * Notification Model
 *
 * @property Job $Job
 */
class Notification extends AppModel {

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
	public $belongsTo = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'job_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);


/******************************************************************************* 
	 * 
	 * 						Model API Start Here
	 * 	
	*********************************************************************************/
	
	/**
	* @access public
	* @Method appGetUserNotificationById.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return Notification Details in Json Format
	*/
	
	public function appGetUserNotificationById($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$user_id  = isset($id) ? $id : '';
		$login_type  = isset($type) ? $type : '';
		if(!empty($user_id))
		{
			$getAllNotificationDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Notification.to_id'=>$user_id,
            		'Notification.login_type'=>$login_type,
            		),            	
            	'order'=>array('Notification.id DESC')
            	));
			//Total unread notification
			
			$getUnreadNotification=$this->find('count',array(
            	'conditions'=>array(
            		'Notification.to_id'=>$user_id,
            		'Notification.login_type'=>$login_type,
            		'Notification.read_status'=>'0',
            		),            	
            	'order'=>array('Notification.id DESC'),            	
            	));

			//echo "<pre>";print_r($getUnreadNotification);die;
			$notificationArray=array();
			if(!empty($getAllNotificationDetails))
			{
				foreach($getAllNotificationDetails as $value)
				{
					$notificationArray['id']=$value['Notification']['id'];
					$notificationArray['job_id']=$value['Notification']['job_id'];
					$notificationArray['message']=$value['Notification']['message'];
					$notificationArray['date'] =date('j,M',strtotime($value['Notification']['message_date']));
                    $notificationArray['time'] = date('h:i A',strtotime($value['Notification']['message_date']));
					$notificationArray['unread_message']=$getUnreadNotification;
					$notificationArray['type']=$value['Notification']['type'];
					$returnData[] = $notificationArray;
				}

				$message = 'Successfully';
				return $returnData;

			}else{

				$message = 'no record found';
            	return false;
			}
		}
	}

	/**
	* @access public
	* @Method appUpdateUnreadNotification.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return Notification Details in Json Format
	*/
	
	public function appUpdateUnreadNotification($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$user_id  = isset($id) ? $id : '';

		if(!empty($user_id))
		{
				if($this->updateAll(array('Notification.read_status' => 1),array('Notification.to_id' =>$user_id))){

					$message = 'updated';
		        	return true;

				}else{
					$message = 'error';
		        	return false;

				}
		}
	}

/**
	* @access public
	* @Method appSendMessage.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return appSendMessage
	*/
	
	public function appSendMessage($myArrayData=null, &$message='')
	{   
 		$Job = new Job();
 		$User = new User();
 		$Notification=new Notification();
 		$UserToken = new UserToken();
		$notificationSend = new SendNotificationComponent(new ComponentCollection);
		//Extract Comming Data
		extract($myArrayData); 
		$job_id  = isset($job_id) ? $job_id : '';
		$from_id  = isset($from_id) ? $from_id : '';
		$login_type  = isset($login_type) ? $login_type : '';
		$message  = isset($message) ? $message : '';
		$employee_id=isset($employee_id) ? $employee_id : '';		
		if(!empty($job_id))
		{
			$getJobDetailsByJobId=$Job->findById($job_id);
			
			$messageArray=array();
			if(!empty($job_id) && !empty($from_id))
			{
				
					
						$userName=$User->findById($from_id);				
					$msg='You have received a message from <b>'.ucwords($userName['User']['name']).'</b> for job <b>'.$getJobDetailsByJobId['Job']['title'].' </b> "'.$message.'"';
						$messageArray['Notification']['from_id']=$from_id;
						$messageArray['Notification']['to_id']=$getJobDetailsByJobId['Job']['user_id'];
						$messageArray['Notification']['job_id']=$job_id;
						$messageArray['Notification']['message']=$msg;
						$messageArray['Notification']['type']='message';
						$messageArray['Notification']['login_type']='employer';				
						$this->save($messageArray);
						$this->clear();					  
						
					 $tokenDetails=$UserToken->find('all',array(
                    'recursive'=>-1,
                    'conditions'=>array(
                        'UserToken.user_id'=>$getJobDetailsByJobId['Job']['user_id'])));
						if(!empty($tokenDetails))
						{
							$i=0;
							foreach($tokenDetails as $tokenValue)
							{
								$tokenSend1[$i]['device_token']=$tokenValue['UserToken']['device_token'];
								$tokenSend1[$i]['device_type']=$tokenValue['UserToken']['device_type'];
								$tokenSend1[$i]['message']= 'You have received a message from '.ucwords($userName['User']['name']).' for job '.$getJobDetailsByJobId['Job']['title'].' "'.$message.'"';
								$i++;
							}                                      
							$badge = $Notification->find('count', array(
								'conditions' => array(
									'Notification.to_id' => $getJobDetailsByJobId['Job']['user_id'],
									'Notification.read_status'=>0
									)
							));
							$notificationSend->send_notification($tokenSend1, $badge);   
															
						   
						}
					$message = 'Message sent successfully';
					return true;
                          
				//message by employee to employer single message

			}else{

					if($employee_id == 'all')//Message send to all
					{
						//message from employer to all employee(bid accepted employee)
						if(!empty($getJobDetailsByJobId['Bid']))
						{
							
							$msg='You have received a message from <b>'.ucwords($getJobDetailsByJobId['User']['name']).'</b> for job <b>'.$getJobDetailsByJobId['Job']['title'].' </b> "'.$message.'"';
							foreach($getJobDetailsByJobId['Bid'] as $value)
							{
								if($value['status'] == '1')
								{
									
											$messageArray['Notification']['from_id']=$getJobDetailsByJobId['Job']['user_id'];
											$messageArray['Notification']['to_id']=$value['user_id'];
											$messageArray['Notification']['job_id']=$job_id;
											$messageArray['Notification']['message']=$msg;
											$messageArray['Notification']['type']='message';
											$messageArray['Notification']['login_type']='employee';
											$this->save($messageArray);
											$this->clear();
						              $tokenDetails=$UserToken->find('all',array(
										'recursive'=>-1,
										'conditions'=>array(
										'UserToken.user_id'=>$value['user_id'])));
										if(!empty($tokenDetails))
										{
										 	$i=0;
											foreach($tokenDetails as $tokenValue)
											{
												$tokenSend1[$i]['device_token']=$tokenValue['UserToken']['device_token'];
												$tokenSend1[$i]['device_type']=$tokenValue['UserToken']['device_type'];
												$tokenSend1[$i]['message']= 'You have received a message from '.ucwords($userName['User']['name']).' for job '.$getJobDetailsByJobId['Job']['title'].' "'.$message.'"';
												$i++;
											}                                        
											
											$badge = $Notification->find('count', array(
											'conditions' => array(
											    'Notification.to_id' => $value['user_id'],
											    'Notification.read_status'=>0
											    )
											));                                   
											$notificationSend->send_notification($tokenSend1, $badge);
							            }
					                continue;
								}
							}
							
							$message = 'Message sent successfully';
				        	return true; 
						}

					}else{ //message send to single person

							
								$msg='You have received a message from <b>'.ucwords($getJobDetailsByJobId['User']['name']).'</b> for job <b>'.$getJobDetailsByJobId['Job']['title'].' </b> "'.$message.'"';

								$notifiMsg = 'You have received a message from '.ucwords($getJobDetailsByJobId['User']['name']).' for job '.$getJobDetailsByJobId['Job']['title'].' "'.$message.'"';

								$messageArray['Notification']['from_id']=$getJobDetailsByJobId['Job']['user_id'];
								$messageArray['Notification']['to_id']=$employee_id;
								$messageArray['Notification']['job_id']=$job_id;
								$messageArray['Notification']['message']=$msg;
								$messageArray['Notification']['type']='message';
								$messageArray['Notification']['login_type']='employee';				
								$this->save($messageArray);
				                $this->clear();	
								$tokenDetails=$UserToken->find('all',array(
                                        'recursive'=>-1,
                                        'conditions'=>array(
                                            'UserToken.user_id'=>$employee_id)));
							if(!empty($tokenDetails))
							{								
								$i=0;
								foreach($tokenDetails as $tokenValue)
								{
									$tokenSend1[$i]['device_token']=$tokenValue['UserToken']['device_token'];
									$tokenSend1[$i]['device_type']=$tokenValue['UserToken']['device_type'];
									$tokenSend1[$i]['message']= $notifiMsg;
									$i++;
								}                                      
                                $badge = $Notification->find('count', array(
                                    'conditions' => array(
                                        'Notification.to_id' => $employee_id,
                                        'Notification.read_status'=>0
                                        )
                                ));                                   
                                $notificationSend->send_notification($tokenSend1, $badge);
				                							
							}
							 $message = 'Message sent successfully';
						     return true; 

						}
					

			}
		}
	}

}