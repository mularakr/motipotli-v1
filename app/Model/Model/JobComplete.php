<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Job'); 
App::import('Model', 'User'); 
App::import('Model', 'Notification'); 
App::import('Model', 'Bid');
App::import('Component','SendNotification');
App::import('Model', 'UserToken');
/**
 * Bid Model	
 *
 * @property Job $Job
 * @property User $User
 */
class JobComplete extends AppModel {


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
	/******************************************************************************* 
	 * 
	 * 						Model API Start Here
	 * 	
	*********************************************************************************/



	/**
	* @access public
	* @Method appUpdateMarkJobComplete.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : app Update Mark Job Complete
	*/
	
	public function appUpdateMarkJobComplete($myArrayData=null, &$message='')
	{   		
		//echo "<pre>";print_r($myArrayData);die;
		//Extract Comming Data
		$Job=new Job();
		$User=new User();
		$Notification=new Notification();
		$UserToken = new UserToken();
		$notificationSend = new SendNotificationComponent(new ComponentCollection);
		extract($myArrayData); 
		$jobId  = isset($jobId) ? $jobId : '';
		$user_id  = isset($user_id) ? $user_id : '';
		$status  = isset($status) ? $status : '';
		if(!empty($jobId))
		{	
		    
			//If jobId and user_id not empty mean Employee mark job as complete and create new entry in db
			if(!empty($jobId) && !empty($user_id)){
				
				$getDetails=$Job->findById($jobId);
				$getUserDetails=$User->findById($user_id);
				//Set message details  for employer regarding job mark as complete
				if(!empty($getDetails))
				{

					foreach($getDetails['Bid'] as $value)
					{
						if($value['user_id'] == $user_id && $value['status'] == 1){
							$amount=$value['bid_amount'];
							break;
						}						
					}

					if($getDetails['Job']['company_id'] != '0')
					{						
							//When Company negotiable/non-negotiable job bid is Completed : 
							$message='The job <b>'.$getDetails['Job']['title'].'</b> from <b>'.$getDetails['Company']['title'].'</b> is completed,you may proceed with the payment of <b>'.$amount.' INR </b> for <b>'.ucwords($getUserDetails['User']['name']).'</b>';		

							$notifiMsg = 'The job '.$getDetails['Job']['title'].' from '.$getDetails['Company']['title'].' is completed,you may proceed with the payment of '.$amount.' INR for '.ucwords($getUserDetails['User']['name']).'';

					}else{

						$message='The job <b>'.$getDetails['Job']['title'].'</b> is completed,you may proceed with the payment of <b>'.$amount.' INR </b>  for <b> '.ucwords($getUserDetails['User']['name']).'</b>';

						$notifiMsg = 'The job '.$getDetails['Job']['title'].' is completed,you may proceed with the payment of '.$amount.' INR for '.ucwords($getUserDetails['User']['name']).' ';


					}
				}				
				//echo "<pre>";print_r($message);die;
				

				//notificatio code
				
					$notificationArray['Notification']['from_id'] = $user_id;
					$notificationArray['Notification']['to_id']=$getDetails['Job']['user_id'];
					$notificationArray['Notification']['job_id']= $jobId;
					$notificationArray['Notification']['message'] = $message;
					$notificationArray['Notification']['type']='markjob';
					$notificationArray['Notification']['login_type']= 'employer';
					$notificationArray['Notification']['message_date']= date('Y-m-d H:i:s');
					$Notification->save($notificationArray);
	                $Notification->clear();
                    $markJobCompleteArray['JobComplete']['user_id']=$user_id;
				    $markJobCompleteArray['JobComplete']['job_id']=$jobId;
				    $markJobCompleteArray['JobComplete']['status']=1;
				    $this->save($markJobCompleteArray);
				    $this->clear();
				    $tokenDetails=$UserToken->find('all',array(
						    'recursive'=>-1,
						    'conditions'=>array(
						        'UserToken.user_id'=>$getDetails['Job']['user_id'])));
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
    							'Notification.to_id' => $getDetails['Job']['user_id'],
    							'Notification.read_status'=>0
    							)));                                   
    					$notificationSend->send_notification($tokenSend1, $badge);
    				}
    				$message = 'Job mark completed';
		            return true;

				//employee mark job as complete				
			   /* $markJobCompleteArray['JobComplete']['user_id']=$user_id;
				$markJobCompleteArray['JobComplete']['job_id']=$jobId;
				$markJobCompleteArray['JobComplete']['status']=1;
			
				if($this->save($markJobCompleteArray))
				{
				    echo "<pre>";print_r($markJobCompleteArray);die;
					$this->clear();
					$message = 'Job mark completed';
		            return true;

				}else{

					$message = 'Oops! Some error occurred, please try again';	           
		            return false;

				}*/
			

			}else{	

				$getDetails=$this->findById($jobId);
				//employer update job status Accept/Declined				
				if($status == 'accept')
				{				
					//$saveArray['job_id']=$jobId;
					$getDetails['JobComplete']['id']=$jobId;
					$getDetails['JobComplete']['status']=2; //Accept
					
				}else{

					//$saveArray['job_id']=$jobId;
					$getDetails['JobComplete']['id']=$jobId;
					$getDetails['JobComplete']['status']=3; //Declined
				}
				if($this->save($getDetails))
    			{
    				$message = 'Job mark completed';
    	            return true;
    
    			}else{
    
    				$message = 'Oops! Some error occurred, please try again';	           
    	            return false;
    
    			}
			}		
		//	echo "<pre>";print_r($getDetails);die;		
			
		}
	}



	/**
	* @access public
	* @Method appGetMarkJobEmployeeList.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : app Get Mark Job Comployee List
	*/
	
	public function appGetMarkJobEmployeeList($myArrayData=null, &$message='')
	{   		
		$Bid=new Bid();
		//Extract Comming Data
		extract($myArrayData); 
		$jobId  = isset($id) ? $id : '';		
		$dataArray=array();
		if(!empty($jobId))
		{	

			$getDataList=$this->find('all',array(
				'conditions'=>array(
					'JobComplete.job_id'=>$jobId,				
					),
				'order' => array('JobComplete.id DESC'),
				));
			
			if(!empty($getDataList))
			{

				foreach($getDataList as $value)
				{
					$findBidAmount=$Bid->find('first',array(
						'conditions'=>array(
							'Bid.user_id'=>$value['User']['id'],
							'Bid.job_id'=>$jobId),
						'order' => array('Bid.id DESC')));
					
					$dataArray['bid_amount']=$findBidAmount['Bid']['bid_amount'];
					$dataArray['id']=$value['JobComplete']['id'];
					$dataArray['job_id']=$value['JobComplete']['job_id'];
					$dataArray['status']=$value['JobComplete']['status'];
					$dataArray['job_title']=$value['Job']['title'];
					$dataArray['user_name']=$value['User']['name'];
					$returnData[] = $dataArray;
				}

				$message = 'Successfully';
				return $returnData;  

			}else{

				$message = 'No record found';	           
	            return false;

			}			
		}
	}
	
	/**
	* @access public
	* @Method appGetMarkJobDetailsForEmployerByID.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : app Get Mark Job list
	*/
	
	public function appGetMarkJobDetailsForEmployerByID($myArrayData=null, &$message='')
	{   		
		//Extract Comming Data
		extract($myArrayData); 
		$markjob_id  = isset($markjob_id) ? $markjob_id : '';		
		$dataArray=array();
		if(!empty($markjob_id))
		{	

			$getDataList=$this->find('first',array(
				'conditions'=>array(
					'JobComplete.id'=>$markjob_id,				
					),
				'order' => array('JobComplete.id DESC'),
				));
			
			if(!empty($getDataList))
			{

				$message = 'Successfully';
				return $getDataList;
				//echo "<pre>";print_r($getDataList);die;
				/*foreach($getDataList as $value)
				{
					$dataArray['id']=$value['JobComplete']['id'];
					$dataArray['job_id']=$value['JobComplete']['job_id'];
					$dataArray['status']=$value['JobComplete']['status'];
					$dataArray['job_title']=$value['Job']['title'];
					$dataArray['user_name']=$value['User']['name'];
					$returnData[] = $dataArray;
				}

				$message = 'Successfully';
				return $returnData; */ 

			}else{

				$message = 'No record found';	           
	            return false;

			}			
		}
	}
}
