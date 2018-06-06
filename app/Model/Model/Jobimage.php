<?php
App::uses('AppModel', 'Model');
/**
 * Jobimage Model
 *
 * @property Job $Job
 */
class Jobimage extends AppModel {


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
		)
	);
	
	/******************************************************************************* 
	 * 
	 * 						Model API Start Here
	 * 	
	*********************************************************************************/
	
	/** [appDeleteJobImage description] */
	public function appDeleteJobImage($myArrayData=null, &$message=''){
		//Extract Comming Data	
		extract($myArrayData); 
		$imageId  = isset($id) ? $id : '';
	 	$file_full = WWW_ROOT.'uploads/job/big/';
     	$file_thumb = WWW_ROOT.'uploads/job/thumb/';  

		if(!empty($imageId)){	

			$imageDetails=$this->findById($imageId);
			$imageName=$imageDetails['Jobimage']['images'];
			//echo "<pre>";print_r($imageDetails);die;
			if($this->delete($imageId))
			{	
				  if(!empty($imageName))
					{
						unlink($file_full . $imageName);	
						unlink($file_thumb . $imageName);
					}			
				  $message = 'Job Image Delete Successfully';
	              return true; 	
			}else{
				$message = 'Oops! Some error occurred, please try again';
	            return false;	
			}	
		}	
	} 


}
