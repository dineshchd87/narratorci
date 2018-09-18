<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {
	/**
     * @developer       :   Dinesh
     * @created date    :   09-09-2018 (dd-mm-yyyy)
     * @purpose         :   manage payment settings
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
		$this->load->helper('security');
		$this->load->library("pagination");
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   26-08-2018 (dd-mm-yyyy)
     * @purpose         :   load payment page
     * @params          :
     * @return          :   
     */
	public function index(){
		if($this->session->userdata('user_name')){
				$data['userData'] = $this->session->userdata();	
				redirect('payments/view');
			}else{
				redirect('/');
			}
	}
	
	public function view(){
		if($this->session->userdata('user_name')){
				$data['userData'] = $this->session->userdata();	
				$config = array();
				$config["base_url"] = base_url() . "payments/view";
				$config["total_rows"] = $this->customers_model->getPaymentCount();
				$config["per_page"] = PER_PAGE_NUMBER;
				$config['num_links'] = 4;
				$config['uri_segment'] = 3;
				$config['use_page_numbers'] = TRUE;
				$config['page_query_string']  = TRUE;
				$config['reuse_query_string'] = TRUE;
				$config['attributes']=array('class' => 'page-link');
             
				$config['full_tag_open'] = '<ul class="pagination">';
				$config['full_tag_close'] = '</ul>';
				 
				$config['first_link'] = 'First Page';
				$config['first_tag_open'] = '<li class="page-item">';
				$config['first_tag_close'] = '</li">';
				 
				$config['last_link'] = 'Last Page';
				$config['last_tag_open'] = '<li class="page-item">';
				$config['last_tag_close'] =  '</li">';
				 
				$config['next_link'] = 'Next Page';
				$config['next_tag_open'] = '<li class="page-item">';
				$config['next_tag_close'] = '</li">';
	 
				$config['prev_link'] = 'Prev Page';
				$config['prev_tag_open'] = '<li class="page-item">';
				$config['prev_tag_close'] = '</li">';
	 
				$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
				$config['cur_tag_close'] = '</a></li">';
	 
				$config['num_tag_open'] = '<li class="page-item">';
				$config['num_tag_close'] = '</li">';
				$this->pagination->initialize($config);
				$data["total_rows"] = $config["total_rows"];
				
				/*$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				if($page == 0){
						$data['page'] = $page + 1;
						$data["per_page"] = $config["per_page"];
				}else{
					$data['page'] = $page + 1;
					$data["per_page"] = $page + $config["per_page"];
					if($data["per_page"] > $config["total_rows"]){
						$data["per_page"] = $config["total_rows"];
					}
				}*/
				
				if($this->input->get('page')){
					echo $start = ($this->input->get('page')) - 1;
					$data['page'] = $start + 1;
					$data["per_page"] = $start + $config["per_page"];
					if($data["per_page"] > $config["total_rows"]){
						$data["per_page"] = $config["total_rows"];
					}
				}
				else{
					$start = 0;
					
					$data['page'] = $start + 1;
					$data["per_page"] = $config["per_page"];
				}
				
				echo $config["per_page"].'===='. $start;
				
				$data["results"] = $this->customers_model->getPaymentList($config["per_page"], $start);
				$data["links"] = $this->pagination->create_links();
				//echo "<pre>"; print_r($data); die('here');
				$this->load->view('common/header.php',$data);
				$this->load->view('payments/paymentView.php',$data);
				$this->load->view('common/footer.php',$data);
			}else{
				redirect('/');
			}
		}


	/**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :   validate current password
     * @params          :   password
     * @return          :   
     */
	public function pword_check($password){                                 
	  $currentUserPassword = $this->session->userdata('user_pass');	
	  if( $password != "" && $password != $currentUserPassword){ 
	    $this->form_validation->set_message('pword_check', 'The %s does not exist in our database.');
	    return FALSE;
	  }
	  else{
	    return TRUE;
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
				
				$this->form_validation->set_rules('cust_name', 'name', 'trim|required',
						array('required' => 'Please enter %s.')
				);
                $this->form_validation->set_rules('cust_comp', 'company name', 'trim|required',
                        array('required' => 'Please enter %s.')
				);
				
				$this->form_validation->set_rules('cust_email', 'email address', 'trim|required|valid_email|is_unique[nrf_customers.cust_email]',
						array(
							'required' => 'Please enter %s.',
							'valid_email' => 'Please enter valid email address.',
							'is_unique' => 'The %s is already taken',
						)
				);
				$this->form_validation->set_rules('cust_zip', ' ZIP', 'numeric[12]',
						array('required' => 'Please enter %s.','numeric' => 'The ZIP/PIN should be number.')
				);
				$this->form_validation->set_rules('cust_phone', ' phone number', 'max_length[12]',
						array('required' => 'Please enter %s.','max_length' => 'The lenght of phone number should be less then or equal to 12.')
				);
				$this->form_validation->set_rules('cust_country', 'country', 'trim|required',
						 array('required' => 'Please select %s.')
				);

				$this->form_validation->set_rules('current_password', 'current password', 'trim|required|callback_pword_check[' . $this->input->post('current_password') . ']',
						array('required' => 'Please enter %s for validation.')
				);

                if ($this->form_validation->run() == TRUE) {
                	$this->customers_model->addCustomer($this->input->post());
                	$this->session->set_flashdata('successMsg', ' Customer added successfully.');
                			redirect('customers/add');
                } 
			}
			$data['countries'] = $this->common_model->getCountries();
			$this->load->view('common/header.php',$data);
			$this->load->view('customers/add_customerView.php',$data);
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
	function check_customer_email($customerId ,$currentEmailInfo) {  
		$customerInfo = explode('||', $currentEmailInfo);  
	    if( empty($customerInfo) || $customerId == ""){
	    	return TRUE;
	    }else{
			$customer = $this->customers_model->getCustomerById($customerInfo[1]);
			if(!empty($customer) && $customer[0]['cust_email'] == $customerInfo[0] ){
				return  TRUE;
			}else{
				$customerCount = $this->customers_model->check_unique_customer_email($customerInfo[1],$customerInfo[0]); 
				if($customerCount > 0){
					$this->form_validation->set_message('check_customer_email', 'The email address is already taken.');
					return FALSE;
				}else{
					return TRUE;
				}
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
				$this->form_validation->set_rules('cust_email', 'email address', 'callback_check_customer_email['.$this->input->post('cust_email').'|| '.$this->input->post('customer_id').']');

				$this->form_validation->set_rules('cust_zip', ' ZIP', 'numeric[12]',
						array('required' => 'Please enter %s.','numeric' => 'The ZIP/PIN should be number.')
				);
				$this->form_validation->set_rules('cust_phone', ' phone number', 'max_length[12]',
						array('required' => 'Please enter %s.','max_length' => 'The lenght of phone number should be less then or equal to 12.')
				);
				$this->form_validation->set_rules('cust_country', 'country', 'trim|required',
						 array('required' => 'Please select %s.')
				);

				$this->form_validation->set_rules('current_password', 'current password', 'trim|required|callback_pword_check[' . $this->input->post('current_password') . ']',
						array('required' => 'Please enter %s for validation.')
				);

                if ($this->form_validation->run() == TRUE) {
                	$this->customers_model->updateCustomerData($customerId,$this->input->post());
                	$this->session->set_flashdata('successMsg', ' Customer updated successfully.');
                	redirect('customers/');
                } 
			}
			$data['countries'] = $this->common_model->getCountries();
			$data['customer_details'] = $this->customers_model->getCustomerById($customerId);
			$this->load->view('common/header.php',$data);
			$this->load->view('customers/edit_customerView.php',$data);
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
     * @purpose         :   get customers revenue and page
     * @params          :   cust_id
     * @return          :   
     */
	public function get_revenue_details($customerID = ''){ 
		if($this->session->userdata('user_name')){
				if($customerID != ''){
					$data = $this->customers_model->get_revenue_details($customerID);
					if(!empty($data[0])){
						echo json_encode($data);
					}
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
