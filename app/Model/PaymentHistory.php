<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Job'); 
App::import('Model', 'User'); 
App::import('Model', 'JobComplete'); 
App::import('Model', 'Bid'); 
App::import('Model', 'Notification');
App::import('Component','SendNotification');
App::import('Model', 'UserToken');
App::import('Model', 'Company');

/**
 * PaymentHistory Model	
 *
 * @property Job $Job
 * @property User $User
 */
class PaymentHistory extends AppModel {


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
	* @Method savePaymentHistory.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : 
	*/
	
	public function getPaymentDetailsForAdmin(){
		$User = new User();
		$Company = new Company();
		$Job = new Job();
		$getDetails=$this->find('all');			
		$paymentArray=array();
		if(!empty($getDetails)){

			foreach($getDetails as $value){

				$JobDetails=$Job->findById($value['Job']['id']);
				
				if(!empty($JobDetails['Job']['company_id']))
				{					
					$paymentArray['company_name']=$JobDetails['Company']['title'];

				}else{
					$paymentArray['company_name']='Personal';

				}
				$paymentArray['title']=$JobDetails['Job']['title'];
				$paymentArray['position']=$JobDetails['Job']['positions'];
				$paymentArray['category']=$JobDetails['Category']['name'];
				$paymentArray['employer_name']=$JobDetails['User']['name'];				
				$paymentArray['date']=$value['PaymentHistory']['payment_date'];			
				$paymentArray['bid_amount']=$value['PaymentHistory']['amount'];
				$paymentArray['employee_name']=$value['User']['name'];				

				if($value['PaymentHistory']['payment_flag'] =='0')
				{
					$paymentArray['payment_status']='Pending';

				}else if($value['PaymentHistory']['payment_flag'] =='1'){

					$paymentArray['payment_status']='Success';

				}else{

					$paymentArray['payment_status']='Declined';

				}		

				$returnData[] = $paymentArray;
				//echo "<pre>";print_r($paymentArray);die;		
			}		
			return $returnData;

		}
	}

	/**
	* @access public
	* @Method savePaymentHistory.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : 
	*/
	
