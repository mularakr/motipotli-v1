<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Company');
App::import('Model', 'User');
App::import('Model', 'Notification');
App::import('Model', 'Category');
App::import('Model', 'JobComplete');
App::import('Model','Job');
App::import('Model', 'Rating');
App::import('Component','SendNotification');
App::import('Model', 'UserToken');
/**
 * Bid Model
 *
 * @property Job $Job
 * @property User $User
 */
class Bid extends AppModel {


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

/**
	* @access public
	* @Method appGetJobDetails.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :01_Dec_2017
	* @param string $myArrayData    
	* @return job details in Json Format
	*/
	
	public function appGetJobBidDetails($myArrayData=null, &$message='')
	{   
		$Company = new Company();
		$Rating =new Rating();
		//Extract Comming Data
		extract($myArrayData); 

		$jobId  = isset($jobId) ? $jobId : '';				
		if(!empty($jobId)){			
           $getBidDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Bid.job_id'=>$jobId,      
            		'Bid.status'=>0,             		            	
            		),
            		'order' => array('Bid.id DESC'),
            	
            	));         
           //accept bid count 
			
           if(!empty($getBidDetails))
           {  

           		//get total job position           
           		//echo "<pre>";print_r($getBidDetails[0]['Job']['positions']);
           		//total accept job count for this job id
           		$acceptBidCount=$this->find('count',array(
            	'conditions'=>array(
            		'Bid.job_id'=>$jobId,      
            		'Bid.status'=>1,             		
            		//'NOT' => array('Bid.status' =>array(0,2))	
            		),
            		'order' => array('Bid.id DESC'),
            	
            	));

				//
				if($acceptBidCount >=$getBidDetails[0]['Job']['positions'])
				{					
					$message = 'Job position full';
            		return false;

				}else{

						foreach($getBidDetails as $bidValue)
		           		{
		           			$bidData['bid_id'] = $bidValue['Bid']['id'];
							$bidData['job_id'] = $bidValue['Bid']['job_id'];
							$bidData['bid_amount'] = $bidValue['Bid']['bid_amount'];
							$bidData['bid_attempt'] = $bidValue['Bid']['bid_attempt'];
							$bidData['bid_status'] = $bidValue['Bid']['status'];
							$bidData['employee_name'] = $bidValue['User']['name'];
							$bidData['employee_id'] = $bidValue['User']['id'];
							
							$getRating = $Rating->find('all', array(
						    'conditions' => array(
						    'Rating.user_id' => $bidData['employee_id']),
						    'fields' => array('sum(Rating.rating) as total_sum','count(Rating.rating) as total')));


							if(!empty($getRating[0][0]['total_sum']))
							{
							//$bidData['employee_rating']='0';	
								$bidData['employee_rating']=round($getRating[0][0]['total_sum']/$getRating[0][0]['total'],0);								
							}else{
								$bidData['employee_rating']='0';
							}
							
							$lastBidDetails=$this->find('first',array(
								'conditions'=>array(
									'Bid.user_id'=>$bidData['employee_id'],
									'Bid.job_id'=>$bidValue['Bid']['job_id'],
									'Bid.status'=>2),
									'fields' => array('Bid.status','Bid.bid_amount'),
									'order' => array('Bid.id DESC'),
								));

							if(!empty($lastBidDetails['Bid']['status']))
							{
								$bidData['last_bid_amount'] = $lastBidDetails['Bid']['bid_amount'];
							}
							else{
								$bidData['last_bid_amount']='';
							}
							
							if(empty($companyName)){
								$bidData['company_name'] = 'Personal';
							}else{
								$bidData['company_name'] = $companyName['Company']['title'];
							}

							$companyName=$Company->find('first',array(
								'conditions'=>array(
									'Company.id'=>$bidValue['Job']['company_id']),
									'fields' => array('Company.title'),
								));
							if(empty($companyName)){
								$bidData['company_name'] = 'Personal';
							}else{
								$bidData['company_name'] = $companyName['Company']['title'];
							}		
							$returnData[] = $bidData;           			
		           		}
		           		

		           		$message = 'Successfully';
						return $returnData;  
				

				}
				//echo "<pre>";print_r($acceptBidCount);die;           		          		
           }else{

           		$message = 'no record found';
            	return false;
           }
        }

    }//end


    /**
	* @access public
	* @Method appGetAcceptBidDetails.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :07_Dec_2017
	* @param string $myArrayData    
	* @return accept Bid details in Json Format
	*/
	
	public function appGetAcceptBidDetails($myArrayData=null, &$message='')
	{   
		$Company = new Company();
		$Rating =new Rating();
		//Extract Comming Data
		extract($myArrayData); 

		$jobId  = isset($jobId) ? $jobId : '';				
		if(!empty($jobId)){			
           $getBidDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Bid.job_id'=>$jobId,  
            		'Bid.status'=>1, 
            		),
            		'order' => array('Bid.id DESC'),
            	
            	)); 
           //echo "<pre>";print_r($getBidDetails);die;
           if(!empty($getBidDetails))
           {  
           		foreach($getBidDetails as $bidValue)
           		{
           			$bidData['bid_id'] = $bidValue['Bid']['id'];
					$bidData['job_id'] = $bidValue['Bid']['job_id'];
					$bidData['bid_amount'] = $bidValue['Bid']['bid_amount'];
					$bidData['bid_attempt'] = $bidValue['Bid']['bid_attempt'];
					$bidData['bid_status'] = $bidValue['Bid']['status'];
					$bidData['employee_name'] = $bidValue['User']['name'];
					$bidData['employee_id'] = $bidValue['User']['id'];
					$bidData['employee_phone'] = $bidValue['User']['phone'];
					$bidData['employee_address'] = $bidValue['User']['address'].','.$bidValue['User']['address2'];
					$bidData['employee_email'] = $bidValue['User']['email'];
					$companyName=$Company->find('first',array(
						'conditions'=>array(
							'Company.id'=>$bidValue['Job']['company_id']),
							'fields' => array('Company.title'),
						));
						
						$getRating = $Rating->find('all', array(
						    'conditions' => array(
						    'Rating.user_id' => $bidData['employee_id']),
						    'fields' => array('sum(Rating.rating) as total_sum','count(Rating.rating) as total')));

							//echo "<pre>";print_r($getRating);
							if(!empty($getRating[0][0]['total_sum']))
							{
								//die('1');
								$bidData['employee_rating']=round($getRating[0][0]['total_sum']/$getRating[0][0]['total'],0);								
							}else{
								//die('2');
								$bidData['employee_rating']='0';
							}
							
					if(empty($companyName)){
						$bidData['company_name'] = 'Personal';
					}else{
						$bidData['company_name'] = $companyName['Company']['title'];
					}	
					if($bidData['employee_address'] ==',')
					{
						$bidData['employee_address']='NA';
					}
					$returnData[] = $bidData;           			
           		}
           		$message = 'Successfully';
				return $returnData;            		

           }else{

           		$message = 'no record found';
            	return false;
           }
        }

    }//end



