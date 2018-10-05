<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Talents extends CI_Controller {
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
		$this->load->model('talent_model');
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->helper('captcha');
		$this->load->helper('global');
		$this->load->helper('security');
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
				$data['allTalent'] = $this->talent_model->getAllTalent();
				//echo $myJSONString = json_encode($data['allCustomers']);die;
				$this->load->view('common/header.php',$data);
				$this->load->view('talents/talentView.php',$data);
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
				
				$this->form_validation->set_rules('tlnt_fname', 'first name', 'trim|required',
						array('required' => 'Please enter %s.')
				);
                $this->form_validation->set_rules('tlnt_lname', 'last name', 'trim|required',
                        array('required' => 'Please enter %s.')
				);
				
				$this->form_validation->set_rules('tlnt_email', 'email address', 'trim|required|valid_email|is_unique[nrf_talent.tlnt_email]',
						array(
							'required' => 'Please enter %s.',
							'valid_email' => 'Please enter valid email address.',
							'is_unique' => 'The %s is already taken',
						)
				);
				
				$this->form_validation->set_rules('tlnt_phone', ' phone', 'trim|required|max_length[12]',
						array('required' => 'Please enter %s.','max_length' => 'The lenght of phone number should be less then or equal to 12.')
				);
				$this->form_validation->set_rules('tlnt_rate', 'rate per page', 'trim|required|numeric|xss_clean',
						 array('required' => 'Please select %s.','valid_email' => '%s only numeric allowed')
				);


                if ($this->form_validation->run() == TRUE) {
                	$this->talent_model->addTalent($this->input->post());
                	$this->session->set_flashdata('successMsg', ' Talent added successfully.');
                			redirect('talents/add');
                } 
			}
			$data['countries'] = $this->common_model->getCountries();
			$this->load->view('common/header.php',$data);
			$this->load->view('talents/add_talentView.php',$data);
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
	public function edit($talentId = ""){
		if($this->session->userdata('user_name')){
			if($talentId == ""){
				redirect('talents');
			}
			$data['userData'] = $this->session->userdata();
			if($this->input->post()){
				$this->form_validation->set_rules('tlnt_fname', 'first name', 'trim|required',
						array('required' => 'Please enter %s.')
				);
                $this->form_validation->set_rules('tlnt_lname', 'last name', 'trim|required',
                        array('required' => 'Please enter %s.')
				);
				
				$this->form_validation->set_rules('tlnt_email', 'email address', 'trim|required|valid_email',
						array(
							'required' => 'Please enter %s.',
							'valid_email' => 'Please enter valid email address.'							
						)
				);
				
				$this->form_validation->set_rules('tlnt_phone', ' phone', 'trim|required|max_length[12]',
						array('required' => 'Please enter %s.','max_length' => 'The lenght of phone number should be less then or equal to 12.')
				);
				$this->form_validation->set_rules('tlnt_rate', 'rate per page', 'trim|required|numeric|xss_clean',
						 array('required' => 'Please select %s.','valid_email' => '%s only numeric allowed')
				);

                if ($this->form_validation->run() == TRUE) {
                	$this->talent_model->updateTalentData($talentId,$this->input->post());
                	$this->session->set_flashdata('successMsg', ' Talent updated successfully.');
                	redirect('talents/');
                } 
			}
			$data['countries'] = $this->common_model->getCountries();
			$data['talent_details'] = $this->talent_model->getTalentById($talentId);
			$this->load->view('common/header.php',$data);
			$this->load->view('talents/edit_talentView.php',$data);
			$this->load->view('common/footer.php',$data);
		}else{
			redirect('/');
		}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :   delete talents page
     * @params          :   talentID
     * @return          :   
     */
	public function deleteTalent($talentID = ''){
		if($this->session->userdata('user_name')){
				if($talentID != ''){
					$this->talent_model->deleteTalent($talentID);
					die();
				}else{
					redirect('talents');
				}
				
			}else{
				redirect('/');
			}
	}


	/**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :   update talents status
     * @params          :   talentID
     * @return          :   
     */
	public function updatestatus($talentID = ''){
		
		if($this->session->userdata('user_name')){
				if($talentID != ''){
					$this->talent_model->updateTalent($talentID,$this->input->post('type'));
					die();
				}else{
					redirect('talents');
				}
				
		}else{
				redirect('/');
		}
	}
	
		/**
     * @developer       :   Dinesh
     * @created date    :   27-08-2018 (dd-mm-yyyy)
     * @purpose         :   update talents note
     * @params          :   talentID
     * @return          :   
     */
	public function updatNote($talentID = ''){
		
		if($this->session->userdata('user_name')){
				if($talentID != ''){
					$this->talent_model->updateTalentnote($talentID,$this->input->post('note'));
					die();
				}else{
					redirect('talents');
				}
				
		}else{
				redirect('/');
		}
	}
}