	public function savePaymentHistory($myArrayData=null, &$message='')
	{   				
		//create obj for JobComplete table
		$JobComplete = new JobComplete();
		$jobCompleteArray=array();
		$paymentHistoryArray=array();
		$array=explode(",",$myArrayData['lastname']);
		//Get details
		$jobCompleteValue=$JobComplete->find('first',array('conditions'=>array('JobComplete.user_id'=>$array[0],'JobComplete.job_id'=>$array[1])));
		//echo "<pre>";print_r($jobCompleteValue);die('111');
		
		$paymentHistoryArray['PaymentHistory']['mihpayid']=$myArrayData['mihpayid'];
		$paymentHistoryArray['PaymentHistory']['user_id']=$array[0];
		$paymentHistoryArray['PaymentHistory']['job_id']=$array[1];
		$paymentHistoryArray['PaymentHistory']['employer_id']=$jobCompleteValue['Job']['user_id'];
		$paymentHistoryArray['PaymentHistory']['job_complete_id']=$jobCompleteValue['JobComplete']['id'];
		$paymentHistoryArray['PaymentHistory']['mkey']=$myArrayData['key'];
		$paymentHistoryArray['PaymentHistory']['txnid']=$myArrayData['txnid'];
		$paymentHistoryArray['PaymentHistory']['mode']=$myArrayData['mode'];
		$paymentHistoryArray['PaymentHistory']['status']=$myArrayData['status'];
		$paymentHistoryArray['PaymentHistory']['firstname']=$myArrayData['firstname'];
		$paymentHistoryArray['PaymentHistory']['email']=$myArrayData['email'];
		$paymentHistoryArray['PaymentHistory']['phone']=$myArrayData['phone'];
		$paymentHistoryArray['PaymentHistory']['unmappedstatus']=$myArrayData['unmappedstatus'];
		$paymentHistoryArray['PaymentHistory']['amount']=$myArrayData['amount'];
		$paymentHistoryArray['PaymentHistory']['cardCategory']=$myArrayData['cardCategory'];
		$paymentHistoryArray['PaymentHistory']['discount']=$myArrayData['discount'];
		$paymentHistoryArray['PaymentHistory']['net_amount_debit']=$myArrayData['net_amount_debit'];
		$paymentHistoryArray['PaymentHistory']['addedon']=$myArrayData['addedon'];
		$paymentHistoryArray['PaymentHistory']['productinfo']=$myArrayData['productinfo'];
		$paymentHistoryArray['PaymentHistory']['hash']=$myArrayData['hash'];
		$paymentHistoryArray['PaymentHistory']['field9']=$myArrayData['field9'];
		$paymentHistoryArray['PaymentHistory']['payment_source']=$myArrayData['payment_source'];
		$paymentHistoryArray['PaymentHistory']['PG_TYPE']=$myArrayData['PG_TYPE'];
		$paymentHistoryArray['PaymentHistory']['bank_ref_num']=$myArrayData['bank_ref_num'];
		$paymentHistoryArray['PaymentHistory']['bankcode']=$myArrayData['bankcode'];
		$paymentHistoryArray['PaymentHistory']['error']=$myArrayData['error'];
		$paymentHistoryArray['PaymentHistory']['error_Message']=$myArrayData['error_Message'];
		$paymentHistoryArray['PaymentHistory']['name_on_card']=$myArrayData['name_on_card'];
		$paymentHistoryArray['PaymentHistory']['cardnum']=$myArrayData['cardnum'];
		$paymentHistoryArray['PaymentHistory']['issuing_bank']=$myArrayData['issuing_bank'];
		$paymentHistoryArray['PaymentHistory']['card_type']=$myArrayData['card_type'];
		$paymentHistoryArray['PaymentHistory']['payment_mode']='payu';
		if($myArrayData['status']=='success')
		{
			$paymentHistoryArray['PaymentHistory']['trn_status']=1;
		}else{
			$paymentHistoryArray['PaymentHistory']['trn_status']=2;

		}
		if($this->save($paymentHistoryArray))
			{
				if($myArrayData['status']=='success')
				{
					if($job['JobComplete']=='1')
					{
						//Job Complete Array
						$jobCompleteArray['JobComplete']['id']=$jobCompleteValue['JobComplete']['id'];
						$jobCompleteArray['JobComplete']['user_id']=$array[0];
						$jobCompleteArray['JobComplete']['job_id']=$array[1];
						$jobCompleteArray['JobComplete']['status']=2;						
               			$JobComplete->save($jobCompleteArray);
               			$JobComplete->clear();
					}

				}				
				$message = 'Successfully';
				return $dataArray['txnid']=$myArrayData['txnid'];
	            //return true;

			}else{

				$message = 'Oops! Some error occurred, please try again';	           
	            return false;

			}		

	}

	/**
	* @access public
	* @Method appGetPaymentTransactionStatus.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : 
	*/
	
	public function appGetPaymentTransactionStatus($myArrayData=null, &$message='')
	{   	
		extract($myArrayData); 
		$txnid  = isset($txnid) ? $txnid : '';
		if(!empty($txnid))
		{
			$findDetails=$this->find('first',array(
				'conditions'=>array(
					'PaymentHistory.txnid'=>$txnid)));
			if(!empty($findDetails))
			{
				$message = 'Successfully';
				return $findDetails;
				//echo "<pre>";print_r($findDetails);die;
			}else{

				$message = 'Oops! Some error occurred, please try again';	           
	            return false;

			}
			
		}
		
	}



/**
	* @access public
	* @Method appPayAmountByCash.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : 
	*/
	