/**
	* @access public
	* @Method appGetUserJobBidDetails.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $myArrayData    
	* @return user job bid details in Json Format
	*/
	
	public function appGetUserJobBidDetails($myArrayData=null, &$message='')
	{   
		$Company = new Company();
		//Extract Comming Data
		extract($myArrayData); 
		$jobId  = isset($jobId) ? $jobId : '';	
		$UserId  = isset($UserId) ? $UserId : '';	

		if(!empty($jobId)){			
           $getBidDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Bid.job_id'=>$jobId, 
            		'Bid.user_id'=>$UserId,            		
            		),
            		'order' => array('Bid.id ASC'),            	
            	)); 
			//echo "<pre>";print_r($getBidDetails);die;
           if(!empty($getBidDetails))
           {  
           		foreach($getBidDetails as $bidValue)
           		{
           			$bidData['bid_id'] = $bidValue['Bid']['id'];
					$bidData['job_id'] = $bidValue['Bid']['job_id'];
					$bidData['bid_amount'] = $bidValue['Bid']['bid_amount'];
					$bidData['bid_attempt'] = $bidValue['Bid']['bid_attempt'];
					$bidData['status'] = $bidValue['Bid']['status'];
					if($bidValue['Bid']['status']==0)
					{
						$bidData['bid_status']='Bid Pending';

					}else if($bidValue['Bid']['status']== 1){

						$bidData['bid_status']='Bid Accepted';

					}else{
						$bidData['bid_status']='Bid Rejected';
					}					
					$returnData[] = $bidData;           			
           		}
           		$message = 'Successfully';
				return $returnData;            		

           }else{

           		$message = 'no record found';
            	return false;
           }
        }

    }//end


/**
	* @access public
	* @Method appPlaceBid.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $myArrayData    
	* @return 
	*/
	
