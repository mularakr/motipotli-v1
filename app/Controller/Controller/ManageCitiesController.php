<?php
App::uses('AppController', 'Controller');
/**
 * ManageCities Controller
 *
 * @property Cities $Cities,State $State
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ManageCitiesController extends AppController {

/**
 * Components
 *
 * @var array
 */	
	public $components = array('Paginator', 'Session', 'Email','Flash','Qimage');

/**
 * admin_index method
 *
 * @return void
 */

	public function admin_index($stateId = null) {
		$this->layout = 'admin';
		$this->set('title_for_layout', 'Moti Potli - Manage Cities');
		$this->loadModel('State');		
		$states = $this->State->find('list');	
		$this->set(compact('states'));		
		if($stateId)
		{			
			$cities = array();
			$this->loadModel('City');				
			/*$cities = $this->City->find('all', array(
				'fields' => array(
					'id',
					'city',
					'is_popular',
				),
				'recursive'=>-1,
				'conditions' => array(
					'City.state_id' => $stateId
				)
			));			
			$this->set('cities',$cities);			*/
			 $this->Paginator->settings = array(
			 	'recursive'=>-1,
		        'conditions' => array('City.state_id' => $stateId),
		        'limit' => 20
		    );
		    $data = $this->Paginator->paginate('City');
		    $this->set('cities',$data);
		    $this->set(compact('stateId'));

			//echo "<pre>";print_r($data);die;

		}
		
	}
	
	/*
	Get All City basis on states with ajex responce
	*/
	public function admin_getCities() {		
		$cities = array();
		$this->loadModel('City');	
		if (isset($this->request['data']['id'])) {
			$cities = $this->City->find('list', array(
				'fields' => array(
					'id',
					'city',
				),
				'conditions' => array(
					'City.state_id' => $this->request['data']['id']
				)
			));
		}
		header('Content-Type: application/json');
		echo json_encode($cities);
		exit();
	}


public function admin_changeCityStatus()
	{
		$this->loadModel('City');	
		if(!$this->request->is('AJAX'))
		{
			return $this->redirect(array('admin'=>true,'controller'=>'manageCities', 'action'=>'admin_index'));
		}			
        $data=array();       
         //echo "<pre>";print_r($this->request->data);die;    
       	$status=$this->request->data['status'];              
        if($status == 'true')
        {
        	$data['City']['id']=$this->request->data['id'];
        	$data['City']['is_popular']='0';

        }else{

        	$data['City']['id']=$this->request->data['id'];
        	$data['City']['is_popular']='1';

        }           
        if(!$this->City->save($data))
        {
            echo json_encode(array('status'=>'failure', 'message'=>'Unable to update status at the moment.'));
            die;
        }   
        echo json_encode(array('status'=>'success', 'message'=>'Status updated.'));
        die;
	}



public function ajaxemail() {  
	 
	 	 $this->layout=null;
		 $this->loadModel('User');
		 $profilearr=$this->User->find('first',array('conditions'=>array('email'=>$_REQUEST['data']['User']['email'])));
		 if(count($profilearr) >0){
		 	echo "false";exit;
		 }else{
		 echo "true";exit;
		 }
	 
	 }

//status change function
/*public function change_status()
    {
    	//echo Router::url('/', true); die;
        $userStatus = $this->request->data;
         $this->loadModel('User');
     
        //echo '<pre>'; print_r($userStatus); 
        $action = $userStatus['action'];
        $userid = $userStatus['userid'];
       if($action=='Approved'){
			$userval = 1;
		}else if($useraction=='Disapproved'){
			$userval = 0;
		}
		$userArr = array();
		$userArr['User']['id'] = $userid;
		$userArr['User']['status'] = $userval;
		//echo "<pre>";
		//print_r($userArr);
		//$this->User->id = $userid;
	 	if($this->User->save($userArr)){
	 	//print_r($this->User); die;
	 	echo 'success'; die;
	 	}else{
	 		echo 'failure';die;
	 	}
     
    }*/


}