	public function appPayAmountByCash($myArrayData=null, &$message='')
	{   	
		$JobComplete = new JobComplete();
		$Bid = new Bid();
		$Job = new Job();
		$Notification=new Notification();
		$UserToken = new UserToken();
		$notificationSend = new SendNotificationComponent(new ComponentCollection);
		//echo "<pre>";print_r($myArrayData);die;
		extract($myArrayData); 
		$payment_source  = isset($payment_source) ? $payment_source : '';
		if(!empty($payment_source))
		{
			
			$array=explode(",",$myArrayData['lastname']);
			$employee_id=$array[0];
			$jobID=$array[1];		
			//Check if already payement for this job
			 $findDetails=$this->find('first',array(
				'conditions'=>array(
					'PaymentHistory.job_id'=>$jobID,
					'PaymentHistory.user_id'=>$employee_id,
					'PaymentHistory.trn_status'=>1)));	
			  
			  // Find JOb details
			  
			  $findJobDetails=$Bid->find('first',array(
				'conditions'=>array(
					'Bid.job_id'=>$jobID,
					'Bid.user_id'=>$employee_id,
					'Bid.status'=>1)));

			   //Find complete job id details 

				$findCompleteJobDetails=$JobComplete->find('first',array(
				'conditions'=>array(
					'JobComplete.job_id'=>$jobID,
					'JobComplete.user_id'=>$employee_id,
					'JobComplete.status'=>1)));
				//Get Company and employer details
				$companyDetails=$Job->findById($jobID);
				if($companyDetails['Job']['company_id'] != '0'){
					$companyName=$companyDetails['Company']['title'];
				}else{
					$companyName='personal';
				}	

			if(!empty($findJobDetails))
			{

				if(!empty($findDetails))
				{
					if($findDetails['PaymentHistory']['payment_mode']=='cash' && $findDetails['PaymentHistory']['payment_flag']=='0')
					{

						$message = 'Payment Already done for this job';
						return false;
					}else if($findDetails['PaymentHistory']['payment_mode']=='cash' && $findDetails['PaymentHistory']['payment_flag']=='1'){

						$message = 'Employee Already Received Confirmation of Payement for this job';
						return false;

					}else if($findDetails['PaymentHistory']['payment_mode']=='cash' && $findDetails['PaymentHistory']['payment_flag']=='2'){

						//Re confirm payemnt for employee
						$msg='You have received cash payment of <b> '.$findJobDetails['Bid']['bid_amount'].' INR</b> for completing the job <b>'.$findJobDetails['Job']['title'].'</b> for company '.$companyName.' by <b>'.$companyDetails['User']['name'].'</b>';

						$notifiMsg = 'You have received cash payment of '.$findJobDetails['Bid']['bid_amount'].' for completing the job '.$findJobDetails['Job']['title'].' for company '.$companyName.' by '.$companyDetails['User']['name'].'';

						$messageArray['Notification']['from_id']=$companyDetails['User']['id'];
						$messageArray['Notification']['to_id']=$employee_id;
						$messageArray['Notification']['job_id']=$jobID;
						$messageArray['Notification']['message']=$msg;
						$messageArray['Notification']['type']='payment';
						$messageArray['Notification']['login_type']='employee';	
           				//Save Notification 
						$Notification->save($messageArray);
               			$Notification->clear();							
						$paymentArray['PaymentHistory']['id']=$findDetails['PaymentHistory']['id'];
						$paymentArray['PaymentHistory']['payment_flag']=0;
						$this->save($paymentArray);
						$this->clear();
						$message = 'Payment initiated successfully';
						return true;

					}

				}else{
					
					//If no payment done for employee
					$paymentArray['PaymentHistory']['user_id']=$employee_id;
					$paymentArray['PaymentHistory']['job_id']=$jobID;
					$paymentArray['PaymentHistory']['employer_id']=$findJobDetails['Job']['user_id'];//employer Id
					$paymentArray['PaymentHistory']['company_id']=$findJobDetails['Job']['company_id'];//employer Id
					$paymentArray['PaymentHistory']['job_complete_id']=$findCompleteJobDetails['JobComplete']['id'];
					$paymentArray['PaymentHistory']['firstname']=$findJobDetails['User']['name'];
					$paymentArray['PaymentHistory']['email']=$findJobDetails['User']['email'];
					$paymentArray['PaymentHistory']['phone']=$findJobDetails['User']['phone'];
					$paymentArray['PaymentHistory']['amount']=$findJobDetails['Bid']['bid_amount'];
					$paymentArray['PaymentHistory']['payment_source']='cash';
					$paymentArray['PaymentHistory']['trn_status']=1;
					$paymentArray['PaymentHistory']['payment_mode']='cash';
					$paymentArray['PaymentHistory']['payment_flag']=0;		

					if($this->save($paymentArray))
					{
						if($findCompleteJobDetails['JobComplete']['status']=='1' || $findCompleteJobDetails['JobComplete']['status']=='3')
						{
							$jobCompleteArray['JobComplete']['id']=$findCompleteJobDetails['JobComplete']['id'];
							$jobCompleteArray['JobComplete']['user_id']=$employee_id;
							$jobCompleteArray['JobComplete']['job_id']=$jobID;
							$jobCompleteArray['JobComplete']['status']=1;

							//send notification to employee regarding payment
							$msg='You have received cash payment of <b>'.$findJobDetails['Bid']['bid_amount'].' INR</b> for completing the job <b>'.$findJobDetails['Job']['title'].'</b> for company '.$companyName.' by <b>'.$companyDetails['User']['name'].'</b>';

							$notifiMsg = 'You have received cash payment of '.$findJobDetails['Bid']['bid_amount'].' for completing the job '.$findJobDetails['Job']['title'].' for company '.$companyName.' by '.$companyDetails['User']['name'].'';

							$messageArray['Notification']['from_id']=$companyDetails['User']['id'];
							$messageArray['Notification']['to_id']=$employee_id;
							$messageArray['Notification']['job_id']=$jobID;
							$messageArray['Notification']['message']=$msg;
							$messageArray['Notification']['type']='payment';
							$messageArray['Notification']['login_type']='employee';	
               				//Save Notification 
							$Notification->save($messageArray);
	               			$Notification->clear();

							//Notification Array 
							               		
								/*$msg='You have received cash payment of <b>'.$findJobDetails['Bid']['bid_amount'].'</b> for completing the job <b>'.$findJobDetails['Job']['title'].'</b> for company '.$companyName.' by <b>'.$companyDetails['User']['name'].'</b>';               			
								$messageArray['Notification']['from_id']=$companyDetails['User']['id'];//employer Id;
								$messageArray['Notification']['to_id']=$employee_id;
								$messageArray['Notification']['job_id']=$jobID;
								$messageArray['Notification']['message']=$msg;
								$messageArray['Notification']['type']='payment';
								$messageArray['Notification']['login_type']='employee';	
	               				
	               				//Save Notification 
								$Notification->save($messageArray);
		               			$Notification->clear();*/
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
	               			//Save Job complete status
							$JobComplete->save($jobCompleteArray);
	               			$JobComplete->clear();
						}
						$message = 'Payment initiated successfully';
						return true;

					}else{
						
						$message = 'Oops! Some error occurred, please try again';	           
	            		return false;
					}

				}

			}else{

				$message = 'Oops! Some error occurred, please try again';	           
	            return false;

			}
			
		}
		
	}

/**
	* @access public
	* @Method appCheckUserPaymentStatusForCurrentJob.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : 
	*/
	