public function appPlaceBid($myArrayData=null, &$message='')
	{   

		$User = new User();
		$Notification = new Notification();
		$UserToken = new UserToken();
		$notificationSend = new SendNotificationComponent(new ComponentCollection);
		
		//Extract Comming Data
		extract($myArrayData); 
		$jobId  = isset($job_id) ? $job_id : '';
		$UserId  = isset($user_id) ? $user_id : '';	
		$bid_value  = isset($bid_value) ? $bid_value : '';	
		//$login_type  = isset($login_type) ? $login_type : '';	
		$bidArray=array();

		if(!empty($jobId)){

		   //get job max bids allowbids count
		   $jobMaxBid=$this->Job->findById($jobId);
		   //get bidder UserDetails
		   $bidderUserDetails=$User->findById($UserId);
		   //get Job Category Name
		   $jobCatagory=$jobMaxBid['Category']['name'];

		   //Get accept bid for this job 
		   $getAcceptBidCountDetails=$this->find('all',array(
           	'recursive'=>-1,
            	'conditions'=>array(
            		'Bid.job_id'=>$jobId, 
            		'Bid.status'=>1,            		
            		),
            		'order' => array('Bid.id ASC'),            	
            	)); 
		   
		   if($jobMaxBid['Job']['positions'] == count($getAcceptBidCountDetails))
		   {
		   		$message = 'Position for this job is already full! Try later ';
		   		return false;

		   }
		   //All accept bid for same job and max position		 
			//get total bid place by user
           $getBidDetails=$this->find('all',array(
           	'recursive'=>-1,
            	'conditions'=>array(
            		'Bid.job_id'=>$jobId, 
            		'Bid.user_id'=>$UserId,            		
            		),
            		'order' => array('Bid.id ASC'),            	
            	));   

	        if(!empty($getBidDetails))
	        {

	        	$totalBidcount=$totalBidcount=count($getBidDetails);
	        	
	        	if($jobMaxBid['Job']['allowbids'] != '0'){
		        	if($totalBidcount >= $jobMaxBid['Job']['allowbids'])
					{
						$message = 'You reached your bid limits';
						return $returnData; 
					}
	        	}

				if($totalBidcount >= $jobMaxBid['Job']['allowbids'])
				{
					$message = 'You reached your bid limits';
					return $returnData; 
				}

				//get last bid status
				$lastBidStatus=$this->find('first',array(
					'recursive'=>-1,
					'conditions'=>array(
						'Bid.job_id'=>$jobId, 
            			'Bid.user_id'=>$UserId, 
						),
					'order' => array('Bid.id DESC'),
					));

				if($lastBidStatus['Bid']['status'] == 0)
				{
					$message = 'Your last bid still pending for this job';	           
	            	return false;

				}elseif($lastBidStatus['Bid']['status'] == 1){

					$message = 'Bid already accepted for this job';	           
	            	return false;
				}

				$bidArray['Bid']['user_id']=$UserId;
	        	$bidArray['Bid']['job_id']=$jobId;
	        	$bidArray['Bid']['bid_amount']=$bid_value;
	        	$bidArray['Bid']['bid_attempt']=$lastBidStatus['Bid']['bid_attempt']+1;	  

	        } else{

	        	$bidArray['Bid']['user_id']=$UserId;
	        	$bidArray['Bid']['job_id']=$jobId;
	        	$bidArray['Bid']['bid_amount']=$bid_value;
	        	$bidArray['Bid']['bid_attempt']=1;
	        } 
	        $notificationArray=array();		
	        if($this->save($bidArray))
	        	{
	        		//set notification based on conditions
					//0 mean personal job
					if($jobMaxBid['Job']['company_id'] != '0')
					{	
						// message with company details
						if($jobMaxBid['Job']['jobcost'] == 'negotiable')
						{
							//set notification Message						
						   	$notificationMessage ='You have received a bid of <b>'.$bid_value.'INR </b> from <b>'.ucwords($bidderUserDetails['User']['name']).'</b> for your company <b>'.$jobMaxBid['Company']['title'].' </b> for the job role of <b>'.$jobMaxBid['Job']['title'].' </b>';

						   	$notifiMsg = 'You have received a bid of '.$bid_value.' from '.ucwords($bidderUserDetails['User']['name']).' for your company '.$jobMaxBid['Company']['title'].' for the job role of '.$jobMaxBid['Job']['title'].' ';

						}else{
							//set notification Message		
						   	$notificationMessage ='You have received a bid of <b>'.$bid_value.' INR</b> from <b>'.ucwords($bidderUserDetails['User']['name']).'</b> for your company <b>'.$jobMaxBid['Company']['title'].' </b> for the job role of <b>'.$jobMaxBid['Job']['title'].' </b>';

						   	$notifiMsg = 'You have received a bid of '.$bid_value.' INR from '.ucwords($bidderUserDetails['User']['name']).' for your company '.$jobMaxBid['Company']['title'].' for the job role of '.$jobMaxBid['Job']['title'].' ';
						}
					}else{

						// message with personal details
						if($jobMaxBid['Job']['jobcost'] == 'negotiable')
						{	
							//set notification Message		             
							$notificationMessage ='You have received a bid of <b>'.$bid_value.' INR</b> from </b>'.ucwords($bidderUserDetails['User']['name']).'</b> for the job <b>'.$jobMaxBid['Job']['title'].'</b>';

							$notifiMsg = 'You have received a bid of '.$bid_value.' INR from '.ucwords($bidderUserDetails['User']['name']).' for the job '.$jobMaxBid['Job']['title'].' ';
						}else{

							//set notification Message		
							$notificationMessage ='You have received an application from <b>'.$bidderUserDetails['User']['name'].' </b> for the job <b>'.$jobMaxBid['Job']['title'].'</b>';

							$notifiMsg = 'You have received an application from '.$bidderUserDetails['User']['name'].' for the job '.$jobMaxBid['Job']['title'].' ';
						}
					}        	
					
					$notificationArray['Notification']['from_id'] = $UserId;
					$notificationArray['Notification']['to_id']=$jobMaxBid['Job']['user_id'];
					$notificationArray['Notification']['job_id']= $jobId;
					$notificationArray['Notification']['message'] = $notificationMessage;
					$notificationArray['Notification']['type']='placebid';
					$notificationArray['Notification']['login_type']= 'employer';
					$notificationArray['Notification']['message_date']= date('Y-m-d H:i:s');
					$Notification->save($notificationArray);
                    $Notification->clear();
					$tokenDetails=$UserToken->find('all',array(
							    'recursive'=>-1,
							    'conditions'=>array(
							        'UserToken.user_id'=>$jobMaxBid['Job']['user_id'])));
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
						    'Notification.to_id' => $jobMaxBid['Job']['user_id'],
						    'Notification.read_status'=>0
						    )
						));                                   
						$notificationSend->send_notification($tokenSend1, $badge);
					}
	        		$message = 'Bid Place Successfully';	           
	            	return true;

	        	}else{
	        		$message = 'Oops! Some error occurred, please try again';	           
	            	return false;

	        	}
        }

    }//end

    /**
	* @access public
	* @Method appPlaceBid.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $myArrayData    
	* @return 
	*/
	
	public function appBidAcceptReject($myArrayData=null, &$message='')
	{   
		$Notification = new Notification();
		$UserToken = new UserToken();
		$notificationSend = new SendNotificationComponent(new ComponentCollection);
		//Extract Comming Data
		extract($myArrayData); 
		$jobId  = isset($job_id) ? $job_id : '';	
		$UserId  = isset($emp_id) ? $emp_id : '';	
		$bid_id  = isset($bid_id) ? $bid_id : '';
		$message  = isset($message) ? $message : '';			
		$status  = isset($status) ? $status : '';
		//$login_type  = isset($login_type) ? $login_type : '';
		$bidStatusArray=array();
		$msg;
		if(!empty($status))
		{		
			
		   //get Job details
		   $jobMaxBid=$this->Job->findById($jobId);				  
		   //get bidder User Details
		   $bidderUserDetails=$this->User->findById($UserId);
		   //get Bid Details
		   $bidDetails=$this->findById($bid_id);			  	
			if($status == 'reject')
			{
				$type='bidreject';
				//set Notification Message if job rejected	
				if($jobMaxBid['Job']['company_id'] != '0')
				{
					// message with company details
					if($jobMaxBid['Job']['jobcost'] == 'negotiable')
					{									
					   	$notificationMessage ='Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR</b> for the job <b>'.$jobMaxBid['Job']['title'].'</b> from <b>'.$jobMaxBid['Company']['title'].'</b> is rejected';

					   	$notifiMsg = 'Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR</b> for the job '.$jobMaxBid['Job']['title'].' from '.$jobMaxBid['Company']['title'].' is rejected';

					}else{							

					  $notificationMessage ='Your application for the job <b>'.$jobMaxBid['Job']['title'].'</b> from <b>'.$jobMaxBid['Company']['title'].'</b> is rejected';

					  $notifiMsg = 'Your application for the job '.$jobMaxBid['Job']['title'].' from '.$jobMaxBid['Company']['title'].' is rejected';
					}

				}else{

					//personal
					if($jobMaxBid['Job']['jobcost'] == 'negotiable')
					{								          
						$notificationMessage ='Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR</b> for the job <b>'.$jobMaxBid['Job']['title'].'</b> is rejected';

						$notifiMsg = 'Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR </b>for the job '.$jobMaxBid['Job']['title'].' is rejected';

					}else{						
						$notificationMessage ='Your application for the job <b>'.$jobMaxBid['Job']['title'].'</b> is rejected';

						$notifiMsg = 'Your application for the job '.$jobMaxBid['Job']['title'].' is rejected';
					}
				}
				
				$bidStatusArray['Bid']['status']=2;
				$msg="Bid rejected successfully";

			}else if($status == 'accept')
			{
				$type='bidaccept';
				//set Notification Message if job accepted	
				if($jobMaxBid['Job']['company_id'] != '0')
				{
					// message with company details
					if($jobMaxBid['Job']['jobcost'] == 'negotiable')
					{									
					   	$notificationMessage ='Congratulations ! Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR</b> for the job <b>'.$jobMaxBid['Job']['title'].'</b> from <b>'.$jobMaxBid['Company']['title'].'</b> is accepted';						   		

					   	$notifiMsg = 'Congratulations ! Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR </b> for the job '.$jobMaxBid['Job']['title'].' from '.$jobMaxBid['Company']['title'].' is accepted';

					}else{							

					  $notificationMessage ='Congratulations ! Your application for the job <b>'.$jobMaxBid['Job']['title'].' </b>from <b>'.$jobMaxBid['Company']['title'].'</b> is accepted';

					  $notifiMsg = 'Congratulations ! Your application for the job '.$jobMaxBid['Job']['title'].' from '.$jobMaxBid['Company']['title'].' is accepted';

					}

				}else{
					//personal
					if($jobMaxBid['Job']['jobcost'] == 'negotiable')
					{								          
						$notificationMessage ='Congratulations ! Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR</b> for the job <b>'.$jobMaxBid['Job']['title'].'</b> is accepted';

						$notifiMsg = 'Congratulations ! Your bid of '.$bidDetails['Bid']['bid_amount'].' for the job '.$jobMaxBid['Job']['title'].' is accepted';
					}else{	

						$notificationMessage ='Congratulations ! Your application for the job <b>'.$jobMaxBid['Job']['title'].'</b> is accepted';

						$notifiMsg = 'Congratulations ! Your application for the job '.$jobMaxBid['Job']['title'].' is accepted';
					}
				}
				//Set Bid Status
				$bidStatusArray['Bid']['status']=1;
				$msg="Bid accepted successfully";
			}
			$bidStatusArray['Bid']['id']=$bid_id;
			if(isset($message) && !empty($message)){

				$messageEmployer='You have received a message from Employer <b>'.ucwords($jobMaxBid['User']['name']).'</b> for the job <b>'.$jobMaxBid['Job']['title'].'</b> <b>" '.$message.' "</b>';
				
				$notifiMsgEmployer ='You have received a message from Employer '.ucwords($jobMaxBid['User']['name']).' for the job '.$jobMaxBid['Job']['title'].' " '.$message.' "';
			

			
			$bidStatusArray['Bid']['bid_message']= isset($messageEmployer) ? $messageEmployer : '';
				
					$messageArray['Notification']['from_id'] = $jobMaxBid['Job']['user_id'];
					$messageArray['Notification']['to_id']=$UserId;
					$messageArray['Notification']['job_id']= $jobId;
					$messageArray['Notification']['message'] = isset($messageEmployer) ? $messageEmployer : '';
					$messageArray['Notification']['type']='message';
					$messageArray['Notification']['login_type']= 'employee';				
					$messageArray['Notification']['message_date']= date('Y-m-d H:i:s');
					$Notification->save($messageArray);
					$Notification->clear();
					$tokenDetails=$UserToken->find('all',array(
					    'recursive'=>-1,
					    'conditions'=>array(
					        'UserToken.user_id'=>$UserId)));
				if(!empty($tokenDetails))
				{
					$i=0;
					foreach($tokenDetails as $tokenValue)
					{
						$tokenSend1[$i]['device_token']=$tokenValue['UserToken']['device_token'];
						$tokenSend1[$i]['device_type']=$tokenValue['UserToken']['device_type'];
						$tokenSend1[$i]['message']= isset($notifiMsgEmployer) ? $notifiMsgEmployer : '';
						$i++;
					}                                        
					$badge = $Notification->find('count', array(
					'conditions' => array(
						'Notification.to_id' => $UserId,
						'Notification.read_status'=>0
						)
					));                                   
					$notificationSend->send_notification($tokenSend1, $badge);
				}
			}
			//echo "<pre>";print_r($notificationMessage);
			if($this->save($bidStatusArray))
        	{	
		    			$notificationArray['Notification']['from_id'] = $jobMaxBid['Job']['user_id'];
						$notificationArray['Notification']['to_id']=$UserId;
						$notificationArray['Notification']['job_id']= $jobId;
						$notificationArray['Notification']['message'] = $notificationMessage;
						$notificationArray['Notification']['type']=$type;
						$notificationArray['Notification']['login_type']= 'employee';				
						$notificationArray['Notification']['message_date']= date('Y-m-d H:i:s');
						$Notification->save($notificationArray);
		                $Notification->clear();
		                
		                $tokenDetails=$UserToken->find('all',array(
								    'recursive'=>-1,
								    'conditions'=>array(
								        'UserToken.user_id'=>$UserId)));
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
						    'Notification.to_id' => $UserId,
						    'Notification.read_status'=>0
						    )
						));                                   
						$notificationSend->send_notification($tokenSend1, $badge);
					}
    			
    			// get total accepted bid for this job
		   		$acceptBidCount=$this->find('count',array(
	            	'conditions'=>array(
	            		'Bid.job_id'=>$jobId,
	            		'Bid.status'=>1,
	            		),
	            		'order' => array('Bid.id DESC'),
            	
            	));
            	
            	//if all the position full then change the job status open to booked and send message to all pending bid user
            	if($acceptBidCount >=$jobMaxBid['Job']['positions'])
				{					
					//status job
					$changeJobStatus['Job']['job_status']='1';
					$changeJobStatus['Job']['id']=$jobId;
					$this->Job->save($changeJobStatus);

					//Get notification message based on condition
					$notificationMessage= $this->setBookedJobNotification($jobMaxBid,$bidDetails); 		   			

		   			//Get All pending user details
					$allBidPendingUserDetails=$this->find('all',array(
		            	'conditions'=>array(
		            		'Bid.job_id'=>$jobId,
		            		'Bid.status'=>0,
		            		),
		            		'order' => array('Bid.id DESC'),
            		));

					if(!empty($allBidPendingUserDetails)){ 

	                    foreach($allBidPendingUserDetails as $value)
	                    {	                        
				    			$messageDate = date('Y-m-d H:i:s');
		                        $notificationArray['Notification']['from_id'] = $value['Job']['user_id'] ;
		                        $notificationArray['Notification']['to_id']=$value['Bid']['user_id'];
		                        $notificationArray['Notification']['job_id']= $value['Job']['id'];
		                        $notificationArray['Notification']['message'] = $notificationMessage['notificationMessage'];
		                        $notificationArray['Notification']['type']='filled';
		                        $notificationArray['Notification']['login_type']='employee';
		                        $notificationArray['Notification']['message_date']= $messageDate;
		                        $Notification->save($notificationArray);
		                        $Notification->clear();
				                
								$tokenDetails=$UserToken->find('all',array(
							    'recursive'=>-1,
							    'conditions'=>array(
							        'UserToken.user_id'=>$value['Bid']['user_id'])));
				        		if(!empty($tokenDetails))
								{
				                
									$i=0;
									foreach($tokenDetails as $tokenValue)
									{
										$tokenSend1[$i]['device_token']=$tokenValue['UserToken']['device_token'];
										$tokenSend1[$i]['device_type']=$tokenValue['UserToken']['device_type'];
										$tokenSend1[$i]['message']= $notificationMessage['notifiMsg'];
										$i++;
									}                                        
									$badge = $Notification->find('count', array(
									'conditions' => array(
									    'Notification.to_id' => $value['Bid']['user_id'],
									    'Notification.read_status'=>0
									    )
									));                                   
									$notificationSend->send_notification($tokenSend1, $badge);
								}
	                        
	                        $bidChangeStatusArray['Bid']['id']=$value['Bid']['id'];
	                        $bidChangeStatusArray['Bid']['status']='3';// as job filled 
	                        $this->save($bidChangeStatusArray);	                        
	                    }
                	}
                	
				}
    			$message = $msg;	           
        		return true;

        	}else{
        		
        		$message = 'Oops! Some error occurred, please try again';	           
            	return false;

        	}
        }

    }//end
	
	
	/**
	* @access public
	* @Method appBidAcceptReject.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $myArrayData    
	* @return 
	*/
	
