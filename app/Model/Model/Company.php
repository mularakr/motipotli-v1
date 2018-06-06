<?php
App::uses('AppModel', 'Model');
/**
 * Company Model
 *
 * @property User $User
 */
class Company extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	public $actsAs = array('Containable');
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
	* @Method appCompanyDetailByCurrentUserId.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return Company Details in Json Format
	*/
	
	public function appCompanyDetailByCurrentUserId($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		 $user_id      		= isset($userId) 	? $userId : ''; 

		if(!empty($user_id)){

			$getCompanyDetails = $this->find('all', array(
        	'recursive' => -1,
            'conditions' => array(
                'Company.user_id' => $user_id,                 
                )
            ));
            
            if(!empty($getCompanyDetails))
            {
            	foreach($getCompanyDetails as $company){
            		$arrayData['company_id']					 =$company['Company']['id'];
            		$arrayData['title']					 =ucwords($company['Company']['title']);
            		$returnData[]=$arrayData;
            	} 
            	$prArray['company_id']=	'0';
            	$prArray['title']='Personal';
            	$returnData[]=$prArray;           	
            	$message = 'Successfully';
				return $returnData;					
            }else{
	            	
	            	$prArray['company_id']=	'0';
	            	$prArray['title']='Personal';
	            	$returnData[]=$prArray;
	            	return $returnData;
	            	//$message = 'no record found';
					//return false;
	            }           
		}

    }
    
	/**
	* @access public
	* @Method appCompanyDetailByCurrentUserId1.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return Company Details in Json Format
	*/
	
	public function appCompanyDetailByCurrentUserId1($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$user_id      		= isset($userId) 	? $userId : ''; 
		
		if(!empty($user_id)){			

				$getCompanyDetails = $this->find('all', array(
	        	'recursive' => -1,
	            'conditions' => array(
	                'Company.user_id' => $user_id,
	                )
	            ));
	           
	            if(!empty($getCompanyDetails))
	            {
	            	foreach($getCompanyDetails as $company){
	            		$arrayData['company_id']			=$company['Company']['id'];
	            		$arrayData['title']					=ucwords($company['Company']['title']);
	            		$returnData[]=$arrayData;
	            	}	            	
	            	$message = 'Successfully';
	            	//echo "<pre>";print_r($returnData);die;
					return $returnData;
	            }else{
	            	
	            	$message = 'no record found';
					return false;
	            }
		}

    }
    /** 
     04 dec 2017
     */

	/**
	* @access public
	* @Method appGetCompanyAddress.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return Company Details in Json Format
	*/
	
	public function appGetCompanyAddress($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$company_id      		= isset($company_id) 	? $company_id : ''; 

		if(!empty($company_id)){

			$getCompanyDetails = $this->find('first', array(
        	'recursive' => 0,
            'conditions' => array(
                'Company.id' => $company_id,                 
                )
            ));          
            if(!empty($getCompanyDetails))
            {
            	$addressArray['id']=$getCompanyDetails['Company']['id'];
            	$addressArray['title']=$getCompanyDetails['Company']['title'];
            	$addressArray['bio']=$getCompanyDetails['Company']['bio'];
            	$addressArray['phone']=$getCompanyDetails['Company']['phone'];
            	$addressArray['address1']=$getCompanyDetails['Company']['address1'];
            	$addressArray['address2']=$getCompanyDetails['Company']['address2'];
            	$addressArray['pincode']=$getCompanyDetails['Company']['pincode'];
            	$addressArray['state_id']=$getCompanyDetails['Company']['state_id'];
            	$addressArray['city_id']=$getCompanyDetails['Company']['city_id'];
            	$addressArray['company_logo']=$getCompanyDetails['Company']['logo'];
            	//echo $this->webroot;die;
            	$message = 'Successfully';
				return $addressArray;            
            }           
		}

    }


    /** [appDeleteJobDetails description] */
	public function appDeleteCompanyDetails($myArrayData=null, &$message=''){
		//Extract Comming Data	
		extract($myArrayData); 
		$companyId  = isset($id) ? $id : '';
	 	$file_full = WWW_ROOT.'uploads/company_logo/big/';
     	$file_thumb = WWW_ROOT.'uploads/company_logo/thumb/';  

		if(!empty($companyId)){	

			$companyDetails=$this->findById($companyId);
			$logoName=$companyDetails['Company']['logo'];
			//echo "<pre>";print_r($companyDetails['Company']['logo']);die;
			if($this->delete($companyId))
			{	
				  if(!empty($logoName))
					{
						unlink($file_full . $logoName);	
						unlink($file_thumb . $logoName);		
					}			
				  $message = 'Company Delete Successfully';	          
	              return true; 	
			}else{
				$message = 'Oops! Some error occurred, please try again';
	            return false;	
			}		
		}	
	} 


























}
