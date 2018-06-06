<?php
App::uses('AppController', 'Controller');
/**
 * Managelists Controller
 *
 * @property Category $Faq
 * @property PaginatorComponent $Paginator
 */
class ManagelistsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');
	//public $helpers = array('Editor');

/**
 * index method
 *
 * @return void
 */
	public function admin_list() {
		$this->layout = 'admin';
		$this->set('title_for_layout', 'Moti Potli - Manage Content List');		
		$this->Managelist->recursive = 0;
		$this->set('managelists', $this->Paginator->paginate());
		
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
		if (!$this->Managelist->exists($id)) {
			throw new NotFoundException(__('Invalid Content'));
		}		
		if ($this->request->is(array('post', 'put'))) {		
			if ($this->Managelist->save($this->request->data)) {
				$this->Flash->success(__('The Content has been saved.'));
				return $this->redirect(array('action' => 'list'));
			} else {
				$this->Flash->error(__('The content could not be saved. Please, try again.'));
			}
		} else {

			$options = array('conditions' => array('Managelist.' . $this->Managelist->primaryKey => $id));
			$this->request->data = $this->Managelist->find('first', $options);			
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
		if (!$this->Managelist->exists($id)) {
			throw new NotFoundException(__('Invalid id'));
		}
		$options = array('conditions' => array('Managelist.' . $this->Managelist->primaryKey => $id));
		$this->set('managelists', $this->Managelist->find('first', $options));
	}



}