public function setBookedJobNotification($jobMaxBid=null,$bidDetails=null)
	{
		if($jobMaxBid['Job']['company_id'] != '0')
			{
				//if job posted by company
				if($jobMaxBid['Job']['jobcost'] == 'negotiable')
				{
					$notificationMessage='Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR</b> for the job <b>'.$jobMaxBid['Job']['title'].'</b> from <b>'. $jobMaxBid['Company']['title'] .'</b> is no longer available';

					$notifiMsg ='Your bid of '.$bidDetails['Bid']['bid_amount'].' INR for the job '.$jobMaxBid['Job']['title'].' from '. $jobMaxBid['Company']['title'] .' is no longer available';
				}else{
			
					$notificationMessage='Your application for the job <b>'.$jobMaxBid['Job']['title'].'</b> from <b>'.$jobMaxBid['Company']['title'].'</b> is no longer available';

					$notifiMsg ='Your application for the job '.$jobMaxBid['Job']['title'].' from '.$jobMaxBid['Company']['title'].' is no longer available';
				}
			}else{
				//if job posted by personal
				if($jobMaxBid['Job']['jobcost'] == 'negotiable')
				{
					$notificationMessage='Your bid of <b>'.$bidDetails['Bid']['bid_amount'].' INR </b> for the job <b>'.$jobMaxBid['Job']['title'].'</b> is no longer available';

					$notifiMsg ='Your bid of '.$bidDetails['Bid']['bid_amount'].' INR for the job '.$jobMaxBid['Job']['title'].' is no longer available';

				}else{

					$notificationMessage='Your application for the job <b>'.$jobMaxBid['Job']['title'].'</b> is no longer available';

					$notifiMsg ='Your application for the job '.$jobMaxBid['Job']['title'].' is no longer available';
				}
			}
			return array('notificationMessage' => $notificationMessage, 'notifiMsg' => $notifiMsg);

		//echo "<pre>";print_r($notificationMessage);die;
	}