	public function appCheckUserPaymentStatusForCurrentJob($myArrayData=null, &$message='')
	{   	
		/*$JobComplete = new JobComplete();
		$Bid = new Bid();
		$Job = new Job();
		$Notification=new Notification();*/
		//echo "<pre>";print_r($myArrayData);die;
		extract($myArrayData); 
		$jobId  = isset($jobId) ? $jobId : '';
		$UserId  = isset($UserId) ? $UserId : '';
		if(!empty($UserId))
		{

			//Find Payment by cash history
			$paymentDetails=$this->find('first',array(
				'conditions'=>array(
					'PaymentHistory.user_id'=>$UserId,
					'PaymentHistory.job_id'=>$jobId,
					'PaymentHistory.payment_mode'=>'cash')));
			// echo "<pre>";print_r($paymentDetails);die;
			if(!empty($paymentDetails))
			{				
				$message = 'ok';
				return $paymentDetails['PaymentHistory'];

			}else{

				$message = 'Oops! Some error occurred, please try again';	           
	            return false;
			}
		}
	}

/**
	* @access public
	* @Method appCheckUserPaymentStatusForCurrentJob.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : 
	*/
	
	public function appCheckEmployerPaymentStatusForCurrentJob($myArrayData=null, &$message='')
	{   	
		/*$JobComplete = new JobComplete();
		$Bid = new Bid();
		$Job = new Job();
		$Notification=new Notification();*/
		//echo "<pre>";print_r($myArrayData);die;
		extract($myArrayData); 
		$jobId  = isset($jobId) ? $jobId : '';
		$UserId  = isset($UserId) ? $UserId : '';
		if(!empty($UserId))
		{

			//Find Payment by cash history
			$paymentDetails=$this->find('first',array(
				'conditions'=>array(
					'PaymentHistory.employer_id'=>$UserId,
					'PaymentHistory.job_id'=>$jobId,
					'PaymentHistory.payment_mode'=>'cash')));
			// echo "<pre>";print_r($paymentDetails);die;
			if(!empty($paymentDetails))
			{				
				$message = 'ok';
				return $paymentDetails['PaymentHistory'];

			}else{

				$message = 'Oops! Some error occurred, please try again';	           
	            return false;
			}
		}
	}

