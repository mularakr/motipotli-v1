<?php
App::uses('AppModel', 'Model');
App::import('Model', 'Bid');
App::import('Model', 'Jobimage');
App::import('Model', 'User');
App::import('Model', 'Company');
App::import('Model', 'Notification');
App::import('Model', 'State');
App::import('Model', 'City');
App::import('Model', 'UserToken');
App::import('Component','SendNotification');
/**
 * Job Model
 *
 * @property Category $Category
 * @property User $User
 * @property Bid $Bid
 * @property Jobimage $Jobimage
 */
class Job extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
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
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Bid' => array(
			'className' => 'Bid',
			'foreignKey' => 'job_id',
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
		'Jobimage' => array(
			'className' => 'Jobimage',
			'foreignKey' => 'job_id',
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
		'Notification' => array(
            'className' => 'Notification',
            'foreignKey' => 'job_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'job_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
	);

	/******************************************************************************* 
	 * 
	 * 						Model API Start Here
	 * 	
	*********************************************************************************/

	public function appJobPost($myArrayData=null, &$message=''){

        extract($myArrayData);
		
        $User = new User();
        $Company = new Company();
        $Notification = new Notification();
		$UserToken = new UserToken();
        $notificationSend = new SendNotificationComponent(new ComponentCollection);
        $jobDataArray = array();
        $nameArray = array();
			
        if(isset($myArrayData['user_id']))
        {
            $jobDataArray['Job']['user_id'] = isset($myArrayData['user_id']) ? $myArrayData['user_id'] : '';
            $jobDataArray['Job']['title'] = isset($myArrayData['title']) ? $myArrayData['title'] : '';
            $jobDataArray['Job']['category_id'] = isset($myArrayData['category_id']) ? $myArrayData['category_id'] : '';
            $jobDataArray['Job']['company_id'] = isset($myArrayData['company_id']) ? $myArrayData['company_id'] : '';
            $jobDataArray['Job']['positions']=isset($myArrayData['positions']) ? $myArrayData['positions'] : '';
            $jobDataArray['Job']['address1']=isset($myArrayData['address1']) ? $myArrayData['address1'] : '';
            $jobDataArray['Job']['address2']=isset($myArrayData['address2']) ? $myArrayData['address2'] : '';
            $jobDataArray['Job']['pincode']=isset($myArrayData['pincode']) ? $myArrayData['pincode'] : '';
            $jobDataArray['Job']['description']=isset($myArrayData['description']) ? $myArrayData['description'] : '';
            $jobDataArray['Job']['state_id']=isset($myArrayData['state_id']) ? $myArrayData['state_id'] : '';
            $jobDataArray['Job']['city_id']=isset($myArrayData['city_id']) ? $myArrayData['city_id'] : '';
            $jobDataArray['Job']['startdate']=isset($myArrayData['startdate']) ? $myArrayData['startdate'] : '';
            $jobDataArray['Job']['enddate']=isset($myArrayData['enddate']) ? $myArrayData['enddate'] : '';
            $jobDataArray['Job']['starttime']=isset($myArrayData['starttime']) ? $myArrayData['starttime'] : '';
            $jobDataArray['Job']['endtime']=isset($myArrayData['endtime']) ? $myArrayData['endtime'] : '';
            $jobDataArray['Job']['allowbids']=isset($myArrayData['allowbids']) ? $myArrayData['allowbids'] : '';
            $jobDataArray['Job']['allowbid_cost']=isset($myArrayData['allowbid_cost']) ? $myArrayData['allowbid_cost'] : '';
            //$jobDataArray['Job']['idproof']=isset($myArrayData['idproof']) ? $myArrayData['idproof'] : '';      
            $jobDataArray['Job']['jobcost']=isset($myArrayData['jobcost']) ? $myArrayData['jobcost'] : '';
            $jobDataArray['Job']['pincode']=isset($myArrayData['pincode']) ? $myArrayData['pincode'] : '';
            $jobDataArray['Job']['buyer_cost']=isset($myArrayData['buyer_cost']) ? $myArrayData['buyer_cost'] : '';
            $jobDataArray['Job']['wage_type']=isset($myArrayData['wage_type']) ? $myArrayData['wage_type'] : '';
            $jobDataArray['Job']['total_wage']=isset($myArrayData['total_wage']) ? $myArrayData['total_wage'] : '';
            $jobDataArray['Job']['include_value']=isset($myArrayData['include_value']) ? $myArrayData['include_value'] : '';

            $idproof=isset($myArrayData['idproof']) ? $myArrayData['idproof'] : '';      
            if($idproof=='false')
            {
                $jobDataArray['Job']['idproof']=0;
            }else{
                 $jobDataArray['Job']['idproof']=1;
            }

            $addressCheck=isset($myArrayData['addressCheck']) ? $myArrayData['addressCheck'] : '';      
            if($addressCheck =='false')
            {
                $jobDataArray['Job']['iscompany_address']=0;

            }else{

                 $jobDataArray['Job']['iscompany_address']=1;
            }

            //get the Job userId
            $userId = $jobDataArray['Job']['user_id'];

            if ($this->Save($jobDataArray)) 
            {
                //get last insertId
                $data['id'] = $this->getLastInsertID();             
                
                //get Job details
                $jobInfo = $this->find('first',array(
                    'recursive'=>-2,
                    'conditions'=>array(
                        'Job.id'=>$data['id'])
                    ));
                    
                    //Posted Job date & time
                $postJobStartTime=strtotime($jobInfo['Job']['startdate'].' '.$jobInfo['Job']['starttime']);
                $postJobEndtime=strtotime($jobInfo['Job']['enddate'].' '.$jobInfo['Job']['endtime']);

                //set Category Id              
                $categoryId = $jobInfo['Job']['category_id'];         
                
                //get the category name
                $categoryName = $jobInfo['Category']['name'];
                
                //set company name or user name
                if($jobInfo['Job']['company_id'] == '0')
                {
                    $userName = ucwords($jobInfo['User']['name']);

                }else{

                    $userName = $jobInfo['Company']['title'];
                }
				
				 //get user details by category id and city id for job notification
				 $categoryUser=$User->find('all', array(              
                    'conditions'=>array(                          
                            'FIND_IN_SET(\''. $categoryId .'\',User.category_id)',
                            'FIND_IN_SET(\''. $jobInfo['Job']['city_id'].'\',User.city_id)',
                            ), 
                            'order' => array('User.id DESC'),                                           
                    'contain' => array(
                        'Bid' => array(
                            'conditions' => array(
                                'Bid.status' => 1  // <-- Notice this addition
                            ),
                            'Job' => array(                          
                            )                                                
                        )
                    ),              
                ));
								
            if(!empty($categoryUser))
            {   
                //post job time             

                foreach($categoryUser as $value)
                {               
                    if(!empty($value['Bid']))
                    {
                        $count = count($value['Bid']);
                        $countbid = $count -1;
                        $bidstatus = $value['Bid'][$countbid]['status'];
                        if($bidstatus == 1)
                        {
                           // echo "<pre>";print_r($value['Bid'][$countbid]);                        

                            $jobBidStartDateTime =strtotime($value['Bid'][$countbid]['Job']['startdate'].' '.$value['Bid'][$countbid]['Job']['starttime']);
                            $jobBidEndDateTime=strtotime($value['Bid'][$countbid]['Job']['enddate'].' '.$value['Bid'][$countbid]['Job']['endtime']);

                         
                                if(($jobBidStartDateTime > $postJobEndtime ||  $jobBidEndDateTime < $postJobStartTime))
                                {
                                    //send notification 
                                    
											                                  
										$to_id = $value['User']['id'] ;
										$messageDate = date('Y-m-d H:i:s');

										$notificationMessage = 'A new job <b>'.' '.$myArrayData['title'].'</b> '.'from <b>'.' '.$userName.' </b> '.'under <b>'.' '.$categoryName.' '.'</b> Category is being posted . Please click to browse the job details.' ; 

                                        $notifiMsg = 'A new job '.' '.$myArrayData['title'].' '.'from '.' '.$userName.' '.'under '.' '.$categoryName.' '.' Category is being posted . Please click to browse the job details.'; 

										//echo $notificationMessge; die;
										$notificationArray['Notification']['from_id'] = $userId;
										$notificationArray['Notification']['to_id']=$to_id;
										$notificationArray['Notification']['job_id']= $data['id'];
										$notificationArray['Notification']['message'] = $notificationMessage;
										$notificationArray['Notification']['type']='postjob';
										$notificationArray['Notification']['login_type']='employee';
										$notificationArray['Notification']['message_date']= $messageDate;
										$Notification->save($notificationArray);
										$Notification->clear();
										
										$tokenDetails=$UserToken->find('all',array(
                                        'recursive'=>-1,
                                        'conditions'=>array(
                                            'UserToken.user_id'=>$value['User']['id'])));
                                         if(!empty($tokenDetails))
                                        {
    										$i=0;
                                            foreach($tokenDetails as $tokenValue)
                                            {
                                                $tokenSend[$i]['device_token']=$tokenValue['UserToken']['device_token'];
                                                $tokenSend[$i]['device_type']=$tokenValue['UserToken']['device_type'];
                                                $tokenSend[$i]['message']= $notifiMsg;
                                                $i++;
                                            }
                                            $badge = $Notification->find('count', array(
                                                    'conditions' => array(
                                                        'Notification.to_id' => $to_id,
                                                        'Notification.read_status'=>0)
                                                ));

                                            $notificationSend->send_notification($tokenSend, $badge);
									}
                                }
                           //die;
                        }else{
							
									$to_id = $value['User']['id'] ;
									$messageDate = date('Y-m-d H:i:s');

									$notificationMessage = 'A new job <b>'.' '.$myArrayData['title'].'</b> '.'from <b>'.' '.$userName.' </b> '.'under <b>'.' '.$categoryName.' '.'</b> Category is being posted . Please click to browse the job details.' ;

                                    $notifiMsg = 'A new job '.' '.$myArrayData['title'].' '.'from '.' '.$userName.' '.'under '.' '.$categoryName.' '.' Category is being posted . Please click to browse the job details.';
									//echo $notificationMessge; die;
									$notificationArray['Notification']['from_id'] = $userId;
									$notificationArray['Notification']['to_id']=$to_id;
									$notificationArray['Notification']['job_id']= $data['id'];
									$notificationArray['Notification']['message'] = $notificationMessage;
									$notificationArray['Notification']['type']='postjob';
									$notificationArray['Notification']['login_type']='employee';
									$notificationArray['Notification']['message_date']= $messageDate;
									$Notification->save($notificationArray);
									$Notification->clear();
									$tokenDetails=$UserToken->find('all',array(
								'recursive'=>-1,
								'conditions'=>array(
									'UserToken.user_id'=>$value['User']['id'])));

									if(!empty($tokenDetails))
								{
									$i=0;
                                    foreach($tokenDetails as $tokenValue)
                                    {
                                        $tokenSend[$i]['device_token']=$tokenValue['UserToken']['device_token'];
                                        $tokenSend[$i]['device_type']=$tokenValue['UserToken']['device_type'];
                                        $tokenSend[$i]['message']= $notifiMsg;
                                        $i++;
                                    }
									$badge = $Notification->find('count', array(
											'conditions' => array(
												'Notification.to_id' => $to_id,
												'Notification.read_status'=>0)
									));

                                    $notificationSend->send_notification($tokenSend, $badge);
								}

                            //echo "Mai notification send karuga"; 
                        }


                    }else{
                        //if no bid for user send notification
                        
                            $to_id = $value['User']['id'] ;
                            $messageDate = date('Y-m-d H:i:s');

                            $notificationMessage = 'A new job <b>'.' '.$myArrayData['title'].'</b> '.'from <b>'.' '.$userName.' </b> '.'under <b>'.' '.$categoryName.' '.'</b> Category is being posted . Please click to browse the job details.' ;

                            $notifiMsg ='A new job '.' '.$myArrayData['title'].' '.'from '.' '.$userName.' '.'under '.' '.$categoryName.' '.' Category is being posted . Please click to browse the job details.' ;

                            //echo $notificationMessge; die;
                            $notificationArray['Notification']['from_id'] = $userId;
                            $notificationArray['Notification']['to_id']=$to_id;
                            $notificationArray['Notification']['job_id']= $data['id'];
                            $notificationArray['Notification']['message'] = $notificationMessage;
                            $notificationArray['Notification']['type']='postjob';
                            $notificationArray['Notification']['login_type']='employee';
                            $notificationArray['Notification']['message_date']= $messageDate;
                            $Notification->save($notificationArray);
                            $Notification->clear();
						
						$tokenDetails=$UserToken->find('all',array(
						'recursive'=>-1,
						'conditions'=>array(
							'UserToken.user_id'=>$value['User']['id'])));

						if(!empty($tokenDetails))
						{
                            $i=0;
                            foreach($tokenDetails as $tokenValue)
                            {
                                $tokenSend[$i]['device_token']=$tokenValue['UserToken']['device_token'];
                                $tokenSend[$i]['device_type']=$tokenValue['UserToken']['device_type'];
                                $tokenSend[$i]['message']= $notifiMsg;
                                $i++;
                            }
                                $badge = $Notification->find('count', array(
                                        'conditions' => array(
                                            'Notification.to_id' => $to_id,
                                            'Notification.read_status'=>0)
                                    ));
                                $notificationSend->send_notification($tokenSend, $badge);
						}
                            //echo "Mai notification send karuga"; 
                    }           
                 }//foREACH END            
                }//main if end
                $message = 'Job Details Save Successfully';
                return $data;                
            } else {
                $message = 'Oops! Some error occurred, please try again';
                return false;
            }
        }		
   }  
	/**
	* @access public
	* @Method appGetOpenJobs.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :15_Nov_2017
	* @param string $Data    
	* @return User Details in Json Format
	*/
	
	public function appGetOpenJobs($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$user_id  = isset($id) ? $id : '';
		if(!empty($user_id)){

           $getOpenBookDetails=$this->find('all',array(
             //'recursive'=>-3,
            	'conditions'=>array(
            		'Job.user_id'=>$user_id,              		
            		'Job.job_status'=>0,          		
            		),
            		'order'=>array('Job.id DESC')
            	));
            //echo "<pre>";print_r($getOpenBookDetails);die;
            if(!empty($getOpenBookDetails))
            {
            	foreach($getOpenBookDetails as $value)
            	{
					$arrayData['user_id'] = $value['Job']['user_id'];
					$arrayData['job_id'] = $value['Job']['id'];
					$arrayData['title'] = $value['Job']['title'];
            		$arrayData['category_id'] = $value['Job']['category_id'];
            		$arrayData['company_id'] = $value['Job']['company_id'];
            		$arrayData['positions'] = $value['Job']['positions'];
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
            		$arrayData['total_bid']=count($value['Bid']);            		
                    $arrayData['total_notification']=count($value['Notification']); 

            		$timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
            		$hours = intval($timeDiff / 3600); 
            		$seconds_remain = ($timeDiff - ($hours * 3600)); 
					$minutes = intval($seconds_remain / 60);  					
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;
                    
                    /*
                     * 15Mar
                     * */
                     //Set Job positions
                    $bookedJob=$this->Bid->find('count',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.status'=>1),
                        'order'=>array('Bid.id DESC')
                        )
                    );                
                    if(!empty($bookedJob))
                    {
                        if($bookedJob <= $value['Job']['positions'])
                        {
                            $arrayData['positions'] = $value['Job']['positions'] - $bookedJob;
                        }
                        
                    }else{

                        $arrayData['positions'] = $value['Job']['positions'];
                    }
                       		
            		//Category array            	
            		$arrayData['category_name'] = $value['Category']['name'];
            		$arrayData['company_name'] = $value['Company']['title'];   
            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];         		
            		//User array            		
            		$arrayData['name'] = $value['User']['name'];
                    if(!empty($value['Bid'])){                    
                        foreach($value['Bid'] as $bidValueStatus){
                            if($bidValueStatus['status']=='1'){
                                $arrayData['acceptBidStatus'] = '1';
                                break;
                            }else{
                                $arrayData['acceptBidStatus'] = '0';
                             }
                        }
                    } else{

                         $arrayData['acceptBidStatus'] = '0';
                    } 
					$returnData[] = $arrayData;					
            	}
            	
            	$message = 'Successfully';
				return $returnData;            	          
			} else{
            	$message = 'No open jobs found';
            	return false;
            }
        }
    }

    /**
	* @access public
	* @Method appGetBookedJobs.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :30_Nov_2017
	* @param string $Data    
	* @return Jobs Details in Json Format
	*/
	
	public function appGetBookedJobs($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$user_id  = isset($id) ? $id : '';

		if(!empty($user_id)){

           $getOpenBookDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Job.user_id'=>$user_id,  
            		'Job.status'=>0,
            		'Job.job_status'=>1,       		
            		),
            		'order'=>array('Job.id DESC')
            	));
           //echo "<pre>";print_r($getOpenBookDetails);die;
            if(!empty($getOpenBookDetails))
            {
            	foreach($getOpenBookDetails as $value)
            	{
					$arrayData['user_id'] = $value['Job']['user_id'];
					$arrayData['job_id'] = $value['Job']['id'];
					$arrayData['title'] = $value['Job']['title'];
            		$arrayData['category_id'] = $value['Job']['category_id'];
            		$arrayData['company_id'] = $value['Job']['company_id'];
            		$arrayData['positions'] = $value['Job']['positions'];
            		$arrayData['address1'] = $value['Job']['address1'];
            		$arrayData['address2'] = $value['Job']['address2'];
            		$arrayData['pincode'] = $value['Job']['pincode'];
            		$arrayData['description'] = $value['Job']['description'];
            		$arrayData['state_id'] = $value['Job']['state_id'];
            		$arrayData['city_id'] = $value['Job']['city_id'];
            		
            		$arrayData['startdate'] =date('j,M',strtotime($value['Job']['startdate']));
            		$arrayData['enddate'] = date('j,M',strtotime($value['Job']['enddate']));
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
            		//Not show total time at booked jobs 
                    /*$timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);                    
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;*/
            		//Category array            	
            		$arrayData['category_name'] = $value['Category']['name'];
            		$arrayData['company_name'] = $value['Company']['title'];
            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];

            		//User array            		
            		$arrayData['name'] = $value['User']['name'];
					$returnData[] = $arrayData;			
            	}
            	
            	$message = 'Successfully';
				return $returnData;            
			} else{
            	$message = 'no booked job found';
            	return false;
            }
        }
    }
    
    /**
	* @access public
	* @Method appGetJobDetails.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :01_Dec_2017
	* @param string $myArrayData    
	* @return job details in Json Format
	*/
	public function appGetJobDetails($myArrayData=null, &$message='')
	{   

        $State = new State();
        $City = new City();

		//Extract Comming Data
		extract($myArrayData); 
		$jobId  = isset($jobId) ? $jobId : '';

		if(!empty($jobId)){

           $getJobDetails=$this->find('first',array(
            	'conditions'=>array(
            		'Job.id'=>$jobId,              	
            		'NOT' => array('Job.job_status' =>2)
            		),
            	
            	));
         //  echo "<pre>";print_r($getJobDetails);die;
           if(!empty($getJobDetails))
           {  
           			$value=$getJobDetails;                                        
           			$arrayData['user_id'] = $value['Job']['user_id'];
					$arrayData['job_id'] = $value['Job']['id'];
					$arrayData['title'] = $value['Job']['title'];
            		$arrayData['category_id'] = $value['Job']['category_id'];
            		$arrayData['company_id'] = $value['Job']['company_id'];
            		$arrayData['positions'] = $value['Job']['positions'];
            		$arrayData['address1'] = $value['Job']['address1'];
            		$arrayData['address2'] = $value['Job']['address2'];
            		$arrayData['pincode'] = $value['Job']['pincode'];
            		$arrayData['description'] = $value['Job']['description'];
            		$arrayData['state_id'] = $value['Job']['state_id'];
            		$arrayData['city_id'] = $value['Job']['city_id'];
            		$arrayData['startdate'] =date('j,M',strtotime($value['Job']['startdate']));
            		$arrayData['enddate'] = date('j, M',strtotime($value['Job']['enddate']));
            		//$arrayData['starttime'] = date('h:i A',strtotime($value['Job']['starttime']));
            	    //$arrayData['endtime'] = date('h:i A',strtotime($value['Job']['endtime']));    
                
                    $arrayData['starttime'] = $value['Job']['starttime'];
                    $arrayData['endtime'] = $value['Job']['endtime'];  


                    $arrayData['stime'] = date('h:i A',strtotime($value['Job']['starttime']));
                    $arrayData['etime'] = date('h:i A',strtotime($value['Job']['endtime'])); 
                            
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
                     //Get City
                    $getCity=$City->find('first',array(
                        'conditions'=>array(
                            'City.id'=>$value['Job']['city_id'])
                        ));

                    $arrayData['state'] = $getCity['State']['name'];
                    $arrayData['city'] = $getCity['City']['city'];
				    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
            		$hours = intval($timeDiff / 3600); 
            		$seconds_remain = ($timeDiff - ($hours * 3600)); 
					$minutes = intval($seconds_remain / 60);  					
            		$arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
            		$arrayData['total_time']=$time;

                    if(!empty($value['Bid'])){

                        foreach($value['Bid'] as $bidValueStatus){
                            if($bidValueStatus['status']=='1'){
                                $arrayData['acceptBidStatus'] = '1';
                                break;
                            }else{
                                $arrayData['acceptBidStatus'] = '0';
                             }
                        }
                    }else{

                         $arrayData['acceptBidStatus'] = '0';
                    } 
            		
            		//Category array            	
            		$arrayData['category_name'] = $value['Category']['name'];
            		$arrayData['company_name'] = $value['Company']['title'];
            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo']; 
            		$arrayData['sdate'] =date('Y-m-d',strtotime($value['Job']['startdate']));
            		$arrayData['edate'] = date('Y-m-d',strtotime($value['Job']['enddate']));

            		//User array            		
            		$arrayData['name'] = $value['User']['name'];
            		$arrayData['imageArray']=$value['Jobimage'];
					$returnData = $arrayData;
					//echo "<pre>";print_r($returnData);die;

           			$message = 'Successfully';
					return $returnData;      

           }else{

           		$message = 'no record found';
            	return false;
           }
        }

    }//end
	

	/** [appEditPost description] */
	public function appEditPost($myArrayData=null, &$message=''){

		if(isset($myArrayData['job_id']))
		{
			$jobDataArray['Job']['id']=isset($myArrayData['job_id']) ? $myArrayData['job_id'] : '';
			$jobDataArray['Job']['user_id']=isset($myArrayData['user_id']) ? $myArrayData['user_id'] : '';
			$jobDataArray['Job']['title']=isset($myArrayData['title']) ? $myArrayData['title'] : '';
			$jobDataArray['Job']['category_id']=isset($myArrayData['category_id']) ? $myArrayData['category_id'] : '';
			$jobDataArray['Job']['company_id']=isset($myArrayData['company_id']) ? $myArrayData['company_id'] : '';
			$jobDataArray['Job']['positions']=isset($myArrayData['positions']) ? $myArrayData['positions'] : '';
			$jobDataArray['Job']['address1']=isset($myArrayData['address1']) ? $myArrayData['address1'] : '';
			$jobDataArray['Job']['address2']=isset($myArrayData['address2']) ? $myArrayData['address2'] : '';
			$jobDataArray['Job']['pincode']=isset($myArrayData['pincode']) ? $myArrayData['pincode'] : '';
			$jobDataArray['Job']['description']=isset($myArrayData['description']) ? $myArrayData['description'] : '';
			$jobDataArray['Job']['state_id']=isset($myArrayData['state_id']) ? $myArrayData['state_id'] : '';
			$jobDataArray['Job']['city_id']=isset($myArrayData['city_id']) ? $myArrayData['city_id'] : '';
			$jobDataArray['Job']['startdate']=isset($myArrayData['startdate']) ? $myArrayData['startdate'] : '';
			$jobDataArray['Job']['enddate']=isset($myArrayData['enddate']) ? $myArrayData['enddate'] : '';
			$jobDataArray['Job']['starttime']=isset($myArrayData['starttime']) ? $myArrayData['starttime'] : '';
			$jobDataArray['Job']['endtime']=isset($myArrayData['endtime']) ? $myArrayData['endtime'] : '';
			$jobDataArray['Job']['allowbids']=isset($myArrayData['allowbids']) ? $myArrayData['allowbids'] : '';
			$jobDataArray['Job']['allowbid_cost']=isset($myArrayData['allowbid_cost']) ? $myArrayData['allowbid_cost'] : '';
			//$jobDataArray['Job']['idproof']=isset($myArrayData['idproof']) ? $myArrayData['idproof'] : '';		
			$jobDataArray['Job']['jobcost']=isset($myArrayData['jobcost']) ? $myArrayData['jobcost'] : '';
			$jobDataArray['Job']['pincode']=isset($myArrayData['pincode']) ? $myArrayData['pincode'] : '';
			$jobDataArray['Job']['buyer_cost']=isset($myArrayData['buyer_cost']) ? $myArrayData['buyer_cost'] : '';
            $jobDataArray['Job']['wage_type']=isset($myArrayData['wage_type']) ? $myArrayData['wage_type'] : '';
            $jobDataArray['Job']['total_wage']=isset($myArrayData['total_wage']) ? $myArrayData['total_wage'] : '';
			$jobDataArray['Job']['include_value']=isset($myArrayData['include_value']) ? $myArrayData['include_value'] : '';
                  $idproof=isset($myArrayData['idproof']) ? $myArrayData['idproof'] : '';      
                 
                  if($idproof=='false')
                  {
                      $jobDataArray['Job']['idproof']=0;
                  }else{
                       $jobDataArray['Job']['idproof']=1;
                  }

                  $addressCheck=isset($myArrayData['addressCheck']) ? $myArrayData['addressCheck'] : '';      
                  if($addressCheck =='false')
                  {
                      $jobDataArray['Job']['iscompany_address']=0;

                  }else{

                       $jobDataArray['Job']['iscompany_address']=1;
                  }			
			if ($this->Save($jobDataArray)) {
	            $message = 'Job Details Save Successfully';	          
	            return $jobDataArray;          
	        } else {
	            $message = 'Oops! Some error occurred, please try again';
	            return false;
	        }

		}			
   }   



	/** [appDeleteJobDetails description] */
	public function appDeleteJobDetails($myArrayData=null, &$message=''){
		//Extract Comming Data
		$Bid = new Bid();
		extract($myArrayData); 
		$jobId  = isset($id) ? $id : '';
		$file_url = Router::url('/', true).'uploads/job/big/';	
		if(!empty($jobId)){	

			$bidCount=$this->Bid->find('count',array(
					'conditions'=>array(
						   'Bid.job_id'=>$jobId,							 	
						  'Bid.status'=>1)));
				
			if($bidCount > 0)
			{
				$message = 'You can not delete this job ,Already job accepted';
	            return false;				
			}
			$jobCancelArray['Job']['id']=$jobId;
            $jobCancelArray['Job']['job_status']='2';             
            if($this->save($jobCancelArray))
            {
                 $message = 'Record deleted successfully';           
                 return true;  

            }else{

                $message = 'Oops! Some error occurred, please try again';
                return false;
            }    			
		}	
	}  


	/**
	* @access public
	* @Method appGetEmployeeJobsByCategoryId.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $myArrayData    
	* @return job details by catagory id in Json Format
	*/
	
	public function appGetEmployeeJobsByCategoryId($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$categoryId  = isset($category_id) ? $category_id : '';
        $city_id  = isset($city_id) ? $city_id : '';
        $state_id  = isset($state_id) ? $state_id : ''; 
		if(!empty($categoryId))
		{
			$jobDetails=$this->find('all',array(
				'conditions'=>array(
					'Job.category_id'=>$categoryId,
                    'Job.city_id'=>$city_id,
                    'Job.state_id'=>$state_id,
					'Job.job_status'=>0,
					),
				'order'=>array('Job.id DESC')
				)
			);
			if(!empty($jobDetails))
			{
				foreach($jobDetails as $value){$arrayData['user_id'] = $value['Job']['user_id'];
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
            		
                    $arrayData['total_bid']=count($value['Bid']);

                    //find left job count
                    $bookedJob=$this->Bid->find('count',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.status'=>1),
                        'order'=>array('Bid.id DESC')
                        )
                    );                
                    if(!empty($bookedJob))
                    {
                        if($bookedJob <= $value['Job']['positions'])
                        {
                            $arrayData['positions'] = $value['Job']['positions'] - $bookedJob;
                        }
                        
                    }else{

                        $arrayData['positions'] = $value['Job']['positions'];
                    }

                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);                    
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;

            		//Category array            	
            		$arrayData['category_name'] = $value['Category']['name'];
            		$arrayData['company_name'] = $value['Company']['title'];   
            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];         		
            		//User array            		
            		$arrayData['name'] = $value['User']['name'];
					$returnData[] = $arrayData;
                   // echo "<pre>";print_r( $jobLeft);
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
	* @Method appGetJobDetailsByCompanyId.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return app Get Job Details By CompanyId
	*/
	
	public function appGetJobDetailsByCompanyId($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$companyid  = isset($companyid) ? $companyid : '';
		$user_id  = isset($uId) ? $uId : '';

		if(!empty($user_id)){

           $getFilterDataDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Job.user_id'=>$user_id,  
            		'Job.company_id'=>$companyid,            		
            		'Job.job_status'=>0, 
            		'Job.status'=>0,         		
            		),
            	'order'=>array('Job.id DESC')
            	));
           	//echo "<pre>";print_r($getOpenBookDetails);die;
            if(!empty($getFilterDataDetails))
            {	
            	foreach($getFilterDataDetails as $value)
            	{


					$arrayData['user_id'] = $value['Job']['user_id'];
					$arrayData['job_id'] = $value['Job']['id'];
					$arrayData['title'] = $value['Job']['title'];
            		$arrayData['category_id'] = $value['Job']['category_id'];
            		$arrayData['company_id'] = $value['Job']['company_id'];
            		$arrayData['positions'] = $value['Job']['positions'];
            		$arrayData['address1'] = $value['Job']['address1'];
            		$arrayData['address2'] = $value['Job']['address2'];
            		$arrayData['pincode'] = $value['Job']['pincode'];
            		$arrayData['description'] = $value['Job']['description'];
            		$arrayData['state_id'] = $value['Job']['state_id'];
            		$arrayData['city_id'] = $value['Job']['city_id'];
            		
            		$arrayData['startdate'] =date('j,M',strtotime($value['Job']['startdate']));
            		$arrayData['enddate'] = date('j,M',strtotime($value['Job']['enddate']));
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
            		$arrayData['total_bid']=count($value['Bid']);            		
                    
                    $arrayData['total_notification']=count($value['Notification']); 
                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                            $minutes = intval($seconds_remain / 60);                    
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;
                               		
            		//Category array            	
            		$arrayData['category_name'] = $value['Category']['name'];
            		$arrayData['company_name'] = $value['Company']['title'];   
            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];         		
            		//User array            		
            		$arrayData['name'] = $value['User']['name'];
            		if(!empty($value['Bid'])){                    
                        foreach($value['Bid'] as $bidValueStatus){
                            if($bidValueStatus['status']=='1'){
                                $arrayData['acceptBidStatus'] = '1';
                                break;
                            }else{
                                $arrayData['acceptBidStatus'] = '0';
                             }
                        }
                    }else{

                         $arrayData['acceptBidStatus'] = '0';
                    }
					$returnData[] = $arrayData;				
            	}
            	
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
	* @Method appGetBookedJobs.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :30_Nov_2017
	* @param string $Data    
	* @return Jobs Details in Json Format
	*/
	
	public function appGetBookedJobDetailsByCompanyId($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$companyid  = isset($companyid) ? $companyid : '';
		$user_id  = isset($uId) ? $uId : '';

		if(!empty($user_id)){

           $getOpenBookDetails=$this->find('all',array(
            	'conditions'=>array(
            		'Job.user_id'=>$user_id,  
            		'Job.company_id'=>$companyid,
            		'Job.status'=>0,
            		'Job.job_status'=>1,          		
            		),
            	'order'=>array('Job.id DESC')
            	));
           //echo "<pre>";print_r($getOpenBookDetails);die;
            if(!empty($getOpenBookDetails))
            {
            	foreach($getOpenBookDetails as $value)
            	{
					$arrayData['user_id'] = $value['Job']['user_id'];
					$arrayData['job_id'] = $value['Job']['id'];
					$arrayData['title'] = $value['Job']['title'];
            		$arrayData['category_id'] = $value['Job']['category_id'];
            		$arrayData['company_id'] = $value['Job']['company_id'];
            		$arrayData['positions'] = $value['Job']['positions'];
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
            		 //Not using total time in booked Job
                    /*$timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;*/
            		//Category array            	
            		$arrayData['category_name'] = $value['Category']['name'];
            		$arrayData['company_name'] = $value['Company']['title'];
            		$arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];

            		//User array            		
            		$arrayData['name'] = $value['User']['name'];
					$returnData[] = $arrayData;				
            	}
            	
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
    * @Method appGetJobsByCategoryId.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $myArrayData    
    * @return job details by catagory id in Json Format
    */
    
    public function appGetJobsByCategoryId($myArrayData=null, &$message='')
    {   
        //Extract Comming Data
        extract($myArrayData); 
        $categoryId  = isset($catId) ? $catId : ''; 
        $userId  = isset($userId) ? $userId : ''; 	
        if(!empty($categoryId))
        {
           if(!empty($userId))
            {
                $conditions = array(
                    'conditions'=>array(
                        //'NOT'=>array('Job.user_id'=>$userId),
                        'AND'=>array(
                          'Job.user_id !='=>$userId,
                          'Job.job_status'=>0,
                          'Job.category_id'=>$categoryId,
                        )),
                     'order'=>array('Job.id DESC')
                    );

            }else{

                $conditions = array(
                    'conditions'=>array(
                        'Job.category_id'=>$categoryId,
                        'Job.job_status'=>0,
                        ),
                        'order'=>array('Job.id DESC')
                        );
                    

            }            
            $jobDetails=$this->find('all',$conditions); 
            //echo "<pre>";print_r($jobDetails);die;
            if(!empty($jobDetails))
            {
                foreach($jobDetails as $value){
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
                    
                    $arrayData['total_bid']=count($value['Bid']);
					//Find Current user bid details 
                     $currentUserBidDetails=$this->Bid->find('first',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.user_id'=>$userId,
                            ),
                        'order'=>array('Bid.id DESC')
                        )
                    );  
                     if(!empty($currentUserBidDetails))
                     {
                        $arrayData['userBidStatus']=$currentUserBidDetails['Bid']['status'];                       

                     }else{

                        $arrayData['userBidStatus']='';                         

                     }
					 
                    //find left job count
                    $bookedJob=$this->Bid->find('count',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.status'=>1),
                        'order'=>array('Bid.id DESC')
                        )
                    );                
                    if(!empty($bookedJob))
                    {
                        if($bookedJob <= $value['Job']['positions'])
                        {
                            $arrayData['positions'] = $value['Job']['positions'] - $bookedJob;
                        }
                        
                    }else{

                        $arrayData['positions'] = $value['Job']['positions'];
                    }
                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;
                    //Category array 
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];   
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];
                    //User array
                    $arrayData['name'] = $value['User']['name'];
                    $returnData[] = $arrayData;
                 
                }               
                $message = 'Successfully';
                return $returnData; 
                
            }else{
                $message = 'no jobs found for your search criteria';
                return false;
            }
        }
    }//end

    /**
    * @access public
    * @Method appGetOpenJobsByCalendar.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $Data    
    * @return Jobs Detail in Json Format
    */
    
    public function appGetOpenJobsByCalendar($myArrayData=null, &$message='')
    {   

        //Extract Comming Data
        extract($myArrayData); 
        $nStart  = isset($start) ? $start : '';
        $nEnd  = isset($end) ? $end : '';
		$user_id  = isset($user_id) ? $user_id : '';
        if(!empty($nStart))
        {
			$startDate=date('Y-m-d',strtotime($nStart));
            $endDate=date('Y-m-d',strtotime($nEnd));
            if(!empty($startDate) && empty($endDate))
            {
                //search by single start date

                $conditions = array(
                'conditions'=>array(
                    'Job.startdate ='=>$startDate,
					'Job.user_id'=>$user_id,                    
                    'Job.job_status'=>0,                
                    ),
                'order'=>array('Job.id DESC'));
                

            }else{
					                   
                //search by both date
				$conditions = array(
                    'conditions'=>array(
                        'AND'=>array(                          
                            'Job.user_id'=>$user_id,
                            'Job.job_status'=>0,
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startDate, $endDate),
                                    'Job.enddate BETWEEN ? and ?' => array($startDate, $endDate),                                   
                                    )
                        ))
                    );

            }
            $getOpenBookDetails=$this->find('all',$conditions);         
            if(!empty($getOpenBookDetails))
            { 
                foreach($getOpenBookDetails as $value)
                {


                    $arrayData['user_id'] = $value['Job']['user_id'];
                    $arrayData['job_id'] = $value['Job']['id'];
                    $arrayData['title'] = $value['Job']['title'];
                    $arrayData['category_id'] = $value['Job']['category_id'];
                    $arrayData['company_id'] = $value['Job']['company_id'];
                    $arrayData['positions'] = $value['Job']['positions'];
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

                    //$arrayData['starttime'] = date('g:i',strtotime($value['Job']['starttime']));
                    //$arrayData['endtime'] = date('g:i',strtotime($value['Job']['endtime']));
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
                    $arrayData['total_bid']=count($value['Bid']);
                    $arrayData['total_notification']=count($value['Notification']);             
                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;
                    //Category array                
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];   
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];
                    //User array                    
                    $arrayData['name'] = $value['User']['name'];

                    if(!empty($value['Bid'])){
                        foreach($value['Bid'] as $bidValueStatus){
                            if($bidValueStatus['status']=='1'){
                                $arrayData['acceptBidStatus'] = '1';
                                break;
                            }else{
                                $arrayData['acceptBidStatus'] = '0';
                             }
                        }
                    }else{

                         $arrayData['acceptBidStatus'] = '0';
                    }              
                    $returnData[] = $arrayData;
                }
                $message = 'Successfully';              
                return $returnData;  

            }else{
                $message = 'no open jobs found';
                return false;
            }  
        }        
    }

	
	 /**
    * @access public
    * @Method appGetBookedJobsByCalendar.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $Data    
    * @return Jobs Detail in Json Format
    */
    
    public function appGetBookedJobsByCalendar($myArrayData=null, &$message='')
    {   

        //Extract Comming Data
        extract($myArrayData); 
        $nStart  = isset($start) ? $start : '';
        $nEnd  = isset($end) ? $end : '';
        $user_id  = isset($user_id) ? $user_id : '';

        if(!empty($nStart))
        {
			$startDate=date('Y-m-d',strtotime($nStart));
            $endDate=date('Y-m-d',strtotime($nEnd)); 
            if(!empty($startDate) && empty($endDate))
            {
                //search by single start date
               
                $conditions = array(
                'conditions'=>array(
                    'Job.startdate ='=>$startDate,
                    'Job.user_id'=>$user_id,
                    'Job.job_status'=>1,                
                    ),
                'order'=>array('Job.id DESC'));
                

            }else{               
                //search by both date               
                $conditions = array(
                    'conditions'=>array(
                        'AND'=>array(                          
                            'Job.user_id'=>$user_id,
                            'Job.job_status'=>1,
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startDate, $endDate),
                                    'Job.enddate BETWEEN ? and ?' => array($startDate, $endDate),                                   
                                    )
                        ))
                    );

            }
            $getBookedJobsDetails=$this->find('all',$conditions);

            if(!empty($getBookedJobsDetails))
            { 
                foreach($getBookedJobsDetails as $value)
                {
                    $arrayData['user_id'] = $value['Job']['user_id'];
                    $arrayData['job_id'] = $value['Job']['id'];
                    $arrayData['title'] = $value['Job']['title'];
                    $arrayData['category_id'] = $value['Job']['category_id'];
                    $arrayData['company_id'] = $value['Job']['company_id'];
                    $arrayData['positions'] = $value['Job']['positions'];
                    $arrayData['address1'] = $value['Job']['address1'];
                    $arrayData['address2'] = $value['Job']['address2'];
                    $arrayData['pincode'] = $value['Job']['pincode'];
                    $arrayData['description'] = $value['Job']['description'];
                    $arrayData['state_id'] = $value['Job']['state_id'];
                    $arrayData['city_id'] = $value['Job']['city_id'];
                    $arrayData['startdate'] =date('j,M',strtotime($value['Job']['startdate']));
                    $arrayData['enddate'] = date('j,M',strtotime($value['Job']['enddate']));
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
                    //Category array
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];
                    //User array
                    $arrayData['name'] = $value['User']['name'];
                    $returnData[] = $arrayData;
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
    * @Method appGetOpenJobsForEmployeeByCalendar.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $myArrayData    
    * @return job details by calendar date in Json Format
    */
    
    public function appGetOpenJobsForEmployeeByCalendar($myArrayData=null, &$message='')
    {   

        //Extract Comming Data
        extract($myArrayData); 
        $startDate  = isset($start) ? $start : '';
        $endDate  = isset($end) ? $end : '';
        $user_id  = isset($user_id) ? $user_id : '';      
        if(!empty($user_id))
        {

            $userDetails=$this->User->findById($user_id);           
           if(!empty($startDate) && empty($endDate))
            {
                //search by single start date
               
                $conditions = array(
                'conditions'=>array(
                    'Job.startdate ='=>$startDate,                   
                    'Job.state_id'=>$userDetails['User']['state_id'],
                    'Job.city_id'=>$userDetails['User']['city_id'],
                    'Job.job_status'=>0,                
                    ),
                'order'=>array('Job.id DESC'));
                

            }else{               
                //search by both date               
                $conditions = array(
                    'conditions'=>array(
                        'AND'=>array(                          
                            'Job.state_id'=>$userDetails['User']['state_id'],
                            'Job.city_id'=>$userDetails['User']['city_id'],
                            'Job.job_status'=>0,
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startDate, $endDate),
                                    'Job.enddate BETWEEN ? and ?' => array($startDate, $endDate),                                   
                                    )
                        ))
                    );

            }

            $jobDetails=$this->find('all',$conditions);                            
            //echo "<pre>";print_r($jobDetails);die;
            if(!empty($jobDetails))
            {
                foreach($jobDetails as $value){
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
                    
                    $arrayData['total_bid']=count($value['Bid']);

                    //find left job count
                    $bookedJob=$this->Bid->find('count',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.status'=>1),
                        'order'=>array('Bid.id DESC')
                        )
                    );                
                    if(!empty($bookedJob))
                    {
                        if($bookedJob <= $value['Job']['positions'])
                        {
                            $arrayData['positions'] = $value['Job']['positions'] - $bookedJob;
                        }
                        
                    }else{

                        $arrayData['positions'] = $value['Job']['positions'];
                    }

                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);                    
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;

                    //Category array                
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];   
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];                
                    //User array                    
                    $arrayData['name'] = $value['User']['name'];
                    $returnData[] = $arrayData;
                   // echo "<pre>";print_r( $jobLeft);
                }
               // die;
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
    * @Method appGetJobsByGeographicalSearch.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $myArrayData    
    * @return job details by SearchText,State,category
    */
    
    public function appGetJobsByGeographicalSearch($myArrayData=null, &$message='')
    {   
        //Extract Comming Data
        extract($myArrayData); 
        $searchKey  = isset($searchKey) ? $searchKey : ''; 
        $city_id  = isset($city_id) ? $city_id : ''; 
        $category_id  = isset($category_id) ? $category_id : ''; 
        $flag  = isset($flag) ? $flag : ''; 
		$userId  = isset($userId) ? $userId : '';		
        //$userId  = isset($userId) ? $userId : '';
        if(!empty($flag))
        {
			if(!empty($searchKey) && empty($city_id) && empty($category_id))
            {
            
                //$searchKey='xyz'
                //state_id=''
                //category_id=''
                
                $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                        'AND'=>array(                            
                            'OR'=>array(
                                'Job.title LIKE ' =>'%'.$searchKey.'%',
                                'Job.description LIKE' =>'%'.$searchKey.'%',                                   
                                )
                        )),
                     'order'=>array('Job.id DESC')
                    );          
            }else if(empty($searchKey) && !empty($city_id) && !empty($category_id)){

                //$searchKey=''
                //state_id='1'
                //category_id='2'
                
                $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                        'AND'=>array(  
                            'Job.city_id'=>$city_id,                          
                            'Job.category_id'=>$category_id,                          
                        )), 
                    'order'=>array('Job.id DESC')
                    );
            }else if(empty($searchKey) && empty($city_id) && !empty($category_id)){

                //$searchKey=''
                //state_id=''
                //category_id='1'
                $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                        'AND'=>array(  
                            'Job.category_id'=>$category_id,                            
                        )), 
                    'order'=>array('Job.id DESC')
                    );
            
            }else if(empty($searchKey) && empty($city_id) && empty($category_id)){

                //$searchKey=''
                //state_id=''
                //category_id=''
                 $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                       ), 
                    'order'=>array('Job.id DESC')
                    );

            } else if(!empty($searchKey) && !empty($city_id) && !empty($category_id)){

                //$searchKey='xyz'
                //state_id='1'
                //category_id='2'
                
                $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                        'Job.city_id'=>$city_id,
                        'Job.category_id'=>$category_id,
                        'AND'=>array(                            
                            'OR'=>array(
                                'Job.title LIKE ' =>'%'.$searchKey.'%',
                                'Job.description LIKE' =>'%'.$searchKey.'%',                                   
                                )
                        )),
                     'order'=>array('Job.id DESC')
                    );        
            }else if(!empty($searchKey) && !empty($city_id) && empty($category_id)){

                //$searchKey='xyz'
                //state_id='1'
                //category_id=''
                $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                        'Job.city_id'=>$city_id,                       
                        'AND'=>array(                            
                            'OR'=>array(
                                'Job.title LIKE ' =>'%'.$searchKey.'%',
                                'Job.description LIKE' =>'%'.$searchKey.'%',                                   
                                )
                        )),
                     'order'=>array('Job.id DESC')
                    );

            }else if(!empty($searchKey) && empty($city_id) && empty($category_id)){

                 //$searchKey='xyz'
                //state_id=''
                //category_id='2'
                
                $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                         'Job.category_id'=>$category_id,
                        'AND'=>array(
                            'OR'=>array(
                                'Job.title LIKE ' =>'%'.$searchKey.'%',
                                'Job.description LIKE' =>'%'.$searchKey.'%',
                                )
                        )),
                     'order'=>array('Job.id DESC')
                    );   

            }else if(empty($searchKey) && !empty($city_id) && empty($category_id)){
                 
                 $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,                         
                        'AND'=>array(
                            'Job.city_id'=>$city_id, 
                        )),
                     'order'=>array('Job.id DESC')
                    ); 

            }

            $getJobDetails=$this->find('all',$conditions); 
            //echo "<pre>";print_r($getJobDetails);die;
            if(!empty($getJobDetails))
            {
                foreach($getJobDetails as $value){
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
                    
                    $arrayData['total_bid']=count($value['Bid']);
					//Find Current user bid details 
                     $currentUserBidDetails=$this->Bid->find('first',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.user_id'=>$userId,
                            ),
                        'order'=>array('Bid.id DESC')
                        )
                    );  
                     if(!empty($currentUserBidDetails))
                     {
                        $arrayData['userBidStatus']=$currentUserBidDetails['Bid']['status'];                       

                     }else{

                        $arrayData['userBidStatus']='';                         

                     }
                    //find left job count
                    $bookedJob=$this->Bid->find('count',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.status'=>1),
                        'order'=>array('Bid.id DESC')
                        )
                    );                
                    if(!empty($bookedJob))
                    {
                        if($bookedJob <= $value['Job']['positions'])
                        {
                            $arrayData['positions'] = $value['Job']['positions'] - $bookedJob;
                        }
                        
                    }else{

                        $arrayData['positions'] = $value['Job']['positions'];
                    }
                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;
                    //Category array 
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];   
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];
                    //User array
                    $arrayData['name'] = $value['User']['name'];
                    $returnData[] = $arrayData;
                 
                }               
                $message = 'Successfully';
                return $returnData; 

            }else{

                 $message = 'no jobs found for your search criteria';
                return false;
            }
            
        }
    }//end