/**
	* @access public
	* @Method appGetEmployeeMyJobs.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :01_Dec_2017
	* @param string $myArrayData    
	* @return job details in Json Format
	*/
	
	public function appGetEmployeeMyJobs($myArrayData=null, &$message='')
	{   
		//Extract Comming Data
		$Company = new Company();		
		$Category = new Category();
		$JobComplete= new JobComplete();
		extract($myArrayData); 
		$user_id  = isset($user_id) ? $user_id : '';
		if(!empty($user_id)){
           $getBidDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Bid.user_id'=>$user_id, 
            		'Bid.status'=>1,            		
            		),
            		'order' => array('Bid.id DESC'),            	
            	));    
           // echo "<pre>";print_r($getBidDetails);die;
           if(!empty($getBidDetails))
           {

           		foreach($getBidDetails as $value){
					$arrayData['user_id'] = $value['Job']['user_id'];
					$arrayData['job_id'] = $value['Job']['id'];
					$arrayData['title'] = $value['Job']['title'];
            		$arrayData['category_id'] = $value['Job']['category_id'];
            		$arrayData['company_id'] = $value['Job']['company_id'];
            		$arrayData['address1'] = $value['Job']['address1'];
            		$arrayData['address2'] = $value['Job']['address2'];
            		$arrayData['pincode'] = $value['Job']['pincode'];
            		$arrayData['description'] = $value['Job']['description'];
            		$arrayData['state_id'] = $value['Job']['state_id'];
            		$arrayData['city_id'] = $value['Job']['city_id'];
            		$arrayData['startdate'] =date('j,M',strtotime($value['Job']['startdate']));
            		$arrayData['enddate'] = date('j, M',strtotime($value['Job']['enddate']));
                    $arrayData['starttime'] = date('h:i A',strtotime($value['Job']['starttime']));
                    $arrayData['endtime'] = date('h:i A',strtotime($value['Job']['endtime']));
            		$arrayData['jobcost'] = $value['Job']['jobcost'];
            		$arrayData['buyer_cost'] = $value['Job']['buyer_cost'];            		
            		$arrayData['wage_type'] = $value['Job']['wage_type'];
                    $arrayData['total_wage'] = $value['Job']['total_wage'];
            		$arrayData['filename'] = $value['Job']['filename'];
            		$arrayData['allowbids'] = $value['Job']['allowbids'];
            		$arrayData['allowbid_cost'] = $value['Job']['allowbid_cost'];
            		$arrayData['idproof'] = $value['Job']['idproof'];
            		$arrayData['dated'] = $value['Job']['dated'];
            		$arrayData['include_value'] = $value['Job']['include_value'];
            		$arrayData['iscomplete'] = $value['Job']['iscomplete'];
            		$arrayData['iscompany_address'] = $value['Job']['iscompany_address'];
            		$arrayData['status'] = $value['Job']['status'];
            		$arrayData['job_status'] = $value['Job']['job_status'];
            		$arrayData['bid_status']=$value['Bid']['status'];
                    $arrayData['total_bid']=count($value['Bid']);

                    $getCompleteStatus=$JobComplete->find('first',array(
                    	'conditions'=>array(
                    		'JobComplete.user_id'=>$user_id,
                    		'JobComplete.job_id'=>$value['Job']['id'],
                    		//'JobComplete.status'=>1,
                    		))
                    );                 
                    if(!empty($getCompleteStatus))
                    {
                    	if($getCompleteStatus['JobComplete']['status'] == 1 || $getCompleteStatus['JobComplete']['status'] == 3)
                    	{
                    		//(status Pending) job completed by Employee and declined by Employer
                    		$arrayData['buttonStatus']='pending';

                    	}else if($getCompleteStatus['JobComplete']['status'] == 2){

                    		//(status Done) job completed by both Employee/Employer
                    		$arrayData['buttonStatus']='true';
                    	}
                    }else{

                    		$arrayData['buttonStatus']='false';
                    } 
                    //$arrayData['cmplt_status']= flase;

                    
                    //Get Job category Name
                    $getCategoryName=$Category->find('first',array(
                    			'recursive'=>-1,
								'conditions'=>array(
									'Category.id'=>$value['Job']['category_id']),
									'fields' => array('Category.name'),
								));

                    //Get Company details
                    $getCompanyDetails=$Company->find('first',array(
                    			'recursive'=>-1,
								'conditions'=>array(
									'Company.id'=>$value['Job']['company_id']),
								));
                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;

            		//Category array            	
            		$arrayData['category_name'] = $getCategoryName['Category']['name'];
            		$arrayData['company_name'] = $getCompanyDetails['Company']['title'];   
            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$getCompanyDetails['Company']['logo'];    		
            		//User array            		
            		$arrayData['name'] = $value['User']['name'];
					$returnData[] = $arrayData;                  
				}
				$message = 'Successfully';
				return $returnData; 
           }else{
           		
           		$message = 'You have no Active Jobs Yet!';
            	return false;
           }
           //accept bid count 
       }
   }
   
   /** [appGetJobsForEmployeeByCalendar description] */

