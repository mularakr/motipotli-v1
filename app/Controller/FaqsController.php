<?php
App::uses('AppController', 'Controller');
/**
 * Faqs Controller
 *
 * @property Category $Faq
 * @property PaginatorComponent $Paginator
 */
class FaqsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->layout = 'admin';
		$this->set('title_for_layout', 'Moti Potli - Faq List');
		$this->Faq->recursive = 0;
		$this->set('faq', $this->Paginator->paginate());
	}

	/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		$this->layout = 'admin';
		if ($this->request->is('post')) {
			//echo '<pre>'; print_r($this->request->data);
			$this->Faq->create();
			if ($this->Faq->save($this->request->data)) {
				$this->Flash->success(__('The Faq has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The Faq could not be saved. Please, try again.'));
			}	
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
		if (!$this->Faq->exists($id)) {
			throw new NotFoundException(__('Invalid faq'));
		}
		$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
		$this->set('faq', $this->Faq->find('first', $options));
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
		if (!$this->Faq->exists($id)) {
			throw new NotFoundException(__('Invalid faq'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Faq']['id']=$id;
			if ($this->Faq->save($this->request->data)) {
				$this->Flash->success(__('The faq has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The Faq could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Faq.' . $this->Faq->primaryKey => $id));
			$this->request->data = $this->Faq->find('first', $options);
		}
	}

	/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Faq->id = $id;		
		if (!$this->Faq->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		//Check if id not empty
		if(!empty($id))
		{
			if($this->Faq->delete($id))
			{
				$this->Session->setFlash(__('The Faq has been Deleted.'));	

			}else{
				$this->Session->setFlash('The Faq could not be deleted. Please, try again');
			}
			return $this->redirect(array('action' => 'index'));
		}
	}
}