<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property PaymentOption  $PaymentOption
 * @property PaginatorComponent $Paginator
 */
class PaymentOptionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash','Qimage');

/**
 * index method
 *
 * @return void
 */
	/*public function index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->Paginator->paginate());
	}*/

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*public function view($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
	}*/

/**
 * add method
 *
 * @return void
 */
	/*public function add() {
		if ($this->request->is('post')) {	
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The category could not be saved. Please, try again.'));
			}
		}
	}*/

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*public function edit($id = null) {
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
		}
	}*/

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*public function delete($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Category->delete()) {
			$this->Flash->success(__('The category has been deleted.'));
		} else {
			$this->Flash->error(__('The category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}*/

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		//echo '111';die;
		$this->layout = 'admin';
		$this->set('title_for_layout', 'Moti Potli - Payment Options List');
		$this->PaymentOption->recursive = 0;
		$this->set('paymentoption', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*public function admin_view($id = null) {
		$this->layout = 'admin';
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
	}*/

/**
 * admin_add method
 *
 * @return void
 */
	/*public function admin_add() {
		$this->layout = 'admin';
		if ($this->request->is('post')) {
			$myArray =  $this->request->data;
			$myArray['Category']['name'] = trim($myArray['Category']['name']);			
			$myArray['Category']['catimage'] = '';
			$myArray['Category']['status'] ='0';

			if(!empty($this->data['Category']['catimage']['name']))
			{
				//Get full image information basename,extention,size
				$imagename=$this->data['Category']['catimage']['name'];
				$file=basename($imagename);
				$ext=pathinfo($file,PATHINFO_EXTENSION);
				$file_temp_name= $this->data['Category']['catimage']['tmp_name'];
				$sizeimage = getimagesize($file_temp_name);
				$new_file_name = time().'.'.$ext;
				//Upload image into the dir and comprised with Qimage component
				if(move_uploaded_file($file_temp_name, WWW_ROOT.'uploads/category/big/'.$new_file_name))
				{ 
				//Comprised image 
				$this->Qimage->resize(array('height' => 73, 'width' => 73, 'file' => WWW_ROOT. '/uploads/category/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/category/thumb/'));
				}

				//set new image name
				$myArray['Category']['catimage'] = $new_file_name; 			
			}
			//echo "<pre>";print_r($myArray);die;
			//$this->Category->create();
			if ($this->Category->save($myArray)) {
				$this->Flash->success(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The category could not be saved. Please, try again.'));
			}
		}
	}*/

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*public function admin_edit($id = null) {
		$this->layout = 'admin';
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$categoryDetails = $this->Category->findById($id);		

		if ($this->request->is(array('post', 'put'))) {
			//set all comming data into myarray variable
			$myArray =  $this->request->data;	
			$myArray['Category']['id']=$id;
			if(!empty($this->data['Category']['catimage']['name']))
			{
				//Get full image information basename,extention,size
				$imagename=$this->data['Category']['catimage']['name'];
				$file=basename($imagename);
				$ext=pathinfo($file,PATHINFO_EXTENSION);
				$file_temp_name= $this->data['Category']['catimage']['tmp_name'];
				$sizeimage = getimagesize($file_temp_name);
				$new_file_name = time().'.'.$ext;

				//Remove old image if exist
				if(!empty($categoryDetails['Category']['catimage']))
				{
					unlink( WWW_ROOT . 'uploads/category/big/' . $categoryDetails['Category']['catimage']);
					unlink( WWW_ROOT . 'uploads/category/thumb/' . $categoryDetails['Category']['catimage']);
				}
				//Upload image into the dir and comprised with Qimage component
				if(move_uploaded_file($file_temp_name, WWW_ROOT.'uploads/category/big/'.$new_file_name))
				{ 
				//Comprised image 
				$this->Qimage->resize(array('height' => 73, 'width' => 73, 'file' => WWW_ROOT. '/uploads/category/big/'.$new_file_name.'', 'output' => WWW_ROOT. 'uploads/category/thumb/'));
				}
				//set new image name
				$myArray['Category']['catimage'] = $new_file_name; 

			}else{
				//if image not comming then remain old image in db
				$myArray['Category']['catimage']= $categoryDetails['Category']['catimage'];

			}

			if ($this->Category->save($myArray)) {

				$this->Flash->success(__('The category has been saved.'));
				//$this->Session->setFlash('The category has been saved');
			} else {				

				$this->Flash->error(__('The category could not be saved. Please, try again.'));
				//$this->Session->setFlash('The category could not be saved. Please, try again');
			}
			return $this->redirect(array('action' => 'index'));
		}else{

			$this->request->data = $categoryDetails;
		}
		$this->set(compact('categoryDetails'));		
	}*/

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	/*public function admin_delete($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		if(!empty($id))
		{			
			//Get User details by ID
			$categoryDetails=$this->Category->findById($id);
			
			//get user image 
			$file_name = $categoryDetails['Category']['catimage'];

			//Get Full image path 
			$file_full = WWW_ROOT.'uploads/category/big/';
			$file_thumb = WWW_ROOT.'uploads/category/thumb/';
			
			if($this->Category->delete($id))
			{
				if(!empty($file_name))
				{	
					//Remove old image form Dir
					unlink($file_full . $file_name);
					unlink($file_thumb . $file_name);
					
				}
				$this->Flash->success(__('The category has been deleted.'));
				//$this->Session->setFlash(__('The Category has been Deleted.'));	

			}else{

				$this->Flash->error(__('The category could not be deleted. Please, try again.'));
				//$this->Session->setFlash('The Category could not be deleted. Please, try again');
			}
			return $this->redirect(array('action' => 'index'));

		}
	
	}*/
	
	/**
	* @access public
	* @Method 	 : admin_category_status.
	* @Developer : Rafi (Evon Technologies)
	* @Date      : 01_Oct_2017
	* @param 	 : NA
	* @return 	 :Change category status from admin panel 
	**/

	/*public function admin_category_status()
	{
		if(!$this->request->is('AJAX'))
		{
			return $this->redirect(array('admin'=>true,'controller'=>'categories', 'action'=>'admin_index'));
		}			
        $data=array();
        $data['Category']['id'] =$this->request->data['cat_id'];
        $data['Category']['status'] =$this->request->data['status'];
        if(!$this->Category->save($data))
        {
            echo json_encode(array('status'=>'failure', 'message'=>'Unable to update status at the moment.'));
            die;
        }   
        echo json_encode(array('status'=>'success', 'message'=>'Status updated.'));
        die;
	}*/

//status change function
public function cat_change_status()
    {
    	//echo Router::url('/', true); die;
        $userStatus = $this->request->data;
        //echo "<pre>";print_r($userStatus);die;
         $this->loadModel('PaymentOption');
     
        //echo '<pre>'; print_r($userStatus); 
        $action = $userStatus['action'];
        $userid = $userStatus['userid'];
       if($action=='Approved'){
			$userval = 1;
		}else if($useraction=='Disapproved'){
			$userval = 0;
		}
		$userArr = array();
		$userArr['PaymentOption']['id'] = $userid;
		$userArr['PaymentOption']['status'] = $userval;
		
		//$this->User->id = $userid;
		//$this->Category->save($userArr);
	 	if($this->PaymentOption->save($userArr)){
	 	
	 		echo 'success'; die;

	 	}else{
	 		
	 		echo 'failure';die;
	 	}
     
    }




}
