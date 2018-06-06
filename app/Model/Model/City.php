<?php
App::uses('AppModel', 'Model');
/**
 * City Model
 *
 * @property State $State
 * @property User $User
 */
class City extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'city_id',
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
	* @Method 	 : appGetCities.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 08_Nov_2017
	* @param 	 : NA
	* @return Get All Cities in Json Format
	**/
	public function appGetCities($myArrayData=null, &$message='')
	{	
		extract($myArrayData);		
        $stateId    = isset($id)  	?  strtolower($id)  	: '';

		$cities = $this->find("all", array(           
              'conditions'=>array('City.state_id'=>$stateId ),
              'order' => array(
                    'City.city' => 'ASC')
        ));           
		if (!empty($cities)) {
			
			foreach($cities as $city)
			{				
				$arrayData['id']=$city['City']['id'];
				$arrayData['state_id']=$city['City']['state_id'];				
				$arrayData['city']=$city['City']['city'];
				$returnData[]=$arrayData;
			}
			$message = 'Successfully';
			return $returnData;

		}else{

			$message = 'no record found for state';
            return false;
		}	
	}

/**
	* @access public
	* @Method 	 : appGetUserCities.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 08_Nov_2017
	* @param 	 : NA
	* @return Get All Cities in Json Format
	**/
	public function appGetUserCities($myArrayData=null, &$message='')
	{	
		extract($myArrayData);		
        $stateId    = isset($state_id)  	?  strtolower($state_id)  	: '';

		$cities = $this->find("all", array(           
              'conditions'=>array('City.state_id'=>$stateId ),
              'order' => array(
                    'City.city' => 'ASC')
        ));           
		if (!empty($cities)) {
			
			foreach($cities as $city)
			{				
				$arrayData['id']=$city['City']['id'];
				$arrayData['state_id']=$city['City']['state_id'];				
				$arrayData['city']=$city['City']['city'];
				$returnData[]=$arrayData;
			}
			$message = 'Successfully';
			return $returnData;

		}else{

			$message = 'no record found for state';
            return false;
		}	
	}
	
	/**
	* @access public
	* @Method 	 : appGetPopularCity.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 09_Nov_2017
	* @param 	 : NA
	* @return Get All Cities in Json Format
	**/
	public function appGetPopularCity($myArrayData=null, &$message='')
	{	
        $cities = $this->find("all",array(
        	'recursive'=>-1,
        	'conditions'=>array(
        		'City.is_popular'=>0),
        	 'order' => array(
                    'city' => 'ASC')
        	));
		if (!empty($cities)) {
			
			foreach($cities as $city)
			{

				$arrayData['id']=$city['City']['id'];
				$arrayData['name']=$city['City']['city'];
				$returnData[]=$arrayData;

			}
			$message = 'Successfully';			
			return $returnData;
 			
		}else{

			$message = 'no record found';
            return false;
		}		
	}

/**
	* @access public
	* @Method 	 : appPopulerCityByStateAPI.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 
	* @param 	 : NA
	* @return Get All Cities in Json Format
	**/
	public function appPopulerCityByStateAPI($myArrayData=null, &$message='')
	{	
		extract($myArrayData);		
        $stateId    = isset($state_id)  	?  strtolower($state_id)  	: '';

		$cities = $this->find("all", array(           
              'conditions'=>array('City.state_id'=>$stateId,
              'City.is_popular'=> 0),
              'order' => array(
                    'City.city' => 'ASC')
        ));           
		if (!empty($cities)) {
			
			foreach($cities as $city)
			{				
				$arrayData['id']=$city['City']['id'];
				$arrayData['state_id']=$city['City']['state_id'];				
				$arrayData['city']=$city['City']['city'];
				$returnData[]=$arrayData;
			}
			$message = 'Successfully';
			return $returnData;

		}else{

			$message = 'no record found for state';
            return false;
		}	
	}





}
