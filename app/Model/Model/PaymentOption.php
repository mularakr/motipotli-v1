<?php
App::uses('AppModel', 'Model');
/**
 * PaymentOption Model
 *
 * @property Venue $Venue
 */
class PaymentOption extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	/*public $belongsTo = array(
		'Venue' => array(
			'className' => 'Venue',
			'foreignKey' => 'venue_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/
	
	
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
	
	public function appGetAllPaymentOptionsDetails($myArrayData=null, &$message='')
	{   				
		extract($myArrayData); 
		$flag  = isset($flag) ? $flag : '';
		if(!empty($flag))
		{
			$paymentOptions = $this->find("all");
			if(!empty($paymentOptions))
			{
				foreach($paymentOptions as $value)
				{
					$optionArray['id']=$value['PaymentOption']['id'];
					$optionArray['name']=$value['PaymentOption']['name'];
					$optionArray['status']=$value['PaymentOption']['status'];					
					$returnData[] = $optionArray;
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
