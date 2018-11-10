<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
		$this->load->helper('cookie');
		$this->load->helper('string');
		$this->load->helper('captcha');
		$this->load->helper('global');
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   load user login page
     * @params          :
     * @return          :   
     */
	public function index(){
		if($this->session->userdata('user_name')){
			redirect('/users/dashboard', 'refresh');
		}else{
			$this->load->view('loginView.php');
		}
	}
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
     * @purpose         :   validate user data and proceed login
     * @params          :
     * @return          :   data as []
     */
	public function doLogin(){
		if ($this->input->method() == 'post') {		
			$isAuthenticUser=$this->users_model->login($this->input->post());
			if($isAuthenticUser){
				if($this->input->post('remember')!= ''){
					setcookie('nrf_user', $this->input->post('username').','.'YES', time() + (86400 * 30), "/");
				}
				else{
					setcookie("nrf_user", "", time() - 3600);
				}
				redirect('users/dashboard');
			}else{
				
				$this->session->set_flashdata('error', '<div class="error">Invalid username or password.</div>');
				redirect('/');
			}
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
     * @created date    :   09-02-2018 (dd-mm-yyyy)
     * @purpose         :   check email if exist
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
     * @created date    :   17-08-2018 (dd-mm-yyyy)
     * @purpose         :   get user details
     * @params          :
     * @return          :   data as []
     */
	public function profile(){
		if($this->session->userdata('user_name')){

			if($this->input->post()){
				$this->form_validation->set_rules('user_name', 'user name', 'trim|required',
						array('required' => 'Please enter %s.')
				);
                $this->form_validation->set_rules('user_fname', 'first name', 'trim|required',
                        array('required' => 'Please enter %s.')
				);
				$this->form_validation->set_rules('user_lname', 'last name', 'trim|required',
						array('required' => 'Please enter %s.')
				);
				$this->form_validation->set_rules('user_email', 'email address', 'trim|required|valid_email|callback_check_user_email[' . $this->input->post('user_email') . ']',
						array(
							'required' => 'Please enter %s.',
							'valid_email' => 'Please enter valid email address.'
						)
				);
				$this->form_validation->set_rules('user_phone', ' phone number', 'required|max_length[12]',
						array('required' => 'Please enter %s.','max_length' => 'The lenght of phone number should be less then or equal to 12.')
				);
				$this->form_validation->set_rules('csrm_country', 'country name', 'trim|required',
						array('required' => 'Please select %s.')
				);
				$this->form_validation->set_rules('password', 'current password', 'trim|required|callback_pword_check[' . $this->input->post('password') . ']',
						array('required' => 'Please enter %s for validation.')
				);

                if ($this->form_validation->run() == TRUE) {
                	echo "<pre>"; print_r($this->input->post());
                		$this->users_model->updateUserDetails($this->session->userdata('user_id'),$this->input->post());
        			$this->session->set_flashdata('successMsg', 'User details updated successfully.');
        			redirect('users/profile'); 
                } 
			}

			$data['countries'] = $this->common_model->getCountries();
			$data['userDetail'] = $this->users_model->getUserById($this->session->userdata('user_id'));
			
			$this->load->view('common/header.php',$data);
			$this->load->view('profileView.php',$data);
			$this->load->view('common/footer.php',$data);
		}else{
			$this->load->view('loginView.php');
		}
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   18-08-2018 (dd-mm-yyyy)
     * @purpose         :   reset user password
     * @params          :
     * @return          :   data as []
     */
	public function changepassword(){
		if($this->session->userdata('user_name')){
			if($this->input->post()){
				$this->form_validation->set_rules('current_password', 'current password', 'trim|required',
						array('required' => 'Please enter %s.')
				);
                $this->form_validation->set_rules('new_password', 'new password', 'trim|required',
                        array('required' => 'Please enter %s.')
				);
				$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|matches[new_password]',
						array('required' => 'Please enter %s.','matches'=>'Confirm password not matched.')
				);

                if ($this->form_validation->run() == TRUE) {
                		$currentUserPassword = $this->session->userdata('user_pass');
                		$password = $this->input->post('current_password');

                		if($currentUserPassword == $password){
                			$this->users_model->updatePassword($this->session->userdata('user_id'),$this->input->post());
                			$this->session->set_flashdata('successMsg', 'Password updated successfully.');
                			redirect('users/changepassword');
                		}else{
                			$this->session->set_flashdata('errorMsg', 'You have entered wrong current password.');
                			redirect('users/changepassword');
                		} 
                	
                	
                } 
			}
		
			$this->load->view('common/header.php');
			$this->load->view('changepasswordView.php');
			$this->load->view('common/footer.php');
		}else{
			$this->load->view('loginView.php');
		}
	}
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   load user dashboard,get customer order count
     * @params          :
     * @return          :   
     */
	public function dashboard($orderType = ''){
		if($this->session->userdata('user_name')){
			$data['orderType'] = $orderType;
			$data['userData'] = $this->session->userdata();	
			$data['oStatus'] = $this->common_model->getAllOrdersStatus();
			$data['sales_snapshot'] = $this->common_model->getsnepShot();
//echo"<pre>";print_r($data['userData']);die;			
			$data['cOrderCount'] = $this->orders_model->getAllCustomersOrdresCount($data['userData']);
			$data['totallOrdersCount'] = $this->orders_model->getAllOrdresCount($data['userData']);
			$data['voiceCount'] = count($this->orders_model->getVoiceTalent());
			$data['recentOrder'] = $this->orders_model->getRecentOrder($orderType);
			$this->load->view('common/header.php',$data);
			$this->load->view('dashboardView.php',$data);
			$this->load->view('common/footer.php',$data);
		}else{
			redirect('/');
		}
	}
	/**
     * @developer       :   Dinesh
     * @created date    :   02-09-2018 (dd-mm-yyyy)
	 * @updated date    :   02-09-2018 (dd-mm-yyyy)
     * @purpose         :   load user dashboard,get customer order count (testing)
     * @params          :
     * @return          :   
     */
	
	public function dashboardTest($orderType = ''){
		if($this->session->userdata('user_name')){
			$data['orderType'] = $orderType;
			$data['userData'] = $this->session->userdata();	
			$data['oStatus'] = $this->common_model->getAllOrdersStatus();	
			$data['cOrderCount'] = $this->orders_model->getAllCustomersOrdresCount($data['userData']);
			$data['totallOrdersCount'] = $this->orders_model->getAllOrdresCount($data['userData']);
			$data['voiceCount'] = count($this->orders_model->getVoiceTalent());
			$data['recentOrder'] = $this->orders_model->getRecentOrder($orderType);
			$this->load->view('common/header.php',$data);
			$this->load->view('dashboardTestView.php',$data);
			$this->load->view('common/footer.php',$data);
		}else{
			redirect('/');
		}
	}
	
	/**
     * @developer       :   Dinesh
     * @created date    :   09-08-2018 (dd-mm-yyyy)
	 * @updated date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   load user reset password view
     * @params          :
     * @return          :   
     */
	public function resetpassword(){
		if($this->session->userdata('user_name')){
			redirect('users/dashboard');
		}else{
			if ($this->input->method() == 'post') {			
				if ($this->validate('forgot_password')) {
					$inputCaptcha=$this->input->post('security_code');
					$inputEmail=$this->input->post('email');
					if($inputCaptcha==$this->session->userdata('captchaVal')){
						$isemailExist=$this->users_model->getUserbyEmail($inputEmail);
						if($isemailExist){
							$templateData=$this->emails_model->getEmailbyId(8)[0];
							$userData=$isemailExist[0];
							$emailData=array_merge($templateData,$userData);	
												
							send_email($isemailExist[0]['user_email'],'password_recovery',$emailData);
							$this->session->set_flashdata('success', '<div class="success">password recovery email has been sent to your email address.</div>');
							redirect('/');
						}else{
							$this->session->set_flashdata('error', '<div class="error">Email is not registerd with us.</div>');
							redirect('users/resetpassword');
						}
					}else{
						$this->session->set_flashdata('error', '<div class="error">Captcha value is not correct.</div>');
						redirect('users/resetpassword');
					}
				}							
			}
			$rand = random_string('numeric', 8);
			$this->session->set_userdata('captchaVal', $rand);
			$vals = array(
				'word'	     => $rand,
				'img_path'   => './assets/captcha_images/',
				'img_url'    => base_url().'/assets/captcha_images/',
				'img_width'  => '150',
				'img_height' => 60,
				'expiration' => 7200
				);
			$cap = create_captcha($vals);  
			
			$this->load->view('forgotView',$cap);
		}
	}
	
	/**
     * @developer       :   Dinesh
     * @created date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   destroy all session
     * @params          :
     * @return          :   
     */
	public function logout(){ 
		$this->session->unset_userdata($this->userData);
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}

	/**
     * @developer       :   Dinesh
     * @created date    :   16-08-2018 (dd-mm-yyyy)
     * @purpose         :   validate form
     * @params          :
     * @return          :   
     */
	
	private function validate($type) {        
		$config = [
			'save' => [
				[
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => 'Email address is required.',
						'valid_email' => 'Please provide valid email.',
					],
				],
				[
					'user_name' => 'user_name',
					'label' => 'user_name',
					'rules' => 'required',
					'errors' => [
						'required' => 'User name is required.',
					],
				],[
					'name' => 'name',
					'label' => 'name',
					'rules' => 'required',
					'errors' => [
						'required' => 'Name is required.',
					],
				]
			],
			'register' => [
				[
					'field' => 'first_name',
					'label' => 'First name',
					'rules' => 'required'
				],
				[
					'field' => 'last_name',
					'label' => 'Last name',
					'rules' => 'required'
				],
				[
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'required|valid_email|callback_check_email_existance',
				],
				[
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required|matches[confirm_password]',
					'errors' => [
						'required' => 'Password is required',
						'matches' => 'Confirm password is not matched.'
					],
				],
				[
					'field' => 'confirm_password',
					'label' => 'Confirm password',
					'rules' => 'required',
					'errors' => [
						'required' => 'Confirm password is required.',
					],
				]
			],
			'forgot_password' => [
				[
					'field' => 'email',
					'label' => 'email',
					'rules' => 'required|valid_email'
				],
				[
					'field' => 'security_code',
					'label' => 'captcha',
					'rules' => 'required'
				]
			]
		];

		$this->form_validation->set_rules($config[$type]);
		return $this->form_validation->run();
	}

}
