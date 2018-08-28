<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   load all models and libraries and manage user functionality
     * @params          :
     * @return          :   
     */
	public $userData = array();
	
	public function __construct() {
	    parent::__construct();
	    $this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('common_model');
	    $this->load->model('users_model');
		$this->load->model('emails_model');
		$this->load->model('orders_model');
		$this->load->model('customers_model');
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->helper('captcha');
		$this->load->helper('global');
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   26-08-2018 (dd-mm-yyyy)
     * @purpose         :   load customers page
     * @params          :
     * @return          :   
     */
	public function index(){
		if($this->session->userdata('user_name')){
				$data['userData'] = $this->session->userdata();	
				$data['allCustomers'] = $this->customers_model->getAllCustomers();
				$this->load->view('common/header.php',$data);
				$this->load->view('customers/customerView.php',$data);
				$this->load->view('common/footer.php',$data);
			}else{
				redirect('/');
			}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :   delete customers page
     * @params          :   cust_id
     * @return          :   
     */
	public function deleteCustomer($customerID = ''){
		if($this->session->userdata('user_name')){
				if($customerID != ''){
					$this->customers_model->deleteCustomer($customerID);
					die();
				}else{
					redirect('customers');
				}
				
			}else{
				redirect('/');
			}
	}


	/**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :   update customers status
     * @params          :   cust_id
     * @return          :   
     */
	public function updateStatus($customerID = ''){
		if($this->session->userdata('user_name')){
				if($customerID != ''){
					//echo "<pre>"; print_r($this->input->post());
					$this->customers_model->updateCustomer($customerID,$this->input->post('type'));
					die();
				}else{
					redirect('customers');
				}
				
			}else{
				redirect('/');
			}
	}
}
