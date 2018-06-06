<?php
App::uses('AppModel', 'Model');
/**
 * State Model
 *
 * @property City $City
 * @property User $User
 */
class State extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'state_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'state_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);





	/******************************************************************************* 
	 * 
	 * 						Model API Start Here
	 * 	
	*********************************************************************************/

	/**
	* @access public
	* @Method 	 : appGetStates.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 03_Nov_2017
	* @param 	 : NA
	* @return Get All States in Json Format
	**/
	public function appGetStates($myArrayData=null, &$message='')
	{	
		$states = $this->find("all", array(
              'recursive'=>0,
              'order' => array(
                    'id' => 'ASC')
        ));
		if (!empty($states)) {
			
			foreach($states as $state)
			{
				$arrayData['id']=$state['State']['id'];
				$arrayData['name']=$state['State']['name'];
				$returnData[]=$arrayData;
			}
			$message = 'Successfully';
			return $returnData;

		}else{

			$message = 'no record found';
            return false;
		}		
	}














}