/**
    * @access public
    * @Method appGetSearchEmployeeJobs.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $Data    
    * @return Job Details in Json Format
    */
    
    public function appGetSearchEmployeeJobs($myArrayData=null, &$message='')
    {   

        //Extract Comming Data
        extract($myArrayData); 
        $user_id  = isset($user_id) ? $user_id : '';
		$User = new User();
        if(!empty($user_id)){
			
		  $userDetails=$User->findById($user_id);          
            $val = explode(",",$userDetails['User']['category_id']);
            $getOpenJobDetails = $this->find('all',array(
                'conditions' => array(
                    'Job.job_status' =>0,
                    'Job.category_id'=>$val,
                    'Job.state_id'=>$userDetails['User']['state_id']),
                'order'=>array('Job.id DESC')
                ));
           //echo "<pre>";print_r($this->getDataSource()->getLog());die;           
            if(!empty($getOpenJobDetails))
            {   
                foreach($getOpenJobDetails as $value)
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
                    $arrayData['total_bid']=count($value['Bid']);      
                    $arrayData['total_notification']=count($value['Notification']);             

                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);                    
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;

                    //Find Current user bid details 
                     $currentUserBidDetails=$this->Bid->find('first',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.user_id'=>$user_id,
                            ),
                        'order'=>array('Bid.id DESC')
                        )
                    );  
                     if(!empty($currentUserBidDetails))
                     {
                        $arrayData['userBidStatus']=$currentUserBidDetails['Bid']['status'];                       

                     }else{

                        $arrayData['userBidStatus']='';                         

                     }
                   
                    //Set Job positions
                    $bookedJob=$this->Bid->find('count',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.status'=>1),
                        'order'=>array('Bid.id DESC')
                        )
                    );                
                    if(!empty($bookedJob))
                    {
                        if($bookedJob <= $value['Job']['positions'])
                        {
                            $arrayData['positions'] = $value['Job']['positions'] - $bookedJob;
                        }
                        
                    }else{

                        $arrayData['positions'] = $value['Job']['positions'];
                    }
                   
                    //Category array                
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];   
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];                
                    //User array                    
                    $arrayData['name'] = $value['User']['name'];                   
                    $returnData[] = $arrayData; 
                }
                
                $message = 'Successfully';                
                return $returnData;             
            } else{
                $message = 'no jobs found for your search critaria';
                return false;
            }
        }
    }

