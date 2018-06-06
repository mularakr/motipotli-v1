<?php
App::uses('AppController', 'Controller');
/**
 * ContactQueries Controller
 *
 * @property ContactQueries  $ContactQueries
 * @property PaginatorComponent $Paginator
 */
class ContactQueriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash','Qimage');


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {	
		$this->layout = 'admin';
		$this->set('title_for_layout', 'Moti Potli - Contact Queries List');	
		$this->ContactQueries->recursive = 0;
		$this->set('myQueryDetails', $this->Paginator->paginate());

	}



}
