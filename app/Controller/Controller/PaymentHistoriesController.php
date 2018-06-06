<?php
App::uses('AppController', 'Controller');
/**
 * PaymentHistories Controller
 *
 * @property PaymentHistories  $PaymentHistories
 * @property PaginatorComponent $Paginator
 */
class PaymentHistoriesController extends AppController {

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
		//echo '111';die;
		$this->layout = 'admin';
		$this->set('title_for_layout', 'Moti Potli - Payment Histories List');	
		$paydetails=$this->PaymentHistory->getPaymentDetailsForAdmin();			
		$this->set('mydetails', $paydetails);		
	}



}
