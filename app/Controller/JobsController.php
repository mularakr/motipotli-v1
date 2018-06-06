<?php
App::uses('AppController', 'Controller');
/**
 * Jobs Controller
 *
 * @property Job $Job
 * @property PaginatorComponent $Paginator
 */
class JobsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash','Qimage');

	//public $uses = array('State', 'City');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Job->recursive = 0;
		$this->set('jobs', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Job->exists($id)) {
			throw new NotFoundException(__('Invalid job'));
		}
		$options = array('conditions' => array('Job.' . $this->Job->primaryKey => $id));
		$this->set('job', $this->Job->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Job->create();
			if ($this->Job->save($this->request->data)) {
				return $this->flash(__('The job has been saved.'), array('action' => 'index'));
			}
		}
		$categories = $this->Job->Category->find('list');
		$users = $this->Job->User->find('list');
		$this->set(compact('categories', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Job->exists($id)) {
			throw new NotFoundException(__('Invalid job'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Job->save($this->request->data)) {
				return $this->flash(__('The job has been saved.'), array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('Job.' . $this->Job->primaryKey => $id));
			$this->request->data = $this->Job->find('first', $options);
		}
		$categories = $this->Job->Category->find('list');
		$users = $this->Job->User->find('list');
		$this->set(compact('categories', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Invalid job'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Job->delete()) {
			return $this->flash(__('The job has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The job could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$requestArgs = $this->request->data;
		$this->layout = 'admin';
		$this->set('title_for_layout', 'Moti Potli - Job List');
		$this->Job->recursive = 0;
		if(empty($requestArgs)){
			$this->set('jobs', $this->Paginator->paginate());
		}else{ 
			$this->Paginator->settings = array(
	            'conditions'=>array(
	                'Job.title LIKE' => '%'.trim($requestArgs['Job']['search']).'%'),
	                'limit'=>10
	                );                
			$this->set('jobs', $this->Paginator->paginate());
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
		$this->set('title_for_layout', 'Moti Potli - View Job Details');
		if (!$this->Job->exists($id)) {
			throw new NotFoundException(__('Invalid job'));
		}
		$this->loadModel('State');
		$this->loadModel('City');
		$jobDetails=$this->Job->findById($id);				
		$states = $this->State->find('list');
		$cities = $this->City->find('list');
		$this->set(compact('jobDetails','states','cities'));
		//echo "<pre>";print_r($options);die;
		//$options = array('conditions' => array('Job.' . $this->Job->primaryKey => $id));
		//$this->set('job', $this->Job->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'admin';
		$this->set('title_for_layout', 'Moti Potli - Add Job');
		if ($this->request->is('post')) {
			//echo "<pre>";print_r($this->request->data);die;
			$this->Job->create();
			if ($this->Job->save($this->request->data)) {
				
				$this->Flash->success(__('The job has been saved.'));
				return $this->redirect(array('action' => 'index'));
			}
		}
		$this->loadModel('State');
		$this->loadModel('City');
		$categories = $this->Job->Category->find('list');
		$users = $this->Job->User->find('list');
		$states = $this->State->find('list');
		$cities = $this->City->find('list');
		$this->set(compact('categories', 'users','states','cities'));
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
		$this->set('title_for_layout', 'Moti Potli - Edit Job Details');

		if (!$this->Job->exists($id)) {
			throw new NotFoundException(__('Invalid job'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Job']['id']=$id;			
			if ($this->Job->save($this->request->data)) {
				$this->Flash->success(__('The job has been saved.'));
				//return $this->flash(__('The job has been saved.'), array('admin'=>true,'action' => 'index'));
			}else{
				$this->Flash->success(__('The job could not be saved. Please, try again'));
			}
			return $this->redirect(array('action' => 'index'));
		} else {
			$options = array('conditions' => array('Job.' . $this->Job->primaryKey => $id));
			$this->request->data = $this->Job->find('first', $options);
		}
		$this->loadModel('State');
		$this->loadModel('City');
		$categories = $this->Job->Category->find('list');
		$users = $this->Job->User->find('list');
		$states = $this->State->find('list');
		$cities = $this->City->find('list');
		$this->set(compact('categories', 'users','states','cities'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Invalid job'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Job->delete()) {
			return $this->flash(__('The job has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The job could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}
}