	/**
	* @access public
	* @Method appConfirmPaymentByEmployee.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : string $myArrayData    
	* @return    : 
	*/
	
	public function appConfirmPaymentByEmployee($myArrayData=null, &$message='')
	{  

		$JobComplete = new JobComplete();
		$Job = new Job();
		$Bid = new Bid();
		$Notification=new Notification();
		$UserToken = new UserToken();
		$notificationSend = new SendNotificationComponent(new ComponentCollection);
		/*$Job = new Job();
		$Notification=new Notification();*/
		//echo "<pre>";print_r($myArrayData);die;
		extract($myArrayData); 
		$job_id  = isset($job_id) ? $job_id : '';
		$user_id  = isset($user_id) ? $user_id : '';
		$payment_id  = isset($payment_id) ? $payment_id : '';
		$caseForm  = isset($caseForm) ? $caseForm : '';	

		if(!empty($payment_id))
		{

			//Find Payment by cash history
			$paymentDetails=$this->find('first',array(
				'conditions'=>array(
					'PaymentHistory.id'=>$payment_id)));
			
			if(!empty($paymentDetails))
			{
				if($caseForm == 'yes')
				{
					$findCompleteJobDetails=$JobComplete->find('first',array(
					'conditions'=>array(
						'JobComplete.job_id'=>$job_id,
						'JobComplete.user_id'=>$user_id,
						'JobComplete.status'=>1)));

					$jobcompleteArray['JobComplete']['id']=$findCompleteJobDetails['JobComplete']['id'];
					$jobcompleteArray['JobComplete']['status']=2;

					$payArray['PaymentHistory']['id']=$payment_id;
					$payArray['PaymentHistory']['payment_flag']=1;
					$payArray['PaymentHistory']['payment_date']=date("Y-m-d");

					//Save Notification 
					$this->save($payArray);
           			$this->clear();
           			//Save Job complete status
					$JobComplete->save($jobcompleteArray);
           			$JobComplete->clear();

           			$JobCompleteCount=$JobComplete->find('count',array(
           				'conditions'=>array(
           					'JobComplete.job_id'=>$job_id,
           					'JobComplete.status' => 2				
           					),
           				'order' => array('JobComplete.id DESC'),
           				));

           			$bidCount=$Bid->find('count',array(
           				'conditions'=>array(
           					'Bid.job_id'=>$job_id,
           					'Bid.status' => 1				
           					),
           				));
					if($JobCompleteCount == $bidCount){
           				$jobData = $Job->findById($job_id);
           				$jobData['Job']['iscomplete'] = 1;
           				$Job->save($jobData);
           				$Job->clear();
           			}

    			}else{

					//Find User Bid details for notification 
					$findJobBidDetails=$Bid->find('first',array(
						'conditions'=>array(
							'Bid.job_id'=>$job_id,
							'Bid.user_id'=>$user_id,
							'Bid.status'=>1),
						'order'=>array('Bid.id DESC')));
					
						$msg='Employee <b>'.$findJobBidDetails['User']['name'].' </b> has declined the received of payment of <b>'.$findJobBidDetails['Bid']['bid_amount'].'  INR</b> for the job <b>'.$findJobBidDetails['Job']['title'].'</b>.';  

						$notifiMsg = 'Employee '.$findJobBidDetails['User']['name'].' has declined the received of payment of '.$findJobBidDetails['Bid']['bid_amount'].'  INR for the job'.$findJobBidDetails['Job']['title'].'.';

						$messageArray['Notification']['from_id']=$user_id;//employee Id;
						$messageArray['Notification']['to_id']=$findJobBidDetails['Job']['user_id']; //Employer Id
						$messageArray['Notification']['job_id']=$job_id;
						$messageArray['Notification']['message']=$msg;
						$messageArray['Notification']['type']='payment';
						$messageArray['Notification']['login_type']='employer';	       			
						//Save Notification 
						$Notification->save($messageArray);
	           			$Notification->clear();
	           			$tokenDetails=$UserToken->find('all',array(
							    'recursive'=>-1,
							    'conditions'=>array(
							        'UserToken.user_id'=>$findJobBidDetails['Job']['user_id'])));
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
								'Notification.to_id' => $findJobBidDetails['Job']['user_id'],
								'Notification.read_status'=>0
								)
							));                                   
							$notificationSend->send_notification($tokenSend1, $badge);

						}

