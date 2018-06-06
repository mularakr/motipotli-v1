<?php
App::uses('AppModel', 'Model');


/**
 * CompanyDocument Model
 *
 * 
 */
class CompanyDocument extends AppModel {

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
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
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
	* @Method appGetCompanyAddress.
	* @Developer : Rafi (Evon Technologies)
	* @Date      :
	* @param string $Data    
	* @return Company Details in Json Format
	*/
	public function appDeleteCompanyDocDetails($myArrayData=null, &$message=''){
		//Extract Comming Data	
		extract($myArrayData); 
		$companyId  = isset($id) ? $id : '';
	 	$file_full = WWW_ROOT.'uploads/company_doc/big/';     	
		if(!empty($companyId)){	

			$companyDetails=$this->findById($companyId);
			$docName=$companyDetails['CompanyDocument']['doc_name'];
			//echo "<pre>";print_r($companyDetails);die;
			if($this->delete($companyId))
			{	
				  if(!empty($docName))
					{
						unlink($file_full . $docName);							
					}			
				  $message = 'Company Document Delete Successfully';
	              return true; 	
			}else{
				$message = 'Oops! Some error occurred, please try again';
	            return false;	
			}	
		}	
	} 
	



}