public function appGetJobsForEmployeeByCalendar($myArrayData=null, &$message='')
	{   
		//Extract Comming Data
		$Company = new Company();		
		$Category = new Category();
		$Job= new Job();
		$JobComplete= new JobComplete();
		extract($myArrayData); 
		$user_id  = isset($user_id) ? $user_id : '';
		$nStart  = isset($start) ? $start : '';
        $nEnd  = isset($end) ? $end : '';
		if(!empty($user_id)){
           $getBidDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Bid.user_id'=>$user_id, 
            		'Bid.status'=>1,            		
            		),
            		'order' => array('Bid.id DESC'),            	
            	)); 
			$startDate=date('Y-m-d',strtotime($nStart));
            $endDate=date('Y-m-d',strtotime($nEnd));				
          // echo "<pre>";print_r($getBidDetails);die;
           if(!empty($getBidDetails))
           {


           		foreach($getBidDetails as $value1){

           			$conditions = array(
                    'conditions'=>array(
                        'AND'=>array(                          
                            'Job.id'=>$value1['Job']['id'],                           
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startDate, $endDate),
                                    'Job.enddate BETWEEN ? and ?' => array($startDate, $endDate),                                   
                                    )
                        ))
                    );
                    $value=$Job->find('first',$conditions);
                    if(!empty($value))
                    {
                    	//echo"<pre>";print_r($value);die;
	                    $arrayData['user_id'] = $value['Job']['user_id'];
						$arrayData['job_id'] = $value['Job']['id'];
						$arrayData['title'] = $value['Job']['title'];
	            		$arrayData['category_id'] = $value['Job']['category_id'];
	            		$arrayData['company_id'] = $value['Job']['company_id'];
	            		$arrayData['address1'] = $value['Job']['address1'];
	            		$arrayData['address2'] = $value['Job']['address2'];
	            		$arrayData['pincode'] = $value['Job']['pincode'];
	            		$arrayData['description'] = $value['Job']['description'];
	            		$arrayData['state_id'] = $value['Job']['state_id'];
	            		$arrayData['city_id'] = $value['Job']['city_id'];
	            		$arrayData['startdate'] =date('j,M',strtotime($value['Job']['startdate']));
	            		$arrayData['enddate'] = date('j, M',strtotime($value['Job']['enddate']));
	                    $arrayData['starttime'] = date('h:i A',strtotime($value['Job']['starttime']));
	                    $arrayData['endtime'] = date('h:i A',strtotime($value['Job']['endtime']));
	            		$arrayData['jobcost'] = $value['Job']['jobcost'];
	            		$arrayData['buyer_cost'] = $value['Job']['buyer_cost'];            		
	            		$arrayData['wage_type'] = $value['Job']['wage_type'];
                    	$arrayData['total_wage'] = $value['Job']['total_wage'];
	            		$arrayData['filename'] = $value['Job']['filename'];
	            		$arrayData['allowbids'] = $value['Job']['allowbids'];
	            		$arrayData['allowbid_cost'] = $value['Job']['allowbid_cost'];
	            		$arrayData['idproof'] = $value['Job']['idproof'];
	            		$arrayData['dated'] = $value['Job']['dated'];
	            		$arrayData['include_value'] = $value['Job']['include_value'];
	            		$arrayData['iscomplete'] = $value['Job']['iscomplete'];
	            		$arrayData['iscompany_address'] = $value['Job']['iscompany_address'];
	            		$arrayData['status'] = $value['Job']['status'];
	            		$arrayData['job_status'] = $value['Job']['job_status'];
	            		$arrayData['bid_status']=$value['Bid']['status'];
	                    $arrayData['total_bid']=count($value['Bid']);
	                 
	                    //Get Job category Name
	                    $getCategoryName=$Category->find('first',array(
	                    			'recursive'=>-1,
									'conditions'=>array(
										'Category.id'=>$value['Job']['category_id']),
										'fields' => array('Category.name'),
									));

	                    //Get Company details
	                    $getCompanyDetails=$Company->find('first',array(
	                    			'recursive'=>-1,
									'conditions'=>array(
										'Company.id'=>$value['Job']['company_id']),
									));
									//Check if job status complete or not 
                    $getCompleteStatus=$JobComplete->find('first',array(
                    	'conditions'=>array(
                    		'JobComplete.user_id'=>$user_id,
                    		'JobComplete.job_id'=>$value['Job']['id'],
                    		//'JobComplete.status'=>1,
                    		))
                    );                 
                    if(!empty($getCompleteStatus))
                    {
                    	if($getCompleteStatus['JobComplete']['status'] == 1 || $getCompleteStatus['JobComplete']['status'] == 3)
                    	{
                    		//(status Pending) job completed by Employee and declined by Employer
                    		$arrayData['buttonStatus']='pending';

                    	}else if($getCompleteStatus['JobComplete']['status'] == 2){

                    		//(status Done) job completed by both Employee/Employer
                    		$arrayData['buttonStatus']='true';
                    	}
                    }else{

                    		$arrayData['buttonStatus']='false';
                    } 
	                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
	                    $hours = intval($timeDiff / 3600); 
	                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
	                    $minutes = intval($seconds_remain / 60);
	                    $arrayData1['total_time'] = $hours.':'.$minutes;
	                    $time=date('H:i',strtotime($arrayData1['total_time']));
	                    $arrayData['total_time']=$time;

	            		//Category array            	
	            		$arrayData['category_name'] = $getCategoryName['Category']['name'];
	            		$arrayData['company_name'] = $getCompanyDetails['Company']['title'];   
	            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$getCompanyDetails['Company']['logo'];    		
	            		//User array            		
	            		$arrayData['name'] = $value['User']['name'];
						$returnData[] = $arrayData; 
						
                    }
                  //  echo"<pre>";print_r($returnData);die;
				}
				$message = 'Successfully';
				return $returnData; 
           }else{
           		
           		$message = 'no record found';
            	return false;
           }
           //accept bid count 
       }
   }

