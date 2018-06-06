<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Job $Job
 */
class Category extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
 public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		));
	
	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'category_id',
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
	* @Method 	 : appGetCategories.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 31_Oct_2017
	* @param 	 : NA
	* @return Get All Categories in Json Format
	**/
	public function appGetCategories($myArrayData=null, &$message='')
	{	
		$categories = $this->find("all", array(
			'conditions'=>array('status'=>0),
              'recursive'=>0,
              'order' => array(
                    'name' => 'ASC')
        ));
		if (!empty($categories)) {
			
			foreach($categories as $cat)
			{
				$arrayData['id']					 =$cat['Category']['id'];
				$arrayData['name']					 =$cat['Category']['name'];
				$arrayData['thumb']            = $this->fullurl($cat['Category']['catimage'], "uploads/category/thumb/");
				$arrayData['full']             = $this->fullurl($cat['Category']['catimage'], "uploads/category/big/");

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