//16Feb
/**
    * @access public
    * @Method appGetSearchEmployeeJobsByFilter.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $myArrayData    
    * @return job details by SearchText,State,category
    */
    public function appGetSearchEmployeeJobsByFilter($myArrayData=null, &$message='')
    {   $User = new User();
        //Extract Comming Data
        extract($myArrayData); 
        $startdate  = isset($startdate) ? $startdate : ''; 
        $enddate  = isset($enddate) ? $enddate : ''; 
        $state_id  = isset($state_id) ? $state_id : ''; 
        $category_id  = isset($category_id) ? $category_id : '';       
        $user_id  = isset($user_id) ? $user_id : '';
        if(!empty($user_id))
        {
            $userDetails=$User->findById($user_id);
            $val = explode(",",$userDetails['User']['category_id']); 
           if(empty($startdate) &&  empty($enddate) && empty($state_id) && empty($category_id))
           {
            
                /*$conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                       // 'FIND_IN_SET(\''. $userDetails['User']['category_id'] .'\',Job.category_id)',
                        'Job.category_id'=>$userDetails['User']['category_id'],
                        'Job.state_id'=>$userDetails['User']['state_id'],
                        ), 
                    'order'=>array('Job.id DESC')
                    );*/
                $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                        ), 
                    'order'=>array('Job.id DESC')
                    );

           }else if(!empty($startdate) &&  !empty($enddate) && !empty($state_id) && !empty($category_id)){
              
                $conditions = array(
                    'conditions'=>array(
                        'Job.job_status'=>0,
                        'AND'=>array(                            
                            'Job.state_id'=>$state_id,
                            'Job.category_id'=>$category_id,
                            'OR'=>array(
                                'Job.startdate BETWEEN ? and ?' => array($startdate, $enddate),
                                'Job.enddate BETWEEN ? and ?' => array($startdate, $enddate),                                   
                                )
                        )), 
                    'order'=>array('Job.id DESC')
                    );

           }else if(!empty($startdate) &&  empty($enddate) && empty($state_id) && empty($category_id)){

                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array( 
                                'Job.startdate'=>$startdate,
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(empty($startdate) &&  !empty($enddate) && empty($state_id) && empty($category_id)){

                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(
                                'Job.enddate'=>$enddate,
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(empty($startdate) &&  empty($enddate) && !empty($state_id) && empty($category_id)){

                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(                                 
                                'Job.state_id'=>$state_id,
                            )), 
                        'order'=>array('Job.id DESC')
                        );        
           }else if(empty($startdate) &&  empty($enddate) && empty($state_id) && !empty($category_id)){

                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(
                                'Job.category_id'=>$category_id, 
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(!empty($startdate) &&  !empty($enddate) && empty($state_id) && empty($category_id)){
                
                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startdate, $enddate),
                                    'Job.enddate BETWEEN ? and ?' => array($startdate, $enddate),                                   
                                )
                                //'Job.startdate'=>$startdate,
                                //'Job.enddate'=>$enddate,
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(empty($startdate) &&  empty($enddate) && !empty($state_id) && !empty($category_id)){

                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(
                                'Job.state_id'=>$state_id,
                                'Job.category_id'=>$category_id,
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(!empty($startdate) &&  empty($enddate) && !empty($state_id) && empty($category_id)){

                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(
                                'Job.startdate'=>$startdate,
                                'Job.state_id'=>$state_id,
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(!empty($startdate) &&  empty($enddate) && empty($state_id) && !empty($category_id)){
                
                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(
                                'Job.startdate'=>$startdate,
                                'Job.category_id'=>$category_id, 
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(!empty($startdate) && !empty($enddate) && !empty($state_id) && empty($category_id)){
                
                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(                                
                                'Job.state_id'=>$state_id,
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startdate, $enddate),
                                    'Job.enddate BETWEEN ? and ?' => array($startdate, $enddate),                                   
                                )
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(!empty($startdate) && !empty($enddate) && empty($state_id) && !empty($category_id)){
                
                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(                               
                                'Job.category_id'=>$category_id,
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startdate, $enddate),
                                    'Job.enddate BETWEEN ? and ?' => array($startdate, $enddate),                                   
                                )
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(empty($startdate) &&  !empty($enddate) && !empty($state_id) && empty($category_id)){

                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(
                                'Job.enddate'=>$enddate,  
                                'Job.state_id'=>$state_id,
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(empty($startdate) &&  !empty($enddate) && empty($state_id) && !empty($category_id)){
                
                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(                              
                                'Job.enddate'=>$enddate,
                                'Job.category_id'=>$category_id,
                            )), 
                        'order'=>array('Job.id DESC')
                        );

           }else if(empty($startdate) &&  !empty($enddate) && !empty($state_id) && !empty($category_id)){
                
                $conditions = array(
                        'conditions'=>array(
                            'Job.job_status'=>0,
                            'AND'=>array(                                
                                'Job.enddate'=>$enddate,
                                'Job.state_id'=>$state_id,
                                'Job.category_id'=>$category_id,
                            )), 
                        'order'=>array('Job.id DESC')
                        );
           }
            
           $getSearchJobDetailsFilter=$this->find('all',$conditions); 
           //echo "<pre>";print_r($getSearchJobDetailsFilter);die;
           if(!empty($getSearchJobDetailsFilter))
           {
                foreach($getSearchJobDetailsFilter as $value)
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
                    $arrayData['jobcost'] =$value['Job']['jobcost'];
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
                    $arrayData['total_bid']=count($value['Bid']);      
                    $arrayData['total_notification']=count($value['Notification']);             

                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);                    
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;

                    //Find Current user bid details 
                     $currentUserBidDetails=$this->Bid->find('first',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.user_id'=>$user_id,
                            ),
                        'order'=>array('Bid.id DESC')
                        )
                    );  
                     if(!empty($currentUserBidDetails))
                     {
                        $arrayData['userBidStatus']=$currentUserBidDetails['Bid']['status'];                       

                     }else{

                        $arrayData['userBidStatus']='';                         

                     }
                   
                    //Set Job positions
                    $bookedJob=$this->Bid->find('count',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.status'=>1),
                        'order'=>array('Bid.id DESC')
                        )
                    );                
                    if(!empty($bookedJob))
                    {
                        if($bookedJob <= $value['Job']['positions'])
                        {
                            $arrayData['positions'] = $value['Job']['positions'] - $bookedJob;
                        }
                        
                    }else{

                        $arrayData['positions'] = $value['Job']['positions'];
                    }
                   
                    //Category array                
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];   
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];                
                    //User array                    
                    $arrayData['name'] = $value['User']['name'];                   
                    $returnData[] = $arrayData;             
                  //   echo "<pre>";print_r($returnData);
                }
                
                $message = 'Successfully';                
                return $returnData;   

           }else{
                $message = 'no record found based on your category, state and city ';
                return false;

           }          
        }
    }