/**
	* @access public
	* @Method appGetEmployeeMyBidsJobs.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $myArrayData    
	* @return bid details with job in Json Format
	*/
	
	public function appGetEmployeeMyBidsJobs($myArrayData=null, &$message='')
	{   
		//Extract Comming Data
		$Company = new Company();		
		$Category = new Category();
		$JobComplete= new JobComplete();
		extract($myArrayData); 		
		if(!empty($user_id)){
          $getBidDetails=$this->find('all',array(        
            	'conditions'=>array(
            		'Bid.user_id'=>$user_id, 
            		),            	
            		'order' => array('Bid.id ASC'),            	
            	));                      
           if(!empty($getBidDetails))
           {
          
           		foreach($getBidDetails as $value){
           			$arrayData['user_id'] = $value['Job']['user_id'];
					$arrayData['job_id'] = $value['Job']['id'];
					$arrayData['title'] = $value['Job']['title'];
            		$arrayData['category_id'] = $value['Job']['category_id'];
            		$arrayData['company_id'] = $value['Job']['company_id'];
            		$arrayData['address1'] = $value['Job']['address1'];
            		$arrayData['address2'] = $value['Job']['address2'];
            		$arrayData['pincode'] = $value['Job']['pincode'];
            		$arrayData['description'] = $value['Job']['description'];
            		$arrayData['state_id'] = $value['Job']['state_id'];
            		$arrayData['city_id'] = $value['Job']['city_id'];
            		$arrayData['startdate'] =date('j,M',strtotime($value['Job']['startdate']));
            		$arrayData['enddate'] = date('j, M',strtotime($value['Job']['enddate']));
                    $arrayData['starttime'] = date('h:i A',strtotime($value['Job']['starttime']));
                    $arrayData['endtime'] = date('h:i A',strtotime($value['Job']['endtime']));
            		$arrayData['jobcost'] = $value['Job']['jobcost'];
            		$arrayData['buyer_cost'] = $value['Job']['buyer_cost'];            		
            		$arrayData['wage_type'] = $value['Job']['wage_type'];
                    $arrayData['total_wage'] = $value['Job']['total_wage'];
            		$arrayData['filename'] = $value['Job']['filename'];
            		$arrayData['allowbids'] = $value['Job']['allowbids'];
            		$arrayData['allowbid_cost'] = $value['Job']['allowbid_cost'];
            		$arrayData['idproof'] = $value['Job']['idproof'];
            		$arrayData['dated'] = $value['Job']['dated'];
            		$arrayData['include_value'] = $value['Job']['include_value'];
            		$arrayData['iscomplete'] = $value['Job']['iscomplete'];
            		$arrayData['iscompany_address'] = $value['Job']['iscompany_address'];
            		$arrayData['status'] = $value['Job']['status'];
            		$arrayData['job_status'] = $value['Job']['job_status'];
            		$arrayData['bid_status']=$value['Bid']['status'];
                    $arrayData['total_bid']=count($value['Bid']); 
                    $arrayData['bid_amount']=$value['Bid']['bid_amount'];
                    if($value['Bid']['status']==0)
					{
						$arrayData['bid_status_val']='Pending';

					}else if($value['Bid']['status']== 1){

						$arrayData['bid_status_val']='Accepted';

					}else if($value['Bid']['status']== 2){
						
						$arrayData['bid_status_val']='Rejected';

					}else{
							$arrayData['bid_status_val']='Position Filled';
					}
                    //Check if job status complete or not 
                    $getCompleteStatus=$JobComplete->find('first',array(
                    	'conditions'=>array(
                    		'JobComplete.user_id'=>$user_id,
                    		'JobComplete.job_id'=>$value['Job']['id'],                    	
                    		))
                    );                 
                    if(!empty($getCompleteStatus))
                    {
                    	if($getCompleteStatus['JobComplete']['status'] == 1 || $getCompleteStatus['JobComplete']['status'] == 3)
                    	{
                    		//(status Pending) job completed by Employee and declined by Employer
                    		$arrayData['buttonStatus']='pending';

                    	}else if($getCompleteStatus['JobComplete']['status'] == 2){

                    		//(status Done) job completed by both Employee/Employer
                    		$arrayData['buttonStatus']='true';
                    	}
                    }else{

                    		$arrayData['buttonStatus']='false';
                    }                  
                    
                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;

                    //Get Job category Name
                    $getCategoryName=$Category->find('first',array(
                    			'recursive'=>-1,
								'conditions'=>array(
									'Category.id'=>$value['Job']['category_id']),
									'fields' => array('Category.name'),
								));

                    //Get Company details
                    $getCompanyDetails=$Company->find('first',array(
                    			'recursive'=>-1,
								'conditions'=>array(
									'Company.id'=>$value['Job']['company_id']),
								));

            		//Category array            	
            		$arrayData['category_name'] = $getCategoryName['Category']['name'];
            		$arrayData['company_name'] = $getCompanyDetails['Company']['title'];   
            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$getCompanyDetails['Company']['logo'];    		
            		//User array            		
            		$arrayData['name'] = $value['User']['name'];
					$returnData[] = $arrayData;  
					                
				}
				$message = 'Successfully';
				return $returnData; 
           }else{
           		
           		$message = 'no bid has been done by you yet!';
            	return false;
           }
           //accept bid count 
       }
   }

/** [appGetMyBidsForEmployeeByCalendar description] */