					$payArray['PaymentHistory']['id']=$payment_id;
					$payArray['PaymentHistory']['payment_flag']=2;
					//Save payment Array 
					$this->save($payArray);
           			$this->clear();		
				}
				$message = 'Payemnt Declined';
				return true;
				//echo "<pre>";print_r($paymentDetails);die;
				//$message = 'ok';
				//return $paymentDetails['PaymentHistory'];

			}else{

				$message = 'Oops! Some error occurred, please try again';	           
	            return false;
			}
		}
	}
	

	/**
	* @access public
	* @Method appGetEmployerTransactionHistory.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : 
	* @return    : 
	*/
	
	public function appGetEmployerTransactionHistory($myArrayData=null, &$message='')
	{   	
		$Job = new Job();
		extract($myArrayData); 
		$employer_Id  = isset($employer_Id) ? $employer_Id : '';
		if(!empty($employer_Id))
		{
			$findDetails=$this->find('all',array(
				'conditions'=>array(
					'PaymentHistory.employer_id'=>$employer_Id,
					'PaymentHistory.payment_flag'=>1)));
			if(!empty($findDetails))
			{
				foreach($findDetails as $paymentValue)
				{
					$payHistoryArray['payment_id']=$paymentValue['PaymentHistory']['id'];
					$payHistoryArray['job_title']=$paymentValue['Job']['title'];
					
					if($paymentValue['Job']['company_id'] !='0'){
						$companyDetails=$Job->findById($paymentValue['Job']['id']);
						$payHistoryArray['company_name']=$companyDetails['Company']['title'];						
					}else{
						$payHistoryArray['company_name']='Personal';
					}
									
					$payHistoryArray['payment_mode']=$paymentValue['PaymentHistory']['payment_mode'];
					$payHistoryArray['payment_amount']=$paymentValue['PaymentHistory']['amount'];
					$payHistoryArray['payment_date']=date('M,j Y',strtotime($paymentValue['PaymentHistory']['payment_date']));
					$returnData[] = $payHistoryArray;
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
	* @Method appGetEmployeeTransactionHistory.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param     : 
	* @return    : 
	*/
	
	public function appGetEmployeeTransactionHistory($myArrayData=null, &$message='')
	{   	
		$Job = new Job();
		extract($myArrayData); 
		$employee_Id  = isset($employee_Id) ? $employee_Id : '';
		if(!empty($employee_Id))
		{
			$findDetails=$this->find('all',array(
				'conditions'=>array(
					'PaymentHistory.user_id'=>$employee_Id,
					'PaymentHistory.payment_flag'=>1)));
			if(!empty($findDetails))
			{
				foreach($findDetails as $paymentValue)
				{
					$payHistoryArray['payment_id']=$paymentValue['PaymentHistory']['id'];
					$payHistoryArray['job_title']=$paymentValue['Job']['title'];
					
					if($paymentValue['Job']['company_id'] !='0'){
						$companyDetails=$Job->findById($paymentValue['Job']['id']);
						$payHistoryArray['company_name']=$companyDetails['Company']['title'];						
					}else{
						$payHistoryArray['company_name']='Personal';
					}
									
					$payHistoryArray['payment_mode']=$paymentValue['PaymentHistory']['payment_mode'];
					$payHistoryArray['payment_amount']=$paymentValue['PaymentHistory']['amount'];
					$payHistoryArray['payment_date']=date('M,j Y',strtotime($paymentValue['PaymentHistory']['payment_date']));
					$returnData[] = $payHistoryArray;
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
    * @Method appSearchEmployerTransactionHistory.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $myArrayData    
    * @return Employer Transaction History details by company,date
    */
    public function appSearchEmployerTransactionHistory($myArrayData=null, &$message='')
    {   
    	$User = new User();
    	$Job = new Job();
        //Extract Comming Data
        extract($myArrayData); 
        $startdate  = isset($startdate) ? $startdate : ''; 
        $enddate  = isset($enddate) ? $enddate : ''; 
        $state_id  = isset($state_id) ? $state_id : ''; 
        $company_id  = isset($company_id) ? $company_id : '';
        $user_id  = isset($user_id) ? $user_id : '';

		if(!empty($user_id))
		{
			$userDetails=$User->findById($user_id);
			if($company_id =='' &&  empty($startdate) && empty($enddate))
            {    

            	$conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.employer_id'=>$user_id,
                        ), 
                    'order'=>array('PaymentHistory.id DESC')
                    );
            	

            }else if($company_id !='' &&  !empty($startdate) && !empty($enddate)){

            	 $conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.employer_id'=>$user_id, 
                        'AND'=>array( 
                        	'PaymentHistory.company_id'=>$company_id,                                                      
                            'OR'=>array(
                                'PaymentHistory.payment_date BETWEEN ? and ?' => array($startdate, $enddate),                                 
                                )
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );
            	
            }else if($company_id !='' &&  empty($startdate) && empty($enddate)){            	 	
            	 $conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.employer_id'=>$user_id,                        
                        'AND'=>array( 
                            'PaymentHistory.company_id'=>$company_id
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );   
                         	
            }else if($company_id =='' &&  !empty($startdate) && empty($enddate)){

            	$conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.employer_id'=>$user_id, 
                        'AND'=>array( 
                        	'PaymentHistory.payment_date'=>$startdate,                           
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );            	

            }else if($company_id =='' &&  empty($startdate) && !empty($enddate)){
            	
            	$conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.employer_id'=>$user_id, 
                        'AND'=>array( 
                        	'PaymentHistory.payment_date'=>$enddate,                           
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );

            }else if($company_id !='' &&  !empty($startdate) && empty($enddate)){

            	$conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.employer_id'=>$user_id, 
                        'AND'=>array( 
                        	'PaymentHistory.company_id'=>$company_id,
                        	'PaymentHistory.payment_date'=>$startdate,                           
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );
            }else if($company_id !='' &&  empty($startdate) && !empty($enddate)){
            		
            		$conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.employer_id'=>$user_id, 
                        'AND'=>array( 
                        	'PaymentHistory.company_id'=>$company_id,
                        	'PaymentHistory.payment_date'=>$enddate,                           
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );

            }else if($company_id =='' &&  !empty($startdate) && !empty($enddate)){
            		
            		$conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.employer_id'=>$user_id, 
                        'AND'=>array( 
                            'OR'=>array(
                                'PaymentHistory.payment_date BETWEEN ? and ?' => array($startdate, $enddate),                                 
                                )
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );

            }
                     
            $findDetails=$this->find('all',$conditions);
           // echo "<pre>";print_r($findDetails);die;   
            if(!empty($findDetails))
			{
				foreach($findDetails as $paymentValue)
				{
					//echo "<pre>";print_r($paymentValue);die;   
					$payHistoryArray['payment_id']=$paymentValue['PaymentHistory']['id'];
					$payHistoryArray['job_title']=$paymentValue['Job']['title'];
					
					if($paymentValue['Job']['company_id'] !='0'){
						$companyDetails=$Job->findById($paymentValue['Job']['id']);
						$payHistoryArray['company_name']=$companyDetails['Company']['title'];						
					}else{
						$payHistoryArray['company_name']='Personal';
					}
									
					$payHistoryArray['payment_mode']=$paymentValue['PaymentHistory']['payment_mode'];
					$payHistoryArray['payment_amount']=$paymentValue['PaymentHistory']['amount'];
					$payHistoryArray['payment_date']=date('M,j Y',strtotime($paymentValue['PaymentHistory']['payment_date']));
					$returnData[] = $payHistoryArray;
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
    * @Method appSearchEmployeeTransactionHistory.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $myArrayData    
    * @return Employee Transaction History details by date search
    */
    public function appSearchEmployeeTransactionHistory($myArrayData=null, &$message='')
    {   
    	$User = new User();
    	$Job = new Job();
        //Extract Comming Data
        extract($myArrayData); 
        $startdate  = isset($startdate) ? $startdate : ''; 
        $enddate  = isset($enddate) ? $enddate : '';        
        $user_id  = isset($user_id) ? $user_id : '';
        if(!empty($user_id))
		{
			$userDetails=$User->findById($user_id);
			if(empty($startdate) && empty($enddate))
            {
            	$conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.user_id'=>$user_id,
                        ), 
                    'order'=>array('PaymentHistory.id DESC')
                    );

            }else if(!empty($startdate) && !empty($enddate)){

            	 $conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.user_id'=>$user_id, 
                        'AND'=>array( 
                            'OR'=>array(
                                'PaymentHistory.payment_date BETWEEN ? and ?' => array($startdate, $enddate),                                 
                                )
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );

            }else if(!empty($startdate) && empty($enddate)){
            	 
            	 $conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.user_id'=>$user_id, 
                        'AND'=>array( 
                            'OR'=>array(
                                'PaymentHistory.payment_date' => $startdate
                                )
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );

            }else if(empty($startdate) && !empty($enddate)){

            	$conditions = array(
                    'conditions'=>array(
                        'PaymentHistory.payment_flag'=>1,
                        'PaymentHistory.user_id'=>$user_id, 
                        'AND'=>array( 
                            'OR'=>array(
                                'PaymentHistory.payment_date' => $enddate
                                )
                        )), 
                    'order'=>array('PaymentHistory.id DESC')
                    );
            }

            $findEmployeeDetails=$this->find('all',$conditions);
            if(!empty($findEmployeeDetails))
			{
				foreach($findEmployeeDetails as $paymentValue)
				{
					$payHistoryArray['payment_id']=$paymentValue['PaymentHistory']['id'];
					$payHistoryArray['job_title']=$paymentValue['Job']['title'];
					
					if($paymentValue['Job']['company_id'] !='0'){
						$companyDetails=$Job->findById($paymentValue['Job']['id']);
						$payHistoryArray['company_name']=$companyDetails['Company']['title'];						
					}else{
						$payHistoryArray['company_name']='Personal';
					}
									
					$payHistoryArray['payment_mode']=$paymentValue['PaymentHistory']['payment_mode'];
					$payHistoryArray['payment_amount']=$paymentValue['PaymentHistory']['amount'];
					$payHistoryArray['payment_date']=date('M,j Y',strtotime($paymentValue['PaymentHistory']['payment_date']));
					$returnData[] = $payHistoryArray;
				}
				
				$message = 'Successfully';
				return $returnData;

			}else{

				$message = 'No record found';	           
	            return false;

			}



        }
    
    }

}