/*
 *26Mar2018
 */

/**
    * @access public
    * @Method appGetOpenJobs.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :15_Nov_2017
    * @param string $Data    
    * @return User Details in Json Format
    */
    
    public function appGetExpiredJobs($myArrayData=null, &$message='')
    {   

        //Extract Comming Data
        extract($myArrayData); 
        $user_id  = isset($id) ? $id : '';        
        $todayDate=date("Y-m-d");

        if(!empty($user_id)){

           $getExpiredJobDetails=$this->find('all',array(             
                'conditions'=>array(
                    'Job.user_id'=>$user_id,                    
                    'Job.job_status'=>3,                
                    ),
                'order'=>array('Job.id DESC')
                ));


           //echo "<pre>";print_r($this->getDataSource()->getLog());die;
            
            if(!empty($getExpiredJobDetails))
            {   
                foreach($getExpiredJobDetails as $value)
                {

                    $arrayData['user_id'] = $value['Job']['user_id'];
                    $arrayData['job_id'] = $value['Job']['id'];
                    $arrayData['title'] = $value['Job']['title'];
                    $arrayData['category_id'] = $value['Job']['category_id'];
                    $arrayData['company_id'] = $value['Job']['company_id'];                 
                    $arrayData['address1'] = $value['Job']['address1'];
                    $arrayData['address2'] = $value['Job']['address2'];
                    $arrayData['pincode'] = $value['Job']['pincode'];
                    $arrayData['description'] = substr($value['Job']['description'], 0, 80);
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
                    $arrayData['total_bid']=count($value['Bid']);      
                    $arrayData['total_notification']=count($value['Notification']);             
                
                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);                    
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;

                    //Set Job positions
                    $bookedJob=$this->Bid->find('count',array(
                        'conditions'=>array(
                            'Bid.job_id'=>$value['Job']['id'],
                            'Bid.status'=>1),
                        'order'=>array('Bid.id DESC')
                        )
                    );                
                    if(!empty($bookedJob))
                    {
                        if($bookedJob <= $value['Job']['positions'])
                        {
                            $arrayData['positions'] = $value['Job']['positions'] - $bookedJob;
                        }
                        
                    }else{

                        $arrayData['positions'] = $value['Job']['positions'];
                    }

                    //$time= date('H:m',strtotime($arrayData1['total_time']));          
                    //$arrayData['total_time']=$time;
                    //Category array                
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];   
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];                
                    //User array                    
                    $arrayData['name'] = $value['User']['name'];

                    if(!empty($value['Bid'])){                    
                        foreach($value['Bid'] as $bidValueStatus){
                            if($bidValueStatus['status']=='1'){
                                $arrayData['acceptBidStatus'] = '1';
                                break;
                            }else{
                                $arrayData['acceptBidStatus'] = '0';
                             }
                        }
                    }else{

                         $arrayData['acceptBidStatus'] = '0';
                    }              
                    $returnData[] = $arrayData;                            
                }
                
                $message = 'Successfully';               
                return $returnData;             
            } else{
                $message = 'no expired jobs found';
                return false;
            }
        }
    }

     /**
    * @access public
    * @Method appGetExpiredJobDetailsByCompanyId.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :30_Nov_2017
    * @param string $Data    
    * @return Jobs Details in Json Format
    */
    
    public function appGetExpiredJobDetailsByCompanyId($myArrayData=null, &$message='')
    {   

        //Extract Comming Data
        extract($myArrayData); 
        $companyid  = isset($companyid) ? $companyid : '';
        $user_id  = isset($uId) ? $uId : '';

        if(!empty($user_id)){

           $getExpireBookDetails=$this->find('all',array(
                'conditions'=>array(
                    'Job.user_id'=>$user_id,  
                    'Job.company_id'=>$companyid,                  
                    'Job.job_status'=>3,
                    ),
                'order'=>array('Job.id DESC')
                ));
          
            if(!empty($getExpireBookDetails))
            {
                foreach($getExpireBookDetails as $value)
                {
                    $arrayData['user_id'] = $value['Job']['user_id'];
                    $arrayData['job_id'] = $value['Job']['id'];
                    $arrayData['title'] = $value['Job']['title'];
                    $arrayData['category_id'] = $value['Job']['category_id'];
                    $arrayData['company_id'] = $value['Job']['company_id'];
                    $arrayData['positions'] = $value['Job']['positions'];
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
                    
                    //Not using total time in booked Job
                    /*$timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;*/

                    //Category array                
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];

                    //User array                    
                    $arrayData['name'] = $value['User']['name'];
                    $returnData[] = $arrayData;             
                }
                
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
    * @Method appGetExpiredJobsByCalendar.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $Data    
    * @return Jobs Detail in Json Format
    */
    
    public function appGetExpiredJobsByCalendar($myArrayData=null, &$message='')
    {   

        //Extract Comming Data
        extract($myArrayData); 
        $nStart  = isset($start) ? $start : '';
        $nEnd  = isset($end) ? $end : '';
        $user_id  = isset($user_id) ? $user_id : '';

        if(!empty($nStart))
        {        
            $startDate=date('Y-m-d',strtotime($nStart));
            $endDate=date('Y-m-d',strtotime($nEnd));          
            if(!empty($startDate) && empty($endDate))
            {
                //search by single start date
               
                $conditions = array(
                'conditions'=>array(
                    'Job.startdate ='=>$startDate,
                    'Job.user_id'=>$user_id,
                    'Job.job_status'=>3,                
                    ),
                'order'=>array('Job.id DESC'));
                

            }else{               
                //search by both date               
                $conditions = array(
                    'conditions'=>array(
                        'AND'=>array(                          
                            'Job.user_id'=>$user_id,
                            'Job.job_status'=>3,
                                'OR'=>array(
                                    'Job.startdate BETWEEN ? and ?' => array($startDate, $endDate),
                                    'Job.enddate BETWEEN ? and ?' => array($startDate, $endDate),                                   
                                    )
                        ))
                    );

            }
            $getOpenBookDetails=$this->find('all',$conditions);
            if(!empty($getOpenBookDetails))
            { 
                foreach($getOpenBookDetails as $value)
                {


                    $arrayData['user_id'] = $value['Job']['user_id'];
                    $arrayData['job_id'] = $value['Job']['id'];
                    $arrayData['title'] = $value['Job']['title'];
                    $arrayData['category_id'] = $value['Job']['category_id'];
                    $arrayData['company_id'] = $value['Job']['company_id'];
                    $arrayData['positions'] = $value['Job']['positions'];
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

                    //$arrayData['starttime'] = date('g:i',strtotime($value['Job']['starttime']));
                    //$arrayData['endtime'] = date('g:i',strtotime($value['Job']['endtime']));
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
                    $arrayData['total_bid']=count($value['Bid']);
                    $arrayData['total_notification']=count($value['Notification']);             
                    $timeDiff=(strtotime($value['Job']['endtime'])-strtotime($value['Job']['starttime']));
                    $hours = intval($timeDiff / 3600); 
                    $seconds_remain = ($timeDiff - ($hours * 3600)); 
                    $minutes = intval($seconds_remain / 60);
                    $arrayData1['total_time'] = $hours.':'.$minutes;
                    $time=date('H:i',strtotime($arrayData1['total_time']));
                    $arrayData['total_time']=$time;
                    //Category array                
                    $arrayData['category_name'] = $value['Category']['name'];
                    $arrayData['company_name'] = $value['Company']['title'];   
                    $arrayData['company_logo'] = Router::url('/', true).'uploads/company_logo/thumb/'.$value['Company']['logo'];
                    //User array                    
                    $arrayData['name'] = $value['User']['name'];

                    if(!empty($value['Bid'])){
                        foreach($value['Bid'] as $bidValueStatus){
                            if($bidValueStatus['status']=='1'){
                                $arrayData['acceptBidStatus'] = '1';
                                break;
                            }else{
                                $arrayData['acceptBidStatus'] = '0';
                             }
                        }
                    }else{

                         $arrayData['acceptBidStatus'] = '0';
                    }              
                    $returnData[] = $arrayData;
                }
                $message = 'Successfully';              
                return $returnData;  

            }else{
                $message = 'no record found';
                return false;
            }  
        }        
    }

}