public function appGetMyBidsForEmployeeByCalendar($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		$Company = new Company();		
		$Category = new Category();
		$Job= new Job();
		$JobComplete= new JobComplete();
		extract($myArrayData); 
		$user_id  = isset($user_id) ? $user_id : '';
		$startDate  = isset($start) ? $start : '';
        $endDate  = isset($end) ? $end : '';
		if(!empty($user_id)){
           $getBidDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Bid.user_id'=>$user_id, 
            		),
            		'order' => array('Bid.id DESC'),            	
            	));    
          
           if(!empty($getBidDetails))
           {


           		foreach($getBidDetails as $value1){

           			$conditions = array(
                    'conditions'=>array(
                        'AND'=>array(                          
                            'Job.id'=>$value1['Job']['id'],                           
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startDate, $endDate),
                                    'Job.enddate BETWEEN ? and ?' => array($startDate, $endDate),                                   
                                    )
                        ))
                    );
                    $value=$Job->find('first',$conditions);
                    if(!empty($value))
                    {
		                    $arrayData['user_id'] = $value['Job']['user_id'];
							$arrayData['job_id'] = $value['Job']['id'];
							$arrayData['title'] = $value['Job']['title'];
		            		$arrayData['category_id'] = $value['Job']['category_id'];
		            		$arrayData['company_id'] = $value['Job']['company_id'];
		            		$arrayData['address1'] = $value['Job']['address1'];
		            		$arrayData['address2'] = $value['Job']['address2'];
		            		$arrayData['pincode'] = $value['Job']['pincode'];
		            		$arrayData['description'] = $value['Job']['description'];
		            		$arrayData['state_id'] = $value['Job']['state_id'];
		            		$arrayData['city_id'] = $value['Job']['city_id'];
		            		$arrayData['startdate'] =date('j,M',strtotime($value['Job']['startdate']));
		            		$arrayData['enddate'] = date('j, M',strtotime($value['Job']['enddate']));
		                    $arrayData['starttime'] = date('h:i A',strtotime($value['Job']['starttime']));
		                    $arrayData['endtime'] = date('h:i A',strtotime($value['Job']['endtime']));
		            		$arrayData['jobcost'] = $value['Job']['jobcost'];
		            		$arrayData['buyer_cost'] = $value['Job']['buyer_cost'];            	
		            		$arrayData['wage_type'] = $value['Job']['wage_type'];
                    		$arrayData['total_wage'] = $value['Job']['total_wage'];	
		            		$arrayData['filename'] = $value['Job']['filename'];
		            		$arrayData['allowbids'] = $value['Job']['allowbids'];
		            		$arrayData['allowbid_cost'] = $value['Job']['allowbid_cost'];
		            		$arrayData['idproof'] = $value['Job']['idproof'];
		            		$arrayData['dated'] = $value['Job']['dated'];
		            		$arrayData['include_value'] = $value['Job']['include_value'];
		            		$arrayData['iscomplete'] = $value['Job']['iscomplete'];
		            		$arrayData['iscompany_address'] = $value['Job']['iscompany_address'];
		            		$arrayData['status'] = $value['Job']['status'];
		            		$arrayData['job_status'] = $value['Job']['job_status'];
		            		$arrayData['bid_status']=$value1['Bid']['status'];
		                    $arrayData['total_bid']=count($value1['Bid']); 
		                    $arrayData['bid_amount']=$value1['Bid']['bid_amount'];
		                    if($value1['Bid']['status']==0)
							{
								$arrayData['bid_status_val']='Pending';

							}else if($value1['Bid']['status']== 1){

								$arrayData['bid_status_val']='Accepted';

							}else if($value1['Bid']['status']== 2){
								
								$arrayData['bid_status_val']='Rejected';

							}else{
									$arrayData['bid_status_val']='Position Filled';
							}
		                    //Check if job status complete or not 
		                    $getCompleteStatus=$JobComplete->find('first',array(
		                    	'conditions'=>array(
		                    		'JobComplete.user_id'=>$user_id,
		                    		'JobComplete.job_id'=>$value['Job']['id'],
		                    		//'JobComplete.status'=>1,
		                    		))
		                    );                 
		                    if(!empty($getCompleteStatus))
		                    {
		                    	if($getCompleteStatus['JobComplete']['status'] == 1 || $getCompleteStatus['JobComplete']['status'] == 3)
		                    	{
		                    		//(status Pending) job completed by Employee and declined by Employer
		                    		$arrayData['buttonStatus']='pending';

		                    	}else if($getCompleteStatus['JobComplete']['status'] == 2){

		                    		//(status Done) job completed by both Employee/Employer
		                    		$arrayData['buttonStatus']='true';
		                    	}
		                    }else{

		                    		$arrayData['buttonStatus']='false';
		                    }                  
		                    
		                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
		                    $hours = intval($timeDiff / 3600); 
		                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
		                    $minutes = intval($seconds_remain / 60);
		                    $arrayData1['total_time'] = $hours.':'.$minutes;
		                    $time=date('H:i',strtotime($arrayData1['total_time']));
		                    $arrayData['total_time']=$time;

		                    //Get Job category Name
		                    $getCategoryName=$Category->find('first',array(
		                    			'recursive'=>-1,
										'conditions'=>array(
											'Category.id'=>$value['Job']['category_id']),
											'fields' => array('Category.name'),
										));

		                    //Get Company details
		                    $getCompanyDetails=$Company->find('first',array(
		                    			'recursive'=>-1,
										'conditions'=>array(
											'Company.id'=>$value['Job']['company_id']),
										));

		            		//Category array            	
		            		$arrayData['category_name'] = $getCategoryName['Category']['name'];
		            		$arrayData['company_name'] = $getCompanyDetails['Company']['title'];   
		            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$getCompanyDetails['Company']['logo'];    		
		            		//User array            		
		            		$arrayData['name'] = $value['User']['name'];
							$returnData[] = $arrayData; 
	                    }
	                    	                   
				}
				$message = 'Successfully';
				return $returnData; 
           }else{
           		
           		$message = 'no record found';
            	return false;
           }
           //accept bid count 
       }
   }
	
	
	/**
	* @access public
	* @Method appGetRegisteredEmployeeUserForMessage.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $myArrayData    
	* @return user details in Json Format
	*/
	
	public function appGetRegisteredEmployeeUserForMessage($myArrayData=null, &$message='')
	{   
		$JobComplete = new JobComplete();

		//Extract Comming Data
		extract($myArrayData); 
		$jobId  = isset($jobId) ? $jobId : '';		
		if(!empty($jobId)){			
           
            $getUserDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Bid.job_id'=>$jobId, 
            		'Bid.status'=>1,            		
            		),
            		'order' => array('Bid.id ASC'),            	
            	));

        	if(!empty($getUserDetails))
        	{
        		foreach($getUserDetails as $value)
        		{	
        			$jobComplete=$JobComplete->find('first',array(
        											'recursive' => -1,
								            		'conditions'=>array(
									            		'JobComplete.job_id'=>$jobId,
									            		'JobComplete.user_id'=>$value['User']['id']
								            		)
								            	));
        			$employeeArray['employee_id']=$value['User']['id'];
        			$employeeArray['employee_name']=$value['User']['name'];
        			$employeeArray['employee_jobStatus']=$jobComplete['JobComplete']['status'];
        			$returnData[] = $employeeArray; 
        		}

        		$message = 'Successfully';
				return $returnData; 

        	} else{

        		$message = 'no record found';
            	return false;
        	}
            // echo "<pre>";print_r($getUserDetails);die;
        }
    }
	

	/**
	* @access public
	* @Method appDeleteLastBid.
	* @Developer : Ayush (Evon Technologies)
	* @Date      :
	* @param string $myArrayData    
	* @return user details in Json Format
	*/
	public function appDeleteLastBid($myArrayData=null, &$message='')
	{   
		
		$Notification = new Notification();

		//Extract Comming Data
		extract($myArrayData); 
		$bidId  = isset($bidId) ? $bidId : '';
		$userId  = isset($userId) ? $userId : '';
		$jobId  = isset($jobId) ? $jobId : '';	
		
		if(!empty($jobId)){			           
            if($this->delete($bidId)){ // deletes last bid of the employee.
				$notificationData = $Notification->find('first', array(
					'recursive'=>-1,
					'conditions' => array(
						'Notification.from_id' => $userId, 
						'Notification.job_id' => $jobId
					),
					'order' => array('Notification.id' => 'DESC'))
				);
				// deletes notification of the respective bid
				if($Notification->delete($notificationData['Notification']['id'])){
					
					$message = 'Successfully deleted last bid';
					$valueID['lastID']=$bidId;					
					return $valueID;  

				}else{
					
					$message = 'no record found';
            		return false;
				}


            }else{

            	$message = 'somthing went wrong';
            	return false;
            }                 
        }
    }
}
