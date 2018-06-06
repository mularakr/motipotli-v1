<?php
App::uses('AppModel', 'Model');
/**
 * Document Model
 *
 * @property User $User
 */
class Document extends AppModel {


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
	* @Method appGetUserDocDetailById.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return User doc Details in Json Format
	*/
	
	public function appGetUserDocDetailById($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$user_id      		= isset($id) 	? $id : ''; 
              
        /*if (empty($user_id)) {
            $message = 'Enetr User id. Try Again!';
            return false;
        } */ 
		if(!empty($user_id)){

			$getDocDetails = $this->find('first', array(
        	'recursive' => -1,
            'conditions' => array(
                'Document.user_id' => $user_id,                 
                )
            ));   

            if(!empty($getDocDetails))
            {
            		$arrayData['id']=$getDocDetails['Document']['id'];
            		$arrayData['user_id']=$getDocDetails['Document']['user_id'];
					$arrayData['doc_file']=$getDocDetails['Document']['doc_file'];


            	/*foreach($getDocDetails as $value)
            	{
            		$arrayData['id']=$value['Document']['id'];
            		$arrayData['user_id']=$value['Document']['user_id'];
					$arrayData['doc_file']=$value['Document']['doc_file'];

					$returnData[] = $arrayData;	
				}*/			
				$message = 'Successfully';
				return $arrayData; 

            } else{

            	$message = 'no record found';
            	return false;
            }

		}

    }

    /**
	* @access public
	* @Method appGetUserDocCount.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return User doc Details in Json Format
	*/
	
	public function appGetUserDocCount($myArrayData=null, &$message='')
	{   

		//Extract Comming Data
		extract($myArrayData); 
		$user_id      		= isset($id) 	? $id : '';              
		if(!empty($user_id)){

			$getDocDetails = $this->find('count', array(
	        	'recursive' => -1,
	            'conditions' => array(
	                'Document.user_id' => $user_id,                 
	                )
	            ));   
			//	echo "<pre>";print_r($getDocDetails);die;
            if(!empty($getDocDetails))
            {
            	$arrayData['count']=$getDocDetails;            	
				$message = 'Successfully';
				return $arrayData; 

            } else{

            	$arrayData['count']='0'; 
            	$message = 'no record found';
				return $arrayData;
            	//$message = 'no record found';
            	//return $arrayData;
            }

		}

    }

/**
	* @access public
	* @Method appDeleteUserDocDetails.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return Delete doc Details in Json Format
	*/
	public function appDeleteUserDocDetails($myArrayData=null, &$message=''){
		//Extract Comming Data	
		extract($myArrayData); 
		$docId  = isset($id) ? $id : '';
	 	$file_full = WWW_ROOT.'uploads/doc_file/big/';     	
		if(!empty($docId)){	

			$docDetails=$this->findById($docId);
			$docName=$docDetails['Document']['doc_file'];			
			if($this->delete($docId))
			{	
				  if(!empty($docName))
					{
						unlink($file_full . $docName);							
					}			
				  $message = 'User Document Delete Successfully';
	              return true; 	
			}else{
				$message = 'Oops! Some error occurred, please try again';
	            return false;	
			}	
		}	
	} 











}
