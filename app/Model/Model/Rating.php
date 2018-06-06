<?php
App::uses('AppModel', 'Model');
/**
 * Rating Model
 *
 * @property User $User
 */
class Rating extends AppModel {


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
    * @Method appSetRatingData.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $Data    
    * @return 
    */
	function appSetRatingData($myArrayData=null, &$message='')
	{
		extract($myArrayData);
		$rating  = isset($rating) ? $rating : '';
		$employer_id  = isset($employer_id) ? $employer_id : '';
		$employee_id  = isset($employee_id) ? $employee_id : '';
		$job_id  = isset($job_id) ? $job_id : '';
		if(!empty($job_id))
		{

			$findDetailsIfExist=$this->find('first',array(
				'conditions'=>array(
					'Rating.employer_id'=>$employer_id,
					'Rating.user_id'=>$employee_id,
					'Rating.job_id'=>$job_id)));
			if(!empty($findDetailsIfExist))
			{	
				$ratingArray['Rating']['id']=$findDetailsIfExist['Rating']['id'];
				$ratingArray['Rating']['employer_id']=$employer_id;
				$ratingArray['Rating']['user_id']=$employee_id;
				$ratingArray['Rating']['job_id']=$job_id;
				$ratingArray['Rating']['rating']=$rating;
				$messageFor='Rate Update Successfully';
			}else{

				$ratingArray['Rating']['employer_id']=$employer_id;
				$ratingArray['Rating']['user_id']=$employee_id;
				$ratingArray['Rating']['job_id']=$job_id;
				$ratingArray['Rating']['rating']=$rating;
				$messageFor='Rate Successfully';
			}
			if($this->save($ratingArray))
			{
				$this->clear();
				$message =$messageFor;
				return true;

			}else{
				$message = 'Oops! Some error occurred, please try again';
				return false;

			}
		}

	}


 /**
    * @access public
    * @Method appSetRatingData.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $Data    
    * @return 
    */
	function appGetRatingInfo($myArrayData=null, &$message='')
	{
		extract($myArrayData);	
		$employer_id  = isset($employer_id) ? $employer_id : '';
		$employee_id  = isset($employee_id) ? $employee_id : '';
		$job_id  = isset($job_id) ? $job_id : '';
		
		if(!empty($job_id))
		{
			$findDetailsIfExist=$this->find('first',array(
				'conditions'=>array(
					'Rating.employer_id'=>$employer_id,
					'Rating.user_id'=>$employee_id,
					'Rating.job_id'=>$job_id)));
			if(!empty($findDetailsIfExist))
			{
				$ratingValue['ratingval']=$findDetailsIfExist['Rating']['rating'];
				$ratingValue['employer_id']=$findDetailsIfExist['Rating']['employer_id'];
				$ratingValue['employee_id']=$findDetailsIfExist['Rating']['user_id'];
				$ratingValue['job_id']=$findDetailsIfExist['Rating']['job_id'];
				return 	$ratingValue;
				return true;			
			}else{
				$message = 'Rate Employee';
				return false;
			}

		}
	}
	
	/**
    * @access public
    * @Method appGetUserRatingForCurrentJobDetails.
    * @Developer : Rafi (Evon Technologies)
    * @Date      :
    * @param string $Data    
    * @return 
    */
   
	function appGetUserRatingForCurrentJobDetails($myArrayData=null, &$message='')
	{
		extract($myArrayData);	
		$UserId  = isset($UserId) ? $UserId : '';
		$jobId  = isset($jobId) ? $jobId : '';
		
		if(!empty($jobId))
		{
			$findDetailsIfExist=$this->find('first',array(
				'conditions'=>array(					
					'Rating.user_id'=>$UserId,
					'Rating.job_id'=>$jobId)));
			if(!empty($findDetailsIfExist))
			{
				if($findDetailsIfExist['Rating']['rating'] =='100')
				{
					$ratingValue['jobRating']='Must Hire';

				}else if($findDetailsIfExist['Rating']['rating'] == '50'){

					$ratingValue['jobRating']='Can Hire';

				}else{

					$ratingValue['jobRating']='Absent';

				}				
				$ratingValue['employee_id']=$findDetailsIfExist['Rating']['user_id'];
				$ratingValue['job_id']=$findDetailsIfExist['Rating']['job_id'];
				return 	$ratingValue;
				return true;			
			}else{
				$message = 'No rating';
				return false;
			}

		}
	}

	
	
	
	

}
