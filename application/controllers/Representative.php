<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Representative extends CI_Controller {
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
		$this->load->model('representative_model');
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->helper('captcha');
		$this->load->helper('global');
		$this->load->helper('security');
		$this->load->library('email');
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
				$data['allCsr'] = $this->representative_model->getAllCSR();
				$this->load->view('common/header.php',$data);
				$this->load->view('representative/representativeView.php',$data);
				$this->load->view('common/footer.php',$data);
			}else{
				redirect('/');
			}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :   load customers add view
     * @params          :   cust_id
     * @return          :   
     */
	public function add(){
		if($this->session->userdata('user_name')){
			$data['userData'] = $this->session->userdata();
			if($this->input->post()){
				

/*$this->email->from('liveopensource88@gmail.com', 'Rajesh Thakur');
$this->email->to('rajesh32426@gmail.com');
$this->email->cc('yitu7890@gmail.com');
$this->email->subject('Email Test');
$this->email->message('Hello Yittu kya hal chal hai.');

$this->email->send();
die('send');*/
				$this->form_validation->set_rules('user_name', 'user name', 'trim|required',
						array('required' => 'Please enter %s.')
				);
                $this->form_validation->set_rules('user_fname', 'first name', 'trim|required',
                        array('required' => 'Please enter %s.')
				);
				$this->form_validation->set_rules('user_lname', 'last name', 'trim|required',
                        array('required' => 'Please enter %s.')
				);
				
				$this->form_validation->set_rules('user_email', 'email address', 'trim|required|valid_email|is_unique[nrf_users.user_email]',
						array(
							'required' => 'Please enter %s.',
							'valid_email' => 'Please enter valid email address.',
							'is_unique' => 'The %s is already taken',
						)
				);
				$this->form_validation->set_rules('csrm_rate', ' rate per page', 'trim|required|numeric[12]',
						array('required' => 'Please enter %s.','numeric' => 'The %s should be number.')
				);
				$this->form_validation->set_rules('csrm_zip', 'ZIP/PIN', 'numeric[12]',
						array('required' => 'Please enter %s.','numeric' => 'The ZIP/PIN should be number.')
				);
				$this->form_validation->set_rules('user_phone', ' phone number', 'trim|required|max_length[12]',
						array('required' => 'Please enter %s.','max_length' => 'The lenght of phone number should be less then or equal to 12.')
				);
				$this->form_validation->set_rules('csrm_country', 'country', 'trim|required',
						 array('required' => 'Please select %s.')
				);

                if ($this->form_validation->run() == TRUE) {
					//echo "<pre>"; print_r($this->input->post());
				//die('here');
                	//$this->representative_model->addCustomer($this->input->post());
                	$this->session->set_flashdata('successMsg', ' Customer added successfully.');
                			redirect('representative/add');
                } 
			}
			$data['countries'] = $this->common_model->getCountries();
			$this->load->view('common/header.php',$data);
			$this->load->view('representative/add_representativeView.php',$data);
			$this->load->view('common/footer.php',$data);
		}else{
			redirect('/');
		}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :   check customer email if exist
     * @params          :   email
     * @return          :   
     */
	function check_user_email($email) {      
		$current_email = $this->session->userdata('user_email') ; 
	    if( $email == "" || $email == $current_email){
	    	return TRUE;
	    }else{
			$userCount = $this->users_model->check_unique_user_email($email);
			if($userCount > 0){
				$this->form_validation->set_message('check_user_email', 'The email address is already taken.');
				return  FALSE;
			}else{
				return TRUE;
			}
	    }
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :   edit customer 
     * @params          :   cust_id
     * @return          :   
     */
	public function edit($customerId = ""){
		if($this->session->userdata('user_name')){
			if($customerId == ""){
				redirect('customers');
			}
			$data['userData'] = $this->session->userdata();
			if($this->input->post()){
				$this->form_validation->set_rules('cust_name', 'name', 'trim|required',
						array('required' => 'Please enter %s.')
				);
                $this->form_validation->set_rules('cust_comp', 'company name', 'trim|required',
                        array('required' => 'Please enter %s.')
				);
				$this->form_validation->set_rules('cust_email', 'email address', 'trim|required|valid_email',
						array(
							'required' => 'Please enter %s.',
							'valid_email' => 'Please enter valid email address.'
						)
				);
				$this->form_validation->set_rules('cust_email', 'email address', 'callback_check_user_email['.$this->input->post('cust_email').'|| '.$this->input->post('customer_id').']');

				$this->form_validation->set_rules('cust_zip', ' ZIP', 'numeric[12]',
						array('required' => 'Please enter %s.','numeric' => 'The ZIP/PIN should be number.')
				);
				$this->form_validation->set_rules('cust_phone', ' phone number', 'max_length[12]',
						array('required' => 'Please enter %s.','max_length' => 'The lenght of phone number should be less then or equal to 12.')
				);
				$this->form_validation->set_rules('cust_country', 'country', 'trim|required',
						 array('required' => 'Please select %s.')
				);


                if ($this->form_validation->run() == TRUE) {
                	$this->representative_model->updateCustomerData($customerId,$this->input->post());
                	$this->session->set_flashdata('successMsg', ' Customer updated successfully.');
                	redirect('customers/');
                } 
			}
			$data['countries'] = $this->common_model->getCountries();
			$data['customer_details'] = $this->representative_model->getCustomerById($customerId);
			$this->load->view('common/header.php',$data);
			$this->load->view('customers/edit_customerView.php',$data);
			$this->load->view('common/footer.php',$data);
		}else{
			redirect('/');
		}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :   delete user from users and csr tables
     * @params          :   user_id
     * @return          :   
     */
	public function deleteUser($userId = ''){
		if($this->session->userdata('user_name')){
				if($userId != ''){
					$this->representative_model->deleteUser($userId);
					die();
				}else{
					redirect('representative');
				}
				
			}else{
				redirect('/');
			}
	}


	/**
     * @developer       :   Dinesh
     * @created date    :   04-09-2018 (dd-mm-yyyy)
     * @purpose         :   update user status
     * @params          :   user_id
     * @return          :   
     */
	public function updateStatus($userID = ''){
		if($this->session->userdata('user_name')){
				if($userID != ''){
					$this->representative_model->updateUserStatus($userID,$this->input->post('type'));
					die();
				}else{
					redirect('representative');
				}
				
			}else{
				redirect('/');
			}
	}
}
