<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail','Network/Email');
App::uses('Security','Utility');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('User','State', 'City');
	public $components = array('Paginator', 'Session', 'Flash','Qimage');

	public function beforeFilter()
	{
		parent::beforeFilter();
		// Allow users to perform these task without login.
		$this->Auth->allow('login','logout');//,'add'
	}



/**
* @Function :login method
* @Date		: 26 Oct 2017 
* @param	string $email
* @param	string $password
* @return	on success redirect user to Admin dashboard, set error message if invalid credentials or user does not exist.
*/

	public function login()
	{			
		//Set Admin Layout		
		$this->layout='login';	 	
		if ($this->request->is('post')) 
		{					
			if ($this->Auth->login()) 
			{	
				if ($this->Auth->user('role') == 'admin') {
					
					return $this->redirect($this->Auth->redirectUrl());					
				}
				else {

					$this->Session->setFlash('Username or password is incorrect. Please try again later');
					$this -> redirect(array('controller' => 'users', 'action' => 'login'));					
				}

			
				//return $this->redirect($this->Auth->redirectUrl());							

			}else{

				$this->Session->setFlash('Username or password is incorrect. Please try again later');
				$this -> redirect(array('controller' => 'users', 'action' => 'login'));
			}
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->layout = 'admin';
		$this->User->recursive = 0;
		$this->Paginator->settings = array(
            'conditions'=>array(
                'User.role !='=>'admin'),
                'limit'=>10,
                'order' => array(
                    'User.id' => 'desc')
                );                
        $this->set('users', $this->Paginator->paginate('User'));       
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$states = $this->User->State->find('list');
		$cities = $this->User->City->find('list');
		//$roles = $this->User->Role->find('list');
		$this->set(compact('states', 'cities'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$states = $this->User->State->find('list');
		$cities = $this->User->City->find('list');
		$this->set(compact('states', 'cities'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {

		$requestArgs = $this->request->data;
		$this->layout = 'admin';
		if(empty($requestArgs)){
					
			$this->User->recursive = 0;
			$this->Paginator->settings = array(
		        'conditions'=>array(
		            'User.role !='=>'admin'),
		            'limit'=>10,
		            'order' => array(
		                'User.id' => 'desc')
		            );                
		    $this->set('users', $this->Paginator->paginate('User'));

		}else{

			$this->User->recursive = 0;
			$this->Paginator->settings = array(
	            'conditions'=>array(
	                				'User.role !='=>'admin', 
	                				'OR'=> array('User.name LIKE' => '%'.trim($requestArgs['User']['search']).'%', 
	                				'User.email LIKE' => '%'.trim($requestArgs['User']['search']).'%')
	                			),
	                'limit'=>10,
	                'order' => array(
	                    'User.id' => 'desc')
	                );                
			$this->set('users', $this->Paginator->paginate('User')); 
		}	

	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'admin';
		if ($this->request->is('post')) {	
			//set all comming data into myarray variable
			$myArray =  $this->request->data;
			$myArray['User']['name'] = trim($myArray['User']['name']);
			$myArray['User']['password'] = trim($myArray['User']['password']);
			$myArray['User']['email'] = trim($myArray['User']['email']);
			$myArray['User']['profileimg'] = '';
			if(!empty($this->data['User']['profileimg']['name']))
			{
				//Get full image information basename,extention,size
				$imagename=$this->data['User']['profileimg']['name'];
				$file=basename($imagename);
				$ext=pathinfo($file,PATHINFO_EXTENSION);
				$file_temp_name= $this->data['User']['profileimg']['tmp_name'];
				$sizeimage = getimagesize($file_temp_name);
				$new_file_name = time().'.'.$ext;
				//Upload image into the dir and comprised with Qimage component
				if(move_uploaded_file($file_temp_name, WWW_ROOT.'uploads/profile_image/big/'.$new_file_name))
				{ 
				//Comprised image 
				$this->Qimage->resize(array('height' => 100, 'width' => 130, 'file' => WWW_ROOT. '/uploads/profile_image/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/profile_image/thumb/'));
				}

				//set new image name
				$myArray['User']['profileimg'] = $new_file_name; 			
			}		

			//echo "<pre>";print_r($myArray);die;
			$this->User->create();
			if ($this->User->save($myArray)) {
				$this->Flash->success(__('The user has been saved.'));
				
				//$this->Session->setFlash(__('The user has been saved'));

				return $this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The user could not be saved. Please, try again'));
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$states = $this->State->find('list',array('fields'=>array('State.id','State.name')));
		//$this->set('countries', $countries);
		//$states = $this->User->State->find('list');
		//$cities = $this->User->City->find('list');
		$this->set(compact('states', 'cities'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {

		$this->layout = 'admin';
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		
		//Find User details by ID
		$userDetails = $this->User->findById($id);		
		if(!$userDetails)
		{
			$this->Flash->error(__('no record found for this user. Please, try again.'));

		}
		if ($this->request->is(array('post', 'put'))) 
		{

			//set all comming data into myarray variable
			$myArray =  $this->request->data;

			//echo "<pre>";print_r($myArray);die;
			//set article id into myarray      
			$myArray['User']['id']=$id;
			if(!empty($this->data['User']['profileimg']['name']))
			{
				//Get full image information basename,extention,size
				$imagename=$this->data['User']['profileimg']['name'];
				$file=basename($imagename);
				$ext=pathinfo($file,PATHINFO_EXTENSION);
				$file_temp_name= $this->data['User']['profileimg']['tmp_name'];
				$sizeimage = getimagesize($file_temp_name);
				$new_file_name = time().'.'.$ext;

				//Remove old image if exist
				unlink( WWW_ROOT . 'uploads/profile_image/big/' . $userDetails['User']['profileimg']);
				unlink( WWW_ROOT . 'uploads/profile_image/thumb/' . $userDetails['User']['profileimg']);

				//Upload image into the dir and comprised with Qimage component
				if(move_uploaded_file($file_temp_name, WWW_ROOT.'uploads/profile_image/big/'.$new_file_name))
				{ 
				//Comprised image 
				$this->Qimage->resize(array('height' => 100, 'width' => 130, 'file' => WWW_ROOT. '/uploads/profile_image/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/profile_image/thumb/'));
				}
				//set new image name
				$myArray['User']['profileimg'] = $new_file_name; 

			}else{
				//if image not comming then remain old image in db
				$myArray['User']['profileimg']= $userDetails['User']['profileimg'];

			}			
			if ($this->User->save($myArray)) {
				$this->Session->setFlash('The user has been saved');
			} else {				
				$this->Session->setFlash('The user could not be saved. Please, try again');
			}
			return $this->redirect(array('action' => 'index'));

		}else{

			$this->request->data = $userDetails;
		}
		$states = $this->User->State->find('list');
		$cities = $this->User->City->find('list');
		$this->set(compact('states', 'cities'));		
		//echo "<pre>";print_r($userDetails);die;
		/*if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}*/
	}

	/**
    * @Function :admin_changePassword method
    * @Developer: Rafi Ahmad
    * @Date:
    * 
    * @return   Admin Change Password function.
    */

    public function admin_changePassword()
	{
		
    	$this->layout = 'admin';
    	
    	if ($this->request->is(array('post', 'put'))) 
		{
			$myarray =  $this->request->data;
			$Id=$this->Session->read('Auth.User.id');
			$currentPassword=$myarray['User']['password'];
			
			//Set the simplePasswordHasher for compair the password
			$hasher = new SimplePasswordHasher();

			//Check if current password not match
			if (!$this->User->hasAny(array('User.id' => $Id, 'User.password'=>$hasher->hash($currentPassword)))) 
			{
                $this->Session->setFlash('Invalid current password. Please enter a correct password.'); 
                 return $this->redirect(array('action' => 'changePassword'));

            }
			//Find the user details and set new password into the table
			$user = $this->User->findById($Id);                 
			$user["User"]["password"] = $myarray['User']['new_password'];
			if ($this->User->save($user)) 
			{
				$this->Session->setFlash('Your password has been successfully updated'); 
				return $this->redirect(array('action' => 'changePassword'));
			}else{
				$this->Session->setFlash('Failed to update password. Please try again'); 
				return $this->redirect(array('action' => 'changePassword'));
			}         
			
		}//End post method
	}//end change_password  


/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		
		$this->User->id = $id;		
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		//$this->request->allowMethod('post', 'delete');
		//Check if id not empty
		if(!empty($id))
		{			
			//Get User details by ID
			$imageDetails=$this->User->findById($id);
			
			//get user image 
			$file_name = $imageDetails['User']['profileimg'];

			//Get Full image path 
			$file_full = WWW_ROOT.'uploads/profile_image/big/';
			$file_thumb = WWW_ROOT.'uploads/profile_image/thumb/';
			
			if($this->User->delete($id))
			{
				if(!empty($file_name))
				{	
					//Remove old image form Dir
					unlink($file_full . $file_name);
					unlink($file_thumb . $file_name);
					
				}
				
				$this->Session->setFlash(__('The User has been Deleted.'));	

			}else{

				$this->Session->setFlash('The user could not be deleted. Please, try again');

			}
			return $this->redirect(array('action' => 'index'));

		}
		/*if ($this->User->delete()) {
			$this->Session->setFlash('The user has been deleted.');
			//$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash('The user could not be deleted. Please, try again');
			//$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
	return $this->redirect(array('action' => 'index'));*/
	}


	/**
	* @Function :logout method
	* @Date: 26 Oct 2017 
	* 
	* @return	Admin logout.
	*/

	public function logout() 
	{				
		return $this->redirect($this->Auth->logout());
	}

	/*
	Get All City basis on states with ajex responce
	*/
	public function admin_getCities() {		
		$cities = array();
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

	 /*#---------------------------------
    # @WebPageFunction: change_status
    # @Developer : Rafi Rizvi
    # @return updated status
    # @param
    #-------------------------------*/
    public function admin_change_status()
    {
    	pr($this->request->data); exit;
    	// pr($this->request->data); exit;
        //echo 'Abcd Vipul Srivastava';die;
    }


}
